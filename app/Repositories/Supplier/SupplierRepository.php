<?php 

namespace App\Repositories\Supplier;


use App\Models\Supplier;
use DB;

class SupplierRepository implements ISupplierRepository
{
    public function getSupplier(){

        // $suppliers = DB::table('suppliers as s')
        //     ->leftJoin('companies as c', 'c.auto_id', '=', 's.company')
        //     ->leftJoin('g_s_t__state__masters as gsm', 'gsm.gst_state_code', '=', 's.gst_state_name')
        //     ->leftJoin('towns_details as td', 'td.country_code', '=', 's.country')
        //     // ->leftJoin('towns_details as td', 'td.country_code', '=', 's.country')
        //     ->select('s.*', 'c.company_name','gsm.gst_state_name','td.country_name')
        //     ->orderBy('s.id', 'desc')
        //     ->get();

        // return $suppliers;
        $suppliers = Supplier::all();

        return $suppliers;
    }

    public function storeSupplier($form_credentials){

        $save_data = new Supplier;
        $save_data->auto_id = 'S'.str_pad( ( $save_data->max( 'id' )+1 ), 9, '0', STR_PAD_LEFT );;
        $save_data->company = $form_credentials['company'];
        $save_data->gst_state_name = $form_credentials['gst_state_name'];
        $save_data->supplier_code = $form_credentials['supplier_code'];
        $save_data->supplier_name = $form_credentials['supplier_name'];
        $save_data->s_address_1 = $form_credentials['s_address_1'];
        $save_data->s_address_2 = $form_credentials['s_address_2'];
        $save_data->s_address_3 = $form_credentials['s_address_3'];
        $save_data->country = $form_credentials['country'];
        $save_data->state = $form_credentials['state'];
        $save_data->city = $form_credentials['city'];
        $save_data->postal_code = $form_credentials['postal_code'];
        $save_data->geo_hierarchy_level = $form_credentials['geo_hierarchy_level'];
        $save_data->geo_hierarchy_value = $form_credentials['geo_hierarchy_value'];
        $save_data->phone_no = $form_credentials['phone_no'];
        $save_data->contact_person = $form_credentials['contact_person'];
        $save_data->s_emailid = $form_credentials['s_emailid'];
        $save_data->tin_no = $form_credentials['tin_no'];
        $save_data->pin_no = $form_credentials['pin_no'];
        $save_data->created_by =  $form_credentials['created_by'];
        $save_data->modified_by =  $form_credentials['modified_by'];
        $save_data->save();

        if($save_data) {
            return 200;
        } else {
            return 424;
        }

    }

    public function findSupplier($id){
        $supplier = Supplier::find($id);
        return $supplier;

    }

    public function updateSupplier($form_credentials){
        $supplier = Supplier::find($form_credentials['id']);
        $supplier->company = $form_credentials['company'];
        $supplier->gst_state_name = $form_credentials['gst_state_name'];
        $supplier->supplier_code = $form_credentials['supplier_code'];
        $supplier->supplier_name = $form_credentials['supplier_name'];
        $supplier->s_address_1 = $form_credentials['s_address_1'];
        $supplier->s_address_2 = $form_credentials['s_address_2'];
        $supplier->s_address_3 = $form_credentials['s_address_3'];
        $supplier->country = $form_credentials['country'];
        $supplier->state = $form_credentials['state'];
        $supplier->city = $form_credentials['city'];
        $supplier->postal_code = $form_credentials['postal_code'];
        $supplier->geo_hierarchy_level = $form_credentials['geo_hierarchy_level'];
        $supplier->geo_hierarchy_value = $form_credentials['geo_hierarchy_value'];
        $supplier->phone_no = $form_credentials['phone_no'];
        $supplier->contact_person = $form_credentials['contact_person'];
        $supplier->s_emailid = $form_credentials['s_emailid'];
        $supplier->tin_no = $form_credentials['tin_no'];
        $supplier->pin_no = $form_credentials['pin_no'];
        $supplier->created_by =  $form_credentials['created_by'];
        $supplier->modified_by =  $form_credentials['modified_by'];
        $supplier->update();

        if($supplier) {
            return 200;
        } else {
            return 424;
        }

    }
    public function deleteSupplier($id){
        $supplier = Supplier::find($id);
        $supplier->delete();

        if($supplier) {
            return 200;
        } else {
            return 424;
        }
    }
}

?>