<?php

namespace App\Exports;

use App\product;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
//use Maatwebsite\Excel\Concerns\WithDrawings;
//use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ProductsLowStock implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return product::with('categories')->whereRaw('stock < low_stock_treshold')->get();
    }

   public function map($product) : array {
        $rows = [];
        foreach ($product->categories as $p) {
            array_push($rows,[
                    $product->product_code,
                    $product->Product_name,
                    $product->description,
                    $p->pivot->category_id,
                    $product->price,
                    $product->stock,
                    $product->low_stock_treshold,
                    $product->status,
                    $product->updated_at,
                ]);
            }
        
        return $rows;
    }

    public function headings() : array {
        return [
            'Product_Code',
            'Product_Name',
            'Description',
            'category_id',
            'Price',
            'Stock',
            'Low_stock_treshold',
            'Status',
            'Updated At',
         ] ;
    }
}
