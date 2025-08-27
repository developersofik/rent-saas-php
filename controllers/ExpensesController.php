<?php
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/audit.php';
require_once __DIR__ . '/../models/Expense.php';
require_once __DIR__ . '/../models/ExpenseHead.php';
require_once __DIR__ . '/../models/Building.php';

class ExpensesController {
  private $m; private $h; private $b;
  public function __construct(){ $this->m=new Expense(); $this->h=new ExpenseHead(); $this->b=new Building(); }
  public function index(){ require_auth(); require_role(['ADMIN','MANAGER']); $items=$this->m->all(); view('expenses/index',compact('items')); }
  public function create(){ require_auth(); require_role(['ADMIN','MANAGER']); $heads=$this->h->all(); $buildings=$this->b->all(); view('expenses/form',compact('heads','buildings')); }
  public function store(){ require_auth(); require_role(['ADMIN','MANAGER']); verify_csrf(); $data=[ 'building_id'=>(int)($_POST['building_id']??0), 'expense_head_id'=>(int)($_POST['expense_head_id']??0), 'amount'=>(float)($_POST['amount']??0), 'date'=>$_POST['date']??date('Y-m-d'), 'notes'=>$_POST['notes']??'', 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s') ]; $id=$this->m->insert($data); audit_log('create','expenses',$id,$data); redirect('index.php?r=expenses/index'); }
  public function edit(){ require_auth(); require_role(['ADMIN','MANAGER']); $id=(int)($_GET['id']??0); $item=$this->m->find($id); $heads=$this->h->all(); $buildings=$this->b->all(); view('expenses/form',compact('item','heads','buildings')); }
  public function update(){ require_auth(); require_role(['ADMIN','MANAGER']); verify_csrf(); $id=(int)($_GET['id']??0); $data=[ 'building_id'=>(int)($_POST['building_id']??0), 'expense_head_id'=>(int)($_POST['expense_head_id']??0), 'amount'=>(float)($_POST['amount']??0), 'date'=>$_POST['date']??date('Y-m-d'), 'notes'=>$_POST['notes']??'', 'updated_at'=>date('Y-m-d H:i:s') ]; $this->m->update($id,$data); audit_log('update','expenses',$id,$data); redirect('index.php?r=expenses/index'); }
  public function delete(){ require_auth(); require_role(['ADMIN','MANAGER']); $id=(int)($_GET['id']??0); $this->m->delete($id); audit_log('delete','expenses',$id,[]); redirect('index.php?r=expenses/index'); }
}
