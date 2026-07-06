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
                    <input type="date" name="tanggal_awal" value="{{ date('Y-m-01') }}" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                </div>

                <!-- Filter Tanggal Akhir -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" value="{{ date('Y-m-t') }}" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white">
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

                <!-- Filter Kalurahan -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Kalurahan</label>
                    <select name="kalurahan" id="kalurahan" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                        <option value="">-- Semua Kalurahan --</option>
                        @if(isset($kelurahans))
                            @foreach($kelurahans as $kel)
                                <option value="{{ $kel->nama_kelurahan }}">{{ $kel->nama_kelurahan }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <!-- Filter Puskesmas (Hanya untuk Admin Dinkes) -->
                @if(auth()->user()->role === 'admin_dinkes')
                <div class="lg:col-span-3">
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
                <button type="button" onclick="fetchData()" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white bg-slate-800 rounded-xl hover:bg-slate-900 shadow-md transition-all hover:scale-[1.02] dark:bg-primary-600 dark:hover:bg-primary-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Tampilkan Data
                </button>

                <button type="submit" formaction="{{ route('laporan.export.csv') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 hover:text-slate-900 shadow-sm transition-all">
                    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Unduh CSV/Excel
                </button>
                
                <button type="submit" formtarget="_blank" formaction="{{ route('laporan.export.pdf') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 shadow-md transition-all hover:scale-[1.02]">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Unduh & Cetak PDF
                </button>
            </div>
        </form>

    </div>

    <!-- Tabel Preview -->
    <div class="mt-8 bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 sm:rounded-2xl p-6 lg:p-8">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Pratinjau Data Laporan</h3>
            <span id="data-count" class="text-sm font-medium text-slate-500 bg-slate-100 dark:bg-slate-700 px-3 py-1 rounded-full">0 Data Ditemukan</span>
        </div>
        
        <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700">
            <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-slate-700/50 dark:text-slate-400">
                    <tr>
                        <th scope="col" class="px-6 py-4 whitespace-nowrap">Tanggal</th>
                        <th scope="col" class="px-6 py-4 whitespace-nowrap">NIK / Pasien</th>
                        <th scope="col" class="px-6 py-4 whitespace-nowrap">Domisili</th>
                        <th scope="col" class="px-6 py-4 whitespace-nowrap">Tensi & IMT</th>
                        <th scope="col" class="px-6 py-4 min-w-[200px]">Diagnosis & Terapi</th>
                    </tr>
                </thead>
                <tbody id="table-body" class="divide-y divide-slate-200 dark:divide-slate-700">
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-10 h-10 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p>Klik "Tampilkan Data" untuk memuat pratinjau data.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

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
            @if(auth()->user()->role === 'admin_dinkes')
            new TomSelect('#id_puskesmas',{
                create: false,
                allowEmptyOption: true,
                sortField: { field: "text", direction: "asc" }
            });
            @endif

            const puskesmasSelect = document.getElementById('id_puskesmas');
            const kelurahanSelect = document.getElementById('kalurahan');

            if (puskesmasSelect && kelurahanSelect) {
                puskesmasSelect.addEventListener('change', function() {
                    const id = this.value;
                    kelurahanSelect.innerHTML = '<option value="">-- Memuat --</option>';
                    
                    const fetchUrl = id ? `/puskesmas/${id}/kelurahans` : `/kelurahans`;
                    
                    fetch(fetchUrl)
                        .then(res => res.json())
                        .then(data => {
                            kelurahanSelect.innerHTML = '<option value="">-- Semua Kalurahan --</option>';
                            data.forEach(kel => {
                                const option = document.createElement('option');
                                option.value = kel.nama_kelurahan;
                                option.textContent = kel.nama_kelurahan;
                                kelurahanSelect.appendChild(option);
                            });
                        });
                });
            }
        });

        function fetchData() {
            const form = document.getElementById('form-laporan');
            const formData = new FormData(form);
            const tbody = document.getElementById('table-body');
            const dataCount = document.getElementById('data-count');
            
            // Show loading
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="animate-spin w-8 h-8 text-primary-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <p>Memuat data pemeriksaan...</p>
                        </div>
                    </td>
                </tr>
            `;
            dataCount.textContent = 'Memuat...';

            fetch('{{ route("laporan.preview") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                dataCount.textContent = `${data.length} Data Ditemukan`;
                
                if(data.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p>Tidak ada data yang cocok dengan filter pencarian.</p>
                                </div>
                            </td>
                        </tr>
                    `;
                    return;
                }

                tbody.innerHTML = '';
                data.forEach(item => {
                    tbody.innerHTML += `
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-slate-900 dark:text-white font-medium">${item.tanggal_pemeriksaan}</span><br>
                                <span class="text-xs text-slate-500">${item.petugas}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-slate-900 dark:text-white font-semibold">${item.nama_pasien}</span><br>
                                <span class="text-xs text-slate-500">${item.nik} | ${item.usia} Thn</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-slate-700 dark:text-slate-300">${item.kalurahan}</span><br>
                                <span class="text-xs text-slate-500">${item.puskesmas}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm">TD: <span class="font-semibold text-slate-900 dark:text-white">${item.tensi}</span> (${item.kategori_tensi})</span><br>
                                <span class="text-sm">IMT: <span class="font-semibold text-slate-900 dark:text-white">${item.imt}</span> (${item.status_imt})</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm mb-1"><span class="font-medium text-slate-700 dark:text-slate-300">Dx:</span> ${item.diagnosis || '-'}</div>
                                <div class="text-sm"><span class="font-medium text-slate-700 dark:text-slate-300">Rx:</span> <span class="text-emerald-600 dark:text-emerald-400">${item.obat || '-'}</span></div>
                            </td>
                        </tr>
                    `;
                });
            })
            .catch(error => {
                console.error('Error:', error);
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-rose-500">
                            Terjadi kesalahan saat memuat data. Silakan coba lagi.
                        </td>
                    </tr>
                `;
            });
        }
    </script>
</x-app-layout>
