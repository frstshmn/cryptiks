<div class="row">
    <div class="col-12">
        <canvas id="profitChart" width="50%" height="30"></canvas>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card h-100">
            <h3 class="fw-bold">Статистика</h3>
            <small class="d-flex flex-row">
                <div class="me-5">Середній курс: <br>{{$metadata['average_price']}}</div>
                <div class="me-5">Сума {{$metadata['currency_from']}} ({{$metadata['currency_to']}}): <br>{{$metadata['sum_qty']}} ({{$metadata['sum_quoteQty']}})</div>
            </small>
        </div>
    </div>
</div>
