<?php 

namespace App\Repositories\Customer;


use App\Models\Customer_general;
use App\Models\ordered_items;
use App\Models\Customer_licence_setting;
use App\Models\Customer_coverage_attributes;
use App\Models\Outlet_images;
use DB;

class CustomerRepository implements ICustomerRepository
{
    public function getCustomers($where){

        $customer_general = DB::table('customer_generals as cg')
        ->select('cg.*')
        ->where($where)
        ->get();

        return $customer_general;
    }

    public function storeCustomer($form_credentials){

        $cg_input = new Customer_general;
        $cg_input->auto_id = 'CG'.str_pad( ( $cg_input->max( 'id' )+1 ), 9, '0', STR_PAD_LEFT );;
        $cg_input->cg_distributor_branch = $form_credentials['cg_distributor_branch'];
        $cg_input->cg_type = $form_credentials['cg_type'];
        $cg_input->cg_customer_code = $form_credentials['cg_customer_code'];
        $cg_input->cg_dist_cust_code = $form_credentials['cg_dist_cust_code'];
        $cg_input->cg_cmpny_cust_code = $form_credentials['cg_cmpny_cust_code'];
        $cg_input->cg_salesman_code = $form_credentials['cg_salesman_code'];
        $cg_input->cg_customer_name = $form_credentials['cg_customer_name'];
        $cg_input->cg_address_1 = $form_credentials['cg_address_1'];
        $cg_input->cg_address_2 = $form_credentials['cg_address_2'];
        $cg_input->cg_address_3 = $form_credentials['cg_address_3'];
        $cg_input->cg_country = $form_credentials['cg_country'];
        $cg_input->cg_state = $form_credentials['cg_state'];
        $cg_input->cg_city = $form_credentials['cg_city'];
        $cg_input->cg_town = $form_credentials['cg_town'];
        $cg_input->cg_postal_code = $form_credentials['cg_postal_code'];
        $cg_input->cg_phoneno = $form_credentials['cg_phoneno'];
        $cg_input->cg_mobile = $form_credentials['cg_mobile'];
        $cg_input->cg_latitude = $form_credentials['cg_latitude'];
        $cg_input->cg_longitude = $form_credentials['cg_longitude'];
        $cg_input->cg_distance = $form_credentials['cg_distance'];
        $cg_input->cg_dob = $form_credentials['cg_dob'];
        $cg_input->cg_anniversary = $form_credentials['cg_anniversary'];
        $cg_input->cg_enrollment_date = $form_credentials['cg_enrollment_date'];
        $cg_input->cg_contact_person = $form_credentials['cg_contact_person'];
        $cg_input->cg_emailid = $form_credentials['cg_emailid'];
        $cg_input->cg_gst_state = $form_credentials['cg_gst_state'];
        $cg_input->cg_retailer_type = $form_credentials['cg_retailer_type'];
        $cg_input->cg_pan_type = $form_credentials['cg_pan_type'];
        $cg_input->cg_panno = $form_credentials['cg_panno'];
        $cg_input->cg_aadhaar_no = $form_credentials['cg_aadhaar_no'];
        $cg_input->cg_gstin_number = $form_credentials['cg_gstin_number'];
        $cg_input->cg_tcs_applicable = $form_credentials['cg_tcs_applicable'];
        $cg_input->cg_related_party = $form_credentials['cg_related_party'];
        $cg_input->cg_composite = $form_credentials['cg_composite'];
        $cg_input->cg_tds_applicable = $form_credentials['cg_tds_applicable'];
        $cg_input->ca_customer_status = $form_credentials['ca_customer_status'];
        $cg_input->ca_approval_status = $form_credentials['ca_approval_status'];
        $cg_input->cg_billType = $form_credentials['cg_billType'];
        $cg_input->otpStatus = $form_credentials['otpStatus'];
        $cg_input->created_by =  $form_credentials['created_by'];
        $cg_input->modified_by =  $form_credentials['modified_by'];
        $cg_input->save();

        $lastInsertedId = $cg_input->auto_id;
        
        $cl_input = new Customer_licence_setting;
        $cl_input->auto_id = 'CL'.str_pad( ( $cl_input->max( 'id' )+1 ), 9, '0', STR_PAD_LEFT );;
        $cl_input->cg_id = $lastInsertedId;
        $cl_input->ls_tin_no = $form_credentials['ls_tin_no'];
        $cl_input->ls_pin_no = $form_credentials['ls_pin_no'];
        $cl_input->ls_license_no = $form_credentials['ls_license_no'];
        $cl_input->ls_cst_no = $form_credentials['ls_cst_no'];
        $cl_input->ls_drug_license_no1 = $form_credentials['ls_drug_license_no1'];
        $cl_input->ls_lic_expiry_date = $form_credentials['ls_lic_expiry_date'];
        $cl_input->ls_drug_license_no2 = $form_credentials['ls_drug_license_no2'];
        $cl_input->ls_dl1_expiry_date = $form_credentials['ls_dl1_expiry_date'];
        $cl_input->ls_pest_license_no = $form_credentials['ls_pest_license_no'];
        $cl_input->ls_dl2_expiry_date = $form_credentials['ls_dl2_expiry_date'];
        $cl_input->ls_fssai_no = $form_credentials['ls_fssai_no'];
        $cl_input->ls_credit_bill = $form_credentials['ls_credit_bill'];
        $cl_input->ls_credit_bill_status = $form_credentials['ls_credit_bill_status'];
        $cl_input->ls_credit_limit = $form_credentials['ls_credit_limit'];
        $cl_input->ls_credit_limit_status = $form_credentials['ls_credit_limit_status'];
        $cl_input->ls_credit_days = $form_credentials['ls_credit_days'];
        $cl_input->ls_credit_days_status = $form_credentials['ls_credit_days_status'];
        $cl_input->ls_cash_discount = $form_credentials['ls_cash_discount'];
        $cl_input->ls_limit_amount = $form_credentials['ls_limit_amount'];
        $cl_input->ls_cd_trigger_action = $form_credentials['ls_cd_trigger_action'];
        $cl_input->ls_trigger_amount = $form_credentials['ls_trigger_amount'];
        $cl_input->save();
        
        $ca_input = new Customer_coverage_attributes;
        $ca_input->auto_id = 'CA'.str_pad( ( $ca_input->max( 'id' )+1 ), 9, '0', STR_PAD_LEFT );
        $ca_input->cg_id = $lastInsertedId;
        $ca_input->ca_coverage_mode = $form_credentials['ca_coverage_mode'];
        $ca_input->ca_coverage_frequency = $form_credentials['ca_coverage_frequency'];
        $ca_input->ca_sales_route = $form_credentials['ca_sales_route'];
        $ca_input->ca_delivery_route = $form_credentials['ca_delivery_route'];
        $ca_input->ca_channel = $form_credentials['ca_channel'];
        $ca_input->ca_subchannel = $form_credentials['ca_subchannel'];
        $ca_input->ca_group = $form_credentials['ca_group'];
        $ca_input->ca_class = $form_credentials['ca_class'];
        $ca_input->ca_parent_child = $form_credentials['ca_parent_child'];
        $ca_input->ca_attach_parent = $form_credentials['ca_attach_parent'];
        $ca_input->ca_key_account = $form_credentials['ca_key_account'];
        $ca_input->ca_ra_mapping = $form_credentials['ca_ra_mapping'];
        $ca_input->save();


        foreach($form_credentials['outlet_images'] as $image_name) {

            $oi_input = new Outlet_images;
            $oi_input->auto_id = 'OI'.str_pad( ( $oi_input->max( 'id' )+1 ), 9, '0', STR_PAD_LEFT );
            $oi_input->cg_id = $lastInsertedId;
            $oi_input->image_name = $image_name;
            $oi_input->save();
        
        }

        if($ca_input) {

            return 200;

        } else {

            return 424;
        }

    }

