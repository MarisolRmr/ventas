<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Devoluciones;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use App\Models\VentaProducto;


class DevolucionesController extends Controller{

    public function __construct(){
        //protegemos la url
        //al metodo index con el constructor le pasamos el parametro de autenticacion
        $this->middleware('auth');
    }

    public function index(){
        $consulta = "
        SELECT 
            d.venta_id,
            v.referencia,
            p.imagen,
            pr.nombre AS nombre_producto,
            c.nombre AS nombre_cliente,
            d.cantidad_devuelta,
            d.created_at
        FROM 
            devoluciones d
        JOIN 
            venta_producto vp ON d.producto_id = vp.producto_id AND d.venta_id = vp.venta_id
        JOIN 
            venta v ON d.venta_id = v.id
        JOIN 
            producto p ON d.producto_id = p.id
        JOIN 
            producto pr ON vp.producto_id = pr.id
        JOIN 
            cliente c ON v.cliente_id = c.id";

        $devoluciones = DB::select($consulta);

        return view('devoluciones.lista', ['devoluciones' => $devoluciones]);
    }

    
    // Mostrar vista de formulario
    public function create(){
        $ventas = Venta::all();
        $productos = Producto::all();
        $clientes = Cliente::all();
        
        return view('devoluciones.create')->with(['ventas' => $ventas,'productos' => $productos,'clientes' => $clientes]);
    }


    public function store(Request $request){
        // Reglas de validación
        $this->validate($request, [
            'referencia' => 'required',
            'productos' => 'required',
            'cantidades_devueltas' => 'required',
        ]);
        $userId = Auth::id();
       
        $ventaId = $request->input('referencia');
        $productos = $request->input('productos');
        $cantidadesDevueltas = $request->input('cantidades_devueltas');


        foreach ($productos as $productoId ) {
            
            $cantidadDevuelta = $cantidadesDevueltas[$productoId];
            
            if ($cantidadDevuelta > 0) {
                Devoluciones::create([
                    'venta_id' => $ventaId,
                    'producto_id' => $productoId,
                    'cantidad_devuelta' => $cantidadDevuelta,
                    'user_id' => $userId,
                ]);

                // Actualizar la cantidad en la tabla de productos
                $producto = Producto::find($productoId);
                $producto->unidades += $cantidadDevuelta;
                $producto->save();
            }


        }

        return redirect()->route('devoluciones.index')->with('success', 'Devolución registrada correctamente');
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
