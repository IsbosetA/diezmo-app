@extends('adminlte::page')

@section('title', 'Configuraciones')

@section('content_header')
    <h1>Configuraciones</h1>
@stop

@section('content')
    <div class="p-4">
        <form class="max-w-full mx-auto flex justify-center" method="POST" action="{{ route('settings.update') }}">
            @csrf
            <input type="hidden" name="settings" value="{{$settings ? $settings->id : '' }}">
            <div class="max-w-96 w-96">
                <div class="relative z-[4001] w-full mb-5 group">
                    <div x-data="{
                        datePickerOpen: false,
                        datePickerValue: '{{$settings ? \Carbon\Carbon::parse($settings->period_start)->format('M d, y') : '' }}',
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
                                <label for="datepicker" class="block mb-1 text-sm font-medium text-neutral-500">Inicio del
                                    Periodo</label>
                                <div class="relative w-full">
                                    <input x-ref="datePickerInput" type="text" @click="datePickerOpen=!datePickerOpen"
                                        x-model="datePickerValue" name="period_start" x-on:keydown.escape="datePickerOpen=false"
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
                <div class="relative z-[4000] w-full mb-5 group">
                    <div x-data="{
                        datePickerOpen: false,
                        datePickerValue: '{{$settings ? \Carbon\Carbon::parse($settings->period_end)->format('M d, y') : '' }}',
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
                                <label for="datepicker" class="block mb-1 text-sm font-medium text-neutral-500">Final del
                                    Periodo</label>
                                <div class="relative w-full">
                                    <input x-ref="datePickerInput" type="text" @click="datePickerOpen=!datePickerOpen"
                                        x-model="datePickerValue" name="period_end" x-on:keydown.escape="datePickerOpen=false"
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
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="church_name" id="church_name"
                        value="{{$settings ? $settings->church_name : '' }}"
                        class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                        placeholder=" " required />
                    <label for="church_name"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nombre de la Iglesia</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="city" id="city"
                        value="{{$settings ? $settings->city : '' }}"
                        class="block py-2.5 px-0 w-full !text-sm text-gray-900 !bg-transparent !border-0 !border-b-2 !border-gray-300 !appearance-none focus:!outline-none focus:!ring-0 focus:!border-blue-600 peer"
                        placeholder=" " required />
                    <label for="city"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Ciudad</label>
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Actualizar</button>
                </div>
            </div>
        </form>
    </div>
@stop

@section('css')
@stop
