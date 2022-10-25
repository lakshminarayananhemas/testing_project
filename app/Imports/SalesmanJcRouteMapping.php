<?php

namespace App\Imports;

use App\Models\Salesman_jc_route_mapping;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SalesmanJcRouteMapping implements ToModel, WithStartRow
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
        return new Salesman_jc_route_mapping([
            'distributor_code'     => $row[0],
            'customer_code'     => $row[1],
            'salesman_code'     => $row[2],
            'route_code'     => $row[3],
            'jc_month'     => $row[4],
            'frequency'     => $row[5],
            'daily'     => $row[6],
            'weekly'     => $row[7],
            'monthly'     => $this->transformDate($row[8]),
            'status'     => $row[9],
            
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
