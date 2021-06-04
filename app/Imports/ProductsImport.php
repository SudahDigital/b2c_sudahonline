<?php

namespace App\Imports;

use App\product;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function rules(): array
    {
        $stock_status= \DB::table('product_stock_status')->first();
        if($stock_status->stock_status == 'ON'){
            return [
                'product_code' => 'required',
                'stock' => 'max:999999999|numeric',
                
            ];
        }else{
            return [
                'product_code' => 'required',
                //'stock' => 'max:999999999|numeric',
                
            ];
        }
    }

    public function customValidationMessages()
    {
        $stock_status= \DB::table('product_stock_status')->first();
        if($stock_status->stock_status == 'ON'){
            return [
                'product_code.required' => 'Product_code is required.',
                'stock' => 'stock is max 9 digits.',
            ];
        }else{
            return [
                'product_code.required' => 'Product_code is required.',
                //'stock' => 'stock is max 9 digits.',
            ];
        }
    }

    public function model(array $rows)
    {
            //dd($rows);
            $cek = product::where('product_code','=',$rows['product_code'])->count();
            $stock_status= \DB::table('product_stock_status')->first();
            //dd($cek);
            
            if($cek > 0){
                $product = product::where('product_code','=',$rows['product_code'])->first();
                $product->product_code = $rows['product_code'];
                $product->Product_name = $rows['product_name'];
                $product->slug = \Str::slug($rows['product_name']);
                $product->description = $rows['description'];
                $product->price = $rows['price'];
                $product->price_promo = $rows['price'];
                $product->discount = 0.00;
                $product->updated_by = \Auth::user()->id;
                if($stock_status->stock_status == 'ON'){
                    if(!empty( $rows['stock'])){
                        $product->stock = $rows['stock'];
                    }
                    if(!empty( $rows['low_stock_treshold'])){
                        $product->low_stock_treshold = $rows['low_stock_treshold'];
                    }
                }
                //$product->low_stock_treshold = $rows['low_stock_treshold']== NULL ? null : $rows['low_stock_treshold'];
                $product->status = $rows['status'];
                $product->save();
                $product->categories()->sync($rows['category_id']);
            }else{
                $product = new product;
                $product->product_code = $rows['product_code'];
                $product->Product_name = $rows['product_name'];
                $product->slug = \Str::slug($rows['product_name']);
                $product->description = $rows['description'];
                $product->price = $rows['price'];
                $product->price_promo = $rows['price'];
                $product->discount = 0.00;
                $product->created_by = \Auth::user()->id;
                if($stock_status->stock_status == 'ON'){
                    if(!empty( $rows['stock'])){
                        $product->stock = $rows['stock'];
                    }
                    if(!empty( $rows['low_stock_treshold'])){
                        $product->low_stock_treshold = $rows['low_stock_treshold'];
                    }
                }
                //$product->low_stock_treshold = $rows['low_stock_treshold']== NULL ? null : $rows['low_stock_treshold'];
                $product->status = $rows['status'];
                $product->save();
                $product->categories()->attach($rows['category_id']);
            }
            
        
    }

}