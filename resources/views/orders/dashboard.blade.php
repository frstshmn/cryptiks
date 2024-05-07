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
        body.inverted .no-revert {
            -webkit-filter: invert(90%);
            filter: invert(90%);
        }
        .container {
            margin-top: 50px;
        }
        th {
            cursor: pointer;
        }
        th.active{
            background-color: #f8f9fa;
            color: darkviolet;
        }
        th.asc:after {
            content: ' 🔼';
        }
        th.desc:after {
            content: ' 🔽';
        }
        th:hover {
            background-color: #f8f9fa;
        }
        .shadow {
        }
        .card {
            background-color: #f8f9fa;
            color: #222;
            padding: 20px;
            border-radius: 15px;
        }
        .balance-card {
            background-color: #222;
            color: #f8f9fa;
            padding: 20px;
            border-radius: 15px 15px 0 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .balance-card + .trade-btn {
            border: 0;
            box-shadow: inset 0 5px 5px rgba(0, 0, 0, 0.3);
            border-radius: 0 0 15px 15px;
            width: 100%;
        }
        .border-rounded {
            border-radius: 15px;
        }
        .balance-card .amount_orders {
            color: #777;
        }
        .vr {
            border-left: 1px solid #ddd;
            height: 100%;
            margin: 0 10px;
        }
        .input-header {
            border: 0;
            padding: 0 1em;
            font-size: 1.2em;
            width: 90px;
            text-align: center;
        }
        .input-header:focus {
            outline: none;
        }
    </style>
</head>
<body class="@if($styles['isInverted']) inverted @endif px-4 pt-4">
    <div class="d-flex flex-row justify-content-between">
        <h1 class="fw-bold mb-3">Ордери</h1>
        <form method="get" class="d-flex flex-row align-items-center">
            <input class="input-header" type="text" name="currency_from" placeholder="Currency From" value="{{ $metadata['currency_from'] ?? '' }}"><br>
            <div class="vr"></div>
            <input class="input-header" type="text" name="currency_to" placeholder="Currency To" value="{{ $metadata['currency_to'] ?? '' }}"><br>
            <small>
                <input class="btn btn-dark no-revert small fw-bold py-1 fs-6 ms-3 border-rounded px-3" type="submit" value="Шукати 🔍">
            </small>
        </form>
        <div class="profile">
             Привіт, {{ Auth::user()->name }}!
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="shadow border-rounded">
                @include('components.balances.binance')
            </div>
            <br>
            <div class="card">
                <h6 class="fw-bold">Підсумок</h6>
                <small>
                    <div>Середній курс: {{$metadata['average_price']}}</div>
                    <div>Прибуток: {{$metadata['sum_quoteQty']}}</div>
                </small>
            </div>
            <br>
            <div class="card">
                <div class="row">
                    <div class="col-6">
                        <h6 class="fw-bold">Курс</h6>
                    </div>
                    <div class="col-6">
                        <h6 class="fw-bold">Сума</h6>
                    </div>
                </div>
                @foreach($orders as $order)
                    <div class="row">
                        <div class="col-6">
                            <span class="small">{{ $order['price'] }}</span>
                        </div>
                        <div class="col-6">
                            <span class="small">
                                @if($order['isBuyer'])
                                   <span style="color: darkred; font-weight: bold">-</span>
                                @else
                                    <span style="color: darkgreen; font-weight: bold">+</span>
                                @endif
                                {{ $order['quoteQty']}}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-9">
            @include('components.orders.statistics')
            <br>
            <table class="table table-striped">
                <tbody>
                <tr>
                    <th>Пара</th>
                    <th></th>
                    <th>Курс</th>
                    <th>Кількість</th>
                    <th>Комісія</th>
                    <th>Дата</th>
                </tr>
                @foreach($orders as $order)
                    <tr>
                        <td class="small" data-sort="1">{{ $order['symbol'] }}</td>
                        @if($order['isBuyer'])
                            <td class="small" data-sort="1"><span class="operationType no-revert" style="color: darkgreen; font-weight: bold">Купівля</span></td>
                        @else
                            <td class="small" data-sort="0"><span class="operationType no-revert" style="color: darkred; font-weight: bold">Продаж</span></td>
                        @endif
                        <td class="small" data-sort="{{ $order['price'] }}">{{ $order['price'] }}</td>
                        <td class="small" data-sort="{{ $order['qty'] }}">{{ $order['qty'] }} ({{ $order['quoteQty'] }})</td>
                        <td class="small" data-sort="{{ $order['commission'] }}">{{ $order['commission'] }} ({{$order['commissionAsset']}})</td>
                        <td class="small" data-sort="{{ $order['time'] }}">{{ date('Y-m-d H:i:s', $order['time']/1000) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.0.2"></script>
    <script>
        const getCellValue = (tr, idx) => parseFloat(tr.children[idx].dataset.sort);

        const comparer = (idx, asc) => (a, b) => ((v1, v2) =>
                v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2)
        )(getCellValue(asc ? a : b, idx), getCellValue(asc ? b : a, idx));

        document.querySelectorAll('th').forEach(th => th.addEventListener('click', (() => {
            const table = th.closest('table tbody');
            $('th').removeClass('active');
            $(th).addClass('active');
            $('th').removeClass('asc');
            $('th').removeClass('desc');
            $(th).addClass(this.asc ? 'desc' : 'asc');
            Array.from(table.querySelectorAll('tr:nth-child(n+2)'))
                .sort(comparer(Array.from(th.parentNode.children).indexOf(th), this.asc = !this.asc))
                .forEach(tr => table.appendChild(tr) );
        })));
    </script>
    <script>
        const ctx = document.getElementById('profitChart');
        let labels = {!! $graph['profit']['labels'] !!};
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Прибуток',
                    data: {!! $graph['profit']['data'] !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1,
                    pointRadius: 0 // Add this line
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false
                    },
                    x: {
                        display: false // Add this line
                    }
                },
                plugins: {
                    annotation: {
                        annotations: {
                            zeroLine: {
                                type: 'line',
                                yMin: 0,
                                yMax: 0,
                                borderColor: 'rgb(255, 0, 0)',
                                borderWidth: 2
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
