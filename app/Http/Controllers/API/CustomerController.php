<?php

namespace App\Http\Controllers\API;

use DB;
use App\Models\orders;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Customer\ICustomerRepository; 
use App\Repositories\Order\IOrderRepository; 
use App\Repositories\Salesman\ISalesmanRepository; 
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function __construct(IOrderRepository $orderrepo,ISalesmanRepository $salerepo,ICustomerRepository $custrepo)
    {
        $this->custrepo = $custrepo;
        $this->salerepo = $salerepo;
        $this->orderrepo = $orderrepo;
    }
    // ganaga
    public function index(Request $request){
        try {

            $where=array();
            $where[] = ['ca_approval_status', '=', $request->input( 'approval_status' )];
            $customer_result = $this->custrepo->getCustomers( $where  );

            if(!empty($customer_result)){
                $status = 'true';
                $message = 'success';
                $result = $customer_result; 
            }else{
                $status = 'false';
                $message = 'No Data Found';
                $result = $customer_result;
            }
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$customer_result,
            ]);
        }
        catch (\Execption $e) {
            $status = 'false';
            $message = $e;
            $result = 'Failed';
          
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);
        }
        
    }

    public function store(Request $request){
        try{
            $customer_code = $request->has( 'cg_customer_code' ) ? $request->input( 'cg_customer_code' ) :  $request->input('cg_salesman_code')."_".$request->input('cg_postal_code')."_".mt_rand(1000,9999);
            if($request->has('cg_photo_filename') && !empty($request->file('cg_photo_filename'))) {
                $outlet_images = array();
                foreach($request->file('cg_photo_filename') as $image) {

                    $outlet_images_name = $customer_code."_".rand().'.'.$image->getClientOriginalExtension();
                    $outlet_images[] = $outlet_images_name;
                    $image->storeAs('uploads/outlets/', $outlet_images_name, 'public');

                }
                
            }else{
                $outlet_images = array();

            }


            if($request->has('attach_parent') && !empty($request->file('attach_parent'))) {
                $original_image_name = $request->file('attach_parent')->getClientOriginalName();
                $image = $request->file('attach_parent');
                $ca_attach_parent = time().rand(). '.'.$image->getClientOriginalExtension();
                $image->storeAs('uploads/outlets/', $ca_attach_parent, 'public');

            }
            else{
                $ca_attach_parent = '';
            }

            $form_credentials = array(
                'cg_distributor_branch' => $request->has('cg_distributor_code') ? $request->input('cg_distributor_code') : '', //sub stockist
                'cg_type' => $request->has( 'cg_type' ) ? $request->input('cg_type') : 'Retailer',
                'cg_customer_code' => $customer_code,
                'cg_dist_cust_code' => $request->has('cg_distributor_code') ? $request->input('cg_distributor_code')."_".$customer_code : '',
                'cg_cmpny_cust_code' => $request->has( 'cg_company_code' ) ? $request->input('cg_company_code')."_".$customer_code : '', //cg_customer_code
                'cg_customer_name' => $request->has( 'cg_customer_name' ) ? $request->input('cg_customer_name') : '', //retailer name
                'cg_salesman_code' => $request->has( 'cg_salesman_code' ) ? $request->input('cg_salesman_code') : '',
                'cg_address_1' => $request->has( 'cg_address_1' ) ? $request->input('cg_address_1') : '', //address1
                'cg_address_2' => $request->has( 'cg_address_2' ) ? $request->input('cg_address_2') : '', //address2
                'cg_address_3' => $request->has( 'cg_address_3' ) ? $request->input('cg_address_3') : '',
                'cg_country' => $request->has('cg_country') ? $request->input('cg_country') : '', //country
                'cg_state' => $request->has('cg_state') ? $request->input('cg_state') : '', //state
                'cg_city' => $request->has('cg_city') ? $request->input('cg_city') : '', //city
                'cg_town' => $request->has('cg_town') ? $request->input('cg_town') : '', //cg_town
                'cg_postal_code' => $request->has('cg_postal_code') ? $request->input('cg_postal_code') : '',//postal code
                'cg_phoneno' => $request->has('cg_phoneno') ? $request->input('cg_phoneno') : '', //phone
                'cg_mobile' => $request->has('cg_mobile') ? $request->input('cg_mobile') : '',//mobile
                'cg_latitude' => $request->has('cg_latitude') ? $request->input('cg_latitude') : '', //latitude
                'cg_longitude' =>$request->has('cg_longitude') ? $request->input('cg_longitude') : '', //longitude
                'cg_distance'=>$request->has('cg_distance') ? $request->input('cg_distance') : '',
                'cg_dob'=>$request->has('cg_dob') ? $request->input('cg_dob') : '',
                'cg_anniversary'=>$request->has('cg_anniversary') ? $request->input('cg_anniversary') : '',
                'cg_enrollment_date'=>$request->has('cg_enrollment_date') ? $request->input('cg_enrollment_date') : '',
                'cg_contact_person'=>$request->has('cg_contact_person') ? $request->input('cg_contact_person') : '',
                'cg_emailid'=>$request->has('cg_emailid') ? $request->input('cg_emailid') : '',
                'cg_gst_state'=>$request->has('cg_gst_state') ? $request->input('cg_gst_state') : '',
                'cg_retailer_type'=>$request->has('cg_retailer_type') ? $request->input('cg_retailer_type') : '', //get user type
                'cg_pan_type'=>$request->has('cg_pan_type') ? $request->input('cg_pan_type') : '', //get pan type
                'cg_panno'=>$request->has('cg_panno') ? $request->input('cg_panno') : '', //pan no
                'cg_aadhaar_no'=>$request->has('cg_aadhaar_no') ? $request->input('cg_aadhaar_no') : '',
                'cg_gstin_number'=>$request->has('cg_gstin_number') ? $request->input('cg_gstin_number') : '', //gst no
                'cg_tcs_applicable'=>$request->has('cg_tcs_applicable') ? $request->input('cg_tcs_applicable') : '',
                'cg_related_party'=>$request->has('cg_related_party') ? $request->input('cg_related_party') : '',
                'cg_composite'=>$request->has('cg_composite') ? $request->input('cg_composite') : '',
                'cg_tds_applicable'=>$request->has('cg_tds_applicable') ? $request->input('cg_tds_applicable') : '',
                

                'ls_tin_no'=>$request->has('ls_tin_no') ? $request->input('ls_tin_no') : '',
                'ls_pin_no'=>$request->has('ls_pin_no') ? $request->input('ls_pin_no') : '',
                'ls_license_no'=>$request->has('ls_license_no') ? $request->input('ls_license_no') : '',
                'ls_cst_no'=>$request->has('ls_cst_no') ? $request->input('ls_cst_no') : '',
                'ls_drug_license_no1'=>$request->has('ls_drug_license_no1') ? $request->input('ls_drug_license_no1') : '',
                'ls_lic_expiry_date'=>$request->has('ls_lic_expiry_date') ? $request->input('ls_lic_expiry_date') : '',
                'ls_drug_license_no2'=>$request->has('ls_drug_license_no2') ? $request->input('ls_drug_license_no2') : '',
                'ls_dl1_expiry_date'=>$request->has('ls_dl1_expiry_date') ? $request->input('ls_dl1_expiry_date') : '',
                'ls_pest_license_no'=>$request->has('ls_pest_license_no') ? $request->input('ls_pest_license_no') : '',
                'ls_dl2_expiry_date'=>$request->has('ls_dl2_expiry_date') ? $request->input('ls_dl2_expiry_date') : '',
                'ls_fssai_no'=>$request->has('ls_fssai_no') ? $request->input('ls_fssai_no') : '',
                'ls_credit_bill'=>$request->has('ls_credit_bill') ? $request->input('ls_credit_bill') : '',
                'ls_credit_bill_status'=>$request->has('ls_credit_bill_status') ? $request->input('ls_credit_bill_status') : '',
                'ls_credit_limit'=>$request->has('ls_credit_limit') ? $request->input('ls_credit_limit') : '',
                'ls_credit_limit_status'=>$request->has('ls_credit_limit_status') ? $request->input('ls_credit_limit_status') : '',
                'ls_credit_days'=>$request->has('ls_credit_days') ? $request->input('ls_credit_days') : '',
                'ls_credit_days_status'=>$request->has('ls_credit_days_status') ? $request->input('ls_credit_days_status') : '',
                'ls_cash_discount'=>$request->has('ls_cash_discount') ? $request->input('ls_cash_discount') : '',
                'ls_limit_amount'=>$request->has('ls_limit_amount') ? $request->input('ls_limit_amount') : '',
                'ls_cd_trigger_action'=>$request->has('ls_cd_trigger_action') ? $request->input('ls_cd_trigger_action') : '',
                'ls_trigger_amount'=>$request->has('ls_trigger_amount') ? $request->input('ls_trigger_amount') : '',

                'ca_coverage_mode'=>$request->has('ca_coverage_mode') ? $request->input('ca_coverage_mode') : '',
                'ca_coverage_frequency'=>$request->has('ca_coverage_frequency') ? $request->input('ca_coverage_frequency') : '',
                'ca_sales_route'=>$request->has('ca_sales_route') ? $request->input('ca_sales_route') : '', //route
                'ca_delivery_route'=>$request->has('ca_delivery_route') ? $request->input('ca_delivery_route') : '',
                'ca_channel'=>$request->has('ca_channel') ? $request->input('ca_channel') : '', //channel
                'ca_subchannel'=>$request->has('ca_subchannel') ? $request->input('ca_subchannel') : '', //subchannel
                'ca_group'=>$request->has('ca_group') ? $request->input('ca_group') : '',//group
                'ca_class'=>$request->has('ca_class') ? $request->input('ca_class') : '',//class
                'ca_parent_child'=>$request->has('ca_parent_child') ? $request->input('ca_parent_child') : '',
                'ca_attach_parent'=>$ca_attach_parent,
                'ca_approval_status'=>$request->has('ca_approval_status') ? $request->input('ca_approval_status') : 'Pending', //ca_approval_status
                'ca_customer_status'=>$request->has('ca_customer_status') ? $request->input('ca_customer_status') : 'Inactive', //ca_customer_status
                'ca_key_account'=>$request->has('ca_key_account') ? $request->input('ca_key_account') : '',
                'ca_ra_mapping'=>$request->has('ca_ra_mapping') ? $request->input('ca_ra_mapping') : '',
                'created_by' => '900102',
                'modified_by'=> '900102',
                'outlet_images'=> $outlet_images,
                'cg_billType' => 'Unbilled', //billtype
                'otpStatus' => 1, //otpStatus

                // 'modified_by'=>auth()->user()->empID,
            ); 

            $customer_result = $this->custrepo->storeCustomer( $form_credentials );
       
       
            if($customer_result ==200){
                $message = 'Customer Added Successfully';
            }else{
                $message = 'Request Failed';

            }
            return response()->json([
                'status'=>$customer_result,
                'message'=>$message ,
            ]);

        }catch (\Exception $e) {
            $status = 'false';
            $message = $e;
            $result = 'Failed';
            return response()->json([
                'status'=>$status,
                'message'=>$message,
            ]);
        }
    }
    
    public function edit($id){

        try{
            $cg_result = $this->custrepo->findCustomergeneral( $id );
            $c_ls_result = $this->custrepo->findCustomerlicenceSetting( $id );
            $c_ca_result = $this->custrepo->findCustomercoverageAttribute( $id );
            $outletimages_result = $this->custrepo->findOutletimages( $id );

            if(!empty($cg_result)){
                return response()->json([
                    'status'=>200,
                    'cg_result'=>$cg_result,
                    'ls_result'=>$c_ls_result,
                    'ca_result'=>$c_ca_result,
                    'outletimages_result'=>$outletimages_result,
                    'message'=>'success',
                ]);
            }else{
                return response()->json([
                    'status'=>500,
                    'cg_result'=>$cg_result,
                    'ls_result'=>$c_ls_result,
                    'ca_result'=>$c_ca_result,
                    'outletimages_result'=>$outletimages_result,
                    'message'=>'success',
                ]);
            }
            
        }catch (\Exception $e) {
            $status = 500;
            $message = $e;

            return response()->json([
                'status'=>$status,
                'cg_result'=>'false',
                'ls_result'=>'false',
                'ca_result'=>'false',
                'outletimages_result'=>'false',
                'message'=>$message,
            ]);
        }
    }

    public function update(Request $request){

        try{
            $customer_code = $request->has( 'cg_customer_code' ) ? $request->input( 'cg_customer_code' ) :  $request->input('cg_salesman_code')."_".$request->input('cg_postal_code')."_".mt_rand(1000,9999);
            if($request->has('cg_photo_filename') && !empty($request->file('cg_photo_filename'))) {
                $outlet_images = array();
                foreach($request->file('cg_photo_filename') as $image) {

                    $outlet_images_name = $customer_code."_".rand().'.'.$image->getClientOriginalExtension();
                    $outlet_images[] = $outlet_images_name;
                    $image->storeAs('uploads/outlets/', $outlet_images_name, 'public');

                }
                
            }else{
                $outlet_images = array();

            }


            if($request->has('attach_parent') && !empty($request->file('attach_parent'))) {
                $original_image_name = $request->file('attach_parent')->getClientOriginalName();
                $image = $request->file('attach_parent');
                $ca_attach_parent = time().rand(). '.'.$image->getClientOriginalExtension();
                $image->storeAs('uploads/outlets/', $ca_attach_parent, 'public');

            }
            else{
                $ca_attach_parent = '';
            }

            $form_credentials = array(
                'auto_id' => $request->input('auto_id'),
                'cg_distributor_branch' => $request->has('cg_distributor_code') ? $request->input('cg_distributor_code') : '', //sub stockist
                'cg_type' => $request->has( 'cg_type' ) ? $request->input('cg_type') : 'Retailer',
                'cg_customer_code' => $customer_code,
                'cg_dist_cust_code' => $request->has('cg_distributor_code') ? $request->input('cg_distributor_code')."_".$customer_code : '',
                'cg_cmpny_cust_code' => $request->has( 'cg_company_code' ) ? $request->input('cg_company_code')."_".$customer_code : '', //cg_customer_code
                'cg_customer_name' => $request->has( 'cg_customer_name' ) ? $request->input('cg_customer_name') : '', //retailer name
                'cg_salesman_code' => $request->has( 'cg_salesman_code' ) ? $request->input('cg_salesman_code') : '',
                'cg_address_1' => $request->has( 'cg_address_1' ) ? $request->input('cg_address_1') : '', //address1
                'cg_address_2' => $request->has( 'cg_address_2' ) ? $request->input('cg_address_2') : '', //address2
                'cg_address_3' => $request->has( 'cg_address_3' ) ? $request->input('cg_address_3') : '',
                'cg_country' => $request->has('cg_country') ? $request->input('cg_country') : '', //country
                'cg_state' => $request->has('cg_state') ? $request->input('cg_state') : '', //state
                'cg_city' => $request->has('cg_city') ? $request->input('cg_city') : '', //city
                'cg_town' => $request->has('cg_town') ? $request->input('cg_town') : '', //cg_town
                'cg_postal_code' => $request->has('cg_postal_code') ? $request->input('cg_postal_code') : '',//postal code
                'cg_phoneno' => $request->has('cg_phoneno') ? $request->input('cg_phoneno') : '', //phone
                'cg_mobile' => $request->has('cg_mobile') ? $request->input('cg_mobile') : '',//mobile
                'cg_latitude' => $request->has('cg_latitude') ? $request->input('cg_latitude') : '', //latitude
                'cg_longitude' =>$request->has('cg_longitude') ? $request->input('cg_longitude') : '', //longitude
                'cg_distance'=>$request->has('cg_distance') ? $request->input('cg_distance') : '',
                'cg_dob'=>$request->has('cg_dob') ? $request->input('cg_dob') : '',
                'cg_anniversary'=>$request->has('cg_anniversary') ? $request->input('cg_anniversary') : '',
                'cg_enrollment_date'=>$request->has('cg_enrollment_date') ? $request->input('cg_enrollment_date') : '',
                'cg_contact_person'=>$request->has('cg_contact_person') ? $request->input('cg_contact_person') : '',
                'cg_emailid'=>$request->has('cg_emailid') ? $request->input('cg_emailid') : '',
                'cg_gst_state'=>$request->has('cg_gst_state') ? $request->input('cg_gst_state') : '',
                'cg_retailer_type'=>$request->has('cg_retailer_type') ? $request->input('cg_retailer_type') : '', //get user type
                'cg_pan_type'=>$request->has('cg_pan_type') ? $request->input('cg_pan_type') : '', //get pan type
                'cg_panno'=>$request->has('cg_panno') ? $request->input('cg_panno') : '', //pan no
                'cg_aadhaar_no'=>$request->has('cg_aadhaar_no') ? $request->input('cg_aadhaar_no') : '',
                'cg_gstin_number'=>$request->has('cg_gstin_number') ? $request->input('cg_gstin_number') : '', //gst no
                'cg_tcs_applicable'=>$request->has('cg_tcs_applicable') ? $request->input('cg_tcs_applicable') : '',
                'cg_related_party'=>$request->has('cg_related_party') ? $request->input('cg_related_party') : '',
                'cg_composite'=>$request->has('cg_composite') ? $request->input('cg_composite') : '',
                'cg_tds_applicable'=>$request->has('cg_tds_applicable') ? $request->input('cg_tds_applicable') : '',
                

                'ls_tin_no'=>$request->has('ls_tin_no') ? $request->input('ls_tin_no') : '',
                'ls_pin_no'=>$request->has('ls_pin_no') ? $request->input('ls_pin_no') : '',
                'ls_license_no'=>$request->has('ls_license_no') ? $request->input('ls_license_no') : '',
                'ls_cst_no'=>$request->has('ls_cst_no') ? $request->input('ls_cst_no') : '',
                'ls_drug_license_no1'=>$request->has('ls_drug_license_no1') ? $request->input('ls_drug_license_no1') : '',
                'ls_lic_expiry_date'=>$request->has('ls_lic_expiry_date') ? $request->input('ls_lic_expiry_date') : '',
                'ls_drug_license_no2'=>$request->has('ls_drug_license_no2') ? $request->input('ls_drug_license_no2') : '',
                'ls_dl1_expiry_date'=>$request->has('ls_dl1_expiry_date') ? $request->input('ls_dl1_expiry_date') : '',
                'ls_pest_license_no'=>$request->has('ls_pest_license_no') ? $request->input('ls_pest_license_no') : '',
                'ls_dl2_expiry_date'=>$request->has('ls_dl2_expiry_date') ? $request->input('ls_dl2_expiry_date') : '',
                'ls_fssai_no'=>$request->has('ls_fssai_no') ? $request->input('ls_fssai_no') : '',
                'ls_credit_bill'=>$request->has('ls_credit_bill') ? $request->input('ls_credit_bill') : '',
                'ls_credit_bill_status'=>$request->has('ls_credit_bill_status') ? $request->input('ls_credit_bill_status') : '',
                'ls_credit_limit'=>$request->has('ls_credit_limit') ? $request->input('ls_credit_limit') : '',
                'ls_credit_limit_status'=>$request->has('ls_credit_limit_status') ? $request->input('ls_credit_limit_status') : '',
                'ls_credit_days'=>$request->has('ls_credit_days') ? $request->input('ls_credit_days') : '',
                'ls_credit_days_status'=>$request->has('ls_credit_days_status') ? $request->input('ls_credit_days_status') : '',
                'ls_cash_discount'=>$request->has('ls_cash_discount') ? $request->input('ls_cash_discount') : '',
                'ls_limit_amount'=>$request->has('ls_limit_amount') ? $request->input('ls_limit_amount') : '',
                'ls_cd_trigger_action'=>$request->has('ls_cd_trigger_action') ? $request->input('ls_cd_trigger_action') : '',
                'ls_trigger_amount'=>$request->has('ls_trigger_amount') ? $request->input('ls_trigger_amount') : '',

                'ca_coverage_mode'=>$request->has('ca_coverage_mode') ? $request->input('ca_coverage_mode') : '',
                'ca_coverage_frequency'=>$request->has('ca_coverage_frequency') ? $request->input('ca_coverage_frequency') : '',
                'ca_sales_route'=>$request->has('ca_sales_route') ? $request->input('ca_sales_route') : '', //route
                'ca_delivery_route'=>$request->has('ca_delivery_route') ? $request->input('ca_delivery_route') : '',
                'ca_channel'=>$request->has('ca_channel') ? $request->input('ca_channel') : '', //channel
                'ca_subchannel'=>$request->has('ca_subchannel') ? $request->input('ca_subchannel') : '', //subchannel
                'ca_group'=>$request->has('ca_group') ? $request->input('ca_group') : '',//group
                'ca_class'=>$request->has('ca_class') ? $request->input('ca_class') : '',//class
                'ca_parent_child'=>$request->has('ca_parent_child') ? $request->input('ca_parent_child') : '',
                'ca_attach_parent'=>$ca_attach_parent,
                'ca_approval_status'=>$request->has('ca_approval_status') ? $request->input('ca_approval_status') : 'Pending', //ca_approval_status
                'ca_customer_status'=>$request->has('ca_customer_status') ? $request->input('ca_customer_status') : 'Inactive', //ca_customer_status
                'ca_key_account'=>$request->has('ca_key_account') ? $request->input('ca_key_account') : '',
                'ca_ra_mapping'=>$request->has('ca_ra_mapping') ? $request->input('ca_ra_mapping') : '',
                'created_by' => '900102',
                'modified_by'=> '900102',
                'outlet_images'=> $outlet_images,
                // 'cg_billType' => 'Unbilled', //billtype

                // 'modified_by'=>auth()->user()->empID,
            ); 

            $customer_result = $this->custrepo->updateCustomer( $form_credentials );
            
            if($customer_result ==200){
                $message = 'Customer Updated Successfully';
            }else{
                $message = 'Request Failed';

            }
            return response()->json([
                'status'=>$customer_result,
                'message'=>$message ,
            ]);

        }catch (\Exception $e) {
            $status = 500;
            $message = $e;

            return response()->json([
                'status'=>$status,
                'message'=>$message,
            ]);
        }
    }

    public function destroy($id){

        try {
            $customer_result = $this->custrepo->deleteCustomer( $id );
            if($customer_result ==200){
                $message = 'Customer Deleted Successfully';
            }else{
                $message = 'Request Failed';
            }
            return response()->json([
                'status'=>$customer_result,
                'message'=>$message ,
            ]);

        } catch (\Exception $e) {
            $status = 500;
            $message = $e;

            return response()->json([
                'status'=>$status,
                'message'=>$message,
            ]);
        }
        
    }

    public function upload(Request $request){
        return $request->file('image');
    }

    public function customers_pending_approval(Request $request){
        $form_credentials = array(
            // 'distributor_id' => $request->input( 'distributor_id' ),
            'ca_approval_status' => $request->input( 'approval_status' ),
        );
        $customer_result = $this->custrepo->getCustomerscondition($form_credentials  );
        return $customer_result;
    }
    
    public function customers_distributor(Request $request){

        try{

            $form_credentials = array(
                'distributor_id' => $request->input( 'distributor_id' ),
                'ca_approval_status' => 'Approved',
            );
            $customer_result = $this->custrepo->getCustomerscondition_dist($form_credentials  );

            if(!empty($customer_result)){
                $status = 'true';
                $message = 'success';
                $result = $customer_result; 
            }else{
                $status = 'false';
                $message = 'No Data Found';
                $result = $customer_result;
            }
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$customer_result,
            ]);

        }catch (\Exception $e) {

            $status = 500;
            $message = $e;
    
            return response()->json([
                'status'=>$status,
                'message'=>$message,
            ]);
        }

    }

    public function customer_status_update(Request $request){
        
        try{
            $form_credentials = array(
                'ca_approval_status' => $request->input( 'approval_status' ),
                'ca_customer_status' => $request->input( 'ca_customer_status' ),
                'auto_id' => explode(',', $request->input( 'approval_id' )),
            );
            $result = $this->custrepo->customer_status_update($form_credentials  );
            if($result ==200){
                $message = 'Updated Successfully';
            }else{
                $message = 'Request Failed';
            }
            return response()->json([
                'status'=>$result,
                'message'=>$message ,
            ]);
        }catch (\Exception $e) {
            $status = 500;
            $message = $e;
    
            return response()->json([
                'status'=>$status,
                'message'=>$message,
            ]);
        }
    }

    public function get_pending_outlets(Request $request){
        try {
            
            $distributor_code = $request->input( 'distributor_code' );
        $salesman_code = $request->input( 'salesman_code' );

        $current_date = date('Y-m-d');
            // $current_date = '2022-09-21';
            $where=array();
            $where[] = ['from_date', '<=', $current_date];
            $where[] = ['to_date', '>=', $current_date];

            $result = $this->salerepo->get_pjp_jcmonth( $where );

        $where1=array();
        $where1[] = ['cg.cg_distributor_branch', '=', $distributor_code];
        $where1[] = ['cg.cg_salesman_code', '=', $salesman_code];
        $where1[] = ['cg.ca_approval_status', '=', 'Pending'];
                
        $gcjcb_result = $this->custrepo->get_pending_outlets($where1 );
        
            if(count($gcjcb_result) !=0){
                $test_result_array = array();
                $comp_custinfo_array = array();

                foreach ($gcjcb_result as $key_2 => $bor_value) {
                    $comp_custinfo_array[$key_2]['customer_code'] = $bor_value->cg_customer_code;
                    $comp_custinfo_array[$key_2]['salesman_code'] = $bor_value->cg_salesman_code;
                    $comp_custinfo_array[$key_2]['distributor_code'] = $bor_value->cg_distributor_branch;
                    $comp_custinfo_array[$key_2]['cg_distance'] = $bor_value->cg_distance;
                    $comp_custinfo_array[$key_2]['ca_channel'] = $bor_value->ca_channel;
                    $comp_custinfo_array[$key_2]['ca_subchannel'] = $bor_value->ca_subchannel;
                    $comp_custinfo_array[$key_2]['ca_group'] = $bor_value->ca_group;
                    $comp_custinfo_array[$key_2]['ca_class'] = $bor_value->ca_class;
                    $comp_custinfo_array[$key_2]['auto_id'] = $bor_value->auto_id;
                    $comp_custinfo_array[$key_2]['cg_auto_id'] = $bor_value->cg_auto_id;
                    $comp_custinfo_array[$key_2]['cg_customer_name'] = $bor_value->cg_customer_name;
                    $comp_custinfo_array[$key_2]['cg_latitude'] = $bor_value->cg_latitude;
                    $comp_custinfo_array[$key_2]['cg_longitude'] = $bor_value->cg_longitude;
                    $comp_custinfo_array[$key_2]['otpStatus'] = $bor_value->otpStatus;

                    $custid_array = array();
                    array_push($custid_array,$bor_value->cg_customer_code);

                    $form_credentials = array(
                        'distributor_code' => $request->input( 'distributor_code' ),
                        'salesman_code' => $request->input( 'salesman_code' ),
                        'from_created_at' => $result[0]->from_date,
                        'to_created_at' =>  $result[0]->to_date,
                        'customer_code' =>$custid_array,
                        'status' =>'Approved',
                    );
                    $gcjcd_result_app1 = $this->orderrepo->get_jc_customer_order_details_status($form_credentials );
                    $gcjcd_result_app1 = json_decode(json_encode($gcjcd_result_app1), true);

                    $cust_achieved_amount = array_sum(array_column($gcjcd_result_app1, 'total_amount'));

                    // return ($gcjcd_result_app1);
                    $form_credentials = array(
                        'distributor_code' => $request->input( 'distributor_code' ),
                        'salesman_code' => $request->input( 'salesman_code' ),
                        'from_created_at' => $result[0]->from_date,
                        'to_created_at' =>  $result[0]->to_date,
                        'customer_code' =>$custid_array,
                        'status' =>'Pending',
                    );

                    $gcjcd_result_pen1 = $this->orderrepo->get_jc_customer_order_details_status($form_credentials );

                    $total_order_taken = count($gcjcd_result_app1) + count($gcjcd_result_pen1);
                    $comp_custinfo_array[$key_2]['total_orders_taken'] = $total_order_taken;
                    $comp_custinfo_array[$key_2]['orders_confirmed'] = count($gcjcd_result_app1);

                    // get target balance
                    if($bor_value->target_amount >=$cust_achieved_amount){
                        $target_balance = $bor_value->target_amount - $cust_achieved_amount;
                    }elseif ($bor_value->target_amount < $cust_achieved_amount) {
                        $target_balance = 0;
                    }else{
                        $target_balance=0;
                    }

                    $comp_custinfo_array[$key_2]['target_amount'] = $bor_value->target_amount;
                    $comp_custinfo_array[$key_2]['achieved_amount'] = $cust_achieved_amount;
                    $comp_custinfo_array[$key_2]['target_balance'] = $target_balance;


                    // get average of l3m
                    $last_three_month_date = Carbon::now()->subMonth(3);
                     $form_credentials_ltm = array(
                        'distributor_code' => $request->input( 'distributor_code' ),
                        'salesman_code' => $request->input( 'salesman_code' ),
                        'from_created_at' => $last_three_month_date,
                        'customer_code' =>$custid_array,
                        // 'status' =>'Approved',
                    );

                     $last_three_month_result = $this->orderrepo->last_three_month_average($form_credentials_ltm );
                    if(count($last_three_month_result) !=0){
                        $last_three_month_avg = ($last_three_month_result[0]->total_amount ) / 3;
                    }else{
                        $last_three_month_avg=0;
                    }

                    $comp_custinfo_array[$key_2]['last_three_month_avg'] = round($last_three_month_avg);

                    // get customer freequency
                    $where2=array();
                    $where2[] = ['s.distributor_code', '=', $request->input( 'distributor_code' )];
                    $where2[] = ['s.salesman_code', '=', $request->input( 'salesman_code' )];
                    $where2[] = ['s.customer_code', '=', $custid_array];
                    $where2[] = ['s.jc_month', '=', $result[0]->jc];

                    $cus_freq_result = $this->orderrepo->get_customer_frequency($where2 );

                    if(count($cus_freq_result) != 0){
                        // get_coverage details
                        if($cus_freq_result[0]->frequency == 'Daily'){

                            $total_coverage = 28;
                            // get covered coverage details
                            $covered_coverage_result = $this->orderrepo->salesman_marketvisit_coverage($form_credentials );

                            $coverage_output = $covered_coverage_result." / ".$total_coverage;

                        }elseif ($cus_freq_result[0]->frequency == 'Weekly') {
                            
                            $total_coverage = 4;
                            $covered_coverage_result = $this->orderrepo->salesman_marketvisit_coverage($form_credentials );
                            $coverage_output = $covered_coverage_result." / ".$total_coverage;
                            
                        }else{

                            $total_coverage = 1;
                            $covered_coverage_result = $this->orderrepo->salesman_marketvisit_coverage($form_credentials );
                            $coverage_output = $covered_coverage_result." / ".$total_coverage;

                        }

                        $comp_custinfo_array[$key_2]['coverage_output'] = $coverage_output;
                    }else{
                        $comp_custinfo_array[$key_2]['coverage_output'] = "0 / 0";

                    }

                    // get productivity details

                        $order_productivity_count = $total_order_taken;
                        // get sales return count
                        $sales_retun_result = $this->orderrepo->salesman_sales_return_count($form_credentials);
                        $sales_return_productivity_count = $sales_retun_result;


                    $comp_custinfo_array[$key_2]['order_productivity_count'] = $order_productivity_count;
                    $comp_custinfo_array[$key_2]['sales_return_productivity_count'] = $sales_return_productivity_count;



                }
                $test_result_array['pending_outlets'] = $comp_custinfo_array;

                $status = 'true';
                $message = 'Data Found';
            }
            else{
                $status = 'false';
                $message = 'No Data Found';
                $test_result_array=[];
                $test_result_array['pending_outlets'] = [];

            }


            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$test_result_array,
                

            ]);
        } catch (\Throwable $e) {
            $status = 'false';
            $message = $e;
            $test_result_array = [];
            
            $test_result_array['pending_outlets'] = [];
            
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                // 'result'=>$result,
                'result'=>$test_result_array,

            ]);
        }
        
    }
    //ganaga 
    
    // app 22 aug

    //fetch outlet/customer
    public function get_outlet(Request $request){
        $form_credentials = array(
            'salesmanCode' => $request->input( 'salesmanCode'),
            'distributorCode' => $request->input( 'distributorCode'),  
        ); 
        $salesmanCode = $request->input( 'salesmanCode');
        $result = $this->custrepo->getOutlet( $form_credentials );
        return $result;   
    }

    public function create_outlet(Request $request){
        
        if ($request->file('cg_photo_filename1')) {
            $imagePath1 = $request->file('cg_photo_filename1');
            $cg_photo_filename1 = $imagePath1->getClientOriginalName();
            $path1 = $request->file('cg_photo_filename1')->storeAs('uploads/outlets', $cg_photo_filename1, 'public');
        }
        else{
            $cg_photo_filename1 = '';
        }
        if ($request->file('cg_photo_filename2')) {
            $imagePath2 = $request->file('cg_photo_filename2');
            $cg_photo_filename2 = $imagePath2->getClientOriginalName();
            $path2 = $request->file('cg_photo_filename2')->storeAs('uploads/outlets', $cg_photo_filename2, 'public');
        }
        else{
            $cg_photo_filename2 = '';
        }
        if ($request->file('cg_photo_filename3')) {
            $imagePath3 = $request->file('cg_photo_filename3');
            $cg_photo_filename3 = $imagePath3->getClientOriginalName();
            $path3 = $request->file('cg_photo_filename3')->storeAs('uploads/outlets', $cg_photo_filename3, 'public');
        }
        else{
            $cg_photo_filename3 = '';
        }

        $form_credentials = array(
            'cg_cmp_customer_code' => $request->input( 'cg_customer_code' ),
            'cg_customer_code' => substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6),
            'cg_dist_cust_code' => $request->input( 'cg_dist_cust_code' ),
            'cg_customer_name' => $request->input( 'cg_customer_name' ),
            'cg_phoneno' => $request->input( 'cg_phoneno' ),
            'cg_mobile' => $request->input( 'cg_mobile' ),
            'cg_address1' => $request->input( 'cg_address1' ),
            'cg_address2' => $request->input( 'cg_address2' ),
            'cg_state' => $request->input( 'cg_state' ),
            'cg_gstin_number' => $request->input( 'cg_gstin_number' ),
            'cg_panno' => $request->input('cg_panno'),
            'cg_city' => $request->input('cg_city'),
            'cg_latitude' => $request->input('cg_latitude'),
            'cg_longitude' => $request->input('cg_longitude'),
            'cg_postal_code' => $request->input('cg_postal_code'),
            'cg_retailer_type' => $request->input('cg_retailer_type'),
            'cg_type' => $request->input('cg_type'),
            'cg_photo_filename1'=>$cg_photo_filename1,
            'cg_photo_filename2'=>$cg_photo_filename2,
            'cg_photo_filename3'=>$cg_photo_filename3,
            // 'approval_status'=>'Pending',
            'ca_approval_status'=>'Pending',
            'ca_customer_status'=>'Inactive',
            'created_by' => '900102',
            'modified_by'=> '900102',
            'cg_channel' => $request->input( 'cg_channel' ),
            'cg_subchannel' => $request->input( 'cg_subchannel' ),
            'cg_group' => $request->input( 'cg_group' ),
            'cg_sclass' => $request->input( 'cg_sclass' ),
            
            'cg_billType' => 'Unbilled',
            'cg_avgl3m' => '0',
            'cg_target' => '0',
            'cg_achieved' => '0',

            'cg_balance' => '0',
            'cg_coverage' => '0',
            'cg_prod' => '0',
            'cg_jtd' => '0',
            'cg_distance' => '5',

            // 'modified_by'=>auth()->user()->empID,
        ); 

        $customer_result = $this->custrepo->storeOutlet( $form_credentials );
        return $customer_result;
    }

    //update outlet/customer
    public function update_outlet(Request $request){
        $form_credentials = array(
            'outletId' => $request->input( 'outletId'),); 

        $customer_result = $this->custrepo->updateOutlet( $form_credentials );
        return $customer_result;
    }

    //create orders
    public function create_orders(Request $request){
        if ($request->file('ord_photo_filename')) {
          $imagePath = $request->file('ord_photo_filename');
          $ord_photo_filename = $imagePath->getClientOriginalName();
          $path = $request->file('ord_photo_filename')->storeAs('uploads/orders', $ord_photo_filename, 'public');
      }
      else{
          $ord_photo_filename = '';
      }
      $orderId = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
      $response=$request->input( 'ord_products' ); 
      $data = json_decode($response,true) ;
      $form_credentials = array(
          'orderId'             => $orderId,
          'ord_photo_filename'  => $ord_photo_filename,
          'ord_customerCode'    => $data['ord_customerCode'],
          'ord_salesmanCode'    => $data['ord_salesmanCode'],
          'ord_distributorCode' => $data['ord_distributorCode'],
          'ord_totalAmount'     => $data['ord_totalAmount'],
          'ord_taxAmount'       => $data['ord_taxAmount'],
          'ord_discount'        => $data['ord_discount'],
          'ord_products'        => $data['ord_products'],
      );
      $order_result = $this->custrepo->storeOrders( $form_credentials );
      return $order_result;    
    }

    //fetch products for sales return
    public function list_products(Request $request){
        $form_credentials = array(
            'orderId' => $request->input( 'orderId'),
        ); 
        //$salesmanCode = $request->input( 'salesmanCode');
        $result = $this->custrepo->listProducts( $form_credentials );
        return $result;   
    }


    //sales return
    //sales return new
    //sales return
    /* public function sales_return(Request $request){
        try {
                if ($request->file('invoice_photo_filename')) {
                $imagePath = $request->file('invoice_photo_filename');
                $invoice_photo_filename = $imagePath->getClientOriginalName();
                $path = $request->file('invoice_photo_filename')->storeAs('uploads/sales_return', $invoice_photo_filename, 'public');
            }
            else{
                $invoice_photo_filename = '';
            }
            $sales_return_id = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
            $response=$request->input( 'sales_return_items' );
            // $response=$request->input( 'ord_returns' );
            $data = json_decode($response,true) ;

            // return $response;

            $form_credentials = array(
                'sales_return_id'      => $sales_return_id,
                'reference'            => $data['reference'],
                'invoice'              => $invoice_photo_filename,
                'invoice_no'           => $data['invoice_no'],
                'salesman_code'           => $data['salesmanCode'],
                'customer_code'           => $data['customerCode'],
                'distributor_code'           => $data['distributorCode'],
                'sales_return_items'   => $data['sales_return_items'],
            );
            $sales_return = $this->custrepo->storeSalesReturn( $form_credentials );   
            // return response()->json([
            //     'status'=>$sales_return['status'],
            //     'message'=>$sales_return['message'],
            // ]);
            return $sales_return;
        } 
        catch (\Exception $e) {
        return response()->json([
            'status'=>"False",
            'message'=>$e,
        ]);
        }
    } */
    //sales return
    public function sales_return(Request $request){
        try{
            if ($request->file('invoice_photo_filename')) {
                $imagePath = $request->file('invoice_photo_filename');
                $invoice_photo_filename = $imagePath->getClientOriginalName();
                $path = $request->file('invoice_photo_filename')->storeAs('uploads/sales_return', $invoice_photo_filename, 'public');
            }
            else{
                $invoice_photo_filename = '';
            }
            $sales_return_id = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
            //$response=$request->input( 'sales_return_items' );
            $response=$request->input( 'ord_returns' );
            $data = json_decode($response,true) ;
            //return $response['reference'];

            $form_credentials = array(
                'sales_return_id'      => $sales_return_id,
                'reference'            => $data['reference'],
                'invoice'              => $invoice_photo_filename,
                'invoice_no'           => $data['invoice_no'],
                'salesman_code'        => $data['salesmanCode'],
                'customer_code'        => $data['customerCode'],
                'distributor_code'     => $data['distributorCode'],
                'sales_return_items'   => $data['sales_return_items'],
            );
            $sales_return = $this->custrepo->storeSalesReturn( $form_credentials ); 
            if($sales_return){
                $status = "true";
                $message = 'Products Returned Successfully';
            }else{
                $status = "false";
                $message = $sales_return;

            }
        }
        catch(\Exception $e){
            $status = "false";
            $message = $e->getMessage().' Controller Error';
        }  

        return response()->json([
        'status'=>$status,
        'message'=>$message,
        ]);
    }

    //fetch new outlet/customer
    public function get_new_outlet(Request $request){
        $form_credentials = array(
            'salesmanCode' => $request->input( 'salesmanCode'),
            'distributorCode' => $request->input( 'distributorCode'),  
        );  
        $salesmanCode = $request->input( 'salesmanCode'); 
        $result = $this->custrepo->getNewOutlet( $form_credentials );
        return $result;   
    }

    //top 10 outlets
    public function top_outlets(Request $request){
        $form_credentials = array(
            'salesmanCode' => $request->input( 'salesmanCode'),
            'api' => $request->input( 'api'),  
        ); 
        $result = $this->custrepo->topOutlet( $form_credentials );
        return $result;   
    }
     
    //fetch orders
    public function get_orders(Request $request){
        $form_credentials = array(
            'salesmanCode' => $request->input( 'salesmanCode'),
            'distributorCode' => $request->input( 'distributorCode'), 
            'customerCode' => $request->input( 'customerCode'),  
        ); 
        $result = $this->custrepo->getOrders( $form_credentials );
        return $result;   
    }
    // end app

    

    //leelavinothan
    public function current_last_month_sales(Request $request){
        try {
           $lm = date('m', strtotime(date('Y-m') . " -1 month"));
           $cm = date('m');
           $y = date('Y');
           $datas = DB::table('orders')
               ->Join('customer_generals', 'cg_customer_code', '=', 'orders.customer_code')
               ->select(
                   'orders.customer_code as custCode',
                   'cg_customer_name as custName',
                   DB::raw("SUM(orders.total_amount) as current_month_total")
               )
               ->whereMonth('orders.created_at', $cm)
               ->whereYear('orders.created_at', $y)
               ->where('salesman_code', $request->salesmanCode)
               ->where('distributor_code', $request->distributorCode)
               ->groupBy('orders.customer_code', 'customer_generals.cg_customer_name')
               ->get()->toArray();
           $last_datas = DB::table('orders')
               ->Join('customer_generals', 'cg_customer_code', '=', 'orders.customer_code')
               ->select(
                   'orders.customer_code as custCode',
                   'cg_customer_name as custName',
                   DB::raw("SUM(orders.total_amount) as last_month_total")
               )
               ->whereMonth('orders.created_at', $lm)
               ->whereYear('orders.created_at', $y)
               ->where('salesman_code', $request->salesmanCode)
               ->where('distributor_code', $request->distributorCode)
               ->groupBy('orders.customer_code', 'customer_generals.cg_customer_name')
               ->get()->toArray();
           $currentandlastmonth=[];
           if(!empty($datas)){
               foreach ($datas as $key => $value) {
                   $check=DB::table('orders')->where('customer_code',$value->custCode)
                   ->whereMonth('orders.created_at', $lm)
                   ->whereYear('orders.created_at', $y)
                   ->where('salesman_code', $request->salesmanCode)
                   ->where('distributor_code', $request->distributorCode)
                   ->sum('total_amount');
                   if(!empty($check)){
                       $combine=[
                           "custCode"=> $value->custCode,
                           "custName"=> $value->custName,
                           "current_month_total"=> $value->current_month_total,
                           'last_monnth_total'=>$check
                       ];
                       array_push($currentandlastmonth,$combine);
                   }else{
                       $combine=[
                           "custCode"=> $value->custCode,
                           "custName"=> $value->custName,
                           "current_month_total"=> $value->current_month_total,
                           'last_monnth_total'=>0
                       ];
                       array_push($currentandlastmonth,$combine);
                   }
               }
           }else if(!empty($last_datas)){
               foreach ($last_datas as $key => $value) {
                   $combine=[
                       "custCode"=> $value->custCode,
                       "custName"=> $value->custName,
                       "current_month_total"=> 0,
                       'last_monnth_total'=>$value->last_month_total
                   ];
                   array_push($currentandlastmonth,$combine);
               }
           }else{
               $combine=[
                   "custCode"=> $value->custCode,
                   "custName"=> $value->custName,
                   "current_month_total"=> 0,
                   'last_monnth_total'=> 0
               ];
               array_push($currentandlastmonth,$combine);
           }
           if(!empty($currentandlastmonth)){
                   $status = 'true';
                   $message = 'success';
                   $result = $currentandlastmonth; 
               return response()->json([
                   'status'=>$status,
                   'message'=>$message,
                   'result'=>$result,
               ]);
           }else{
                   $status = 'false';
                   $message = 'No Data Found';
                   $result = $array;
               return response()->json([
                   'status'=>$status,
                   'message'=>$message,
                   'result'=>$result,
               ]);
           }

        } catch (\Exception $e) {
            $status = 'false';
            $message = $e;
            $result = 'Failed';
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);
        }
       }



       public function all_status_orders(Request $request){
           try {
           $pending_orders = orders::leftJoin('customer_generals as cg','cg.cg_customer_code','=','orders.customer_code')
                               ->select('orders.customer_code','orders.distributor_code','orders.order_id as invoice_no','orders.signature','orders.total_amount','orders.tax_amount','orders.discount','orders.status','orders.created_at as invoice_date','cg.cg_customer_name as custName')
                               ->where('orders.distributor_code',$request->distributorCode)
                               ->where('orders.salesman_code',$request->salesmanCode)
                               ->where('orders.status','Pending')
                               ->orderBy('orders.created_at','DESC')
                               ->get()->toArray();
           $pending_count = count($pending_orders);
           $pending_total = orders::leftJoin('customer_generals as cg','cg.cg_customer_code','=','orders.customer_code')
                                   ->select(DB::raw("SUM(orders.total_amount) as pending_total"),'orders.customer_code')
                                   ->where('orders.distributor_code',$request->distributorCode)
                               ->where('orders.salesman_code',$request->salesmanCode)
                                   ->where('orders.status','Pending')
                                   ->groupBy('orders.customer_code')
                                   ->first();
           $pending_array['pending_count']=$pending_count;
           $pending_array['pending_total']=$pending_total->pending_total;
           $pending_array['pending_orders']=$pending_orders;

           $approved_orders = orders::leftJoin('customer_generals as cg','cg.cg_customer_code','=','orders.customer_code')
                               ->select('orders.customer_code','orders.distributor_code','orders.order_id as invoice_no','orders.signature','orders.total_amount','orders.tax_amount','orders.discount','orders.status','orders.created_at as invoice_date','cg.cg_customer_name as custName')
                               ->where('orders.distributor_code',$request->distributorCode)
                               ->where('orders.salesman_code',$request->salesmanCode)
                               ->where('orders.status','Approved')
                               ->orderBy('orders.created_at','DESC')
                               ->get()->toArray();
           $approved_count = count($approved_orders);
           if(count($approved_orders) > 0 ){
               $at = orders::leftJoin('customer_generals as cg','cg.cg_customer_code','=','orders.customer_code')
                                   ->select(DB::raw("SUM(orders.total_amount) as approved_total"),'orders.customer_code')
                                   ->where('orders.distributor_code',$request->distributorCode)
                               ->where('orders.salesman_code',$request->salesmanCode)
                                   ->where('orders.status','Approved')
                                   ->groupBy('orders.customer_code')
                                   ->first();
               $approved_total = $at->approved_total;
           }else{
               $approved_total = 0;
           }
           
           $approved_array['approved_count']=$approved_count;
           $approved_array['approved_total']=$approved_total;
           $approved_array['approved_orders']=$approved_orders;

           $rejected_orders = orders::leftJoin('customer_generals as cg','cg.cg_customer_code','=','orders.customer_code')
                               ->select('orders.customer_code','orders.distributor_code','orders.order_id as invoice_no','orders.signature','orders.total_amount','orders.tax_amount','orders.discount','orders.status','orders.created_at as invoice_date','cg.cg_customer_name as custName')
                               ->where('orders.distributor_code',$request->distributorCode)
                               ->where('orders.salesman_code',$request->salesmanCode)
                               ->where('orders.status','Declined')
                               ->orderBy('orders.created_at','DESC')
                               ->get()->toArray();
           $rejected_count = count($rejected_orders);
           if(count($rejected_orders) > 0 ){
               $rt = orders::leftJoin('customer_generals as cg','cg.cg_customer_code','=','orders.customer_code')
                                   ->select(DB::raw("SUM(orders.total_amount) as rejected_total"),'orders.customer_code')
                                   ->where('orders.distributor_code',$request->distributorCode)
                                   ->where('orders.salesman_code',$request->salesmanCode)
                                   ->where('orders.status','Declined')
                                   ->groupBy('orders.customer_code')
                                   ->first();
               $rejected_total = $rt->rejected_total;
           }else{
               $rejected_total = 0;
           }
           $rejected_array['rejected_count']=$rejected_count;
           $rejected_array['rejected_total']=$rejected_total;
           $rejected_array['rejected_orders']=$rejected_orders;     

               if((!empty($pending_orders))||(!empty($approved_orders))||(!empty($rejected_orders))){
                       $status = 'true';
                       $message = 'success';
                       $result['Pending'] = $pending_array;
                       $result['Approved'] = $approved_array;
                       $result['Rejected'] = $rejected_array;

                       $result['pending_total'] = $pending_total;
                   return response()->json([
                       'status'=>$status,
                       'message'=>$message,
                       'result'=>$result,
                   ]);
               }else{
                       $status = 'false';
                       $message = 'No Data Found';
                       $result = $array;
                   return response()->json([
                       'status'=>$status,
                       'message'=>$message,
                       'result'=>$result,
                   ]);
               }
           } catch (\Exception $e) {
               $status = 'false';
               $message = $e;
               $result = 'Failed';
               return response()->json([
                   'status'=>$status,
                   'message'=>$message,
                   'result'=>$result,
               ]);
           }
    }
    public function previous_orders(Request $request){
    try {
        $array = orders::leftJoin('customer_generals as cg','cg.cg_customer_code','=','orders.customer_code')
                        ->join('ordered_items as oi','oi.order_id','=','orders.order_id')
                        ->select('oi.*')
                        ->where('orders.salesman_code','=',$request->salesmanCode)
                        ->where('orders.customer_code','=',$request->customerCode)
                        ->where('orders.distributor_code','=',$request->distributorCode)
                        ->orderBy('oi.created_at','DESC')
                        // ->toSql();
                        ->take(15)
                        ->get()->toArray();
            // dd($array);
            if(!empty($array)){
                    $status = 'true';
                    $message = 'success';
                    $result = $array;
                return response()->json([
                    'status'=>$status,
                    'message'=>$message,
                    'result'=>$result,
                ]);
            }else{
                    $status = 'false';
                    $message = 'No Data Found';
                    $result = $array;
                return response()->json([
                    'status'=>$status,
                    'message'=>$message,
                    'result'=>$result,
                ]);
            }
    } catch (\Exception $e) {
        $status = 'false';
        $message = $e;
        $result = 'Failed';
        return response()->json([
            'status'=>$status,
            'message'=>$message,
            'result'=>$result,
        ]);
    }
    }


