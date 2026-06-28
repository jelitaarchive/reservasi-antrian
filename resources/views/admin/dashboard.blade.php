<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ANTRE.in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>
<body class="bg-[#efefef] font-sans text-gray-800 antialiased">

    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-gray-200 border-r border-gray-300 p-6 flex flex-col justify-between hidden md:flex">
            <div>
                <div class="text-2xl font-bold tracking-wider text-gray-900 mb-2 pl-2">
                    ANTRE.in
                </div>
                <div class="text-xs font-bold text-gray-500 mb-8 pl-2 uppercase tracking-widest">
                    Admin
                </div>
                
                <nav class="space-y-1">
                    <div class="relative flex items-center bg-gray-800 rounded-xl mb-4">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 text-white font-bold p-3 w-full">
                            <span class="material-icons-outlined text-xl text-white">home</span>
                            <span class="text-sm">Dashboard</span>
                        </a>
                    </div>
                    
                    <a href="{{ route('admin.kelola.antrian') }}" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">dashboard</span>
                        <span class="font-medium text-sm">Kelola Antrian</span>
                    </a>
                    
                    <a href="{{ route('admin.kelola-layanan') }}" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">headset_mic</span>
                        <span class="font-medium text-sm">Kelola Layanan</span>
                    </a>
                    
                    <a href="{{ route('admin.kelola.mahasiswa') }}" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">people_outline</span>
                        <span class="font-medium text-sm">Kelola Mahasiswa</span>
                    </a>
                    
                    <a href="{{ route('admin.verifikasi.berkas') }}" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">description</span>
                        <span class="font-medium text-sm">Verifikasi Berkas</span>
                    </a>
                    
                    <a href="{{ route('admin.kelola-admin') }}" class="flex tems-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">group</span>
                        <span class="font-medium text-sm">Kelola Admin</span>
                    </a>

                    <a href="{{ route('admin.laporan') }}" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">picture_as_pdf</span>
                        <span class="font-medium text-sm">Laporan PDF</span>
                    </a>

                    <a href="{{ route('admin.monitoring') }}" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">insert_chart_outlined</span>
                        <span class="font-medium text-sm">Monitoring Antrian</span>
                    </a>

                    <a href="{{ route('admin.riwayat') }}" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">history</span>
                        <span class="font-medium text-sm">Riwayat Antrian</span>
                    </a>

                    <a href="{{ route('admin.profile.edit') }}" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">account_box</span>
                        <span class="font-medium text-sm">Profil Admin</span>
                    </a>
                </nav>
            </div>

            <div class="border-t border-gray-400 pt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 text-gray-600 hover:text-red-600 transition p-3 w-full text-left">
                        <span class="font-medium text-sm">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-8 md:p-12 overflow-y-auto">
            <div class="w-full max-w-7xl mx-auto">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                    
                    <div class="bg-white rounded-2xl p-6 shadow-sm text-center border border-gray-100">
                        <p class="text-xs font-semibold text-gray-500 mb-2">Total Antrian Hari Ini</p>
                        <h3 id="stat-total" class="text-4xl font-bold">0</h3>
                        <p class="text-[10px] text-gray-400">Total keseluruhan</p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-sm text-center border border-gray-100">
                        <p class="text-xs font-semibold text-gray-500 mb-2">Antrian Selesai</p>
                        <h3 id="stat-selesai" class="text-4xl font-bold">0</h3>
                        <p class="text-[10px] text-gray-400">Telah dilayani</p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-sm text-center border border-gray-100">
                        <p class="text-xs font-semibold text-gray-500 mb-2">Belum Dilayani</p>
                        <h3 id="stat-belum" class="text-4xl font-bold">0</h3>
                        <p class="text-[10px] text-gray-400">Belum dilayani</p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-sm text-center border border-gray-100">
                        <p class="text-xs font-semibold text-gray-500 mb-2">Mahasiswa Dilayani</p>
                        <<h3 id="stat-dilayani" class="text-4xl font-bold">0</h3>
                        <p class="text-[10px] text-gray-400">Orang hari ini</p>
                    </div>

                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    
                    <div class="lg:col-span-7 bg-[#E8EBF3] rounded-3xl p-6 shadow-sm">
                        <h4 class="text-sm font-bold text-gray-800 mb-6">Grafik Antrian (7 Hari Terakhir)</h4>
                        
                        <div class="relative w-full h-56 bg-white bg-opacity-60 rounded-xl p-4 flex flex-col justify-between">
                            <div class="text-xs text-gray-400 text-center flex flex-col justify-between h-full w-full">
                                <canvas id="antrianChart"></canvas>
                            </div>                           
                        </div>
                    </div>

                    <div class="lg:col-span-5 bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                        <h4 class="text-sm font-bold text-gray-800 mb-8">Antrian per Layanan</h4>
                        <div class="relative w-full h-48">
                            <canvas id="layananChart"></canvas>
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // 1. Update Kartu
        function updateStats() {
            fetch("{{ route('admin.dashboard.data') }}")
                .then(res => res.json())
                .then(data => {
                    document.getElementById('stat-total').innerText = data.total;
                    document.getElementById('stat-selesai').innerText = data.selesai;
                    document.getElementById('stat-belum').innerText = data.belum;
                    document.getElementById('stat-dilayani').innerText = data.dilayani;
                });
        }

        // 2. Grafik Bar 7 Hari
        const chart1 = new Chart(document.getElementById('antrianChart'), {
            type: 'line',
            data: { labels: [], datasets: [{ label: 'Antrian', data: [], borderColor: '#3b82f6' }] }
        });

        // 3. Grafik Donat Layanan
        const chart2 = new Chart(document.getElementById('layananChart'), {
            type: 'doughnut',
            data: { labels: [], datasets: [{ data: [], backgroundColor: ['#eab308', '#22d3ee', '#a855f7'] }] }
        });

        function refreshDashboard() {
            updateStats();
            // Update Chart 1
            fetch("{{ route('admin.dashboard.chart-data') }}").then(r => r.json()).then(d => {
                chart1.data.labels = d.labels; chart1.data.datasets[0].data = d.data; chart1.update();
            });
            // Update Chart 2
            fetch("{{ route('admin.dashboard.layanan-data') }}").then(r => r.json()).then(d => {
                chart2.data.labels = d.labels; chart2.data.datasets[0].data = d.counts; chart2.update();
            });
        }

        setInterval(refreshDashboard, 5000); // Auto update setiap 5 detik
        refreshDashboard();
    </script>

</body>
</html>