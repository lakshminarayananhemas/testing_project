<?php

namespace App\Imports;

use App\Models\Salesman_info;
use App\Models\salesman_distributor_mapping;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use DB;

class SalesmanImport implements ToModel, WithStartRow
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

        // check salesman already exits using mobile no
        $result = DB::table('salesman_infos as si')
        ->select('si.*')
        ->where('si.phone_no',  '=', $row[4])
        ->get();
        if(count($result) ==0){
            
            $get_scode = new Salesman_info;
            $put_scode = 'SC'.str_pad( ( $get_scode->max( 'id' )+1 ), 6, '0', STR_PAD_LEFT );
        
            Salesman_info::create([
                'distributor_code'     => $row[0],
                'distributor_branch_code'    => $row[1], 
                'salesman_name'    => $row[2], 
                'email_id'    => $row[3], 
                'phone_no'    => $row[4], 
                'daily_allowance'    => $row[5], 
                'salary'    => $row[6], 
                'status'    => $row[7], 
                'salesman_code'    => $put_scode, 
                'dob'    => $this->transformDate($row[8]), 
                'doj'    => $this->transformDate($row[9]), 
                'password'    => $row[10], 
                'salesman_type'    => $row[11], 
                'sm_unique_code'    => $row[12], 
                'third_party_empcode'    => $row[13], 
                'replacement_for'    => $row[14], 
            ]);
            
            salesman_distributor_mapping::create([
                'distributor_code'     => $row[0],
                'salesman_code'    => $put_scode, 
                
            ]);

        }else{

            $result_sdm = DB::table('salesman_distributor_mappings as sdm')
            ->select('sdm.*')
            ->where('sdm.salesman_code',  '=', $result[0]->salesman_code)
            ->where('sdm.distributor_code',  '=', $row[0])
            ->get();

            if(count($result_sdm) ==0){
                return new salesman_distributor_mapping([
                    'distributor_code'     => $row[0],
                    'salesman_code'    => $result[0]->salesman_code, 
                    
                ]);
            }
            
        }
        
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
