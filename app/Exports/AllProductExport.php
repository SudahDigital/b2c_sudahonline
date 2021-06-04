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
        //return product::withall();
        return product::with('categories')->get();
    }

    public function map($product) : array {
        $rows = [];
        $stock_status= \DB::table('product_stock_status')->first();
        if($stock_status->stock_status == 'ON'){
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
        }
        else{
            foreach ($product->categories as $p) {
                array_push($rows,[
                    $product->product_code,
                    $product->Product_name,
                    $product->description,
                    $p->pivot->category_id,
                    $product->price,
                    $product->status,
                    $product->updated_at,
                ]);
            }
        }
        
        
        return $rows;
    }

    public function headings() : array {
        $stock_status= \DB::table('product_stock_status')->first();
        if($stock_status->stock_status == 'ON'){
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
        }else{
            return [
                'Product_Code',
                'Product_Name',
                'Description',
                'category_id',
                'Price',
                'Status',
                'Updated At',
            ] ;
        }
        
    }
}
