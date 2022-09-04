<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Mail\SendMailreset;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use App\Models\Admin;

class ForgetPasswordController extends Controller
{
    public function sendEmail(Request $request)
    {
        if (!$this->validateEmail($request->email)) {  // this is validate to fail send mail or true
            return $this->failedResponse();
        }
        $this->send($request->email);  //this is a function to send mail 
        return $this->successRespopnse();
    }

    public function send($email)
    {
        $token = $this->createToken($email);
        Mail::to($email)->send(new SendMailreset($token, $email));  // token is important in send mail 
    }

    public function createToken($email)
    {
        $oldToken = DB::table('password_resets')->where('email', $email)->first();

        if($oldToken)
        {
            return $oldToken->token;
        }

        $token = Str::random(40);
        $this->saveToken($token, $email);
        return $token;
    }

    public function saveToken($token, $email)
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }

    public function validateEmail($email)
    {
        return !!Admin::where('email', $email)->first();
    }

    public function failedResponse()
    {
        return response()->json([
            'error' => 'Email does\'t found on our database'
        ], Response::HTTP_NOT_FOUND);
    }

    public function successRespopnse()
    {
        return response()->json([
            'data' => 'Reset Email is send successfully, please check your inbox'
        ], Response::HTTP_OK);
    }
}
