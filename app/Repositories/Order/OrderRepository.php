<?php 
namespace App\Repositories\Order;

use DB;
use App\Models\orders;

class OrderRepository implements IOrderRepository
{

    public function get_orderitem_list($where){

        $results = DB::table('ordered_items')
        ->select('*')
        ->where($where) 
        ->get();

        return $results;

    }

    public function get_order_list($where)
    {
        $results = DB::table('orders')
        ->select('*')
        ->where($where) 
        ->get();
        return $results;
    }

    // Leelavinothan
    // 26/09

    public function previous_orders($data){
        $array = orders::leftJoin('customer_generals as cg','cg.cg_customer_code','=','orders.customer_code')
                        ->join('ordered_items as oi','oi.order_id','=','orders.order_id')
                        ->select('oi.*')
                        ->where('orders.salesman_code','=',$data['salesman_code'])
                        ->where('orders.customer_code','=',$data['customer_code'])
                        ->where('orders.distributor_code','=',$data['distributor_code'])
                        ->orderBy('oi.created_at','DESC')
                        ->take(15)
                        ->get()->toArray();
        $distributor_info = DB::table('distributors')
                                ->where('distributor_code',$data['distributor_code'])->first();
        $salesman_info = DB::table('salesman_infos')
                                ->where('salesman_code',$data['salesman_code'])->first();
        $customer_info = DB::table('customer_generals')
                                ->where('cg_customer_code',$data['customer_code'])->first();
        if(empty($distributor_info)){
            $result['message'] = "No Distributor found";
        }else if(empty($salesman_info)){
            $result['message'] = "No Salesman found";
        }else if(empty($customer_info)){
            $result['message'] = "No Customer found";
        }else{            
            $result['message'] = "success";
            $result['ord'] = $array;
        }
        return $result;
    }

