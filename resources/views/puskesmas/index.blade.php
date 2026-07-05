<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                    {{ __('Master Data Puskesmas') }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola data fasilitas puskesmas dan jangkauan wilayah.</p>
            </div>
            <div>
                <a href="{{ route('puskesmas.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors rounded-xl shadow-sm bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Tambah Puskesmas
                </a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-slate-800 relative shadow-sm border border-slate-100 dark:border-slate-700 sm:rounded-2xl overflow-hidden">
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 dark:bg-slate-800/50 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700">
                    <tr>
                        <th scope="col" class="px-5 py-4 font-semibold">Kode</th>
                        <th scope="col" class="px-5 py-4 font-semibold">Nama Puskesmas</th>
                        <th scope="col" class="px-5 py-4 font-semibold">Kecamatan / Area</th>
                        <th scope="col" class="px-5 py-4 font-semibold">Alamat Lengkap</th>
                        <th scope="col" class="px-5 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($puskesmas as $p)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors group">
                        <td class="px-5 py-4">
                            <span class="font-mono text-xs font-semibold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded">{{ $p->kode_puskesmas }}</span>
                        </td>
                        <td class="px-5 py-4 font-semibold text-slate-900 dark:text-white">
                            {{ $p->nama_puskesmas }}
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $p->kecamatan->nama_kecamatan ?? '-' }}</span>
                            <span class="block text-xs text-slate-400">{{ $p->kecamatan->kabupaten->nama_kabupaten ?? '' }}</span>
                        </td>
                        <td class="px-5 py-4 text-slate-600 dark:text-slate-400 truncate max-w-xs">
                            {{ $p->alamat }}
                            <span class="block text-xs text-slate-400 mt-0.5">{{ $p->no_telp ?? 'Tanpa nomor telepon' }}</span>
                        </td>
                        <td class="px-5 py-4 text-right whitespace-nowrap">
                            <a href="{{ route('puskesmas.edit', $p->id_puskesmas) }}" class="inline-flex items-center justify-center w-8 h-8 mr-1 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/30 dark:hover:text-primary-400 transition-colors" title="Edit Puskesmas">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <form action="{{ route('puskesmas.destroy', $p->id_puskesmas) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin? Penghapusan ini dapat berdampak pada data pasien yang terikat.');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-rose-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/30 dark:hover:text-rose-400 transition-colors" title="Hapus Data">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-slate-500">
                            Belum ada master data puskesmas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-5 border-t border-slate-100 dark:border-slate-700">
            {{ $puskesmas->links() }}
        </div>
    </div>
</x-app-layout>
