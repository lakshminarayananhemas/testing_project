<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\orders;
use App\Models\ordered_items;
use DB;
use App\Repositories\Order\IOrderRepository; 
use App\Repositories\Salesman\ISalesmanRepository; 
use App\Repositories\Customer\ICustomerRepository; 
use App\Repositories\Billing\IBillingRepository; 

use Carbon\Carbon;
use App\Repositories\Common\ICommonRepository; 
use App\Models\Product;

use PDF;
use File;

class OrderController extends Controller
{
    //
    public function __construct(IOrderRepository $orderrepo,IBillingRepository $billrepo,ISalesmanRepository $salerepo,ICustomerRepository $custrepo,ICommonRepository $crepo)
    {
        $this->orderrepo = $orderrepo;
        $this->billrepo = $billrepo;
        $this->salerepo = $salerepo;
        $this->custrepo = $custrepo;
        $this->crepo = $crepo;

    }

    public function edit_oder_by_dis($id)
    {

        $where=array();
        $where[] = ['order_id', '=', $id];

        $result = $this->orderrepo->get_order_list($where );


        return response()->json([
            'status'=>200,
            'order_data'=>$result,
        ]);
    }

    public function save_order_from_dis(Request $request)
    {


        $data= $request->input('people');
        // return $data;


        $total_amount=0;
        $tax_amount=0;
        foreach($data as $order_item){
            $total_amount=$total_amount+$order_item['gross_amt'];
            $tax_amount=$tax_amount+($order_item['tax_amt']*$order_item['order_qty']);
        }


        try {
            $orderId = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);

            $save_data=[
                'salesman_code'=>$request->input('salesman_code')[0],
                'customer_code'=>$request->input('customerData')[0]['value'],
                'distributor_code'=>$request->input('distributor_code'),
                'order_id'=>$orderId,
                'signature'=>'',
                'total_amount'=>$total_amount,
                'tax_amount'=>$tax_amount,
                'discount'=>'0',
            ];


            $order_result = $this->custrepo->create_order( $save_data );

            // insert product info
            foreach($data as $order_item){
                $save_order_item_data=[
                    'order_id'=>$orderId,
                    'product_id'=>$order_item['product_code'],
                    'product_name'=>$order_item['product_name'],
                    'quantity'=>$order_item['order_qty'],
                    'ptr'=>$order_item['sell_rate'],
                    'tentative_discount'=>'0',
                    'tax_percentage'=>$order_item['tax_amt']*$order_item['order_qty'],
                    'tentative_line_value'=>($order_item['sell_rate']*$order_item['order_qty'])+($order_item['tax_amt']*$order_item['order_qty']),
                    'quantity_type'=>$order_item['uom'],
                    'scheme_id'=>'0',
                ];
    

                $order_item_result = $this->custrepo->create_order_items( $save_order_item_data );
            }
           
            return response()->json([
                'status'=>"Success",
                'message'=> "Order Saved Successfully.."
            ]);
            
         
        } catch (\Exception $e) {
            $status='false';
            $message=$e->getMessage();

            return response()->json([
                'status'=>$status,
                'message'=> "Request Failed"
            ]);    
        }
       

    }

    
    
    public function fetch_fresh_order(Request $request){
        $distributor_code = $request->distributor_code;

        $record = DB::table('orders as o')
        ->leftjoin('salesman_infos as sm', 'sm.salesman_code','=','o.salesman_code')
        ->leftjoin('customer_generals as cg', 'cg.cg_customer_code','=','o.customer_code')
        ->select('o.*','sm.*','cg.*')
        ->where('o.distributor_code', '=', $distributor_code)
        ->where('o.status', '=', "Pending")
        // ->orderBy( 'qt.created_at', 'desc' )
        // ->groupBy( 'qt.ticket_id' )
        ->get();
        return $record;


        // $orders = orders::where('distributor_code','=',$distributor_code);
        // $orders = $orders->where('status','=',"Pending");  
        // $orders = $orders->get(); 
        // // $orders = orders::all();
        // return $orders; 
    }
    public function fetch_approved_data(Request $request){
        $distributor_code = $request->distributor_code;

        $record = DB::table('orders as o')
        ->leftjoin('salesman_infos as sm', 'sm.salesman_code','=','o.salesman_code')
        ->leftjoin('customer_generals as cg', 'cg.cg_customer_code','=','o.customer_code')
        ->select('o.*','sm.*','cg.*')
        ->where('o.distributor_code', '=', $distributor_code)
        ->where('o.status', '=', "Approved")
        ->orderBy( 'o.created_at', 'desc' )
        // ->groupBy( 'qt.ticket_id' )
        ->get();
        return $record;

        // $orders = orders::where('distributor_code','=',$distributor_code);
        // $orders = $orders->where('status','=',"Approved"); 
        // $orders = $orders->get(); 
        // // $orders = orders::all();
        // return $orders; 
    }
    public function fetch_declined_data(Request $request){
        $distributor_code = $request->distributor_code;

        $record = DB::table('orders as o')
        ->leftjoin('salesman_infos as sm', 'sm.salesman_code','=','o.salesman_code')
        ->leftjoin('customer_generals as cg', 'cg.cg_customer_code','=','o.customer_code')
        ->select('o.*','sm.*','cg.*')
        ->where('o.distributor_code', '=', $distributor_code)
        ->where('o.status', '=', "Declined")
        ->orderBy( 'o.created_at', 'desc' )
        // ->groupBy( 'qt.ticket_id' )
        ->get();
        return $record;

        // $orders = orders::where('distributor_code','=',$distributor_code);
        // $orders = $orders->where('status','=',"Declined"); 
        // $orders = $orders->get(); 
        // // $orders = orders::all();
        // return $orders; 
    }
    public function fetch_order_items(Request $request){
        $orders = ordered_items::where('order_id','=',$request->order_id)->get(); 
        return $orders; 
    }
    public function decline_order(Request $request){
        $update = new orders();
        $update = $update->where( 'order_id', '=', $request->order_id);
        $update = $update->update( [ 
            'status' => "Declined",
        ] );
        if($update) {
            return response()->json([
                'status'=>200,
                'message'=>'Order Declined Successfully',
            ]);
        } else {
            return response()->json([
                'status'=>424,
                'message'=>'Order Declined Failed',
            ]);
        }
    }

    
    public function approve_order(Request $request){

        $order_detail = orders::where('order_id','=',$request->order_id)->get(); 
        
        $order_items = ordered_items::where('order_id','=',$request->order_id)->get(); 

        // return response()->json([
        //     'data1'=>$order_detail,
        //     'data2'=>$order_items,
        // ]);


        $total_order_q=0;
        $total_dis_amt=0;
        $order_qty=array();
        $product_code=array();
        $product_name=array();
        $sel_rate=array();
        $dis_amt=array();
        $product_mrp=array();

        $batch=array();
        $expiry_date=array();
        $net_rate=array();
        $net_amt=array();
        $hsn_code=array();


        foreach($order_items as $order_itm){

            $single_product = Product::where('product_code','=',$order_itm->product_id)->get(); 


            $product_mrp[]=$single_product[0]->mrp;
            $hsn_code[]=$single_product[0]->hsn_code;

            $total_order_q= $total_order_q+$order_itm->quantity;
            $total_dis_amt= $total_dis_amt+$order_itm->tentative_discount;
            $product_code[]= $order_itm->product_id;
            $product_name[]= $order_itm->product_name;
            $product_name[]= $order_itm->product_name;
            $sel_rate[]= $order_itm->ptr;
            $dis_amt[]= $order_itm->tentative_discount;
            $order= $order_itm->quantity.''.$order_itm->quantity_type;

            $order_qty[]= $order_itm->quantity;

            $batch[]='';
            $expiry_date[]='';
            $net_rate[]='';
            $net_amt[]='';
        }
        // billing module
        $form_credentials = array(
            'salesman_code' => $order_detail[0]['salesman_code'],
            'route_code' => $order_detail[0]['distributor_code'],
            'customer_code' => $order_detail[0]['customer_code'],
            'distributor_code' => $order_detail[0]['distributor_code'],
            'order_qty' => $total_order_q,
            'cash_dist_amt' => $total_dis_amt,
            'scheme_dist_amt' => $total_dis_amt,
            'total_invoice_qty' => $total_order_q,
            'credit_note_adjustment' => '',
            'debit_note_adjustment' => '',
            'gross_amount' => $order_detail[0]['total_amount'],
            'total_addition' => '',
            'total_deduction' => '',
            'net_amount' => $order_detail[0]['total_amount'],
            'product_code' => $product_code,
            'product_name' => $product_name,
            'batch' => $batch,
            'expiry_date' => $expiry_date,
            'order' => $order,
            'order_qty' => $order_qty,
            'inv_qty' => $order_qty,
            'mrp' => $product_mrp,
            'sell_rate' => $sel_rate,
            'gross_amt' => $sel_rate,
            'line_disc_amt' => $dis_amt,
            'tax_amt' => $sel_rate,
            'net_rate' => $net_rate,
            'net_amt' => $net_amt,
            'order_date' => date('Y-m-d'),
            'order_status' => 'Pending',
        );
        // return $form_credentials;
 

        $invoice_number = $this->billrepo->create_billing( $form_credentials);
        $invoice_data = array(
            'item_count' => count($order_items),
            'invoice_number' => $invoice_number,
            'invoice_date' => date('d/m/Y'),
            'salesman_code' => $order_detail[0]['salesman_code'],
            'route_code' => $order_detail[0]['distributor_code'],
            'customer_code' => $order_detail[0]['customer_code'],
            'distributor_code' =>  $order_detail[0]['distributor_code'],
            'order_qty' => $total_order_q,
            'cash_dist_amt' => $total_dis_amt,
            'scheme_dist_amt' => $total_dis_amt,
            'total_invoice_qty' => $total_order_q,
            'credit_note_adjustment' => '',
            'debit_note_adjustment' => '',
            'gross_amount' => $order_detail[0]['total_amount'],
            'total_addition' => '',
            'total_deduction' => '',
            'net_amount' => $order_detail[0]['total_amount'],
            'product_code' => $product_code,
            'hsn_code' => $hsn_code,
            'product_name' => $product_name,
            'batch' => $batch,
            'expiry_date' => $expiry_date,
            'order' => $order,
            'order_qty' => $order_qty,
            'inv_qty' => $order_qty,
            'mrp' => $product_mrp,
            'sell_rate' => $sel_rate,
            'gross_amt' => $sel_rate,
            'line_disc_amt' => $dis_amt,
            'tax_amt' => $sel_rate,
            'net_rate' => $net_rate,
            'net_amt' => $net_amt,
        );

        $pdf = PDF::loadView('billing', $invoice_data)->setPaper('a4', 'landscape');
        $path = public_path().'/uploads/billing_invoice/'.$order_detail[0]['distributor_code'];
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
        $fileName = $invoice_number. '.' . 'pdf';
        $pdf->save($path . '/' . $fileName);

        $offer_letter_filename = '/billing_invoice/'.$order_detail[0]['distributor_code'].'/'.$fileName;

        // billing module end

        $update = new orders();
        $update = $update->where( 'order_id', '=', $request->order_id);
        $update = $update->update( [  
            'order_bill_id' => $invoice_number,
            'status' => "Approved",
        ] );

        if($update) {
            return response()->json([
                'status'=>200,
                'message'=>'Order Approved Successfully',
            ]);
        } else {
            return response()->json([
                'status'=>424,
                'message'=>'Order Approval Failed',
            ]);
        }
    }
    
    //ganagavathy

        // 27-09

        public function get_orderitems_list(Request $request){

            try {
                $where=array();
                $where[] = ['order_id', '=', $request->input( 'order_id' )];

                $result = $this->orderrepo->get_orderitem_list($where );

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

        public function get_jc_beats(Request $request){

            try {
                
                $current_date = date('Y-m-d');
                // $current_date = '2022-09-21';
                $where=array();
                $where[] = ['from_date', '<=', $current_date];
                $where[] = ['to_date', '>=', $current_date];

                $result = $this->salerepo->get_pjp_jcmonth( $where );

                if(count($result) !=0){
                    $test_result_array = [];

                    // get current jc route details
                    $where1=array();
                    $where1[] = ['s.distributor_code', '=', $request->input( 'distributor_code' )];
                    $where1[] = ['s.salesman_code', '=', $request->input( 'salesman_code' )];
                    $where1[] = ['s.jc_month', '=', $result[0]->jc];
                    $where1[] = ['cg.ca_approval_status', '=', 'Approved'];
                    
                    $gcjrd_result = $this->orderrepo->get_current_jc_route_details($where1 );
                    
                    if(count($gcjrd_result) !=0){

                        foreach ($gcjrd_result as $key => $gcjrd_value) {

                            $test_result_array[$gcjrd_value->route_code]['route_name'] = $gcjrd_value->route_name;
                            $test_result_array[$gcjrd_value->route_code]['route_code'] = $gcjrd_value->route_code;

                            $where2=array();
                            $where2[] = ['s.distributor_code', '=', $request->input( 'distributor_code' )];
                            $where2[] = ['s.salesman_code', '=', $request->input( 'salesman_code' )];
                            $where2[] = ['s.route_code', '=', $gcjrd_value->route_code];
                            $where2[] = ['s.jc_month', '=', $result[0]->jc];
                            $where2[] = ['cg.ca_approval_status', '=', 'Approved'];

                            $total_outlet_result = $this->orderrepo->get_current_jc_customer_byroute($where2 );
                            
                            $test_result_array[$gcjrd_value->route_code]['total_outlet'] = count($total_outlet_result);

                            $custid_array = [];
                            foreach ($total_outlet_result as $key1 => $tor_value) {
                                array_push($custid_array,$tor_value->customer_code);
                            }

                            // get billed outlet count
                            $form_credentials = array(
                                'distributor_code' => $request->input( 'distributor_code' ),
                                'salesman_code' => $request->input( 'salesman_code' ),
                                'from_created_at' => $result[0]->from_date,
                                'to_created_at' =>  $result[0]->to_date,
                                'customer_code' =>$custid_array,
                                'ca_approval_status' =>'Approved',
                            );
                            $billed_outlet_result = $this->orderrepo->get_jc_route_billed_outlet($form_credentials );
                            
                            $test_result_array[$gcjrd_value->route_code]['billed_outlet'] = count($billed_outlet_result);

                            $unbilled_outlet = count($total_outlet_result) - count($billed_outlet_result);
                            
                            $test_result_array[$gcjrd_value->route_code]['unbilled_outlet'] = $unbilled_outlet;

                        }

                    //    return $test_result_array;
                    $test_result_array = array_values($test_result_array);


                        $status = 'true';
                        $message = 'Data Found';
                        
                    }
                    else{

                        $status = 'false1';
                        $message = 'No Data Found';
                        $test_result_array =[];
                    }

                    
                }
                else{
                    $status = 'false';
                    $message = 'No Data Found';
                    $test_result_array=[];

                }

                return response()->json([
                    'status'=>$status,
                    'message'=>$message,
                    'result'=>$test_result_array,
                    

                ]);

            } catch (\Execption $e) {
                $status = 'false';
                $message = $e;
                $test_result_array = [];
                
            
                return response()->json([
                    'status'=>$status,
                    'message'=>$message,
                    // 'result'=>$result,
                    'result'=>$test_result_array,

                ]);
            }
        }

        public function get_jc_beats_byroute_total_outlet(Request $request){

            try {
                
                $distributor_code = $request->input( 'distributor_code' );
                $salesman_code = $request->input( 'salesman_code' );
                $route_code = $request->input( 'route_code' );

                $current_date = date('Y-m-d');
                // $current_date = '2022-09-21';
                $where=array();
                $where[] = ['from_date', '<=', $current_date];
                $where[] = ['to_date', '>=', $current_date];

                $result = $this->salerepo->get_pjp_jcmonth( $where );
                
                if(count($result) !=0){

                    $where1=array();
                    $where1[] = ['s.distributor_code', '=', $distributor_code];
                    $where1[] = ['s.salesman_code', '=', $salesman_code];
                    $where1[] = ['s.route_code', '=', $route_code];
                    $where1[] = ['s.jc_month', '=', $result[0]->jc];
                    $where1[] = ['cg.ca_approval_status', '=', 'Approved'];
                    
                    $gcjcb_result = $this->orderrepo->get_current_jc_customer_byroute($where1 );
                    
                    if(count($gcjcb_result) !=0){
                        $test_result_array = [];
                        
                        $custid_ind_array = [];
                        foreach ($gcjcb_result as $key1 => $gcjcb_value) {
                            array_push($custid_ind_array,$gcjcb_value->customer_code);
                        }

                        // get billed outlet count
                        $form_credentials = array(
                            'distributor_code' => $request->input( 'distributor_code' ),
                            'salesman_code' => $request->input( 'salesman_code' ),
                            'from_created_at' => $result[0]->from_date,
                            'to_created_at' =>  $result[0]->to_date,
                            'customer_code' =>$custid_ind_array,
                            'ca_approval_status' =>'Approved',

                        );
                        $billed_outlet_result = $this->orderrepo->get_jc_route_billed_outlet($form_credentials );
                        $billed_custid_array = [];

                        if(count($billed_outlet_result) !=0){

                            // billed outlets array 

                            $comp_custinfo_array = array();
                            foreach ($billed_outlet_result as $key_2 => $bor_value) {
                                array_push($billed_custid_array,$bor_value->customer_code);


                                $comp_custinfo_array[$key_2]['customer_code'] = $bor_value->customer_code;
                                $comp_custinfo_array[$key_2]['salesman_code'] = $bor_value->salesman_code;
                                $comp_custinfo_array[$key_2]['distributor_code'] = $bor_value->distributor_code;
                                $comp_custinfo_array[$key_2]['cg_distance'] = $bor_value->cg_distance;
                                $comp_custinfo_array[$key_2]['ca_channel'] = $bor_value->ca_channel;
                                $comp_custinfo_array[$key_2]['ca_subchannel'] = $bor_value->ca_subchannel;
                                $comp_custinfo_array[$key_2]['ca_group'] = $bor_value->ca_group;
                                $comp_custinfo_array[$key_2]['ca_class'] = $bor_value->ca_class;
                                $comp_custinfo_array[$key_2]['auto_id'] = $bor_value->auto_id;
                                $comp_custinfo_array[$key_2]['cg_customer_name'] = $bor_value->cg_customer_name;
                                $comp_custinfo_array[$key_2]['cg_latitude'] = $bor_value->cg_latitude;
                                $comp_custinfo_array[$key_2]['cg_longitude'] = $bor_value->cg_longitude;
                                $comp_custinfo_array[$key_2]['otpStatus'] = $bor_value->otpStatus;
                                
                                $custid_array = array();
                                array_push($custid_array,$bor_value->customer_code);

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
                                    'status' =>'Approved',
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
                            $test_result_array['billed_outlets'] = $comp_custinfo_array;
                        
                            
                        }else{
                            $billed_outlet = 0;
                            // $test_result_array[$key_m]['billed_outlets'] = 0;
                            $test_result_array['billed_outlets'] =[];
                            
                        }

                        // return $custid_array;
                        // return $billed_custid_array;
                        $unbilled_outlet_id=array_diff($custid_ind_array,$billed_custid_array);

                        if(count($unbilled_outlet_id) !=0){
                            
                            $form_credentials = array(
                                'distributor_code' => $request->input( 'distributor_code' ),
                                'salesman_code' => $request->input( 'salesman_code' ),
                                'from_created_at' => $result[0]->from_date,
                                'to_created_at' =>  $result[0]->to_date,
                                'customer_code' =>$unbilled_outlet_id,
                                'ca_approval_status' =>'Approved',

                            );
                            
                            $gcjcd_result_pen = $this->orderrepo->get_jc_customer_details($form_credentials );
                            if(count($gcjcd_result_pen) !=0){
                                $unbilled_outlet = count($gcjcd_result_pen);
                                // $test_result_array[$key_m]['unbilled_outlets'] =$unbilled_outlet;

                                // pending outlets array 
                                $pending_custinfo_array = array();

                                // return $gcjcd_result_pen;
                                foreach ($gcjcd_result_pen as $key_1 => $grp_value) {

                                    $pending_custinfo_array[$key_1]['customer_code'] = $grp_value->cg_customer_code;
                                    $pending_custinfo_array[$key_1]['salesman_code'] = $grp_value->cg_salesman_code;
                                    $pending_custinfo_array[$key_1]['distributor_code'] = $grp_value->cg_distributor_branch;
                                    $pending_custinfo_array[$key_1]['cg_distance'] = $grp_value->cg_distance;
                                    $pending_custinfo_array[$key_1]['ca_channel'] = $grp_value->ca_channel;
                                    $pending_custinfo_array[$key_1]['ca_subchannel'] = $grp_value->ca_subchannel;
                                    $pending_custinfo_array[$key_1]['ca_group'] = $grp_value->ca_group;
                                    $pending_custinfo_array[$key_1]['ca_class'] = $grp_value->ca_class;
                                    $pending_custinfo_array[$key_1]['target_amount'] = $grp_value->target_amount;

                                    $pending_custinfo_array[$key_1]['auto_id'] = $grp_value->auto_id;
                                    $pending_custinfo_array[$key_1]['cg_customer_name'] = $grp_value->cg_customer_name;
                                    $pending_custinfo_array[$key_1]['cg_latitude'] = $grp_value->cg_latitude;
                                    $pending_custinfo_array[$key_1]['cg_longitude'] = $grp_value->cg_longitude;
                                    $pending_custinfo_array[$key_1]['otpStatus'] = $grp_value->otpStatus;

                                    $custid_array = array();
                                    array_push($custid_array,$grp_value->cg_customer_code);
                                    
                                    $form_credentials = array(
                                        'distributor_code' => $request->input( 'distributor_code' ),
                                        'salesman_code' => $request->input( 'salesman_code' ),
                                        'from_created_at' => $result[0]->from_date,
                                        'to_created_at' =>  $result[0]->to_date,
                                        'customer_code' =>$custid_array,
                                        'status' =>'Approved',
                                        'ca_approval_status' =>'Approved',
                                    );
                                    $gcjcd_result_app1 = $this->orderrepo->get_jc_customer_order_details($form_credentials );
                                    $gcjcd_result_app1 = json_decode(json_encode($gcjcd_result_app1), true);

                                    $cust_achieved_amount = array_sum(array_column($gcjcd_result_app1, 'total_amount'));

                                    $pending_custinfo_array[$key_1]['orders_confirmed'] = count($gcjcd_result_app1);
                                    $pending_custinfo_array[$key_1]['achieved_amount'] = $cust_achieved_amount;

                                    // return ($gcjcd_result_app1);
                                    $form_credentials = array(
                                        'distributor_code' => $request->input( 'distributor_code' ),
                                        'salesman_code' => $request->input( 'salesman_code' ),
                                        'from_created_at' => $result[0]->from_date,
                                        'to_created_at' =>  $result[0]->to_date,
                                        'customer_code' =>$custid_array,
                                        'status' =>'Pending',
                                        'ca_approval_status'=>'Approved'
                                    );
                                    
                                    $gcjcd_result_pen1 = $this->orderrepo->get_jc_customer_order_details($form_credentials );
                                    
                                    $total_order_taken = count($gcjcd_result_app1) + count($gcjcd_result_pen1);
                                    $pending_custinfo_array[$key_1]['total_orders_taken'] = $total_order_taken;
                                    
                                    if($grp_value->target_amount >=$cust_achieved_amount){
                                        $target_balance = $grp_value->target_amount - $cust_achieved_amount;
                                    }elseif ($grp_value->target_amount < $cust_achieved_amount) {
                                        $target_balance = 0;
                                    }else{
                                        $target_balance=0;
                                    }
                                    $pending_custinfo_array[$key_1]['target_balance'] = $target_balance;

                                    
                                    // get average of l3m
                                    $last_three_month_date = Carbon::now()->subMonth(3);
                                    $form_credentials_ltm = array(
                                        'distributor_code' => $request->input( 'distributor_code' ),
                                        'salesman_code' => $request->input( 'salesman_code' ),
                                        'from_created_at' => $last_three_month_date,
                                        'customer_code' =>$custid_array,
                                        'status' =>'Approved',
                                    );
                                    
                                    $last_three_month_result = $this->orderrepo->last_three_month_average($form_credentials_ltm );
                                    if(count($last_three_month_result) !=0){
                                        $last_three_month_avg = ($last_three_month_result[0]->total_amount) / 3;
                                    }else{
                                        $last_three_month_avg=0;
                                    }
                                    
                                    $pending_custinfo_array[$key_1]['last_three_month_avg'] = round($last_three_month_avg);

                                    // get customer freequency
                                    $where2=array();
                                    $where2[] = ['s.distributor_code', '=', $request->input( 'distributor_code' )];
                                    $where2[] = ['s.salesman_code', '=', $request->input( 'salesman_code' )];
                                    $where2[] = ['s.customer_code', '=', $custid_array];
                                    $where2[] = ['s.jc_month', '=', $result[0]->jc];
                                    
                                    $cus_freq_result = $this->orderrepo->get_customer_frequency($where2 );

                                    if(count($cus_freq_result) !=0){
                                        // get_coverage details
                                        if($cus_freq_result[0]->frequency == 'Daily'){

                                            $total_coverage = 28;
                                            // get covered coverage details
                                            $covered_coverage_result = $this->orderrepo->salesman_marketvisit_coverage($form_credentials);

                                            $coverage_output = $covered_coverage_result." / ".$total_coverage;

                                        }elseif ($cus_freq_result[0]->frequency == 'Weekly') {
                                            
                                            $total_coverage = 4;
                                            $covered_coverage_result = $this->orderrepo->salesman_marketvisit_coverage($form_credentials );
                                            $coverage_output = $covered_coverage_result." / ".$total_coverage;
                                            
                                        }else{

                                            $total_coverage = 1;
                                            $covered_coverage_result = $this->orderrepo->salesman_marketvisit_coverage($form_credentials);
                                            $coverage_output = $covered_coverage_result." / ".$total_coverage;

                                        }

                                        $pending_custinfo_array[$key_1]['coverage_output'] = $coverage_output;

                                        // get productivity details
                                        
                                            $order_productivity_count = $total_order_taken;

                                            // get sales return count
                                            $sales_retun_result = $this->orderrepo->salesman_sales_return_count($form_credentials);
                                            $salesreturn_productivity_count = $sales_retun_result;


                                        $pending_custinfo_array[$key_1]['order_productivity_count'] = $order_productivity_count;
                                        $pending_custinfo_array[$key_1]['salesreturn_productivity_count'] = $salesreturn_productivity_count;
                                    }
                                    else{
                                        $pending_custinfo_array[$key_1]['coverage_output'] = "0 / 0";
                                        $pending_custinfo_array[$key_1]['order_productivity_count'] = "0";
                                        $pending_custinfo_array[$key_1]['salesreturn_productivity_count'] = "0";

                                    }
                                    

                                    
                                }
                                $test_result_array['unbilled_outlets'] =$pending_custinfo_array;
                                
                            }else{

                                $unbilled_outlet = 0;
                                // $test_result_array[$key_m]['unbilled_outlets'] =0;
                                $test_result_array['unbilled_outlets'] =[];
                                
                            }
                            
                            
                        }
                        else{

                            $unbilled_outlet = 0;
                            // $test_result_array[$key_m]['unbilled_outlets'] =0;
                            $test_result_array['unbilled_outlets'] =[];
                            
                        }
                        
                        // $test_result_array = array_values($test_result_array);

                        $status = 'true';
                        $message = 'Data Found';
                    }
                    else{
                        $status = 'false1';
                        $message = 'No Data Found';
                        $test_result_array = [];
                        $test_result_array['billed_outlets'] =[];
                        $test_result_array['unbilled_outlets'] =[];

                    }

                }else{
                    $status = 'false';
                    $message = 'No Data Found';
                    $test_result_array = [];
                    $test_result_array['billed_outlets'] =[];
                    $test_result_array['unbilled_outlets'] =[];
                }

                return response()->json([
                    'status'=>$status,
                    'message'=>$message,
                    // 'result'=>$result,
                    'result_array'=>$test_result_array,
                    

                ]);
            } catch (\Execption $e) {
                $status = 'false';
                $message = $e;
                $test_result_array = [];
                $test_result_array['billed_outlets'] =[];
                $test_result_array['unbilled_outlets'] =[];
            
                return response()->json([
                    'status'=>$status,
                    'message'=>$message,
                    // 'result'=>$result,
                    'result_array'=>$test_result_array,

                ]);
            }
            
        }

        public function get_jc_beats_byroute_billed_outlet(Request $request){
            try {
                
                $distributor_code = $request->input( 'distributor_code' );
                $salesman_code = $request->input( 'salesman_code' );
                $route_code = $request->input( 'route_code' );

                $current_date = date('Y-m-d');
                // $current_date = '2022-09-21';
                $where=array();
                $where[] = ['from_date', '<=', $current_date];
                $where[] = ['to_date', '>=', $current_date];

                $result = $this->salerepo->get_pjp_jcmonth( $where );

                if(count($result) !=0){

                    $where1=array();
                    $where1[] = ['s.distributor_code', '=', $distributor_code];
                    $where1[] = ['s.salesman_code', '=', $salesman_code];
                    $where1[] = ['s.route_code', '=', $route_code];
                    $where1[] = ['s.jc_month', '=', $result[0]->jc];
                    $where1[] = ['cg.ca_approval_status', '=', 'Approved'];
                    
                    $gcjcb_result = $this->orderrepo->get_current_jc_customer_byroute($where1 );
                    
                    if(count($gcjcb_result) !=0){
                        $test_result_array = [];
                        $custid_ind_array = [];
                        foreach ($gcjcb_result as $key1 => $gcjcb_value) {
                            array_push($custid_ind_array,$gcjcb_value->customer_code);
                        }
                        
                        $order_status_array = ["Approved","Pending"];

                        foreach ($order_status_array as $key_os => $os_value) {
                            // get approved order
                            $form_credentials = array(
                                'distributor_code' => $request->input( 'distributor_code' ),
                                'salesman_code' => $request->input( 'salesman_code' ),
                                'from_created_at' => $result[0]->from_date,
                                'to_created_at' =>  $result[0]->to_date,
                                'customer_code' =>$custid_ind_array,
                                'status' => $os_value,
                                'ca_approval_status' =>'Approved',

                            );

                            $approved_order_result = $this->orderrepo->get_jc_customer_app_order($form_credentials );

                            if(count($approved_order_result) !=0){
                                $comp_custinfo_array = array();

                                foreach ($approved_order_result as $key_2 => $bor_value) {
                                    $comp_custinfo_array[$key_2]['customer_code'] = $bor_value->customer_code;
                                    $comp_custinfo_array[$key_2]['salesman_code'] = $bor_value->salesman_code;
                                    $comp_custinfo_array[$key_2]['distributor_code'] = $bor_value->distributor_code;
                                    $comp_custinfo_array[$key_2]['cg_distance'] = $bor_value->cg_distance;
                                    $comp_custinfo_array[$key_2]['ca_channel'] = $bor_value->ca_channel;
                                    $comp_custinfo_array[$key_2]['ca_subchannel'] = $bor_value->ca_subchannel;
                                    $comp_custinfo_array[$key_2]['ca_group'] = $bor_value->ca_group;
                                    $comp_custinfo_array[$key_2]['ca_class'] = $bor_value->ca_class;
                                    $comp_custinfo_array[$key_2]['auto_id'] = $bor_value->auto_id;
                                    $comp_custinfo_array[$key_2]['cg_customer_name'] = $bor_value->cg_customer_name;
                                    $comp_custinfo_array[$key_2]['cg_latitude'] = $bor_value->cg_latitude;
                                    $comp_custinfo_array[$key_2]['cg_longitude'] = $bor_value->cg_longitude;
                                    $comp_custinfo_array[$key_2]['otpStatus'] = $bor_value->otpStatus;
                                    
                                    $custid_array = array();
                                    array_push($custid_array,$bor_value->customer_code);

                                    $form_credentials = array(
                                        'distributor_code' => $request->input( 'distributor_code' ),
                                        'salesman_code' => $request->input( 'salesman_code' ),
                                        'from_created_at' => $result[0]->from_date,
                                        'to_created_at' =>  $result[0]->to_date,
                                        'customer_code' =>$custid_array,
                                        'status' =>'Approved',
                                        'ca_approval_status'=>'Approved'
                                    );
                                    $gcjcd_result_app1 = $this->orderrepo->get_jc_customer_order_details($form_credentials );
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
                                        'ca_approval_status'=>'Approved'
                                    );
                                    
                                    $gcjcd_result_pen1 = $this->orderrepo->get_jc_customer_order_details($form_credentials );
                                    
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
                                        'status' =>'Approved',
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
                                $result_key = $os_value."_order";
                                $test_result_array[$result_key] = $comp_custinfo_array;
                            
                                
                                
                            }else{
                                $result_key = $os_value."_order";

                                $test_result_array[$result_key] =[];

                            }
                        }
                        

                        $status = 'true';
                        $message = 'Data Found';
                    }
                    else{
                        $status = 'false1';
                        $message = 'No Data Found';
                        $test_result_array = [];
                    }
                }else{
                    $status = 'false';
                    $message = 'No Data Found';
                    $test_result_array = [];
                }
                return response()->json([
                    'status'=>$status,
                    'message'=>$message,
                    // 'result'=>$result,
                    'result_array'=>$test_result_array,
                    

                ]);
            }
            catch (\Execption $e) {
                $status = 'false';
                $message = $e;
                $test_result_array = [];
                
            
                return response()->json([
                    'status'=>$status,
                    'message'=>$message,
                    // 'result'=>$result,
                    'result_array'=>$test_result_array,

                ]);
            }
        }

        public function get_other_jc_beats(Request $request){

            try {
                
                $current_date = date('Y-m-d');
                // $current_date = '2022-09-21';
                $where=array();
                $where[] = ['from_date', '<=', $current_date];
                $where[] = ['to_date', '>=', $current_date];

                $result = $this->salerepo->get_pjp_jcmonth( $where );

                if(count($result) !=0){
                    $test_result_array = [];

                    // get other route details
                    $where1=array();
                    $where1[] = ['s.distributor_code', '=', $request->input( 'distributor_code' )];
                    $where1[] = ['s.salesman_code', '=', $request->input( 'salesman_code' )];
                    
                    $gcjrd_result = $this->orderrepo->get_other_route_details($where1 );
                    
                    if(count($gcjrd_result) !=0){

                        foreach ($gcjrd_result as $key => $gcjrd_value) {

                            $test_result_array[$gcjrd_value->route_code]['route_name'] = $gcjrd_value->route_name;
                            $test_result_array[$gcjrd_value->route_code]['route_code'] = $gcjrd_value->route_code;

                            $form_credentials_cb = array(
                                'distributor_code' => $request->input( 'distributor_code' ),
                                'salesman_code' => $request->input( 'salesman_code' ),
                                'route_code' => $gcjrd_value->route_code,
                                'ca_approval_status' =>'Approved',
                            );

                            $total_outlet_result = $this->orderrepo->get_other_customer_byroute($form_credentials_cb );
                            
                            $test_result_array[$gcjrd_value->route_code]['total_outlet'] = count($total_outlet_result);

                            $custid_array = [];
                            foreach ($total_outlet_result as $key1 => $tor_value) {
                                array_push($custid_array,$tor_value->cg_customer_code);
                            }

                            // get billed outlet count
                            $form_credentials = array(
                                'distributor_code' => $request->input( 'distributor_code' ),
                                'salesman_code' => $request->input( 'salesman_code' ),
                                'from_created_at' => $result[0]->from_date,
                                'to_created_at' =>  $result[0]->to_date,
                                'customer_code' =>$custid_array,
                                'ca_approval_status' =>'Approved',
                            );
                            $billed_outlet_result = $this->orderrepo->get_jc_route_billed_outlet($form_credentials );
                            
                            $test_result_array[$gcjrd_value->route_code]['billed_outlet'] = count($billed_outlet_result);

                            $unbilled_outlet = count($total_outlet_result) - count($billed_outlet_result);
                            
                            $test_result_array[$gcjrd_value->route_code]['unbilled_outlet'] = $unbilled_outlet;

                        }

                        $test_result_array = array_values($test_result_array);

                        $status = 'true';
                        $message = 'Data Found';
                        
                    }
                    else{

                        $status = 'false1';
                        $message = 'No Data Found';
                        $test_result_array =[];
                    }

                    
                }
                else{
                    $status = 'false';
                    $message = 'No Data Found';
                    $test_result_array=[];

                }

                return response()->json([
                    'status'=>$status,
                    'message'=>$message,
                    'result'=>$test_result_array,
                    

                ]);

            } catch (\Execption $e) {
                $status = 'false';
                $message = $e;
                $test_result_array = [];
                
            
                return response()->json([
                    'status'=>$status,
                    'message'=>$message,
                    // 'result'=>$result,
                    'result'=>$test_result_array,

                ]);
            }
        }

        public function get_other_beats_byroute_total_outlet(Request $request){

            try {
                
                $distributor_code = $request->input( 'distributor_code' );
                $salesman_code = $request->input( 'salesman_code' );
                $route_code = $request->input( 'route_code' );

                $current_date = date('Y-m-d');
                // $current_date = '2022-09-21';
                $where=array();
                $where[] = ['from_date', '<=', $current_date];
                $where[] = ['to_date', '>=', $current_date];

                $result = $this->salerepo->get_pjp_jcmonth( $where );
                
                if(count($result) !=0){

                    $form_credentials_cb = array(
                        'distributor_code' => $request->input( 'distributor_code' ),
                        'salesman_code' => $request->input( 'salesman_code' ),
                        'route_code' => $route_code,
                        'ca_approval_status' =>'Approved',
                    );

                    $gcjcb_result = $this->orderrepo->get_other_customer_byroute($form_credentials_cb );
                    
                    if(count($gcjcb_result) !=0){
                        $test_result_array = [];
                        
                        $custid_ind_array = [];
                        foreach ($gcjcb_result as $key1 => $gcjcb_value) {
                            array_push($custid_ind_array,$gcjcb_value->cg_customer_code);
                        }

                        // get billed outlet count
                        $form_credentials = array(
                            'distributor_code' => $request->input( 'distributor_code' ),
                            'salesman_code' => $request->input( 'salesman_code' ),
                            'from_created_at' => $result[0]->from_date,
                            'to_created_at' =>  $result[0]->to_date,
                            'customer_code' =>$custid_ind_array,
                            'ca_approval_status' =>'Approved',

                        );
                        $billed_outlet_result = $this->orderrepo->get_other_route_billed_outlet($form_credentials );
                        $billed_custid_array = [];

                        if(count($billed_outlet_result) !=0){

                            // billed outlets array 

                            $comp_custinfo_array = array();
                            foreach ($billed_outlet_result as $key_2 => $bor_value) {
                                array_push($billed_custid_array,$bor_value->customer_code);


                                $comp_custinfo_array[$key_2]['customer_code'] = $bor_value->customer_code;
                                $comp_custinfo_array[$key_2]['salesman_code'] = $bor_value->salesman_code;
                                $comp_custinfo_array[$key_2]['distributor_code'] = $bor_value->distributor_code;
                                $comp_custinfo_array[$key_2]['cg_distance'] = $bor_value->cg_distance;
                                $comp_custinfo_array[$key_2]['ca_channel'] = $bor_value->ca_channel;
                                $comp_custinfo_array[$key_2]['ca_subchannel'] = $bor_value->ca_subchannel;
                                $comp_custinfo_array[$key_2]['ca_group'] = $bor_value->ca_group;
                                $comp_custinfo_array[$key_2]['ca_class'] = $bor_value->ca_class;
                                $comp_custinfo_array[$key_2]['auto_id'] = $bor_value->auto_id;
                                $comp_custinfo_array[$key_2]['cg_customer_name'] = $bor_value->cg_customer_name;
                                $comp_custinfo_array[$key_2]['cg_latitude'] = $bor_value->cg_latitude;
                                $comp_custinfo_array[$key_2]['cg_longitude'] = $bor_value->cg_longitude;
                                $comp_custinfo_array[$key_2]['otpStatus'] = $bor_value->otpStatus;
                                
                                $custid_array = array();
                                array_push($custid_array,$bor_value->customer_code);

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
                                    'status' =>'Approved',
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
                            $test_result_array['billed_outlets'] = $comp_custinfo_array;
                        
                            
                        }else{
                            $billed_outlet = 0;
                            // $test_result_array[$key_m]['billed_outlets'] = 0;
                            $test_result_array['billed_outlets'] =[];
                            
                        }

                        // return $custid_array;
                        // return $billed_custid_array;
                        $unbilled_outlet_id=array_diff($custid_ind_array,$billed_custid_array);

                        if(count($unbilled_outlet_id) !=0){
                            
                            $form_credentials = array(
                                'distributor_code' => $request->input( 'distributor_code' ),
                                'salesman_code' => $request->input( 'salesman_code' ),
                                'from_created_at' => $result[0]->from_date,
                                'to_created_at' =>  $result[0]->to_date,
                                'customer_code' =>$unbilled_outlet_id,
                                'ca_approval_status' =>'Approved',

                            );
                            
                            $gcjcd_result_pen = $this->orderrepo->get_jc_customer_details($form_credentials );
                            if(count($gcjcd_result_pen) !=0){
                                $unbilled_outlet = count($gcjcd_result_pen);
                                // $test_result_array[$key_m]['unbilled_outlets'] =$unbilled_outlet;

                                // pending outlets array 
                                $pending_custinfo_array = array();

                                // return $gcjcd_result_pen;
                                foreach ($gcjcd_result_pen as $key_1 => $grp_value) {

                                    $pending_custinfo_array[$key_1]['customer_code'] = $grp_value->cg_customer_code;
                                    $pending_custinfo_array[$key_1]['salesman_code'] = $grp_value->cg_salesman_code;
                                    $pending_custinfo_array[$key_1]['distributor_code'] = $grp_value->cg_distributor_branch;
                                    $pending_custinfo_array[$key_1]['cg_distance'] = $grp_value->cg_distance;
                                    $pending_custinfo_array[$key_1]['ca_channel'] = $grp_value->ca_channel;
                                    $pending_custinfo_array[$key_1]['ca_subchannel'] = $grp_value->ca_subchannel;
                                    $pending_custinfo_array[$key_1]['ca_group'] = $grp_value->ca_group;
                                    $pending_custinfo_array[$key_1]['ca_class'] = $grp_value->ca_class;
                                    $pending_custinfo_array[$key_1]['target_amount'] = $grp_value->target_amount;

                                    $pending_custinfo_array[$key_1]['auto_id'] = $grp_value->auto_id;
                                    $pending_custinfo_array[$key_1]['cg_customer_name'] = $grp_value->cg_customer_name;
                                    $pending_custinfo_array[$key_1]['cg_latitude'] = $grp_value->cg_latitude;
                                    $pending_custinfo_array[$key_1]['cg_longitude'] = $grp_value->cg_longitude;
                                    $pending_custinfo_array[$key_1]['otpStatus'] = $grp_value->otpStatus;

                                    $custid_array = array();
                                    array_push($custid_array,$grp_value->cg_customer_code);
                                    
                                    $form_credentials = array(
                                        'distributor_code' => $request->input( 'distributor_code' ),
                                        'salesman_code' => $request->input( 'salesman_code' ),
                                        'from_created_at' => $result[0]->from_date,
                                        'to_created_at' =>  $result[0]->to_date,
                                        'customer_code' =>$custid_array,
                                        'status' =>'Approved',
                                        'ca_approval_status' =>'Approved',
                                    );
                                    $gcjcd_result_app1 = $this->orderrepo->get_jc_customer_order_details($form_credentials );
                                    $gcjcd_result_app1 = json_decode(json_encode($gcjcd_result_app1), true);

                                    $cust_achieved_amount = array_sum(array_column($gcjcd_result_app1, 'total_amount'));

                                    $pending_custinfo_array[$key_1]['orders_confirmed'] = count($gcjcd_result_app1);
                                    $pending_custinfo_array[$key_1]['achieved_amount'] = $cust_achieved_amount;

                                    // return ($gcjcd_result_app1);
                                    $form_credentials = array(
                                        'distributor_code' => $request->input( 'distributor_code' ),
                                        'salesman_code' => $request->input( 'salesman_code' ),
                                        'from_created_at' => $result[0]->from_date,
                                        'to_created_at' =>  $result[0]->to_date,
                                        'customer_code' =>$custid_array,
                                        'status' =>'Pending',
                                        'ca_approval_status'=>'Approved'
                                    );
                                    
                                    $gcjcd_result_pen1 = $this->orderrepo->get_jc_customer_order_details($form_credentials );
                                    
                                    $total_order_taken = count($gcjcd_result_app1) + count($gcjcd_result_pen1);
                                    $pending_custinfo_array[$key_1]['total_orders_taken'] = $total_order_taken;
                                    
                                    if($grp_value->target_amount >=$cust_achieved_amount){
                                        $target_balance = $grp_value->target_amount - $cust_achieved_amount;
                                    }elseif ($grp_value->target_amount < $cust_achieved_amount) {
                                        $target_balance = 0;
                                    }else{
                                        $target_balance=0;
                                    }
                                    $pending_custinfo_array[$key_1]['target_balance'] = $target_balance;

                                    
                                    // get average of l3m
                                    $last_three_month_date = Carbon::now()->subMonth(3);
                                    $form_credentials_ltm = array(
                                        'distributor_code' => $request->input( 'distributor_code' ),
                                        'salesman_code' => $request->input( 'salesman_code' ),
                                        'from_created_at' => $last_three_month_date,
                                        'customer_code' =>$custid_array,
                                        'status' =>'Approved',
                                    );
                                    
                                    $last_three_month_result = $this->orderrepo->last_three_month_average($form_credentials_ltm );
                                    if(count($last_three_month_result) !=0){
                                        $last_three_month_avg = ($last_three_month_result[0]->total_amount) / 3;
                                    }else{
                                        $last_three_month_avg=0;
                                    }
                                    
                                    $pending_custinfo_array[$key_1]['last_three_month_avg'] = round($last_three_month_avg);

                                    // get customer freequency
                                    $where2=array();
                                    $where2[] = ['s.distributor_code', '=', $request->input( 'distributor_code' )];
                                    $where2[] = ['s.salesman_code', '=', $request->input( 'salesman_code' )];
                                    $where2[] = ['s.customer_code', '=', $custid_array];
                                    $where2[] = ['s.jc_month', '=', $result[0]->jc];
                                    
                                    $cus_freq_result = $this->orderrepo->get_customer_frequency($where2 );

                                    if(count($cus_freq_result) !=0){
                                        // get_coverage details
                                        if($cus_freq_result[0]->frequency == 'Daily'){

                                            $total_coverage = 28;
                                            // get covered coverage details
                                            $covered_coverage_result = $this->orderrepo->salesman_marketvisit_coverage($form_credentials);

                                            $coverage_output = $covered_coverage_result." / ".$total_coverage;

                                        }elseif ($cus_freq_result[0]->frequency == 'Weekly') {
                                            
                                            $total_coverage = 4;
                                            $covered_coverage_result = $this->orderrepo->salesman_marketvisit_coverage($form_credentials );
                                            $coverage_output = $covered_coverage_result." / ".$total_coverage;
                                            
                                        }else{

                                            $total_coverage = 1;
                                            $covered_coverage_result = $this->orderrepo->salesman_marketvisit_coverage($form_credentials);
                                            $coverage_output = $covered_coverage_result." / ".$total_coverage;

                                        }

                                        $pending_custinfo_array[$key_1]['coverage_output'] = $coverage_output;

                                        // get productivity details
                                        
                                            $order_productivity_count = $total_order_taken;

                                            // get sales return count
                                            $sales_retun_result = $this->orderrepo->salesman_sales_return_count($form_credentials);
                                            $salesreturn_productivity_count = $sales_retun_result;


                                        $pending_custinfo_array[$key_1]['order_productivity_count'] = $order_productivity_count;
                                        $pending_custinfo_array[$key_1]['salesreturn_productivity_count'] = $salesreturn_productivity_count;
                                    }
                                    else{
                                        $pending_custinfo_array[$key_1]['coverage_output'] = "0 / 0";
                                        $pending_custinfo_array[$key_1]['order_productivity_count'] = "0";
                                        $pending_custinfo_array[$key_1]['salesreturn_productivity_count'] = "0";

                                    }
                                    

                                    
                                }
                                $test_result_array['unbilled_outlets'] =$pending_custinfo_array;
                                
                            }else{

                                $unbilled_outlet = 0;
                                // $test_result_array[$key_m]['unbilled_outlets'] =0;
                                $test_result_array['unbilled_outlets'] =[];
                                
                            }
                            
                            
                        }
                        else{

                            $unbilled_outlet = 0;
                            // $test_result_array[$key_m]['unbilled_outlets'] =0;
                            $test_result_array['unbilled_outlets'] =[];
                            
                        }
                        
                        // $test_result_array = array_values($test_result_array);

                        $status = 'true';
                        $message = 'Data Found';
                    }
                    else{
                        $status = 'false1';
                        $message = 'No Data Found';
                        $test_result_array = [];
                    }

                }else{
                    $status = 'false';
                    $message = 'No Data Found';
                    $test_result_array = [];
                
                }

                return response()->json([
                    'status'=>$status,
                    'message'=>$message,
                    // 'result'=>$result,
                    'result_array'=>$test_result_array,
                    

                ]);
            } catch (\Execption $e) {
                $status = 'false';
                $message = $e;
                $test_result_array = [];
                
            
                return response()->json([
                    'status'=>$status,
                    'message'=>$message,
                    // 'result'=>$result,
                    'result_array'=>$test_result_array,

                ]);
            }
            
        }

        public function get_other_beats_byroute_billed_outlet(Request $request){

            try {
                
                $distributor_code = $request->input( 'distributor_code' );
                $salesman_code = $request->input( 'salesman_code' );
                $route_code = $request->input( 'route_code' );

                $current_date = date('Y-m-d');
                // $current_date = '2022-09-21';
                $where=array();
                $where[] = ['from_date', '<=', $current_date];
                $where[] = ['to_date', '>=', $current_date];

                $result = $this->salerepo->get_pjp_jcmonth( $where );

                if(count($result) !=0){

                    $form_credentials_cb = array(
                        'distributor_code' => $distributor_code,
                        'salesman_code' => $salesman_code,
                        'route_code' => $route_code,
                        'ca_approval_status' =>'Approved',
                    );
                    $gcjcb_result = $this->orderrepo->get_other_customer_byroute($form_credentials_cb );
                    
                    if(count($gcjcb_result) !=0){
                        $test_result_array = [];
                        $custid_ind_array = [];
                        foreach ($gcjcb_result as $key1 => $gcjcb_value) {
                            array_push($custid_ind_array,$gcjcb_value->cg_customer_code);
                        }
                        
                        $order_status_array = ["Approved","Pending"];

                        foreach ($order_status_array as $key_os => $os_value) {
                            // get approved order
                            $form_credentials = array(
                                'distributor_code' => $request->input( 'distributor_code' ),
                                'salesman_code' => $request->input( 'salesman_code' ),
                                'from_created_at' => $result[0]->from_date,
                                'to_created_at' =>  $result[0]->to_date,
                                'customer_code' =>$custid_ind_array,
                                'status' => $os_value,
                                'ca_approval_status' =>'Approved',

                            );

                            $approved_order_result = $this->orderrepo->get_jc_customer_app_order($form_credentials );

                            if(count($approved_order_result) !=0){
                                $comp_custinfo_array = array();

                                foreach ($approved_order_result as $key_2 => $bor_value) {
                                    $comp_custinfo_array[$key_2]['customer_code'] = $bor_value->customer_code;
                                    $comp_custinfo_array[$key_2]['salesman_code'] = $bor_value->salesman_code;
                                    $comp_custinfo_array[$key_2]['distributor_code'] = $bor_value->distributor_code;
                                    $comp_custinfo_array[$key_2]['cg_distance'] = $bor_value->cg_distance;
                                    $comp_custinfo_array[$key_2]['ca_channel'] = $bor_value->ca_channel;
                                    $comp_custinfo_array[$key_2]['ca_subchannel'] = $bor_value->ca_subchannel;
                                    $comp_custinfo_array[$key_2]['ca_group'] = $bor_value->ca_group;
                                    $comp_custinfo_array[$key_2]['ca_class'] = $bor_value->ca_class;
                                    $comp_custinfo_array[$key_2]['auto_id'] = $bor_value->auto_id;
                                    $comp_custinfo_array[$key_2]['cg_customer_name'] = $bor_value->cg_customer_name;
                                    $comp_custinfo_array[$key_2]['cg_latitude'] = $bor_value->cg_latitude;
                                    $comp_custinfo_array[$key_2]['cg_longitude'] = $bor_value->cg_longitude;
                                    $comp_custinfo_array[$key_2]['otpStatus'] = $bor_value->otpStatus;
                                    
                                    $custid_array = array();
                                    array_push($custid_array,$bor_value->customer_code);

                                    $form_credentials = array(
                                        'distributor_code' => $request->input( 'distributor_code' ),
                                        'salesman_code' => $request->input( 'salesman_code' ),
                                        'from_created_at' => $result[0]->from_date,
                                        'to_created_at' =>  $result[0]->to_date,
                                        'customer_code' =>$custid_array,
                                        'status' =>'Approved',
                                        'ca_approval_status'=>'Approved'
                                    );
                                    $gcjcd_result_app1 = $this->orderrepo->get_jc_customer_order_details($form_credentials );
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
                                        'ca_approval_status'=>'Approved'
                                    );
                                    
                                    $gcjcd_result_pen1 = $this->orderrepo->get_jc_customer_order_details($form_credentials );
                                    
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
                                        'status' =>'Approved',
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
                                $result_key = $os_value."_order";
                                $test_result_array[$result_key] = $comp_custinfo_array;
                            
                                
                                
                            }else{
                                $result_key = $os_value."_order";

                                $test_result_array[$result_key] =[];

                            }
                        }
                        

                        $status = 'true';
                        $message = 'Data Found';
                    }
                    else{
                        $status = 'false1';
                        $message = 'No Data Found';
                        $test_result_array = [];
                    }
                }else{
                    $status = 'false';
                    $message = 'No Data Found';
                    $test_result_array = [];
                }
                return response()->json([
                    'status'=>$status,
                    'message'=>$message,
                    // 'result'=>$result,
                    'result_array'=>$test_result_array,
                    

                ]);
            }
            catch (\Execption $e) {
                $status = 'false';
                $message = $e;
                $test_result_array = [];
                
            
                return response()->json([
                    'status'=>$status,
                    'message'=>$message,
                    // 'result'=>$result,
                    'result_array'=>$test_result_array,

                ]);
            }
        }
        // 27-09

    //ganagavathy


    //Leelavinothan
    // 26/09
    public function previous_orders(Request $request){
        $data = array(
            'salesman_code' => $request->salesman_code,
            'distributor_code' => $request->distributor_code,
            'customer_code' => $request->customer_code,
        );
        // $result = $this->orderrepo->previous_orders( $data );
        // return $result;
        try {
            $result = $this->orderrepo->previous_orders( $data );
                if( empty($result) ){
                    $status = 'false';
                    $message = 'No Data Found';
                    $result = [];
                    return response()->json([
                        'status'=>$status,
                        'message'=>$message,
                        'result'=> $result,
                    ]);
                }else if( $result['message'] == 'success' ){
                    $status = 'true';
                    $message = $result['message'];
                        return response()->json([
                            'status'=> $status,   
                            'message'=> $message,
                            'result'=> $result['ord'],
                        ]);
                }else{
                    $status = 'false';
                    $message = $result['message'];
                    $result = [];
                        return response()->json([
                            'status'=>$status,   
                            'message'=>$message,
                            'result'=> $result,
                        ]);
                }
        }catch (\Exception $e) {
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
        $data = array(
            'salesman_code' => $request->salesmanCode,
            'distributor_code' => $request->distributorCode,
          //  'customer_code' => $request->customerCode,
        );
        // $result = $this->orderrepo->all_status_orders( $data );
        // return $result;
        try {
            $result = $this->orderrepo->all_status_orders( $data );
                if( empty($result) ){
                    $status = 'false';
                    $message = 'No Data Found';
                    $result = [];
                    return response()->json([
                        'status'=>$status,
                        'message'=>$message,
                        'result'=>'',
                    ]);
                }elseif( $result['message'] == 'success' ){
                    $status = 'true';
                    $message = $result['message'];
                    unset($result['message']);
                        return response()->json([
                            'status'=>$status,   
                            'message'=>$message,
                            'result'=>$result,
                        ]);
                }else{
                    $status = 'false';
                    $message = $result['message'];
                        return response()->json([
                            'status'=>$status,   
                            'message'=>$message,
                            'result'=>'',
                        ]);
                }
        }catch (\Exception $e) {
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
    public function current_last_month_sales(Request $request){
        $data = array(
            'salesman_code' => $request->salesmanCode,
        );
        // $result = $this->orderrepo->current_last_month_sales( $data );
        // return $result;
        try {
            $result = $this->orderrepo->current_last_month_sales( $data );
                if( !empty($result) ){
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
        }catch (\Exception $e) {
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
    // 

    
    
}
