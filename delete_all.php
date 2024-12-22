<?php 
include "config.php";
?>
<?php
//NOTE: join this table with other and with newsite table on site code to restore it when it neccessary
if(isset($_GET['id2']))
{
$id =$_GET['id2'];
$sqll = "SELECT *                FROM NEW_SITES    WHERE ID = :id";
$sqll2= "SELECT s.*, t.* , c.*   FROM NEW_SITES s INNER JOIN TWO_G_SITES t   ON(s.ID = t.SITE_ID)   JOIN TWO_G_CELLS c   ON (t.CELL_ID = c.CID_KEY)       WHERE s.ID = :id";
$sqll3= "SELECT s.*, t.* , c.*   FROM NEW_SITES s INNER JOIN THREE_G_SITES t ON(s.ID = t.SITE_ID)   JOIN THREE_G_CELLS c ON (t.CELL_ID = c.CID)           WHERE s.ID = :id";
$sqll4= "SELECT s.*, t.* , c.*   FROM NEW_SITES s INNER JOIN FOUR_G_SITES t  ON(s.ID = t.SID)       JOIN FOUR_G_CELLS c   ON (t.CELL_ID_KEY = c.CID_KEY)  WHERE s.ID = :id";



$resultt = oci_parse($conn,$sqll);
oci_bind_by_name($resultt ,':id' ,$id);
oci_execute($resultt);

$resultsqll2 = oci_parse($conn,$sqll2);
oci_bind_by_name($resultsqll2 ,':id' ,$id);
oci_execute($resultsqll2);

$resultsqll3 = oci_parse($conn,$sqll3);
oci_bind_by_name($resultsqll3 ,':id' ,$id);
oci_execute($resultsqll3);

$resultsqll4 = oci_parse($conn,$sqll4);
oci_bind_by_name($resultsqll4 ,':id' ,$id);
oci_execute($resultsqll4);


$cancelldate = date("m-d-Y");

if($row = oci_fetch_array($resultt  , OCI_ASSOC + OCI_RETURN_NULLS)){
echo $row['SITE_CODE'];


// Prepare the query
$query = "INSERT INTO CANCELLED_SITES (SITE_ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, ON_AIR_DATE, COORDINATES_E, COORDINATES_N, SITE_ADRESS)
SELECT ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, SITE_ON_AIR_DATE, COORDINATES_E, COORDINATES_N, SITE_ADDRESS
FROM NEW_SITES
WHERE ID = :id";

// Parse the query
$stid = oci_parse($conn, $query);

// Bind the variable
oci_bind_by_name($stid, ":id", $id);

// Execute the query
$resultt1 = oci_execute($stid);

if (!$resultt1) {
    $e = oci_error($stid);
    echo htmlentities($e['message'], ENT_QUOTES);
}

// Free the statement and close the connection
oci_free_statement($stid);
oci_close($conn);





$query1 = "UPDATE CANCELLED_SITES SET CANCELLATION_DATE= :cancelldate WHERE SITE_ID = :id";
$std =  oci_parse($conn, $query1);
oci_bind_by_name($std, ":id", $id);
oci_bind_by_name($std, ":cancelldate", $cancelldate);
$resultt3 = oci_execute($std);
if (!$resultt3) {
    $e = oci_error($resultt3);
    echo htmlentities($e['message'], ENT_QUOTES);
}

// Free the statement and close the connection
oci_free_statement($std);
oci_close($conn);

}

else {
    echo "Site doesn't Exist!!";
}

if($row2 = oci_fetch_array($resultsqll2  , OCI_ASSOC + OCI_RETURN_NULLS)){
 $cellid = $row2['CID_KEY'];
 $BAND   = $row2['BAND'];
 $status = $row2['SITE_STATUS'];
 $note   = $row2['NOTES'];

 if(isset($row2['NINTY_GSM_RBS_TYPE'])){
    $RBS =$row2['NINTY_GSM_RBS_TYPE'];
 }
else {
    //$RBS =$row2['EIGHTY_GSM_RBS_TYPE'];
}



// Prepare the query
$query2 = "INSERT INTO CANCELLED_CELLS (CELL_ID_KEY, CELL_CODE, CELL_NAME, CELL_ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, BSC, ON_AIR_DATE, NOTE, SERVING_AREA, SERVING_AREA_IN_ENGLISH)
SELECT c.CID_KEY, c.CELL_CODE, c.CELL_NAME, c.CELL_ID, s.SITE_CODE, s.SITE_NAME, s.ZONE, s.PROVINCE, s.CR, s.SUPPLIER, s.BSC, c.CELL_ON_AIR_DATE, c.NOTE, c.SERVING_AREA, c.SERVING_AREA_IN_ENGLISH
FROM NEW_SITES s
INNER JOIN TWO_G_SITES t ON s.ID = t.SITE_ID
JOIN TWO_G_CELLS c ON t.Cell_ID = c.CID_KEY
WHERE c.CID_KEY = :cellid AND s.ID = :id";

// Parse the query
$stid11 = oci_parse($conn, $query2);

// Bind the variables
oci_bind_by_name($stid11, ":cellid", $cellid);
oci_bind_by_name($stid11, ":id", $id);

// Execute the query
$resultquery2 = oci_execute($stid11);

if (!$resultquery2) {
    $e = oci_error($stid11);
    echo htmlentities($e['message'], ENT_QUOTES);
}

// Free the statement and close the connection
oci_free_statement($stid11);
oci_close($conn);




$query3 = "UPDATE CANCELLED_CELLS SET CANCELLED_DATE =:cancelldate WHERE CELL_ID_KEY= :cellid";
$resultquery3= oci_parse($conn,$query3);
oci_bind_by_name($resultquery3, ":cancelldate", $cancelldate);
oci_bind_by_name($resultquery3, ":cellid", $cellid);

$resultquery33 = oci_execute($resultquery3);

$username = "C##Hadeel";
$password = "MTN";
$connection_string = "//localhost/XE"; // Change XE if your SID is different

// Connect to Oracle
$conn = oci_connect($username, $password, $connection_string);

if (!$conn) {
    $e = oci_error();
    die("Connection failed: " . $e['message']);
}
else {
    //echo"connect Successfully";
}


$query4 = "UPDATE CANCELLED_SITES SET CANCELLATION_DATE =:cancelldate, CELL_ID =:cellid, TWO_G_RBS =:RBS, BAND =:BAND, STATUS_BEFORE =:status, NOTE =:note
 WHERE SITE_ID= :id";
$resultquery4= oci_parse($conn,$query4);

oci_bind_by_name($resultquery4, ":cancelldate", $cancelldate);
oci_bind_by_name($resultquery4, ":cellid", $cellid);
oci_bind_by_name($resultquery4, ":RBS", $RBS);
oci_bind_by_name($resultquery4, ":BAND", $BAND);
oci_bind_by_name($resultquery4, ":status", $status);
oci_bind_by_name($resultquery4, ":note", $note);
oci_bind_by_name($resultquery4, ":id", $id);

$resultquery44 = oci_execute($resultquery4);
if (!$resultquery4) {
    $e = oci_error($resultquery44);
    echo htmlentities($e['message'], ENT_QUOTES);
}
oci_free_statement($resultquery4);
oci_close($conn);

}
else {

echo "No 2G Site found!!";
}



if($row3 = oci_fetch_array($resultsqll3  , OCI_ASSOC + OCI_RETURN_NULLS)){
    $cellid= $row3['CID'];

// Prepare the query
$query = "INSERT INTO CANCELLED_SITES (SITE_ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, STATUS_BEFORE, ON_AIR_DATE, NOTE, COORDINATES_E, COORDINATES_N, SITE_ADRESS, TWO_G_RBS)
SELECT s.ID, t.SITE_CODE, s.SITE_NAME, s.ZONE, s.PROVINCE, s.CR, s.SUPPLIER, t.SITE_STATUS, t.THREE_G_ON_AIR_DATE, t.NOTES, s.COORDINATES_E, s.COORDINATES_N, s.SITE_ADDRESS, t.REAL_RNC
FROM NEW_SITES s
INNER JOIN THREE_G_SITES t ON s.ID = t.SITE_ID
WHERE s.ID = :id";

$stid88 = oci_parse($conn, $query);

oci_bind_by_name($stid88, ":id", $id);

$resultquery = oci_execute($stid88);

if (!$resultquery) {
    $e = oci_error($stid88);
    echo htmlentities($e['message'], ENT_QUOTES);
}

oci_free_statement($stid88);
//oci_close($conn);

// Prepare and execute the INSERT query
$query2 = "INSERT INTO CANCELLED_CELLS (CELL_ID_KEY, CELL_CODE, CELL_NAME, CELL_ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, BSC, ON_AIR_DATE, NOTE, SERVING_AREA, SERVING_AREA_IN_ENGLISH)
SELECT c.CID, c.CELL_CODE, c.CELL_NAME, c.CELL_ID, t.SITE_CODE, s.SITE_NAME, s.ZONE, s.PROVINCE, s.CR, s.SUPPLIER, s.BSC, c.ON_AIR_DATE, c.NOTE, c.SERVING_AREA, c.SERVING_AREA_IN_ENGLISH
FROM NEW_SITES s
INNER JOIN THREE_G_SITES t ON s.ID = t.SITE_ID
INNER JOIN THREE_G_CELLS c ON t.CELL_ID = c.CID
WHERE c.CID = :cellid AND s.ID = :id";
$stid2 = oci_parse($conn, $query2);
oci_bind_by_name($stid2, ":cellid", $cellid);
oci_bind_by_name($stid2, ":id", $id);
$resultquery12 = oci_execute($stid2);
if (!$resultquery12) {
    $e = oci_error($stid2);
    echo htmlentities($e['message'], ENT_QUOTES);
}

// Prepare and execute the first UPDATE query
$query3 = "UPDATE CANCELLED_CELLS SET CANCELLED_DATE = :cancelldate WHERE CELL_ID_KEY = :cellid";
$stid3 = oci_parse($conn, $query3);
oci_bind_by_name($stid3, ":cancelldate", $cancelldate);
oci_bind_by_name($stid3, ":cellid", $cellid);
$resultquery3 = oci_execute($stid3);
if (!$resultquery3) {
    $e = oci_error($stid3);
    echo htmlentities($e['message'], ENT_QUOTES);
}

// Prepare and execute the second UPDATE query
$query4 = "UPDATE CANCELLED_SITES SET CANCELLATION_DATE = :cancelldate, CELL_ID = :cellid WHERE SITE_ID = :id";
$stid4 = oci_parse($conn, $query4);
oci_bind_by_name($stid4, ":cancelldate", $cancelldate);
oci_bind_by_name($stid4, ":cellid", $cellid);
oci_bind_by_name($stid4, ":id", $id);
$resultquery4 = oci_execute($stid4);
if (!$resultquery4) {
    $e = oci_error($stid4);
    echo htmlentities($e['message'], ENT_QUOTES);
}

// Free the statements and close the connection
oci_free_statement($stid2);
oci_free_statement($stid3);
oci_free_statement($stid4);
oci_close($conn);


   
   }
   else {

    echo "No 3G Site found!!";
    }




   if($row4 = oci_fetch_array($resultsqll4  , OCI_ASSOC + OCI_RETURN_NULLS)){
    $cellid= $row4['CID_KEY'];

$query = "INSERT INTO CANCELLED_SITES (SITE_ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, STATUS_BEFORE, ON_AIR_DATE, NOTE, COORDINATES_E, COORDINATES_N, SITE_ADRESS)
SELECT s.ID, t.SITE_CODE, s.SITE_NAME, s.ZONE, s.PROVINCE, s.CR, s.SUPPLIER, t.Status, t.Activation_Date, t.NOTE, s.COORDINATES_E, s.COORDINATES_N, s.SITE_ADDRESS
FROM NEW_SITES s
INNER JOIN FOUR_G_SITES t ON s.ID = t.SID
WHERE s.ID = :id";
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ":id", $id);
$resultquery = oci_execute($stid);
if (!$resultquery) {
    $e = oci_error($stid);
    echo htmlentities($e['message'], ENT_QUOTES);
}

$query22 = "INSERT INTO CANCELLED_CELLS (CELL_ID_KEY, CELL_CODE, CELL_NAME, CELL_ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, BSC, ON_AIR_DATE, NOTE, SERVING_AREA, SERVING_AREA_IN_ENGLISH)
SELECT c.CID_KEY, c.CELL_CODE, c.CELL_NAME, c.CELL_ID, t.SITE_CODE, s.SITE_NAME, s.ZONE, s.PROVINCE, s.CR, s.SUPPLIER, s.BSC, c.ON_AIR_DATE, c.NOTES, c.SERVING_AREA, c.SERVING_AREA_IN_ENGLISH
FROM NEW_SITES s
INNER JOIN FOUR_G_SITES t ON s.ID = t.SID
INNER JOIN FOUR_G_CELLS c ON t.CELL_ID_KEY = c.CID_KEY
WHERE c.CID_KEY = :cellid AND s.ID = :id";
$stid22 = oci_parse($conn, $query22);
oci_bind_by_name($stid22, ":cellid", $cellid);
oci_bind_by_name($stid22, ":id", $id);
$resultquery22 = oci_execute($stid22);
if (!$resultquery22) {
    $e = oci_error($stid22);
    echo htmlentities($e['message'], ENT_QUOTES);
}


$query3 = "UPDATE CANCELLED_CELLS SET CANCELLED_DATE = :cancelldate WHERE CELL_ID_KEY = :cellid";
$stid3 = oci_parse($conn, $query3);
oci_bind_by_name($stid3, ":cancelldate", $cancelldate);
oci_bind_by_name($stid3, ":cellid", $cellid);
$resultquery3 = oci_execute($stid3);
if (!$resultquery3) {
    $e = oci_error($stid3);
    echo htmlentities($e['message'], ENT_QUOTES);
}

$query4 = "UPDATE CANCELLED_SITES SET CANCELLATION_DATE = :cancelldate, CELL_ID = :cellid WHERE SITE_ID = :id";
$stid4 = oci_parse($conn, $query4);
oci_bind_by_name($stid4, ":cancelldate", $cancelldate);
oci_bind_by_name($stid4, ":cellid", $cellid);
oci_bind_by_name($stid4, ":id", $id);
$resultquery4 = oci_execute($stid4);
if (!$resultquery4) {
    $e = oci_error($stid4);
    echo htmlentities($e['message'], ENT_QUOTES);
}


oci_free_statement($stid);
oci_free_statement($stid22);
oci_free_statement($stid3);
oci_free_statement($stid4);
oci_close($conn);





   }
   else {

    echo "No 4G Site found!!";
    }
    // $queryy = "SELECT `CANCELLED_TECHNOLOGIES` FROM CANCELLED_SITES WHERE SITE_ID= '$id'";
    // $resultqueryy = mysqli_query($conn,$queryy);


