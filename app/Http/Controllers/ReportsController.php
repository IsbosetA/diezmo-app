<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


//Libraries
use Barryvdh\DomPDF\Facade\Pdf as PDF;

//Models
use App\Models\Envelope;
use App\Models\Offering;


class ReportsController extends Controller
{
    public function monthly()
    {
        try {
            // Obtener la fecha actual y calcular el rango de fechas del mes anterior
            $startOfMonth = Carbon::now()->subMonth()->startOfMonth();
            $endOfMonth = Carbon::now()->subMonth()->endOfMonth();

            // Obtener sobres con sus montos de ofrenda
            $envelopes_unfilter = Envelope::whereBetween('date', [$startOfMonth, $endOfMonth])
                ->with(['offerings' => function ($query) {
                    // Agrupar las ofrendas por tipo
                    $query->select('id_envelope', 'id_offering_type', DB::raw('SUM(amount) as total_amount'))
                        ->groupBy('id_envelope', 'id_offering_type');
                }])
                ->get();

            // Inicializar variables para los totales
            $totalLoveOffering = 0;
            $totalOtherOfferings = 0;
            $totalTithes = 0;
            $totalAmount = 0;

            // Preparar la respuesta
            $envelopes = $envelopes_unfilter->map(function ($envelope) use (&$totalLoveOffering, &$totalOtherOfferings, &$totalTithes, &$totalAmount) {
                $offeringLove = $envelope->offerings->firstWhere(function ($offering) {
                    return strtolower($offering->type->name) === 'ofrenda de amor'; // Ignorar mayúsculas
                });
                $amountLove = $offeringLove ? $offeringLove->total_amount : 0;
                $totalLoveOffering += $amountLove; // Sumar a la variable total de ofrendas de amor

                $otherOfferings = $envelope->offerings->filter(function ($offering) {
                    return strtolower($offering->type->name) !== 'ofrenda de amor'; // Filtrar otras ofrendas
                });

                $amountOther = $otherOfferings->sum('total_amount');
                $totalOtherOfferings += $amountOther; // Sumar a la variable total de otras ofrendas

                // Sumar el diezmo
                $titheAmount = $envelope->tithe->amount;
                $totalTithes += $titheAmount; // Sumar a la variable total de diezmos

                // Sumar el total del sobre
                $total = $envelope->total;
                $totalAmount += $total; // Sumar a la variable total general

                return json_decode(json_encode([
                    'envelope_number' => $envelope->envelope_number,
                    'member' => $envelope->member,
                    'tithe' => $titheAmount,
                    'total' => $total,
                    'amount_love_offering' => $amountLove,
                    'amount_other_offerings' => $amountOther,
                ]));
            });

            // Convertir a PDF
            return PDF::loadView('reports.month', compact('envelopes', 'totalLoveOffering', 'totalOtherOfferings', 'totalTithes', 'totalAmount'))
                ->stream("monthly_{$startOfMonth->toDateString()}_to_{$endOfMonth->toDateString()}_report.pdf");
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function weekly()
    {
        try {
            // Obtener la fecha actual y calcular el rango de fechas de la semana pasada
            $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY)->subWeek();
            $endOfWeek = Carbon::now()->endOfWeek(Carbon::SATURDAY)->subWeek();

            $envelopes = Envelope::whereBetween('date', [$startOfWeek, $endOfWeek])->select('envelope_number', 'id_member', 'total')->get();

            //Convertir a PDF
            return PDF::loadView('reports.week', compact('envelopes'))->stream("weekly_{$startOfWeek->toDateString()}_to_{$endOfWeek->toDateString()}_report.pdf");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
