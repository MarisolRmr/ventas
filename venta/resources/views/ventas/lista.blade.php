
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

</style>
@endsection

@section('navegacion')
Ventas
@endsection

@section('contenido')
<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0 mb-2">
            <div class="text-right">
                <a href="{{route('ventas.create')}}" class="h-2 flex gap-2 btn btn-primary my-4 p-2 text-white hover:text-white">
                    <svg style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-2 h-2">
                        <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                    </svg>
                    Agregar Venta
                </a>
            </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
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
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7 ">Referencia</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Fecha</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Pago</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Total</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Cliente</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Creado por</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($ventas as $venta)
                        <tr class="text-center">
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $venta->id }}</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $venta->referencia }}</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $venta->fecha }}</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $venta->pagocon }}</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $venta->total }}</p>
                            </td>
                            <td>
                                <a href="#" ><p class="text-xs font-weight-bold mb-0">{{ $venta->usuario->username }}</p></a>
                            </td> 
                            <td>
                                <a href="#" ><p class="text-xs font-weight-bold mb-0">{{ $venta->cliente->nombre }}</p></a>
                            </td> 
                            

                            <td class=" px-3 py-2 exclude-column">
                            
                                <a href="{{ route('ventas.detalles', $venta->id) }}" style="background-color: #a3a3a3; color: white;border-radius: 50px !important; border:none !important" class="inline-block px-2 py-2 rounded-lg font-bold text-white bg-gray-600 hover:bg-gray-700 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                    <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
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