@props([
    'locations' => null,
    'name' => 'location',
    'value' => null,
    'placeholder' => 'Select Location',
    'id' => null,
    'triggerClass' => '',
    'autoSubmit' => false,
])

@php
    $inputVal = $value ?? request($name, '');

    $canonicalLocations = [
        'Ampara' => ['Ampara', 'Kalmunai', 'Akkaraipattu', 'Sammanthurai', 'Pottuvil', 'Sainthamaruthu', 'Uhana', 'Maha Oya', 'Dehiattakandiya', 'Nintavur', 'Oluvil', 'Thirukkovil'],
        'Anuradhapura' => ['Anuradhapura', 'Kekirawa', 'Thambuttegama', 'Eppawala', 'Medawachchiya', 'Mihintale', 'Nochchiyagama', 'Galenbindunuwewa', 'Horowpothana', 'Talawa', 'Kahatagasdigiliya', 'Rajanganaya'],
        'Badulla' => ['Badulla', 'Bandarawela', 'Ella', 'Haputale', 'Welimada', 'Mahiyanganaya', 'Passara', 'Hali-Ela', 'Diyatalawa', 'Haldummulla', 'Lunugala', 'Meegahakiula'],
        'Batticaloa' => ['Batticaloa', 'Kattankudy', 'Eravur', 'Valaichchenai', 'Kalkudah', 'Chenkalady', 'Kaluwanchikudy', 'Vakarai', 'Arayampathy', 'Oddamavadi'],
        'Colombo' => ['Colombo', 'Dehiwala', 'Mount Lavinia', 'Nugegoda', 'Maharagama', 'Kotte', 'Kaduwela', 'Homagama', 'Piliyandala', 'Moratuwa', 'Avissawella', 'Hanwella', 'Malabe', 'Rajagiriya', 'Boralesgamuwa'],
        'Galle' => ['Galle', 'Hikkaduwa', 'Ambalangoda', 'Elpitiya', 'Baddegama', 'Karapitiya', 'Ahangama', 'Balapitiya', 'Bentota', 'Imaduwa', 'Udugama', 'Nagoda', 'Yakkalamulla'],
        'Gampaha' => ['Gampaha', 'Negombo', 'Veyangoda', 'Nittambuwa', 'Kiribathgoda', 'Kadawatha', 'Ja-Ela', 'Wattala', 'Minuwangoda', 'Divulapitiya', 'Kelaniya', 'Ragama', 'Ganemulla', 'Katunayake', 'Mirigama'],
        'Hambantota' => ['Hambantota', 'Tangalle', 'Beliatta', 'Tissamaharama', 'Ambalantota', 'Walasmulla', 'Weeraketiya', 'Middeniya', 'Suriyawewa', 'Lunugamvehera', 'Kirinda', 'Ranna'],
        'Jaffna' => ['Jaffna', 'Nallur', 'Chavakachcheri', 'Point Pedro', 'Valvettithurai', 'Kopay', 'Tellippalai', 'Chankanai', 'Karainagar', 'Kayts', 'Atchuvely', 'Kodikamam'],
        'Kalutara' => ['Kalutara', 'Panadura', 'Horana', 'Matugama', 'Beruwala', 'Aluthgama', 'Bandaragama', 'Wadduwa', 'Payagala', 'Ingiriya', 'Bulathsinhala', 'Millaniya', 'Agalawatta'],
        'Kandy' => ['Kandy', 'Peradeniya', 'Gampola', 'Katugastota', 'Kundasale', 'Kadugannawa', 'Wattegama', 'Nawalapitiya', 'Digana', 'Akurana', 'Galagedara', 'Pussellawa', 'Teldeniya', 'Pilimathalawa'],
        'Kegalle' => ['Kegalle', 'Mawanella', 'Rambukkana', 'Warakapola', 'Ruwanwella', 'Yatiyantota', 'Dehiowita', 'Deraniyagala', 'Galigamuwa', 'Bulathkohupitiya', 'Aranayaka'],
        'Kilinochchi' => ['Kilinochchi', 'Paranthan', 'Poonakary', 'Pallai', 'Akkarayankulam', 'Uruthirapuram', 'Kandawalai'],
        'Kurunegala' => ['Kurunegala', 'Kuliyapitiya', 'Narammala', 'Pannala', 'Wariyapola', 'Nikaweratiya', 'Mawathagama', 'Polgahawela', 'Bingiriya', 'Alawwa', 'Galgamuwa', 'Ibbagamuwa', 'Melsiripura', 'Rideegama'],
        'Mannar' => ['Mannar', 'Pesalai', 'Talaimannar', 'Murunkan', 'Madhu', 'Nanaddan', 'Erukkalampiddy'],
        'Matale' => ['Matale', 'Dambulla', 'Galewela', 'Ukuwela', 'Naula', 'Rattota', 'Yatawatta', 'Pallepola', 'Sigiriya', 'Laggala', 'Wilgamuwa'],
        'Matara' => ['Matara', 'Weligama', 'Akuressa', 'Kamburupitiya', 'Hakmana', 'Dikwella', 'Deniyaya', 'Kotapola', 'Gandara', 'Devinuwara', 'Kirinda Puhulwella', 'Malimbada'],
        'Monaragala' => ['Monaragala', 'Wellawaya', 'Buttala', 'Bibile', 'Siyambalanduwa', 'Kataragama', 'Thanamalwila', 'Badalkumbura', 'Medagama', 'Okkampitiya'],
        'Mullaitivu' => ['Mullaitivu', 'Puthukkudiyiruppu', 'Oddusuddan', 'Maritimepattu', 'Thunukkai', 'Mallavi', 'Kokkilai'],
        'Nuwara Eliya' => ['Nuwara Eliya', 'Hatton', 'Talawakele', 'Ginigathhena', 'Nanu Oya', 'Kotagala', 'Lindula', 'Maskeliya', 'Ragala', 'Walapane', 'Hanguranketha', 'Ambagamuwa'],
        'Polonnaruwa' => ['Polonnaruwa', 'Hingurakgoda', 'Kaduruwela', 'Medirigiriya', 'Welikanda', 'Lankapura', 'Aralaganwila', 'Bakamuna', 'Dimbulagala'],
        'Puttalam' => ['Puttalam', 'Chilaw', 'Wennappuwa', 'Marawila', 'Nattandiya', 'Anamaduwa', 'Dankotuwa', 'Kalpitiya', 'Madampe', 'Mundel', 'Norochcholai', 'Mahawewa'],
        'Ratnapura' => ['Ratnapura', 'Balangoda', 'Embilipitiya', 'Pelmadulla', 'Eheliyagoda', 'Kuruwita', 'Kahawatta', 'Godakawela', 'Rakwana', 'Kalawana', 'Nivitigala', 'Kolonna'],
        'Trincomalee' => ['Trincomalee', 'Kinniya', 'Kantale', 'Nilaveli', 'Mutur', 'China Bay', 'Thampalakamam', 'Kuchchaveli', 'Seruwila', 'Pulmoddai'],
        'Vavuniya' => ['Vavuniya', 'Omanthai', 'Cheddikulam', 'Nedunkeni', 'Puwarasankulam', 'Settikulam'],
    ];

    ksort($canonicalLocations);

    $initialActiveDistrict = null;
    if ($inputVal) {
        $cleanVal = strtolower(trim($inputVal));
        foreach ($canonicalLocations as $dist => $areas) {
            if (strtolower($dist) === $cleanVal) {
                $initialActiveDistrict = $dist;
                break;
            }
            foreach ($areas as $area) {
                if (strtolower($area) === $cleanVal) {
                    $initialActiveDistrict = $dist;
                    break 2;
                }
            }
        }
    }

    $inputId = $id ?: 'location-picker-' . uniqid();
