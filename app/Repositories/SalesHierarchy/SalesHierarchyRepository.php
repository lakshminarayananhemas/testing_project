<?php 

namespace App\Repositories\SalesHierarchy;


use App\Models\SalesHierarchyLevel;
use App\Models\SalesHierarchyLevelValue;
use DB;

class SalesHierarchyRepository implements ISalesHierarchyRepository
{

    public function getSalesHierarchyLevel(){
        $result = DB::table('sales_hierarchy_levels as shl');
        $result = $result->select('shl.*','c.company_name');
        $result = $result->leftJoin( 'companies as c', 'shl.company_code', '=', 'c.auto_id' );
        $result = $result->get();

        return $result;
    }

    public function storeSalesHierarchyLevel( $form_credentials ){
        $input = new SalesHierarchyLevel;
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

    public function findSalesHierarchyLevel($form_credentials){
        $result = DB::table('sales_hierarchy_levels as shl')
        ->select('shl.*')
        ->where('shl.company_code',  '=', $form_credentials['company_code'])
        ->where('shl.level_code',  '=', $form_credentials['level_code'])
        ->where('shl.level_name',  '=', $form_credentials['level_name'])
        ->count();

        return $result;
    }

    public function updateSalesHierarchyLevel( $form_credentials ){
        $result = new SalesHierarchyLevel();
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

    public function deleteSalesHierarchyLevel( $id ){

        $result = DB::table('sales_hierarchy_levels')->where('id', $id)->delete();

        if($result) {
            return 200;
        } else {
            return 424;
        }
    }

    public function getSalesHierarchyLevelValue(){
        $result = DB::table('sales_hierarchy_level_values as shlv');
        $result = $result->select('shlv.*','c.company_name');
        $result = $result->leftJoin( 'companies as c', 'shlv.company_code', '=', 'c.auto_id' );
        $result = $result->get();

        return $result;
    }

    public function storeSalesHierarchyLevelValue( $form_credentials ){
        $input = new SalesHierarchyLevelValue;
        $input->company_code = $form_credentials['company_code'];
        $input->level_code = $form_credentials['level_code'];
        $input->level_name = $form_credentials['level_name'];
        $input->company_value = $form_credentials['company_value'];
        $input->save();

        if($input) {

            return 200;

        } else {

            return 424;
        }

    }

    public function findSalesHierarchyLevelValue($form_credentials){
        $result = DB::table('sales_hierarchy_level_values as shlv')
        ->select('shlv.*')
        ->where('shlv.company_code',  '=', $form_credentials['company_code'])
        ->where('shlv.level_code',  '=', $form_credentials['level_code'])
        ->where('shlv.level_name',  '=', $form_credentials['level_name'])
        ->where('shlv.company_value',  '=', $form_credentials['company_value'])
        ->count();

        return $result;
    }

    public function updateSalesHierarchyLevelValue( $form_credentials ){
        $result = new SalesHierarchyLevelValue();
        $result = $result->where( 'id', '=', $form_credentials['id'] );
        
        $result->update( [ 
            'level_code' => $form_credentials['level_code'],
            'level_name' => $form_credentials['level_name'],
            'company_value' => $form_credentials['company_value'],
        ] );

        if($result) {
            return 200;
        } else {
            return 424;
        }
    }

    public function deleteSalesHierarchyLevelValue( $id ){

        $result = DB::table('sales_hierarchy_level_values')->where('id', $id)->delete();

        if($result) {
            return 200;
        } else {
            return 424;
        }
    }
}
?>

