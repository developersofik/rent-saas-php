<?php
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../models/Building.php';
require_once __DIR__ . '/../models/Tenant.php';
require_once __DIR__ . '/../models/Invoice.php';

class DashboardController {
  public function index() {
    require_auth();
    $tenants = (int)db()->query('SELECT COUNT(*) c FROM tenants')->fetch()['c'];
    $units = (int)db()->query('SELECT COUNT(*) c FROM units')->fetch()['c'];
    $outstanding = 0;
    try {
      $stmt = db()->query("SELECT COALESCE(SUM(CAST(JSON_EXTRACT(totals_json,'$.grand_total') AS DECIMAL(18,2))),0) AS g FROM invoices");
      $g = (float)$stmt->fetch()['g'];
      $p = (float)db()->query("SELECT COALESCE(SUM(amount),0) p FROM payments")->fetch()['p'];
      $outstanding = (int)($g - $p);
    } catch (Throwable $e) { $outstanding = 0; }
    $collection_mtd = (int)db()->query("SELECT COALESCE(SUM(amount),0) c FROM payments WHERE MONTH(paid_at)=MONTH(CURDATE()) AND YEAR(paid_at)=YEAR(CURDATE())")->fetch()['c'];
    $kpis = compact('tenants','units','outstanding','collection_mtd');

    // Fetch latest invoices with tenant name and amount for dashboard list
    $latestInvoices = [];
    try {
      $sql = "SELECT i.id, t.name AS tenant, CAST(JSON_EXTRACT(i.totals_json,'$.grand_total') AS DECIMAL(12,2)) AS amount
              FROM invoices i
              LEFT JOIN leases l ON i.lease_id = l.id
              LEFT JOIN tenants t ON l.tenant_id = t.id
              ORDER BY i.created_at DESC
              LIMIT 5";
      $latestInvoices = db()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $e) {
      $latestInvoices = [];
    }

    // Sample product category distribution for the doughnut chart
    $categoryData = [
      'labels' => ['Rent', 'Utilities', 'Parking', 'Others'],
      'values' => [55, 25, 10, 10]
    ];

    view('dashboard/index', [
      'kpis' => $kpis,
      'latestInvoices' => $latestInvoices,
      'categoryData' => $categoryData
    ]);
  }
}
