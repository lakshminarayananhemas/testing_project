<?php

namespace App\Repositories\Salesman;

interface ISalesmanRepository {
    public function storeSalesman( $form_credentials );
    public function getSalesman($where);
    public function deleteSalesman( $id );
    public function findSalesman( $id );
    public function updateSalesman( $form_credentials );
    public function fetch_salesman_route_list($form_credentials);
    public function getSalesmanjc_routemapping_list($where);
    public function salesman_attendance($where);
    public function get_marketvisit_attendance_info( $where );

    public function get_pjp_jcmonth( $where );
    public function get_pjp_details( $where );
    public function get_pjp_outlet_details( $where );

    public function check_salesman_attendance( $form_credentials );
    public function mark_salesman_attendance( $form_credentials );
    public function mark_salesman_market_attendance( $form_credentials );
    public function update_salesman_attendance( $form_credentials );
    
}