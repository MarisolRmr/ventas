@extends('layouts.app')
<!--directiva para integrar los estilos de dropzone-->
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
@endpush

@section('estilos')
<style>
    input:focus {
        outline-color: #5e72e4;
    }
    textarea:focus {
        outline-color: #5e72e4;
    }

    input {
        border-radius: 20px;
    }
    .mb-5 label {
        margin-bottom: 0.5rem;
        
    }
    .dropzone.dz-clickable .dz-message, .dropzone.dz-clickable .dz-message * {
        width: 400px !important;
    }
    
</style>
@endsection

@section('navegacion')
    Agregar Devolución
@endsection

@section('contenido')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0 mb-2 text-center">
          <h4>Agregar una nueva devolución</h4>
        </div>
        <div class="card-body px-4 pt-4 pb-2 flex items-center justify-center text-center">
  
            <form action="{{route('devoluciones.store')}}" method="post" novalidate>
            @csrf
            
            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="referenciaVenta" class="mb-2 block uppercase text-gray-500 font-bold">
                    Referencia de venta
                </label>
                <select 
                    style="border-radius: 20px !important; height: 50px; width: 400px; margin-left: 20px; "
                    id="referenciaVenta"
                    name="referenciaVenta"
                    class="border p-3 w-full rounded-lg @error ('venta') border-red-500 @enderror"
                    value="{{old('referenciaVenta')}}"
                >
                    <option value="">Seleccione la venta a devolver</option>
                    @foreach($ventas as $venta)
                        <option value="{{$venta->id}}">{{$venta->referencia}}</option>
                    @endforeach
                </select>
                @error('venta')
                    <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            <div class="p-3 overflow text-center" style="max-height: 55%;height: 100%; overflow-y:auto" id="carritoContainer">
                No hay productos
                @error('carrito')
                    <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            <br>

            
            
            <div class="text-center">
              <button type="submit"class="h-2 flex gap-2 btn btn-primary my-4 p-2 text-white hover:text-white">Guardar</button>
              <button type="button"class="h-2 flex gap-2 btn btn-secondary my-4 p-2 text-black hover:text-white"><a href="{{route('devoluciones.index')}}">Cancelar</a></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
    $(document).ready(function() {
        $('#referenciaVenta').on('change', function() {
            var ventaId = $(this).val();

            if (ventaId) {
                $.ajax({
                    url: '/get-products/' + ventaId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var productos = response.productos;
                        var carritoContainer = $('#carritoContainer');

                        carritoContainer.empty();

                        if (productos.length > 0) {
                            $.each(productos, function(index, productoVenta) {
                                console.log(productoVenta);
                                var producto = productoVenta.producto;

                                const productoHtml = `
        <div class="container d-flex align-items-center justify-content-center" overflow-y: scroll;">
            <div class="card mb-3 p-2" style="width: 500px; height: 150px;">
                <div class="row g-0" style="width: 500px; height: 100px;">
                    <div class="col-md-4 d-flex align-items-center">
                        <img style="height: 90px; border-radius: 10px;" src="{{ asset('uploads/') }}/${producto.imagen}" alt="Imagen de producto" class="img-fluid shadow">
                    </div>
                    <div class="col-md-8 p-0">
                        <div class="card-body p-2">
                            <h5 class="card-title mb-1" style="font-size:16px">${producto.nombre}</h5>
                            <div class="d-flex align-items-center mt-1">
                            <p class="card-text mb-0 mr-3" style="font-size: 15px">Pre. Unit. <br>$${parseFloat(producto.precio_venta).toFixed(2)}</p>
                            <p class="card-text mb-0 mr-3" style="font-size: 15px">Cantidad Comprada <br>${productoVenta.cantidad}</p>
                            <p class="card-text mb-0" style="font-size: 15px">Total <br>$${(parseFloat(producto.precio_venta * productoVenta.cantidad)).toFixed(2) }</p>
                            </div>
                            <div class="d-flex align-items-center mt-3">
                                <button class="btn btn-sm btn-primary mr-2" onclick="disminuirCantidad(${producto.id})">-</button>
                                <input type="number" style="outline:none; width: 27px;border:1px solid gray; border-radius: 8px; color:gray" class="text-center mr-2" value="${producto.cantidad}" class="mr-2" oninput="validarCantidadInput(${producto.id}, this)"/>
                                <button class="btn btn-sm btn-primary" onclick="agregarCantidad(${producto.id})">+</button>
                                <button class="btn btn-danger btn-sm ml-auto" onclick="eliminarDeVenta(${producto.id})"> Devolver toda la compra
                                    <svg style="width: 15px; height: 15px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
            `;
            carritoContainer.append('<p>' + productoHtml + '</p>');

            


                            });
                        } else {
                            carritoContainer.text('No hay productos');
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            } else {
                $('#carritoContainer').text('No hay productos');
            }
        });

        
    });
</script>


@endsection
