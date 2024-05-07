<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $currency_from = strtoupper($request->currency_from);
        $currency_to = strtoupper($request->currency_to);

        if ($currency_to && $currency_from) {

            $user = auth()->user();
            $key = $user->binance_api_key;
            $secret = $user->binance_api_secret;

            $url = "https://api.binance.com/api/v3/time";
            $result = $this->request($url, $key);

            $query = "symbol=" . $currency_from . $currency_to . "&timestamp=" . $result['serverTime'];
            $sign = hash_hmac('SHA256', $query, $secret);
            $url = "https://api.binance.com/api/v3/myTrades?" . ($query) . "&signature=" . $sign;

            $result = $this->request($url, $key);
            usort($result, array($this, 'date_compare'));

            $average_price = 0;
            $count = 0;
            $sum_qty = 0;
            $sum_quoteQty = 0;
            foreach ($result as $item) {
                $average_price += $item['price'];
                if ($item['isBuyer']) {
                    $sum_qty += $item['qty'];
                    $sum_quoteQty += $item['quoteQty'];
                } else {
                    $sum_qty -= $item['qty'];
                    $sum_quoteQty -= $item['quoteQty'];
                }
                $count++;
            }
            $average_price = $average_price / $count;

            $balances = $this->balances($key, $secret);

            $balance_from_free = 0;
            $balance_from_locked = 0;
            $balance_to_free = 0;
            $balance_to_locked = 0;

            foreach($balances['balances'] as $balance) {
                if($balance['asset'] == $currency_from) {
                    $balance_from_free = $balance['free'];
                    $balance_from_locked = $balance['locked'];
                }
                if($balance['asset'] == $currency_to) {
                    $balance_to_free = $balance['free'];
                    $balance_to_locked = $balance['locked'];
                }
            }

            $labels = [];
            $data = [];
            $current_profit = 0;
            for($i = 0; $i < count($result); $i++) {
                $labels[] = date('Y-m-d H:i:s', $result[$i]['time']/1000);
                if ($result[$i]['isBuyer']) {
                    $current_profit += $result[$i]['quoteQty'];
                } else {
                    $current_profit -= $result[$i]['quoteQty'];
                }
                $data[] = $current_profit;
            }

            $graph = [
                'profit' => [
                    'labels' => json_encode($labels),
                    'data' => json_encode($data)
                ]
            ];

            $styles = [
                'isInverted' => (bool) $request->isInverted ?? false,
            ];

            $metadata = [
                'currency_from' => $currency_from,
                'currency_to' => $currency_to,
                'average_price' => $average_price,
                'sum_qty' => $sum_qty,
                'sum_quoteQty' => $sum_quoteQty,
                'balance_from_free' => $balance_from_free,
                'balance_to_free' => $balance_to_free,
                'balance_from_locked' => $balance_from_locked,
                'balance_to_locked' => $balance_to_locked
            ];

            return view('orders.dashboard', [
                    'orders' => $result,
                    'metadata' => $metadata,
                    'styles' => $styles,
                    'graph' => $graph
                ]
            );
        }
    }

    private function balances($key, $secret)
    {
        $url = "https://api.binance.com/api/v3/time";
        $result = $this->request($url, $key);

        $query = "timestamp=" . $result['serverTime'];
        $sign = hash_hmac('SHA256', $query, $secret);

        $url = "https://api.binance.com/api/v3/account?" . ($query) . "&signature=" . $sign;

        $result = $this->request($url, $key);

        return $result;
    }

    public function request($url, $key, $method = 'GET', $data = null)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-MBX-APIKEY:'.$key));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        $result = curl_exec($ch);

        $result = json_decode($result, true);

        curl_close($ch);

        return $result;
    }

    function date_compare($element1, $element2) {
        return $element2['time'] - $element1['time'];
    }

}
