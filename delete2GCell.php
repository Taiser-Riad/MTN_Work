<?php 
include "config.php";
?>
<?php
if(isset($_GET['id2']))
{
$id =$_GET['id2'];
$sql ="SELECT * FROM 2gcells WHERE Cell_code = '$id'";
$result = mysqli_query($conn,$sql);

$sqll= "SELECT s.*, t.* , c.*   FROM new_sites s INNER JOIN 2gsites t ON(s.ID = t.Site_ID) JOIN 2gcells c ON (t.Cell_ID = c.CID_Key)     WHERE c.Cell_code = '$id'";
$resultt = mysqli_query($conn,$sqll);

$cancelldate = date("m-d-Y");

if($row = mysqli_fetch_assoc($resultt)){

    $cellid = $row['Cell_ID'];
    $cellidkey = $row['CID_Key'];
    $sid = $row['Site_ID'];
    $band   = $row['Band'];
    $status = $row['Site_Status'];
    $note   = $row['Notes'];
    $cellcode = $row['Cell_code'];
    $sitecode = $row['Site_code'];
   
    if(isset($row['900GSM_RBS_Type'])){
       $RBS =$row['900GSM_RBS_Type'];
    }
   else {
       $RBS =$row['1800GSM_RBS_Type'];
   }

    $query2 ="INSERT INTO `cancelled_cells`(Cell_ID_KEY, Cell_Code, Cell_Name, Cell_ID, Site_code, Site_name, Zone, Province, CR, Supplier, BSC, On_air_Date, Note, Serving_Area, serving_Area_IN_English)
    SELECT c.CID_Key, c.Cell_code, c.Cell_Name, c.Cell_ID, s.Site_code, s.Site_Name, s.Zone, s.Province, s.CR, s.Supplier, s.BSC, c.Cell_On_Air_Date, c.Note ,c.Serving_Area, c.serving_Area_IN_English FROM new_sites s INNER JOIN 2gsites t ON(s.ID = t.Site_ID) JOIN 2gcells c ON (t.Cell_ID = c.CID_Key)
    WHERE (c.Cell_code = '$id')";
    $resultt1 = mysqli_query($conn,$query2);


    $query3 = "UPDATE `cancelled_cells` SET `Cancelled_Date`= '$cancelldate' WHERE Cell_ID_KEY= '$cellidkey' AND Cell_Code = '$id'";
    $resultquery3= mysqli_query($conn,$query3);

    $sqll2    = "DELETE FROM `2gcells` WHERE Cell_code = '$id'";
    $resultt2 = mysqli_query($conn,$sqll2);

    //$num1 = mysqli_num_rows($resultt2);
    if ($resultt2 === true){
        echo '<script>alert("'.$row["Cell_code"].'  cell deleted Successfully")</script>'; 
    }

    $sqll3 = "SELECT * FROM 2gcells WHERE CID_Key = '$cellidkey'";
    $stmt = mysqli_query($conn,$sqll3);
    $num =  mysqli_num_rows($stmt);
    //echo $num;
    


    if ( $num > 0){
        
     }
    elseif ( $num == 0){
        echo '<script>alert("'.$row["Site_code"].' 2G site will be delete.")</script>'; 

      
       $tech = "2G";

       $query5 ="INSERT INTO `cancelled_sites`(Site_ID, Site_Code, Site_Name, Zone, Province, CR, Supplier, On_Air_Date, Coordinates_E, Coordinates_N, Site_Adress)
        SELECT s.ID, s.Site_code, s.Site_Name, s.Zone, s.Province, s.CR, s.Supplier, t.2G_On_Air_Date ,s.Coordinates_E, s.Coordinates_N, s.Site_Adress  FROM new_sites s INNER JOIN 2gsites t ON(s.ID = t.Site_ID) 
        WHERE  s.ID = '$sid'";
        $resultquery15 = mysqli_query($conn,$query5);

        
       $query13 = "UPDATE `cancelled_cells` SET `Cancelled_Date`= '$cancelldate' WHERE Cell_ID_KEY= '$cellidkey' AND Cell_Code = '$cellcode'";
       $resultquery13= mysqli_query($conn,$query13);
       
       $query14 = "UPDATE `cancelled_sites` SET `Cancellation_Date`= '$cancelldate',`Cell_ID`= '$cellid', `Cancelled_Technologies` = '$tech', 2G_RBS= '$RBS', Band = '$band', Status_Before = '$status',Note = '$note'  WHERE Site_ID= '$sid' AND Site_Code ='$sitecode'";
       $resultquery14= mysqli_query($conn,$query14);


       $delete = "DELETE 2gsites, 2gcells FROM 2gsites INNER JOIN 2gcells ON (2gsites.Cell_ID = 2gcells.CID_Key) WHERE 2gsites.Cell_ID = '$cellid'";
       $resultdelete = mysqli_query($conn, $delete);
       echo '<script>alert("'.$row["Site_code"].' site and cells deleted Successfully")</script>';   

    }

}


}
?>