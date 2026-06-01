<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - ANTRE.in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>
<body class="bg-[#F5F5F5] font-sans text-gray-800 antialiased" x-data="{ tab: 'edit_profil' }">

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
                    
                    <a href="#" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">analytics</span>
                        <span class="font-medium text-sm">Monitoring Antrian</span>
                    </a>
                    
                    <a href="{{ route('tambah.antrian') }}" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">add_box</span>
                        <span class="font-medium text-sm">Tambah Antrian</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 text-gray-400 hover:text-gray-900 transition p-3">
                        <span class="material-icons-outlined text-xl">history</span>
                        <span class="font-medium text-sm">Riwayat Antrian</span>
                    </a>
                    
                    <div class="relative flex items-center">
                        <div class="absolute left-[-24px] w-1.5 h-6 bg-black rounded-r-md"></div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 text-gray-900 font-bold p-3 w-full">
                            <span class="material-icons-outlined text-xl text-black">person</span>
                            <span class="text-sm">Akun Saya</span>
                        </a>
                    </div>
                </nav>
            </div>
        </aside>

        <main class="flex-1 p-8 md:p-12 flex justify-center items-start">
            <div class="w-full max-w-3xl">
                
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-gray-700 tracking-tight">Profil</h2>
                    
                    <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
                        @csrf
                    </form>
                    
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="flex items-center space-x-1.5 text-gray-600 hover:text-gray-900 transition text-sm font-medium">
                        <span class="material-icons-outlined text-lg">logout</span>
                        <span>Logout</span>
                    </a>
                </div>

                <div class="flex items-center space-x-3 mb-8">
                    <button type="button" @click="tab = 'edit_profil'"
                        :class="tab === 'edit_profil' ? 'bg-[#C4C4C4] text-gray-800 font-semibold border-transparent shadow-sm' : 'bg-white text-gray-500 border-gray-300 hover:bg-gray-50'"
                        class="px-6 py-1.5 border rounded-full text-xs transition duration-200">
                        Edit Profil
                    </button>

                    <button type="button" @click="tab = 'preferensi'"
                        :class="tab === 'preferensi' ? 'bg-[#C4C4C4] text-gray-800 font-semibold border-transparent shadow-sm' : 'bg-white text-gray-500 border-gray-300 hover:bg-gray-50'"
                        class="px-6 py-1.5 border rounded-full text-xs transition duration-200">
                        Preferensi
                    </button>

                    <button type="button" @click="tab = 'tentang'"
                        :class="tab === 'tentang' ? 'bg-[#C4C4C4] text-gray-800 font-semibold border-transparent shadow-sm' : 'bg-white text-gray-500 border-gray-300 hover:bg-gray-50'"
                        class="px-6 py-1.5 border rounded-full text-xs transition duration-200">
                        Tentang
                    </button>
                </div>

                @if (session('status') === 'profile-updated')
                    <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-6 py-2.5 rounded-full text-xs font-semibold shadow-sm">
                        Perubahan profil berhasil disimpan!
                    </div>
                @endif

                <div class="bg-white rounded-[32px] border border-gray-200 shadow-sm p-10 min-h-[400px]">
                    
                    <div x-show="tab === 'edit_profil'" class="transition-all">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('patch') <div class="flex flex-col md:flex-row gap-8 items-start">
                                
                                <div class="relative flex-shrink-0 mx-auto md:mx-0">
                                    <div id="avatar-preview" class="w-20 h-20 bg-gray-100 rounded-full border border-gray-300 flex items-center justify-center text-gray-400 overflow-hidden">
                                        @if(Auth::user()->avatar)
                                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Foto Profil" class="w-full h-full object-cover">
                                        @else
                                            <span class="material-icons-outlined text-5xl">account_circle</span>
                                        @endif
                                    </div>

                                    <button type="button" onclick="document.getElementById('avatar-input').click();" class="absolute bottom-0 right-0 w-7 h-7 bg-white border border-gray-300 rounded-full flex items-center justify-center shadow-sm text-gray-600 hover:bg-black hover:text-white transition cursor-pointer">
                                        <span class="material-icons-outlined text-sm">photo_camera</span>
                                    </button>

                                    <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*" onchange="previewImage(this)">
                                </div>

                                <div class="flex-1 w-full space-y-5">
                                    <div>
                                        <label class="block text-[11px] font-semibold text-gray-400 mb-1 pl-1">Nama Lengkap</label>
                                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full px-5 py-2 bg-white border border-gray-300 rounded-full text-xs text-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400 transition">
                                        @error('name') <span class="text-red-500 text-[10px] pl-2 block mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-semibold text-gray-400 mb-1 pl-1">NIM / ID</label>
                                        <input type="text" name="nim" value="{{ old('nim', Auth::user()->nim) }}" class="w-full px-5 py-2 bg-white border border-gray-300 rounded-full text-xs text-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400 transition">
                                        @error('nim') <span class="text-red-500 text-[10px] pl-2 block mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-semibold text-gray-400 mb-1 pl-1">Email</label>
                                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full px-5 py-2 bg-white border border-gray-300 rounded-full text-xs text-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400 transition">
                                        @error('email') <span class="text-red-500 text-[10px] pl-2 block mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-semibold text-gray-400 mb-1 pl-1">Nomor WhatsApp</label>
                                        <input type="text" name="whatsapp" value="{{ old('whatsapp', Auth::user()->whatsapp) }}" class="w-full px-5 py-2 bg-white border border-gray-300 rounded-full text-xs text-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400 transition">
                                        @error('whatsapp') <span class="text-red-500 text-[10px] pl-2 block mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="pt-4 flex justify-end">
                                        <button type="submit" class="px-8 py-2 bg-[#C4C4C4] hover:bg-gray-400 text-gray-800 font-bold rounded-full text-xs shadow-sm transition">
                                            Simpan
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>

                    <div x-show="tab === 'preferensi'" x-cloak class="transition-all">
                        <div class="border border-gray-300 rounded-[24px] p-6 text-xs text-gray-500 leading-relaxed space-y-4">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut volutpat vehicula accumsan. Nullam euismod placerat dui sed hendrerit. Maecenas vel purus mollis, fermentum nisi et, dictum quam.</p>
                        </div>
                    </div>

                    <div x-show="tab === 'tentang'" x-cloak class="transition-all">
                        <div class="border border-gray-300 rounded-[24px] p-6 text-xs text-gray-500 leading-relaxed space-y-4">
                            <p>Cras porttitor pulvinar mauris eu varius. Nullam quis pellentesque ante. Morbi iaculis sollicitudin nisl vel tincidunt. Nunc nec ante tincidunt, faucibus eros in, fringilla sem.</p>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var previewContainer = document.getElementById('avatar-preview');
                    previewContainer.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover">';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>