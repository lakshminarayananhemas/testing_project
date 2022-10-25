<?php

namespace App\Imports;

use App\Models\Customer_route;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CustomerRouteImport implements ToModel, WithStartRow
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
        return new Customer_route([
            'distributor_code'     => $row[0],
            'distributor_branch_code'    => $row[1], 
            'customer_code'    => $row[2], 
            'route_code'    => $row[3], 
            'route_type'    => $row[4], 
        ]);
    }
}
