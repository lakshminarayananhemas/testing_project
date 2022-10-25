<?php

namespace App\Imports;

use App\Models\salesman_distributor_mapping;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SalesmanDistributorMappingImport implements ToModel, WithStartRow
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
            return new salesman_distributor_mapping([
            
                'salesman_code'    => $row[0], 
                'distributor_code'     => $row[1],
            ]);
        }
    }
}
