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

//$sitecode = $row['SITE_CODE'];
}

if(isset($_POST['submit'])){

        // Debugging output

    $sid         = $_POST ['id'] ?? '';
    $sitecode    = $_POST['sitecode'];
    $serial      = $_POST['serial'] ?? '';
    $counter     = $_POST['counter'] ?? '';
    $cowner      = $_POST['cowner'] ?? '';
    $cpower      = $_POST['cpower'] ?? '';
    $cabtype     = $_POST['cabtype'] ?? '';
    $HIP         = $_POST['HIP'] ?? '';
    $DIP         = $_POST['DIP'] ?? '';
    $EIP         = $_POST['EIP'] ?? '';
    $ACqty       = $_POST ['ACqty'] ?? '';
    $solarqty    = $_POST['solarqty'];
    $cabinetcage = $_POST['cabinetcage'] ?? '';
    $cabnote     = $_POST['cabnote'] ?? '';
    $Gen         = $_POST['Gen'] ?? '';
    $gen_brand   = $_POST['gen_brand'] ?? '';
    $engine_brand = $_POST['engine_brand'] ?? '';
    $status      = $_POST['status'] ?? '';
    $ownership   = $_POST['ownership'] ?? '';
    $capacity    = $_POST['capacity'] ?? '';
    $qty         = $_POST ['qty'] ?? '';
    $cage        = $_POST['cage'];
    $tank1       = $_POST['tank1'] ?? '';
    $t1shape     = $_POST['t1shape'] ?? '';
    $t1type      = $_POST['t1type'] ?? '';
    $t1volume    = $_POST['t1volume'] ?? '';
    $t1height    = $_POST['t1height'] ?? '';
    $t1width     = $_POST['t1width'] ?? '';
    $t1length    = $_POST['t1length'] ?? '';
    $t1max       = $_POST['t1max'] ?? '';
    $tank2       = $_POST['tank2'] ?? '';
    $t2shape     = $_POST['t2shape'] ?? '';
    $t2type      = $_POST['t2type'] ?? '';
    $t2volume    = $_POST['t2volume'] ?? '';
    $t2height    = $_POST['t2height'] ?? '';
    $t2width     = $_POST['t2width'] ?? '';
    $t2length    = $_POST['t2length'] ?? '';
    $t2max       = $_POST['t2max'] ?? '';
    $tank3       = $_POST['tank3'] ?? '';
    $t3shape     = $_POST['t3shape'] ?? '';
    $t3type      = $_POST['t3type'] ?? '';
    $t3volume    = $_POST['t3volume'] ?? '';
    $t3height    = $_POST['t3height'] ?? '';
    $t3width     = $_POST['t3width'] ?? '';
    $t3length    = $_POST['t3length'] ?? '';
    $t3max       = $_POST['t3max'] ?? '';

    $Hyprid      = $_POST['Hyprid'] ?? '';
    $solartype   = $_POST['solartype'] ?? '';
    $solarstatus = $_POST['solarstatus'] ?? '';
    $solarqty    = $_POST['solarqty'] ?? '';
    $solarcapacity= $_POST['solarcapacity'] ?? '';
    $solarmodqty = $_POST['solarmodqty'] ?? '';
    $solarownership= $_POST['solarownership'] ?? '';
    //$NonRationig = $_POST['NonRationig'] ?? '';
    $Ampere      = $_POST['Ampere'] ?? '';
    $ampcapacity = $_POST['ampcapacity'] ?? '';
    $ampduration = $_POST['ampduration'] ?? '';
    $B1Battaries = $_POST['B1Battaries'] ?? '';
    $b1status    = $_POST['b1status'] ?? '';
    $b1type      = $_POST['b1type'] ?? '';
    $b1capacity  = $_POST['b1capacity'] ?? '';
    $b1brand     = $_POST['b1brand'] ?? '';
    $b1qty       = $_POST['b1qty'] ?? '';
    $b1b1date    = $_POST['b1b1date'] ?? '';
    $B2Battaries = $_POST['B2Battaries'] ?? '';
    $b2status    = $_POST['b2status'] ?? '';
    $b2type      = $_POST['b2type'] ?? '';
    $b2capacity  = $_POST['b2capacity'] ?? '';
    $b2brand     = $_POST['b2brand'] ?? '';
    $b2qty       = $_POST['b2qty'] ?? '';
    $b2b1date    = $_POST['b2b1date'] ?? '';

    






    }





