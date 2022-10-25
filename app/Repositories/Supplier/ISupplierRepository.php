<?php

namespace App\Repositories\Supplier;

interface ISupplierRepository {
    public function getSupplier();
    public function storeSupplier($form_credentials);
    public function findSupplier($id);
    public function updateSupplier($form_credentials);
    public function deleteSupplier($id);
}

?>