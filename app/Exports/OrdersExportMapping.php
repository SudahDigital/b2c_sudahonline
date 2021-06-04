<?php

namespace App\Exports;

use App\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class OrdersExportMapping implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::with('products')->whereNotNull('customer_id')->orderBy('created_at', 'DESC')->get();
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
                $order->customers->store_code,
                $order->customers->store_name,
                $order->customers->name,
                $order->users['name'],
                $order->user_loc,
                $p->Product_name,
                $p->pivot->quantity,
                $p->pivot->price_item,
                $p->pivot->paket_id,
                $p->pivot->group_id,
                $p->pivot->bonus_cat,
                $order->notes,
                $order->created_at,
                $order->process_time,
                $order->finish_time,
                $order->cancel_time,
                //Carbon::parse($order->created_at)->toFormattedDateString()
            ]);
        }
        return $rows;
    }

    public function headings() : array {
        return [
           'Order Id',
           'Status',
           'Cust. Code',
           'Name',
           'Contact Person',
           'Sales Rep',
           'On/Off Loc.',
           'Product',
           'Quantity',
           'Price',
           'Paket_id',
           'Group_id',
           'Bonus Product',
           'Note',
           'Order Date',
           'Process Date',
           'Finish Date',
           'Cancel Date'
        ] ;
    }

    public function columnFormats(): array
    {
        return [
            'F' =>'0',
        ];
        
    }
}
