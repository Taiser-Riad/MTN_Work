<?php 
include "config.php";
?>
<?php
if(isset($_GET['id4']))
{
    $id =$_GET['id4'];
    $sql ="SELECT * FROM 4gcells WHERE Cell_code = '$id'";
    $sqll= "SELECT s.*, t.* , c.*  FROM new_sites s INNER JOIN 4gsites t ON (s.ID = t.SID) INNER JOIN 4gcells c ON (t.Cell_ID_KEY = c.CID_Key) WHERE c.Cell_code = '$id'";

    $resultt = mysqli_query($conn,$sqll);
    $cancelldate = date("m-d-Y h:i:s A");


    if($row4 = mysqli_fetch_assoc($resultt)){

      $siteid   = $row4['SID'];
      $cellidkey= $row4['CID_Key'];
      $cellcode = $row4['Cell_code'];
      $sitecode = $row4['Site_code'];


      $query22 ="INSERT INTO `cancelled_cells`(Cell_ID_KEY, Cell_Code, Cell_Name, Cell_ID, Site_code, Site_name, Zone, Province, CR, Supplier, BSC, On_air_Date, Note, Serving_Area, serving_Area_IN_English)
       SELECT c.CID_Key, c.Cell_code, c.Cell_Name, c.Cell_ID, t.Site_code, s.Site_Name, s.Zone, s.Province, s.CR, s.Supplier, s.BSC, c.On_Air_Date, c.Notes ,c.Serving_Area, c.serving_Area_IN_English FROM new_sites s INNER JOIN 4gsites t ON(s.ID = t.SID) INNER JOIN 4gcells c ON (t.Cell_ID_KEY = c.CID_Key)
      WHERE (c.Cell_code = '$id')";
      
      $resultquery22= mysqli_query($conn,$query22);

      $sqll2    = "DELETE FROM `4gcells` WHERE Cell_code = '$id'";
      $resultt2 = mysqli_query($conn,$sqll2);

      if ($resultt2 === true){
        echo '<script>alert("'.$row4["Cell_code"].'  cell deleted Successfully")</script>'; 
      }
   
      $sqll3 = "SELECT * FROM `4gcells` WHERE CID_Key = '$cellidkey'";
      $resultt3 = mysqli_query($conn,$sqll3);
      $num3 = mysqli_num_rows($resultt3);

      if ($num3 == 0){
        echo '<script>alert("'.$row4["Site_code"].' 4G site will be delete.")</script>'; 


    $tech = "4G";
    $query ="INSERT INTO `cancelled_sites`(Site_ID, Site_Code, Site_Name, Zone, Province, CR, Supplier,  Status_Before, On_Air_Date, Note, Coordinates_E, Coordinates_N, Site_Adress)
    SELECT  s.ID, t.Site_code, s.Site_Name,s.Zone, s.Province, s.CR, s.Supplier, t.Status, t.Activation_Date, t.Note ,s.Coordinates_E, s.Coordinates_N, s.Site_Adress FROM new_sites s INNER JOIN 4gsites t ON(s.ID = t.SID)
    WHERE s.ID = '$siteid'";
   
   $resultquery= mysqli_query($conn,$query);
    
   $query3  = "UPDATE `cancelled_cells` SET `Cancelled_Date`= '$cancelldate' WHERE Cell_ID_KEY= '$cellidkey' AND Cell_Code = '$cellcode'";
   $resultquery3= mysqli_query($conn,$query3);

   $query4 = "UPDATE `cancelled_sites` SET `Cancellation_Date`= '$cancelldate' ,`Cell_ID`= '$cellidkey' ,`Cancelled_Technologies` = '$tech'  WHERE Site_ID= '$id' AND Site_Code= '$sitecode'";
   $resultquery4= mysqli_query($conn, $query4);
    
   $delete1 = "DELETE 4gsites, 4gcells FROM 4gsites INNER JOIN 4gcells ON (4gsites.Cell_ID_KEY = 4gcells.CID_Key) WHERE 4gsites.Cell_ID_KEY = '$cellidkey'";
   $resultdelete1 = mysqli_query($conn, $delete1);
    
    
    }
    }

}


?>