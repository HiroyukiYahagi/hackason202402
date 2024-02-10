@extends('layouts.empty')

@section('main')

<div class="uk-overflow-auto" style="min-width: 1400px;">
  <div class="uk-grid-collapse" uk-grid>
    <div class="uk-width-medium uk-background-muted" style="height: 100vh;">
    @auth("user")
      @include('layouts.sidebar.user')
    @else
      @auth("shop")
        @include('layouts.sidebar.shop')
      @else
        @include('layouts.sidebar.none')
      @endauth
    @endauth
    </div>
    <div class="uk-width-expand">
      <div style="height: 100vh;overflow: scroll;">
        @yield('header')
        <div class="uk-section uk-section-small">
          <div class="uk-container uk-container-xlarge">
            @yield('content')
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include("components.common.message")

@endsection
