@extends('layouts.app')
<!--directiva para integrar los estilos de dropzone-->
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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
    .dataTables_wrapper .dataTables_filter input {
        color: gray;
        border-radius: 20px;
        margin-left: 10px;
        outline-offset: 0px;
    }
    .dataTables_wrapper .dataTables_filter input:focus{
        border-radius: 20px;
        margin-left: 10px;
        outline-offset: 0px;
        border: 1px solid gray;
        outline: none;
        padding: 5px 15px;
    }
    .dataTables_wrapper .dataTables_length select {

        outline-offset: 0px;
        outline: none;
    }

    input[type="search"]::-webkit-search-cancel-button {
        display: none;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 50px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        border: 1px solid transparent;
        background: rgb(94, 114, 228);
    }
    .bg-green-200 {
        background-color: #86efac;
    }
    .select2-selection{
        border-radius: 20px !important; 
        height: 50px !important; 
        width: 100% !important; 
        border-bottom-right-radius: 20px !important;
        border-bottom-left-radius: 20px !important;
            
    }
    .select2-selection:focus{
        outline-color: #5e72e4;
        height: 50px !important; 
        width: 100% !important; 
       
        border-bottom-right-radius: 20px !important;
        border-bottom-left-radius: 20px !important;
            
    }
    .select2-selection[aria-expanded='true'] {
        border-bottom-right-radius: 20px !important;
        border-bottom-left-radius: 20px  !important;
    }
    .select2.select2-container {
        width: 100% !important;
        
    }
    .select2-container .select2-selection--single {
        height: 50px !important;
    }
    .bg-red-500{
        background-color: #f56565 !important;
    }
    input[type=number] { -moz-appearance:textfield; }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
    }
</style>
@endsection

@section('navegacion')
Agregar Compra
@endsection

