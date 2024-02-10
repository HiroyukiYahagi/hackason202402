@extends('layouts.app')

@section('content')

<h1>
  寄付金の受け取り申請
</h1>

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
    </div>
  </div>
</div>

<h2>
  受け取り申請履歴
</h2>

<div class="uk-margin">
  <div class="uk-margin-small">
    <progress class="uk-progress uk-margin-small" value="{{ $petition->rest_price }}" max="{{ $petition->usable_price }}"></progress>
  </div>
  <div class="uk-margin-small">
    最大{{ $petition->usable_price }}円のうち現在{{ $petition->rest_price }}円が利用可能です
  </div>
</div>

<div class="uk-margin">
  <a class="uk-button uk-button-large uk-button-primary" uk-toggle href="#add-modal">
    受け取り申請する
  </a>
</div>

<table class="uk-table-small uk-table-striped uk-width-1-1">
  <thead>
    <tr>
      <td>申請日</td>
      <td>申請金額</td>
      <td>申請内容</td>
      <td>画像</td>
      <td>申請ステータス</td>
    </tr>
  </thead>
  <tbody>
    @foreach( $petition->receipts as $recipt )
    <tr>
      <td>
        {{ $recipt->created_at->format("Y年m月d日") }}
      </td>
      <td>
        ¥{{ $recipt->price }}
      </td>
      <td>
        {!! nl2br($recipt->description) !!}
      </td>
      <td>
        <img class="uk-width-small" uk-img data-src="{{ $recipt->image }}" />
      </td>
      <td>
        {{ $recipt->status == 1 ? '承認済み': '承認待ち' }}
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

<div id="add-modal" uk-modal="esc-close:false;bg-close:false;">
    <div class="uk-modal-dialog uk-border-rounded uk-overflow-hidden">
        <form method="POST" action="{{route('shop.petitions.receipts', ['petition' => $petition])}}" enctype="multipart/form-data">
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">受取り申請フォーム</h2>
            </div>
            <div class="uk-modal-body">
                <p class="uk-text-small">
                    寄付の利用用途と利用明細の画像をアップロードしてください
                </p>
                <div class="uk-margin-small">
                    @include("components.input.text", [
                        "label" => "利用金額", "name" => "price", "type" => "number"
                    ])
                </div>
                <div class="uk-margin-small">
                    @include("components.input.textarea", [
                        "label" => "利用目的を記載して下さい", "name" => "description"
                    ])
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label">
                        領収書・明細書をアップロード
                    </label>
                    <div class="uk-form-controls">
                        <div uk-form-custom="target: true">
                          <input name="file" type="file" aria-label="Custom controls">
                          <input class="uk-input uk-form-width-medium" type="text" placeholder="ファイルを選択する" aria-label="Custom controls" disabled>
                        </div>  
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer">
                <div class="uk-grid-small uk-margin" uk-grid>
                    <div class="uk-width-1-2">
                        <a class="uk-button uk-button-link uk-modal-close uk-width-1-1" type="button">キャンセル</a>
                    </div>
                    <div class="uk-width-1-2">
                        <button class="uk-button uk-button-primary uk-width-1-1">申請する</button>
                    </div>
                </div>
            </div>
            {{ csrf_field() }}
        </form>
    </div>
</div>

@endsection