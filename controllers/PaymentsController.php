<?php
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/audit.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/../models/Invoice.php';

class PaymentsController {
  private $m; private $i;
  public function __construct(){ $this->m=new Payment(); $this->i=new Invoice(); }
  public function index(){ require_auth(); require_role(['ADMIN','MANAGER']); $items=$this->m->all(); view('payments/index',compact('items')); }
  public function create(){ require_auth(); require_role(['ADMIN','MANAGER']); $invoices=$this->i->all(); view('payments/form',compact('invoices')); }
  public function store(){
    require_auth(); require_role(['ADMIN','MANAGER']); verify_csrf();
    $data=[ 'invoice_id'=>(int)($_POST['invoice_id']??0), 'method'=>$_POST['method']??'', 'txn_ref'=>$_POST['txn_ref']??'', 'amount'=>(float)($_POST['amount']??0), 'paid_at'=>$_POST['paid_at']??date('Y-m-d H:i:s'), 'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s') ];
    $id=$this->m->insert($data);
    // update invoice status
    $inv=$this->i->find($data['invoice_id']);
    $tot=json_decode($inv['totals_json'] ?: '{}', true);
    $stmt=db()->prepare("SELECT SUM(amount) as s FROM payments WHERE invoice_id=?");
    $stmt->execute([$data['invoice_id']]);
    $paid=(float)($stmt->fetch()['s'] ?? 0);
    $status='unpaid';
    if ($paid >= ($tot['grand_total'] ?? 0)) $status='paid';
    elseif ($paid>0) $status='part-paid';
    $this->i->update($data['invoice_id'], ['status'=>$status,'updated_at'=>date('Y-m-d H:i:s')]);
    audit_log('create','payments',$id,$data);
    redirect('index.php?r=payments/index');
  }
  public function delete(){ require_auth(); require_role(['ADMIN','MANAGER']); $id=(int)($_GET['id']??0); $this->m->delete($id); audit_log('delete','payments',$id,[]); redirect('index.php?r=payments/index'); }
}
