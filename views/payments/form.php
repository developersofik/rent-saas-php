<?php require_auth(); ?>
<h4>Create Payment</h4>
<form method="post" action="<?= base_url('index.php?r=payments/store') ?>">
  <?php csrf_field() ?>
  <div class="row g-3">
    <div class="col-md-4">
      <label class="form-label">Invoice</label>
      <select class="form-select" name="invoice_id" required>
        <?php foreach($invoices as $inv): ?>
          <option value="<?= e($inv['id']) ?>">#<?= e($inv['invoice_no']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">Method</label>
      <input class="form-control" name="method" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Reference</label>
      <input class="form-control" name="txn_ref">
    </div>
    <div class="col-md-3">
      <label class="form-label">Amount</label>
      <input class="form-control" name="amount" required>
    </div>
    <div class="col-md-2">
      <label class="form-label">Paid At</label>
      <input type="datetime-local" class="form-control" name="paid_at" value="<?= date('Y-m-d\TH:i') ?>">
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-primary">Save</button>
    <a class="btn btn-light" href="<?= base_url('index.php?r=payments/index') ?>">Cancel</a>
  </div>
</form>
