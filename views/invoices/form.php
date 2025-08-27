<?php require_auth(); ?>
<h4>Create Invoice</h4>
<form method="post" action="<?= base_url('index.php?r=invoices/store') ?>">
  <?php csrf_field() ?>
  <div class="row g-3 mb-3">
    <div class="col-md-3">
      <label class="form-label">Lease</label>
      <select class="form-select" name="lease_id" required>
        <option value="">Select Lease</option>
        <?php foreach($leases as $l): ?>
          <option value="<?= e($l['id']) ?>"><?= e($l['tenant'].' - '.$l['unit_no'].' (Floor '.$l['floor'].')') ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">Period (YYYY-MM)</label>
      <input class="form-control" name="period_month" placeholder="2025-08" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Invoice No</label>
      <input class="form-control" name="invoice_no" placeholder="INV-0001" required>
    </div>
  </div>
  <table class="table table-sm">
    <thead><tr><th>Head</th><th>Description</th><th>Qty</th><th>Rate</th><th>Amount</th></tr></thead>
    <tbody>
      <?php foreach(['Rent','Utilities','Parking','Others'] as $d): ?>
      <tr>
        <td>
          <select class="form-select" name="income_head_id[]">
            <?php foreach($income_heads as $h): ?>
              <option value="<?= e($h['id']) ?>"><?= e($h['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </td>
        <td><input class="form-control" name="desc[]" value="<?= $d ?>"></td>
        <td><input class="form-control" name="qty[]" value="1"></td>
        <td><input class="form-control" name="rate[]" value="0"></td>
        <td class="text-muted">auto</td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="row g-3">
    <div class="col-md-3"><label class="form-label">Previous Due</label><input class="form-control" name="previous_due" value="0"></div>
    <div class="col-md-3"><label class="form-label">Discount</label><input class="form-control" name="discount" value="0"></div>
    <div class="col-md-3"><label class="form-label">Advance Adjust</label><input class="form-control" name="advance_adjust" value="0"></div>
    <div class="col-md-3"><label class="form-label">Tax</label><input class="form-control" name="tax" value="0"></div>
  </div>
  <div class="mt-3">
    <button class="btn btn-primary">Save</button>
    <a class="btn btn-light" href="<?= base_url('index.php?r=invoices/index') ?>">Cancel</a>
  </div>
</form>
