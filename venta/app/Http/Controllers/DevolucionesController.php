<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devoluciones;

class DevolucionesController extends Controller{

    public function __construct(){
        //protegemos la url
        //al metodo index con el constructor le pasamos el parametro de autenticacion
        $this->middleware('auth');
    }

    public function index(){
        $devoluciones = Devoluciones::with('usuario')->get();
        return view('devoluciones.lista')->with(['devoluciones' => $devoluciones]);
    }

    // Mostrar vista de formulario
    public function create(){
        return view('devoluciones.create');
    }

}
