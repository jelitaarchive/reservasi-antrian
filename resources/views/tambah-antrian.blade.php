<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Antrian - ANTRE.in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>
<body class="bg-[#F5F5F5] font-sans text-gray-800 antialiased" x-data="{ step: 1, waktu_layanan: '' }">

    <div class="flex min-h-screen">
        
        <!-- SIDEBAR -->
        <aside class="w-64 bg-gray-200 border-r border-gray-300 p-6 flex flex-col justify-between hidden md:flex">
            <div>
                <div class="text-2xl font-bold tracking-wider text-gray-900 mb-10 pl-2">
                    ANTRE.in
                </div>
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">home</span>
                        <span class="font-medium text-sm">Beranda</span>
                    </a>
                    
                    <a href="{{ route('riwayat.antrian') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">analytics</span>
                        <span class="font-medium text-sm">Monitoring Antrian</span>
                    </a>
                    
                    <div class="relative flex items-center">
                        <div class="absolute left-[-24px] w-1.5 h-6 bg-black rounded-r-md"></div>
                        <a href="{{ route('tambah.antrian') }}" class="flex items-center space-x-3 text-gray-900 font-bold p-3 w-full">
                            <span class="material-icons-outlined text-xl text-black">add_box</span>
                            <span class="text-sm">Tambah Antrian</span>
                        </a>
                    </div>
                    
                    <a href="{{ route('riwayat.antrian') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">history</span>
                        <span class="font-medium text-sm">Riwayat Antrian</span>
                    </a>
                    
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">person</span>
                        <span class="font-medium text-sm">Akun Saya</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-8 md:p-12 flex justify-center items-start">
            <div class="w-full max-w-3xl">
                
                <!-- HEADER CONTENT -->
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-8">
                    <div class="flex flex-col">
                        <h2 class="text-3xl font-bold text-gray-700 tracking-tight leading-none">Tambah</h2>
                        <h2 class="text-3xl font-bold text-gray-700 tracking-tight mt-1 leading-none">Antrian</h2>
                    </div>


                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 self-end md:self-auto hover:opacity-80 transition group">
                        <div class="text-right">
                            <h4 class="font-bold text-gray-800 text-xs leading-tight group-hover:text-blue-600 transition">Halo, {{ Auth::user()->name ?? 'Jelita Admin' }}</h4>
                            <p class="text-[10px] text-gray-400">{{ Auth::user()->nim ?? '220101001' }}</p>
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

                <!-- PROGRESS BAR STEP -->
                <div x-show="step < 5" class="flex items-center justify-between gap-3 mb-10 w-full">
                    <div class="w-full h-3 rounded-full border transition-colors duration-300" :class="step >= 1 ? 'bg-blue-500 border-blue-600 shadow-sm' : 'bg-[#D9D9D9]'"></div>
                    <div class="w-full h-3 rounded-full transition-colors duration-300" :class="step >= 2 ? 'bg-blue-500 border border-blue-600 shadow-sm' : 'bg-[#D9D9D9]'"></div>
                    <div class="w-full h-3 rounded-full transition-colors duration-300" :class="step >= 3 ? 'bg-blue-500 border border-blue-600 shadow-sm' : 'bg-[#D9D9D9]'"></div>
                    <div class="w-full h-3 rounded-full transition-colors duration-300" :class="step >= 4 ? 'bg-blue-500 border border-blue-600 shadow-sm' : 'bg-[#D9D9D9]'"></div>
                </div>

                <!-- FORM UTAMA -->
                <form id="queueForm" action="#" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- STEP 1: BIODATA -->
                    <div x-show="step === 1" class="bg-white rounded-[32px] border border-gray-200 shadow-sm p-10 transition-all">
                        <h3 class="text-2xl font-bold text-gray-800 tracking-tight">Biodata</h3>
                        <p class="text-gray-400 text-xs mt-0.5 mb-8">Lengkapi biodata dibawah ini!</p>
                        <div class="space-y-5">
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-500 mb-1.5 pl-3">Nama Lengkap</label>
                                <input type="text" id="nama" name="nama" required value="{{ Auth::user()->name ?? 'Jelita Admin' }}" class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-xs text-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400 transition">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-500 mb-1.5 pl-3">NIM</label>
                                <input type="text" id="nim" name="nim" required value="{{ Auth::user()->nim ?? '220101001' }}" class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-xs text-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400 transition">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-500 mb-1.5 pl-3">Email</label>
                                <input type="email" id="email" name="email" required value="{{ Auth::user()->email ?? 'admin@antrein.com' }}" class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-xs text-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400 transition">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-gray-500 mb-1.5 pl-3">Nomor WhatsApp</label>
                                <input type="text" id="whatsapp" name="whatsapp" required value="{{ Auth::user()->whatsapp ?? '081234567890' }}" class="w-full px-5 py-2.5 border border-gray-300 rounded-full text-xs text-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400 transition">
                            </div>
                            <div class="pt-6">
                                <button type="button" @click="if(document.getElementById('nama').checkValidity() && document.getElementById('nim').checkValidity() && document.getElementById('email').checkValidity() && document.getElementById('whatsapp').checkValidity()) { step = 2; } else { document.getElementById('queueForm').reportValidity(); }" class="w-full py-2.5 border border-gray-300 rounded-full text-xs font-bold text-gray-600 hover:bg-gray-50 transition flex items-center justify-center space-x-1.5">
                                    <span>Lanjutkan</span>
                                    <span class="material-icons-outlined text-sm">arrow_forward</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: LAYANAN -->
                    <div x-show="step === 2" x-cloak class="bg-white rounded-[32px] border border-gray-200 shadow-sm p-10 transition-all">
                        <button type="button" @click="step = 1" class="flex items-center text-gray-400 hover:text-gray-700 mb-4 transition">
                            <span class="material-icons-outlined text-xl">arrow_back</span>
                        </button>
                        <h3 class="text-2xl font-bold text-gray-800 tracking-tight">Layanan</h3>
                        <p class="text-gray-400 text-xs mt-0.5 mb-8">Pilih layanan yang dibutuhkan</p>
                        <div class="space-y-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-3">Jenis Layanan</label>
                                <div class="space-y-3 pl-1">
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input type="radio" id="layanan_pembayaran" name="layanan" value="Pembayaran UKT" required class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <span class="text-xs text-gray-600 font-medium">Pembayaran</span>
                                    </label>
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input type="radio" id="layanan_administrasi" name="layanan" value="Administrasi Kampus" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <span class="text-xs text-gray-600 font-medium">Administrasi</span>
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-2">Kategori Jenis Layanan</label>
                                <textarea id="kategori_layanan" name="kategori_layanan" required placeholder="Ketikkan detail kategori atau keterangan jenis layanan disini..." class="w-full h-44 border border-gray-300 rounded-[20px] bg-white p-4 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400 transition resize-none shadow-sm"></textarea>
                            </div>
                            <div class="pt-4">
                                <button type="button" @click="if(document.getElementById('kategori_layanan').checkValidity() && (document.getElementById('layanan_pembayaran').checked || document.getElementById('layanan_administrasi').checked)) { step = 3; } else { document.getElementById('queueForm').reportValidity(); }" class="w-full py-2.5 border border-gray-300 rounded-full text-xs font-bold text-gray-600 hover:bg-gray-50 transition flex items-center justify-center space-x-1.5">
                                    <span>Lanjutkan</span>
                                    <span class="material-icons-outlined text-sm">arrow_forward</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div x-show="step === 3" x-cloak class="bg-white rounded-[32px] border border-gray-200 shadow-sm p-10 transition-all" 
                        x-data="{ fileList: [] }">
                        
                        <button type="button" @click="step = 2" class="flex items-center text-gray-400 hover:text-gray-700 mb-4 transition">
                            <span class="material-icons-outlined text-xl">arrow_back</span>
                        </button>
                        <h3 class="text-2xl font-bold text-gray-800 tracking-tight">Upload Berkas</h3>
                        <p class="text-gray-400 text-xs mt-0.5 mb-8">Upload berkas yang dibutuhkan (bisa pilih banyak)</p>
                        
                        <div class="space-y-6">
                            <div class="flex flex-col items-center justify-center w-full">
                                <label class="flex flex-col items-center justify-center w-full h-40 border border-gray-300 border-dashed rounded-[20px] cursor-pointer bg-white hover:bg-gray-50 transition relative">
                                    
                                    <div x-show="fileList.length === 0" class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <span class="material-icons-outlined text-gray-400 text-3xl mb-2">add</span>
                                        <p class="text-xs font-semibold text-gray-500">Tambahkan File</p>
                                    </div>

                                    <div x-show="fileList.length > 0" x-cloak class="w-full px-4 text-center overflow-y-auto max-h-32">
                                        <p class="text-[10px] font-bold text-gray-500 mb-2">Daftar Berkas Anda:</p>
                                        <template x-for="(file, index) in fileList" :key="index">
                                            <div class="flex items-center justify-center space-x-2 py-0.5">
                                                <span class="material-icons-outlined text-green-500 text-[10px]">check_circle</span>
                                                <p class="text-[10px] font-medium text-gray-700 truncate" x-text="file.name"></p>
                                            </div>
                                        </template>
                                    </div>

                                    <input type="file" id="berkas" name="berkas[]" multiple required class="hidden"
                                        @change="fileList = Array.from($event.target.files)" />
                                </label>
                            </div>

                            <div class="w-full border rounded-full py-2.5 px-6 flex items-center justify-between text-xs font-semibold shadow-sm transition-all duration-300"
                                :class="fileList.length > 0 ? 'bg-green-50 border-green-300 text-green-700' : 'bg-white border-gray-300 text-gray-500'">
                                
                                <span x-text="fileList.length > 0 ? fileList.length + ' Berkas telah dipilih' : 'Belum Ada Berkas'"></span>
                                <span class="material-icons-outlined text-base" x-text="fileList.length > 0 ? 'cloud_done' : 'cloud_upload'"></span>
                            </div>

                            <div class="pt-8">
                                <button type="button" 
                                    @click="if(fileList.length > 0) { step = 4; } else { alert('Silakan pilih berkas terlebih dahulu!'); }" 
                                    class="w-full py-2.5 border border-gray-300 rounded-full text-xs font-bold text-gray-600 hover:bg-gray-50 transition flex items-center justify-center space-x-1.5">
                                    <span>Lanjutkan</span>
                                    <span class="material-icons-outlined text-sm">arrow_forward</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 4: WAKTU LAYANAN -->
                    <div x-show="step === 4" x-cloak class="bg-white rounded-[32px] border border-gray-200 shadow-sm p-10 transition-all">
                        <button type="button" @click="step = 3" class="flex items-center text-gray-400 hover:text-gray-700 mb-4 transition">
                            <span class="material-icons-outlined text-xl">arrow_back</span>
                        </button>
                        <h3 class="text-2xl font-bold text-gray-800 tracking-tight">Waktu Layanan</h3>
                        <p class="text-gray-400 text-xs mt-0.5 mb-8">Pilih waktu layanan dibawah ini</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                            <div @click="waktu_layanan = '08.00-12.00 WIB'" :class="waktu_layanan === '08.00-12.00 WIB' ? 'border-blue-500 bg-blue-50/30' : 'border-gray-200'" class="border-2 rounded-[24px] p-8 text-center cursor-pointer transition hover:border-blue-400 flex flex-col items-center justify-center min-h-[180px]">
                                <span class="text-5xl font-bold text-gray-700 mb-3">A</span>
                                <span class="text-xs font-semibold text-gray-500 tracking-wide">08.00-12.00 WIB</span>
                            </div>
                            <div @click="waktu_layanan = '13.30-16.00 WIB'" :class="waktu_layanan === '13.30-16.00 WIB' ? 'border-blue-500 bg-blue-50/30' : 'border-gray-200'" class="border-2 rounded-[24px] p-8 text-center cursor-pointer transition hover:border-blue-400 flex flex-col items-center justify-center min-h-[180px]">
                                <span class="text-5xl font-bold text-gray-700 mb-3">B</span>
                                <span class="text-xs font-semibold text-gray-500 tracking-wide">13.30-16.00 WIB</span>
                            </div>
                        </div>
                        <input type="hidden" name="waktu_layanan" :value="waktu_layanan" required>
                        <div>
                            <button type="button" @click="if(waktu_layanan !== '') { step = 5; } else { alert('Pilih salah satu waktu sesi layanan terlebih dahulu!'); }" class="w-full py-2.5 border border-gray-300 rounded-full text-xs font-bold text-gray-600 hover:bg-gray-50 transition flex items-center justify-center space-x-1.5">
                                <span>Kirim</span>
                                <span class="material-icons-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 5: DETAIL NOMOR ANTRIAN (Selesai & Alihkan) -->
                    <div x-show="step === 5" x-cloak class="bg-white rounded-[32px] border border-gray-200 shadow-sm p-10 transition-all flex flex-col items-center">
                        <h3 class="text-lg font-bold text-gray-500 tracking-tight mt-2">Nomor Antrian</h3>
                        <h3 class="text-lg font-bold text-gray-500 tracking-tight leading-none mb-6">Anda</h3>
                        <div class="text-[64px] font-bold text-gray-700 tracking-tight my-4 leading-none">A-09</div>
                        <div class="w-full max-w-md mt-8 space-y-4 text-xs px-4">
                            <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                                <span class="text-gray-400 font-medium">Jenis Pelayanan</span>
                                <span class="text-gray-700 font-bold" x-text="document.getElementById('layanan_pembayaran').checked ? 'Pembayaran UKT' : 'Administrasi Kampus'">Pembayaran UKT</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-400 font-medium">Waktu Pelayanan</span>
                                <span class="text-gray-700 font-bold" x-text="waktu_layanan">08.00-12.00 WIB</span>
                            </div>
                        </div>
                        <div class="w-full pt-12">
                            <!-- Link Diperbarui Ke Route Monitoring/Riwayat Berkas Asli Anda -->
                            <a href="{{ route('riwayat.antrian') }}" class="w-full py-2.5 bg-gray-900 border border-transparent rounded-full text-xs font-bold text-white hover:bg-gray-800 transition flex items-center justify-center space-x-1.5 shadow-sm">
                                <span>Monitoring Antrian</span>
                                <span class="material-icons-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                </form>
            </div>
        </main>
    </div>

</body>
</html>