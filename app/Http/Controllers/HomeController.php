<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Muestra la página principal (Index) de la aplicación.
     * 
     * En el patrón MVC, este método se encarga de recibir la petición a la raíz ("/")
     * y devolver la vista correspondiente (home.index). Aquí podrías en un futuro
     * cargar datos de la base de datos (como productos destacados) para enviarlos a la vista.
     */
    public function index()
    {
        return view('home.index');
    }
}
