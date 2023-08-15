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
                    class="border p-3 w-full rounded-lg @error ('referenciaVenta') border-red-500 @enderror"
                    value="{{old('referenciaVenta')}}"
                >
                    <option value="">Seleccione la venta a devolver</option>
                    @foreach($ventas as $venta)
                        <option value="{{$venta->id}}">{{$venta->referencia}}</option>
                    @endforeach
                </select>
                @error('referenciaVenta')
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
            <div class="card mb-3 p-2" style="width: 500px; height: 190px;">
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
                                <p class="card-text mb-0" style="font-size: 15px">Cantidad a Devolver </p>
                            </div>
                            <div class="d-flex align-items-center" style="display:flex; justify-content:center">
                                <button class="btn btn-sm btn-primary mr-2" onclick="disminuirCantidad(${producto.id})" type="button">-</button>
                                <input id="cantidadInput${producto.id}" type="number" min="0" style="outline:none; width: 40px; border: 1px solid gray; border-radius: 8px; color: gray" class="text-center mr-2" value="0" oninput="validarCantidadInput(${producto.id}, this)" readonly onkeydown="return false"  />
                                <button class="btn btn-sm btn-primary" onclick="agregarCantidad(${producto.id}, ${productoVenta.cantidad})" type="button">+</button>

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

    
    function disminuirCantidad(productoId) {
        const cantidadInput = document.getElementById(`cantidadInput${productoId}`);
        if (cantidadInput.value > 0) {
            cantidadInput.value = parseInt(cantidadInput.value) - 1;
        }
    }

    function agregarCantidad(productoId, cantidadComprada) {
        const cantidadInput = document.getElementById(`cantidadInput${productoId}`);

        if (cantidadInput.value < cantidadComprada) {
            cantidadInput.value = parseInt(cantidadInput.value) + 1;
        }
    }


    
</script>


@endsection
