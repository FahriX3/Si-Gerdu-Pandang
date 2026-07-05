<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight flex items-center gap-3">
                    <a href="{{ route('pemeriksaan.index') }}" class="p-1.5 bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    Detail Pemeriksaan Klinis
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 ml-11">Data rekam medis pasien yang tercatat di sistem.</p>
            </div>
            <div class="flex gap-3">
                <!-- Action Buttons -->
                <a href="{{ route('pemeriksaan.print', $pemeriksaan->id_pemeriksaan) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-xl font-semibold text-xs text-slate-700 dark:text-slate-300 uppercase tracking-widest shadow-sm hover:bg-slate-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Rekam Medis
                </a>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Info Pasien & Pemeriksa -->
        <div class="space-y-6 lg:col-span-1">
            <!-- Kartu Pasien -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="p-5 bg-gradient-to-br from-primary-500 to-primary-700">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center border-2 border-white/30 text-white font-bold text-2xl">
                            {{ substr($pemeriksaan->pasien->nama_lengkap ?? 'A', 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-lg leading-tight">{{ $pemeriksaan->pasien->nama_lengkap ?? 'Data Terhapus' }}</h3>
                            <p class="text-primary-100 text-sm opacity-90 mt-0.5">{{ $pemeriksaan->pasien->nik ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Status Kepesertaan</span>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> {{ $pemeriksaan->pasien->status_peserta ?? 'Aktif' }}
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Usia</span>
                            <span class="text-sm font-medium text-slate-900 dark:text-white">{{ $pemeriksaan->pasien->umur ?? '-' }} Tahun</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Kelamin</span>
                            <span class="text-sm font-medium text-slate-900 dark:text-white">{{ $pemeriksaan->pasien->jenis_kelamin ?? '-' }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Domisili</span>
                        <span class="text-sm font-medium text-slate-900 dark:text-white">{{ $pemeriksaan->pasien->kalurahan ?? '-' }}</span>
                    </div>
                </div>
                <div class="p-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-700 text-center">
                    <a href="{{ route('pasien.show', $pemeriksaan->id_pasien) }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700 transition-colors">
                        Lihat Profil Lengkap Pasien &rarr;
                    </a>
                </div>
            </div>

            <!-- Detail Pemeriksaan (Metadata) -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="p-5 border-b border-slate-100 dark:border-slate-700 flex items-center gap-3">
                    <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg text-blue-600 dark:text-blue-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white">Metadata Pemeriksaan</h3>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tanggal Pemeriksaan</span>
                        <span class="text-sm font-medium text-slate-900 dark:text-white">{{ $pemeriksaan->tanggal_pemeriksaan->format('d F Y') }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tempat Pelayanan</span>
                        <span class="text-sm font-medium text-slate-900 dark:text-white">{{ $pemeriksaan->tempat_pemeriksaan }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Petugas Medis</span>
                        <span class="text-sm font-medium text-slate-900 dark:text-white flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-500 flex items-center justify-center text-xs font-bold">{{ substr($pemeriksaan->pemeriksa->name ?? 'S', 0, 1) }}</span>
                            {{ $pemeriksaan->pemeriksa->name ?? 'Sistem' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Hasil Klinis & Terapi -->
        <div class="space-y-6 lg:col-span-2">
            
            <!-- Diagnosa & Tensi -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row gap-6 justify-between items-start sm:items-center">
                        <div class="flex-1">
                            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Kesimpulan Diagnosis</h3>
                            @if($pemeriksaan->diagnosis === 'HT terkontrol')
                                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800/50 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    HIPERTENSI TERKONTROL
                                </div>
                            @else
                                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-900/20 dark:text-rose-400 dark:border-rose-800/50 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    HIPERTENSI TIDAK TERKONTROL
                                </div>
                            @endif
                        </div>
                        
                        <div class="bg-slate-50 dark:bg-slate-900/50 p-4 rounded-xl border border-slate-100 dark:border-slate-700 text-center w-full sm:w-48">
                            <span class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Tekanan Darah</span>
                            <div class="text-3xl font-black text-slate-900 dark:text-white">
                                {{ $pemeriksaan->systole }}<span class="text-slate-400 text-xl font-normal">/</span>{{ $pemeriksaan->diastole }}
                            </div>
                            <span class="block mt-1 text-[11px] font-bold uppercase tracking-wide {{ 
                                $pemeriksaan->kategori_tensi == 'Normal' ? 'text-emerald-500' : 
                                ($pemeriksaan->kategori_tensi == 'Prehipertensi' ? 'text-yellow-500' : 'text-rose-500')
                            }}">{{ $pemeriksaan->kategori_tensi }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pemeriksaan Fisik & Lab -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="p-5 border-b border-slate-100 dark:border-slate-700 flex items-center gap-3">
                    <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg text-indigo-600 dark:text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white">Hasil Pemeriksaan Klinis</h3>
                </div>
                
                <div class="p-6">
                    <div class="mb-6">
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Keluhan Utama</span>
                        <div class="p-4 bg-yellow-50/50 dark:bg-yellow-900/10 border-l-4 border-yellow-400 rounded-r-xl text-slate-700 dark:text-slate-300">
                            {{ $pemeriksaan->keluhan }}
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mb-6">
                        <div>
                            <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Berat Badan</span>
                            <span class="text-base font-bold text-slate-900 dark:text-white">{{ $pemeriksaan->berat_badan }} <span class="text-sm font-normal text-slate-500">kg</span></span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Tinggi Badan</span>
                            <span class="text-base font-bold text-slate-900 dark:text-white">{{ $pemeriksaan->tinggi_badan }} <span class="text-sm font-normal text-slate-500">cm</span></span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Lingkar Perut</span>
                            <span class="text-base font-bold text-slate-900 dark:text-white">{{ $pemeriksaan->lingkar_perut }} <span class="text-sm font-normal text-slate-500">cm</span></span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Nadi</span>
                            <span class="text-base font-bold text-slate-900 dark:text-white">{{ $pemeriksaan->nadi }} <span class="text-sm font-normal text-slate-500">x/mnt</span></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 pt-6 border-t border-slate-100 dark:border-slate-700">
                        <div>
                            <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">IMT</span>
                            <span class="text-base font-bold text-slate-900 dark:text-white">{{ $pemeriksaan->imt }}</span>
                            <span class="block text-[11px] font-medium text-slate-500">{{ $pemeriksaan->status_imt }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">GDS</span>
                            <span class="text-base font-bold text-slate-900 dark:text-white">{{ $pemeriksaan->gula_darah_sewaktu ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Kolesterol</span>
                            <span class="text-base font-bold text-slate-900 dark:text-white">{{ $pemeriksaan->kolesterol_total ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Dokumen Lab</span>
                            @if($pemeriksaan->dokumen_lab)
                                <a href="{{ asset('storage/' . $pemeriksaan->dokumen_lab) }}" target="_blank" class="inline-flex items-center text-sm font-bold text-primary-600 hover:text-primary-700">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    Lihat File
                                </a>
                            @else
                                <span class="text-sm font-medium text-slate-400">-</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Terapi Obat -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="p-5 border-b border-slate-100 dark:border-slate-700 flex items-center gap-3">
                    <div class="p-2 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg text-emerald-600 dark:text-emerald-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white">Daftar Terapi & Resep Obat</h3>
                </div>
                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                            <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-700">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-semibold w-12">No</th>
                                    <th scope="col" class="px-6 py-4 font-semibold">Nama Obat</th>
                                    <th scope="col" class="px-6 py-4 font-semibold">Aturan Pakai</th>
                                    <th scope="col" class="px-6 py-4 font-semibold text-center w-24">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                @forelse($pemeriksaan->terapiObats as $index => $obat)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                        <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">{{ $obat->nama_obat }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-semibold tracking-wide">
                                                {{ $obat->aturan_pakai }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center font-bold text-slate-900 dark:text-white">{{ $obat->jumlah_obat }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                            Tidak ada data terapi obat yang dicatat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($pemeriksaan->catatan)
                    <div class="p-6 bg-slate-50 dark:bg-slate-800/30 border-t border-slate-100 dark:border-slate-700">
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Catatan Tambahan Khusus</span>
                        <p class="text-slate-700 dark:text-slate-300 text-sm leading-relaxed">{{ $pemeriksaan->catatan }}</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
