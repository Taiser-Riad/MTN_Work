<?php 
include "config.php";
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $scode= $_POST['sitecode'] ?? '';
    $sname= $_POST['sitename'] ?? '';
    $pbackup= $_POST['powerbackup'] ?? '';
    $ondate= $_POST['onairdate'] ?? '';
    $relocdate= "-";
    $coorE =$_POST['coordinatesE'] ?? '';
    $coorN =$_POST['coordinatesN'] ?? '';
    $alttuide =$_POST['alttitude'] ?? '';
    $siteadd =$_POST['address'] ?? '';
    $ara_name =$_POST['arabicname'] ?? '';
    $admin_area =$_POST['adminarea'] ?? '';
    $TX_node =$_POST['txnode'] ?? '';
    $supplier =$_POST['supplier'] ?? '';
    $cityrural1 =$_POST['C/R'] ?? '';
    $prio = $_POST['priority'] ?? '';
    $cat = $_POST['category'] ?? '';
    $subcontractor = $_POST['sub'] ?? '';
    $invoice = $_POST['invoice'] ?? '';
    $site_ranking = $_POST['sranking'] ?? '';
    //$site_type = $_POST['SiteType'] ?? '';
    $sitecode = $_POST['sitecode'].'L';
    $BTS = $_POST['BTS'] ?? '';
    $status = "On Air";
    //$date4G = $_POST['onairdate'] ?? '';
    $restordate = $_POST['restoration'] ?? '';
    $lac = $_POST['lac'] ?? '';

    $site_type = $_POST['SiteType'] ?? '';
    //$sitecode1 = $_POST['sitecode'];
    $code1 = substr($scode,0,3)?? '';
    $code2 = substr($scode,-3)?? '';
    
    $suppliers = [
        'Ericsson' => ['EVOBSC1', 'EVOBSC2', 'EVOBSC4','EVOBSC5','EVOBSC6','EVOBSC9','HDBSC1','HDBSC2'],
        'Huawei' => ['HBSC1', 'HBSC2', 'HBSC4','HBSC7','HBSC8','HBSC10','HBSC11','HSKBSC2'],
    ];
//echo $code1;
//echo $code2;
$scode = strtoupper($scode);
$code1 = substr($scode, 0, 3);

if (!preg_match("/^(DAM|DMR|DRA|ALP|DRZ|HMS|HMA|TRS|LTK|RKA|IDB|SWD|QRA|HSK)$/i", $code1)) {
    echo '<script>alert("Site code not valid");</script>';
    //exit;
}

// if($BSC == "HBSC1"){$LBSC = "HBSC1_Thawra";}
// elseif($BSC == "HBSC2"){$LBSC = "HBSC2_Thawra";}
// elseif($BSC == "HBSC4"){$LBSC = "HBSC4_DahietKudsaya";}
// elseif($BSC == "HBSC7"){$LBSC = "HBSC7_Swaida";}
// elseif($BSC == "HBSC8"){$LBSC = "HBSC8_Daraa";}
// elseif($BSC == "HBSC10"){$LBSC = "HBSC10_YouthCity";}
// elseif($BSC == "HBSC11"){$LBSC = "HBSC11_DahietQudsaya";}
// else {$LBSC = $BSC;}

    
 
   

        if (substr($scode,0,3) == "DAM"){ $province = "Damascus" ; $zone ="South"; }
    elseif (substr($scode,0,3) == "ALP"){$province = "Aleppo" ; $zone ="North"; }
    elseif (substr($scode,0,3) == "DMR"){$province = "Damascus Rural" ; $zone ="South"; }
    elseif (substr($scode,0,3) == "DRA"){$province = "Daraa" ; $zone ="South"; }
    elseif (substr($scode,0,3) == "DRZ"){$province = "Deir Elzor" ; $zone ="North"; }
    elseif (substr($scode,0,3) == "HMA"){$province = "Hama" ; $zone ="North"; }
    elseif (substr($scode,0,3) == "HMS"){$province = "Homs" ; $zone ="North"; }
    elseif (substr($scode,0,3) == "HSK"){$province = "Hassakeh" ; $zone ="North"; }
    elseif (substr($scode,0,3) == "IDB"){$province = "Idleb" ; $zone ="North"; }
    elseif (substr($scode,0,3) == "LTK"){$province = "Lattakia" ; $zone ="North"; }
    elseif (substr($scode,0,3) == "RKA"){$province = "Rakka" ; $zone ="North"; }
    elseif (substr($scode,0,3) == "SWD"){$province = "Sweida" ; $zone ="South"; }
    elseif (substr($scode,0,3) == "TRS"){$province = "Tartous" ; $zone ="North"; }
    elseif (substr($scode,0,3) == "QRA"){$province = "Qounaitera" ; $zone ="South"; }

