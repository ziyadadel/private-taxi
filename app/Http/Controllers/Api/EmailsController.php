<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\TripMail;
use Illuminate\Support\Facades\Mail;

class EmailsController extends Controller
{
    public function TripMail(Request $request)
    {
        $email = $request->email;
        $flight_number = $request->flight_number;
        $date = $request->date;
        $size = $request->size;
        $name_on_board = $request->name_on_board;
        $Passengers_number = $request->Passengers_number;
        $too = $request->too;
        // $from2 = $request->from2;
        Mail::to('diaforastore3@gmail.com')->send(new TripMail($email,$flight_number,$date,$size,$name_on_board,$Passengers_number,$too));
    }
}
