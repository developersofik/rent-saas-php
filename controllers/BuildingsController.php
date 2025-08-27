<?php
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../models/Building.php';

class BuildingsController {
  private $m;
  public function __construct() { $this->m = new Building(); }
  public function index() { require_auth(); $items = $this->m->all(); view('buildings/index', compact('items')); }
  public function create() { require_auth(); view('buildings/form'); }
  public function store() {
    require_auth(); verify_csrf();
    $this->m->insert([
      'name' => $_POST['name'] ?? '',
      'short_code' => $_POST['short_code'] ?? '',
      'address' => $_POST['address'] ?? '',
      'manager_id' => null, 'currency' => $_POST['currency'] ?? 'BDT',
      'amenities_json' => '{}', 'utility_config' => '{}',
      'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
    ]);
    redirect('index.php?r=buildings/index');
  }
  public function edit() { require_auth(); $id = (int)($_GET['id'] ?? 0); $item = $this->m->find($id); view('buildings/form', compact('item')); }
  public function update() {
    require_auth(); verify_csrf(); $id = (int)($_GET['id'] ?? 0);
    $this->m->update($id, [
      'name' => $_POST['name'] ?? '',
      'short_code' => $_POST['short_code'] ?? '',
      'address' => $_POST['address'] ?? '',
      'currency' => $_POST['currency'] ?? 'BDT',
      'updated_at' => date('Y-m-d H:i:s')
    ]);
    redirect('index.php?r=buildings/index');
  }
  public function delete() { require_auth(); $id = (int)($_GET['id'] ?? 0); $this->m->delete($id); redirect('index.php?r=buildings/index'); }
}
