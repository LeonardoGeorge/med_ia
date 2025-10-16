<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    public function index()
    {
        return view('consulta');
    }

    public function resultado()
    {
        $diagnostico = session('diagnostico');

        if (!$diagnostico) {
            return redirect()->route('consulta');
        }

        return view('resultado', compact('diagnostico'));
    }
}
