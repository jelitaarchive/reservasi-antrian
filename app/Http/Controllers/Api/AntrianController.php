<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Antrian;

use Illuminate\Http\Request;



class AntrianController extends Controller
{


public function store(Request $request)
{


$antrian = Antrian::create([


'nama'=>$request->nama,


'nim'=>$request->nim,


'email'=>$request->email,


'whatsapp'=>$request->whatsapp,


'jenis_layanan'=>$request->jenis_layanan,


'kategori_layanan'=>$request->kategori_layanan,


'metode_pembayaran'=>$request->metode_pembayaran,


'waktu_layanan'=>$request->waktu_layanan,


'nomor_antrian'=>$request->nomor_antrian,


'tanggal_antrian'=>now(),


'status'=>$request->status,


'bukti_transfer'=>$request->bukti_transfer


]);


return response()->json([


'message'=>'berhasil',


'data'=>$antrian


]);


}



public function riwayat($nim)
{


$data = Antrian::where(

'nim',

$nim

)

->latest()

->get();


return response()->json(

$data

);


}



}