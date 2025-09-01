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
    //echo "File uploaded successfully.<br>";



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
            set_time_limit(1000);

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

            if (empty($rows) || count($rows) < 2) {
                echo "No data found in sheet: $sheetName<br>";
                continue; // Skip to the next sheet
            }


            if ($sheetName == "Sites") {
                

    
                foreach ($rows as $index => $row) {
                    if ($index == 0) continue; // Skip header
                 $siteCodeFromExcel = $row[0]; // Assuming SITE_CODE is in the first column
                 if (empty($siteCodeFromExcel)) {
                    //echo "Skipping empty SITE_CODE<br>";
                    continue; // Skip to the next iteration
                }
                 //echo $siteCodeFromExcel;

                 $sequenceSql = "SELECT NEW_SITES_SEQ.NEXTVAL AS ID FROM dual";
                 $sequenceStmt = oci_parse($conn, $sequenceSql);
                 oci_execute($sequenceStmt);
                 $sequenceRow = oci_fetch_assoc($sequenceStmt);
                 $newSiteId = $sequenceRow['ID'];
                 oci_free_statement($sequenceStmt);



                 // Check if the site exists in NEW_SITES
                    $checkSql1 = "SELECT ID FROM NEW_SITES WHERE SITE_CODE = :sitecode";
                    $checkStmt1 = oci_parse($conn, $checkSql1);
                    oci_bind_by_name($checkStmt1, ":sitecode", $siteCodeFromExcel);
                    oci_execute($checkStmt1);
                    
                    //$rowExists1 = oci_fetch_array($checkStmt1, OCI_ASSOC);

                    //oci_free_statement($checkStmt1);
                if ($rowExists1 = oci_fetch_array($checkStmt1, OCI_ASSOC)) {
                    // Prepare insert statement
                    //echo $rowExists1;
                    //echo "Updating existing site: " . $siteCodeFromExcel . "<br>";
                    $sql = "UPDATE NEW_SITES 
                    SET SITE_NAME = :sname,
                        ZONE = :zone,
                        PROVINCE = :province,
                        CR = :cityrural,
                        SUPPLIER = :supplier,
                        POWER_BACKUP = :pbackup,
                        SITE_ON_AIR_DATE = :ondate,
                        COORDINATES_E = :coorE,
                        COORDINATES_N = :coorN,
                        SITE_ADDRESS = :siteadd,
                        ARABIC_NAME = :ara_name,
                        BSC = :bsc,
                        ALTTITUDE = :att,
                        RELOCATION_DATE = :relocation,
                        TX_NODE = :TX_node,
                        TECHNICAL_PRIORITY = :prio,
                        ADMINSTRITAVE_AREA = :admin_area,
                        NODE_CATEGORY = :cat,
                        SITE_RANKING = :site_ranking,
                        SUBCONTRACTOR = :subcontractor,
                        INVOICE_TOYOLOGY = :invoice
                    WHERE SITE_CODE = : sitecode";
    
    
                    $stmt = oci_parse($conn, $sql);
                  
                    oci_bind_by_name($stmt, ':sname', $row[1]);
                    oci_bind_by_name($stmt, ':zone', $row[2]);
                    oci_bind_by_name($stmt, ':province', $row[3]);
                    oci_bind_by_name($stmt, ':cityrural', $row[4]);
                    oci_bind_by_name($stmt, ':supplier', $row[5]);
                    oci_bind_by_name($stmt, ':pbackup', $row[7]);
                    oci_bind_by_name($stmt, ':ondate', $row[8]);
                    oci_bind_by_name($stmt, ':coorE', $row[10]);
                    oci_bind_by_name($stmt, ':coorN', $row[11]);
                    oci_bind_by_name($stmt, ':siteadd', $row[12]);
                    oci_bind_by_name($stmt, ':ara_name', $row[13]);
                    oci_bind_by_name($stmt, ':TX_node', $row[14]);
                    oci_bind_by_name($stmt, ':prio', $row[15]);
                    oci_bind_by_name($stmt, ':admin_area', $row[16]);
                    oci_bind_by_name($stmt, ':cat', $row[17]);
                    oci_bind_by_name($stmt, ':site_ranking', $row[18]);
                    oci_bind_by_name($stmt, ':subcontractor', $row[19]);
                    oci_bind_by_name($stmt, ':invoice', $row[20]);
                    oci_bind_by_name($stmt, ':bsc', $row[6]);
                    oci_bind_by_name($stmt, ':relocation', $row[9]);
                    oci_bind_by_name($stmt, ':att', $row[21]);
                   // oci_bind_by_name($resultt, ':area_rank', $area_rank);
                    oci_bind_by_name($stmt, ':sitecode', $row[0]);
                    
    
                    if (!oci_execute($stmt)) {
                        // $e = oci_error($stmt);
                        // echo "Error inserting row: " . $e['message'] . "<br>";
                        //echo "Data updated successfully.";

                    }
                    
                    oci_free_statement($stmt);
            }
            else {

                //echo "Inserting new site: " . $siteCodeFromExcel . "<br>";
                $sql = "INSERT INTO NEW_SITES (
                    ID,
                    SITE_CODE,
                    SITE_NAME,
                    ZONE,
                    PROVINCE,
                    CR,
                    SUPPLIER,
                    POWER_BACKUP,
                    SITE_ON_AIR_DATE,
                    COORDINATES_E,
                    COORDINATES_N,
                    SITE_ADDRESS,
                    ARABIC_NAME,
                    BSC,
                    ALTTITUDE,
                    RELOCATION_DATE,
                    TX_NODE,
                    TECHNICAL_PRIORITY,
                    ADMINSTRITAVE_AREA,
                    NODE_CATEGORY,
                    SITE_RANKING,
                    SUBCONTRACTOR,
                    INVOICE_TOYOLOGY
                ) VALUES (
                    :id,
                    :sitecode,
                    :sname,
                    :zone,
                    :province,
                    :cityrural,
                    :supplier,
                    :pbackup,
                    :ondate,
                    :coorE,
                    :coorN,
                    :siteadd,
                    :ara_name,
                    :bsc,
                    :att,
                    :relocation,
                    :TX_node,
                    :prio,
                    :admin_area,
                    :cat,
                    :site_ranking,
                    :subcontractor,
                    :invoice
                )";
        
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':id', $newSiteId);
        oci_bind_by_name($stmt, ':sitecode', $row[0]);
        oci_bind_by_name($stmt, ':sname', $row[1]);
        oci_bind_by_name($stmt, ':zone', $row[2]);
        oci_bind_by_name($stmt, ':province', $row[3]);
        oci_bind_by_name($stmt, ':cityrural', $row[4]);
        oci_bind_by_name($stmt, ':supplier', $row[5]);
        oci_bind_by_name($stmt, ':bsc', $row[6]);
        oci_bind_by_name($stmt, ':pbackup', $row[7]);
        oci_bind_by_name($stmt, ':ondate', $row[8]);
        oci_bind_by_name($stmt, ':coorE', $row[10]);
        oci_bind_by_name($stmt, ':coorN', $row[11]);
        oci_bind_by_name($stmt, ':siteadd', $row[12]);
        oci_bind_by_name($stmt, ':ara_name', $row[13]);
        oci_bind_by_name($stmt, ':TX_node', $row[14]);
        oci_bind_by_name($stmt, ':prio', $row[15]);
        oci_bind_by_name($stmt, ':admin_area', $row[16]);
        oci_bind_by_name($stmt, ':cat', $row[17]);
        oci_bind_by_name($stmt, ':site_ranking', $row[18]);
        oci_bind_by_name($stmt, ':subcontractor', $row[19]);
        oci_bind_by_name($stmt, ':invoice', $row[20]);
        oci_bind_by_name($stmt, ':relocation', $row[9]);
        oci_bind_by_name($stmt, ':att', $row[21]);
        
        if (!oci_execute($stmt)) {
            $e = oci_error($stmt);
            //echo "Error inserting row: " . $e['message'] . "<br>";
        }
        oci_free_statement($stmt);
        


            }




        }

        echo '<script>alert("site\'s basic info updated Successfully")</script>';   
    }



        if ($sheetName == "2G Sites") {
            foreach ($rows as $index => $row) {




                if ($index == 0) continue; // Skip header
                set_time_limit(300);
                $siteCodeFromExcel = $row[0]; // Assuming "cell code" is in the 1st column in the Excel file
                if (empty($siteCodeFromExcel)) {
                    //echo "Skipping empty SITE_CODE<br>";
                    continue; // Skip to the next iteration
                }
                $checkSql1 = "SELECT ID FROM NEW_SITES WHERE SITE_CODE = :sitecode";
                $checkStmt1 = oci_parse($conn, $checkSql1);
                oci_bind_by_name($checkStmt1, ":sitecode", $siteCodeFromExcel);
                oci_execute($checkStmt1);
                
                $newSiteRow = oci_fetch_assoc($checkStmt1);
               
                $newSiteId = $newSiteRow['ID'] ?? '';
                //echo $newSiteId;
               // oci_free_statement($checkStmt1);
                if ($newSiteRow) {
                   // $newSiteId = $newSiteRow['ID'];


                    $checkSql2G = "SELECT SITE_ID FROM TWO_G_SITES WHERE SITE_CODE = :sitecode";
                    $checkStmt2G = oci_parse($conn, $checkSql2G);
                    oci_bind_by_name($checkStmt2G, ":sitecode", $siteCodeFromExcel);
                    oci_execute($checkStmt2G);
                    
                    $rowExists2G = oci_fetch_assoc($checkStmt2G);
                    oci_free_statement($checkStmt2G);
                    if ($rowExists2G) {
                       // echo "Updating existing site: " . $siteCodeFromExcel . "two g<br>";
                        $query = "UPDATE TWO_G_SITES 
                        SET BAND = :band,
                            SITE_STATUS = :status2G,
                            BTS_TYPE = :BTS,
                            BSC = :BSC,
                            TWOG_ON_AIR_DATE = :date2G,
                            NINTY_GSM_RBS_TYPE = :RBS1,
                            NINTY_ON_AIR_DATE = :date1,
                            EIGHTY_GSM_RBS_TYPE = :RBS2,
                            EIGHTY_ON_AIR_DATE = :date2,
                            NOTES = :snote,
                            REAL_BSC = :rBSC,
                            LAC = :lac,
                            RESTORATION_DATE = :restoration
                            
                        WHERE SITE_CODE = :sitecode";
              //echo $sid;
                        $updateresult = oci_parse($conn, $query);
                        
                        oci_bind_by_name($updateresult, ':band', $row[1]);
                        oci_bind_by_name($updateresult, ':status2G', $row[2]);
                        oci_bind_by_name($updateresult, ':BTS', $row[3]);
                        oci_bind_by_name($updateresult, ':BSC', $row[4]);
                        oci_bind_by_name($updateresult, ':date2G', $row[5]);
                        oci_bind_by_name($updateresult, ':RBS1', $row[6]);
                        oci_bind_by_name($updateresult, ':date1', $row[7]);
                        oci_bind_by_name($updateresult, ':RBS2', $row[8]);
                        oci_bind_by_name($updateresult, ':date2', $row[9]);
                        oci_bind_by_name($updateresult, ':snote', $row[10]);
                        oci_bind_by_name($updateresult, ':rBSC', $row[11]);
                        oci_bind_by_name($updateresult, ':lac', $row[13]);
                        oci_bind_by_name($updateresult, ':restoration', $row[12]);
                        oci_bind_by_name($updateresult, ':sitecode', $row[0]);
                                    
                        if (!oci_execute($updateresult)) {
                            //$e = oci_error($updateresult);
                            //echo "Error inserting row: " . $e['message'] . "<br>";
                        }
                        oci_free_statement($updateresult);


                    }

                    else {
                      //  echo "Inserting new site: " . $siteCodeFromExcel . "two g sites<br>";
                        $sequenceSql = "SELECT TWO_G_SITES_SEQ.NEXTVAL AS CELL_ID FROM dual";
                        $sequenceStmt = oci_parse($conn, $sequenceSql);
                        oci_execute($sequenceStmt);
                        $sequenceRow = oci_fetch_assoc($sequenceStmt);
                        $twoSiteId = $sequenceRow['CELL_ID'];
                        oci_free_statement($sequenceStmt);

                        $query = "INSERT INTO TWO_G_SITES (SITE_ID,
                            CELL_ID,
                            BAND,
                            SITE_STATUS,
                            BTS_TYPE,
                            BSC,
                            TWOG_ON_AIR_DATE,
                            NINTY_GSM_RBS_TYPE,
                            NINTY_ON_AIR_DATE,
                            EIGHTY_GSM_RBS_TYPE,
                            EIGHTY_ON_AIR_DATE,
                            NOTES,
                            REAL_BSC,
                            LAC,
                            RESTORATION_DATE,
                            SITE_CODE
                        ) VALUES (
                            :siid,
                            :cellid,
                            :band,
                            :status2G,
                            :BTS,
                            :BSC,
                            :date2G,
                            :RBS1,
                            :date1,
                            :RBS2,
                            :date2,
                            :snote,
                            :rBSC,
                            :lac,
                            :restoration,
                            :sitecode
                        )";
            
                        $inserresult = oci_parse($conn, $query);
                        
                        oci_bind_by_name($inserresult, ':siid', $newSiteId);
                        oci_bind_by_name($inserresult, ':cellid', $twoSiteId);
                        oci_bind_by_name($inserresult, ':band', $row[1]);
                        oci_bind_by_name($inserresult, ':status2G', $row[2]);
                        oci_bind_by_name($inserresult, ':BTS', $row[3]);
                        oci_bind_by_name($inserresult, ':BSC', $row[4]);
                        oci_bind_by_name($inserresult, ':date2G', $row[5]);
                        oci_bind_by_name($inserresult, ':RBS1', $row[6]);
                        oci_bind_by_name($inserresult, ':date1', $row[7]);
                        oci_bind_by_name($inserresult, ':RBS2', $row[8]);
                        oci_bind_by_name($inserresult, ':date2', $row[9]);
                        oci_bind_by_name($inserresult, ':snote', $row[10]);
                        oci_bind_by_name($inserresult, ':rBSC', $row[11]);
                        oci_bind_by_name($inserresult, ':lac', $row[13]);
                        oci_bind_by_name($inserresult, ':restoration', $row[12]);
                        oci_bind_by_name($inserresult, ':sitecode', $row[0]);
                        
                        if (!oci_execute($inserresult)) {
                            //$e = oci_error($inserresult);
                            //echo "Error inserting row: " . $e['message'] . "<br>";
                        }
                        oci_free_statement($inserresult);
            

                    }
                   
                }
                else{
                echo '<script>alert("'.$siteCodeFromExcel.' site doesn\'t exist")</script>';
                }
            }
            echo '<script>alert("2G site\'s info updated Successfully")</script>'; 
            } 
        
            elseif ($sheetName == "3G Sites") {


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
                    $siteCodeFromExcel = $row[0];

                    set_time_limit(300);
                    
                    if (empty($siteCodeFromExcel)) {
                        //echo "Skipping empty SITE_CODE<br>";
                        continue; // Skip to the next iteration
                    }

                    $newsitecode3 = substr($siteCodeFromExcel,0,6);
                    //echo $newsitecode3;

                
                    $checkSql1 = "SELECT ID ,SITE_CODE FROM NEW_SITES WHERE SITE_CODE = :sitecode";
                    $checkStmt1 = oci_parse($conn, $checkSql1);
                    oci_bind_by_name($checkStmt1, ":sitecode", $newsitecode3);
                    oci_execute($checkStmt1);
                    
                    $newSiteRow = oci_fetch_assoc($checkStmt1);
                    $newSiteId   = $newSiteRow['ID'] ?? '';
                    //oci_free_statement($checkStmt1);
                    if ($newSiteRow) {
                        
                       // $newsitecode = $newSiteRow['SITE_CODE'];

                        $checkSql3G = "SELECT SITE_ID FROM THREE_G_SITES WHERE SITE_CODE = :sitecode";
                        $checkStmt3G = oci_parse($conn, $checkSql3G);
                        oci_bind_by_name($checkStmt3G, ":sitecode", $siteCodeFromExcel);
                        oci_execute($checkStmt3G);
                        
                        $rowExists3G = oci_fetch_assoc($checkStmt3G);
                        oci_free_statement($checkStmt3G);
                        if ($rowExists3G) {
                            //echo "Updating existing site: " . $siteCodeFromExcel . "three g<br>";
                            $query1 = "UPDATE THREE_G_SITES 
                            SET WBTS_TYPE = :wbts,
                                RNC = :RNC,
                                SITE_STATUS = :status,
                                THREE_G_ON_AIR_DATE = :date3G,
                                Renovation_Date = :reno,
                                BTS_TYPE = :BTS,
                                NUMBER_OF_CARRIERS = :carriers,
                                NOTES = :snote,
                                REAL_RNC = :RRNC,
                                RESTORATION_Date = :restordate,
                              
                                LAC =:lac
                        
                                
                            WHERE SITE_CODE = :sitecode";
                            //echo $sid;
                            $updateresult2 = oci_parse($conn, $query1);
    
                        oci_bind_by_name($updateresult2, ':wbts', $row[1]);
                        oci_bind_by_name($updateresult2, ':RNC', $row[2]);
                        oci_bind_by_name($updateresult2, ':status', $row[3]);
                        oci_bind_by_name($updateresult2, ':date3G', $row[4]);
                        oci_bind_by_name($updateresult2, ':reno', $row[5]);
                        oci_bind_by_name($updateresult2, ':BTS', $row[6]);
                        oci_bind_by_name($updateresult2, ':carriers', $row[7]);
                        oci_bind_by_name($updateresult2, ':snote', $row[9]);
                        oci_bind_by_name($updateresult2, ':RRNC', $row[10]);
                        oci_bind_by_name($updateresult2, ':restordate', $row[11]);
                        oci_bind_by_name($updateresult2, ':lac', $row[12]);
                        
                        oci_bind_by_name($updateresult2, ':sitecode', $siteCodeFromExcel);
          
                            
                            if (!oci_execute($updateresult2)) {
                                //$e = oci_error($updateresult2);
                                //echo "Error inserting row: " . $e['message'] . "<br>";
                            }
                            oci_free_statement($updateresult2);


                        }
                        else{
                            //echo "Inserting new site: " . $siteCodeFromExcel . "3g sites<br>";
                            $sequenceSql = "SELECT THREE_G_SITES_SEQ.NEXTVAL AS CELL_ID FROM dual";
                            $sequenceStmt = oci_parse($conn, $sequenceSql);
                            oci_execute($sequenceStmt);
                            $sequenceRow = oci_fetch_assoc($sequenceStmt);
                            $threeSiteId = $sequenceRow['CELL_ID'];
                            //oci_free_statement($sequenceStmt);


                            $query1 = "INSERT INTO THREE_G_SITES (SITE_ID,
                                CELL_ID,
                                WBTS_TYPE,
                                RNC,
                                SITE_STATUS,
                                THREE_G_ON_AIR_DATE,
                                Renovation_Date,
                                BTS_TYPE,
                                NUMBER_OF_CARRIERS,
                                NOTES,
                                REAL_RNC,
                                RESTORATION_Date,
                                LAC,
                                SITE_CODE
                            ) VALUES (
                                :sd,
                                :cell,
                                :wbts,
                                :RNC,
                                :status,
                                :date3G,
                                :reno,
                                :BTS,
                                :carriers,
                                :snote,
                                :RRNC,
                                :restordate,
                                :lac,
                                :sitecode
                            )";
    
                            $inserresult = oci_parse($conn, $query1);

                            oci_bind_by_name($inserresult, ':sd', $newSiteId);
                            oci_bind_by_name($inserresult, ':cell', $threeSiteId);
                            oci_bind_by_name($inserresult, ':wbts', $row[1]);
                            oci_bind_by_name($inserresult, ':RNC', $row[2]);
                            oci_bind_by_name($inserresult, ':status', $row[3]);
                            oci_bind_by_name($inserresult, ':date3G', $row[4]);
                            oci_bind_by_name($inserresult, ':reno', $row[5]);
                            oci_bind_by_name($inserresult, ':BTS', $row[6]);
                            oci_bind_by_name($inserresult, ':carriers', $row[7]);
                            oci_bind_by_name($inserresult, ':snote', $row[9]);
                            oci_bind_by_name($inserresult, ':RRNC', $row[10]);
                            oci_bind_by_name($inserresult, ':restordate', $row[11]);
                            oci_bind_by_name($inserresult, ':lac', $row[12]);
                            oci_bind_by_name($inserresult, ':sitecode', $row[0]);
                            
                            if (!oci_execute($inserresult)) {
                                $e = oci_error($inserresult);
                                echo "Error inserting row: " . $e['message'] . "<br>";
                            }
                            oci_free_statement($inserresult);
    






                        }
                    



                    }
                    else{
                    echo '<script>alert("'.$siteCodeFromExcel.' site doesn\'t exist")</script>';
                    }
                }
                echo '<script>alert("3G site\'s info updated Successfully")</script>'; 
            }


            elseif ($sheetName == "4G Sites") {


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
                    $siteCodeFromExcel = $row[0];

                    set_time_limit(300);
                    
                    if (empty($siteCodeFromExcel)) {
                        //echo "Skipping empty SITE_CODE<br>";
                        continue; // Skip to the next iteration
                    }


                     $newsitecode = substr($siteCodeFromExcel,0,6);
                    $checkSql1 = "SELECT ID ,SITE_CODE FROM NEW_SITES WHERE SITE_CODE = :sitecode";
                    $checkStmt1 = oci_parse($conn, $checkSql1);
                    oci_bind_by_name($checkStmt1, ":sitecode", $newsitecode);
                    oci_execute($checkStmt1);
                    
                    $newSiteRow = oci_fetch_assoc($checkStmt1);
                    $newSiteId   = $newSiteRow['ID'] ?? '';
                    oci_free_statement($checkStmt1);

                    if ($newSiteRow) {
                        
                        //$newsitecode = $newSiteRow['SITE_CODE'];

                        $checkSql4G = "SELECT SID FROM FOUR_G_SITES WHERE SITE_CODE = :newsitecode";
                        $checkStmt4G = oci_parse($conn, $checkSql4G);
                        oci_bind_by_name($checkStmt4G, ":newsitecode", $siteCodeFromExcel);
                        oci_execute($checkStmt4G);
                        
                        $rowExists4G = oci_fetch_assoc($checkStmt4G);
                        oci_free_statement($checkStmt4G);

                        if ($rowExists4G) {
                            //echo "Updating existing site: " . $siteCodeFromExcel . "four g<br>";
                            $query1 = "UPDATE FOUR_G_SITES SET ENODEB_ID =:nodeb, BTS_TYPE =:BTS, LAC =:lac, STATUS =:status, ACTIVATION_DATE =:date4G, NOTE =:snote, RESTORATION_DATE =:restordate ,Radio_Plan =:radio WHERE SITE_CODE =:sitecode";
    
                            $updateresult = oci_parse($conn, $query1);
                            
                            oci_bind_by_name($updateresult, ':sitecode', $row[0]);
                            oci_bind_by_name($updateresult, ':nodeb', $row[1]);
                            oci_bind_by_name($updateresult, ':BTS', $row[2]);
                            oci_bind_by_name($updateresult, ':status', $row[3]);
                            oci_bind_by_name($updateresult, ':date4G', $row[4]);
                            oci_bind_by_name($updateresult, ':snote', $row[5]);
                            oci_bind_by_name($updateresult, ':restordate', $row[6]);
                            oci_bind_by_name($updateresult, ':radio', $row[7]);
                            oci_bind_by_name($updateresult, ':lac', $row[8]);
                            
                            if (oci_execute($updateresult)) {
                            //echo "Data Updated Successfully";
                            } else {
                            $e = oci_error($updateresult);
                            echo "Error Updating Data: " . htmlentities($e['message']);
                            }
    

                        }

                        else{
                            //echo "Inserting new site: " . $siteCodeFromExcel . "4g sites<br>";
                            $sequenceSql = "SELECT FOUR_G_SITES_SEQ.NEXTVAL AS CELL_ID_KEY FROM dual";
                            $sequenceStmt = oci_parse($conn, $sequenceSql);
                            oci_execute($sequenceStmt);
                            $sequenceRow = oci_fetch_assoc($sequenceStmt);
                            $fourSiteId = $sequenceRow['CELL_ID_KEY'];
                            oci_free_statement($sequenceStmt);
                            

                        $query1 = "INSERT INTO FOUR_G_SITES (SID, CELL_ID_KEY, SITE_CODE, ENODEB_ID, BTS_TYPE, LAC, STATUS, ACTIVATION_DATE, NOTE, RESTORATION_DATE, Radio_Plan) 
                                    VALUES (:sid, :cell, :sitecode, :nodeb, :BTS, :lac, :status, :date4G, :snote, :restordate, :radio)";

                            $inserresult = oci_parse($conn, $query1);

                            oci_bind_by_name($inserresult, ':cell', $fourSiteId);
                            oci_bind_by_name($inserresult, ':sid', $newSiteId);
                            oci_bind_by_name($inserresult, ':sitecode', $row[0]);
                            oci_bind_by_name($inserresult, ':nodeb', $row[1]);
                            oci_bind_by_name($inserresult, ':BTS', $row[2]);
                            oci_bind_by_name($inserresult, ':status', $row[3]);
                            oci_bind_by_name($inserresult, ':date4G', $row[4]);
                            oci_bind_by_name($inserresult, ':snote', $row[5]);
                            oci_bind_by_name($inserresult, ':restordate', $row[6]);
                            oci_bind_by_name($inserresult, ':radio', $row[7]);
                            oci_bind_by_name($inserresult, ':lac', $row[8]);

                            if (oci_execute($inserresult)) {
                                //echo "Data Inserted Successfully";
                            } else {
                                $e = oci_error($inserresult);
                                echo "Error Inserting Data: " . htmlentities($e['message']);
                            }



                        }
                       
                    }
                    else{
                        echo '<script>alert("'.$siteCodeFromExcel.' site doesn\'t exist")</script>';
                    }
                }
                echo '<script>alert("4G site\'s info updated Successfully")</script>'; 
            }



            if ($sheetName == "2G Cells") {
                foreach ($rows as $index => $row) {
                    if ($index == 0) continue; // Skip header row
                    
                    $cellCodeFromExcel = $row[1];
                    // Check if cell code is empty
                    if (empty($cellCodeFromExcel)) {
                        continue; // Skip to the next iteration
                    }

                    $site = substr($cellCodeFromExcel, 0, 6);
                    //echo "Processing site: $site<br>";

                    $checkSql2G = "SELECT CELL_ID FROM TWO_G_SITES WHERE SITE_CODE = :sitecode";
                    $checkStmt2G = oci_parse($conn, $checkSql2G);
                    oci_bind_by_name($checkStmt2G, ":sitecode", $site);
                    oci_execute($checkStmt2G);
                    
                    $rowExists2G = oci_fetch_assoc($checkStmt2G);
                    oci_free_statement($checkStmt2G);

                    if ($rowExists2G) {
                        $cellId = $rowExists2G['CELL_ID'];
                        //echo "Found CELL_ID: $cellId<br>";

                        // Check for existing cell code
                        $checkSql2 = "SELECT * FROM TWO_G_CELLS WHERE CELL_CODE = :cellcode";
                        $checkStmt2 = oci_parse($conn, $checkSql2);
                        oci_bind_by_name($checkStmt2, ":cellcode", $cellCodeFromExcel);
                        oci_execute($checkStmt2);
                        
                        $rowExists22 = oci_fetch_assoc($checkStmt2);
                        oci_free_statement($checkStmt2);

                        if ($rowExists22) {
                            // Update existing record
                            $query1 = "UPDATE TWO_G_CELLS 
                            SET CELL_NAME = :cname,
                                AZIMUTH = :azimuth,
                                HIEGHT = :height,
                                BSIC = :BSIC,
                                M_TILT = :mtilt,
                                E_TILT = :etilt,
                                TOTAL_TILT = :ttilt,
                                BSC = :BSC,
                                CELL_ON_AIR_DATE = :celldate,
                                NOTE = :cnote,
                                SERVING_AREA_IN_ENGLISH = :aarea,
                                SERVING_AREA = :earea,
                                CGI = :cgi,
                                CGI_HEX = :hcgi
                            WHERE CELL_CODE = :cellcode";

                            $updateresult = oci_parse($conn, $query1);
                            oci_bind_by_name($updateresult, ':cname', $row[2]);
                            oci_bind_by_name($updateresult, ':azimuth', $row[8]);
                            oci_bind_by_name($updateresult, ':height', $row[9]);
                            oci_bind_by_name($updateresult, ':BSIC', $row[15]);
                            oci_bind_by_name($updateresult, ':etilt', $row[11]);
                            oci_bind_by_name($updateresult, ':mtilt', $row[10]);
                            oci_bind_by_name($updateresult, ':ttilt', $row[12]);
                            oci_bind_by_name($updateresult, ':BSC', $row[7]);
                            oci_bind_by_name($updateresult, ':celldate', $row[3]);
                            oci_bind_by_name($updateresult, ':cnote', $row[6]);
                            oci_bind_by_name($updateresult, ':aarea', $row[5]);
                            oci_bind_by_name($updateresult, ':earea', $row[4]);
                            oci_bind_by_name($updateresult, ':cgi', $row[13]);
                            oci_bind_by_name($updateresult, ':hcgi', $row[14]);
                            oci_bind_by_name($updateresult, ':cellcode', $row[1]);

                            if (oci_execute($updateresult)) {
                                //echo "Data Updated Successfully for CELL_CODE: $cellCodeFromExcel<br>";
                            } else {
                                $e = oci_error($updateresult);
                                echo "Error Updating Data: " . htmlentities($e['message']) . "<br>";
                            }
                        } else {
                            // Insert new record
                            $query1 = "INSERT INTO TWO_G_CELLS 
                                        (CID_KEY, CELL_CODE, CELL_NAME, CELL_ID, AZIMUTH, HIEGHT, BSIC, M_TILT, E_TILT, TOTAL_TILT, BSC, CELL_ON_AIR_DATE, NOTE, SERVING_AREA_IN_ENGLISH, SERVING_AREA, CGI, CGI_HEX) 
                                        VALUES 
                                        (:cid, :cellcode, :cname,:cell, :azimuth, :height, :BSIC, :mtilt, :etilt, :ttilt, :BSC, :celldate, :cnote, :aarea, :earea, :cgi, :hcgi)";

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
                            oci_bind_by_name($inserresult, ':cell', $row[0]);

                            if (oci_execute($inserresult)) {
                                //echo "Data Inserted Successfully for CELL_CODE: $cellCodeFromExcel<br>";
                            } else {
                                $e = oci_error($inserresult);
                                echo "Error Inserting Data: " . htmlentities($e['message']) . "<br>";
                            }
                        }
                        
                    } else {
                        //echo "No matching site found for SITE_CODE: $site<br>";
                        echo '<script>alert("'.$site.' site doesn\'t exist in 2G sites")</script>';
                    }
                }
                echo '<script>alert("2G cells updated Successfully")</script>';
            }


            elseif ($sheetName == "3G Cells") {


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

                    $newsitecode3 = substr($cellCodeFromExcel,0,7);

                    $checkSql2G = "SELECT CELL_ID FROM THREE_G_SITES WHERE SITE_CODE = :sitecode";
                    $checkStmt2G = oci_parse($conn, $checkSql2G);
                    oci_bind_by_name($checkStmt2G, ":sitecode", $newsitecode3);
                    oci_execute($checkStmt2G);
                    
                    $rowExists3G = oci_fetch_assoc($checkStmt2G);
         
                    $cellId = $rowExists3G['CELL_ID'];
                    $multisectorid = "2775";
                    oci_free_statement($checkStmt2G);
                    //echo "Found CELL_ID: $cellId<br>";
                    if ($rowExists3G) {
                        //echo "Updating existing site: " . $siteCodeFromExcel . "3g cells<br>";
                        $checkSql2 = "SELECT * FROM THREE_G_CELLS WHERE CELL_CODE = :cellcode";
                        $checkStmt2 = oci_parse($conn, $checkSql2);
                        oci_bind_by_name($checkStmt2, ":cellcode", $cellCodeFromExcel);
                        oci_execute($checkStmt2);
                        
                        $rowExists32 = oci_fetch_assoc($checkStmt2);
                        oci_free_statement($checkStmt2);
                     if($rowExists32){

                        $query2 = "UPDATE THREE_G_CELLS
                        SET CELL_NAME = :cname,
                            ON_AIR_DATE = :celldate,
                            AZIMUTH = :azimuth,
                            M_TILT = :mtilt,
                            E_TILT = :etilt,
                            TOTAL_TILT = :ttilt,
                            SERVING_AREA = :aarea,
                            SERVING_AREA_IN_ENGLISH = :earea,
                            NOTE = :cnote,
                            HIEGHT = :height,
                            CGI =:cgi,
                            CGI_HEX =:hcgi,
                            CARRIER =:car
                        WHERE CELL_CODE = :cellcode";
                
                        $result2 = oci_parse($conn, $query2);
                        
                    
                        oci_bind_by_name($result2, ':cellcode', $row[1]);
                        oci_bind_by_name($result2, ':cname', $row[2]);
                        oci_bind_by_name($result2, ':celldate', $row[3]);
                        oci_bind_by_name($result2, ':azimuth', $row[8]);
                        oci_bind_by_name($result2, ':mtilt', $row[10]);
                        oci_bind_by_name($result2, ':etilt', $row[11]);
                        oci_bind_by_name($result2, ':ttilt', $row[12]);
                        oci_bind_by_name($result2, ':aarea', $row[5]);
                        oci_bind_by_name($result2, ':earea', $row[4]);
                        oci_bind_by_name($result2, ':cnote', $row[6]);
                        oci_bind_by_name($result2, ':height', $row[9]);
                        oci_bind_by_name($result2, ':cgi', $row[13]);
                        oci_bind_by_name($result2, ':hcgi', $row[14]);
                        oci_bind_by_name($result2, ':car', $row[7]);
                        
                      
                        if (oci_execute($result2)) {
                        //echo "Data Updated Successfully";
                        } else {
                        $e = oci_error($result2);
                        echo "Error Updating Data: " . htmlentities($e['message']);
                        }


                    }
                    else {
                       // echo "Inserting new site: " . $siteCodeFromExcel . "3g cells<br>";
                        $query2 = "INSERT INTO THREE_G_CELLS 
                                    (CID, MSCELL_ID,CELL_ID , CELL_CODE, CELL_NAME, ON_AIR_DATE, AZIMUTH, M_TILT, E_TILT, TOTAL_TILT, SERVING_AREA, SERVING_AREA_IN_ENGLISH, NOTE, HIEGHT, CGI, CGI_HEX, CARRIER) 
                                    VALUES 
                                    (:cid,:ms,:cell, :cellcode, :cname, :celldate, :azimuth, :mtilt, :etilt, :ttilt, :aarea, :earea, :cnote, :height, :cgi, :hcgi, :car)";

                        $result2 = oci_parse($conn, $query2);


                        oci_bind_by_name($result2, ':cid', $cellId);
                        oci_bind_by_name($result2, ':ms', $multisectorid);
                        oci_bind_by_name($result2, ':cellcode', $row[1]);
                        oci_bind_by_name($result2, ':cname', $row[2]);
                        oci_bind_by_name($result2, ':celldate', $row[3]);
                        oci_bind_by_name($result2, ':azimuth', $row[8]);
                        oci_bind_by_name($result2, ':mtilt', $row[10]);
                        oci_bind_by_name($result2, ':etilt', $row[11]);
                        oci_bind_by_name($result2, ':ttilt', $row[12]);
                        oci_bind_by_name($result2, ':aarea', $row[5]);
                        oci_bind_by_name($result2, ':earea', $row[4]);
                        oci_bind_by_name($result2, ':cnote', $row[6]);
                        oci_bind_by_name($result2, ':height', $row[9]);
                        oci_bind_by_name($result2, ':cgi', $row[13]);
                        oci_bind_by_name($result2, ':hcgi', $row[14]);
                        oci_bind_by_name($result2, ':car', $row[7]);
                        oci_bind_by_name($result2, ':cell', $row[0]);

                        if (oci_execute($result2)) {
                            echo "Data Inserted Successfully";
                        } else {
                            $e = oci_error($result2);
                            echo "Error Inserting Data: " . htmlentities($e['message']);
                        }
   
                    }
                    
                }
                else{
                echo '<script>alert("'.$newsitecode3.' site doesn\'t exist in 3G sites")</script>';
                }
            }
            echo '<script>alert("3G cells updated Successfully")</script>';
        }

            elseif ($sheetName == "4G Cells") {

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

                    $newsitecode4 = substr($cellCodeFromExcel,0,7);

                    $checkSql2G = "SELECT CELL_ID_KEY FROM FOUR_G_SITES WHERE SITE_CODE = :sitecode";
                    $checkStmt2G = oci_parse($conn, $checkSql2G);
                    oci_bind_by_name($checkStmt2G, ":sitecode", $newsitecode4);
                    oci_execute($checkStmt2G);
                    
                    $rowExists4G = oci_fetch_assoc($checkStmt2G);
                    oci_free_statement($checkStmt2G);
                    $cellId = $rowExists4G['CELL_ID_KEY'] ?? '';
                    //echo "Found CELL_ID: $cellId<br>";
                    if ($rowExists4G) {
                        //echo "Updating existing site: " . $siteCodeFromExcel . "4g cells<br>";
                        $checkSql2 = "SELECT * FROM FOUR_G_CELLS WHERE CELL_CODE = :cellcode";
                        $checkStmt2 = oci_parse($conn, $checkSql2);
                        oci_bind_by_name($checkStmt2, ":cellcode", $cellCodeFromExcel);
                        oci_execute($checkStmt2);
                        
                        $rowExists42 = oci_fetch_assoc($checkStmt2);
                        oci_free_statement($checkStmt2);
                     if($rowExists42){
                        $query2 = "UPDATE FOUR_G_CELLS
                        SET CELL_NAME = :cname,
                            ON_AIR_DATE = :celldate,
                            AZIMUTH = :azimuth,
                            M_TILT = :mtilt,
                            E_TILT = :etilt,
                            TOTAL_TILT = :ttilt,
                            SERVING_AREA = :aarea,
                            SERVING_AREA_IN_ENGLISH = :earea,
                            NOTES = :cnote,
                            HEIGHT = :height, 
                            CGI =:cgi,
                            CGI_HEX =:hcgi
                        WHERE CELL_CODE = :cellcode";
                
                            $result2 = oci_parse($conn, $query2);
                            
                            
                        
                            oci_bind_by_name($result2, ':cellcode', $row[1]);
                            oci_bind_by_name($result2, ':cname', $row[2]);
                            oci_bind_by_name($result2, ':celldate', $row[3]);
                            oci_bind_by_name($result2, ':azimuth', $row[7]);
                            oci_bind_by_name($result2, ':mtilt', $row[9]);
                            oci_bind_by_name($result2, ':etilt', $row[10]);
                            oci_bind_by_name($result2, ':ttilt', $row[11]);
                            oci_bind_by_name($result2, ':aarea', $row[5]);
                            oci_bind_by_name($result2, ':earea', $row[4]);
                            oci_bind_by_name($result2, ':cnote', $row[13]);
                            oci_bind_by_name($result2, ':height', $row[8]);
                            oci_bind_by_name($result2, ':cgi', $row[12]);
                            oci_bind_by_name($result2, ':hcgi', $row[13]);
                
            
    
                      
                        if (oci_execute($result2)) {
                        //echo "Data Updated Successfully";
                        } else {
                        $e = oci_error($result2);
                        echo "Error Updating Data: " . htmlentities($e['message']);
                        }

                     }
                    else{
                        //echo "Inserting new site: " . $siteCodeFromExcel . "4Gcells<br>";
                        $query2 = "INSERT INTO FOUR_G_CELLS 
                        (CID_KEY,CELL_ID, CELL_CODE, CELL_NAME, ON_AIR_DATE, AZIMUTH, M_TILT, E_TILT, TOTAL_TILT, SERVING_AREA, SERVING_AREA_IN_ENGLISH, NOTES, HEIGHT, CGI, CGI_HEX) 
                        VALUES 
                        (:cid, :cell, :cellcode, :cname, :celldate, :azimuth, :mtilt, :etilt, :ttilt, :aarea, :earea, :cnote, :height, :cgi, :hcgi)";
            
                        $result2 = oci_parse($conn, $query2);
                        
                        oci_bind_by_name($result2, ':cid', $cellId);
                        oci_bind_by_name($result2, ':cell', $row[0]);
                        oci_bind_by_name($result2, ':cellcode', $row[1]);
                        oci_bind_by_name($result2, ':cname', $row[2]);
                        oci_bind_by_name($result2, ':celldate', $row[3]);
                        oci_bind_by_name($result2, ':azimuth', $row[7]);
                        oci_bind_by_name($result2, ':mtilt', $row[9]);
                        oci_bind_by_name($result2, ':etilt', $row[10]);
                        oci_bind_by_name($result2, ':ttilt', $row[11]);
                        oci_bind_by_name($result2, ':aarea', $row[5]);
                        oci_bind_by_name($result2, ':earea', $row[4]);
                        oci_bind_by_name($result2, ':cnote', $row[13]);
                        oci_bind_by_name($result2, ':height', $row[8]);
                        oci_bind_by_name($result2, ':cgi', $row[12]);
                        oci_bind_by_name($result2, ':hcgi', $row[13]);
                        
                        if (oci_execute($result2)) {
                            //echo "Data Inserted Successfully";
                        } else {
                            $e = oci_error($result2);
                            echo "Error Inserting Data: " . htmlentities($e['message']);
                        }
                        
                   }
             
                    }
                    else{
                    echo '<script>alert("'.$newsitecode4.' site doesn\'t exist in 4G sites")</script>';
                        }


                }
                echo '<script>alert("4G cells updated Successfully")</script>';
            }




     //   }

        oci_close($conn);
        exit();
        //echo "Data imported successfully.";
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
