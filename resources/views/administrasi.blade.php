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

        
        <!-- KONTEN UTAMA SUB-MENU ADMINISTRASI -->
        <main class="flex-1 p-6 md:p-10 flex justify-center items-start">
            <div class="w-full max-w-6xl bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                
                <!-- HEADER ATAS -->
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

                <!-- GRID KARTU MENU ADMINISTRASI -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- 1. Pengajuan Skripsi/TA -->
                    <div class="border border-gray-200 rounded-3xl p-6 flex flex-col justify-between hover:shadow-md transition bg-white">
                            <div class="flex items-start space-x-4 mb-4">
                                <div class="w-20 h-20 bg-blue-50 text-blue-500 rounded-full flex-shrink-0 flex items-center justify-center">
                                    <span class="material-icons-outlined text-4xl">assignment</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Pengajuan Skripsi/TA</h3>
                                    <p class="text-gray-400 text-xs leading-relaxed">Proses administrasi awal pendaftaran tugas akhir bagi mahasiswa tingkat akhir yang telah memenuhi syarat SKS.</p>
                                </div>
                            </div>
                            <div class="border-t border-gray-100 pt-4">
                                <p class="text-xs font-bold text-gray-800 mb-2">Berkas persyaratan:</p>
                                <ol class="text-xs text-gray-500 list-decimal pl-4 space-y-1 mb-4">
                                    <li>Transkrip nilai terbaru yang telah disahkan.</li>
                                    <li>Lembar persetujuan judul dari dosen pembimbing.</li>
                                    <li>Bukti lunas pembayaran biaya pendidikan.</li>
                                </ol>
                                <a href="{{ route('tambah.antrian') }}" class="flex items-center justify-center w-full py-2.5 bg-gray-900 text-white text-xs font-bold rounded-xl hover:bg-gray-700 transition">
                                <span>Mulai Antri</span>
                                <span class="material-icons-outlined text-sm ml-1">chevron_right</span>
                            </a>
                            </div>
                        </div>

                    <!-- 2. Pendaftaran Magang dan PKL -->
                    <div class="border border-gray-200 rounded-3xl p-6 flex flex-col justify-between hover:shadow-md transition bg-white">
                            <div class="flex items-start space-x-4 mb-4">
                                <div class="w-20 h-20 bg-green-50 text-green-500 rounded-full flex-shrink-0 flex items-center justify-center">
                                    <span class="material-icons-outlined text-4xl">work</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Pendaftaran Magang dan PKL</h3>
                                    <p class="text-gray-400 text-xs leading-relaxed">Pengurusan surat pengantar resmi dari fakultas/universitas untuk keperluan magang.</p>
                                </div>
                            </div>
                            <div class="border-t border-gray-100 pt-4">
                                <p class="text-xs font-bold text-gray-800 mb-2">Berkas persyaratan:</p>
                                <ol class="text-xs text-gray-500 list-decimal pl-4 space-y-1 mb-4">
                                    <li>Surat permohonan magang dari mahasiswa.</li>
                                    <li>Proposal rencana kegiatan magang.</li>
                                    <li>Kartu Tanda Mahasiswa (KTM) yang masih berlaku.</li>
                                </ol>
                                <a href="{{ route('tambah.antrian') }}" class="flex items-center justify-center w-full py-2.5 bg-gray-900 text-white text-xs font-bold rounded-xl hover:bg-gray-700 transition">
                                    <span>Mulai Antri</span>
                                    <span class="material-icons-outlined text-sm ml-1">chevron_right</span>
                                </a>
                            </div>
                        </div>

                    <!-- 3. Surat Keterangan Aktif Kuliah -->
                    <div class="border border-gray-200 rounded-3xl p-6 flex flex-col justify-between hover:shadow-md transition bg-white">
                        <div class="flex items-start space-x-4 mb-4">
                            <div class="w-20 h-20 bg-indigo-50 text-indigo-500 rounded-full flex-shrink-0 flex items-center justify-center">
                                <span class="material-icons-outlined text-4xl">badge</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Surat Keterangan Aktif Kuliah</h3>
                                <p class="text-gray-400 text-xs leading-relaxed">Layanan penerbitan surat keterangan resmi status mahasiswa aktif.</p>
                            </div>
                        </div>
                        <div class="border-t border-gray-100 pt-4">
                            <p class="text-xs font-bold text-gray-800 mb-2">Berkas persyaratan:</p>
                            <ol class="text-xs text-gray-500 list-decimal pl-4 space-y-1 mb-4">
                                <li>Fotokopi KTM.</li>
                                <li>Bukti pembayaran UKT semester berjalan.</li>
                                <li>Formulir permohonan surat keterangan.</li>
                            </ol>
                            <a href="{{ route('tambah.antrian') }}" class="flex items-center justify-center w-full py-2.5 bg-gray-900 text-white text-xs font-bold rounded-xl hover:bg-gray-700 transition">
                                <span>Mulai Antri</span>
                                <span class="material-icons-outlined text-sm ml-1">chevron_right</span>
                            </a>
                        </div>
                    </div>

                    <!-- 4. Penggantian KTM -->
                    <div class="border border-gray-200 rounded-3xl p-6 flex flex-col justify-between hover:shadow-md transition bg-white">
                            <div class="flex items-start space-x-4 mb-4">
                                <div class="w-20 h-20 bg-amber-50 text-amber-500 rounded-full flex-shrink-0 flex items-center justify-center">
                                    <span class="material-icons-outlined text-4xl">credit_card</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Penggantian KTM</h3>
                                    <p class="text-gray-400 text-xs leading-relaxed">Layanan untuk penggantian kartu mahasiswa yang hilang atau rusak.</p>
                                </div>
                            </div>
                            <div class="border-t border-gray-100 pt-4">
                                <p class="text-xs font-bold text-gray-800 mb-2">Berkas persyaratan:</p>
                                <ol class="text-xs text-gray-500 list-decimal pl-4 space-y-1 mb-4">
                                    <li>Surat kehilangan dari kepolisian.</li>
                                    <li>KTM yang rusak (untuk kasus rusak).</li>
                                    <li>Pas foto terbaru ukuran 3x4.</li>
                                </ol>
                                <a href="{{ route('tambah.antrian') }}" class="flex items-center justify-center w-full py-2.5 bg-gray-900 text-white text-xs font-bold rounded-xl hover:bg-gray-700 transition">
                                    <span>Mulai Antri</span>
                                    <span class="material-icons-outlined text-sm ml-1">chevron_right</span>
                                </a>
                            </div>
                        </div>

                    <!-- 5. Pengajuan Cuti Kuliah -->
                    <div class="border border-gray-200 rounded-3xl p-6 flex flex-col justify-between hover:shadow-md transition bg-white">
                            <div class="flex items-start space-x-4 mb-4">
                                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex-shrink-0 flex items-center justify-center">
                                    <span class="material-icons-outlined text-4xl">event_busy</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Pengajuan Cuti Kuliah</h3>
                                    <p class="text-gray-400 text-xs leading-relaxed">Prosedur resmi penangguhan masa studi semester tertentu.</p>
                                </div>
                            </div>
                            <div class="border-t border-gray-100 pt-4">
                                <p class="text-xs font-bold text-gray-800 mb-2">Berkas persyaratan:</p>
                                <ol class="text-xs text-gray-500 list-decimal pl-4 space-y-1 mb-4">
                                    <li>Surat permohonan cuti bermaterai.</li>
                                    <li>Surat izin atau rekomendasi dari orang tua/wali.</li>
                                    <li>Transkrip nilai.</li>
                                </ol>
                                <a href="{{ route('tambah.antrian') }}" class="flex items-center justify-center w-full py-2.5 bg-gray-900 text-white text-xs font-bold rounded-xl hover:bg-gray-700 transition">
                                    <span>Mulai Antri</span>
                                    <span class="material-icons-outlined text-sm ml-1">chevron_right</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</x-app-layout>