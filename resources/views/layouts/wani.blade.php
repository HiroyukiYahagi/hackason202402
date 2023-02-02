@extends('layouts.empty')

@section('main')

@include("layouts.header_wani")

<div class="uk-section uk-section-small uk-section-muted">
  <div class="uk-container uk-container-xsmall uk-padding" style="background-color: white;">
    @yield('content')
  </div>
</div>

@include("components.common.message")


@include("layouts.footer")

@endsection
