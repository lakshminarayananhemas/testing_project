<?php 

namespace App\Repositories\SalesReturn;

use DB;

class SalesReturnRepository implements ISalesReturnRepository
{
    public function getSalesReturn($where){

        $result = DB::table('sales_returns as sr')
        ->select('sr.*')
        ->where($where) 
        // ->groupBy('td.district_name')
        ->get();

        return $result;
    }

    public function get_salesreturn_items($sales_return_id ){
        $result = DB::table('sales_return_items as sri')
        ->select('sri.*')
        ->where('sri.sales_return_id','=', $sales_return_id) 
        // ->groupBy('td.district_name')
        ->get();

        return $result;
    }

}