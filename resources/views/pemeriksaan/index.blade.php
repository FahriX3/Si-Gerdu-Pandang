<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                    {{ __('Data Pemeriksaan Klinis') }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Riwayat lengkap hasil pemeriksaan dan terapi.</p>
            </div>
            <div>
                <a href="{{ route('pemeriksaan.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors rounded-xl shadow-sm bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Pemeriksaan Baru
                </a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-slate-800 relative shadow-sm border border-slate-100 dark:border-slate-700 sm:rounded-2xl overflow-hidden">
        
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
            <div class="w-full md:w-2/3">
                <form class="flex flex-col sm:flex-row gap-3 items-center" method="GET" action="{{ route('pemeriksaan.index') }}">
                    <label for="simple-search" class="sr-only">Cari</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" id="simple-search" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-slate-900 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white transition-colors" placeholder="Cari Nama Pasien atau NIK..." value="{{ request('search') }}">
                    </div>
                    @if(auth()->user()->role === 'admin_dinkes')
                    <div class="w-full sm:w-64 flex-shrink-0">
                        <select name="id_puskesmas" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-slate-900 dark:border-slate-600 dark:text-white" onchange="this.form.submit()">
                            <option value="">Semua Puskesmas</option>
                            @foreach($puskesmas as $p)
                                <option value="{{ $p->id_puskesmas }}" {{ request('id_puskesmas') == $p->id_puskesmas ? 'selected' : '' }}>{{ $p->nama_puskesmas }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <!-- Hidden submit button in case enter is pressed on text input -->
                    <button type="submit" class="hidden"></button>
                </form>
            </div>
        </div>

        <div class="block w-full overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                <thead class="hidden md:table-header-group text-xs text-slate-500 uppercase bg-slate-50/50 dark:bg-slate-800/50 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700">
                    <tr>
                        <th scope="col" class="px-5 py-4 font-semibold">Tgl & Pasien</th>
                        <th scope="col" class="px-5 py-4 font-semibold">Tekanan Darah</th>
                        <th scope="col" class="px-5 py-4 font-semibold">IMT</th>
                        <th scope="col" class="px-5 py-4 font-semibold">Diagnosis</th>
                        <th scope="col" class="px-5 py-4 font-semibold">Petugas</th>
                        <th scope="col" class="px-5 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700 flex flex-col md:table-row-group">
                    @forelse($pemeriksaans as $pemeriksaan)
                    <tr class="flex flex-col md:table-row hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors group p-4 md:p-0">
                        <td class="md:px-5 md:py-4 mb-3 md:mb-0">
                            <div class="flex justify-between items-start md:block">
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold text-primary-600 dark:text-primary-400 mb-1 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $pemeriksaan->tanggal_pemeriksaan->format('d M Y') }}
                                    </span>
                                    <span class="font-medium text-slate-900 dark:text-white text-base md:text-sm">{{ $pemeriksaan->pasien->nama_lengkap ?? 'Terhapus' }}</span>
                                </div>
                                <div class="md:hidden">
                                     <a href="{{ route('pemeriksaan.show', $pemeriksaan->id_pemeriksaan) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:text-primary-600 bg-slate-100 dark:bg-slate-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="md:px-5 md:py-4 mb-2 md:mb-0 flex md:table-cell items-center justify-between md:justify-start">
                            <span class="md:hidden text-xs text-slate-500 font-semibold uppercase">Tensi</span>
                            <div class="flex flex-col text-right md:text-left">
                                <span class="font-bold text-slate-800 dark:text-slate-200 text-base">
                                    {{ $pemeriksaan->systole }}<span class="text-slate-400 font-normal">/</span>{{ $pemeriksaan->diastole }}
                                </span>
                                <span class="text-[11px] font-medium uppercase tracking-wide {{ 
                                    $pemeriksaan->kategori_tensi == 'Normal' ? 'text-emerald-500' : 
                                    ($pemeriksaan->kategori_tensi == 'Prehipertensi' ? 'text-yellow-500' : 'text-rose-500')
                                }}">{{ $pemeriksaan->kategori_tensi }}</span>
                            </div>
                        </td>
                        <td class="md:px-5 md:py-4 mb-2 md:mb-0 flex md:table-cell items-center justify-between md:justify-start">
                            <span class="md:hidden text-xs text-slate-500 font-semibold uppercase">IMT</span>
                            <div class="flex flex-col text-right md:text-left">
                                <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $pemeriksaan->imt }}</span>
                                <span class="text-[11px] font-medium text-slate-500">{{ $pemeriksaan->status_imt }}</span>
                            </div>
                        </td>
                        <td class="md:px-5 md:py-4 mb-2 md:mb-0 flex md:table-cell items-center justify-between md:justify-start">
                            <span class="md:hidden text-xs text-slate-500 font-semibold uppercase">Diagnosis</span>
                            <div class="flex flex-wrap gap-1 mt-1">
                                @forelse($pemeriksaan->diagnoses as $diagnosis)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-medium {{ stripos($diagnosis->nama_diagnosis, 'tidak terkontrol') !== false ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200' }}">
                                        {{ mb_strtoupper($diagnosis->nama_diagnosis) }}
                                    </span>
                                @empty
                                    <span class="text-xs text-slate-500">-</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="md:px-5 md:py-4 mb-3 md:mb-0 flex md:table-cell items-center justify-between md:justify-start text-slate-600 dark:text-slate-400">
                            <span class="md:hidden text-xs text-slate-500 font-semibold uppercase">Petugas</span>
                            {{ $pemeriksaan->pemeriksa->name ?? 'Sistem' }}
                        </td>
                        <td class="hidden md:table-cell px-5 py-4 text-right">
                            <a href="{{ route('pemeriksaan.show', $pemeriksaan->id_pemeriksaan) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/30 dark:hover:text-primary-400 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr class="flex md:table-row">
                        <td colspan="6" class="w-full px-5 py-8 text-center text-slate-500">
                            Belum ada riwayat pemeriksaan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-5 border-t border-slate-100 dark:border-slate-700">
            {{ $pemeriksaans->links() }}
        </div>
    </div>
</x-app-layout>
