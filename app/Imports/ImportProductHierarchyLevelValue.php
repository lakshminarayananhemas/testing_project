<?php

namespace App\Imports;

use App\Models\ProductHierarchyLevelValue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportProductHierarchyLevelValue implements ToModel, WithStartRow
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
        if($row[1] !=''){

            return new ProductHierarchyLevelValue([
                'company_code'     => $row[0],
                'level_name'    => $row[1], 
                'level_value_code'    => $row[2], 
                'level_value_name'    => $row[3], 
                'reporting_level_name'    => $row[4], 
            ]);
        }
    }
}
