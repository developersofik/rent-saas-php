<?php
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../models/Invoice.php';

class InvoicesController {
  private $m;
  public function __construct() { $this->m = new Invoice(); }
  public function index() { require_auth(); $items = array_map(function($row){
      $row['totals_json'] = json_decode($row['totals_json'] ?: '{}', true);
      return $row;
  }, $this->m->all('id DESC')); view('invoices/index', compact('items')); }
  public function create() { require_auth(); view('invoices/form'); }
  public function store() {
    require_auth(); verify_csrf();
    $totals = ['grand_total' => (float)($_POST['grand_total'] ?? 0)];
    $this->m->insert([
      'invoice_no' => $_POST['invoice_no'] ?? '',
      'lease_id' => (int)($_POST['lease_id'] ?? 0),
      'building_id' => 1,
      'period_month' => $_POST['period_month'] ?? '',
      'totals_json' => json_encode($totals),
      'status' => 'unpaid',
      'qr_payload' => '',
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s')
    ]);
    redirect('index.php?r=invoices/index');
  }
  public function show() {
    require_auth();
    $id = (int)($_GET['id'] ?? 0);
    $item = $this->m->find($id);
    $item['totals_json'] = json_decode($item['totals_json'] ?: '{}', true);
    view('invoices/show', compact('item'));
  }
}
