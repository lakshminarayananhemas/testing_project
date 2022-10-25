<?php

header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');
header('Access-Control-Allow-Origin: *');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\API\SupplierController;
use App\Http\Controllers\API\DistributorController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\ETLController;
use App\Http\Controllers\API\SalesmanController;
use App\Http\Controllers\API\ConfigurationController;

use App\Http\Controllers\API\RouteController;
use App\Http\Controllers\API\UomController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\CommonController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\SalesReturnController;
use App\Http\Controllers\API\StockController;
use App\Http\Controllers\API\ProductHierarchyController;
use App\Http\Controllers\API\SalesHierarchyController;
use App\Http\Controllers\API\GeoHierarchyController;
use App\Http\Controllers\API\BillingController;
use App\Http\Controllers\API\TargetUploadController;


Route::post('/login_valid',[LoginController::class,'login_valid']);

// company
Route::post('/create_company',[CompanyController::class,'store']);

Route::get('/get_company_list',[CompanyController::class,'get_company_list']);
Route::get('/get-companyList',[CompanyController::class,'get_companyList']);

Route::get('/get_company_data/{id}',[CompanyController::class,'edit']);
Route::post('/update_company/{id}',[CompanyController::class,'update']);

// distributor
Route::get('/fetch_distributor',[DistributorController::class,'fetch']);
Route::post('/create-distributor',[DistributorController::class,'save']);
Route::get('/edit-distributor/{id}',[DistributorController::class,'edit']);
Route::delete('/delete-distributor/{id}',[DistributorController::class,'destroy']);

// products
Route::get('/fetch_products',[ProductController::class,'fetch']);
Route::post('/create-product',[ProductController::class,'save']);
Route::get('/edit-product/{id}',[ProductController::class,'edit']);
Route::put('/update-product/{id}',[ProductController::class,'update']);
Route::delete('/delete-product/{id}',[ProductController::class,'destroy']);
// salesman route mapping

Route::post('/fetch_salesman_route_map_list',[SalesmanController::class,'fetch_salesman_route_map_list']);

// fetch_order
Route::post('/fetch_fresh_order',[OrderController::class,'fetch_fresh_order']);
Route::post('/fetch_approved_data',[OrderController::class,'fetch_approved_data']);
Route::post('/fetch_declined_data',[OrderController::class,'fetch_declined_data']);

Route::post('/fetch_order_items',[OrderController::class,'fetch_order_items']); 
Route::post('/decline_order',[OrderController::class,'decline_order']);
Route::post('/approve_order',[OrderController::class,'approve_order']); 

Route::post('/sales-return-list',[SalesReturnController::class,'sales_return_list']);
Route::get('/get-salesreturn-items/{id}',[SalesReturnController::class,'get_salesreturn_items']);

Route::post('/dis_current_stock_report_list',[StockController::class,'dis_current_stock_report_list']);


Route::post('/upload_dsc_target_upload',[TargetUploadController::class,'upload_dsc_target_upload']);
 
// pen end

// app 22 aug

//raja
Route::post('/salesman_login',[SalesmanController::class,'salesman_login']);
Route::post('/get_distributor',[DistributorController::class,'get_distributor']);
Route::post('/create_outlet',[CustomerController::class,'create_outlet']);
Route::post('/get_outlet',[CustomerController::class,'get_outlet']);
Route::post('/get_products',[ProductController::class,'get_products']);
Route::post('/update_outlet',[CustomerController::class,'update_outlet']);
Route::post('/create_orders',[CustomerController::class,'create_orders']);
Route::post('/list_products',[CustomerController::class,'list_products']);
Route::post('/sales_return',[CustomerController::class,'sales_return']);

Route::post('/get_new_outlet',[CustomerController::class,'get_new_outlet']);
Route::post('/top_outlets',[CustomerController::class,'top_outlets']);
Route::post('/get_orders',[CustomerController::class,'get_orders']);

//leela vinothan
Route::post('/sales_trends_old',[CustomerController::class,'current_last_month_sales_old']);
Route::post('/cancelled_orders_old',[CustomerController::class,'all_status_orders_old']);
Route::post('/previous_orders_old',[CustomerController::class,'previous_orders_old']);

