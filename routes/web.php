<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\DiagnosticoController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/consulta', [ConsultaController::class, 'index'])->name('consulta');
Route::post('/diagnostico', [DiagnosticoController::class, 'processar'])->name('diagnostico.processar');
Route::get('/resultado', [ConsultaController::class, 'resultado'])->name('resultado');

// Rota de saúde da API
Route::get('/health', function () {
    return response()->json(['status' => 'API operacional']);
});
