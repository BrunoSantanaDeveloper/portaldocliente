<?php

namespace App\Http\Controllers\Winthor;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ReceivementWinthorController extends Controller
{

    /**
     * get by acknowledgment of receipt from winThor API
     *
     * @return object
     */

    public function getReceivement($page)
    {

        $user = Auth::user()->id;
        $client = Clients::where('id_user',$user)->first();

        $client_id = $client->id_erp;

        $url = config('winthor.winthor_url').'api/Uteis/rotina?rotina=100001&filtros=where codcli = '.$client_id.' order by data_faturamento desc &paginado=true&pagina='.$page.'&pagesize=30';

        // auth Winthor
        $authWinthor = new AuthWinthorController();
        $token = $authWinthor->Authenticate();
        
        $response = Http::withToken($token)->retry(2,100)->get($url);
         
        if ($response->status() == 200) {
            /* dd($response->headers()['X-PageCount']); */
            $data['objects'] = $response->object();
            $data['header'] = $response->headers();
            
            //--- START PAGINATION
            $data['PageCount'] = $response->headers()['X-PageCount'];
            if($page == 1){
                $data['FirstPage'] = 'active';
                $data['ActivePage'] = '';
                $data['AtualPage'] = 2;
                $data['PreviousPage'] = 'disabled';
                $data['LinkPreviousPage'] = '#';
                $data['LinkAtualPage'] = route('receivement.getReceivement',['page' => $page + 1 ]);
               
            }else{
                $data['FirstPage'] = '';
                $data['ActivePage'] = 'active';
                $data['AtualPage'] = $page;
                $data['PreviousPage'] = '';
                $data['LinkPreviousPage'] = route('receivement.getReceivement',['page' => $page - 1 ]);
                $data['LinkAtualPage'] = route('receivement.getReceivement',['page' => $page ]);
                
            }
            $data['LinkNextPage'] = route('receivement.getReceivement',['page' => $data['AtualPage']+1 ]);
            $data['NextPage'] =  $data['AtualPage']+1;
            //--- END PAGINATION
        
            return view('ar',$data);
        }

        return ;

    }

    public function getItemOrder($nota)
    {

        $url = config('winthor.winthor_url').'api/Uteis/rotina?rotina=100002&filtros=where "Nota" = '.$nota.' order by "Numseq" &paginado=false';

        // auth Winthor
        $authWinthor = new AuthWinthorController();
        $token = $authWinthor->Authenticate();
        
        $response = Http::withToken($token)->retry(2,100)->get($url);
         
        if ($response->status() == 200) {
            /* dd($response->headers()['X-PageCount']); */
           
        
            echo $response;
        }

        return ;

    }
    


}
