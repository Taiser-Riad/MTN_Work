<?php 
include "config.php";
?>
<?php
if(isset($_GET['id13']))
{
    $id =$_GET['id13'];
    $sqll= "SELECT s.*, t.* , c.*   FROM new_sites s INNER JOIN 3gsites t ON(s.ID = t.Site_ID) JOIN 3gcells c ON (t.Cell_ID = c.CID) WHERE s.ID = '$id'";

    $resultt = mysqli_query($conn,$sqll);
    $cancelldate = date("m-d-Y h:i:s A");


    if($row2 = mysqli_fetch_assoc($resultt)){
        $cellid   = $row2['CID'];
        $cellcode = $row2['Cell_Code'];
        $sitecode = $row2['Site_Code'];
        $tech = "3G";
        $query ="INSERT INTO `cancelled_sites`(Site_ID, Site_Code, Site_Name, Zone, Province, CR, Supplier,  Status_Before, On_Air_Date, Note, Coordinates_E, Coordinates_N, Site_Adress, 2G_RBS)
        SELECT  s.ID, t.Site_Code, s.Site_Name,s.Zone, s.Province, s.CR, s.Supplier, t.Site_Status, t.3GOn_Air_Date, t.Notes ,s.Coordinates_E, s.Coordinates_N, s.Site_Adress ,t.Real_RNC FROM new_sites s INNER JOIN 3gsites t ON(s.ID = t.Site_ID)
        WHERE s.ID = '$id'";
       
       $resultquery= mysqli_query($conn,$query);
       
       $query2 ="INSERT INTO `cancelled_cells`(Cell_ID_KEY, Cell_Code, Cell_Name, Cell_ID, Site_code, Site_name, Zone, Province, CR, Supplier, BSC, On_air_Date, Note, Serving_Area, serving_Area_IN_English)
       SELECT c.CID, c.Cell_Code, c.Cell_Name, c.Cell_ID, t.Site_code, s.Site_Name, s.Zone, s.Province, s.CR, s.Supplier, s.BSC, c.On_Air_Date, c.Note ,c.Serving_Area, c.Serving_area_In_English FROM new_sites s INNER JOIN 3gsites t ON(s.ID = t.Site_ID) INNER JOIN 3gcells c ON (t.Cell_ID = c.CID)
       WHERE (c.CID = '$cellid' AND s.ID = '$id')";
       
       $resultquery12= mysqli_query($conn,$query2);
       
       $query3 =  "UPDATE `cancelled_cells` SET `Cancelled_Date`= '$cancelldate' WHERE Cell_ID_KEY= '$cellid' AND Cell_Code = '$cellcode'";
       $resultquery3= mysqli_query($conn,$query3);
    
       $query4 = "UPDATE `cancelled_sites` SET `Cancellation_Date`= '$cancelldate' ,`Cell_ID`= '$cellid', `Cancelled_Technologies` = '$tech' WHERE Site_ID= '$id' AND Site_Code ='$sitecode'";
       $resultquery4= mysqli_query($conn, $query4);
    
    
       
       }
       else {
    
        echo "No 3G Site found!!";
        }

        /*$queryy = "SELECT `Cancelled_Technologies` FROM `cancelled_sites` WHERE Site_ID= '$id'";
        $resultqueryy = mysqli_query($conn,$queryy);
        $roww = mysqli_fetch_assoc($resultqueryy);

       
        if ($roww['Cancelled_Technologies'] == ' '){
         $tech = "3G";
            $insert = "INSERT INTO `cancelled_sites`(`Cancelled_Technologies`) VALUES ('$tech') WHERE Site_ID= '$id'";
            $res = mysqli_query($conn, $insert);
            }
        elseif($roww['Cancelled_Technologies']  == '2G') {
         $tech = "2G/3G";
           $updated = "UPDATE `cancelled_sites` SET  `Cancelled_Technologies`='$tech' WHERE  Site_ID= '$id'"; 
           $res = mysqli_query($conn, $updated);
        }
        elseif($roww['Cancelled_Technologies'] == '4G') {
          $tech = "3G/4G";
           $updated1 = "UPDATE `cancelled_sites` SET  `Cancelled_Technologies`='$tech' WHERE  Site_ID= '$id'";
           $res1 = mysqli_query($conn, $updated1);
        }
        elseif($roww['Cancelled_Technologies'] == '2G/4G') {
            $tech = "All";
             $updated1 = "UPDATE `cancelled_sites` SET  `Cancelled_Technologies`='$tech' WHERE  Site_ID= '$id'";
             $res1 = mysqli_query($conn, $updated1);
          }*/


        $delete2 = "DELETE 3gsites, 3gcells FROM 3gsites INNER JOIN 3gcells ON (3gsites.Cell_ID = 3gcells.CID) WHERE 3gsites.Cell_ID = '$id'";
        $resultdelete2 = mysqli_query($conn, $delete2);

        echo '<script>alert("'.$row2["Site_Code"].' site and cells deleted Successfully")</script>';  
   
        $sql1 = "SELECT *  FROM 2gsites t JOIN 2gcells c ON (t.Cell_ID = c.CID_Key)     WHERE t.Site_ID = '$id'";
        $sql2 = "SELECT *  FROM 4gsites t JOIN 4gcells c ON (t.Cell_ID_KEY = c.CID_Key) WHERE t.SID = '$id'";
     
        $stmt  = mysqli_query($conn, $sql1);
        $stmt1 = mysqli_query($conn ,$sql2);
     
        $num1 = mysqli_num_rows($stmt);
        $num2 = mysqli_num_rows($stmt1);
     
        if($num1 == 0 && $num2 == 0){
            $tech1 = "All";
            $sitecode1 = $row['Site_code'] ;
         echo '<script>alert("'.$row["Site_code"].' site will Cancelled")</script>';
         $updatetech = "UPDATE `cancelled_sites` SET `Cancelled_Technologies` = '$tech1 ' WHERE  Site_ID= '$id' AND Site_Code ='$sitecode1'";
         $resupd = mysqli_query($conn, $updatetech);


         $delete4 = "DELETE FROM new_sites  WHERE ID = '$id'";
         $resultdelete3 = mysqli_query($conn, $delete4);
     
        }

}
?>