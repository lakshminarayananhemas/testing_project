<?php 

namespace App\Repositories\Salesman;


use App\Models\Salesman_info;
use App\Models\Salesman;
use DB;
use App\Models\orders;
use App\Models\Salesman_attendance;
use App\Models\Salesman_marketvisit_attendance;

class SalesmanRepository implements ISalesmanRepository
{
    public function getSalesman($where){

        $result = DB::table('salesman_infos')
        ->select('*')
        ->where($where)
        ->get();

        return $result;
    }


    public function storeSalesman( $form_credentials ){
        $input = new Salesman_info;
        $input->distributor_code = $form_credentials['distributor_code'];
        $input->distributor_branch_code = $form_credentials['distributor_branch_code'];
        $input->salesman_name = $form_credentials['salesman_name'];
        $input->email_id = $form_credentials['email_id'];
        $input->phone_no = $form_credentials['phone_no'];
        $input->daily_allowance = $form_credentials['daily_allowance'];
        $input->salary = $form_credentials['salary'];
        $input->status = $form_credentials['status'];
        $input->salesman_code = 'SC'.str_pad( ( $input->max( 'id' )+1 ), 6, '0', STR_PAD_LEFT );
        $input->dob = $form_credentials['dob'];
        $input->doj = $form_credentials['doj'];
        $input->password = $form_credentials['password'];
        $input->salesman_type = $form_credentials['salesman_type'];
        $input->sm_unique_code = $form_credentials['sm_unique_code'];
        $input->third_party_empcode = $form_credentials['third_party_empcode'];
        $input->replacement_for = $form_credentials['replacement_for'];
        $input->attach_company = $form_credentials['attach_company'];
        $input->sales_type = $form_credentials['sales_type'];
        $input->godown_status = $form_credentials['godown_status'];
        
        $input->aadhaar_no = $form_credentials['aadhaar_no'];
        $input->sfa_status = $form_credentials['sfa_status'];
        $input->device_no = $form_credentials['device_no'];
        $input->sfa_pass_status = $form_credentials['sfa_pass_status'];
        $input->salesman_image = $form_credentials['salesman_image'];
        $input->save();

        if($input) { 
            return 200;
        } else {
            return 424;
        }
    }

    public function updateSalesman( $form_credentials ){

        $result = new Salesman_info();
        $result = $result->where( 'id', '=', $form_credentials['id'] );
        
        $result->update( [ 
            'distributor_code' => $form_credentials['distributor_code'],
            'distributor_branch_code' => $form_credentials['distributor_branch_code'],
            'salesman_name' => $form_credentials['salesman_name'],
            'email_id' => $form_credentials['email_id'],
            'phone_no' => $form_credentials['phone_no'],
            'daily_allowance' => $form_credentials['daily_allowance'],
            'salary' => $form_credentials['salary'],
            'status' => $form_credentials['status'],
            'salesman_code' => $form_credentials['salesman_code'],
            'dob' => $form_credentials['dob'],
            'doj' => $form_credentials['doj'],
            'password' => $form_credentials['password'],
            'salesman_type' => $form_credentials['salesman_type'],
            'sm_unique_code' => $form_credentials['sm_unique_code'],
            'third_party_empcode' => $form_credentials['third_party_empcode'],
            'replacement_for' => $form_credentials['replacement_for'],
            'attach_company' => $form_credentials['attach_company'],
            'sales_type' => $form_credentials['sales_type'],
            'godown_status' => $form_credentials['godown_status'],
            'aadhaar_no' => $form_credentials['aadhaar_no'],
            'sfa_status' => $form_credentials['sfa_status'],
            'device_no' => $form_credentials['device_no'],
            'sfa_pass_status' => $form_credentials['sfa_pass_status'],
            'salesman_image' => $form_credentials['salesman_image'],
        ] );

        if($result) {
            return 200;
        } else {
            return 424;
        }
    }

    public function deleteSalesman( $id ){

        $result = DB::table('salesman_infos')->where('id', $id)->delete();

        if($result) {
            return 200;
        } else {
            return 424;
        }
    }

    public function findSalesman( $id ){
        $result = DB::table('salesman_infos as s')
        ->select('s.*')
        ->where('s.id',$id)
        ->get();

        return $result;
    }

    public function fetch_salesman_route_list($data){
        
        $record=  DB::table('salesman_route_mappings as smrt')
        ->join('routes as route', 'route.route_code','=','smrt.route_code')
        ->join('salesman_infos as sm', 'sm.salesman_code','=','smrt.salesman_code')
        ->select('smrt.*','route.*','sm.*')
        ->where('sm.distributor_code',$data['distributor_code'])
        ->orderBy('smrt.created_at', 'desc' )
        ->get();
        return $record;
    }

