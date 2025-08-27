-- MySQL 8 schema (utf8mb4)
CREATE DATABASE IF NOT EXISTS rent_saas CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE rent_saas;

-- users
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  phone VARCHAR(30) NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('ADMIN','MANAGER','STAFF') DEFAULT 'ADMIN',
  last_login DATETIME NULL,
  status ENUM('active','inactive') DEFAULT 'active',
  created_at DATETIME NULL,
  updated_at DATETIME NULL
) ENGINE=InnoDB;

-- buildings
CREATE TABLE IF NOT EXISTS buildings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  short_code VARCHAR(20) NULL,
  address TEXT NULL,
  manager_id INT NULL,
  currency VARCHAR(10) DEFAULT 'BDT',
  amenities_json JSON NULL,
  utility_config JSON NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
) ENGINE=InnoDB;

-- units
CREATE TABLE IF NOT EXISTS units (
  id INT AUTO_INCREMENT PRIMARY KEY,
  building_id INT NOT NULL,
  unit_no VARCHAR(20) NOT NULL,
  floor VARCHAR(20) NULL,
  type VARCHAR(50) NULL,
  size_sqft INT NULL,
  base_rent DECIMAL(12,2) DEFAULT 0,
  deposit_amount DECIMAL(12,2) DEFAULT 0,
  status ENUM('vacant','occupied','maintenance') DEFAULT 'vacant',
  meter_number_electric VARCHAR(50) NULL,
  meter_number_water VARCHAR(50) NULL,
  meter_number_gas VARCHAR(50) NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  CONSTRAINT fk_units_building FOREIGN KEY (building_id) REFERENCES buildings(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- tenants
CREATE TABLE IF NOT EXISTS tenants (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  phone VARCHAR(30) NULL,
  email VARCHAR(120) NULL,
  nid VARCHAR(40) NULL,
  address TEXT NULL,
  guarantor_json JSON NULL,
  documents_json JSON NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
) ENGINE=InnoDB;

-- leases
CREATE TABLE IF NOT EXISTS leases (
  id INT AUTO_INCREMENT PRIMARY KEY,
  lease_no VARCHAR(50) UNIQUE,
  tenant_id INT NOT NULL,
  unit_id INT NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NULL,
  deposit DECIMAL(12,2) DEFAULT 0,
  billing_cycle ENUM('monthly') DEFAULT 'monthly',
  escalation_json JSON NULL,
  late_fee_rule_json JSON NULL,
  status ENUM('active','ended','paused') DEFAULT 'active',
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  CONSTRAINT fk_leases_tenant FOREIGN KEY (tenant_id) REFERENCES tenants(id),
  CONSTRAINT fk_leases_unit FOREIGN KEY (unit_id) REFERENCES units(id)
) ENGINE=InnoDB;

-- income_heads
CREATE TABLE IF NOT EXISTS income_heads (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description VARCHAR(255) NULL,
  status ENUM('active','inactive') DEFAULT 'active',
  created_at DATETIME NULL,
  updated_at DATETIME NULL
) ENGINE=InnoDB;

-- expense_heads
CREATE TABLE IF NOT EXISTS expense_heads (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description VARCHAR(255) NULL,
  status ENUM('active','inactive') DEFAULT 'active',
  created_at DATETIME NULL,
  updated_at DATETIME NULL
) ENGINE=InnoDB;

-- invoices
CREATE TABLE IF NOT EXISTS invoices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  invoice_no VARCHAR(50) UNIQUE,
  lease_id INT NULL,
  building_id INT NULL,
  period_month CHAR(7) NOT NULL, -- YYYY-MM
  totals_json JSON NULL,
  status ENUM('draft','unpaid','part-paid','paid','cancelled') DEFAULT 'unpaid',
  qr_payload TEXT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
) ENGINE=InnoDB;

-- invoice_lines
CREATE TABLE IF NOT EXISTS invoice_lines (
  id INT AUTO_INCREMENT PRIMARY KEY,
  invoice_id INT NOT NULL,
  income_head_id INT NULL,
  description VARCHAR(255) NULL,
  qty DECIMAL(12,2) DEFAULT 1,
  rate DECIMAL(12,2) DEFAULT 0,
  amount DECIMAL(12,2) DEFAULT 0,
  tax DECIMAL(12,2) DEFAULT 0,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  CONSTRAINT fk_il_invoice FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- expenses
CREATE TABLE IF NOT EXISTS expenses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  building_id INT NULL,
  expense_head_id INT NULL,
  vendor_id INT NULL,
  amount DECIMAL(12,2) NOT NULL,
  date DATE NOT NULL,
  payment_method VARCHAR(50) NULL,
  notes TEXT NULL,
  attachments TEXT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
) ENGINE=InnoDB;

-- payments
CREATE TABLE IF NOT EXISTS payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  invoice_id INT NOT NULL,
  method VARCHAR(50) NULL,
  txn_ref VARCHAR(100) NULL,
  amount DECIMAL(12,2) NOT NULL,
  paid_at DATETIME NOT NULL,
  gateway_payload JSON NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL,
  CONSTRAINT fk_pay_invoice FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- maintenance_tickets
CREATE TABLE IF NOT EXISTS maintenance_tickets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  building_id INT NULL,
  unit_id INT NULL,
  tenant_id INT NULL,
  type VARCHAR(50) NULL,
  priority ENUM('low','medium','high') DEFAULT 'medium',
  sla_json JSON NULL,
  status ENUM('open','in-progress','resolved','closed') DEFAULT 'open',
  assigned_to INT NULL,
  created_at DATETIME NULL,
  updated_at DATETIME NULL
) ENGINE=InnoDB;

-- audit_logs
CREATE TABLE IF NOT EXISTS audit_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  action VARCHAR(50) NULL,
  entity VARCHAR(50) NULL,
  entity_id INT NULL,
  diff_json JSON NULL,
  created_at DATETIME NULL
) ENGINE=InnoDB;

-- Seed admin
INSERT INTO users (name,email,password_hash,role,status,created_at) VALUES
('Admin','admin@example.com', '$2y$10$r3vUfx0M76wKqwp5MdX9vOkz6c5m1.0YTxH28QG1S8MyC0HdC7UGK', 'ADMIN','active', NOW());
-- password: password
