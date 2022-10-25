<?php

namespace App\Repositories\Customer;

interface ICustomerRepository {
    public function getCustomers($where);

    public function storeCustomer($form_credentials);

    public function findCustomergeneral($id);

    public function findCustomerlicenceSetting($id);

    public function findCustomercoverageAttribute($id);

    public function updateCustomer($form_credentials);
    
    public function deleteCustomer($id);

    public function customer_status_update($form_credentials  );
    public function getCustomerscondition_dist($form_credentials  );

    public function findOutletimages( $id );
    public function get_pending_outlets($where1 );

}

?>