    public function findCustomergeneral($id){

        $customer_general = DB::table('customer_generals as cg')
        ->select('cg.*','d.distributor_name','td.town_name','td.district_name','td.state_name','td.country_name')
        ->leftjoin('distributors as d', 'cg.cg_distributor_branch', '=', 'd.distributor_code')
        ->leftjoin('towns_details as td', 'cg.cg_town', '=', 'td.town_code')
        ->where('cg.auto_id', '=', $id)
        ->orderBy('cg.auto_id', 'desc')
        ->get();

        return $customer_general;

    }

    public function findCustomerlicenceSetting($id){

        $licence_setting = DB::table('customer_licence_settings as ls')
        ->select('ls.*')
        ->where('ls.cg_id',$id)
        ->get();

        return $licence_setting;

    }
    
    public function findCustomercoverageAttribute($id){

        $coverage_attribute = DB::table('customer_coverage_attributes as ca')
        ->select('ca.*','sr.route_name as sales_route','dr.route_name as delivery_route','cd.ChannelName','cd.SubChannelName','cd.GroupName','cd.ClassName')
        ->leftjoin('routes as sr', 'ca.ca_sales_route', '=', 'sr.route_code')
        ->leftjoin('routes as dr', 'ca.ca_delivery_route', '=', 'dr.route_code')
        ->leftjoin('channel_details as cd', 'ca.ca_class', '=', 'cd.ClassCode')
        
        ->where('ca.cg_id',$id)
        ->get();

        return $coverage_attribute;

    }
    public function findOutletimages( $id ){
        $outlet_images = DB::table('outlet_images as oi')
        ->select('oi.*')
        ->where('oi.cg_id',$id)
        ->get();

        return $outlet_images;
    }

    
    public function updateCustomer($form_credentials){

        $update_customertbl = new Customer_general();
        $update_customertbl = $update_customertbl->where( 'auto_id', '=', $form_credentials['auto_id'] );
    
        $update_customertbl->update( [ 
            'cg_distributor_branch' => $form_credentials['cg_distributor_branch'],
            'cg_type' => $form_credentials['cg_type'],
            'cg_customer_code' => $form_credentials['cg_customer_code'],
            'cg_dist_cust_code' => $form_credentials['cg_dist_cust_code'],
            'cg_cmpny_cust_code' => $form_credentials['cg_cmpny_cust_code'],
            'cg_salesman_code' => $form_credentials['cg_salesman_code'],
            'cg_customer_name' => $form_credentials['cg_customer_name'],
            'cg_address_1' => $form_credentials['cg_address_1'],
            'cg_address_2' => $form_credentials['cg_address_2'],
            'cg_address_3' => $form_credentials['cg_address_3'],
            'cg_country' => $form_credentials['cg_country'],
            'cg_state' => $form_credentials['cg_state'],
            'cg_city' => $form_credentials['cg_city'],
            'cg_town' => $form_credentials['cg_town'],
            'cg_postal_code' => $form_credentials['cg_postal_code'],
            'cg_phoneno' => $form_credentials['cg_phoneno'],
            'cg_mobile' => $form_credentials['cg_mobile'],
            'cg_latitude' => $form_credentials['cg_latitude'],
            'cg_longitude' => $form_credentials['cg_longitude'],
            'cg_distance' => $form_credentials['cg_distance'],
            'cg_dob' => $form_credentials['cg_dob'],
            'cg_anniversary' => $form_credentials['cg_anniversary'],
            'cg_enrollment_date' => $form_credentials['cg_enrollment_date'],
            'cg_contact_person' => $form_credentials['cg_contact_person'],
            'cg_emailid' => $form_credentials['cg_emailid'],
            'cg_gst_state' => $form_credentials['cg_gst_state'],
            'cg_retailer_type' => $form_credentials['cg_retailer_type'],
            'cg_pan_type' => $form_credentials['cg_pan_type'],
            'cg_panno' => $form_credentials['cg_panno'],
            'cg_aadhaar_no' => $form_credentials['cg_aadhaar_no'],
            'cg_gstin_number' => $form_credentials['cg_gstin_number'],
            'cg_tcs_applicable' => $form_credentials['cg_tcs_applicable'],
            'cg_related_party' => $form_credentials['cg_related_party'],
            'cg_composite' => $form_credentials['cg_composite'],
            'cg_tds_applicable' => $form_credentials['cg_tds_applicable'],
            'ca_customer_status' => $form_credentials['ca_customer_status'],
            'ca_approval_status' => $form_credentials['ca_approval_status'],
        ] );
        
        $update_customertbl = new Customer_licence_setting();
        $update_customertbl = $update_customertbl->where( 'cg_id', '=', $form_credentials['auto_id'] );
        
        $update_customertbl->update( [ 
            'ls_tin_no' => $form_credentials['ls_tin_no'],
            'ls_pin_no' => $form_credentials['ls_pin_no'],
            'ls_license_no' => $form_credentials['ls_license_no'],
            'ls_cst_no' => $form_credentials['ls_cst_no'],
            'ls_drug_license_no1' => $form_credentials['ls_drug_license_no1'],
            'ls_lic_expiry_date' => $form_credentials['ls_lic_expiry_date'],
            'ls_drug_license_no2' => $form_credentials['ls_drug_license_no2'],
            'ls_dl1_expiry_date' => $form_credentials['ls_dl1_expiry_date'],
            'ls_pest_license_no' => $form_credentials['ls_pest_license_no'],
            'ls_dl2_expiry_date' => $form_credentials['ls_dl2_expiry_date'],
            'ls_fssai_no' => $form_credentials['ls_fssai_no'],
            'ls_credit_bill' => $form_credentials['ls_credit_bill'],
            'ls_credit_bill_status' => $form_credentials['ls_credit_bill_status'],
            'ls_credit_limit' => $form_credentials['ls_credit_limit'],
            'ls_credit_limit_status' => $form_credentials['ls_credit_limit_status'],
            'ls_credit_days' => $form_credentials['ls_credit_days'],
            'ls_credit_days_status' => $form_credentials['ls_credit_days_status'],
            'ls_cash_discount' => $form_credentials['ls_cash_discount'],
            'ls_limit_amount' => $form_credentials['ls_limit_amount'],
            'ls_cd_trigger_action' => $form_credentials['ls_cd_trigger_action'],
            'ls_trigger_amount' => $form_credentials['ls_trigger_amount']
        ] );
        
        $update_customertbl = new Customer_coverage_attributes();
        $update_customertbl = $update_customertbl->where( 'cg_id', '=', $form_credentials['auto_id'] );
        
        $update_customertbl->update( [ 
            'ca_coverage_mode' => $form_credentials['ca_coverage_mode'],
            'ca_coverage_frequency' => $form_credentials['ca_coverage_frequency'],
            'ca_sales_route' => $form_credentials['ca_sales_route'],
            'ca_delivery_route' => $form_credentials['ca_delivery_route'],
            'ca_channel' => $form_credentials['ca_channel'],
            'ca_subchannel' => $form_credentials['ca_subchannel'],
            'ca_group' => $form_credentials['ca_group'],
            'ca_class' => $form_credentials['ca_class'],
            'ca_parent_child' => $form_credentials['ca_parent_child'],
            'ca_attach_parent' => $form_credentials['ca_attach_parent'],
            'ca_key_account' => $form_credentials['ca_key_account'],
            'ca_ra_mapping' => $form_credentials['ca_ra_mapping']
        ] );
        
        $customer = DB::table('outlet_images')->where('cg_id',  $form_credentials['auto_id'])->delete();

        foreach($form_credentials['outlet_images'] as $image_name) {

            $oi_input = new Outlet_images;
            $oi_input->auto_id = 'OI'.str_pad( ( $oi_input->max( 'id' )+1 ), 9, '0', STR_PAD_LEFT );
            $oi_input->cg_id = $form_credentials['auto_id'];
            $oi_input->image_name = $image_name;
            $oi_input->save();
        
        }
        
        if($update_customertbl) {
            return 200;
        } else {
            return 424;
        }

    }
    public function deleteCustomer($id){
        // $customer = Customer_general::find($id);
        // $customer->delete();

        $customer = DB::table('customer_generals')->where('auto_id', $id)->delete();
        $customer = DB::table('customer_licence_settings')->where('cg_id', $id)->delete();
        $customer = DB::table('customer_coverage_attributes')->where('cg_id', $id)->delete();

        if($customer) {
            return 200;
        } else {
            return 424;
        }
    }

