<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Facades\JWTAuth;

trait QVMTrait
{
    public function getPureToken()
    {
        $token = JWTAuth::getToken();
        return $token;

    }
    public function guestPostData($url, $data = [])
    {
        $response = Http::post($url, $data)->json();
        return $response;
    }
    public function postData($url, $data = [])
    {
        $jwt_token = $this->getPureToken();
        $response = Http::acceptJson()->withToken($jwt_token)->post($url, $data)->json();
        return $response;
    }
    public function getData($url, $data = [])
    {

        $jwt_token = $this->getPureToken();
        $response = Http::withToken($jwt_token)->get($url, $data)->json();
        return $response;
    }
}
