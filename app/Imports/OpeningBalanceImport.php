<?php

namespace App\Imports;

use App\Models\Opening_balance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class OpeningBalanceImport implements ToModel, WithStartRow
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
        return new Opening_balance([
            'distributor_code'     => $row[0],
            'distributor_branch_code'    => $row[1], 
            'coa_code'    => $row[2], 
            'credit_amount'    => $row[3], 
            'debit_amount'    => $row[4], 
            'opening_balance_date'    => $this->transformDate($row[5]),
        ]);
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
