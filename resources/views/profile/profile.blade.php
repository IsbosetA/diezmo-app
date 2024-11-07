@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
    <h1>Perfil</h1>
@stop

@section('content')
    <div class="p-4">
        <div class="grid grid-cols-2 justify-items-center">
            <div class="max-w-96 w-96">
                <div class="relative z-0 w-full mb-5 group">
                    <input type="email" name="floating_email" id="floating_email" value="{{ Auth::user()->member->email }}"
                        {{ Auth::user()->hasRole('admin') ? '' : 'disabled' }}
                        class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer {{ Auth::user()->hasRole('admin') ? '' : 'cursor-not-allowed' }}"
                        placeholder=" " required />
                    <label for="floating_email"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Correo
                        Electronico</label>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="floating_first_name" id="floating_first_name"
                            value="{{ Auth::user()->member->firstname }}"
                            {{ Auth::user()->hasRole('admin') ? '' : 'disabled' }}
                            class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer {{ Auth::user()->hasRole('admin') ? '' : 'cursor-not-allowed' }}"
                            placeholder=" " required />
                        <label for="floating_first_name"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nombre</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="floating_last_name" id="floating_last_name"
                            value="{{ Auth::user()->member->lastname }}"
                            {{ Auth::user()->hasRole('admin') ? '' : 'disabled' }}
                            class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer {{ Auth::user()->hasRole('admin') ? '' : 'cursor-not-allowed' }}"
                            placeholder=" " required />
                        <label for="floating_last_name"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Apellido</label>
                    </div>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" name="floating_phone"
                        value="{{ Auth::user()->member->phone }}" {{ Auth::user()->hasRole('admin') ? '' : 'disabled' }}
                        id="floating_phone"
                        class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer {{ Auth::user()->hasRole('admin') ? '' : 'cursor-not-allowed' }}"
                        placeholder=" " required />
                    <label for="floating_phone"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Telefono
                        (+58 123 234 2345)</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="floating_company" id="floating_company"
                        value="{{ Auth::user()->member->address }}" {{ Auth::user()->hasRole('admin') ? '' : 'disabled' }}
                        class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer {{ Auth::user()->hasRole('admin') ? '' : 'cursor-not-allowed' }}"
                        placeholder=" " required />
                    <label for="floating_company"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Direccion</label>
                </div>
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
            </div>
            <div class="max-w-[35rem] w-[35rem]">
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="email" name="floating_email" id="floating_email"
                            value="{{ Auth::user()->username }}" {{ Auth::user()->hasRole('admin') ? '' : 'disabled' }}
                            class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer {{ Auth::user()->hasRole('admin') ? '' : 'cursor-not-allowed' }}"
                            placeholder=" " required />
                        <label for="floating_email"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nombre
                            de Usuario</label>
                    </div>
                    <div>
                        <button type="button"
                            class="px-5 py-2.5 text-sm font-medium text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5 me-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                            Cambiar Contraseña
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop
