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
      <div>Building: <?= e($item['building_id']) ?></div>
    </div>
    <div class="col-6 text-end">
      <strong>Invoice</strong><br>
      No: <?= e($item['invoice_no']) ?><br>
      Period: <?= e($item['period_month']) ?>
    </div>
  </div>
  <hr>
  <table class="table table-sm">
    <thead><tr><th>SL</th><th>Description</th><th class="text-end">Amount (৳)</th></tr></thead>
    <tbody>
      <tr><td>1</td><td>Rent</td><td class="text-end"><?= e(number_format((float)($item['totals_json']['grand_total'] ?? 0))) ?></td></tr>
    </tbody>
    <tfoot>
      <tr><th colspan="2" class="text-end">Grand Total</th><th class="text-end">৳ <?= e(number_format((float)($item['totals_json']['grand_total'] ?? 0))) ?></th></tr>
    </tfoot>
  </table>
  <div class="row">
    <div class="col-4">Prepared by: ____________</div>
    <div class="col-4">Approved by: ____________</div>
    <div class="col-4">Tenant signature: ____________</div>
  </div>
  <small class="text-muted">Late fee policy: ...</small>
</div>
