<?php
require 'config.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->fromArray([
    'ID', 'Name', 'Type', 'Material', 'Purity', 'Weight', 'Price', 'Supplier', 'Date Acquired', 'Status'
], NULL, 'A1');

$stmt = $pdo->query('SELECT * FROM jewels ORDER BY id ASC');
$rowNum = 2;
while ($row = $stmt->fetch()) {
    $sheet->fromArray([
        $row['id'],
        $row['jewel_name'],
        $row['type'],
        $row['material'],
        $row['purity'],
        $row['weight'],
        $row['price'],
        $row['supplier'],
        $row['date_acquired'],
        $row['status'],
    ], NULL, 'A' . $rowNum);
    $rowNum++;
}

$writer = new Xlsx($spreadsheet);
$filename = 'jewels_' . date('Ymd_His') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
$writer->save('php://output');
exit;
?>
