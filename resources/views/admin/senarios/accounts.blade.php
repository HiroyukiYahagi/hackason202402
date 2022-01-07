@extends('layouts.app')

@section('sidebar')
@include("layouts.sidebar.bot")
@endsection

@section('subbar')
@include("layouts.sidebar.senario")
@endsection


@section('content')
    
<h1>
  <span class="uk-text-small">{{ $senario->name }}</span><br/>
  該当アカウント
</h1>

<hr />


<table class="uk-table uk-table-striped uk-table-small uk-table-middle uk-margin">
  <thead>
    <tr>
      <th>#</th>
      <th>登録日</th>
      <th>ブロック日</th>
      <th>シナリオ名</th>
      <th class="uk-width-medium">action</th>
    </tr>
  </thead>
  <tbody>
  @foreach( $accounts as $account )
    <tr>
      <td>
        {{ $account->id }}
      </td>
      <td>
        {{ $account->created_at }}
      </td>
      <td>
        {{ $account->blocked_at }}
      </td>
      <td>
        {{ $account->name }}
      </td>
      <td>
        <a class="uk-icon-button uk-button-primary" href="{{route('admin.accounts.view', ['bot' => $bot, 'account' => $account])}}">
          <span uk-icon="file-edit"></span>
        </a>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>

<div class="uk-margin uk-text-center">
  {{ $accounts->appends($param)->links() }}
</div>


@endsection
