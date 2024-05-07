<div class="row">
    <div class="col-3">
        <div class="card h-100">
            <h3 class="fw-bold">Статистика</h3>
            <small>
                <div>Середній курс: <br>{{$metadata['average_price']}}</div>
                <br>
                <div>Сума {{$metadata['currency_from']}} ({{$metadata['currency_to']}}): <br>{{$metadata['sum_qty']}} ({{$metadata['sum_quoteQty']}})</div>
            </small>
        </div>
    </div>
    <div class="col-9">
        <canvas id="profitChart" width="50%" height="30"></canvas>
    </div>
</div>
