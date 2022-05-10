<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Winthor\ReceivementWinthorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Receivement extends Controller
{
    //

    public function index(){
       
        $ReceivementWinthor = new ReceivementWinthorController();
        
        $results = $ReceivementWinthor->getReceivement(71,1);

        return view('ar',['results' => $results]);
    }
}
