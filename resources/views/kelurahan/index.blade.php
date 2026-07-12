<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                    {{ __('Data Master Kalurahan') }}
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola data referensi Kalurahan berdasarkan Puskesmas (Khusus Super Admin Dinkes).</p>
            </div>
            <div>
                <button type="button" onclick="document.getElementById('addModal').classList.remove('hidden')" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-bold text-white transition-all rounded-xl shadow-md bg-primary-600 hover:bg-primary-700 hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Kalurahan
                </button>
            </div>
        </div>
    </x-slot>

    <!-- Notifikasi Sukses -->
    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:border-emerald-800/50 dark:text-emerald-400 flex items-start gap-3 relative z-10">
            <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h3 class="font-bold">Berhasil!</h3>
                <p class="text-sm opacity-90">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Search Bar -->
    <div class="mb-6">
        <form method="GET" action="{{ route('master-kelurahan.index') }}" class="relative max-w-md">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" class="block w-full p-3 pl-10 text-sm text-slate-900 border border-slate-200 rounded-xl bg-white shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-slate-800 dark:border-slate-700 dark:placeholder-slate-400 dark:text-white" placeholder="Cari nama puskesmas atau kalurahan...">
        </form>
    </div>

    <!-- Data Grouped by Puskesmas -->
    <div class="space-y-6 relative z-10">
        @forelse ($kelurahans as $nama_puskesmas => $listKelurahan)
            <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 sm:rounded-2xl overflow-hidden">
                <div class="bg-slate-50/50 dark:bg-slate-900/50 px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        {{ $nama_puskesmas }}
                    </h3>
                    <span class="px-3 py-1 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-semibold rounded-full">{{ count($listKelurahan) }} Kalurahan</span>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($listKelurahan as $kel)
                            <div class="flex items-center justify-between p-3 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 hover:border-primary-400 dark:hover:border-primary-600 hover:shadow-md transition-all group">
                                <span class="font-medium text-slate-700 dark:text-slate-200">{{ $kel->nama_kelurahan }}</span>
                                <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button onclick="editKelurahan('{{ $kel->id_kelurahan }}', '{{ $kel->id_puskesmas }}', '{{ addslashes($kel->nama_kelurahan) }}')" class="p-1.5 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors dark:hover:bg-blue-900/50 dark:text-blue-400" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <form action="{{ route('master-kelurahan.destroy', $kel->id_kelurahan) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus Kalurahan {{ addslashes($kel->nama_kelurahan) }}? (Semua Dukuh di bawahnya juga akan terhapus!)');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-rose-600 hover:bg-rose-100 rounded-lg transition-colors dark:hover:bg-rose-900/50 dark:text-rose-400" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 sm:rounded-2xl p-12 text-center">
                <div class="w-16 h-16 mx-auto bg-slate-50 dark:bg-slate-900/50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h4 class="text-sm font-semibold text-slate-900 dark:text-white">Belum Ada Data Kalurahan</h4>
            </div>
        @endforelse
    </div>

    <!-- Modal Tambah -->
    <div id="addModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 p-4 transition-opacity duration-300">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all border border-slate-100 dark:border-slate-700">
            <div class="flex justify-between items-center p-5 border-b border-slate-100 dark:border-slate-700">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Tambah Kalurahan Baru</h3>
                <button onclick="document.getElementById('addModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-500 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('master-kelurahan.store') }}" method="POST" class="p-5">
                @csrf
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Pilih Puskesmas Naungan</label>
                    <select name="id_puskesmas" required class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                        <option value="">-- Pilih Puskesmas --</option>
                        @foreach($puskesmasList as $p)
                            <option value="{{ $p->id_puskesmas }}">{{ $p->nama_puskesmas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Kalurahan</label>
                    <input type="text" name="nama_kelurahan" placeholder="Contoh: Jangkaran" required class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div id="editModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 p-4 transition-opacity duration-300">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all border border-slate-100 dark:border-slate-700">
            <div class="flex justify-between items-center p-5 border-b border-slate-100 dark:border-slate-700">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Edit Kalurahan</h3>
                <button onclick="document.getElementById('editModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-500 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form id="editForm" method="POST" class="p-5">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Pilih Puskesmas Naungan</label>
                    <select name="id_puskesmas" id="edit_id_puskesmas" required class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                        <option value="">-- Pilih Puskesmas --</option>
                        @foreach($puskesmasList as $p)
                            <option value="{{ $p->id_puskesmas }}">{{ $p->nama_puskesmas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Kalurahan</label>
                    <input type="text" name="nama_kelurahan" id="edit_nama_kelurahan" required class="bg-white border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editKelurahan(id, idPuskesmas, kelurahan) {
            document.getElementById('edit_id_puskesmas').value = idPuskesmas;
            document.getElementById('edit_nama_kelurahan').value = kelurahan;
            document.getElementById('editForm').action = '/master-kelurahan/' + id;
            document.getElementById('editModal').classList.remove('hidden');
        }
    </script>
</x-app-layout>
