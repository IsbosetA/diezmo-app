@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
    <h1>Perfil</h1>
@stop

@section('content')
    <div class="p-4">
        <div class="grid grid-cols-2 justify-items-center">
            @if (Auth::user()->hasRole('member'))
                <div class="max-w-96 w-96">
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="email" name="floating_email" id="floating_email"
                            value="{{ Auth::user()->member->email }}" {{ Auth::user()->hasRole('admin') ? '' : 'disabled' }}
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
                            value="{{ Auth::user()->member->phone }}"
                            {{ Auth::user()->hasRole('admin') ? '' : 'disabled' }} id="floating_phone"
                            class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer {{ Auth::user()->hasRole('admin') ? '' : 'cursor-not-allowed' }}"
                            placeholder=" " required />
                        <label for="floating_phone"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Telefono
                            (+58 123 234 2345)</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="floating_company" id="floating_company"
                            value="{{ Auth::user()->member->address }}"
                            {{ Auth::user()->hasRole('admin') ? '' : 'disabled' }}
                            class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer {{ Auth::user()->hasRole('admin') ? '' : 'cursor-not-allowed' }}"
                            placeholder=" " required />
                        <label for="floating_company"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Direccion</label>
                    </div>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
                </div>
            @endif
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

                        <div x-data="{ modalOpen: false }" @keydown.escape.window="modalOpen = false"
                            :class="{ 'z-40': modalOpen }" class="relative w-auto h-auto">
                            <button type="button" @click="modalOpen=true"
                                class="px-5 py-2.5 text-sm font-medium text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 me-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                                Cambiar Contraseña
                            </button>
                            <template x-teleport="body">
                                <div x-show="modalOpen"
                                    class="fixed top-0 left-0 z-[4000] flex items-center justify-center w-screen h-screen"
                                    x-cloak>
                                    <div x-show="modalOpen" x-transition:enter="ease-out duration-300"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave="ease-in duration-300" x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0" @click="modalOpen=false"
                                        class="absolute inset-0 w-full h-full bg-white backdrop-blur-sm bg-opacity-70">
                                    </div>
                                    <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen"
                                        x-transition:enter="ease-out duration-300"
                                        x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95"
                                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                        x-transition:leave="ease-in duration-200"
                                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                        x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95"
                                        class="relative w-full py-6 bg-white border shadow-lg px-7 border-neutral-200 sm:max-w-lg sm:rounded-lg">
                                        <div class="flex items-center justify-between pb-3">
                                            <h3 class="text-lg font-semibold">Actualizar Contraseña</h3>
                                            <button @click="modalOpen=false"
                                                class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 !mt-5 !mr-5 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50">
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <form action="{{ route('profile.update.password') }}" method="post">
                                            @csrf
                                            <div x-data="passwordValidation()" class="relative w-auto pb-8">
                                                <div class="mt-4">
                                                    <div class="relative z-0 w-full mb-3 group">
                                                        <input :type="showPassword ? 'text' : 'password'"
                                                            name="new_password" id="new_password"
                                                            class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                                                            placeholder=" " required x-model="password"
                                                            @input="validatePassword" />
                                                        <label for="new_password"
                                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nueva
                                                            Contraseña</label>

                                                        <button type="button" @click="showPassword = !showPassword"
                                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                                            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 text-gray-500" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg"
                                                                class="h-5 w-5 text-gray-500" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.52-3.497m14.437 8.822A9.993 9.993 0 0112 5a9.993 9.993 0 00-3.875.825m9.062 6.853A3 3 0 1112 15a3 3 0 013-3zm-6 0a3 3 0 013-3" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <!-- Requisitos de la contraseña -->
                                                    <ul class="mt-2 mb-3 text-sm" x-show="password.length > 0">
                                                        <li
                                                            :class="{
                                                                'text-green-600': requirements
                                                                    .uppercase,
                                                                'text-red-600': !requirements
                                                                    .uppercase
                                                            }">
                                                            <span x-show="requirements.uppercase">✔</span>
                                                            <span x-show="!requirements.uppercase">✘</span> Una letra
                                                            mayúscula
                                                        </li>
                                                        <li
                                                            :class="{
                                                                'text-green-600': requirements
                                                                    .lowercase,
                                                                'text-red-600': !requirements
                                                                    .lowercase
                                                            }">
                                                            <span x-show="requirements.lowercase">✔</span>
                                                            <span x-show="!requirements.lowercase">✘</span> Una letra
                                                            minúscula
                                                        </li>
                                                        <li
                                                            :class="{
                                                                'text-green-600': requirements.number,
                                                                'text-red-600':
                                                                    !requirements.number
                                                            }">
                                                            <span x-show="requirements.number">✔</span>
                                                            <span x-show="!requirements.number">✘</span> Un número
                                                        </li>
                                                        <li
                                                            :class="{
                                                                'text-green-600': requirements
                                                                    .specialChar,
                                                                'text-red-600': !requirements
                                                                    .specialChar
                                                            }">
                                                            <span x-show="requirements.specialChar">✔</span>
                                                            <span x-show="!requirements.specialChar">✘</span> Un
                                                            carácter especial (!@#$%^&*()_-+=)
                                                        </li>
                                                        <li
                                                            :class="{
                                                                'text-green-600': requirements
                                                                    .minLength,
                                                                'text-red-600': !requirements
                                                                    .minLength
                                                            }">
                                                            <span x-show="requirements.minLength">✔</span>
                                                            <span x-show="!requirements.minLength">✘</span> Mínimo 8
                                                            caracteres
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="relative z-0 w-full mb-3 group flex items-center">
                                                    <!-- Input para confirmar la contraseña -->
                                                    <input :type="showPassword ? 'text' : 'password'"
                                                        name="new_password_confirmation" id="new_password_confirmation"
                                                        class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                                                        placeholder=" " required x-model="confirmPassword"
                                                        @input="validatePassword" />
                                                    <label for="new_password_confirmation"
                                                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirmar
                                                        Contraseña</label>

                                                    <button type="button"
                                                        @click="showConfirmPassword = !showConfirmPassword"
                                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                                                        <svg x-show="!showConfirmPassword"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5 text-gray-500" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                        <svg x-show="showConfirmPassword"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5 text-gray-500" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.52-3.497m14.437 8.822A9.993 9.993 0 0112 5a9.993 9.993 0 00-3.875.825m9.062 6.853A3 3 0 1112 15a3 3 0 013-3zm-6 0a3 3 0 013-3" />
                                                        </svg>
                                                    </button>
                                                </div>

                                                <!-- Mensaje de verificación de coincidencia de contraseñas -->
                                                <p x-show="confirmPassword.length > 0 && !passwordsMatch"
                                                    class="text-sm text-red-600 mt-1">✘ Las contraseñas no coinciden
                                                </p>
                                            </div>
                                            <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
                                                <button @click="modalOpen=false" type="button"
                                                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-cente">Cancelar</button>
                                                <button type="submit" :disabled="!formValid()"
                                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center disabled:opacity-50">Actualizar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function passwordValidation() {
            return {
                password: '',
                confirmPassword: '',
                showPassword: false,
                showConfirmPassword: false,
                requirements: {
                    uppercase: false,
                    lowercase: false,
                    number: false,
                    specialChar: false,
                    minLength: false
                },
                get passwordsMatch() {
                    return this.password === this.confirmPassword;
                },
                get formValid() {
                    return Object.values(this.requirements).every(value => value) && this.passwordsMatch;
                },
                validatePassword() {
                    this.requirements.uppercase = /[A-Z]/.test(this.password);
                    this.requirements.lowercase = /[a-z]/.test(this.password);
                    this.requirements.number = /\d/.test(this.password);
                    this.requirements.specialChar = /[!@#$%^&*()_\-+=]/.test(this.password);
                    this.requirements.minLength = this.password.length >= 8;
                }
            };
        }
    </script>
@stop

@section('css')
@stop
