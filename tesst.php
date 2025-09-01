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

// Create new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Combined Data'); // Set title for the sheet

// Set Headers
$sheet->setCellValue('A1', 'SITE_CODE');
$sheet->setCellValue('B1', 'SERIAL_NUMBER');
$sheet->setCellValue('C1', 'TYPE');
$sheet->setCellValue('D1', 'OWNER_SHIP');
$sheet->setCellValue('E1', 'COUNTER_CIRCUIT_BREAKER');
$sheet->setCellValue('F1', 'STATUS');
$sheet->setCellValue('G1', 'ATS_INSTALLED');
$sheet->setCellValue('H1', 'CABINET_TYPE');
$sheet->setCellValue('I1', 'RECTIFIER_TYPE');
$sheet->setCellValue('J1', 'AC_MODULE_QUANTITY');
$sheet->setCellValue('K1', 'SOLAR_MOUDULE_QUANTITY');
$sheet->setCellValue('L1', 'DELTA_IP');
$sheet->setCellValue('M1', 'HWAUEI_IP');
$sheet->setCellValue('N1', 'ELTEK_IP');
$sheet->setCellValue('O1', 'CABINET_CAGE');
$sheet->setCellValue('P1', 'NOTE');
$sheet->setCellValue('Q1', 'MAIN');
$sheet->setCellValue('R1', 'BRAND');
$sheet->setCellValue('S1', 'ENGINE_BRAND');
$sheet->setCellValue('T1', 'CAPACITY');
$sheet->setCellValue('U1', 'INITIAL_STATUS');
$sheet->setCellValue('V1', 'QUANTITY');
$sheet->setCellValue('W1', 'OWNERSHIP');
$sheet->setCellValue('X1', 'CAGE');
$sheet->setCellValue('Y1', 'CURRENT_STATUS');
$sheet->setCellValue('Z1', 'TANK_SHAPE');
$sheet->setCellValue('AA1', 'TANK_TYPE');
$sheet->setCellValue('AB1', 'TANK_ACTUAL_VOLUME');
$sheet->setCellValue('AC1', 'TANK_HEIGHT');
$sheet->setCellValue('AD1', 'TANK_WIDTH');
$sheet->setCellValue('AE1', 'TANK_LENGTH');
$sheet->setCellValue('AF1', 'TANK_MAXIMUM');
$sheet->setCellValue('AG1', 'TANK_INDEX');
$sheet->setCellValue('AH1', 'TYPE');
$sheet->setCellValue('AI1', 'PANELS_QUANTITY');
$sheet->setCellValue('AJ1', 'PANELS_CAPACITY');
$sheet->setCellValue('AK1', 'STATUS');
$sheet->setCellValue('AL1', 'MODULE_QUANTITY');
$sheet->setCellValue('AM1', 'BRAND');
$sheet->setCellValue('AN1', 'CAPACITY');
$sheet->setCellValue('AO1', 'DURATION');
$sheet->setCellValue('AP1', 'G1_BRAND');
$sheet->setCellValue('AQ1', 'G1_CAPACITY');
$sheet->setCellValue('AR1', 'G1_TYPE');
$sheet->setCellValue('AS1', 'G1_QUANTITY');
$sheet->setCellValue('AT1', 'G1_INSTALLATION_DATE');
$sheet->setCellValue('AU1', 'G2_BRAND');
$sheet->setCellValue('AV1', 'G2_CAPACITY');
$sheet->setCellValue('AW1', 'G2_TYPE');
$sheet->setCellValue('AX1', 'G2_QUANTITY');
$sheet->setCellValue('AY1', 'G2_INSTALLATION_DATE');
$sheet->setCellValue('AZ1', 'LINE_TYPE');

// Start filling data from the second row
$currentRow = 2;

// Prepare Queries
$queries = [
    "SELECT * FROM ELECTRICAL_COUNTER" => ['SITE_CODE', 'SERIAL_NUMBER', 'TYPE', 'OWNER_SHIP', 'COUNTER_CIRCUIT_BREAKER', 'STATUS', 'ATS_INSTALLED'],
    "SELECT P.SITE_CODE, C.* FROM POWER_BACKUP P JOIN CABINET C ON (P.PID = C.PID)" => ['SITE_CODE', 'CABINET_TYPE', 'RECTIFIER_TYPE', 'AC_MODULE_QUANTITY', 'SOLAR_MOUDULE_QUANTITY', 'DELTA_IP', 'HWAUEI_IP', 'ELTEK_IP', 'CABINET_CAGE', 'NOTE', 'MAIN'],
    "SELECT * FROM GENERTAOR" => ['SITE_CODE', 'BRAND', 'ENGINE_BRAND', 'CAPACITY', 'INITIAL_STATUS', 'QUANTITY', 'OWNERSHIP', 'CAGE', 'CURRENT_STATUS'],
    "SELECT G.*, T.* FROM GENERTAOR G JOIN TANK T ON (G.GID = T.GID)" => ['SITE_CODE', 'TANK_SHAPE', 'TANK_TYPE', 'TANK_ACTUAL_VOLUME', 'TANK_HEIGHT', 'TANK_WIDTH', 'TANK_LENGTH', 'TANK_MAXIMUM', 'TANK_INDEX'],
    "SELECT * FROM HYPRID" => ['SITE_CODE', 'TYPE', 'PANELS_QUANTITY', 'PANELS_CAPACITY', 'STATUS', 'MODULE_QUANTITY', 'BRAND'],
    "SELECT * FROM AMPERE" => ['SITE_CODE', 'CAPACITY', 'DURATION'],
    "SELECT * FROM BATTERIES" => ['SITE_CODE', 'G1_BRAND', 'G1_CAPACITY', 'G1_TYPE', 'G1_QUANTITY', 'G1_INSTALLATION_DATE', 'G2_BRAND', 'G2_CAPACITY', 'G2_TYPE', 'G2_QUANTITY', 'G2_INSTALLATION_DATE'],
    "SELECT * FROM LINES" => ['SITE_CODE', 'TYPE']
];

// Execute queries and fill data
foreach ($queries as $query => $headers) {
    $stid = oci_parse($conn, $query);
    oci_execute($stid);

    while ($record = oci_fetch_assoc($stid)) {
        // Fill each cell directly without using an array
        $col = 'A'; // Reset column index for each row
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $currentRow, isset($record[$header]) ? $record[$header] : '');
            $col++; // Move to the next column
        }
        $currentRow++; // Move to the next row
    }

    // Free statement for the current query
    oci_free_statement($stid);
}

// Close Oracle connection
oci_close($conn);

// Save Excel file
$filename = 'POWER_BACKUP_COMBINED.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($filename);

// Download file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
readfile($filename);

// Delete the file from the server after download
unlink($filename);
?>
