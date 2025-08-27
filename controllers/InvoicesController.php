<?php
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/audit.php';
require_once __DIR__ . '/../models/Invoice.php';
require_once __DIR__ . '/../models/InvoiceLine.php';
require_once __DIR__ . '/../models/IncomeHead.php';
require_once __DIR__ . '/../models/Lease.php';

class InvoicesController {
  private $m; private $l;
  public function __construct() { $this->m = new Invoice(); $this->l = new InvoiceLine(); }
  public function index() { require_auth(); require_role(['ADMIN','MANAGER']); $items = array_map(function($row){ $row['totals_json'] = json_decode($row['totals_json'] ?: '{}', true); return $row; }, $this->m->all('id DESC')); view('invoices/index', compact('items')); }
  public function create() {
    require_auth(); require_role(['ADMIN','MANAGER']);
    $ih = new IncomeHead();
    $income_heads = $ih->all();
    $stmt = db()->query("SELECT l.id, t.name tenant, u.unit_no, u.floor FROM leases l JOIN tenants t ON l.tenant_id=t.id JOIN units u ON l.unit_id=u.id WHERE l.status='active' ORDER BY u.floor, u.unit_no");
    $leases = $stmt->fetchAll();
    view('invoices/form', compact('income_heads','leases'));
  }
  public function store() {
    require_auth(); require_role(['ADMIN','MANAGER']); verify_csrf();
    $descs = $_POST['desc'] ?? [];
    $qtys = $_POST['qty'] ?? [];
    $rates = $_POST['rate'] ?? [];
    $head_ids = $_POST['income_head_id'] ?? [];
    $lines = [];
    $subtotal = 0;
    foreach ($descs as $i => $d) {
      $qty = (float)($qtys[$i] ?? 1);
      $rate = (float)($rates[$i] ?? 0);
      $amount = $qty * $rate;
      $subtotal += $amount;
      $lines[] = ['income_head_id'=>(int)($head_ids[$i] ?? 0),'description'=>$d,'qty'=>$qty,'rate'=>$rate,'amount'=>$amount,'tax'=>0];
    }
    $previous_due = (float)($_POST['previous_due'] ?? 0);
    $discount = (float)($_POST['discount'] ?? 0);
    $advance_adjust = (float)($_POST['advance_adjust'] ?? 0);
    $tax = (float)($_POST['tax'] ?? 0);
    $grand_total = $subtotal + $previous_due - $discount - $advance_adjust + $tax;
    $totals = compact('subtotal','previous_due','discount','advance_adjust','tax','grand_total');
    $data = [
      'invoice_no' => $_POST['invoice_no'] ?? '',
      'lease_id' => (int)($_POST['lease_id'] ?? 0),
      'building_id' => 1,
      'period_month' => $_POST['period_month'] ?? '',
      'totals_json' => json_encode($totals),
      'status' => 'unpaid',
      'qr_payload' => '',
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s')
    ];
    $id = $this->m->insert($data);
    foreach ($lines as $ln) { $ln['invoice_id']=$id; $ln['created_at']=date('Y-m-d H:i:s'); $ln['updated_at']=date('Y-m-d H:i:s'); $this->l->insert($ln); }
    audit_log('create','invoices',$id,$data);
    redirect('index.php?r=invoices/index');
  }
  public function show() {
    require_auth(); require_role(['ADMIN','MANAGER']);
    $id = (int)($_GET['id'] ?? 0);
    $stmt = db()->prepare("SELECT i.*, t.name tenant, u.unit_no, u.floor, b.name building_name FROM invoices i LEFT JOIN leases l ON i.lease_id=l.id LEFT JOIN tenants t ON l.tenant_id=t.id LEFT JOIN units u ON l.unit_id=u.id LEFT JOIN buildings b ON i.building_id=b.id WHERE i.id=?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    $item['totals_json'] = json_decode($item['totals_json'] ?: '{}', true);
    $stmt = db()->prepare("SELECT il.*, h.name head_name FROM invoice_lines il LEFT JOIN income_heads h ON il.income_head_id=h.id WHERE il.invoice_id=?");
    $stmt->execute([$id]);
    $lines = $stmt->fetchAll();
    view('invoices/show', compact('item','lines'));
  }

  public function print_month() {
    require_auth(); require_role(['ADMIN','MANAGER']);
    $month = $_GET['month'] ?? date('Y-m');
    $building_id = (int)($_GET['building_id'] ?? 0);
    $sql = "SELECT i.*, t.name tenant, u.unit_no, u.floor, b.name building_name FROM invoices i LEFT JOIN leases l ON i.lease_id=l.id LEFT JOIN tenants t ON l.tenant_id=t.id LEFT JOIN units u ON l.unit_id=u.id LEFT JOIN buildings b ON i.building_id=b.id WHERE i.period_month=?";
    $params = [$month];
    if ($building_id) { $sql .= " AND i.building_id=?"; $params[] = $building_id; }
    $sql .= " ORDER BY u.floor, u.unit_no";
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    $items = $stmt->fetchAll();
    $lineStmt = db()->prepare("SELECT il.*, h.name head_name FROM invoice_lines il LEFT JOIN income_heads h ON il.income_head_id=h.id WHERE il.invoice_id=?");
    foreach ($items as &$it) {
      $lineStmt->execute([$it['id']]);
      $it['lines'] = $lineStmt->fetchAll();
      $it['totals_json'] = json_decode($it['totals_json'] ?: '{}', true);
    }
    view('invoices/print_month', ['items'=>$items,'month'=>$month]);
  }
}
