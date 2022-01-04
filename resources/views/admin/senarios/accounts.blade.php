@extends('layouts.app')

@section('sidebar')
@include("layouts.sidebar.bot")
@endsection

@section('subbar')
@include("layouts.sidebar.senario")
@endsection


@section('content')
    
<h1>
  <span class="uk-text-small">{{ $senario->name }}</span><br/>
  該当アカウント
</h1>

<hr />


@endsection
