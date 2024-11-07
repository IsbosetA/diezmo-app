<?php

use Illuminate\Support\Facades\Route;

//Controllers
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OfferingTypeController;
use App\Http\Controllers\EnvelopeController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('mail', function(){
    $username = "PepeGrillox";
    $temporalPassword = "Pinocho3000";
    return view('emails.welcomeMail', compact('username', 'temporalPassword'));
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //Rutas para los administradores
    Route::middleware(['role:admin'])->group(function (){
        //Rutas para la Administracion de los Miembros
        Route::get('/members', [MemberController::class, 'index'])->name('members');
        Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
        Route::get('/members/show/{member_id}', [MemberController::class, 'show'])->name('members.show');
        Route::post('/members/add', [MemberController::class, 'store'])->name('members.add');
        Route::put('/members/update', [MemberController::class, 'update'])->name('members.update');
        Route::delete('/members/delete', [MemberController::class, 'destroy'])->name('members.destroy');

        //Rutas para la Administracion de los tipos de Ofrendas
        Route::get('/offerings', [OfferingTypeController::class, 'index'])->name('offerings');
        Route::get('/offerings/create', [OfferingTypeController::class, 'create'])->name('offerings.create');
        Route::get('/offerings/show/{offeringType_id}', [OfferingTypeController::class, 'show'])->name('offerings.show');
        Route::post('/offerings/add', [OfferingTypeController::class, 'store'])->name('offerings.add');
        Route::put('/offerings/update', [OfferingTypeController::class, 'update'])->name('offerings.update');
        Route::delete('/offerings/delete', [OfferingTypeController::class, 'destroy'])->name('offerings.destroy');

        //Rutas para las configuraciones
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('/settings/updated', [SettingsController::class, 'storeUpdate'])->name('settings.update');

        //Ruta para los Sobres - Eliminar
        Route::delete('/envelopes/delete', [EnvelopeController::class, 'destroy'])->name('envelopes.destroy');

        //Rutas para los reportes
        Route::get('weekly/report', [ReportsController::class, 'weekly'])->name('reports.weekly');
        Route::get('monthly/report', [ReportsController::class, 'monthly'])->name('reports.monthly');
    });

    //Rutas para los administradores y para los Feligreses
    Route::middleware(['role:admin|member'])->group(function (){
        //Ruta para la creacion de Sobres
        Route::get('/envelopes', [EnvelopeController::class, 'index'])->name('envelopes');
        Route::get('/envelopes/create', [EnvelopeController::class, 'create'])->name('envelopes.create');
        Route::post('/envelopes/add', [EnvelopeController::class, 'store'])->name('envelopes.add');
        Route::put('/envelopes/update', [EnvelopeController::class, 'update'])->name('envelopes.update');
        Route::get('/envelopes/show/{envelope_id}', [EnvelopeController::class, 'show'])->name('envelopes.show');

        //Perfil del Usuario
        Route::get('profile', [SettingsController::class, 'profile'])->name('profile');
    });
});
