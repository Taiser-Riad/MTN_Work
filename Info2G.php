<?php 
include "config.php";
?>
<?php
if(isset($_GET['id2']))
{
$siteid =$_GET['id2'];
$sql= "SELECT s.*,  t.* , c.* FROM NEW_SITES s JOIN TWO_G_SITES t ON(s.ID = t.SITE_ID) JOIN TWO_G_CELLS c ON (t.CELL_ID = c.CID_KEY)     WHERE  t.SITE_ID = :siteid";
//$sql= "SELECT s.Site_code,  t.* FROM new_sites s JOIN TWO_G_SITES t ON(s.ID = t.Site_ID) WHERE t.Site_ID = '$siteid'";
//$sql=  "SELECT * FROM TWO_G_SITES WHERE Site_ID = '$siteid'";
$sqll= "SELECT t.* , c.* FROM  TWO_G_SITES t JOIN TWO_G_CELLS c ON (t.CELL_ID = c.CID_KEY) WHERE t.Site_ID = :siteid";

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
//if($_SERVER["REQUEST_METHOD"] == "POST")
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


<title> Update 2G Site Info page </title>
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

width: 65%;
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
    width: 95%;
    padding-left: 40px;
   
}
input {
    background-color:#e1e6ed;
    border:0.5px solid #e1e6ed;
    color:#1c355c;
}
select {
    background-color:#e1e6ed;
    border:0.5px solid #e1e6ed;
    color:#1c355c;
    opacity:1;
}
input[type=text]:focus{
    border:0.8px solid #e1e6ed;
}
input[type=select]:focus{
    border:0.8px solid #e1e6ed;

}
input[type="checkbox"][disabled][checked] {
 
    border:0.5px solid #e1e6ed;
    opacity:1;

}

input[type="radio"]:disabled:checked{
    background-color:#e1e6ed;
    border:0.5px solid #e1e6ed;
    opacity:1;

}
.field{
    background-color:#e1e6ed;
    
}


</style>


</head>
<body >
    <div class="container">
    
        <div class="header">
            <h1></br> <?php echo $row['SITE_CODE']; ?>  </h1>
            2G details Info.</br>
</br>
        </div>
     
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form1">
        <div>
            <input type ="hidden" name ="id"       value="<?php echo $siteid; ?>">
            <input type ="hidden" name ="cid"      value="<?php echo $row['CID_KEY']; ?>">
            
        </div>
        
            Select Band Width: </br>
            <?php
            $checked = [];
            $checked[0] =   isset($row['BAND']) && $row['BAND'] == "900"         ? 'checked' : '';
            $checked[1] =   isset($row['BAND']) && $row['BAND'] == "1800"        ? 'checked' : '';
            $checked[2] =   isset($row['BAND']) && $row['BAND'] == "900/1800"    ? 'checked' : '';

            ?>
            <input type ="radio" id= "option1"  name="band" value="900"     disabled  checked="<?php echo $checked[0];?>">900
            <input type ="radio" id= "option2"  name="band" value="1800"    disabled checked="<?php echo $checked[0];?>">1800
            <input type ="radio" id= "option3"  name="band" value="900/1800" disabled checked="<?php echo $checked[0];?>">900/1800</br></br>

            <div>
    <label for="air date">2G On Air Date:</label>
    <input type ="text" name="onairdate" size="15" id="air date" disabled value="<?php echo $row['TWOG_ON_AIR_DATE']; ?>"></br></br>
</div>

<div>
BTS Type:  <select name="BTS" disabled>
        
        <option value="Empty">--</option>
        <option value="Macro" <?php if($row['BTS_TYPE'] == "Macro") echo 'Selected' ;?>>Macro</option>
        <option value="Mbts"  <?php if($row['BTS_TYPE'] == "Mbts" ) echo 'Selected' ;?>>MBTS</option>
        <option value="Micro" <?php if($row['BTS_TYPE'] == "Micro") echo 'Selected' ;?>>Micro</option>
        <option value="Grd"   <?php if($row['BTS_TYPE'] == "Grd"  ) echo 'Selected' ;?>>GRD</option>
        <option value="Rdu"   <?php if($row['BTS_TYPE'] == "Rdu"  ) echo 'Selected' ;?>>RDU</option>
        
</select></br></br>
</div>

<div>
Site Status: <select name="sitestatus" disabled>
        
        <option value="Empty">--</option>
        <option value="On Air"              <?php if($row['BTS_TYPE'] == "Macro") echo 'Selected' ;?>>On Air </option>
        <option value="On Air (Stopped)"    <?php if($row['BTS_TYPE'] == "Mbts" ) echo 'Selected' ;?>>On Air (Stopped)  </option>
        <option value="On Air (Stopped_2)"  <?php if($row['BTS_TYPE'] == "Micro") echo 'Selected' ;?>>On Air (Stopped_2)</option>
        </select>
    </br></br>
