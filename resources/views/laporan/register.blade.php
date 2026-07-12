<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between w-full">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                    {{ __('Laporan') }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Saring data pemeriksaan dan unduh laporan untuk analisis lanjutan.</p>
            </div>
        </div>
    </x-slot>

    <div class="mb-6 bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 sm:rounded-2xl px-6 lg:px-8 print:hidden">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <a href="{{ route('laporan.index') }}" class="border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 dark:text-slate-400 dark:hover:text-slate-300 dark:hover:border-slate-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Laporan Bulanan
            </a>
            <a href="{{ route('laporan.register') }}" class="border-primary-500 text-primary-600 dark:text-primary-400 whitespace-nowrap py-4 px-1 border-b-2 font-semibold text-sm">
                Laporan Tahunan (Buku Register)
            </a>
        </nav>
    </div>

    <!-- Filter form -->
    <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 sm:rounded-2xl p-6 lg:p-8 mb-8 print:hidden">
        <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-6">Filter Pencarian Data</h3>
        <form method="GET" action="{{ route('laporan.register') }}">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @if(auth()->user()->role === 'admin_dinkes')
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Puskesmas</label>
                    <select name="id_puskesmas" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white" onchange="this.form.submit()">
                        <option value="">Semua Puskesmas</option>
                        @foreach($puskesmas as $p)
                            <option value="{{ $p->id_puskesmas }}" {{ request('id_puskesmas') == $p->id_puskesmas ? 'selected' : '' }}>{{ $p->nama_puskesmas }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Kalurahan</label>
                    <select name="id_kelurahan" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white" onchange="this.form.submit()">
                        <option value="">Semua Kalurahan</option>
                        @foreach($kelurahans as $k)
                            <option value="{{ $k->id_kelurahan }}" {{ request('id_kelurahan') == $k->id_kelurahan ? 'selected' : '' }}>{{ $k->nama_kelurahan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Tahun</label>
                    <select name="tahun" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white" onchange="this.form.submit()">
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center gap-4 pt-6 border-t border-slate-100 dark:border-slate-700">
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white bg-slate-800 rounded-xl hover:bg-slate-900 shadow-md transition-all hover:scale-[1.02] dark:bg-primary-600 dark:hover:bg-primary-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Tampilkan Data
                </button>

                <button type="button" onclick="exportTableToExcel('buku_register_{{ $tahun }}.xls')" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 hover:text-slate-900 shadow-sm transition-all">
                    <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Unduh Excel
                </button>
                
                <button type="button" onclick="window.print()" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 shadow-md transition-all hover:scale-[1.02]">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Unduh & Cetak PDF
                </button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 sm:rounded-2xl mb-8">
        <div class="p-6 lg:p-8">
            
            <style>
                .register-table th, .register-table td {
                    border: 1px solid #e2e8f0;
                    padding: 0.5rem;
                    vertical-align: top;
                }
                .register-table th {
                    background-color: #f8fafc;
                    text-align: center;
                    font-weight: 600;
                }
                .dark .register-table th {
                    background-color: #1e293b;
                    border-color: #334155;
                }
                .dark .register-table td {
                    border-color: #334155;
                }
                
                /* Styling the cell grid inside month */
                .cell-grid {
                    display: grid;
                    grid-template-columns: 35px 1fr;
                    grid-template-rows: auto auto auto auto auto;
                    gap: 2px;
                    font-size: 0.75rem;
                    line-height: 1.1;
                }
                .tgl-box {
                    grid-column: 1 / -1;
                    font-weight: bold;
                    border-bottom: 1px dashed #cbd5e1;
                    margin-bottom: 2px;
                    padding-bottom: 2px;
                }
                .dark .tgl-box {
                    border-bottom-color: #475569;
                }
                .meas-col {
                    grid-column: 1;
                    color: #475569;
                }
                .dark .meas-col {
                    color: #94a3b8;
                }
                .val-col {
                    grid-column: 2;
                }
                .s-tx-col {
                    grid-column: 1 / -1;
                    margin-top: 4px;
                }
                @media print {
                    body * { visibility: hidden; }
                    #printable-area, #printable-area * { visibility: visible; }
                    #printable-area { position: absolute; left: 0; top: 0; width: 100%; }
                    @page { size: landscape; margin: 5mm; }
                    .register-table { font-size: 8pt; width: 100%; }
                    .register-table th, .register-table td { padding: 2px; }
                    .cell-grid { font-size: 7pt; }
                    .sticky { position: static !important; }
                }
            </style>

            <div id="printable-area" class="overflow-x-auto">
                <h2 class="text-center font-bold text-lg mb-2 hidden print:block">REGISTER PESERTA GERDU PANDANG</h2>
                <h3 class="text-center font-bold text-md mb-4 hidden print:block">TAHUN {{ $tahun }}</h3>
                <table class="register-table w-full text-left whitespace-nowrap" style="min-width: 1500px;">
                    <thead>
                        <tr>
                            <th class="w-10 sticky left-0 z-10 bg-slate-50 dark:bg-slate-700">No</th>
                            <th class="w-48 sticky left-10 z-10 bg-slate-50 dark:bg-slate-700">Nama Pasien<br><span class="text-xs font-normal">(Umur - L/P)</span></th>
                            @php
                                $months = ['JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'];
                            @endphp
                            @foreach($months as $m)
                                <th class="w-40">{{ $m }} {{ $tahun }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pasiens as $index => $pasien)
                        <tr>
                            <td class="sticky left-0 z-10 bg-white dark:bg-slate-800 text-center">{{ $index + 1 }}</td>
                            <td class="sticky left-10 z-10 bg-white dark:bg-slate-800 whitespace-normal">
                                <div class="font-bold text-slate-800 dark:text-slate-100">{{ $pasien->nama_lengkap }}</div>
                                <div class="text-xs text-slate-500">({{ $pasien->umur }} thn - {{ $pasien->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }})</div>
                            </td>
                            
                            @for($i = 1; $i <= 12; $i++)
                                <td>
                                    @php
                                        // Get pemeriksaan for this month
                                        $pemeriksaansBulanIni = $pasien->pemeriksaans->filter(function($pem) use ($i) {
                                            return $pem->tanggal_pemeriksaan->month == $i;
                                        });
                                        // We take the latest or just the first if there are multiple
                                        $pem = $pemeriksaansBulanIni->last();
                                    @endphp

                                    @if($pem)
                                    <div class="cell-grid whitespace-normal break-words">
                                        <div class="tgl-box">Tgl: {{ $pem->tanggal_pemeriksaan->format('d') }}</div>
                                        
                                        <div class="meas-col">BB:</div>
                                        <div class="val-col">{{ $pem->berat_badan ?? '-' }}</div>
                                        
                                        <div class="meas-col">TB:</div>
                                        <div class="val-col">{{ $pem->tinggi_badan ?? '-' }}</div>
                                        
                                        <div class="meas-col">LP:</div>
                                        <div class="val-col">{{ $pem->lingkar_perut ?? '-' }}</div>
                                        
                                        <div class="meas-col">TD:</div>
                                        <div class="val-col">{{ $pem->systole ?? '-' }}/{{ $pem->diastole ?? '-' }}</div>
                                        
                                        <div class="meas-col">N:</div>
                                        <div class="val-col">{{ $pem->nadi ?? '-' }}</div>
                                        
                                        <div class="s-tx-col">
                                            <span class="font-bold text-slate-700 dark:text-slate-300">S:</span> {{ $pem->keluhan ?? '-' }}
                                        </div>
                                        
                                        <div class="s-tx-col">
                                            <span class="font-bold text-slate-700 dark:text-slate-300">Tx:</span>
                                            @if($pem->terapiObats && $pem->terapiObats->count() > 0)
                                                <ul class="pl-3 list-disc">
                                                @foreach($pem->terapiObats as $obat)
                                                    <li>{{ $obat->nama_obat }} {{ $obat->aturan_pakai ? '('.$obat->aturan_pakai.')' : '' }}</li>
                                                @endforeach
                                                </ul>
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                        @endforeach
                        @if($pasiens->count() == 0)
                        <tr>
                            <td colspan="14" class="text-center py-4">Tidak ada data pasien</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
    function exportTableToExcel(filename) {
        var table = document.querySelector(".register-table");
        var clone = table.cloneNode(true);
        
        // Convert the CSS grid elements into something Excel understands (like br tags)
        var cellGrids = clone.querySelectorAll('.cell-grid');
        cellGrids.forEach(function(grid) {
            // Since Excel ignores CSS Grid, we convert inner text to use newlines
            var text = grid.innerText;
            // Replace newlines with <br> for Excel
            grid.innerHTML = text.replace(/(\r\n|\n|\r)/gm, "<br>");
        });

        var html = clone.outerHTML;
        
        // Add meta tag to tell Excel it's utf-8
        var url = 'data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(
            '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta charset="UTF-8"><style>table, td, th { border: 1px solid black; }</style></head><body>' + html + '</body></html>'
        );
        
        var downloadLink = document.createElement("a");
        downloadLink.href = url;
        downloadLink.download = filename;
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
    </script>
</x-app-layout>
