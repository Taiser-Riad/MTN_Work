<?php 
include "config.php";
?>
<?php
if(isset($_GET['id12']))
{
$id =$_GET['id12'];
$sql = "SELECT s.*, t.*         FROM new_sites s INNER JOIN 2gsites t ON(s.ID = t.Site_ID)                                               WHERE t.Site_ID = '$id'";
$sqll= "SELECT s.*, t.* , c.*   FROM new_sites s INNER JOIN 2gsites t ON(s.ID = t.Site_ID) JOIN 2gcells c ON (t.Cell_ID = c.CID_Key)     WHERE t.Site_ID = '$id'";



$result = mysqli_query($conn,$sql);
$resultt = mysqli_query($conn,$sqll);
$cancelldate = date("m-d-Y h:i:sa");



if($row = mysqli_fetch_assoc($result)){
    
    $sitecode = $row['Site_code'];
    $query ="INSERT INTO `cancelled_sites`(Site_ID, Site_Code, Site_Name, Zone, Province, CR, Supplier, On_Air_Date, Coordinates_E, Coordinates_N, Site_Adress)
    SELECT  ID, Site_code, Site_Name, Zone, Province, CR, Supplier, Site_On_Air_Date ,Coordinates_E, Coordinates_N, Site_Adress  FROM new_sites
    WHERE ID = '$id'";

    $resultt1 =  mysqli_query($conn,$query);

    $query1 = "UPDATE `cancelled_sites` SET `Cancellation_Date`= '$cancelldate' WHERE Site_ID= '$id' AND Site_Code ='$sitecode'";
    $resultt3 =  mysqli_query($conn,$query1);

}

else {
    echo "Site doesn't Exist!!";
}


if($row2 = mysqli_fetch_assoc($resultt)){
    $cellid = $row2['CID_Key'];
    $band   = $row2['Band'];
    $status = $row2['Site_Status'];
    $note   = $row2['Notes'];
    $cellcode = $row2['Cell_code'];
    $sitecode = $row2['Site_code'];
   
    if(isset($row2['900GSM_RBS_Type'])){
       $RBS =$row2['900GSM_RBS_Type'];
    }
   else {
       $RBS =$row2['1800GSM_RBS_Type'];
   }
   $tech = "2G";
   
   $query2 ="INSERT INTO `cancelled_cells`(Cell_ID_KEY, Cell_Code, Cell_Name, Cell_ID, Site_code, Site_name, Zone, Province, CR, Supplier, BSC, On_air_Date, Note, Serving_Area, serving_Area_IN_English)
   SELECT c.CID_Key, c.Cell_code, c.Cell_Name, c.Cell_ID, s.Site_code, s.Site_Name, s.Zone, s.Province, s.CR, s.Supplier, s.BSC, c.Cell_On_Air_Date, c.Note ,c.Serving_Area, c.serving_Area_IN_English FROM new_sites s INNER JOIN 2gsites t ON(s.ID = t.Site_ID) JOIN 2gcells c ON (t.Cell_ID = c.CID_Key)
   WHERE (c.CID_Key = '$cellid' AND s.ID = '$id')";
   
   $resultquery2= mysqli_query($conn,$query2);
   
   $query3 = "UPDATE `cancelled_cells` SET `Cancelled_Date`= '$cancelldate' WHERE Cell_ID_KEY= '$cellid' AND Cell_Code = '$cellcode'";
   $resultquery3= mysqli_query($conn,$query3);
   
   $query4 = "UPDATE `cancelled_sites` SET `Cancellation_Date`= '$cancelldate',`Cell_ID`= '$cellid', `Cancelled_Technologies` = '$tech', 2G_RBS= '$RBS', Band = '$band', Status_Before = '$status',Note = '$note'  WHERE Site_ID= '$id' AND Site_Code ='$sitecode'";
   $resultquery4= mysqli_query($conn,$query4);
   
   }

   else {
    echo "No 2G Site found!!";
   }
   /*$queryy = "SELECT `Cancelled_Technologies` FROM `cancelled_sites` WHERE Site_ID= '$id'";
   $resultqueryy = mysqli_query($conn,$queryy);
   $roww = mysqli_fetch_assoc($resultqueryy);
  
   if ($roww['Cancelled_Technologies'] == ''){
    $tech = "2G";
       $insert = "INSERT INTO `cancelled_sites`(`Cancelled_Technologies`) VALUES '$tech' WHERE Site_ID= '$id' ";
       $res = mysqli_query($conn, $insert);
       }
   elseif($roww['Cancelled_Technologies'] == '3G') {
    $tech = "2G/3G";
      $update = "UPDATE `cancelled_sites` SET  `Cancelled_Technologies`='$tech' WHERE  Site_ID= '$id' "; 
      $res = mysqli_query($conn, $updated);
   }
   elseif($roww['Cancelled_Technologies'] == '4G') {
    $tech = "2G/4G";
      $update1 = "UPDATE `cancelled_sites` SET  `Cancelled_Technologies`='$tech' WHERE  Site_ID= '$id' ";
      $res1 = mysqli_query($conn, $updated1);
   }
   elseif($roww['Cancelled_Technologies'] == '3G/4G') {
    $tech = "All";
     $updated1 = "UPDATE `cancelled_sites` SET  `Cancelled_Technologies`='$tech' WHERE  Site_ID= '$id'";
     $res1 = mysqli_query($conn, $updated1);
  }*/


   $delete = "DELETE 2gsites, 2gcells FROM 2gsites INNER JOIN 2gcells ON (2gsites.Cell_ID = 2gcells.CID_Key) WHERE 2gsites.Cell_ID = '$id'";
   $resultdelete = mysqli_query($conn, $delete);
   echo '<script>alert("'.$row["Site_code"].' site and cells deleted Successfully")</script>';   



   

   $sql1 = "SELECT * FROM 3gsites t JOIN 3gcells c ON (t.Cell_ID = c.CID)         WHERE t.Site_ID = '$id'";
   $sql2 = "SELECT * FROM 4gsites t JOIN 4gcells c ON (t.Cell_ID_KEY = c.CID_Key) WHERE t.SID = '$id'";

   $stmt  = mysqli_query($conn, $sql1);
   $stmt1 = mysqli_query($conn ,$sql2);

   $num1 = mysqli_num_rows($stmt);
   $num2 = mysqli_num_rows($stmt1);

   if($num1 == 0 && $num2 == 0){
    $tech1 = "All";
    $sitecode1 = $row['Site_code'] ;
    echo '<script>alert("'.$row["Site_code"].' site  will Cancelled")</script>'; 

    $updatetech = "UPDATE `cancelled_sites` SET `Cancelled_Technologies` = '$tech1 ' WHERE  Site_ID= '$id' AND Site_Code ='$sitecode1'";
    $resupd = mysqli_query($conn, $updatetech);

    $delete4 = "DELETE FROM new_sites  WHERE ID = '$id'";
    $resultdelete3 = mysqli_query($conn, $delete4);

   }

}

?>