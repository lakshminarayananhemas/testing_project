<?php 

namespace App\Repositories\ProductHierarchy;


use App\Models\ProductHierarchyLevel;
use App\Models\ProductHierarchyLevelValue;
use DB;

class ProductHierarchyRepository implements IProductHierarchyRepository
{

    public function getProductHierarchyLevel(){
        $result = DB::table('product_hierarchy_levels as phl');
        $result = $result->select('phl.*','c.company_name');
        $result = $result->leftJoin( 'companies as c', 'phl.company_code', '=', 'c.auto_id' );
        $result = $result->get();

        return $result;
    }

    public function storeProductHierarchyLevel( $form_credentials ){
        $input = new ProductHierarchyLevel;
        $input->company_code = $form_credentials['company_code'];
        $input->level_code = $form_credentials['level_code'];
        $input->level_name = $form_credentials['level_name'];
        $input->save();

        if($input) {

            return 200;

        } else {

            return 424;
        }

    }

    public function findProductHierarchyLevel($form_credentials){
        $result = DB::table('product_hierarchy_levels as phl')
        ->select('phl.*')
        ->where('phl.company_code',  '=', $form_credentials['company_code'])
        ->where('phl.level_code',  '=', $form_credentials['level_code'])
        ->where('phl.level_name',  '=', $form_credentials['level_name'])
        ->count();

        return $result;
    }

    public function deleteProductHierarchyLevel( $id ){

        $result = DB::table('product_hierarchy_levels')->where('id', $id)->delete();

        if($result) {
            return 200;
        } else {
            return 424;
        }
    }

    public function updateProductHierarchyLevel( $form_credentials ){
        $result = new ProductHierarchyLevel();
        $result = $result->where( 'id', '=', $form_credentials['id'] );
        
        $result->update( [ 
            'level_code' => $form_credentials['level_code'],
            'level_name' => $form_credentials['level_name'],
        ] );

        if($result) {
            return 200;
        } else {
            return 424;
        }
    }

    public function reporting_level_list($hl_code ){
        $result = DB::table('hierarchy_reporting_levels as rl')
        ->select('rl.auto_id','rl.reporting_level_name')
        ->where('rl.hierarchy_level_id','=', $hl_code) 
        ->groupBy('rl.reporting_level_name')
        ->get();

        return $result;
    }

    public function getProductHierarchyLevelValue(){
        $result = DB::table('product_hierarchy_level_values as phl');
        $result = $result->select('phl.*','c.company_name');
        $result = $result->leftJoin( 'companies as c', 'phl.company_code', '=', 'c.auto_id' );
        $result = $result->get();

        return $result;
    }

    public function deleteProductHierarchyLevelValue($id){

        $result = DB::table('product_hierarchy_level_values')->where('id', $id)->delete();

        if($result) {
            return 200;
        } else {
            return 424;
        }
    }

    public function updateProductHierarchyLevelValue($form_credentials){
        $result = new ProductHierarchyLevelValue();
        $result = $result->where( 'id', '=', $form_credentials['id'] );
        
        $result->update( [ 
            'level_name' => $form_credentials['level_name'],
            'level_value_code' => $form_credentials['level_value_code'],
            'level_value_name' => $form_credentials['level_value_name'],
            'reporting_level_name' => $form_credentials['reporting_level_name'],
        ] );

        if($result) {
            return 200;
        } else {
            return 424;
        }
    }

}
?>

