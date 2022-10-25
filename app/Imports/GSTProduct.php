<?php

namespace App\Imports;

use App\Models\GST_Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GSTProduct implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        //
        return GST_Product::updateOrCreate([

            'company_code'     => $row['company_code'],
            'product_code'    => $row['product_code'], 
            'product_name'    => $row['product_name'], 
            'hsn_code'    => $row['hsn_code'], 
            'hsn_name'    => $row['hsn_name'], 
            'gst_product_type'     => $row['gst_product_type'],
            'status'    => "Active", 
        ]);
    }
}
