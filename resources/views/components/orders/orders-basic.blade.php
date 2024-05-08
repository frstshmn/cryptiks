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
    <div class="d-flex flex-column-reverse">
        @php($profit = 0)
        @foreach($orders as $order)
            <div class="row profit-calc">
                <div class="col-4">
                    <span class="small">{{ $order['price'] }}</span>
                </div>
                <div class="col-4">
                <span class="small">
                    @if($order['isBuyer'])
                        @php($profit -= $order['quoteQty'])
                        <span style="color: darkred; font-weight: bold">- {{ $order['quoteQty']}}</span>
                    @else
                        @php($profit += $order['quoteQty'])
                        <span style="color: darkgreen; font-weight: bold">&nbsp; {{ $order['quoteQty']}}</span>
                    @endif
                    <span style="color: @if($profit < 0) darkred @else darkgreen @endif; font-weight: bold; opacity: 0.4">&nbsp; {{$profit}}</span>


                </span>
                </div>
            </div>
        @endforeach
    </div>
</div>
