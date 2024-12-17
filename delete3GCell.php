<?php 
include "config.php";
?>
<?php
if(isset($_GET['id2']))
{
    $id =$_GET['id2'];
    $sql ="SELECT * FROM 3gcells WHERE Cell_Code = '$id'";
    $sqll= "SELECT s.*, t.* , c.*   FROM new_sites s INNER JOIN 3gsites t ON(s.ID = t.Site_ID) JOIN 3gcells c ON (t.Cell_ID = c.CID) WHERE c.Cell_Code = '$id'";

    $result = mysqli_query($conn,$sql);
    $resultt = mysqli_query($conn,$sqll);

    $cancelldate = date("m-d-Y h:i:s A");

    if($row2 = mysqli_fetch_assoc($resultt)){
        $cellidkey = $row2['CID'];

        $query2 ="INSERT INTO `cancelled_cells`(Cell_ID_KEY, Cell_Code, Cell_Name, Cell_ID, Site_code, Site_name, Zone, Province, CR, Supplier, BSC, On_air_Date, Note, Serving_Area, serving_Area_IN_English)
        SELECT c.CID, c.Cell_Code, c.Cell_Name, c.Cell_ID, t.Site_code, s.Site_Name, s.Zone, s.Province, s.CR, s.Supplier, s.BSC, c.On_Air_Date, c.Note ,c.Serving_Area, c.Serving_area_In_English FROM new_sites s INNER JOIN 3gsites t ON(s.ID = t.Site_ID) INNER JOIN 3gcells c ON (t.Cell_ID = c.CID)
        WHERE (c.Cell_Code = '$id')";
        
        $resultquery12= mysqli_query($conn,$query2);


        $query3 = "UPDATE `cancelled_cells` SET `Cancelled_Date`= '$cancelldate' WHERE Cell_ID_KEY = '$cellidkey' AND Cell_Code = '$id'";
        $resultquery3= mysqli_query($conn,$query3);

        $sqll2    = "DELETE FROM 3gcells WHERE Cell_Code = '$id'";
        $resultt2 = mysqli_query($conn,$sqll2);

        if ($resultt2 === true){
          echo '<script>alert("'.$row2["Cell_Code"].'  cell deleted Successfully")</script>'; 
        }

        $sqll3 = "SELECT * FROM 3gcells WHERE CID = '$cellidkey'";
        $resultt3 = mysqli_query($conn,$sqll3);
        $num3 = mysqli_num_rows($resultt3);

        if ($num3 == 0){
            echo '<script>alert("'.$row2["Site_Code"].' 3G site will be delete.")</script>'; 


            $siteid   = $row2['Site_ID'];
            $cellid   = $row2['CID'];
            $cellcode = $row2['Cell_Code'];
            $sitecode = $row2['Site_Code'];
            $tech = "3G";
            $query ="INSERT INTO `cancelled_sites`(Site_ID, Site_Code, Site_Name, Zone, Province, CR, Supplier,  Status_Before, On_Air_Date, Note, Coordinates_E, Coordinates_N, Site_Adress, 2G_RBS)
            SELECT  s.ID, t.Site_Code, s.Site_Name,s.Zone, s.Province, s.CR, s.Supplier, t.Site_Status, t.3GOn_Air_Date, t.Notes ,s.Coordinates_E, s.Coordinates_N, s.Site_Adress ,t.Real_RNC FROM new_sites s INNER JOIN 3gsites t ON(s.ID = t.Site_ID)
            WHERE s.ID = '$siteid'";
           
           $resultquery= mysqli_query($conn,$query);
           
           $query3 =  "UPDATE `cancelled_cells` SET `Cancelled_Date`= '$cancelldate' WHERE Cell_ID_KEY= '$cellidkey' AND Cell_Code = '$cellcode'";
           $resultquery3= mysqli_query($conn,$query3);
        
           $query4 = "UPDATE `cancelled_sites` SET `Cancellation_Date`= '$cancelldate' ,`Cell_ID`= '$cellid', `Cancelled_Technologies` = '$tech' WHERE Site_ID= '$siteid' AND Site_Code ='$sitecode'";
           $resultquery4= mysqli_query($conn, $query4);


           $delete2 = "DELETE 3gsites, 3gcells FROM 3gsites INNER JOIN 3gcells ON (3gsites.Cell_ID = 3gcells.CID) WHERE 3gsites.Cell_ID = '$cellid'";
           $resultdelete2 = mysqli_query($conn, $delete2);
   
           echo '<script>alert("'.$row2["Site_Code"].' site and cells deleted Successfully")</script>';  

        }
        //header("location: Search copy.php");
        header( "Location: Search copy.php? id = $id" );
        //header("location:javascript://history.go(-1)");
        //header('Location: ' . $_SERVER['HTTP_REFERER']);


    }

}

?>