$queryy = "SELECT CANCELLED_TECHNOLOGIES FROM CANCELLED_SITES WHERE SITE_ID = :id";

$stid = oci_parse($conn, $queryy);
oci_bind_by_name($stid, ":id", $id);


oci_execute($stid);


    $tech = "All";

//if ($resultqueryy == ''){
  if(oci_fetch_array($stid, OCI_ASSOC) == ''){
     
    $update = "UPDATE CANCELLED_SITES SET CANCELLED_TECHNOLOGIES = :tech WHERE SITE_ID = :id";
    
   
    $stmt = oci_parse($conn, $update);
    
  
    oci_bind_by_name($stmt, ':tech', $tech);
    oci_bind_by_name($stmt, ':id', $id);

    $resultUpdate = oci_execute($stmt);
    


    
    }
else {
   $update = "UPDATE CANCELLED_SITES SET  CANCELLED_TECHNOLOGIES='$tech' WHERE  SITE_ID= '$id' "; 
}

// $delete1 = "DELETE FOUR_G_SITES, FOUR_G_CELLS FROM FOUR_G_SITES INNER JOIN FOUR_G_CELLS ON (FOUR_G_SITES.CELL_ID_KEY = FOUR_G_CELLS.CID_KEY) WHERE FOUR_G_SITES.CELL_ID_KEY = '$id'";
// $resultdelete1 = mysqli_query($conn, $delete1);


