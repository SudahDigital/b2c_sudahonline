<?php

namespace App\Exports;

use App\product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AllProductExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return product::all();
    }

    public function map($product) : array {
        return[
                $product->id,
                $product->Product_name,
                $product->description,
                $product->price,
                $product->stock,
                $product->low_stock_treshold,
                $product->status,
            ];
    }

    public function headings() : array {
        return [
           'Product_id',
           'Product_Name',
           'Description',
           'Price',
           'Stock',
           'Low_stock_treshold',
           'Status',
        ] ;
    }
}
