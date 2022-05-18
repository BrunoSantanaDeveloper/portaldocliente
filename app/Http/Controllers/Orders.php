<?php

namespace App\Http\Controllers;

use App\Mail\SendMailOrders;
use App\Models\Clients;
use App\Models\Orders as ModelsOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Orders extends Controller
{
    public function aproveOrder($nota,$order,$emitente,$emitenteEmail){

        $user = Auth::user();
        $client = Clients::where('id_user',$user->id)->first();
        dd($client);
        $data = ['id_cli' => $client->id, 'nf' => $nota, 'erp_order' => $order, 'status' => "APROVADO", 'note' =>''];
        if(ModelsOrders::create($data)){

            $dataMail = [
                'name' => $client->name_cli,
                'nf' => $nota,
                'erp_order' => $order,
                'status' => 'APROVADO',
                'note' =>''
            ];

            Mail::send('mails.orders', $dataMail, function ($message,$emitente,$emitenteEmail) {
                $user = Auth::user();
                
                $message->from('noreply@portaldocliente.las.app.br', 'LOGÍSTICA - LAS');
                $message->sender('noreply@portaldocliente.las.app.br', 'LOGÍSTICA - LAS');
                $message->to($user->email, $user->name);
                $message->cc('logistica@lasdobrasil.com.br', $name = null);
                $message->cc('estoque@lasdobrasil.com.br', $name = null);
                $message->cc($emitente, $name = null);
                $message->cc($emitenteEmail, $name = null);
                $message->subject('Pedido Aprovado');
                $message->priority(1);
            });

            
            return true;
        }
        
        return false;
    }

    public function rejectOrder(Request $request){

        $user = Auth::user()->id;
        $client = Clients::where('id_user',$user)->first();

        $data = ['id_cli' => $client->id, 'nf' => $request->input('nf'), 'erp_order' => $request->input('erp_order'), 'status' => "REJEITADO", 'note' => $request->input('note')];
        if(ModelsOrders::create($data)){

            $dataMail = [
                'name' => $client->name_cli,
                'nf' => $request->input('nf'),
                'erp_order' => $request->input('erp_order'),
                'status' => 'REJEITADO',
                'note' =>'Motivo: '.$request->input('note')
            ];

            Mail::send('mails.orders', $dataMail, function ($message) {
                $message->from('noreply@portaldocliente.las.app.br', 'LOGÍSTICA - LAS');
                $message->sender('noreply@portaldocliente.las.app.br', 'LOGÍSTICA - LAS');
                $message->to('ti@lasdobrasil.com.br', 'TI LAS');
                $message->subject('Pedido Rejeitado');
                $message->priority(1);
            });

            return redirect('ar/1');
        }
        
        return false;
    }
}
