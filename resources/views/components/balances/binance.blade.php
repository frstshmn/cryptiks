<div class="balance-card">
    <h2 class="h5 fw-bold"><img src="https://upload.wikimedia.org/wikipedia/commons/1/12/Binance_logo.svg" width="40%" /> Баланс</h2>
    <hr>
    <small>
        <div class="row">
            <div class="col-3 ">
                <span class="h5 text-right">{{$metadata['currency_from']}}</span>:
            </div>
            <div class="col-9">
                <div class="row amount_free">
                    {{$metadata['balance_from_free']}}
                </div>
                <div class="row amount_orders">
                    {{$metadata['balance_from_locked']}} в ордерах
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-3 ">
                <span class="h5 text-right">{{$metadata['currency_to']}}</span>:
            </div>
            <div class="col-9">
                <div class="row amount_free">
                    {{$metadata['balance_to_free']}}
                </div>
                <div class="row amount_orders">
                    {{$metadata['balance_to_locked']}} в ордерах
                </div>
            </div>
        </div>
    </small>
</div>
<a class="btn btn-warning fw-bold border-rounded px-3 trade-btn" href="https://www.binance.com/uk-UA/trade/{{$metadata['currency_from']}}_{{$metadata['currency_to']}}?type=spot" target="_blank">Торгівля {{$metadata['currency_from']}}{{$metadata['currency_to']}}</a>
