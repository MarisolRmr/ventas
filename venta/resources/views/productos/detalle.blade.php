
@extends('layouts.app')

@section('estilos')

<style>
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

.p-2 {
    padding: 0.5rem;
}

.rounded-lg {
    border-radius: 0.5rem;
}

.mb-6 {
    margin-bottom: 1.5rem;
}

.text-black {
    color: #000000;
}

.text-center {
    text-align: center;
}
.inline-block {
    display: inline-block;
}

.px-2 {
    padding-left: 0.5rem;
    padding-right: 0.5rem;
}

.py-2 {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}


.font-bold {
    font-weight: bold;
}

.text-white {
    color: #ffffff;
}

.bg-red-600 {
    background-color: #dc2626;
}
.bg-blue-600 {
    background-color: #2563eb;
}

.hover\:bg-red-700:hover {
    background-color: #b91c1c;
}

.hover\:bg-blue-700:hover {
    background-color: #1d4ed8;
}

.transition-colors {
    transition-property: color;
    transition-duration: 0.3s;
}

.svg {
    display: inline-block;
    vertical-align: middle;
}

.w-5 {
    width: 1.25rem;
}

.h-5 {
    height: 1.25rem;
}
.mb-2{
    margin-bottom: 100px;
}
</style>
@endsection

@section('navegacion')
Detalles de Producto
@endsection

@section('contenido')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 mb-4 ">
                    <div class="row justify-content-between">
                        <div class="text-left mb-2 col-md-6">
                            Producto: {{$productos->nombre}}
                        </div>

                        <div style="padding-bottom: 10px;padding-right: 15px">
                            <button onclick="exportToPDF('detalle_producto')" style="background-color: #e34444" class="btn mr-2 inline-block px-2 py-1 rounded-lg font-bold text-sm text-white bg-red-600 hover:bg-red-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M0 64C0 28.7 28.7 0 64 0H224V128c0 17.7 14.3 32 32 32H384V304H176c-35.3 0-64 28.7-64 64V512H64c-35.3 0-64-28.7-64-64V64zm384 64H256V0L384 128zM176 352h32c30.9 0 56 25.1 56 56s-25.1 56-56 56H192v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V448 368c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24H192v48h16zm96-80h32c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H304c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H320v96h16zm80-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V432 368z"/></svg>    
                            </button>
            
                            <button onclick="exportToExcel('detalle_producto')" style="background-color: #3d8d3d" class="btn inline-block px-2 py-1 rounded-lg font-bold text-sm text-white bg-green-600 hover:bg-green-700 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM155.7 250.2L192 302.1l36.3-51.9c7.6-10.9 22.6-13.5 33.4-5.9s13.5 22.6 5.9 33.4L221.3 344l46.4 66.2c7.6 10.9 5 25.8-5.9 33.4s-25.8 5-33.4-5.9L192 385.8l-36.3 51.9c-7.6 10.9-22.6 13.5-33.4 5.9s-13.5-22.6-5.9-33.4L162.7 344l-46.4-66.2c-7.6-10.9-5-25.8 5.9-33.4s25.8-5 33.4 5.9z"/></svg>    
                            </button>
                        </div>

                        
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <div class="d-flex justify-content-center" style="padding-bottom: 30px;">
                        <div class="mx-2 text-center d-flex justify-content-center align-items-center">
                            <img src="{{ asset('img/codigo-de-barras.png') }}" alt="Imagen del producto" class="img-fluid mx-auto" style="max-height: 100px;">
                            
                        </div>  
                    </div>
                    

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="example" class="table align-items-center mb-0 hover">
                                <thead>
                                  <tr>
                                    <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7 ">Imagen</th>
                                    <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7 ">Nombre</th>
                                    <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Precio de Compra</th>
                                    <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Precio de Venta</th>
                                    <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Unidades</th>
                                    <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Categoria</th>
                                    <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Subcategoria</th>
                                    <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Marca</th>
                                    <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Creado por</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  
                                      <tr class="text-center">
                                          <td>
                                              <p class="text-xs font-weight-bold mb-0">{{ $productos->id }}</p>
                                          </td>
                                          <td>
                                            <img src="{{ asset('uploads/' . $productos->imagen) }}" alt="Imagen del producto" style="height: 80px; border-radius:17px">
                                        </td>
                                          
                                          <td>
                                              <p class="text-xs font-weight-bold mb-0">{{ $productos->nombre }}</p>
                                          </td>
                                          <td>
                                              <p class="text-xs font-weight-bold mb-0">${{ $productos->precio_compra }}</p>
                                          </td>
                                          <td>
                                              <p class="text-xs font-weight-bold mb-0">${{ $productos->precio_venta }}</p>
                                          </td>
                                          <td>
                                              <p class="text-xs font-weight-bold mb-0">{{ $productos->unidades }}</p>
                                          </td>
                                          <td>
                                              <p class="text-xs font-weight-bold mb-0">{{  $categorias[$productos->categoria_id] }}</p>
                                          </td>
                                          <td>
                                          @if(!$subcategorias->isEmpty() && isset($subcategorias[$productos->subcategoria_id]))
                                              <p class="text-xs font-weight-bold mb-0">{{ $subcategorias[$productos->subcategoria_id] }}</p>
                                          @else
                                              <p class="text-xs font-weight-bold mb-0">Sin subcategoría</p>
                                          @endif
                                          </td>
              
                                          <td>
                                              <p class="text-xs font-weight-bold mb-0">{{  $marcas[$productos->marca_id] }}</p>
                                          </td>
                                          <td>
                                              <a href="#" ><p class="text-xs font-weight-bold mb-0">{{ $productos->usuario->username }}</p></a>
                                          </td>
              
                                          
                                      </tr>
                                  
                                  
                                </tbody>
                              </table>

                        </div>
                    </div>

                    

                </div>
                
                

            </div>
        </div>
      </div>
    </div>
</div>


@endsection

@section('js')

<script>
    new DataTable('#example', {
        order: [[3, 'desc']],
        "lengthMenu":[[5,10,50,-1],[5,10,50,"All"]],
        language: {
            emptyTable: "No hay detalles que mostrar."
        }
    });

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.js" integrity="sha512-sk0cNQsixYVuaLJRG0a/KRJo9KBkwTDqr+/V94YrifZ6qi8+OO3iJEoHi0LvcTVv1HaBbbIvpx+MCjOuLVnwKg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script src="{{ asset('exportarPdfExcel.js') }}"></script>
@endsection