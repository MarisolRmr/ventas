<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\Marca;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

use Illuminate\Support\Facades\Validator;


class ProductosController extends Controller
{
    public function __construct(){
        //protegemos la url
        //al metodo index con el constructor le pasamos el parametro de autenticacion
        $this->middleware('auth');
    }

    //mostrar vista de listado productos
    public function index()
    {
        $productos = Producto::all();
        
        // Obtener los nombres de categoría correspondientes a cada producto
        $categorias = Categoria::whereIn('id', $productos->pluck('categoria_id'))->pluck('nombre', 'id');

        // Obtener los nombres de marcas correspondientes a cada producto
        $marcas = Marca::whereIn('id', $productos->pluck('marca_id'))->pluck('nombre', 'id');

        // Obtener los nombres de subcategorias correspondientes a cada producto
        $subcategorias = Subcategoria::whereIn('id', $productos->pluck('subcategoria_id'))->pluck('nombre', 'id');

        return view('productos.lista')->with([
            'productos' => $productos,
            'categorias' => $categorias,
            'subcategorias' => $subcategorias,
            'marcas' => $marcas
        ]);
    }

    public function delete($id)
    {
        Producto::find($id)->delete();
        return redirect()->back()->with('success', 'Producto eliminado correctamente');
    }
    
    // Mostrar vista de formulario
    public function create()
    {
        $categorias = Categoria::all();
        $marcas = Marca::all();
        $subcategorias = Subcategoria::all();
        return view('productos.create', compact('categorias','marcas','subcategorias'));
    }

    //editar
    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        $marcas = Marca::all();
        $subcategorias = Subcategoria::all();
        return view('productos.edit', compact('producto','categorias','marcas','subcategorias'));
    }

    // Validar y guardar datos del formulario
    public function store(Request $request)
    {
        // Reglas de validación
        $this->validate($request, [
            'nombre' => 'required',
            'unidades' => 'required|numeric|min:0',
            'imagen'=>'required',
            'precio_venta' => 'required|numeric|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'categoria_id' => 'required',
            'marca_id' => 'required',
        ]);
        // Obtener el ID del usuario autenticado
        $userId = Auth::id();

        // Invocar el modelo Producto para crear el registro
        Producto::create([
            'nombre' => $request->nombre,
            'precio_venta' => $request->precio_venta,
            'precio_compra' => $request->precio_compra,
            'unidades' => $request->unidades,
            'categoria_id' => $request->categoria_id,
            'subcategoria_id' => $request->subcategoria_id,
            'marca_id' => $request->marca_id,
            'imagen' => $request->imagen,
            'user_id' => $userId,
        ]);

        // Redireccionar a la vista de listado de categorías
        return redirect()->route('productos.index')->with('agregada', 'Producto agregado correctamente');
    }
    //guardar cambios editados
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'unidades' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'categoria_id' => 'required',
            'marca_id' => 'required',
            'imagen' => 'required',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->nombre = $request->nombre;
        $producto->precio_venta = $request->precio_venta;
        $producto->precio_compra = $request->precio_compra;
        $producto->unidades = $request->unidades;
        $producto->imagen = $request->imagen;
        $producto->subcategoria_id = $request->subcategoria_id;
        $producto->categoria_id = $request->categoria_id;
        $producto->marca_id = $request->marca_id;
        $producto->save();

        return redirect()->route('productos.index')->with('actualizado', 'Producto actualizado correctamente.');
    }
    //para guardar la imagen del producto
    public function store_imagen(Request $request){
        //identificar el archivo que se sube en dropzone
        $imagen=$request->file('file');

        //convertimos el arreglo input a formato json
        //return response()->json(['imagen'=>$imagen->extension()]);
        //genera un id unico para cada una de las imagenes que se cargan en el server
        $nombreImagen = Str::uuid() . ".". $imagen->extension();

        //implementar intervention Image 
        $imagenServidor=Image::make($imagen);

        //agregamos efectps de intervention image: indicamos la medida de cada imagen
        $imagenServidor->fit(1000,1000);

        //movemos la imagen a un lugar fisico del servidor
        $imagenPath=public_path('uploads'). '/'. $nombreImagen;

        //pasamos la imagen de memoria al server
        $imagenServidor->save($imagenPath);

        ///verificamos que el nombre del archivo se ponga como unico
        return response()->json(['imagen'=>$nombreImagen]);

    }

    public function detalles($id){

       
        $producto = Producto::find($id);

        $categorias = Categoria::whereIn('id', $producto->pluck('categoria_id'))->pluck('nombre', 'id');

        // Obtener los nombres de marcas correspondientes a cada producto
        $marcas = Marca::whereIn('id', $producto->pluck('marca_id'))->pluck('nombre', 'id');

        // Obtener los nombres de subcategorias correspondientes a cada producto
        $subcategorias = Subcategoria::whereIn('id', $producto->pluck('subcategoria_id'))->pluck('nombre', 'id');
    
        // Verificar si se encontró el producto
        if ($producto) {
            // pasar los datos del producto a la vista
            
            return view('productos.detalle')->with([
                'productos' => $producto,
                'categorias' => $categorias,
                'subcategorias' => $subcategorias,
                'marcas' => $marcas
            ]);
        } else {
            // Manejar la situación si el producto no se encontró
            return redirect()->back()->with('error', 'Producto no encontrado');
        }
    }

    public function importar_form(){
        return view('productos.importar');
    }

    public function importar(Request $request){
        $userId = Auth::id();
        $archivoCSV = $request->file('archivo_csv');

        $validator = Validator::make($request->all(), [
            'archivo_csv' => 'required|mimes:csv,txt',
        ]);

        // Obtener la primera línea del archivo
        $primerLinea = null;
        if (($handle = fopen($request->archivo_csv, "r")) !== false) {
            $primerLinea = fgetcsv($handle);
            fclose($handle);
        }

        // Estructura esperada en la primera línea
        $estructuraEsperada = ['nombre', 'precio_venta', 'precio_compra', 'unidades', 'categoria_id', 'subcategoria_id', 'marca_id', 'imagen'];

        // Validar la estructura del archivo
        if ($primerLinea === null || count($primerLinea) !== count($estructuraEsperada) || $primerLinea !== $estructuraEsperada) {
            return redirect()->back()->with('error', 'El archivo CSV no cumple con la estructura esperada.');
        }


        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Error al cargar el archivo CSV');
        }

        if ($archivoCSV) {
            $csv = array_map('str_getcsv', file($archivoCSV));
            $cabeceras = array_shift($csv); // Ignora la primera fila con las cabeceras

            foreach ($csv as $fila) {
               
                Producto::create([
                    'nombre' => $fila[0],
                    'precio_venta' => $fila[1],
                    'precio_compra' => $fila[2],
                    'unidades' => $fila[3],
                    'categoria_id' => $fila[4],
                    'subcategoria_id' => $fila[5],
                    'marca_id' => $fila[6],
                    'imagen' => $fila[7],
                    'user_id' => $userId,
                ]);
            }

            return redirect()->back()->with('success', 'Productos importados correctamente.');
        }

        return redirect()->back()->with('error', 'Error al cargar el archivo CSV');
    }


}

