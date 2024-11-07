@extends('adminlte::page')

@section('title', 'Nuevo Sobre')

@section('content_header')
    <h1>Nuevo Sobre</h1>
@stop

@section('content')
    <div x-data="attach" class="p-4">
        <form class="max-w-full mx-auto" method="POST" action="{{ route('envelopes.add') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-2 justify-items-center">
                <div class="max-w-96 w-96">
                    <div class="relative z-[4000] w-full mb-5 group">
                        <div x-data="{
                            datePickerOpen: false,
                            datePickerValue: '',
                            datePickerFormat: 'M d, Y',
                            datePickerMonth: '',
                            datePickerYear: '',
                            datePickerDay: '',
                            datePickerDaysInMonth: [],
                            datePickerBlankDaysInMonth: [],
                            datePickerMonthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                            datePickerDays: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                            datePickerDayClicked(day) {
                                let selectedDate = new Date(this.datePickerYear, this.datePickerMonth, day);
                                this.datePickerDay = day;
                                this.datePickerValue = this.datePickerFormatDate(selectedDate);
                                this.datePickerIsSelectedDate(day);
                                this.datePickerOpen = false;
                            },
                            datePickerPreviousMonth() {
                                if (this.datePickerMonth == 0) {
                                    this.datePickerYear--;
                                    this.datePickerMonth = 12;
                                }
                                this.datePickerMonth--;
                                this.datePickerCalculateDays();
                            },
                            datePickerNextMonth() {
                                if (this.datePickerMonth == 11) {
                                    this.datePickerMonth = 0;
                                    this.datePickerYear++;
                                } else {
                                    this.datePickerMonth++;
                                }
                                this.datePickerCalculateDays();
                            },
                            datePickerIsSelectedDate(day) {
                                const d = new Date(this.datePickerYear, this.datePickerMonth, day);
                                return this.datePickerValue === this.datePickerFormatDate(d) ? true : false;
                            },
                            datePickerIsToday(day) {
                                const today = new Date();
                                const d = new Date(this.datePickerYear, this.datePickerMonth, day);
                                return today.toDateString() === d.toDateString() ? true : false;
                            },
                            datePickerCalculateDays() {
                                let daysInMonth = new Date(this.datePickerYear, this.datePickerMonth + 1, 0).getDate();
                                // find where to start calendar day of week
                                let dayOfWeek = new Date(this.datePickerYear, this.datePickerMonth).getDay();
                                let blankdaysArray = [];
                                for (var i = 1; i <= dayOfWeek; i++) {
                                    blankdaysArray.push(i);
                                }
                                let daysArray = [];
                                for (var i = 1; i <= daysInMonth; i++) {
                                    daysArray.push(i);
                                }
                                this.datePickerBlankDaysInMonth = blankdaysArray;
                                this.datePickerDaysInMonth = daysArray;
                            },
                            datePickerFormatDate(date) {
                                let formattedDay = this.datePickerDays[date.getDay()];
                                let formattedDate = ('0' + date.getDate()).slice(-2); // appends 0 (zero) in single digit date
                                let formattedMonth = this.datePickerMonthNames[date.getMonth()];
                                let formattedMonthShortName = this.datePickerMonthNames[date.getMonth()].substring(0, 3);
                                let formattedMonthInNumber = ('0' + (parseInt(date.getMonth()) + 1)).slice(-2);
                                let formattedYear = date.getFullYear();

                                if (this.datePickerFormat === 'M d, Y') {
                                    return `${formattedMonthShortName} ${formattedDate}, ${formattedYear}`;
                                }
                                if (this.datePickerFormat === 'MM-DD-YYYY') {
                                    return `${formattedMonthInNumber}-${formattedDate}-${formattedYear}`;
                                }
                                if (this.datePickerFormat === 'DD-MM-YYYY') {
                                    return `${formattedDate}-${formattedMonthInNumber}-${formattedYear}`;
                                }
                                if (this.datePickerFormat === 'YYYY-MM-DD') {
                                    return `${formattedYear}-${formattedMonthInNumber}-${formattedDate}`;
                                }
                                if (this.datePickerFormat === 'D d M, Y') {
                                    return `${formattedDay} ${formattedDate} ${formattedMonthShortName} ${formattedYear}`;
                                }

                                return `${formattedMonth} ${formattedDate}, ${formattedYear}`;
                            },
                        }" x-init="currentDate = new Date();
                        if (datePickerValue) {
                            currentDate = new Date(Date.parse(datePickerValue));
                        }
                        datePickerMonth = currentDate.getMonth();
                        datePickerYear = currentDate.getFullYear();
                        datePickerDay = currentDate.getDay();
                        datePickerValue = datePickerFormatDate(currentDate);
                        datePickerCalculateDays();" x-cloak>
                            <div>
                                <div>
                                    <label for="datepicker"
                                        class="block mb-1 text-sm font-medium text-neutral-500">Fecha</label>
                                    <div class="relative w-full">
                                        <input x-ref="datePickerInput" type="text"
                                            @click="datePickerOpen=!datePickerOpen" x-model="datePickerValue" name="date"
                                            x-on:keydown.escape="datePickerOpen=false"
                                            class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                                            placeholder="Fecha" readonly />
                                        <div @click="datePickerOpen=!datePickerOpen; if(datePickerOpen){ $refs.datePickerInput.focus() }"
                                            class="absolute top-0 right-0 px-3 py-2 cursor-pointer text-neutral-400 hover:text-neutral-500">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div x-show="datePickerOpen" x-transition @click.away="datePickerOpen = false"
                                            class="absolute top-0 left-0 max-w-lg p-4 mt-12 antialiased bg-white border rounded-lg shadow w-full border-neutral-200/70">
                                            <div class="flex items-center justify-between mb-2">
                                                <div>
                                                    <span x-text="datePickerMonthNames[datePickerMonth]"
                                                        class="text-lg font-bold text-[#343A40]"></span>
                                                    <span x-text="datePickerYear"
                                                        class="ml-1 text-lg font-normal text-gray-600"></span>
                                                </div>
                                                <div>
                                                    <button @click="datePickerPreviousMonth()" type="button"
                                                        class="inline-flex p-1 transition duration-100 ease-in-out rounded-full cursor-pointer focus:outline-none focus:shadow-outline hover:bg-gray-100">
                                                        <svg class="inline-flex w-6 h-6 text-gray-400" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 19l-7-7 7-7" />
                                                        </svg>
                                                    </button>
                                                    <button @click="datePickerNextMonth()" type="button"
                                                        class="inline-flex p-1 transition duration-100 ease-in-out rounded-full cursor-pointer focus:outline-none focus:shadow-outline hover:bg-gray-100">
                                                        <svg class="inline-flex w-6 h-6 text-gray-400" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-7 mb-3">
                                                <template x-for="(day, index) in datePickerDays" :key="index">
                                                    <div class="px-0.5">
                                                        <div x-text="day"
                                                            class="text-xs font-medium text-center text-[#343A40]"></div>
                                                    </div>
                                                </template>
                                            </div>
                                            <div class="grid grid-cols-7">
                                                <template x-for="blankDay in datePickerBlankDaysInMonth">
                                                    <div class="p-1 text-sm text-center border border-transparent">
                                                    </div>
                                                </template>
                                                <template x-for="(day, dayIndex) in datePickerDaysInMonth"
                                                    :key="dayIndex">
                                                    <div class="px-0.5 mb-1 aspect-square">
                                                        <div x-text="day" @click="datePickerDayClicked(day)"
                                                            :class="{
                                                                'bg-neutral-200': datePickerIsToday(day) == true,
                                                                'text-gray-600 hover:bg-neutral-200': datePickerIsToday(
                                                                    day) == false && datePickerIsSelectedDate(
                                                                    day) == false,
                                                                'bg-neutral-800 text-white hover:bg-opacity-75': datePickerIsSelectedDate(
                                                                    day) == true
                                                            }"
                                                            class="flex items-center justify-center text-sm leading-none text-center rounded-full cursor-pointer h-7 w-7">
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="group relative z-0 mb-5 w-full">
                            <label for="member" class="sr-only">Underline select</label>
                            <select id="member" name="member"
                                class="peer block w-full !appearance-none !border-0 !border-b-2 !border-gray-300 !bg-transparent !px-0 py-2.5 !text-sm  text-gray-900 focus:!border-blue-600 focus:!outline-none focus:!ring-0"
                                placeholder=" " required>
                                <option selected class="text-gray-500 font-bold">Selecciona un Miembro</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}" class="text-gray-500">{{ $member->firstname }}
                                        {{ $member->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div x-data="{ amount: '' }" class="relative z-0 w-full mb-5 group">
                            <input type="number" name="tithe" id="tithe"
                                x-model="amount"
                                @blur="if (Number.isInteger(+amount) && amount !== '') { amount = (+amount).toFixed(2); }"
                                class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                                placeholder=" " required />
                            <label for="tithe"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Diezmo</label>
                        </div>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="description" id="description"
                            class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                            placeholder=" " required />
                        <label for="description"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Descripcion</label>
                    </div>
                    <div class="group relative z-0 mb-5 w-full">
                        <div class="flex items-center">
                            <input id="default-checkbox" type="checkbox" value="" x-model="transf"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 !rounded focus:ring-blue-500">
                            <label for="default-checkbox" class="ms-2 !text-sm !font-medium text-gray-900 !mb-0">Adjuntar
                                Transferencias</label>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Crear</button>
                    </div>
                </div>
                {{-- Ofrendas --}}
                <div x-data="inputManager()">
                    <div class="max-w-96 w-96">
                        <div>
                            <div class="relative z-0 w-full group flex justify-end">
                                <button type="button" @click="addInput()"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    <span class="sr-only">Plus Icon</span>
                                </button>
                            </div>
                            <!-- Mensaje de advertencia al llegar al límite -->
                            <template x-if="inputs.length >= 4">
                                <div class="text-red-500 text-sm mt-2">Has alcanzado el límite de ofrendas.</div>
                            </template>
                        </div>

                        <template x-for="(input, index) in inputs" :key="index">
                            <div class="flex justify-between h-16">
                                <!-- Botón de eliminar visible solo en los inputs clonados -->
                                <template x-if="index > 0">
                                    <div class="flex justify-start items-center mr-2 mt-4">
                                        <div>
                                            <button type="button" @click="removeInput(index)"
                                                class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                <span class="sr-only">Eliminar</span>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                                <div class="grid md:grid-cols-2 md:gap-6 mt-4">
                                    <div class="relative z-0 w-full mb-5 group">
                                        <label :for="'offering_type_' + index" class="sr-only">Underline select</label>
                                        <select :id="'offering_type_' + index" :name="'offering_type[]'"
                                            class="peer block w-full !appearance-none !border-0 !border-b-2 !border-gray-300 !bg-transparent !px-0 py-2.5 !text-sm text-gray-900 focus:!border-blue-600 focus:!outline-none focus:!ring-0"
                                            required>
                                            <option selected class="text-gray-500 font-bold">Selecciona una Ofrenda
                                            </option>
                                            <!-- Aquí puedes reemplazar con tu lógica de PHP -->
                                            @foreach ($offeringsTypes as $offering)
                                                <option value="{{ $offering->id }}" class="text-gray-500">
                                                    {{ $offering->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div x-data="{ amount: '' }" class="relative z-0 w-full mb-5 group">
                                        <input type="number" :name="'offering_amount[]'" :id="'offering_amount_' + index"
                                            x-model="amount"
                                            @blur="if (Number.isInteger(+amount) && amount !== '') { amount = (+amount).toFixed(2); }"
                                            class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                                            placeholder=" " required />
                                        <label :for="'offering_amount_' + index"
                                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Cantidad</label>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <template x-if="transf">
                <div class="mt-8">
                    <div>
                        <div class="relative z-0 w-full group flex justify-end">
                            <button type="button" @click="addInput()"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                <span class="sr-only">Plus Icon</span>
                            </button>
                        </div>
                        <!-- Mensaje de advertencia al llegar al límite -->
                        <template x-if="inputs.length >= 4">
                            <div class="text-red-500 text-sm mt-2">Has alcanzado el límite de ofrendas.</div>
                        </template>
                    </div>
                    <template x-for="(input, index) in inputs" :key="index">
                        <div class="flex justify-between h-16">
                            <template x-if="index > 0">
                                <div class="flex justify-start items-center mr-2">
                                    <div>
                                        <button type="button" @click="removeInput(index)"
                                            class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                            <span class="sr-only">Eliminar</span>
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <div class="w-full grid grid-cols-5 gap-4">
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="text" :id="'transfer_date_' + index" :name="'transfer_date[]'"
                                        class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                                        placeholder=" " required />
                                    <label :for="'transfer_date_' + index"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Fecha
                                        de Transferencia</label>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="text" :id="'transfer_num_' + index" :name="'transfer_num[]'"
                                        class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                                        placeholder=" " required />
                                    <label :for="'transfer_num_' + index"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Numero
                                        de Transferencia</label>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="text" :id="'transfer_bank_' + index" :name="'transfer_bank[]'"
                                        class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                                        placeholder=" " required />
                                    <label :for="'transfer_bank_' + index"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Banco
                                        Receptor / Cuenta</label>
                                </div>
                                <div x-data="{ amount: '' }" class="relative z-0 w-full mb-5 group">
                                    <input type="number" :id="'transfer_amount_' + index" :name="'transfer_amount[]'"
                                        x-model="amount"
                                        @blur="if (Number.isInteger(+amount) && amount !== '') { amount = (+amount).toFixed(2); }"
                                        class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                                        placeholder=" " required />
                                    <label :for="'transfer_amount_' + index"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Monto
                                        de Transferencia</label>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <label class="block">
                                        <span class="sr-only" :for="'capture_' + index">Escoge la captura de la
                                            transferencia</span>
                                        <input type="file" :id="'capture_' + index" :name="'capture[]'"
                                            class="block w-full text-sm text-gray-500 cursor-pointer file:cursor-pointer
                                            file:me-4 file:py-2 file:px-4
                                            file:rounded-lg file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-blue-600 file:text-white
                                            hover:file:bg-blue-700
                                            file:disabled:opacity-50 file:disabled:pointer-events-none
                                            ">
                                    </label>
                                </div>
                            </div>
                        </div>
                </div>
            </template>
            </template>
        </form>
    </div>

    <script>
        function inputManager() {
            return {
                inputs: [{
                    ofering_type: '',
                    offering_amount: ''
                }],
                addInput() {
                    if (this.inputs.length < 4) {
                        this.inputs.push({
                            ofering_type: '',
                            offering_amount: ''
                        });
                    }
                },
                removeInput(index) {
                    this.inputs.splice(index, 1);
                }
            }
        }

        function attach() {
            return {
                transf: false,
                inputs: [{
                    transfer_date: '',
                    transfer_num: '',
                    transfer_bank: '',
                    transfer_amount: '',
                    capture: ''
                }],
                addInput() {
                    if (this.inputs.length < 4) {
                        this.inputs.push({
                            transfer_date: '',
                            transfer_num: '',
                            transfer_bank: '',
                            transfer_amount: '',
                            capture: ''
                        });
                    }
                },
                removeInput(index) {
                    this.inputs.splice(index, 1);
                }
            }
        }
    </script>
@stop

@section('css')
@stop
