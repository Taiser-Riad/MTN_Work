<?php 
include "config.php";
?>
<?php
if(isset($_GET['id']))
{
$siteid =$_GET['id'];
$sqll= "SELECT * FROM NEW_SITES WHERE ID= :siteid";
$result = oci_parse($conn,$sqll);
oci_bind_by_name($result, ':siteid' ,$siteid);
oci_execute($result);
$row = oci_fetch_array($result , OCI_ASSOC + OCI_RETURN_NULLS);

//echo $row['SITE_CODE'];
}

if(isset($_POST['submit'])){
    $id            = $_POST['id'];
    $scode         = $_POST['sitecode'];
    $sname         = $_POST['sitename'];
    $pbackup       = $_POST['powerbackup'];
    $ondate        = $_POST['onairdate'];
    $relocdate     = "-";
    $coorE         = $_POST['coordinatesE'];
    $coorN         = $_POST['coordinatesN'];
    $alttuide      = $_POST['alttitude'];
    $siteadd       = $_POST['address'];
    $ara_name      = $_POST['arabicname'];
    $admin_area    = $_POST['adminarea'];
    $TX_node       = $_POST['txnode'];
    //$area_rank     = $_POST['arearanking'];
    //$zone =$_POST['zone'];
    $supplier      = $_POST['supplier'];
    $cityrural     = $_POST['C/R'];
    //$province =$_POST['province'];
    //$BSC = $_POST['BSC'];
    $prio          =  $_POST['priority'];
    $cat           =  $_POST['category'];
    $subcontractor =  $_POST['sub'];
    $invoice       =  $_POST['invoice'];
    $site_ranking  =  $_POST['sranking'];
    $zone          =  $_POST['Zone'];
    $province      =  $_POST['province'];


    /*$sql = "UPDATE `NEW_SITES` SET `SITE_CODE`='$scode',`SITE_NAME`='$sname',`Zone`='$zone',`Province`='$province',`CR`='$cityrural',`Supplier`='$supplier',`POWER_BACKUP`='$pbackup',`Site_On_Air_Date`='$ondate',`Coordinates_E`='$coorE',`Coordinates_N`='$coorN',`Altitude`='$alttuide',`Site_Adress`='$siteadd',`Arabic_Name`='$ara_name',`TX_Node`='$TX_node',`Technical_Priority`='$prio',`Administrative_Area`='$admin_area',`Node_Category`='$cat',`Site_Ranking`='$site_ranking',`Subcontractor`='$subcontractor',`Invoice_Tyology`='$invoice',`Area_Ranking`='$area_rank' WHERE ID = '$id'";
    $resultt = mysqli_query($conn,$sql);
    //$row_cnt = mysqli_num_rows($resultt);

    if($resultt == 1) {
        //echo '<script>alert("Data Updated Successfully")</script>';
 
    }*/


    //$search = $_POST['search'];
    //$search = "%$search%"; // Preparing the search variable for Oracle
    
    $sql = "UPDATE NEW_SITES 
            SET SITE_CODE = :scode,
                SITE_NAME = :sname,
                ZONE = :zone,
                PROVINCE = :province,
                CR = :cityrural,
                SUPPLIER = :supplier,
                POWER_BACKUP = :pbackup,
                SITE_ON_AIR_DATE = :ondate,
                COORDINATES_E = :coorE,
                COORDINATES_N = :coorN,
                ALTTITUDE = :altitude,
                SITE_ADDRESS = :siteadd,
                ARABIC_NAME = :ara_name,
                TX_NODE = :TX_node,
                TECHNICAL_PRIORITY = :prio,
                ADMINSTRITAVE_AREA = :admin_area,
                NODE_CATEGORY = :cat,
                SITE_RANKING = :site_ranking,
                SUBCONTRACTOR = :subcontractor,
                INVOICE_TOYOLOGY = :invoice
            WHERE ID = :id";
            
    $resultt = oci_parse($conn, $sql);
    
    oci_bind_by_name($resultt, ':scode', $scode);
    oci_bind_by_name($resultt, ':sname', $sname);
    oci_bind_by_name($resultt, ':zone', $zone);
    oci_bind_by_name($resultt, ':province', $province);
    oci_bind_by_name($resultt, ':cityrural', $cityrural);
    oci_bind_by_name($resultt, ':supplier', $supplier);
    oci_bind_by_name($resultt, ':pbackup', $pbackup);
    oci_bind_by_name($resultt, ':ondate', $ondate);
    oci_bind_by_name($resultt, ':coorE', $coorE);
    oci_bind_by_name($resultt, ':coorN', $coorN);
    oci_bind_by_name($resultt, ':altitude', $altitude);
    oci_bind_by_name($resultt, ':siteadd', $siteadd);
    oci_bind_by_name($resultt, ':ara_name', $ara_name);
    oci_bind_by_name($resultt, ':TX_node', $TX_node);
    oci_bind_by_name($resultt, ':prio', $prio);
    oci_bind_by_name($resultt, ':admin_area', $admin_area);
    oci_bind_by_name($resultt, ':cat', $cat);
    oci_bind_by_name($resultt, ':site_ranking', $site_ranking);
    oci_bind_by_name($resultt, ':subcontractor', $subcontractor);
    oci_bind_by_name($resultt, ':invoice', $invoice);
   // oci_bind_by_name($resultt, ':area_rank', $area_rank);
    oci_bind_by_name($resultt, ':id', $id);
    
    //oci_execute($resultt);
    
    //if ($resultt) {
        // Update was successful
        //echo '<script>alert("Data Updated Successfully")</script>';
   // }
    
   if (oci_execute($resultt)) {  
    echo "Data Updated Successfully";
 } 
   else { 
    $e = oci_error($resultt); echo "Error Updating Data: " . htmlentities($e['message']);

   }


}
?>


