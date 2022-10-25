<?php

namespace App\Imports;

use App\Models\GeoHierarchyLevelValue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportGeoHierarchyLevelValue implements ToModel, WithStartRow
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

            return new GeoHierarchyLevelValue([
                'company_code'     => $row[0],
                'level_code'    => $row[1], 
                'level_name'    => $row[2], 
                'company_value'    => $row[3], 
                'reporting_to'    => $row[4], 
            ]);
        }
    }
}
