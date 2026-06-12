<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Antrian - ANTRE.in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>
<body class="bg-[#F5F5F5] font-sans text-gray-800 antialiased">

    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-gray-200 border-r border-gray-300 p-6 flex flex-col justify-between hidden md:flex">
            <div>
                <div class="text-2xl font-bold tracking-wider text-gray-900 mb-10 pl-2">ANTRE.in</div>
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 p-3">
                        <span class="material-icons-outlined text-xl">home</span>
                        <span class="text-sm">Beranda</span>
                    </a>
                    <a href="{{ route('monitoring.antrian') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 p-3">
                        <span class="material-icons-outlined text-xl">analytics</span>
                        <span class="text-sm">Monitoring Antrian</span>
                    </a>
                    <div class="relative flex items-center bg-gray-300 rounded-xl">
                        <div class="absolute left-[-24px] w-1.5 h-6 bg-black rounded-r-md"></div>
                        <a href="{{ route('tambah.antrian') }}" class="flex items-center space-x-3 text-gray-900 font-bold p-3 w-full">
                            <span class="material-icons-outlined text-xl text-black">add_box</span>
                            <span class="text-sm">Tambah Antrian</span>
                        </a>
                    </div>
                    <a href="{{ route('riwayat.antrian') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 p-3">
                        <span class="material-icons-outlined text-xl">history</span>
                        <span class="text-sm">Riwayat Antrian</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">person</span>
                        <span class="font-medium text-sm">Akun Saya</span>
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 p-6 md:p-10 flex justify-center">
            <div class="w-full max-w-4xl">
                
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-700">Tambah Antrian</h2>
                    </div>
                   
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 hover:opacity-80 transition group">
                        <div class="text-right">
                            <h4 class="font-bold text-gray-800 text-xs leading-tight">{{ Auth::user()->name ?? 'Halo, Mahasiswa' }}</h4>
                            <p class="text-[10px] text-gray-400">{{ Auth::user()->nim ?? 'ST020230300' }}</p>
                        </div>
                        <div class="w-8 h-8 bg-gray-100 rounded-full border border-gray-300 flex items-center justify-center overflow-hidden">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Foto Profil" class="w-full h-full object-cover">
                            @else
                                <span class="material-icons-outlined text-xl text-gray-400">account_circle</span>
                            @endif
                        </div>
                    </a>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded-[20px] mb-6 shadow-sm">
                        <div class="flex items-center space-x-2 mb-2 font-bold text-sm">
                            <span class="material-icons-outlined text-base">error_outline</span>
                            <span>Gagal Menyimpan Antrian:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('tambah.antrian.store') }}" method="POST">
                    @csrf

                    <div class="bg-white border border-gray-200 rounded-[32px] p-10 shadow-sm text-center">
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-2">Nomor Antrian Anda</p>
                        
                        <h1 class="text-7xl font-black tracking-tighter text-gray-800 my-6">B-08</h1>
                        
                        <div class="max-w-md mx-auto space-y-4 text-left border-t border-gray-100 pt-6 mb-10">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Jenis Pelayanan</span>
                                <span class="font-bold text-gray-700">Pembayaran</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Kategori</span>
                                <span class="font-bold text-gray-700">Pembayaran UKT</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">Waktu Pelayanan</span>
                                <span class="font-bold text-gray-700">13.30-16.00 WIB</span>
                            </div>
                        </div>

                        <input type="hidden" name="jenis_layanan" value="Pembayaran">
                        <input type="hidden" name="kategori_layanan" value="Pembayaran UKT">
                        <input type="hidden" name="waktu_layanan" value="13.30-16.00 WIB">
                        <input type="hidden" name="nomor_antrian" value="B-08">

                        <button type="submit" class="w-full max-w-md bg-gray-900 hover:bg-black text-white font-bold py-4 px-6 rounded-full inline-flex items-center justify-center space-x-2 transition shadow-md">
                            <span>Monitoring Antrian</span>
                            <span class="material-icons-outlined text-sm">arrow_forward</span>
                        </button>
                    </div>
                </form>

            </div>
        </main>
    </div>
</body>
</html>