<!DOCTYPE html>
<html lang="en">
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href= "fontawesome-free-6.5.2-web\css\all.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> Update Site Info page </title>
<style>
.footer
{
    background: #1c355c;
    font-size: 17px;
    margin-top:10px;
    color: white;
    width: 99%;
    padding-left:10px;
    padding-bottom:10px;
    padding-top:30px;
 
 

}




.submit{
    width: 30%;
    float:right;
    
    display: flex;
 
 
}

.submit input {
    
   width: 70%;
   Height: 35px;
   font-size: 17px;
   font-weight: bold;
   margin:10px;
   border-radius: 10px;
text-align:center;
  border:none;
   color:#1c355c;

}


body
{
min-height: 100vh;
display: flex;
align-items: center;
justify-content: center;
background: goldenrod;


}

.container
{
    /*position: relative;*/

width: 60%;
background: whitesmoke;
padding-top:0;
margin-top:0px;
box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);

border:2px solid gray;
color: #1c355c;
border-radius:5px;

}
h1{
    text-align: center;
    width: 100%;
    height: 100px;
    margin-top:0;
    color: white;
    margin-bottom:0px;
    
    
}


.header {
    
    width: 100%;
    background: #1c355c;
    color: white;
    text-align: center;
    
    
}

.form1{
    margin-top: 15px;
    width: 80%;
    padding: 40px;
   
}
input {
    background-color:#e1e6ed;
    border:0.5px solid #e1e6ed;
}
select {
    background-color:#e1e6ed;
    border:0.5px solid #e1e6ed;
}
input[type=text]:focus{
    border:0.8px solid #e1e6ed;
}
input[type=select]:focus{
    border:0.8px solid #e1e6ed;

}

</style>




</head>
<body>
<div class="container">
<div class="header">
            <h1></br>Update Basic Site Informations </h1>
             Please update basic site informations .</br>
</br>
        </div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
<div class="form1">
<div>
<input type ="hidden" name ="id" value="<?php echo $siteid; ?>">
</div>

<div>
    <label for="code">Site Code:</label>
    <input type ="text" name="sitecode" size="7" id="code" value="<?php echo $row['SITE_CODE'] ?>"></br></br>

</div>

<div>
    <label for="name">Site Name:</label>
    <input type ="text" name="sitename" size="33" id="name" value="<?php echo $row['SITE_NAME'] ?>"></br></br>
</div>
<div>
    <label for="name">Zone:</label>
    <input type ="text" name="Zone" size="33" id="name" value="<?php echo $row['ZONE'] ?>"></br></br>
