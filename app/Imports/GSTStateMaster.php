<?php

namespace App\Imports;

use App\Models\GST_State_Master;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GSTStateMaster implements ToModel, WithHeadingRow
{
    /** 
    * @param Collection $collection 
    */
    public function model(array $row)
    {
        //
        return GST_State_Master::updateOrCreate([
            'gst_state_Code'     => $row['gst_state_Code'],
            'gst_state_name'    => $row['gst_state_name'], 
            'is_union_territory'    => $row['is_union_territory'], 
            'is_gst_enabled'    => $row['is_gst_enabled'], 
            'status'    => "Active", 
        ]);
    }
}
