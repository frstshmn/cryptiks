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
        .card.card-green {
            background-color: #d4edda;
            color: #155724;
        }
        .balance-card {
            background-color: #222;
            color: #f8f9fa;
            padding: 20px;
            border-radius: 15px 15px 0 0;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.5);
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
            width: 120px;
            text-align: center;
        }
        .input-header:focus {
            outline: none;
        }

        .currency-options {
            display: none;
            top: 70px;
            position: absolute;
            height: 300px;
            width: 200px;
            overflow: auto;
            background-color: #f8f9fa;
            border-radius: 15px;
            box-shadow: 0 8px 10px rgba(0, 0, 0, 0.3);
            z-index: 100;
            border: 1px solid #ddd;
        }
        .currency-option-search {
            border: 0;
            border-radius: 15px 15px 0 0;
            box-shadow: 0 5px 5px rgba(0, 0, 0, 0.1);
            padding: 0.5em 1em;
            width: 200px;
            margin-bottom: 5px;
        }
        .currency-option-search:focus {
            outline: none;
        }
        .currency-option {
            padding: 5px 15px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .currency-option:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body class="@if($styles['isInverted']) inverted @endif px-4 pt-4">
    <div class="d-flex flex-row justify-content-between">
        <h1 class="fw-bold mb-3">Ордери</h1>
        <form method="get" class="d-flex flex-row align-items-center">
            <input class="input-header dropdown" type="text" name="currency_from" placeholder="" value="{{ $metadata['currency_from'] ?? '' }}">
            <div class="currency-options">
                <input class="currency-option-search" placeholder="Шукати...">
                @foreach($metadata['currencies'] as $currency)
                    <div class="currency-option" data-value="{{ $currency }}">{{ $currency }}</div>
                @endforeach
            </div>

            <div class="vr"></div>

            <input class="input-header dropdown" type="text" name="currency_to" placeholder="" value="{{ $metadata['currency_to'] ?? '' }}">
            <div class="currency-options">
                <input class="currency-option-search" placeholder="Шукати...">
                @foreach($metadata['currencies'] as $currency)
                    <div class="currency-option" data-value="{{ $currency }}">{{ $currency }}</div>
                @endforeach
            </div>

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
            <div class="card card-green text-center shadow">
                <h4 class="fw-bold">Підсумок</h4>
                <small class="">
                    <div class="mb-3">Середній курс: <br><span class="fw-bold h5 mt-2">{{$metadata['average_price']}}</span></div>
                    <div>Прибуток: <br><span class="fw-bold h5 mt-2">{{$metadata['sum_quoteQty']}}</span></div>
                </small>
            </div>
            <br>
            <div class="card shadow">
                <h3 class="fw-bold">Статистика</h3>
                <small>
                    <div class="me-5">Середній курс: <br>{{$metadata['average_price']}}</div>
                    <br>
                    <div class="me-5">Сума {{$metadata['currency_from']}} ({{$metadata['currency_to']}}): <br>{{$metadata['sum_qty']}} ({{$metadata['sum_quoteQty']}})</div>
                </small>
            </div>
            <br>
        </div>
        <div class="col-9">
            @include('components.orders.statistics')
            <br>
            <nav class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Стисло</a>
                <a class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Детально</a>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-4">
                                <h6 class="fw-bold">Курс ({{$metadata['average_price']}})</h6>
                            </div>
                            <div class="col-4">
                                <h6 class="fw-bold">Сума {{$metadata['currency_to']}} ({{$metadata['sum_quoteQty']}})</h6>
                            </div>
                        </div>
                        <hr>
                    @foreach($orders as $order)
                            <div class="row">
                                <div class="col-4">
                                    <span class="small">{{ $order['price'] }}</span>
                                </div>
                                <div class="col-4">
                            <span class="small">
                                @if($order['isBuyer'])
                                    <span style="color: darkred; font-weight: bold">- {{ $order['quoteQty']}}</span>
                                @else
                                    <span style="color: darkgreen; font-weight: bold">&nbsp; {{ $order['quoteQty']}}</span>
                                @endif
                            </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
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
                                <td class="small" data-sort="{{ $order['time'] }}">{{ date('d M Y H:i:s', $order['time']/1000) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
        $('.input-header').on('focus', function() {
            $('.currency-options').hide();
            let selector_tooltip = $(this).next();
            selector_tooltip.show();
            selector_tooltip.css('left', ($(this).position().left) - 40);
        });
        $('.currency-option-search').on('keyup', function() {
            let value = $(this).val().toLowerCase();
            $(this).parent().find('.currency-option').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
        $('.currency-option').on('click', function() {
            $(this).parent().prev().val($(this).data('value'));
            $(this).parent().hide();
        });
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
                    backgroundColor: '#d4edda',
                    borderColor: '#155724',
                    borderWidth: 1
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
