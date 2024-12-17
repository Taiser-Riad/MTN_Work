<?php 
include "config.php";
?>
<?php
if(isset($_GET['id14']))
{
    $id =$_GET['id14'];

    $sqll= "SELECT s.*, t.* , c.*   FROM new_sites s INNER JOIN 4gsites t ON(s.ID = t.SID)    JOIN 4gcells c ON (t.Cell_ID_KEY = c.CID_Key) WHERE s.ID = '$id'";

    $resultt = mysqli_query($conn,$sqll);
    $cancelldate = date("m-d-Y h:i:s A");



    if($row4 = mysqli_fetch_assoc($resultt)){
        $cellid   = $row4['CID_Key'];
        $cellcode = $row4['Cell_code'];
        $sitecode = $row4['Site_code'];
        $tech = "4G";
        $query ="INSERT INTO `cancelled_sites`(Site_ID, Site_Code, Site_Name, Zone, Province, CR, Supplier,  Status_Before, On_Air_Date, Note, Coordinates_E, Coordinates_N, Site_Adress)
        SELECT  s.ID, t.Site_code, s.Site_Name,s.Zone, s.Province, s.CR, s.Supplier, t.Status, t.Activation_Date, t.Note ,s.Coordinates_E, s.Coordinates_N, s.Site_Adress FROM new_sites s INNER JOIN 4gsites t ON(s.ID = t.SID)
        WHERE s.ID = '$id'";
       
       $resultquery= mysqli_query($conn,$query);
    
       $query22 ="INSERT INTO `cancelled_cells`(Cell_ID_KEY, Cell_Code, Cell_Name, Cell_ID, Site_code, Site_name, Zone, Province, CR, Supplier, BSC, On_air_Date, Note, Serving_Area, serving_Area_IN_English)
        SELECT c.CID_Key, c.Cell_code, c.Cell_Name, c.Cell_ID, t.Site_code, s.Site_Name, s.Zone, s.Province, s.CR, s.Supplier, s.BSC, c.On_Air_Date, c.Notes ,c.Serving_Area, c.serving_Area_IN_English FROM new_sites s INNER JOIN 4gsites t ON(s.ID = t.SID) INNER JOIN 4gcells c ON (t.Cell_ID_KEY = c.CID_Key)
       WHERE (c.CID_Key = '$cellid' AND s.ID = '$id')";
       
      
       $resultquery22= mysqli_query($conn,$query22);
       
       $query3  = "UPDATE `cancelled_cells` SET `Cancelled_Date`= '$cancelldate' WHERE Cell_ID_KEY= '$cellid' AND Cell_Code = '$cellcode'";
       $resultquery3= mysqli_query($conn,$query3);
    
       $query4 = "UPDATE `cancelled_sites` SET `Cancellation_Date`= '$cancelldate' ,`Cell_ID`= '$cellid' ,`Cancelled_Technologies` = '$tech'  WHERE Site_ID= '$id' AND Site_Code= '$sitecode'";
       $resultquery4= mysqli_query($conn, $query4);
    
    
    
       }
       else {
    
        echo "No 4G Site found!!";
        }


        /*$queryy = "SELECT `Cancelled_Technologies` FROM `cancelled_sites` WHERE Site_ID= '$id'";
        $resultqueryy = mysqli_query($conn,$queryy);
        $roww = mysqli_fetch_assoc($resultqueryy);

       
        if ($roww['Cancelled_Technologies'] == ' '){
         $tech = "4G";
            $insert = "INSERT INTO `cancelled_sites`(`Cancelled_Technologies`) VALUES ('$tech') WHERE Site_ID= '$id'";
            $res = mysqli_query($conn, $insert);
            }
        elseif($roww['Cancelled_Technologies']  == '2G') {
         $tech = "2G/4G";
           $updated = "UPDATE `cancelled_sites` SET  `Cancelled_Technologies`='$tech' WHERE  Site_ID= '$id'"; 
           $res = mysqli_query($conn, $updated);
        }
        elseif($roww['Cancelled_Technologies'] == '3G') {
          $tech = "3G/4G";
           $updated1 = "UPDATE `cancelled_sites` SET  `Cancelled_Technologies`='$tech' WHERE  Site_ID= '$id'";
           $res1 = mysqli_query($conn, $updated1);
        }

        elseif($roww['Cancelled_Technologies'] == '2G/3G') {
            $tech = "All";
             $updated1 = "UPDATE `cancelled_sites` SET  `Cancelled_Technologies`='$tech' WHERE  Site_ID= '$id'";
             $res1 = mysqli_query($conn, $updated1);
          }*/


        $delete1 = "DELETE 4gsites, 4gcells FROM 4gsites INNER JOIN 4gcells ON (4gsites.Cell_ID_KEY = 4gcells.CID_Key) WHERE 4gsites.Cell_ID_KEY = '$id'";
        $resultdelete1 = mysqli_query($conn, $delete1);

        echo '<script>alert("'.$row4["Site_code"].' site and cells deleted Successfully")</script>';  

       
   
                $sql1 ="SELECT *  FROM 2gsites t JOIN 2gcells c ON (t.Cell_ID = c.CID_Key)     WHERE t.Site_ID = '$id'";
                $sql2 = "SELECT * FROM 3gsites t JOIN 3gcells c ON (t.Cell_ID = c.CID)         WHERE t.Site_ID = '$id'";
       
             
                $stmt  = mysqli_query($conn, $sql1);
                $stmt1 = mysqli_query($conn ,$sql2);
             
                $num1 = mysqli_num_rows($stmt);
                $num2 = mysqli_num_rows($stmt1);
             
                if($num1 == 0 && $num2 == 0){
                    $tech1 = "All";
                    $sitecode1 = $row4['Site_code'] ;

             
                 echo '<script>alert("'.$row["Site_code"].' site and will Cancelled")</script>'; 

                 $updatetech = "UPDATE `cancelled_sites` SET `Cancelled_Technologies` = '$tech1 ' WHERE  Site_ID= '$id' AND Site_Code ='$sitecode1'";
                 $resupd = mysqli_query($conn, $updatetech);


                 $delete4 = "DELETE FROM new_sites  WHERE ID = '$id'";
                 $resultdelete3 = mysqli_query($conn, $delete4);
             
                }

}
?>