</div>

<div>
    900 GSM RBS Type:   
    <select name="900Rbs" disabled> 
        <option value="">--</option>       
        <option value="BTS3900"  <?php if($row['NINTY_GSM_RBS_TYPE'] == "BTS3900") echo 'Selected' ;?>>BTS3900</option>
        <option value="DBS3900"  <?php if($row['NINTY_GSM_RBS_TYPE'] == "DBS3900") echo 'Selected' ;?>>DBS3900</option>
        <option value="DBS5900"  <?php if($row['NINTY_GSM_RBS_TYPE'] == "DBS5900") echo 'Selected' ;?>>DBS5900</option>
        <option value="BTS3900A" <?php if($row['NINTY_GSM_RBS_TYPE'] == "BTS3900A")echo 'Selected' ;?>>BTS3900A</option>
        <option value="BTS3900L" <?php if($row['NINTY_GSM_RBS_TYPE'] == "BTS3900L")echo 'Selected' ;?>>BTS3900L</option>
        <option value="6102"     <?php if($row['NINTY_GSM_RBS_TYPE'] == "6102")    echo 'Selected' ;?>>6102</option>
        <option value="6130"     <?php if($row['NINTY_GSM_RBS_TYPE'] == "6130")    echo 'Selected' ;?>>6130</option>
        <option value="6150"     <?php if($row['NINTY_GSM_RBS_TYPE'] == "6150")    echo 'Selected' ;?>>6150</option>
        <option value="6201"     <?php if($row['NINTY_GSM_RBS_TYPE'] == "6201")    echo 'Selected' ;?>>6201</option>
        <option value="6301"     <?php if($row['NINTY_GSM_RBS_TYPE'] == "6301")    echo 'Selected' ;?>>6301</option>
        <option value="2109"     <?php if($row['NINTY_GSM_RBS_TYPE'] == "2109")    echo 'Selected' ;?>>2109</option>
        <option value="2111"     <?php if($row['NINTY_GSM_RBS_TYPE'] == "2111")    echo 'Selected' ;?>>2111</option>
        <option value="2116"     <?php if($row['NINTY_GSM_RBS_TYPE'] == "2116")    echo 'Selected' ;?>>2116</option>
        <option value="2206"     <?php if($row['NINTY_GSM_RBS_TYPE'] == "2206")    echo 'Selected' ;?>>2206</option>
        <option value="2216"     <?php if($row['NINTY_GSM_RBS_TYPE'] == "2216")    echo 'Selected' ;?>>2216</option>
        <option value="2302"     <?php if($row['NINTY_GSM_RBS_TYPE'] == "2302")    echo 'Selected' ;?>>2302</option>
        <option value="2308"     <?php if($row['NINTY_GSM_RBS_TYPE'] == "2308")    echo 'Selected' ;?>>2308</option>

    </select>
    </br></br>

    <label for="air date1">900 On Air Date:</label>
    <input type ="text" name="900onairdate"  size="15" id="air date1" disabled value="<?php echo $row['NINTY_ON_AIR_DATE']; ?>"></br></br>
</div>

    <div>
    1800 GSM RBS Type:   
    <select name="1800Rbs" disabled> 
        
        <option value="">--</option>
        <option value="BTS3900"  <?php if($row['EIGHTY_GSM_RBS_TYPE']  == "BTS3900") echo 'Selected' ;?>>BTS3900</option>
        <option value="DBS3900"  <?php if($row['EIGHTY_GSM_RBS_TYPE'] == "DBS3900") echo 'Selected' ;?>>DBS3900</option>
        <option value="DBS5900"  <?php if($row['EIGHTY_GSM_RBS_TYPE'] == "DBS5900") echo 'Selected' ;?>>DBS5900</option>
        <option value="BTS3900A" <?php if($row['EIGHTY_GSM_RBS_TYPE'] == "BTS3900A")echo 'Selected' ;?>>BTS3900A</option>
        <option value="BTS3900L" <?php if($row['EIGHTY_GSM_RBS_TYPE'] == "BTS3900L")echo 'Selected' ;?>>BTS3900L</option>
        <option value="6102"     <?php if($row['EIGHTY_GSM_RBS_TYPE'] == "6102")    echo 'Selected' ;?>>6102</option>
        <option value="6130"     <?php if($row['EIGHTY_GSM_RBS_TYPE'] == "6130")    echo 'Selected' ;?>>6130</option>
        <option value="6150"     <?php if($row['EIGHTY_GSM_RBS_TYPE'] == "6150")    echo 'Selected' ;?>>6150</option>
        <option value="6201"     <?php if($row['EIGHTY_GSM_RBS_TYPE'] == "6201")    echo 'Selected' ;?>>6201</option>
        <option value="6301"     <?php if($row['EIGHTY_GSM_RBS_TYPE'] == "6301")    echo 'Selected' ;?>>6301</option>
        <option value="2109"     <?php if($row['EIGHTY_GSM_RBS_TYPE'] == "2109")    echo 'Selected' ;?>>2109</option>
        <option value="2111"     <?php if($row['EIGHTY_GSM_RBS_TYPE'] == "2111")    echo 'Selected' ;?>>2111</option>
        <option value="2116"     <?php if($row['EIGHTY_GSM_RBS_TYPE'] == "2116")    echo 'Selected' ;?>>2116</option>
        <option value="2206"     <?php if($row['EIGHTY_GSM_RBS_TYPE'] == "2206")    echo 'Selected' ;?>>2206</option>
        <option value="2216"     <?php if($row['EIGHTY_GSM_RBS_TYPE'] == "2216")    echo 'Selected' ;?>>2216</option>
        <option value="2302"     <?php if($row['EIGHTY_GSM_RBS_TYPE'] == "2302")    echo 'Selected' ;?>>2302</option>
        <option value="2308"     <?php if($row['EIGHTY_GSM_RBS_TYPE'] == "2308")    echo 'Selected' ;?>>2308</option>

    </select>
    </br></br>

    <label for="air date2">1800 On Air Date:</label>
    <input type ="text" name="1800onairdate" size="15"  id="air date2" disabled value="<?php echo $row['EIGHTY_ON_AIR_DATE']; ?>"></br></br>    
    </div>