@section('contenido')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0 mb-2 text-center">
          <h4>Agregar una compra</h4>
        </div>
        <div class="card-body px-4 pt-4 pb-2 flex items-center justify-center text-center"> 
            <form action="{{route('compras.store')}}" method="post" novalidate>
                @csrf
                
            <!-- Primera fila -->
            <div class="mb-4 w-full" style="display: flex; align-items: center; justify-content:center">
                <div style="margin-right: 20px" class="w-100">
                    <div>
                    <label for="proveedor_id" class="block uppercase text-gray-500 font-bold">
                        Proveedor
                    </label>
                    </div>
                    <div>
                    <select class="form-control mi-selector" id="proveedor_id" name="proveedor_id" style="width: 300px;">
                        <option value="">Seleccione un proveedor</option>
                        @foreach ($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}" 
                                @if (old('proveedor_id') == $proveedor->id)
                                    selected
                                @endif
                            >{{$proveedor->nombre}}</option>
                        @endforeach
                    </select>
                    <div class="error-message error-proveedor_id"></div>
                    @error('proveedor_id')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{$message}}
                        </p>
                    @enderror
                    </div>
                </div>
                <div style="margin-right: 20px" class="w-100">
                    <div>
                    <label for="producto_id" class="block uppercase text-gray-500 font-bold">
                        Producto
                    </label>
                    </div>
                    <div>
                    <select class="form-control mi-selector" id="producto_id" name="producto_id" style="width: 300px;">
                        <option value="">Seleccione un producto</option>
                        @foreach ($productos as $producto)
                            <option data-precio="{{$producto->precio_compra}}" data-imagen="{{$producto->imagen}}" data-nombre="{{$producto->nombre}}" value="{{ $producto->id }}" 
                                @if (old('producto_id') == $producto->id)
                                    selected
                                @endif
                            >{{$producto->nombre}}</option>
                        @endforeach
                    </select>
                    <div class="error-message error-producto_id"></div>
                    @error('producto_id')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{$message}}
                        </p>
                    @enderror
                    </div>
                </div>
                
            </div>

            <!-- Segunda fila -->
            <div class="mb-4 w-full" style="display: flex; align-items: center; justify-content:center">
                
                
                <div style="margin-right: 20px" class="w-100">
                    <div>
                    <label for="cantidad" class="block uppercase text-gray-500 font-bold">
                        Cantidad
                    </label>
                    </div>
                    <div>
                    <input 
                        style="width:100%; border-radius: 20px !important; height: 45px;  margin-top: 5px"
                        id="cantidad"
                        name="cantidad"
                        type="text"
                        placeholder="Cantidad de productos"
                        class="border p-3 w-full rounded-lg @error ('cantidad') border-red-500 @enderror"
                        value="{{old('cantidad')}}"
                    >
                    @error('cantidad')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{$message}}
                        </p>
                    @enderror
                    <div class="error-message error-cantidad"></div>
                    </div>
                </div>
                
                <div class="w-100">
                    <div>
                    <label for="precio_compra" class="block uppercase text-gray-500 font-bold">
                        Precio de compra
                    </label>
                    </div>
                    <div>
                    <input 
                        style="width:100%; border-radius: 20px !important; height: 45px; margin-top: 5px"
                        id="precio_compra"
                        name="precio_compra"
                        type="text"
                        placeholder="Modificar el precio de compra"
                        class="border p-3 w-full rounded-lg @error ('precio_compra') border-red-500 @enderror"
                        value="{{old('precio_compra')}}"
                    >
                    @error('precio_compra')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{$message}}
                        </p>
                    @enderror
                    
                    </div>
                </div>
            </div>

                <div class="text-right mb-2">
                    <a id="agregarProducto" class="h-2 flex gap-2 btn btn-primary my-1 p-2 text-white hover:text-white">
                        <svg style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-2 h-2">
                            <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                        </svg>
                        Agregar producto
                    </a>
                </div>
            
                <div class="card m-1" >
                    <div class="card-body m-h-200">
                        <div class="table-responsive">
                            <table id="example" class="table align-items-center mb-0 hover w-100">
                                <thead>
                                    <tr>
                                    <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7 ">Producto</th>
                                    <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7 ">Imagen</th>
                                    <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Precio de compra</th>
                                    <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Cantidad</th>
                                    <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Subtotal</th>
                                    <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Impuestos</th>
                                    <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Total</th>
                                    <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    @error('carrito')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{$message}}
                        </p>
                    @enderror
                    </div>   
                </div>
                <input type="hidden" id="total_hidden" name="total" value="{{old('total')}}">
                <input type="hidden" id="subtotal_hidden" name="subtotal" value="{{old('subtotal')}}">
                <input type="hidden" id="impuestos_hidden" name="impuestos" value="{{old('impuestos')}}">
                <input type="hidden" id="carrito_input" name="carrito" value="{{old('carrito')}}">
                <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
                <div class="mb-2 mt-4 w-full" style="display: flex; align-items: center; justify-content:center"> 
                    <div class="w-100 ">
                        <div>
                            <label for="referencia" class="block uppercase text-gray-500 font-bold">
                                Referencia de Compra
                            </label>
                        </div>
                        <div >
                            <input 
                                style="border-radius: 20px !important; height: 45px; width: 100%; margin-top: 5px"
                                id="referencia"
                                name="referencia"
                                type="text"
                                placeholder="Referencia de la compra"
                                class="border p-3 w-full rounded-lg @error ('referencia') border-red-500 @enderror"
                                value="{{old('referencia')}}"
                            >
                            <div class="error-message error-referencia"></div>
                            @error('referencia')
                                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                                    {{$message}}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-end items-center w-100 mt-4">
                    <div class="text-center w-50">
                    <div>
                    <label for="descripcion" class="block uppercase text-gray-500 font-bold">
                        Descripción
                    </label>
                    </div>
                    <div>
                    <textarea 
                        style="width:100%;border-radius: 20px !important; height: 100px;  margin-top: 5px"
                        id="descripcion"
                        name="descripcion"
                        type="text"
                        placeholder="Descripción de la compra"
                        class="border p-3 w-full rounded-lg "
                        value="{{old('descripcion')}}"
                    >{{old('descripcion')}}</textarea>
                    <div class="error-message error-descripcion"></div>
                    @error('descripcion')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{$message}}
                        </p>
                    @enderror
                    </div>
                    </div>
                    <div class="text-end w-50">
                        <p>Subtotal: $<span id="subtotalValor">0.00</span></p>
                        <p>IVA (16%): $<span id="impuestosValor">0.00</span></p>
                        <p>Total: $<span id="totalValor">0.00</span></p>
                        <button type="submit" class="h-2 flex gap-2 btn btn-primary my-2 p-2 text-white hover:text-white">Finalizar Compra</button>
                    </div>

                </div>
            </form>
        </div>


      </div>
    </div>
  </div>
</div>

