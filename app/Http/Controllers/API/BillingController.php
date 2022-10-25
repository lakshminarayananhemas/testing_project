<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Billing\IBillingRepository; 
use App\Repositories\Distributor\IDistributorRepository; 
use App\Repositories\Common\ICommonRepository; 

use App\Models\Route;
use DB;
use PDF;
use File;

class BillingController extends Controller
{
    public function __construct(IDistributorRepository $distrepo,IBillingRepository $billrepo,ICommonRepository $crepo)
    {
        $this->distrepo = $distrepo;
        $this->billrepo = $billrepo;
        $this->crepo = $crepo;

    }

    // ganagavathy github changes
    public function test(){
        $status = "approved";

        return $status;
    }

    public function test1(){
        $status = "approved";

        return $status;
    }
    // ganagavathy github changes


    // ganaga

    public function get_salesman_by_distributor(Request $request){

        try {

            $where=array();
            $where[] = ['distributor_code', '=', $request->input( 'distributor_code' )];
            
            $result = $this->billrepo->get_salesman_by_distributor( $where);

 
            if(count($result) >0){
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
        }catch (\Exception $e) {
            $status = 'false';
            $message = $e;
            $result = [];

            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);
        }
    }

    public function get_route_by_salesman(Request $request){
        
        try {

            $form_credentials = array(
                'distributor_code' => $request->input( 'distributor_code' ),
                'salesman_code' => $request->input( 'salesman_code' ),
            );
           
            $result = $this->billrepo->get_route_by_salesman( $form_credentials);

            if(count($result) >0){
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
        }catch (\Exception $e) {
            $status = 'false';
            $message = $e;
            $result = [];

            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);
        }
    }

    public function get_customer_by_route(Request $request){
        try {

            $form_credentials = array(
                'distributor_code' => $request->input( 'distributor_code' ),
                'salesman_code' => $request->input( 'salesman_code' ),
                'route_code' => $request->input( 'route_code' ),
            );
            
            $result = $this->billrepo->get_customer_by_route( $form_credentials);

            if(count($result) >0){
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
        }catch (\Exception $e) {
            $status = 'false';
            $message = $e;
            $result = [];

            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);
        }
    }

    public function get_product_listby_distributor(Request $request){
        try {

            $form_credentials = array(
                'distributor_code' => $request->input( 'distributor_code' ),
            );
            
            $result = $this->billrepo->get_product_listby_distributor( $form_credentials);

            if(count($result) >0){
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
        }catch (\Exception $e) {
            $status = 'false';
            $message = $e;
            $result = [];

            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);
        }
    }

    public function get_product_info(Request $request){
        try {

            $form_credentials = array(
                'distributor_code' => $request->input( 'distributor_code' ),
                'product_code' => $request->input( 'product_code' ),
            );
            // return $form_credentials;
            $result = $this->billrepo->get_product_info( $form_credentials);

            if(count($result) >0){
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
        }catch (\Exception $e) {
            $status = 'false';
            $message = $e;
            $result = [];

            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);
        }
    }

