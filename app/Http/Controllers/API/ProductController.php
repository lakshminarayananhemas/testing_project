<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Repositories\Product\IProductRepository; 

class ProductController extends Controller
{
    // 
    public function __construct(IProductRepository $product_repo)
    {
        $this->product_repo = $product_repo;

    }

    public function fetch(){
        $Product = Product::all();
        return $Product;
    }

    public function save(Request $request){

        $form_credentials = array( 

            'phll'=>$request->input('phll'),
            'product_code'=>$request->input('product_code'),
            'product_name'=>$request->input('product_name'),
            'short_name'=>$request->input('short_name'),
            'uom'=>$request->input('uom'),
            'conversion_factor'=>$request->input('conversion_factor'),
            'ean_code'=>$request->input('ean_code'),
            'net_wgt'=>$request->input('net_wgt'),
            'weight_type'=>$request->input('weight_type'),
            'shelf_life'=>$request->input('shelf_life'),
            'product_type'=>$request->input('product_type'),
            'drug_product'=>$request->input('drug_product'),
            'status'=>$request->input('status'),
            'serial_no_exist'=>$request->input('serial_no_exist'),
            'second_serial_no_applicable'=>$request->input('second_serial_no_applicable'),
            'second_serial_no_mandatory'=>$request->input('second_serial_no_mandatory'),
            'ghl'=>$request->input('ghl'),
            'hsn_code'=>$request->input('hsn_code'),
            'hsn_name'=>$request->input('hsn_name'),
            'gst_p_type'=>$request->input('gst_p_type'),
            'brandcategory'=>$request->input('brandcategory'),
            'brandpack'=>$request->input('brandpack'),
            'division'=>$request->input('division'),
            'created_by' => '900102',
            'modified_by' => "",
            
        ); 

        $result = $this->product_repo->save( $form_credentials );
        
        if($result ==200){
            $message = 'Product Added Successfully';
        }else{
            $message = 'Request Failed';

        }
        return response()->json([
            'status'=>$result,
            'message'=>$message ,
        ]);
    }

    public function edit($id){
        $product_result = $this->product_repo->find( $id );
        return response()->json([
            'status'=>200,
            'product'=>$product_result,
        ]);
    }

    public function update(Request $request,$id){
        
        $form_credentials = array(
            'id' => $id,
            'phll'=>$request->input('phll'),
            'product_code'=>$request->input('product_code'),
            'product_name'=>$request->input('product_name'),
            'short_name'=>$request->input('short_name'),
            'uom'=>$request->input('uom'),
            'conversion_factor'=>$request->input('conversion_factor'),
            'ean_code'=>$request->input('ean_code'),
            'net_wgt'=>$request->input('net_wgt'),
            'weight_type'=>$request->input('weight_type'),
            'shelf_life'=>$request->input('shelf_life'),
            'product_type'=>$request->input('product_type'),
            'drug_product'=>$request->input('drug_product'),
            'status'=>$request->input('status'),
            'serial_no_exist'=>$request->input('serial_no_exist'),
            'second_serial_no_applicable'=>$request->input('second_serial_no_applicable'),
            'second_serial_no_mandatory'=>$request->input('second_serial_no_mandatory'),
            'ghl'=>$request->input('ghl'),
            'hsn_code'=>$request->input('hsn_code'),
            'hsn_name'=>$request->input('hsn_name'),
            'gst_p_type'=>$request->input('gst_p_type'),
            'brandcategory'=>$request->input('brandcategory'),
            'brandpack'=>$request->input('brandpack'),
            'division'=>$request->input('division'),
            'created_by' => "123",
            'modified_by' => "",
        ); 

        $product_result = $this->product_repo->update( $form_credentials );
        
        if($product_result ==200){
            $message = 'Product Updated Successfully';
        }else{
            $message = 'Request Failed';
        }
        
        return response()->json([
            'status'=>$product_result,
            'message'=>$message ,
        ]);
    }

    public function destroy($id){
        $product_result = $this->product_repo->delete( $id );
        if($product_result ==200){
            $message = 'Product Deleted Successfully';
        }else{
            $message = 'Request Failed';
        }
        return response()->json([
            'status'=>$product_result,
            'message'=>$message ,
        ]);
    }

    // aug 22
    //fetch products
    public function get_products(Request $request){
        $form_credentials = array(
            'productType' => $request->input( 'productType'),
            'skuType' => $request->input( 'skuType'),  
        ); 
       // $salesmanCode = $request->input( 'salesmanCode');
        $result = $this->product_repo->getProducts( $form_credentials );
        return $result;   
    }
    // aug 22 end


}
