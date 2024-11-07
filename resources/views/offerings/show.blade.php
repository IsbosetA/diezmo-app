@extends('adminlte::page')

@section('title', 'Ofrenda')

@section('content_header')
    <h1>Tipo de Ofrenda</h1>
@stop

@section('content')
    <div class="p-4">
        <form class="max-w-md mx-auto" method="POST" action="{{route('offerings.update')}}">
            @method('put')
            @csrf
            <input type="hidden" name="offeringType" value="{{$offeringType->id}}">
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="name" id="name" value="{{$offeringType->name}}"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                    placeholder="" required />
                <label for="name"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nombre de la Ofrenda</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="description" id="description" value="{{$offeringType->description}}"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                    placeholder="" required />
                <label for="description"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Descripcion</label>
            </div>
            <div class="flex justify-end">
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Actualizar</button>
            </div>
        </form>
    </div>
@stop

@section('css')
@stop
