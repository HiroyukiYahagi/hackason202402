@extends('layouts.app')
@section('content')
    <h2>インタビュー一覧</h2>
    <hr>
    <div class="uk-margin">
        <h3>
            検索条件
            <span class="uk-text-small">({{ $interviews->total() }}件)</span>
        </h3>
        <form action="{{ route('interviews.index') }}">
            <div class="uk-grid-small uk-flex-bottom" uk-grid>
                <div class="uk-width-1-6@s">
                    <label for="partner_name" class="uk-form-label">
                        <small>
                            パートナー名
                        </small>
                    </label>
                    <input type="text" class="uk-input" name="partner_name" placeholder="パートナー名を入力"
                        value="{{ isset($param['partner_name']) ? $param['partner_name'] : null }}">
                </div>
                <div class="uk-width-1-6@s">
                    <button class="uk-button uk-button-primary uk-width-1-1">
                        検索
                    </button>
                </div>
            </div>
            @csrf
        </form>
    </div>
    <table class="uk-table uk-table-striped">
        <thead class="thead-color">
            <tr>
                <th>ID</th>
                <th>回答日</th>
                <th>パートナー名</th>
                <th>代表者名</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($interviews as $interview)
                <tr>
                    <td>
                        <a href="{{ route('interviews.show', compact('interview')) }}">
                            {{ $interview->id }}
                        </a>
                    </td>
                    <td>{{ $interview->created_at->format('Y/m/d') }}</td>
                    <td>
                        <a href="{{ route('partners.show', ['partner' => $interview->partner]) }}">
                            {{ $interview->partner_name }}
                        </a>
                    </td>
                    <td>{{ $interview->representative_name }}</td>
                    <td>
                        <a href="{{ route('interviews.show', compact('interview')) }}">
                            詳細
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $interviews->appends(request()->query())->links('pagination::default') }}
@endsection
