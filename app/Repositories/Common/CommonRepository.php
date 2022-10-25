<?php 

namespace App\Repositories\Common;

use DB;

use App\Models\OrderBilling;
use App\Models\OrderBillingItem;


class CommonRepository implements ICommonRepository
{

    
    public function fetch_gststate_list(){
        $gststate_list = DB::table('g_s_t__state__masters as gs')
        ->select('gs.*')
        ->where('status','=', 'Active') 
        ->get();

        return $gststate_list;
    }

    public function fetch_country_list(){
        $country_list = DB::table('towns_details as td')
        ->select('td.*')
        ->groupBy('td.country_name')
        ->get();

        return $country_list;
    }

    public function get_states_by_country($countryid){

        $state_list = DB::table('towns_details as td')
        ->select('td.state_code','td.state_name')
        ->where('td.country_code','=', $countryid) 
        ->groupBy('td.state_name')
        ->get();

        return $state_list;
    }

    public function get_town_by_district($districtid ){

        $town_list = DB::table('towns_details as td')
        ->select('td.town_code','td.town_name')
        ->where('td.district_code','=', $districtid) 
        ->groupBy('td.town_name')
        ->get();

        return $town_list;
    }


    public function get_channel_list_all(){
        $results = DB::table('channel_details')
        ->select('ChannelName', 'ChannelCode', 'SubChannelName', 'SubChannelCode')
        ->groupBy('ChannelName', 'ChannelCode', 'SubChannelName', 'SubChannelCode')
        ->get();
        return $results;
    }
    public function get_group_list_all(){
        $results = DB::table('channel_details')
        ->select('ChannelName', 'GroupCode', 'GroupName')
        ->groupBy('ChannelName', 'GroupCode', 'GroupName')
        ->get();
        return $results;
    }
    public function get_class_list_all(){
        $results = DB::table('channel_details')
        ->select('GroupName', 'ClassCode', 'ClassName')
        ->groupBy('GroupName', 'ClassCode', 'ClassName')
        ->get();
        return $results;
    }



    public function get_city_by_state($stateid){

        $city_list = DB::table('towns_details as td')
        ->select('td.district_code','td.district_name')
        ->where('td.state_code','=', $stateid) 
        ->groupBy('td.district_name')
        ->get();

        return $city_list;
    }

    public function get_postalcode_by_city($cityid ){
        $city_list = DB::table('towns_details as td')
        ->select('td.postal_code')
        ->where('td.district_code','=', $cityid) 
        ->groupBy('td.district_name')
        ->get();

        return $city_list;
    }

   
    public function get_channel_list(){
        $results = DB::table('channel_details as cd')
        ->select('cd.*')
        ->groupBy('cd.ChannelCode')
        ->get();

        return $results;
    }

    public function get_subchannel_by_channel($where ){
        $results = DB::table('channel_details as cd')
        ->select('cd.*')
        ->where($where) 
        ->groupBy('cd.SubChannelCode')
        ->get();

        return $results;
    }

    public function get_group_list($where){
        $results = DB::table('channel_details as cd')
        ->select('cd.*')
        ->where($where) 
        ->groupBy('cd.GroupCode')
        ->get();

        return $results;
    }

    public function get_class_list($where){

        $results = DB::table('channel_details as cd')
        ->select('cd.*')
        ->where($where) 
        ->groupBy('cd.ClassCode')
        ->get();

        return $results;

    }

    

    

   
    