@endsection
@section('js')
<script>
    $('#producto_id').change(function () {
        actualizarPrecioCompra();
    });
    // Función para actualizar el campo de precio de compra
    function actualizarPrecioCompra() {
        var producto_id = $('#producto_id').val();
        var precioCompra = $('#producto_id option:selected').data('precio');
        
        if (precioCompra) {
            $('#precio_compra').val(precioCompra);
        } else {
            $('#precio_compra').val('');
        }
    }
    function actualizarCarrito() {
        $('#example tbody tr:first-child').hide();
        if ($('#example tbody tr').length === 1) {
            $('#example tbody tr:first-child').show();
        }

        let totalCarrito = 0;
        let subtotalCarrito = 0;
        let impuestosCarrito = 0;
        console.log(carrito);
        document.getElementById('carrito_input').value = JSON.stringify(carrito);
        // Iterating over the products in the cart and accumulating the values
        carrito.forEach(producto => {
            totalCarrito += parseFloat(producto.total);
            subtotalCarrito += parseFloat(producto.subtotal);
            impuestosCarrito += parseFloat(producto.impuestos);
        });

        // Updating values on the page
        const totalElement = document.getElementById('totalValor');
        const subtotalElement = document.getElementById('subtotalValor');
        const impuestosElement = document.getElementById('impuestosValor');

        totalElement.textContent = totalCarrito.toFixed(2);
        subtotalElement.textContent = subtotalCarrito.toFixed(2);
        impuestosElement.textContent = impuestosCarrito.toFixed(2);
        // Actualizar los input hidden con los valores
        document.getElementById('subtotal_hidden').value = subtotalCarrito.toFixed(2);
        document.getElementById('impuestos_hidden').value = impuestosCarrito.toFixed(2);
        document.getElementById('total_hidden').value = totalCarrito.toFixed(2);

        // ...
    }
    function eliminarDelCarrito(producto_id) {
        // Convertir el producto_id recibido a cadena de texto
        producto_id = producto_id.toString();

        // Filtrar el carrito y mantener todos los productos excepto el que tiene el producto_id
        carrito = carrito.filter(producto => producto.producto_id !== producto_id);

        // Eliminar la fila de la tabla por ID
        $('#' + producto_id).remove();

        // Actualizar los valores del carrito después de la eliminación
        actualizarCarrito();
    }
    // Función para actualizar la cantidad de un producto en el carrito y hacer la validación
    function validarCantidadInput(productId, inputCantidad) {
        const productoEnCarrito = carrito.find(producto => producto.producto_id !== producto_id);

        if (productoEnCarrito) {
            const nuevaCantidad = parseInt(inputCantidad.value);
            
            if (nuevaCantidad>0) {
                productoEnCarrito.cantidad = nuevaCantidad;
                
            }else{
                inputCantidad.value = 1; 
                productoEnCarrito.cantidad=1;
            }
            productoEnCarrito.total = (parseFloat(productoEnCarrito.precio_compra) * productoEnCarrito.cantidad).toFixed(2);
            productoEnCarrito.impuestos = (productoEnCarrito.total * 0.16).toFixed(2);
            productoEnCarrito.subtotal = (parseFloat(productoEnCarrito.total) - parseFloat(productoEnCarrito.impuestos)).toFixed(2);
            const filaTabla = $(`#${productId}`);
            filaTabla.find('#subtotal-column').text(`$${productoEnCarrito.subtotal}`);
            filaTabla.find('#impuestos-column').text(`$${productoEnCarrito.impuestos}`);
            filaTabla.find('#total-column').text(`$${productoEnCarrito.total}`);

            actualizarCarrito();
            
        }
    }
    //Funcion para agregar cantidad de productos al carrito
    function agregarCantidad(productId, cantidad) {
        event.preventDefault();
        productId = productId.toString();
        console.log(productId);
        // Buscar el producto en el carrito por su ID
        const productoEnCarrito = carrito.find(producto => producto.producto_id !== producto_id);

        if (productoEnCarrito) {
            productoEnCarrito.cantidad++;
            productoEnCarrito.total = (parseFloat(productoEnCarrito.precio_compra) * productoEnCarrito.cantidad).toFixed(2);
            productoEnCarrito.impuestos = (productoEnCarrito.total * 0.16).toFixed(2);
            productoEnCarrito.subtotal = (parseFloat(productoEnCarrito.total) - parseFloat(productoEnCarrito.impuestos)).toFixed(2);
            
            // Actualizar el valor del campo de cantidad en el input correspondiente
            const cantidadInput = document.querySelector(`#cantidad-${productId}`);
            if (cantidadInput) {
                cantidadInput.value = productoEnCarrito.cantidad;
                const filaTabla = $(`#${productId}`);
                filaTabla.find('#subtotal-column').text(`$${productoEnCarrito.subtotal}`);
                filaTabla.find('#impuestos-column').text(`$${productoEnCarrito.impuestos}`);
                filaTabla.find('#total-column').text(`$${productoEnCarrito.total}`);
            }
            actualizarCarrito();
            
        }

        // Actualizar el contenido del carrito
        actualizarCarrito();
    }

    // Función para disminuir la cantidad de un producto en el carrito
    function disminuirCantidad(productId) {
        event.preventDefault();
        productId = productId.toString();
        console.log(productId);
        // Buscar el producto en el carrito por su ID
        const productoEnCarrito = carrito.find(producto => producto.producto_id !== producto_id);

        if (productoEnCarrito) {
            // Si el producto está en el carrito y su cantidad es mayor a 1, disminuir la cantidad en 1
            if (productoEnCarrito.cantidad > 1) {
                productoEnCarrito.cantidad--;
                productoEnCarrito.total = (parseFloat(productoEnCarrito.precio_compra) * productoEnCarrito.cantidad).toFixed(2);
                productoEnCarrito.impuestos = (productoEnCarrito.total * 0.16).toFixed(2);
                productoEnCarrito.subtotal = (parseFloat(productoEnCarrito.total) - parseFloat(productoEnCarrito.impuestos)).toFixed(2);

                // Actualizar el valor del campo de cantidad en el input correspondiente
            const cantidadInput = document.querySelector(`#cantidad-${productId}`);
            if (cantidadInput) {
                cantidadInput.value = productoEnCarrito.cantidad;
                const filaTabla = $(`#${productId}`);
                filaTabla.find('#subtotal-column').text(`$${productoEnCarrito.subtotal}`);
                filaTabla.find('#impuestos-column').text(`$${productoEnCarrito.impuestos}`);
                filaTabla.find('#total-column').text(`$${productoEnCarrito.total}`);
            }
            } 
            actualizarCarrito();
        }

        // Actualizar el contenido del carrito
        actualizarCarrito();
    }
    // Función para crear las filas de la tabla con los datos del carrito
    function crearFilasDelCarrito() {
        const tablaBody = $('#example tbody');
        
        carrito.forEach(producto => {
            const productoHtml = `
                <tr id="${producto.producto_id}">
                    <td class="text-center">${producto.nombre}</td>
                    <td class="text-center"><img style="width: 45px;height: 45px; border-radius:15px" src="{{asset('uploads/${producto.imagen}')}}" alt="Imagen del producto" width="50"></td>
                    <td class="text-center" id="precio_compra-column">$${producto.precio_compra}</td>
                    <td class="text-center"><button class="btn btn-sm btn-primary mr-2" onclick="disminuirCantidad(${producto.producto_id})">-</button>
                            <input id="cantidad-${producto.producto_id}" type="number" style="outline:none; width: 27px;border:1px solid gray; border-radius: 8px; color:gray" class="text-center mr-2" value="${producto.cantidad}"  oninput="validarCantidadInput(${producto.producto_id}, this)"/>
                            <button class="btn btn-sm btn-primary" onclick="agregarCantidad(${producto.producto_id})">+</button>
                            </td>
                    <td class="text-center" id="subtotal-column">$${producto.subtotal}</td>
                    <td class="text-center" id="impuestos-column">$${producto.impuestos}</td>
                    <td class="text-center" id="total-column">$${producto.total}</td>
                    <td class="text-center">
                        <a href="#" class="text-danger" onclick="eliminarDelCarrito(${producto.producto_id}); return false;">Eliminar</a>
                    </td>
                </tr>`;
            
            tablaBody.append(productoHtml);
        });
    }

    // Variable para almacenar los productos del carrito
    let carrito = [];
    @if(old('carrito'))
        carrito = {!! json_encode(json_decode(urldecode(old('carrito')))) !!};
        crearFilasDelCarrito();
        actualizarCarrito();
    @endif
    
    $(document).ready(function () {
        // Inicializar el selector Select2
        $('.mi-selector').select2({ width: 'resolve' });

        // Agregar evento clic al enlace "Agregar producto"
        $('#agregarProducto').click(function (e) {
            e.preventDefault(); // Evitar la acción predeterminada del enlace
            
            // Realizar la validación de campos
            var producto_id = $('#producto_id').val();
            var proveedor_id = $('#proveedor_id').val();
            var cantidad = $('#cantidad').val();

            var errors = {};

            
            if (!producto_id) {
                errors.producto_id = 'Debe seleccionar un producto';
            }

            if (!proveedor_id) {
                errors.proveedor_id = 'Debe seleccionar un proveedor';
            }

            if (!/^[1-9]\d*$/.test(cantidad)) {
                errors.cantidad = 'La cantidad debe ser un número entero mayor que cero';
            }


            // Mostrar mensajes de error
            $('.error-message').empty();
            for (var field in errors) {
                var errorMessage = '<p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">' + errors[field] + '</p>';
                $('.error-' + field).html(errorMessage);
            }

            /// Si no hay errores, continuar con la acción 
            if (Object.keys(errors).length === 0) {
                const productoExistente = carrito.find(producto => producto.producto_id === producto_id);

            if (productoExistente) {
                productoExistente.proveedor_id=$('#proveedor_id').val();
                productoExistente.precio_compra=$('#precio_compra').val();
                productoExistente.cantidad = parseInt(productoExistente.cantidad) + parseInt(cantidad);
                productoExistente.total = (parseFloat(productoExistente.precio_compra) * productoExistente.cantidad).toFixed(2);
                productoExistente.impuestos = (productoExistente.total * 0.16).toFixed(2);
                productoExistente.subtotal = (parseFloat(productoExistente.total) - parseFloat(productoExistente.impuestos)).toFixed(2);
                // Actualizar la fila en la tabla
                const filaTabla = $(`#${producto_id}`);
                filaTabla.find(`#cantidad-${producto_id}`).val(productoExistente.cantidad);
                filaTabla.find('#subtotal-column').text(`$${productoExistente.subtotal}`);
                filaTabla.find('#impuestos-column').text(`$${productoExistente.impuestos}`);
                filaTabla.find('#total-column').text(`$${productoExistente.total}`);
                filaTabla.find('#precio_compra-column').text(`$${productoExistente.precio_compra}`);

            } else {
                // Agregar los detalles del producto a la tabla
                var productoSeleccionado = $('#producto_id option:selected');
                var imagen = productoSeleccionado.data('imagen');
                var nombre = productoSeleccionado.data('nombre');
                var precioCompra = $('#precio_compra').val();
                var total = (parseFloat(precioCompra) * parseInt(cantidad)).toFixed(2);
                var impuestos = (total * 0.16).toFixed(2);
                var subtotal = (parseFloat(total) - parseFloat(impuestos)).toFixed(2);
                
                carrito.push({
                    producto_id: producto_id,
                    proveedor_id: proveedor_id,
                    nombre: nombre,
                    imagen: imagen,
                    precio_compra: precioCompra,
                    cantidad: cantidad,
                    total: (precioCompra * cantidad).toFixed(2),
                    subtotal: ((precioCompra * cantidad)-((precioCompra * cantidad) * 0.16)).toFixed(2),
                    impuestos: ((precioCompra * cantidad) * 0.16).toFixed(2)
                    
                });
                console.log(carrito);
                document.getElementById('carrito_input').value = JSON.stringify(carrito);

                var productoHtml = `
                    <tr id="${producto_id}">
                        <td class="text-center">${nombre}</td>
                        <td class="text-center"><img style="width: 45px;height: 45px; border-radius:15px" src="{{asset('uploads/${imagen}')}}" alt="Imagen del producto" width="50"></td>
                        <td class="text-center" id="precio_compra-column">$${precioCompra}</td>
                        <td class="text-center"><button class="btn btn-sm btn-primary mr-2" onclick="disminuirCantidad(${producto_id})">-</button>
                                <input id="cantidad-${producto_id}" type="number" style="outline:none; width: 27px;border:1px solid gray; border-radius: 8px; color:gray" class="text-center mr-2" value="${cantidad}"  oninput="validarCantidadInput(${producto_id}, this)"/>
                                <button class="btn btn-sm btn-primary" onclick="agregarCantidad(${producto_id})">+</button>
                                </td>
                        <td class="text-center" id="subtotal-column">$${subtotal}</td>
                        <td class="text-center" id="impuestos-column">$${impuestos}</td>
                        <td class="text-center" id="total-column">$${total}</td>
                        <td class="text-center">
                            <a href="#" class="text-danger" onclick="eliminarDelCarrito(${producto_id}); return false;">Eliminar</a>
                        </td>
                    </tr>`;

                $('#example tbody').append(productoHtml);
                
            }
                actualizarCarrito();
                // Limpiar los campos
                $('#producto_id').val('').trigger('change');
                $('#cantidad').val('');
                $('#precio_compra').val('');
            }
        
        });
    });

    new DataTable('#example', {
        order: [[3, 'desc']],
        "lengthMenu":[[5,10,50,-1],[5,10,50,"All"]],
        language: {
            emptyTable: "Aún no hay productos en la compra."
        }
    });
</script>

@endsection