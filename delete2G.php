<?php 
include "config.php";
?>
<?php
if(isset($_GET['id12']))
{
$id =$_GET['id12'];

$sql =  "SELECT s.*, t.*       FROM NEW_SITES s INNER JOIN TWO_G_SITES t ON s.ID = t.SITE_ID WHERE t.SITE_ID = :id";
$sqll = "SELECT s.*, t.*, c.*  FROM NEW_SITES s INNER JOIN TWO_G_SITES t ON s.ID = t.SITE_ID JOIN TWO_G_CELLS c ON t.CELL_ID = c.CID_KEY WHERE t.SITE_ID = :id";

$stid1 = oci_parse($conn, $sql);
oci_bind_by_name($stid1, ":id", $id);
oci_execute($stid1);

$stid2 = oci_parse($conn, $sqll);
oci_bind_by_name($stid2, ":id", $id);
oci_execute($stid2);

// Free the statements and close the connection
// oci_free_statement($stid1);
// oci_free_statement($stid2);
// oci_close($conn);

$cancelldate = date("m-d-Y h:i:sa");

if(($row = oci_fetch_array($stid1, OCI_ASSOC)) != false){
    
    $sitecode = $row['SITE_CODE'];
    $query ="INSERT INTO CANCELLED_SITES(SITE_ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, ON_AIR_DATE, COORDINATES_E, COORDINATES_N, SITE_ADRESS)
    SELECT  ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, Site_ON_AIR_DATE ,COORDINATES_E, COORDINATES_N, SITE_ADDRESS  FROM NEW_SITES
    WHERE ID = :id";

    //$resultt1 =  mysqli_query($conn,$query);

    $resultt1 = oci_parse($conn, $query);
    oci_bind_by_name($resultt1, ":id", $id);
    oci_execute($resultt1);

    $query1 = "UPDATE CANCELLED_SITES SET CANCELLATION_DATE =:cancelldate WHERE SITE_ID =:id AND SITE_CODE =:sitecode";
    //$resultt3 =  mysqli_query($conn,$query1);

    $resultt3 = oci_parse($conn, $query1);
    oci_bind_by_name($resultt3, ":id", $id);
    oci_bind_by_name($resultt3, ":cancelldate", $cancelldate);
    oci_bind_by_name($resultt3, ":sitecode", $sitecode);
    oci_execute($resultt3);


}

else {
    echo "Site doesn't Exist!!";
}


if(($row2 = oci_fetch_array($stid2, OCI_ASSOC)) != false){
    $cellid = $row2['CID_KEY'];
    $BAND   = $row2['BAND'];
    $status = $row2['SITE_STATUS'];
    $note   = $row2['NOTES'];
    $cellcode = $row2['CELL_CODE'];
    $sitecode = $row2['SITE_CODE'];
   
    if(isset($row2['NINTY_GSM_RBS_TYPE'])){
       $RBS =$row2['NINTY_GSM_RBS_TYPE'];
    }
   else {
       //$RBS =$row2['EIGHTY_GSM_RBS_TYPE'];
   }
   $tech = "2G";
   
   $query2 ="INSERT INTO CANCELLED_CELLS(CELL_ID_KEY, CELL_CODE, CELL_NAME, CELL_ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, BSC, ON_AIR_DATE, NOTE, SERVING_AREA, SERVING_AREA_IN_ENGLISH)
   SELECT c.CID_KEY, c.CELL_CODE, c.CELL_NAME, c.CELL_ID, s.SITE_CODE, s.SITE_NAME, s.ZONE, s.PROVINCE, s.CR, s.SUPPLIER, s.BSC, c.Cell_ON_AIR_DATE, c.NOTE ,c.SERVING_AREA, c.SERVING_AREA_IN_ENGLISH FROM NEW_SITES s INNER JOIN TWO_G_SITES t ON(s.ID = t.SITE_ID) JOIN TWO_G_CELLS c ON (t.CELL_ID = c.CID_KEY)
   WHERE (c.CID_KEY = :cellid AND s.ID = :id )";
   
   $resultquery2= oci_parse($conn, $query2);
   oci_bind_by_name($resultquery2, ":id", $id);
   oci_bind_by_name($resultquery2, ":cellid", $cellid);
   oci_execute($resultquery2);

   $query3 = "UPDATE CANCELLED_CELLS SET CANCELLED_DATE =:cancelldate WHERE CELL_ID_KEY =:cellid AND CELL_CODE =:cellcode";
 
   $resultquery3 = oci_parse($conn, $query3);
   oci_bind_by_name($resultquery3, ":cellid", $cellid);
   oci_bind_by_name($resultquery3, ":cancelldate", $cancelldate);
   oci_bind_by_name($resultquery3, ":cellcode", $cellcode);
   oci_execute($resultquery3);
   
   $query4 = "UPDATE CANCELLED_SITES SET CANCELLATION_DATE =:cancelldate, CELL_ID =:cellid, CANCELLED_TECHNOLOGIES =:tech, TWO_G_RBS =:RBS, BAND =:BAND, STATUS_BEFORE =:status ,NOTE =:note  WHERE SITE_ID =:id AND SITE_CODE =:sitecode";
  
   $resultquery4 = oci_parse($conn, $query4);
   oci_bind_by_name($resultquery4, ":cellid", $cellid);
   oci_bind_by_name($resultquery4, ":tech", $tech);
   oci_bind_by_name($resultquery4, ":cancelldate", $cancelldate);
   oci_bind_by_name($resultquery4, ":RBS", $RBS);
   oci_bind_by_name($resultquery4, ":BAND", $BAND);
   oci_bind_by_name($resultquery4, ":status", $status);
   oci_bind_by_name($resultquery4, ":note", $note);
   oci_bind_by_name($resultquery4, ":id", $id);
   oci_bind_by_name($resultquery4, ":sitecode", $sitecode);
   oci_execute($resultquery4);

   
   }

   else {
    echo "No 2G Site found!!";
   }
   /*$queryy = "SELECT `CANCELLED_TECHNOLOGIES` FROM CANCELLED_SITES WHERE SITE_ID= '$id'";
   $resultqueryy = mysqli_query($conn,$queryy);
   $roww = mysqli_fetch_assoc($resultqueryy);
  
   if ($roww['CANCELLED_TECHNOLOGIES'] == ''){
    $tech = "2G";
       $insert = "INSERT INTO CANCELLED_SITES(`CANCELLED_TECHNOLOGIES`) VALUES '$tech' WHERE SITE_ID= '$id' ";
       $res = mysqli_query($conn, $insert);
       }
   elseif($roww['CANCELLED_TECHNOLOGIES'] == '3G') {
    $tech = "2G/3G";
      $update = "UPDATE CANCELLED_SITES SET  `CANCELLED_TECHNOLOGIES`='$tech' WHERE  SITE_ID= '$id' "; 
      $res = mysqli_query($conn, $updated);
   }
   elseif($roww['CANCELLED_TECHNOLOGIES'] == '4G') {
    $tech = "2G/4G";
      $update1 = "UPDATE CANCELLED_SITES SET  `CANCELLED_TECHNOLOGIES`='$tech' WHERE  SITE_ID= '$id' ";
      $res1 = mysqli_query($conn, $updated1);
   }
   elseif($roww['CANCELLED_TECHNOLOGIES'] == '3G/4G') {
    $tech = "All";
     $updated1 = "UPDATE CANCELLED_SITES SET  `CANCELLED_TECHNOLOGIES`='$tech' WHERE  SITE_ID= '$id'";
     $res1 = mysqli_query($conn, $updated1);
  }


   $delete = "DELETE TWO_G_SITES, TWO_G_CELLS FROM TWO_G_SITES INNER JOIN TWO_G_CELLS ON (TWO_G_SITES.CELL_ID = TWO_G_CELLS.CID_KEY) WHERE TWO_G_SITES.CELL_ID = '$id'";
   $resultdelete = mysqli_query($conn, $delete);
*/



// Delete from TWO_G_CELLS
$delete1 = "DELETE FROM TWO_G_CELLS WHERE CID_KEY IN (SELECT CELL_ID FROM TWO_G_SITES WHERE CELL_ID = :id)";
$stid11 = oci_parse($conn, $delete1);
oci_bind_by_name($stid11, ":id", $id);
$resultdelete1 = oci_execute($stid11);
if (!$resultdelete1) {
    $e = oci_error($stid11);
    echo htmlentities($e['message'], ENT_QUOTES);
}

// Delete from TWO_G_SITES
$delete2 = "DELETE FROM TWO_G_SITES WHERE CELL_ID = :id";
$stid22 = oci_parse($conn, $delete2);
oci_bind_by_name($stid22, ":id", $id);
$resultdelete2 = oci_execute($stid22);
if (!$resultdelete2) {
    $e = oci_error($stid22);
    echo htmlentities($e['message'], ENT_QUOTES);
}
echo '<script>alert("'.$row["SITE_CODE"].' site and cells deleted Successfully")</script>';   
// Free the statements and close the connection
if ($stid11) oci_free_statement($stid11);
if ($stid22) oci_free_statement($stid22);
oci_close($conn);




// Prepare and execute the first query
$sql1 = "SELECT * FROM THREE_G_SITES t JOIN THREE_G_CELLS c ON t.CELL_ID = c.CID WHERE t.SITE_ID = :id";
$stmt = oci_parse($conn, $sql1);
oci_bind_by_name($stmt, ":id", $id);
oci_execute($stmt);

// Count the number of rows for the first query
$num1 = 0;
while (($row11 = oci_fetch_array($stmt, OCI_ASSOC)) != false) {
    $num1++;
}

// Prepare and execute the second query
$sql2 = "SELECT * FROM FOUR_G_SITES t JOIN FOUR_G_CELLS c ON t.CELL_ID_KEY = c.CID_KEY WHERE t.SID = :id";
$stmt1 = oci_parse($conn, $sql2);
oci_bind_by_name($stmt1, ":id", $id);
oci_execute($stmt1);

// Count the number of rows for the second query
$num2 = 0;
if (($row22 = oci_fetch_array($stmt1, OCI_ASSOC)) != false) {
    $num2++;
    //$sitecode1 = $row['SITE_CODE'];
}

// If both queries return 0 rows, update and delete as needed
if ($num1 == 0 && $num2 == 0) {
    $tech1 = "All";

    // Assuming $sitecode1 is fetched from a previous operation
    $sitecode1 = $row['SITE_CODE'];
    echo '<script>alert("'.$sitecode1.' site will be cancelled")</script>';

    // Prepare and execute the update query
    $updatetech = "UPDATE CANCELLED_SITES SET CANCELLED_TECHNOLOGIES = :tech WHERE SITE_ID = :id AND SITE_CODE = :sitecode";
    $stid3 = oci_parse($conn, $updatetech);
    oci_bind_by_name($stid3, ":tech", $tech1);
    oci_bind_by_name($stid3, ":id", $id);
    oci_bind_by_name($stid3, ":sitecode", $sitecode1);
    $resupd = oci_execute($stid3);
    if (!$resupd) {
        $e = oci_error($stid3);
        echo htmlentities($e['message'], ENT_QUOTES);
    }

    // Prepare and execute the delete query
    $delete4 = "DELETE FROM NEW_SITES WHERE ID = :id";
    $stid4 = oci_parse($conn, $delete4);
    oci_bind_by_name($stid4, ":id", $id);
    $resultdelete4 = oci_execute($stid4);
    if (!$resultdelete4) {
        $e = oci_error($stid4);
        echo htmlentities($e['message'], ENT_QUOTES);
    }

    // Free the statements
    if ($stid3) oci_free_statement($stid3);
    if ($stid4) oci_free_statement($stid4);
}

// Free the statements and close the connection
if ($stmt) oci_free_statement($stmt);
if ($stmt1) oci_free_statement($stmt1);
oci_close($conn);


header("Location:Delete_Thankyou.html");

}

?>