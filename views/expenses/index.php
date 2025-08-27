<?php require_auth(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Expenses</h4>
  <a class="btn btn-primary" href="<?= base_url('index.php?r=expenses/create') ?>">Add</a>
</div>
<table class="table table-sm table-striped">
  <thead><tr><th>#</th><th>Building</th><th>Head</th><th>Amount</th><th>Date</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($items as $e): ?>
    <tr>
      <td><?= e($e['id']) ?></td>
      <td><?= e($e['building_id']) ?></td>
      <td><?= e($e['expense_head_id']) ?></td>
      <td><?= e($e['amount']) ?></td>
      <td><?= e($e['date']) ?></td>
      <td class="text-end">
        <a class="btn btn-sm btn-outline-secondary" href="<?= base_url('index.php?r=expenses/edit&id=' . $e['id']) ?>">Edit</a>
        <a class="btn btn-sm btn-outline-danger" href="<?= base_url('index.php?r=expenses/delete&id=' . $e['id']) ?>" onclick="return confirm('Delete?')">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