Route::post('/customer_sales_overview_old',[CustomerController::class,'customer_sales_overview_old']);
// app end

//gst
Route::post('/upload-gst',[GSTController::class,'upload']);

Route::post('/get_dist_salesman_target_list',[TargetUploadController::class,'get_dist_salesman_target_list']);


Route::get('/route_list',[CommonController::class,'route_list']);
//Route::get('/channel_list',[CommonController::class,'channel_list']);
Route::post('/country_list',[CommonController::class,'country_list']);
Route::post('/district_list',[CommonController::class,'country_district_list']);
Route::post('/state_list',[CommonController::class,'country_state_list']);
Route::post('/town_list',[CommonController::class,'state_town_list']); 

Route::post('/get_jc_calender',[ConfigurationController::class,'index']); 

Route::post('/get_today_date',[CommonController::class,'get_today_date']); 

Route::post('/save_order_from_dis',[OrderController::class,'save_order_from_dis']);

Route::get('/edit_oder_by_dis/{id}',[OrderController::class,'edit_oder_by_dis']);

Route::post('/salesman_day_summary',[SalesmanController::class,'salesman_day_summary']);
Route::post('/jtd_unbilled_outlets',[CommonController::class,'jtd_unbilled_outlets']);
Route::post('/salesman_target_achieved',[SalesmanController::class,'salesman_target_achieved']);
Route::post('/previous_orders',[OrderController::class,'previous_orders']);
Route::post('/cancelled_orders',[OrderController::class,'all_status_orders']);
Route::post('/customer_sales_overview',[CustomerController::class,'customer_sales_overview1']);
Route::post('/sales_trends',[OrderController::class,'current_last_month_sales']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// g
// upto 14-10-22

// supplier
Route::get('/suppliers',[SupplierController::class,'index']);
Route::post('/create-supplier',[SupplierController::class,'store']);
Route::get('/edit-supplier/{id}',[SupplierController::class,'edit']);
Route::put('/update-supplier/{id}',[SupplierController::class,'update']);
Route::delete('/delete-supplier/{id}',[SupplierController::class,'destroy']);

//customer
Route::post('/customers',[CustomerController::class,'index']);
Route::post('/customers-distributor',[CustomerController::class,'customers_distributor']);
Route::post('/customers-pending-approval',[CustomerController::class,'customers_pending_approval']);
Route::post('/customer-status-update',[CustomerController::class,'customer_status_update']);
Route::post('/create-customer',[CustomerController::class,'store']);
Route::get('/view-customer/{id}',[CustomerController::class,'edit']);
Route::post('/update-customer',[CustomerController::class,'update']);
Route::delete('/delete-customer/{id}',[CustomerController::class,'destroy']);

//etl
Route::post('/upload-etl',[ETLController::class,'upload']);

//salesman
Route::Post('/salesman',[SalesmanController::class,'index']);
Route::post('/create-salesman',[SalesmanController::class,'store']);
Route::delete('/delete-salesman/{id}',[SalesmanController::class,'destroy']);
Route::get('/view-salesman/{id}',[SalesmanController::class,'edit']);
Route::put('/update-salesman/{id}',[SalesmanController::class,'update']);


Route::post('/upload-salesman-jc-routemapping',[SalesmanController::class,'upload_salesman_jc_routemapping']);
Route::post('/salesmanjc-routemapping-list',[SalesmanController::class,'salesmanjc_routemapping_list']);
Route::post('/salesman-attendance',[SalesmanController::class,'salesman_attendance']);
Route::get('/get-marketvisit-details/{id}',[SalesmanController::class,'get_marketvisit_details']);

//route
Route::post('/route',[RouteController::class,'index']);
Route::get('/get_companyList',[CompanyController::class,'get_companyList']);
Route::get('/city-list',[RouteController::class,'city_list']);
Route::post('/create-route',[RouteController::class,'store']);
Route::delete('/delete-route/{id}',[RouteController::class,'destroy']);
Route::get('/view-route/{id}',[RouteController::class,'edit']);
Route::put('/update-route/{id}',[RouteController::class,'update']);

//uom
Route::get('/uom',[UomController::class,'index']);
Route::post('/create-uom',[UomController::class,'store']);
Route::delete('/delete-uom/{id}',[UomController::class,'destroy']);
Route::put('/update-uom/{id}',[UomController::class,'update']);

Route::get('/get-gststate-list',[CommonController::class,'get_gststate_list']);
Route::get('/get-country-list',[CommonController::class,'get_country_list']);
Route::get('/get-states-by-country/{id}',[CommonController::class,'get_states_by_country']);
Route::get('/get-city-by-state/{id}',[CommonController::class,'get_city_by_state']);
Route::get('/get-town-by-city/{id}',[CommonController::class,'get_town_by_district']);
Route::get('/get-postalcode-by-city/{id}',[CommonController::class,'get_postalcode_by_city']);

Route::get('/get-class-by-group/{id}',[CommonController::class,'get_class_list']);
Route::get('/get-channel-list',[CommonController::class,'get_channel_list']);
Route::get('/get-subchannel-by-channel/{id}',[CommonController::class,'get_subchannel_by_channel']);
Route::get('/get-group-by-subchannel/{id}',[CommonController::class,'get_group_list']);

Route::post('/get-subchannel-by-multichannel',[CommonController::class,'get_subchannel_by_multichannel']);
Route::post('/get-group-by-multisubchannel',[CommonController::class,'get_group_by_multisubchannel']);
Route::post('/get-class-by-multigroup',[CommonController::class,'get_class_by_multigroup']);

Route::post('/get_channel_list',[CommonController::class,'get_channel_list_all']);
Route::post('/get_group_list',[CommonController::class,'get_group_list_all']);
Route::post('/get_class_list',[CommonController::class,'get_class_list_all']);

Route::get('/distributor-branchcode-list',[CommonController::class,'distributor_branchcode_list']);

Route::get('/sales-route-list',[RouteController::class,'sales_route_list']);
Route::get('/delivery-route-list',[RouteController::class,'delivery_route_list']);


Route::post('/get-pjp-list',[SalesmanController::class,'get_pjp_list']); 

Route::post('/get-orderitems-list',[OrderController::class,'get_orderitems_list']); 
Route::post('/get-pending-outlets',[CustomerController::class,'get_pending_outlets']); 
Route::post('/get-jc-beats',[OrderController::class,'get_jc_beats']); 
Route::post('/get-jc-beats-byroute-total-outlet',[OrderController::class,'get_jc_beats_byroute_total_outlet']); 
Route::post('/get-jc-beats-byroute-billed-outlet',[OrderController::class,'get_jc_beats_byroute_billed_outlet']); 
Route::post('/get-other-jc-beats',[OrderController::class,'get_other_jc_beats']); 
Route::post('/get-other-beats-byroute-total-outlet',[OrderController::class,'get_other_beats_byroute_total_outlet']); 
Route::post('/get-other-beats-byroute-billed-outlet',[OrderController::class,'get_other_beats_byroute_billed_outlet']); 


Route::post('/get-product-info',[CommonController::class,'get_product_info']);
Route::post('/get_distributor_branchCode',[CommonController::class,'get_distributor_branchCode']); 

Route::post('/get-pending-outlets',[CustomerController::class,'get_pending_outlets']); 
Route::post('/get-jc-beats',[OrderController::class,'get_jc_beats']); 
Route::post('/get-jc-beats-byroute-total-outlet',[OrderController::class,'get_jc_beats_byroute_total_outlet']); 
Route::post('/get-jc-beats-byroute-billed-outlet',[OrderController::class,'get_jc_beats_byroute_billed_outlet']); 


Route::post('/mark-salesman-attendance',[SalesmanController::class,'mark_salesman_attendance']); 
Route::post('/check-salesman-attendance',[SalesmanController::class,'check_salesman_attendance']); 
Route::post('/mark-salesman-market-attendance',[SalesmanController::class,'mark_salesman_market_attendance']); 
Route::post('/update-salesman-attendance',[SalesmanController::class,'update_salesman_attendance']); 
  
//product hierarchy level
Route::get('/product-hierarchy-level',[ProductHierarchyController::class,'index']);
Route::post('/create-product-hierarchy-level',[ProductHierarchyController::class,'store']);
Route::delete('/delete-product-hierarchy-level/{id}',[ProductHierarchyController::class,'destroy']);
Route::put('/update-product-hierarchy-level/{id}',[ProductHierarchyController::class,'update']);
Route::get('/get-reporting-level/{id}',[ProductHierarchyController::class,'reporting_level_list']);

Route::get('/product-hierarchy-level-value',[ProductHierarchyController::class,'product_hierarchy_level_value']);
Route::post('/product-hierarchy-value-bulk-upload',[ProductHierarchyController::class,'product_hierarchy_value_bulk_upload']);
Route::delete('/delete-product-hierarchy-level-value/{id}',[ProductHierarchyController::class,'destroy_level_value']);
Route::put('/update-product-hierarchy-level-value/{id}',[ProductHierarchyController::class,'update_level_value']);

Route::get('/sales-hierarchy-level',[SalesHierarchyController::class,'sales_hierarchy_level']); 
Route::post('/create-sales-hierarchy-level',[SalesHierarchyController::class,'store']);
Route::put('/update-sales-hierarchy-level/{id}',[SalesHierarchyController::class,'update_sales_hierarchy_level']);
Route::delete('/delete-sales-hierarchy-level/{id}',[SalesHierarchyController::class,'destroy']);
Route::post('/sales-hierarchy-bulk-upload',[SalesHierarchyController::class,'sales_hierarchy_bulk_upload']);

Route::get('/sales-hierarchy-level-value',[SalesHierarchyController::class,'sales_hierarchy_level_value']); 
Route::post('/create-sales-hierarchy-level-value',[SalesHierarchyController::class,'store_value']);
Route::put('/update-sales-hierarchy-level-value/{id}',[SalesHierarchyController::class,'update_sales_hierarchy_level_value']);
Route::delete('/delete-sales-hierarchy-level-value/{id}',[SalesHierarchyController::class,'destroy_value']);
Route::post('/sales-hierarchy-value-bulk-upload',[SalesHierarchyController::class,'sales_hierarchy_bulk_upload_value']);

Route::get('/geo-hierarchy-level',[GeoHierarchyController::class,'geo_hierarchy_level']); 
Route::post('/create-geo-hierarchy-level',[GeoHierarchyController::class,'store']);
Route::put('/update-geo-hierarchy-level/{id}',[GeoHierarchyController::class,'update_geo_hierarchy_level']);
Route::delete('/delete-geo-hierarchy-level/{id}',[GeoHierarchyController::class,'destroy']);
Route::post('/geo-hierarchy-bulk-upload',[GeoHierarchyController::class,'geo_hierarchy_bulk_upload']);

Route::get('/geo-hierarchy-level-value',[GeoHierarchyController::class,'geo_hierarchy_level_value']); 
Route::post('/create-geo-hierarchy-level-value',[GeoHierarchyController::class,'store_value']);
Route::put('/update-geo-hierarchy-level-value/{id}',[GeoHierarchyController::class,'update_geo_hierarchy_level_value']);
Route::delete('/delete-geo-hierarchy-level-value/{id}',[GeoHierarchyController::class,'destroy_value']);
Route::post('/geo-hierarchy-value-bulk-upload',[GeoHierarchyController::class,'geo_hierarchy_bulk_upload_value']);


Route::post('/get-salesman-by-distributor',[BillingController::class,'get_salesman_by_distributor']); 
Route::post('/get-route-by-salesman',[BillingController::class,'get_route_by_salesman']);
Route::post('/get-customer-by-route',[BillingController::class,'get_customer_by_route']);
Route::post('/get-product-listby-distributor',[BillingController::class,'get_product_listby_distributor']);
Route::post('/get-product-info',[BillingController::class,'get_product_info']);
Route::post('/create-billing',[BillingController::class,'create_billing']);
Route::post('/get-billing-list',[BillingController::class,'get_billing_list']);
Route::post('/get-billing-info',[BillingController::class,'get_billing_info']);
// g