    // app 22 aug
    public function getOutlet($form_credentials){
        $salesmanCode = $form_credentials['salesmanCode'];
        $distributorCode = $form_credentials['distributorCode'];
        $result = Customer_general::
                   where([['cg_salesman_code', '=', $salesmanCode],
                   ['ca_approval_status', '=', 'Approved'],
                   ['cg_distributor_branch', '=', $distributorCode],])
                    ->get();
        $bill = Customer_general::
                    where([['cg_salesman_code', '=', $salesmanCode],
                    ['ca_approval_status', '=', 'Approved'],
                    ['cg_distributor_branch', '=', $distributorCode],
                    ['cg_billType', '=', 'Billed'],])
                    ->withCount('order_list_unconfirmed')
                    ->withCount('order_list_confirmed')
                    ->withCount('order_list_total')
                     ->get(); 
        $billCount = count($bill);
        $unbill = Customer_general::
                    where([['cg_salesman_code', '=', $salesmanCode],
                    ['ca_approval_status', '=', 'Approved'],
                    ['cg_distributor_branch', '=', $distributorCode],
                    ['cg_billType', '=', 'Unbilled'],])
                    ->withCount('order_list_unconfirmed')
                    ->withCount('order_list_confirmed')
                    ->withCount('order_list_total')
                     ->get(); 
        $unbillCount = count($unbill);  
        
               
       // $allOutletsCount = count($allOutlets);   
                    
        if($result->isEmpty())
        {
            $status='false';
            $message='No Outlet mapped with the salesman';
            $result=[];
            $billedResult=[];
            $unbilledResult=[];
            $billedCount=0;
            $unbilledCount=0;
            $jtdSum = 0;   
            $avgl3mSum = 0;
        }
        else{
            $status='true';
            $message='success';
            $result=$result;
            $billedResult=$bill;
            $unbilledResult=$unbill;
            $billedCount=$billCount;
            $unbilledCount=$unbillCount;
            $jtdSum = $result->sum('cg_jtd');   
            $avgl3mSum = $result->sum('cg_avgl3m');
        }
    
        return response()->json([
            'status'=>$status,
            'message'=>$message,
            'jtdSum'=>$jtdSum,
            'avgl3mSum'=>$avgl3mSum,
            'billedCount'=>$billedCount,
            'unbilledCount'=>$unbilledCount,
            'result'=>$result,
            'billedResult'=>$billedResult,
            'unbilledResult'=>$unbilledResult,
        ]);
    }



