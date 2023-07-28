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
            <div class="card m-1 ">
            <img src="{{ asset('uploads/' . $producto->imagen) }}" alt="Imagen de producto" class="card-img-top h-200" >
            <div class="card-body m-h-200">
                <div class="d-flex justify-content-between">
                <h2 class="card-title mb-2 text-bold " >{{$producto->nombre}}</h2>
                <h2 class="card-title mb-2 text-orange">${{$producto->precio_venta}}</h2>
                </div>
                <p class="card-text mb-2">{{$producto->marca->nombre}}</p>
                <small class="card-text">Unidades disponibles: {{$producto->unidades}}</small>
            </div>
            </div></a>
        </div>
        @endforeach
    </div>
  </div>
  

  <div class="col-3 bg-white rounded mt-4 p-0 m-0" style="box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15);">

  </div>

  <a href="{{route('ventas.create')}}" class="p-3 m-0 col-12" style="text-align: center">Ver todos los productos</a>

</div>
@endsection

@section('js')
<script>
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
