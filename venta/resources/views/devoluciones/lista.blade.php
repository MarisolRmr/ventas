
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

@section('contenido')
<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0 mb-2">
            <div class="text-right">
                <a href="{{route('subcategorias.create')}}" class="h-2 flex gap-2 btn btn-primary my-4 p-2 text-white hover:text-white">
                    <svg style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-2 h-2">
                        <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                    </svg>
                    Agregar Devolución
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
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7 ">Producto</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Fecha</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Cliente</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Total</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Pagado</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Adeudo</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7">Creado por</th>
                      <th class="text-center text-uppercase  text-xxs font-weight-bolder opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                        <tr class="text-center">
                            <td>
                                <p class="text-xs font-weight-bold mb-0">1</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">Uvas</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">2023-06-12</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">Liam Payne</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">Completo</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">$500.00</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">$500.00</p>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">$0.00</p>
                            </td>
                            <td>
                                <a href="#" ><p class="text-xs font-weight-bold mb-0">lore</p></a>
                            </td>

                            <td class=" px-3 py-2 exclude-column">
                                <form action="#" method="POST">
                                <div style="display: flex; justify-content:center">
                                @method('delete')
                                @csrf
                                <button type="submit" style="border-radius: 50px !important; border:none !important ; margin-right: 10px;" class="inline-block px-2 py-2 rounded-lg font-bold text-white bg-red-600 hover:bg-red-700 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                </form>
                                <a href="#" style="border-radius: 50px !important; border:none !important" class="inline-block px-2 py-2 rounded-lg font-bold text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" />
                                </svg>
                                </a>
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