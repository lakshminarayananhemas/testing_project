<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Salesman;
use App\Imports\SalesmanImport;
use App\Repositories\Salesman\ISalesmanRepository; 
use App\Models\Salesman_jc_route_mapping;
use App\Imports\SalesmanJcRouteMapping;

class SalesmanController extends Controller
{
    public function __construct(ISalesmanRepository $salerepo)
    {
        $this->salerepo = $salerepo;
    }
    
    // ganaga
    public function index(Request $request){
        try {
            if($request->input( 'user_type' ) =='Admin'){

                $where=array();
                $where[] = ['status', '=', 'Active'];
        
            }elseif ($request->input( 'user_type' ) =='Distributor') {
    
                $where=array();
                $where[] = ['status', '=', 'Active'];  
                $where[] = ['distributor_code', '=', $request->input( 'distributor_code' )];
    
            }else{
                $where=array();
            }
    
            $result = $this->salerepo->getSalesman( $where );
            
            if(!empty($result)){
                $status = 'true';
                $message = 'success';
                $result = $result; 
            }else{
                $status = 'false';
                $message = 'No Data Found';
                $result = $result;
            }
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);

        } catch (\Execption $e) {
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

    public function fetch_salesman_route_map_list(Request $request){
        try {

        if($request->input( 'user_type' ) =='Admin'){
            $where=array();
            $where[] = ['sm.status', '=', 'Active'];
        }elseif ($request->input( 'user_type' ) =='Distributor') {
            $where=array();
            $where[] = ['sm.status', '=', 'Active'];  
            $where[] = ['sm.distributor_code', '=', $request->input( 'distributor_code' )];
        }
        $result = $this->salerepo->fetch_salesman_route_list($where);


        if(!empty($result)){
            $status = 'true';
            $message = 'success';
            $result = $result; 
        }else{
            $status = 'false';
            $message = 'No Data Found';
            $result = $result;
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message,
            'result'=>$result,
        ]);
        } catch (\Execption $e) {
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

        try {
            
            if($request->input( 's_sfa_pass_status' ) =='Y'){
                $password = '123456';
            }else{
                $password = '';
            }

            if($request->has('s_filename')) {
                $original_image_name = $request->file('s_filename')->getClientOriginalName();
                $image = $request->file('s_filename');
                $salesman_image = "si_".rand(). '.'.$image->getClientOriginalExtension();
                $image->storeAs('uploads/salesman_images/', $salesman_image, 'public');
    
            }
            else{
                $salesman_image = '';
            }
           
            $form_credentials = array(
                'distributor_code' => $request->input( 's_distributor_code' ),
                'distributor_branch_code' => '',
                'salesman_name' => $request->input( 's_salesman_name' ),
                'email_id' => $request->input( 's_email_id' ),
                'phone_no' => $request->input( 's_phone_no' ),
                'daily_allowance' => $request->input( 's_daily_allowance' ),
                'salary' => $request->input( 's_monthly_allowance' ),
                'status' => $request->input( 's_status' ),
                'salesman_code' => $request->input( 's_salesman_code' ),
                'dob' => $request->input( 's_dob' ),
                'doj' => $request->input( 's_doj' ),
                'password' => $password,
                'salesman_type' => $request->input( 's_salesman_type' ),
                'sm_unique_code' => $request->input( 's_sm_unique_code' ),
                'third_party_empcode' => $request->input( 's_third_party_emp_code' ),
                'replacement_for' => $request->input( 's_replacement' ),
    
                'attach_company' => $request->input( 's_attach_company' ),
                'sales_type' => $request->input( 's_sales_type' ),
                'godown_status' => $request->input( 's_godown_status' ),
                'aadhaar_no' => $request->input( 's_aadhar_no' ),
                'sfa_status' => $request->input( 's_sfa_status' ),
                'device_no' => $request->input( 's_device_no' ),
                'sfa_pass_status' => $request->input( 's_sfa_pass_status' ),
                'salesman_image' => $salesman_image,
            );
            $salesman_result = $this->salerepo->storeSalesman( $form_credentials );
    
            if($salesman_result ==200){
                $message = 'Salesman Added Successfully';
            }else{
                $message = 'Request Failed';
    
            }
    
            return response()->json([
                'status'=>$salesman_result,
                'message'=>$message,
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

    public function destroy($id){

        try {
            $result = $this->salerepo->deleteSalesman( $id );
            if($result ==200){
                $message = 'Salesman Deleted Successfully';
            }else{
                $message = 'Request Failed';
            }

            return response()->json([
                'status'=>$result,
                'message'=>$message,
            ]);

            return response()->json([
                'status'=>$result,
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

    public function update(Request $request,$id){
        try {

            if($request->input( 's_sfa_pass_status' ) =='Y'){
                $password = '123456';
            }else{
                $password = '';
            }

            if ($request->file('s_filename')) {
                
                $imageName = time().'.'.$request->s_filename->extension();  
            
                $request->s_filename->move(public_path('salesman_images'), $imageName);

                $salesman_image = $imageName;
            }
            else{
                $salesman_image = '';
            }
            
            $form_credentials = array(
                'id' => $id,
                'distributor_code' => $request->input( 's_distributor_code' ),
                'distributor_branch_code' => '',
                'salesman_name' => $request->input( 's_salesman_name' ),
                'email_id' => $request->input( 's_email_id' ),
                'phone_no' => $request->input( 's_phone_no' ),
                'daily_allowance' => $request->input( 's_daily_allowance' ),
                'salary' => $request->input( 's_monthly_allowance' ),
                'status' => $request->input( 's_status' ),
                'salesman_code' => $request->input( 's_salesman_code' ),
                'dob' => $request->input( 's_dob' ),
                'doj' => $request->input( 's_doj' ),
                'password' => $password,
                'salesman_type' => $request->input( 's_salesman_type' ),
                'sm_unique_code' => $request->input( 's_sm_unique_code' ),
                'third_party_empcode' => $request->input( 's_third_party_emp_code' ),
                'replacement_for' => $request->input( 's_replacement' ),

                'attach_company' => $request->input( 's_attach_company' ),
                'sales_type' => $request->input( 's_sales_type' ),
                'godown_status' => $request->input( 's_godown_status' ),
                'aadhaar_no' => $request->input( 's_aadhar_no' ),
                'sfa_status' => $request->input( 's_sfa_status' ),
                'device_no' => $request->input( 's_device_no' ),
                'sfa_pass_status' => $request->input( 's_sfa_pass_status' ),
                'salesman_image' => $salesman_image,
            );
            $result = $this->salerepo->updateSalesman( $form_credentials );

            if($result ==200){
                $message = 'Salesman Updated Successfully';
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

    public function edit($id){

        try {

            $result = $this->salerepo->findSalesman( $id );

            if(!empty($result)){
                $status = 200;
                $message = 'success';
                $result = $result; 
            }else{
                $status = 500;
                $message = 'No Data Found';
                $result = $result;
            }
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);

        } catch (\Exception $e) {

            $status = 'false';
            $result = 'Failed';
            $message = $e;

            return response()->json([
                'status'=>$status,
                'result'=>$result,
                'message'=>$message,
            ]);
        }
        
    }

    public function upload_salesman_jc_routemapping(Request $request){

        try {

            \Excel::import(new SalesmanJcRouteMapping,$request->import_file);

            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);
        }
        catch (\Exception $e) {

            $status = 'false';
            $message = $e;

            return response()->json([
                'status'=>$status,
                'message'=>$message,
            ]);
        }
    }

    public function salesmanjc_routemapping_list(Request $request){

        try {
            if($request->input( 'user_type' ) =='Admin'){

                $where=array();
                $where[] = ['status', '=', 'Active'];
        
            }elseif ($request->input( 'user_type' ) =='Distributor') {
    
                $where=array();
                $where[] = ['status', '=', 'Active'];  
                $where[] = ['distributor_code', '=', $request->input( 'distributor_code' )];
    
            }else{
                $where=array();
            }
    
            $result = $this->salerepo->getSalesmanjc_routemapping_list( $where );
            
            if(!empty($result)){
                $status = 'true';
                $message = 'success';
                $result = $result; 
            }else{
                $status = 'false';
                $message = 'No Data Found';
                $result = $result;
            }
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);

        } catch (\Execption $e) {
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

    public function get_pjp_list(Request $request){
        try {
            $get_filter_date = $request->input( 'filter_date' );
            $where=array();
            $where[] = ['from_date', '<=', $get_filter_date];
            $where[] = ['to_date', '>=', $get_filter_date];

            $result = $this->salerepo->get_pjp_jcmonth( $where );

            if(count($result) !=0){

                $get_jc_month = $result[0]->jc;
                $where_1=array();
                $where_1[] = ['s.jc_month', '=', $get_jc_month];
                $where_1[] = ['s.salesman_code', '=', $request->input( 'salesman_code' )];

                $get_result = $this->salerepo->get_pjp_details( $where_1 );
                
                if(count($get_result) !=0){

                    if(($get_result[0]->frequency) =='Monthly'){
                        
                        if($get_result[0]->monthly == $get_filter_date){

                            foreach ($get_result as $key => $value) {

                                $where_2=array();
                                $where_2[] = ['s.jc_month', '=', $get_jc_month];
                                $where_2[] = ['s.salesman_code', '=', $request->input( 'salesman_code' )];
                                $where_2[] = ['s.route_code', '=', $value->route_code];
    
                                $get_outlet_list = $this->salerepo->get_pjp_outlet_details( $where_2 );
                                
                                $outlet_list[] = array(
                                    "route_code" =>  $value->route_code,
                                    "route_name" => $value->route_name,
                                    "no_of_outlet" => $value->no_of_outlet,
                                    "outlet_array" => $get_outlet_list,
                                );
                               
    
                            }
                            
                            $status = 'true';
                            $message = 'Data Found';
                            $outlet_list = $outlet_list;
                        }else{
                            $status = 'false';
                            $message = 'No Data Found';
                            $outlet_list = [];
                        }
                    }elseif (($get_result[0]->frequency) =='Weekly') {

                        $timestamp = strtotime($get_filter_date);

                        $get_day = date('l', $timestamp);
                        
                        if($get_result[0]->weekly == $get_day){

                            foreach ($get_result as $key => $value) {

                                $where_2=array();
                                $where_2[] = ['s.jc_month', '=', $get_jc_month];
                                $where_2[] = ['s.salesman_code', '=', $request->input( 'salesman_code' )];
                                $where_2[] = ['s.route_code', '=', $value->route_code];
    
                                $get_outlet_list = $this->salerepo->get_pjp_outlet_details( $where_2 );
                                
                                $outlet_list[] = array(
                                    "route_code" =>  $value->route_code,
                                    "route_name" => $value->route_name,
                                    "no_of_outlet" => $value->no_of_outlet,
                                    "outlet_array" => $get_outlet_list,
                                );
                               
    
                            }
                            
                            $status = 'true';
                            $message = 'Data Found';
                            $outlet_list = $outlet_list;
                        }else{
                            $status = 'false';
                            $message = 'No Data Found';
                            $outlet_list = [];
                        }

                    }else{
                        
                        // $outlet_list =array();
                        // $outlet_list = array("route_code" => array(), "route_name" => array(), "no_of_outlet" => array());
                        foreach ($get_result as $key => $value) {

                            $where_2=array();
                            $where_2[] = ['s.jc_month', '=', $get_jc_month];
                            $where_2[] = ['s.salesman_code', '=', $request->input( 'salesman_code' )];
                            $where_2[] = ['s.route_code', '=', $value->route_code];

                            $get_outlet_list = $this->salerepo->get_pjp_outlet_details( $where_2 );
                            
                            $outlet_list[] = array(
                                "route_code" =>  $value->route_code,
                                "route_name" => $value->route_name,
                                "no_of_outlet" => $value->no_of_outlet,
                                "outlet_array" => $get_outlet_list,
                            );
                           

                        }
                        
                        $status = 'true';
                        $message = 'Data Found';
                        $outlet_list = $outlet_list;
                        // $jc_month = $get_jc_month; 

                    }
                }
                else{
                    $status = 'false';
                    $message = 'No Data Found';
                    $outlet_list = [];
                }
            }
            else{
                $status = 'false';
                $message = 'No Data Found';
                $outlet_list = [];
            }

            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'outlet_list'=>$outlet_list,
            ]);

        } catch (\Execption $e) {
            $status = 'false';
            $message = $e;
            $outlet_list = [];
          
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
                'jc_month'=>$jc_month,
                'get_result'=>$get_result,
            ]);
        }
    }

    public function salesman_attendance(Request $request){

        try {
                $current_date = date('Y-m-d');
                $where=array();

                if(!empty($request->input( 'from_date' )) && !empty($request->input( 'to_date' ))){

                    $where[] = ['date', '>=', $request->input( 'from_date' )];
                    $where[] = ['date', '<=', $request->input( 'to_date' )];

                }
                elseif(($request->input( 'from_date' ) !='' && $request->input( 'to_date' ) =='')){
                    $where[] = ['date', '=', $request->input( 'from_date' )];
                }
                elseif(($request->input( 'from_date' ) =='' && $request->input( 'to_date' ) !='')){
                    $where[] = ['date', '=', $request->input( 'to_date' )];
                }else{
                    $where[] = ['date', '=', $current_date];

                }
        
            
            $result = $this->salerepo->salesman_attendance( $where );
            
            if(count($result) !=0){
                $status = 'true';
                $message = 'success';
                $result = $result; 
                 
            }else{
                $status = 'false';
                $message = 'No Data Found';
                $result = $result;
            }
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
                
            ]);

        } catch (\Execption $e) {
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

    public function get_marketvisit_details($auto_id){
        try {
            $where=array();
            $where[] = ['sa_id', '=', $auto_id];

            $result = $this->salerepo->get_marketvisit_attendance_info( $where );
            
            if(count($result) !=0){
                $status = 'true';
                $message = 'success';
                $result = $result; 
                 
            }else{
                $status = 'false';
                $message = 'No Data Found';
                $result = $result;
            }
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
                
            ]);

        } catch (\Execption $e) {
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

    // 27-09
    public function mark_salesman_attendance(Request $request){

        try {
            
            $form_credentials = array(
                'salesman_code' => $request->input( 'salesman_code' ),
                'start_time' => $request->input( 'start_time' ),
                'end_time' => $request->input( 'end_time' ),
                'date' => $request->input( 'date' ),
                'attendance_type' => $request->input( 'attendance_type' ),
                'reason' => $request->input( 'reason' ),
                'remark' => $request->input( 'remark' ),
                
            );

            $check_result = $this->salerepo->check_salesman_attendance( $form_credentials );

            if($check_result ==0){
                $result = $this->salerepo->mark_salesman_attendance( $form_credentials );
            
                $form_credentials['lastid'] = $result;

                if($result !=''){
                    $status = 200;
                    $message = 'Added Successfully';
                    $result = $form_credentials;
                }else{
                    $status = 424;
                    $message = 'Request Failed';
                    $result = $form_credentials;
        
                }
            }else{
                $status = 424;
                $result = $form_credentials;

                $message = 'Attendance Already Exits';
            }

            
    
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);

        } catch (\Execption $e) {
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

    public function check_salesman_attendance(Request $request){

        try {
            
            $form_credentials = array(
                'salesman_code' => $request->input( 'salesman_code' ),
                'date' => $request->input( 'date' ),
                
            );
    
            $check_result = $this->salerepo->check_salesman_attendance( $form_credentials );
    
                if($check_result ==0){
    
                    $status = 200;
                    $message = 'No Record Found';
    
                }
                elseif ($check_result !=0) {
                    $status = 201;
                    $message = 'Record Found';
                }
                else{
                    $status = 424;
                    $message = 'Failed message';
                }
    
                return response()->json([
                    'status'=>$status,
                    'message'=>$message,
                ]);

        } catch (\Execption $e) {
            $status = 424;
            $message = $e;
          
            return response()->json([
                'status'=>$status,
                'message'=>$message,
            ]);
        }
        

    }

    public function mark_salesman_market_attendance(Request $request){

        try {
            
            $form_credentials = array(
                'sa_id' => $request->input( 'sa_id' ),
                'salesman_code' => $request->input( 'salesman_code' ),
                'customer_code' => $request->input( 'customer_code' ),
                'start_time' => $request->input( 'start_time' ),
                'end_time' => $request->input( 'end_time' ),
                'date' => $request->input( 'date' ),
                'no_sale_reason' => $request->input( 'no_sale_reason' ),
                'current_market_hours' => $request->input( 'current_market_hours' ),
                
            );
            $result = $this->salerepo->mark_salesman_market_attendance( $form_credentials );
            
            $form_credentials['lastid'] = $result;

            if($result !=''){
                $status = 200;
                $message = 'Added Successfully';
                $result = $form_credentials;
            }else{
                $status = 424;
                $message = 'Request Failed';
                $result = $form_credentials;
    
            }
    
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);

        } catch (\Execption $e) {
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

    public function update_salesman_attendance(Request $request){
        try {
            
            $form_credentials = array(
                'auto_id' => $request->input( 'auto_id' ),
                'end_time' => $request->input( 'end_time' ),
                'total_market_hours' => $request->input( 'total_market_hours' ),
                'total_login_hours' => $request->input( 'total_login_hours' ),
                
                
            );
             $result = $this->salerepo->update_salesman_attendance( $form_credentials );
            
            if($result ==200){
                $status = 200;
                $message = 'Added Successfully';
            }else{
                $status = 424;
                $message = 'Request Failed';
    
            }
    
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);

        } catch (\Execption $e) {
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
    // ganaga


    // app 22 aug
    //salesman login
    public function salesman_login(Request $request){
        $login_credentials = array(
            'username' => $request->input( 'username' ),
            'password' => $request->input( 'password' )
        );
        $result = $this->salerepo->loginSalesman( $login_credentials );
        return $result;   
    }

    
    // app 22 aug end

    // app 26
    public function salesman_day_summary(Request $request){
        // $result = $this->salerepo->salesman_day_summary( $request->salesman_code  );
            // return $result;
        try {
        $result = $this->salerepo->salesman_day_summary( $request->salesman_code  );
                if(!empty($result)){
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

    public function salesman_target_achieved(Request $request){
        try {
            $result = $this->salerepo->salesman_target_achieved( $request->salesman_code  );
                if(!empty($result)){
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

    
}
