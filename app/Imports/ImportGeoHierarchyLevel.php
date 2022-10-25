<?php

namespace App\Imports;

use App\Models\GeoHierarchyLevel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportGeoHierarchyLevel implements ToModel, WithStartRow
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

            return new GeoHierarchyLevel([
                    'company_code'     => $row[0],
                    'level_code'    => $row[1], 
                    'level_name'    => $row[2], 
            
            ]);
        }
    }
}
