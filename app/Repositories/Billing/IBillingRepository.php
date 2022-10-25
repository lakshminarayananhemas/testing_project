<?php

namespace App\Repositories\Billing;

interface IBillingRepository {
    
    public function get_salesman_by_distributor($where);
    public function get_route_by_salesman( $form_credentials);
    public function get_customer_by_route( $form_credentials);
    public function get_product_listby_distributor( $form_credentials);
    public function get_product_info( $form_credentials);
    public function create_billing( $form_credentials);
    public function get_billing_list( $form_credentials );
    public function get_billing_info( $form_credentials );

}