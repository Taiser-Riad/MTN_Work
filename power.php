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
    $gen         = $_POST['Gen'] ?? '';
    $num         = $_POST['count'] ?? '';
    //define bool values
    $mtngen       = isset($_POST['MTN'])          ? 1 : 0;
    $rented       = isset($_POST['MTN_RENTED'])   ? 1 : 0;
    $oos          = isset($_POST['MTN_OOS'])      ? 1 : 0;
    $othermtn     = isset($_POST['OTHER_MTN'])    ? 1 : 0;
    $other        = isset($_POST['OTHER'])        ? 1 : 0;
    $ste          = isset($_POST['STE'])          ? 1 : 0;
    $switch       = isset($_POST['SWITCH'])       ? 1 : 0;
    $mainhyprid   = isset($_POST['Hyprid'])       ? 1 : 0;
    $hyprid       = isset($_POST['hyprid'])       ? 1 : 0;
    $inactive     = isset($_POST['inactive'])     ? 1 : 0;
    $installed    = isset($_POST['installed'])    ? 1 : 0;
    $hypridoos    = isset($_POST['HOOS'])         ? 1 : 0;
    $wind         = isset($_POST['Wind'])         ? 1 : 0;
    $nonration    = isset($_POST['NonRationig'])  ? 1 : 0;
    $golden       = isset($_POST['Golden'])       ? 1 : 0;
    $ration       = isset($_POST['Rationing'])    ? 1 : 0;
    $ampere       = isset($_POST['Ampere'])       ? 1 : 0;
    $lithium      = isset($_POST['Lithium'])      ? 1 : 0;
    $ind          = isset($_POST['industrial'])   ? 1 : 0;
    $batt         = isset($_POST['Battaries'])    ? 1 : 0;
    $syriatel     = isset($_POST['SYRIATEL'])    ? 1 : 0;



    // echo "PID: $PID<br>";
    // echo "Site Code: $sitecode<br>";
    // echo "MTN: $mtngen<br>";
    // echo "Number of MTN: $num<br>";
    // echo "MTN_OOS: $oos<br>";
    // echo "MTN_RENTED: $rented<br>";
    // echo "OTHER_MTN: $othermtn<br>";
    // echo "OTHER: $other<br>";
    // echo "STE: $ste<br>";
    // echo "SWITCH: $switch<br>";
    // echo "SYRIATEL: $syriatel<br>";



    
    $check_sql = "SELECT * FROM POWER_BACKUP WHERE SITE_CODE = :sitecode";
    $check_stmt = oci_parse($conn, $check_sql);
    oci_bind_by_name($check_stmt, ':sitecode', $sitecode);

    if (oci_execute($check_stmt)) {
        // $check_row = oci_fetch_array($check_stmt, OCI_ASSOC);
        // $count = $check_row['count'];
       

        $count = 0;
        while ($row = oci_fetch_array($check_stmt, OCI_ASSOC)) {
            $count++;
        }

        echo "Count of records in POWER_BACKUP: $count<br>"; // Debugging line


if ($count == 0) {



$sql  = "INSERT INTO POWER_BACKUP (SID, PID, SITE_CODE) 
VALUES (:siteid,POWER_SEQ.NEXTVAL,:sitecode) RETURNING PID INTO :last_pid";


$insert_stmt = oci_parse($conn,$sql);
oci_bind_by_name($insert_stmt,':siteid'   ,$sid);
oci_bind_by_name($insert_stmt,':sitecode' ,$sitecode);
oci_bind_by_name($insert_stmt,':last_pid', $PID, -1, SQLT_INT);
//oci_execute($insert_stmt);





if (oci_execute($insert_stmt)) {


if (!empty($_POST['Gen']) && isset($_POST['Gen'])){




    if ($_POST['MTN'] == 1){
      $num = (!empty($_POST['count'])) ? $_POST['count'] : 1; // If 'count' is not empty, use it; otherwise, set $num to 1
        
    }
    elseif ($_POST['MTN'] == 0){
        $num = 0;
    }
   

    $sqll = "INSERT INTO GENERTAOR (PID ,MTN ,NUMBER_OF_MTN ,MTN_OOS ,MTN_RENTED ,OTHER_MTN ,OTHER ,STE ,SWITCH ,SITE_CODE,SYRIATEL) VALUES (:pid ,:mtn ,:num ,:mtnoos ,:rented ,:othermtn ,:other ,:ste ,:switch ,:sitecode,:syriatel)";
   
    
    $insert_sqll = oci_parse($conn,$sqll);

    oci_bind_by_name($insert_sqll,':pid'   ,$PID);
    oci_bind_by_name($insert_sqll,':sitecode' ,$sitecode);
    oci_bind_by_name($insert_sqll,':mtn'   ,$mtngen);
    oci_bind_by_name($insert_sqll,':num' ,$num);
    oci_bind_by_name($insert_sqll,':mtnoos' ,$oos);
    oci_bind_by_name($insert_sqll,':rented'   ,$rented);
    oci_bind_by_name($insert_sqll,':othermtn' ,$othermtn);
    oci_bind_by_name($insert_sqll,':other'   ,$other);
    oci_bind_by_name($insert_sqll,':ste' ,$ste);
    oci_bind_by_name($insert_sqll,':switch' ,$switch);
    oci_bind_by_name($insert_sqll,':syriatel' ,$syriatel);
   










    if (oci_execute($insert_sqll)) {  
        //echo "DONE";
        //header("Location:Update_thankyou.html");
     } 
       else { 
        $e = oci_error($insert_sqll); echo "Error Updating Data: " . htmlentities($e['message']);
    
       }

}


if (!empty($_POST['Hyprid']) && isset($_POST['Hyprid'])){
$stmt = "INSERT INTO HYPRID (PID, SITE_CODE, HYPRID, INSTALLED, OOS, WIND) VALUES (:pid ,:sitecode ,:hyprid ,:installed ,:oos ,:wind)";
$resultt = oci_parse($conn,$stmt);

oci_bind_by_name($resultt,':pid' ,$PID);
oci_bind_by_name($resultt,':sitecode' ,$sitecode);
oci_bind_by_name($resultt,':hyprid' ,$hyprid);
oci_bind_by_name($resultt,':installed' ,$installed);
oci_bind_by_name($resultt,':oos' ,$hypridoos);
oci_bind_by_name($resultt,':wind' ,$wind);


if (oci_execute($resultt)) {  
    //echo "DONE";
    //header("Location:Update_thankyou.html");
 } 
   else { 
    $e = oci_error($resultt); echo "Error Updating Data: " . htmlentities($e['message']);

   }

}


if(!empty($_POST['NonRationig']) && isset($_POST['NonRationig'])){
$sttmt = "INSERT INTO NON_RATIONING (PID, SITE_CODE, RATINING, GOLDEN) VALUES (:pid, :sitecode, :rat, :golden)"; 

$res = oci_parse($conn,$sttmt);

oci_bind_by_name($res,':pid' ,$PID);
oci_bind_by_name($res,':sitecode' ,$sitecode);
oci_bind_by_name($res,':rat' ,$ration);
oci_bind_by_name($res,':golden' ,$golden);


if (oci_execute($res)) {  
    //echo "DONE";
    //header("Location:Update_thankyou.html");
 } 
   else { 
    $e = oci_error($res); echo "Error Updating Data: " . htmlentities($e['message']);

   }

}


if(!empty($_POST['Ampere']) && isset($_POST['Ampere'])){

    $sttmt = "INSERT INTO AMPERE (PID, SITE_CODE, AMPERE) VALUES (:pid, :sitecode, :ampere)"; 

    $res = oci_parse($conn,$sttmt);
    
    oci_bind_by_name($res,':pid' ,$PID);
    oci_bind_by_name($res,':sitecode' ,$sitecode);
    oci_bind_by_name($res,':ampere' ,$ampere);
    if (oci_execute($res)) {  
        //echo "DONE";
        //header("Location:Update_thankyou.html");
     } 
       else { 
        $e = oci_error($res); echo "Error Updating Data: " . htmlentities($e['message']);
    
       }

}


if(!empty($_POST['Battaries']) && isset($_POST['Battaries'])){
    $sttmt = "INSERT INTO BATTERIES (PID, SITE_CODE, BATT) VALUES (:pid, :sitecode, :batt)"; 

    $res = oci_parse($conn,$sttmt);
    
    oci_bind_by_name($res,':pid' ,$PID);
    oci_bind_by_name($res,':sitecode' ,$sitecode);
    oci_bind_by_name($res,':batt' ,$batt);
    if (oci_execute($res)) {  
        //echo "DONE";
        //header("Location:Update_thankyou.html");
     } 
       else { 
        $e = oci_error($res); echo "Error Updating Data: " . htmlentities($e['message']);
    
       }
}

if(!empty($_POST['Lithium']) && isset($_POST['Lithium'])){
    $sttmt = "INSERT INTO LITHIUM_BATT (PID, SITE_CODE, LITHIUM) VALUES (:pid, :sitecode, :lithium)"; 

    $res = oci_parse($conn,$sttmt);
    
    oci_bind_by_name($res,':pid' ,$PID);
    oci_bind_by_name($res,':sitecode' ,$sitecode);
    oci_bind_by_name($res,':lithium' ,$lithium);
    if (oci_execute($res)) {  
        //echo "DONE";
        //header("Location:Update_thankyou.html");
     } 
       else { 
        $e = oci_error($res); echo "Error Updating Data: " . htmlentities($e['message']);
    
       }
}

if(!empty($_POST['industrial']) && isset($_POST['industrial'])){
    $sttmt = "INSERT INTO INDUSTRIAL_LINE (PID, SITE_CODE, INDUSTRIAL) VALUES (:pid, :sitecode, :industrial)"; 

    $res = oci_parse($conn,$sttmt);
    
    oci_bind_by_name($res,':pid' ,$PID);
    oci_bind_by_name($res,':sitecode' ,$sitecode);
    oci_bind_by_name($res,':industrial' ,$ind);
    if (oci_execute($res)) {  
        //echo "DONE";
        //header("Location:Update_thankyou.html");
     } 
       else { 
        $e = oci_error($res); echo "Error Updating Data: " . htmlentities($e['message']);
    
       }
}


}

header("Location:Power_thankyou.html");
exit();
}

else{
    $check_sql = "SELECT * FROM POWER_BACKUP WHERE SITE_CODE = :sitecode";
    $check_stmt = oci_parse($conn, $check_sql);
    oci_bind_by_name($check_stmt, ':sitecode', $sitecode);
    oci_execute($check_stmt);
        $check_row = oci_fetch_array($check_stmt, OCI_ASSOC);
        $PID = $check_row['PID'];



    if (!empty($_POST['Gen']) && isset($_POST['Gen'])) {

        if ($_POST['MTN'] == 1) {
            $num = (!empty($_POST['count'])) ? $_POST['count'] : 1; // If 'count' is not empty, use it; otherwise, set $num to 1
        } elseif ($_POST['MTN'] == 0) {
            $num = 0;
        }
    
        // Update statement for GENERTAOR table
        $sqll = "UPDATE GENERTAOR 
                 SET MTN = :mtn, 
                     NUMBER_OF_MTN = :num, 
                     MTN_OOS = :mtnoos, 
                     MTN_RENTED = :rented, 
                     OTHER_MTN = :othermtn, 
                     OTHER = :other, 
                     STE = :ste, 
                     SWITCH = :switch, 
                     SITE_CODE = :sitecode, 
                     SYRIATEL = :syriatel 
                 WHERE PID = :pid"; // Specify the condition to identify which record to update
    
        $update_sqll = oci_parse($conn, $sqll);
    
        // Bind parameters to the update statement
        oci_bind_by_name($update_sqll, ':pid', $PID);
        oci_bind_by_name($update_sqll, ':sitecode', $sitecode);
        oci_bind_by_name($update_sqll, ':mtn', $mtngen);
        oci_bind_by_name($update_sqll, ':num', $num);
        oci_bind_by_name($update_sqll, ':mtnoos', $oos);
        oci_bind_by_name($update_sqll, ':rented', $rented);
        oci_bind_by_name($update_sqll, ':othermtn', $othermtn);
        oci_bind_by_name($update_sqll, ':other', $other);
        oci_bind_by_name($update_sqll, ':ste', $ste);
        oci_bind_by_name($update_sqll, ':switch', $switch);
        oci_bind_by_name($update_sqll, ':syriatel', $syriatel);
    
        echo "Updating GENERTAOR with PID: $PID, MTN: $mtngen, Number of MTN: $num<br>";


        // Execute the update statement
        if (oci_execute($update_sqll)) {
            // Logic for successful update
            echo "Record updated successfully.";
        } else {
            $e = oci_error($update_sqll);
            echo "Error updating record: " . htmlentities($e['message']);
        }
    }



    if (!empty($_POST['Hyprid']) && isset($_POST['Hyprid'])) {
        // Update statement for HYPRID table
        $stmt = "UPDATE HYPRID 
                  SET SITE_CODE = :sitecode, 
                      HYPRID = :hyprid, 
                      INSTALLED = :installed, 
                      OOS = :oos, 
                      WIND = :wind 
                  WHERE PID = :pid"; // Specify the condition to identify which record to update
    
        $resultt = oci_parse($conn, $stmt);
    
        // Bind parameters to the update statement
        oci_bind_by_name($resultt, ':pid', $PID);
        oci_bind_by_name($resultt, ':sitecode', $sitecode);
        oci_bind_by_name($resultt, ':hyprid', $hyprid);
        oci_bind_by_name($resultt, ':installed', $installed);
        oci_bind_by_name($resultt, ':oos', $hypridoos);
        oci_bind_by_name($resultt, ':wind', $wind);
    
        // Execute the update statement
        if (oci_execute($resultt)) {  
            // Logic for successful update can be added here
            // echo "DONE";
            // header("Location:Update_thankyou.html");
        } else { 
            $e = oci_error($resultt); 
            echo "Error Updating Data: " . htmlentities($e['message']);
        }
    }
    
    if (!empty($_POST['NonRationig']) && isset($_POST['NonRationig'])) {
        // Update statement for NON_RATIONING table
        $sttmt = "UPDATE NON_RATIONING 
                  SET SITE_CODE = :sitecode, 
                      RATINING = :rat, 
                      GOLDEN = :golden 
                  WHERE PID = :pid"; // Specify the condition to identify which record to update
    
        $res = oci_parse($conn, $sttmt);
    
        // Bind parameters to the update statement
        oci_bind_by_name($res, ':pid', $PID);
        oci_bind_by_name($res, ':sitecode', $sitecode);
        oci_bind_by_name($res, ':rat', $ration);
        oci_bind_by_name($res, ':golden', $golden);
    
        // Execute the update statement
        if (oci_execute($res)) {  
            // Logic for successful update can be added here
            // echo "DONE";
            // header("Location:Update_thankyou.html");
        } else { 
            $e = oci_error($res); 
            echo "Error Updating Data: " . htmlentities($e['message']);
        }
    }
    
    if (!empty($_POST['Ampere']) && isset($_POST['Ampere'])) {
        // Update statement for AMPERE table
        $sttmt = "UPDATE AMPERE 
                  SET SITE_CODE = :sitecode, 
                      AMPERE = :ampere 
                  WHERE PID = :pid"; // Specify the condition to identify which record to update
    
        $res = oci_parse($conn, $sttmt);
        
        // Bind parameters to the update statement
        oci_bind_by_name($res, ':pid', $PID);
        oci_bind_by_name($res, ':sitecode', $sitecode);
        oci_bind_by_name($res, ':ampere', $ampere);
    
        // Execute the update statement
        if (oci_execute($res)) {  
            // Logic for successful update can be added here
            // echo "DONE";
            // header("Location:Update_thankyou.html");
        } else { 
            $e = oci_error($res); 
            echo "Error Updating Data: " . htmlentities($e['message']);
        }
    }
    


    if (!empty($_POST['Battaries']) && isset($_POST['Battaries'])) {
        // Update statement for BATTERIES table
        $sttmt = "UPDATE BATTERIES 
                  SET SITE_CODE = :sitecode, 
                      BATT = :batt 
                  WHERE PID = :pid"; // Specify the condition to identify which record to update
    
        $res = oci_parse($conn, $sttmt);
        
        // Bind parameters to the update statement
        oci_bind_by_name($res, ':pid', $PID);
        oci_bind_by_name($res, ':sitecode', $sitecode);
        oci_bind_by_name($res, ':batt', $batt);
    
        // Execute the update statement
        if (oci_execute($res)) {  
            // Logic for successful update can be added here
            // echo "DONE";
            // header("Location:Update_thankyou.html");
        } else { 
            $e = oci_error($res); 
            echo "Error Updating Data: " . htmlentities($e['message']);
        }
    }
    
    if (!empty($_POST['Lithium']) && isset($_POST['Lithium'])) {
        // Update statement for LITHIUM_BATT table
        $sttmt = "UPDATE LITHIUM_BATT 
                  SET SITE_CODE = :sitecode, 
                      LITHIUM = :lithium 
                  WHERE PID = :pid"; // Specify the condition to identify which record to update
    
        $res = oci_parse($conn, $sttmt);
        
        // Bind parameters to the update statement
        oci_bind_by_name($res, ':pid', $PID);
        oci_bind_by_name($res, ':sitecode', $sitecode);
        oci_bind_by_name($res, ':lithium', $lithium);
    
        // Execute the update statement
        if (oci_execute($res)) {  
            // Logic for successful update can be added here
            // echo "DONE";
            // header("Location:Update_thankyou.html");
        } else { 
            $e = oci_error($res); 
            echo "Error Updating Data: " . htmlentities($e['message']);
        }
    }
    
    if (!empty($_POST['industrial']) && isset($_POST['industrial'])) {
        // Update statement for INDUSTRIAL_LINE table
        $sttmt = "UPDATE INDUSTRIAL_LINE 
                  SET SITE_CODE = :sitecode, 
                      INDUSTRIAL = :industrial 
                  WHERE PID = :pid"; // Specify the condition to identify which record to update
    
        $res = oci_parse($conn, $sttmt);
        
        // Bind parameters to the update statement
        oci_bind_by_name($res, ':pid', $PID);
        oci_bind_by_name($res, ':sitecode', $sitecode);
        oci_bind_by_name($res, ':industrial', $ind);
    
        // Execute the update statement
        if (oci_execute($res)) {  
            // Logic for successful update can be added here
            // echo "DONE";
            // header("Location:Update_thankyou.html");
        } else { 
            $e = oci_error($res); 
            echo "Error Updating Data: " . htmlentities($e['message']);
        }
    }
    header("Location:Power_thankyou.html");   
    exit();
}


    }

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
<h3>Select Options:</h3>

