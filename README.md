# Rent SaaS (Raw PHP Starter)

A starter project for a rental/property management system using **raw PHP (no framework)**, 
**MySQLi/PDO**, **Bootstrap 5**, and **Chart.js**. It implements:

- Auth (login/logout, session)
- Dashboard UI (cards + sample charts)
- CRUD: Buildings, Tenants (extensible pattern for other entities)
- Invoices (very basic create/list) with HTML print view
- Reports (stubs): Monthly Collection Sheet, Yearly Summary
- SQL schema for the core tables you specified (see `migrations/schema.sql`)

> This is a **starter** to get you moving fast and to plug into Codex tasks.
> Extend using the same patterns for Units, Leases, Payments, Expenses, etc.

## Requirements
- PHP 8.1+
- MySQL 8+
- Apache/Nginx (for pretty URLs use `.htaccess` provided for Apache)
- Composer (optional if you later add libraries like TCPDF/FPDF)

## Setup
1. Create a DB and import `migrations/schema.sql`.
2. Copy `config/config.sample.php` to `config/config.php` and set DB creds.
3. Serve `public/` as the web root (or run `php -S localhost:8000 -t public` for dev).
4. Login with: **admin@example.com** / **password** (seeded).

## Routing
Single entry `public/index.php`. Route query param `r` maps to `<controller>/<action>`,
default is `dashboard/index`. Example:
- `/index.php?r=buildings/index`
- `/index.php?r=tenants/create`

## How to add a new module
- Create a Model in `models/` (see `Building.php`).
- Create a Controller in `controllers/` with actions.
- Add Views in `views/<module>/` (index/create/edit/show).
- Link it from `views/partials/sidebar.php`.

## PDF
For now, invoices have **HTML print**. To add PDF later, install **TCPDF** or **FPDF** and call it from `controllers/InvoiceController.php` (`printPdf` TODO marked).

## License
MIT - do whatever, just keep the notice.
# rent-saas-php
