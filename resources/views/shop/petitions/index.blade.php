@extends('layouts.app')

@section('content')

<h1>{{ $shop->shop_name }}の受け取り履歴</h1>

@foreach( $shop->petitions as $petition )
<div class="uk-margin uk-card uk-card-body uk-card-default uk-border-rounded">
  <div class="uk-grid-divider" uk-grid>
    <div class="uk-width-1-2">
      <table class="uk-table-small uk-table-divider">
        <tbody>
          <tr>
            <td class="uk-text-bold uk-text-small uk-width-small">申請日</td>
            <td>
              {{ $petition->created_at->format("Y年m月d日") }}
            </td>
          </tr>
          <tr>
            <td class="uk-text-bold uk-text-small">目標金額</td>
            <td>
              ¥{{ $petition->desired_price }}
            </td>
          </tr>
          <tr>
            <td class="uk-text-bold uk-text-small">利用目的</td>
            <td>
              {!! nl2br($petition->description) !!}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="uk-width-1-2">
      @foreach( $petition->affiliations as $affiliation )
      <div class="uk-margin">
        <h5 class="uk-margin-small">{{ $affiliation->thema->title }}</h5>
        <div class="uk-margin-small">
          <progress class="uk-progress uk-margin-small" value="{{ $affiliation->results->sum("price") }}" max="{{ $affiliation->price }}"></progress>
          <div class="uk-text-small uk-text-right">
            最大{{ $affiliation->price }}円のうち現在{{ $affiliation->results->sum("price") }}円が利用可能です
          </div>
        </div>
      </div>
      @endforeach
      @if( $petition->usable_price > 0 )
      <div class="uk-margin uk-text-right">
        <a class="uk-button uk-button-default" href="{{route('shop.petitions.view', ['petition' => $petition])}}">
          寄付金を利用する
        </a>
      </div>
      @endif
    </div>
  </div>
</div>
@endforeach

@endsection
