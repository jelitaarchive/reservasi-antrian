<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ANTRE.in - Cetak Laporan PDF</title>
    <style>
        /* Standarisasi Font & Warna Sesuai Vibe Projek ANTRE.in */
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            font-size: 12px; 
            color: #1f2937; /* text-gray-800 */
            background-color: #ffffff;
            margin: 0;
            padding: 10px;
        }
        
        /* Kop Header Laporan Minimalis & Bold */
        .header { 
            margin-bottom: 25px; 
            border-bottom: 2px solid #111827; /* border-gray-900 */
            padding-bottom: 15px; 
        }
        .header h2 { 
            margin: 0; 
            font-size: 22px; 
            font-weight: bold;
            letter-spacing: 0.05em;
            color: #111827; /* text-gray-900 */
        }
        .header p { 
            margin: 4px 0 0 0; 
            font-size: 11px;
            color: #6b7280; /* text-gray-500 */
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: bold;
        }

        /* Informasi Periode */
        .meta-info { 
            margin-bottom: 20px; 
            font-size: 13px;
            font-weight: bold;
            color: #374151; /* text-gray-700 */
        }
        .meta-info span {
            color: #111827;
            background-color: #f3f4f6;
            padding: 3px 8px;
            border-radius: 4px;
        }

        /* Styling Tabel Custom Mirip Struktur Tailwind */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        th, td { 
            border: 1px solid #e5e7eb; /* border-gray-200 */
            padding: 12px 10px; 
            text-align: left; 
        }
        th { 
            background-color: #f3f4f6; /* bg-gray-100 */
            color: #374151; /* text-gray-700 */
            font-size: 11px;
            font-weight: bold; 
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        tr:nth-child(even) {
            background-color: #f9fafb; /* Efek zebra strip strip tipis */
        }
        
        /* Helper Class Data */
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .text-blue { color: #2563eb; } /* Khas warna nomor antrean */
        
        /* Badge Status Sesuai Standar Projek */
        .status {
            font-size: 10px;
            font-weight: bold;
            padding: 4px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            display: inline-block;
        }
        .status-selesai { 
            background-color: #ecfdf5; /* bg-emerald-50 */
            color: #059669; /* text-emerald-600 */
        }
        .status-batal { 
            background-color: #fef2f2; /* bg-red-50 */
            color: #dc2626; /* text-red-600 */
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>ANTRE.in</h2>
        <p>Laporan Resmi Riwayat Antrean Layanan Administrasi Kampus</p>
    </div>

    <div class="meta-info">
        Periode Rekapitulasi: <span>{{ $bulan }} {{ $tahun }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 8%">No</th>
                <th>Nama Mahasiswa</th>
                <th class="text-center" style="width: 15%">No Antrean</th>
                <th>Jenis Layanan</th>
                <th>Tanggal Masuk</th>
                <th class="text-center" style="width: 15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataLaporan as $key => $item)
            <tr>
                <td class="text-center" style="color: #6b7280;">{{ $key + 1 }}</td>
                <td class="font-bold" style="color: #111827;">{{ $item->nama ?? 'N/A' }}</td>
                <td class="text-center font-bold text-blue">{{ $item->nomor_antrian ?? $item->no_antrian ?? '-' }}</td>
                <td style="color: #4b5563;">{{ $item->jenis_layanan ?? '-' }}</td>
                <td style="color: #6b7280;">{{ date('d M Y', strtotime($item->created_at)) }}</td>
                <td class="text-center">
                    @if(strtolower($item->status) == 'selesai')
                        <span class="status status-selesai">Selesai</span>
                    @else
                        <span class="status status-batal">Batal</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>