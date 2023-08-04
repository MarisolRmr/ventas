
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
Detalles de Venta
@endsection

@section('contenido')
<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0 mb-4 ">
                <div class="row">
                    <div class="text-left mb-2 col-md-6">
                        Detalle de Venta: 123_ioioi
                    </div>
                    <div class="text-right mb-2 col-md-6">
                        Fecha: 2023-06-12
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
            <div class="text-center mb-5 px-4 ">
                <div class="row">
                    <div class="col-md-4">
                        <h3 class="text-primary">Datos del cliente</h3>
                        Nombre: Juan Perez<br>
                        Dirección: Colonia Tamaulipas, Victoria, Tamaulipas, Mexíco.<br>
                        Email: juanito@gmail.com<br>
                    </div>
                    <div class="col-md-4">
                        <h3 class="text-primary">Datos del Vendedor</h3>
                        Nombre: Juan Perez<br>
                        Dirección: Colonia Tamaulipas, Victoria, Tamaulipas, Mexíco.<br>
                        Email: juanito@gmail.com<br>
                    </div>
                    <div class="col-md-4">
                        <h3 class="text-primary">Datos del Recibo</h3>
                        Fecha: 2023-06-12<br>
                        Estatus: Pagado
                    </div>
                </div>
                </div>

              <div class="table-responsive p-0">
                @if(session('agregada'))
                    <div class="bg-green-200 p-2 rounded-lg mb-6 text-black text-center ">
                        {{ session('agregada') }}
                    </div>
                @endif
                @if(session('success'))
                    <div class="bg-green-200 p-2 rounded-lg mb-6 text-black text-center ">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('actualizada'))
                    <div class="bg-green-200 p-2 rounded-lg mb-6 text-black text-center ">
                        {{ session('actualizada') }}
                    </div>
                @endif
                <table id="example" class="table align-items-center mb-0 hover">
                  <thead>
                    <tr>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">ID</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7 ">Producto</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Cantidad</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Precio</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Descuento</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Impuestos</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                        <tr class="text-center">
                            <td>
                                <p class="text-xs font-weight-bold mb-0">1</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">Fresas</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">2</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">$50.00</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">$0.00</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">$5.00</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">$55.00</p>
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


@endsection

@section('js')

<script>
    new DataTable('#example', {
        order: [[3, 'desc']],
        "lengthMenu":[[5,10,50,-1],[5,10,50,"All"]],
        language: {
            emptyTable: "Aún no hay ventas que mostrar."
        }
    });

</script>
@endsection