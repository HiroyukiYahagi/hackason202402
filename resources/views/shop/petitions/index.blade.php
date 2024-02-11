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
              ¥{{ number_format($petition->desired_price) }}
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
        <div class="uk-margin-small uk-grid-small uk-flex-middle" uk-grid>
          <div class="uk-width-auto">
            <div class="uk-thumbnail uk-image-wrapper uk-border-rounded">
              <img uk-img data-src="{{ $affiliation->thema->image_url }}" />
            </div>
          </div>
          <div class="uk-width-expand">
            <h5>{{ $affiliation->thema->title }}</h5>
          </div>
        </div>
        <div class="uk-margin-small">
          <progress class="uk-progress uk-margin-small" value="{{ $affiliation->results->sum("price") }}" max="{{ $affiliation->price }}"></progress>
          <div class="uk-text-small uk-text-right">
            最大{{ number_format($affiliation->price) }}円のうち現在{{ number_format($affiliation->results->sum("price")) }}円が利用可能です
          </div>
        </div>
        @if( $affiliation->results->sum("price") > 0 )
        <div class="uk-margin-small">
          <h6 class="uk-margin-remove">支援者</h6>
          <div class="uk-grid-small uk-flex-middle" uk-grid>
            @foreach( $affiliation->results as $result )
            @continue( $result->status == 0 )
            <div>
              <img style="width:40px;" uk-img data-src="{{ asset('images/icon.png') }}" />
              <span class="uk-text-small">{{ $result->usecase->donate->user->nick_name }}</span>
            </div>
            @endforeach
          </div>
        </div>
        @endif
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
