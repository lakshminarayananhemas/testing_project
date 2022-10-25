<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Route\IRouteRepository; 
use DataTables;

class RouteController extends Controller
{
    public function __construct(IRouteRepository $routerepo)
    {
        $this->routerepo = $routerepo;

    }
    // ganaga
    public function index(Request $request){

        try {

            if($request->input( 'user_type' ) =='Admin'){

                $where=array();
                $where[] = ['status', '=', 'Y'];
        
            }elseif ($request->input( 'user_type' ) =='Distributor') {

                $where=array();
                $where[] = ['status', '=', 'Y'];
                $where[] = ['distributor_code', '=', $request->input( 'distributor_code' )];

            }else{
                $where=array();
            }
            
            $result = $this->routerepo->getRoute( $where );

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

    public function sales_route_list(Request $request){
        
        try {
            
            $form_credentials = array(
                'route_type' => 'Sales Route',
            );
            $result = $this->routerepo->sales_route_list( $form_credentials );
            
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

    public function delivery_route_list(Request $request){
        try {
            $form_credentials = array(
                'route_type' => 'Delivery Route',
            );
            $result = $this->routerepo->sales_route_list( $form_credentials );
    
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
    public function city_list(){

        try {
            
            $result = $this->routerepo->city_list( );
    
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
    public function store(Request $request){

        try {
            $form_credentials = array(
                'distributor_code' => $request->input( 'distributor_branch_code' ),
                'distributor_branch_code' => $request->input( 'distributor_branch_code' ),
                'route_code' => $request->input( 'route_code' ),
                'route_name' => $request->input( 'route_name' ),
                'distance' => $request->input( 'distance' ),
                'population' => $request->input( 'population' ),
                'city' => $request->input( 'city' ),
                'van_route_status' => $request->input( 'van_route' ),
                'route_type' => $request->input( 'route_type' ),
                'status' => $request->input( 'active_status' ),
                'country_status' => $request->input( 'country_status' ),
            );
    
            $result = $this->routerepo->storeRoute( $form_credentials );
            
            if($result ==200){
                $status = $result;
                $message = 'Route Added Successfully';
            }else{
                $status = $result;
                $message = 'Request Failed';
            }
            return response()->json([
                'status'=>$result,
                'message'=>$message,
            ]);
    
        } catch (\Exception $e) {
            $status = $result;
            $message = $e;

            return response()->json([
                'status'=>$status,
                'message'=>$message,
            ]);
        }
        
    }

    public function destroy($id){
        try {
            $result = $this->routerepo->deleteRoute( $id );
            if($result ==200){
                $message = 'Route Deleted Successfully';
            }else{
                $message = 'Request Failed';
            }
            return response()->json([
                'status'=>$result,
                'message'=>$message ,
            ]);
        } catch (\Exception $e) {
            $status = $result;
            $message = $e;

            return response()->json([
                'status'=>$status,
                'message'=>$message,
            ]);
        }
        
    }

    public function edit($id){

        try {
            $result = $this->routerepo->findRoute( $id );

            if(!empty($result)){
                $status = 200;
                $message = 'success';
                $result = $result; 
            }else{
                $status = 500;
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
            $result = 'Failed';
            $message = $e;

            return response()->json([
                'status'=>$status,
                'result'=>$result,
                'message'=>$message,
            ]);
        }

        
    }

    public function update(Request $request,$id){
        try {
            
            $form_credentials = array(
                'id' => $id,
                'distributor_code' => $request->input( 'distributor_branch_code' ),
                'distributor_branch_code' => $request->input( 'distributor_branch_code' ),
                'route_code' => $request->input( 'route_code' ),
                'route_name' => $request->input( 'route_name' ),
                'distance' => $request->input( 'distance' ),
                'population' => $request->input( 'population' ),
                'city' => $request->input( 'city' ),
                'van_route_status' => $request->input( 'van_route' ),
                'route_type' => $request->input( 'route_type' ),
                'status' => $request->input( 'active_status' ),
                'country_status' => $request->input( 'country_status' ),
            );
            $result = $this->routerepo->updateRoute( $form_credentials );
    
            if($result ==200){
                
                $message = 'Route Updated Successfully';
            }else{
                $message = 'Request Failed';
    
            }
    
            return response()->json([
                'status'=>$result,
                'message'=>$message ,
            ]);

        } catch (\Exception $th) {
            $status = '500';
            $message = $e;

            return response()->json([
                'status'=>$status,
                'message'=>$message,
            ]);
        }
        
    }
    // ganaga


}
