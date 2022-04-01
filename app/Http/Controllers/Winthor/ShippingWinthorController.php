<?php

namespace App\Http\Controllers\Winthor;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class ShippingWinthorController extends Controller
{

    /**
     * get Shipping Price from win Thor API
     * @param int $client_code
     * @param Array $produtcs_id
     * @return object
     */
    public function getShippingPrice($produtcs_id, $qtds)
    {

        $user = Auth::guard('web')->user();

        $url = config('winthor.winthor_url').'api/Pctabelas/RetornaFretePedido';

        // auth Winthor
        $authWinthor = new AuthWinthorController();
        $token = $authWinthor->Authenticate();

        /*
        $response = Http::withToken($token)->retry(3,100)->post($url, [
            'codprod' => $produtcs_id,
            'codcli' => $user->codcli,
            'qt' => $qtds
        ]);
*/
        $response = Http::withToken($token)->retry(3,100)->post($url, [
            'codprod' => array("17905","17904","11322"),
            'codcli' => "690",
            'qt' => array("1","50","1")
        ]);


        return $response;

    }


}
