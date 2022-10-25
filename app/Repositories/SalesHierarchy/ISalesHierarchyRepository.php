<?php

namespace App\Repositories\SalesHierarchy;

interface ISalesHierarchyRepository {
    public function getSalesHierarchyLevel( );
    public function storeSalesHierarchyLevel( $form_credentials );
    public function findSalesHierarchyLevel($form_credentials);
    public function updateSalesHierarchyLevel( $form_credentials );
    public function deleteSalesHierarchyLevel($id);

    public function getSalesHierarchyLevelValue( );
    public function storeSalesHierarchyLevelValue( $form_credentials );
    public function findSalesHierarchyLevelValue($form_credentials);
    public function updateSalesHierarchyLevelValue( $form_credentials );
    public function deleteSalesHierarchyLevelValue($id);
    
}