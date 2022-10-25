<?php

namespace App\Imports;

use App\Models\Salesman_route_mapping;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SalesmanRouteMappingImport implements ToModel, WithStartRow
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
        
        if($row[0] !=''){
            return new Salesman_route_mapping([
            
                'distributor_code'     => $row[0],
                'distributor_branch_code'   => $row[1], 
                'salesman_code'    => $row[2], 
                'route_code'    => $row[3], 
            ]);
        }
        
    }
}
