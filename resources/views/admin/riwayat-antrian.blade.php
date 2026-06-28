<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Antrian - ANTRE.in</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
</head>

<body class="bg-[#efefef] font-sans text-gray-800 antialiased">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-200 border-r border-gray-300 p-6 flex flex-col justify-between hidden md:flex">

        <div>

            <div class="text-2xl font-bold tracking-wider text-gray-900 mb-2 pl-2">
                ANTRE.in
            </div>

            <div class="text-xs font-bold text-gray-500 mb-8 pl-2 uppercase tracking-widest">
                Admin
            </div>

            <nav class="space-y-1">

                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">

                    <span class="material-icons-outlined">
                        home
                    </span>

                    <span class="font-medium text-sm">
                        Dashboard
                    </span>

                </a>


                <a href="{{ route('admin.kelola.antrian') }}"
                   class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">

                    <span class="material-icons-outlined">
                        dashboard
                    </span>

                    <span class="font-medium text-sm">
                        Kelola Antrian
                    </span>

                </a>


                <a href="{{ route('admin.kelola-layanan') }}"
                   class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">

                    <span class="material-icons-outlined">
                        headset_mic
                    </span>

                    <span class="font-medium text-sm">
                        Kelola Layanan
                    </span>

                </a>


                <a href="{{ route('admin.kelola.mahasiswa') }}"
                   class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">

                    <span class="material-icons-outlined">
                        people_outline
                    </span>

                    <span class="font-medium text-sm">
                        Kelola Mahasiswa
                    </span>

                </a>


                <a href="{{ route('admin.verifikasi.berkas') }}"
                   class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">

                    <span class="material-icons-outlined">
                        description
                    </span>

                    <span class="font-medium text-sm">
                        Verifikasi Berkas
                    </span>

                </a>


                <a href="#"
                   class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">

                    <span class="material-icons-outlined">
                        group
                    </span>

                    <span class="font-medium text-sm">
                        Kelola Admin
                    </span>

                </a>


                <a href="#"
                   class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">

                    <span class="material-icons-outlined">
                        picture_as_pdf
                    </span>

                    <span class="font-medium text-sm">
                        Laporan PDF
                    </span>

                </a>


                <a href="{{ route('admin.monitoring') }}"
                   class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">

                    <span class="material-icons-outlined">
                        insert_chart_outlined
                    </span>

                    <span class="font-medium text-sm">
                        Monitoring Antrian
                    </span>

                </a>


                <!-- Menu Aktif -->
                <div class="bg-gray-800 rounded-xl">

                    <a href="{{ route('admin.riwayat') }}"
                       class="flex items-center space-x-3 text-white font-bold p-3">

                        <span class="material-icons-outlined">
                            history
                        </span>

                        <span class="text-sm">
                            Riwayat Antrian
                        </span>

                    </a>

                </div>


                <a href="{{ route('admin.profile.edit') }}"
                   class="flex items-center space-x-3 text-gray-600 hover:text-gray-900 transition p-3">

                    <span class="material-icons-outlined">
                        account_box
                    </span>

                    <span class="font-medium text-sm">
                        Profil Admin
                    </span>

                </a>

            </nav>

        </div>


        <div class="border-t border-gray-400 pt-4">

            <form method="POST"
                  action="{{ route('logout') }}">

                @csrf

                <button type="submit"
                        class="flex items-center space-x-3 text-gray-600 hover:text-red-600 transition p-3 w-full text-left">

                    <span class="font-medium text-sm">

                        Logout

                    </span>

                </button>

            </form>

        </div>

    </aside>



    <!-- CONTENT -->

    <main class="flex-1 p-10">

        <div class="max-w-7xl mx-auto">

            <h1 class="text-3xl font-bold mb-8">

                Riwayat Antrian

            </h1>


            <div class="flex justify-between items-center mb-6">

                <div class="flex gap-4">

                    <input
                        type="text"
                        placeholder="12/05/2025 - 19/05/2025"
                        class="bg-white border rounded-xl px-4 py-3 w-64">

                    <select
                        class="bg-white border rounded-xl px-4 py-3 w-56">

                        <option>

                            Semua Layanan

                        </option>

                    </select>

                </div>


                <button
                    class="bg-black text-white px-6 py-3 rounded-xl">

                    Export

                </button>

            </div>



            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                <table class="w-full">

                    <thead class="bg-gray-100">

                    <tr>

                        <th class="p-4 text-left">
                            NIM
                        </th>

                        <th class="p-4 text-left">
                            Nama
                        </th>

                        <th class="p-4 text-left">
                            No Antrian
                        </th>

                        <th class="p-4 text-left">
                            Layanan
                        </th>

                        <th class="p-4 text-left">
                            Waktu Daftar
                        </th>

                        <th class="p-4 text-left">
                            Waktu Selesai
                        </th>

                        <th class="p-4 text-left">
                            Status
                        </th>

                    </tr>

                    </thead>

                    <tbody>

@forelse($riwayat as $item)

<tr class="border-b">

    <td class="p-4">
        {{ $item->nim }}
    </td>

    <td class="p-4">
        {{ $item->nama }}
    </td>

    <td class="p-4">
        {{ $item->nomor_antrian }}
    </td>

    <td class="p-4">
        {{ $item->jenis_layanan }}
    </td>

    <td class="p-4">
        {{ $item->tanggal_antrian }}
    </td>

    <td class="p-4">
        {{ $item->waktu_layanan }}
    </td>

    <td class="p-4">

        <span
            class="bg-green-100
                   text-green-600
                   px-3
                   py-1
                   rounded-full
                   text-xs">

            {{ $item->status }}

        </span>

    </td>

</tr>

@empty

<tr>

<td colspan="7"
class="text-center py-8 text-gray-500">

Belum ada riwayat antrian

</td>

</tr>

@endforelse

</tbody>

                </table>

            </div>


            <div class="mt-8">

            {{ $riwayat->links() }}

            </div>

        </div>

    </main>

</div>

</body>
</html>