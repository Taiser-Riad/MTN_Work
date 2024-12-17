<?php 
include "config.php";
?>
<?php
if(isset($_GET['id3']))
{
$siteid =$_GET['id3'];

$sql ="SELECT s.* , t.* , c.* FROM NEW_SITES s JOIN THREE_G_SITES t ON(s.ID = t.SITE_ID) JOIN THREE_G_CELLS c ON (t.CELL_ID = c.CID)   WHERE  t.SITE_ID = :siteid";

$sqll="SELECT t.* , c.* FROM  THREE_G_SITES t JOIN THREE_G_CELLS c ON (t.CELL_ID = c.CID)   WHERE  t.SITE_ID = :siteid";
$result = oci_parse($conn,$sql);
oci_bind_by_name($result ,':siteid' ,$siteid);
oci_execute($result);
$row = oci_fetch_array($result , OCI_ASSOC + OCI_RETURN_NULLS);

$resultt = oci_parse($conn,$sqll);
oci_bind_by_name($resultt ,':siteid' ,$siteid);


if (oci_execute($resultt)){
//define array with keys to store the fetching result for each cell in it
$data = [
    'A' => null,
    'B' => null,
    'C' => null,
    'D' => null,
    'X' => null,
    'Y' => null,
    'Z' => null,
    'W' => null,
    'V' => null,
    'E' => null,

];
    
   
    while ($row1 = oci_fetch_array($resultt , OCI_ASSOC + OCI_RETURN_NULLS)){
      
        //Get The Letter of Cell Code
        $cellcode_char  =substr($row1['CELL_CODE'],-1);
        //search in $data array to find one of this letters
        if (in_array($cellcode_char , ['A','B','C','D','X','Y','Z','D','W','V','E'])){
            //store th row from fetching result in array due to letter  
            $data[$cellcode_char] = $row1;
        }
      
    
    }

}

}
    ?>
    <?php    

if(isset($_POST['submit']))
{


 
    }

?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href= "fontawesome-free-6.5.2-web\css\all.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> 3G Site page </title>

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
    
   float : right; 
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
            <h1></br>  <?php echo $row['SITE_CODE']; ?>  </h1>
              3G details Info.</br>
</br>
        </div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<div class="form1">
<div>
<input type ="hidden" name ="id" value="<?php echo $siteid; ?>">
Site Code:<input type ="text" name ="sitecode" disabled value="<?php echo $row['SITE_CODE']; ?>"></br></br>
Site Name:<input type ="text" name ="sitename" disabled value="<?php echo $row['SITE_NAME']; ?>"></br></br>
</div>
<div>
    <label for="wbts">WBTS ID:</label>
    <input type ="text" name="wbts" size="5" id="wbts" disabled value="<?php echo $row['WBTS_TYPE']; ?>" ></br></br>
</div>

<div>
    RNC:   <select name="RNC" disabled value="<?php echo $row['RNC']; ?>">    
        <option value="">--</option>
        <option value="">RNC_ALP2 </option>
        <option value="">RNC_ALP3 </option>
        <option value="">RNC_ALP4 </option>
        <option value="">RNC_Hama </option>
        <option value="">RNC_Homs2</option>
        <option value="">RNC_TRS1 </option>
        <option value="">RNC_TRS4 </option>
        <option value="">RNC3_LTK </option>
        <option value="">HBSC2_Thawra</option>
        <option value="">HBSC4_DahietKudsaya</option>
        <option value="">HBSC7_Swaida</option>
        <option value="">HBSC8_Daraa </option>
        <option value="">HBSC10_YouthCity</option>
        <option value="">HBSC11_DahietQudsaya</option>
    </select>
    </br></br>
</div>



<div>
    <label for="air date">3G On Air Date:</label>
    <input type ="text" name="onairdate" size="15" id="air date" disabled value="<?php echo $row['THREE_G_ON_AIR_DATE']; ?>"></br></br>
</div>

<div>
    BTS Type:   <select name="bts" disabled value="<?php echo $row['BTS_TYPE']; ?>"> 
        <option value="">--</option>       
        <option value="">3206</option>
        <option value="">6102</option>
        <option value="">6130</option>
        <option value="">6150</option>
        <option value="">6201</option>
        <option value="">6601</option>

    </select>
    </br></br>
</div>
<div>
    <label for="carry">Numbers Of Carries:</label>
    <input type ="text" name="numcarriers" size="3" id="carry" disabled value="<?php echo $row['NUMBER_OF_CARRIERS']; ?>"></br></br>
</div>

<div>
    <label for="rest">Restoration Date:</label>
    <input type ="text" name="restoration" size="15" id="rest" disabled value="<?php echo $row['RESTORATION_DATE']; ?>"></br></br>
</div>
<div>
<label for="lac">LAC:</label>
    <input type ="text" name="lac" size="4" id="lac" disabled value="<?php echo $row['LAC']; ?>"></br></br>
</div>







<label for="note1">Site Notes:</label>
    <input type ="text" name="snotes" size="75" id="note1" disabled value="<?php echo $row['NOTES']; ?>"></br></br>

Select Cells:</br>
<?php 
foreach (['A','B','C','X','Y','Z','D','W','V','E'] as $letter) : ?>


<div>


</br>
    <input type = "checkbox" name="cell[]"   disabled  value="<?= $letter ?>" <?php if ( $data[$letter]) echo 'checked'; ?> ><?= $letter ?>

    <input type ="text"      name="cellid"   size="4"  placeholder="Cell ID"              disabled      value = "<?= $data[$letter]['CELL_ID']?? '' //echo cell_id and if it is null echo ''?>">
    <input type ="text"      name="cellcode" size="5"  placeholder="Cell Code"            disabled      value = "<?= $data[$letter]['CELL_CODE']?? '' ?>" >
    <input type ="text"      name="cellname" size="15"  placeholder="Cell Name"           disabled      value = "<?= $data[$letter]['CELL_NAME']?? '' ?>" >
    <input type ="text"      name="azimuth"  size="3"  placeholder="Azimuth"              disabled      value = "<?= $data[$letter]['AZIMUTH']?? '' ?>" >
    <input type ="text"      name="celldate" size="6"  placeholder="On Air Date"          disabled      value = "<?= $data[$letter]['ON_AIR_DATE']?? '' ?>" >
    <input type ="text"      name="height"   size="3"  placeholder="Height"               disabled      value = "<?= $data[$letter]['HIEGHT']?? '' ?>">
    <input type ="text"      name="mtilt"    size="3"  placeholder="M_TILT"               disabled      value = "<?= $data[$letter]['M_TILT']?? '' ?>">
    <input type ="text"      name="etilt"    size="3"  placeholder="E_TILT"               disabled      value = "<?= $data[$letter]['E_TILT']?? '' ?>"></br>
    <input type ="text"      name="area1"    size="20" placeholder="Arabic Serving Area"  disabled      value = "<?= $data[$letter]['SERVING_AREA']?? '' ?>">
    <input type ="text"      name="area2"    size="20" placeholder="English Serving Area" disabled      value = "<?= $data[$letter]['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
    <input type ="text"      name="cnotes"   size="75" placeholder="Note"                 disabled      value = "<?= $data[$letter]['NOTE']?? '' ?>">

</div>
<?php endforeach; ?>
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