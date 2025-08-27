<?php
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';

class ReportsController {
  public function monthly() { require_auth(); view('reports/monthly'); }
  public function yearly() { require_auth(); view('reports/yearly'); }
}