    public function get_branchcode_by_distributor($where){
        $results = DB::table('distributor__stock_reports as dsr')
        ->select('dsr.*')
        ->where($where) 
        ->groupBy('dsr.distributor_br_code')
        ->get();

        return $results;
    }

    
    // 26-09
    public function jtd_unbilled_outlets($data) {
        $today = date('Y-m-d');
        $jc_info = DB::table('altec_jc_calendars')
                            ->select('*')
                            ->whereRaw('? between from_date and to_date', [date('Y-m-d')])
                            ->first();
        // $jc_info = DB::table('altec_jc_calendars')
        //                     ->select('*')
        //                     ->where('jc_num',$jc_info->jc_num-2)
        //                     ->first();
        $jc_start_row = DB::table('altec_jc_calendars')
                            ->select('*')
                            ->where('jc', $jc_info->jc)
                            ->orderBy('jc_week_num','asc')->first();
        $jc_end_row = DB::table('altec_jc_calendars')
                            ->select('*')
                            ->where('jc', $jc_info->jc)
                            ->orderBy('jc_week_num','desc')->first();
        $salesman_cust = DB::table('customer_generals')
                            ->where('cg_salesman_code',$data['salesman_code'])
                            ->count();
        $ordered_outlet_count = DB::table('orders')
                                    ->where('salesman_code',$data['salesman_code'])
                                    ->select('customer_code')
                                    ->groupBy('customer_code')
                                    ->get()->count();
        $unbilled_outlet_count = $salesman_cust - $ordered_outlet_count;
        $jc_ordered_outlet_count = DB::table('orders')
                                    ->where('salesman_code',$data['salesman_code'])
                                    ->whereBetween('created_at', [$jc_start_row->from_date, $today])
                                    ->select('customer_code')
                                    ->groupBy('customer_code')                                        
                                    ->get()->count();
        $jc_unbilled_outlet_count = $salesman_cust - $jc_ordered_outlet_count;


        $customer_routes_with_jc_bw = DB::table('customer_generals as cg')
                                    ->leftJoin('customer_coverage_attributes as cc','cg.auto_id','=','cc.cg_id')
                                    // ->leftJoin('orders as o','cg.cg_customer_code','=','o.customer_code')
                                    // ->select('cg.cg_customer_code')
                                    // ->select(DB::raw('COUNT(cc.cg_id) as customer_count'),'cc.ca_sales_route')
                                    // ->groupBy('cc.ca_sales_route')
                                    // ->whereBetween('o.created_at', [$jc_start_row->from_date, $today])
                                    ->where('cg.cg_salesman_code',$data['salesman_code'])
                                    // ->tosql();
                                    ->pluck('cg.cg_customer_code')->toArray();
                                    // ->get();

        $all_customer_bw_jc = DB::table('customer_generals as cg')
                                // ->leftJoin('customer_coverage_attributes as cc','cg.auto_id','=','cc.cg_id')
                                ->leftJoin('orders as o','cg.cg_customer_code','=','o.customer_code')
                                // ->select('o.customer_code')
                                // ->select(DB::raw('COUNT(cc.cg_id) as customer_count'),'cc.ca_sales_route')
                                // ->groupBy('cg.cg_customer_code')
                                ->whereBetween('o.created_at', [$jc_start_row->from_date, $today])
                                ->where('cg.cg_salesman_code',$data['salesman_code'])
                                ->pluck('o.customer_code')->toArray();

        $customer_routes_with_jc = DB::table('customer_generals as cg')
                                    ->leftJoin('customer_coverage_attributes as cc','cg.auto_id','=','cc.cg_id')
                                    ->leftJoin('routes as r','r.route_code','=','cc.ca_sales_route')
                                    // ->leftJoin('orders as o','cg.cg_customer_code','=','o.customer_code')
                                    // ->select('cg.cg_customer_code','cc.ca_sales_route')
                                    ->select(DB::raw('COUNT(cg.auto_id) as customer_count'),'cc.ca_sales_route','r.route_name')
                                    ->groupBy('cc.ca_sales_route')
                                    // ->whereNotBetween('o.created_at', [$jc_start_row->from_date, $today])
                                    ->where('cg.cg_salesman_code',$data['salesman_code'])
                                    ->whereNotIn('cg.cg_customer_code',$all_customer_bw_jc)
                                    // ->tosql();
                                    ->get();
        $customer_routes_with_jc111 = DB::table('customer_generals as cg')
                                    ->leftJoin('customer_coverage_attributes as cc','cg.auto_id','=','cc.cg_id')
                                    // ->leftJoin('orders as o','cg.cg_customer_code','=','o.customer_code')
                                    ->select('cg.cg_customer_code')
                                    // ->select(DB::raw('COUNT(cc.cg_id) as customer_count'),'cc.ca_sales_route')
                                    // ->groupBy('cc.ca_sales_route')
                                    // ->whereNotBetween('o.created_at', [$jc_start_row->from_date, $today])
                                    ->where('cg.cg_salesman_code',$data['salesman_code'])
                                    ->whereNotIn('cg.cg_customer_code',$all_customer_bw_jc)
                                    // ->tosql();
                                    ->get();

        $result_cust =array_diff($customer_routes_with_jc_bw,$all_customer_bw_jc);
        $salesman_cust_code = DB::table('customer_generals')
                                ->where('cg_salesman_code',$data['salesman_code'])
                                ->pluck('cg_customer_code')->toArray();
        $ordered_cust_code = DB::table('orders')
                                ->where('salesman_code',$data['salesman_code'])
                                ->groupBy('customer_code')
                                ->pluck('customer_code')->toArray();
        $unordered_result_cust = array_diff($salesman_cust_code,$ordered_cust_code);
        $unord_customer_routes = DB::table('customer_generals as cg')
                                    ->leftJoin('customer_coverage_attributes as cc','cg.auto_id','=','cc.cg_id')
                                    ->leftJoin('routes as r','r.route_code','=','cc.ca_sales_route')
                                    ->select(DB::raw('COUNT(cg.auto_id) as customer_count'),'cc.ca_sales_route','r.route_name')
                                    ->groupBy('cc.ca_sales_route')
                                    ->where('cg.cg_salesman_code',$data['salesman_code'])
                                    ->whereIn('cg.cg_customer_code',$unordered_result_cust)
                                    ->get();
        $result1=[];
        // return $customer_routes_with_jc;
        foreach ($customer_routes_with_jc as $key => $value) {
            $ord_count = DB::table('customer_generals as cg')
                            ->leftJoin('customer_coverage_attributes as cc','cg.auto_id','=','cc.cg_id')
                            ->leftJoin('orders as o','cg.cg_customer_code','=','o.customer_code')
                            ->select(DB::raw('COUNT(o.customer_code) as customer_count'))
                            ->where('o.salesman_code',$data['salesman_code'])
                            ->where('cc.ca_sales_route',$value->ca_sales_route)
                            ->whereNotBetween('o.created_at', [$jc_start_row->from_date, $today])
                            ->groupBy('o.customer_code',)
                            ->first();

                $customer_daydiff_notbwjc = DB::table('customer_generals as cg')
                        ->join('customer_coverage_attributes as cc','cg.auto_id','=','cc.cg_id')
                        ->leftJoin('orders as o','cg.cg_customer_code','=','o.customer_code')
                        ->select('cg.cg_customer_name','cg.cg_customer_code',DB::raw('MAX(o.created_at) as last_order_Date'),DB::raw('DATEDIFF(NOW(),o.created_at) as day_diff'))
                        ->where('o.salesman_code',$data['salesman_code'])
                        ->where('cc.ca_sales_route',$value->ca_sales_route)
                        ->whereNotBetween('o.created_at', [$jc_start_row->from_date, $today])
                        ->groupBy('o.customer_code',)
                        ->orderBy('o.created_at','desc')
                        ->get()->toArray();

            if(count($customer_daydiff_notbwjc) == 0){
                $customer_info = DB::table('customer_generals as cg')
                                        ->leftJoin('customer_coverage_attributes as cc','cg.auto_id','=','cc.cg_id')
                                        ->select([
                                                "cg.cg_customer_code", 
                                                "cg.cg_customer_name", 
                                                DB::raw("'' as last_order_Date"),
                                                DB::raw("'' as day_diff")
                                            ])
                                        ->where('cg.cg_salesman_code',$data['salesman_code'])
                                        ->where('cc.ca_sales_route',$value->ca_sales_route)
                                        ->whereIn('cg.cg_customer_code',$result_cust)
                                        ->get()->toArray();
                        $test1=[
                              "customer_count"=> $value->customer_count,
                              "ca_sales_route_code"=> $value->ca_sales_route,
                              "ca_sales_route_name"=> $value->route_name,
                              "customer_details" => $customer_info,
                            ];
                array_push($result1,$test1);
            }else if(count($customer_daydiff_notbwjc) < ($value->customer_count)){
                $customer_info = DB::table('customer_generals as cg')
                                        ->leftJoin('customer_coverage_attributes as cc','cg.auto_id','=','cc.cg_id')
                                        ->select([
                                                "cg.cg_customer_code", 
                                                "cg.cg_customer_name", 
                                                DB::raw("'' as last_order_Date"),
                                                DB::raw("'' as day_diff")
                                            ])
                                        ->where('cg.cg_salesman_code',$data['salesman_code'])
                                        ->where('cc.ca_sales_route',$value->ca_sales_route)
                                        ->whereIn('cg.cg_customer_code',$unordered_result_cust)
                                        // ->whereIn('cg.cg_customer_code',$result_cust)
                                        ->get()->toArray();
                $test = $customer_daydiff_notbwjc;
                $test1 = $customer_info;
                $tt = array_merge_recursive($test1, $test);
                $test111=[
                          "customer_count"=> $value->customer_count,
                          "ca_sales_route_code"=> $value->ca_sales_route,
                          "ca_sales_route_name"=> $value->route_name,
                          "customer_details"=> $tt,
                        ];
                array_push($result1,$test111);
            }else{
                $test=[
                          "customer_count"=> $value->customer_count,
                          "ca_sales_route_code"=> $value->ca_sales_route,
                          "ca_sales_route_name"=> $value->route_name,
                          "customer_details" => $customer_daydiff_notbwjc,
                        ];
                array_push($result1,$test);
            }   
        }
        $result2=[];
        foreach ($unord_customer_routes as $key => $value) {
            $customer_info = DB::table('customer_generals as cg')
                                        ->leftJoin('customer_coverage_attributes as cc','cg.auto_id','=','cc.cg_id')
                                        ->select([
                                                "cg.cg_customer_code", 
                                                "cg.cg_customer_name", 
                                                DB::raw("'' as last_order_Date"),
                                                DB::raw("'' as day_diff")
                                            ])
                                        ->where('cg.cg_salesman_code',$data['salesman_code'])
                                        ->where('cc.ca_sales_route',$value->ca_sales_route)
                                        ->whereIn('cg.cg_customer_code',$unordered_result_cust)
                                        ->get()->toArray();
                        $test1=[
                              "customer_count"=> $value->customer_count,
                              "ca_sales_route_code"=> $value->ca_sales_route,
                              "ca_sales_route_name"=> $value->route_name,
                              "customer_details" => $customer_info,
                            ];
                array_push($result2,$test1); 
        }
        $result3 = DB::table('customer_generals as cg')
                        ->leftJoin('orders as o','cg.cg_customer_code','=','o.customer_code')
                        ->select('cg.cg_customer_name','cg.cg_customer_code',DB::raw('MAX(o.created_at) as last_order_Date'),DB::raw('DATEDIFF(NOW(),o.created_at) as day_diff'))
                        ->where('cg.cg_salesman_code',$data['salesman_code'])
                        ->whereNotBetween('o.created_at', [$jc_start_row->from_date, $today])
                        ->groupBy('cg.cg_customer_code',)
                        ->orderBy('day_diff','desc')
                        ->get()->toArray();
        $result['jtd_unbilled_outlet'] = $jc_unbilled_outlet_count;
        $result['unbilled_outlet'] = $unbilled_outlet_count;
        $result['jtd_unbilled_routes'] = $result1;
        $result['unbilled_routes'] = $result2;
        $result['jtd_unbilled_outlet_list'] = $result3;
        return $result;
    }



}