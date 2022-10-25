<?php

namespace App\Repositories\Uom;

interface IUomRepository {
    public function getUom( );
    public function storeUom( $form_credentials );
    public function findUom($form_credentials);
    public function deleteUom($id);
    public function updateUom( $form_credentials );
}