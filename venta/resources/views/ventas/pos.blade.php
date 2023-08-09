@extends('layouts.app')

@section('estilos')
<style>
    .rounded-xl {
        border-radius: 15px !important;
    }
    .m-h-200{
        min-height:230px !important;
        height:230px !important;
    }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
    }

    input[type=number] { -moz-appearance:textfield; }

    /* Color de fondo de la barra de desplazamiento */
    .overflow::-webkit-scrollbar {
      background-color: rgba(222, 226, 243, 0.82); 
      width: 8px;
    }

    /* Estilo de la barra de desplazamiento */
    .overflow::-webkit-scrollbar-thumb {
      background-color: #97A3E7 ;
      border-radius: 10px;
    }
    .select2-container .select2-selection--single {
        height: 50px !important;
    }
</style>
@endsection

@section('contenido')
<div class="card overflow-auto overflow" style="background-color: #fafaf9; overflow-x: auto;">
    <h2 class="ml-4 mt-1">Categorías</h2>
    <div class="mb-0 pb-0 pt-1 card-body d-flex flex-nowrap" id="categoriasContainer">
        @foreach($categorias as $categoria)
        <a href="#" class="categoria-link" data-id="{{ $categoria->id }}">
            <div class="card rounded-xl  mr-3 p-2" style="min-width: 100px;">
                <img class="card-img-top rounded mb-2 mt-1" src="{{ asset('uploads/' . $categoria->imagen) }}" alt="Imagen de la subcategoria" style="height: 70px">
                <h5 class="card-title text-center m-0" style="font-size: 1rem">{{$categoria->nombre}}</h5>
            </div>
        </a>
        @endforeach
    </div>
     <!-- esto mostrará las subcategorias -->
     <div class="mt-0 pt-0 card-body d-flex flex-column">
     <h3 class="ml-4 mt-1" id="subcategoriasTitle" style="display: none;">Subcategorías</h3>
        
        <div class="row ml-3" id="subcategoriasContainer">
            <!-- Aquí se mostrarán las cards de las subcategorías -->
        </div>
    </div>
</div>
<div class="row m-0">
 <div class="col-9 ">
    <div class="row row-cols-2 row-cols-md-3 p-4 m-0"  id="productosFiltradosContainer">
        
    </div>
  </div>
  

  <div class="col-3 bg-white rounded mt-2 p-0 m-0" style="box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15);">
    <div class="p-3">
        <select class="form-control mi-selector" id="cliente_select">
            <option value="" >Seleccione un cliente</option>
            @foreach ($clientes as $cliente)
            @php
                // Combina el nombre y el código en una sola cadena separada por un carácter especial (por ejemplo, '|').
                $optionValue = $cliente->nombre . ' ' . $cliente->codigo;
            @endphp
                <option value="{{ $cliente->id }}"  data-imagen="{{ asset('uploads/' . $cliente->imagen) }}">{{ $optionValue }} </option>
            @endforeach
        </select>

    </div>
    <a href="#" onclick="limpiarCarrito()"><p class="mr-3 pt-3 mb-2" style="text-align:end">Eliminar artículos</p></a> 
    <h2 class="mt-2 ml-3">Lista de compra</h2>
    <p class="mt-2 ml-3 mb-0">Total de artículos: <span class="ml-2" id="total">0</span></p> 
    <div class="p-3 overflow text-center" style="max-height: 300px;height: 300px; overflow-y:auto" id="carritoContainer">
        Aún no ha agregado productos
    </div>
    <div>
    <div class="p-3 " style="height: 150px; overflow-y:auto; text-align: right; box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15);" id="totalcarrito">
        <p class="mb-2">Subtotal: $0.00</p>
        <p class="mb-2">IVA 16%: $0.00</p>
        <p>Total: $0.00</p>
    </div>
    <div class="d-flex align-items-center mt-0 pb-0 pl-4 mb-2 pt-2" >
        <label for="cambio" class="mr-2">Pago con:</label>
        <input style="outline:none; width: 70px; border:1px solid #b0b1b9; border-radius: 10px; color:black; padding:5px; padding-left: 10px" type="number" id="pagocon" name="pagocon" min="0" step="any">
        
    </div>
    <div class="d-flex align-items-center mt-0 pb-0 pl-4  " >
        Cambio: <span class="ml-2" id="cambio"></span>
    </div>
    <p id="no-cambio" class="ml-4 text-danger" style="display: none;">Necesita más dinero para completar el pago.</p>
    </div>  

  </div>

  <a href="#" onclick="cargarTodosLosProductos()" class="p-3 m-0 col-12" style="text-align: center; cursor: pointer">Ver todos los productos</a>

