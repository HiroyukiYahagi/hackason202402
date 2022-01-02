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
  シナリオ設定の変更
</h1>

<hr />

@endsection
