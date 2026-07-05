<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                {{ __('Laporan & Ekspor Data') }}
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Saring data pemeriksaan dan unduh laporan untuk analisis lanjutan.</p>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 sm:rounded-2xl p-6 lg:p-8">
        
        <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-6">Filter Pencarian Data</h3>
        
        <form method="POST" id="form-laporan">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Filter Tanggal Awal -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                </div>

                <!-- Filter Tanggal Akhir -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                </div>

                <!-- Filter Tensi -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Kategori Tensi</label>
                    <select name="kategori_tensi" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                        <option value="">-- Semua Kategori --</option>
                        <option value="Normal">Normal</option>
                        <option value="Prehipertensi">Prehipertensi</option>
                        <option value="Hipertensi Derajat 1">Hipertensi Derajat 1</option>
                        <option value="Hipertensi Derajat 2">Hipertensi Derajat 2</option>
                    </select>
                </div>

                <!-- Filter IMT -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Status IMT</label>
                    <select name="status_imt" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                        <option value="">-- Semua Status --</option>
                        <option value="Kurus">Kurus</option>
                        <option value="Normal">Normal</option>
                        <option value="Overweight">Overweight</option>
                        <option value="Obesitas">Obesitas</option>
                    </select>
                </div>
                
                <!-- Filter Puskesmas (Hanya untuk Admin Dinkes) -->
                @if(auth()->user()->role === 'admin_dinkes')
                <div class="lg:col-span-2">
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Asal Puskesmas</label>
                    <select name="id_puskesmas" id="id_puskesmas" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                        <option value="">-- Seluruh Wilayah (Semua Puskesmas) --</option>
                        @foreach($puskesmas as $p)
                            <option value="{{ $p->id_puskesmas }}">{{ $p->nama_puskesmas }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center gap-4 pt-6 border-t border-slate-100 dark:border-slate-700">
                <button type="submit" formaction="{{ route('laporan.export.csv') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 hover:text-slate-900 shadow-sm transition-all">
                    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Unduh CSV/Excel
                </button>
                
                <button type="submit" formaction="{{ route('laporan.export.pdf') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 shadow-md transition-all hover:scale-[1.02]">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Unduh & Cetak PDF
                </button>
            </div>
        </form>

    </div>

    @if(auth()->user()->role === 'admin_dinkes')
    <!-- TomSelect CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ts-control { border-radius: 0.75rem; border-color: #cbd5e1; padding: 0.75rem; background-color: #f8fafc; font-size: 0.875rem; }
        .ts-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 1px #3b82f6; }
        .dark .ts-control { background-color: #0f172a; border-color: #334155; color: white; }
        .dark .ts-dropdown { background-color: #0f172a; border-color: #334155; color: white; }
        .dark .ts-dropdown .option { color: white; }
        .dark .ts-dropdown .active { background-color: #1e293b; color: white; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect('#id_puskesmas',{
                create: false,
                sortField: { field: "text", direction: "asc" }
            });
        });
    </script>
    @endif
</x-app-layout>
