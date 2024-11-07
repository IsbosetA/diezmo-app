<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Models
use App\Models\GeneralConfiguration;

class SettingsController extends Controller
{
    public function index()
    {
        try {
           // Obtener el primer registro de la configuración
            $settings = GeneralConfiguration::first();


            return view('settings.index', compact('settings'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function storeUpdate(Request $request)
    {
        try {
            $validated = $request->validate([
                'period_start' => 'required|date',
                'period_end' => 'required|date',
                'city' => 'required',
                'church_name' => 'required',
                'settings' => 'sometimes'
            ]);

            if($validated['settings'] !== null){
                $settings = GeneralConfiguration::firstOrFail();

                $settings->period_start = $validated['period_start'];
                $settings->period_end = $validated['period_end'];
                $settings->city = $validated['city'];
                $settings->church_name = $validated['church_name'];
                $settings->save();

                return redirect()->back()->with('success', 'Configuracion Actualizada Correctamente');
            }

            $settings = GeneralConfiguration::create([
                'period_start' => $validated['period_start'],
                'period_end' =>  $validated['period_end'],
                'city' =>  $validated['city'],
                'church_name' =>  $validated['church_name'],
            ]);

            return redirect()->back()->with('success', 'Configuracion Actualizada Correctamente');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function profile()
    {
        return view('profile.profile');
    }
}
