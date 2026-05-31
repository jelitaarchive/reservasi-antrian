<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 font-sans text-gray-800">
        
        <aside class="w-64 bg-white border-r border-gray-200 p-6 flex flex-col justify-between hidden md:flex">
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
                    <a href="{{ route('antrean.riwayat') }}" class="flex items-center space-x-3 text-gray-900 font-semibold bg-gray-100 p-3 rounded-xl">
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
            <div class="w-full max-w-6xl bg-white rounded-3xl shadow-sm border border-gray-100 p-8 relative min-h-[600px]">
                
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                    <div class="flex items-start space-x-4">
                        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-900 transition mt-1">
                            <span class="material-icons-outlined text-2xl">arrow_back</span>
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 leading-tight">Riwayat<br>Antrian</h1>
                        </div>
                    </div>

                    <div class="flex-1 max-w-md mx-0 md:mx-8">
                        <div class="relative">
                            <input type="text" placeholder="Cari..." class="w-full px-5 py-2 pl-12 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent text-sm">
                            <span class="material-icons-outlined absolute left-4 top-2.5 text-gray-400 text-sm">search</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 self-end md:self-center">
                        <div class="text-right">
                            <h4 class="font-bold text-gray-900">Halo, {{ Auth::user()->name }}</h4>
                            <p class="text-xs text-gray-400">STI202303000</p>
                        </div>
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 border border-gray-300">
                            <span class="material-icons-outlined">account_circle</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 max-w-4xl mb-20">
                    @forelse($histories as $history)
                        <div class="border border-gray-300 bg-gray-100 rounded-[32px] p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 hover:shadow-md transition">
                            
                            <div class="flex items-center space-x-4 flex-shrink-0">
                                <div class="flex -space-x-4 bg-white p-2 rounded-xl border border-gray-200 shadow-sm">
                                    <div class="w-12 h-16 bg-gray-50 border border-gray-300 rounded shadow-sm flex items-center justify-center text-[10px] text-gray-400 font-mono">DOC</div>
                                    <div class="w-12 h-16 bg-gray-50 border border-gray-300 rounded shadow-sm flex items-center justify-center text-[10px] text-gray-400 font-mono">PDF</div>
                                </div>
                                <span class="text-sm font-bold text-gray-600">+1</span>
                            </div>

                            <div class="flex-1 text-gray-700">
                                <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $history->title }}</h3>
                                <p class="text-xs font-semibold text-gray-500">
                                    Hari, Tanggal : <span class="font-normal text-gray-600">{{ \Carbon\Carbon::parse($history->date)->translatedFormat('l, j F Y') }}</span>
                                </p>
                                <p class="text-xs font-semibold text-gray-500 mb-2">
                                    Jam : <span class="font-normal text-gray-600">{{ \Carbon\Carbon::parse($history->start_time)->format('H.i') }} - {{ \Carbon\Carbon::parse($history->end_time)->format('H.i') }} WIB</span>
                                </p>
                                <p class="text-xs text-gray-500 leading-relaxed max-w-xl">
                                    {{ $history->description }}
                                </p>
                            </div>

                        </div>
                    @empty
                        <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-[32px]">
                            <span class="material-icons-outlined text-4xl text-gray-300 mb-2">history_toggle_off</span>
                            <p class="text-sm text-gray-400">Belum ada riwayat antrian saat ini.</p>
                        </div>
                    @endforelse
                </div>

                <div class="absolute bottom-4 right-8 w-44 h-44 opacity-80 pointer-events-none hidden lg:block">
                    <div class="w-full h-full flex flex-col justify-end items-end text-right text-xs text-gray-300 font-mono">
                        <span>[ Ilustrasi ]</span>
                        <span>Cat & Girl</span>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</x-app-layout>