    public function all_status_orders($data){
        $pending_count = orders::leftJoin('customer_generals as cg','cg.cg_customer_code','=','orders.customer_code')
                            ->select('orders.customer_code','orders.distributor_code','orders.order_id as invoice_no','orders.signature','orders.total_amount','orders.tax_amount','orders.discount','orders.status','orders.created_at as invoice_date','cg.cg_customer_name as custName')
                            ->where('orders.distributor_code',$data['distributor_code'])
                            ->where('orders.salesman_code',$data['salesman_code'])
                            ->where('orders.status','Pending')
                            ->orderBy('orders.created_at','DESC')
                            ->count();
        if($pending_count > 0 ){
            $pending_orders = orders::leftJoin('customer_generals as cg','cg.cg_customer_code','=','orders.customer_code')
                            ->select('orders.customer_code','orders.distributor_code','orders.order_id as invoice_no','orders.signature','orders.total_amount','orders.tax_amount','orders.discount','orders.status','orders.created_at as invoice_date','cg.cg_customer_name as custName')
                            ->where('orders.distributor_code',$data['distributor_code'])
                            ->where('orders.salesman_code',$data['salesman_code'])
                            ->where('orders.status','Pending')
                            ->orderBy('orders.created_at','DESC')
                            ->get()->toArray();
            $pending_total1 = orders::leftJoin('customer_generals as cg','cg.cg_customer_code','=','orders.customer_code')
                                    ->select(DB::raw("SUM(orders.total_amount) as pending_total"),'orders.distributor_code')
                                    ->where('orders.salesman_code',$data['salesman_code'])
                                    ->where('orders.distributor_code',$data['distributor_code'])
                                    ->where('orders.status','Pending')
                                    ->groupBy('orders.distributor_code')
                                    ->first();
            $pending_total = $pending_total1->pending_total;
        }else{
            $pending_total = 0;
            $pending_orders = [];
        }
        $pending_array['pending_count']=$pending_count;
        $pending_array['pending_total']=$pending_total;
        $pending_array['pending_orders']=$pending_orders;
        $approved_count = orders::leftJoin('customer_generals as cg','cg.cg_customer_code','=','orders.customer_code')
                            ->select('orders.customer_code','orders.distributor_code','orders.order_id as invoice_no','orders.signature','orders.total_amount','orders.tax_amount','orders.discount','orders.status','orders.created_at as invoice_date','cg.cg_customer_name as custName')
                            ->where('orders.salesman_code',$data['salesman_code'])
                            ->where('orders.distributor_code',$data['distributor_code'])
                            ->where('orders.status','Approved')
                            ->orderBy('orders.created_at','DESC')
                            ->count();
        if($approved_count > 0 ){
            $approved_orders = orders::leftJoin('customer_generals as cg','cg.cg_customer_code','=','orders.customer_code')
                            ->select('orders.customer_code','orders.distributor_code','orders.order_id as invoice_no','orders.signature','orders.total_amount','orders.tax_amount','orders.discount','orders.status','orders.created_at as invoice_date','cg.cg_customer_name as custName')
                            ->where('orders.salesman_code',$data['salesman_code'])
                            ->where('orders.distributor_code',$data['distributor_code'])
                            ->where('orders.status','Approved')
                            ->orderBy('orders.created_at','DESC')
                            ->get()->toArray();
            $at = orders::leftJoin('customer_generals as cg','cg.cg_customer_code','=','orders.customer_code')
                                ->select(DB::raw("SUM(orders.total_amount) as approved_total"),'orders.customer_code')
                                ->where('orders.salesman_code',$data['salesman_code'])
                                ->where('orders.distributor_code',$data['distributor_code'])
                                ->where('orders.status','Approved')
                                ->groupBy('orders.customer_code')
                                ->first();
            $approved_total = $at->approved_total;
        }else{
            $approved_total = 0;
            $approved_orders = [];
        }
        $approved_array['approved_count']=$approved_count;
        $approved_array['approved_total']=$approved_total;
        $approved_array['approved_orders']=$approved_orders;
        $rejected_count = orders::leftJoin('customer_generals as cg','cg.cg_customer_code','=','orders.customer_code')
                            ->select('orders.customer_code','orders.distributor_code','orders.order_id as invoice_no','orders.signature','orders.total_amount','orders.tax_amount','orders.discount','orders.status','orders.created_at as invoice_date','cg.cg_customer_name as custName')
                            ->where('orders.salesman_code',$data['salesman_code'])
                            ->where('orders.distributor_code',$data['distributor_code'])
                            ->where('orders.status','Declined')
                            ->orderBy('orders.created_at','DESC')
                            ->count();
        if($rejected_count > 0 ){
            $rejected_orders = orders::leftJoin('customer_generals as cg','cg.cg_customer_code','=','orders.customer_code')
                                    ->select('orders.customer_code','orders.distributor_code','orders.order_id as invoice_no','orders.signature','orders.total_amount','orders.tax_amount','orders.discount','orders.status','orders.created_at as invoice_date','cg.cg_customer_name as custName')
                                    ->where('orders.salesman_code',$data['salesman_code'])
                                    ->where('orders.distributor_code',$data['distributor_code'])
                                    ->where('orders.status','Declined')
                                    ->orderBy('orders.created_at','DESC')
                                    ->get()->toArray();
            $rt = orders::leftJoin('customer_generals as cg','cg.cg_customer_code','=','orders.customer_code')
                                ->select(DB::raw("SUM(orders.total_amount) as rejected_total"),'orders.customer_code')
                                ->where('orders.salesman_code',$data['salesman_code'])
                                ->where('orders.distributor_code',$data['distributor_code'])
                                ->where('orders.status','Declined')
                                ->groupBy('orders.customer_code')
                                ->first();
            $rejected_total = $rt->rejected_total;
        }else{
            $rejected_total = 0;
            $rejected_orders = [];
        }
        $rejected_array['rejected_total']=$rejected_total;
        $rejected_array['rejected_orders']=$rejected_orders;
        $distributor_info = DB::table('distributors')
                                ->where('distributor_code',$data['distributor_code'])->first();
        $salesman_info = DB::table('salesman_infos')
                                ->where('salesman_code',$data['salesman_code'])->first();
        if(empty($distributor_info)){
            $result['message'] = "No Distributor found";
        }else if(empty($salesman_info)){
            $result['message'] = "No Salesman found";
        }else{
            $result['Pending'] = $pending_array;
            $result['Approved'] = $approved_array;
            $result['Rejected'] = $rejected_array;
            $result['message'] = "success";
        }
        return $result;
    }
    
