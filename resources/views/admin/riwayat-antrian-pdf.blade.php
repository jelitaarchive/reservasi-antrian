<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<style>

body{
font-family: DejaVu Sans;
font-size:12px;
}

table{
width:100%;
border-collapse:collapse;
}

table,th,td{
border:1px solid black;
}

th,td{
padding:8px;
text-align:left;
}

h2{
text-align:center;
}

</style>

</head>

<body>

<h2>Riwayat Antrian ANTRE.in</h2>

<p>
Tanggal Export :
{{ date('d-m-Y H:i') }}
</p>

<table>

<thead>

<tr>

<th>NIM</th>

<th>Nama</th>

<th>No Antrian</th>

<th>Layanan</th>

<th>Tanggal</th>

<th>Waktu</th>

<th>Status</th>

</tr>

</thead>

<tbody>

@foreach($riwayat as $item)

<tr>

<td>{{ $item->nim }}</td>

<td>{{ $item->nama }}</td>

<td>{{ $item->nomor_antrian }}</td>

<td>{{ $item->jenis_layanan }}</td>

<td>{{ $item->tanggal_antrian }}</td>

<td>{{ $item->waktu_layanan }}</td>

<td>{{ $item->status }}</td>

</tr>

@endforeach

</tbody>

</table>

</body>

</html>