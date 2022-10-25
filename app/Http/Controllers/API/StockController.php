<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\Stock\IStockRepository; 


class StockController extends Controller
{
    //
    public function __construct(IStockRepository $stockrepo)
    {
        $this->stockrepo = $stockrepo;
    }

    public function dis_current_stock_report_list(Request $request){
        $pass_data = array(
            'distributor_code' => $request->input( 'distributor_code' ),
        );
        $result = $this->stockrepo->get_dis_stock_report($pass_data);

        return $result;
    }
}