    public function storeOutlet($form_credentials){
            
        try {  
        $cg_input = new Customer_general;
        $cg_input->auto_id = 'CG'.str_pad( ( $cg_input->max( 'id' )+1 ), 9, '0', STR_PAD_LEFT );
        $cg_input->cg_distributor_branch = '';
        $cg_input->cg_cmpny_cust_code = '';
        $cg_input->cg_address_3 = '';
        $cg_input->cg_country = 'India';
        $cg_input->cg_city = $form_credentials['cg_city'];
        $cg_input->cg_distance = '';
        $cg_input->cg_dob = '';
        $cg_input->cg_anniversary = '';
        $cg_input->cg_enrollment_date = '';
        $cg_input->cg_contact_person = '';
        $cg_input->cg_emailid = '';
        $cg_input->cg_gst_state = '';
        $cg_input->cg_aadhaar_no = '';        
        $cg_input->cg_cmpny_cust_code = $form_credentials['cg_cmp_customer_code'];
        $cg_input->cg_customer_code = $form_credentials['cg_customer_code'];
        $cg_input->cg_dist_cust_code = $form_credentials['cg_dist_cust_code'];
        $cg_input->cg_customer_name = $form_credentials['cg_customer_name'];
        $cg_input->cg_phoneno = $form_credentials['cg_phoneno'];
        $cg_input->cg_mobile = $form_credentials['cg_mobile'];
        $cg_input->cg_address_1 = $form_credentials['cg_address1'];
        $cg_input->cg_address_2 = $form_credentials['cg_address2'];
        $cg_input->cg_state = $form_credentials['cg_state'];
        $cg_input->cg_gstin_number = $form_credentials['cg_gstin_number'];
        $cg_input->cg_panno = $form_credentials['cg_panno'];
        $cg_input->cg_latitude = $form_credentials['cg_latitude'];
        $cg_input->cg_longitude = $form_credentials['cg_longitude'];
        $cg_input->cg_postal_code = $form_credentials['cg_postal_code'];
        $cg_input->cg_retailer_type = $form_credentials['cg_retailer_type'];
        $cg_input->cg_type = $form_credentials['cg_type'];
        $cg_input->ca_customer_status = $form_credentials['ca_customer_status'];
        $cg_input->cg_photo_filename1 = $form_credentials['cg_photo_filename1'];
        $cg_input->cg_photo_filename2 = $form_credentials['cg_photo_filename2'];
        $cg_input->cg_photo_filename3 = $form_credentials['cg_photo_filename3'];
        $cg_input->ca_approval_status = $form_credentials['ca_approval_status'];
        $cg_input->created_by =  $form_credentials['created_by'];
        $cg_input->modified_by =  $form_credentials['modified_by'];

        $cg_input->cg_jtd =  $form_credentials['cg_jtd'];
        $cg_input->cg_channel =  $form_credentials['cg_channel'];
        $cg_input->cg_subchannel =  $form_credentials['cg_subchannel'];
        $cg_input->cg_group =  $form_credentials['cg_group'];
        $cg_input->cg_sclass =  $form_credentials['cg_sclass'];
        $cg_input->cg_billType =  $form_credentials['cg_billType'];
        $cg_input->cg_avgl3m =  $form_credentials['cg_avgl3m'];
        $cg_input->cg_target =  $form_credentials['cg_target'];
        $cg_input->cg_achieved =  $form_credentials['cg_achieved'];
        $cg_input->cg_balance =  $form_credentials['cg_balance'];
        $cg_input->cg_coverage =  $form_credentials['cg_coverage'];
        $cg_input->cg_prod =  $form_credentials['cg_prod'];
        $cg_input->cg_distance =  $form_credentials['cg_distance'];
       
        $cg_input->save();

        if($cg_input) {

            $status='true';
            $message='Success'; 

        } else {

            $status='false';
            $message='Failed';
        }
          
        } catch (\Exception $e) {
            $status='false';
                $message=$e->getMessage();    
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]);

    }

    //update Outlet
    public function updateOutlet($form_credentials){
        try{
            $outletUpdate = DB::table('customer_generals')
            ->where('id',$form_credentials['outletId']);
            if($outletUpdate->count()>=1){
                    $update = $outletUpdate ->update([
                        'cg_billType' => 'Billed'
                     ]);
                    $status='true';
                    $message='Success';  
            }
            else{
                $status='false';
                $message='Outlet not Found';
            }
                return response()->json([
                    'status'=>$status,
                    'message'=>$message,
                ]);  
        }
        catch(QueryException $e){
            return response()->json([
                'status'=>'false',
                'message'=>$e,
            ]);
        } 
    }

    public function create_order($form_credentials)
    {
        $orders = array(
            'customer_code' => $form_credentials['customer_code'],
            'salesman_code' => $form_credentials['salesman_code'],
            'distributor_code' => $form_credentials['distributor_code'],
            'order_id' => $form_credentials['order_id'],
            'signature' => $form_credentials['signature'],
            'total_amount' => $form_credentials['total_amount'],
            'tax_amount' => $form_credentials['tax_amount'],
            'discount' => $form_credentials['discount'],
            'status' => 'Pending',
       );
       $insertOrder = DB::table('orders')->insert($orders);

       return response()->json([
        'status'=>"Success",
        'message'=>"Success"
        ]); 
    }

    public function create_order_items($form_credentials)
    {
        $orders = array(
            'order_id' => $form_credentials['order_id'],
            'product_id' => $form_credentials['product_id'],
            'product_name' => $form_credentials['product_name'],
            'quantity' => $form_credentials['quantity'],
            'ptr' => $form_credentials['ptr'],
            'tentative_discount' => $form_credentials['tentative_discount'],
            'tax_percentage' => $form_credentials['tax_percentage'],
            'tentative_line_value' => $form_credentials['tentative_line_value'],
            'quantity_type' => $form_credentials['quantity_type'],
            'scheme_id' => $form_credentials['scheme_id'],
       );
       $insertOrder = DB::table('ordered_items')->insert($orders);

       return response()->json([
        'status'=>"Success",
        'message'=>"Success"
        ]); 
    }

    public function storeOrders($form_credentials){
            
        try {
            
            $orders = array(
                'customer_code' => $form_credentials['ord_customerCode'],
                'salesman_code' => $form_credentials['ord_salesmanCode'],
                'distributor_code' => $form_credentials['ord_distributorCode'],
                'order_id' => $form_credentials['orderId'],
                'signature' => $form_credentials['ord_photo_filename'],
                'total_amount' => $form_credentials['ord_totalAmount'],
                'tax_amount' => $form_credentials['ord_taxAmount'],
                'discount' => $form_credentials['ord_discount'],
                'status' => 'Pending',
           );
           $insertOrder = DB::table('orders')->insert($orders);
           $result = $form_credentials['ord_products'];
           if($insertOrder){
               foreach($result as $values) {
                   $orderItems = array(
                    'order_id' => $form_credentials['orderId'],
                    'product_id' => $values['items_productId'],
                    'product_name' => $values['items_productName'],
                    'quantity' => $values['items_quantity'],
                    'ptr' => $values['items_ptr'],
                    'tentative_discount' => $values['items_tentativeDiscount'],
                    'tax_percentage' => $values['items_taxPercentage'],
                    'tentative_line_value' => $values['items_tentativeLineValue'],
                    'quantity_type' => $values['items_quantityType'],
                    'scheme_id' => $values['items_schemeId'],
                   );
                   $insertOrderItems = DB::table('ordered_items')->insert($orderItems);
                   if($insertOrderItems){
                       $status='true';
                       $message='Success'; 
                   }
                   else{
                       $status='false';
                       $message='Product Items Failed'; 
                   }
                }
           }
           else{
           $status='false';
           $message='Order Failed'; 
           }
         
   } catch (\Exception $e) {
       $status='false';
       $message=$e->getMessage();    
   }
   return response()->json([
       'status'=>$status,
       'message'=>$message
   ]); 
   }



    //listProducts for sales return
    public function listProducts($form_credentials){
        $orderId = $form_credentials['orderId'];
        
        $orders = Ordered_Items::where('order_id','=',$orderId)->get(); 
            
        if(empty($orders))
        {
            $status='false';
            $message='No Products found';
        }
        else{
            $status='true';
            $message='success';
        } 

    return response()->json([
        'status'=>$status,
        'message'=>$message,
        'orders'=>$orders,
    ]);
    }



    public function storeSalesReturn1($form_credentials){
            
        
            
              $sales = array(
                'sales_return_id'    => $form_credentials['sales_return_id'],
                'reference'          => $form_credentials['reference'],
                'invoice'            => $form_credentials['invoice'],
                'salesman_code'            => $form_credentials['salesman_code'],
                'customer_code'            => $form_credentials['customer_code'],
                'distributor_code'            => $form_credentials['distributor_code'],
                'invoice_no'         => $form_credentials['invoice_no'],

                
            );
            // 'sales_return_items' => $form_credentials['sales_return_items'],
            $insertSales = DB::table('sales_returns')->insert($sales);
            $result = $form_credentials['sales_return_items'];
        
             if($insertSales){
                 foreach($result as $values) {
                    $salesItems = array(
                        'sales_return_id' => $form_credentials['sales_return_id'],
                        'product_id' => $values['items_productId'],
                        'product_name' => $values['items_productName'],
                        'sold_quantity' => $values['items_squantity'],
                        'return_quantity' => $values['items_uquantity'],
                        'return_type' => $values['items_returnType'],
                        'reason' => $values['items_reason'],
                    );
                    $insertSalesItems = DB::table('sales_return_items')->insert($salesItems);
                    if($insertSalesItems){
                        $status='true';
                        $message='Success'; 
                    }
                    else{
                        $status='false';
                        $message='Sales Return Failed'; 
                    }
                 } 
            }
            else{
            $status='false';
            $message='Sales Return Failed'; 
            }      
         
        $status='false';
        return response()->json([
            'status'=>$status,
            'message'=>$message
        ]); 
        
    }
   


    // 

    // public function storeSalesReturn($form_credentials){
            
    //     try {
            
    //           $sales = array(
    //             'sales_return_id'    => $form_credentials['sales_return_id'],
    //             'reference'          => $form_credentials['reference'],
    //             'invoice'            => $form_credentials['invoice'],
    //             'salesman_code'            => $form_credentials['salesman_code'],
    //             'customer_code'            => $form_credentials['customer_code'],
    //             'distributor_code'            => $form_credentials['distributor_code'],
    //             'invoice_no'         => $form_credentials['invoice_no'],
               
    //         );
    //         // 'sales_return_items' => $form_credentials['sales_return_items'],
    //         $insertSales = DB::table('sales_returns')->insert($sales);
    //         $result = $form_credentials['sales_return_items'];
        
    //          if($insertSales){
    //              foreach($result as $values) {
    //                 $salesItems = array(
    //                     'sales_return_id' => $form_credentials['sales_return_id'],
    //                     'product_id' => $values['items_productId'],
    //                     'product_name' => $values['items_productName'],
    //                     'sold_quantity' => $values['items_squantity'],
    //                     'return_quantity' => $values['items_uquantity'],
    //                     'return_type' => $values['items_returnType'],
    //                     'reason' => $values['items_reason'],
    //                 );
    //                 $insertSalesItems = DB::table('sales_return_items')->insert($salesItems);
    //                 if($insertSalesItems){
    //                     $status='true';
    //                     $message='Success'; 
    //                 }
    //                 else{
    //                     $status='false';
    //                     $message='Sales Return Failed'; 
    //                 }
    //              } 
    //         }
    //         else{
    //         $status='false';
    //         $message='Sales Return Failed'; 
    //         }      
    //      } catch (\Exception $e) {
    //     $status='false';
    //     $message=$e->getMessage();    
    // }
    // return response()->json([
    //     'status'=>$status,
    //     'message'=>$message
    // ]); 
    // }

    // new

    public function storeSalesReturn($form_credentials){
            
        try {
            
              $sales = array(
                'sales_return_id'    => $form_credentials['sales_return_id'],
                'reference'          => $form_credentials['reference'],
                'invoice'            => $form_credentials['invoice'],
                'salesman_code'            => $form_credentials['salesman_code'],
                'customer_code'            => $form_credentials['customer_code'],
                'distributor_code'            => $form_credentials['distributor_code'],
                'invoice_no'         => $form_credentials['invoice_no'],
               
            );
            // 'sales_return_items' => $form_credentials['sales_return_items'],
            $insertSales = DB::table('sales_returns')->insert($sales);
            $result = $form_credentials['sales_return_items'];
        
             if($insertSales){
                 foreach($result as $values) {
                    $salesItems = array(
                        'sales_return_id' => $form_credentials['sales_return_id'],
                        'product_id' => $values['items_productId'],
                        'product_name' => $values['items_productName'],
                        'sold_quantity' => $values['items_squantity'],
                        'return_quantity' => $values['items_uquantity'],
                        'return_type' => $values['items_returnType'],
                        'reason' => $values['items_reason'],
                    );
                    $insertSalesItems = DB::table('sales_return_items')->insert($salesItems);
                    if($insertSalesItems){
                        $status='true';
                        $message='Success'; 
                    }
                    else{
                        $status='false';
                        $message='Sales Return Failed'; 
                    }
                 } 
            }
            else{
            $status='false';
            $message='Sales Return Failed'; 
            }      
         } catch (\Exception $e) {
        $status='false';
        $message=$e->getMessage().' Rep Errror';    
    }
    return response()->json([
        'status'=>$status,
        'message'=>$message
    ]); 
    }


    //get new outlet
    public function getNewOutlet($form_credentials){
        $salesmanCode = $form_credentials['salesmanCode'];
        $distributorCode = $form_credentials['distributorCode'];
       
                  $result = Customer_general::

                  where([['cg_salesman_code', '=', $salesmanCode],['ca_approval_status', '=', 'Pending'],

                  ['cg_distributor_branch', '=', $distributorCode],

                  ])
                  ->withCount('order_list_unconfirmed')
                  ->withCount('order_list_confirmed')
                  ->withCount('order_list_total')
                ->get();
                
        if($result->isEmpty())
        {
            $status='false';
            $message='No Outlet mapped with the salesman';
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

    //top outlets
    public function topOutlet($form_credentials){
        $salesmanCode = $form_credentials['salesmanCode'];
        $api = $form_credentials['api'];
        if($api=='topOutlet'){
            $result = DB::table('orders')
            ->leftJoin('customer_generals', 'orders.customer_code', '=', 'customer_generals.cg_customer_code')
            ->where('orders.salesman_code','=',$salesmanCode)
            ->select('orders.customer_code as custCode', 'customer_generals.cg_customer_name as custName' , 
        DB::raw('count(orders.customer_code) as noofinv'),
         DB::raw('sum(orders.total_amount) as totalSales'), 
         DB::raw('avg(orders.total_amount) as avgPercentage'))
        ->groupBy('orders.customer_code','customer_generals.cg_customer_code')
        ->orderByRaw('SUM(orders.total_amount) DESC')
        ->take(10)
        ->get();
        }
        else if($api=='beatwiseOutlet'){
            $result = DB::table('orders')
        ->leftJoin('customer_generals', 'orders.customer_code', '=', 'customer_generals.cg_customer_code')
        ->where('orders.salesman_code','=',$salesmanCode)
        ->select('orders.customer_code as custCode', 'customer_generals.cg_customer_name as custName' , 
         DB::raw('count(orders.customer_code) as noofinv'),
         DB::raw('sum(orders.total_amount) as totalSales'), 
         DB::raw('avg(orders.total_amount) as avgPercentage'))
        ->groupBy('orders.customer_code','customer_generals.cg_customer_code')
        ->orderByRaw('SUM(orders.total_amount) DESC')
        ->get();
        }
                     
                    
        if($result->isEmpty())
        {
            $status='false';
            $message='No Data Found';
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


//get orders
public function getOrders($form_credentials){
    $salesmanCode = $form_credentials['salesmanCode'];
    $distributorCode = $form_credentials['distributorCode'];
    $customerCode = $form_credentials['customerCode'];
   
                $result = DB::table('orders')
                ->where([['salesman_code', '=', $salesmanCode],['customer_code', '=', $customerCode],
                ['distributor_code', '=', $distributorCode],
                ])
                
              ->get();
            
    if($result->isEmpty())
    {
        $status='false';
        $message='No Orders Found';
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

    public function getCustomerscondition($form_credentials  ){

        $customer_general = DB::table('customer_generals as cg')
        ->select('cg.*')
        // ->where('cg.cg_dist_cust_code',$form_credentials['distributor_id'] )
        ->where('cg.ca_approval_status',$form_credentials['ca_approval_status'])
        ->get();

        return $customer_general;
    }

    public function customer_status_update($form_credentials  ){

        $update_customertbl = new Customer_general();
        $update_customertbl = $update_customertbl->whereIn( 'auto_id', $form_credentials['auto_id'] );
    
        $update_customertbl->update( [ 
            'ca_approval_status' => $form_credentials['ca_approval_status'],
            'ca_customer_status' => $form_credentials['ca_customer_status'],
            
        ] );

        if($update_customertbl) {
            return 200;
        } else {
            return 424;
        }
    }

    public function getCustomerscondition_dist($form_credentials  ){

        $customer_general = DB::table('customer_generals as cg')
        ->select('cg.*')
        ->where('cg.cg_distributor_branch',$form_credentials['distributor_id'] )
        ->where('cg.ca_approval_status',$form_credentials['ca_approval_status'])
        ->get();

        return $customer_general;
    }


    // leelevinothan
    // public function customer_sales_overview_old($data){
    //     try {
    //             $customer_info = DB::table('customer_generals as cg')
    //                                 ->where('cg.cg_customer_code','=',$data['customer_code'])->first();
    //             $last3_month =  array(
    //                                 date('m', time()),
    //                                 date('m', strtotime('-1 month')),
    //                                 date('m', strtotime('-2 month'))
    //                             );
    //             $m1 = date('m', time());
    //             $m2 = date('m', strtotime('-1 month'));
    //             $m3 = date('m', strtotime('-2 month'));

    //             $order_avg_sale = DB::table('orders')
    //                                 ->select(DB::raw("SUM(orders.total_amount) as total_value"),'orders.customer_code')
    //                                 ->where('customer_code', $data['customer_code'])
    //                                 ->whereMonth('created_at','>=',$m3)
    //                                 ->whereMonth('created_at','<=',$m1)
    //                                 ->groupBy('orders.customer_code')
    //                                 ->first();
    //                                 // ->get()->toArray();
    //             $last_order_info = DB::table('orders')
    //                                 ->where('customer_code',$data['customer_code'])
    //                                 ->orderBy('id','desc')->first();
    //             $last_visit_dt = DB::table('orders')
    //                                 ->where('customer_code',$data['customer_code'])
    //                                 ->orderBy('updated_at','desc')->first();
    //             $pending_bills = DB::table('orders')
    //                                 ->select(DB::raw("SUM(orders.total_amount) as total_value"),'orders.customer_code')
    //                                 ->where('customer_code',$data['customer_code'])
    //                                 ->where('status','Pending')
    //                                 ->groupBy('orders.customer_code')
    //                                 ->first();
    //             if( !empty($customer_info) ){
    //                 $status = 'true';
    //                 $message = 'success';
    //                 $result['customer_info'] = $customer_info;
    //                /*  $result['last3_month_avg_sale'] = $order_avg_sale->total_value;
    //                 $result['last_visit_date'] = $last_visit_dt->updated_at;
    //                 $result['last_order_value'] = $last_order_info->total_amount;
    //                 $result['last_order_date'] = $last_order_info->created_at;
    //                 $result['pending_bills'] = $pending_bills->total_value; */
    //                 $result['last3_month_avg_sale'] = ($order_avg_sale) ? $order_avg_sale->total_value : 0;

    //                 $result['last_visit_date'] = $last_visit_dt->updated_at;

    //                 $result['last_order_value'] = ($last_order_info) ? $last_order_info->total_amount : 0;

    //                 $result['last_order_date'] = $last_order_info->created_at;

    //                 $result['pending_bills'] = ($pending_bills) ? $pending_bills->total_value : 0;
    //                     return response()->json([
    //                         'status'=>$status,   
    //                         'message'=>$message,
    //                         'result'=>$result,
    //                     ]);
    //             }else{
    //                 $status = 'false';
    //                 $message = 'No Data Found';
    //                 $result = $array;
    //                 return response()->json([
    //                     'status'=>$status,
    //                     'message'=>$message,
    //                     'result'=>$result,
    //                 ]);
    //             }
    //         } catch (\Exception $e) {
    //             $status = 'false';
    //            $message = $e->getMessage();
    //             $result = 'Failed';
    //             return response()->json([
    //                 'status'=>$status,
    //                 'message'=>$message,
    //                 'result'=>$result,
    //             ]);
    //         }
    // }
    // leelevinothan


    // 13-10-2022
    public function customer_sales_overview($data){
       
        $customer_info = DB::table('customer_generals as cg')
                            ->leftJoin('customer_coverage_attributes as cc','cc.cg_id','=','cg.auto_id')
                            ->leftJoin('towns_details as std','std.state_code','=','cg.cg_state')
                            ->leftJoin('towns_details as cntry','cntry.country_code','=','cg.cg_country')
                            // ->leftJoin('towns_details as dist','dist.district_code','=','cg.auto_id')
                            ->leftJoin('towns_details as twn','twn.town_code','=','cg.cg_town')
                            ->select('cg.*','cc.ca_class','cc.ca_channel','cc.ca_subchannel','cc.ca_group','std.state_name','cntry.country_name','twn.town_name')
                            ->where('cg.cg_customer_code','=',$data['customer_code'])->first();
        if( !empty($customer_info) ){
            $last3_month =  array(
                                date('m', time()),
                                date('m', strtotime('-1 month')),
                                date('m', strtotime('-2 month'))
                            );
            $m1 = date('m', time()); 
            $m2 = date('m', strtotime('-1 month'));
            $m3 = date('m', strtotime('-2 month'));
            $y = date('Y');
            $order_avg_sale = DB::table('orders')
                                ->select(DB::raw("SUM(orders.total_amount) as total_value"),'orders.customer_code')
                                ->where('customer_code', $data['customer_code'])
                                ->whereMonth('created_at','>=',$m3)
                                ->whereMonth('created_at','<=',$m1)
                                ->whereYear('created_at', $y)
                                ->groupBy('orders.customer_code')
                                // ->tosql();
                                ->first();
                                // ->get()->toArray();
            $last_order_info = DB::table('orders')
                                ->where('customer_code',$data['customer_code'])
                                ->orderBy('id','desc')->first();
            $last_visit_dt = DB::table('orders')
                                ->where('customer_code',$data['customer_code'])
                                ->orderBy('updated_at','desc')->first();
            $pending_bills = DB::table('orders')
                                ->select(DB::raw("SUM(orders.total_amount) as total_value"),'orders.customer_code')
                                ->where('customer_code',$data['customer_code'])
                                ->where('status','Pending')
                                ->groupBy('orders.customer_code')
                                ->first();
            if(!empty($last_visit_dt)){
                $last_visitdt = $last_visit_dt->updated_at;
            }else{
                $last_visitdt = '';
            }
            if(!empty($last_order_info)){
                $last_order_date = $last_order_info->created_at;
                $last_order_info = $last_order_info->total_amount;
            }else{
                $last_order_date = '';
                $last_order_info = 0;
            }
            if(!empty($order_avg_sale->total_value)){
                $order_avg_sale = $order_avg_sale->total_value;
            }else{
                $order_avg_sale = 0;
            }
            if(!empty($pending_bills->total_value)){
                $pending_bills = $pending_bills->total_value;
            }else{
                $pending_bills = 0;
            }
                $result['customer_info'] = $customer_info;
                $result['last3_month_avg_sale'] = $order_avg_sale;
                $result['last_visit_date'] = $last_visitdt;
                $result['last_order_value'] = $last_order_info;
                $result['last_order_date'] = $last_order_date;
                $result['pending_bills'] = $pending_bills;
        }else{
            $result = '';   
        }
        return $result;
    }
    // 13-10-2022 end




    // 26/09

    public function customer_sales_overview1($data){
        $customer_info = DB::table('customer_generals as cg')
                            ->where('cg.cg_customer_code','=',$data['customer_code'])->first();
        if( !empty($customer_info) ){
            $last3_month =  array(
                                date('m', time()),
                                date('m', strtotime('-1 month')),
                                date('m', strtotime('-2 month'))
                            );
            $m1 = date('m', time()); 
            $m2 = date('m', strtotime('-1 month'));
            $m3 = date('m', strtotime('-2 month'));
            $y = date('Y');
            $order_avg_sale = DB::table('orders')
                                ->select(DB::raw("SUM(orders.total_amount) as total_value"),'orders.customer_code')
                                ->where('customer_code', $data['customer_code'])
                                ->whereMonth('created_at','>=',$m3)
                                ->whereMonth('created_at','<=',$m1)
                                ->whereYear('created_at', $y)
                                ->groupBy('orders.customer_code')
                                // ->tosql();
                                ->first();
                                // ->get()->toArray();
            $last_order_info = DB::table('orders')
                                ->where('customer_code',$data['customer_code'])
                                ->orderBy('id','desc')->first();
            $last_visit_dt = DB::table('orders')
                                ->where('customer_code',$data['customer_code'])
                                ->orderBy('updated_at','desc')->first();
            $pending_bills = DB::table('orders')
                                ->select(DB::raw("SUM(orders.total_amount) as total_value"),'orders.customer_code')
                                ->where('customer_code',$data['customer_code'])
                                ->where('status','Pending')
                                ->groupBy('orders.customer_code')
                                ->first();
            if(!empty($last_visit_dt)){
                $last_visitdt = $last_visit_dt->updated_at;
            }else{
                $last_visitdt = '';
            }
            if(!empty($last_order_info)){
                $last_order_date = $last_order_info->created_at;
                $last_order_info = $last_order_info->total_amount;
            }else{
                $last_order_date = '';
                $last_order_info = 0;
            }
            if(!empty($order_avg_sale)){
                $order_avg_sale = $order_avg_sale->total_value;
            }else{
                $order_avg_sale = 0;
            }
            if(!empty($pending_bills)){
                $pending_bills = $pending_bills->total_value;
            }else{
                $pending_bills = 0;
            }
                $result['customer_info'] = $customer_info;
                $result['last3_month_avg_sale'] = $order_avg_sale;
                $result['last_visit_date'] = $last_visitdt;
                $result['last_order_value'] = $last_order_info;
                $result['last_order_date'] = $last_order_date;
                $result['pending_bills'] = $pending_bills;
        }else{
            $result = '';   
        }
        return $result;
    }


    // 27-09
    public function get_pending_outlets($where1 ){
        $customer_general = DB::table('customer_generals as cg')
        ->select('cg.*','ca.*','cg.auto_id as cg_auto_id','d.distributor_name','tu.target_amount')
        ->leftjoin('customer_coverage_attributes as ca', 'ca.cg_id','=','cg.auto_id')
        ->leftjoin('distributors as d', 'cg.cg_distributor_branch', '=', 'd.distributor_code')
        ->leftjoin('target_uploads as tu', 'tu.employee_code','=','cg.cg_customer_code')

        ->where($where1)
        ->orderBy('cg.auto_id', 'desc')
        ->get();

        return $customer_general;
    }
    // 27-09

}

?>