    public function getSalesmanjc_routemapping_list($where){

        $result = DB::table('salesman_jc_route_mappings')
        ->select('*')
        ->where($where)
        ->get();

        return $result;
    }

    public function get_marketvisit_attendance_info( $where ){

        $result = DB::table('salesman_marketvisit_attendances')
        ->select('*')
        ->where($where)
        ->get();

        return $result;
    }

    public function get_pjp_jcmonth( $where ){

        $result = DB::table('altec_jc_calendars')
        ->select('*')
        ->where($where)
        ->groupBy('jc')
        ->get();

        return $result;
    }

    public function get_pjp_details( $where ){

        $result = DB::table('salesman_jc_route_mappings as s')
        ->join('routes as r', 'r.route_code','=','s.route_code')
        ->select('s.*','r.route_name',DB::raw('count(s.customer_code) as no_of_outlet'),)
        ->where($where)
        ->groupBy('s.route_code')
        ->get();

        return $result;
    }

    public function get_pjp_outlet_details( $where ){
        $result = DB::table('salesman_jc_route_mappings as s')
        ->leftjoin('routes as r', 'r.route_code','=','s.route_code')
        ->leftjoin('customer_generals as cg', 'cg.cg_customer_code','=','s.customer_code')
        ->select('s.distributor_code','s.customer_code','s.route_code','s.frequency','r.route_name','cg.cg_customer_name')
        ->where($where)
        ->get();

        return $result;
    }




    public function salesman_attendance($where){

        $result = DB::table('salesman_attendances')
        ->select('*')
        ->where($where)
        ->get();

        return $result;
    }

