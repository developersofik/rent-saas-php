<?php
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/audit.php';
require_once __DIR__ . '/../models/Invoice.php';
require_once __DIR__ . '/../models/InvoiceLine.php';

class InvoicesController {
  private $m; private $l;
  public function __construct() { $this->m = new Invoice(); $this->l = new InvoiceLine(); }
  public function index() { require_auth(); require_role(['ADMIN','MANAGER']); $items = array_map(function($row){ $row['totals_json'] = json_decode($row['totals_json'] ?: '{}', true); return $row; }, $this->m->all('id DESC')); view('invoices/index', compact('items')); }
  public function create() { require_auth(); require_role(['ADMIN','MANAGER']); view('invoices/form'); }
  public function store() {
    require_auth(); require_role(['ADMIN','MANAGER']); verify_csrf();
    $descs = $_POST['desc'] ?? [];
    $qtys = $_POST['qty'] ?? [];
    $rates = $_POST['rate'] ?? [];
    $lines = [];
    $subtotal = 0;
    foreach ($descs as $i => $d) {
      $qty = (float)($qtys[$i] ?? 1);
      $rate = (float)($rates[$i] ?? 0);
      $amount = $qty * $rate;
      $subtotal += $amount;
      $lines[] = ['description'=>$d,'qty'=>$qty,'rate'=>$rate,'amount'=>$amount,'tax'=>0];
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
    $item = $this->m->find($id);
    $item['totals_json'] = json_decode($item['totals_json'] ?: '{}', true);
    $stmt = db()->prepare("SELECT * FROM invoice_lines WHERE invoice_id=?");
    $stmt->execute([$id]);
    $lines = $stmt->fetchAll();
    view('invoices/show', compact('item','lines'));
  }
}
