<?php

namespace App\Exports;

use App\City;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CitiesExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return City::all();
        return City::where('type','=','Kota')
        ->orderBy('display_order','ASC')
        ->orderBy('postal_code','ASC')
        ->get();
    }

    public function map($city) : array {
        return[
                $city->id,
                $city->city_name,
            ];
    }

    public function headings() : array {
        return [
           'City ID',
           'City Name',
        ] ;
    }
}