// $delete2 = "DELETE THREE_G_SITES, THREE_G_CELLS FROM THREE_G_SITES INNER JOIN THREE_G_CELLS ON (THREE_G_SITES.CELL_ID = THREE_G_CELLS.CID) WHERE THREE_G_SITES.CELL_ID = '$id'";
// $resultdelete2 = mysqli_query($conn, $delete2);

// $delete3 = "DELETE TWO_G_SITES, TWO_G_CELLS FROM TWO_G_SITES INNER JOIN TWO_G_CELLS ON (TWO_G_SITES.CELL_ID = TWO_G_CELLS.CID_KEY) WHERE TWO_G_SITES.CELL_ID = '$id'";
// $resultdelete3 = mysqli_query($conn, $delete3);

// $delete4 = "DELETE FROM NEW_SITES  WHERE ID = '$id'";
// $resultdelete3 = mysqli_query($conn, $delete4);



$delete1a = "DELETE FROM FOUR_G_CELLS WHERE CID_KEY = :id";
$stid1a = oci_parse($conn, $delete1a);
oci_bind_by_name($stid1a, ":id", $id);
$resultdelete1a = oci_execute($stid1a);
if (!$resultdelete1a) {
    $e = oci_error($stid1a);
    echo htmlentities($e['message'], ENT_QUOTES);
}

