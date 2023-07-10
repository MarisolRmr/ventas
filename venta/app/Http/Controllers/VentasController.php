<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VentasController extends Controller
{
    public function __construct(){
        //protegemos la url
        //al metodo index con el constructor le pasamos el parametro de autenticacion
        $this->middleware('auth');
    }
    //vista de ventas
    public function index(){
        return view('ventas.lista');
    }
    //vista de detalles de ventas
    public function detalles_index(){
        return view('ventas.detalles');
    }
    
}
