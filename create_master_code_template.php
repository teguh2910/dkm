<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet;
$sheet = $spreadsheet->getActiveSheet();

// Set header
$sheet->setCellValue('A1', 'Code');
$sheet->setCellValue('B1', 'Name');
$sheet->setCellValue('C1', 'Description');
$sheet->setCellValue('D1', 'Year');

// Add example data
$sheet->setCellValue('A2', 'MC-2025-001');
$sheet->setCellValue('B2', 'Operasional 2025');
$sheet->setCellValue('C2', 'Budget untuk operasional tahun 2025');
$sheet->setCellValue('D2', '2025');

$sheet->setCellValue('A3', 'MC-2025-002');
$sheet->setCellValue('B3', 'Proyek 2025');
$sheet->setCellValue('C3', 'Budget untuk proyek tahun 2025');
$sheet->setCellValue('D3', '2025');

// Style header
$sheet->getStyle('A1:D1')->getFont()->setBold(true);

// Set column widths
$sheet->getColumnDimension('A')->setWidth(20);
$sheet->getColumnDimension('B')->setWidth(25);
$sheet->getColumnDimension('C')->setWidth(40);
$sheet->getColumnDimension('D')->setWidth(10);

// Save file
$writer = new Xlsx($spreadsheet);
$writer->save('public/master_code_template.xlsx');

echo "Template master code berhasil dibuat!\n";
