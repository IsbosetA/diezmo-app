@extends('adminlte::page')

@section('title', 'Miembros')

@section('content_header')
    <h1>Miembros</h1>
@stop

@section('content')
    <div class="relative overflow-x-auto sm:rounded-lg p-4">
        <div class="!pb-4 flex justify-between">
            <div>
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <form action="{{ route('members') }}" method="get">
                        <input type="text" id="search" name="search"
                            class="block !pt-2 ps-10 !text-sm text-gray-900 !border !border-gray-300 !rounded-lg w-80 !bg-gray-50 focus:!ring-blue-500 focus:!border-blue-500"
                            placeholder="Buscar Miembro">
                    </form>
                </div>
            </div>
            <div>
                <a href="{{ route('members.create') }}"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <i class="fa fa-plus w-3.5 h-3.5 me-2" aria-hidden="true"></i>
                    Nuevo
                </a>
            </div>
        </div>

        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-300 uppercase bg-[#343A40]">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nombre Completo
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Correo
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Telefono
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Direccion
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($members->isEmpty())
                    <tr class="bg-white border-b">
                        <th scope="row" colspan="5" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-center">
                            Sin Registro o No Encontrado
                        </th>
                    </tr>
                @else
                    @foreach ($members as $member)
                        <tr class="bg-white border-b">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $member->firstname }} {{ $member->lastname }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $member->email }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $member->phone }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $member->address }}
                            </td>
                            <td class="px-6 py-4 flex flex-col">
                                <a href="{{ route('members.show', $member->id) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Editar</a>
                                <div x-data="{ modalOpen: false }" @keydown.escape.window="modalOpen = false"
                                    class="relative z-50 w-auto h-auto">
                                    <button @click="modalOpen=true"
                                        class="font-medium text-red-600 dark:text-red-500 hover:underline">Eliminar</button>
                                    <template x-teleport="body">
                                        <div x-show="modalOpen"
                                            class="fixed top-0 left-0 z-[1040] flex items-center justify-center w-screen h-screen"
                                            x-cloak>
                                            <div x-show="modalOpen" x-transition:enter="ease-out duration-300"
                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                x-transition:leave="ease-in duration-300"
                                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                                @click="modalOpen=false"
                                                class="absolute inset-0 w-full h-full bg-black bg-opacity-40"></div>
                                            <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen"
                                                x-transition:enter="ease-out duration-300"
                                                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                x-transition:leave="ease-in duration-200"
                                                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                class="relative w-full py-6 bg-white px-7 sm:max-w-lg sm:rounded-lg">
                                                <div class="flex items-center justify-between pb-2">
                                                    <h3 class="text-lg font-semibold">Eliminar Miembro</h3>
                                                    <button @click="modalOpen=false"
                                                        class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 !mt-5 !mr-5 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50">
                                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="relative w-auto pb-8">
                                                    <p>¿Estas seguro de eliminar este miembro? Esta accion no se puede
                                                        deshacer.</p>
                                                </div>
                                                <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
                                                    <button @click="modalOpen=false" type="button"
                                                        class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors border rounded-md focus:outline-none focus:ring-2 focus:ring-neutral-100 focus:ring-offset-2">Cancelar</button>
                                                    <form action="{{ route('members.destroy') }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" name="member" value="{{ $member->id }}">
                                                        <button type="submit"
                                                            class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium text-white transition-colors border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 focus:ring-offset-2 bg-red-500 hover:bg-red-600">Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="mt-2 p-2">
            {{ $members->links() }}
        </div>
    </div>

@stop

@section('css')
@stop
