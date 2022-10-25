<?php 

namespace App\Repositories\Product;

use DB;
use App\Models\Product;


class ProductRepository implements IProductRepository
{
    public function fetch(){

        $product = Product::all();

        return $Product;
    }

    public function save($form_credentials){

        $save_data = new Product;
        $save_data->auto_id = 'P'.str_pad( ( $save_data->max( 'id' )+1 ), 9, '0', STR_PAD_LEFT );;
        $save_data->phll = $form_credentials['phll'];
        $save_data->product_code = $form_credentials['product_code'];
        $save_data->product_name = $form_credentials['product_name'];
        $save_data->short_name = $form_credentials['short_name'];
        $save_data->uom = $form_credentials['uom'];
        $save_data->conversion_factor = $form_credentials['conversion_factor'];
        $save_data->ean_code = $form_credentials['ean_code'];
        $save_data->net_wgt = $form_credentials['net_wgt'];

        $save_data->weight_type = $form_credentials['weight_type'];
        $save_data->shelf_life = $form_credentials['shelf_life'];
        $save_data->product_type = $form_credentials['product_type'];
        $save_data->drug_product = $form_credentials['drug_product'];
        $save_data->status = $form_credentials['status'];
        $save_data->serial_no_exist = $form_credentials['serial_no_exist'];
        $save_data->second_serial_no_applicable = $form_credentials['second_serial_no_applicable'];
        $save_data->second_serial_no_mandatory = $form_credentials['second_serial_no_mandatory'];
        $save_data->ghl = $form_credentials['ghl'];
        $save_data->hsn_code = $form_credentials['hsn_code'];
        $save_data->hsn_name = $form_credentials['hsn_name'];
        $save_data->gst_p_type = $form_credentials['gst_p_type'];
        $save_data->brandcategory = $form_credentials['brandcategory'];
        $save_data->brandpack = $form_credentials['brandpack'];
        $save_data->division = $form_credentials['division'];
        $save_data->created_by =  $form_credentials['created_by'];
        $save_data->modified_by =  $form_credentials['modified_by'];
        
        $save_data->save();

        if($save_data) {
            return 200;
        } else {
            return 424;
        }

    }

    public function find($id){
        $supplier = Product::find($id);
        return $supplier;

    }

    

    public function update($form_credentials){


        $distributor = Product::find($form_credentials['id']);
        $distributor->phll = $form_credentials['phll'];
        $distributor->product_code = $form_credentials['product_code'];
        $distributor->product_name = $form_credentials['product_name'];
        $distributor->short_name = $form_credentials['short_name'];
        $distributor->uom = $form_credentials['uom'];
        $distributor->conversion_factor = $form_credentials['conversion_factor'];
        $distributor->ean_code = $form_credentials['ean_code'];
        $distributor->net_wgt = $form_credentials['net_wgt'];

        $distributor->weight_type = $form_credentials['weight_type'];
        $distributor->shelf_life = $form_credentials['shelf_life'];
        $distributor->product_type = $form_credentials['product_type'];
        $distributor->drug_product = $form_credentials['drug_product'];
        $distributor->status = $form_credentials['status'];
        $distributor->serial_no_exist = $form_credentials['serial_no_exist'];
        $distributor->second_serial_no_applicable = $form_credentials['second_serial_no_applicable'];
        $distributor->second_serial_no_mandatory = $form_credentials['second_serial_no_mandatory'];
        $distributor->ghl = $form_credentials['ghl'];
        $distributor->hsn_code = $form_credentials['hsn_code'];
        $distributor->hsn_name = $form_credentials['hsn_name'];
        $distributor->gst_p_type = $form_credentials['gst_p_type'];
        $distributor->brandcategory = $form_credentials['brandcategory'];
        $distributor->brandpack = $form_credentials['brandpack'];
        $distributor->division = $form_credentials['division'];
        $distributor->created_by = $form_credentials['created_by'];
        $distributor->modified_by =  $form_credentials['modified_by'];
        $distributor->update();

        if($distributor) {
            return 200;
        } else {
            return 424;
        }

    }
    public function delete($id){
        $supplier = Product::find($id);
        $supplier->delete();

        if($supplier) {
            return 200;
        } else {
            return 424;
        }
    }

    // app 22 aug
    public function getProducts($form_credentials){
        $productType = $form_credentials['productType'];
        $skuType = $form_credentials['skuType'];
        if($skuType=="")
        {
            $result = Product::get(); 

        }
        else{
            $result = Product::where('sku_type','=',$skuType)->get(); 
        }
                    
        if($result->isEmpty())
        {
            $status='false';
            $message='No Products found';
            $result=[];
        }
        else{
            $status='true';
            $message='success';
            $result=$result;
        }
    
    return response()->json([
        'status'=>$status,
        'message'=>$message,
        'result'=>$result,
    ]);
    }
    // end app
}

?>