<?php

namespace App\Repositories\ProductHierarchy;

interface IProductHierarchyRepository {
    public function getProductHierarchyLevel( );
    public function storeProductHierarchyLevel( $form_credentials );
    public function findProductHierarchyLevel($form_credentials);
    public function deleteProductHierarchyLevel($id);
    public function updateProductHierarchyLevel( $form_credentials );
    public function reporting_level_list($hl_code );

    public function getProductHierarchyLevelValue();
    public function deleteProductHierarchyLevelValue($id);
    public function updateProductHierarchyLevelValue($form_credentials);
}