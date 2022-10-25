<?php 

namespace App\Repositories\GeoHierarchy;


use App\Models\GeoHierarchyLevel;
use App\Models\GeoHierarchyLevelValue;
use DB;

class GeoHierarchyRepository implements IGeoHierarchyRepository
{

    public function getGeoHierarchyLevel(){
        $result = DB::table('geo_hierarchy_levels as shl');
        $result = $result->select('shl.*','c.company_name');
        $result = $result->leftJoin( 'companies as c', 'shl.company_code', '=', 'c.auto_id' );
        $result = $result->get();

        return $result;
    }

    public function storeGeoHierarchyLevel( $form_credentials ){
        $input = new GeoHierarchyLevel;
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

    public function findGeoHierarchyLevel($form_credentials){
        $result = DB::table('geo_hierarchy_levels as ghl')
        ->select('ghl.*')
        ->where('ghl.company_code',  '=', $form_credentials['company_code'])
        ->where('ghl.level_code',  '=', $form_credentials['level_code'])
        ->where('ghl.level_name',  '=', $form_credentials['level_name'])
        ->count();

        return $result;
    }

    public function updateGeoHierarchyLevel( $form_credentials ){
        $result = new GeoHierarchyLevel();
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

    public function deleteGeoHierarchyLevel( $id ){

        $result = DB::table('geo_hierarchy_levels')->where('id', $id)->delete();

        if($result) {
            return 200;
        } else {
            return 424;
        }
    }

    public function getGeoHierarchyLevelValue(){
        $result = DB::table('geo_hierarchy_level_values as ghlv');
        $result = $result->select('ghlv.*','c.company_name');
        $result = $result->leftJoin( 'companies as c', 'ghlv.company_code', '=', 'c.auto_id' );
        $result = $result->get();

        return $result;
    }

    public function storeGeoHierarchyLevelValue( $form_credentials ){
        $input = new GeoHierarchyLevelValue;
        $input->company_code = $form_credentials['company_code'];
        $input->level_code = $form_credentials['level_code'];
        $input->level_name = $form_credentials['level_name'];
        $input->company_value = $form_credentials['company_value'];
        $input->reporting_to = $form_credentials['reporting_to'];
        $input->save();

        if($input) {

            return 200;

        } else {

            return 424;
        }

    }

    public function findGeoHierarchyLevelValue($form_credentials){
        $result = DB::table('geo_hierarchy_level_values as ghlv')
        ->select('ghlv.*')
        ->where('ghlv.company_code',  '=', $form_credentials['company_code'])
        ->where('ghlv.level_code',  '=', $form_credentials['level_code'])
        ->where('ghlv.level_name',  '=', $form_credentials['level_name'])
        ->where('ghlv.company_value',  '=', $form_credentials['company_value'])
        ->where('ghlv.reporting_to',  '=', $form_credentials['reporting_to'])
        ->count();

        return $result;
    }

    public function updateGeoHierarchyLevelValue( $form_credentials ){
        $result = new GeoHierarchyLevelValue();
        $result = $result->where( 'id', '=', $form_credentials['id'] );
        
        $result->update( [ 
            'level_code' => $form_credentials['level_code'],
            'level_name' => $form_credentials['level_name'],
            'company_value' => $form_credentials['company_value'],
            'reporting_to' => $form_credentials['reporting_to'],
        ] );

        if($result) {
            return 200;
        } else {
            return 424;
        }
    }

    public function deleteGeoHierarchyLevelValue( $id ){

        $result = DB::table('geo_hierarchy_level_values')->where('id', $id)->delete();

        if($result) {
            return 200;
        } else {
            return 424;
        }
    }
}
?>