    public function create_billing(Request $request){
        
        try {

            $form_credentials = array(
                'salesman_code' => $request->input( 'salesman_code' ),
                'route_code' => $request->input( 'route_code' ),
                'customer_code' => $request->input( 'customer_code' ),
                'distributor_code' => $request->input( 'distributor_code' ),
                'order_qty' => $request->input( 'order_qty' ),
                'cash_dist_amt' => $request->input( 'cash_dist_amt' ),
                'scheme_dist_amt' => $request->input( 'scheme_dist_amt' ),
                'total_invoice_qty' => $request->input( 'total_invoice_qty' ),
                'credit_note_adjustment' => $request->input( 'credit_note_adjustment' ),
                'debit_note_adjustment' => $request->input( 'debit_note_adjustment' ),
                'gross_amount' => $request->input( 'gross_amount' ),
                'total_addition' => $request->input( 'total_addition' ),
                'total_deduction' => $request->input( 'total_deduction' ),
                'net_amount' => $request->input( 'net_amount' ),
                'product_code' => $request->input( 'product_code' ),
                'product_name' => $request->input( 'product_name' ),
                'batch' => $request->input( 'batch' ),
                'expiry_date' => $request->input( 'expiry_date' ),
                'order' => $request->input( 'order' ),
                'order_qty' => $request->input( 'order_qty' ),
                'inv_qty' => $request->input( 'inv_qty' ),
                'mrp' => $request->input( 'mrp' ),
                'sell_rate' => $request->input( 'sell_rate' ),
                'gross_amt' => $request->input( 'gross_amt' ),
                'line_disc_amt' => $request->input( 'line_disc_amt' ),
                'tax_amt' => $request->input( 'tax_amt' ),
                'net_rate' => $request->input( 'net_rate' ),
                'net_amt' => $request->input( 'net_amt' ),
                'order_date' => date('Y-m-d'),
                'order_status' => 'Pending',
            );
            // return $form_credentials;


            $invoice_number = $this->billrepo->create_billing( $form_credentials);

            // get cust and dist data for invoice
            
            $invoice_data = array(
                'item_count' => count($request->input( 'product_code' )),
                'invoice_number' => $invoice_number,
                'invoice_date' => date('d/m/Y'),
                'salesman_code' => $request->input( 'salesman_code' ),
                'route_code' => $request->input( 'route_code' ),
                'customer_code' => $request->input( 'customer_code' ),
                'distributor_code' => $request->input( 'distributor_code' ),
                'order_qty' => $request->input( 'order_qty' ),
                'cash_dist_amt' => $request->input( 'cash_dist_amt' ),
                'scheme_dist_amt' => $request->input( 'scheme_dist_amt' ),
                'total_invoice_qty' => $request->input( 'total_invoice_qty' ),
                'credit_note_adjustment' => $request->input( 'credit_note_adjustment' ),
                'debit_note_adjustment' => $request->input( 'debit_note_adjustment' ),
                'gross_amount' => $request->input( 'gross_amount' ),
                'total_addition' => $request->input( 'total_addition' ),
                'total_deduction' => $request->input( 'total_deduction' ),
                'net_amount' => $request->input( 'net_amount' ),
                'product_code' => $request->input( 'product_code' ),
                'hsn_code' => $request->input( 'hsn_code' ),
                'product_name' => $request->input( 'product_name' ),
                'batch' => $request->input( 'batch' ),
                'expiry_date' => $request->input( 'expiry_date' ),
                'order' => $request->input( 'order' ),
                'order_qty' => $request->input( 'order_qty' ),
                'inv_qty' => $request->input( 'inv_qty' ),
                'mrp' => $request->input( 'mrp' ),
                'sell_rate' => $request->input( 'sell_rate' ),
                'gross_amt' => $request->input( 'gross_amt' ),
                'line_disc_amt' => $request->input( 'line_disc_amt' ),
                'tax_amt' => $request->input( 'tax_amt' ),
                'net_rate' => $request->input( 'net_rate' ),
                'net_amt' => $request->input( 'net_amt' ),
            );

            $pdf = PDF::loadView('billing', $invoice_data)->setPaper('a4', 'landscape');
            $path = public_path().'/uploads/billing_invoice/'.$request->input( 'distributor_code' );
            File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
            $fileName = $invoice_number. '.' . 'pdf';
            $pdf->save($path . '/' . $fileName);

            $offer_letter_filename = '/billing_invoice/'.$request->input( 'distributor_code' ).'/'.$fileName;


            if($invoice_number !=''){
                $status = 'true';
                $message = 'success';
                $result = 200; 
                $file_path = $offer_letter_filename;
            }else{
                $status = 'false';
                $message = 'No Data Found';
                $result = $invoice_number;
                $file_paths = '';

            }
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
                'file_path'=>$file_path,
            ]);
        }catch (\Exception $e) {
            $status = 'false';
            $message = $e;
            $result = [];
            $file_path = '';
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
                'file_path'=>$file_path,

            ]);
        }

    }

    public function get_billing_list(Request $request){

        $where=array();
        $where[] = ['ob.distributor_code', '=', $request->input( 'distributor_code' )];
        $result = $this->billrepo->get_billing_list( $where );

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
    }
    public function get_billing_info(Request $request){

        $form_credentials = array(
            'order_id' => $request->input( 'order_id' ),
        );
       
        $result = $this->billrepo->get_billing_info( $form_credentials );

        $where=array();
        $where[] = ['ob.order_id', '=',  $request->input( 'order_id' )];
        $result_bl = $this->billrepo->get_billing_list( $where );

            if(!empty($result)){
                $status = 'true';
                $message = 'success';
                $result = $result; 
                $result_bl = $result_bl; 
            }else{
                $status = 'false';
                $message = 'No Data Found';
                $result = $result;
                $result_bl = $result_bl;
            }
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
                'result_bl'=>$result_bl,
            ]);
    }


   
    // ganaga end

}
