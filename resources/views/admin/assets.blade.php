@extends('layouts.app')


@section('content')
    
<h1>
  素材一覧
</h1>

<hr />

<div class="js-upload uk-placeholder uk-text-center">
  <span uk-icon="icon: cloud-upload"></span>
  <span class="uk-text-middle">画像ファイルをここにドラッグ&ドロップするするか</span>
  <div uk-form-custom>
    <input type="file">
    <span class="uk-link">ファイルを選択してください</span>
  </div>
</div>
<progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden></progress>

<script>
var bar = document.getElementById('js-progressbar');
UIkit.upload('.js-upload', {
  url: '{{route("admin.assets.view")}}',
  name: "file",
  params: {
    _token: "{{ csrf_token() }}"
  },
  loadStart: function (e) {
    bar.removeAttribute('hidden');
    bar.max = e.total;
    bar.value = e.loaded;
  },
  progress: function (e) {
    bar.max = e.total;
    bar.value = e.loaded;
  },
  loadEnd: function (e) {
    bar.max = e.total;
    bar.value = e.loaded;
    setTimeout(function () {
        bar.setAttribute('hidden', 'hidden');
        window.location.href = "{{route('admin.assets.index')}}";
    }, 1000);
  }
});
</script>


<div uk-grid="masonry: true;" class="uk-grid-small">
  @foreach( $assets as $asset )
  <div class="uk-width-1-4">
    <div class="uk-position-relative">
      <img src="{{ $asset->full_url }}" />
      <form method="post" action="{{route('admin.assets.delete', ['asset' => $asset])}}" onsubmit="return confirm('本当に削除しますか？');">
        <button class="uk-icon-button uk-button-danger uk-position-top-right uk-position-small">
          <span uk-icon="trash"></span>
        </button>
        @csrf
      </form>
    </div>
    <div>
      <input class="uk-input" type="text" value="{{ $asset->full_url }}" readonly />
    </div>
  </div>
  @endforeach
</div>

<div class="uk-margin uk-text-center">
  {{ $assets->appends([])->links() }}
</div>


@endsection
