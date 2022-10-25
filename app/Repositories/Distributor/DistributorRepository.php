<?php 

namespace App\Repositories\Distributor;

use DB;
use App\Models\Distributor;


class DistributorRepository implements IDistributorRepository
{
    public function fetch(){

        $distributor = Distributor::all();

        return $distributor;
    }

    public function save($form_credentials){

        $save_data = new Distributor;
        $save_data->auto_id = 'D'.str_pad( ( $save_data->max( 'id' )+1 ), 9, '0', STR_PAD_LEFT );;
        $save_data->distributor_code = $form_credentials['distributor_code'];
        $save_data->distributor_name = $form_credentials['distributor_name'];
        $save_data->distributor_type = $form_credentials['distributor_type'];
        $save_data->parent_code = $form_credentials['parent_code'];
        $save_data->supplier = $form_credentials['supplier'];
        $save_data->discount_based_on = $form_credentials['discount_based_on'];
        $save_data->distributor_permission = $form_credentials['distributor_permission'];
        $save_data->status = $form_credentials['status'];

        $save_data->country = $form_credentials['country'];
        $save_data->state = $form_credentials['state'];
        $save_data->city = $form_credentials['city'];
        $save_data->postal_code = $form_credentials['postal_code'];
        $save_data->phone_no = $form_credentials['phone_no'];
        $save_data->email_id = $form_credentials['email_id'];
        $save_data->fssai_no = $form_credentials['fssai_no'];
        $save_data->drug_licence_no = $form_credentials['drug_licence_no'];
        $save_data->dl_expiry_date = $form_credentials['dl_expiry_date'];
        $save_data->weekly_off = $form_credentials['weekly_off'];
        $save_data->channel_code = $form_credentials['channel_code'];
        $save_data->category_type = $form_credentials['category_type'];
        $save_data->numofsalesmans = $form_credentials['numofsalesmans'];
        $save_data->salary_budget = $form_credentials['salary_budget'];
        $save_data->latitude = $form_credentials['latitude'];
        $save_data->longitude = $form_credentials['longitude'];
        $save_data->geo_hierarchy_level = $form_credentials['geo_hierarchy_level'];
        $save_data->geo_hierarchy_value = $form_credentials['geo_hierarchy_value'];
        $save_data->sales_hierarchy_level = $form_credentials['sales_hierarchy_level'];
        $save_data->lob = $form_credentials['lob'];
        $save_data->sales_hierarchy_value = $form_credentials['sales_hierarchy_value'];
        $save_data->gst_state_name = $form_credentials['gst_state_name'];
        $save_data->pan_no = $form_credentials['pan_no'];
        $save_data->gstin_number = $form_credentials['gstin_number'];
        $save_data->aadhar_no = $form_credentials['aadhar_no'];
        $save_data->tcs_applicable = $form_credentials['tcs_applicable'];
        $save_data->gst_distributor = $form_credentials['gst_distributor'];
        $save_data->tds_applicable = $form_credentials['tds_applicable'];
        $save_data->created_by = $form_credentials['created_by'];
        $save_data->modified_by =  $form_credentials['modified_by'];
        $save_data->password =  '123456';
        $save_data->save();

        if($save_data) {
            return 200;
        } else {
            return 424;
        }

    }

    public function find($id){
        $supplier = Distributor::find($id);
        return $supplier;

    }

    

