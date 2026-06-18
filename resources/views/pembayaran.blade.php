<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 font-sans text-gray-800">
        
        <!-- SIDEBAR KIRI -->
        <aside class="w-64 bg-gray-200 border-r border-gray-300 p-6 flex flex-col justify-between hidden md:flex">
            <div>
                <div class="text-2xl font-bold tracking-wider text-gray-900 mb-10">
                    ANTRE.in
                </div>
                <nav class="space-y-4">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">home</span>
                        <span>Beranda</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">analytics</span>
                        <span>Monitoring Antrian</span>
                    </a>
                    <a href="{{ route('tambah.antrian') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">add_box</span>
                        <span>Tambah Antrian</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">history</span>
                        <span>Riwayat Antrian</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">person</span>
                        <span>Akun Saya</span>
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 p-6 md:p-10 flex justify-center items-start">
            <div class="w-full max-w-6xl bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                
                <!-- HEADER -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('dashboard') }}" class="w-10 h-10 bg-gray-50 border border-gray-200 rounded-full flex items-center justify-center text-gray-600 hover:bg-gray-100 transition">
                            <span class="material-icons-outlined">arrow_back</span>
                        </a>
                        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Beranda</h2>
                    </div>


                    <div class="flex items-center space-x-3 self-end md:self-auto">
                        <div class="text-right">
                            <h4 class="font-bold text-gray-900 text-sm">Halo, {{ Auth::user()->name }}</h4>
                            <p class="text-xs text-gray-400">STI202303000</p>
                        </div>
                        <div class="w-8 h-8 bg-gray-100 rounded-full border border-gray-300 flex items-center justify-center overflow-hidden">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Foto Profil" class="w-full h-full object-cover">
                            @else
                                <span class="material-icons-outlined text-xl text-gray-400">account_circle</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- GRID KARTU MENU PEMBAYARAN -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Pembayaran UKT -->
                <div class="border border-gray-200 rounded-3xl p-6 flex flex-col hover:shadow-lg transition bg-white">
                        <div class="flex items-start space-x-4 mb-4">
                            <div class="w-16 h-16 bg-blue-50 rounded-2xl flex-shrink-0 flex items-center justify-center text-blue-500">
                                <span class="material-icons-outlined text-3xl">school</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Pembayaran UKT</h3>
                                <p class="text-gray-400 text-xs leading-relaxed">Pembayaran biaya operasional pendidikan rutin setiap semester.</p>
                            </div>
                        </div>
                        <div class="border-t border-gray-100 pt-4 mt-auto">
                            <p class="text-xs font-bold text-gray-800 mb-2">Berkas persyaratan:</p>
                            <ol class="text-xs text-gray-500 list-decimal pl-4 space-y-1 mb-4">
                                <li>Kartu Rencana Studi (KRS) semester berjalan.</li>
                                <li>Tagihan resmi dari sistem informasi akademik.</li>
                                <li>Bukti bayar (jika ada kendala transaksi).</li>
                            </ol>
                            <a href="{{ route('tambah.antrian') }}" class="flex items-center justify-center w-full py-2.5 bg-gray-900 text-white text-xs font-bold rounded-xl hover:bg-gray-700 transition">
                                <span>Mulai Antri</span>
                                <span class="material-icons-outlined text-sm ml-1">chevron_right</span>
                            </a>
                        </div>
                    </div>

                    <!-- Pembayaran KKL -->
                    <div class="border border-gray-200 rounded-3xl p-6 flex flex-col hover:shadow-lg transition bg-white">
                            <div class="flex items-start space-x-4 mb-4">
                                <div class="w-16 h-16 bg-green-50 rounded-2xl flex-shrink-0 flex items-center justify-center text-green-500">
                                    <span class="material-icons-outlined text-3xl">directions_bus</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Pembayaran KKL</h3>
                                    <p class="text-gray-400 text-xs leading-relaxed">Pembayaran dana kegiatan KKL untuk transportasi, akomodasi, dan program lapangan.</p>
                                </div>
                            </div>
                            <div class="border-t border-gray-100 pt-4 mt-auto">
                                <p class="text-xs font-bold text-gray-800 mb-2">Berkas persyaratan:</p>
                                <ol class="text-xs text-gray-500 list-decimal pl-4 space-y-1 mb-4">
                                    <li>Lembar persetujuan mengikuti KKL.</li>
                                    <li>Slip pembayaran dari pihak panitia/jurusan.</li>
                                    <li>Kartu Tanda Mahasiswa (KTM) aktif.</li>
                                </ol>
                                <a href="{{ route('tambah.antrian') }}" class="flex items-center justify-center w-full py-2.5 bg-gray-900 text-white text-xs font-bold rounded-xl hover:bg-gray-700 transition">
                                    <span>Mulai Antri</span>
                                    <span class="material-icons-outlined text-sm ml-1">chevron_right</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Pengajuan Keringanan UKT -->
                    <div class="border border-gray-200 rounded-3xl p-6 flex flex-col hover:shadow-lg transition bg-white">
                        <div class="flex items-start space-x-4 mb-4">
                            <div class="w-16 h-16 bg-orange-50 rounded-2xl flex-shrink-0 flex items-center justify-center text-orange-500">
                                <span class="material-icons-outlined text-3xl">payments</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Pengajuan Keringanan UKT</h3>
                                <p class="text-gray-400 text-xs leading-relaxed">Layanan bagi mahasiswa yang mengajukan permohonan penyesuaian/angsuran biaya pendidikan karena kondisi ekonomi atau kendala tertentu.</p>
                            </div>
                        </div>
                        <div class="border-t border-gray-100 pt-4 mt-auto">
                            <p class="text-xs font-bold text-gray-800 mb-2">Berkas persyaratan:</p>
                            <ol class="text-xs text-gray-500 list-decimal pl-4 space-y-1 mb-4">
                                <li>Surat permohonan keringanan bermaterai.</li>
                                <li>Surat keterangan penghasilan orang tua/wali.</li>
                                <li>Kartu Keluarga (KK) dan dokumen pendukung lainnya.</li>
                            </ol>
                            <a href="{{ route('tambah.antrian') }}" class="flex items-center justify-center w-full py-2.5 bg-gray-900 text-white text-xs font-bold rounded-xl hover:bg-gray-700 transition">
                                <span>Mulai Antri</span>
                                <span class="material-icons-outlined text-sm ml-1">chevron_right</span>
                            </a>
                        </div>
                    </div>

                    <!-- Pembayaran Non-Akademik -->
                    <div class="border border-gray-200 rounded-3xl p-6 flex flex-col hover:shadow-lg transition bg-white">
                        <div class="flex items-start space-x-4 mb-4">
                            <div class="w-16 h-16 bg-purple-50 rounded-2xl flex-shrink-0 flex items-center justify-center text-purple-500">
                                <span class="material-icons-outlined text-3xl">receipt_long</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Pembayaran Non-Akademik</h3>
                                <p class="text-gray-400 text-xs leading-relaxed">Pembayaran layanan di luar akademik seperti denda perpustakaan, biaya sewa fasilitas kampus, atau biaya sertifikasi.</p>
                            </div>
                        </div>
                        <div class="border-t border-gray-100 pt-4 mt-auto">
                            <p class="text-xs font-bold text-gray-800 mb-2">Berkas persyaratan:</p>
                            <ol class="text-xs text-gray-500 list-decimal pl-4 space-y-1 mb-4">
                                <li>Surat keterangan denda/biaya dari unit terkait.</li>
                                <li>Identitas diri (KTM/KTP).</li>
                                <li>Slip pembayaran atau kode billing dari sistem.</li>
                            </ol>
                            <a href="{{ route('tambah.antrian') }}" class="flex items-center justify-center w-full py-2.5 bg-gray-900 text-white text-xs font-bold rounded-xl hover:bg-gray-700 transition">
                                <span>Mulai Antri</span>
                                <span class="material-icons-outlined text-sm ml-1">chevron_right</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</x-app-layout>