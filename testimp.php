<?php 
include "config.php";
?>
<?php
require 'autoload.php';
require 'PhpSpreadsheet/src/PhpSpreadsheet/IOFactory.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$uploadDir = 'uploads/';
$uploadedFile = $uploadDir . basename($_FILES["excel_file"]["name"]);

if (move_uploaded_file($_FILES["excel_file"]["tmp_name"], $uploadedFile)) {
    echo "File uploaded successfully.<br>";



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





    try {
        // Load the Excel file
        $spreadsheet = IOFactory::load($uploadedFile);


  


        // Iterate through all sheets in the Excel file
        foreach ($spreadsheet->getSheetNames() as $sheetIndex => $sheetName) {
            $worksheet = $spreadsheet->getSheet($sheetIndex);
            $rows = $worksheet->toArray();

            // Determine which table to insert into based on the sheet name
            set_time_limit(500);





            if ($sheetName == "2G Cells") {

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









               
                foreach ($rows as $index => $row) {
                    if ($index == 0) continue; // Skip header row
                    $cellCodeFromExcel = $row[1];

                    set_time_limit(300);
                    
                    // if (empty($cellCodeFromExcel)) {
                    //     //echo "Skipping empty SITE_CODE<br>";
                    //     continue; // Skip to the next iteration
                    // }

                    $site = substr($cellCodeFromExcel,0,6);
                    echo $site;
                    $checkSql2G = "SELECT CELL_ID FROM TWO_G_SITES WHERE SITE_CODE = :sitecode";
                    $checkStmt2G = oci_parse($conn, $checkSql2G);
                    oci_bind_by_name($checkStmt2G, ":sitecode", $site);
                    oci_execute($checkStmt2G);
                    
                    $rowExists2G = oci_fetch_assoc($checkStmt2G);
                   
                    $cellId = $rowExists2G['CELL_ID'];
                 
                    echo $cellId;
                    oci_free_statement($checkStmt2G);
                    if ($rowExists2G) {

                        $checkSql2 = "SELECT * FROM TWO_G_CELLS WHERE CELL_CODE = :cellcode";
                        $checkStmt2 = oci_parse($conn, $checkSql2);
                        oci_bind_by_name($checkStmt2, ":cellcode", $cellCodeFromExcel);
                        oci_execute($checkStmt2);
                        
                        $rowExists22 = oci_fetch_assoc($checkStmt2);
                        oci_free_statement($checkStmt2);
                     if($rowExists22){
                        //echo "Updating existing site: " . $siteCodeFromExcel . " 2g cells<br>";
                     


                        $query1 = "UPDATE TWO_G_CELLS 
                        SET CELL_NAME = :cname,
                            AZIMUTH = :azimuth,
                            HIEGHT = :height,
                            BSIC = :BSIC,
                            M_TILT = :mtilt,
                            E_TILT = :etilt,
                            TOTAL_TILT =:ttilt,
                            BSC = :BSC,
                            CELL_ON_AIR_DATE = :celldate,
                            NOTE = :cnote,
                            SERVING_AREA_IN_ENGLISH = :aarea,
                            SERVING_AREA = :earea,
                            CGI =:cgi,
                            CGI_HEX =:hcgi
                        WHERE CELL_CODE = :cellcode";
    
                        $updateresult = oci_parse($conn, $query1);
                        
                        oci_bind_by_name($updateresult, ':cname', $row[2]);
                        oci_bind_by_name($updateresult, ':azimuth',$row[8]);
                        oci_bind_by_name($updateresult, ':height', $row[9]);
                        oci_bind_by_name($updateresult, ':BSIC', $row[15]);
                        oci_bind_by_name($updateresult, ':etilt', $row[11]);
                        oci_bind_by_name($updateresult, ':mtilt', $row[10]);
                        oci_bind_by_name($updateresult, ':ttilt', $row[12]);
                        oci_bind_by_name($updateresult, ':BSC', $row[7]);
                        //oci_bind_by_name($updateresult, ':bcch', $row[11]);
                        oci_bind_by_name($updateresult, ':celldate', $row[3]);
                        oci_bind_by_name($updateresult, ':cnote', $row[6]);
                        oci_bind_by_name($updateresult, ':aarea', $row[5]);
                        oci_bind_by_name($updateresult, ':earea', $row[4]);
                        oci_bind_by_name($updateresult, ':cgi', $row[13]);
                        oci_bind_by_name($updateresult, ':hcgi', $row[14]);
                        oci_bind_by_name($updateresult, ':cellcode', $row[1]);
                        
                        if (oci_execute($updateresult)) {
                        echo "Data Updated Successfully";
                        } else {
                        $e = oci_error($updateresult);
                        echo "Error Updating Data: " . htmlentities($e['message']);
                        }
                     }
                     else{
                        //echo "Inserting new site: " . $siteCodeFromExcel . "2g cells<br>";
                        $query1 = "INSERT INTO TWO_G_CELLS 
                                    (CID_KEY,CELL_CODE, CELL_NAME, AZIMUTH, HIEGHT, BSIC, M_TILT, E_TILT, TOTAL_TILT, BSC, CELL_ON_AIR_DATE, NOTE, SERVING_AREA_IN_ENGLISH, SERVING_AREA, CGI, CGI_HEX) 
                                    VALUES 
                                    (:cid,:cellcode, :cname, :azimuth, :height, :BSIC, :mtilt, :etilt, :ttilt, :BSC, :celldate, :cnote, :aarea, :earea, :cgi, :hcgi)";

                            $inserresult = oci_parse($conn, $query1);

                            oci_bind_by_name($inserresult, ':cellcode', $row[1]);
                            oci_bind_by_name($inserresult, ':cname', $row[2]);
                            oci_bind_by_name($inserresult, ':azimuth', $row[8]);
                            oci_bind_by_name($inserresult, ':height', $row[9]);
                            oci_bind_by_name($inserresult, ':BSIC', $row[15]);
                            oci_bind_by_name($inserresult, ':mtilt', $row[10]);
                            oci_bind_by_name($inserresult, ':etilt', $row[11]);
                            oci_bind_by_name($inserresult, ':ttilt', $row[12]);
                            oci_bind_by_name($inserresult, ':BSC', $row[7]);
                            oci_bind_by_name($inserresult, ':celldate', $row[3]);
                            oci_bind_by_name($inserresult, ':cnote', $row[6]);
                            oci_bind_by_name($inserresult, ':aarea', $row[5]);
                            oci_bind_by_name($inserresult, ':earea', $row[4]);
                            oci_bind_by_name($inserresult, ':cgi', $row[13]);
                            oci_bind_by_name($inserresult, ':hcgi', $row[14]);
                            oci_bind_by_name($inserresult, ':cid', $cellId);

                            if (oci_execute($inserresult)) {
                                echo "Data Inserted Successfully";
                            } else {
                                $e = oci_error($inserresult);
                                echo "Error Inserting Data: " . htmlentities($e['message']);
                            }

                     }

                    }




                }
           


            

       }

        oci_close($conn);
        echo "Data imported successfully.";
    }
    } 
    catch (Exception $e) {
        die("Error loading Excel file: " . $e->getMessage());
    }
}
else {
    echo "Error uploading file.";
}


