@extends('layouts.empty')

@section('main')

@include("layouts.header")



<div class="uk-section uk-section-small">
  <div class="uk-container uk-container-xsmall">
    @yield('content')
  </div>
</div>

@include("components.common.message")

@endsection
