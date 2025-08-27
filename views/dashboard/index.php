<?php require_auth(); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="mb-0">Dashboard</h4>
</div>
<div class="row g-3">
  <div class="col-12 col-md-3">
    <div class="card card-kpi p-3">
      <div class="small text-muted">Total tenants</div>
      <div class="h4 mb-0"><?= e($kpis['tenants'] ?? 0) ?></div>
    </div>
  </div>
  <div class="col-12 col-md-3">
    <div class="card card-kpi p-3">
      <div class="small text-muted">Total units</div>
      <div class="h4 mb-0"><?= e($kpis['units'] ?? 0) ?></div>
    </div>
  </div>
  <div class="col-12 col-md-3">
    <div class="card card-kpi p-3">
      <div class="small text-muted">Outstanding</div>
      <div class="h4 mb-0">৳ <?= e(number_format($kpis['outstanding'] ?? 0, 0)) ?></div>
    </div>
  </div>
  <div class="col-12 col-md-3">
    <div class="card card-kpi p-3">
      <div class="small text-muted">Collection (MTD)</div>
      <div class="h4 mb-0">৳ <?= e(number_format($kpis['collection_mtd'] ?? 0, 0)) ?></div>
    </div>
  </div>
</div>

<div class="card mt-4 p-3">
  <h6>Product sales</h6>
  <canvas id="salesChart" height="100"></canvas>
</div>
