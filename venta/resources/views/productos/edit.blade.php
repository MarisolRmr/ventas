@extends('layouts.app')

@section('estilos')
<style>
    input:focus {
        outline-color: #5e72e4;
    }
    textarea:focus {
        outline-color: #5e72e4;
    }
    select:focus {
        outline-color: #5e72e4;
    }

    input {
        border-radius: 20px;
    }
    .mb-5 label {
        margin-bottom: 0.5rem;
    }
</style>
@endsection

@section('contenido')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0 mb-2 text-center">
          <h4>Editar Producto</h4>
        </div>
        <div class="card-body px-4 pt-4 pb-2 flex items-center justify-center text-center">
        <form action="{{ route('productos.update', $producto->id) }}" method="post" novalidate>
            @method('put')
            @csrf
            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="nombre" class="mb-2 block uppercase text-gray-500 font-bold">
                    Nombre
                </label>
                <input 
                    style="border-radius: 20px !important; height: 45px; width: 400px; margin-left: 20px; "
                    id="nombre"
                    name="nombre"
                    type="text"
                    placeholder="Nombre del producto"
                    class="border p-3 w-full rounded-lg @error('nombre') border-red-500 @enderror"
                    value="{{ old('nombre', $producto->nombre) }}"
                >
                @error('nombre')
                    <p style="background-color: #f56565; color: #fff; margin-top: 0.5rem; border-radius: 0.5rem; font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ $message }}
                    </p>    
                @enderror
            </div>

            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="precio_compra" class="mb-2 block uppercase text-gray-500 font-bold">
                    Precio de compra
                </label>
                <input 
                    style="border-radius: 20px !important; height: 45px; width: 400px; margin-left: 20px; "
                    id="precio_compra"
                    name="precio_compra"
                    type="number"
                    placeholder="Precio de compra"
                    class="border p-3 w-full rounded-lg @error('precio_compra') border-red-500 @enderror"
                    value="{{ old('precio_compra', $producto->precio_compra) }}"
                >
                @error('precio_compra')
                    <p style="background-color: #f56565; color: #fff; margin-top: 0.5rem; border-radius: 0.5rem; font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ $message }}
                    </p>    
                @enderror
            </div>

            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="precio_venta" class="mb-2 block uppercase text-gray-500 font-bold">
                    Precio de venta
                </label>
                <input 
                    style="border-radius: 20px !important; height: 45px; width: 400px; margin-left: 20px; "
                    id="precio_venta"
                    name="precio_venta"
                    type="number"
                    placeholder="Precio de venta"
                    class="border p-3 w-full rounded-lg @error('precio_venta') border-red-500 @enderror"
                    value="{{ old('precio_venta', $producto->precio_venta) }}"
                >
                @error('precio_venta')
                    <p style="background-color: #f56565; color: #fff; margin-top: 0.5rem; border-radius: 0.5rem; font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ $message }}
                    </p>    
                @enderror
            </div>

            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="unidades" class="mb-2 block uppercase text-gray-500 font-bold">
                    Unidades
                </label>
                <input 
                    style="border-radius: 20px !important; height: 45px; width: 400px; margin-left: 20px; "
                    id="unidades"
                    name="unidades"
                    type="number"
                    placeholder="Unidades"
                    class="border p-3 w-full rounded-lg @error('unidades') border-red-500 @enderror"
                    value="{{ old('unidades', $producto->unidades) }}"
                >
                @error('unidades')
                    <p style="background-color: #f56565; color: #fff; margin-top: 0.5rem; border-radius: 0.5rem; font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ $message }}
                    </p>    
                @enderror
            </div>

            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="categoria_id" class="mb-2 block uppercase text-gray-500 font-bold">
                    Categoría
                </label>
                <select 
                    style="border-radius: 20px !important; height: 55px; width: 400px; margin-left: 20px; "
                    id="categoria_id"
                    name="categoria_id"
                    class="border p-3 w-full rounded-lg @error('categoria_id') border-red-500 @enderror"
                >
                    <option value="">Selecciona una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ $categoria->id == old('categoria_id', $producto->categoria_id) ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id')
                    <p style="background-color: #f56565; color: #fff; margin-top: 0.5rem; border-radius: 0.5rem; font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ $message }}
                    </p>    
                @enderror
            </div>

            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="marca_id" class="mb-2 block uppercase text-gray-500 font-bold">
                    Marca
                </label>
                <select 
                    style="border-radius: 20px !important; height: 55px; width: 400px; margin-left: 20px; "
                    id="marca_id"
                    name="marca_id"
                    class="border p-3 w-full rounded-lg @error('marca_id') border-red-500 @enderror"
                >
                    <option value="">Selecciona una marca</option>
                    @foreach($marcas as $marca)
                        <option value="{{ $marca->id }}" {{ $marca->id == old('marca_id', $producto->marca_id) ? 'selected' : '' }}>
                            {{ $marca->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('marca_id')
                    <p style="background-color: #f56565; color: #fff; margin-top: 0.5rem; border-radius: 0.5rem; font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{ $message }}
                    </p>    
                @enderror
            </div>
            
            <div class="text-center">
              <button type="submit" class="h-2 flex gap-2 btn btn-primary my-4 p-2 text-white hover:text-white">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
