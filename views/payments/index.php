<?php require_auth(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Payments</h4>
  <a class="btn btn-primary" href="<?= base_url('index.php?r=payments/create') ?>">Add</a>
</div>
<table class="table table-sm table-striped">
  <thead><tr><th>#</th><th>Invoice</th><th>Method</th><th>Reference</th><th>Amount</th><th>Paid At</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($items as $p): ?>
    <tr>
      <td><?= e($p['id']) ?></td>
      <td><?= e($p['invoice_id']) ?></td>
      <td><?= e($p['method']) ?></td>
      <td><?= e($p['txn_ref']) ?></td>
      <td><?= e($p['amount']) ?></td>
      <td><?= e($p['paid_at']) ?></td>
      <td class="text-end">
        <a class="btn btn-sm btn-outline-danger" href="<?= base_url('index.php?r=payments/delete&id=' . $p['id']) ?>" onclick="return confirm('Delete?')">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
