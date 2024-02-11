@extends('layouts.app')

@section('content')

<h1>{{ $user->nick_name }}の寄付実績</h1>

@foreach( $user->donates as $donate )
<div class="uk-margin uk-card uk-card-body uk-card-default uk-border-rounded">
  <div class="uk-grid-divider" uk-grid>
    <div class="uk-width-1-2">
      <table class="uk-table-small uk-table-divider">
        <tbody>
          <tr>
            <td class="uk-text-bold uk-text-small uk-width-small">寄付日</td>
            <td>
              {{ $donate->created_at->format("Y年m月d日") }}
            </td>
          </tr>
          <tr>
            <td class="uk-text-bold uk-text-small">寄付金額</td>
            <td>
              ¥{{ number_format($donate->price) }}
            </td>
          </tr>
          <tr>
            <td class="uk-text-bold uk-text-small">寄付目的</td>
            <td>
              {!! nl2br($donate->description) !!}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="uk-width-1-2">
      @foreach( $donate->usecases as $usecase )
      <div class="uk-margin">
        <div class="uk-margin-small uk-grid-small uk-flex-middle" uk-grid>
          <div class="uk-width-auto">
            <div class="uk-thumbnail uk-image-wrapper uk-border-rounded">
              <img uk-img data-src="{{ $usecase->thema->image_url }}" />
            </div>
          </div>
          <div class="uk-width-expand">
            <h5>{{ $usecase->thema->title }}</h5>
          </div>
        </div>
        <div class="uk-margin-small">
          <progress class="uk-progress uk-margin-small" value="{{ $usecase->use_price }}" max="{{ $usecase->price }}"></progress>
          <div class="uk-text-small uk-text-right">
            最大{{ number_format($usecase->price) }}円のうち現在{{ number_format($usecase->results->sum("price")) }}円が利用済みです
          </div>
        </div>
        @foreach( $usecase->results as $result )
        @if( $result->status == 1 )
        <div class="uk-margin-small uk-padding-small uk-background-muted uk-border-rounded">
          <div class="uk-grid-small uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <img style="width:40px;" uk-img data-src="{{ asset('images/icon.png') }}" />
            </div>
            <div class="uk-width-expand">
              {{ $result->affiliation->petition->shop->shop_name }}に¥{{ number_format($result->price) }}付与しました
            </div>
            <div class="uk-width-auto">
              <a class="uk-button uk-button-small uk-button-default" href="#result-modal_{{ $result->id }}" uk-toggle>
                詳細
              </a>
            </div>
          </div>
        </div>
        <div id="result-modal_{{ $result->id }}" uk-modal="">
          <div class="uk-modal-dialog uk-border-rounded uk-overflow-hidden">
            <div class="uk-modal-header">
              <h2 class="uk-modal-title">{{ $result->affiliation->petition->shop->shop_name }}について</h2>
            </div>
            <div class="uk-modal-body">
              <p class="uk-text-small">
                  {!! nl2br($result->affiliation->petition->description) !!}
              </p>
              <p class="uk-text-small">
                  最大利用額 : ¥{{ number_format($result->affiliation->price) }}
              </p>
            </div>
          </div>
        </div>
        @else
        <div class="uk-padding-small uk-background-muted uk-border-rounded">
          <div class="uk-grid-small uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <img style="width:40px;" uk-img data-src="{{ asset('images/icon.png') }}" />
            </div>
            <div class="uk-width-expand">
              <div class="uk-text-small uk-text-bold">
                申請日: {{ $result->created_at->format("Y年m月d日") }}
              </div>
              <div class="uk-text-bold">
                {{ $result->affiliation->petition->shop->shop_name }}
                <div class="uk-text-small">
                  ¥{{ number_format($result->affiliation->price) }}
                </div>
              </div>
              <div class="uk-margin-small uk-text-right">
                <a class="uk-button uk-button-small uk-button-default" href="#result-modal_{{ $result->id }}" uk-toggle>
                  詳細・利用承認
                </a>
              </div>
            </div>
          </div>
        </div>
        <div id="result-modal_{{ $result->id }}" uk-modal="">
          <div class="uk-modal-dialog uk-border-rounded uk-overflow-hidden">
              <form method="POST" action="{{route('user.results.edit', ['result' => $result])}}">
                  <div class="uk-modal-header">
                      <h2 class="uk-modal-title">{{ $result->affiliation->petition->shop->shop_name }}が利用申請</h2>
                  </div>
                  <div class="uk-modal-body">
                      <p class="uk-text-small">
                          {!! nl2br($result->affiliation->petition->description) !!}
                      </p>
                      <p class="uk-text-small">
                          最大利用額 : ¥{{ number_format($result->affiliation->price) }}
                      </p>
                      <p class="uk-text-small">
                          あなたが寄付できる額 : ¥{{ number_format(min( $result->affiliation->rest_price, $result->usecase->rest_price )) }}
                      </p>
                  </div>
                  <div class="uk-modal-footer">
                      <div class="uk-grid-small uk-margin" uk-grid>
                          <div class="uk-width-1-2">
                              <button class="uk-button uk-button-danger uk-width-1-1" name="status" value="-1">否認する</button>
                          </div>
                          <div class="uk-width-1-2">
                              <button class="uk-button uk-button-primary uk-width-1-1"name="status" value="1">承認する</button>
                          </div>
                      </div>
                  </div>
                  {{ csrf_field() }}
              </form>
          </div>
        </div>
        @endif
        @endforeach
      </div>
      @endforeach
    </div>
  </div>
</div>
@endforeach

<h2>利用申請</h2>

@if( $user->votes->count() == 0 )
<p>
  利用申請はまだ届いていません
</p>
@else
<table class="uk-table-small uk-table-striped uk-width-1-1">
  <thead>
    <tr>
      <td>申請日</td>
      <td>申請内容</td>
      <td>画像</td>
      <td>承認する</td>
    </tr>
  </thead>
  <tbody>
    @foreach( $user->votes as $vote )
    <tr>
      <td>
        {{ $vote->created_at->format("Y年m月d日") }}
      </td>
      <td>
        <div class="uk-grid-small uk-flex-middle" uk-grid>
          <div class="uk-width-auto">
            <img style="width:40px;" uk-img data-src="{{ asset('images/icon.png') }}" />
          </div>
          <div class="uk-width-expand">
            {{ $vote->receipt->petition->shop->shop_name }}
          </div>
        </div>
        利用金額 : ¥{{ number_format($vote->receipt->price) }}<br/>
        {!! nl2br($vote->receipt->description) !!}
      </td>
      <td>
        <img class="uk-width-small" uk-img data-src="{{ $vote->receipt->image }}" />
      </td>
      <td>
        @if( $vote->status === null )
        <form method="POST" action="{{route('user.votes.edit', ['vote' => $vote])}}">
          <div class="uk-margin-small">
            <button class="uk-button uk-button-danger uk-width-1-1" name="status" value="-1">否認する</button>
          </div>
          <div class="uk-margin-small">
            <button class="uk-button uk-button-primary uk-width-1-1"name="status" value="1">承認する</button>
          </div>
          {{ csrf_field() }}
        </form>
        @else
        {{ $vote->status == 1 ? '承認': '否認' }}
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endif

@endsection
