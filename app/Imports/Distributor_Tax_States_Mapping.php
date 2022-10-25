<?php

namespace App\Imports;

use App\Models\GST_Distributor_Tax_States_Mapping;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Distributor_Tax_States_Mapping implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        //
        return GST_Distributor_Tax_States_Mapping::updateOrCreate([

            'company_code'     => $row['company_code'],
            'distributor_code'    => $row['distributor_code'], 
            'to_state_code'    => $row['to_state_code'], 
            'status'    => "Active", 
        ]);
    }
}