$delete1b = "DELETE FROM FOUR_G_SITES WHERE CELL_ID_KEY = :id";
$stid1b = oci_parse($conn, $delete1b);
oci_bind_by_name($stid1b, ":id", $id);
$resultdelete1b = oci_execute($stid1b);
if (!$resultdelete1b) {
    $e = oci_error($stid1b);
    echo htmlentities($e['message'], ENT_QUOTES);
}

$delete2a = "DELETE FROM THREE_G_CELLS WHERE CID = :id";
$stid2a = oci_parse($conn, $delete2a);
oci_bind_by_name($stid2a, ":id", $id);
$resultdelete2a = oci_execute($stid2a);
if (!$resultdelete2a) {
    $e = oci_error($stid2a);
    echo htmlentities($e['message'], ENT_QUOTES);
}

$delete2b = "DELETE FROM THREE_G_SITES WHERE CELL_ID = :id";
$stid2b = oci_parse($conn, $delete2b);
oci_bind_by_name($stid2b, ":id", $id);
$resultdelete2b = oci_execute($stid2b);
if (!$resultdelete2b) {
    $e = oci_error($stid2b);
    echo htmlentities($e['message'], ENT_QUOTES);
}

$delete3a = "DELETE FROM TWO_G_CELLS WHERE CID_KEY = :id";
$stid3a = oci_parse($conn, $delete3a);
oci_bind_by_name($stid3a, ":id", $id);
$resultdelete3a = oci_execute($stid3a);
if (!$resultdelete3a) {
    $e = oci_error($stid3a);
    echo htmlentities($e['message'], ENT_QUOTES);
}

$delete3b = "DELETE FROM TWO_G_SITES WHERE CELL_ID = :id";
$stid3b = oci_parse($conn, $delete3b);
oci_bind_by_name($stid3b, ":id", $id);
$resultdelete3b = oci_execute($stid3b);
if (!$resultdelete3b) {
    $e = oci_error($stid3b);
    echo htmlentities($e['message'], ENT_QUOTES);
}

$delete4 = "DELETE FROM NEW_SITES WHERE ID = :id";
$stid4 = oci_parse($conn, $delete4);
oci_bind_by_name($stid4, ":id", $id);
$resultdelete4 = oci_execute($stid4);
if (!$resultdelete4) {
    $e = oci_error($stid4);
    echo htmlentities($e['message'], ENT_QUOTES);
}

oci_free_statement($stid1a);
oci_free_statement($stid1b);
oci_free_statement($stid2a);
oci_free_statement($stid2b);
oci_free_statement($stid3a);
oci_free_statement($stid3b);
oci_free_statement($stid4);
oci_close($conn);


header("Location:Delete_Thankyou.html");


}