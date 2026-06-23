<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANTRE.in - Kelola Layanan</title>
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

                    <div class="relative flex items-center bg-gray-800 rounded-xl mb-4">
                        <a href="{{ route('admin.kelola-layanan') }}" class="flex items-center space-x-3 text-white font-bold p-3 w-full">
                            <span class="material-icons-outlined text-xl text-white">headset_mic</span>
                            <span class="text-sm">Kelola Layanan</span>
                        </a>
                    </div>
                    
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
                
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">Kelola Layanan</h2>
                    <button onclick="openModal()" class="bg-black hover:bg-gray-800 text-white font-medium px-5 py-2.5 rounded-md text-sm flex items-center gap-2 shadow-sm transition">
                        <span>+</span> Tambah Layanan
                    </button>
                </div>

                <div class="overflow-hidden border border-gray-200 rounded-xl bg-white shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-xs font-semibold uppercase tracking-wider border-b border-gray-200">
                                <th class="py-4 px-6 w-16 text-center">No</th>
                                <th class="py-4 px-6">Nama Layanan</th>
                                <th class="py-4 px-6">Estimasi</th>
                                <th class="py-4 px-6 text-center">Status</th>
                                <th class="py-4 px-6 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm font-medium text-gray-700">
                            @forelse($daftarLayanan as $index => $layanan)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-5 px-6 text-center text-gray-500">{{ $index + 1 }}</td>
                                    <td class="py-5 px-6">{{ $layanan->nama_layanan }}</td>
                                    <td class="py-5 px-6 text-gray-500">{{ $layanan->estimasi }}</td>
                                    <td class="py-5 px-6 text-center">
                                        @if(strtolower($layanan->status) == 'aktif')
                                            <span class="bg-emerald-50 text-emerald-600 text-xs px-2.5 py-1 rounded font-semibold">Aktif</span>
                                        @else
                                            <span class="bg-gray-200 text-gray-600 text-xs px-2.5 py-1 rounded font-semibold">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="py-5 px-6 text-center">
                                        <div class="flex justify-center gap-4 text-xs font-bold">
                                            <button class="text-blue-600 hover:underline transition">Edit</button>
                                            <button class="text-red-600 hover:underline transition">Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-10 text-center text-gray-400 font-normal">
                                        Belum ada data layanan di database. silakan klik tombol Tambah Layanan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </main>
        @if(session('success'))
            <div id="notif" class="mb-4 p-4 bg-emerald-100 text-emerald-700 rounded-lg text-sm font-bold transition-all">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => { document.getElementById('notif').style.display = 'none'; }, 3000);
            </script>
        @endif
    </div>
    
    <div id="modalLayanan" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-8 transform transition-all">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-900">Tambah Layanan Baru</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <span class="material-icons-outlined">close</span>
            </button>
        </div>

        <form action="{{ route('admin.layanan-store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Layanan</label>
                    <input type="text" name="nama_layanan" placeholder="Contoh: Pembayaran UKT" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-black transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Estimasi Waktu</label>
                    <input type="text" name="estimasi" placeholder="Contoh: 15 Menit" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-black transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-black transition">
                        <option value="Aktif">Aktif</option>
                        <option value="Nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="mt-8 flex gap-3">
                <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2.5 border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 transition font-semibold text-sm">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-black text-white rounded-lg hover:bg-gray-800 transition font-semibold text-sm">
                    Simpan Layanan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('modalLayanan').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalLayanan').classList.add('hidden');
    }

    // Menutup modal jika klik di luar area modal
    window.onclick = function(event) {
        let modal = document.getElementById('modalLayanan');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>
</body>
</html>