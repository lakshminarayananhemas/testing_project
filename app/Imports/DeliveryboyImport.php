<?php

namespace App\Imports;

use App\Models\Deliveryboy;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DeliveryboyImport implements ToModel, WithStartRow
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
        return new Deliveryboy([
            'distributor_code'     => $row[0],
            'distributor_branch_code'    => $row[1], 
            'deliveryboy_code'    => $row[2], 
            'deliveryboy_name'    => $row[3], 
            'phone_no'    => $row[4], 
            'email_id'     => $row[5],
            'daily_allowance'    => $row[6], 
            'salary'    => $row[7], 
            'status'    => $row[8], 
            'default_status'    => $row[9], 
        ]);
    }
}
