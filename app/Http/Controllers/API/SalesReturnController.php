<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\SalesReturn\ISalesReturnRepository; 

class SalesReturnController extends Controller
{
    
    public function __construct(ISalesReturnRepository $salereturnrepo)
    {
        $this->salereturnrepo = $salereturnrepo;

    }
    // ganaga
    public function sales_return_list(Request $request){

        try {

            if($request->input( 'user_type' ) =='Admin'){

                $where=array();
        
            }elseif ($request->input( 'user_type' ) =='Distributor') {

                $where=array();
                $where[] = ['distributor_code', '=', $request->input( 'distributor_code' )];

            }else{
                $where=array();
            }
            $result = $this->salereturnrepo->getSalesReturn( $where );

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

    public function get_salesreturn_items($sales_return_id){

        $result = $this->salereturnrepo->get_salesreturn_items($sales_return_id );

        return $result;
    }
    // ganaga
}
