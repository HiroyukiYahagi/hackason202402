@extends('layouts.empty')

@section('main')

@include("layouts.header")

<div class="uk-overflow-auto">
  <div style="min-width: 1280px;" class="uk-grid-collapse" uk-grid>
    @hasSection('sidebar')
    <div class="uk-width-medium">
      @yield('sidebar')
    </div>
    @endif
    <div class="uk-width-expand">
      <div class="uk-section">
        <div class="uk-container">
          @yield('content')
        </div>
      </div>
    </div>
  </div>
</div>

@include("components.common.message")

@endsection
