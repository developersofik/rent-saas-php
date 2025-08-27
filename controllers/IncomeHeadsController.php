<?php
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/audit.php';
require_once __DIR__ . '/../models/IncomeHead.php';

class IncomeHeadsController {
  private $m;
  public function __construct(){ $this->m=new IncomeHead(); }
  public function index(){ require_auth(); require_role(['ADMIN','MANAGER']); $items=$this->m->all(); view('income_heads/index',compact('items')); }
  public function create(){ require_auth(); require_role(['ADMIN','MANAGER']); view('income_heads/form'); }
  public function store(){ require_auth(); require_role(['ADMIN','MANAGER']); verify_csrf(); $data=[ 'name'=>$_POST['name']??'', 'description'=>$_POST['description']??'', 'status'=>$_POST['status']??'active','created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s') ]; $id=$this->m->insert($data); audit_log('create','income_heads',$id,$data); redirect('index.php?r=income_heads/index'); }
  public function edit(){ require_auth(); require_role(['ADMIN','MANAGER']); $id=(int)($_GET['id']??0); $item=$this->m->find($id); view('income_heads/form',compact('item')); }
  public function update(){ require_auth(); require_role(['ADMIN','MANAGER']); verify_csrf(); $id=(int)($_GET['id']??0); $data=[ 'name'=>$_POST['name']??'', 'description'=>$_POST['description']??'', 'status'=>$_POST['status']??'active','updated_at'=>date('Y-m-d H:i:s') ]; $this->m->update($id,$data); audit_log('update','income_heads',$id,$data); redirect('index.php?r=income_heads/index'); }
  public function delete(){ require_auth(); require_role(['ADMIN','MANAGER']); $id=(int)($_GET['id']??0); $this->m->delete($id); audit_log('delete','income_heads',$id,[]); redirect('index.php?r=income_heads/index'); }
}
