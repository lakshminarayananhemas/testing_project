<?php 

namespace App\Repositories\Route;


use App\Models\Route;
use DB;

class RouteRepository implements IRouteRepository
{
    public function getRoute($where){
        $result = DB::table('routes')
        ->select('*')
        ->where($where)
        ->orderBy('id','DESC')
        ->get();

        return $result;
    }

    public function sales_route_list( $form_credentials ){
        $result = DB::table('routes as r')
        ->select('r.*')
        ->where('r.route_type',  '=', $form_credentials['route_type'])
        ->get();

        return $result;
    }

    public function city_list(){
        $result = DB::table('towns_details as td')
        ->select('td.*')
        ->limit(10)
        // ->where('ord.cdID',  '=', $input_details['cdID'])
        ->get();

        return $result;
    }

    public function storeRoute( $form_credentials ){
        $input = new Route;
        $input->distributor_code = $form_credentials['distributor_code'];
        $input->distributor_branch_code = $form_credentials['distributor_branch_code'];
        $input->route_code = $form_credentials['route_code'];
        $input->route_name = $form_credentials['route_name'];
        $input->distance = $form_credentials['distance'];
        $input->population = $form_credentials['population'];
        $input->city = $form_credentials['city'];
        $input->van_route_status = $form_credentials['van_route_status'];
        $input->route_type = $form_credentials['route_type'];
        $input->status = $form_credentials['status'];
        $input->country_status = $form_credentials['country_status'];
        $input->save();

        if($input) {

            return 200;

        } else {

            return 424;
        }

    }

    public function updateRoute( $form_credentials ){

        $result = new Route();
        $result = $result->where( 'id', '=', $form_credentials['id'] );
        
        $result->update( [ 
            'distributor_code' => $form_credentials['distributor_code'],
            'distributor_branch_code' => $form_credentials['distributor_branch_code'],
            'route_code' => $form_credentials['route_code'],
            'route_name' => $form_credentials['route_name'],
            'distance' => $form_credentials['distance'],
            'population' => $form_credentials['population'],
            'city' => $form_credentials['city'],
            'van_route_status' => $form_credentials['van_route_status'],
            'route_type' => $form_credentials['route_type'],
            'status' => $form_credentials['status'],
            'country_status' => $form_credentials['country_status'],
            
        ] );

        if($result) {
            return 200;
        } else {
            return 424;
        }
    }

    public function deleteRoute( $id ){

        $result = DB::table('routes')->where('id', $id)->delete();

        if($result) {
            return 200;
        } else {
            return 424;
        }
    }

    public function findRoute( $id ){
        $result = DB::table('routes as r')
        ->select('r.*')
        ->where('r.id',$id)
        ->get();

        return $result;
    }
}