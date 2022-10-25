<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Uom\IUomRepository; 
use DataTables;

class UomController extends Controller
{
    public function __construct(IUomRepository $uomrepo)
    {
        $this->uomrepo = $uomrepo;

    }
    // ganaga
    public function index(){

        $result = $this->uomrepo->getUom(  );

        // return Datatables::of($result)
        //         ->addIndexColumn()
                
        //         ->addColumn('action',function($row){
                    
        //             $action_btn = ' <a class="btn btn-primary btn-xs" href="#/edit_uom/'."".$row->id."".'"><i class="fa fa-pencil"></i></a><button class="btn btn-xs btn-danger" onClick="deleteUom(this,'.$row->id.')"><i class="fa fa-trash"></i></button> ';
                   
        //             return $action_btn;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);

        return $result;
        
    }

    public function store(Request $request){
        $form_credentials = array(
            'uom_code' => $request->input( 'uom_code' ),
            'uom_name' => $request->input( 'uom_name' ),
        );

        $check_result = $this->uomrepo->findUom($form_credentials);

        if($check_result ==0){
            $result = $this->uomrepo->storeUom( $form_credentials );

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

        $result = $this->uomrepo->deleteUom( $id );
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

    public function update(Request $request,$id){

        $form_credentials = array(
            'id' => $id,
            'uom_code' => $request->input( 'uom_code' ),
            'uom_name' => $request->input( 'uom_name' ),
            
        );
        $result = $this->uomrepo->updateUom( $form_credentials );

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
