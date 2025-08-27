<?php require_auth(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Invoices <?= e($month) ?></title>
<style>
.invoice-page{page-break-after:always;border:1px solid #ccc;padding:10px;margin-bottom:20px;}
@media print {.no-print{display:none}}
</style>
</head>
<body>
<div class="no-print text-end mb-3">
  <button onclick="window.print()">Print</button>
</div>
<?php foreach($items as $inv): ?>
  <?php for($copy=1;$copy<=2;$copy++): ?>
  <div class="invoice-page">
    <h4><?= e($config['app_name']) ?></h4>
    <div>Building: <?= e($inv['building_name']) ?></div>
    <div>Tenant: <?= e($inv['tenant']) ?> | Unit: <?= e($inv['unit_no']) ?> | Floor: <?= e($inv['floor']) ?></div>
    <div>Invoice No: <?= e($inv['invoice_no']) ?> | Period: <?= e($inv['period_month']) ?></div>
    <table class="table table-sm">
      <thead><tr><th>SL</th><th>Head</th><th>Description</th><th class="text-end">Qty</th><th class="text-end">Rate</th><th class="text-end">Amount</th></tr></thead>
      <tbody>
        <?php foreach($inv['lines'] as $i=>$ln): ?>
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
        <tr><th colspan="4" class="text-end">Subtotal</th><th class="text-end"><?= e($inv['totals_json']['subtotal'] ?? 0) ?></th></tr>
        <tr><th colspan="4" class="text-end">Previous Due</th><th class="text-end"><?= e($inv['totals_json']['previous_due'] ?? 0) ?></th></tr>
        <tr><th colspan="4" class="text-end">Discount</th><th class="text-end"><?= e($inv['totals_json']['discount'] ?? 0) ?></th></tr>
        <tr><th colspan="4" class="text-end">Advance Adjust</th><th class="text-end"><?= e($inv['totals_json']['advance_adjust'] ?? 0) ?></th></tr>
        <tr><th colspan="4" class="text-end">Tax</th><th class="text-end"><?= e($inv['totals_json']['tax'] ?? 0) ?></th></tr>
        <tr><th colspan="4" class="text-end">Grand Total</th><th class="text-end"><?= e($inv['totals_json']['grand_total'] ?? 0) ?></th></tr>
      </tfoot>
    </table>
    <div class="row">
      <div class="col-4">Prepared by: ____________</div>
      <div class="col-4">Approved by: ____________</div>
      <div class="col-4">Tenant signature: ____________</div>
    </div>
  </div>
  <?php endfor; ?>
<?php endforeach; ?>
</body>
</html>