    public function current_last_month_sales($data){
        $lm = date('m', strtotime(date('Y-m') . " -1 month"));
        $cm = date('m');
        $y = date('Y');
        $datas = DB::table('orders')
                    ->leftJoin('customer_generals', 'cg_customer_code', '=', 'orders.customer_code')
                    ->select(
                        'orders.customer_code as custCode',
                        'cg_customer_name as custName',
                        DB::raw("SUM(orders.total_amount) as current_month_total")
                    )
                    ->whereMonth('orders.created_at', $cm)
                    ->whereYear('orders.created_at', $y)
                    ->where('salesman_code', $data['salesman_code'])
                    ->groupBy('orders.customer_code', 'customer_generals.cg_customer_name')
                    ->get()->toArray();
        $last_datas = DB::table('orders')
                        ->leftJoin('customer_generals', 'cg_customer_code', '=', 'orders.customer_code')
                        ->select(
                            'orders.customer_code as custCode',
                            'cg_customer_name as custName',
                            DB::raw("SUM(orders.total_amount) as last_month_total")
                        )
                        ->whereMonth('orders.created_at', $lm)
                        ->whereYear('orders.created_at', $y)
                        ->where('salesman_code', $data['salesman_code'])
                        ->groupBy('orders.customer_code', 'customer_generals.cg_customer_name')
                        ->get()->toArray();
        $salesman_customer_list = DB::table('customer_generals')
                                    ->where('cg_salesman_code', $data['salesman_code'])
                                    ->select('cg_customer_code','cg_customer_name')->get()->toArray();
        $currentandlastmonth=[];
        if(!empty($datas)){
            foreach ($datas as $key => $value) {
                $check=DB::table('orders')->where('customer_code',$value->custCode)
                            ->whereMonth('orders.created_at', $lm)
                            ->whereYear('orders.created_at', $y)
                            ->where('salesman_code', $data['salesman_code'])
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
            foreach ($salesman_customer_list as $key => $value) {
                $combine=[
                    "custCode"=> $value->cg_customer_code,
                    "custName"=> $value->cg_customer_name,
                    "current_month_total"=> 0,
                    'last_monnth_total'=> 0
                ];
                array_push($currentandlastmonth,$combine);
            }
        }
        return $currentandlastmonth;        
    }

    // 

    

    public function get_current_jc_route_details($where){

        $result = DB::table('salesman_jc_route_mappings as s')
        ->leftjoin('routes as r', 'r.route_code','=','s.route_code')
        ->leftjoin('customer_generals as cg', 'cg.cg_customer_code','=','s.customer_code')
        ->select('s.*','r.route_name')
        ->where($where)
        ->groupBy("s.route_code")
        ->get();

        return $result;
    }

   
    public function get_current_jc_customer_byroute($where){
        $result = DB::table('salesman_jc_route_mappings as s')
        ->leftjoin('routes as r', 'r.route_code','=','s.route_code')
        ->leftjoin('customer_generals as cg', 'cg.cg_customer_code','=','s.customer_code')
        ->select('s.*','r.route_name')
        ->where($where)
        // ->groupBy("s.route_code")
        ->get();

        return $result;
    }


    public function get_customer_frequency($where){
        $result = DB::table('salesman_jc_route_mappings as s')
        ->leftjoin('routes as r', 'r.route_code','=','s.route_code')
        ->leftjoin('customer_generals as cg', 'cg.cg_customer_code','=','s.customer_code')
        ->select('s.*','r.route_name')
        ->where($where)
        // ->groupBy("s.route_code")
        ->get();

        return $result;
    }

    public function salesman_marketvisit_coverage($form_credentials){
        $result = DB::table('salesman_marketvisit_attendances as sma')
        ->select('sma.*')
        // ->where('sma.distributor_code','=', $form_credentials['distributor_code']) 
        ->where('sma.salesman_code','=', $form_credentials['salesman_code']) 
        ->where('sma.customer_code', $form_credentials['customer_code'])
        ->where('sma.date','>=', $form_credentials['from_created_at']) 
        ->where('sma.date','<=', $form_credentials['to_created_at']) 
        // ->groupBy("o.status")
        ->count();

        return $result;
    }

    public function salesman_sales_return_count($form_credentials){
        $result = DB::table('sales_returns')
        ->select('*')
        ->where('distributor_code','=', $form_credentials['distributor_code']) 
        ->where('salesman_code','=', $form_credentials['salesman_code']) 
        ->where('customer_code', $form_credentials['customer_code'])
        ->whereDate('created_at','>=', $form_credentials['from_created_at']) 
        ->whereDate('created_at','<=', $form_credentials['to_created_at']) 
        ->count();

        return $result;
    }

    public function get_jc_route_billed_outlet($form_credentials ){
        $result = DB::table('orders as o')
        ->leftjoin('customer_generals as cg', 'o.customer_code','=','cg.cg_customer_code')
        ->leftjoin('customer_coverage_attributes as ca', 'ca.cg_id','=','cg.auto_id')
        ->leftjoin('target_uploads as tu', 'tu.employee_code','=','cg.cg_customer_code')

        ->select('o.*','cg.cg_distance','ca.ca_channel','ca.ca_subchannel','ca.ca_group','ca.ca_class','tu.target_amount','cg.auto_id','cg.cg_customer_name','cg.cg_customer_name','cg.cg_latitude','cg.cg_longitude','cg.otpStatus' )
        ->where('o.distributor_code','=', $form_credentials['distributor_code']) 
        ->where('o.salesman_code','=', $form_credentials['salesman_code']) 
        ->where('cg.ca_approval_status','=', $form_credentials['ca_approval_status']) 
        ->whereDate('o.created_at','>=', $form_credentials['from_created_at']) 
        ->whereDate('o.created_at','<=', $form_credentials['to_created_at']) 
        ->whereIN('o.customer_code', $form_credentials['customer_code'])
        ->groupBy("o.customer_code")
        ->get();

        return $result;
    }

    public function get_jc_customer_order_details($form_credentials ){
        $result = DB::table('orders as o')
        ->leftjoin('customer_generals as cg', 'o.customer_code','=','cg.cg_customer_code')
        ->leftjoin('customer_coverage_attributes as ca', 'ca.cg_id','=','cg.auto_id')
        ->leftjoin('target_uploads as tu', 'tu.employee_code','=','cg.cg_customer_code')

        ->select('o.*','cg.cg_distance','ca.ca_channel','ca.ca_subchannel','ca.ca_group','ca.ca_class','tu.target_amount','cg.auto_id','cg.cg_customer_name','cg.cg_customer_name','cg.cg_latitude','cg.cg_longitude','cg.otpStatus' )
        ->where('o.distributor_code','=', $form_credentials['distributor_code']) 
        ->where('o.salesman_code','=', $form_credentials['salesman_code']) 
        ->where('cg.ca_approval_status','=', $form_credentials['ca_approval_status']) 
        ->whereDate('o.created_at','>=', $form_credentials['from_created_at']) 
        ->whereDate('o.created_at','<=', $form_credentials['to_created_at']) 
        ->whereIN('o.customer_code', $form_credentials['customer_code'])
        // ->groupBy("o.status")
        ->get();

        return $result;
    }
    
    public function get_jc_customer_order_details_status($form_credentials){
        $result = DB::table('orders as o')
        ->leftjoin('customer_generals as cg', 'o.customer_code','=','cg.cg_customer_code')
        ->leftjoin('customer_coverage_attributes as ca', 'ca.cg_id','=','cg.auto_id')
        ->leftjoin('target_uploads as tu', 'tu.employee_code','=','cg.cg_customer_code')

        ->select('o.*','cg.cg_distance','ca.ca_channel','ca.ca_subchannel','ca.ca_group','ca.ca_class','tu.target_amount','cg.auto_id','cg.cg_customer_name','cg.cg_customer_name','cg.cg_latitude','cg.cg_longitude','cg.otpStatus' )
        ->where('o.distributor_code','=', $form_credentials['distributor_code']) 
        ->where('o.salesman_code','=', $form_credentials['salesman_code']) 
        ->where('o.status','=', $form_credentials['status']) 
        ->whereDate('o.created_at','>=', $form_credentials['from_created_at']) 
        ->whereDate('o.created_at','<=', $form_credentials['to_created_at']) 
        ->whereIN('o.customer_code', $form_credentials['customer_code'])
        // ->groupBy("o.status")
        ->get();

        return $result;
    }

    public function get_jc_customer_app_order($form_credentials ){
        $result = DB::table('orders as o')
        ->leftjoin('customer_generals as cg', 'o.customer_code','=','cg.cg_customer_code')
        ->leftjoin('customer_coverage_attributes as ca', 'ca.cg_id','=','cg.auto_id')
        ->leftjoin('target_uploads as tu', 'tu.employee_code','=','cg.cg_customer_code')

        ->select('o.*','cg.cg_distance','ca.ca_channel','ca.ca_subchannel','ca.ca_group','ca.ca_class','tu.target_amount','cg.auto_id','cg.cg_customer_name','cg.cg_customer_name','cg.cg_latitude','cg.cg_longitude','cg.otpStatus' )
        ->where('o.distributor_code','=', $form_credentials['distributor_code']) 
        ->where('o.salesman_code','=', $form_credentials['salesman_code']) 
        ->where('o.status','=', $form_credentials['status']) 
        ->where('cg.ca_approval_status','=', $form_credentials['ca_approval_status']) 
        ->whereDate('o.created_at','>=', $form_credentials['from_created_at']) 
        ->whereDate('o.created_at','<=', $form_credentials['to_created_at']) 
        ->whereIN('o.customer_code', $form_credentials['customer_code'])
        // ->groupBy("o.status")
        ->get();

        return $result;
    }
    public function get_jc_customer_details($form_credentials ){
        $result = DB::table('customer_generals as cg')
        ->leftjoin('customer_coverage_attributes as ca', 'ca.cg_id','=','cg.auto_id')
        ->leftjoin('target_uploads as tu', 'tu.employee_code','=','cg.cg_customer_code')

        ->select('cg.*','ca.ca_channel','ca.ca_subchannel','ca.ca_group','ca.ca_class','tu.target_amount' )
        ->where('cg.cg_distributor_branch','=', $form_credentials['distributor_code']) 
        ->where('cg.cg_salesman_code','=', $form_credentials['salesman_code']) 
        ->whereIN('cg.cg_customer_code', $form_credentials['customer_code'])
        ->get();

        return $result;
    }
    

    public function last_three_month_average($form_credentials){
        $result = DB::table('orders as o')
        ->select(DB::raw('sum(o.total_amount) as total_amount'))
        ->where('o.distributor_code','=', $form_credentials['distributor_code']) 
        ->where('o.salesman_code','=', $form_credentials['salesman_code']) 
        ->whereDate('o.created_at','>=', $form_credentials['from_created_at']) 
        ->whereIN('o.customer_code', $form_credentials['customer_code'])
        ->get();

        return $result;
    }
    
    public function get_customer_target_details($form_credentials){
        
        $customer_general = DB::table('target_uploads as tu')
        ->select('tu.target_amount')
        ->where('tu.salesman_code','=', $form_credentials['salesman_code']) 
        ->where('tu.employee_code','=', $form_credentials['customer_code']) 
        ->where('tu.jc_period','=', $form_credentials['jc_period']) 
        ->get();
        return $customer_general;

    }
    
    public function get_other_route_details($where){
        $result = DB::table('salesman_route_mappings as s')
        ->leftjoin('routes as r', 'r.route_code','=','s.route_code')
        ->select('s.*','r.route_name')
        ->where($where)
        ->get();

        return $result;
    }

    public function get_other_customer_byroute($form_credentials ){
        $result = DB::table('customer_generals as cg')
        ->leftjoin('customer_coverage_attributes as ca', 'ca.cg_id','=','cg.auto_id')
        ->leftjoin('target_uploads as tu', 'tu.employee_code','=','cg.cg_customer_code')

        ->select('cg.*','ca.ca_channel','ca.ca_subchannel','ca.ca_group','ca.ca_class','tu.target_amount' )
        ->where('cg.cg_distributor_branch','=', $form_credentials['distributor_code']) 
        ->where('cg.cg_salesman_code','=', $form_credentials['salesman_code']) 
        ->where('ca.ca_sales_route','=', $form_credentials['route_code']) 
        ->where('cg.ca_approval_status','=', $form_credentials['ca_approval_status']) 
        ->get();

        return $result;
    }

    public function get_other_route_billed_outlet($form_credentials ){
        $result = DB::table('orders as o')
        ->leftjoin('customer_generals as cg', 'o.customer_code','=','cg.cg_customer_code')
        ->leftjoin('customer_coverage_attributes as ca', 'ca.cg_id','=','cg.auto_id')
        ->leftjoin('target_uploads as tu', 'tu.employee_code','=','cg.cg_customer_code')

        ->select('o.*','cg.cg_distance','ca.ca_channel','ca.ca_subchannel','ca.ca_group','ca.ca_class','tu.target_amount','cg.auto_id','cg.cg_customer_name','cg.cg_customer_name','cg.cg_latitude','cg.cg_longitude','cg.otpStatus' )
        ->where('o.distributor_code','=', $form_credentials['distributor_code']) 
        ->where('o.salesman_code','=', $form_credentials['salesman_code']) 
        ->where('cg.ca_approval_status','=', $form_credentials['ca_approval_status']) 
        ->whereDate('o.created_at','>=', $form_credentials['from_created_at']) 
        ->whereDate('o.created_at','<=', $form_credentials['to_created_at']) 
        ->whereIN('o.customer_code', $form_credentials['customer_code'])
        ->groupBy("o.customer_code")
        ->get();

        return $result;
    }
    

}
?>