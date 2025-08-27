<?php
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/audit.php';
require_once __DIR__ . '/../models/Lease.php';
require_once __DIR__ . '/../models/Tenant.php';
require_once __DIR__ . '/../models/Unit.php';

class LeasesController {
  private $m; private $t; private $u;
  public function __construct(){ $this->m=new Lease(); $this->t=new Tenant(); $this->u=new Unit(); }
  public function index(){ require_auth(); require_role(['ADMIN','MANAGER']); $items=$this->m->all(); view('leases/index',compact('items')); }
  public function create(){ require_auth(); require_role(['ADMIN','MANAGER']); $tenants=$this->t->all(); $units=$this->u->all(); view('leases/form',compact('tenants','units')); }
  public function store(){
    require_auth(); require_role(['ADMIN','MANAGER']); verify_csrf();
    $data=[
      'lease_no'=>$_POST['lease_no']??'',
      'tenant_id'=>(int)($_POST['tenant_id']??0),
      'unit_id'=>(int)($_POST['unit_id']??0),
      'start_date'=>$_POST['start_date']??'',
      'end_date'=>$_POST['end_date']??null,
      'deposit'=>(float)($_POST['deposit']??0),
      'status'=>$_POST['status']??'active',
      'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')
    ];
    $id=$this->m->insert($data);
    audit_log('create','leases',$id,$data);
    redirect('index.php?r=leases/index');
  }
  public function edit(){ require_auth(); require_role(['ADMIN','MANAGER']); $id=(int)($_GET['id']??0); $item=$this->m->find($id); $tenants=$this->t->all(); $units=$this->u->all(); view('leases/form',compact('item','tenants','units')); }
  public function update(){
    require_auth(); require_role(['ADMIN','MANAGER']); verify_csrf(); $id=(int)($_GET['id']??0);
    $data=[
      'lease_no'=>$_POST['lease_no']??'',
      'tenant_id'=>(int)($_POST['tenant_id']??0),
      'unit_id'=>(int)($_POST['unit_id']??0),
      'start_date'=>$_POST['start_date']??'',
      'end_date'=>$_POST['end_date']??null,
      'deposit'=>(float)($_POST['deposit']??0),
      'status'=>$_POST['status']??'active',
      'updated_at'=>date('Y-m-d H:i:s')
    ];
    $this->m->update($id,$data);
    audit_log('update','leases',$id,$data);
    redirect('index.php?r=leases/index');
  }
  public function delete(){ require_auth(); require_role(['ADMIN','MANAGER']); $id=(int)($_GET['id']??0); $this->m->delete($id); audit_log('delete','leases',$id,[]); redirect('index.php?r=leases/index'); }
}
