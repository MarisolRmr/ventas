<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Devoluciones;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;

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
        $ventas = Venta::all();
        $productos = Producto::all();
        $clientes = Cliente::all();
        
        return view('devoluciones.create')->with(['ventas' => $ventas,'productos' => $productos,'clientes' => $clientes]);
    }

    // Validar y guardar datos del formulario
    /*public function store(Request $request){
        // Reglas de validación
        $this->validate($request, [
            'referencia' => 'required'
        ]);

        // Obtener el ID del usuario autenticado
        $userId = Auth::id();
        //dd($userId);

        // Invocar el modelo Categoria para crear el registro con el user_id
        Devoluciones::create([
            'referencia' => $request->referencia,
            'fecha' => $request->fecha,
            'cliente' => $request->cliente,
            'status' => $request->status,
            'total' => $request->total,
            'pagado' => $request->pagado,
            'deuda' => $request->deuda,
            'statusPago' => $request->status2,

            'imagen' => $request->imagen,
            'user_id' => $userId,
        ]);

        // Redireccionar a la vista de listado de categorías
        return redirect()->route('devoluciones.index')->with('agregada', 'Devolución agregada correctamente');
    }*/

    public function store(Request $request){

        dd($request->all());

        $ventaId = $request->input('referencia');
        $cantidadesDevueltas = $request->input('cantidades_devueltas');

        
        $productos = $request->input('productos');
        $cantidadesDevueltas = $request->input('cantidades_devueltas');

        foreach ($productos as $productoId => $producto) {
            $cantidadDevuelta = $cantidadesDevueltas[$productoId];

            if ($cantidadDevuelta > 0) {
                Devoluciones::create([
                    'venta_id' => $ventaId,
                    'producto_id' => $productoId,
                    'cantidad_devuelta' => $cantidadDevuelta,
                ]);
            }
        }

        return redirect()->route('devoluciones.index')->with('success', 'Devolución registrada correctamente.');
    }


    public function buscarVenta($ventaId){

        $venta = Venta::find($ventaId);

        if (!$venta) {
            return response()->json(['error' => 'Venta no encontrada'], 404);
        }

        $productosComprados = $venta->ventaProductos()
        ->with(['producto' => function ($query) {
            $query->select('id', 'imagen', 'nombre', 'precio_venta');
        }])
        ->select('producto_id', 'cantidad')
        ->get();


        return response()->json(['productos' => $productosComprados]);
    }


    

    

}
