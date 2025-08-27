<?php
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/audit.php';
require_once __DIR__ . '/../models/Tenant.php';

class TenantsController {
  private $m;
  public function __construct() { $this->m = new Tenant(); }
  public function index() { require_auth(); require_role(['ADMIN','MANAGER']); $items = $this->m->all(); view('tenants/index', compact('items')); }
  public function create() { require_auth(); require_role(['ADMIN','MANAGER']); view('tenants/form'); }
  public function store() {
    require_auth(); require_role(['ADMIN','MANAGER']); verify_csrf();
    $data = [
      'name' => $_POST['name'] ?? '',
      'phone' => $_POST['phone'] ?? '',
      'email' => $_POST['email'] ?? '',
      'nid' => '', 'address' => $_POST['address'] ?? '',
      'guarantor_json' => '{}', 'documents_json' => '{}',
      'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
    ];
    $id = $this->m->insert($data);
    audit_log('create','tenants',$id,$data);
    redirect('index.php?r=tenants/index');
  }
  public function edit() { require_auth(); require_role(['ADMIN','MANAGER']); $id = (int)($_GET['id'] ?? 0); $item = $this->m->find($id); view('tenants/form', compact('item')); }
  public function update() {
    require_auth(); require_role(['ADMIN','MANAGER']); verify_csrf(); $id = (int)($_GET['id'] ?? 0);
    $data = [
      'name' => $_POST['name'] ?? '',
      'phone' => $_POST['phone'] ?? '',
      'email' => $_POST['email'] ?? '',
      'address' => $_POST['address'] ?? '',
      'updated_at' => date('Y-m-d H:i:s')
    ];
    $this->m->update($id, $data);
    audit_log('update','tenants',$id,$data);
    redirect('index.php?r=tenants/index');
  }
  public function delete() { require_auth(); require_role(['ADMIN','MANAGER']); $id = (int)($_GET['id'] ?? 0); $this->m->delete($id); audit_log('delete','tenants',$id,[]); redirect('index.php?r=tenants/index'); }
}
