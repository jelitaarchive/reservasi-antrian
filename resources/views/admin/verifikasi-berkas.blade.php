<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANTRE.in - Verifikasi Berkas</title>
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
                    
                    <div class="relative flex items-center bg-gray-800 rounded-xl mb-4">
                        <a href="{{ route('admin.verifikasi.berkas') }}" class="flex items-center space-x-3 text-white font-bold p-3 w-full">
                            <span class="material-icons-outlined text-xl text-white">description</span>
                            <span class="text-sm">Verifikasi Berkas</span>
                        </a>
                    </div>
                    
                    <a href="{{ route('admin.kelola-admin') }}" class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">
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
                    <h2 class="text-2xl font-bold text-gray-900">Verifikasi Berkas</h2>
                </div>

                <div class="overflow-hidden border border-gray-200 rounded-xl bg-white shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-xs font-semibold uppercase tracking-wider border-b border-gray-200">
                                <th class="py-4 px-6">NIM</th>
                                <th class="py-4 px-6">Nama</th>
                                <th class="py-4 px-6">Layanan</th>
                                <th class="py-4 px-6 text-center">Berkas</th>
                                <th class="py-4 px-6 text-center">Status</th>
                                <th class="py-4 px-6 text-center w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm font-medium text-gray-700">
                            @foreach($dataBerkas as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-4 px-6 text-gray-500">{{ $item->nim }}</td>
                                <td class="py-4 px-6 font-bold text-gray-900">{{ $item->nama }}</td>
                                <td class="py-4 px-6 text-gray-600">{{ $item->jenis_layanan }}</td>
                                
                                <td class="py-4 px-6 text-center">
                                    @if($item->dokumen)
                                        <button onclick="openModalBerkas('{{ asset('storage/' . $item->dokumen) }}', '{{ $item->nama }}')" class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1.5 rounded-lg font-semibold transition inline-flex items-center space-x-1 shadow-sm">
                                            <span class="material-icons-outlined text-sm">visibility</span>
                                            <span>Lihat Berkas</span>
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400 font-normal italic">Tidak ada berkas</span>
                                    @endif
                                </td>

                                <td class="py-4 px-6 text-center">
                                    @if(strtolower($item->status) == 'selesai')
                                        <span class="bg-emerald-50 text-emerald-600 text-xs px-2.5 py-1 rounded font-semibold uppercase">Selesai</span>
                                    @elseif(strtolower($item->status) == 'batal')
                                        <span class="bg-red-50 text-red-600 text-xs px-2.5 py-1 rounded font-semibold uppercase">Batal</span>
                                    @else
                                        <span class="bg-amber-50 text-amber-600 text-xs px-2.5 py-1 rounded font-semibold uppercase">Menunggu</span>
                                    @endif
                                </td>

                                <td class="py-4 px-6 text-center space-x-1">
                                    <form action="{{ route('admin.verifikasi.update', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="selesai">
                                        <button type="submit" class="text-emerald-600 hover:text-emerald-700 hover:underline font-bold transition text-xs">
                                            Setujui
                                        </button>
                                    </form>

                                    <span class="text-gray-300">|</span>

                                    <form action="{{ route('admin.verifikasi.update', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="batal">
                                        <button type="submit" class="text-red-600 hover:text-red-700 hover:underline font-bold transition text-xs">
                                            Tolak
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div id="modalBerkas" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl h-[85vh] flex flex-col p-6 transform transition-all">
            <div class="flex justify-between items-center mb-4 border-b pb-3">
                <h3 id="modalTitleBerkas" class="text-lg font-bold text-gray-900">Preview Berkas</h3>
                <button onclick="closeModalBerkas()" class="text-gray-400 hover:text-gray-600 transition">
                    <span class="material-icons-outlined">close</span>
                </button>
            </div>

            <div class="flex-1 bg-gray-100 rounded-xl overflow-hidden relative">
                <iframe id="berkasFrame" src="" class="w-full h-full border-0 hidden"></iframe>
                <div id="imgPreviewContainer" class="w-full h-full flex items-center justify-center hidden p-4 overflow-auto">
                    <img id="berkasImg" src="" class="max-h-full max-w-full object-contain rounded-lg shadow">
                </div>
            </div>
        </div>
    </div>

<script>
    function openModalBerkas(fileUrl, namaBerkas) {
        const frame = document.getElementById('berkasFrame');
        const imgContainer = document.getElementById('imgPreviewContainer');
        const img = document.getElementById('berkasImg');
        
        document.getElementById('modalTitleBerkas').innerText = "Preview Berkas: " + namaBerkas;
        
        // Deteksi apakah file berupa PDF atau Gambar
        if (fileUrl.toLowerCase().endsWith('.pdf')) {
            frame.src = fileUrl;
            frame.classList.remove('hidden');
            imgContainer.classList.add('hidden');
        } else {
            img.src = fileUrl;
            imgContainer.classList.remove('hidden');
            frame.classList.add('hidden');
            frame.src = "";
        }
        
        document.getElementById('modalBerkas').classList.remove('hidden');
    }

    function closeModalBerkas() {
        document.getElementById('modalBerkas').classList.add('hidden');
        document.getElementById('berkasFrame').src = "";
        document.getElementById('berkasImg').src = "";
    }

    window.addEventListener('click', function(event) {
        let modal = document.getElementById('modalBerkas');
        if (event.target == modal) {
            closeModalBerkas();
        }
    });
</script>
</body>
</html>