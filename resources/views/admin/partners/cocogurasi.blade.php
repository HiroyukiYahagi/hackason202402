@extends('layouts.app')
@section('content')
    <h1>ココ暮らし出荷用CSV</h1>
    <span class="uk-text-small uk-text-danger">※パートナー毎に部数を指定してください</span>
    <div id="app">
        <form action="{{ route('partners.downloadCsv')}}" method="POST">
            <div class="uk-margin-medium">
                <table class="uk-table uk-table-striped uk-width-xlarge">
                    <thead class="uhead-color">
                        <tr>
                            <td>ID</td>
                            <td>パートナー名</td>
                            <td>部数</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="partner in partners">
                            <td>
                                <span class="uk-text-bold">@{{ partner.id }}</span>
                            </td>
                            <td>
                                @{{ partner.name }}
                            </td>
                            <td>
                                <select class="uk-select" :name="'sizes['+partner.id+']'">
                                    <option v-for="number in numbers" :value="number">
                                        @{{ number }}部
                                    </option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button class="uk-button uk-button-primary">
                CSVをダウンロード
            </button>
            @csrf
        </form>
    </div>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            let vm = new Vue({
                el: '#app',
                data() {
                    var partners = @json($partners);
                    var numbers = []
                    for(let i = 0; i <= 100; i++) {
                        numbers.push(i)
                    }
                    return {
                        numbers: numbers,
                        partners: partners,
                    }
                },
            })
        });
    </script>

@endsection