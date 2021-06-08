<?php

namespace App\Exports;

use App\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExportMapping implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::with('products')->whereNotNull('username')->get();
    }

    public function map($order) : array {
        $rows = [];
        foreach ($order->products as $p) {
            if(($p->pivot->discount_item != NULL)&&($p->pivot->discount_item > 0)){
                $diskon =$p->pivot->discount_item;
                $total= $p->pivot->price_item_promo * $p->pivot->quantity;
            }else{
                $diskon = 0;
                $total= $p->pivot->price_item * $p->pivot->quantity;
            }
            array_push($rows,[
                $order->id,
                $order->status,
                $order->username,
                $order->email,
                $order->address,
                $order->phone,
                $p->description,
                $p->pivot->quantity,
                $p->pivot->price_item,
                $diskon,
                $total,
                Carbon::parse($order->created_at)->toFormattedDateString()
            ]);
        }
        return $rows;
    }

    public function headings() : array {
        return [
           'Order_id',
           'Status',
           'Buyer Name',
           'Email',
           'Address',
           'Phone',
           'Product',
           'Quantity',
           'Price',
           'Discount(%)',
           'Total Price',
           'Order Date'
        ] ;
    }
}
