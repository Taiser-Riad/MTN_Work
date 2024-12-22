<?php 
include "config.php";
?>
<?php
if(isset($_GET['id2']))
{
$id =$_GET['id2'];
$sql    = "SELECT * FROM TWO_G_CELLS WHERE CELL_CODE =:id";
$result = oci_parse($conn, $sql);
oci_bind_by_name($result, ":id", $id);
oci_execute($result);

$sqll = "SELECT s.*, t.*, c.* FROM NEW_SITES s INNER JOIN TWO_G_SITES t ON s.ID = t.SITE_ID INNER JOIN TWO_G_CELLS c ON t.CELL_ID = c.CID_KEY
WHERE c.CELL_CODE = :id";

$resultt = oci_parse($conn, $sqll);

oci_bind_by_name($resultt, ":id", $id);
oci_execute($resultt);



$cancelldate = date("m-d-Y");

if(($row = oci_fetch_array($resultt, OCI_ASSOC)) != false){

    $cellid    = $row['CELL_ID'];
    $cellidkey = $row['CID_KEY'];
    $sid       = $row['SITE_ID'];
    $BAND      = $row['BAND'];
    $status    = $row['SITE_STATUS'];
    $note      = $row['NOTES'];
    $cellcode  = $row['CELL_CODE'];
    $sitecode  = $row['SITE_CODE'];
   
    if(isset($row['NINTY_GSM_RBS_TYPE'])){
       $RBS =$row['NINTY_GSM_RBS_TYPE'];
    }
   else {
       $RBS =$row['EIGHTY_GSM_RBS_TYPE'];
   }

    $query2 ="INSERT INTO CANCELLED_CELLS(CELL_ID_KEY, CELL_CODE, CELL_NAME, CELL_ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, BSC, ON_AIR_DATE, NOTE, SERVING_AREA, SERVING_AREA_IN_ENGLISH)
    SELECT c.CID_KEY, c.CELL_CODE, c.CELL_NAME, c.CELL_ID, s.SITE_CODE, s.SITE_NAME, s.ZONE, s.PROVINCE, s.CR, s.SUPPLIER, s.BSC, c.Cell_ON_AIR_DATE, c.NOTE ,c.SERVING_AREA, c.SERVING_AREA_IN_ENGLISH FROM NEW_SITES s INNER JOIN TWO_G_SITES t ON(s.ID = t.SITE_ID) JOIN TWO_G_CELLS c ON (t.CELL_ID = c.CID_KEY)
    WHERE (c.CELL_CODE =:id)";
    $stid = oci_parse($conn, $query2);
    oci_bind_by_name($stid, ":id", $id); 
    $resultt1 = oci_execute($stid);
    if (!$resultt1) { 
        $e = oci_error($stid); 
        echo htmlentities($e['message'], ENT_QUOTES);
     }


    $query3 = "UPDATE CANCELLED_CELLS SET CANCELLED_DATE = :cancelldate WHERE CELL_ID_KEY = :cellidkey AND CELL_CODE = :id";
    $stid3 = oci_parse($conn, $query3); 
     oci_bind_by_name($stid3, ":cancelldate", $cancelldate); 
     oci_bind_by_name($stid3, ":cellidkey", $cellidkey); 
     oci_bind_by_name($stid3, ":id", $id); // Execute the query 
     $resultquery3 = oci_execute($stid3);



    $sqll2    = "DELETE FROM TWO_G_CELLS WHERE CELL_CODE =:id";
   
    $stid4 = oci_parse($conn,  $sqll2); 
    oci_bind_by_name($stid4, ":id", $id); 
    $resultt2 = oci_execute($stid4);
    //$num1 = mysqli_num_rows($resultt2);
    if (!$resultt2){
        $e = oci_error($stid4); 
        echo htmlentities($e['message'], ENT_QUOTES);
    }
    else{
        echo '<script>alert("'.$row["CELL_CODE"].'  cell deleted Successfully")</script>'; 
    }


    $sqll3 = "SELECT * FROM TWO_G_CELLS WHERE CID_KEY = :cellidkey";
    $stid5 = oci_parse($conn, $sqll3);
     oci_bind_by_name($stid5, ":cellidkey", $cellidkey);
     oci_execute($stid5);

      $num = 0; 
      while (($row11 = oci_fetch_array($stid5, OCI_ASSOC)) != false) { 
        $num++; 
    }



if ($num == false) {
    echo '<script>alert("'.$row["SITE_CODE"].' 2G site will be deleted.")</script>';

    $tech = "2G";

    // Insert into CANCELLED_SITES
    $query5 = "INSERT INTO CANCELLED_SITES (SITE_ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, ON_AIR_DATE, COORDINATES_E, COORDINATES_N, SITE_ADRESS)
    SELECT s.ID, s.SITE_CODE, s.SITE_NAME, s.ZONE, s.PROVINCE, s.CR, s.SUPPLIER, t.TWOG_ON_AIR_DATE, s.COORDINATES_E, s.COORDINATES_N, s.SITE_ADDRESS
    FROM NEW_SITES s
    INNER JOIN TWO_G_SITES t ON s.ID = t.SITE_ID
    WHERE s.ID = :sid";
    $stid2 = oci_parse($conn, $query5);
    oci_bind_by_name($stid2, ":sid", $sid);
    $resultquery15 = oci_execute($stid2);
    if (!$resultquery15) {
        $e = oci_error($stid2);
        echo htmlentities($e['message'], ENT_QUOTES);
    }

    // Update CANCELLED_CELLS
    $query13 = "UPDATE CANCELLED_CELLS SET CANCELLED_DATE = :cancelldate WHERE CELL_ID_KEY = :cellidkey AND CELL_CODE = :cellcode";

    $stid33 = oci_parse($conn, $query13);
    oci_bind_by_name($stid33, ":cancelldate", $cancelldate);
    oci_bind_by_name($stid33, ":cellidkey", $cellidkey);
    oci_bind_by_name($stid33, ":cellcode", $cellcode);
    $resultquery13 = oci_execute($stid33);
    if (!$resultquery13) {
        $e = oci_error($stid33);
        echo htmlentities($e['message'], ENT_QUOTES);
    }

    // Update CANCELLED_SITES
    $query14 = "UPDATE CANCELLED_SITES SET CANCELLATION_DATE = :cancelldate, CELL_ID = :cellid, CANCELLED_TECHNOLOGIES = :tech, TWO_G_RBS = :RBS, BAND = :BAND, STATUS_BEFORE = :status, NOTE = :note
    WHERE SITE_ID = :sid AND SITE_CODE = :sitecode";
   

    $resultquery14 = oci_parse($conn, $query14);
    oci_bind_by_name($resultquery14, ":cellid", $cellid);
    oci_bind_by_name($resultquery14, ":tech", $tech);
    oci_bind_by_name($resultquery14, ":cancelldate", $cancelldate);
    oci_bind_by_name($resultquery14, ":RBS", $RBS);
    oci_bind_by_name($resultquery14, ":BAND", $BAND);
    oci_bind_by_name($resultquery14, ":status", $status);
    oci_bind_by_name($resultquery14, ":note", $note);
    oci_bind_by_name($resultquery14, ":sid", $sid);
    oci_bind_by_name($resultquery14, ":sitecode", $sitecode);
    oci_execute($resultquery14);


    $delete = "DELETE FROM TWO_G_SITES WHERE CELL_ID = :cellid AND EXISTS (SELECT 1 FROM TWO_G_CELLS WHERE TWO_G_SITES.CELL_ID = TWO_G_CELLS.CID_KEY)";
    $stid0 = oci_parse($conn, $delete);
    oci_bind_by_name($stid0, ":cellid", $cellid);
    $resultdelete = oci_execute($stid0);
    if ($resultdelete) {
        echo '<script>alert("'.$row["SITE_CODE"].' site and cells deleted Successfully")</script>';
    } else {
        $e = oci_error($stid0);
        echo htmlentities($e['message'], ENT_QUOTES);
    }

}

}
header("Location:Delete_Thankyou.html");

}
?>