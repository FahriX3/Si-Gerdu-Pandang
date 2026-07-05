<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                    {{ __('Manajemen Pengguna') }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola akses admin, petugas, dan kader ke dalam sistem.</p>
            </div>
            <div>
                <a href="{{ route('users.create') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors rounded-xl shadow-sm bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    Tambah Pengguna
                </a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-slate-800 relative shadow-sm border border-slate-100 dark:border-slate-700 sm:rounded-2xl overflow-hidden">
        
        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
            <div class="w-full md:w-1/2">
                <form class="flex items-center">
                    <label for="simple-search" class="sr-only">Cari Pengguna</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" id="simple-search" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-slate-900 dark:border-slate-600 dark:placeholder-slate-400 dark:text-white transition-colors" placeholder="Cari nama atau email...">
                    </div>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50/50 dark:bg-slate-800/50 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700">
                    <tr>
                        <th scope="col" class="px-5 py-4 font-semibold">Nama / Email</th>
                        <th scope="col" class="px-5 py-4 font-semibold">Role Akses</th>
                        <th scope="col" class="px-5 py-4 font-semibold">Puskesmas Bertugas</th>
                        <th scope="col" class="px-5 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @foreach($users as $user)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors group">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-primary-600 to-indigo-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-semibold text-slate-900 dark:text-white">{{ $user->name }}</span>
                                    <span class="text-xs text-slate-500">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            @php
                                $roleColors = [
                                    'admin_dinkes' => 'bg-purple-100 text-purple-800 border-purple-200 dark:bg-purple-900/30 dark:text-purple-400',
                                    'admin_puskesmas' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400',
                                    'petugas_pustu' => 'bg-emerald-100 text-emerald-800 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400',
                                    'kader_posyandu' => 'bg-orange-100 text-orange-800 border-orange-200 dark:bg-orange-900/30 dark:text-orange-400',
                                ];
                                $colorClass = $roleColors[$user->role] ?? 'bg-slate-100 text-slate-800 border-slate-200';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border {{ $colorClass }}">
                                {{ ucwords(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            @if($user->role === 'admin_dinkes')
                                <span class="text-slate-400 italic text-xs">Seluruh Wilayah (Dinas Kesehatan)</span>
                            @else
                                <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $user->puskesmas->nama_puskesmas ?? '-' }}</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right whitespace-nowrap">
                            <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center justify-center w-8 h-8 mr-1 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/30 dark:hover:text-primary-400 transition-colors" title="Edit Pengguna">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-rose-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/30 dark:hover:text-rose-400 transition-colors" title="Hapus Pengguna">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="p-5 border-t border-slate-100 dark:border-slate-700">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
