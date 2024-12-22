<?php 
include "config.php";
?>
<?php
if(isset($_GET['id14']))
{
    $id =$_GET['id14'];

    $sqll= "SELECT s.*, t.* , c.*   FROM NEW_SITES s INNER JOIN FOUR_G_SITES t ON(s.ID = t.SID)    JOIN FOUR_G_CELLS c ON (t.CELL_ID_KEY = c.CID_KEY) WHERE s.ID = :id";


    $resultt = oci_parse($conn, $sqll);
    oci_bind_by_name($resultt, ":id", $id);
    oci_execute($resultt);
    $cancelldate = date("m-d-Y h:i:s A");


    if($row4 = oci_fetch_array($resultt)){
        $cellid   = $row4['CID_KEY'];
        $cellcode = $row4['CELL_CODE'];
        $sitecode = $row4['SITE_CODE'];
        $tech = "4G";
        // $query ="INSERT INTO CANCELLED_SITES(SITE_ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER,  STATUS_BEFORE, ON_AIR_DATE, NOTE, Coordinates_E, Coordinates_N, Site_Adress)
        // SELECT  s.ID, t.SITE_CODE, s.SITE_NAME,s.ZONE, s.PROVINCE, s.CR, s.SUPPLIER, t.Status, t.Activation_Date, t.NOTE ,s.Coordinates_E, s.Coordinates_N, s.Site_Adress FROM NEW_SITES s INNER JOIN FOUR_G_SITES t ON(s.ID = t.SID)
        // WHERE s.ID = :id";


        $query ="INSERT INTO CANCELLED_SITES(SITE_ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER,  STATUS_BEFORE, ON_AIR_DATE, NOTE, COORDINATES_E, COORDINATES_N, SITE_ADRESS)
        SELECT  s.ID, t.SITE_CODE, s.SITE_NAME,s.ZONE, s.PROVINCE, s.CR, s.SUPPLIER, t.STATUS, t.ACTIVATION_DATE, t.NOTE ,s.COORDINATES_E, s.COORDINATES_N, s.SITE_ADDRESS FROM NEW_SITES s INNER JOIN FOUR_G_SITES t ON(s.ID = t.SID)
        WHERE s.ID = :id";
       
       //$resultquery= mysqli_query($conn,$query);
       $resultquery = oci_parse($conn, $query);
       oci_bind_by_name($resultquery, ":id", $id);
       oci_execute($resultquery);


       $query22 ="INSERT INTO CANCELLED_CELLS(CELL_ID_KEY, CELL_CODE, CELL_NAME, CELL_ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, BSC, ON_AIR_DATE, NOTE, SERVING_AREA, SERVING_AREA_IN_ENGLISH)
        SELECT c.CID_KEY, c.CELL_CODE, c.CELL_NAME, c.CELL_ID, t.SITE_CODE, s.SITE_NAME, s.ZONE, s.PROVINCE, s.CR, s.SUPPLIER, s.BSC, c.ON_AIR_DATE, c.NOTES ,c.SERVING_AREA, c.SERVING_AREA_IN_ENGLISH FROM NEW_SITES s INNER JOIN FOUR_G_SITES t ON(s.ID = t.SID) INNER JOIN FOUR_G_CELLS c ON (t.CELL_ID_KEY = c.CID_KEY)
       WHERE (c.CID_KEY = :cellid AND s.ID = :id)";
       
       
       $resultquery12= oci_parse($conn, $query22);
       oci_bind_by_name($resultquery12, ":id", $id);
       oci_bind_by_name($resultquery12, ":cellid", $cellid);
       oci_execute($resultquery12);
       
       
       $query3  = "UPDATE CANCELLED_CELLS SET CANCELLED_DATE= :cancelldate WHERE CELL_ID_KEY= :cellid AND CELL_CODE = :cellcode";
       $resultquery13 = oci_parse($conn, $query3);
       oci_bind_by_name($resultquery13, ":cellid", $cellid);
       oci_bind_by_name($resultquery13, ":cancelldate", $cancelldate);
       oci_bind_by_name($resultquery13, ":cellcode", $cellcode);
       oci_execute($resultquery13);



    
       $query4 = "UPDATE CANCELLED_SITES SET CANCELLATION_DATE= :cancelldate, CELL_ID = :cellid , CANCELLED_TECHNOLOGIES = :tech  WHERE SITE_ID= :id AND SITE_CODE= :sitecode";
       
       $resultquery4 = oci_parse($conn, $query4);
       oci_bind_by_name($resultquery4, ":cellid", $cellid);
       oci_bind_by_name($resultquery4, ":tech", $tech);
       oci_bind_by_name($resultquery4, ":cancelldate", $cancelldate);
       oci_bind_by_name($resultquery4, ":id", $id);
       oci_bind_by_name($resultquery4, ":sitecode", $sitecode);
       oci_execute($resultquery4);
    
    
       }
       else {
    
        echo "No 4G Site found!!";
        }



        $deleteCells = "DELETE FROM FOUR_G_CELLS WHERE CID_KEY = :id";
        $stidCells = oci_parse($conn, $deleteCells);
          oci_bind_by_name($stidCells, ':id', $cellid);
          $resultDeleteCells = oci_execute($stidCells);
            if (!$resultDeleteCells) {
                $e = oci_error($stidCells);
                echo htmlentities($e['message'], ENT_QUOTES);
            }

            $deleteSites = "DELETE FROM FOUR_G_SITES WHERE CELL_ID_KEY = :id";
            $stidSites = oci_parse($conn, $deleteSites);
            oci_bind_by_name($stidSites, ':id', $cellid);
            $resultDeleteSites = oci_execute($stidSites);
            if ($resultDeleteSites) {
              echo '<script>alert("'.$row4["SITE_CODE"].' site and cells deleted Successfully")</script>';  
            } else {
                $e = oci_error($stidSites);
                echo htmlentities($e['message'], ENT_QUOTES);
            }

       
                $sql1 = "SELECT *  FROM TWO_G_SITES t   JOIN TWO_G_CELLS c ON (t.CELL_ID = c.CID_KEY) WHERE t.SITE_ID = :id";
                $sql2 = "SELECT * FROM THREE_G_SITES t JOIN THREE_G_CELLS c ON (t.CELL_ID = c.CID)   WHERE t.SITE_ID = :id";
       
             
                $stid13 = oci_parse($conn, $sql1);
                oci_bind_by_name($stid13, ':id', $id);
                oci_execute($stid13);
                $num1 = oci_fetch_all($stid13, $res1);
                
                $stid23 = oci_parse($conn, $sql2);
                oci_bind_by_name($stid23, ':id', $id);
                oci_execute($stid23);
                $num2 = oci_fetch_all($stid23, $res2);
             
                if($num1 == 0 && $num2 == 0){
                    $tech1 = "All";
                    $sitecode1 = $row4['SITE_CODE'] ;

             
                 echo '<script>alert("'.$row4["SITE_CODE"].' site and will Cancelled")</script>'; 

                 $updatetech = "UPDATE CANCELLED_SITES SET CANCELLED_TECHNOLOGIES = :tech1  WHERE  SITE_ID= :id AND SITE_CODE =:sitecode1";
                 $stid31 = oci_parse($conn, $updatetech);
                 oci_bind_by_name($stid31, ':tech1', $tech1);
                 oci_bind_by_name($stid31, ':id', $id);
                 oci_bind_by_name($stid31, ':sitecode1', $sitecode1);
                 $resupd = oci_execute($stid31);

                 $delete4 = "DELETE FROM NEW_SITES  WHERE ID = :id";
                 //$resultdelete3 = mysqli_query($conn, $delete4);

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