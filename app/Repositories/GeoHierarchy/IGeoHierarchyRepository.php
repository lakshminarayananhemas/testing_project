<?php

namespace App\Repositories\GeoHierarchy;

interface IGeoHierarchyRepository {
    public function getGeoHierarchyLevel( );
    public function storeGeoHierarchyLevel( $form_credentials );
    public function findGeoHierarchyLevel($form_credentials);
    public function updateGeoHierarchyLevel( $form_credentials );
    public function deleteGeoHierarchyLevel($id);

    public function getGeoHierarchyLevelValue( );
    public function storeGeoHierarchyLevelValue( $form_credentials );
    public function findGeoHierarchyLevelValue($form_credentials);
    public function updateGeoHierarchyLevelValue( $form_credentials );
    public function deleteGeoHierarchyLevelValue($id);
    
}