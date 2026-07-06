<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                {{ __('Pendaftaran Pasien Baru') }}
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Masukkan data demografi dan riwayat kesehatan awal pasien.</p>
        </div>
    </x-slot>

    <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-100 dark:border-slate-700 sm:rounded-2xl p-6 lg:p-10">
        
        <form action="{{ route('pasien.store') }}" method="POST">
            @csrf

            <!-- Global Error Display -->
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 dark:bg-rose-900/30 dark:border-rose-800/50 dark:text-rose-400">
                    <div class="flex items-center gap-2 mb-2 font-bold">
                        <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Terdapat kesalahan pengisian data!
                    </div>
                    <ul class="list-disc list-inside text-sm space-y-1 ml-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Section 1: Identitas Dasar -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white border-b border-slate-100 dark:border-slate-700 pb-3 mb-5">Identitas Dasar</h3>
                
                <div class="grid gap-6 sm:grid-cols-2">
                    @if(auth()->user()->role === 'admin_dinkes')
                    <div class="sm:col-span-2">
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Puskesmas Naungan Pasien <span class="text-rose-500">*</span></label>
                        <select name="id_puskesmas" id="id_puskesmas" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                            <option value="">-- Pilih Puskesmas --</option>
                            @foreach($puskesmas as $p)
                                <option value="{{ $p->id_puskesmas }}" {{ old('id_puskesmas') == $p->id_puskesmas ? 'selected' : '' }}>{{ $p->nama_puskesmas }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Nomor Induk Kependudukan (NIK) <span class="text-rose-500">*</span></label>
                        <input type="text" name="nik" maxlength="16" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required value="{{ old('nik') }}">
                        @error('nik') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Nomor Kartu Keluarga (KK) <span class="text-rose-500">*</span></label>
                        <input type="text" name="no_kk" maxlength="16" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required value="{{ old('no_kk') }}">
                        @error('no_kk') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Lengkap Pasien <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_lengkap" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required value="{{ old('nama_lengkap') }}">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Kepala Keluarga <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_kepala_keluarga" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required value="{{ old('nama_kepala_keluarga') }}">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Tanggal Lahir <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_lahir" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required value="{{ old('tanggal_lahir') }}">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Jenis Kelamin <span class="text-rose-500">*</span></label>
                        <select name="jenis_kelamin" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 2: Domisili & Kontak -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white border-b border-slate-100 dark:border-slate-700 pb-3 mb-5">Domisili & Kontak</h3>
                
                <div class="grid gap-6 sm:grid-cols-3">
                    <div class="sm:col-span-3">
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Kalurahan / Desa <span class="text-rose-500">*</span></label>
                        <select name="kalurahan" id="kalurahan" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                            <option value="">-- Pilih Kalurahan --</option>
                            @if(auth()->user()->role !== 'admin_dinkes' && isset($kelurahans))
                                @foreach($kelurahans as $kel)
                                    <option value="{{ $kel->nama_kelurahan }}" {{ old('kalurahan') == $kel->nama_kelurahan ? 'selected' : '' }}>{{ $kel->nama_kelurahan }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Dusun / Dukuh</label>
                        <input type="text" name="dukuh" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" value="{{ old('dukuh') }}">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">RT</label>
                        <input type="text" name="rt" maxlength="5" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" value="{{ old('rt') }}">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">RW</label>
                        <input type="text" name="rw" maxlength="5" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" value="{{ old('rw') }}">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Nomor HP Aktif</label>
                        <input type="text" name="no_hp" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full md:w-1/2 p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" value="{{ old('no_hp') }}">
                    </div>
                </div>
            </div>

            <!-- Section 3: Data Kepesertaan & Riwayat -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white border-b border-slate-100 dark:border-slate-700 pb-3 mb-5">Status & Riwayat</h3>
                
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Status Peserta <span class="text-rose-500">*</span></label>
                        <select name="status_peserta" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Meninggal">Meninggal</option>
                            <option value="Pindah Domisili">Pindah Domisili</option>
                            <option value="Non-Aktif">Non-Aktif</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Tanggal Awal Terdaftar <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_awal_terdaftar" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required value="{{ date('Y-m-d') }}">
                    </div>
                    
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Riwayat Hipertensi Keluarga <span class="text-rose-500">*</span></label>
                        <select name="riwayat_hipertensi_keluarga" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                            <option value="">-- Pilih --</option>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                            <option value="Tidak Tahu">Tidak Tahu</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Status Merokok <span class="text-rose-500">*</span></label>
                        <select name="status_merokok" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                            <option value="Tidak">Tidak</option>
                            <option value="Ya">Ya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Jenis Pekerjaan <span class="text-rose-500">*</span></label>
                        <select name="jenis_pekerjaan" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                            <option value="">-- Pilih Pekerjaan --</option>
                            <option value="PNS" {{ old('jenis_pekerjaan') == 'PNS' ? 'selected' : '' }}>PNS</option>
                            <option value="TNI/Polri" {{ old('jenis_pekerjaan') == 'TNI/Polri' ? 'selected' : '' }}>TNI/Polri</option>
                            <option value="Swasta" {{ old('jenis_pekerjaan') == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                            <option value="Wiraswasta" {{ old('jenis_pekerjaan') == 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                            <option value="Petani/Nelayan" {{ old('jenis_pekerjaan') == 'Petani/Nelayan' ? 'selected' : '' }}>Petani/Nelayan</option>
                            <option value="Tidak Kerja" {{ old('jenis_pekerjaan') == 'Tidak Kerja' ? 'selected' : '' }}>Tidak Kerja</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Nomor JKN / BPJS</label>
                        <input type="text" name="no_jkn" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white" value="{{ old('no_jkn') }}">
                    </div>
                    
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Status Peserta Prolanis <span class="text-rose-500">*</span></label>
                        <div class="flex gap-4 mt-3">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="jenis_prolanis" value="HT" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500" {{ old('jenis_prolanis') == 'HT' ? 'checked' : '' }} required>
                                <span class="text-sm text-slate-700 dark:text-slate-300 font-medium">HT (Hipertensi)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="jenis_prolanis" value="DM" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500" {{ old('jenis_prolanis') == 'DM' ? 'checked' : '' }} required>
                                <span class="text-sm text-slate-700 dark:text-slate-300 font-medium">DM (Diabetes Melitus)</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700 dark:text-slate-300">Status Peserta PRB</label>
                        <select name="status_peserta_prb" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 shadow-sm dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                            <option value="">-- Bukan Peserta PRB --</option>
                            <option value="HT" {{ old('status_peserta_prb') == 'HT' ? 'selected' : '' }}>HT</option>
                            <option value="DM" {{ old('status_peserta_prb') == 'DM' ? 'selected' : '' }}>DM</option>
                            <option value="Penyakit Jantung" {{ old('status_peserta_prb') == 'Penyakit Jantung' ? 'selected' : '' }}>Penyakit Jantung</option>
                            <option value="PPOK" {{ old('status_peserta_prb') == 'PPOK' ? 'selected' : '' }}>PPOK</option>
                            <option value="Asma" {{ old('status_peserta_prb') == 'Asma' ? 'selected' : '' }}>Asma</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end pt-6 border-t border-slate-100 dark:border-slate-700 gap-3">
                <a href="{{ route('pasien.index') }}" class="inline-flex items-center px-6 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 focus:ring-4 focus:outline-none focus:ring-slate-100 shadow-sm transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-2.5 text-sm font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 shadow-md shadow-primary-500/30 transition-all hover:scale-[1.02]">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Pasien Baru
                </button>
            </div>
        </form>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const puskesmasSelect = document.getElementById('id_puskesmas');
            const kelurahanSelect = document.getElementById('kalurahan');
            const oldKalurahan = '{{ old("kalurahan") }}';

            if (puskesmasSelect) {
                puskesmasSelect.addEventListener('change', function() {
                    const id = this.value;
                    kelurahanSelect.innerHTML = '<option value="">-- Memuat --</option>';
                    
                    if (id) {
                        fetch(`/puskesmas/${id}/kelurahans`)
                            .then(res => res.json())
                            .then(data => {
                                kelurahanSelect.innerHTML = '<option value="">-- Pilih Kalurahan --</option>';
                                data.forEach(kel => {
                                    const option = document.createElement('option');
                                    option.value = kel.nama_kelurahan;
                                    option.textContent = kel.nama_kelurahan;
                                    if (oldKalurahan === kel.nama_kelurahan) option.selected = true;
                                    kelurahanSelect.appendChild(option);
                                });
                            });
                    } else {
                        kelurahanSelect.innerHTML = '<option value="">-- Pilih Puskesmas Terlebih Dahulu --</option>';
                    }
                });

                // Trigger change on load if already selected
                if (puskesmasSelect.value) {
                    puskesmasSelect.dispatchEvent(new Event('change'));
                }
            }
        });
    </script>
</x-app-layout>
