<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Antrian - ANTRE.in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>
<body class="bg-[#F5F5F5] font-sans text-gray-800 antialiased">

    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-gray-200 border-r border-gray-300 p-6 flex flex-col justify-between hidden md:flex flex-shrink-0">
            <div>
                <div class="text-2xl font-bold tracking-wider text-gray-900 mb-6 pl-2">
                    ANTRE.in
                </div>
                
                <div class="mb-6 pl-2 flex items-center space-x-3">
                    <span class="material-icons-outlined text-3xl text-gray-600">account_circle</span>
                    <div>
                        <div class="text-xs font-bold text-gray-800">Halo, Admin</div>
                        <div class="text-[10px] text-gray-500 font-medium">Petugas Administrasi</div>
                    </div>
                </div>

                <div class="text-[10px] font-bold text-gray-400 tracking-wider uppercase mb-4 pl-2">
                    ADMIN
                </div>
                
                <nav class="space-y-1">
                    <div class="relative flex items-center bg-gray-800 rounded-xl mb-4">
                        <a href="#" class="flex items-center space-x-3 text-white font-bold p-3 w-full">
                            <span class="material-icons-outlined text-xl text-white">home</span>
                            <span class="text-sm">Dashboard</span>
                        </a>
                    </div>
                    
                    <a href="{{ route('admin.kelola.antrian') }}" class="flex items-center space-x-3 text-gray-900 font-bold p-3">
                        <span class="material-icons-outlined text-xl text-black">dashboard</span>
                        <span class="text-sm">Kelola Antrian</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">headset_mic</span>
                        <span class="font-medium text-sm">Kelola Layanan</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">people_outline</span>
                        <span class="font-medium text-sm">Kelola Mahasiswa</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">description</span>
                        <span class="font-medium text-sm">Verifikasi Berkas</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">group</span>
                        <span class="font-medium text-sm">Kelola Admin</span>
                    </a>

                    <a href="#" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">picture_as_pdf</span>
                        <span class="font-medium text-sm">Laporan PDF</span>
                    </a>

                    <a href="#" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">insert_chart_outlined</span>
                        <span class="font-medium text-sm">Statistik</span>
                    </a>

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

            <div>
                <hr class="border-gray-300 mb-4">
                <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
                    @csrf
                </form>
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-2 font-medium text-sm">
                    <span class="material-icons-outlined text-xl">logout</span>
                    <span>Logout</span>
                </a>
            </div>
        </aside>

        <main class="flex-1 p-8 md:p-12 overflow-y-auto">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Kelola Antrian</h1>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl text-xs font-bold flex items-center space-x-2">
                    <span class="material-icons-outlined text-sm">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 text-center">
                    <div class="text-xs text-gray-500 font-semibold mb-2 tracking-wide">Menunggu</div>
                    <div class="text-4xl font-bold text-gray-900">{{ $menunggu }}</div>
                </div>
                
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 text-center">
                    <div class="text-xs text-gray-500 font-semibold mb-2 tracking-wide">Sedang Dilayani</div>
                    <div class="text-4xl font-bold text-yellow-600">{{ $sedangMelayani }}</div>
                </div>
                
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 text-center">
                    <div class="text-xs text-gray-500 font-semibold mb-2 tracking-wide">Selesai Hari Ini</div>
                    <div class="text-4xl font-bold text-green-600">{{ $selesaiHariIni }}</div>
                </div>
                
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 text-center">
                    <div class="text-xs text-gray-500 font-semibold mb-2 tracking-wide">Dibatalkan</div>
                    <div class="text-4xl font-bold text-red-600">{{ $dibatalkan }}</div>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.kelola.antrian') }}" class="flex flex-col sm:flex-row gap-4 mb-6">
                <div class="relative flex-1">
                    <span class="material-icons-outlined absolute left-4 top-2.5 text-gray-400">search</span>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, NIM lalu tekan Enter..." class="w-full pl-12 pr-4 py-2 bg-white border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-gray-400 transition shadow-sm">
                </div>
                <div class="relative w-full sm:w-64">
                    <select name="layanan" onchange="this.form.submit()" class="w-full px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-1 focus:ring-gray-400 appearance-none transition pr-10 shadow-sm cursor-pointer text-gray-700">
                        <option value="Semua Layanan" {{ $layanan == 'Semua Layanan' ? 'selected' : '' }}>Semua Layanan</option>
                        <option value="Pembayaran" {{ $layanan == 'Pembayaran' ? 'selected' : '' }}>Pembayaran</option>
                        <option value="Administrasi" {{ $layanan == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                    </select>
                    <span class="material-icons-outlined absolute right-3 top-2.5 text-gray-500 pointer-events-none">arrow_drop_down</span>
                </div>
            </form>

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-xs font-bold uppercase border-b border-gray-200">
                                <th class="px-6 py-4">No Antrian</th>
                                <th class="px-6 py-4">Nama</th>
                                <th class="px-6 py-4">NIM</th>
                                <th class="px-6 py-4">Layanan</th>
                                <th class="px-6 py-4">Waktu Daftar</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center">Aksi / Kontrol Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm font-medium text-gray-700">
                            @forelse ($daftarAntrian as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-bold text-gray-900 tracking-wider">{{ $item->nomor_antrian }}</td>
                                    <td class="px-6 py-4">{{ $item->nama }}</td>
                                    <td class="px-6 py-4 text-xs font-mono text-gray-600">{{ $item->nim }}</td>
                                    <td class="px-6 py-4 text-xs text-gray-500">{{ $item->jenis_layanan }} <span class="text-gray-300">•</span> {{ $item->kategori_layanan }}</td>
                                    <td class="px-6 py-4 text-xs text-gray-500">{{ $item->created_at ? $item->created_at->format('H:i') : '-' }} WIB</td>
                                    <td class="px-6 py-4">
                                        @if($item->status === 'menunggu')
                                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-xs font-semibold border border-gray-200">Menunggu</span>
                                        @elseif($item->status === 'melayani')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-md text-xs font-bold border border-yellow-200 animate-pulse">Sedang Dilayani</span>
                                        @elseif($item->status === 'selesai')
                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-md text-xs font-bold border border-green-200">Selesai</span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-md text-xs font-bold border border-red-200">Batal</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            
                                            @if($item->status === 'menunggu')
                                                <form method="POST" action="{{ route('admin.antrian.update-status', [$item->id, 'melayani']) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="p-1.5 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 border border-yellow-200 rounded-lg transition flex items-center" title="Panggil ke Loket">
                                                        <span class="material-icons-outlined text-lg">play_arrow</span>
                                                    </button>
                                                </form>
                                            @endif

                                            @if($item->status === 'melayani')
                                                <form method="POST" action="{{ route('admin.antrian.update-status', [$item->id, 'selesai']) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="p-1.5 bg-green-50 hover:bg-green-100 text-green-700 border border-green-200 rounded-lg transition flex items-center" title="Tandai Selesai">
                                                        <span class="material-icons-outlined text-lg">check</span>
                                                    </button>
                                                </form>
                                            @endif

                                            @if(in_array($item->status, ['menunggu', 'melayani']))
                                                <form method="POST" action="{{ route('admin.antrian.update-status', [$item->id, 'batal']) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan antrian ini?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="p-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 rounded-lg transition flex items-center" title="Batalkan Antrian">
                                                        <span class="material-icons-outlined text-lg">close</span>
                                                    </button>
                                                </form>
                                            @endif

                                            <form method="POST" action="{{ route('admin.antrian.destroy', $item->id) }}" onsubmit="return confirm('Hapus permanen data antrian ini dari database?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-gray-100 rounded-lg transition flex items-center" title="Hapus Data">
                                                    <span class="material-icons-outlined text-lg">delete</span>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-sm text-gray-400 font-normal">
                                        Belum ada data antrian masuk untuk kriteria ini hari ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

</body>
</html>