@endphp

<div
    x-data="{
        open: false,
        selectedLocation: @js($inputVal),
        activeDistrict: @js($initialActiveDistrict),
        autoSubmit: @js($autoSubmit),

        togglePicker() {
            this.open = !this.open;
        },

        closePicker() {
            this.open = false;
        },

        selectLocation(val) {
            this.selectedLocation = val;
            this.open = false;
            this.$nextTick(() => {
                const el = this.$refs.hiddenInput;
                if (el) {
                    el.value = this.selectedLocation;
                    el.dispatchEvent(new Event('input', { bubbles: true }));
                    el.dispatchEvent(new Event('change', { bubbles: true }));
                }
                this.$dispatch('location-selected', { location: this.selectedLocation });
                if (this.autoSubmit) {
                    const form = this.$el.closest('form');
                    if (form) {
                        form.submit();
                    }
                }
            });
        },

        clearLocation() {
            this.activeDistrict = null;
            this.selectLocation('');
        }
    }"
    @keydown.escape.window="closePicker()"
    @click.outside="closePicker()"
    class="relative w-full"
    data-component="masterDetailLocationPicker"
>
    <!-- Hidden input holding the actual selected value for form submissions -->
    <input
        type="hidden"
        name="{{ $name }}"
        id="{{ $inputId }}"
        :value="selectedLocation"
        x-ref="hiddenInput"
    >

    <!-- Trigger Button / Input labeled "Select Location" -->
    <button
        type="button"
        @click="togglePicker()"
        :aria-expanded="open.toString()"
        class="group relative flex w-full items-center justify-between text-left transition focus:outline-none {{ $triggerClass }}"
    >
        <span class="flex items-center min-w-0 pr-2">
            <svg
                aria-hidden="true"
                class="mr-2.5 h-5 w-5 shrink-0 text-slate-400 group-hover:text-slate-600"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657 13.414 20.9a2 2 0 0 1-2.828 0l-4.243-4.243a8 8 0 1 1 11.314 0ZM15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
            </svg>
            <span
                class="truncate text-sm font-medium"
                :class="selectedLocation ? 'text-slate-900 font-semibold' : 'text-slate-500'"
                x-text="selectedLocation || '{{ $placeholder }}'"
            >
                {{ $inputVal ?: $placeholder }}
            </span>
        </span>

        <span class="flex items-center shrink-0 space-x-1.5">
            <!-- Clear Button when a location is active -->
            <span
                x-show="selectedLocation"
                x-cloak
                @click.stop="clearLocation()"
                title="Clear location"
                class="rounded-full p-1 text-slate-400 hover:bg-slate-200 hover:text-slate-700 transition"
            >
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </span>

            <!-- Dropdown Indicator Arrow -->
            <svg
                aria-hidden="true"
                class="h-4 w-4 text-slate-500 transition-transform duration-200"
                :class="open ? 'rotate-180 text-emerald-600' : ''"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
            </svg>
        </span>
    </button>

    <!-- Master-Detail Cascading Dropdown Panel -->
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
        class="absolute left-0 top-full z-50 mt-2 w-full sm:w-[560px] md:w-[620px] max-w-[calc(100vw-2rem)] rounded-xl border border-slate-200 bg-white shadow-2xl shadow-slate-900/15 ring-1 ring-black/5 overflow-hidden"
    >
        <!-- Panel Header -->
        <div class="flex items-center justify-between border-b border-slate-100 px-4 py-3 bg-slate-50/70">
            <div class="flex items-center space-x-2">
                <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Select Location</span>
            </div>
            <div class="flex items-center space-x-3">
                <button
                    type="button"
                    @click="clearLocation()"
                    class="text-xs font-semibold text-blue-600 hover:text-blue-800 hover:underline"
                >
                    All of Sri Lanka
                </button>
                <button
                    type="button"
                    @click="closePicker()"
                    class="rounded-lg p-1 text-slate-400 hover:bg-slate-200 hover:text-slate-700 transition"
                    aria-label="Close"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Master-Detail Two Column Layout -->
        <div class="grid grid-cols-1 sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-slate-200">
            <!-- LEFT COLUMN: All 25 Sri Lankan Districts (A-Z) -->
            <div class="flex flex-col bg-slate-50/40">
                <div class="px-3.5 pt-2.5 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    Districts (A-Z)
                </div>
                <div class="max-h-[350px] overflow-y-auto space-y-0.5 p-2 custom-scrollbar">
                    @foreach($canonicalLocations as $distName => $areasList)
                        <button
                            type="button"
                            @mouseenter="activeDistrict = '{{ $distName }}'"
                            @click="activeDistrict = '{{ $distName }}'"
                            :class="activeDistrict === '{{ $distName }}'
                                ? 'bg-emerald-600 text-white font-semibold shadow-sm'
                                : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900 font-medium'"
                            class="group flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-sm transition"
                        >
                            <span>{{ $distName }}</span>
                            <!-- Right-pointing chevron icon (▶) -->
                            <span
                                class="text-xs transition-transform"
                                :class="activeDistrict === '{{ $distName }}' ? 'text-white' : 'text-slate-400 group-hover:text-slate-600'"
                                aria-hidden="true"
                            >▶</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- RIGHT COLUMN: Local Areas (Initially Empty/Hidden until Hover/Click) -->
            <div class="flex flex-col bg-white">
                <!-- When no District is hovered/clicked yet (Empty initially) -->
                <div
                    x-show="!activeDistrict"
                    class="flex h-[350px] flex-col items-center justify-center p-6 text-center text-slate-400"
                >
                    <svg class="mb-3 h-10 w-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657 13.414 20.9a2 2 0 0 1-2.828 0l-4.243-4.243a8 8 0 1 1 11.314 0ZM15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                    <p class="text-xs font-medium text-slate-500">Hover or click any district on the left to explore its local areas.</p>
                </div>

                <!-- When a District is active/hovered -->
                @foreach($canonicalLocations as $distName => $areasList)
                    <div
                        x-show="activeDistrict === '{{ $distName }}'"
                        x-cloak
                        class="flex flex-col h-full"
                    >
                        <div class="px-3.5 pt-2.5 pb-1 text-[11px] font-bold uppercase tracking-wider text-slate-500 truncate">
                            Local Areas in {{ $distName }}
                        </div>

                        <div class="max-h-[350px] overflow-y-auto space-y-0.5 p-2 custom-scrollbar flex-1">
                            <!-- First Option: "All of [District Name]" -->
                            <button
                                type="button"
                                @click="selectLocation('{{ $distName }}')"
                                class="group flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-sm font-bold text-emerald-700 hover:bg-emerald-50 transition border border-emerald-100 mb-1.5 bg-emerald-50/50"
                                :class="selectedLocation === '{{ $distName }}' ? 'bg-emerald-100 text-emerald-900 ring-1 ring-emerald-300' : ''"
                            >
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>All of {{ $distName }}</span>
                                </span>
                                <span class="text-xs text-emerald-600 font-semibold">Select All</span>
                            </button>

                            <!-- List of Local Areas -->
                            @foreach($areasList as $area)
                                <button
                                    type="button"
                                    @click="selectLocation('{{ addslashes($area) }}')"
                                    :class="selectedLocation === '{{ addslashes($area) }}'
                                        ? 'bg-emerald-50 text-emerald-800 font-bold ring-1 ring-emerald-200'
                                        : 'text-slate-700 hover:bg-slate-50 hover:text-slate-900 font-medium'"
                                    class="flex w-full items-center justify-between rounded-lg px-3 py-1.5 text-left text-sm transition"
                                >
                                    <span>{{ $area }}</span>
                                    <span
                                        x-show="selectedLocation === '{{ addslashes($area) }}'"
                                        class="text-xs font-bold text-emerald-600"
                                    >✓</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@once
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f8fafc;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endonce
