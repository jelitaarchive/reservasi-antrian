<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Antrian - ANTRE.in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>
<body class="bg-[#F5F5F5] font-sans text-gray-800 antialiased">

    <div class="flex min-h-screen">
        
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
                    
                    <a href="{{ route('monitoring.antrian') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">analytics</span>
                        <span class="font-medium text-sm">Monitoring Antrian</span>
                    </a>
                    
                    <a href="{{ route('tambah.antrian') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">add_box</span>
                        <span class="font-medium text-sm">Tambah Antrian</span>
                    </a>
                    
                    <div class="relative flex items-center">
                        <div class="absolute left-[-24px] w-1.5 h-6 bg-black rounded-r-md"></div>
                        <a href="{{ route('riwayat.antrian') }}" class="flex items-center space-x-3 text-gray-900 font-bold p-3 w-full">
                            <span class="material-icons-outlined text-xl text-black">history</span>
                            <span class="text-sm">Riwayat Antrian</span>
                        </a>
                    </div>
                    
                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">person</span>
                        <span class="font-medium text-sm">Akun Saya</span>
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 p-8 md:p-12">
            <div class="w-full max-w-4xl mx-auto">
                
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-700 tracking-tight">Riwayat Antrian</h2>
                        <p class="text-xs text-gray-400 mt-1">Daftar seluruh antrean pelayanan Anda</p>
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

                <div class="space-y-4">
                    @forelse($histories as $history)
                        @php
                            $status = isset($history->status) ? strtolower($history->status) : '';
                            $description = isset($history->description) ? strtolower($history->description) : '';
                            $isBatal = (Str::contains($status, 'batal') || Str::contains($description, 'batal'));
                        @endphp

                        <div class="bg-white border border-gray-200 rounded-[24px] p-6 shadow-sm flex flex-col md:flex-row md:items-start md:justify-between gap-4 hover:border-gray-300 transition-all">
                            <div class="flex items-start space-x-4 flex-1">
                                @if($isBatal)
                                    <div class="p-3 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center border border-red-100">
                                        <span class="material-icons-outlined text-2xl">cancel</span>
                                    </div>
                                @else
                                    <div class="p-3 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center border border-green-100">
                                        <span class="material-icons-outlined text-2xl">check_circle</span>
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        {{-- MODIFIKASI: Menampilkan Kategori Layanan --}}
                                        <h4 class="font-bold text-gray-800 text-sm">{{ $history->kategori_layanan ?? 'Pelayanan Antrian' }}</h4>
                                        
                                        @if($isBatal)
                                            <span class="px-2.5 py-0.5 bg-red-100 text-red-700 rounded-full text-[10px] font-bold border border-red-200">Gagal / Batal</span>
                                        @else
                                            <span class="px-2.5 py-0.5 bg-green-100 text-green-700 rounded-full text-[10px] font-bold border border-green-200">Sukses Selesai</span>
                                        @endif
                                    </div>
                                    
                                    <p class="text-xs text-gray-500 mt-1 flex items-center gap-1.5">
                                        <span class="material-icons-outlined text-xs">calendar_today</span>
                                        {{-- MODIFIKASI: Menggunakan tanggal_antrian --}}
                                        {{ $history->tanggal_antrian ? \Carbon\Carbon::parse($history->tanggal_antrian)->translatedFormat('d F Y') : '-' }}
                                        
                                        <span class="mx-1">•</span>
                                        
                                        <span class="material-icons-outlined text-xs">schedule</span>
                                        {{-- MODIFIKASI: Menggunakan waktu_layanan --}}
                                        {{ $history->waktu_layanan ?? '--:--' }} WIB
                                    </p>
                                    
                                    @if($history->description)
                                        <p class="text-[11px] text-gray-400 mt-2 bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-100 max-w-xl italic">
                                            "{!! nl2br(e($history->description)) !!}"
                                        </p>
                                    @endif

                                    <div class="mt-3">
                                        @php
                                            $docRaw = trim($history->dokumen ?? '');
                                            $docRaw = trim($docRaw, '[]"\''); 
                                            $documents = array_filter(explode(',', $docRaw), 'trim');
                                        @endphp

                                        @if(count($documents) > 0) 
                                            <div class="flex flex-wrap gap-2 mt-1">
                                                @foreach($documents as $index => $singleDoc)
                                                    @php $cleanPath = stripslashes(trim($singleDoc, '"\' ')); @endphp
                                                    <div class="inline-flex items-center space-x-2 bg-green-50 border border-green-200 py-1.5 px-3 rounded-xl max-w-xs shadow-sm">
                                                        <span class="material-icons-outlined text-green-600 text-sm flex-shrink-0">description</span>
                                                        <p class="text-[11px] font-bold text-gray-700 truncate w-24">
                                                            Berkas {{ $index + 1 }}
                                                        </p>
                                                        <a href="{{ asset('storage/' . $cleanPath) }}" target="_blank" class="p-1 hover:bg-green-100 rounded-md transition text-green-700 flex items-center">
                                                            <span class="material-icons-outlined text-xs">visibility</span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="flex items-center space-x-1.5 text-gray-400 italic text-[11px] mt-1">
                                                <span class="material-icons-outlined text-sm">info</span>
                                                <span>Tidak ada lampiran dokumen berkas</span>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>
                            
                            {{-- MODIFIKASI: Mengganti label ID Sesi menjadi No. Antrian dan memanggil nomor_antrian --}}
                            <div class="text-right flex md:flex-col items-center md:items-end justify-between md:justify-center border-t md:border-t-0 pt-3 md:pt-0 border-gray-100 min-w-[100px]">
                                <span class="text-xs font-bold text-gray-400 md:mb-1 block">No. Antrian</span>
                                <span class="text-xl font-black text-blue-600 tracking-tight">{{ $history->nomor_antrian ?? '-' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white border border-gray-200 rounded-[32px] p-12 text-center shadow-sm">
                            <span class="material-icons-outlined text-gray-300 text-6xl mb-3">history_toggle_off</span>
                            <h4 class="font-bold text-gray-700 text-sm">Belum Ada Riwayat Antrian</h4>
                            <p class="text-xs text-gray-400 mt-1 max-w-sm mx-auto">Anda belum pernah menambahkan atau memiliki riwayat pengajuan antrean pelayanan.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </main>
    </div>

</body>
</html>