    public function update($form_credentials){
        $distributor = Distributor::find($form_credentials['id']);
        $distributor->distributor_code = $form_credentials['distributor_code'];
        $distributor->distributor_name = $form_credentials['distributor_name'];
        $distributor->distributor_type = $form_credentials['distributor_type'];
        $distributor->parent_code = $form_credentials['parent_code'];
        $distributor->supplier = $form_credentials['supplier'];
        $distributor->discount_based_on = $form_credentials['discount_based_on'];
        $distributor->distributor_permission = $form_credentials['distributor_permission'];
        $distributor->status = $form_credentials['status'];

        $distributor->country = $form_credentials['country'];
        $distributor->state = $form_credentials['state'];
        $distributor->city = $form_credentials['city'];
        $distributor->postal_code = $form_credentials['postal_code'];
        $distributor->phone_no = $form_credentials['phone_no'];
        $distributor->email_id = $form_credentials['email_id'];
        $distributor->fssai_no = $form_credentials['fssai_no'];
        $distributor->drug_licence_no = $form_credentials['drug_licence_no'];
        $distributor->dl_expiry_date = $form_credentials['dl_expiry_date'];
        $distributor->weekly_off = $form_credentials['weekly_off'];
        $distributor->channel_code = $form_credentials['channel_code'];
        $distributor->category_type = $form_credentials['category_type'];
        $distributor->numofsalesmans = $form_credentials['numofsalesmans'];
        $distributor->salary_budget = $form_credentials['salary_budget'];
        $distributor->latitude = $form_credentials['latitude'];
        $distributor->longitude = $form_credentials['longitude'];
        $distributor->geo_hierarchy_level = $form_credentials['geo_hierarchy_level'];
        $distributor->geo_hierarchy_value = $form_credentials['geo_hierarchy_value'];
        $distributor->sales_hierarchy_level = $form_credentials['sales_hierarchy_level'];
        $distributor->lob = $form_credentials['lob'];
        $distributor->sales_hierarchy_value = $form_credentials['sales_hierarchy_value'];
        $distributor->gst_state_name = $form_credentials['gst_state_name'];
        $distributor->pan_no = $form_credentials['pan_no'];
        $distributor->gstin_number = $form_credentials['gstin_number'];
        $distributor->aadhar_no = $form_credentials['aadhar_no'];
        $distributor->tcs_applicable = $form_credentials['tcs_applicable'];
        $distributor->gst_distributor = $form_credentials['gst_distributor'];
        $distributor->tds_applicable = $form_credentials['tds_applicable'];
        $distributor->created_by = $form_credentials['created_by'];
        $distributor->modified_by =  $form_credentials['modified_by'];
        $distributor->update();

        if($distributor) {
            return 200;
        } else {
            return 424;
        }

    }
    public function delete($id){
        $supplier = Distributor::find($id);
        $supplier->delete();

        if($supplier) {
            return 200;
        } else {
            return 424;
        }
    }

    // aug 22
    public function getDistributor($salesmanCode){
        $result = DB::table('salesman_distributor_mappings')
                    ->join('distributors', 'salesman_distributor_mappings.distributor_code', '=', 'distributors.distributor_code')
                    ->where('salesman_distributor_mappings.salesman_code', $salesmanCode)
                    ->get();
        if($result->isEmpty())
        {
            $status='false';
            $message='No Distributor mapped with the salesman';
            $result=[];
            // $result=response()->json(null);
        }
        else{
            $status='true';
            $message='success';
            $result=$result;
        }
    
        return response()->json([
            'status'=>$status,
            'message'=>$message,
            'result'=>$result,
        ]);
    }
    // end aug 22


    public function distributor_login($login_credentials){
        if (Distributor::where([
            ['distributor_code', '=', $login_credentials['user_id']],
        ])->count() > 0) {

        $result = Distributor::where([
            ['distributor_code', '=', $login_credentials['user_id']],
            ['password', '=', $login_credentials['password']]
        ])->first();

        if($result === null) 
        {
            $status='false';
            $message='Please check the login credentials';
            $result=response()->json(null);
            $user_type="";
        }
        else{
            $status='true';
            $message='success';
            $result=$result;
            $user_type="Distributor";
        }   
        }
        else{
            $status='false';
            $message='User not found';
            $result= response()->json(null); 
            $user_type="";
        }
        return response()->json([
            'url'=>url( '/' ), 
            'response' => $status,
            'status' => "500",
            'type' => $user_type,
            'message'=>$message,
            'data'=>$result,
        ]);
    }

}

?>