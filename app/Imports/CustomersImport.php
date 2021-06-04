<?php

namespace App\Imports;

use App\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CustomersImport implements ToModel,  WithHeadingRow, WithValidation
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function rules(): array
    {
        return [
            'cust_code' => 'required',
            'name' => 'required',
            //'city_id'=>'required',
            //'payment_term' => 'required',
        ];

    }

    public function customValidationMessages()
    {
        return [
            'cust_code.required' => 'cust_code is required.',
            'name.required' => 'name is required.',
            //'city_id.required'=> 'City ID is required.',
            //'payment_term.required' => 'payment_term is required.',
        ];
    }

    public function model(array $rows)
    {
        //dd($rows);
        $cek = Customer::where('store_code','=',$rows['cust_code'])->count();
        if($cek > 0){
            $customer = Customer::where('store_code','=',$rows['cust_code'])->first();
            $customer->store_name = $rows['name'];
            if(!empty( $rows['email'])){
                $customer->email = $rows['email'];
            }
            if(!empty( $rows['city_id'])){
                $customer->city_id = $rows['city_id'];
            }
            $customer->address = $rows['address'];
            if(!empty( $rows['whatsapp'])){
                $customer->phone = $rows['whatsapp'];
            }
            if(!empty( $rows['owner_phone'])){
                $customer->phone_owner = $rows['owner_phone'];
            }
            if(!empty( $rows['office_phone'])){
                $customer->phone_store = $rows['office_phone'];
            }
            if(!empty( $rows['contact'])){
                $customer->name = $rows['contact'];
            }
            $customer->payment_term = $rows['payment_term'];
            if(!empty( $rows['sales_rep'])){
                $customer->user_id = $rows['sales_rep'];
            }
            $customer->save();
        }else{
            $customer = new Customer;
            $customer->store_code = $rows['cust_code'];
            $customer->store_name = $rows['name'];
            if(!empty( $rows['email'])){
                $customer->email = $rows['email'];
            }
            if(!empty( $rows['city_id'])){
                $customer->city_id = $rows['city_id'];
            }
            $customer->address = $rows['address'];
            if(!empty( $rows['whatsapp'])){
                $customer->phone = $rows['whatsapp'];
            }
            if(!empty( $rows['owner_phone'])){
                $customer->phone_owner = $rows['owner_phone'];
            }
            if(!empty( $rows['office_phone'])){
                $customer->phone_store = $rows['office_phone'];
            }
            if(!empty( $rows['contact'])){
                $customer->name = $rows['contact'];
            }
            $customer->payment_term = $rows['payment_term'];
            if(!empty( $rows['sales_rep'])){
                $customer->user_id = $rows['sales_rep'];
            }
            $customer->save();
        }
        /*return new Customer([
            'store_code'=>$row[0]=='NULL' ? null : $row[0],
            'store_name' => $row[1]=='NULL' ? null : $row[1],
            'address' => $row[2]=='NULL' ? null : $row[2],
            'phone'=>$row[3]=='NULL' ? null : $row[3],
            'phone_owner'=>$row[4]=='NULL' ? null : $row[4],
            'phone_store'=>$row[5]=='NULL' ? null : $row[5],
            'name' => $row[6]=='NULL' ? null : $row[6],
            'payment_term'=>$row[7]=='NULL' ? null : $row[7],
            /*'user_id'=>$row[8]=='NULL' ? null : $row[8],
        ]);*/
    }

    /*public function startRow(): int
    {
        return 2;
    }*/
}
