<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANTRE.in - Kelola Mahasiswa</title>
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
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">home</span>
                        <span class="text-sm font-medium">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.kelola.antrian') }}" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">dashboard</span>
                        <span class="font-medium text-sm">Kelola Antrian</span>
                    </a>
                    
                    <a href="{{ route('admin.kelola.layanan') }}" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">headset_mic</span>
                        <span class="font-medium text-sm">Kelola Layanan</span>
                    </a>

                    <div class="relative flex items-center bg-gray-800 rounded-xl mb-4">
                        <a href="{{ route('admin.kelola.mahasiswa') }}" class="flex items-center space-x-3 text-white font-bold p-3 w-full">
                            <span class="material-icons-outlined text-xl text-white">people_outline</span>
                            <span class="text-sm">Kelola Mahasiswa</span>
                        </a>
                    </div>
                    
                    <a href="{{ route('admin.verifikasi.berkas') }}" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
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

                    <a href="{{ route('admin.monitoring') }}" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">insert_chart_outlined</span>
                        <span class="font-medium text-sm">Monitoring Antrian</span>
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
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-lg text-sm font-semibold">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">Kelola Mahasiswa</h2>
                    
                    <div class="flex items-center gap-4">
                        <form action="{{ route('admin.kelola.mahasiswa') }}" method="GET" class="relative w-64">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ $search ?? '' }}"
                                placeholder="Cari nama / NIM / email..." 
                                class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-md text-sm bg-white focus:outline-none focus:ring-1 focus:ring-gray-400 transition"
                            >
                            <button type="submit" class="material-icons-outlined absolute right-3 top-2.5 text-gray-400 text-lg">search</button>
                        </form>
                        
                        <button class="bg-black hover:bg-gray-800 text-white font-medium px-5 py-2.5 rounded-md text-sm flex items-center gap-2 shadow-sm transition">
                            <span>+</span> Tambah Mahasiswa
                        </button>
                    </div>
                </div>

                <div class="overflow-hidden border border-gray-200 rounded-xl bg-white shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-xs font-semibold uppercase tracking-wider border-b border-gray-200">
                                <th class="py-4 px-6 w-16 text-center">No</th>
                                <th class="py-4 px-6">NIM</th>
                                <th class="py-4 px-6">Nama Mahasiswa</th>
                                <th class="py-4 px-6">Email</th>
                                <th class="py-4 px-6 text-center">No. Telepon</th>
                                <th class="py-4 px-6 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm font-medium text-gray-700">
                            @forelse($daftarMahasiswa as $index => $mahasiswa)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-5 px-6 text-center text-gray-500">
                                        {{ ($daftarMahasiswa->currentPage() - 1) * $daftarMahasiswa->perPage() + $index + 1 }}
                                    </td>
                                    <td class="py-5 px-6 font-mono text-gray-600">{{ $mahasiswa->nim ?? '-' }}</td>
                                    <td class="py-5 px-6">{{ $mahasiswa->name }}</td>
                                    <td class="py-5 px-6 text-gray-500 font-normal">{{ $mahasiswa->email }}</td>
                                    <td class="py-5 px-6 text-center text-gray-500 font-normal">
                                        {{ $mahasiswa->phone ?? '-' }}
                                    </td>
                                    <td class="py-5 px-6 text-center">
                                        <div class="flex justify-center gap-4 text-xs font-bold">
                                            <button class="text-blue-600 hover:underline transition">Edit</button>
                                            
                                            <form action="{{ route('admin.mahasiswa.destroy', $mahasiswa->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline transition">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-10 text-center text-gray-400 font-normal">
                                        Belum ada data mahasiswa di database atau hasil pencarian tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $daftarMahasiswa->links() }}
                </div>

            </div>
        </main>
    </div>

</body>
</html>