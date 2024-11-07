@extends('adminlte::page')

@section('title', 'Sobre')

@section('content_header')
    <h1>Sobre #{{ $envelope->envelope_number }}</h1>
@stop

@section('content')
    <div x-data="attach({{ json_encode($envelope->transfers) }})" class="p-4">
        <form class="max-w-full mx-auto" method="POST" action="{{ route('envelopes.update') }}" enctype="multipart/form-data">
            @csrf
            @method('put')
            <input type="hidden" name="envelope" value="{{ $envelope->id }}">
            <div class="grid grid-cols-2 justify-items-center">
                <div class="max-w-96 w-96">
                    <div class="relative z-[4000] w-full mb-5 group">
                        <div x-data="{
                            datePickerOpen: false,
                            datePickerValue: '{{ \Carbon\Carbon::parse($envelope->date)->format('M d, y') }}',
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
                        @if (Auth::user()->hasRole('admin'))
                            <div class="group relative z-0 mb-5 w-full">
                                <label for="member" class="sr-only">Underline select</label>
                                <select id="member" name="member"
                                    class="peer block w-full !appearance-none !border-0 !border-b-2 !border-gray-300 !bg-transparent !px-0 py-2.5 !text-sm  text-gray-900 focus:!border-blue-600 focus:!outline-none focus:!ring-0"
                                    placeholder=" " required>
                                    <option selected class="text-gray-500 font-bold">Selecciona un Miembro</option>
                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}" class="text-gray-500"
                                            {{ $member->id == $envelope->member->id ? 'selected' : '' }}>
                                            {{ $member->firstname }}
                                            {{ $member->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        @if (Auth::user()->hasRole('member'))
                            <input type="hidden" name="member" value="{{ Auth::user()->member->id }}">
                            <div class="relative z-0 w-full mb-5 group">
                                <input type="text" name="member_fullname" id="member_fullname" value="{{ Auth::user()->member->firstname.' '.Auth::user()->member->lastname }}" disabled
                                    class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer  cursor-not-allowed"
                                    placeholder=" " required />
                                <label for="member_fullname"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Descripcion</label>
                            </div>
                        @endif
                        <div class="relative z-0 w-full mb-5 group">
                            <input type="number" name="tithe" id="tithe" value="{{ $envelope->tithe->amount }}"
                                class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                                placeholder=" " required />
                            <label for="tithe"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Diezmo</label>
                        </div>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="description" id="description" value="{{ $envelope->description }}"
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
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Actualizar</button>
                    </div>
                </div>
                {{-- Ofrendas --}}
                <div x-data="inputManager({{ json_encode($envelope->offerings) }})">
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
                                        <input type="hidden" :name="'offering_id[]'" :id="'offering_id_' + index"
                                            x-model="input.offering_id">
                                        <label :for="'offering_type_' + index" class="sr-only">Underline select</label>
                                        <select :id="'offering_type_' + index" :name="'offering_type[]'"
                                            x-model="input.offering_type"
                                            class="peer block w-full !appearance-none !border-0 !border-b-2 !border-gray-300 !bg-transparent !px-0 py-2.5 !text-sm text-gray-900 focus:!border-blue-600 focus:!outline-none focus:!ring-0"
                                            required>
                                            <option selected class="text-gray-500 font-bold">Selecciona una Ofrenda
                                            </option>
                                            <!-- Aquí puedes reemplazar con tu lógica de PHP -->
                                            @foreach ($offeringsTypes as $offering)
                                                <option value="{{ $offering->id }}" class="text-gray-500"
                                                    x-bind:selected="input.offering_type == {{ $offering->id }}">
                                                    {{ $offering->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="relative z-0 w-full mb-5 group">
                                        <input type="number" :name="'offering_amount[]'"
                                            :id="'offering_amount_' + index" x-model="input.offering_amount"
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
                    <div class="mb-4">
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
                                    <input type="hidden" :id="'transfer_id_' + index" :name="'transfer_id[]'"
                                        x-model="input.transfer_id" />
                                    <input type="text" :id="'transfer_date_' + index" :name="'transfer_date[]'"
                                        x-model="input.transfer_date"
                                        class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                                        placeholder=" " required />
                                    <label :for="'transfer_date_' + index"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Fecha
                                        de Transferencia</label>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="text" :id="'transfer_num_' + index" :name="'transfer_num[]'"
                                        x-model="input.transfer_num"
                                        class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                                        placeholder=" " required />
                                    <label :for="'transfer_num_' + index"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Numero
                                        de Transferencia</label>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="text" :id="'transfer_bank_' + index" :name="'transfer_bank[]'"
                                        x-model="input.transfer_bank"
                                        class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                                        placeholder=" " required />
                                    <label :for="'transfer_bank_' + index"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Banco
                                        Receptor / Cuenta</label>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">
                                    <input type="number" :id="'transfer_amount_' + index" :name="'transfer_amount[]'"
                                        x-model="input.transfer_amount"
                                        class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                                        placeholder=" " required />
                                    <label :for="'transfer_amount_' + index"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Monto
                                        de Transferencia</label>
                                </div>
                                <template x-if="input.capture != '' && input.changeCap == false">
                                    <div class="relative z-0 w-full mb-5 group flex justify-center gap-5">
                                        <div x-data="{ modalOpen: false }" @keydown.escape.window="modalOpen = false"
                                            :class="{ 'z-40': modalOpen }" class="relative w-auto h-auto">
                                            <button @click="modalOpen=true" type="button"
                                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Captura</button>
                                            <template x-teleport="body">
                                                <div x-show="modalOpen"
                                                    class="fixed top-0 left-0 z-[4010] flex items-center justify-center w-screen h-screen"
                                                    x-cloak>
                                                    <div x-show="modalOpen" x-transition:enter="ease-out duration-300"
                                                        x-transition:enter-start="opacity-0"
                                                        x-transition:enter-end="opacity-100"
                                                        x-transition:leave="ease-in duration-300"
                                                        x-transition:leave-start="opacity-100"
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
                                                            <h3 class="text-lg font-semibold">Captura de la Transferencia
                                                            </h3>
                                                            <button @click="modalOpen=false" type="button"
                                                                class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 mt-5 mr-5 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50">
                                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="relative w-auto pb-8">
                                                            <div class="p-3 flex justify-center">
                                                                <img class="w-[20rem] h-auto"
                                                                    :src="'/storage/' + input.capture" alt="Captura">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
                                                            <button @click="modalOpen=false" type="button"
                                                                class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium text-white transition-colors border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-red-700 focus:ring-offset-2 bg-red-500 hover:bg-red-600">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>

                                        <button type="button" @click='changeInput(index)'
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                                <template x-if="input.capture == '' || input.changeCap == true">
                                    <div class="relative z-0 w-full mb-5 group flex justify-center">
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
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </form>
    </div>

    <script>
        function inputManager(initialOfferings) {
            return {
                inputs: initialOfferings.map(offering => ({
                    offering_id: offering.id,
                    offering_type: offering.id_offering_type, // Ajusta según el atributo correcto
                    offering_amount: offering.amount
                })) || [{
                    offering_id: '',
                    offering_type: '',
                    offering_amount: ''
                }],

                addInput() {
                    if (this.inputs.length < 4) {
                        this.inputs.push({
                            offering_id: '',
                            offering_type: '',
                            offering_amount: ''
                        });
                    }
                },

                removeInput(index) {
                    this.inputs.splice(index, 1);
                }
            }
        }


        function attach(initialTransfers) {
            return {
                transf: {{ $envelope->transfers->isNotEmpty() ? 'true' : 'false' }},
                inputs: initialTransfers.map(transfer => ({
                    transfer_id: transfer.id,
                    transfer_date: new Date(transfer.date).toLocaleDateString('es-ES', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    }),
                    transfer_num: transfer.reference,
                    transfer_bank: transfer.bank,
                    transfer_amount: transfer.amount,
                    capture: transfer.capture,
                    changeCap: false
                })) || [{
                    transfer_id: '',
                    transfer_date: '',
                    transfer_num: '',
                    transfer_bank: '',
                    transfer_amount: '',
                    capture: '',
                    changeCap: false
                }],
                addInput() {
                    if (this.inputs.length < 4) {
                        this.inputs.push({
                            transfer_id: '',
                            transfer_date: '',
                            transfer_num: '',
                            transfer_bank: '',
                            transfer_amount: '',
                            capture: '',
                            changeCap: false
                        });
                    }
                },
                changeInput(index) {
                    this.inputs[index].changeCap = true;
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
