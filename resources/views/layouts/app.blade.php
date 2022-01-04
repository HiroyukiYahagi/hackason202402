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
    @hasSection('subbar')
    <div class="uk-width-medium">
      @yield('subbar')
    </div>
    @endif
    <div class="uk-width-expand">
      <div class="uk-section uk-section-small" style="max-height: calc(100vh - 60px);overflow: scroll;">
        <div class="uk-container uk-container-xlarge">
          @yield('content')
        </div>
      </div>
    </div>
  </div>
</div>

@include("components.common.message")

@endsection
