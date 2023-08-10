<?php

namespace App\Http\Controllers;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Subcategoria;
use App\Models\Cliente;
use App\Models\Venta;
use App\Models\Venta_Producto;
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
        $ventas = Venta::with('usuario','cliente')->get();
        return view('ventas.lista')->with(['ventas' => $ventas]);
    }
    //vista de ventas
    public function create(){
        $categorias = Categoria::all();
        $clientes = Cliente::all();
        return view('ventas.pos')->with(['categorias' => $categorias,'clientes' => $clientes]);
    }
    //vista de detalles de ventas
    public function detalles_index($id){
        // Busca la venta por ID y carga las relaciones con 'usuario' y 'cliente'
        $venta = Venta::with('usuario', 'cliente')->find($id);

        return view('ventas.detalles')->with(['venta' => $venta]);
    }
    // Validar y guardar datos del formulario
    public function store(Request $request){
     
        // Reglas de validación
        $this->validate($request, [
            'referencia' => 'required|unique:venta',
            'pagocon' => 'required',
            'cambio' => 'required',
            'subtotal' => 'required',
            'impuestos' => 'required',
            'total' => 'required',
            'cliente_id' => 'required',
            'user_id' => 'required',
            'carrito' => 'required',
        ]);
        // Invocar el modelo Venta para crear el registro con el user_id y cliente_id
        $venta =Venta::create([
            'referencia' => $request->referencia,
            'pagocon' => $request->pagocon,
            'cambio' => $request->cambio,
            'subtotal' => $request->subtotal,
            'impuestos' => $request->impuestos,
            'total' => $request->total,
            'cliente_id' => $request->cliente_id,
            'user_id' => $request->user_id,
            'fecha' => now(),
        ]);

        $carrito = json_decode($request->carrito, true);
        foreach ($carrito as $producto) {
            // Crear el registro en la tabla venta_productos
            Venta_Producto::create([
                'cantidad' => $producto['cantidad'],
                'venta_id' => $venta->id,
                'producto_id' => $producto['id'],
            ]);
        
            // Obtener el producto desde la base de datos
            $productoModel = Producto::find($producto['id']);
        
            // Restar la cantidad del carrito a las unidades del producto
            $nuevasUnidades = $productoModel->unidades - $producto['cantidad'];
            
            // Actualizar el campo unidades del producto en la base de datos
            $productoModel->update([
                'unidades' => $nuevasUnidades,
            ]);
        }
        
        // Redireccionar a la vista de listado de categorías
        return redirect()->route('ventas.index')->with('agregada', 'Venta agregada correctamente');
    }
    //para obetener las subcategorias de una categoria
    public function subcategorias($id)
    {
        $subcategorias = Subcategoria::where('categoria_id', $id)->get();
        return response()->json($subcategorias);
    }

    // Función para obtener todos los productos con su relación 'marca'
    public function productosTodos()
    {
        $productos = Producto::with('marca')->get();
        return response()->json($productos);
    }

    public function productosPorCategoria($categoriaId)
    {
        // Filtrar los productos por el ID de la categoría seleccionada y cargar la relación con la marca
        $productos = Producto::where('categoria_id', $categoriaId)->with('marca')->get();

        // Retornar los productos filtrados como respuesta JSON
        return response()->json($productos);
    }

    public function productosPorSubcategoria($subcategoriaId)
    {
        // Filtrar los productos por el ID de la subcategoría seleccionada y cargar la relación con la marca
        $productos = Producto::where('subcategoria_id', $subcategoriaId)->with('marca')->get();

        // Retornar los productos filtrados como respuesta JSON
        return response()->json($productos);
    }


}
