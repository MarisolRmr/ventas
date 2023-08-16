<?php

namespace App\Http\Controllers;
use App\Models\Cotizacion;
use App\Models\Cotizacion_Producto;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Http\Request;

class CotizacionesController extends Controller
{
    public function __construct(){
        //protegemos la url
        //al metodo index con el constructor le pasamos el parametro de autenticacion
        $this->middleware('auth');
    }
    //vista de cotizaciones
    public function index(){
        $cotizaciones = Cotizacion::with('usuario','cliente')->get();
        return view('cotizaciones.lista')->with(['cotizaciones' => $cotizaciones]);
    }
    public function create()
    {
        $productos = Producto::all();
        $clientes = Cliente::all();
        return view('cotizaciones.create')->with(['productos' => $productos,'clientes' => $clientes]);
    }
    // Validar y guardar datos del formulario
    public function store(Request $request){
     
        // Reglas de validación
        $this->validate($request, [
            'referencia' => 'required|unique:cotizacion',
            'descripcion' => 'required',
            'subtotal' => 'required',
            'impuestos' => 'required',
            'total' => 'required',
            'cliente_id' => 'required',
            'user_id' => 'required',
            'carrito' => 'required',
        ]);
        // Invocar el modelo cotizacion para crear el registro con el user_id y cliente_id
        $cotizacion =Cotizacion::create([
            'referencia' => $request->referencia,
            'subtotal' => $request->subtotal,
            'descripcion' => $request->descripcion,
            'impuestos' => $request->impuestos,
            'total' => $request->total,
            'cliente_id' => $request->cliente_id,
            'user_id' => $request->user_id,
            'fecha' => now(),
        ]);

        $carrito = json_decode($request->carrito, true);
        foreach ($carrito as $producto) {
            // Crear el registro en la tabla venta_productos
            Cotizacion_Producto::create([
                'cantidad' => $producto['cantidad'],
                'cotizacion_id' => $cotizacion->id,
                'producto_id' => $producto['producto_id'],
            ]);
        
            
        }
        
        // Redireccionar a la vista de listado de categorías
        return redirect()->route('cotizaciones.index')->with('agregada', 'Cotizacion agregada correctamente');
    }
    //vista de detalles de cotizaciones
    public function detalles_index($id){
        // Busca la cotizacion por ID y carga las relaciones con 'usuario' y 'cliente'
        $cotizacion = Cotizacion::with('usuario', 'cliente')->find($id);
        $detalles = Cotizacion_Producto::with('producto')->where('cotizacion_id', $id)->get();
        return view('cotizaciones.detalles')->with(['cotizacion' => $cotizacion,'detalles' => $detalles ]);
    }

    //eliminar cotizacion
    public function delete($id)
    {
        // Eliminar registros de la tabla cotizacion_producto donde cotizacion_id sea igual a $id
        Cotizacion_Producto::where('cotizacion_id', $id)->delete();
        
        // Eliminar la cotización
        Cotizacion::find($id)->delete();
        return redirect()->back()->with('success', 'Cotizacion eliminada correctamente');
    }

    public function edit(Cotizacion $cotizacion)
    {
        $productos = Producto::all();
        $clientes = Cliente::all();
        // Obtén los productos asociados y los detalles relevantes
        $productosAsociados = Cotizacion_Producto::select('id', 'cantidad', 'cotizacion_id', 'producto_id')
        ->with('producto:id,nombre,imagen,precio_venta')
        ->where('cotizacion_id', $cotizacion->id)
        ->get()
        ->map(function ($item) {
            return [
                'id' => $item->id,
                'cantidad' => $item->cantidad,
                'cotizacion_id' => $item->cotizacion_id,
                'producto_id' => strval($item->producto_id),
                'nombre' => $item->producto->nombre,
                'imagen' => $item->producto->imagen,
                'total' => $item->producto->precio_venta * $item->cantidad,
                'impuestos' => ($item->producto->precio_venta * $item->cantidad)*0.16,
                'subtotal' => ( $item->producto->precio_venta * $item->cantidad)-(($item->producto->precio_venta * $item->cantidad)*0.16),
                'precio_venta' => $item->producto->precio_venta,
            ];
        });
        return view('cotizaciones.edit', compact('cotizacion', 'productos', 'clientes', 'productosAsociados'));
    }

    public function update(Request $request, Cotizacion $cotizacion)
    {
        /// Reglas de validación
        $this->validate($request, [
            'referencia' => 'required',
            'descripcion' => 'required',
            'subtotal' => 'required',
            'impuestos' => 'required',
            'total' => 'required',
            'cliente_id' => 'required',
            'user_id' => 'required',
            'carrito' => 'required',
        ]);
        
        
        // Primero eliminamos los registros relacionados en cotizacion_producto
        Cotizacion_Producto::where('cotizacion_id', $cotizacion->id)->delete();
        
        // Luego eliminamos la cotización actual
        $cotizacion->delete();
        
        
        // Invocar el modelo cotizacion para crear el registro con el user_id y cliente_id
        $cotizacion =Cotizacion::create([
            'referencia' => $request->referencia,
            'subtotal' => $request->subtotal,
            'descripcion' => $request->descripcion,
            'impuestos' => $request->impuestos,
            'total' => $request->total,
            'cliente_id' => $request->cliente_id,
            'user_id' => $request->user_id,
            'fecha' => now(),
        ]);

        $carrito = json_decode($request->carrito, true);
        foreach ($carrito as $producto) {
            // Crear el registro en la tabla venta_productos
            Cotizacion_Producto::create([
                'cantidad' => $producto['cantidad'],
                'cotizacion_id' => $cotizacion->id,
                'producto_id' => $producto['producto_id'],
            ]);
        
            
        }
        
        // Redireccionar a la vista de listado de categorías
        return redirect()->route('cotizaciones.index')->with('actualizada', 'Cotizacion actualizada correctamente');
    
    }

    
}
