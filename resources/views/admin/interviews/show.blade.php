@extends('layouts.app')
@section('content')
    <h1>インタビューの詳細</h1>
    <hr>
    <table class="uk-table uk-table-striped">
        <thead class="thead-color">
            <tr>
                <th>質問</th>
                <th>回答</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="uk-width-1-4 uk-text-bold">店舗名</td>
                <td>{{ $interview->partner_name }}</td>
            </tr>
            <tr>
                <td class="uk-width-1-4 uk-text-bold">代表者名</td>
                <td>{{ $interview->representative_name }}</td>
            </tr>
            <tr>
                <td class="uk-width-1-4 uk-text-bold">{{ $interview->question_1 }}</td>
                <td>{{ $interview->answer_1 }}</td>
            </tr>
            <tr>
                <td class="uk-width-1-4 uk-text-bold">{{ $interview->question_2 }}</td>
                <td>{{ $interview->answer_2 }}</td>
            </tr>
            <tr>
                <td class="uk-width-1-4 uk-text-bold">{{ $interview->question_3 }}</td>
                <td>{{ $interview->answer_3 }}</td>
            </tr>
            <tr>
                <td class="uk-width-1-4 uk-text-bold">{{ $interview->question_4 }}</td>
                <td>{{ $interview->answer_4 }}</td>
            </tr>
            <tr>
                <td>画像ファイル</td>
                <td>
                    <div class="uk-grid" uk-grid>
                        @if ($files)
                            @foreach ($files as $i => $file)
                                <form action="{{ route('interviews.downloadFile', compact('interview')) }}" method="GET">
                                    <button class="uk-button uk-button-link" name="path"
                                        value="{{ $file }}">ファイル[{{ $i + 1 }}]</button>
                                </form>
                            @endforeach
                        @else
                            ファイルはありません
                        @endif
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
