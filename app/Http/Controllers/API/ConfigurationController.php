<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Configuration\IConfigurationRepository; 

class ConfigurationController extends Controller
{
    public function __construct(IConfigurationRepository $configrepo)
    {
        $this->configrepo = $configrepo;

    }
     
    public function index(Request $request){
        try {

            $where=array();
            $where[] = ['fin_year', '!=', ""];
            $altec_jc_calendar = $this->configrepo->get_jc_calender( $where  );

            if(!empty($altec_jc_calendar)){
                $status = 'true';
                $message = 'success';
                $result = $altec_jc_calendar; 
            }else{
                $status = 'false';
                $message = 'No Data Found';
                $result = $altec_jc_calendar;
            }
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$altec_jc_calendar,
            ]);
        }
        catch (\Execption $e) {
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
}