?>




elseif ($sheetName == "2G Cells") {

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










foreach ($rows as $index => $row) {
    if ($index == 0) continue; // Skip header row
    $cellCodeFromExcel = $row[1];

    set_time_limit(300);
    
    if (empty($cellCodeFromExcel)) {
        //echo "Skipping empty SITE_CODE<br>";
        continue; // Skip to the next iteration
    }

    $site = substr($cellCodeFromExcel,0,6);
    $checkSql2G = "SELECT CELL_ID FROM TWO_G_SITES WHERE SITE_CODE = :sitecode";
    $checkStmt2G = oci_parse($conn, $checkSql2G);
    oci_bind_by_name($checkStmt2G, ":sitecode", $site);
    oci_execute($checkStmt2G);
    
    $rowExists2G = oci_fetch_assoc($checkStmt2G);
    oci_free_statement($checkStmt2G);
    $cellId = $rowExists2G['CELL_ID'];

    if ($rowExists2G) {

        $checkSql2 = "SELECT * FROM TWO_G_CELLS WHERE CELL_CODE = :cellcode";
        $checkStmt2 = oci_parse($conn, $checkSql2);
        oci_bind_by_name($checkStmt2, ":cellcode", $cellCodeFromExcel);
        oci_execute($checkStmt2);
        
        $rowExists22 = oci_fetch_assoc($checkStmt2);
        oci_free_statement($checkStmt2);
     if($rowExists22){
        //echo "Updating existing site: " . $siteCodeFromExcel . " 2g cells<br>";
     


        $query1 = "UPDATE TWO_G_CELLS 
        SET CELL_NAME = :cname,
            AZIMUTH = :azimuth,
            HIEGHT = :height,
            BSIC = :BSIC,
            M_TILT = :mtilt,
            E_TILT = :etilt,
            TOTAL_TILT =:ttilt,
            BSC = :BSC,
            CELL_ON_AIR_DATE = :celldate,
            NOTE = :cnote,
            SERVING_AREA_IN_ENGLISH = :aarea,
            SERVING_AREA = :earea,
            CGI =:cgi,
            CGI_HEX =:hcgi
        WHERE CELL_CODE = :cellcode";

        $updateresult = oci_parse($conn, $query1);
        
        oci_bind_by_name($updateresult, ':cname', $row[2]);
        oci_bind_by_name($updateresult, ':azimuth',$row[7]);
        oci_bind_by_name($updateresult, ':height', $row[8]);
        oci_bind_by_name($updateresult, ':BSIC', $row[14]);
        oci_bind_by_name($updateresult, ':etilt', $row[10]);
        oci_bind_by_name($updateresult, ':mtilt', $row[9]);
        oci_bind_by_name($updateresult, ':ttilt', $row[11]);
        oci_bind_by_name($updateresult, ':BSC', $row[15]);
        //oci_bind_by_name($updateresult, ':bcch', $row[11]);
        oci_bind_by_name($updateresult, ':celldate', $row[3]);
        oci_bind_by_name($updateresult, ':cnote', $row[6]);
        oci_bind_by_name($updateresult, ':aarea', $row[5]);
        oci_bind_by_name($updateresult, ':earea', $row[4]);
        oci_bind_by_name($updateresult, ':cgi', $row[12]);
        oci_bind_by_name($updateresult, ':hcgi', $row[13]);
        oci_bind_by_name($updateresult, ':cellcode', $row[1]);
        
        if (oci_execute($updateresult)) {
        //echo "Data Updated Successfully";
        } else {
        $e = oci_error($updateresult);
        echo "Error Updating Data: " . htmlentities($e['message']);
        }
     }
     else{
        //echo "Inserting new site: " . $siteCodeFromExcel . "2g cells<br>";
        $query1 = "INSERT INTO TWO_G_CELLS 
                    (CID_KEY,CELL_CODE, CELL_NAME, AZIMUTH, HIEGHT, BSIC, M_TILT, E_TILT, TOTAL_TILT, BSC, CELL_ON_AIR_DATE, NOTE, SERVING_AREA_IN_ENGLISH, SERVING_AREA, CGI, CGI_HEX) 
                    VALUES 
                    (:cid,:cellcode, :cname, :azimuth, :height, :BSIC, :mtilt, :etilt, :ttilt, :BSC, :celldate, :cnote, :aarea, :earea, :cgi, :hcgi)";

            $inserresult = oci_parse($conn, $query1);

            oci_bind_by_name($inserresult, ':cellcode', $row[1]);
            oci_bind_by_name($inserresult, ':cname', $row[2]);
            oci_bind_by_name($inserresult, ':azimuth', $row[7]);
            oci_bind_by_name($inserresult, ':height', $row[8]);
            oci_bind_by_name($inserresult, ':BSIC', $row[14]);
            oci_bind_by_name($inserresult, ':mtilt', $row[9]);
            oci_bind_by_name($inserresult, ':etilt', $row[10]);
            oci_bind_by_name($inserresult, ':ttilt', $row[11]);
            oci_bind_by_name($inserresult, ':BSC', $row[15]);
            oci_bind_by_name($inserresult, ':celldate', $row[3]);
            oci_bind_by_name($inserresult, ':cnote', $row[6]);
            oci_bind_by_name($inserresult, ':aarea', $row[5]);
            oci_bind_by_name($inserresult, ':earea', $row[4]);
            oci_bind_by_name($inserresult, ':cgi', $row[12]);
            oci_bind_by_name($inserresult, ':hcgi', $row[13]);
            oci_bind_by_name($inserresult, ':cid', $cellId);

            if (oci_execute($inserresult)) {
                //echo "Data Inserted Successfully";
            } else {
                $e = oci_error($inserresult);
                echo "Error Inserting Data: " . htmlentities($e['message']);
            }

     }

    }




}
}