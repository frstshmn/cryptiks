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
