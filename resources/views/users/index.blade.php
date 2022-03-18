@extends('layouts.app')

@section('title','Lista de Clientes')

@section('content')
  @foreach ($users as $user)
  {{$user->name}} - <a href="{{ route('users.userById', $user->id)}}">Detalhes</a>
  @endforeach
@endsection
