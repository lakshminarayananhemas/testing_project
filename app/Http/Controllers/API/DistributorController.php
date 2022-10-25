<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Distributor;
use App\Repositories\Distributor\IDistributorRepository; 

 
class DistributorController extends Controller
{
    //
    public function __construct(IDistributorRepository $distributor_repo)
    {
        $this->distributor_repo = $distributor_repo;

    }

    public function fetch(){
        $Distributor = Distributor::all();
        return $Distributor;
    }

    public function save(Request $request){

        $form_credentials = array( 

            'distributor_code'=>$request->input('distributor_code'),
            'distributor_name'=>$request->input('distributor_name'),
            'distributor_type'=>$request->input('distributor_type'),
            'parent_code'=>$request->input('parent_code'),
            'supplier'=>$request->input('supplier'),
            'discount_based_on'=>$request->input('discount_based_on'),
            'distributor_permission'=>$request->input('distributor_permission'),
            'status'=>$request->input('status'),
            'country'=>$request->input('country'),
            'state'=>$request->input('state'),
            'city'=>$request->input('city'),
            'postal_code'=>$request->input('postal_code'),
            'phone_no'=>$request->input('phone_no'),
            'email_id'=>$request->input('email_id'),
            'fssai_no'=>$request->input('fssai_no'),
            'drug_licence_no'=>$request->input('drug_licence_no'),
            'dl_expiry_date'=>$request->input('dl_expiry_date'),
            'weekly_off'=>$request->input('weekly_off'),
            'channel_code'=>$request->input('channel_code'),
            'category_type'=>$request->input('category_type'),
            'numofsalesmans'=>$request->input('numofsalesmans'),
            'salary_budget'=>$request->input('salary_budget'),
            'latitude'=>$request->input('latitude'),
            'longitude'=>$request->input('longitude'),
            'geo_hierarchy_level'=>$request->input('geo_hierarchy_level'),
            'geo_hierarchy_value'=>$request->input('geo_hierarchy_value'),
            'sales_hierarchy_level'=>$request->input('sales_hierarchy_level'),
            'lob'=>$request->input('lob'),
            'sales_hierarchy_value'=>$request->input('sales_hierarchy_value'),
            'gst_state_name'=>$request->input('gst_state_name'),
            'pan_no'=>$request->input('pan_no'),
            'gstin_number'=>$request->input('gstin_number'),
            'aadhar_no'=>$request->input('aadhar_no'),
            'tcs_applicable'=>$request->input('tcs_applicable'),
            'gst_distributor'=>$request->input('gst_distributor'),
            'tds_applicable'=>$request->input('tds_applicable'),
            'created_by' => "123",
            'modified_by' => "", 

            
             
        ); 

        $result = $this->distributor_repo->save( $form_credentials );
        
        if($result ==200){
            $message = 'Distributor Added Successfully';
        }else{
            $message = 'Request Failed';

        }
        return response()->json([
            'status'=>$result,
            'message'=>$message ,
        ]);
    }

    public function edit($id){
        $suppliers_result = $this->distributor_repo->find( $id );
        return response()->json([
            'status'=>200,
            'distributor'=>$suppliers_result,
        ]);
    }

    public function update(Request $request,$id){
        
        $form_credentials = array(
            'id' => $id,
            'distributor_code'=>$request->input('distributor_code'),
            'distributor_name'=>$request->input('distributor_name'),
            'distributor_type'=>$request->input('distributor_type'),
            'parent_code'=>$request->input('parent_code'),
            'supplier'=>$request->input('supplier'),
            'discount_based_on'=>$request->input('discount_based_on'),
            'distributor_permission'=>$request->input('distributor_permission'),
            'status'=>$request->input('status'),
            'country'=>$request->input('country'),
            'state'=>$request->input('state'),
            'city'=>$request->input('city'),
            'postal_code'=>$request->input('postal_code'),
            'phone_no'=>$request->input('phone_no'),
            'email_id'=>$request->input('email_id'),
            'fssai_no'=>$request->input('fssai_no'),
            'drug_licence_no'=>$request->input('drug_licence_no'),
            'dl_expiry_date'=>$request->input('dl_expiry_date'),
            'weekly_off'=>$request->input('weekly_off'),
            'channel_code'=>$request->input('channel_code'),
            'category_type'=>$request->input('category_type'),
            'numofsalesmans'=>$request->input('numofsalesmans'),
            'salary_budget'=>$request->input('salary_budget'),
            'latitude'=>$request->input('latitude'),
            'longitude'=>$request->input('longitude'),
            'geo_hierarchy_level'=>$request->input('geo_hierarchy_level'),
            'geo_hierarchy_value'=>$request->input('geo_hierarchy_value'),
            'sales_hierarchy_level'=>$request->input('sales_hierarchy_level'),
            'lob'=>$request->input('lob'),
            'sales_hierarchy_value'=>$request->input('sales_hierarchy_value'),
            'gst_state_name'=>$request->input('gst_state_name'),
            'pan_no'=>$request->input('pan_no'),
            'gstin_number'=>$request->input('gstin_number'),
            'aadhar_no'=>$request->input('aadhar_no'),
            'tcs_applicable'=>$request->input('tcs_applicable'),
            'gst_distributor'=>$request->input('gst_distributor'),
            'tds_applicable'=>$request->input('tds_applicable'),
            'created_by' => "123",
            'modified_by' => "",
        ); 

        $suppliers_result = $this->distributor_repo->update( $form_credentials );
        
        if($suppliers_result ==200){
            $message = 'Distributor Updated Successfully';
        }else{
            $message = 'Request Failed';
        }
        
        return response()->json([
            'status'=>$suppliers_result,
            'message'=>$message ,
        ]);
    }

    public function destroy($id){
        $suppliers_result = $this->distributor_repo->delete( $id );
        if($suppliers_result ==200){
            $message = 'Distributor Deleted Successfully';
        }else{
            $message = 'Request Failed';
        }
        return response()->json([
            'status'=>$suppliers_result,
            'message'=>$message ,
        ]);
    }

    // app
    //fetch distributor
    public function get_distributor(Request $request){
        $salesmanCode = $request->input( 'salesmanCode'); 
        $result = $this->distributor_repo->getDistributor( $salesmanCode );
        return $result;   
    }
    // end app


    //login check
    public function distributor_login(Request $request){
        $login_credentials = array(
            'username' => $request->input( 'username' ),
            'password' => $request->input( 'password' )
        );
        $result = $this->salerepo->loginSalesman( $login_credentials );
        return $result;   
    } 

}
