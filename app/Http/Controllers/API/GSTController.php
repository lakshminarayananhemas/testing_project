<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Imports\GSTSupplier;
use App\Imports\GSTProduct;
use App\Imports\GSTDistributor;
use App\Imports\Distributor_Tax_States_Mapping;
use App\Imports\GSTStateMaster;

class GSTController extends Controller 
{
    //
    public function upload(Request $request) 
    {
        $document_type = $request->document_type;


        if($document_type == "GST Supplier"){  
            
            // return $request->import_file;
            // exit();
            
            \Excel::import(new GSTSupplier,$request->import_file);

            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);
        }
        elseif($document_type == "GST Product") {

            // return "1";

            \Excel::import(new GSTProduct,$request->import_file);

            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);

        }
        elseif($document_type == "GST Distributor") {


            \Excel::import(new GSTDistributor,$request->import_file);

            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);

        }
        elseif($document_type == "Distributor Tax States Mapping") {

            \Excel::import(new Distributor_Tax_States_Mapping,$request->import_file);

            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);

        }
        elseif($document_type == "GST State Master") {

            \Excel::import(new GSTStateMaster,$request->import_file);

            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);

        }
        elseif($document_type == "GST Customer") {

            \Excel::import(new DeliveryboyImport,$request->import_file);

            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);

        }
        
    }
}
