<?php


namespace App\Helper;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JWTToken{
public static function createToken($userEmail){
$key=env('JWT_KEY');
$payload=[
  'iss'=>'pos-token',
  'iat'=>time(),
  'exp'=>time()+60*3,
  'userEmail' => $userEmail
];
return JWT::encode($payload,$key,'HS256');

}

public static function verifyToken($token)
{
  try{
    $key=env('JWT_KEY');
    $decode=JWT::decode($token,new key($key,'HS256'));
    return $decode->userEmail;
  }
  catch(Exception $e)
  {
  return "unauthorized";
  }
}


}