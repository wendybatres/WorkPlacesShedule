<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $order = Order::create($request->except('_token') + ['user_id' => auth()->id()]);

        $items = cart()->content()->map(function($item) use($order) {
            $orderDetail = OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'price' => $item->price,
                'quantity' => 1
            ]);

            return [
                'id' => "PROD-{$orderDetail->id}",
                'name' => $orderDetail->product->id,
                'quantity' => 1,
                'unit_price' => (float) $orderDetail->price
            ];
        })->values()->toArray();

        MercadoPagoConfig::setAccessToken(config('services.mercado_pago.token'));
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

        $client = new PreferenceClient;

        try {
            $preference = $client->create([
                "items" => $items,
                "auto_return" => "approved",
                "back_urls" => [
                    'success' => route('config', ['order' => $order]),
                    'failure' => route('config', ['order' => $order]),
                    'pending' => route('config', ['order' => $order]),
                ],
                "statement_descriptor" => "Tienda CF",
            ]);

            $order->update(['preference' => $preference->id]);

            return redirect($preference->init_point);
        } catch(\Exception $e) {
            return redirect('/home')->with('message', 'Hubo un error!');
        }
    }

    public function callback(Order $order, Request $request)
    {
        if ($order->preference == $request->preference_id) {
            $order->update(['api_response' => $request->all()]);
            cart()->destroy();
        }

        return redirect('/home')->with('success', 'Se acredito el pago');
    }
}
