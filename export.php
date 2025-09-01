<?php
// Include the manual autoloader
require 'autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Database connection (Update with your Oracle details)
$username = "C##Hadeel";
$password = "MTN";
$connection_string = "//localhost/sitem"; // Change XE if your SID is different

// Connect to Oracle
$conn = oci_connect($username, $password, $connection_string, 'AL32UTF8');

if (!$conn) {
    $e = oci_error();
    die("Connection failed: " . $e['message']);
}
else {
    //echo"connect Successfully";
}

// Prepare Query
$query = "SELECT * FROM NEW_SITES";
$stid = oci_parse($conn, $query);

// Bind Parameter (Example: ID > 0)
// $min_id = 0;
// oci_bind_by_name($stid, ":min_id", $min_id);

// Execute Query
oci_execute($stid);

// Create new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set Headers with Background Color
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'SITE_CODE');













$styleArray = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
];

$sheet->getStyle('A1:B1')->applyFromArray($styleArray);

// Fill Data
$row = 2;
while ($record = oci_fetch_assoc($stid)) {
    $sheet->setCellValue('A' . $row, $record['ID']);
    $sheet->setCellValue('B' . $row, $record['SITE_CODE']);
    $row++;
}

// Close Oracle connection
oci_free_statement($stid);
oci_close($conn);

// Save Excel file
$filename = 'export.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($filename);

// Save Excel file
$filename = 'all Sites.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($filename);

// Download file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
readfile($filename);

// Delete the file from the server after download
unlink($filename);
?>