<div>

    BSC:   <select name="BSC" disabled>    

                <option value="Empty">--</option>  
                <option value="EVOBSC1">EVOBSC1</option>
                <option value="EVOBSC2">EVOBSC2</option>
                <option value="EVOBSC4">EVOBSC4</option>
                <option value="EVOBSC5">EVOBSC5</option>
                <option value="EVOBSC6">EVOBSC6</option>
                <option value="EVOBSC9">EVOBSC9</option>
                <option value="HDBSC1"> HDBSC1 </option>
                <option value="HDBSC2"> HDBSC2 </option>
                <option value="HBSC1">  HBSC1  </option>
                <option value="HBSC2">  HBSC2  </option>
                <option value="HBSC4">  HBSC4  </option>
                <option value="HBSC7">  HBSC7  </option>
                <option value="HBSC8">  HBSC8  </option>
                <option value="HBSC10"> HBSC10 </option>
                <option value="HBSC11"> HBSC11 </option>
                <option value="HSKBSC2">HSKBSC2</option>
          
            

    </select>
    </br></br>
</div>
<div>
    <label for="lac">Real BSC:</label>
    <input type ="text" name="realBSC" size="15"  id="RBSC" disabled value="<?php echo $row['REAL_BSC']; ?>"></br></br>
</div>
<div>
    <label for="lac">LAC:</label>
    <input type ="text" name="lac" size="4"  id="lac" disabled value="<?php echo $row['LAC']; ?>"></br></br>
</div>
<div>
    <label for="note1">Site Notes:</label>
    <input type ="text" name="snotes" size="75"  id="note1" disabled value="<?php echo $row['NOTES']; ?>"></br></br>
</div>

Select Cells:</br>
<?php 
foreach (['A','B','C','X','Y','Z','D','W','V','E'] as $letter) : ?>


<div>


</br>
    <input type = "checkbox" name="cell[]"   disabled  value="<?= $letter ?>" <?php if ( $data[$letter]) echo 'checked'; ?> ><?= $letter ?>

    <input type ="text"      name="cellid"   size="4"  placeholder="Cell ID"              disabled      value = "<?= $data[$letter]['CELL_ID']?? '' //echo CELL_ID and if it is null echo ''?>">
    <input type ="text"      name="cellcode" size="5"  placeholder="Cell Code"            disabled      value = "<?= $data[$letter]['CELL_CODE']?? '' ?>" >
    <input type ="text"      name="cellname" size="15"  placeholder="Cell Name"           disabled      value = "<?= $data[$letter]['CELL_NAME']?? '' ?>" >
    <input type ="text"      name="azimuth"  size="3"  placeholder="Azimuth"              disabled      value = "<?= $data[$letter]['AZIMUTH']?? '' ?>" >
    <input type ="text"      name="celldate" size="6"  placeholder="On Air Date"          disabled      value = "<?= $data[$letter]['CELL_ON_AIR_DATE']?? '' ?>" >
    <input type ="text"      name="height"   size="3"  placeholder="Height"               disabled      value = "<?= $data[$letter]['HIEGHT']?? '' ?>">
    <input type ="text"      name="BSIC"     size="3"  placeholder="BSIC"                 disabled      value = "<?= $data[$letter]['BSIC']?? '' ?>">
    <input type ="text"      name="BCCH"     size="3"  placeholder="BCCH"                 disabled      value = "<?= $data[$letter]['BCCH']?? '' ?>">
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
