<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repositories\ProductHierarchy\IProductHierarchyRepository; 
use App\Imports\ImportProductHierarchyLevelValue;

class ProductHierarchyController extends Controller
{
    public function __construct(IProductHierarchyRepository $prohrepo)
    {
        $this->prohrepo = $prohrepo;

    }
    // ganaga
    public function index(){
        // return "sdfg";

        $result = $this->prohrepo->getProductHierarchyLevel(  );

        return $result;
        
    }

    public function store(Request $request){
        
        $form_credentials = array(
            'company_code' => $request->input( 'company_code' ),
            'level_code' => $request->input( 'level_code' ),
            'level_name' => $request->input( 'level_name' ),
        );

        $check_result = $this->prohrepo->findProductHierarchyLevel($form_credentials);

        if($check_result ==0){
            $result = $this->prohrepo->storeProductHierarchyLevel( $form_credentials );

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

    public function destroy($id){

        $result = $this->prohrepo->deleteProductHierarchyLevel( $id );
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

    public function reporting_level_list($hl_code){

        $result = $this->prohrepo->reporting_level_list($hl_code );

        return response()->json([
            'result'=>$result,
        ]);
    }

    public function update(Request $request,$id){

        $form_credentials = array(
            'id' => $id,
            'level_code' => $request->input( 'level_code' ),
            'level_name' => $request->input( 'level_name' ),
            
        );
        $result = $this->prohrepo->updateProductHierarchyLevel( $form_credentials );

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

    public function product_hierarchy_value_bulk_upload(Request $request){

        \Excel::import(new ImportProductHierarchyLevelValue,$request->import_file);

        return response()->json([
            'status'=>200,
            'message'=>'Your file is imported successfully',
        ]);
    }

    public function product_hierarchy_level_value(){
        $result = $this->prohrepo->getProductHierarchyLevelValue(  );
        return $result;
    }

    public function destroy_level_value($id){
        $result = $this->prohrepo->deleteProductHierarchyLevelValue( $id );
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

    public function update_level_value(Request $request,$id){

        $form_credentials = array(
            'id' => $id,
            'level_name' => $request->input( 'level_name' ),
            'level_value_code' => $request->input( 'level_value_code' ),
            'level_value_name' => $request->input( 'level_value_name' ),
            'reporting_level_name' => $request->input( 'reporting_level_name' ),
            
        );
        $result = $this->prohrepo->updateProductHierarchyLevelValue( $form_credentials );

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

    // ganaga
}
