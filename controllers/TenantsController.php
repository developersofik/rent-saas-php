<?php
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../models/Tenant.php';

class TenantsController {
  private $m;
  public function __construct() { $this->m = new Tenant(); }
  public function index() { require_auth(); $items = $this->m->all(); view('tenants/index', compact('items')); }
  public function create() { require_auth(); view('tenants/form'); }
  public function store() {
    require_auth(); verify_csrf();
    $this->m->insert([
      'name' => $_POST['name'] ?? '',
      'phone' => $_POST['phone'] ?? '',
      'email' => $_POST['email'] ?? '',
      'nid' => '', 'address' => $_POST['address'] ?? '',
      'guarantor_json' => '{}', 'documents_json' => '{}',
      'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
    ]);
    redirect('index.php?r=tenants/index');
  }
  public function edit() { require_auth(); $id = (int)($_GET['id'] ?? 0); $item = $this->m->find($id); view('tenants/form', compact('item')); }
  public function update() {
    require_auth(); verify_csrf(); $id = (int)($_GET['id'] ?? 0);
    $this->m->update($id, [
      'name' => $_POST['name'] ?? '',
      'phone' => $_POST['phone'] ?? '',
      'email' => $_POST['email'] ?? '',
      'address' => $_POST['address'] ?? '',
      'updated_at' => date('Y-m-d H:i:s')
    ]);
    redirect('index.php?r=tenants/index');
  }
  public function delete() { require_auth(); $id = (int)($_GET['id'] ?? 0); $this->m->delete($id); redirect('index.php?r=tenants/index'); }
}
