<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

//Emails
use App\Mail\WelcomeMail;

//Models
use App\Models\Member;
use App\Models\User;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Member::query();

            if ($request->has("search") && $request->input("search")) {
                $search = $request->input("search");
                $query->where(function ($q) use ($search) {
                    $q->where("firstname", "like", "%" . $search . "%")
                        ->orWhere("lastname", "like", "%" . $search . "%")
                        ->orWhere("email", "like", "%" . $search . "%");
                });
            }

            $members = $query->paginate(10);

            return view('members.index', compact('members'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'phone' => 'required',
                'address' => 'max:255',
                'email' => 'required|unique:members|email'
            ]);

            DB::beginTransaction();

            $member = Member::create([
                'firstname' => $validated['firstname'],
                'lastname' => $validated['lastname'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'email' => $validated['email']
            ]);

            $password = $this->generateSecurePassword();

            $user = User::create([
                'username' => User::generateUsername($member->firstname, $member->lastname),
                'password' => Hash::make($password),
                'id_member' => $member->id
            ]);

            $user->assignRole('member');

            Mail::to($member->email)->send(new WelcomeMail($user->username, $password));

            // Confirmar la transacción
            DB::commit();
            return redirect()->route('members')->with('success', 'Miembro Creado Correctamente');
        } catch (\Exception $e) {

            // Si ocurre un error, revertir la transacción
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($member_id)
    {
        try {
            $member = Member::findOrFail($member_id);
            return view('members.show', compact('member'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $member = Member::findOrFail($request->member);

            $validated = $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'phone' => 'required',
                'address' => 'max:255',
                'email' => [
                    'email',
                    Rule::unique('members')->ignore($member->id), // Ignorar el correo actual del miembro
                ],
                'member' => 'required'
            ]);


            $member->firstname = $validated['firstname'];
            $member->lastname = $validated['lastname'];
            $member->phone = $validated['phone'];
            $member->address = $validated['address'];
            $member->email = $validated['email'];
            $member->save();


            return redirect()->route('members')->with('success', 'Miembro Actualizado Correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $validated = $request->validate([
                'member' => 'required'
            ]);

            $member = Member::findOrFail($validated['member']);
            $member->delete();

            return redirect()->back()->with('success', 'Miembro Eliminado Correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    //Funciones Custom
    private function generateSecurePassword($length = 8) {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()_-+=<>?';

        // Asegurar que haya al menos un carácter de cada tipo
        $password = $uppercase[rand(0, strlen($uppercase) - 1)] .
                    $lowercase[rand(0, strlen($lowercase) - 1)] .
                    $numbers[rand(0, strlen($numbers) - 1)] .
                    $specialChars[rand(0, strlen($specialChars) - 1)];

        // Completar la longitud de la contraseña
        $allChars = $uppercase . $lowercase . $numbers . $specialChars;
        for ($i = strlen($password); $i < $length; $i++) {
            $password .= $allChars[rand(0, strlen($allChars) - 1)];
        }

        // Mezclar la contraseña para hacerla aleatoria
        return str_shuffle($password);
    }
}
