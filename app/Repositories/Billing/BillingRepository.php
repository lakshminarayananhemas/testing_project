<?php 

namespace App\Repositories\Billing;

use DB;
use App\Models\OrderBilling;
use App\Models\OrderBillingItem;


class BillingRepository implements IBillingRepository
{
    //ganaga 09-10 
    public function get_salesman_by_distributor($where){
        $results = DB::table('salesman_infos as si')
        ->select('si.*')
        ->where($where) 
        // ->groupBy('cd.ClassCode')
        ->get();

        return $results;
    }

    public function get_route_by_salesman( $form_credentials){

        $record=  DB::table('salesman_route_mappings as smrt')
        ->join('routes as route', 'route.route_code','=','smrt.route_code')
        ->select('smrt.route_code','route.route_name')
        ->where('smrt.distributor_code',$form_credentials['distributor_code'])
        ->where('smrt.salesman_code',$form_credentials['salesman_code'])
        ->orderBy('smrt.created_at', 'desc' )
        ->get();
        return $record;
    }

    public function get_customer_by_route( $form_credentials){
        
        $result = DB::table('customer_generals as cg')
        ->leftjoin('customer_coverage_attributes as ca', 'ca.cg_id','=','cg.auto_id')
        ->select('cg.*')
        ->where('cg.cg_distributor_branch','=', $form_credentials['distributor_code']) 
        ->where('cg.cg_salesman_code','=', $form_credentials['salesman_code']) 
        ->where('ca.ca_sales_route', $form_credentials['route_code'])
        ->get();

        return $result;

    }

    public function get_product_listby_distributor( $form_credentials){

        $result = DB::table('distributor__stock_reports as dsr')
        ->leftjoin('products as p', 'p.product_code','=','dsr.product_code')
        ->select('dsr.*','p.*')
        ->where('dsr.distributorcode','=', $form_credentials['distributor_code']) 
        ->get();

        return $result;

    }

    public function get_product_info( $form_credentials){
        $result = DB::table('products as p')
        ->leftjoin('distributor__stock_reports as dsr', 'p.product_code','=','dsr.product_code')
        ->select('dsr.*','p.*')
        ->where('dsr.distributorcode','=', $form_credentials['distributor_code']) 
        ->where('dsr.product_code','=', $form_credentials['product_code']) 
        ->groupBy('dsr.product_code')
        ->get();

        return $result;
    }

    public function create_billing( $form_credentials){
        

        $cg_input = new OrderBilling;
        $cg_input->order_id = 'OB'.str_pad( ( $cg_input->max( 'id' )+1 ), 9, '0', STR_PAD_LEFT );
        $cg_input->distributor_code = $form_credentials['distributor_code'];
        $cg_input->salesman_code = $form_credentials['salesman_code'];
        $cg_input->route_code = $form_credentials['route_code'];
        $cg_input->customer_code = $form_credentials['customer_code'];
        $cg_input->invoice_no = 'CKBIL'.str_pad( ( $cg_input->max( 'id' )+1 ), 4, '0', STR_PAD_LEFT );;;
        $cg_input->cash_dist_amt = $form_credentials['cash_dist_amt'];
        $cg_input->scheme_dist_amt = $form_credentials['scheme_dist_amt'];
        $cg_input->total_invoice_qty = $form_credentials['total_invoice_qty'];
        $cg_input->credit_note_adjustment = $form_credentials['credit_note_adjustment'];
        $cg_input->debit_note_adjustment = $form_credentials['debit_note_adjustment'];
        $cg_input->gross_amount = $form_credentials['gross_amount'];
        $cg_input->total_addition = $form_credentials['total_addition'];
        $cg_input->total_deduction = $form_credentials['total_deduction'];
        $cg_input->net_amount = $form_credentials['net_amount'];
        $cg_input->order_date = $form_credentials['order_date'];
        $cg_input->order_status = $form_credentials['order_status'];
        $cg_input->save();

        $lastInsertedId = $cg_input->order_id;

        $billing_items = [];
        for ($i=0; $i < count($form_credentials['product_code']); $i++) { 
            $billing_items[] = [
                'order_id' => $lastInsertedId,
                'product_code' => $form_credentials['product_code'][$i],
                'product_name' => $form_credentials['product_name'][$i],
                'batch' => $form_credentials['batch'][$i],
                'exp_date' => $form_credentials['expiry_date'][$i],
                'order' => $form_credentials['order'][$i],
                'order_qty' => $form_credentials['order_qty'][$i],
                'inv_qty' => $form_credentials['inv_qty'][$i],
                'mrp' => $form_credentials['mrp'][$i],
                'sell_rate' => $form_credentials['sell_rate'][$i],
                'gross_amt' => $form_credentials['gross_amt'][$i],
                'line_disc_amt' => $form_credentials['line_disc_amt'][$i],
                'tax_amt' => $form_credentials['tax_amt'][$i],
                'net_rate' => $form_credentials['net_rate'][$i],
                'net_amt' => $form_credentials['net_amt'][$i],
            ];

            // $oi_input = new OrderBillingItem;
            // $oi_input->order_id = $lastInsertedId;
            // $oi_input->product_code = $form_credentials['product_code'][$i];
            // $oi_input->product_name = $form_credentials['product_name'][$i];
            // $oi_input->batch = $form_credentials['batch'][$i];
            // $oi_input->expiry_date = $form_credentials['expiry_date'][$i];
            // $oi_input->order = $form_credentials['order'][$i];
            // $oi_input->order_qty = $form_credentials['order_qty'][$i];
            // $oi_input->inv_qty = $form_credentials['inv_qty'][$i];
            // $oi_input->mrp = $form_credentials['mrp'][$i];
            // $oi_input->sell_rate = $form_credentials['sell_rate'][$i];
            // $oi_input->gross_amt = $form_credentials['gross_amt'][$i];
            // $oi_input->line_disc_amt = $form_credentials['line_disc_amt'][$i];
            // $oi_input->net_rate = $form_credentials['net_rate'][$i];
            // $oi_input->net_amt = $form_credentials['net_amt'][$i];
            // $oi_input->save();

        }
        OrderBillingItem::insert($billing_items);

        if($cg_input) {

            return $lastInsertedId;
        } else {

            return $lastInsertedId;

        }
    }

    public function get_billing_list( $form_credentials ){

        $result = DB::table('order_billings as ob')
        ->leftjoin('salesman_infos as si', 'si.salesman_code','=','ob.salesman_code')
        ->leftjoin('routes as r', 'r.route_code','=','ob.route_code')
        ->leftjoin('customer_generals as cg', 'cg.cg_customer_code','=','ob.customer_code')
        ->select('ob.*','si.salesman_name','r.route_name','cg.cg_customer_name')
        ->where($form_credentials ) 
        ->get();

        return $result;
    }

    public function get_billing_info( $form_credentials ){
        $result = DB::table('order_billing_items as obi')
        ->select('obi.*')
        ->where('obi.order_id','=', $form_credentials['order_id']) 
        ->get();

        return $result;
    }
    //ganaga 09-10 end 

}