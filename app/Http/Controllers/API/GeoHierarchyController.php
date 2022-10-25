<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\GeoHierarchy\IGeoHierarchyRepository; 
use App\Imports\ImportGeoHierarchyLevel;
use App\Imports\ImportGeoHierarchyLevelValue;


class GeoHierarchyController extends Controller
{
    public function __construct(IGeoHierarchyRepository $geohrepo)
    {
        $this->geohrepo = $geohrepo;

    }

    // ganaga
    public function geo_hierarchy_level(){
        $result = $this->geohrepo->getGeoHierarchyLevel(  );
        return $result;
    }

    public function store(Request $request){
        
        $form_credentials = array(
            'company_code' => $request->input( 'company_code' ),
            'level_code' => $request->input( 'level_code' ),
            'level_name' => $request->input( 'level_name' ),
        );

        $check_result = $this->geohrepo->findGeoHierarchyLevel($form_credentials);

        if($check_result ==0){
            $result = $this->geohrepo->storeGeoHierarchyLevel( $form_credentials );

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

    public function update_geo_hierarchy_level(Request $request,$id){

        $form_credentials = array(
            'id' => $id,
            'level_code' => $request->input( 'level_code' ),
            'level_name' => $request->input( 'level_name' ),
            
        );
        $result = $this->geohrepo->updateGeoHierarchyLevel( $form_credentials );

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

        $result = $this->geohrepo->deleteGeoHierarchyLevel( $id );
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

    public function geo_hierarchy_bulk_upload(Request $request){
        
        \Excel::import(new ImportGeoHierarchyLevel,$request->import_file);

        return response()->json([
            'status'=>200,
            'message'=>'Your file is imported successfully',
        ]);

    }

    public function geo_hierarchy_level_value(){
        $result = $this->geohrepo->getGeoHierarchyLevelValue(  );
        return $result;
    }

    public function store_value(Request $request){
        
        $form_credentials = array(
            'company_code' => $request->input( 'company_code' ),
            'level_code' => $request->input( 'level_code' ),
            'level_name' => $request->input( 'level_name' ),
            'company_value' => $request->input( 'company_value' ),
            'reporting_to' => $request->input( 'reporting_to' ),
        );

        $check_result = $this->geohrepo->findGeoHierarchyLevelValue($form_credentials);

        if($check_result ==0){
            $result = $this->geohrepo->storeGeoHierarchyLevelValue( $form_credentials );

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

    public function update_geo_hierarchy_level_value(Request $request,$id){

        $form_credentials = array(
            'id' => $id,
            'level_code' => $request->input( 'level_code' ),
            'level_name' => $request->input( 'level_name' ),
            'company_value' => $request->input( 'company_value' ),
            'reporting_to' => $request->input( 'reporting_to' ),
            
        );
        $result = $this->geohrepo->updateGeoHierarchyLevelValue( $form_credentials );

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

        $result = $this->geohrepo->deleteGeoHierarchyLevelValue( $id );
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

    public function geo_hierarchy_bulk_upload_value(Request $request){
                                    
        \Excel::import(new ImportGeoHierarchyLevelValue,$request->import_file);

            return response()->json([
                'status'=>200,
                'message'=>'Your file is imported successfully',
            ]);

    }

    // ganaga
}
