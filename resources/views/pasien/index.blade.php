<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                    {{ __('Data Pasien') }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola dan pantau data pasien di fasilitas kesehatan Anda.</p>
            </div>
            <div>
                <a href="{{ route('pasien.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors rounded-xl shadow-sm bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-offset-slate-900 gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Pasien
                </a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-slate-800 relative shadow-sm border border-slate-100 dark:border-slate-700 sm:rounded-2xl overflow-hidden">
        
        <!-- Toolbar -->
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
            <div class="w-full md:w-2/3">
                <form class="flex flex-col sm:flex-row gap-3 items-center" method="GET" action="{{ route('pasien.index') }}">
                    <label for="simple-search" class="sr-only">Cari Pasien</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" id="simple-search" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-slate-900 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white transition-colors" placeholder="Cari Nama atau NIK Pasien..." value="{{ request('search') }}">
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
            
            <div class="flex gap-2">
                <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-600 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filter
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="block w-full overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                <thead class="hidden md:table-header-group text-xs text-slate-500 uppercase bg-slate-50/50 dark:bg-slate-800/50 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700">
                    <tr>
                        <th scope="col" class="px-5 py-4 font-semibold">Nama Pasien</th>
                        <th scope="col" class="px-5 py-4 font-semibold">Usia / Kelamin</th>
                        <th scope="col" class="px-5 py-4 font-semibold">Domisili</th>
                        <th scope="col" class="px-5 py-4 font-semibold">Status</th>
                        <th scope="col" class="px-5 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700 flex flex-col md:table-row-group">
                    @forelse($pasiens as $pasien)
                    <tr class="flex flex-col md:table-row hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors group p-4 md:p-0">
                        <td class="md:px-5 md:py-4 mb-3 md:mb-0">
                            <div class="flex justify-between items-start md:block">
                                <div class="flex flex-col">
                                    <span class="font-semibold text-slate-900 dark:text-white text-base md:text-sm">{{ $pasien->nama_lengkap }}</span>
                                    <span class="text-xs text-slate-500 mt-0.5">{{ $pasien->nik }}</span>
                                </div>
                                <div class="md:hidden">
                                     <a href="{{ route('pasien.show', $pasien->id_pasien) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:text-primary-600 bg-slate-100 dark:bg-slate-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="md:px-5 md:py-4 mb-2 md:mb-0 flex md:table-cell items-center justify-between md:justify-start">
                            <span class="md:hidden text-xs text-slate-500 font-semibold uppercase">Usia/Kelamin</span>
                            <div class="flex items-center gap-2 text-right md:text-left">
                                <span class="px-2.5 py-1 rounded-md bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-medium">{{ $pasien->umur }} thn</span>
                                @if($pasien->jenis_kelamin == 'Laki-laki')
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11V3m0 0l-4 4m4-4l4 4M8 21a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                @else
                                    <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4a4 4 0 100 8 4 4 0 000-8zM12 12v9m-3-3h6"></path></svg>
                                @endif
                            </div>
                        </td>
                        <td class="md:px-5 md:py-4 mb-2 md:mb-0 flex md:table-cell items-center justify-between md:justify-start">
                            <span class="md:hidden text-xs text-slate-500 font-semibold uppercase">Domisili</span>
                            <div class="text-right md:text-left">
                                <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $pasien->kalurahan }}</span>
                                <span class="block text-xs text-slate-400 mt-0.5">{{ $pasien->puskesmas->nama_puskesmas ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="md:px-5 md:py-4 flex md:table-cell items-center justify-between md:justify-start">
                            <span class="md:hidden text-xs text-slate-500 font-semibold uppercase">Status</span>
                            @if($pasien->status_peserta == 'Aktif')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span> {{ $pasien->status_peserta }}
                                </span>
                            @endif
                        </td>
                        <td class="hidden md:table-cell px-5 py-4 text-right">
                            <a href="{{ route('pasien.show', $pasien->id_pasien) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/30 dark:hover:text-primary-400 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr class="flex md:table-row">
                        <td colspan="5" class="w-full px-5 py-8 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p>Belum ada data pasien ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-5 border-t border-slate-100 dark:border-slate-700">
            {{ $pasiens->links() }}
        </div>
    </div>
</x-app-layout>
