<?php
require_once __DIR__ . '/../config/database.php';
class BaseModel {
  protected $table;
  protected $pk = 'id';
  public function all($orderBy = 'id DESC') {
    $stmt = db()->query("SELECT * FROM {$this->table} ORDER BY {$orderBy}");
    return $stmt->fetchAll();
  }
  public function find($id) {
    $stmt = db()->prepare("SELECT * FROM {$this->table} WHERE {$this->pk}=?");
    $stmt->execute([$id]);
    return $stmt->fetch();
  }
  public function insert($data) {
    $keys = array_keys($data);
    $cols = implode(',', $keys);
    $place = implode(',', array_fill(0, count($keys), '?'));
    $stmt = db()->prepare("INSERT INTO {$this->table} ({$cols}) VALUES ({$place})");
    $stmt->execute(array_values($data));
    return db()->lastInsertId();
  }
  public function update($id, $data) {
    $sets = implode(',', array_map(fn($k) => "$k=?", array_keys($data)));
    $stmt = db()->prepare("UPDATE {$this->table} SET {$sets} WHERE {$this->pk}=?");
    $vals = array_values($data);
    $vals[] = $id;
    return $stmt->execute($vals);
  }
  public function delete($id) {
    $stmt = db()->prepare("DELETE FROM {$this->table} WHERE {$this->pk}=?");
    return $stmt->execute([$id]);
  }
}
