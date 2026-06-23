<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Antrian;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransController extends Controller
{

public function create($id)
{

Config::$serverKey=
config('services.midtrans.server_key');

Config::$isProduction=false;
Config::$isSanitized=true;
Config::$is3ds=true;


$antrian=
Antrian::findOrFail($id);


$order_id='ORDER-'.time();



$params=[


'transaction_details'=>[

'order_id'=>$order_id,

'gross_amount'=>10000

],


'customer_details'=>[

'first_name'=>$antrian->nama,

'email'=>$antrian->email

]

];


$token=
Snap::getSnapToken($params);



$antrian->update([

'order_id'=>$order_id,

'snap_token'=>$token

]);



return response()->json([

'token'=>$token

]);


}


}