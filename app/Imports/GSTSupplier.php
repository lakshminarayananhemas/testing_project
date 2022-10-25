<?php

namespace App\Imports;

use App\Models\GST_Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class GSTSupplier implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        //
        // return new GST_Supplier([ 
        return GST_Supplier::updateOrCreate([
            'company_code'     => $row['company_code'],
            'supplier_code'    => $row['supplier_code'], 
            'supplier_name'    => $row['supplier_name'], 
            'supplier_state'    => $row['supplier_state'], 
            'gst_state_code'    => $row['gst_state_code'], 
            'supplier_gst_in'     => $row['supplier_gst_in'],
            'status'    => "Active", 
        ]);
    }
}