</div>
@endsection

@section('js')
<script>
    //SELECCIONAR CLIENTE
    $(document).ready(function () {
        // Inicializar el selector Select2 y usar una función de plantilla para personalizar el formato de las opciones.
        $('.mi-selector').select2({
            templateResult: agregarImagenOpcion, // Usamos la función agregarImagenOpcion para personalizar el contenido de las opciones.
        });
    });

    // Función para formatear las opciones del Select2 con imagen y nombre del cliente.
    function agregarImagenOpcion(option) {
        if (!option.id) {
            return option.text; // Opción para el elemento de búsqueda sin resultados
        }

        var $option = $(
            '<span><img src="' + $(option.element).data('imagen') + '" alt="Imagen del cliente" style="height: 40px; border-radius: 50%; margin-right: 4px" />' +
            option.text + '</span>'
        );
        return $option;
    }

    //CARRITO
    // Variable para almacenar los productos del carrito
    let carrito = [];

    // Llamamos a la función para cargar y mostrar todos los productos
    cargarTodosLosProductos();

    // Función para cargar y mostrar todos los productos
    function cargarTodosLosProductos() {
        fetch('/ventas/productosTodos')
            .then(response => response.json())
            .then(productos => {
                let productosHtml = '';
                
                // Iterar sobre cada producto recibido y generar su HTML
                productos.forEach(producto => {
                    const productoParaHTML = {
                        'id':  producto.id,
                        'nombre':producto.nombre,
                        'precio_venta':producto.precio_venta,
                        'unidades':producto.unidades,
                        'marca':producto.marca.nombre, 
                        'imagen':producto.imagen
                    }
                         
                    productosHtml += `
                    <div class="col p-0">
                        <div class="card m-1" >
                            <img src="{{ asset('uploads/${producto.imagen}') }}" alt="Imagen de producto" class="card-img-top" >
                            <div class="card-body m-h-200">
                                <div class="d-flex justify-content-between">
                                <h2 class="card-title mb-2 text-bold " >${producto.nombre}</h2>
                                <h2 class="card-title mb-2 text-orange">$${parseFloat(producto.precio_venta).toFixed(2)}</h2>
                                </div>
                                <p class="card-text mb-2">${producto.marca.nombre}</p>
                                
                                <small class="card-text">Unidades disponibles: ${producto.unidades}</small>
                            </div>
                            <div style="max-height: 100px; padding: 1.5rem; display: flex; justify-content: center; align-items: center;">
                                <button type="button" class="h-2 flex gap-2 btn btn-primary my-4 p-2 text-white hover:text-white" onclick="agregarProductoAlCarrito('${encodeURIComponent(JSON.stringify(productoParaHTML))}')">
                                    <svg style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                    </svg>
                                    Agregar al carrito
                                </button>
                            </div>
                        </div>
                    </div>
                    `;
                });

                // Agregar el contenido generado al contenedor en el DOM
                const productosContainer = document.getElementById('productosFiltradosContainer');
                productosContainer.innerHTML = productosHtml;
            })
            .catch(error => console.error('Error al obtener productos:', error));
    }

    // Función para agregar un producto al carrito
    function agregarProductoAlCarrito(productoCodificado) {
        const producto = JSON.parse(decodeURIComponent(productoCodificado));

        // Verificar si el producto ya está en el carrito
        const productoEnCarrito = carrito.find(item => item.id === producto.id);
   
        
        if (!productoEnCarrito) {
            // Si el producto no está en el carrito, agregarlo con una cantidad inicial de 1
            carrito.push({ ...producto, cantidad: 1 });
        } else {
            // Si el producto ya está en el carrito, aumentar su cantidad en 1
            if (productoEnCarrito.cantidad<productoEnCarrito.unidades){
                productoEnCarrito.cantidad++;
            }
        }

        // Actualizar el contenido del carrito
        actualizarCarrito();
    }

    function limpiarCarrito() {
        // Obtener el contenedor del carrito
        const carritoContainer = document.getElementById('carritoContainer');

        // Limpia el carrito, eliminando todos los productos
        carrito = [];
        actualizarCarrito();

        // Limpiar el contenido del carrito
        carritoContainer.innerHTML = 'Aún no ha agregado productos';
    }

    // Función para actualizar la cantidad de un producto en el carrito y hacer la validación
    function validarCantidadInput(productId, inputCantidad) {
        const productoEnCarrito = carrito.find(item => item.id === productId);

        if (productoEnCarrito) {
            const nuevaCantidad = parseInt(inputCantidad.value);
            const unidadesDisponibles = productoEnCarrito.unidades;

            const divContenedor = inputCantidad.closest('.card-body');
            let mensajeError = divContenedor.querySelector('.mensaje-error');

            if (nuevaCantidad > unidadesDisponibles) {
                inputCantidad.value = unidadesDisponibles; // Restaurar la cantidad a las unidades disponibles
                if (!mensajeError) {
                    mensajeError = document.createElement('p');
                    mensajeError.innerText = 'No hay unidades disponibles para esa cantidad';
                    mensajeError.style.color = 'red';
                    mensajeError.classList.add('mensaje-error');
                    mensajeError.classList.add('mt-1');
                    divContenedor.appendChild(mensajeError); // Agregar mensaje de error debajo del div contenedor del input
                }
            } else if (nuevaCantidad>0) {
                productoEnCarrito.cantidad = nuevaCantidad;
                if (mensajeError) {
                    mensajeError.remove(); // Eliminar mensaje de error si existe
                }
                actualizarCarrito(); // Actualizar el carrito después de cambiar la cantidad
            }else{
                inputCantidad.value = 1; 
            }
        }
    }

    // Función para actualizar el contenido del carrito en el DOM
    function actualizarCarrito() {
        // Obtener el contenedor del carrito
        const carritoContainer = document.getElementById('carritoContainer');
        const totalArticulos = calcularTotalArticulos(); // Nueva función para calcular el total de artículos

        // Limpiar el contenido del carrito
        carritoContainer.innerHTML = '';
        
        // Mostrar el total de artículos en el carrito
        const totalArticulosSpan = document.getElementById('total');
        totalArticulosSpan.textContent = totalArticulos;
        if (totalArticulos<1){
            carritoContainer.innerHTML = 'Aún no ha agregado productos';
        }
        

        // Iterar sobre los productos en el carrito y mostrarlos en el contenedor
        carrito.forEach(producto => {
            const productoHtml = `
            <div class="card mb-3 p-2">
                <div class="row g-0">
                    <div class="col-md-4 d-flex align-items-center">
                        <img style="height: 50px; border-radius: 10px;" src="{{ asset('uploads/') }}/${producto.imagen}" alt="Imagen de producto" class="img-fluid shadow">
                    </div>
                    <div class="col-md-8 p-0">
                        <div class="card-body p-2">
                            <h5 class="card-title mb-1" style="font-size:16px">${producto.nombre}</h5>
                            <div class="d-flex align-items-center mt-1">
                            <p class="card-text mb-0 mr-3" style="font-size: 15px">Pre. Unit. <br>$${parseFloat(producto.precio_venta).toFixed(2)}</p>
                            <p class="card-text mb-0" style="font-size: 15px">Total <br>$${(parseFloat(producto.precio_venta * producto.cantidad)).toFixed(2) }</p>
                            </div>
                            <div class="d-flex align-items-center mt-3">
                                <button class="btn btn-sm btn-primary mr-2" onclick="disminuirCantidad(${producto.id})">-</button>
                                <input type="number" style="outline:none; width: 27px;border:1px solid gray; border-radius: 8px; color:gray" class="text-center mr-2" value="${producto.cantidad}" class="mr-2" oninput="validarCantidadInput(${producto.id}, this)"/>
                                <button class="btn btn-sm btn-primary" onclick="agregarCantidad(${producto.id})">+</button>
                                <button class="btn btn-danger btn-sm ml-auto" onclick="eliminarDelCarrito(${producto.id})">
                                    <svg style="width: 15px; height: 15px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
            `;
            carritoContainer.innerHTML += productoHtml;
        });

        // Mostrar el total del carrito
        const totalContainer = document.getElementById('totalcarrito');
        totalContainer.innerHTML = '';
        const totalCarrito = calcularTotalCarrito();
        let iva=totalCarrito*0.16;
        totalContainer.innerHTML += `<p class="mb-2">Subtotal: $${totalCarrito.toFixed(2)}</p>
        <p class="mb-2">IVA 16%: $${iva.toFixed(2)}</p>
        <p>Total: $${(totalCarrito+iva).toFixed(2)}</p>`;
        actualizarCambio();
    }

    function calcularTotalArticulos() {
        let total = 0;
        carrito.forEach(producto => {
            total += producto.cantidad;
        });
        return total;
    }

    //Funcion para agregar cantidad de productos al carrito
    function agregarCantidad(productId, cantidad) {
        // Buscar el producto en el carrito por su ID
        const productoEnCarrito = carrito.find(item => item.id === productId);

        if (productoEnCarrito) {
            if (productoEnCarrito.cantidad<productoEnCarrito.unidades){
                productoEnCarrito.cantidad++;
            }
        }

        // Actualizar el contenido del carrito
        actualizarCarrito();
    }

    // Función para disminuir la cantidad de un producto en el carrito
    function disminuirCantidad(productId) {
        // Buscar el producto en el carrito por su ID
        const productoEnCarrito = carrito.find(item => item.id === productId);

        if (productoEnCarrito) {
            // Si el producto está en el carrito y su cantidad es mayor a 1, disminuir la cantidad en 1
            if (productoEnCarrito.cantidad > 1) {
                productoEnCarrito.cantidad--;
            } 
        }

        // Actualizar el contenido del carrito
        actualizarCarrito();
    }

    // Función para eliminar un producto del carrito
    function eliminarDelCarrito(productId) {
        // Filtrar los productos y mantener aquellos que no tengan el ID del producto a eliminar
        carrito = carrito.filter(producto => producto.id !== productId);

        // Actualizar el contenido del carrito
        actualizarCarrito();
    }

    // Función para calcular el total del carrito
    function calcularTotalCarrito() {
        return carrito.reduce((total, producto) => total + producto.precio_venta * producto.cantidad, 0);
    }
    
    const pagoInput = document.getElementById('pagocon');
    const cambioSpan = document.getElementById('cambio');

    function actualizarCambio() {
        const totalCarrito = calcularTotalCarrito();
        const pago = parseFloat(pagoInput.value);
        const mensaje = document.getElementById('no-cambio');


        if (isNaN(pago) || pago < 0) {
            // Si no es un número válido o es negativo, vaciar el campo de cambio
            cambioSpan.textContent = '';
            pagoInput.value='';
            console.log(pago);
        } else {
            const cambio = pago - totalCarrito;

            if (cambio < 0) {
                // Si el cambio es negativo, mostrar el mensaje y ocultar el cambio
                mensaje.style.display = 'block';
                cambioSpan.textContent = '';
            } else {
                // Si el cambio es positivo o cero, mostrar el cambio y ocultar el mensaje
                cambioSpan.textContent = `$${cambio.toFixed(2)}`;
                mensaje.style.display = 'none';
            }
        }
    }

    // Agregar evento al input de pago para actualizar el cambio
    pagoInput.addEventListener('input', actualizarCambio);


    //FILTRAR POR CATEGORIA/SUBCATEGORIA
    // Obtenemos el contenedor de todas las categorías
    const categoriasContainer = document.getElementById('categoriasContainer');

    // Obtenemos el contenedor de todas las subcategorías
    const subcategoriasContainer = document.getElementById('subcategoriasContainer');

    // Función para remover las clases bg-primary y text-white de todos los enlaces de categorias
    function quitarClaseActiveCategorias() {
        const links = document.querySelectorAll('.categoria-link');
        links.forEach(link => {
            link.querySelector('.card').classList.remove('bg-primary');
            link.querySelector('.card-title').classList.remove('text-white');
        });
    }
    // Función para remover las clases bg-primary y text-white de todos los enlaces de subcategorias
    function quitarClaseActiveSubcategorias() {
        const links = document.querySelectorAll('.subcategoria-link');
        links.forEach(link => {
            link.querySelector('.card').classList.remove('bg-primary');
            link.querySelector('.card-title').classList.remove('text-white');
        });
    }
 
    // Event listener para el contenedor de categorías 
    categoriasContainer.addEventListener('click', function (event) {
        const clickedElement = event.target;
        // Verificamos que el elemento clickeado sea un enlace de categoría o subcategoría
        const categoriaLink = clickedElement.closest('.categoria-link');
        const subcategoriaLink = clickedElement.closest('.subcategoria-link');

        if (categoriaLink) {
            event.preventDefault();

            // Removemos las clases bg-primary y text-white de cualquier otro enlace de categoría o subcategoría
            quitarClaseActiveCategorias();

            // Agregamos las clases bg-primary y text-white al enlace de categoría clickeado
            categoriaLink.querySelector('.card').classList.add('bg-primary');
            categoriaLink.querySelector('.card-title').classList.add('text-white');

            // Obtenemos el ID de la categoría del enlace clickeado
            const categoriaId = categoriaLink.getAttribute('data-id');

            // Limpiamos el contenedor de subcategorías antes de cargar nuevas subcategorías
            subcategoriasContainer.innerHTML = '';

            // Generamos la URL utilizando la función route de Laravel para obtener las subcategorías relacionadas
            const subcategoriasUrl = `/ventas/subcategorias/${categoriaId}`;

            // Realizamos una solicitud AJAX para obtener las subcategorías
            fetch(subcategoriasUrl)
                .then(response => response.json())
                .then(subcategorias => {
                    // Verificamos si hay subcategorías disponibles antes de mostrar el título "Subcategorías"
                    if (subcategorias.length > 0) {
                        subcategoriasTitle.style.display = 'block';
                    } else {
                        subcategoriasTitle.style.display = 'none';
                    }
                    // Iteramos sobre cada subcategoría recibida y las mostramos en el contenedor
                    subcategorias.forEach(subcategoria => {
                        subcategoriasContainer.innerHTML += `
                            <a href="#" class="subcategoria-link" data-id="${subcategoria.id}">
                                <div class="card rounded-xl mr-3 p-2" style="min-width: 70px;">
                                    <img class="card-img-top rounded mb-2 mt-1" src="{{ asset('uploads/') }}/${subcategoria.imagen}" alt="Imagen de la subcategoria" style="height: 40px">
                                    <h5 class="card-title text-center m-0" style="font-size: 0.8rem">${subcategoria.nombre}</h5>
                                </div>
                            </a>`;
                    });
                })
                .catch(error => console.error('Error al obtener subcategorias:', error));

            // Limpiamos el contenedor de productos antes de cargar nuevos productos filtrados
            const productosContainer = document.getElementById('productosFiltradosContainer');
            productosContainer.innerHTML = '';

            // Generamos la URL utilizando la función route de Laravel para obtener los productos filtrados
            const productosUrl = `/ventas/productosPorCategoria/${categoriaId}`;
            
            // Realizamos una solicitud AJAX para obtener los productos filtrados
            fetch(productosUrl)
            .then(response => response.json())
            .then(productos => {
                let productosHtml = '';

                // Iteramos sobre cada producto filtrado y los mostramos en el contenedor
                productos.forEach(producto => {
                    const productoParaHTML = {
                        'id':  producto.id,
                        'nombre':producto.nombre,
                        'precio_venta':producto.precio_venta ,
                        'unidades':producto.unidades,
                        'marca':producto.marca.nombre, 
                        'imagen':producto.imagen
                    }
                    productosHtml  += `
                    <div class="col p-0">
                        <div class="card m-1" >
                            <img src="{{ asset('uploads/${producto.imagen}') }}" alt="Imagen de producto" class="card-img-top" >
                            <div class="card-body m-h-200">
                                <div class="d-flex justify-content-between">
                                <h2 class="card-title mb-2 text-bold " >${producto.nombre}</h2>
                                <h2 class="card-title mb-2 text-orange">$${parseFloat(producto.precio_venta).toFixed(2)}</h2>
                                </div>
                                <p class="card-text mb-2">${producto.marca.nombre}</p>
                                
                                <small class="card-text">Unidades disponibles: ${producto.unidades}</small>
                            </div>
                            <div style="max-height: 100px; padding: 1.5rem; display: flex; justify-content: center; align-items: center;">
                                <button type="button" class="h-2 flex gap-2 btn btn-primary my-4 p-2 text-white hover:text-white" onclick="agregarProductoAlCarrito('${encodeURIComponent(JSON.stringify(productoParaHTML))}')">
                                    <svg style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                    </svg>
                                    Agregar al carrito
                                </button>
                            </div>
                        </div>
                    </div>`;
                });
                if (productos.length > 0) {
                        // Si hay productos, agregamos el contenido de productosHtml al contenedor productosContainer
                        productosContainer.innerHTML = productosHtml;
                    } else {
                        // Si no hay productos, mostramos el mensaje en el contenedor productosContainer
                        productosContainer.innerHTML = '<div class="col"></div><div class="col"><p class="p-0 m-0">No hay productos disponibles en esta categoría.</p></div>';
                    }
            })
            .catch(error => console.error('Error al obtener productos:', error));

        } else if (subcategoriaLink) {
            event.preventDefault();

            // Removemos las clases bg-primary y text-white de cualquier otro enlace de categoría o subcategoría
            quitarClaseActiveSubcategorias();

            // Agregamos las clases bg-primary y text-white al enlace de subcategoría clickeado
            subcategoriaLink.querySelector('.card').classList.add('bg-primary');
            subcategoriaLink.querySelector('.card-title').classList.add('text-white');
        }
    });

    // Event listener para el contenedor de subcategorías
    subcategoriasContainer.addEventListener('click', function (event) {
        const clickedElement = event.target;
        // Verificamos que el elemento clickeado sea un enlace de subcategoría
        const subcategoriaLink = clickedElement.closest('.subcategoria-link');

        if (subcategoriaLink) {
            event.preventDefault();

            // Removemos las clases bg-primary y text-white de cualquier otro enlace de categoría o subcategoría
            quitarClaseActiveSubcategorias();

            // Agregamos las clases bg-primary y text-white al enlace de subcategoría clickeado
            subcategoriaLink.querySelector('.card').classList.add('bg-primary');
            subcategoriaLink.querySelector('.card-title').classList.add('text-white');

            // Obtenemos el ID de la subcategoría del enlace clickeado
            const subcategoriaId = subcategoriaLink.getAttribute('data-id');

            // Limpiamos el contenedor de productos antes de cargar nuevos productos filtrados
            const productosContainer = document.getElementById('productosFiltradosContainer');
            productosContainer.innerHTML = '';

            // Generamos la URL utilizando la función route de Laravel para obtener los productos filtrados por subcategoría
            const productosPorSubcategoriaUrl = `/ventas/productosPorSubcategoria/${subcategoriaId}`;

            // Realizamos una solicitud AJAX para obtener los productos filtrados por subcategoría
            fetch(productosPorSubcategoriaUrl)
                .then(response => response.json())
                .then(productos => {
                    let productosHtml = '';

                    // Iteramos sobre cada producto filtrado y los mostramos en el contenedor
                    productos.forEach(producto => {
                        const productoParaHTML = {
                            'id':  producto.id,
                            'nombre':producto.nombre,
                            'precio_venta':producto.precio_venta,
                            'unidades':producto.unidades,
                            'marca':producto.marca.nombre, 
                            'imagen':producto.imagen
                        }
                        productosHtml += `
                        <div class="col p-0">
                        <div class="card m-1" >
                        <img src="{{ asset('uploads/${producto.imagen}') }}" alt="Imagen de producto" class="card-img-top" >
                            <div class="card-body m-h-200">
                                <div class="d-flex justify-content-between">
                                <h2 class="card-title mb-2 text-bold " >${producto.nombre}</h2>
                                <h2 class="card-title mb-2 text-orange">$${parseFloat(producto.precio_venta).toFixed(2)}</h2>
                                </div>
                                <p class="card-text mb-2">${producto.marca.nombre}</p>
                                
                                <small class="card-text">Unidades disponibles: ${producto.unidades}</small>
                            </div>
                            <div style="max-height: 100px; padding: 1.5rem; display: flex; justify-content: center; align-items: center;">
                                <button type="button" class="h-2 flex gap-2 btn btn-primary my-4 p-2 text-white hover:text-white" onclick="agregarProductoAlCarrito('${encodeURIComponent(JSON.stringify(productoParaHTML))}')">
                                    <svg style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                    </svg>
                                    Agregar al carrito
                                </button>
                            </div>
                        </div>
                    </div>`;
                    });
                    if (productos.length > 0) {
                        // Si hay productos, agregamos el contenido de productosHtml al contenedor productosContainer
                        productosContainer.innerHTML = productosHtml;
                    } else {
                        // Si no hay productos, mostramos el mensaje en el contenedor productosContainer
                        productosContainer.innerHTML = '<div class="col"></div><div class="col"><p class="p-0 m-0">No hay productos disponibles en esta subcategoría.</p></div>';
                    }
                })
                .catch(error => console.error('Error al obtener productos por subcategoría:', error));
        }
    });
</script>
@endsection