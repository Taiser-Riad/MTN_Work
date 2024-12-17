<?php 
include "config.php";
?>
<?php
//Note: join this table with other and with newsite table on site code to restore it when it neccessary
if(isset($_GET['id2']))
{
$id =$_GET['id2'];
$sqll = "SELECT *                FROM NEW_SITES    WHERE ID = ':id'";
$sqll2= "SELECT s.*, t.* , c.*   FROM NEW_SITES s INNER JOIN TWO_G_SITES t   ON(s.ID = t.Site_ID)   JOIN TWO_G_CELLS c   ON (t.CELL_ID = c.CID_KEY)       WHERE s.ID = ':id'";
$sqll3= "SELECT s.*, t.* , c.*   FROM NEW_SITES s INNER JOIN THREE_G_SITES t ON(s.ID = t.Site_ID)   JOIN THREE_G_CELLS c ON (t.CELL_ID = c.CID)           WHERE s.ID = ':id'";
$sqll4= "SELECT s.*, t.* , c.*   FROM NEW_SITES s INNER JOIN FOUR_G_SITES t  ON(s.ID = t.SID)       JOIN FOUR_G_CELLSc   ON (t.CELL_ID_KEY = c.CID_KEY)   WHERE s.ID = ':id'";


$resultt     = mysqli_query($conn,$sqll);
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
SELECT SITE_ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, ON_AIR_DATE, COORDINATES_E, COORDINATES_N, SITE_ADRESS
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





$query1 = "UPDATE `CANCELLED_SITES` SET `CANCELLATION_DATE`= :cancelldate WHERE Site_ID = :id";
$std =  oci_parse($conn, $query1);
oci_bind_by_name($resultt3, ":id", $id);
$resultt3 = oci_execute($resultt3);
if (!$resultt3) {
    $e = oci_error($re);
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
 $band   = $row2['BAND'];
 $status = $row2['SITE_STATUS'];
 $note   = $row2['NOTES'];

 if(isset($row2['NINTY_GSM_RBS_TYPE'])){
    $RBS =$row2['NINTY_GSM_RBS_TYPE'];
 }
else {
    $RBS =$row2['EIGHTY_GSM_RBS_TYPE'];
}



// Prepare the query
$query2 = "INSERT INTO CANCELLED_CELLS (CELL_ID_KEY, CELL_CODE, CELL_NAME, CELL_ID, STIE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, BSC, ON_AIR_DATE, NOTE, SERVING_AREA, SERVING_AREA_IN_ENGLISH)
SELECT c.CID_KEY, c.CELL_CODE, c.CELL_NAME, c.CELL_ID, s.STIE_CODE, s.SITE_NAME, s.ZONE, s.PROVINCE, s.CR, s.SUPPLIER, s.BSC, c.CELL_ON_AIR_DATE, c.NOTE, c.SERVING_AREA, c.SERVING_AREA_IN_ENGLISH
FROM NEW_SITES s
INNER JOIN TWO_G_SITES t ON s.ID = t.SITE_ID
JOIN TWO_G_CELLS c ON t.Cell_ID = c.CID_KEY
WHERE c.CID_KEY = :cellid AND s.ID = :id";

// Parse the query
$stid = oci_parse($conn, $query2);

// Bind the variables
oci_bind_by_name($stid, ":cellid", $cellid);
oci_bind_by_name($stid, ":id", $id);

// Execute the query
$resultquery2 = oci_execute($stid);

if (!$resultquery2) {
    $e = oci_error($stid);
    echo htmlentities($e['message'], ENT_QUOTES);
}

// Free the statement and close the connection
oci_free_statement($stid);
oci_close($conn);




$query3 = "UPDATE `cancelled_cells` SET `Cancelled_Date`= '$cancelldate' WHERE Cell_ID_KEY= '$cellid'";
$resultquery3= mysqli_query($conn,$query3);

$query4 = "UPDATE `cancelled_sites` SET `Cancellation_Date`= '$cancelldate',`Cell_ID`= '$cellid' , 2G_RBS= '$RBS', Band = '$band', Status_Before = '$status',Note = '$note' WHERE Site_ID= '$id'";
$resultquery4= mysqli_query($conn,$query4);

}
else {

echo "No 2G Site found!!";
}



if($row3 = oci_fetch_array($resultsqll3  , OCI_ASSOC + OCI_RETURN_NULLS)){
    $cellid= $row3['CID'];

    $query ="INSERT INTO `cancelled_sites`(Site_ID, Site_Code, Site_Name, Zone, Province, CR, Supplier,  Status_Before, On_Air_Date, Note, Coordinates_E, Coordinates_N, Site_Adress, 2G_RBS)
    SELECT  s.ID, t.Site_code, s.Site_Name,s.Zone, s.Province, s.CR, s.Supplier, t.Site_Status, t.3GOn_Air_Date, t.Notes ,s.Coordinates_E, s.Coordinates_N, s.Site_Adress ,t.Real_RNC FROM NEW_SITES s INNER JOIN THREE_G_SITES t ON(s.ID = t.Site_ID)
    WHERE s.ID = '$id'";
   
   $resultquery= mysqli_query($conn,$query);
   
   $query2 ="INSERT INTO `cancelled_cells`(Cell_ID_KEY, Cell_Code, Cell_Name, Cell_ID, Site_code, Site_name, Zone, Province, CR, Supplier, BSC, On_air_Date, Note, Serving_Area, serving_Area_IN_English)
   SELECT c.CID, c.Cell_Code, c.Cell_Name, c.Cell_ID, t.Site_code, s.Site_Name, s.Zone, s.Province, s.CR, s.Supplier, s.BSC, c.On_Air_Date, c.Note ,c.Serving_Area, c.Serving_area_In_English FROM NEW_SITES s INNER JOIN THREE_G_SITES t ON(s.ID = t.Site_ID) INNER JOIN THREE_G_CELLS c ON (t.Cell_ID = c.CID)
   WHERE (c.CID = '$cellid' AND s.ID = '$id')";
   
   $resultquery12= mysqli_query($conn,$query2);
   
   $query3 =  "UPDATE `cancelled_cells` SET `Cancelled_Date`= '$cancelldate' WHERE Cell_ID_KEY= '$cellid'";
   $resultquery3= mysqli_query($conn,$query3);

   $query4 = "UPDATE `cancelled_sites` SET `Cancellation_Date`= '$cancelldate' ,`Cell_ID`= '$cellid' WHERE Site_ID= '$id'";
   $resultquery4= mysqli_query($conn, $query4);


   
   }
   else {

    echo "No 3G Site found!!";
    }




   if($row4 = oci_fetch_array($resultsqll4  , OCI_ASSOC + OCI_RETURN_NULLS)){
    $cellid= $row4['CID_Key'];

    $query ="INSERT INTO `cancelled_sites`(Site_ID, Site_Code, Site_Name, Zone, Province, CR, Supplier,  Status_Before, On_Air_Date, Note, Coordinates_E, Coordinates_N, Site_Adress)
    SELECT  s.ID, t.Site_code, s.Site_Name,s.Zone, s.Province, s.CR, s.Supplier, t.Status, t.Activation_Date, t.Note ,s.Coordinates_E, s.Coordinates_N, s.Site_Adress FROM NEW_SITES s INNER JOIN FOUR_G_SITES t ON(s.ID = t.SID)
    WHERE s.ID = '$id'";
   
   $resultquery= mysqli_query($conn,$query);

   $query22 ="INSERT INTO `cancelled_cells`(Cell_ID_KEY, Cell_Code, Cell_Name, Cell_ID, Site_code, Site_name, Zone, Province, CR, Supplier, BSC, On_air_Date, Note, Serving_Area, serving_Area_IN_English)
    SELECT c.CID_Key, c.Cell_code, c.Cell_Name, c.Cell_ID, t.Site_code, s.Site_Name, s.Zone, s.Province, s.CR, s.Supplier, s.BSC, c.On_Air_Date, c.Notes ,c.Serving_Area, c.serving_Area_IN_English FROM NEW_SITES s INNER JOIN FOUR_G_SITES t ON(s.ID = t.SID) INNER JOIN FOUR_G_CELLSc ON (t.Cell_ID_KEY = c.CID_Key)
   WHERE (c.CID_Key = '$cellid' AND s.ID = '$id')";
   
  
   $resultquery22= mysqli_query($conn,$query22);
   
   $query3  = "UPDATE `cancelled_cells` SET `Cancelled_Date`= '$cancelldate' WHERE Cell_ID_KEY= '$cellid'";
   $resultquery3= mysqli_query($conn,$query3);

   $query4 = "UPDATE `cancelled_sites` SET `Cancellation_Date`= '$cancelldate' ,`Cell_ID`= '$cellid' WHERE Site_ID= '$id'";
   $resultquery4= mysqli_query($conn, $query4);



   }
   else {

    echo "No 4G Site found!!";
    }
    $queryy = "SELECT `Cancelled_Technologies` FROM `cancelled_sites` WHERE Site_ID= '$id'";
    $resultqueryy = mysqli_query($conn,$queryy);

    $tech = "All";
if ($resultqueryy == ''){
   
    $insert = "INSERT INTO `cancelled_sites`(`Cancelled_Technologies`) VALUES ('$tech') WHERE Site_ID= '$id' ";
    $res = mysqli_query($conn, $insert);
    }
else {
   $update = "UPDATE `cancelled_sites` SET  `Cancelled_Technologies`='$tech' WHERE  Site_ID= '$id' "; 
}

$delete1 = "DELETE FOUR_G_SITES, FOUR_G_CELLSFROM FOUR_G_SITES INNER JOIN FOUR_G_CELELLON (FOUR_G_SITES.Cell_ID_KEY = 4gcells.CID_Key) WHERE FOUR_G_SITES.Cell_ID_KEY = '$id'";
$resultdelete1 = mysqli_query($conn, $delete1);


$delete2 = "DELETE THREE_G_SITES, THREE_G_CELLS FROM THREE_G_SITES INNER JOIN THREE_G_CELLS ON (THREE_G_SITES.Cell_ID = THREE_G_CELLS.CID) WHERE THREE_G_SITES.Cell_ID = '$id'";
$resultdelete2 = mysqli_query($conn, $delete2);

$delete3 = "DELETE TWO_G_SITES, TWO_G_CELLS FROM TWO_G_SITES INNER JOIN TWO_G_CELLS ON (TWO_G_SITES.Cell_ID = TWO_G_CELLS.CID_Key) WHERE TWO_G_SITES.Cell_ID = '$id'";
$resultdelete3 = mysqli_query($conn, $delete3);

$delete4 = "DELETE FROM NEW_SITES  WHERE ID = '$id'";
$resultdelete3 = mysqli_query($conn, $delete4);

}



