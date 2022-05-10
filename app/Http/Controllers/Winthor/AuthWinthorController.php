<?php

namespace App\Http\Controllers\Winthor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class AuthWinthorController extends Controller
{

    /**
     * Authenticate
     *
     * @return object
     */
    public function Authenticate()
    {


        $url = config('winthor.winthor_url').'Users/authenticate';

        $dados = array(
            'username' => config('winthor.user'),
            'password' => config('winthor.pass')
        );

        
        $response = Http::retry(2,100)->post($url, $dados);
         if ($response->status() == 200 or $response->status() == 202 or $response->status() == 201){
             //Config::set('winthor.token', $response->body());
            return $response->body();
        }


        return ;


    }

    /**
     * RefreshToken
     *
     * @return object
     */
    public function RefreshToken()
    {

        $url = config('winthor.winthor_url').'Users/refresh-token';

        $dados = array( 'token' => config('winthor.token'));

        $response = Http::retry(2,100)->post($url, $dados);

       

        if ($response->status() == 200 or $response->status() == 202 or $response->status() == 201)
            return $response->body();

        return ;

    }


}
