<?php 
include "config.php";
?>
<?php
if(isset($_GET['id13']))
{
    $id =$_GET['id13'];
    $sqll= "SELECT s.*, t.* , c.*   FROM NEW_SITES s INNER JOIN THREE_G_SITES t ON(s.ID = t.SITE_ID) JOIN THREE_G_CELLS c ON (t.CELL_ID = c.CID) WHERE s.ID = :id";
    
    $resultt = oci_parse($conn, $sqll);
    oci_bind_by_name($resultt, ":id", $id);
    oci_execute($resultt);


    $cancelldate = date("m-d-Y h:i:s A");


    if($row2 = oci_fetch_array($resultt , OCI_ASSOC)){
        $cellid   = $row2['CID'];
        $cellcode = $row2['CELL_CODE'];
        $sitecode = $row2['SITE_CODE'];
        $tech = "3G";
      

        $query ="INSERT INTO CANCELLED_SITES(SITE_ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER,  STATUS_BEFORE, ON_AIR_DATE, NOTE, COORDINATES_E, COORDINATES_N, SITE_ADRESS, TWO_G_RBS)
        SELECT  s.ID, t.SITE_CODE, s.SITE_NAME,s.ZONE, s.PROVINCE, s.CR, s.SUPPLIER, t.SITE_STATUS, t.THREE_G_ON_AIR_DATE, t.NOTES, s.COORDINATES_E, s.COORDINATES_N, s.SITE_ADDRESS ,t.REAL_RNC FROM NEW_SITES s INNER JOIN THREE_G_SITES t ON(s.ID = t.SITE_ID)
        WHERE s.ID = :id";
                
       //$resultquery= mysqli_query($conn,$query);
       $resultquery = oci_parse($conn, $query);
       oci_bind_by_name($resultquery, ":id", $id);
       oci_execute($resultquery);
       
       $query2 ="INSERT INTO CANCELLED_CELLS(CELL_ID_KEY, CELL_CODE, CELL_NAME, CELL_ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, BSC, ON_AIR_DATE, NOTE, SERVING_AREA, SERVING_AREA_IN_ENGLISH)
       SELECT c.CID, c.CELL_CODE, c.CELL_NAME, c.CELL_ID, t.SITE_CODE, s.SITE_NAME, s.ZONE, s.PROVINCE, s.CR, s.SUPPLIER, s.BSC, c.ON_AIR_DATE, c.NOTE ,c.SERVING_AREA, c.SERVING_AREA_IN_ENGLISH FROM NEW_SITES s INNER JOIN THREE_G_SITES t ON(s.ID = t.SITE_ID) INNER JOIN THREE_G_CELLS c ON (t.CELL_ID = c.CID)
       WHERE (c.CID = :cellid AND s.ID = :id)";
       

       
       //$resultquery12= mysqli_query($conn,$query2);
       $resultquery12= oci_parse($conn, $query2);
       oci_bind_by_name($resultquery12, ":id", $id);
       oci_bind_by_name($resultquery12, ":cellid", $cellid);
       oci_execute($resultquery12);


       
       $query3 =  "UPDATE CANCELLED_CELLS SET CANCELLED_DATE = :cancelldate WHERE CELL_ID_KEY= :cellid AND CELL_CODE = :cellcode";
       //$resultquery3= mysqli_query($conn,$query3);
       $resultquery3 = oci_parse($conn, $query3);
       oci_bind_by_name($resultquery3, ":cellid", $cellid);
       oci_bind_by_name($resultquery3, ":cancelldate", $cancelldate);
       oci_bind_by_name($resultquery3, ":cellcode", $cellcode);
       oci_execute($resultquery3);


    
       $query4 = "UPDATE CANCELLED_SITES SET CANCELLATION_DATE= :cancelldate ,CELL_ID = :cellid, CANCELLED_TECHNOLOGIES = :tech WHERE SITE_ID= :id AND SITE_CODE =:sitecode";
       //$resultquery4= mysqli_query($conn, $query4);
       $resultquery4 = oci_parse($conn, $query4);
        oci_bind_by_name($resultquery4, ":cellid", $cellid);
        oci_bind_by_name($resultquery4, ":tech", $tech);
        oci_bind_by_name($resultquery4, ":cancelldate", $cancelldate);
        oci_bind_by_name($resultquery4, ":id", $id);
        oci_bind_by_name($resultquery4, ":sitecode", $sitecode);
        oci_execute($resultquery4);

    
       
       }
       else {
    
        echo "No 3G Site found!!";
        }
           
              $deleteCells = "DELETE FROM THREE_G_CELLS WHERE CID = :cellid";
              $stidCells = oci_parse($conn, $deleteCells);
              oci_bind_by_name($stidCells, ":cellid", $cellid);
              $resultDeleteCells = oci_execute($stidCells);
              if (!$resultDeleteCells) {
                  $e = oci_error($stidCells);
                  echo htmlentities($e['message'], ENT_QUOTES);
              }

              // Now, delete from THREE_G_SITES
              $deleteSites = "DELETE FROM THREE_G_SITES WHERE CELL_ID = :cellid";
              $stidSites = oci_parse($conn, $deleteSites);
              oci_bind_by_name($stidSites, ":cellid", $cellid);
              $resultDeleteSites = oci_execute($stidSites);
              if ($resultDeleteSites) {
                  echo '<script>alert("Site and cells deleted successfully.")</script>';
              } else {
                  $e = oci_error($stidSites);
                  echo htmlentities($e['message'], ENT_QUOTES);
              }



        echo '<script>alert("'.$row2["SITE_CODE"].' site and cells deleted Successfully")</script>';  

$sql1 = "SELECT * FROM TWO_G_SITES  t JOIN TWO_G_CELLS c  ON t.CELL_ID     = c.CID_KEY WHERE t.SITE_ID = :id";
$sql2 = "SELECT * FROM FOUR_G_SITES t JOIN FOUR_G_CELLS c ON t.CELL_ID_KEY = c.CID_KEY WHERE t.SID = :id";

$stid13 = oci_parse($conn, $sql1);
oci_bind_by_name($stid13, ':id', $id);
oci_execute($stid13);
$num1 = oci_fetch_all($stid13, $res1);

$stid23 = oci_parse($conn, $sql2);
oci_bind_by_name($stid23, ':id', $id);
oci_execute($stid23);
$num2 = oci_fetch_all($stid23, $res2);

if ($num1 == 0 && $num2 == 0) {
    $tech1 = "All";
    $sitecode1 = $row2['SITE_CODE'];
    echo '<script>alert("'.$row2["SITE_CODE"].' site will be Cancelled")</script>';

    // Update CANCELLED_SITES
    $updatetech = "UPDATE CANCELLED_SITES SET CANCELLED_TECHNOLOGIES = :tech1  WHERE SITE_ID = :id  AND SITE_CODE = :sitecode1";
    $stid3 = oci_parse($conn, $updatetech);
    oci_bind_by_name($stid3, ':tech1', $tech1);
    oci_bind_by_name($stid3, ':id', $id);
    oci_bind_by_name($stid3, ':sitecode1', $sitecode1);
    $resupd = oci_execute($stid3);

    // Delete from NEW_SITES
    $delete4 = "DELETE FROM NEW_SITES WHERE ID = :id";
    $stid4 = oci_parse($conn, $delete4);
    oci_bind_by_name($stid4, ':id', $id);
    $resultdelete3 = oci_execute($stid4);

    if ($resultdelete3) {
        echo '<script>alert("Site deleted successfully.")</script>';
    } else {
        $e = oci_error($stid4);
        echo htmlentities($e['message'], ENT_QUOTES);
    }
}






header("Location:Delete_Thankyou.html");



}
?>