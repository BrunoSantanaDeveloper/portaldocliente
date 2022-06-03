<?php

namespace App\Http\Controllers\Winthor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClientWinthorController extends Controller
{

    /**
     * get by CNPJ from win Thor API
     *
     * @return object
     */

    public function getClients()
    {

        $url = config('winthor.winthor_url').'api/Pcclient/portal';
     //   $token = config('winthor.token');

        // auth Winthor
        $authWinthor = new AuthWinthorController();
        $token = $authWinthor->Authenticate();


         $response = Http::withToken($token)->retry(2,100)->get($url);

        if ($response->status() == 200) {

            foreach($response->object() as $clients){

                return json_encode($clients);
                /* if($clients['cgcent'] == $request->cgc){
                    return $clients['cliente']->object();
                }else{
                    return false;
                }; */
            }
            //dd($response[0]['cgcent']);
            //return $response->object();

        }

        return ;

    }
    public function getByCNPJ($cnpj)
    {

        $url = config('winthor.winthor_url').'api/Pcclient/cnpj/'.$cnpj;
     //   $token = config('winthor.token');

        // auth Winthor
        $authWinthor = new AuthWinthorController();
        $token = $authWinthor->Authenticate();

        $response = Http::withToken($token)->retry(2,100)->get($url);

        if ($response->status() == 200) {

            return $response->object();

        }

        return ;

    }

    public function registerValidate(Request $request)
    {
    $url = config('winthor.winthor_url').'api/Pcclient/portal';

        // auth Winthor
        $authWinthor = new AuthWinthorController();
        $token = $authWinthor->Authenticate();



         $response = Http::withToken($token)->retry(2,100)->get($url);


        if ($response->status() == 200) {
            //dd($response->object());
           foreach($response->object() as $clients){
            //dd($clients->cgcent);

                if($clients->cgcent == $request->cgc){
                    //dd($response->object());
                    $response = [
                        'cliente' => $clients->cliente,
                        'codcli' => $clients->codcli
                    ];
                    return $response;
                }

            }
        }
        return;

    }


}