if($cityrural1 == "City"){
    $cityrural = substr($scode,0,3);
}
else{
    $cityrural = substr($scode,0,3) ."-R";
}

if($code1 == "DAM"){
    if (is_numeric($code2) && intval($code2)){
        $cellid2 = '401'.$code2;
    }
}
elseif($code1 == "DMR"){
    if (is_numeric($code2) && intval($code2)){
        $cellid2 = '402'.$code2;
    }
}
elseif($code1 == "ALP"){
    if (is_numeric($code2) && intval($code2)){
        $cellid2 = '403'.$code2;
    }
}
elseif($code1 == "HMS"){
    if (is_numeric($code2) && intval($code2)){
        $cellid2 = '404'.$code2;
    }
}
elseif($code1 == "HMA"){
    if (is_numeric($code2) && intval($code2)){
        $cellid2 = '405'.$code2;
    }
}
elseif($code1 == "LTK"){
    if (is_numeric($code2) && intval($code2)){
        $cellid2 = '406'.$code2;
    }
}
elseif($code1 == "TRS"){
    if (is_numeric($code2) && intval($code2)){
        $cellid2 = '407'.$code2;
    }
}
elseif($code1 == "HSK"){
    if (is_numeric($code2) && intval($code2)){
        $cellid2 = '408'.$code2;
    }
}
elseif($code1 == "IDB"){
    if (is_numeric($code2) && intval($code2)){
        $cellid2 = '409'.$code2;
    }
}
elseif($code1 == "DRZ"){
    if (is_numeric($code2) && intval($code2)){
        $cellid2 = '410'.$code2;
    }
}
elseif($code1 == "DRA"){
    if (is_numeric($code2) && intval($code2)){
        $cellid2 = '411'.$code2;
    }
}
elseif($code1 == "RKA"){
    if (is_numeric($code2) && intval($code2)){
        $cellid2 = '412'.$code2;
    }
}
elseif($code1 == "SWD"){
    if (is_numeric($code2) && intval($code2)){
        $cellid2 = '413'.$code2;
    }
}
elseif($code1 == "QRA"){
    if (is_numeric($code2) && intval($code2)){
        $cellid2 = '414'.$code2;
    }
}

