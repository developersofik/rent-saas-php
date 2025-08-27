<?php
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../models/Building.php';

class ReportsController {
  public function monthly() {
    require_auth(); require_role(['ADMIN','MANAGER']);
    $bModel = new Building();
    $buildings = $bModel->all();
    $month = $_GET['month'] ?? date('Y-m');
    $status = $_GET['status'] ?? '';
    $building_id = (int)($_GET['building_id'] ?? 0);
    $sql = "SELECT i.*, t.name tenant, u.unit_no, i.totals_json FROM invoices i LEFT JOIN leases l ON i.lease_id=l.id LEFT JOIN tenants t ON l.tenant_id=t.id LEFT JOIN units u ON l.unit_id=u.id WHERE i.period_month=?";
    $params = [$month];
    if ($building_id) { $sql .= " AND i.building_id=?"; $params[] = $building_id; }
    if ($status) { $sql .= " AND i.status=?"; $params[] = $status; }
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    $items = $stmt->fetchAll();
    $items = array_map(function($r){ $r['totals_json'] = json_decode($r['totals_json'] ?: '{}', true); return $r; }, $items);
    view('reports/monthly', compact('items','buildings','month','status','building_id'));
  }
  public function yearly() {
    require_auth(); require_role(['ADMIN','MANAGER']);
    $year = $_GET['year'] ?? date('Y');
    $stmt = db()->prepare("SELECT period_month, SUM(JSON_EXTRACT(totals_json,'$.grand_total')) as total FROM invoices WHERE LEFT(period_month,4)=? GROUP BY period_month");
    $stmt->execute([$year]);
    $rows = $stmt->fetchAll();
    view('reports/yearly', compact('rows','year'));
  }
}
