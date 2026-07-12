<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                {{ __('Formulir Pemeriksaan Klinis') }}
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Lengkapi data rekam medis pasien dengan akurat.</p>
        </div>
        
        <!-- TomSelect CSS -->
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
        <style>
            .ts-control { border-radius: 0.75rem; border-color: #cbd5e1; padding: 0.75rem; background-color: #f8fafc; font-size: 0.875rem; }
            .ts-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 1px #3b82f6; }
            .dark .ts-control { background-color: #0f172a; border-color: #334155; color: white; }
            .dark .ts-dropdown { background-color: #0f172a; border-color: #334155; color: white; }
            .dark .ts-dropdown .option { color: white; }
            .dark .ts-dropdown .active { background-color: #1e293b; color: white; }
        </style>
        <!-- TomSelect JS -->
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    </x-slot>

    <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 sm:rounded-2xl p-6 lg:p-10" x-data="pemeriksaanTabs()">
        
        <!-- Identitas Pasien Info Box -->
        <div x-show="selectedPasien" x-transition style="display: none;" class="mb-8 p-5 bg-emerald-50 border border-emerald-100 rounded-2xl dark:bg-emerald-900/20 dark:border-emerald-800">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-start gap-4 flex-1">
                    <div class="p-3 bg-emerald-100 dark:bg-emerald-800 text-emerald-600 dark:text-emerald-300 rounded-full shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 w-full">
                        <div>
                            <p class="text-[10px] text-emerald-600/70 dark:text-emerald-400/70 font-semibold uppercase tracking-wider mb-0.5">Nama</p>
                            <p class="text-sm font-bold text-slate-800 dark:text-slate-200" x-text="selectedPasien?.nama"></p>
                        </div>
                        <div>
                            <p class="text-[10px] text-emerald-600/70 dark:text-emerald-400/70 font-semibold uppercase tracking-wider mb-0.5">Umur</p>
                            <p class="text-sm font-bold text-slate-800 dark:text-slate-200" x-text="selectedPasien?.umur"></p>
                        </div>
                        <div>
                            <p class="text-[10px] text-emerald-600/70 dark:text-emerald-400/70 font-semibold uppercase tracking-wider mb-0.5">Jenis Kelamin</p>
                            <p class="text-sm font-bold text-slate-800 dark:text-slate-200" x-text="selectedPasien?.jk"></p>
                        </div>
                        <div>
                            <p class="text-[10px] text-emerald-600/70 dark:text-emerald-400/70 font-semibold uppercase tracking-wider mb-0.5">Alamat</p>
                            <p class="text-sm font-bold text-slate-800 dark:text-slate-200 truncate" x-text="selectedPasien?.alamat" :title="selectedPasien?.alamat"></p>
                        </div>
                    </div>
                </div>
                
                <button type="button" @click="window.open(`/pasien/${selectedPasienId}`, 'RiwayatPemeriksaan', 'width=1000,height=700,scrollbars=yes,resizable=yes')" class="shrink-0 inline-flex items-center px-4 py-2 text-sm font-medium text-emerald-700 bg-white border border-emerald-300 rounded-xl hover:bg-emerald-50 focus:ring-4 focus:outline-none focus:ring-emerald-100 shadow-sm transition-colors dark:bg-slate-800 dark:text-emerald-400 dark:border-emerald-700 dark:hover:bg-slate-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Lihat Histori Pemeriksaan
                </button>
            </div>
        </div>

        <!-- Tabs Header -->
        <div class="flex space-x-2 border-b border-slate-200 dark:border-slate-700 mb-8 pb-2 overflow-x-auto">
            <button @click="step = 1" type="button" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-t-xl transition-all border-b-2 whitespace-nowrap" :class="step === 1 ? 'text-primary-600 border-primary-600 bg-primary-50 dark:bg-primary-900/30' : 'text-slate-500 border-transparent hover:text-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800'">
                <span class="flex items-center justify-center w-6 h-6 mr-2 text-xs rounded-full" :class="step === 1 ? 'bg-primary-100 text-primary-700' : 'bg-slate-100 text-slate-500'">1</span>
                Identitas
            </button>
            <button @click="step = 2" type="button" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-t-xl transition-all border-b-2 whitespace-nowrap" :class="step === 2 ? 'text-primary-600 border-primary-600 bg-primary-50 dark:bg-primary-900/30' : 'text-slate-500 border-transparent hover:text-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800'">
                <span class="flex items-center justify-center w-6 h-6 mr-2 text-xs rounded-full" :class="step === 2 ? 'bg-primary-100 text-primary-700' : 'bg-slate-100 text-slate-500'">2</span>
                Pemeriksaan
            </button>
            <button @click="step = 3" type="button" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-t-xl transition-all border-b-2 whitespace-nowrap" :class="step === 3 ? 'text-primary-600 border-primary-600 bg-primary-50 dark:bg-primary-900/30' : 'text-slate-500 border-transparent hover:text-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800'">
                <span class="flex items-center justify-center w-6 h-6 mr-2 text-xs rounded-full" :class="step === 3 ? 'bg-primary-100 text-primary-700' : 'bg-slate-100 text-slate-500'">3</span>
                Terapi
            </button>
            <button @click="step = 4" type="button" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-t-xl transition-all border-b-2 whitespace-nowrap" :class="step === 4 ? 'text-primary-600 border-primary-600 bg-primary-50 dark:bg-primary-900/30' : 'text-slate-500 border-transparent hover:text-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800'">
                <span class="flex items-center justify-center w-6 h-6 mr-2 text-xs rounded-full" :class="step === 4 ? 'bg-primary-100 text-primary-700' : 'bg-slate-100 text-slate-500'">4</span>
                Lab (Opsional)
            </button>
            <button @click="step = 5" type="button" class="flex items-center px-4 py-2.5 text-sm font-semibold rounded-t-xl transition-all border-b-2 whitespace-nowrap" :class="step === 5 ? 'text-primary-600 border-primary-600 bg-primary-50 dark:bg-primary-900/30' : 'text-slate-500 border-transparent hover:text-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800'">
                <span class="flex items-center justify-center w-6 h-6 mr-2 text-xs rounded-full" :class="step === 5 ? 'bg-primary-100 text-primary-700' : 'bg-slate-100 text-slate-500'">5</span>
                EKG (Opsional)
            </button>
        </div>

        <form action="{{ route('pemeriksaan.store') }}" method="POST" id="pemeriksaanForm" @submit.prevent="validateAndSubmit" enctype="multipart/form-data" novalidate>
            @csrf
            
            <!-- Tab 1: Pasien & Keluhan -->
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" data-tab="1">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Identitas & Keluhan</h3>
                    <p class="text-sm text-slate-500 mt-1">Pilih pasien dan catat keluhan utama saat ini.</p>
                </div>

                <div class="grid gap-6 mb-6 sm:grid-cols-2">
                    <div>
                        <label for="id_pasien" class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Pasien (NIK/Nama) <span class="text-rose-500">*</span></label>
                        <select name="id_pasien" id="id_pasien" @change="selectedPasienId = $event.target.value; selectedPasien = patientsData[$event.target.value] || null" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:placeholder-slate-400 dark:text-white" required>
                            <option value="">-- Pilih Pasien Terdaftar --</option>
                            @foreach($pasiens as $pasien)
                                <option value="{{ $pasien->id_pasien }}">{{ $pasien->nik }} - {{ $pasien->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="tanggal_pemeriksaan" class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Tanggal Pemeriksaan <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_pemeriksaan" id="tanggal_pemeriksaan" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="keluhan" class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Keluhan Utama <span class="text-rose-500">*</span></label>
                        <textarea name="keluhan" id="keluhan" rows="3" class="block p-3 w-full text-sm text-slate-900 bg-slate-50 rounded-xl border border-slate-300 focus:ring-primary-500 focus:border-primary-500 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" placeholder="Jelaskan keluhan utama pasien..." required></textarea>
                    </div>
                </div>
                <div class="flex justify-end pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button type="button" @click="step = 2" class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-xl hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 shadow-sm transition-colors">
                        Lanjut ke Pemeriksaan Fisik
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Tab 2: Pemeriksaan Fisik & Klinis -->
            <div x-show="step === 2" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" data-tab="2">
                <div class="mb-6 border-b border-slate-100 dark:border-slate-700 pb-4">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Pemeriksaan Fisik</h3>
                    <p class="text-sm text-slate-500 mt-1">Sistem akan otomatis menghitung IMT dan kategori Tekanan Darah.</p>
                </div>
                
                <div class="grid gap-6 mb-6 sm:grid-cols-3">
                    <!-- Fisik -->
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Berat Badan (kg) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.1" name="berat_badan" x-model="bb" @input="if($el.value.length > 3) { $el.value = $el.value.slice(0,3); bb = $el.value; } calculateIMT()" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Tinggi Badan (cm) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.1" name="tinggi_badan" x-model="tb" @input="if($el.value.length > 3) { $el.value = $el.value.slice(0,3); tb = $el.value; } calculateIMT()" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Lingkar Perut (cm) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.1" name="lingkar_perut" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required @input="if($el.value.length > 3) { $el.value = $el.value.slice(0,3); kolesterol = $el.value; }">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">LILA (cm) <span class="text-slate-400 font-normal">(Opsional)</span></label>
                        <input type="number" step="0.1" name="lila" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                    </div>
                    
                    <!-- IMT Alert -->
                    <div class="sm:col-span-3 flex items-center p-4 text-sm text-blue-800 rounded-xl bg-blue-50/50 border border-blue-100 dark:bg-blue-900/20 dark:text-blue-300 dark:border-blue-800/30 shadow-sm" x-show="imt > 0" x-transition>
                        <svg class="w-5 h-5 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            Indeks Massa Tubuh (IMT) pasien adalah <strong class="text-blue-600 dark:text-blue-400 text-base" x-text="imt"></strong>. Kategori: <strong class="text-blue-600 dark:text-blue-400 text-base uppercase" x-text="imtStatus"></strong>
                        </div>
                    </div>

                    <!-- Tanda Vital -->
                    <div class="sm:col-span-3 border-t border-slate-100 dark:border-slate-700 pt-4 mt-2">
                        <h4 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider mb-4">Tanda Vital</h4>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Systole (mmHg) <span class="text-rose-500">*</span></label>
                        <input type="number" name="systole" x-model="systole" @input="if($el.value.length > 3) { $el.value = $el.value.slice(0,3); systole = $el.value; } checkTensi()" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Diastole (mmHg) <span class="text-rose-500">*</span></label>
                        <input type="number" name="diastole" x-model="diastole" @input="if($el.value.length > 3) { $el.value = $el.value.slice(0,3); diastole = $el.value; } checkTensi()" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Nadi (x/mnt) <span class="text-rose-500">*</span></label>
                        <input type="number" name="nadi" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required @input="if($el.value.length > 3) { $el.value = $el.value.slice(0,3); kolesterol = $el.value; }">
                    </div>

                    <!-- Tensi Alert -->
                    <div class="sm:col-span-3 flex items-center p-4 text-sm rounded-xl shadow-sm border transition-colors" 
                         :class="tensiStatus === 'Normal' ? 'bg-emerald-50 border-emerald-100 text-emerald-800' : 'bg-rose-50 border-rose-100 text-rose-800'"
                         x-show="tensiStatus !== ''" x-transition>
                        <svg class="w-5 h-5 mr-3" :class="tensiStatus === 'Normal' ? 'text-emerald-500' : 'text-rose-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <div>
                            Kategori Tanda Vital: <strong class="text-base uppercase tracking-wide" x-text="tensiStatus"></strong>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Diagnosis Kesimpulan <span class="text-rose-500">*</span></label>
                        <select name="diagnoses[]" id="diagnoses" multiple class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                            @foreach($diagnoses as $diagnosis)
                                <option value="{{ $diagnosis->id_diagnosis }}">{{ $diagnosis->nama_diagnosis }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-slate-500 mt-1">Anda dapat memilih lebih dari satu diagnosis.</p>
                    </div>
                </div>

                <div class="flex justify-between pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button type="button" @click="step = 1" class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 focus:ring-4 focus:outline-none focus:ring-slate-100 shadow-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        Kembali
                    </button>
                    <button type="button" @click="step = 3" class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-xl hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 shadow-sm transition-colors">
                        Lanjut ke Terapi Obat
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Tab 3: Terapi Obat -->
            <div x-show="step === 3" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" data-tab="3">
                <div class="mb-6 border-b border-slate-100 dark:border-slate-700 pb-4">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Terapi Obat</h3>
                    <p class="text-sm text-slate-500 mt-1">Lengkapi data resep obat yang diberikan kepada pasien.</p>
                </div>
                
                <div class="grid gap-6 mb-6">
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <label class="block text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wide">Daftar Terapi Obat <span class="text-rose-500">*</span></label>
                            <button type="button" @click="addObat()" class="inline-flex items-center text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:outline-none focus:ring-emerald-300 font-medium rounded-lg text-xs px-4 py-2 shadow-sm transition-colors">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Obat
                            </button>
                        </div>
                        
                        <div class="space-y-3">
                            <template x-for="(obat, index) in obatList" :key="index">
                                <div class="flex flex-col sm:flex-row gap-3 sm:items-center bg-slate-50 dark:bg-slate-900/50 p-3 sm:p-2 rounded-xl border border-slate-200 dark:border-slate-700" x-transition>
                                    <select name="nama_obat[]" x-model="obat.nama" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full sm:flex-1 p-2.5 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white" required>
                                        <option value="">-- Pilih Obat --</option>
                                        @foreach($obats as $o)
                                            <option value="{{ $o->nama_obat }}">{{ $o->nama_obat }}</option>
                                        @endforeach
                                    </select>
                                    <div class="flex gap-2 items-center w-full sm:w-auto">
                                        <input type="text" name="aturan_pakai[]" x-model="obat.aturan" placeholder="Aturan (ex: 3x1)" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full sm:w-32 p-2.5 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white" required>
                                        <input type="number" name="jumlah_obat[]" x-model="obat.jumlah" placeholder="Jml" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-20 p-2.5 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white" required>
                                        <button type="button" @click="removeObat(index)" class="p-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors focus:outline-none flex-shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="mt-2">
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Catatan Khusus</label>
                        <textarea name="catatan" rows="3" class="block p-3 w-full text-sm text-slate-900 bg-slate-50 rounded-xl border border-slate-300 focus:ring-primary-500 focus:border-primary-500 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white"></textarea>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between pt-4 border-t border-slate-100 dark:border-slate-700 gap-3">
                    <button type="button" @click="step = 2" class="inline-flex justify-center items-center px-6 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 focus:ring-4 focus:outline-none focus:ring-slate-100 shadow-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        Kembali
                    </button>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="inline-flex justify-center items-center px-6 py-2.5 text-sm font-bold text-slate-700 bg-slate-200 rounded-xl hover:bg-slate-300 focus:ring-4 focus:outline-none focus:ring-slate-300 shadow-sm transition-all hover:scale-[1.02]">
                            Simpan (Lewati Lab)
                        </button>
                        <button type="button" @click="step = 4" class="inline-flex justify-center items-center px-6 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-xl hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 shadow-sm transition-colors">
                            Lanjut ke Lab (Opsional)
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tab 4: Laboratorium -->
            <div x-show="step === 4" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" data-tab="4">
                <div class="mb-6 border-b border-slate-100 dark:border-slate-700 pb-4">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Laboratorium (Opsional)</h3>
                    <p class="text-sm text-slate-500 mt-1">Lengkapi data hasil laboratorium pasien jika tersedia.</p>
                </div>
                
                <div class="grid gap-6 mb-6 sm:grid-cols-2 p-5 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Gula Darah Puasa (GDP) (mg/dL)</label>
                        <input type="number" step="0.01" name="gula_darah_puasa" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white" @input="if($el.value.length > 3) { $el.value = $el.value.slice(0,3); kolesterol = $el.value; }">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Gula Darah Sewaktu (GDS) (mg/dL)</label>
                        <input type="number" step="0.01" name="gula_darah_sewaktu" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white" @input="if($el.value.length > 3) { $el.value = $el.value.slice(0,3); kolesterol = $el.value; }">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Kolesterol Total (mg/dL)</label>
                        <input type="number" step="0.01" name="kolesterol_total" x-model="kolesterol" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white" @input="if($el.value.length > 3) { $el.value = $el.value.slice(0,3); kolesterol = $el.value; }">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Kategori Kolesterol</label>
                        <div class="bg-slate-100 border border-slate-200 text-slate-600 text-sm rounded-xl block w-full p-3 shadow-sm font-semibold dark:bg-slate-800 dark:border-slate-700 dark:text-slate-300 select-none cursor-not-allowed" x-text="kolesterolStatus || '-- Auto Kalkulasi --'">
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Asam Urat (mg/dL)</label>
                        <input type="number" step="0.01" name="asam_urat" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white" @input="if($el.value.length > 3) { $el.value = $el.value.slice(0,3); kolesterol = $el.value; }">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">HBA1C (%)</label>
                        <input type="number" step="0.01" name="hba1c" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Ureum (mg/dL)</label>
                        <input type="number" step="0.01" name="ureum" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Kreatinin (mg/dL)</label>
                        <input type="number" step="0.01" name="kreatinin" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">eGFR (mL/min/1.73m²)</label>
                        <input type="number" step="0.01" name="egfr" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">HDL (mg/dL)</label>
                        <input type="number" step="0.01" name="hdl" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">LDL (mg/dL)</label>
                        <input type="number" step="0.01" name="ldl" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Trigliserida (mg/dL)</label>
                        <input type="number" step="0.01" name="trigliserida" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Rasio Kol/HDL</label>
                        <input type="number" step="0.01" name="rasio_kolesterol_hdl" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">SGPT (U/L)</label>
                        <input type="number" step="0.01" name="sgpt" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Mikroalbumin Kuantitatif (mg/L)</label>
                        <input type="number" step="0.01" name="mikroalbumin_kuantitatif" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                    </div>
                    <div class="sm:col-span-2 mt-2 border-t border-slate-200 dark:border-slate-700 pt-4">
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Upload Dokumen Hasil Lab (PDF/JPG/PNG)</label>
                        <input type="file" name="dokumen_lab" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 border border-slate-300 rounded-xl bg-white dark:bg-slate-800 dark:border-slate-600 dark:file:bg-primary-900/30 dark:file:text-primary-400">
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row justify-between pt-4 border-t border-slate-100 dark:border-slate-700 gap-3">
                    <button type="button" @click="step = 3" class="inline-flex justify-center items-center px-6 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 focus:ring-4 focus:outline-none focus:ring-slate-100 shadow-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        Kembali
                    </button>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="inline-flex justify-center items-center px-6 py-2.5 text-sm font-bold text-slate-700 bg-slate-200 rounded-xl hover:bg-slate-300 focus:ring-4 focus:outline-none focus:ring-slate-300 shadow-sm transition-all hover:scale-[1.02]">
                            Simpan (Lewati EKG)
                        </button>
                        <button type="button" @click="step = 5" class="inline-flex justify-center items-center px-6 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-xl hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 shadow-sm transition-colors">
                            Lanjut ke EKG (Opsional)
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tab 5: EKG -->
            <div x-show="step === 5" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" data-tab="5">
                <div class="mb-6 border-b border-slate-100 dark:border-slate-700 pb-4">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">EKG (Opsional)</h3>
                    <p class="text-sm text-slate-500 mt-1">Lengkapi data hasil EKG dan prediksi risiko penyakit kardiovaskular pasien jika tersedia.</p>
                </div>
                
                <div class="grid gap-6 mb-6 sm:grid-cols-2 p-5 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700">
                    <div class="sm:col-span-2">
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Hasil EKG (Deskriptif)</label>
                        <textarea name="hasil_ekg" rows="3" class="block p-3 w-full text-sm text-slate-900 bg-white rounded-xl border border-slate-300 focus:ring-primary-500 focus:border-primary-500 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white" placeholder="Jelaskan hasil EKG..."></textarea>
                    </div>
                    
                    <div class="sm:col-span-2">
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Prediksi Risiko Penyakit Kardiovaskular</label>
                        <select name="prediksi_risiko_kardiovaskular" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-800 dark:border-slate-600 dark:text-white">
                            <option value="">-- Pilih Risiko --</option>
                            <option value="< 5 %" class="text-emerald-600 font-semibold">&lt; 5 % (Hijau)</option>
                            <option value="5 - < 10 %" class="text-yellow-500 font-semibold">5 - &lt; 10 % (Kuning)</option>
                            <option value="10 - < 20 %" class="text-orange-500 font-semibold">10 - &lt; 20 % (Orange)</option>
                            <option value="20 - < 30 %" class="text-rose-500 font-semibold">20 - &lt; 30 % (Merah)</option>
                            <option value="> 30 %" class="text-rose-800 font-semibold">&gt; 30 % (Merah Tua / Maroon)</option>
                        </select>
                    </div>
                    
                    <div class="sm:col-span-2 mt-2 border-t border-slate-200 dark:border-slate-700 pt-4">
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Upload Dokumen Hasil EKG (PDF/JPG/PNG)</label>
                        <input type="file" name="dokumen_ekg" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 border border-slate-300 rounded-xl bg-white dark:bg-slate-800 dark:border-slate-600 dark:file:bg-primary-900/30 dark:file:text-primary-400">
                    </div>
                </div>

                <div class="flex justify-between pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button type="button" @click="step = 4" class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 focus:ring-4 focus:outline-none focus:ring-slate-100 shadow-sm transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        Kembali
                    </button>
                    <button type="submit" class="inline-flex items-center px-6 py-2.5 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 focus:ring-4 focus:outline-none focus:ring-emerald-300 shadow-sm transition-all hover:scale-[1.02]">
                        Simpan Data Rekam Medis
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </div>
            </div>

        </form>
    </div>

    <script>
        const patientsData = {
            @foreach($pasiens as $pasien)
            "{{ $pasien->id_pasien }}": {
                nama: `{!! addslashes($pasien->nama_lengkap) !!}`,
                umur: `{{ $pasien->umur }} Tahun`,
                jk: `{{ $pasien->jenis_kelamin }}`,
                alamat: `{!! addslashes($pasien->dukuhM->nama_dukuh ?? '-') !!}, {!! addslashes($pasien->kelurahan->nama_kelurahan ?? '-') !!}`
            },
            @endforeach
        };

        function pemeriksaanTabs() {
            return {
                step: 1,
                selectedPasienId: '{{ request("id_pasien") }}',
                selectedPasien: null,
                init() {
                    if (this.selectedPasienId) {
                        this.selectedPasien = patientsData[this.selectedPasienId] || null;
                    }
                    setTimeout(() => {
                        new TomSelect('#diagnoses', {
                            plugins: ['remove_button'],
                            placeholder: 'Pilih satu atau lebih diagnosis...',
                            maxItems: null
                        });
                    }, 100);
                },
                showLab: false,
                bb: '',
                tb: '',
                imt: 0,
                imtStatus: '',
                systole: '',
                diastole: '',
                tensiStatus: '',
                kolesterol: '',
                obatList: [
                    {nama: '', aturan: '', jumlah: ''}
                ],
                get kolesterolStatus() {
                    if (!this.kolesterol) return '';
                    const val = parseFloat(this.kolesterol);
                    if (val < 200) return 'Normal';
                    if (val <= 239) return 'Batas Tinggi (Borderline)';
                    return 'Tinggi';
                },
                validateAndSubmit(e) {
                    let form = document.getElementById('pemeriksaanForm');
                    
                    // Clear previous error styles
                    let allInputs = form.querySelectorAll('[required]');
                    allInputs.forEach(input => input.classList.remove('border-rose-500', 'bg-rose-50'));

                    // Find first invalid field
                    let invalidField = null;
                    for (let i = 0; i < allInputs.length; i++) {
                        if (!allInputs[i].value) {
                            invalidField = allInputs[i];
                            break;
                        }
                    }

                    if (invalidField) {
                        e.preventDefault(); // Stop submission
                        
                        // Find which tab this field belongs to
                        let tabContainer = invalidField.closest('[data-tab]');
                        if (tabContainer) {
                            let tabNum = parseInt(tabContainer.getAttribute('data-tab'));
                            this.step = tabNum; // Jump to that tab
                            
                            // Slight delay to allow tab to render before focusing
                            setTimeout(() => {
                                invalidField.classList.add('border-rose-500', 'bg-rose-50');
                                invalidField.focus();
                            }, 50);
                        }
                    } else {
                        // Submit form normally
                        form.submit();
                    }
                },

                calculateIMT() {
                    if (this.tb > 0 && this.bb > 0) {
                        let tbM = this.tb / 100;
                        this.imt = (this.bb / (tbM * tbM)).toFixed(2);
                        
                        if (this.imt < 17.0) this.imtStatus = 'Sangat Kurus';
                        else if (this.imt <= 18.4) this.imtStatus = 'Kurus';
                        else if (this.imt <= 25.0) this.imtStatus = 'Normal (Ideal)';
                        else if (this.imt <= 27.0) this.imtStatus = 'Gemuk (Overweight)';
                        else this.imtStatus = 'Obesitas';
                    } else {
                        this.imt = 0;
                        this.imtStatus = '';
                    }
                },
                checkTensi() {
                    if (this.systole > 0 && this.diastole > 0) {
                        let s = parseInt(this.systole);
                        let d = parseInt(this.diastole);
                        
                        if (s >= 160 || d >= 100) this.tensiStatus = 'Hipertensi Derajat 2';
                        else if (s >= 140 || d >= 90) this.tensiStatus = 'Hipertensi Derajat 1';
                        else if (s >= 120 || d >= 80) this.tensiStatus = 'Pra-Hipertensi';
                        else if (s < 90 || d < 60) this.tensiStatus = 'Hipotensi';
                        else this.tensiStatus = 'Normal';
                    } else {
                        this.tensiStatus = '';
                    }
                },
                addObat() {
                    this.obatList.push({nama: '', aturan: '', jumlah: ''});
                },
                removeObat(index) {
                    if (this.obatList.length > 1) {
                        this.obatList.splice(index, 1);
                    } else {
                        alert('Minimal harus ada 1 jenis obat yang diresepkan (wajib).');
                    }
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            let tom = new TomSelect('#id_pasien',{
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: '-- Cari Pasien Terdaftar --'
            });

            tom.on('change', function(value) {
                // Dispatch native change event so Alpine.js @change can catch it
                document.getElementById('id_pasien').dispatchEvent(new Event('change'));
            });
        });
    </script>
</x-app-layout>