$nodeb = $cellid2;

  
      
    $sqll = 'SELECT * FROM NEW_SITES WHERE SITE_CODE = :site_code'; 
    $stid = oci_parse($conn, $sqll);
    oci_bind_by_name($stid, ':site_code', $scode); 
    oci_execute($stid);

    //$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)
    if($num_rows = oci_num_rows($stid)==0)
    {
try{
     
        $sql = "INSERT INTO NEW_SITES (ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, BSC, POWER_BACKUP, SITE_ON_AIR_DATE, RELOCATION_DATE, COORDINATES_E, COORDINATES_N, ALTTITUDE, SITE_ADDRESS, ARABIC_NAME, TX_NODE, TECHNICAL_PRIORITY, ADMINSTRITAVE_AREA, NODE_CATEGORY, SITE_RANKING, SUBCONTRACTOR, INVOICE_TOYOLOGY) 
        VALUES (NEW_SITES_SEQ.NEXTVAL, :scode, :sname, :zone, :province, :cityrural, :supplier, :BSC, :pbackup, :ondate, :relocdate, :coorE, :coorN, :altitude, :siteadd, :ara_name, :TX_node, :prio, :admin_area, :cat, :site_ranking, :subcontractor, :invoice) 
        RETURNING ID INTO :last_id";

$insert_stmt = oci_parse($conn, $sql);

oci_bind_by_name($insert_stmt, ':scode', $scode);
oci_bind_by_name($insert_stmt, ':sname', $sname);
oci_bind_by_name($insert_stmt, ':zone', $zone);
oci_bind_by_name($insert_stmt, ':province', $province);
oci_bind_by_name($insert_stmt, ':cityrural', $cityrural);
oci_bind_by_name($insert_stmt, ':supplier', $supplier);
oci_bind_by_name($insert_stmt, ':BSC', $BSC);
oci_bind_by_name($insert_stmt, ':pbackup', $pbackup);
oci_bind_by_name($insert_stmt, ':ondate', $ondate);
oci_bind_by_name($insert_stmt, ':relocdate', $relocdate);
oci_bind_by_name($insert_stmt, ':coorE', $coorE);
oci_bind_by_name($insert_stmt, ':coorN', $coorN);
oci_bind_by_name($insert_stmt, ':altitude', $altitude);
oci_bind_by_name($insert_stmt, ':siteadd', $siteadd);
oci_bind_by_name($insert_stmt, ':ara_name', $ara_name);
oci_bind_by_name($insert_stmt, ':TX_node', $TX_node);
oci_bind_by_name($insert_stmt, ':prio', $prio);
oci_bind_by_name($insert_stmt, ':admin_area', $admin_area);
oci_bind_by_name($insert_stmt, ':cat', $cat);
oci_bind_by_name($insert_stmt, ':site_ranking', $site_ranking);
oci_bind_by_name($insert_stmt, ':subcontractor', $subcontractor);
oci_bind_by_name($insert_stmt, ':invoice', $invoice);
//oci_bind_by_name($insert_stmt, ':area_rank', $area_rank);
oci_bind_by_name($insert_stmt, ':last_id', $ID, -1, SQLT_INT);

if (!oci_execute($insert_stmt)) {  
    throw new Exception(oci_error($insert_stmt)['message']);
 }

oci_free_statement($insert_stmt); 
oci_close($conn);

}
 catch (Exception $e) {
     echo "Error executing: " . $e->getMessage();
     }

// Redirect after closing the connection
//header("Location: 2G.php?id=$ID");
//exit;


$sql = "INSERT INTO  FOUR_G_SITES (SID, CELL_ID_KEY, SITE_CODE ,ENODEB_ID, BTS_TYPE, LAC, STATUS, ACTIVATION_DATE, NOTE, RESTORATION_DATE) 
VALUES (:sd,FOUR_G_SITES_SEQ.NEXTVAL , :sitecode, :enodeb, :bts, :lac, :statu, :date4G, :snote, :restordate)
RETURNING CELL_ID_KEY INTO :last_id";
$insert_stmt =oci_parse($conn,$sql);


oci_bind_by_name($insert_stmt, ':sd'      , $ID);
oci_bind_by_name($insert_stmt, ':sitecode', $sitecode);
oci_bind_by_name($insert_stmt, ':enodeb'   , $nodeb);
oci_bind_by_name($insert_stmt, ':bts'     , $BTS);
oci_bind_by_name($insert_stmt, ':statu'   , $status);
oci_bind_by_name($insert_stmt, ':date4G'  , $date4G);
oci_bind_by_name($insert_stmt, ':snote'   , $snote);
oci_bind_by_name($insert_stmt, ':restordate', $restordate);
oci_bind_by_name($insert_stmt, ':lac'       , $lac);
oci_bind_by_name($insert_stmt, ':last_id'   , $Cell_ID, -1, SQLT_INT);
//echo  $Cell_ID;




if(!oci_execute($insert_stmt))
{ 
    $err = oci_error($insert_stmt); 
    die("Error executing: " . $err['message']);
}
//$Cell_ID = oci_parse($conn, "SELECT THREE_G_SITES_SEQ.CURRVAL FROM THREE_G_SITES");


oci_free_statement($insert_stmt); 
oci_close($conn);



if(!empty($_POST['cell'])){
    // Loop to store and display values of individual checked checkbox.
    foreach($_POST['cell'] as $selected){
            echo $selected;
            $cellcode = $sitecode .$selected;
            $cellname = $sname.'-'.$selected;
            echo $cellcode."</br>";
        
            if($selected == 'A'){
                $newcellid = $nodeb.'1';
                $azimuth = $_POST['azimutha'] ?? '';
                $height = $_POST['heighta'] ?? '';
                $mtilt = $_POST['mtilta'] ?? '';
                $etilt = $_POST['etilta'] ?? '';
                $aarea = $_POST['area1a'] ?? '';
                $earea = $_POST['area2a'] ?? '';
                $cnote = $_POST['cnotea'] ?? '';
                if(!empty( $_POST['etilta'] && !empty($_POST['mtilta']))){
                    $ttilt = sprintf('%d',$_POST['mtilta'] + $_POST['etilta']);
                }
                else $ttilt ="-";



            }
            elseif($selected == 'B')
            {
                $newcellid = $nodeb.'2';
                $azimuth = $_POST['azimuthb'] ?? '';
                $height = $_POST['heightb'] ?? '';
                $mtilt = $_POST['mtiltb'] ?? '';
                $etilt = $_POST['etiltb'] ?? '';
                //$ttilt = $_POST['mtiltb'] + $_POST['etiltb'];
                $aarea = $_POST['area1b'] ?? '';
                $earea = $_POST['area2b'] ?? '';
                $cnote = $_POST['cnoteb'] ?? '';
    
                if(!empty( $_POST['etiltb'] && !empty($_POST['mtiltb']))){
                    $ttilt = sprintf('%d',$_POST['mtiltb'] + $_POST['etiltb']);
                }
                else $ttilt ="-";

            }
            elseif($selected == 'C'){
                $newcellid = $nodeb.'3';
                //$newcellid = $cellid2.'3';
                $azimuth = $_POST['azimuthC'] ?? '';
                $height = $_POST['heightC'] ?? '';
                $mtilt = $_POST['mtiltC'] ?? '';
                $etilt = $_POST['etiltC'] ?? '';
                //$ttilt = $_POST['mtiltC'] + $_POST['etiltC'];
                $aarea = $_POST['area1C'] ?? '';
                $earea = $_POST['area2C'] ?? '';
                $cnote = $_POST['cnoteC'] ?? '';
                if(!empty( $_POST['etiltC'] && !empty($_POST['mtiltC']))){
                    $ttilt = sprintf('%d',$_POST['mtiltC'] + $_POST['etiltC']);
                }
                else $ttilt ="-";
            }
            elseif($selected == 'D'){
                $newcellid = $nodeb.'4';
                $azimuth = $_POST['azimuthd'] ?? '';
                $height = $_POST['heightd'] ?? '';
                $mtilt = $_POST['mtiltd'] ?? '';
                $etilt = $_POST['etiltd'] ?? '';
                //$ttilt = $_POST['mtiltd'] + $_POST['etiltd'];
                $aarea = $_POST['area1d'] ?? '';
                $earea = $_POST['area2d'] ?? '';
                $cnote = $_POST['cnoted'] ?? '';
                if(!empty( $_POST['etiltd'] && !empty($_POST['mtiltd']))){
                    $ttilt = sprintf('%d',$_POST['mtiltd'] + $_POST['etiltd']);
                }
                else $ttilt ="-";
            }
            elseif($selected == 'E'){
                $newcellid = $nodeb.'5';
                $azimuth = $_POST['azimuthe'] ?? '';
                $height = $_POST['heighte'] ?? '';
                $mtilt = $_POST['mtilte'] ?? '';
                $etilt = $_POST['etilte'] ?? '';
                //$ttilt = $_POST['mtilte'] + $_POST['etilte'];
                $aarea = $_POST['area1e'] ?? '';
                $earea = $_POST['area2e'] ?? '';
                $cnote = $_POST['cnotee'] ?? '';
                if(!empty( $_POST['etilte'] && !empty($_POST['mtilte']))){
                    $ttilt = sprintf('%d',$_POST['mtilte'] + $_POST['etilte']);
                }
                else $ttilt ="-";
            }
        
        // Database connection details
        $username = "C##Hadeel";
        $password = "MTN";
        $connection_string = "//localhost/XE"; // Change XE if your SID is different
        
        // Connect to Oracle
        $conn = oci_connect($username, $password, $connection_string);
        
        if (!$conn) {
            $e = oci_error();
            die("Connection failed: " . $e['message']);
        }
        else {
            //echo"connect Successfully";
        }
            //echo "cell_id: $Cell_ID,  newcellid:$newcellid ,cellcode: $cellcode, cellname: $cellname, date4G: $date4G, azimuth: $azimuth, mtilt: $mtilt, etilt: $etilt, ttilt: $ttilt, aarea: $aarea, earea: $earea, cnote: $cnote, height: $height";

            $sqll ="INSERT INTO FOUR_G_CELLS (CID_KEY, CELL_ID, CELL_CODE, CELL_NAME, ON_AIR_DATE, AZIMUTH, M_TILT, E_TILT, TOTAL_TILT, SERVING_AREA, SERVING_AREA_IN_ENGLISH, NOTES, HEIGHT) 
            VALUES (:cell_id,:newcellid, :cellcode, :cellname, :date4G, :azimuth, :mtilt, :etilt, :ttilt, :aarea, :earea, :cnote, :height)";
            $stmtt =oci_parse ($conn,$sqll);

            oci_bind_by_name($stmtt, ':cell_id' ,$Cell_ID);
            oci_bind_by_name($stmtt, ':newcellid', $newcellid);
            oci_bind_by_name($stmtt, ':cellcode', $cellcode);
            oci_bind_by_name($stmtt, ':cellname', $cellname);
            oci_bind_by_name($stmtt, ':date4G', $date4G);
            oci_bind_by_name($stmtt, ':azimuth', $azimuth);
            oci_bind_by_name($stmtt, ':mtilt', $mtilt);
            oci_bind_by_name($stmtt, ':etilt', $etilt);
            oci_bind_by_name($stmtt, ':ttilt', $ttilt);
            oci_bind_by_name($stmtt, ':aarea', $aarea);
            oci_bind_by_name($stmtt, ':earea', $earea);
            oci_bind_by_name($stmtt, ':cnote',$cnote);
            oci_bind_by_name($stmtt, ':height', $height);


            if(!oci_execute($stmtt))
            { 
                $err = oci_error($insert_stmt); 
            die("Error executing: " . $err['message']);
            }
            
            oci_free_statement($stmtt); 
            oci_close($conn);


    }
}
        
        }
        else 
    {
        while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS))
        {
            echo "Site Already Exist";
            $ID= $row[0];
            echo "<script>alert('Site Already Exist if you want to add technology you can go to search page');</script>";
        }
    
    }
        
            if($site_type == '3G')
            {
                header("location:3G.php?id2=$ID");
            }
            else if($site_type == '2G'){
                header("location:2G.php?id=$ID");
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
<title> Add New 2G Site page </title>

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

</style>




</head>
<body>
<div class="container">
<div class="header">
            <h1></br> New 4G Site Informations </h1>
             Please fill 4G site informations and then select next page to add another technology.</br>
</br>
        </div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit= "return confirmSubmission();">
<div class="form1">
<div>
    <label class="required-field" for="code">Site Code</label>
    <input type ="text" name="sitecode" size="7" id="code" required></br></br>

</div>

<div>
    <label class="required-field" for="name">Site Name</label>
    <input type ="text" name="sitename" size="33" id="name" required></br></br>
</div>


<div>
    <label class="required-field" >City/Rural</label>
                    <input  type="radio" id="city" name="C/R" value="City" > City
    <input type="radio" id="rural" name="C/R" value="Rural">Rural</br></br>
</div>
<div>
<label class="required-field">Supplier</label>
    <input type="radio" id="erc" name="supplier" value="Ericsson" >Ericsson
    <input type="radio" id="hu" name="supplier" value="Huawei">Huawei</br></br>
</div>
<div>
    Power Backup:
                    <select name="power">
                        <option value="">--</option>
                        <option value="2 MTN Generator">2 MTN Generator</option>
                        <option value="2 MTN Generator + Ampere">2 MTN Generator + Ampere</option>
                        <option value="2 MTN Generator + Hybrid">2 MTN Generator + Hybrid</option>
                        <option value="2 MTN Generator + Hybrid (OOS)">2 MTN Generator + Hybrid (OOS)</option>
                        <option value="2 MTN Generator + Hybrid + Ampere">2 MTN Generator + Hybrid + Ampere</option>
                        <option value="2 MTN Generator + Hybrid + Non Rationing line">2 MTN Generator + Hybrid + Non Rationing line</option>
                        <option value="2 MTN Generator + Hybrid + Wind">2 MTN Generator + Hybrid + Wind</option>
                        <option value="2 MTN Generator + Non Rationing line">2 MTN Generator + Non Rationing line</option>
                        <option value="Ampere">Ampere</option>
                        <option value="Ampere + Industrial line">Ampere + Industrial line</option>
                        <option value="Ampere + Other MTN Gen">Ampere + Other MTN Gen</option>
                        <option value="Ampere + Hybrid">Ampere + Hybrid</option>
                        <option value="Batteries">Batteries</option>
                        <option value="Hybrid">Hybrid</option>
                        <option value="Hybrid (Installed) + MTN Generator">Hybrid (Installed) + MTN Generator</option>
                        <option value="Hybrid + Ampere + Non Rationing line">Hybrid + Ampere + Non Rationing line</option>
                        <option value="Hybrid + Ampere + Other MTN Gen">Hybrid + Ampere + Other MTN Gen</option>
                        <option value="Hybrid + Industrial line">Hybrid + Industrial line</option>
                        <option value="Hybrid + Lithium batteries">Hybrid + Lithium batteries</option>
                        <option value="Hybrid + MTN rented Generator + Ampere">Hybrid + MTN rented Generator + Ampere</option>
                        <option value="Hybrid + Non Rationing line">Hybrid + Non Rationing line</option>
                        <option value="Hybrid + Other MTN Gen">Hybrid + Other MTN Gen</option>
                        <option value="Hybrid + Syriatel Generator">Hybrid + Syriatel Generator</option>
                        <option value="Industrial line">Industrial line</option>
                        <option value="Lithium Batteries">Lithium Batteries</option>
                        <option value="MTN Generator">MTN Generator</option>
                        <option value="MTN Generator (OOS) + Ampere">MTN Generator (OOS) + Ampere</option>
                        <option value="MTN Generator (OOS) + Hybrid + Ampere">MTN Generator (OOS) + Hybrid + Ampere</option>
                        <option value="MTN Generator (OOS) + MTN Rented Generator">MTN Generator (OOS) + MTN Rented Generator</option>
                        <option value="MTN Generator (OOS)+ Hybrid + Ampere">MTN Generator (OOS)+ Hybrid + Ampere</option>
                        <option value="MTN Generator + Ampere">MTN Generator + Ampere</option>
                        <option value="MTN Generator + Ampere + Other MTN Gen">MTN Generator + Ampere + Other MTN Gen</option>
                        <option value="MTN Generator + Ampere + Syriatel Generator">MTN Generator + Ampere + Syriatel Generator</option>
                        <option value="MTN Generator + Hybrid">MTN Generator + Hybrid</option>
                        <option value="MTN Generator + Hybrid (inactive) + Ampere">MTN Generator + Hybrid (inactive) + Ampere</option>
                        <option value="MTN Generator + Hybrid (OOS) + Ampere">MTN Generator + Hybrid (OOS) + Ampere</option>
                        <option value="MTN Generator + Hybrid (OOS) +industrial line">MTN Generator + Hybrid (OOS) +industrial line</option>
                        <option value="MTN Generator + Hybrid + Ampere">MTN Generator + Hybrid + Ampere</option>
                        <option value="MTN Generator + Hybrid + Golden line">MTN Generator + Hybrid + Golden line</option>
                        <option value="MTN Generator + Hybrid + Industrial line">MTN Generator + Hybrid + Industrial line</option>
                        <option value="MTN Generator + Hybrid + Non Rationing line">MTN Generator + Hybrid + Non Rationing line</option>
                        <option value="MTN Generator + Hybrid + Other Generator">MTN Generator + Hybrid + Other Generator</option>
                        <option value="MTN Generator + Hybrid + STE generator">MTN Generator + Hybrid + STE generator</option>
                        <option value="MTN Generator + Hybrid + Syriatel Generator">MTN Generator + Hybrid + Syriatel Generator</option>
                        <option value="MTN Generator + Hybrid(OOS)">MTN Generator + Hybrid(OOS)</option>
                        <option value="MTN Generator + Hybrid+ industrial line">MTN Generator + Hybrid+ industrial line</option>
                        <option value="MTN Generator + Hybrid+ Lithium batteries">MTN Generator + Hybrid+ Lithium batteries</option>
                        <option value="MTN Generator + Industrial line">MTN Generator + Industrial line</option>
                        <option value="MTN Generator + Lithium batteries">MTN Generator + Lithium batteries</option>
                        <option value="MTN Generator + MTN Generator (OOS) + MTN Rented Generator">MTN Generator + MTN Generator (OOS) + MTN Rented Generator</option>
                        <option value="MTN Generator + Non Rationing line">MTN Generator + Non Rationing line</option>
                        <option value="MTN Generator + STE Generator">MTN Generator + STE Generator</option>
                        <option value="MTN Generator + STE Generator + Non Rationing line">MTN Generator + STE Generator + Non Rationing line</option>
                        <option value="MTN Generator + Syriatel Generator">MTN Generator + Syriatel Generator</option>
                        <option value="MTN Generator(OOS)+MTN rented Generaor">MTN Generator(OOS)+MTN rented Generaor</option>
                        <option value="MTN Rented Generator">MTN Rented Generator</option>
                        <option value="MTN Rented Generator + Ampere">MTN Rented Generator + Ampere</option>
                        <option value="Non Rationing line">Non Rationing line</option>
                        <option value="Other Generator">Other Generator</option>
                        <option value="Other MTN Gen + Ampere">Other MTN Gen + Ampere</option>
                        <option value="Other MTN Gen + Industrial line">Other MTN Gen + Industrial line</option>
                        <option value="Other MTN Gen + Non Rationing line">Other MTN Gen + Non Rationing line</option>
                        <option value="Other MTN Generator">Other MTN Generator</option>
                        <option value="STE Generator">STE Generator</option>
                        <option value="Switch Generator">Switch Generator</option>
                        <option value="Syriatel Generator">Syriatel Generator</option>
                    </select>
</div>
</br>
</br>

<div>
    <label class="required-field" for="air date">On Air Date:</label>
    <input type ="date" name="onairdate" size="15" id="air date" required></br></br>
</div>
<div>
    <label class="required-field" for="coorE">Coordinates E:</label>
    <input type ="text" name="coordinatesE" size="10" id="coorE" required></br></br>
</div>
<div>
    <label class="required-field" for="coorN">Coordinates N:</label>
    <input type ="text" name="coordinatesN" size="10" id="coorN" required></br></br>
</div>
<div>
    <label class="required-field" for="Att">Alttitude:</label>
    <input type ="text" name="alttitude" size="4" id="Att" required></br></br>
</div>
<div>
    <label class="required-field" for="address">Site Address:</label>
    <input type ="text" name="address" size="60" id="address" required></br></br>
</div>
<div>
    <label class="required-field" for="arname">Arabic Name:</label>
    <span lang="Ar"><input type ="text" name="arabicname" size="60" id="arname" required></span></br></br>
</div>
<div>
    <label class="required-field" for="admin">Adminstrative Area:</label>
    <input type ="text" name="adminarea" size="60" id="admin" required></br></br>
</div>
<div>
    <label class="required-field" for="node">TX Node:</label>
    <input type ="text" name="txnode" size="3" id="node" required></br></br>
</div>

<div>
    Node Category:   <select name="category" required>    
        <option value="Empty">--</option>  
        <option value="Normal">Normal</option>
        <option value="Golden">Golden</option>
        <option value="Silver">Silver</option>
        <option value="Tail">Tail</option>
    </select>
    </br></br>
</div>

<div>
    Technical Priority:   <select name="priority" required>    
        <option value="Empty">--</option>  
        <option value="Priority1">Priority1</option>
        <option value="Priority2">Priority2</option>
        <option value="Priority3">Priority3</option>
        <option value="Priority4">Priority4</option>
    </select>
    </br></br>
</div>

    <div>
    Subcontractor:   <select name="sub" required> 
        <option value="Empty">--</option>  
        <option value="Brj">Brj</option>
        <option value="others">Others</option>
    </select>
    </br></br>
</div>
<div>
Invoice Topology:   <select name="invoice" required>    
        <option value="Empty">--</option>  
        <option value="Tower / Generator / Solar and or TX Repeater">Tower / Generator / Solar and or TX Repeater</option>
        <option value="PTS Shelter / Indoor shelter and or TX node">PTS Shelter / Indoor shelter and or TX node</option>
        <option value="Others">Others</option>
    </select>
    </br></br>
</div>
<div>
    Site Ranking:   <select name="sranking" required>  
        <option value="Empty">--</option>  
        <option value="Priority1">Priority1</option>
        <option value="Priority1-Tourism">Priority1-Tourism</option>
        <option value="Priority2">Priority2</option>
        <option value="Priority2-Tourism">Priority2-Tourism</option>
        <option value="Priority3">Priority3</option>
        <option value="Priority3-Tourism">Priority3-Tourism</option>
        <option value="Priority4">Priority4</option>
        <option value="Priority4-Tourism">Priority4-Tourism</option>
        <option value="VIP">VIP</option>
        <option value="VIP-Tourism">VIP-Tourism</option>
    </select>
    </br></br>
</div>


<div>
            <label for="rest" required>Restoration Date:</label>
            <input type ="date" name="restoration" size="15" id="rest"></br></br>
        </div>
        <div>
        <label for="note">Site Notes:</label>
            <input type ="text" name="snotes" size="89" id="note"></br></br>
        </div>
        <div>
        <label for="lac" required>TAC:</label>
            <input type ="text" name="lac" size="4" id="lac"></br></br>
        </div>

<div>

<div>
    Select Cells:</br>
    <input type = "checkbox" name="cell[]" value="A">A
    <input type ="text" name="azimutha" size="5" placeholder ="Azimuth"              >
    <input type ="text" name="heighta" size="5"  placeholder ="Height"               >
    <input type ="text" name="mtilta" size="5"   placeholder ="M_TILT"              >
    <input type ="text" name="etilta" size="5"   placeholder ="E_TILT"              >
    <input type ="text" name="area1a" size="15"  placeholder ="Arabic Serving Area" >
    <input type ="text" name="area2a" size="15"  placeholder ="English Serving Area"></br>
    <input type ="text" name="cnotea" size="90"  placeholder="Cell Note">

</div>

<div>
</br>
    <input type = "checkbox" name="cell[]" value="B">B
    <input type ="text" name="azimuthb" size="5" placeholder ="Azimuth"               >
    <input type ="text" name="heightb"  size="5" placeholder ="Height"                >
    <input type ="text" name="mtiltb"   size="5" placeholder ="M_TILT"               >
    <input type ="text" name="etiltb"   size="5" placeholder ="E_TILT"               >
    <input type ="text" name="area1b"   size="15" placeholder ="Arabic Serving Area" >
    <input type ="text" name="area2b"   size="15" placeholder ="English Serving Area"></br>
    <input type ="text" name="cnoteb" size="90"  placeholder="Cell Note">

</div>
<div>
</br>
    <input type = "checkbox" name="cell[]" value="C">C
    <input type ="text" name="azimuthC" size="5" placeholder ="Azimuth"              >
    <input type ="text" name="heightC"  size="5"  placeholder ="Height"              >
    <input type ="text" name="mtiltC" size="5"   placeholder ="M_TILT"              >
    <input type ="text" name="etiltC" size="5"   placeholder  ="E_TILT"             >
    <input type ="text" name="area1C" size="15"  placeholder ="Arabic Serving Area" >
    <input type ="text" name="area2C" size="15"  placeholder ="English Serving Area"></br>
    <input type ="text" name="cnoteC" size="90"  placeholder="Cell Note">
</div>
<div>
</br>
    <input type = "checkbox" name="cell[]" value="D">D
    <input type ="text" name="azimuthd" size="5" placeholder ="Azimuth"              >
    <input type ="text" name="heightd" size="5"  placeholder ="Height"               >
    <input type ="text" name="mtiltd" size="5"   placeholder ="M_TILT"              >
    <input type ="text" name="etiltd" size="5"   placeholder ="E_TILT"              >
    <input type ="text" name="area1d" size="15"  placeholder ="Arabic Serving Area" >
    <input type ="text" name="area2d" size="15"  placeholder ="English Serving Area"></br>
    <input type ="text" name="cnoted" size="90"  placeholder="Cell Note">

</div>
</div>

</div>
            




<div class="footer">
<div>
<label><h3>Select Next Page:</h3></label>
       
    <input type ="radio" id= "custom-option2" name="SiteType" value="2G" class="custom">
    <label for="custom-option2" class="custom-label">2G Site Page.</label>
    
    <input type ="radio" id= "custom-option3" name="SiteType" value="3G" class="custom">
    <label for="custom-option3" class="custom-label">3G Site Page.</label>
</div>
<div class="submit">
    <input type="submit" name="submit" value="Next">
</div>

<div class ="submit1">
        <input type="submit" name="submit" value = "Done" onclick="confirmAndClose();">
    </div>

<div style="clear:both;"></div>
</div>

</form>
</div>
</body>
</html>
<script>
function confirmAndClose() {
    if (window.confirm('Are you sure you want to add 4G site only without continue?')) {
        document.getElementById('myForm').submit();
        setTimeout(() => {
            window.close();
        }, 10); // Delay to ensure form submission completes
    }
}
</script>
