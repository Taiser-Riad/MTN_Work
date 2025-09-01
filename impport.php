<?php
// Include PhpSpreadsheet (Ensure you downloaded it manually and placed it correctly)
require 'autoload.php';
require 'PhpSpreadsheet/src/PhpSpreadsheet/IOFactory.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$uploadDir = 'uploads/'; // Ensure this directory exists and is writable
$uploadedFile = $uploadDir . basename($_FILES["excel_file"]["name"]);

if (move_uploaded_file($_FILES["excel_file"]["tmp_name"], $uploadedFile)) {
    echo "File uploaded successfully.<br>";

    // Load the Excel file
    try {
        $spreadsheet = IOFactory::load($uploadedFile);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // Database connection
        $username = "C##Hadeel";
        $password = "MTN";
        $connection_string = "//localhost/sitem"; // Change XE if your SID is different
        
        // Connect to Oracle
        $conn = oci_connect($username, $password, $connection_string, 'AL32UTF8');
        
        if (!$conn) {
            $e = oci_error();
            die("Connection failed: " . $e['message']);
        }

        // Skip header row and process data
        foreach ($rows as $index => $row) {
            if ($index == 0) continue; // Skip header
            
            $siteCodeFromExcel = $row[0]; // Assuming "cell code" is in the 4th column in the Excel file
            
            // Check if the cell code exists in the database
            $checkSql = "SELECT COUNT(*) AS count FROM TWO_G_SITES WHERE SITE_ID = :sitecode";
            $checkStmt = oci_parse($conn, $checkSql);
            oci_bind_by_name($checkStmt, ":sitecode", $siteCodeFromExcel);
            oci_execute($checkStmt);
            
            $rowExists = oci_fetch_assoc($checkStmt);
            oci_free_statement($checkStmt);

            if ($rowExists['COUNT'] > 0) {
                // Prepare insert statement
                $sql = "UPDATE  TWO_G_SITES
                SET SITE_CODE = :sname WHERE SITE_ID = : sitecode";


                $stmt = oci_parse($conn, $sql);
              
                oci_bind_by_name($stmt, ':sname', $row[1]);
                oci_bind_by_name($stmt, ':sitecode', $row[0]);
                

                if (!oci_execute($stmt)) {
                    $e = oci_error($stmt);
                    echo "Error inserting row: " . $e['message'] . "<br>";
                }
                oci_free_statement($stmt);
            }
        }

        oci_close($conn);
        echo "Data imported successfully.";

    } catch (Exception $e) {
        die("Error loading Excel file: " . $e->getMessage());
    }
} else {
    echo "Error uploading file.";
}
?>
