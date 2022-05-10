<?php

namespace App\Http\Controllers;

use App\Models\User;
use Database\Seeders\UsersSeeder;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Concat;

class UserController extends Controller
{
    public function index(){
        $users = User::get();
        //dd($users);
        return view('users.index', compact('users'));
    }

    public function userById($id){
        //$user = User::where('id',$id)->first; //** FORMATO MANUAL */
        //$user = User::find($id);               //** FORMATO RESUMIDO */
        if(!$user = User::find($id))
            return redirect()->route('users.index');

        return view('users.userData', compact('user'));
    }

    public function create(){
        return view('users.create');
    }
}