</div>
<div>
    <label for="name">Province:</label>
    <input type ="text" name="province" size="33" id="name" value="<?php echo $row['PROVINCE'] ?>"></br></br>
</div>



<?php 
$checked = [];
$checked[0] = (isset($row['CR']) && $row['CR'] == "City") ? 'checked' : '';
$checked[1] = isset($row['CR']) && $row['CR'] == "Rural" ? 'checked' : '';

?>

<div>
    <input type ="radio" id= "city"  name="C/R" value="City"  checked="<?php echo $checked[0];?>">City
    <input type ="radio" id= "rural" name="C/R" value="Rural" checked="<?php echo $checked[1]; ?>" >Rural</br></br>
</div>
<?php 
$checked1 = [];
$checked1[0] =    (isset($row['SUPPLIER'])    && $row['SUPPLIER'] == "Ericsson") ? 'checked' : '';
$checked1[1] =     isset($row['SUPPLIER'])    && $row['SUPPLIER'] ==  "Huawei"   ? 'checked' : '';
 
?>


<div>

    <input type ="radio" id= "erc" name="supplier" value="Ericsson" checked="<?php echo $checked1[0] ;?>">Ericsson
    <input type ="radio" id= "hu" name="supplier"  value="Huawei"   checked="<?php echo $checked1[1]; ?>">Huawei</br></br>
</div>
<div>
    <label for="power">Power Backup:</label>
    <input type ="text" name="powerbackup" size="50" id="power" value="<?php echo $row['POWER_BACKUP'] ?>"></br></br>
</div>
<div>
    <label for="air date">On Air Date:</label>
    <input type ="text" name="onairdate" size="15" id="air date" value="<?php echo $row['SITE_ON_AIR_DATE'] ?>"></br></br>
</div>
<div>
    <label for="coorE">Coordinates E:</label>
    <input type ="text" name="coordinatesE" size="10" id="coorE" value="<?php echo $row['COORDINATES_E'] ?>"></br></br>
</div>
<div>
    <label for="coorN">Coordinates N:</label>
    <input type ="text" name="coordinatesN" size="10" id="coorN" value="<?php echo $row['COORDINATES_N'] ?>"></br></br>
</div>
<div>
    <label for="Att">Alttitude:</label>
    <input type ="text" name="alttitude" size="4" id="Att" value="<?php echo $row['ALTTITUDE'] ?>"></br></br>
</div>
<div>
    <label for="address">Site Address:</label>
    <input type ="text" name="address" size="60" id="address" value="<?php echo $row['SITE_ADDRESS'] ?>"></br></br>
</div>
<div>
    <label for="arname">Arabic Name:</label>
    <span lang="Ar"><input type ="text" name="arabicname" size="60" id="arname" value="<?php echo $row['ARABIC_NAME'] ?>"></span></br></br>
</div>
<div>
    <label for="admin">Adminstrative Area:</label>
    <input type ="text" name="adminarea" size="60" id="admin" value="<?php echo $row['ADMINSTRITAVE_AREA'] ?>"></br></br>
</div>
<div>
    <label for="node">TX Node:</label>
    <input type ="text" name="txnode" size="3" id="node" value="<?php echo $row['NODE_CATEGORY'] ?>"></br></br>
</div>

<div>
    Node Category:   <select name="category">    
        <option value="Empty">--</option>  
        <option value="Normal" <?php if($row['NODE_CATEGORY'] == "Normal") echo 'Selected' ;?>>Normal</option>
        <option value="Golden" <?php if($row['NODE_CATEGORY'] == "Golden") echo 'Selected' ;?>>Golden</option>
        <option value="Silver" <?php if($row['NODE_CATEGORY'] == "Silver") echo 'Selected' ;?>>Silver</option>
        <option value="Tail"   <?php if($row['NODE_CATEGORY'] == "Tail")   echo 'Selected' ;?>>Tail</option>
    </select>
    </br></br>
</div>

