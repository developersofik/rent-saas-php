<?php require_auth(); ?>
<h4>বার্ষিক সারসংক্ষেপ</h4>
<form class="row g-2 mb-3" method="get" action="">
  <input type="hidden" name="r" value="reports/yearly">
  <div class="col-md-3">
    <input class="form-control" name="year" value="<?= e($year) ?>">
  </div>
  <div class="col-md-3">
    <button class="btn btn-primary">ফিল্টার</button>
    <button type="button" class="btn btn-secondary no-print" onclick="window.print()">প্রিন্ট</button>
  </div>
</form>
<table class="table table-sm table-bordered">
  <thead><tr><th>মাস</th><th>মোট সংগ্রহ</th></tr></thead>
  <tbody>
    <?php foreach($rows as $r): ?>
      <tr><td><?= e($r['period_month']) ?></td><td><?= e($r['total']) ?></td></tr>
    <?php endforeach; ?>
  </tbody>
</table>
