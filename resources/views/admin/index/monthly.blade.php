@extends('layouts.app')
@section('content')
    <h1>月間実績</h1>
    <hr>
    <table class="uk-table uk-table-striped">
      <thead class="thead-color">
          <tr>
              <th>年月</th>
              <th>新規契約店舗数</th>
              <th>注文店舗数</th>
              <th>出荷袋数</th>
              <th>売上</th>
          <tr>
      </thead>
      <tbody>
          @foreach ($achievements as $monthly_achievement)
            <tr>
                <td>
                    <form action="{{ route('admin.index.detail') }}">
                        <input type="hidden" name="month" value="{{ $monthly_achievement['month'] }}">
                        <button class="uk-button uk-button-text">
                            {{ $monthly_achievement['month']->format('Y年n月') }}
                        </button>
                    </form>
                </td>
                <td>{{ $monthly_achievement['new_partners'] }}店舗</td>
                <td>{{ $monthly_achievement['has_order_partners'] }}店舗</td>
                <td>{{ $monthly_achievement['month_ships'] }}袋</td>
                <td>{{ number_format($monthly_achievement['month_sales']) }}円</td>
            </tr>
          @endforeach
      </tbody>
    </table>

    <h1>売上データ</h1>
    <canvas id="salesChart"></canvas>

    <h1>パートナーデータ</h1>
    <canvas id="newPartnersChart"></canvas>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

    <script>
        //ラベル
        var achievements = @json($achievements);
        achievements.slice(0, 12)
        achievements.reverse()
        var labels = [];
        for(var item of achievements) {
            labels.push(item.month.split('-', 2).join('/'))
        }
        //売上データ
        var average_weight_log = [];
        for(var item of achievements) {
            average_weight_log.push(item['month_sales'])
        }
        // パートナーデータ
        var new_partners_data = [];
        var order_partners_data = [];
        for(var item of achievements) {
            new_partners_data.push(item['new_partners'])
            order_partners_data.push(item['has_order_partners'])
        }
    
        //売上のグラフ
        var sales = document.getElementById("salesChart");
        var salesChart = new Chart(sales, {
            type: 'line',
            data : {
                labels: labels,
                datasets: [
                    {
                        label: '売上',
                        data: average_weight_log,
                        borderColor: "rgba(0,0,255,1)",
                        backgroundColor: "rgba(0,0,0,0)"
                    },
                ]
            },
        });
        // 新規店舗のグラフ
        var new_partners = document.getElementById("newPartnersChart");
        var newPartnersChart = new Chart(new_partners, {
            type: 'line',
            data : {
                labels: labels,
                datasets: [
                    {
                        label: '新規契約パートナー',
                        data: new_partners_data,
                        borderColor: "rgba(255,0,0)",
                        backgroundColor: "rgba(0,0,0,0)"
                    },
                    {
                        label: '注文店舗',
                        data: order_partners_data,
                        borderColor: "rgba(0,255,0)",
                        backgroundColor: "rgba(0,0,0,0)"
                    }
                ]
            },
        });
    </script>
@endsection