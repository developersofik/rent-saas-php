<?php require_auth(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Invoices</h4>
  <a class="btn btn-primary" href="<?= base_url('index.php?r=invoices/create') ?>">Create</a>
</div>
<table class="table table-sm table-striped">
  <thead><tr><th>#</th><th>Invoice No</th><th>Lease</th><th>Month</th><th>Status</th><th>Total</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($items as $i): ?>
    <tr>
      <td><?= e($i['id']) ?></td>
      <td><?= e($i['invoice_no']) ?></td>
      <td><?= e($i['lease_id']) ?></td>
      <td><?= e($i['period_month']) ?></td>
      <td><?= e($i['status']) ?></td>
      <td>৳ <?= e(number_format((float)($i['totals_json']['grand_total'] ?? 0))) ?></td>
      <td class="text-end">
        <a class="btn btn-sm btn-outline-secondary" href="<?= base_url('index.php?r=invoices/show&id=' . $i['id']) ?>">View</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
