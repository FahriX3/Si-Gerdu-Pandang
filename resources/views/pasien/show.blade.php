<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                    {{ __('Profil Medis Pasien') }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Detail informasi dan rekam medis lengkap pasien.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('pasien.index') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
                    Kembali
                </a>
                <a href="{{ route('pasien.print', $pasien->id_pasien) }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-sm gap-2">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Profil
                </a>
                <a href="{{ route('pasien.edit', $pasien->id_pasien) }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors rounded-xl shadow-sm bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Edit Data
                </a>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Profil Singkat -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 rounded-2xl overflow-hidden relative">
                <div class="h-24 bg-gradient-to-r from-primary-500 to-indigo-600"></div>
                <div class="px-6 pb-6 relative">
                    <div class="absolute -top-12 left-6">
                        <div class="w-24 h-24 bg-white dark:bg-slate-700 rounded-2xl shadow-md flex items-center justify-center p-1 border-4 border-white dark:border-slate-800">
                            @if($pasien->jenis_kelamin == 'Laki-laki')
                                <div class="w-full h-full bg-blue-50 dark:bg-blue-900/30 rounded-xl flex items-center justify-center text-blue-500">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                            @else
                                <div class="w-full h-full bg-pink-50 dark:bg-pink-900/30 rounded-xl flex items-center justify-center text-pink-500">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="pt-16">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $pasien->nama_lengkap }}</h3>
                        <p class="text-sm font-medium text-slate-500 mb-4">{{ $pasien->nik }}</p>
                        
                        <div class="flex items-center gap-2 mb-6">
                            @if($pasien->status_peserta == 'Aktif')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-800 border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span> {{ $pasien->status_peserta }}
                                </span>
                            @endif
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300">
                                {{ $pasien->umur }} Tahun
                            </span>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                <div>
                                    <p class="text-xs text-slate-500">Domisili</p>
                                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Dusun {{ $pasien->dukuhM->nama_dukuh ?? '-' }}, {{ $pasien->kelurahan->nama_kelurahan ?? '-' }} RT {{ $pasien->rt ?? '-' }}/{{ $pasien->rw ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <div>
                                    <p class="text-xs text-slate-500">Kontak</p>
                                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $pasien->no_hp ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <div>
                                    <p class="text-xs text-slate-500">Jenis Pekerjaan</p>
                                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $pasien->jenis_pekerjaan ?: '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <div>
                                    <p class="text-xs text-slate-500">Puskesmas Pembina</p>
                                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $pasien->puskesmas->nama_puskesmas ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <div>
                                    <p class="text-xs text-slate-500">Kelompok Gerdu Pandang</p>
                                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $pasien->kelompokGp->nama_kelompok_gp ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu Info Medis Dasar -->
            <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 rounded-2xl p-6">
                <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 border-b border-slate-100 dark:border-slate-700 pb-2">Informasi Medis Dasar</h4>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Riwayat Hipertensi Keluarga</p>
                        @if($pasien->riwayat_hipertensi_keluarga == 'Ya')
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-rose-100 text-rose-800 border border-rose-200">Ada Riwayat (Ya)</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-800 border border-slate-200">{{ $pasien->riwayat_hipertensi_keluarga }}</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Status Merokok</p>
                        <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $pasien->status_merokok }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Status Peserta Prolanis</p>
                        <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $pasien->jenis_prolanis }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Status Peserta PRB</p>
                        <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $pasien->status_peserta_prb ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 mb-1">No. Rekam Medis (RM)</p>
                        <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $pasien->no_rm ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 mb-1">No JKN / BPJS</p>
                        <p class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $pasien->no_jkn ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Riwayat Pemeriksaan -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 rounded-2xl p-6 h-full">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Riwayat Pemeriksaan (Kunjungan)</h3>
                    <a href="{{ route('pemeriksaan.create', ['id_pasien' => $pasien->id_pasien]) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-primary-700 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors">
                        + Tambah Kunjungan
                    </a>
                </div>

                @if($pasien->pemeriksaans->count() > 0)
                    <div class="relative border-l border-slate-200 dark:border-slate-700 ml-3 space-y-8 pb-4">
                        @foreach($pasien->pemeriksaans as $pemeriksaan)
                            <div class="relative pl-6">
                                <!-- Dot -->
                                <div class="absolute w-3 h-3 bg-primary-500 rounded-full -left-[6.5px] top-1.5 ring-4 ring-white dark:ring-slate-800"></div>
                                
                                <div class="bg-slate-50 dark:bg-slate-900/50 rounded-xl p-5 border border-slate-100 dark:border-slate-700/60 hover:shadow-md transition-shadow">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-3 gap-2">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $pemeriksaan->tanggal_pemeriksaan->format('d F Y') }}</span>
                                            <span class="text-xs font-medium text-slate-500 bg-white dark:bg-slate-800 px-2 py-0.5 rounded-full border border-slate-200 dark:border-slate-700">{{ $pemeriksaan->tempat_pemeriksaan }}</span>
                                        </div>
                                        <a href="{{ route('pemeriksaan.show', $pemeriksaan->id_pemeriksaan) }}" class="text-xs text-primary-600 hover:underline font-medium flex items-center">
                                            Detail Lengkap <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <p class="text-xs text-slate-500 mb-1">Keluhan:</p>
                                        <p class="text-sm text-slate-800 dark:text-slate-300 italic">"{{ $pemeriksaan->keluhan }}"</p>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                        <div class="bg-white dark:bg-slate-800 p-3 rounded-lg border border-slate-100 dark:border-slate-700">
                                            <p class="text-[10px] text-slate-500 uppercase tracking-wider mb-1">Tekanan Darah</p>
                                            <p class="font-bold text-slate-900 dark:text-white">{{ $pemeriksaan->systole }}/{{ $pemeriksaan->diastole }} <span class="text-xs font-normal text-slate-500">mmHg</span></p>
                                        </div>
                                        <div class="bg-white dark:bg-slate-800 p-3 rounded-lg border border-slate-100 dark:border-slate-700">
                                            <p class="text-[10px] text-slate-500 uppercase tracking-wider mb-1">IMT</p>
                                            <p class="font-bold text-slate-900 dark:text-white">{{ $pemeriksaan->imt }}</p>
                                        </div>
                                        <div class="col-span-2 bg-white dark:bg-slate-800 p-3 rounded-lg border border-slate-100 dark:border-slate-700">
                                            <p class="text-[10px] text-slate-500 uppercase tracking-wider mb-1">Diagnosis</p>
                                            <p class="font-bold text-slate-700 dark:text-slate-300">
                                                @forelse($pemeriksaan->diagnoses as $diagnosis)
                                                    <span class="inline-block mr-1 {{ stripos($diagnosis->nama_diagnosis, 'tidak terkontrol') !== false ? 'text-rose-600' : 'text-emerald-600' }}">{{ $diagnosis->nama_diagnosis }}@if(!$loop->last), @endif</span>
                                                @empty
                                                    -
                                                @endforelse
                                            </p>
                                        </div>
                                    </div>

                                    @if($pemeriksaan->terapiObats->count() > 0)
                                        <div class="mt-3 pt-3 border-t border-slate-200 dark:border-slate-700 border-dashed">
                                            <p class="text-[10px] text-slate-500 uppercase tracking-wider mb-2">Terapi Obat</p>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($pemeriksaan->terapiObats as $obat)
                                                    <span class="inline-flex items-center px-2 py-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded text-xs font-medium text-slate-700 dark:text-slate-300">
                                                        {{ $obat->nama_obat }} ({{ $obat->aturan_pakai }}) - {{ $obat->jumlah_obat }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <div class="w-16 h-16 bg-slate-50 dark:bg-slate-900/50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h4 class="text-sm font-semibold text-slate-900 dark:text-white">Belum Ada Rekam Medis</h4>
                        <p class="text-sm text-slate-500 mt-1 max-w-sm">Pasien ini belum memiliki riwayat pemeriksaan atau kunjungan yang tercatat dalam sistem.</p>
                        <a href="{{ route('pemeriksaan.create') }}" class="mt-4 inline-flex items-center px-4 py-2 text-sm font-medium text-primary-700 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors">
                            Mulai Pemeriksaan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
