<?php require_auth(); ?>
<h4>Create Invoice (Basic)</h4>
<form method="post" action="<?= base_url('index.php?r=invoices/store') ?>">
  <?php csrf_field() ?>
  <div class="row g-3">
    <div class="col-md-3">
      <label class="form-label">Lease ID</label>
      <input class="form-control" name="lease_id" placeholder="e.g., 1" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Period (YYYY-MM)</label>
      <input class="form-control" name="period_month" placeholder="2025-08" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Invoice No</label>
      <input class="form-control" name="invoice_no" placeholder="INV-0001" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Total (৳)</label>
      <input class="form-control" name="grand_total" placeholder="15000" required>
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-primary">Save</button>
    <a class="btn btn-light" href="<?= base_url('index.php?r=invoices/index') ?>">Cancel</a>
  </div>
</form>
