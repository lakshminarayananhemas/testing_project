<?php

namespace App\Imports;

use App\Models\Target_upload;
use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DistributorTargetImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    /**
     * @return int
     */

    public function model(array $row)
    {
        return Target_upload::updateOrCreate([
                'employee_code'     => $row['employee_code'],
                'jc_period'    => $row['jc_period'], 
            ],
            [
                'target_amount'    => $row['target_amount'], 
                'role_type'    => 'Distributor', 
                'created_by'    => '4',
            ]
        );
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
