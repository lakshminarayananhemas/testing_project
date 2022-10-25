<?php
namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{

    public function register() {
        
        $this->app->bind(
            'App\Repositories\Supplier\ISupplierRepository',
            'App\Repositories\Supplier\SupplierRepository'
        );
        $this->app->bind(
            'App\Repositories\Customer\ICustomerRepository',
            'App\Repositories\Customer\CustomerRepository'
        );
        $this->app->bind(
            'App\Repositories\Distributor\IDistributorRepository',
            'App\Repositories\Distributor\DistributorRepository'
        );
        $this->app->bind(
            'App\Repositories\Product\IProductRepository',
            'App\Repositories\Product\ProductRepository'
        );
        $this->app->bind(
            'App\Repositories\Salesman\ISalesmanRepository',
            'App\Repositories\Salesman\SalesmanRepository'
        );
        $this->app->bind(
            'App\Repositories\Route\IRouteRepository',
            'App\Repositories\Route\RouteRepository'
        );
        $this->app->bind(
            'App\Repositories\Uom\IUomRepository',
            'App\Repositories\Uom\UomRepository'
        );
        $this->app->bind(
            'App\Repositories\Company\ICompanyRepository',
            'App\Repositories\Company\CompanyRepository'
        );
        $this->app->bind(
            'App\Repositories\Common\ICommonRepository',
            'App\Repositories\Common\CommonRepository'
        );
        $this->app->bind(
            'App\Repositories\ProductHierarchy\IProductHierarchyRepository',
            'App\Repositories\ProductHierarchy\ProductHierarchyRepository'
        );
        $this->app->bind(
            'App\Repositories\SalesReturn\ISalesReturnRepository',
            'App\Repositories\SalesReturn\SalesReturnRepository'
        );
        $this->app->bind(
            'App\Repositories\Stock\IStockRepository',
            'App\Repositories\Stock\StockRepository'
        );
        $this->app->bind(
            'App\Repositories\Configuration\IConfigurationRepository',
            'App\Repositories\Configuration\ConfigurationRepository'
        );
        $this->app->bind(
            'App\Repositories\SalesHierarchy\ISalesHierarchyRepository',
            'App\Repositories\SalesHierarchy\SalesHierarchyRepository'
        );
        $this->app->bind(
            'App\Repositories\GeoHierarchy\IGeoHierarchyRepository',
            'App\Repositories\GeoHierarchy\GeoHierarchyRepository'
        );
        $this->app->bind(
            'App\Repositories\Order\IOrderRepository',
            'App\Repositories\Order\OrderRepository'
        );
        $this->app->bind(
            'App\Repositories\Billing\IBillingRepository',
            'App\Repositories\Billing\BillingRepository'
        );

    }
}
?>