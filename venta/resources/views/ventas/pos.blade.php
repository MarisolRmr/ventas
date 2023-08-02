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
</style>
@endsection

@section('contenido')
<div class="card overflow-auto" style="background-color: #fafaf9; overflow-x: auto;">
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
        @foreach($productos as $producto)
        <div class="col p-0">
        <a href="#" style="text-decoration: none; color: black">
            <div class="card m-1 h-100 d-flex flex-column justify-content-between" > 
                <img src="{{ asset('uploads/' . $producto->imagen) }}" alt="Imagen de producto" class="card-img-top h-200">
                <div class="card-body " style="min-height: 150px">
                    <div class="d-flex justify-content-between">
                        <h2 class="card-title mb-2 text-bold">{{$producto->nombre}}</h2>
                        <h2 class="card-title mb-2 text-orange">${{$producto->precio_venta}}</h2>
                    </div>
                    <p class="card-text mb-2">{{$producto->marca->nombre}}</p>
                    <small class="card-text">Unidades disponibles: {{$producto->unidades}}</small>
                </div>
                <div style="max-height: 100px; padding: 1.5rem; display: flex; justify-content: center; align-items: center;">
                    <button type="button" class="h-2 flex gap-2 btn btn-primary my-4 p-2 text-white hover:text-white" onclick="agregarProductoAlCarrito({{ $producto}})">
                        <svg style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                        Agregar al carrito
                    </button>
                </div>
            </div>
        </a>
    </div>

        
        @endforeach
    </div>
  </div>
  

  <div class="col-3 bg-white rounded mt-4 p-0 m-0" style="box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15);">
    <h2 class="mt-3 ml-3">Carrito de compra</h2>
    <div class="p-3" id="carritoContainer">
        <!-- Aquí se mostrarán los productos agregados al carrito -->
    </div>
  </div>


  <a href="{{route('ventas.create')}}" class="p-3 m-0 col-12" style="text-align: center">Ver todos los productos</a>

</div>
@endsection

@section('js')
<script>
    // Variable para almacenar los productos del carrito
    let carrito = [];

    // Función para agregar un producto al carrito
    function agregarProductoAlCarrito(producto) {
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


    // Función para disminuir la cantidad de un producto en el carrito
    function disminuirCantidad(productId) {
        // Buscar el producto en el carrito por su ID
        const productoEnCarrito = carrito.find(item => item.id === productId);

        if (productoEnCarrito) {
            // Si el producto está en el carrito y su cantidad es mayor a 1, disminuir la cantidad en 1
            if (productoEnCarrito.cantidad > 1) {
                productoEnCarrito.cantidad--;
            } else {
                // Si la cantidad es igual a 1, eliminar el producto del carrito
                carrito = carrito.filter(item => item.id !== productId);
            }
        }

        // Actualizar el contenido del carrito
        actualizarCarrito();
    }



    // Función para calcular el total del carrito
    function calcularTotalCarrito() {
        return carrito.reduce((total, producto) => total + producto.precio_venta * producto.cantidad, 0);
    }



    // Función para eliminar un producto del carrito
    function eliminarDelCarrito(productId) {
        // Filtrar los productos y mantener aquellos que no tengan el ID del producto a eliminar
        carrito = carrito.filter(producto => producto.id !== productId);

        // Actualizar el contenido del carrito
        actualizarCarrito();
    }

    function actualizarCantidadEnCarrito(productId, cantidad) {
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


    // Función para actualizar el contenido del carrito en el DOM
    function actualizarCarrito() {
        // Obtener el contenedor del carrito
        const carritoContainer = document.getElementById('carritoContainer');

        // Limpiar el contenido del carrito
        carritoContainer.innerHTML = '';

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
                            <h5 class="card-title">${producto.nombre}</h5>
                            <p class="card-text mb-0">Precio: $${producto.precio_venta}</p>
                            <div class="d-flex align-items-center mt-3">
                                <button class="btn btn-sm btn-primary mr-2" onclick="disminuirCantidad(${producto.id})">-</button>
                                <span class="mr-2">${producto.cantidad}</span>
                                <button class="btn btn-sm btn-primary" onclick="actualizarCantidadEnCarrito(${producto.id})">+</button>
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
        const totalCarrito = calcularTotalCarrito();
        carritoContainer.innerHTML += `<p>Total: $${totalCarrito}</p>`;
    }

    
    // Función para remover las clases bg-primary y text-white de todos los enlaces
    function removeActiveClassesC() {
        const links = document.querySelectorAll('.categoria-link');
        links.forEach(link => {
            link.querySelector('.card').classList.remove('bg-primary');
            link.querySelector('.card-title').classList.remove('text-white');
        });
    }
    function removeActiveClassesS() {
        const links = document.querySelectorAll('.subcategoria-link');
        links.forEach(link => {
            link.querySelector('.card').classList.remove('bg-primary');
            link.querySelector('.card-title').classList.remove('text-white');
        });
    }

    // Script para manejar el clic en las categorías y subcategorías
    // Obtenemos el contenedor de todas las categorías
    const categoriasContainer = document.getElementById('categoriasContainer');

    // Obtenemos el contenedor de todas las subcategorías
    const subcategoriasContainer = document.getElementById('subcategoriasContainer');

    // Event listener para el contenedor de categorías y subcategorías
    categoriasContainer.addEventListener('click', function (event) {
        const clickedElement = event.target;
        // Verificamos que el elemento clickeado sea un enlace de categoría o subcategoría
        const categoriaLink = clickedElement.closest('.categoria-link');
        const subcategoriaLink = clickedElement.closest('.subcategoria-link');

        if (categoriaLink) {
            event.preventDefault();

            // Removemos las clases bg-primary y text-white de cualquier otro enlace de categoría o subcategoría
            removeActiveClassesC();

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
                    productosHtml  += `
                    <div class="col p-0">
                        <a href="#" style="text-decoration: none; color: black">
                        <div class="card m-1" >
                        <img src="{{ asset('uploads/${producto.imagen}') }}" alt="Imagen de producto" class="card-img-top" >
                            <div class="card-body m-h-200">
                                <div class="d-flex justify-content-between">
                                <h2 class="card-title mb-2 text-bold " >${producto.nombre}</h2>
                                <h2 class="card-title mb-2 text-orange">$${producto.precio_venta}</h2>
                                </div>
                                <p class="card-text mb-2">${producto.marca.nombre}</p>
                                
                                <small class="card-text">Unidades disponibles: ${producto.unidades}</small>
                            </div>
                        </div>
                        </a>
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
            removeActiveClassesS();

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
            removeActiveClassesS();

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
                        productosHtml += `
                        <div class="col p-0">
                        <a href="#" style="text-decoration: none; color: black">
                        <div class="card m-1" >
                        <img src="{{ asset('uploads/${producto.imagen}') }}" alt="Imagen de producto" class="card-img-top" >
                            <div class="card-body m-h-200">
                                <div class="d-flex justify-content-between">
                                <h2 class="card-title mb-2 text-bold " >${producto.nombre}</h2>
                                <h2 class="card-title mb-2 text-orange">$${producto.precio_venta}</h2>
                                </div>
                                <p class="card-text mb-2">${producto.marca.nombre}</p>
                                
                                <small class="card-text">Unidades disponibles: ${producto.unidades}</small>
                            </div>
                        </div>
                        </a>
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
