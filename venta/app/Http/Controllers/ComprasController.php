<?php

namespace App\Http\Controllers;
use App\Models\Compra;
use App\Models\Proveedores;
use App\Models\Producto;
use App\Models\Compra_Producto;
use Illuminate\Http\Request;

class ComprasController extends Controller
{
    public function __construct(){
        //protegemos la url
        //al metodo index con el constructor le pasamos el parametro de autenticacion
        $this->middleware('auth');
    }
    //vista de compras
    public function index(){
        $compras = Compra::with('usuario')->get();
        return view('compras.lista')->with(['compras' => $compras]);
    }
    public function create()
    {
        $proveedores = Proveedores::all();
        $productos = Producto::all();
       
        return view('compras.create')->with(['proveedores' => $proveedores,'productos' => $productos]);
    }
    //editar
    public function edit(cliente $cliente)
    {

        return view('compras.edit', compact('cliente'));
    }
    // Validar y guardar datos del formulario
    public function store(Request $request){
     
        // Reglas de validación
        $this->validate($request, [
            'referencia' => 'required|unique:compra',
            'subtotal' => 'required',
            'impuestos' => 'required',
            'total' => 'required',
            'user_id' => 'required',
            'descripcion' => 'required',
            'carrito' => 'required',
        ]);
        // Invocar el modelo Compra para crear el registro con el user_id 
        $compra =Compra::create([
            'referencia' => $request->referencia,
            'subtotal' => $request->subtotal,
            'impuestos' => $request->impuestos,
            'total' => $request->total,
            'descripcion' => $request->descripcion,
            'user_id' => $request->user_id,
            'fecha' => now(),
        ]);

        $carrito = json_decode($request->carrito, true);
        foreach ($carrito as $producto) {
            // Crear el registro en la tabla compra_productos
            Compra_Producto::create([
                'cantidad' => $producto['cantidad'],
                'precio_compra' => $producto['precio_compra'],
                'proveedor_id' => $producto['proveedor_id'],
                'compra_id' => $compra->id,
                'producto_id' => $producto['producto_id'],
            ]);

        
            // Obtener el producto desde la base de datos
            $productoModel = Producto::find($producto['producto_id']);
        
            // Sumar la cantidad del carrito a las unidades del producto
            $nuevasUnidades = $productoModel->unidades + $producto['cantidad'];
            $nuevasPrecio = $producto['precio_compra'];
            
            // Actualizar el campo unidades del producto en la base de datos
            $productoModel->update([
                'unidades' => $nuevasUnidades,
                'precio_compra' => $nuevasPrecio,
            ]);
        }
        
        // Redireccionar a la vista de listado de categorías
        return redirect()->route('compras.index')->with('agregada', 'Compra agregada correctamente');
    }
    //vista de detalles de compras
    public function detalles_index($id){
        // Busca la compra por ID y carga las relaciones con 'usuario' y 'cliente'
        $compra = Compra::with('usuario')->find($id);
        $detalles = Compra_Producto::with('producto','proveedor')->where('compra_id', $id)->get();
        return view('compras.detalles')->with(['compra' => $compra,'detalles' => $detalles ]);
    }

}