<div>
    Technical Priority:   <select name="priority">    
        <option value="Empty">--</option>  
        <option value="Priority 1" <?php if($row['TECHNICAL_PRIORITY'] == "Priority 1") echo 'Selected' ;?>>Priority1</option>
        <option value="Priority 2" <?php if($row['TECHNICAL_PRIORITY'] == "Priority 2") echo 'Selected' ;?>>Priority2</option>
        <option value="Priority 3" <?php if($row['TECHNICAL_PRIORITY'] == "Priority 3") echo 'Selected' ;?>>Priority3</option>
        <option value="Priority 4" <?php if($row['TECHNICAL_PRIORITY'] == "Priority 4") echo 'Selected' ;?>>Priority4</option>
    </select>
    </br></br>
</div>

    <div>
    Subcontractor:   <select name="sub"> 
        <option value="Empty">--</option>  
        <option value="Brj"   <?php if($row['SUBCONTRACTOR'] ==  "Brj")  echo 'Selected' ;?>>Brj</option>
        <option value="Wetel" <?php if($row['SUBCONTRACTOR'] == "Wetel") echo 'Selected' ;?>>Wetel</option>
        <option value="others">Others</option>
    </select>
    </br></br>
</div>
<div>
Invoice Topology:   <select name="invoice">    
        <option value="Empty">--</option>  
        <option value="Tower / Generator / Solar and or TX Repeater" <?php if($row['INVOICE_TOYOLOGY'] == "Tower / Generator / Solar and or TX Repeater") echo 'Selected' ;?>>Tower / Generator / Solar and or TX Repeater</option>
        <option value="PTS Shelter / Indoor shelter and or TX node"  <?php if($row['INVOICE_TOYOLOGY'] == "PTS Shelter / Indoor shelter and or TX node")  echo 'Selected' ;?>>PTS Shelter / Indoor shelter and or TX node</option>
        <option value="Other"                                        <?php if($row['INVOICE_TOYOLOGY'] == "Other")                                        echo 'Selected' ;?>>Others</option>
    </select>
    </br></br>
</div>
<div>
    Site Ranking:   <select name="sranking">  
        <option value="Empty">--</option>  
        <option value="Priority 1"         <?php if($row['SITE_RANKING'] == "Priority 1")         echo 'Selected' ;?>>Priority1</option>
        <option value="Priority 1-Tourism" <?php if($row['SITE_RANKING'] == "Priority 1-Tourism") echo 'Selected' ;?>>Priority1-Tourism</option>
        <option value="Priority 2"         <?php if($row['SITE_RANKING'] == "Priority 2")         echo 'Selected' ;?>>Priority2</option>
        <option value="Priority 2-Tourism" <?php if($row['SITE_RANKING'] == "Priority 2-Tourism") echo 'Selected' ;?>>Priority2-Tourism</option>
        <option value="Priority 3"         <?php if($row['SITE_RANKING'] == "Priority 3")         echo 'Selected' ;?>>Priority3</option>
        <option value="Priority 3-Tourism" <?php if($row['SITE_RANKING'] == "Priority 3-Tourism") echo 'Selected' ;?>>Priority3-Tourism</option>
        <option value="Priority 4"         <?php if($row['SITE_RANKING'] == "Priority 4")         echo 'Selected' ;?>>Priority4</option>
        <option value="Priority 4-Tourism" <?php if($row['SITE_RANKING'] == "Priority 4-Tourism") echo 'Selected' ;?>>Priority4-Tourism</option>
        <option value="VIP"                <?php if($row['SITE_RANKING'] == "VIP")                 echo 'Selected' ;?>>VIP</option>
        <option value="VIP-Tourism"        <?php if($row['SITE_RANKING'] == "VIP-Tourism")         echo 'Selected' ;?>>VIP-Tourism</option>
    </select>
    </br></br>
</div>

</div>
<div class="footer">
<div>
<label>Select Next Page:</br></label></br>
    <label for="2g"></label>
    <input type ="radio" id= "2g" name="SiteType" value="2G"> Update 2G Site Info.
    <label for="3g"></label>
    <input type ="radio" id= "3g" name="SiteType" value="3G">Update 3G Site Info.
    <label for="4g"></label>
    <input type ="radio" id= "4g" name="SiteType" value="4G">Update 4G Site Info.
    <label for="search"></label>
    <input type ="radio" id= "search" name="SiteType" value="4G">Go back to Search Page.
    
</div>
<div class="submit">
    <input type="submit" name="submit" value="Update">
</div>
<div style="clear:both;"></div>
</div>

</form>
</div>
</body>
</html>