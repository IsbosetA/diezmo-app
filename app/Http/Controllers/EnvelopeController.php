<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

//Models
use App\Models\Envelope;
use App\Models\Member;
use App\Models\OfferingType;
use App\Models\Offering;
use App\Models\Tithe;
use App\Models\Transfer;
use Illuminate\Support\Facades\Auth;

class EnvelopeController extends Controller
{
    public function index(Request $request)
    {
        try {

            $query = Envelope::query();

            if ($request->has("search") && $request->input("search")) {
                $search = $request->input("search");
                $query->where(function ($q) use ($search) {
                    $q->where("envelope_number", "like", "%" . $search . "%");

                    // Si el usuario tiene rol de admin, agrega la búsqueda por nombre del miembro
                    if (Auth::user()->hasRole('admin')) {
                        $q->orWhereHas('member', function ($query) use ($search) {
                            $query->where("name", "like", "%" . $search . "%");
                        });
                    }
                });

            }

            if(Auth::user()->hasRole('member')){
                $envelopes = $query->where('id_member', Auth::user()->member->id)->paginate(10);

                return view('envelopes.index', compact('envelopes'));
            }

            $envelopes = $query->paginate(10);

            return view('envelopes.index', compact('envelopes'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        $members = null;  // Inicializa $members en null por defecto

        if (Auth::user()->hasRole('admin')) {
            $members = Member::all();  // Si es admin, asigna los miembros
        }

        $offeringsTypes = OfferingType::all();

        return view('envelopes.create', compact('members', 'offeringsTypes'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'description' => 'max:255',
                'date' => 'required|date',
                'member' => 'required',
                'offering_type' => 'required|array',
                'offering_amount' => 'required|array',
                'offering_amount.*' => 'decimal:2',
                'transfer_date' => 'required|array',
                'transfer_num' => 'required|array',
                'transfer_bank' => 'required|array',
                'transfer_amount' => 'required|array',
                'transfer_amount.*' => 'decimal:2',
                'capture' => 'required|array',
                'capture.*' => 'mimes:jpg,png,jpeg|max:50000',
                'tithe' => 'required|decimal:2'
            ]);

            $total = 0;

            DB::beginTransaction();

            //Crear el Sobre
            $envelope = Envelope::create([
                'id_member' => (int) $validated['member'],
                'envelope_number' =>  Envelope::getNextEnvelopeNumber($validated['date']),
                'date' => Carbon::parse($validated['date'])->format('Y-m-d'),
                'description' => $validated['description'] ?? ''
            ]);

            foreach ($validated['offering_type'] as $index => $type) {
                // Asegúrate de que 'offering_amount' tiene el mismo número de elementos que 'offering_type'
                if (isset($validated['offering_amount'][$index])) {
                    $amount = $validated['offering_amount'][$index];

                    $offering = Offering::create([
                        'id_envelope' => $envelope->id,
                        'id_offering_type' => $type,
                        'amount' => $amount
                    ]);

                    $total += $amount;
                }
            }

            $tithe = Tithe::create([
                'id_envelope' => $envelope->id,
                'amount' => $validated['tithe']
            ]);

            $tranfers = $this->createTransf($envelope->id, $validated['transfer_date'], $validated['transfer_amount'], $validated['transfer_num'], $validated['transfer_bank'], $validated['capture']);


            if (!$tranfers['status']) {
                // Si ocurre un error, revertir la transacción
                DB::rollBack();
                return redirect()->back()->with('error', $tranfers['message']);
            }

            $total += $tithe->amount;

            $envelope->total = $total;
            $envelope->save();

            // Confirmar la transacción
            DB::commit();

            return redirect()->route('envelopes')->with('success', 'Sobre Creado Correctamente');
        } catch (\Exception $e) {
            // Si ocurre un error, revertir la transacción
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($envelope_id)
    {
        try {
            $members = Member::all();
            $offeringsTypes = OfferingType::all();
            $envelope = Envelope::findOrFail($envelope_id);
            return view('envelopes.show', compact('envelope', 'members', 'offeringsTypes'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            // dd($request);
            $validated = $request->validate([
                'envelope' => 'required',
                'description' => 'max:255',
                'date' => 'required|date',
                'member' => 'required',
                'offering_type' => 'required|array',
                'offering_amount' => 'required|array',
                'offering_amount.*' => 'decimal:2',
                'transfer_date' => 'required|array',
                'transfer_num' => 'required|array',
                'transfer_bank' => 'required|array',
                'transfer_amount' => 'required|array',
                'transfer_amount.*' => 'decimal:2',
                'offering_id' => 'required|array',
                'transfer_id' => 'required|array',
                'capture' => 'sometimes|array',
                'capture.*' => 'mimes:jpg,png,jpeg|max:50000', // Validación solo si está presente
                'tithe' => 'required|decimal:2'
            ]);

            $total = 0;

            DB::beginTransaction();

            //Buscar el Sobre
            $envelope = Envelope::findOrFail($validated['envelope']);
            $envelope->description = $validated['description'];
            $envelope->date = $validated['date'];
            $envelope->id_member = $validated['member'];
            $tithe = $envelope->tithe;

            foreach ($validated['offering_id'] as $index => $offeringExist) {
                $total += $offeringExist ? Offering::where('id', $offeringExist)->first()->amount : 0;
                if ($offeringExist == null) {
                    $offering = Offering::create([
                        'id_envelope' => $envelope->id,
                        'id_offering_type' => $validated['offering_type'][$index],
                        'amount' => $validated['offering_amount'][$index]
                    ]);

                    $total += $offering->amount;
                }
            }

            $tithe->amount = $validated['tithe'];
            $tithe->save();

            foreach ($validated['transfer_id'] as $index => $transferId) {
                // Verifica si se proporciona la imagen y genera el nombre específico para el archivo
                if (isset($validated['capture'][$index])) {
                    // Obtén la referencia, fecha y banco, asegurando que no tengan caracteres especiales
                    $reference = preg_replace('/[^A-Za-z0-9]/', '', $validated['transfer_num'][$index]);
                    $date = Carbon::createFromFormat('d/m/Y', $validated['transfer_date'][$index])->format('Ymd'); // Fecha en formato AAAAMMDD
                    $bank = preg_replace('/[^A-Za-z0-9]/', '', $validated['transfer_bank'][$index]);

                    // Obtén los dos primeros caracteres del nombre original del archivo, sin caracteres especiales y en minúsculas
                    $originalName = pathinfo($validated['capture'][$index]->getClientOriginalName(), PATHINFO_FILENAME);
                    $firstTwoChars = substr(preg_replace('/[^A-Za-z0-9]/', '', $originalName), 0, 2);

                    // Genera el nombre de archivo en minúsculas con los dos primeros caracteres
                    $filename = strtolower("{$firstTwoChars}_{$reference}_{$date}_{$bank}_capture." . $validated['capture'][$index]->extension());

                    // Guarda la imagen con el nombre específico
                    $path = $validated['capture'][$index]->storeAs('transfers', $filename, 'public');
                }

                if ($transferId == null) {
                    // Crear nueva transferencia si transfer_id es null
                    Transfer::create([
                        'id_envelope' => $envelope,
                        'reference' => $reference,
                        'amount' => $validated['transfer_amount'][$index],
                        'date' => Carbon::createFromFormat('d/m/Y', $validated['transfer_date'][$index])->format('Y-m-d'),
                        'bank' => $bank,
                        'capture' => $path
                    ]);
                } else {
                    // Actualizar si ya existe una transferencia y la imagen cambió
                    $transfer = Transfer::find($transferId);
                    if ($transfer && isset($validated['capture'][$index])) {
                        if ($transfer->capture !== $path) {
                            Storage::delete('public/' . $transfer->capture);
                            $transfer->update(['capture' => $path]);
                        }
                    }
                }
            }

            $total += $tithe->amount;

            $envelope->total = $total;
            $envelope->save();

            // Confirmar la transacción
            DB::commit();

            return redirect()->route('envelopes')->with('success', 'Sobre Actualizado Correctamente');
        } catch (\Exception $e) {
            // Si ocurre un error, revertir la transacción
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $validated = $request->validate([
                'envelope' => 'required'
            ]);

            $envelope = Envelope::findOrFail($validated['envelope']);

            $captures = $envelope->transfers;

            foreach ($captures as $capture) {
                Storage::delete('public/' . $capture->capture);
            }

            $envelope->delete();

            return redirect()->back()->with('success', 'Sobre Eliminado Correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Custom Functions
    private function createTransf($envelope, array $transfer_dates, array $transfers_amounts, array $tranfers_nums, array $transfers_banks, array $captures)
    {
        try {
            // Asegurarse de que todos los arrays tengan la misma longitud
            $count = count($transfer_dates);

            for ($index = 0; $index < $count; $index++) {
                // Validar si el índice existe en todos los arrays para evitar errores
                if (isset($transfer_dates[$index], $transfers_amounts[$index], $tranfers_nums[$index], $transfers_banks[$index], $captures[$index])) {

                    // Obtener cada dato específico para la transferencia actual
                    $date = Carbon::createFromFormat('d/m/Y', $transfer_dates[$index])->format('Ymd');
                    $amount = $transfers_amounts[$index];
                    $reference = preg_replace('/[^A-Za-z0-9]/', '', $tranfers_nums[$index]);
                    $bank = preg_replace('/[^A-Za-z0-9]/', '', $transfers_banks[$index]);

                    // Obtener los dos primeros caracteres del nombre original del archivo
                    $originalName = pathinfo($captures[$index]->getClientOriginalName(), PATHINFO_FILENAME);
                    $firstTwoChars = substr(preg_replace('/[^A-Za-z0-9]/', '', $originalName), 0, 2);

                    // Generar el nombre del archivo en minúsculas
                    $filename = strtolower("{$firstTwoChars}_{$reference}_{$date}_{$bank}_capture." . $captures[$index]->extension());

                    // Guardar la imagen con el nombre específico
                    $path = $captures[$index]->storeAs('transfers', $filename, 'public');

                    // Crear la transferencia
                    $tranfser = Transfer::create([
                        'id_envelope' => $envelope,
                        'reference' => $tranfers_nums[$index],
                        'amount' => $amount,
                        'date' => Carbon::createFromFormat('d/m/Y', $transfer_dates[$index])->format('Y-m-d'),
                        'bank' => $bank,
                        'capture' => $path
                    ]);
                }
            }

            return ['status' => true, 'message' => $tranfser];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
