<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::dashboard');


$routes->group('items', static function ($routes) {
    $routes->get('lists', 'ItemsController::list');
    $routes->match(['get','post'],'create', 'ItemsController::create');
    $routes->match(['get','post'],'edit/(:num)', 'ItemsController::edit/$1');
    $routes->post('updateStatus', 'ItemsController::updateStatus');
    $routes->get('view/(:num)', 'ItemsController::view/$1');
    $routes->post('checkItemCodeExist', 'ItemsController::checkItemCodeExist');
});

$routes->group('customer', static function ($routes) {
    $routes->get('lists', 'CustomerController::list');
    $routes->match(['get','post'],'create', 'CustomerController::create');
    $routes->match(['get','post'],'edit/(:num)', 'CustomerController::edit/$1');
    $routes->post('updateStatus', 'CustomerController::updateStatus');
    $routes->get('view/(:num)', 'CustomerController::view/$1');
});

$routes->group('invoice', static function ($routes) {
    $routes->get('lists', 'InvoiceController::list');
    $routes->match(['get','post'],'create', 'InvoiceController::create');
    $routes->match(['get','post'],'edit/(:num)', 'InvoiceController::edit/$1');
    $routes->get('view/(:num)', 'InvoiceController::view/$1');
    $routes->post('statusUpdate/(:num)', 'InvoiceController::statusUpdate/$1');
    $routes->get('invoicePdf/(:num)', 'InvoiceController::invoicePdf/$1');
});

$routes->group('quotation', static function ($routes) {
    $routes->get('lists', 'QuotationController::list');
    $routes->match(['get','post'],'create', 'QuotationController::create');
    $routes->match(['get','post'],'edit/(:num)', 'QuotationController::edit/$1');
    $routes->get('view/(:num)', 'QuotationController::view/$1');
    $routes->post('statusUpdate/(:num)', 'QuotationController::statusUpdate/$1');
    $routes->get('quotationPdf/(:num)', 'QuotationController::quotationPdf/$1');
});