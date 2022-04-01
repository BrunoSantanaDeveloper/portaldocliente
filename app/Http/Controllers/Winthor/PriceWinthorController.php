<?php

namespace App\Http\Controllers\Winthor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;


class PriceWinthorController extends Controller
{

    /**
     * get by CNPJ from win Thor API
     * @param int $client_code
     * @param string $produtcs_id
     * @return object
     */
    public function getProductPriceByClientCod($client_code, $produtcs_id)
    {

        $url = config('winthor.winthor_url').'api/Pctabelas';
        //  $token = config('winthor.token');

        // auth Winthor
        $authWinthor = new AuthWinthorController();
        $token = $authWinthor->Authenticate();

        $response = Http::withToken($token)->retry(3,100)->post($url, [
            'codcli' => $client_code,
            'produtos' => $produtcs_id
        ]);


        if ($response->status() == 200 or $response->status() == 202 or $response->status() == 201)
            return $response->object();

        return ;

    }
}
