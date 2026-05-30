<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ANTRE.in - Selamat Datang</title>
    <!-- Menggunakan Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
        }
    </style>
</head>
<body class="bg-[#EAEAEA] min-h-screen flex flex-col justify-between m-0 p-0">

    <!-- NAVBAR (Logo ANTRE.in bergeser ke tengah) -->
    <nav class="flex items-center justify-center w-full py-8 bg-transparent">
        <div class="text-4xl font-black tracking-tight text-black text-center">
            ANTRE.in
        </div>
    </nav>

    <!-- BODY UTAMA -->
    <main class="flex-grow flex items-center px-16 py-4">
        <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-12 items-center">
            
            <!-- Sisi Kiri: Kotak Utama Abu-Abu -->
            <div class="bg-[#CBD5E1] rounded-[40px] p-12 max-w-xl shadow-sm mx-auto md:mx-0">
                <h1 class="text-5xl font-black tracking-wide text-black mb-6">
                    SELAMAT<br>DATANG
                </h1>
                <p class="text-black text-lg leading-relaxed font-normal mb-8">
                    Sistem manajemen antrean online terintegrasi. Pantau, jadwalkan, dan lakukan reservasi dengan lebih mudah dan efisien tanpa perlu mengantre secara fisik.
                </p>
                <a href="/login" class="inline-block px-10 py-4 text-2xl font-medium text-white bg-black rounded-[30px] hover:bg-gray-800 transition duration-200">
                    Mulai
                </a>
            </div>

            <!-- Sisi Kanan: Tombol Masuk & Daftar Atas-Bawah -->
            <div class="flex flex-col items-center md:items-end justify-center pr-0 md:pr-12 gap-5 w-full">
                <!-- Tombol Masuk -->
                <a href="/login" class="w-full max-w-md py-4 text-2xl font-medium text-black text-center bg-transparent border-2 border-black rounded-[30px] hover:bg-black/5 transition duration-200">
                    Masuk
                </a>
                
                <!-- Tombol Daftar -->
                <a href="/register" class="w-full max-w-md py-4 text-2xl font-medium text-black text-center bg-transparent border-2 border-black rounded-[30px] hover:bg-black/5 transition duration-200">
                    Daftar
                </a>
            </div>

        </div>
    </main>

    <!-- FOOTER (Teks hak cipta bergeser ke tengah) -->
    <footer class="w-full py-6 text-center text-sm text-gray-500 font-medium">
        &copy; 2026 ANTRE.in. All rights reserved.
    </footer>

</body>
</html>