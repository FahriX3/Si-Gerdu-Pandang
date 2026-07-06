<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                {{ __('Ringkasan Eksekutif') }}
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Pantau statistik terkini dari gerakan pemeriksaan kesehatan.</p>
        </div>
    </x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <!-- Card Total Pasien -->
        <div class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-slate-100 sm:p-6 p-5 dark:bg-slate-800 dark:border-slate-700/60 group hover:shadow-md transition-shadow">
            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-blue-50 dark:bg-blue-900/20 transition-transform group-hover:scale-110 duration-500"></div>
            <div class="relative z-10 flex items-center justify-between w-full">
                <div>
                    <h3 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Total Pasien Terdaftar</h3>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">{{ number_format($totalPasien) }}</span>
                        <span class="text-xs font-medium text-emerald-500 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-0.5 rounded-full">+12%</span>
                    </div>
                </div>
                <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Card Total Pemeriksaan -->
        <div class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-slate-100 sm:p-6 p-5 dark:bg-slate-800 dark:border-slate-700/60 group hover:shadow-md transition-shadow">
            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-indigo-50 dark:bg-indigo-900/20 transition-transform group-hover:scale-110 duration-500"></div>
            <div class="relative z-10 flex items-center justify-between w-full">
                <div>
                    <h3 class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Total Pemeriksaan</h3>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">{{ number_format($totalPemeriksaan) }}</span>
                    </div>
                </div>
                <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 text-white shadow-lg shadow-indigo-500/30">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
            </div>
        </div>

        <!-- Card HT Tidak Terkontrol (Alert) -->
        @php
            $isHtDanger = $pasienHipertensiTidakTerkontrol > 0;
            $htBgClass = $isHtDanger ? 'from-rose-500 to-rose-600' : 'from-emerald-500 to-emerald-600';
            $htTextClass = $isHtDanger ? 'text-rose-100' : 'text-emerald-100';
            $htBadgeText = $isHtDanger ? 'Perlu Perhatian' : 'Aman Terkendali';
        @endphp
        <div class="relative overflow-hidden bg-gradient-to-br {{ $htBgClass }} rounded-2xl shadow-md sm:p-6 p-5 group hover:shadow-lg transition-shadow">
            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white/10 transition-transform group-hover:scale-110 duration-500"></div>
            <div class="relative z-10 flex items-center justify-between w-full">
                <div>
                    <h3 class="text-sm font-medium {{ $htTextClass }} mb-1">HT Tidak Terkontrol (30 Hari)</h3>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold tracking-tight text-white">{{ number_format($pasienHipertensiTidakTerkontrol) }}</span>
                        <span class="text-xs font-medium text-white bg-white/20 px-2 py-0.5 rounded-full">{{ $htBadgeText }}</span>
                    </div>
                </div>
                <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-white/20 text-white backdrop-blur-sm border border-white/30">
                    @if($isHtDanger)
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    @else
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 dark:bg-slate-800 dark:border-slate-700/60">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                    Distribusi Pasien {{ Auth::user()->role === 'admin_dinkes' ? 'Per Puskesmas' : 'Per Kalurahan' }}
                </h3>
                <p class="text-sm text-slate-500 dark:text-slate-400">Peta sebaran data berdasarkan demografi wilayah.</p>
            </div>
            
            <a href="{{ route('dashboard.exportPdf') }}" target="_blank" class="text-sm text-primary-600 hover:text-primary-700 font-medium flex items-center gap-1 bg-primary-50 dark:bg-primary-900/20 px-3 py-1.5 rounded-lg transition-colors">
                Unduh PDF
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            </a>
        </div>
        <div id="bar-chart" class="w-full"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            const data = @json($grafikData);
            const labels = data.map(item => item.label);
            const series = data.map(item => item.total);

            const options = {
                series: [{
                    name: 'Total Pasien',
                    data: series
                }],
                chart: {
                    type: 'bar',
                    height: '350px',
                    fontFamily: "Inter, sans-serif",
                    toolbar: { show: false },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        animateGradually: { enabled: true, delay: 150 },
                        dynamicAnimation: { enabled: true, speed: 350 }
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '45%',
                        borderRadius: 6,
                    }
                },
                dataLabels: { enabled: false },
                stroke: { show: true, width: 2, colors: ['transparent'] },
                xaxis: {
                    categories: labels,
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: {
                        style: { colors: '#64748b', fontSize: '12px', fontWeight: 500 }
                    }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#64748b', fontSize: '12px', fontWeight: 500 }
                    }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    yaxis: { lines: { show: true } }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: "vertical",
                        shadeIntensity: 0.25,
                        gradientToColors: undefined,
                        inverseColors: true,
                        opacityFrom: 1,
                        opacityTo: 0.85,
                        stops: [50, 0, 100],
                    },
                },
                colors: ["#3b82f6"],
                tooltip: {
                    theme: 'light',
                    y: { formatter: function (val) { return val + " Pasien" } }
                }
            };

            const chart = new ApexCharts(document.getElementById("bar-chart"), options);
            chart.render();
        });
    </script>
</x-app-layout>
