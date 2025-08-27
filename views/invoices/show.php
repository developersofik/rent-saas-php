<?php require_auth(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Invoice #<?= e($item['invoice_no']) ?></h4>
  <div class="no-print">
    <a class="btn btn-outline-secondary" href="<?= base_url('index.php?r=invoices/index') ?>">Back</a>
    <button class="btn btn-primary" onclick="window.print()">Print</button>
  </div>
</div>
<div class="print-area">
  <div class="row">
    <div class="col-6">
      <h5><?= e($config['app_name']) ?></h5>
      <div>Building: <?= e($item['building_name']) ?></div>
      <div>Tenant: <?= e($item['tenant']) ?> | Unit: <?= e($item['unit_no']) ?> | Floor: <?= e($item['floor']) ?></div>
    </div>
    <div class="col-6 text-end">
      <strong>Invoice</strong><br>
      No: <?= e($item['invoice_no']) ?><br>
      Period: <?= e($item['period_month']) ?>
    </div>
  </div>
  <hr>
  <table class="table table-sm">
    <thead><tr><th>SL</th><th>Head</th><th>Description</th><th class="text-end">Qty</th><th class="text-end">Rate</th><th class="text-end">Amount</th></tr></thead>
    <tbody>
      <?php foreach ($lines as $i=>$ln): ?>
      <tr>
        <td><?= $i+1 ?></td>
        <td><?= e($ln['head_name']) ?></td>
        <td><?= e($ln['description']) ?></td>
        <td class="text-end"><?= e($ln['qty']) ?></td>
        <td class="text-end"><?= e($ln['rate']) ?></td>
        <td class="text-end"><?= e($ln['amount']) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr><th colspan="4" class="text-end">Subtotal</th><th class="text-end"><?= e($item['totals_json']['subtotal'] ?? 0) ?></th></tr>
      <tr><th colspan="4" class="text-end">Previous Due</th><th class="text-end"><?= e($item['totals_json']['previous_due'] ?? 0) ?></th></tr>
      <tr><th colspan="4" class="text-end">Discount</th><th class="text-end"><?= e($item['totals_json']['discount'] ?? 0) ?></th></tr>
      <tr><th colspan="4" class="text-end">Advance Adjust</th><th class="text-end"><?= e($item['totals_json']['advance_adjust'] ?? 0) ?></th></tr>
      <tr><th colspan="4" class="text-end">Tax</th><th class="text-end"><?= e($item['totals_json']['tax'] ?? 0) ?></th></tr>
      <tr><th colspan="4" class="text-end">Grand Total</th><th class="text-end"><?= e($item['totals_json']['grand_total'] ?? 0) ?></th></tr>
    </tfoot>
  </table>
  <div class="row">
    <div class="col-4">Prepared by: ____________</div>
    <div class="col-4">Approved by: ____________</div>
    <div class="col-4">Tenant signature: ____________</div>
  </div>
  <small class="text-muted">Late fee policy: ...</small>
</div>
