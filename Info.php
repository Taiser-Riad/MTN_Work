<?php 
include "config.php";
?>
<?php
if(isset($_GET['id2']))
{
    $siteid =$_GET['id2'];
    $sqll= "SELECT * FROM NEW_SITES WHERE ID= :siteid";
    $result = oci_parse($conn,$sqll);
    oci_bind_by_name($result ,':siteid' ,$siteid);
    oci_execute($result);
    $row = oci_fetch_array($result , OCI_ASSOC + OCI_RETURN_NULLS);
}


?>
<?php
 if(isset($_POST['submit'])){
    header("location:Search.php?id=$ID");
 }
?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href= "fontawesome-free-6.5.2-web\css\all.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> Add Site page </title>
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
    width: 20%;
    
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
    color:#1c355c;
    opacity: 1;
}
select {
    background-color:#e1e6ed;
    border:0.5px solid #e1e6ed;
    color:#1c355c;
    opacity: 1;
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
            <h1></br> <?php echo $row['SITE_CODE']; ?> </h1>
            Basic Info</br>
</br>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<div class="form1">
<div>
<input type ="hidden" name ="id" value="<?php echo $siteid; ?>">
</div>

<div>
    <label for="code">Site Code:</label>
    <input type ="text" name="sitecode" size="7" id="code" disabled  value="<?php echo $row['SITE_CODE'] ?>"></br></br>

</div>

<div>
    <label for="name">Site Name:</label>
    <input type ="text" name="sitename" size="33" id="name" disabled value="<?php echo $row['SITE_NAME'] ?>"></br></br>
</div>
<div>
    <label for="name">Zone:</label>
    <input type ="text" name="Zone" size="33" id="name" disabled value="<?php echo $row['ZONE'] ?>"></br></br>
</div>
<div>
    <label for="name">Province:</label>
    <input type ="text" name="province" size="33" id="name" disabled value="<?php echo $row['PROVINCE'] ?>"></br></br>
</div>



<?php 
//$checked = [];
//$checked[0] = (isset($row['CR']) && $row['CR'] == "City") ? 'checked' : '';
//$checked[1] = isset($row['CR']) && $row['CR'] == "Rural" ? 'checked' : '';
//<input type ="radio" id= "rural" name="C/R" value="Rural" disabled checked="<?php echo $checked[1]; " >Rural</br></br>

?>

<div>
   City /Rural: <input type ="text" id= "city"  name="C/R"  disabled value="<?php echo $row['CR'];?>"></br></br>
</div>
<?php 
$checked1 = [];
$checked1[0] =    (isset($row['SUPPLIER'])    && $row['SUPPLIER'] == "Ericsson") ? 'checked' : '';
$checked1[1] =     isset($row['SUPPLIER'])    && $row['SUPPLIER'] ==  "Huawei"   ? 'checked' : '';
 
?>


<div>

Supplier:   <input type ="text" id= "erc" name="supplier" v disabled value="<?php echo $row['SUPPLIER'] ;?>"></br></br>
</div>
<div>
    <label for="power">Power Backup:</label>
    <input type ="text" name="powerbackup" size="50" id="power" disabled value="<?php echo $row['POWER_BACKUP'] ?>"></br></br>
</div>
<div>
    <label for="air date">On Air Date:</label>
    <input type ="text" name="onairdate" size="15" id="air date" disabled value="<?php echo $row['SITE_ON_AIR_DATE'] ?>"></br></br>
</div>
<div>
    <label for="coorE">Coordinates E:</label>
    <input type ="text" name="coordinatesE" size="10" id="coorE" disabled value="<?php echo $row['COORDINATES_E'] ?>"></br></br>
</div>
<div>
    <label for="coorN">Coordinates N:</label>
    <input type ="text" name="coordinatesN" size="10" id="coorN" disabled value="<?php echo $row['COORDINATES_N'] ?>"></br></br>
</div>
<div>
    <label for="Att">Alttitude:</label>
    <input type ="text" name="alttitude" size="4" id="Att" disabled value="<?php echo $row['ALTTITUDE'] ?>"></br></br>
</div>
<div>
    <label for="address">Site Address:</label>
    <input type ="text" name="address" size="60" id="address" disabled value="<?php echo $row['SITE_ADDRESS'] ?>"></br></br>
</div>
<div>
    <label for="arname">Arabic Name:</label>
    <span lang="Ar"><input type ="text" name="arabicname" size="60" id="arname" disabled value="<?php echo $row['ARABIC_NAME'] ?>"></span></br></br>
</div>
<div>
    <label for="admin">Adminstrative Area:</label>
    <input type ="text" name="adminarea" size="60" id="admin" disabled value="<?php echo $row['ADMINSTRITAVE_AREA'] ?>"></br></br>
</div>
<div>
    <label for="node">TX Node:</label>
    <input type ="text" name="txnode" size="3" id="node" disabled value="<?php echo $row['NODE_CATEGORY'] ?>"></br></br>
</div>

<div>
    Node Category:   <select name="category" disabled>    
        <option value="Empty">--</option>  
        <option value="Normal" <?php if($row['NODE_CATEGORY'] == "Normal") echo 'Selected' ;?>>Normal</option>
        <option value="Golden" <?php if($row['NODE_CATEGORY'] == "Golden") echo 'Selected' ;?>>Golden</option>
        <option value="Silver" <?php if($row['NODE_CATEGORY'] == "Silver") echo 'Selected' ;?>>Silver</option>
        <option value="Tail"   <?php if($row['NODE_CATEGORY'] == "Tail")   echo 'Selected' ;?>>Tail</option>
    </select>
    </br></br>
</div>

<div>
    Technical Priority:   <select name="priority" disabled>    
        <option value="Empty">--</option>  
        <option value="Priority 1" <?php if($row['TECHNICAL_PRIORITY'] == "Priority 1") echo 'Selected' ;?>>Priority1</option>
        <option value="Priority 2" <?php if($row['TECHNICAL_PRIORITY'] == "Priority 2") echo 'Selected' ;?>>Priority2</option>
        <option value="Priority 3" <?php if($row['TECHNICAL_PRIORITY'] == "Priority 3") echo 'Selected' ;?>>Priority3</option>
        <option value="Priority 4" <?php if($row['TECHNICAL_PRIORITY'] == "Priority 4") echo 'Selected' ;?>>Priority4</option>
    </select>
    </br></br>
</div>

    <div>
    Subcontractor:   <select name="sub" disabled> 
        <option value="Empty">--</option>  
        <option value="Brj"   <?php if($row['SUBCONTRACTOR'] ==  "Brj")  echo 'Selected' ;?>>Brj</option>
        <option value="Wetel" <?php if($row['SUBCONTRACTOR'] == "Wetel") echo 'Selected' ;?>>Wetel</option>
        <option value="others">Others</option>
    </select>
    </br></br>
</div>
<div>
Invoice Topology:   <select name="invoice" disabled>    
        <option value="Empty">--</option>  
        <option value="Tower / Generator / Solar and or TX Repeater" <?php if($row['INVOICE_TYOLOGY'] == "Tower / Generator / Solar and or TX Repeater") echo 'Selected' ;?>>Tower / Generator / Solar and or TX Repeater</option>
        <option value="PTS Shelter / Indoor shelter and or TX node"  <?php if($row['INVOICE_TYOLOGY'] == "PTS Shelter / Indoor shelter and or TX node")  echo 'Selected' ;?>>PTS Shelter / Indoor shelter and or TX node</option>
        <option value="Other"                                        <?php if($row['INVOICE_TYOLOGY'] == "Other")                                        echo 'Selected' ;?>>Others</option>
    </select>
    </br></br>
</div>
<div>
    Site Ranking:   <select name="sranking" disabled>  
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

<div class="submit">
    <input type="submit" name="submit" value="Done">
</div>
<div style="clear:both;"></div>
</div>

</form>
</div>
</body>
</html>