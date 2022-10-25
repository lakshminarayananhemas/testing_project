<?php 

namespace App\Repositories\Stock;


use App\Models\Distributor_StockReport;
use DB;

class StockRepository implements IStockRepository
{
    public function get_dis_stock_report($data){

        $result = DB::table('distributor__stock_reports')
        ->select('*')
        ->where('distributorcode','=',$data['distributor_code']) 
        ->get();

        // $result = Distributor_StockReport::all();
        return $result;
    }


}