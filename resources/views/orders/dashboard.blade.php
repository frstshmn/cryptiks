<html>
<head>

    <title>Ордери</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "JetBrains Mono", monospace;
            font-optical-sizing: auto;
            font-style: normal;
        }
        body.inverted {
            background-color: #111;
            -webkit-filter: invert(100%);
            filter: invert(100%);
        }
        body.inverted .operationType {
            -webkit-filter: invert(90%);
            filter: invert(90%);
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body class="@if($styles['isInverted']) inverted @endif">
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h1 class="fw-bold">Ордери</h1>
                <form method="get">
                    <input class="my-1" type="text" name="currency_from" placeholder="Currency From" value="{{ $metadata['currency_from'] ?? '' }}"><br>
                    <input class="my-1" type="text" name="currency_to" placeholder="Currency To" value="{{ $metadata['currency_to'] ?? '' }}"><br>
                    <input class="my-1" type="submit" value="Шукати">
                </form>
            </div>
            <div class="col-6">
                <a class="btn btn-warning" href="https://www.binance.com/uk-UA/trade/{{$metadata['currency_from']}}_{{$metadata['currency_to']}}?type=spot" target="_blank">Торгівля {{$metadata['currency_from']}}{{$metadata['currency_to']}}</a>
                <h3 class="h5 mt-3 fw-bold">Баланс</h3>
                <div> {{$metadata['balance_from_free']}} <span class="fw-bold">{{$metadata['currency_from']}}</span> ({{$metadata['balance_from_locked']}} в ордерах)</div>
                <div> {{$metadata['balance_to_free']}} <span class="fw-bold">{{$metadata['currency_to']}}</span> ({{$metadata['balance_to_locked']}} в ордерах)</div>
            </div>
        </div>

        <br>
        <h3 class="fw-bold">Статистика</h3>
        <div> Середній курс: {{$metadata['average_price']}}</div>
        <div> Сума {{$metadata['currency_from']}} ({{$metadata['currency_to']}}): {{$metadata['sum_qty']}} ({{$metadata['sum_quoteQty']}})</div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Пара</th>
                <th></th>
                <th>Курс</th>
                <th>Кількість</th>
                <th>Комісія</th>
                <th>Дата</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order['symbol'] }}</td>
                    @if($order['isBuyer'])
                        <td><span class="operationType" style="color: darkgreen; font-weight: bold">Купівля</span></td>
                    @else
                        <td><span class="operationType" style="color: darkred; font-weight: bold">Продаж</span></td>
                    @endif
                    <td>{{ $order['price'] }}</td>
                    <td>{{ $order['qty'] }} ( {{ $order['quoteQty'] }} )</td>
                    <td>{{ $order['commission'] }} ({{$order['commissionAsset']}})</td>
                    <td>{{ date('Y-m-d H:i:s', $order['time']/1000) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <script>
        const myChart = new Chart(ctx, {...});
    </script>
</body>

</html>
