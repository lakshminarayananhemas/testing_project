<?php

namespace App\Imports;

use App\Models\Deliveryboy_route;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class Deliveryboy_routeImport implements ToModel, WithStartRow
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
        return new Deliveryboy_route([
            'distributor_code'     => $row[0],
            'distributor_branch_code'    => $row[1], 
            'deliveryboy_code'    => $row[2], 
            'route_code'    => $row[3], 
        ]);
    }
}
