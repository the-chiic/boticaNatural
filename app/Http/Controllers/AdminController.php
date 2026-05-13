<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.index');
    }

    public function productos()
    {
        return view('admin.products');
    }

    public function pedidos()
    {
        return view('admin.orders');
    }

    public function clientes()
    {
        return view('admin.customers');
    }

    public function estadisticas()
    {
        return view('admin.stats');
    }

    public function configuracion()
    {
        return view('admin.settings');
    }
}