    // app
    public function loginSalesman($login_credentials){
        if (Salesman_info::where([
            ['phone_no', '=', $login_credentials['username']],
        ])->count() > 0) {
        $result = Salesman_info::where([
            ['phone_no', '=', $login_credentials['username']],
            ['password', '=', $login_credentials['password']]
        ])->first();
        if($result === null) 
        {
            $status='false';
            $message='Please check the login credentials';
            $result=response()->json(null);
        }
        else{
            $status='true';
            $message='success';
            $result=$result;
        }   
        }
        else{
            $status='false';
            $message='User not found';
            $result= response()->json(null); 
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message,
            'result'=>$result,
        ]);
    }
    // app end

    // 26 -09
    public function salesman_day_summary($id){
        $today = date('Y-m-d');
        $salesman_info = DB::table('salesman_infos')
                            ->where('salesman_code',$id)
                            ->first();
        $total_order_values = DB::table('orders')
                                ->select(DB::raw("SUM(orders.total_amount) as total_value"),'orders.salesman_code')
                                ->where('orders.salesman_code',$id)
                                ->whereDate('orders.created_at',$today)
                                ->groupBy('orders.salesman_code')
                                ->first();
        $customer_list = DB::table('customer_generals as cg')
                                ->where('cg.cg_salesman_code','=',$id)
                                ->pluck('cg_customer_code');
        $taken_count = orders::leftJoin('customer_generals as cg','cg.cg_customer_code','=','orders.customer_code')
                                ->select(DB::raw('COUNT(cg.cg_customer_code) as taken_count'))
                                ->whereIn('orders.customer_code',$customer_list)
                                ->whereDate('orders.created_at', $today)
                                ->groupBy('orders.customer_code')
                                ->count();
        $not_taken_count = count($customer_list) - $taken_count;
        $new_customer_count = DB::table('customer_generals as cg')
                                ->select(DB::raw('COUNT(cg.id) as new_outlet_count'))
                                ->where('cg.cg_salesman_code','=',$id)
                                ->whereDate('cg.created_at','=',$today)
                                ->first();   
        $item_count = DB::table('ordered_items')
                            ->leftJoin('orders as o','o.order_id','=','ordered_items.order_id')
                            ->select(DB::raw('COUNT(ordered_items.order_id) as item_count'))
                            ->where('o.salesman_code',$id)
                            ->whereDate('o.created_at', $today)
                            ->first();
        $salable_count = DB::table('sales_returns as sr')
                                ->leftJoin('sales_return_items as sri','sri.sales_return_id','=','sr.sales_return_id')
                                ->select(DB::raw('COUNT(sri.id) as salable_count'))
                                ->whereDate('sr.created_at', $today)
                                ->whereIn('sr.customer_code',$customer_list)
                                ->where('sri.return_type','=','Saleable Return')
                                ->first();
        $unsalable_count = DB::table('sales_returns as sr')
                                ->leftJoin('sales_return_items as sri','sri.sales_return_id','=','sr.sales_return_id')
                                ->select(DB::raw('COUNT(sri.id) as unsalable_count'))
                                ->whereDate('sr.created_at', $today)
                                ->whereIn('sr.customer_code',$customer_list)
                                ->where('sri.return_type','=','Unsaleable Return')
                                ->first();
        $coverage_outlet_count = DB::table('customer_generals as cg')
                                ->select(DB::raw('COUNT(cg.id) as coverage_outlet_count'))
                                ->where('cg.cg_salesman_code','=',$id)
                                ->whereDate('cg.updated_at','=',$today)
                                ->first(); 
        $coverage_outlet = $coverage_outlet_count->coverage_outlet_count.'/'.count($customer_list);
        
        $productivity_outlet_count = DB::table('orders')
                                        ->select('orders.customer_code')
                                        ->groupBy('customer_code')
                                        ->where('salesman_code','=',$id)
                                        ->whereDate('created_at','=',$today)
                                        ->get();            
        $productivity_outlet = count($productivity_outlet_count).'/'.$coverage_outlet_count->coverage_outlet_count;
        
        if(count($customer_list) > 0){
            $calc = $coverage_outlet_count->coverage_outlet_count / count($customer_list);
            $calc1 = $calc * 100;
            $coverage_percentage = number_format($calc1, 0);
            // $coverage_percentage = $calc1;
        }else{
            $coverage_percentage = 0;
        }

        if($coverage_outlet_count->coverage_outlet_count > 0){
            $calc = count($productivity_outlet_count) / $coverage_outlet_count->coverage_outlet_count;
            $calc1 = $calc * 100;
            $productivity_percentage = number_format($calc1, 0);
            // $productivity_percentage = $calc1;
        }else{
            $productivity_percentage = 0;
        } 

            if(!empty($total_order_values)){
                $total_order_value = $total_order_values->total_value;
            }else{
                $total_order_value = 0;
            }
            if(!empty($salesman_info)){
                    $result['total_order_value'] = $total_order_value; 
                    $result['total_order_taken'] = $taken_count; 
                    $result['total_order_not_taken'] = $not_taken_count; 
                    $result['total_order_item_taken'] = $item_count->item_count; 
                    $result['total_new_outlet_count'] = $new_customer_count->new_outlet_count;
                    $result['salable_count'] = $salable_count->salable_count; 
                    $result['unsalable_count'] = $unsalable_count->unsalable_count; 
                    $result['coverage_outlet_count'] = $coverage_outlet_count->coverage_outlet_count; 
                    $result['coverage_outlet'] = $coverage_outlet; 
                    $result['productivity_outlet_count'] = count($productivity_outlet_count); 
                    $result['productivity_outlet'] = $productivity_outlet;
                    $result['productivity_percentage'] = $productivity_percentage;
                    $result['coverage_percentage'] = $coverage_percentage;
                return $result; 
            }else{
                    $result = [];
                return $result;
            }
    }


    public function salesman_target_achieved($id){
        $today = date('Y-m-d');
        $customer_list = DB::table('customer_generals as cg')
                                    ->where('cg.cg_salesman_code','=',$id)
                                    ->pluck('cg_customer_code');

        $jc_info = DB::table('altec_jc_calendars')
                            ->select('*')
                            ->whereRaw('? between from_date and to_date', [date('Y-m-d')])
                            ->first();
        $jc_start_row = DB::table('altec_jc_calendars')
                            ->select('*')
                            ->where('jc', $jc_info->jc)
                            ->orderBy('jc_week_num','asc')->first();
        $target_info = DB::table('target_uploads')
                            ->where('employee_code',$id)
                            ->where('jc_period',$jc_start_row->jc)->first();
        $salesman_achieved = DB::table('orders')
                        ->select(DB::raw("SUM(orders.total_amount) as total_value"),'salesman_code')
                        // ->where('orders.status','Approved')
                        ->where('salesman_code', $id)
                        ->whereBetween('created_at', [$jc_start_row->from_date, $today])
                        ->groupBy('orders.salesman_code')
                        ->first();
        $outlet_list = DB::table('customer_generals as cg')
                            ->leftJoin('orders as o','cg.cg_customer_code','=','o.customer_code')
                            ->leftJoin('target_uploads as tu','cg.cg_customer_code','=','tu.employee_code')
                            ->select(DB::raw("SUM(o.total_amount) as achieved_amount"),'cg.cg_customer_code','tu.target_amount','cg.cg_customer_name')
                            ->where('cg.cg_salesman_code',$id)
                            ->where('tu.jc_period',$jc_start_row->jc)
                            ->whereBetween('o.created_at', [$jc_start_row->from_date, $today])
                            ->groupBy('o.customer_code')
                            ->get();
        $cust_list =[];
        foreach ($customer_list as $key => $value) {
            $cust_info = DB::table('customer_generals')
                                ->select('cg_customer_name','cg_customer_code')
                                ->where('cg_customer_code',$value)
                                ->first();
            $cust_target = DB::table('target_uploads')
                                ->where('employee_code',$value)
                                ->where('jc_period',$jc_start_row->jc)
                                ->first();
            $cust_achieve = DB::table('orders')
                                ->select(DB::raw("SUM(total_amount) as achieved_amount"))
                                ->whereBetween('created_at', [$jc_start_row->from_date, $today])
                                // ->where('orders.status','Approved')
                                ->where('customer_code',$value)
                                ->groupBy('customer_code')
                                ->first();
            if(!empty($cust_target)){
                $target = $cust_target->target_amount;
            }else{
                $target = 0;
            }
            if(!empty($cust_achieve)){
                $achieved = $cust_achieve->achieved_amount;
            }else{
                $achieved = 0;
            }
            $test1=[
                    "customer_code"=> $cust_info->cg_customer_code,
                    "customer_name"=> $cust_info->cg_customer_name,
                    "customer_target"=> $target,
                    "customer_achieved" => $achieved,
                    ];
            array_push($cust_list,$test1);
        }

        if((!empty($salesman_achieved->total_value))&&(!empty($target_info->target_amount))){
            $achieved_amount = $salesman_achieved->total_value;
            $target_amount = $target_info->target_amount;
            if($target_amount > 0){
                $calc = $achieved_amount / $target_amount;
                $calc1 = $calc * 100;
                $perc_cal = number_format($calc1, 0);
                //$perc_cal = $calc1;
            }else{
                $perc_cal = 0;
            } 
        }else{
            // $achieved_amount = 0;

            $perc_cal = 0;
        }

        if(!empty($salesman_achieved->total_value)){
            $achieved_amount = $salesman_achieved->total_value;
        }else{
            $achieved_amount = 0;
        }

        if(!empty($target_info->target_amount)){
            $target_amount = $target_info->target_amount;
        }else{
            $target_amount = 0;
        }

        $result['outlet_list'] = $cust_list; 
        $result['target_info'] = $target_amount; 
        $result['achieved_info'] = $achieved_amount;
        $result['achieved_per'] = $perc_cal;
        return $result; 
    }

    // 27-09
    public function mark_salesman_attendance( $form_credentials ){
        $input = new Salesman_attendance;
        $input->auto_id = 'SAD'.str_pad( ( $input->max( 'id' )+1 ), 9, '0', STR_PAD_LEFT );;
        $input->salesman_code = $form_credentials['salesman_code'];
        $input->start_time = $form_credentials['start_time'];
        $input->end_time = $form_credentials['end_time'];
        $input->date = $form_credentials['date'];
        $input->attendance_type = $form_credentials['attendance_type'];
        $input->reason = $form_credentials['reason'];
        $input->remark = $form_credentials['remark'];
        $input->save();

        $lastInsertedId = $input->auto_id;


        if($input) { 
            return $lastInsertedId;
        } else {
            $lastInsertedId ='';
            return $lastInsertedId;
        }
    }

    public function check_salesman_attendance( $form_credentials ){
        $result = DB::table('salesman_attendances as sa')
        ->select('sa.*')
        ->where('sa.salesman_code',  '=', $form_credentials['salesman_code'])
        ->where('sa.date',  '=', $form_credentials['date'])
        ->count();

        return $result;
    }

    public function mark_salesman_market_attendance( $form_credentials ){
        
        $input = new Salesman_marketvisit_attendance;
        $input->auto_id = 'SMAD'.str_pad( ( $input->max( 'id' )+1 ), 9, '0', STR_PAD_LEFT );;
        $input->sa_id = $form_credentials['sa_id'];
        $input->salesman_code = $form_credentials['salesman_code'];
        $input->customer_code = $form_credentials['customer_code'];
        $input->start_time = $form_credentials['start_time'];
        $input->end_time = $form_credentials['end_time'];
        $input->date = $form_credentials['date'];
        $input->current_market_hours = $form_credentials['current_market_hours'];
        $input->no_sale_reason = $form_credentials['no_sale_reason'];
        $input->save();

        $lastInsertedId = $input->auto_id;


        if($input) { 
            return $lastInsertedId;
        } else {
            $lastInsertedId ='';
            return $lastInsertedId;
        }

    }
    public function update_salesman_attendance( $form_credentials ){

        if (Salesman_attendance::where([
            ['auto_id', '=', $form_credentials['auto_id']],
        ])->count() > 0) {
            $result = new Salesman_attendance();
            $result = $result->where( 'auto_id', '=', $form_credentials['auto_id'] );
            
            $result->update( [ 
                'end_time' => $form_credentials['end_time'],
                'total_market_hours' => $form_credentials['total_market_hours'],
                'total_login_hours' => $form_credentials['total_login_hours'],
                
            ] );

            return 200;
        }else{
            return 424;
        }


       

     
    }

}