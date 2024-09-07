<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facturama;
use App\Models\Order;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = auth()->user()->orders()->actives()->get();

        return view('invoices.index', [
            'invoices' => $invoices
        ]);
    }

    public function download(Order $order)
    {
        return Storage::download($order->downloadInvoice());
    }

    public function store(Facturama $facturama, Request $request)
    {
        $order = Order::find($request->invoice_id);

        $params = [
            "Currency" => "MXN",
            "ExpeditionPlace" => "29066",
            "Folio" => 159,
            "CfdiType" => "I",
            "PaymentForm" => "99",
            "PaymentMethod" => "PPD",
            "Receiver" => [
                "Rfc" => "GAPL951118JI1",
                "Name" => "LUIS FERNANDO GARCIA PEREZ",
                "CfdiUse" => "S01",
                "TaxZipCode" => "29000",
                "FiscalRegime" => "616",
            ],
            'Items' => [
                [
                    'ProductCode' => '10101504',
                    'IdentificationNumber' => 'EDL',
                    'Description' => 'Estudios de viabilidad',
                    'Unit' => 'NO APLICA',
                    'UnitCode' => 'MTS',
                    'UnitPrice' => 50.0,
                    'Quantity' => 2.0,
                    'Subtotal' => 100.0,
                    "TaxObject" => "02",
                    'Taxes' => [
                        [
                            'Total' => 16.0,
                            'Name' => 'IVA',
                            'Base' => 100.0,
                            'Rate' => 0.16,
                            'IsRetention' => false,
                        ],
                    ],
                    'Total' => 116.0,
                ],
            ],
        ];

        // $params = [
        //     "Currency" => "MXN",
        //     "ExpeditionPlace" => "29066",
        //     "Folio" => 159,
        //     "CfdiType" => "I",
        //     "PaymentForm" => "99",
        //     "PaymentMethod" => "PPD",
        //     "Receiver" => [
        //         "Rfc" => "GAPL951118JI1",
        //         "Name" => "LUIS FERNANDO GARCIA PEREZ",
        //         "CfdiUse" => "S01",
        //         "TaxZipCode" => "29000",
        //         "FiscalRegime" => "616",
        //     ],
        //     'item' => $order->orderDetails->map(function ($item) {
        //         return [
        //             'ProductCode' => '10101504',
        //             'IdentificationNumber' => 'EDL',
        //             'Description' => $item->product->name,
        //             'Unit' => 'NO APLICA',
        //             'UnitCode' => 'MTS',
        //             'UnitPrice' => 50.0,
        //             'Quantity' => 2.0,
        //             'Subtotal' => 100.0,
        //             "TaxObject" => "02",
        //             'Taxes' => [
        //                 [
        //                     'Total' => 16.0,
        //                     'Name' => 'IVA',
        //                     'Base' => 100.0,
        //                     'Rate' => 0.16,
        //                     'IsRetention' => false,
        //                 ],
        //             ],
        //             "total" => "116"
        //         ];
        //     })
        // ];

        $response = $facturama->createInvoice($params);
        $order->update(['facturama_id' => $response->Id]);
        
        return redirect()->route('invoices.index');
    }
}
