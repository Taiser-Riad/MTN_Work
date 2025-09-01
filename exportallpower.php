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

// Function to fill data in a sheet
function fillSheet($sheet, $data, $startRow) {
    $row = $startRow;

    foreach ($data as $record) {
        $col = 'A';
        foreach ($record as $value) {
            $sheet->setCellValue($col . $row, $value);
            $col++;
        }
        $row++;
    }

    return $row; // Return the next available row
}

// Prepare Queries
$query1 = "SELECT * FROM ELECTRICAL_COUNTER"; 
$query2 = "SELECT P.SITE_CODE, C.* FROM POWER_BACKUP P JOIN CABINET C ON (P.PID = C.PID)"; 
$query3 = "SELECT * FROM GENERTAOR";
$query4 = "SELECT G.*, T.* FROM GENERTAOR G JOIN TANK T ON (G.GID = T.GID)"; 
$query5 = "SELECT * FROM HYPRID"; 
$query6 = "SELECT * FROM AMPERE";
$query7 = "SELECT * FROM BATTERIES";
$query8 = "SELECT * FROM LINES";

// Create new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Combined Data'); // Set title for the sheet

// Define headers for the combined sheet
$headers = [
    'SITE_CODE', 'SERIAL_NUMBER', 'TYPE', 'OWNER_SHIP', 'COUNTER_CIRCUIT_BREAKER', 
    'STATUS', 'ATS_INSTALLED', // From ELECTRICAL_COUNTER
    'CABINET_TYPE', 'RECTIFIER_TYPE', 'AC_MODULE_QUANTITY', 'SOLAR_MOUDULE_QUANTITY', 
    'DELTA_IP', 'HWAUEI_IP', 'ELTEK_IP', 'CABINET_CAGE', 'NOTE', 'MAIN', // From CABINET
    'BRAND', 'ENGINE_BRAND', 'CAPACITY', 'INITIAL_STATUS', 'QUANTITY', 
    'OWNERSHIP', 'CAGE', 'CURRENT_STATUS', // From GENERATOR
    'TANK_SHAPE', 'TANK_TYPE', 'TANK_ACTUAL_VOLUME', 'TANK_HEIGHT', 
    'TANK_WIDTH', 'TANK_LENGTH', 'TANK_MAXIMUM', 'TANK_INDEX', // From TANK
    'TYPE', 'PANELS_QUANTITY', 'PANELS_CAPACITY', 'STATUS', 'MODULE_QUANTITY', 'BRAND', // From SOLAR
    'CAPACITY', 'DURATION', // From AMPERE
    'G1_BRAND', 'G1_CAPACITY', 'G1_TYPE', 'G1_QUANTITY', 'G1_INSTALLATION_DATE', 
    'G2_BRAND', 'G2_CAPACITY', 'G2_TYPE', 'G2_QUANTITY', 'G2_INSTALLATION_DATE', // From BATTERIES
    'LINE_TYPE' // From LINES
];

// Set Headers
$col = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($col . '1', $header);
    $col++;
}

// Fill Data
$currentRow = 2; // Start filling data from the second row

// Fetch and fill data for each query
$queries = [
    $query1 => ['ELECTRICAL_COUNTER', ['SITE_CODE', 'SERIAL_NUMBER', 'TYPE', 'OWNER_SHIP', 'COUNTER_CIRCUIT_BREAKER', 'STATUS', 'ATS_INSTALLED']],
    $query2 => ['CABINET', ['SITE_CODE', 'CABINET_TYPE', 'RECTIFIER_TYPE', 'AC_MODULE_QUANTITY', 'SOLAR_MOUDULE_QUANTITY', 'DELTA_IP', 'HWAUEI_IP', 'ELTEK_IP', 'CABINET_CAGE', 'NOTE', 'MAIN']],
    $query3 => ['GENERATOR', ['SITE_CODE', 'BRAND', 'ENGINE_BRAND', 'CAPACITY', 'INITIAL_STATUS', 'QUANTITY', 'OWNERSHIP', 'CAGE', 'CURRENT_STATUS']],
    $query4 => ['TANK', ['SITE_CODE', 'TANK_SHAPE', 'TANK_TYPE', 'TANK_ACTUAL_VOLUME', 'TANK_HEIGHT', 'TANK_WIDTH', 'TANK_LENGTH', 'TANK_MAXIMUM', 'TANK_INDEX']],
    $query5 => ['HYPRID', ['SITE_CODE', 'TYPE', 'PANELS_QUANTITY', 'PANELS_CAPACITY', 'STATUS', 'MODULE_QUANTITY', 'BRAND']],
    $query6 => ['AMPERE', ['SITE_CODE', 'CAPACITY', 'DURATION']],
    $query7 => ['BATTERIES', ['SITE_CODE', 'G1_BRAND', 'G1_CAPACITY', 'G1_TYPE', 'G1_QUANTITY', 'G1_INSTALLATION_DATE', 'G2_BRAND', 'G2_CAPACITY', 'G2_TYPE', 'G2_QUANTITY', 'G2_INSTALLATION_DATE']],
    $query8 => ['LINES', ['SITE_CODE', 'TYPE']]
];

foreach ($queries as $query => $info) {
    $stid = oci_parse($conn, $query);
    oci_execute($stid);

    while ($record = oci_fetch_assoc($stid)) {
        // Prepare a new record with the appropriate number of columns
        $combinedRecord = [];
        
        // Fill in the values for each header
        foreach ($headers as $header) {
            if (array_key_exists($header, $record)) {
                $combinedRecord[] = $record[$header];
            } else {
                $combinedRecord[] = ''; // Empty value if the header does not exist in the current record
            }
        }
        $currentRow = fillSheet($sheet, [$combinedRecord], $currentRow); // Fill the combined record
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
