<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/helpers.php';

$r = $_GET['r'] ?? 'dashboard/index';
list($controller, $action) = array_pad(explode('/', $r), 2, 'index');

$map = [
  'auth' => 'AuthController',
  'dashboard' => 'DashboardController',
  'buildings' => 'BuildingsController',
  'units' => 'UnitsController',
  'tenants' => 'TenantsController',
  'leases' => 'LeasesController',
  'invoices' => 'InvoicesController',
  'payments' => 'PaymentsController',
  'expense_heads' => 'ExpenseHeadsController',
  'expenses' => 'ExpensesController',
  'reports' => 'ReportsController',
];

if (!isset($map[$controller])) { http_response_code(404); echo "Not found"; exit; }

require_once __DIR__ . '/../controllers/' . $map[$controller] . '.php';
$cls = $map[$controller];
$inst = new $cls();

if (!method_exists($inst, $action)) { http_response_code(404); echo "Not found"; exit; }
call_user_func([$inst, $action]);
