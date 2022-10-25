<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Repositories\Supplier\ISupplierRepository; 

class SupplierController extends Controller
{
    public function __construct(ISupplierRepository $suprepo)
    {
        $this->suprepo = $suprepo;

    }
    // ganaga
    public function index(){

        $suppliers_result = $this->suprepo->getSupplier(  );

        return $suppliers_result;
        
    }

    public function store(Request $request){

        $form_credentials = array(
            'company' => $request->input( 'company' ),
            'gst_state_name' => $request->input( 'gst_state_name' ),
            'supplier_code' => $request->input( 'supplier_code' ),
            'supplier_name' => $request->input( 'supplier_name' ),
            's_address_1' => $request->input( 's_address_1' ),
            's_address_2' => $request->input( 's_address_2' ),
            's_address_3' => $request->input( 's_address_3' ),
            'country' => $request->input( 'country' ),
            'state' => $request->input( 'state' ),
            'city' => $request->input('city'),
            'postal_code' => $request->input('postal_code'),
            'geo_hierarchy_level' => $request->input('geo_hierarchy_level'),
            'geo_hierarchy_value' => $request->input('geo_hierarchy_value'),
            'phone_no' => $request->input('phone_no'),
            'contact_person' => $request->input('contact_person'),
            's_emailid' => $request->input('s_emailid'),
            'tin_no' =>$request->input('tin_no'),
            'pin_no'=>$request->input('pin_no'),
            'created_by' => '900102',
            'modified_by'=> '900102'
            // 'modified_by'=>auth()->user()->empID,
        ); 

        $suppliers_result = $this->suprepo->storeSupplier( $form_credentials );
        
        if($suppliers_result ==200){
            $message = 'Supplier Added Successfully';
        }else{
            $message = 'Request Failed';

        }
        return response()->json([
            'status'=>$suppliers_result,
            'message'=>$message ,
        ]);
    }

    public function edit($id){

        $suppliers_result = $this->suprepo->findSupplier( $id );

        return response()->json([
            'status'=>200,
            'supplier'=>$suppliers_result,
        ]);
    }

    public function update(Request $request,$id){
        
        $form_credentials = array(
            'id' => $id,
            'company' => $request->input( 'company' ),
            'gst_state_name' => $request->input( 'gst_state_name' ),
            'supplier_code' => $request->input( 'supplier_code' ),
            'supplier_name' => $request->input( 'supplier_name' ),
            's_address_1' => $request->input( 's_address_1' ),
            's_address_2' => $request->input( 's_address_2' ),
            's_address_3' => $request->input( 's_address_3' ),
            'country' => $request->input( 'country' ),
            'state' => $request->input( 'state' ),
            'city' => $request->input('city'),
            'postal_code' => $request->input('postal_code'),
            'geo_hierarchy_level' => $request->input('geo_hierarchy_level'),
            'geo_hierarchy_value' => $request->input('geo_hierarchy_value'),
            'phone_no' => $request->input('phone_no'),
            'contact_person' => $request->input('contact_person'),
            's_emailid' => $request->input('s_emailid'),
            'tin_no' =>$request->input('tin_no'),
            'pin_no'=>$request->input('pin_no'),
            'created_by' => '900102',
            'modified_by'=> '900102'
            // 'modified_by'=>auth()->user()->empID,
        ); 

        $suppliers_result = $this->suprepo->updateSupplier( $form_credentials );
        
        if($suppliers_result ==200){
            $message = 'Supplier Updated Successfully';
        }else{
            $message = 'Request Failed';

        }
        return response()->json([
            'status'=>$suppliers_result,
            'message'=>$message ,
        ]);
    }

    public function destroy($id){
        $suppliers_result = $this->suprepo->deleteSupplier( $id );
        if($suppliers_result ==200){
            $message = 'Supplier Deleted Successfully';
        }else{
            $message = 'Request Failed';
        }
        return response()->json([
            'status'=>$suppliers_result,
            'message'=>$message ,
        ]);
    }
    // ganaga
}