?>


<!DOCTYPE html>
<html>
<head>
    <title>Power Backup</title>
    <style>
  .content-div {
    display: none;
}
.content-cont{
    display: none;
}
#option1:checked ~ #content-container #div1 {
    display: block;
}
#option1:checked ~ #container2 #div4 {
    display: block;
}
#option2:checked ~ #content-container #div2 {
    display: block;
}
#option2:checked ~ #container2 #div5 {
    display: block;
}
#option3:checked ~ #content-container #div3 {
    display: block;
}
#option3:checked ~ #container2 #div6 {
    display: block;
}
.content-div {
    transition: all 0.5s ease-in-out;
}

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


.submit1{
    width: 20%;
    
   float:left; 
   display: flex;
 
 
}
.submit1 button {
    
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

 .submit1 input {
    
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
input[type="radio"].custom {
  display: none;
}

/* Create a custom radio button for elements with the custom class */
input[type="radio"].custom + label.custom-label {
  display: inline-block;
  padding: 7px 18px;
  margin: 5px;
  cursor: pointer;
  
  border-radius: 8px;
  background-color: #ffffff;
  color: #1c355c;
  transition: background-color 0.3s, color 0.3s;
  font-size:bold;
}

/* Style the selected state for elements with the custom class */
input[type="radio"].custom:checked + label.custom-label {
  background-color: #0056b3;
  color: #ffffff;
  border-color: #007BFF;
  border:2px solid white;
}
.required-field::after {
            content: " *";
            color: goldenrod;
        }
        @media (max-width: 600px) {
            body {
                font-size: 14px;
            }
        }

        .error {
            border: 2px solid red;
        }






        .sub-options {
            display: none;
            margin-left: 20px;
        }

  .filter {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: space-between;}
  

    .filter div {
    flex: 1 1 calc(16.6% - 10px);
    min-width: 200px;
}


.filter label {
    display: block;
    font-weight: bold;
    margin-bottom: 8px;
    color: #1c355c;
    font-size: small;
}

 label {
    display: block;
    font-weight: bold;
    margin-bottom: 8px;
    color: #1c355c;
    font-size: small;
}

.filter select,
.filter input[type="text"],
.filter input[type="number"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccd0d4;
    border-radius: 25px;
    background-color: #d7e0ee;
    font-size: 13px;
    color: #1c355c;
    transition: border-color 0.3s, box-shadow 0.3s;
}

 select,
 input[type="text"],
 input[type="number"] {
    width: 60%;
    padding: 10px;
    margin-left:30px;
    border: 1px solid #ccd0d4;
    border-radius: 15px;
    background-color: #d7e0ee;
    font-size: 13px;
    color: #1c355c;
    transition: border-color 0.3s, box-shadow 0.3s;
}
.filter select:focus,
.filter input[type="text"]:focus,
.filter input[type="number"]:focus {
    border-color: #80bdff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    outline: none;
}

select:focus,
input[type="text"]:focus,
input[type="number"]:focus {
    border-color: #80bdff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    outline: none;
}



.filter h3,
.filter h4 {
    font-size: 1em;
    margin-bottom: 5px;
    color: #1c355c;
}
h3,
h4 {
    font-size: 1em;
    margin-bottom: 5px;
    color: #1c355c;
}

    </style>
    <script>
        function toggleSubOptions(id) {
            var div = document.getElementById('sub_' + id);
            if (document.getElementById(id).checked) {
                div.style.display = 'block';
            } else {
                div.style.display = 'none';
                // Uncheck all inside if hidden
                var checkboxes = div.querySelectorAll('input[type=checkbox]');
                checkboxes.forEach(cb => cb.checked = false);
            }
        }

        function confirmupdate(){
        return confirm ("Are you sure you want to update power backup?" );
     
    }
    </script>
</head>
<body>

<div class="container">
<div class="header">
            <h1></br> <?php echo $row['SITE_CODE']; ?> </h1>
             POWER BACKUP.</br>
</br>
        </div>
<form id="myForm" action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit="return confirmupdate();">
<div class="form1">
<div>
        <input type ="hidden" name ="id"       value="<?php echo $siteid; ?>">
        <input type ="hidden" name ="sitecode" value="<?php echo $row['SITE_CODE']; ?>">

</div>
<!-- <div class="filter"> -->
<div>
<h3> Electrical Counter Info:</h3><br>
<div>
<div>
  <!-- <label> Serial Number</label> -->
  <input type ="text" name="serial" placeholder ="Serial Number"><br><br>
  <!-- <label> Counter Circuit Breaker</label> -->
  <input type ="text" name="counterbraker" placeholder ="Counter Circuit Breaker"><br><br>
</div>

<label>Counter Status:</label>
  <div>
  <select name="cstatus">

   <option value="cBad">Bad</option>
   <option value="cGood">Good</option>
   <option value="cNeed replace">Need replace</option>
   <option value="cNeed Overhauling">Need Overhauling</option>
   
</select>
  </div><br>

  <label>Counter Ownership:</label>
  <div>
  <select name="cowner">

   <option value="MTN">MTN</option>

</select>
  </div><br>

  <label>Power Type:</label>
  <div>
  <select name="cpower">
  <option value="Three phase">Three phase </option>
   <option value="Mono phase">Mono phase </option>

</select>
  </div><br>



</div>


<h3> Cabinet Info:</h3><br>
<div>

<label> Cabinet Type:</label>
<div>
   <select name="cabtype">
   
                      <option value="Delta">Delta</option>
                      <option value="Ericsson">Ericsson</option>
                      <option value="Huawei">Huawei</option>
                      <option value="Eltek">Eltek</option>
                  </select>
  
  </div><br>
  <label> Rectifier Type:</label>
  <div>
   <select name="rectype">
   
                      <option value="Delta">Delta</option>
                      <option value="Ericsson">Ericsson</option>
                      <option value="ETP48200">ETP48200</option>
                      <option value="Eltek">Eltek</option>
                  </select>
  
  </div><br>

  <div>
  <!-- <label> Huawei IP</label> -->
  <input type ="text" name="HIP" size="5" placeholder="Huawei IP"><br><br>
</div>

<div>
  <!-- <label> Delta IP</label> -->
  <input type ="text" name="DIP" size="5" placeholder="Delta IP"><br><br>
</div>

<div>
  <!-- <label> ELTEK IP</label> -->
  <input type ="text" name="EIP" size="5" placeholder="ELTEK IP"><br><br>
</div>

  <!-- <label> AC Module Quantity</label> -->
  <input type ="text" name="ACqty" size="5" placeholder="AC Module Quantity"><br><br>
<!-- 
<label> Solar Module Quantity</label> -->
  <input type ="text" name="solarqty" size="5" placeholder="Solar Module Quantity"><br><br>


  <label>Cabinet Cage:</label>
  <div><br>
<input type ="radio" name= "cabinetcage"> Yes 
<input type ="radio" name= "cabinetcage"> No 
  </div><br>
  <label> Note</label>
  <input type ="text" name="cabnote" size="5"><br><br>

</div>





<h3> Generator Info:</h3><br>
<label><input type="checkbox" name="Gen" id="main1" onclick="toggleSubOptions('main1')"> Generator</label><br>
<div id="sub_main1" class="sub-options">
   
 
    

      <label> Brand:</label>
      <div>
     <select name="gen_brand">
    
                        <option value="Paknika">Paknika</option>
                        <option value="Sdmo">Sdmo</option>
                        <option value="Saccal">Saccal</option>
                        <option value="Trion">Trion</option>
                        <option value="Green Power">Green Power</option>
                        <option value="Telegen">Telegen</option>
                        <option value="JET">JET</option>
                        <option value="MPG">MPG</option>
                        <option value="FAW">FAW</option>
                        <option value="KeyPower">KeyPower</option>
                        <option value="Valiant">Valiant</option>
                        <option value="JIMCO">JIMCO</option>
                        <option value="EATON">EATON</option>
                    </select>
                    </div><br>
    

    
    
    <label> Engine Brand:</label>
    <div>
   <select name="engine_brand">
   
                      <option value="-">-</option>
                      <option value="Paknika">Paknika</option>
                      <option value="Yanmar">Yanmar</option>
                      <option value="John Deere">John Deere</option>
                      <option value="Kohler">Kohler</option>
                      <option value="YORK">YORK</option>
                      <option value="FAW">FAW</option>
                      <option value="Mitsubishi">Mitsubishi</option>
                      <option value="Lister">Lister</option>
                    
                  </select>
  
  </div><br>



  <label>Initial Status:</label>
  <div>
  <select name="status">
   
   <option value="-">-</option>
   <option value="Bad">Bad</option>
   <option value="Good">Good</option>
   <option value="Need replace">Need replace</option>
   <option value="Need Overhauling">Need Overhauling</option>
   
</select>
  </div><br>

  <label> Ownership:</label>
    <div>
   <select name="ownership">

                      <option value="MTN_OOS">MTN_OOS</option>
                      <option value="MTN_Rented">MTN_Rented</option>
                      <option value="Other_MTN">Other_MTN</option>
                      <option value="Other">Other</option>
                      <option value="STE">STE</option>
                      <option value="Switch">Switch</option>
                      <option value="Syriatel">Syriatel</option>
               
                    
                  </select>
  
  </div><br>



  <!-- <label>Capacity:</label> -->
  <div>
<input type ="text" name= "capacity" size= "5" placeholder ="Capacity">
  </div><br>

  <!-- <label>Quantity:</label> -->
  <div>
<input type ="text" name= "qty" size= "5" placeholder ="Quantity">
  </div><br>

  <label>Generator Cage:</label>
  <div><br>
<input type ="radio" name= "cage"> Yes 
<input type ="radio" name= "cage"> No 
  </div><br>

  <h4>Tanks Info:</h4>

  <label><input type="checkbox" name="tank1" id="main13" onclick="toggleSubOptions('main13')"> Tank1</label>
<div id="sub_main13" class="sub-options">


<label> Shape:</label>
    <div>
   <select name="t1shape">

                      <option value="Cuboid">Cuboid</option>
                      <option value="Cylinder">Cylinder</option>

                  </select>
  
  </div><br>
<label> Type:</label>
    <div>
   <select name="t1type">

                      <option value="Internal">Internal</option>
                      <option value="External">External</option>
                      
                  </select>
  
  </div><br>



    <input type ="text" name="t1volume" size="5" placeholder="Actual Volume"><br><br>
    <input type ="text" name="t1height" size="5" placeholder="Height"><br><br>
    <input type ="text" name="t1width" size="5"  placeholder="Width"><br><br>
    <input type ="text" name="t1length" size="5" placeholder="Length"><br><br>
    <input type ="text" name="t1max" size="5" placeholder="Maximum fuel Quantity"><br><br>


</div>


<label><input type="checkbox" name="tank2" id="main14" onclick="toggleSubOptions('main14')"> Tank2</label>
<div id="sub_main14" class="sub-options">


<label> Shape:</label>
    <div>
   <select name="t2shape">

                      <option value="Cuboid">Cuboid</option>
                      <option value="Cylinder">Cylinder</option>

                  </select>
  
  </div><br>
<label> Type:</label>
    <div>
   <select name="t2type">

                      <option value="Internal">Internal</option>
                      <option value="External">External</option>
                      
                  </select>
  
  </div><br>



    <input type ="text" name="t2volume" size="5" placeholder="Actual Volume"><br><br>
    <input type ="text" name="t2height" size="5" placeholder="Height"><br><br>
    <input type ="text" name="t2width" size="5"  placeholder="Width"><br><br>
    <input type ="text" name="t2length" size="5" placeholder="Length"><br><br>
    <input type ="text" name="t2max" size="5" placeholder="Maximum fuel Quantity"><br><br>


</div>


<label><input type="checkbox" name="tank3" id="main15" onclick="toggleSubOptions('main15')"> Tank3</label>
<div id="sub_main15" class="sub-options">


<label> Shape:</label>
    <div>
   <select name="t3shape">

                      <option value="Cuboid">Cuboid</option>
                      <option value="Cylinder">Cylinder</option>

                  </select>
  
  </div><br>
<label> Type:</label>
    <div>
   <select name="t3type">

                      <option value="Internal">Internal</option>
                      <option value="External">External</option>
                      
                  </select>
  
  </div><br>



    <input type ="text" name="t3volume" size="5" placeholder="Actual Volume"><br><br>
    <input type ="text" name="t3height" size="5" placeholder="Height"><br><br>
    <input type ="text" name="t3width" size="5"  placeholder="Width"><br><br>
    <input type ="text" name="t3length" size="5" placeholder="Length"><br><br>
    <input type ="text" name="t3max" size="5" placeholder="Maximum fuel Quantity"><br><br>


</div>








</div>
<h3> Solar Info:</h3><br>
<label><input type="checkbox" name="Hyprid" id="main2" onclick="toggleSubOptions('main2')"> Hyprid "Solar"</label><br>
<div id="sub_main2" class="sub-options">
<label> Type</label>
    <div>
   <select name="solartype">

                      <option value="Delta">Delta</option>
                      <option value="Eltek">Eltek</option>

                  </select>
  
  </div><br>

  <label> Status</label>
    <div>
   <select name="solarstatus">

                      <option value="Active">Active</option>
                      <option value="Not Active">Not Active</option>

                  </select>
  
  </div><br>

  <!-- <label>Solar Panels Quantity</label> -->
  <div>
<input type ="text" name= "solarqty" size= "5" placeholder = "Solar Panels Quantity">
  </div><br>
  <!-- <label>Solar Panel Capacity</label> -->
  <div>
<input type ="text" name= "solarcapacity" size= "5" placeholder = "Solar Panel Capacity">
  </div><br>
  <!-- <label>Solar Module Quantity</label> -->
  <div>
<input type ="text" name= "solarmodqty" size= "5" placeholder = "Solar Module Quantity">
  </div><br>

  <label> Ownership</label>
    <div>
   <select name="solarownership">

                      <option value="hyprid"> Hyprid</option>
                      <option value="inactive"> Inactive</option>
                      <option value="installed"> Installed</option>
                      <option value="OOS"> OOS</option>
                      <option value="hyprid"> Hyprid</option>
                      <option value="Wind"> Wind</option>

                  </select>
  
  </div><br>

</div>

<label><input type="checkbox" name="NonRationig" id="main3" onclick="toggleSubOptions('main3')"> Non Rationing Line</label><br>
<div id="sub_main3" class="sub-options">
    <label><input type="checkbox" name="Golden">    Golden line   </label><br>
    <label><input type="checkbox" name="Rationing"> Rationing line</label><br>

</div>
<!-- You can add a form and PHP logic to save selected options -->

<h3> Ampere Info:</h3><br>
<label><input type="checkbox" name="Ampere" id="main4" onclick="toggleSubOptions('main4')"> Ampere</label><br>
<div id="sub_main4" class="sub-options">
<!-- <label>Ampere Capacity</label> -->
  <div>
<input type ="text" name= "ampcapacity" size= "5" placeholder="Ampere Capacity">
  </div><br>

  <!-- <label>Ampere Duration</label> -->
  <div>
<input type ="text" name= "ampduration" size= "5" placeholder="Ampere Duration">
  </div><br>
</div>


<div>
<h3> Batteries Info:</h3><br>
<label><input type="checkbox" name="B1Battaries" id="main5" onclick="toggleSubOptions('main5')"> Batteries</label><br>
<div id="sub_main5" class="sub-options">



<label> Brand:</label>
    <div>
   <select name="b1brand">

                      <option value="North_Star">North Star</option>
                      <option value="Narada">Narada</option>
                      <option value="Power_Safe">Power Safe</option>
                      <option value="CDTRUE">CDTRUE</option>
                      <option value="Huawei">Huawei</option>
                      <option value="Agisson">Agisson</option>
                      <option value="Deye">Deye</option>
                      <option value="Riyada">Riyada</option>
                      <option value="AHG">AHG</option>
                      <option value="VR-Solar">VR-Solar</option>
                      <option value="Shoto">Shoto</option>
                      <option value="GFM">GFM</option>
                      <option value="Coslight">Coslight</option>
                      <option value="NO">NO</option>
                      <option value="Angeergy">Angeergy</option>
                      <option value="Marathon">Marathon</option>
                      <option value="Fiamm">Fiamm</option>
                      <option value="Sonnenschein">Sonnenschein</option>
                      <option value="LI_Ion">LI - Ion</option>
                  </select>
  
  </div><br>

  <label> Type:</label>
    <div>
   <select name="b1type">

                      <option value="Gel">Gel</option>
                      <option value="Lithium">Lithium</option>
                  </select>
  
  </div><br>

  <label> Status:</label>
    <div>
   <select name="b1status">

                      <option value="Active">Active</option>
                      <option value="Not Active">Not Active</option>
                  </select>
  
  </div><br>

  <div>
    <!-- <label> Quantity:</label> -->
    <input type="text" name="b1qty" placeholder = "Quantity"><br>
  
  </div><br>

  <div>
    <!-- <label> Capacity:</label> -->
    <input type="text" name="b1capacity" placeholder = "Capacity"><br>
  
  </div><br>


  <div>
    <!-- <label> Installation Date:</label> -->
    <input type="date" name="b1date" placeholder = "Installation Date"><br>
  
  </div><br>
  <label><input type="checkbox" name="B2Battaries" id="main19" onclick="toggleSubOptions('main19')">Adittional Battaries</label><br>
        <div id="sub_main19" class="sub-options">

        <label> Brand:</label>
    <div>
   <select name="b2brand">

                      <option value="North_Star">North Star</option>
                      <option value="Narada">Narada</option>
                      <option value="Power_Safe">Power Safe</option>
                      <option value="CDTRUE">CDTRUE</option>
                      <option value="Huawei">Huawei</option>
                      <option value="Agisson">Agisson</option>
                      <option value="Deye">Deye</option>
                      <option value="Riyada">Riyada</option>
                      <option value="AHG">AHG</option>
                      <option value="VR-Solar">VR-Solar</option>
                      <option value="Shoto">Shoto</option>
                      <option value="GFM">GFM</option>
                      <option value="Coslight">Coslight</option>
                      <option value="NO">NO</option>
                      <option value="Angeergy">Angeergy</option>
                      <option value="Marathon">Marathon</option>
                      <option value="Fiamm">Fiamm</option>
                      <option value="Sonnenschein">Sonnenschein</option>
                      <option value="LI_Ion">LI - Ion</option>
                  </select>
  
  </div><br>

  <label> Type:</label>
    <div>
   <select name="b2type">

                      <option value="Gel">Gel</option>
                      <option value="Lithium">Lithium</option>
                  </select>
  
  </div><br>

  <label> Status:</label>
    <div>
   <select name="b2status">

                      <option value="Active">Active</option>
                      <option value="Not Active">Not Active</option>
                  </select>
  
  </div><br>

  <div>
    <!-- <label> Quantity:</label> -->
    <input type="text" name="b2qty" placeholder="Quantity"><br>
  
  </div><br>

  <div>
    <!-- <label> Capacity:</label> -->
    <input type="text" name="b2capacity" placeholder="Capacity"><br>
  
  </div><br>


  <div>
    <!-- <label> Installation Date:</label> -->
    <input type="date" name="b2date" placeholder="Installation Date"><br>
  
  </div><br>



</div>
</div>
</div>


<div>

<label><input type="checkbox" name="industrial" id="main7" > Industrial Line</label><br>

</div>
<h3> Site Safty:</h3><br>
<label>Cage:</label>
  <div><br>
<input type ="radio" name= "sitecage"> Yes 
<input type ="radio" name= "sitecage"> No 
  </div><br>


  <label>Gurde:</label>
  <div><br>
<input type ="radio" name= "sitegurde"> Yes 
<input type ="radio" name= "sitegurde"> No 
  </div><br>


    </div>
</div>

<div class="footer">
<div class="submit">
<input type="submit" name="submit" value="Done">
    </div>
    <div style="clear:both;"></div>
        </div>


   


    
   
    </div>
</body>
</html>


