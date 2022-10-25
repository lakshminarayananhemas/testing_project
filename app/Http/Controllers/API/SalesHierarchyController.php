<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SalesHierarchy\ISalesHierarchyRepository; 
use App\Imports\ImportSalesHierarchyLevel;
use App\Imports\ImportSalesHierarchyLevelValue;

class SalesHierarchyController extends Controller
{
    public function __construct(ISalesHierarchyRepository $saleshrepo)
    {
        $this->saleshrepo = $saleshrepo;

    }

    // ganaga
    public function sales_hierarchy_level(){
        $result = $this->saleshrepo->getSalesHierarchyLevel(  );
        return $result;
    }

    public function store(Request $request){
        
        $form_credentials = array(
            'company_code' => $request->input( 'company_code' ),
            'level_code' => $request->input( 'level_code' ),
            'level_name' => $request->input( 'level_name' ),
        );

        $check_result = $this->saleshrepo->findSalesHierarchyLevel($form_credentials);

        if($check_result ==0){
            $result = $this->saleshrepo->storeSalesHierarchyLevel( $form_credentials );

            if($result ==200){
                $message = 'Added Successfully';
            }else{
                $message = 'Request Failed';
    
            }
        }else{
            $result = 424;

            $message = 'Record Already Exits';
        }

        

        return response()->json([
            'status'=>$result,
            'message'=>$message ,
        ]);
    }

    public function update_sales_hierarchy_level(Request $request,$id){

        $form_credentials = array(
            'id' => $id,
            'level_code' => $request->input( 'level_code' ),
            'level_name' => $request->input( 'level_name' ),
            
        );
        $result = $this->saleshrepo->updateSalesHierarchyLevel( $form_credentials );

        if($result ==200){
            $message = 'Updated Successfully';
        }else{
            $message = 'Request Failed';
        }

        return response()->json([
            'status'=>$result,
            'message'=>$message ,
        ]);
    }

    public function destroy($id){

        $result = $this->saleshrepo->deleteSalesHierarchyLevel( $id );
        if($result ==200){
            $message = 'Deleted Successfully';
        }else{
            $message = 'Request Failed';
        }
        return response()->json([
            'status'=>$result,
            'message'=>$message ,
        ]);
    }

    public function sales_hierarchy_bulk_upload(Request $request){
        
        \Excel::import(new ImportSalesHierarchyLevel,$request->import_file);

        return response()->json([
            'status'=>200,
            'message'=>'Your file is imported successfully',
        ]);

    }

    public function sales_hierarchy_level_value(){
        $result = $this->saleshrepo->getSalesHierarchyLevelValue(  );
        return $result;
    }

    public function store_value(Request $request){
        
        $form_credentials = array(
            'company_code' => $request->input( 'company_code' ),
            'level_code' => $request->input( 'level_code' ),
            'level_name' => $request->input( 'level_name' ),
            'company_value' => $request->input( 'company_value' ),
        );

        $check_result = $this->saleshrepo->findSalesHierarchyLevelValue($form_credentials);

        if($check_result ==0){
            $result = $this->saleshrepo->storeSalesHierarchyLevelValue( $form_credentials );

            if($result ==200){
                $message = 'Added Successfully';
            }else{
                $message = 'Request Failed';
    
            }
        }else{
            $result = 424;

            $message = 'Record Already Exits';
        }

        

        return response()->json([
            'status'=>$result,
            'message'=>$message ,
        ]);
    }

    public function update_sales_hierarchy_level_value(Request $request,$id){

        $form_credentials = array(
            'id' => $id,
            'level_code' => $request->input( 'level_code' ),
            'level_name' => $request->input( 'level_name' ),
            'company_value' => $request->input( 'company_value' ),
            
        );
        $result = $this->saleshrepo->updateSalesHierarchyLevelValue( $form_credentials );

        if($result ==200){
            $message = 'Updated Successfully';
        }else{
            $message = 'Request Failed';
        }

        return response()->json([
            'status'=>$result,
            'message'=>$message ,
        ]);
    }

    public function destroy_value($id){

        $result = $this->saleshrepo->deleteSalesHierarchyLevelValue( $id );
        if($result ==200){
            $message = 'Deleted Successfully';
        }else{
            $message = 'Request Failed';
        }
        return response()->json([
            'status'=>$result,
            'message'=>$message ,
        ]);
    }

    public function sales_hierarchy_bulk_upload_value(Request $request){
        
        \Excel::import(new ImportSalesHierarchyLevelValue,$request->import_file);

        return response()->json([
            'status'=>200,
            'message'=>'Your file is imported successfully',
        ]);

    }
    // ganaga
}
