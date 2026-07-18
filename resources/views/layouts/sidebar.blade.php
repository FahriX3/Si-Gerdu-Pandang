<!-- Navbar -->
<nav class="fixed top-0 z-50 w-full glass">
  <div class="px-4 py-3 lg:px-6">
    <div class="flex items-center justify-between">
      <div class="flex items-center justify-start rtl:justify-end">
        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-slate-500 rounded-lg sm:hidden hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-200 dark:text-slate-400 dark:hover:bg-slate-800 dark:focus:ring-slate-600 transition-colors">
            <span class="sr-only">Buka sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
               <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
         </button>
        <a href="{{ route('dashboard') }}" class="flex ms-3 md:me-24 items-center gap-3 group">
          <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="h-16 md:h-20 w-auto object-contain group-hover:scale-105 transition-transform" />
        </a>
      </div>
      <div class="flex items-center">
          <div class="flex items-center ms-3">
            <div>
              <button type="button" class="flex items-center gap-3 text-sm rounded-full focus:ring-4 focus:ring-primary-100 dark:focus:ring-slate-700 transition-all p-1 pe-3 border border-transparent hover:border-slate-200 dark:hover:border-slate-700 bg-white/50 dark:bg-slate-800/50 hover:bg-white dark:hover:bg-slate-800" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                <span class="sr-only">Menu Pengguna</span>
                <div class="w-9 h-9 rounded-full bg-primary-600 flex items-center justify-center text-white font-semibold shadow-inner">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <div class="hidden md:block text-left">
                    <div class="text-sm font-medium text-slate-800 dark:text-slate-100 leading-tight">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">{{ ucwords(str_replace('_', ' ', Auth::user()->role)) }}</div>
                </div>
                <svg class="w-4 h-4 text-slate-500 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
              </button>
            </div>
            
            <!-- Dropdown -->
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-slate-100 rounded-xl shadow-xl dark:bg-slate-800 dark:divide-slate-700 border border-slate-100 dark:border-slate-700 min-w-[200px]" id="dropdown-user">
              <div class="px-4 py-3" role="none">
                <p class="text-sm text-slate-900 dark:text-white font-medium" role="none">
                  {{ Auth::user()->name }}
                </p>
                <p class="text-xs font-medium text-slate-500 truncate dark:text-slate-400 mt-1" role="none">
                  {{ Auth::user()->email }}
                </p>
                @if(Auth::user()->puskesmas)
                <p class="text-xs font-medium text-primary-600 dark:text-primary-400 mt-1" role="none">
                  {{ Auth::user()->puskesmas->nama_puskesmas }}
                </p>
                @endif
              </div>
              <ul class="py-1" role="none">
                <li>
                  <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-white transition-colors flex items-center gap-2" role="menuitem">
                      <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                      Pengaturan Profil
                  </a>
                </li>
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-900/30 transition-colors flex items-center gap-2" role="menuitem">
                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar
                    </a>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
    </div>
  </div>
</nav>

