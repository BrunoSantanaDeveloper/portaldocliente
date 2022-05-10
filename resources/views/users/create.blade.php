@extends('layouts.app')

@section('title','Novo Cliente')

@section('content')
 <h1>Novo Cliente</h1>
 <form action="#" method="post">
   <input type="text" name="name" placeholder="Nome">
   <input type="email" name="email" placeholder="E-mail">
   <input type="password" name="password" placeholder="Senha">
   <button type="submit">Salvar</button>
 </form>
@endsection
