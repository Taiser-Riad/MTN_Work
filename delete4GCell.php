<?php 
include "config.php";
?>
<?php
if(isset($_GET['id4']))
{
    $id =$_GET['id4'];
    $sql ="SELECT * FROM FOUR_G_CELLS WHERE CELL_CODE = :id";
    $sqll= "SELECT s.*, t.* , c.*  FROM NEW_SITES s INNER JOIN FOUR_G_SITES t ON (s.ID = t.SID) INNER JOIN FOUR_G_CELLS c ON (t.CELL_ID_KEY = c.CID_KEY) WHERE c.CELL_CODE = :id";

    $result = oci_parse($conn, $sql);
    oci_bind_by_name($result, ":id", $id);
    oci_execute($result);

    $resultt = oci_parse($conn, $sqll);
    oci_bind_by_name($resultt, ":id", $id);
    oci_execute($resultt);



    $cancelldate = date("m-d-Y h:i:s A");


    if($row4 = oci_fetch_array($resultt, OCI_ASSOC)){

      $siteid   = $row4['SID'];
      $cellidkey= $row4['CID_KEY'];
      $cellcode = $row4['CELL_CODE'];
      $sitecode = $row4['SITE_CODE'];


      $query22 ="INSERT INTO CANCELLED_CELLS(CELL_ID_KEY, CELL_CODE, CELL_NAME, CELL_ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, BSC, ON_AIR_DATE, NOTE, SERVING_AREA, SERVING_AREA_IN_ENGLISH)
       SELECT c.CID_KEY, c.CELL_CODE, c.CELL_NAME, c.CELL_ID, t.SITE_CODE, s.SITE_NAME, s.ZONE, s.PROVINCE, s.CR, s.SUPPLIER, s.BSC, c.ON_AIR_DATE, c.NOTEs ,c.SERVING_AREA, c.SERVING_AREA_IN_ENGLISH FROM NEW_SITES s INNER JOIN FOUR_G_SITES t ON(s.ID = t.SID) INNER JOIN FOUR_G_CELLS c ON (t.CELL_ID_KEY = c.CID_KEY)
       WHERE (c.CELL_CODE = :id)";
      
      $resultquery22 = oci_parse($conn, $query22);
      oci_bind_by_name($resultquery22, ":id", $id);
      oci_execute($resultquery22);



      $query3 = "UPDATE CANCELLED_CELLS SET CANCELLED_DATE = :cancelldate WHERE CELL_ID_KEY = :cellidkey AND CELL_CODE = :id";
     
      $stid33 = oci_parse($conn, $query3);
      oci_bind_by_name($stid33, ":cancelldate", $cancelldate);
      oci_bind_by_name($stid33, ":cellidkey", $cellidkey);
      oci_bind_by_name($stid33, ":id", $id);
      $resultquery13 = oci_execute($stid33);
      if (!$resultquery13) {
          $e = oci_error($stid33);
          echo htmlentities($e['message'], ENT_QUOTES);
      }

      $sqll2    = "DELETE FROM FOUR_G_CELLS WHERE CELL_CODE = :id";
  
      $stid4 = oci_parse($conn,  $sqll2); 
      oci_bind_by_name($stid4, ":id", $id); 
      $resultt2 = oci_execute($stid4);
      if (!$resultt2){
          $e = oci_error($stid4); 
          echo htmlentities($e['message'], ENT_QUOTES);
      }
      else{
          echo '<script>alert("'.$row4["CELL_CODE"].'  cell deleted Successfully")</script>'; 
      }
   
      $sqll3 = "SELECT * FROM FOUR_G_CELLS WHERE CID_KEY = :cellidkey";
      $stid5 = oci_parse($conn, $sqll3);
      oci_bind_by_name($stid5, ":cellidkey", $cellidkey);
      oci_execute($stid5);
 
       $num = 0; 
       while (($row11 = oci_fetch_array($stid5, OCI_ASSOC)) != false) { 
         $num++; 
     }



      if ($num == false){
        echo '<script>alert("'.$row4["SITE_CODE"].' 4G site will be delete.")</script>'; 


    $tech = "4G";
    $query ="INSERT INTO CANCELLED_SITES(SITE_ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER,  STATUS_BEFORE, ON_AIR_DATE, NOTE, COORDINATES_E, COORDINATES_N, SITE_ADRESS)
    SELECT  s.ID, t.SITE_CODE, s.SITE_NAME,s.ZONE, s.PROVINCE, s.CR, s.SUPPLIER, t.STATUS, t.ACTIVATION_DATE, t.NOTE ,s.COORDINATES_E, s.COORDINATES_N, s.SITE_ADDRESS FROM NEW_SITES s INNER JOIN FOUR_G_SITES t ON(s.ID = t.SID)
    WHERE s.ID = :siteid";
   
   $stid21 = oci_parse($conn, $query);
   oci_bind_by_name($stid21, ":siteid", $sited);
   $resultquery15 = oci_execute($stid21);
   if (!$resultquery15) {
       $e = oci_error($stid21);
       echo htmlentities($e['message'], ENT_QUOTES);
   }
    
   $query3  = "UPDATE CANCELLED_CELLS SET CANCELLED_DATE= :cancelldate WHERE CELL_ID_KEY= :cellidkey AND CELL_CODE = :cellcode";

   $stid33 = oci_parse($conn, $query3);
   oci_bind_by_name($stid33, ":cancelldate", $cancelldate);
   oci_bind_by_name($stid33, ":cellidkey", $cellidkey);
   oci_bind_by_name($stid33, ":cellcode", $cellcode);
   $resultquery13 = oci_execute($stid33);
   if (!$resultquery13) {
       $e = oci_error($stid33);
       echo htmlentities($e['message'], ENT_QUOTES);
   }



   $query4 = "UPDATE CANCELLED_SITES SET CANCELLATION_DATE= :cancelldate ,CELL_ID= :cellidkey ,CANCELLED_TECHNOLOGIES = :tech  WHERE SITE_ID= :siteid AND SITE_CODE= :sitecode";
   $resultquery14 = oci_parse($conn, $query4);
   oci_bind_by_name($resultquery14, ":cellidkey", $cellidkey);
   oci_bind_by_name($resultquery14, ":tech", $tech);
   oci_bind_by_name($resultquery14, ":cancelldate", $cancelldate);
   oci_bind_by_name($resultquery14, ":siteid", $siteid);
   oci_bind_by_name($resultquery14, ":sitecode", $sitecode);
   oci_execute($resultquery14);
    

$deleteCells1 = "DELETE FROM FOUR_G_CELLS WHERE CID_KEY = :cellidkey";
$stidCells1 = oci_parse($conn, $deleteCells1);
oci_bind_by_name($stidCells1, ':cellidkey', $cellidkey);
$resultDeleteCells = oci_execute($stidCells1);
if (!$resultDeleteCells) {
    $e = oci_error($stidCells1);
    echo htmlentities($e['message'], ENT_QUOTES);
}

$deleteSites1 = "DELETE FROM FOUR_G_SITES WHERE CELL_ID_KEY = :cellidkey";
$stidSites1 = oci_parse($conn, $deleteSites1);
oci_bind_by_name($stidSites1, ':cellidkey', $cellidkey);
$resultDeleteSites = oci_execute($stidSites1);
if ($resultDeleteSites) {
    echo '<script>alert("Site and cells deleted successfully.")</script>';
} else {
    $e = oci_error($stidSites1);
    echo htmlentities($e['message'], ENT_QUOTES);
}


    
    
    }
    }
    
    header("Location:Delete_Thankyou.html");

}


?>