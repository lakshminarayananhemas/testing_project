<?php


namespace App\Repositories\Order;

interface IOrderRepository {
    
    public function get_orderitem_list($where);

    public function get_current_jc_route_details($where);
    public function get_jc_route_billed_outlet($form_credentials );
    public function get_jc_customer_order_details($form_credentials );
    public function get_jc_customer_details($form_credentials );
    public function get_jc_customer_order_details_status($form_credentials);
    public function get_customer_target_details($form_credentials);
    public function last_three_month_average($form_credentials);
    public function salesman_marketvisit_coverage($form_credentials);
    public function get_customer_frequency($where);
    public function salesman_sales_return_count($form_credentials);
    public function get_current_jc_customer_byroute($form_credentials);
    public function get_jc_customer_app_order($form_credentials );

    public function get_other_route_details($where1 );
    public function get_other_customer_byroute($where2 );
    public function get_other_route_billed_outlet($form_credentials );
    
}

?>