<?php

namespace App\Http\Controllers;

use App\Mail\OTPMail;
use Exception;
use App\Models\User;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    
    function userRegistration(Request $request)
    {
        try{User::create([
            'firstName'=>$request->input('firstName'),
            'lastName'=>$request->input('lastName'),
            'email'=>$request->input('email'),
            'mobile'=>$request->input('mobile'),
            'password'=>$request->input('password')
        ]); 

        return response()->json(['status'=>'success',
    'message'=>'User registration completed'],200);
    }
    catch(Exception $e)
    {
        return response()->json(['status'=>'failed',
        'message'=>'User registration failed'],200);
    }

}  

function userLogin(Request $request)
{
    $count=User::where("email",$request->input('email'))->where('password',$request->input('password'))->count();
    if($count===1)
    {
        $token= JWTToken::createToken($request->input('email'));
        return response()->json(['status'=>'success',
        'message'=>'User login successful','token'=>$token],200);
        
    }
    else{
        return response()->json(['status'=>'failed',
        'message'=>'Unauthorized'],401);
    }

}

function sendOTP(Request $request)
{
    $email=$request->all();
    $email=$email['email'];

    $count=User::where("email",$email)->count();
    if($count===1)
    {
        $otp=rand(1000,9999);
        Mail::to($email)->send(new OTPMail($otp));
        User::where("email",$email)->update(['otp'=>$otp]);
        return response()->json(['status'=>'success',
        'message'=>'OTP sent.'],200);
        
    }
    else{
        return response()->json(['status'=>'failed',
        'message'=>'Unauthorized'],401);
    }

}


    function verifyOTP(Request $request)
    {
        $email=$request->input('email');
        $otp=$request->input('otp');
        $count=User::where("email",$email)->where('otp',$otp)->count();
    if($count===1)
    {
        User::where("email",$email)->update(['otp'=>'0']);
        $token= JWTToken::createToken($email);
        return response()->json(['status'=>'success',
        'message'=>'OTP verified','token'=>$token],200);
        
    }
    else{
        return response()->json(['status'=>'failed',
        'message'=>'Unauthorized'],401);
    }
    }

    function resetPassword(Request $request)
    {
        try{
        $email=$request->header('email');
        $pass=$request->input('password');
        User::where("email",$email)->update(['password'=>$pass]);

        return response()->json(['status'=>'success',
        'message'=>'Password reset complete'],200);
        
    }
    catch(Exception $e){
        return response()->json(['status'=>'failed',
        'message'=>'Unauthorized'],401);
    }
    }
}
