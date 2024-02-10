@extends('layouts.app')

@section('header')
<div class="uk-position-relative">
  <img class="uk-width-1-1" src="{{asset('images/fv.jpg')}}" />
  <div class="uk-position-absolute" style="top:10%;right: 5%;left: 40%;">
    <h2>
      その気持ちをコトに寄付しよう
    </h2>
    <p>
      「コト基金」は、特定の人や団体ではなく、コトに寄付できるサービスです。<br/>
      寄付したい金額と、対象を自由に入力すると、受け取りを希望する団体や個人に対して、AIによる自動判別によって公平に分配されます。
    </p>
    <div class="uk-h2">
      現在の総寄付金額 ¥<span class="uk-heading-medium">{{ number_format($totalPrice) }}</span>
    </div>
  </div>
</div>
@endsection

@section('content')

<h2>
  人気のテーマ
</h2>
<div class="uk-grid-match" uk-grid>
  @foreach( $themas as $thema )
  <div class="uk-width-1-3">
    <div class="uk-card uk-card-default uk-border-rounded uk-overflow-hidden">
      <div class="uk-height-small uk-image-wrapper">
        <img uk-img data-src="{{ $thema->image_url }}" />
      </div>
      <div class="uk-card-body">
        <h4>
          {{ $thema->title }}に対する寄付
        </h4>
        <div class="uk-grid-small uk-grid-divider" uk-grid>
          <div class="uk-width-1-2">
            寄付者<br/>
            <span class="uk-h2">{{ $thema->usecases->count() }}</span>人
          </div>
          <div class="uk-width-1-2">
            寄付金額<br/> 
            ¥<span class="uk-h2">{{ number_format($thema->usecases->sum("price")) }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>

@endsection
