# Jewel Inventory Management System

This repository contains a sample PHP application for managing jewel inventory, custom orders, and sales records. It uses MySQL for data storage and Bootstrap 5.3 for styling.

## Setup
1. Install PHP 8.3+ and MySQL.
2. Create a database named `jewel_db` and import the schema from `schema.sql` (provided below).
3. Update `config.php` with your database credentials.
4. Install dependencies via Composer for exporting Excel files:
   ```bash
   composer require phpoffice/phpspreadsheet
   ```
5. Serve the project with your preferred web server.

## Database Schema
See `schema.sql` for table definitions.
