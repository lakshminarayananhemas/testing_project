<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salesman;
use App\Models\Route;
use App\Models\Salesman_route_mapping;
use App\Models\Opening_balance;
use App\Models\Customer_route;
use App\Models\Deliveryboy;
use App\Models\Deliveryboy_route;

use App\Imports\SalesmanImport;
use App\Imports\RouteImport;
use App\Imports\SalesmanRouteMappingImport;
use App\Imports\OpeningBalanceImport;
use App\Imports\CustomerRouteImport;
use App\Imports\DeliveryboyImport;
use App\Imports\Deliveryboy_routeImport;
use App\Imports\SalesmanDistributorMappingImport;

class ETLController extends Controller
{
    public function upload(Request $request) 
    {
        $document_type = $request->document_type;

        if($document_type == "Salesman"){
            

            \Excel::import(new SalesmanImport,$request->import_file);

            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);
        }
        elseif($document_type == "Route") {

            \Excel::import(new RouteImport,$request->import_file);

            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);

        }
        elseif($document_type == "Salesman_Route_Mapping") {

            \Excel::import(new SalesmanRouteMappingImport,$request->import_file);

            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);

        }
        elseif($document_type == "Salesman_Distributor_Mapping") {

            \Excel::import(new SalesmanDistributorMappingImport,$request->import_file);

            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);

        }
        elseif($document_type == "Opening_Balance") {

            \Excel::import(new OpeningBalanceImport,$request->import_file);

            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);

        }
        elseif($document_type == "Customer_Route") {

            \Excel::import(new CustomerRouteImport,$request->import_file);

            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);

        }
        elseif($document_type == "DeliveryBoy") {

            \Excel::import(new DeliveryboyImport,$request->import_file);

            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);

        }
        elseif($document_type == "DeliveryBoy_Route_Mapping") {

            \Excel::import(new Deliveryboy_routeImport,$request->import_file);

            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);

        }
    }
}
