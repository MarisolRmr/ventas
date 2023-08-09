<?php

namespace App\Http\Controllers;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Subcategoria;
use App\Models\Cliente;
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
    //vista de ventas
    public function create(){
        $categorias = Categoria::all();
        $clientes = Cliente::all();
        return view('ventas.pos')->with(['categorias' => $categorias,'clientes' => $clientes]);
    }
    //vista de detalles de ventas
    public function detalles_index(){
        return view('ventas.detalles');
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