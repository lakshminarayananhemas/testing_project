<?php

namespace App\Imports;

use App\Models\Route;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class RouteImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        return new Route([
            'distributor_code'     => $row[0],
            'distributor_branch_code'    => $row[1], 
            'route_name'    => $row[2], 
            'route_code'    => rand(), 
            'status'    => $row[3], 
            'van_route_status'    => $row[4], 
            'population'    => $row[5], 
            'distance'    => $row[6], 
            'route_type'    => $row[7], 
            'city'    => $row[8], 
            'country_status'    => $row[9], 
        ]);
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
}
