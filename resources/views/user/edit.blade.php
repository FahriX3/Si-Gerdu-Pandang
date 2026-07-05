<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                {{ __('Edit Pengguna') }}
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Perbarui data atau ubah hak akses pengguna.</p>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 sm:rounded-2xl p-6 lg:p-8 max-w-3xl">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white" required value="{{ old('name', $user->name) }}">
                    @error('name') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Email Login <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white" required value="{{ old('email', $user->email) }}">
                    @error('email') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800/50 rounded-xl">
                    <p class="text-sm font-medium text-yellow-800 dark:text-yellow-400 mb-3">Ganti password? (Biarkan kosong jika tidak ingin mengubah password)</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <input type="password" name="password" placeholder="Password Baru" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                            @error('password') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password Baru" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-slate-100 dark:border-slate-700 pt-6 mt-6">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Role Akses <span class="text-rose-500">*</span></label>
                        <select name="role" id="role" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin_dinkes" {{ old('role', $user->role) == 'admin_dinkes' ? 'selected' : '' }}>Admin Dinkes</option>
                            <option value="admin_puskesmas" {{ old('role', $user->role) == 'admin_puskesmas' ? 'selected' : '' }}>Admin Puskesmas</option>
                        </select>
                        @error('role') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div id="puskesmas-container">
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Puskesmas Bertugas</label>
                        <select name="id_puskesmas" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                            <option value="">-- Pilih Puskesmas --</option>
                            @foreach($puskesmas as $p)
                                <option value="{{ $p->id_puskesmas }}" {{ old('id_puskesmas', $user->id_puskesmas) == $p->id_puskesmas ? 'selected' : '' }}>{{ $p->nama_puskesmas }}</option>
                            @endforeach
                        </select>
                        @error('id_puskesmas') <span class="text-xs text-rose-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end mt-8 gap-3">
                <a href="{{ route('users.index') }}" class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 shadow-sm transition-colors">Batal</a>
                <button type="submit" class="inline-flex items-center px-6 py-2.5 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 shadow-md transition-all hover:scale-[1.02]">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('role-select').addEventListener('change', function() {
            const puskesmasContainer = document.getElementById('puskesmas-container');
            if(this.value === 'admin_dinkes') {
                puskesmasContainer.style.display = 'none';
            } else {
                puskesmasContainer.style.display = 'block';
            }
        });
        document.getElementById('role-select').dispatchEvent(new Event('change'));
    </script>
</x-app-layout>
