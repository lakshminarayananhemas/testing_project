<?php

namespace App\Http\Controllers\API;

use App\Models\Route;
use DB;
use PDF;
use File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Distributor\IDistributorRepository; 
use App\Repositories\Common\ICommonRepository; 

class CommonController extends Controller
{

    public function __construct(IDistributorRepository $distrepo,ICommonRepository $crepo)
    {
        $this->distrepo = $distrepo;
        $this->crepo = $crepo;

    }

    // g
    public function distributor_branchcode_list(){
        
        try {

            $result = $this->distrepo->fetch( );

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

    public function get_distributor_branchCode(Request $request){

        try {

            $where=array();
            $where[] = ['distributorcode', '=', $request->input( 'distributor_code' )];
            
            $result = $this->crepo->get_branchcode_by_distributor( $where);


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
    
    public function get_today_date(){
        $date=date('d/m/Y');
        $time=date('d/m/Y H:i:s');
        // $month=date("F",$time);
        // $year=date("Y",$time);

        $date_info=[
            'date'=>$date,
            'time'=>$time,
        ];

            return response()->json([
                'status'=>"Success",
                'message'=>$date_info,
            ]);
    }
    
    public function get_gststate_list(){

        try {

            $result = $this->crepo->fetch_gststate_list( );

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
            $result = 'Failed';

            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);
        }
    }

    public function get_country_list(){

        try {

            $result = $this->crepo->fetch_country_list( );

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
            $result = 'Failed';

            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);
        }

    }

    public function get_states_by_country($countryid){

        try {

            $result = $this->crepo->get_states_by_country($countryid );

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
            $result = 'Failed';

            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);
        }
    }

    public function get_city_by_state($stateid){

        try {

            $result = $this->crepo->get_city_by_state($stateid );

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
            $result = 'Failed';

            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);
        }
    }

