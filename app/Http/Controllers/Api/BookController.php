<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\BookMail;
use Illuminate\Support\Facades\Mail;

class BookController extends Controller
{
    public function BookMail(Request $request)
    {
        $trip_name = $request->trip_name;
        $email = $request->email;
        $date = $request->date;
        $size = $request->size;
        $Passengers_number = $request->Passengers_number;
        Mail::to('diaforastore3@gmail.com')->send(new BookMail($trip_name,$email,$date,$size,$Passengers_number));
    }
}
