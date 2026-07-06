<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                {{ __('Edit Data Puskesmas') }}
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Perbarui profil dan area cakupan Puskesmas.</p>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 sm:rounded-2xl p-6 lg:p-8 max-w-3xl">
        <form action="{{ route('puskesmas.update', $puskesma->id_puskesmas) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Kode Puskesmas (Unik) <span class="text-rose-500">*</span></label>
                        <input type="text" name="kode_puskesmas" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white" required value="{{ old('kode_puskesmas', $puskesma->kode_puskesmas) }}">
                        @error('kode_puskesmas') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Puskesmas <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_puskesmas" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white" required value="{{ old('nama_puskesmas', $puskesma->nama_puskesmas) }}">
                        @error('nama_puskesmas') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Kecamatan <span class="text-rose-500">*</span></label>
                    <select name="id_kecamatan" id="id_kecamatan" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id_kecamatan }}" {{ old('id_kecamatan', $puskesma->id_kecamatan) == $kecamatan->id_kecamatan ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                    @error('id_kecamatan') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Alamat Lengkap <span class="text-rose-500">*</span></label>
                    <textarea name="alamat" rows="3" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>{{ old('alamat', $puskesma->alamat) }}</textarea>
                    @error('alamat') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Nomor Telepon</label>
                    <input type="text" name="no_telp" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full md:w-1/2 p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white" value="{{ old('no_telp', $puskesma->no_telp) }}">
                    @error('no_telp') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="pt-4 border-t border-slate-100 dark:border-slate-700">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Daftar Kelurahan Naungan</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Tambahkan kelurahan yang masuk dalam wilayah kerja puskesmas ini.</p>
                        </div>
                        <button type="button" onclick="addKelurahan()" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-slate-800 dark:bg-slate-700 rounded-lg hover:bg-slate-700 dark:hover:bg-slate-600 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Kelurahan
                        </button>
                    </div>
                    
                    <datalist id="kelurahan-suggestions">
                        @foreach($semuaKelurahans as $sk)
                            <option value="{{ $sk->nama_kelurahan }}">
                        @endforeach
                    </datalist>
                    
                    <div id="kelurahan-container" class="space-y-3">
                        @if($puskesma->kelurahans && $puskesma->kelurahans->count() > 0)
                            @foreach($puskesma->kelurahans as $kel)
                            <div class="flex items-center gap-3 kelurahan-item">
                                <input type="text" name="kelurahans[]" list="kelurahan-suggestions" value="{{ $kel->nama_kelurahan }}" placeholder="Nama Kelurahan" class="flex-1 bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                                <button type="button" onclick="removeKelurahan(this)" class="p-3 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-xl transition-colors" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                            @endforeach
                        @else
                            <div class="flex items-center gap-3 kelurahan-item">
                                <input type="text" name="kelurahans[]" list="kelurahan-suggestions" placeholder="Nama Kelurahan" class="flex-1 bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                                <button type="button" onclick="removeKelurahan(this)" class="p-3 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-xl transition-colors" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end mt-8 gap-3">
                <a href="{{ route('puskesmas.index') }}" class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 shadow-sm transition-colors">Batal</a>
                <button type="submit" class="inline-flex items-center px-6 py-2.5 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 shadow-md transition-all hover:scale-[1.02]">
                    Simpan Perubahan
                </button>
            </div>
        </form>
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
            new TomSelect('#id_kecamatan',{
                create: false,
                sortField: { field: "text", direction: "asc" }
            });
        });

        function addKelurahan() {
            const container = document.getElementById('kelurahan-container');
            const item = document.createElement('div');
            item.className = 'flex items-center gap-3 kelurahan-item';
            item.innerHTML = `
                <input type="text" name="kelurahans[]" list="kelurahan-suggestions" placeholder="Nama Kelurahan" class="flex-1 bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                <button type="button" onclick="removeKelurahan(this)" class="p-3 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-xl transition-colors" title="Hapus">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
            `;
            container.appendChild(item);
        }

        function removeKelurahan(btn) {
            const items = document.querySelectorAll('.kelurahan-item');
            if (items.length > 1) {
                btn.closest('.kelurahan-item').remove();
            } else {
                btn.closest('.kelurahan-item').querySelector('input').value = '';
            }
        }
    </script>
</x-app-layout>
