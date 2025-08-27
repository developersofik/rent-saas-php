<?php
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../models/Unit.php';
require_once __DIR__ . '/../models/Building.php';
require_once __DIR__ . '/../config/audit.php';

class UnitsController {
  private $m;
  private $b;
  public function __construct() { $this->m = new Unit(); $this->b = new Building(); }
  public function index() { require_auth(); require_role(['ADMIN','MANAGER']); $items = $this->m->all(); view('units/index', compact('items')); }
  public function create() { require_auth(); require_role(['ADMIN','MANAGER']); $buildings = $this->b->all(); view('units/form', compact('buildings')); }
  public function store() {
    require_auth(); require_role(['ADMIN','MANAGER']); verify_csrf();
    $data = [
      'building_id' => (int)($_POST['building_id'] ?? 0),
      'unit_no' => $_POST['unit_no'] ?? '',
      'floor' => $_POST['floor'] ?? '',
      'type' => $_POST['type'] ?? '',
      'size_sqft' => (int)($_POST['size_sqft'] ?? 0),
      'base_rent' => (float)($_POST['base_rent'] ?? 0),
      'deposit_amount' => (float)($_POST['deposit_amount'] ?? 0),
      'status' => $_POST['status'] ?? 'vacant',
      'meter_number_electric' => $_POST['meter_number_electric'] ?? '',
      'meter_number_water' => $_POST['meter_number_water'] ?? '',
      'meter_number_gas' => $_POST['meter_number_gas'] ?? '',
      'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
    ];
    $id = $this->m->insert($data);
    audit_log('create','units',$id,$data);
    redirect('index.php?r=units/index');
  }
  public function edit() { require_auth(); require_role(['ADMIN','MANAGER']); $id = (int)($_GET['id'] ?? 0); $item = $this->m->find($id); $buildings = $this->b->all(); view('units/form', compact('item','buildings')); }
  public function update() {
    require_auth(); require_role(['ADMIN','MANAGER']); verify_csrf(); $id = (int)($_GET['id'] ?? 0);
    $data = [
      'building_id' => (int)($_POST['building_id'] ?? 0),
      'unit_no' => $_POST['unit_no'] ?? '',
      'floor' => $_POST['floor'] ?? '',
      'type' => $_POST['type'] ?? '',
      'size_sqft' => (int)($_POST['size_sqft'] ?? 0),
      'base_rent' => (float)($_POST['base_rent'] ?? 0),
      'deposit_amount' => (float)($_POST['deposit_amount'] ?? 0),
      'status' => $_POST['status'] ?? 'vacant',
      'meter_number_electric' => $_POST['meter_number_electric'] ?? '',
      'meter_number_water' => $_POST['meter_number_water'] ?? '',
      'meter_number_gas' => $_POST['meter_number_gas'] ?? '',
      'updated_at' => date('Y-m-d H:i:s')
    ];
    $this->m->update($id,$data);
    audit_log('update','units',$id,$data);
    redirect('index.php?r=units/index');
  }
  public function delete() { require_auth(); require_role(['ADMIN','MANAGER']); $id=(int)($_GET['id']??0); $this->m->delete($id); audit_log('delete','units',$id,[]); redirect('index.php?r=units/index'); }
}
