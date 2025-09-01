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
// Function to fill data in a sheet
function fillSheet($sheet, $stid, $headers) {
    // Set Headers
    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col . '1', $header);
        $col++;
    }

    // Apply style to headers
    $styleArray = [
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
            ],
        ],
    ];
    $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray($styleArray);

    // Fill Data
    $row = 2;
    while ($record = oci_fetch_assoc($stid)) {
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $record[$header]);
            $col++;
        }

        // Apply borders to the current row
        $sheet->getStyle('A' . $row . ':' . $sheet->getHighestColumn() . $row)->applyFromArray($styleArray['borders']);

        $row++;
    }
}

// Prepare Queries
$query1 = "SELECT * FROM ELECTRICAL_COUNTER"; // First query

$query2 = "SELECT P.SITE_CODE ,C.* FROM POWER_BACKUP P JOIN CABINET C ON (P.PID = C.PID) WHERE P.PID = C.PID"; 

$query3 = "SELECT * FROM GENERTAOR";

$query4 = "SELECT G.* ,T.* FROM GENERTAOR G JOIN TANK T ON (G.GID = T.GID) WHERE G.GID = T.GID"; 

$query5 = "SELECT * FROM HYPRID"; 

$query6 = "SELECT * FROM AMPERE";

$query7 = "SELECT * FROM BATTERIES";

$query8 = "SELECT * FROM LINES";



// Create new Spreadsheet
$spreadsheet = new Spreadsheet();

// First Sheet: ELECTRICAL_COUNTER
$sheet1 = $spreadsheet->getActiveSheet();
$sheet1->setTitle('ELECTRICAL_COUNTER'); // Set title for the first sheet
$headers1 = ['SITE_CODE', 'SERIAL_NUMBER', 'TYPE', 'OWNER_SHIP', 'COUNTER_CIRCUIT_BREAKER', 'STATUS', 'ATS_INSTALLED'];

$stid1 = oci_parse($conn, $query1);
oci_execute($stid1);
fillSheet($sheet1, $stid1, $headers1); // Fill the first sheet with data

// Free statement for the first query
oci_free_statement($stid1);

// Second Sheet: CABINET
$sheet2 = $spreadsheet->createSheet(); // Create a new sheet
$sheet2->setTitle('CABINET'); // Set title for the second sheet
$headers2 = ['SITE_CODE','CABINET_TYPE', 'RECTIFIER_TYPE', 'AC_MODULE_QUANTITY', 'SOLAR_MOUDULE_QUANTITY', 'DELTA_IP', 'HWAUEI_IP', 'ELTEK_IP', 'CABINET_CAGE', 'NOTE', 'MAIN'];

$stid2 = oci_parse($conn, $query2);
oci_execute($stid2);
fillSheet($sheet2, $stid2, $headers2); // Fill the second sheet with data

// Free statement for the second query
oci_free_statement($stid2);


//$spreadsheet = new Spreadsheet();
$sheet3 = $spreadsheet->createSheet(); 

$sheet3->setTitle('GENERATOR'); // Set title for the first sheet


$headers3 = ['SITE_CODE', 'BRAND','ENGINE_BRAND','CAPACITY','INITIAL_STATUS','QUANTITY','OWNERSHIP','CAGE','CURRENT_STATUS'];


$stid3 = oci_parse($conn, $query3);
oci_execute($stid3);
fillSheet($sheet3, $stid3, $headers3); // Fill the first sheet with data

// Free statement for the first query
oci_free_statement($stid3);



$sheet4 = $spreadsheet->createSheet(); 

$sheet4->setTitle('TANKS'); // Set title for the first sheet


$headers4 = ['SITE_CODE', 'TANK_SHAPE','TANK_TYPE','TANK_ACTUAL_VOLUME','TANK_HEIGHT','TANK_WIDTH','TANK_LENGTH','TANK_MAXIMUM','TANK_INDEX'];


$stid4 = oci_parse($conn, $query4);
oci_execute($stid4);
fillSheet($sheet4, $stid4, $headers4); // Fill the first sheet with data

// Free statement for the first query
oci_free_statement($stid4);




$sheet5 = $spreadsheet->createSheet(); 

$sheet5->setTitle('SOLAR'); // Set title for the first sheet


$headers5 = ['SITE_CODE', 'TYPE','PANELS_QUANTITY','PANELS_CAPACITY','STATUS','MODULE_QUANTITY','BRAND'];


$stid5 = oci_parse($conn, $query5);
oci_execute($stid5);
fillSheet($sheet5, $stid5, $headers5); // Fill the first sheet with data

// Free statement for the first query
oci_free_statement($stid5);




$sheet6 = $spreadsheet->createSheet(); 

$sheet6->setTitle('AMPERE'); // Set title for the first sheet


$headers6 = ['SITE_CODE', 'CAPACITY','DURATION'];


$stid6 = oci_parse($conn, $query6);
oci_execute($stid6);
fillSheet($sheet6, $stid6, $headers6); // Fill the first sheet with data

// Free statement for the first query
oci_free_statement($stid6);





$sheet7 = $spreadsheet->createSheet(); 

$sheet7->setTitle('BATTERIES'); // Set title for the first sheet


$headers7 = ['SITE_CODE', 'G1_BRAND','G1_CAPACITY','G1_TYPE','G1_QUANTITY','G1_INSTALLATION_DATE' , 'G2_BRAND','G2_CAPACITY','G2_TYPE','G2_QUANTITY','G2_INSTALLATION_DATE'];


$stid7 = oci_parse($conn, $query7);
oci_execute($stid7);
fillSheet($sheet7, $stid7, $headers7); // Fill the first sheet with data

// Free statement for the first query
oci_free_statement($stid7);



$sheet8 = $spreadsheet->createSheet(); 

$sheet8->setTitle('LINES'); // Set title for the first sheet


$headers8 = ['SITE_CODE', 'TYPE'];


$stid8 = oci_parse($conn, $query8);
oci_execute($stid8);
fillSheet($sheet8, $stid8, $headers8); // Fill the first sheet with data

// Free statement for the first query
oci_free_statement($stid8);



// Close Oracle connection
oci_close($conn);

// Save Excel file
$filename = 'POWER BACKUP.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($filename);

// Download file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
readfile($filename);

// Delete the file from the server after download
unlink($filename);
?>
