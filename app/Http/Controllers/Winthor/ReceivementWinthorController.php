<?php

namespace App\Http\Controllers\Winthor;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ReceivementWinthorController extends Controller
{

    /**
     * get by acknowledgment of receipt from winThor API
     *
     * @return object
     */

    public function getReceivement($page)
    {

        if (!Auth::check()) {
            return redirect('login');
        }
    
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

            $i = 0;
            foreach($data['objects'] as $object){

                $order = Orders::where('nf',$object->NOTA_FISCAL)->first();

                if(isset($order)){
                    $data['objects'][$i]->status = $order->status;
                    if($order->status == 'APROVADO'){
                        $data['objects'][$i]->status_class = 'success';
                    }else{
                        $data['objects'][$i]->status_class = 'danger';
                    }
                }else{
                    $data['objects'][$i]->status = 'PENDENTE';
                    $data['objects'][$i]->status_class = 'warning';
                }

                $i++;
                
            }

            //dd($data['objects']);

            //--- START PAGINATION
            $data['PageCount'] = $response->headers()['X-PageCount'];
            if($page == 1){
                $data['FirstPage'] = 'active';
                $data['ActivePage'] = '';
                $data['AtualPage'] = 2;
                $data['PreviousPage'] = 'disabled';
                $data['LinkPreviousPage'] = '#';
                $data['LinkAtualPage'] = route('receivement.get-receivement',['page' => $page + 1 ]);
               
            }else{
                $data['FirstPage'] = '';
                $data['ActivePage'] = 'active';
                $data['AtualPage'] = $page;
                $data['PreviousPage'] = '';
                $data['LinkPreviousPage'] = route('receivement.get-receivement',['page' => $page - 1 ]);
                $data['LinkAtualPage'] = route('receivement.get-receivement',['page' => $page ]);
                
            }
            $data['LinkNextPage'] = route('receivement.get-receivement',['page' => $data['AtualPage']+1 ]);
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

    public function getXml($ntrans){

        $url = config('winthor.winthor_url').'api/Uteis/rotina?rotina=100003&filtros=where transacao  = '.$ntrans.' &paginado=false';

        
        // auth Winthor
        $authWinthor = new AuthWinthorController();
        $token = $authWinthor->Authenticate();
        
        $response = Http::withToken($token)->retry(2,100)->get($url);

        
         
        if ($response->status() == 200) {
            //dd($response->object()[0]->XML);
          
            Storage::put('files_xml/file.xml',$response->object()[0]->XML);
            return Storage::download('files_xml/file.xml');
            /* return $response; */
        }

        return ;
    }
    


}
