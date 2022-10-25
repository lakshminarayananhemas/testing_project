<?php

namespace App\Repositories\Company;

interface ICompanyRepository {
    public function getCompany();
    public function storeCompany($form_credentials);
    public function find($id);
    public function updateCompany($form_credentials);
    public function deletecompany($id);
} 

?>