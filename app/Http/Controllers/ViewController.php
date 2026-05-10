<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function productos()
    {
        return view('productos');
    }

    public function pedidos()
    {
        return view('pedidos');
    }

    public function clientes()
    {
        return view('clientes');
    }

    public function estadisticas()
    {
        return view('estadisticas');
    }

    public function configuracion()
    {
        return view('configuracion');
    }
}
