<?php

namespace App\Repositories\Product;

interface IProductRepository {
    public function fetch();
    public function save($form_credentials);
    public function find($id);
    public function update($form_credentials);
    public function delete($id);
}

?>