public function customer_sales_overview(Request $request){
    $data = array(
        'customer_code'     => $request->customer_code,
        'm1'                => date('m', time()),
        'm2'                => date('m', strtotime('-1 month')),
        'm3'                => date('m', strtotime('-2 month')),
    );
    $order_avg_sale = $this->custrepo->customer_sales_overview( $data );   
    return $order_avg_sale; 
}
    //leelavinothan


    // 13/10

    public function customer_sales_overview1(Request $request){
        $data = array(
            'customer_code'     => $request->customer_code,
            'm1'                => date('m', time()),
            'm2'                => date('m', strtotime('-1 month')),
            'm3'                => date('m', strtotime('-2 month')),
        );
        // $result = $this->custrepo->customer_sales_overview( $data );
            // return $result;
        try {
            $result = $this->custrepo->customer_sales_overview( $data );
                if( !empty($result['customer_info']) ){
                    $status = 'true';
                    $message = 'success';
                        return response()->json([
                            'status'=>$status,   
                            'message'=>$message,
                            'result'=>$result,
                        ]);
                }else{
                    $status = 'false';
                    $message = 'No Data Found';
                    $result = [];
                    return response()->json([
                        'status'=>$status,
                        'message'=>$message,
                        'result'=>$result,
                    ]);
                }
            } catch (\Exception $e) {
                $status = 'false';
                $message = $e->getMessage();
                $result = 'Failed';
                return response()->json([
                    'status'=>$status,
                    'message'=>$message,
                    'result'=>$result,
                ]);
            }
    }

    // 26/09

    public function old_customer_sales_overview1(Request $request){
        $data = array(
            'customer_code'     => $request->customer_code,
            'm1'                => date('m', time()),
            'm2'                => date('m', strtotime('-1 month')),
            'm3'                => date('m', strtotime('-2 month')),
        );
        try {
            $result = $this->custrepo->customer_sales_overview1( $data );
                if( !empty($result['customer_info']) ){
                    $status = 'true';
                    $message = 'success';
                        return response()->json([
                            'status'=>$status,   
                            'message'=>$message,
                            'result'=>$result,
                        ]);
                }else{
                    $status = 'false';
                    $message = 'No Data Found';
                    $result = [];
                    return response()->json([
                        'status'=>$status,
                        'message'=>$message,
                        'result'=>$result,
                    ]);
                }
            } catch (\Exception $e) {
                $status = 'false';
                $message = $e->getMessage();
                $result = 'Failed';
                return response()->json([
                    'status'=>$status,
                    'message'=>$message,
                    'result'=>$result,
                ]);
            }
    }

    
    // 

}
