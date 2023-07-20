<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;

use Illuminate\Http\Request;

class TokenController extends Controller
{

    function createToken($payload,$secretKey){
    
    return JWT::encode($payload,$secretKey,'HS256');
    
    }
function getToken(Request $request)
{
    return $this->createToken($request->input('payload'),$request->input('secretKey'));
}
}
