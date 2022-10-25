<?php 

namespace App\Repositories\Company;


use App\Models\Company;


class CompanyRepository implements ICompanyRepository
{
    public function getCompany(){

        $companyies = Company::all();

        return $companies;
    }

    public function storeCompany($data){
        $save_data = new Company;
        $save_data->auto_id = 'C'.date("Y").'/'.str_pad( ( $save_data->max( 'id' )+1 ), 5, '0', STR_PAD_LEFT );
        $save_data->company_name = $data['company_name'];
        $save_data->company_code = $data['company_code'];
        $save_data->company_address = $data['company_address'];
        $save_data->company_address1 = $data['company_address1'];
        $save_data->company_address2 = $data['company_address2'];
        $save_data->company_postal_code = $data['company_postal_code'];
        $save_data->company_country = $data['company_country'];
        $save_data->company_state = $data['company_state'];
        $save_data->company_city = $data['company_city'];
        $save_data->business_vertical = $data['business_vertical'];
        $save_data->default_status = $data['default_status'];
        $save_data->save();
        if($save_data) {
            return 200;
        } else {
            return 424;
        }
    }

    public function find($id){
        $company = Company::find($id);
        return $company;

    }

    public function updateCompany($form_credentials){ 
        $company = Company::find($form_credentials['id']);
        $company->company_name = $form_credentials['company_name'];
        $company->company_code = $form_credentials['company_code'];
        $company->company_address = $form_credentials['company_address'];
        $company->company_address1 = $form_credentials['company_address1'];
        $company->company_address2 = $form_credentials['company_address2'];
        $company->company_postal_code = $form_credentials['company_postal_code'];
        $company->company_country = $form_credentials['company_country'];
        $company->company_state = $form_credentials['company_state'];
        $company->company_city = $form_credentials['company_city'];
        $company->business_vertical = $form_credentials['business_vertical'];
        $company->default_status = $form_credentials['default_status'];
        $company->update();
        if($company) {
            return $form_credentials;
        } else {
            return 424;
        };

    }
    public function deletecompany($id){
        $company = Company::find($id);
        $company->delete();

        if($company) {
            return 200;
        } else {
            return 424;
        }
    }
}

?>