<!-- Sidebar -->
<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-slate-200 sm:translate-x-0 dark:bg-slate-900 dark:border-slate-800 shadow-sm" aria-label="Sidebar">
   <div class="h-full px-4 pb-4 overflow-y-auto bg-white dark:bg-slate-900 flex flex-col justify-between">
      <ul class="space-y-1.5 font-medium mt-2">
         
         <li class="mb-4 px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider">Menu Utama</li>
         
         <li>
            <a href="{{ route('dashboard') }}" class="flex items-center p-2.5 text-slate-700 rounded-xl dark:text-slate-200 hover:bg-slate-100 hover:text-primary-600 dark:hover:bg-slate-800 dark:hover:text-primary-400 transition-all group {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400 font-semibold' : '' }}">
               <svg class="w-5 h-5 transition-colors {{ request()->routeIs('dashboard') ? 'text-primary-600 dark:text-primary-400' : 'text-slate-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                  <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                  <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
               </svg>
               <span class="ms-3">Dashboard</span>
            </a>
         </li>
         
         <li>
            <a href="{{ route('pasien.index') }}" class="flex items-center p-2.5 text-slate-700 rounded-xl dark:text-slate-200 hover:bg-slate-100 hover:text-primary-600 dark:hover:bg-slate-800 dark:hover:text-primary-400 transition-all group {{ request()->routeIs('pasien.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400 font-semibold' : '' }}">
               <svg class="w-5 h-5 transition-colors {{ request()->routeIs('pasien.*') ? 'text-primary-600 dark:text-primary-400' : 'text-slate-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Data Pasien</span>
            </a>
         </li>

         <li>
            <a href="{{ route('pemeriksaan.index') }}" class="flex items-center p-2.5 text-slate-700 rounded-xl dark:text-slate-200 hover:bg-slate-100 hover:text-primary-600 dark:hover:bg-slate-800 dark:hover:text-primary-400 transition-all group {{ request()->routeIs('pemeriksaan.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400 font-semibold' : '' }}">
               <svg class="w-5 h-5 transition-colors {{ request()->routeIs('pemeriksaan.*') ? 'text-primary-600 dark:text-primary-400' : 'text-slate-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Pemeriksaan</span>
            </a>
         </li>

         <li>
            <a href="{{ route('laporan.index') }}" class="flex items-center p-2.5 text-slate-700 rounded-xl dark:text-slate-200 hover:bg-slate-100 hover:text-primary-600 dark:hover:bg-slate-800 dark:hover:text-primary-400 transition-all group {{ request()->routeIs('laporan.index') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400 font-semibold' : '' }}">
               <svg class="w-5 h-5 transition-colors {{ request()->routeIs('laporan.index') ? 'text-primary-600 dark:text-primary-400' : 'text-slate-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Laporan</span>
            </a>
         </li>

         @if(Auth::user()->role === 'admin_dinkes')
         <li class="mt-6 mb-2 px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider block">Administrator</li>
         <li>
            <a href="{{ route('puskesmas.index') }}" class="flex items-center p-2.5 text-slate-700 rounded-xl dark:text-slate-200 hover:bg-slate-100 hover:text-primary-600 dark:hover:bg-slate-800 dark:hover:text-primary-400 transition-all group {{ request()->routeIs('puskesmas.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400 font-semibold' : '' }}">
               <svg class="w-5 h-5 transition-colors {{ request()->routeIs('puskesmas.*') ? 'text-primary-600 dark:text-primary-400' : 'text-slate-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Master Puskesmas</span>
            </a>
         </li>
         <li>
            <a href="{{ route('master-obat.index') }}" class="flex items-center p-2.5 text-slate-700 rounded-xl dark:text-slate-200 hover:bg-slate-100 hover:text-primary-600 dark:hover:bg-slate-800 dark:hover:text-primary-400 transition-all group {{ request()->routeIs('master-obat.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400 font-semibold' : '' }}">
               <svg class="w-5 h-5 transition-colors {{ request()->routeIs('master-obat.*') ? 'text-primary-600 dark:text-primary-400' : 'text-slate-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Master Obat</span>
            </a>
         </li>
         <li>
            <a href="{{ route('master-pekerjaan.index') }}" class="flex items-center p-2.5 text-slate-700 rounded-xl dark:text-slate-200 hover:bg-slate-100 hover:text-primary-600 dark:hover:bg-slate-800 dark:hover:text-primary-400 transition-all group {{ request()->routeIs('master-pekerjaan.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400 font-semibold' : '' }}">
               <svg class="w-5 h-5 transition-colors {{ request()->routeIs('master-pekerjaan.*') ? 'text-primary-600 dark:text-primary-400' : 'text-slate-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Master Pekerjaan</span>
            </a>
         </li>
         <li>
            <a href="{{ route('master-kelurahan.index') }}" class="flex items-center p-2.5 text-slate-700 rounded-xl dark:text-slate-200 hover:bg-slate-100 hover:text-primary-600 dark:hover:bg-slate-800 dark:hover:text-primary-400 transition-all group {{ request()->routeIs('master-kelurahan.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400 font-semibold' : '' }}">
               <svg class="w-5 h-5 transition-colors {{ request()->routeIs('master-kelurahan.*') ? 'text-primary-600 dark:text-primary-400' : 'text-slate-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Master Kalurahan</span>
            </a>
         </li>
         <li>
            <a href="{{ route('master-dukuh.index') }}" class="flex items-center p-2.5 text-slate-700 rounded-xl dark:text-slate-200 hover:bg-slate-100 hover:text-primary-600 dark:hover:bg-slate-800 dark:hover:text-primary-400 transition-all group {{ request()->routeIs('master-dukuh.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400 font-semibold' : '' }}">
               <svg class="w-5 h-5 transition-colors {{ request()->routeIs('master-dukuh.*') ? 'text-primary-600 dark:text-primary-400' : 'text-slate-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Master Dukuh</span>
            </a>
         </li>
         <li>
            <a href="{{ route('master-diagnosis.index') }}" class="flex items-center p-2.5 text-slate-700 rounded-xl dark:text-slate-200 hover:bg-slate-100 hover:text-primary-600 dark:hover:bg-slate-800 dark:hover:text-primary-400 transition-all group {{ request()->routeIs('master-diagnosis.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400 font-semibold' : '' }}">
               <svg class="w-5 h-5 transition-colors {{ request()->routeIs('master-diagnosis.*') ? 'text-primary-600 dark:text-primary-400' : 'text-slate-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Master Diagnosis</span>
            </a>
         </li>
         <li>
            <a href="{{ route('master-kelompok-gp.index') }}" class="flex items-center p-2.5 text-slate-700 rounded-xl dark:text-slate-200 hover:bg-slate-100 hover:text-primary-600 dark:hover:bg-slate-800 dark:hover:text-primary-400 transition-all group {{ request()->routeIs('master-kelompok-gp.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400 font-semibold' : '' }}">
               <svg class="w-5 h-5 transition-colors {{ request()->routeIs('master-kelompok-gp.*') ? 'text-primary-600 dark:text-primary-400' : 'text-slate-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Master Kelompok GP</span>
            </a>
         </li>
         <li>
            <a href="{{ route('users.index') }}" class="flex items-center p-2.5 text-slate-700 rounded-xl dark:text-slate-200 hover:bg-slate-100 hover:text-primary-600 dark:hover:bg-slate-800 dark:hover:text-primary-400 transition-all group {{ request()->routeIs('users.*') ? 'bg-primary-50 text-primary-700 dark:bg-primary-900/20 dark:text-primary-400 font-semibold' : '' }}">
               <svg class="w-5 h-5 transition-colors {{ request()->routeIs('users.*') ? 'text-primary-600 dark:text-primary-400' : 'text-slate-400 group-hover:text-primary-600 dark:group-hover:text-primary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Master Pengguna</span>
            </a>
         </li>
         @endif
      </ul>
      
      <!-- Bottom Info -->
      <div class="p-4 mt-6 bg-primary-50 dark:bg-slate-800/50 rounded-2xl border border-primary-100 dark:border-slate-700/50">
          <div class="flex items-center gap-3">
              <div class="flex-shrink-0 w-10 h-10 bg-white dark:bg-slate-700 rounded-full flex items-center justify-center shadow-sm">
                  <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
              </div>
              <div>
                  <p class="text-xs font-semibold text-slate-800 dark:text-white">SI GERDU PANDANG</p>
                  <p class="text-[10px] text-slate-500 dark:text-slate-400">Ver 1.0 (Secure)</p>
              </div>
          </div>
      </div>
   </div>
</aside>