<label><input type="checkbox" name="Gen" id="main1" onclick="toggleSubOptions('main1')"> Generators</label><br>
<div id="sub_main1" class="sub-options">
    <label><input type="checkbox" name="MTN" id="main11" onclick="toggleSubOptions('main11')"> MTN</label> <br>
    
    <div id="sub_main11" class="sub-options">
    
      <label> Number Of MTN Generators:</label><br><input type="text" name="count" size="3"> <br>
    </div>
    <label><input type="checkbox" name="MTN_OOS"> MTN_OOS</label><br>
    <label><input type="checkbox" name="MTN_RENTED"> MTN_Rented</label><br>
    <label><input type="checkbox" name="OTHER_MTN"> Other_MTN</label><br>
    <label><input type="checkbox" name="OTHER"> Other</label><br>
    <label><input type="checkbox" name="STE"> STE</label><br>
    <label><input type="checkbox" name="SWITCH"> Switch</label><br>
    <label><input type="checkbox" name="SYRIATEL"> Syriatel</label><br>
</div>

<label><input type="checkbox" name="Hyprid" id="main2" onclick="toggleSubOptions('main2')"> Hyprid</label><br>
<div id="sub_main2" class="sub-options">
    <label><input type="checkbox" name="hyprid"> Hyprid</label><br>
    <label><input type="checkbox" name="inactive"> Inactive</label><br>
    <label><input type="checkbox" name="installed"> Installed</label><br>
    <label><input type="checkbox" name="OOS"> OOS</label><br>
    <label><input type="checkbox" name="Wind"> Wind</label><br>
</div>

<label><input type="checkbox" name="NonRationig" id="main3" onclick="toggleSubOptions('main3')"> Non Rationing Line</label><br>
<div id="sub_main3" class="sub-options">
    <label><input type="checkbox" name="Golden">    Golden line   </label><br>
    <label><input type="checkbox" name="Rationing"> Rationing line</label><br>

</div>
<!-- You can add a form and PHP logic to save selected options -->

<div>
<label><input type="checkbox" name="Ampere" id="main4" > Ampere</label><br>
</div>


<div>
<label><input type="checkbox" name="Battaries" id="main5" > Battaries</label><br>
</div>
<div>
<label><input type="checkbox" name="Lithium" id="main6" > Lithium Battaries</label><br>
</div>

<div>

<label><input type="checkbox" name="industrial" id="main7" > Industrial Line</label><br>

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


