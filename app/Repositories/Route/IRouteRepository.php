<?php

namespace App\Repositories\Route;

interface IRouteRepository {
    public function storeRoute( $form_credentials );
    public function city_list();
    public function getRoute($where);
    public function deleteRoute( $id );
    public function findRoute( $id );
    public function updateRoute( $form_credentials );
    public function sales_route_list( $form_credentials );
}