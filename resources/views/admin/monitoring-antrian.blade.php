<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANTRE.in - Monitoring Antrian</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>
<body class="bg-[#efefef] font-sans text-gray-800 antialiased">

    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-gray-200 border-r border-gray-300 p-6 flex flex-col justify-between hidden md:flex">
            <div>
                <div class="text-2xl font-bold tracking-wider text-gray-900 mb-2 pl-2">ANTRE.in</div>
                <div class="text-xs font-bold text-gray-500 mb-8 pl-2 uppercase tracking-widest">Admin</div>
                
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">home</span>
                        <span class="text-sm font-medium">Dashboard</span>
                    </a>

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
                    
                    <a href="#" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">group</span>
                        <span class="font-medium text-sm">Kelola Admin</span>
                    </a>

                    <a href="{{ route('admin.laporan') }}" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">picture_as_pdf</span>
                        <span class="font-medium text-sm">Laporan PDF</span>
                    </a>

                    <div class="relative flex items-center bg-gray-800 rounded-xl mb-4">
                        <a href="{{ route('admin.monitoring') }}" class="flex items-center space-x-3 text-white font-bold p-3 w-full">
                            <span class="material-icons-outlined text-xl text-white">insert_chart_outlined</span>
                            <span class="text-sm">Monitoring Antrian</span>
                        </a>
                    </div>

                    <a href="#" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
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
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Monitoring Antrian</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white p-8 rounded-xl border border-gray-200 text-center shadow-sm">
                        <p class="text-gray-600 font-medium">Nomor Sedang Dilayani</p>
                        <h1 class="text-6xl font-black my-4 text-gray-900">{{ $sedangDilayani->nomor_antrian ?? 'A-00' }}</h1>
                        <p class="font-bold">{{ $sedangDilayani->jenis_layanan ?? '-' }}</p>
                        <p class="text-sm text-gray-500">{{ $sedangDilayani->nama ?? '-' }}</p>
                    </div>
                    <div class="bg-white p-8 rounded-xl border border-gray-200 text-center shadow-sm">
                        <p class="text-gray-600 font-medium">Sisa Antrian</p>
                        <h1 class="text-6xl font-black my-4 text-gray-900">{{ $sisaAntrian ?? '0' }}</h1>
                        <p class="font-bold">Orang</p>
                    </div>
                </div>

                <div class="flex gap-4 mb-12">
                    <form action="{{ route('admin.monitoring.panggil') }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-black hover:bg-gray-800 text-white font-bold px-5 py-4 rounded-xl flex items-center justify-center gap-2 transition">
                            <span class="material-icons-outlined">play_arrow</span> Panggil Berikutnya
                        </button>
                    </form>
                    <button class="flex-1 bg-white border border-gray-300 hover:bg-gray-50 font-bold px-5 py-4 rounded-xl flex items-center justify-center gap-2 transition">
                        <span class="material-icons-outlined">skip_next</span> Lewati
                    </button>
                </div>

                <h3 class="font-bold text-gray-900 mb-4">Daftar Antrian Berikutnya</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @forelse($antrianBerikutnya as $antrian)
                        <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                            <p class="text-2xl font-bold text-gray-900">{{ $antrian->nomor_antrian }}</p>
                            <p class="font-bold text-sm mt-2 text-gray-800">{{ $antrian->nama }}</p>
                            <p class="text-xs text-gray-500">{{ $antrian->jenis_layanan }}</p>
                        </div>
                    @empty
                        <div class="col-span-4 py-10 text-center text-gray-400">Belum ada antrian berikutnya.</div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
</body>
</html>