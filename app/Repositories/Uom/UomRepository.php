<?php 

namespace App\Repositories\Uom;


use App\Models\Uom;
use DB;

class UomRepository implements IUomRepository
{

    public function getUom(){
        $result = DB::table('uoms as u')
        ->select('u.*')
        // ->where('ord.cdID',  '=', $input_details['cdID'])
        ->get();

        return $result;
    }

    public function storeUom( $form_credentials ){
        $input = new Uom;
        $input->uom_code = $form_credentials['uom_code'];
        $input->uom_name = $form_credentials['uom_name'];
        $input->save();

        if($input) {

            return 200;

        } else {

            return 424;
        }

    }

    public function findUom($form_credentials){
        $result = DB::table('uoms as u')
        ->select('u.*')
        ->where('u.uom_code',  '=', $form_credentials['uom_code'])
        ->where('u.uom_name',  '=', $form_credentials['uom_name'])
        ->count();

        return $result;
    }

    public function deleteUom( $id ){

        $result = DB::table('uoms')->where('id', $id)->delete();

        if($result) {
            return 200;
        } else {
            return 424;
        }
    }

    public function updateUom( $form_credentials ){
        $result = new Uom();
        $result = $result->where( 'id', '=', $form_credentials['id'] );
        
        $result->update( [ 
            'uom_code' => $form_credentials['uom_code'],
            'uom_name' => $form_credentials['uom_name'],
        ] );

        if($result) {
            return 200;
        } else {
            return 424;
        }
    }
}
?>