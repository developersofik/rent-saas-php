<?php
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/audit.php';
require_once __DIR__ . '/../models/Building.php';

class BuildingsController {
  private $m;
  public function __construct() { $this->m = new Building(); }
  public function index() { require_auth(); require_role(['ADMIN','MANAGER']); $items = $this->m->all(); view('buildings/index', compact('items')); }
  public function create() { require_auth(); require_role(['ADMIN','MANAGER']); view('buildings/form'); }
  public function store() {
    require_auth(); require_role(['ADMIN','MANAGER']); verify_csrf();
    $data = [
      'name' => $_POST['name'] ?? '',
      'short_code' => $_POST['short_code'] ?? '',
      'address' => $_POST['address'] ?? '',
      'manager_id' => null, 'currency' => $_POST['currency'] ?? 'BDT',
      'amenities_json' => '{}', 'utility_config' => '{}',
      'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
    ];
    $id = $this->m->insert($data);
    audit_log('create','buildings',$id,$data);
    redirect('index.php?r=buildings/index');
  }
  public function edit() { require_auth(); require_role(['ADMIN','MANAGER']); $id = (int)($_GET['id'] ?? 0); $item = $this->m->find($id); view('buildings/form', compact('item')); }
  public function update() {
    require_auth(); require_role(['ADMIN','MANAGER']); verify_csrf(); $id = (int)($_GET['id'] ?? 0);
    $data = [
      'name' => $_POST['name'] ?? '',
      'short_code' => $_POST['short_code'] ?? '',
      'address' => $_POST['address'] ?? '',
      'currency' => $_POST['currency'] ?? 'BDT',
      'updated_at' => date('Y-m-d H:i:s')
    ];
    $this->m->update($id, $data);
    audit_log('update','buildings',$id,$data);
    redirect('index.php?r=buildings/index');
  }
  public function delete() { require_auth(); require_role(['ADMIN','MANAGER']); $id = (int)($_GET['id'] ?? 0); $this->m->delete($id); audit_log('delete','buildings',$id,[]); redirect('index.php?r=buildings/index'); }
}
