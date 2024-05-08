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
