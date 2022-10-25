<?php

namespace App\Imports;

use App\Models\GST_Distributor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GSTDistributor implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        //
        return GST_Distributor::updateOrCreate([

            'company_code'     => $row['company_code'],
            'distributor_code'    => $row['distributor_code'], 
            'distributor_name'    => $row['distributor_name'], 
            'gstin_number'    => $row['gstin_number'], 
            'gst_distr_type'    => $row['gst_distr_type'], 
            'pan_no'     => $row['pan_no'],
            'gst_state_code'     => $row['gst_state_code'],
            'fssai_no'     => $row['fssai_no'],
            'aadhar_no'     => $row['aadhar_no'],
            'tcs_applicable'     => $row['tcs_applicable'],
            'tds_applicable'     => $row['tds_applicable'],
            'itr_filed'     => $row['itr_filed'],
            'status'    => "Active", 
        ]);
    }
}
