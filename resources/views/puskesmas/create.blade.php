<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                {{ __('Tambah Puskesmas Baru') }}
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftarkan faskes baru beserta area operasionalnya.</p>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 sm:rounded-2xl p-6 lg:p-8 max-w-3xl">
        <form action="{{ route('puskesmas.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Kode Puskesmas (Unik) <span class="text-rose-500">*</span></label>
                        <input type="text" name="kode_puskesmas" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white" required value="{{ old('kode_puskesmas') }}">
                        @error('kode_puskesmas') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Puskesmas <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_puskesmas" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white" required value="{{ old('nama_puskesmas') }}">
                        @error('nama_puskesmas') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Kecamatan <span class="text-rose-500">*</span></label>
                    <select name="id_kecamatan" id="id_kecamatan" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->id_kecamatan }}" {{ old('id_kecamatan') == $kecamatan->id_kecamatan ? 'selected' : '' }}>{{ $kecamatan->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                    @error('id_kecamatan') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Alamat Lengkap <span class="text-rose-500">*</span></label>
                    <textarea name="alamat" rows="3" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>{{ old('alamat') }}</textarea>
                    @error('alamat') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Nomor Telepon</label>
                    <input type="text" name="no_telp" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full md:w-1/2 p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white" value="{{ old('no_telp') }}">
                    @error('no_telp') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex items-center justify-end mt-8 gap-3">
                <a href="{{ route('puskesmas.index') }}" class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 shadow-sm transition-colors">Batal</a>
                <button type="submit" class="inline-flex items-center px-6 py-2.5 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 shadow-md transition-all hover:scale-[1.02]">
                    Simpan Puskesmas
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
    </script>
</x-app-layout>