    public function get_town_by_district($districtid){

        try {

            $result = $this->crepo->get_town_by_district($districtid );

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
            $result = 'Failed';

            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);
        }
    }

    public function get_postalcode_by_city($cityid){

        try {

            $result = $this->crepo->get_postalcode_by_city($cityid );

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
            $result = 'Failed';

            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'result'=>$result,
            ]);
        }
    }

    public function get_channel_list(){

        try {

            $result =$this->crepo->get_channel_list();
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

    public function get_channel_list_all(){
        $result = $this->crepo->get_channel_list_all( );
        return $result; 
    }

    public function get_group_list_all(){
        $result = $this->crepo->get_group_list_all( );
        return $result;
    }

    public function get_class_list_all(){
        $result = $this->crepo->get_class_list_all( );
        return $result;
    }

    public function get_subchannel_by_channel($channel_code){
        try {

            $where=array();
            $where[] = ['ChannelCode', '=', $channel_code];
            $where[] = ['SubChannelCode', '!=', ''];
            $result = $this->crepo->get_subchannel_by_channel($where );

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

    public function get_group_list($subchannel_code){
        try {

            $where=array();
            $where[] = ['SubChannelCode', '=', $subchannel_code];
            $where[] = ['GroupCode', '!=', ''];
            $result =$this->crepo->get_group_list($where);
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

    public function get_class_list($group_code){
        try {

            $where=array();
            $where[] = ['GroupCode', '=', $group_code];
            $where[] = ['ClassCode', '!=', ''];
            $result = $this->crepo->get_class_list( $where);
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
    
    // g



   
    //leelavinothan
    public function route_list(Request $request){
        try {
            $route_list = Route::get()->toArray();
                if(!empty($route_list)){
                        $status = 'true';
                        $message = 'success';
                        $result = $route_list; 
                    return response()->json([
                        'status'=>$status,
                        'message'=>$message,
                        'result'=>$result,
                    ]);
                }else{
                        $status = 'false';
                        $message = 'No Data Found';
                        $result = $route_list;
                    return response()->json([
                        'status'=>$status,
                        'message'=>$message,
                        'result'=>$result,
                    ]);
                }
            } catch (\Exception $e) {
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

    //channel list
    public function channel_list(Request $request){
        try {
            $channel_list = DB::table('channel_detailss')
                                ->get()->toArray();
                if(!empty($channel_list)){
                        $status = 'true';
                        $message = 'success';
                        $result = $channel_list; 
                    return response()->json([
                        'status'=>$status,
                        'message'=>$message,
                        'result'=>$result,
                    ]);
                }else{
                        $status = 'false';
                        $message = 'No Data Found';
                        $result = $channel_list;
                    return response()->json([
                        'status'=>$status,
                        'message'=>$message,
                        'result'=>$result,
                    ]);
                }
            } catch (\Exception $e) {
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

    public function country_list(Request $request){
        try {
            $country_list = DB::table('towns_details')
                                ->select('country_name','country_code')
                                ->groupBy('country_name','country_code')
                                ->get()->toArray();
                if(!empty($country_list)){
                        $status = 'true';
                        $message = 'success';
                        $result['country'] = $country_list; 
                    return response()->json([
                        'status'=>$status,
                        'message'=>$message,
                        'result'=>$result,
                    ]);
                }else{
                        $status = 'false';
                        $message = 'No Data Found';
                        $result = $route_list;
                    return response()->json([
                        'status'=>$status,
                        'message'=>$message,
                        'result'=>$result,
                    ]);
                }
            } catch (\Exception $e) {
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

    public function country_state_list(Request $request){
        try {
            $state_list = DB::table('towns_details')
                                ->where('country_code',$request->country_code)
                                ->select('state_name','state_code')
                                ->groupBy('state_name','state_code')
                                ->get()->toArray();
                if(!empty($state_list)){
                        $status = 'true';
                        $message = 'success';
                        $result['state'] = $state_list;
                    return response()->json([
                        'status'=>$status,
                        'message'=>$message,
                        'result'=>$result,
                    ]);
                }else{
                        $status = 'false';
                        $message = 'No Data Found';
                        $result = $route_list;
                    return response()->json([
                        'status'=>$status,
                        'message'=>$message,
                        'result'=>$result,
                    ]);
                }
            } catch (\Exception $e) {
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

    public function country_district_list(Request $request){
        try {
            $district_list = DB::table('towns_details')
                                ->where('district_code',$request->district_code)
                                ->select('district_name','district_code')
                                ->groupBy('district_name','district_code')
                                ->get()->toArray();
                if(!empty($district_list)){
                        $status = 'true';
                        $message = 'success';
                        $result['district'] = $district_list;
                    return response()->json([
                        'status'=>$status,
                        'message'=>$message,
                        'result'=>$result,
                    ]);
                }else{
                        $status = 'false';
                        $message = 'No Data Found';
                        $result = $route_list;
                    return response()->json([
                        'status'=>$status,
                        'message'=>$message,
                        'result'=>$result,
                    ]);
                }
            } catch (\Exception $e) {
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

    public function state_town_list(Request $request){
        try {
            $town_list = DB::table('towns_details')
                                ->where('state_code',$request->state_code)
                                ->select('town_name','town_code')
                                ->groupBy('town_name','town_code')
                                ->get()->toArray();
                if(!empty($town_list)){
                        $status = 'true';
                        $message = 'success';
                        $result['town'] = $town_list;
                    return response()->json([
                        'status'=>$status,
                        'message'=>$message,
                        'result'=>$result,
                    ]);
                }else{
                        $status = 'false';
                        $message = 'No Data Found';
                        $result = $route_list;
                    return response()->json([
                        'status'=>$status,
                        'message'=>$message,
                        'result'=>$result,
                    ]);
                }
            } catch (\Exception $e) {
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

    public function jtd_unbilled_outlets(Request $request){
        $data = array(
            'salesman_code' => $request->salesman_code,
        );
        // $result = $this->crepo->jtd_unbilled_outlets( $data );
        // return $result;
        try {
            $result = $this->crepo->jtd_unbilled_outlets( $data );
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


}
