<?php 
include "config.php";
?>
<?php
if(isset($_GET['id']))
{
$siteid =$_GET['id'];

$sqll = "SELECT * FROM NEW_SITES WHERE ID = :siteid";
$result = oci_parse($conn, $sqll);
oci_bind_by_name($result, ':siteid', $siteid);
 oci_execute($result);
$row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS);

//echo $row['Site_code'];
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
$sid= $_POST ['id'];
$sitecode = $_POST['sitecode'];
$sitename = $_POST['sitename'];
$band = $_POST['band'] ?? '';
$status2G = "On Air";
$BTS = $_POST['BTS'] ?? '';
$date2G = $_POST['onairdate'] ?? '';
$date1 = $_POST['900onairdate'] ?? '';
$date2 = $_POST['1800onairdate'] ?? '';
$RBS1 = $_POST['900Rbs'] ?? '';
$RBS2 = $_POST['1800Rbs'] ?? '';
$BSC = $_POST['BSC'] ?? '';
$lac = $_POST['lac'] ?? '';
$cells = $_POST['cell'] ?? '';
//$cellid2 = $_POST['cellid'] ?? '';
$BSIC = "-";
$BCCH = "-";
$snote = $_POST['snotes'] ;
$site_type = $_POST['SiteType'] ?? '';
$supplier = $_POST['supplier'] ?? '';
$code1 = substr($sitecode,0,3)?? '';
$code2 = substr($sitecode,-3)?? '';
$code2 = substr($sitecode,-2)?? '';
$suppliers = [
    'Ericsson' => ['EVOBSC1', 'EVOBSC2', 'EVOBSC4','EVOBSC5','EVOBSC6','EVOBSC9','HDBSC1','HDBSC2'],
    'Huawei' => ['HBSC1', 'HBSC2', 'HBSC4','HBSC7','HBSC8','HBSC10','HBSC11','HSKBSC2'],
];
//echo $code1;
//echo $code2;
$date2 = $date1;
$dateTime1 = new DateTime($date2G);
$date2G = $dateTime1->format('m/d/Y');

$dateTime2 = new DateTime($date1);
$date1 = $dateTime2->format('d/M/Y');

$dateTime3 = new DateTime($date2);
$date2 = $dateTime3->format('d/M/Y');


$dateTime4 = new DateTime($date2);
$$date2 = $dateTime4->format('d/M/y');

if($BSC == "HBSC1"){$LBSC = "HBSC1_Thawra";}
elseif($BSC == "HBSC2"){$LBSC = "HBSC2_Thawra";}
elseif($BSC == "HBSC4"){$LBSC = "HBSC4_DahietKudsaya";}
elseif($BSC == "HBSC7"){$LBSC = "HBSC7_Swaida";}
elseif($BSC == "HBSC8"){$LBSC = "HBSC8_Daraa";}
elseif($BSC == "HBSC10"){$LBSC = "HBSC10_YouthCity";}
elseif($BSC == "HBSC11"){$LBSC = "HBSC11_DahietQudsaya";}
else {$LBSC = $BSC;}


if($code1 == "DAM"){
    if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
        $cellid2 = '10'.$code3;
    }
    elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
        $cellid2 = '11'.$code3;
    }
    elseif (is_numeric($code2) && intval($code2) >= 200 && intval($code2) <= 299){
        $cellid2 = '12'.$code3;
    }
    elseif (is_numeric($code2) && intval($code2) >= 300 && intval($code2) <= 399){
        $cellid2 = ("13".$code3);
    }
    elseif (is_numeric($code2) && intval($code2) >= 400 && intval($code2) <= 499){
        $cellid2 = ("14".$code3);
    }
    elseif (is_numeric($code2) && intval($code2) >= 500 && intval($code2) <= 599){
        $cellid2 = ("15".$code3);
    }
    elseif (is_numeric($code2) && intval($code2) >= 600 && intval($code2) <= 699){
        $cellid2 = ("16".$code3);
    }
    elseif (is_numeric($code2) && intval($code2) >= 700 && intval($code2) <= 799){
        $cellid2 = ("17".$code3);
    }
    elseif (is_numeric($code2) && intval($code2) >= 800 && intval($code2) <= 899){
        $cellid2 = ("18".$code3);
    }
    elseif (is_numeric($code2) && intval($code2) >= 900 && intval($code2) <= 999){
        $cellid2 = ("19".$code3);
    }
    }
    
    elseif($code1 == "DMR"){
        if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
            $cellid2 = ("54".$code3);
        }
        elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
            $cellid2 = ("55".$code3);
        }
        elseif (is_numeric($code2) && intval($code2) >= 200 && intval($code2) <= 299){
            $cellid2 = ("56".$code3);
        }
        elseif (is_numeric($code2) && intval($code2) >= 300 && intval($code2) <= 399){
            $cellid2 = ("57".$code3);
        }
        elseif (is_numeric($code2) && intval($code2) >= 400 && intval($code2) <= 499){
            $cellid2 = ("58".$code3);
        }
        elseif (is_numeric($code2) && intval($code2) >= 500 && intval($code2) <= 599){
            $cellid2 = ("59".$code3);
        }
        elseif (is_numeric($code2) && intval($code2) >= 600 && intval($code2) <= 699){
            $cellid2 = ("52".$code3);
        }
        elseif (is_numeric($code2) && intval($code2) >= 800 && intval($code2) <= 899){
            $cellid2 = ("53".$code3);
        }
        }
        elseif($code1 == "DRA"){
            if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                $cellid2 = ("60".$code3);
            }
            elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                $cellid2 = ("61".$code3);
            } 
        }
        elseif($code1 == "SWD"){
            if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                $cellid2 = ("48".$code3);
            }
            elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                $cellid2 = ("49".$code3);
            } 
        }
        elseif($code1 == "QRA"){
            if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                $cellid2 = ("64".$code3);
            }
            elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                $cellid2 = ("65".$code3);
            } 
        }
        if($code1 == "ALP"){
            if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                $cellid2 = ("20".$code3);
            }
            elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                $cellid2 = ("21".$code3);
            }
            elseif (is_numeric($code2) && intval($code2) >= 200 && intval($code2) <= 299){
                $cellid2 = ("22".$code3);
            }
            elseif (is_numeric($code2) && intval($code2) >= 300 && intval($code2) <= 399){
                $cellid2 = ("23".$code3);
            }
            elseif (is_numeric($code2) && intval($code2) >= 400 && intval($code2) <= 499){
                $cellid2 = ("24".$code3);
            }
            elseif (is_numeric($code2) && intval($code2) >= 500 && intval($code2) <= 599){
                $cellid2 = ("25".$code3);
            }
            elseif (is_numeric($code2) && intval($code2) >= 800 && intval($code2) <= 899){
                $cellid2 = ("28".$code3);
            }
            elseif (is_numeric($code2) && intval($code2) >= 900 && intval($code2) <= 999){
                $cellid2 = ("29".$code3);
            }
            }
            elseif($code1 == "IDB"){
                if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                    $cellid2 = ("50".$code3);
                }
                elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                    $cellid2 = ("51".$code3);
                } 
            }
            elseif($code1 == "RKA"){
                if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                    $cellid2 = ("62".$code3);
                }
                elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                    $cellid2 = ("63".$code3);
                } 
            }
            elseif($code1 == "DRZ"){
                if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                    $cellid2 = ("26".$code3);
                }
                elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                    $cellid2 = ("27".$code3);
                } 
            }
            elseif($code1 == "HSK"){
                if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                    $cellid2 = ("38".$code3);
                }
                elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                    $cellid2 = ("39".$code3);
                } 
            }
                elseif($code1 == "HMS"){
                if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                    $cellid2 = ("30".$code3);
                }
                elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                    $cellid2 = ("31".$code3);
                }
                elseif (is_numeric($code2) && intval($code2) >= 200 && intval($code2) <= 299){
                    $cellid2 = ("32".$code3);
                }
                elseif (is_numeric($code2) && intval($code2) >= 300 && intval($code2) <= 399){
                    $cellid2 = ("33".$code3);
                }
            }
            elseif($code1 == "HMA"){
                if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                    $cellid2 = ("34".$code3);
                }
                elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                    $cellid2 = ("35".$code3);
                }
                elseif (is_numeric($code2) && intval($code2) >= 200 && intval($code2) <= 299){
                    $cellid2 = ("36".$code3);
                }
                elseif (is_numeric($code2) && intval($code2) >= 500 && intval($code2) <= 599){
                    $cellid2 = ("37".$code3);
                }
            }
            elseif($code1 == "LTK"){
                if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                    $cellid2 = ("40".$code3);
                }
                elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                    $cellid2 = ("41".$code3);
                }
                elseif (is_numeric($code2) && intval($code2) >= 200 && intval($code2) <= 299){
                    $cellid2 = ("42".$code3);
                }
                elseif (is_numeric($code2) && intval($code2) >= 300 && intval($code2) <= 399){
                    $cellid2 = ("43".$code3);
                }
            }
            elseif($code1 == "TRS"){
                if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                    $cellid2 = ("44".$code3);
                }
                elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                    $cellid2 = ("45".$code3);
                }
                elseif (is_numeric($code2) && intval($code2) >= 200 && intval($code2) <= 299){
                    $cellid2 = ("46".$code3);
                }
                elseif (is_numeric($code2) && intval($code2) >= 500 && intval($code2) <= 599){
                    $cellid2 = ("47".$code3);
                }
            }

try{
$sql = "INSERT INTO TWO_G_SITES(SITE_ID, CELL_ID, BAND, SITE_STATUS, BTS_TYPE, BSC, TWOG_ON_AIR_DATE, NINTY_GSM_RBS_TYPE, NINTY_ON_AIR_DATE, EIGHTY_GSM_RBS_TYPE, EIGHTY_ON_AIR_DATE, NOTES, REAL_BSC, LAC) 
VALUES (:sd, TWO_G_SITES_SEQ.NEXTVAL, :band,:statu, :bts, :bsc, :date2G, :ninty_rbs, :ninty_date, :eighty_rbs, :eighty_date, :snote, :Rbsc,:lac)
RETURNING CELL_ID INTO :last_id";

$insert_stmt =oci_parse($conn,$sql);

oci_bind_by_name($insert_stmt, ':sd'      , $sid);
//oci_bind_by_name($insert_stmt, ':sitecode', $sitecode);
oci_bind_by_name($insert_stmt, ':band'    , $band);
oci_bind_by_name($insert_stmt, ':bsc'     , $BSC);
oci_bind_by_name($insert_stmt, ':statu'   , $status2G);
oci_bind_by_name($insert_stmt, ':date2G'  , $date2G);
oci_bind_by_name($insert_stmt, ':bts'     , $BTS);
oci_bind_by_name($insert_stmt, ':ninty_rbs', $RBS1);
oci_bind_by_name($insert_stmt, ':ninty_date', $date1);
oci_bind_by_name($insert_stmt, ':eighty_rbs', $RBS2);
oci_bind_by_name($insert_stmt, ':eighty_date', $date2);
oci_bind_by_name($insert_stmt, ':snote'   , $snote);
oci_bind_by_name($insert_stmt, ':Rbsc', $LBSC);
oci_bind_by_name($insert_stmt, ':lac'       , $lac);
oci_bind_by_name($insert_stmt, ':last_id'   , $Cell_ID, -1, SQLT_INT);



if (!oci_execute($insert_stmt)) {
    throw new Exception(oci_error($insert_stmt)['message']);
}

//$Cell_ID = oci_parse($conn, "SELECT 2GSITES_SEQ.CURRVAL FROM TWOGSITES");
    oci_free_statement($insert_stmt);
    oci_close($conn);
}
catch (Exception $e) {
    echo "Error executing: " . $e->getMessage();
}
    $selectedA = false;
    $selectedB = false;
    $selectedC = false;
    $selectedD = false;
    if(!empty($_POST['cell'])){
        // Loop to store and display values of individual checked checkbox.
        foreach($_POST['cell'] as $selected){

            $cellcode = $sitecode .$selected;
            $cellname = $sitename.'-'.$selected;
            if($selected == 'A'){
                $selectedA = true;
                $newcellid = $cellid2.'1';
                $azimuth = $_POST['azimutha']?? '';
                $height = $_POST['heighta']?? '';
                $mtilt = $_POST['mtilta']?? '';
                $etilt = $_POST['etilta']?? '';
                $earea = $_POST['area1a']?? '';
                $aarea = $_POST['area2a']?? '';
                $cnote = $_POST['cnotea']?? '';
                if(!empty( $_POST['etilta'] && !empty($_POST['mtilta']))){
                    $ttilt = sprintf('%d',$_POST['mtilta'] + $_POST['etilta']);
                }
                else $ttilt ="-";
              
            }
            elseif($selected == 'B'){
                $selectedB = true;
                $newcellid = $cellid2.'2';
                $azimuth = $_POST['azimuthb']?? '';
                $height = $_POST['heightb']?? '';
                $mtilt = $_POST['mtiltb']?? '';
                $etilt = $_POST['etiltb']?? '';
                $earea = $_POST['area1b']?? '';
                $aarea = $_POST['area2b']?? '';
                $cnote = $_POST['cnoteb']?? '';
                if(!empty( $_POST['etiltb'] && !empty($_POST['mtiltb']))){
                    $ttilt = sprintf('%d',$_POST['mtiltb'] + $_POST['etiltb']);
                }
                else $ttilt ="-";


              
            }
            elseif($selected == 'C'){
                $selectedC = true;
                $newcellid = $cellid2.'3';
                $azimuth = $_POST['azimuthC']?? '';
                $height = $_POST['heightC']?? '';
                $mtilt = $_POST['mtiltC']?? '';
                $etilt = $_POST['etiltC']?? '';
                $earea = $_POST['area1C']?? '';
                $aarea = $_POST['area2C']?? '';
                $cnote = $_POST['cnoteC']?? '';
                if(!empty( $_POST['etiltC'] && !empty($_POST['mtiltC']))){
                    $ttilt = sprintf('%d',$_POST['mtiltC'] + $_POST['etiltC']);
                }
                else $ttilt ="-";



               
            }
            elseif($selected == 'X'){
                $newcellid = $cellid2.'4';
                if($selectedA){
                $azimuth = $_POST['azimutha']?? '';
                $height = $_POST['heighta']?? '';
                $mtilt = $_POST['mtilta']?? '';
                $etilt = $_POST['etilta']?? '';
                $earea = $_POST['area1a']?? '';
                $aarea = $_POST['area2a']?? '';
               
                if(!empty( $_POST['etilta'] && !empty($_POST['mtilta']))){
                    $ttilt = sprintf('%d',$_POST['mtilta'] + $_POST['etilta']);
                }
                else $ttilt ="-";

            }
            else {
                $azimuth = $_POST['azimuthx']?? '';
                $height = $_POST['heightx']?? '';
                $mtilt = $_POST['mtiltx']?? '';
                $etilt = $_POST['etiltx']?? '';
                $earea = $_POST['area1x']?? '';
                $aarea = $_POST['area2x']?? '';
                $cnote = $_POST['cnotex']?? '';
                if(!empty( $_POST['etiltx'] && !empty($_POST['mtiltx']))){
                    $ttilt = sprintf('%d',$_POST['mtiltx'] + $_POST['etiltx']);
                }
                else $ttilt ="-";


            }


                
            }
            elseif($selected == 'Y'){
                $newcellid = $cellid2.'5';
                if($selectedB){
                $azimuth = $_POST['azimuthb']?? '';
                $height = $_POST['heightb']?? '';
                $mtilt = $_POST['mtiltb']?? '';
                $etilt = $_POST['etiltb']?? '';
                $earea = $_POST['area1b']?? '';
                $aarea = $_POST['area2b']?? '';
                if(!empty( $_POST['etiltb'] && !empty($_POST['mtiltb']))){
                    $ttilt = sprintf('%d',$_POST['mtiltb'] + $_POST['etiltb']);
                }
                else $ttilt ="-";
            }
            else{
                $azimuth = $_POST['azimuthy']?? '';
                $height = $_POST['heighty']?? '';
                $mtilt = $_POST['mtilty']?? '';
                $etilt = $_POST['etilty']?? '';
                $earea = $_POST['area1y']?? '';
                $aarea = $_POST['area2y']?? '';
                $cnote = $_POST['cnotey']?? '';
                if(!empty( $_POST['etilty'] && !empty($_POST['mtilty']))){
                    $ttilt = sprintf('%d',$_POST['mtilty'] + $_POST['etilty']);
                }
                else $ttilt ="-";
            }

        }
            elseif($selected == 'Z'){
                $newcellid = $cellid2.'6';
                if($selectedC){
                $azimuth = $_POST['azimuthC']?? '';
                $height = $_POST['heightC']?? '';
                $mtilt = $_POST['mtiltC']?? '';
                $etilt = $_POST['etiltC']?? '';
                $earea = $_POST['area1C']?? '';
                $aarea = $_POST['area2C']?? '';
                if(!empty( $_POST['etiltC'] && !empty($_POST['mtiltC']))){
                    $ttilt = sprintf('%d',$_POST['mtiltC'] + $_POST['etiltC']);
                }
                else $ttilt ="-";
            }

                else{
                    $azimuth = $_POST['azimuthz']?? '';
                    $height = $_POST['heightz']?? '';
                    $mtilt = $_POST['mtiltz']?? '';
                    $etilt = $_POST['etiltz']?? '';
                    $earea = $_POST['area1z']?? '';
                    $aarea = $_POST['area2z']?? '';
                    $cnote = $_POST['cnotez']?? '';
                    if(!empty( $_POST['etiltz'] && !empty($_POST['mtiltz']))){
                        $ttilt = sprintf('%d',$_POST['mtiltz'] + $_POST['etiltz']);
                    }
                    else $ttilt ="-";
                }
            }
    
            elseif($selected == 'D'){
                $selectedD = true;
                $newcellid = $cellid2.'7';
                $azimuth = $_POST['azimuthd']?? '';
                $height = $_POST['heightd']?? '';
                $mtilt = $_POST['mtiltd']?? '';
                $etilt = $_POST['etiltd']?? '';
                $earea = $_POST['area1d']?? '';
                $aarea = $_POST['area2d']?? '';
                $cnote = $_POST['cnoted']?? '';
                if(!empty( $_POST['etiltd'] && !empty($_POST['mtiltd']))){
                    $ttilt = sprintf('%d',$_POST['mtiltd'] + $_POST['etiltd']);
                }
                else $ttilt ="-";
               
            }
            elseif($selected == 'W'){
                $newcellid = $cellid2.'8';
                if($selectedD){
                $azimuth = $_POST['azimuthd']?? '';
                $height = $_POST['heightd']?? '';
                $mtilt = $_POST['mtiltd']?? '';
                $etilt = $_POST['etiltd']?? '';
                $earea = $_POST['area1d']?? '';
                $aarea = $_POST['area2d']?? '';
                
                if(!empty( $_POST['etiltd'] && !empty($_POST['mtiltd']))){
                    $ttilt = sprintf('%d',$_POST['mtiltd'] + $_POST['etiltd']);
                }
                else $ttilt ="-";
            }
            else{
                $azimuth = $_POST['azimuthw']?? '';
                $height = $_POST['heightw']?? '';
                $mtilt = $_POST['mtiltw']?? '';
                $etilt = $_POST['etiltw']?? '';
                $earea = $_POST['area1w']?? '';
                $aarea = $_POST['area2w']?? '';
                $cnote = $_POST['cnotew']?? '';
                if(!empty( $_POST['etiltw'] && !empty($_POST['mtiltw']))){
                    $ttilt = sprintf('%d',$_POST['mtiltw'] + $_POST['etiltw']);
                }
                else $ttilt ="-";
            }
        }
            elseif($selected == 'E'){
                $newcellid = $cellid2.'0';
                $azimuth = $_POST['azimuthe']?? '';
                $height = $_POST['heighte']?? '';
                $mtilt = $_POST['mtilte']?? '';
                $etilt = $_POST['etilte']?? '';
                $earea = $_POST['area1e']?? '';
                $aarea = $_POST['area2e']?? '';
                $cnote = $_POST['cnotee']?? '';
                if(!empty( $_POST['etilte'] && !empty($_POST['mtilte']))){
                    $ttilt = sprintf('%d',$_POST['mtilte'] + $_POST['etilte']);
                }
                else $ttilt ="-";
              
            
            }
            elseif($selected == 'U'){
                $newcellid = $cellid2.'0';
                $azimuth = $_POST['azimuthu']?? '';
                $height = $_POST['heightu']?? '';
                $mtilt = $_POST['mtiltu']?? '';
                $etilt = $_POST['etiltu']?? '';
                $earea = $_POST['area1u']?? '';
                $aarea = $_POST['area2u']?? '';
                $cnote = $_POST['cnoteu']?? '';
                if(!empty( $_POST['etiltu'] && !empty($_POST['mtiltu']))){
                    $ttilt = sprintf('%d',$_POST['mtiltu'] + $_POST['etiltu']);
                }
                else $ttilt ="-";
                
            }
            elseif($selected == 'V'){
                $newcellid = $cellid2.'9';
                $azimuth = $_POST['azimuthv']?? '';
                $height = $_POST['heightv']?? '';
                $mtilt = $_POST['mtiltv']?? '';
                $etilt = $_POST['etiltv']?? '';
                $earea = $_POST['area1v']?? '';
                $aarea = $_POST['area2v']?? '';
                $cnote = $_POST['cnotev']?? '';
                if(!empty( $_POST['etiltv'] && !empty($_POST['mtiltv']))){
                    $ttilt = sprintf('%d',$_POST['mtiltv'] + $_POST['etiltv']);
                }
                else $ttilt ="-";
             
            }
try{
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
           

        $sql = "INSERT INTO TWO_G_CELLS(CID_KEY, CELL_CODE, CELL_NAME, CELL_ID, AZIMUTH, HIEGHT, BSIC, M_TILT, E_TILT, TOTAL_TILT, BSC, BCCH, CELL_ON_AIR_DATE, NOTE, SERVING_AREA_IN_ENGLISH, SERVING_AREA) 
        VALUES (:cid_key, :cell_code, :cell_name, :cell_id, :azimuth, :height, :bsic, :m_tilt, :e_tilt, :total_tilt, :bsc, :bcch, :cell_on_air_date, :note, :serving_area_in_english, :serving_area)";

        $stid = oci_parse($conn, $sql);

            oci_bind_by_name($stid, ':cid_key', $Cell_ID);
            oci_bind_by_name($stid, ':cell_code', $cellcode);
            oci_bind_by_name($stid, ':cell_name', $cellname);
            oci_bind_by_name($stid, ':cell_id', $newcellid);
            oci_bind_by_name($stid, ':azimuth', $azimuth);
            oci_bind_by_name($stid, ':height', $height);
            oci_bind_by_name($stid, ':bsic', $BSIC);
            oci_bind_by_name($stid, ':m_tilt', $mtilt);
            oci_bind_by_name($stid, ':e_tilt', $etilt);
            oci_bind_by_name($stid, ':total_tilt', $ttilt);
            oci_bind_by_name($stid, ':bsc', $LBSC);
            oci_bind_by_name($stid, ':bcch', $BCCH);
            oci_bind_by_name($stid, ':cell_on_air_date', $date2);
            oci_bind_by_name($stid, ':note', $cnote);
            oci_bind_by_name($stid, ':serving_area_in_english', $earea);
            oci_bind_by_name($stid, ':serving_area', $aarea);

            if (!oci_execute($stid)) {
                 $e = oci_error($stid); 
                 throw new Exception($e['message']);
                 }

            oci_free_statement($stid);
            oci_close($conn);

}
    catch (Exception $e) { 
    echo "Error: " . $e->getMessage(); }

        }
    }

  

    if($site_type == '3G')
    {
        header("location:3G.php?id2=$sid");
    }
    else if($site_type == '4G'){
        header("location:4G.php?id3=$sid");
    }
    else if($site_type == 'addsite'){
        header("location:Add Site.php");
    }

  else {

  }









}








?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href= "fontawesome-free-6.5.2-web\css\all.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">



<title> 2G Site page </title>
<style>
.content-div {
    display: none;
}

#option1:checked ~ #content-container #div1 {
    display: block;
}
#option2:checked ~ #content-container #div2 {
    display: block;
}
#option3:checked ~ #content-container #div3 {
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
.submit2 {
    
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


.fixed-button {
            position: fixed; /* Fixes the button in place */
            right: 0px; /* Distance from the right side */
            top: 55%; /* Centers it vertically */
            transform: translateY(-50%); /* Adjusts the position to truly center it */
            background-color: #1c355c; /* Button color */
            color: white; /* Text color */
            border: none; /* No border */
            padding: 15px 20px; /* Padding around the text */
            border-radius: 15px 0px 0px 15px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow for depth */
            decoration:none;
        }

        .fixed-button2 {
            position: fixed; /* Fixes the button in place */
            right: 0px; /* Distance from the right side */
            top: 62%; /* Centers it vertically */
            transform: translateY(-50%); /* Adjusts the position to truly center it */
            background-color: #1c355c; /* Button color */
            color: white; /* Text color */
            border: none; /* No border */
            padding: 15px 20px; /* Padding around the text */
            border-radius: 15px 0px 0px 15px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow for depth */
        }

        .fixed-button3 {
            position: fixed; /* Fixes the button in place */
            right: 0px; /* Distance from the right side */
            top: 70%; /* Centers it vertically */
            transform: translateY(-50%); /* Adjusts the position to truly center it */
            background-color: #1c355c; /* Button color */
            color: white; /* Text color */
            border: none; /* No border */
            padding: 15px 20px; /* Padding around the text */
            border-radius: 15px 0px 0px 15px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow for depth */
        }

        .fixed-button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }

        .fixed-button2:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
        .fixed-button3:hover {
            background-color: #0056b3; /* Darker shade on hover */
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

<script type="text/javascript">
 
            function validateForm() {
            // Get all checkboxes
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            
            // Check if at least one checkbox is selected
            let isAnyCheckboxChecked = false;
            for (let checkbox of checkboxes) {
                if (checkbox.checked) {
                    isAnyCheckboxChecked = true;
                    break;
                }
            }
            
            if (!isAnyCheckboxChecked) {
                alert("Please select at least one checkbox.");
                return false; // Prevent form submission
            }
        }


    </script>

</head>
<body >
    <div class="container">
    
        <div class="header">
            <h1></br> 2G Site Informations </h1>
             Fill <?php echo $row['SITE_CODE']; ?>   details Informations.</br>
</br>
        </div>
        
        <form id ="myForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit= "return validateForm();">
        <div class="form1">
        <div>
            <input type ="hidden" name ="id"       value="<?php echo $siteid; ?>">
            <input type ="hidden" name ="sitecode" value="<?php echo $row['SITE_CODE']; ?>">
            <input type ="hidden" name ="sitename" value="<?php echo $row['SITE_NAME']; ?>">
            <input type ="hidden" name ="supplier" value="<?php echo $row['SUPPLIER']; ?>">
         
        </div>
        
            Select Band Width: </br>
            


            <input type ="radio" id= "option1"  name="band" value="900">900
            <input type ="radio" id= "option2" name="band" value="1800">1800
            <input type ="radio" id= "option3"  name="band" value="900/1800">900/1800</br></br>




        


    <div>
    BTS Type:  <select name="BTS" required>
        
        <option value="Empty">--</option>
        <option value="macro">Macro</option>
        <option value="mbts">MBTS</option>
        <option value="micro">Micro</option>
        <option value="grd">GRD</option>
        <option value="rdu">RDU</option>

        
    </select>
    </br></br>
</div>

<div>
    <label for="air date" required>2G On Air Date:</label>
    <input type ="date" name="onairdate" size="15" id="air date"></br></br>
</div>
<div id="content-container">
<div id="div1" class="content-div">
    900 GSM RBS Type:   
    <select name="900Rbs"> 
        <option value="">--</option>     
        <option value="BTS5900"    >BTS5900</option>  
        <option value="BTS3900"     >BTS3900</option>
        <option value="DBS3900"     >DBS3900</option>
        <option value="DBS5900"     >DBS5900</option>
        <option value="BTS3900A"    >BTS3900A</option>
        <option value="BTS3900L"    >BTS3900L</option>
        <option value="6130"        >6130</option>
        <option value="6102"        >6102</option>
        <option value="6102/RRUS"   >6102/RRUS</option>
        <option value="6102/RUS"    >6102/RUS</option>
        <option value="6102_V2"     >6102_V2</option>
        <option value="6102/RUG"    >6102/RUG</option>
        <option value="6102\RRUS"   >6102\RRUS</option>
        <option value="6102W"       >6102W</option>
        <option value="2206"        >2206</option>
        <option value="2206_V1"     >2206_V1</option>
        <option value="2206_V2"     >2206_V2</option>
        <option value="2216"       >2216</option>
        <option value="2216_V2"     >2216_V2</option>
        <option value="6150"        >6150</option>
        <option value="6150/RUS"    >6150/RUS</option>
        <option value="6201"        >6201</option>
        <option value="6201_V2"     >6201_V2</option>
        <option value="6201\DUG"   >6201\DUG</option>
        <option value="6201/RUS"    >6201/RUS</option>
        <option value="6201V2/RUS" >6201V2/RUS</option>
        <option value="6301"        >6301</option>
        <option value="6301/RRUS"   >6301/RRUS</option>
        <option value="2109"        >2109</option>
        <option value="2111"        >2111</option>
        <option value="2116"       >2116</option>
        <option value="2302"        >2302</option>
        <option value="2308"        >2308</option>
        <option value="6601"        >6601</option>
        <option value="6601/RRUS"  >6601/RRUS</option>

    </select>
    </br></br>

    <label for="air date1">900 On Air Date:</label>
    <input type ="date" name="900onairdate" size="15" id="air date1"></br></br>
    </div>

    <div id="div2" class="content-div">
    1800 GSM RBS Type:   
    <select name="1800Rbs"> 
        
        <option value="">--</option>
        <option value="BTS5900"    >BTS5900</option>
        <option value="BTS3900"     >BTS3900</option>
        <option value="DBS3900"     >DBS3900</option>
        <option value="DBS5900"     >DBS5900</option>
        <option value="BTS3900A"    >BTS3900A</option>
        <option value="BTS3900L"    >BTS3900L</option>
        <option value="6130"        >6130</option>
        <option value="6102"        >6102</option>
        <option value="6102/RRUS"   >6102/RRUS</option>
        <option value="6102/RUS"    >6102/RUS</option>
        <option value="6102_V2"     >6102_V2</option>
        <option value="6102/RUG"    >6102/RUG</option>
        <option value="6102\RRUS"   >6102\RRUS</option>
        <option value="6102W"       >6102W</option>
        <option value="2206"        >2206</option>
        <option value="2206_V1"     >2206_V1</option>
        <option value="2206_V2"     >2206_V2</option>
        <option value="2216"       >2216</option>
        <option value="2216_V2"     >2216_V2</option>
        <option value="6150"        >6150</option>
        <option value="6150/RUS"    >6150/RUS</option>
        <option value="6201"        >6201</option>
        <option value="6201_V2"     >6201_V2</option>
        <option value="6201\DUG"   >6201\DUG</option>
        <option value="6201/RUS"    >6201/RUS</option>
        <option value="6201V2/RUS" >6201V2/RUS</option>
        <option value="6301"        >6301</option>
        <option value="6301/RRUS"   >6301/RRUS</option>
        <option value="2109"        >2109</option>
        <option value="2111"        >2111</option>
        <option value="2116"       >2116</option>
        <option value="2302"        >2302</option>
        <option value="2308"        >2308</option>
        <option value="6601"        >6601</option>
        <option value="6601/RRUS"  >6601/RRUS</option>


    </select>
    </br></br>

    <label for="air date2">1800 On Air Date:</label>
    <input type ="date" name="1800onairdate" size="15" id="air date2"></br></br>    
    </div>






<div id="div3" class="content-div">
    <div id="div1-inner">
    900 GSM RBS Type:   <select name="900Rbs"> 
        <option value="">--</option> 
        <option value="BTS5900"    >BTS5900</option>      
        <option value="BTS3900"     >BTS3900</option>
        <option value="DBS3900"     >DBS3900</option>
        <option value="DBS5900"     >DBS5900</option>
        <option value="BTS3900A"    >BTS3900A</option>
        <option value="BTS3900L"    >BTS3900L</option>
        <option value="6130"        >6130</option>
        <option value="6102"        >6102</option>
        <option value="6102/RRUS"   >6102/RRUS</option>
        <option value="6102/RUS"    >6102/RUS</option>
        <option value="6102_V2"     >6102_V2</option>
        <option value="6102/RUG"    >6102/RUG</option>
        <option value="6102\RRUS"   >6102\RRUS</option>
        <option value="6102W"       >6102W</option>
        <option value="2206"        >2206</option>
        <option value="2206_V1"     >2206_V1</option>
        <option value="2206_V2"     >2206_V2</option>
        <option value="2216"       >2216</option>
        <option value="2216_V2"     >2216_V2</option>
        <option value="6150"        >6150</option>
        <option value="6150/RUS"    >6150/RUS</option>
        <option value="6201"        >6201</option>
        <option value="6201_V2"     >6201_V2</option>
        <option value="6201\DUG"   >6201\DUG</option>
        <option value="6201/RUS"    >6201/RUS</option>
        <option value="6201V2/RUS" >6201V2/RUS</option>
        <option value="6301"        >6301</option>
        <option value="6301/RRUS"   >6301/RRUS</option>
        <option value="2109"        >2109</option>
        <option value="2111"        >2111</option>
        <option value="2116"       >2116</option>
        <option value="2302"        >2302</option>
        <option value="2308"        >2308</option>
        <option value="6601"        >6601</option>
        <option value="6601/RRUS"  >6601/RRUS</option>


    </select>
    </br></br>

    <label for="air date1">900 On Air Date:</label>
    <input type ="date" name="900onairdate" size="15" id="air date1"></br></br>
    </div>

    <div id="div2-inner">
    1800 GSM RBS Type:   <select name="1800Rbs"> 
        
        <option value="">--</option>
        <option value="BTS5900"    >BTS5900</option>
        <option value="BTS3900"     >BTS3900</option>
        <option value="DBS3900"     >DBS3900</option>
        <option value="DBS5900"     >DBS5900</option>
        <option value="BTS3900A"    >BTS3900A</option>
        <option value="BTS3900L"    >BTS3900L</option>
        <option value="6130"        >6130</option>
        <option value="6102"        >6102</option>
        <option value="6102/RRUS"   >6102/RRUS</option>
        <option value="6102/RUS"    >6102/RUS</option>
        <option value="6102_V2"     >6102_V2</option>
        <option value="6102/RUG"    >6102/RUG</option>
        <option value="6102\RRUS"   >6102\RRUS</option>
        <option value="6102W"       >6102W</option>
        <option value="2206"        >2206</option>
        <option value="2206_V1"     >2206_V1</option>
        <option value="2206_V2"     >2206_V2</option>
        <option value="2216"       >2216</option>
        <option value="2216_V2"     >2216_V2</option>
        <option value="6150"        >6150</option>
        <option value="6150/RUS"    >6150/RUS</option>
        <option value="6201"        >6201</option>
        <option value="6201_V2"     >6201_V2</option>
        <option value="6201\DUG"   >6201\DUG</option>
        <option value="6201/RUS"    >6201/RUS</option>
        <option value="6201V2/RUS" >6201V2/RUS</option>
        <option value="6301"        >6301</option>
        <option value="6301/RRUS"   >6301/RRUS</option>
        <option value="2109"        >2109</option>
        <option value="2111"        >2111</option>
        <option value="2116"       >2116</option>
        <option value="2302"        >2302</option>
        <option value="2308"        >2308</option>
        <option value="6601"        >6601</option>
        <option value="6601/RRUS"  >6601/RRUS</option>


    </select>
    </br></br>

    <label for="air date2">1800 On Air Date:</label>
    <input type ="date" name="1800onairdate" size="15" id="air date2"></br></br>    
    </div>
</div>
    </div>


    BSC:   <select name="BSC" required>    
  
            <?php if(isset($supplier)) {?>

        <?php foreach ($suppliers[$supplier] as $newsupplier): ?>
                <option value="<?php echo htmlspecialchars($newsupplier); ?>"><?php echo htmlspecialchars($newsupplier); ?></option>
            <?php endforeach; ?>
            <?php } else {?>
                <option value="Empty">--</option>  
                <option value="EVOBSC1">EVOBSC1</option>
                <option value="EVOBSC2">EVOBSC2</option>
                <option value="EVOBSC4">EVOBSC4</option>
                <option value="EVOBSC5">EVOBSC5</option>
                <option value="EVOBSC6">EVOBSC6</option>
                <option value="EVOBSC9">EVOBSC9</option>
                <option value="HDBSC1">HDBSC1</option>
                <option value="HDBSC2">HDBSC2</option>
                <option value="HBSC1">HBSC1</option>
                <option value="HBSC2">HBSC2</option>
                <option value="HBSC4">HBSC4</option>
                <option value="HBSC7">HBSC7</option>
                <option value="HBSC8">HBSC8</option>
                <option value="HBSC10">HBSC10</option>
                <option value="HBSC11">HBSC11</option>
                <option value="HSKBSC2">HSKBSC2</option>
            <?php  }?>
            

    </select>
    </br></br>

<div>
    <label for="lac" required>LAC:</label>
    <input type ="text" name="lac" size="4" id="lac"></br></br>
</div>
<div>
    <label for="note1">Site Notes:</label>
    <input type ="text" name="snotes" size="89" id="note1"></br></br>
</div>



<div>
    Select Cells:</br>
    <input type = "checkbox" name="cell[]" id="checkbox1" value="A">A
    <input type ="text" name="azimutha" size="5" placeholder="AzimuthA">
    <input type ="text" name="heighta" size="5"  placeholder="Height A">
    <input type ="text" name="mtilta" size="5" placeholder="M_TILT">
    <input type ="text" name="etilta" size="5" placeholder="E_TILT">
    <input type ="text" name="area1a" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2a" size="15" placeholder="English Serving Area"><br/>
    <input type ="text" name="cnotea" size="90" placeholder="Cell Note">
</div>

<div>
    </br>
    <input type = "checkbox" name="cell[]" id="checkbox2" value="B">B
    <input type ="text" name="azimuthb" size="5" placeholder="AzimuthB">
    <input type ="text" name="heightb" size="5"  placeholder="Height B">
    <input type ="text" name="mtiltb" size="5" placeholder="M_TILT">
    <input type ="text" name="etiltb" size="5" placeholder="E_TILT">
    <input type ="text" name="area1b" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2b" size="15" placeholder="English Serving Area"></br>
    <input type ="text" name="cnoteb" size="90" placeholder="Cell Note">

</div>
<div>
    </br>
    <input type = "checkbox" name="cell[]" id="checkbox3" value="C">C
    <input type ="text" name="azimuthC" size="5" placeholder="AzimuthC">
    <input type ="text" name="heightC" size="5"  placeholder="Height C">
    <input type ="text" name="mtiltC" size="5" placeholder="M_TILT">
    <input type ="text" name="etiltC" size="5" placeholder="E_TILT">
    <input type ="text" name="area1C" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2C" size="15" placeholder="English Serving Area"></br>
    <input type ="text" name="cnoteC" size="90" placeholder="Cell Note">
</div>
<div>
    </br>
    <input type = "checkbox" name="cell[]" id="checkbox4" value="D">D
    <input type ="text" name="azimuthd" size="5" placeholder="AzimuthD">
    <input type ="text" name="heightd" size="5"  placeholder="Height D">
    <input type ="text" name="mtiltd" size="5" placeholder="M_TILT">
    <input type ="text" name="etiltd" size="5" placeholder="E_TILT">
    <input type ="text" name="area1d" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2d" size="15" placeholder="English Serving Area"></br>
    <input type ="text" name="cnoted" size="90" placeholder="Cell Note">

</div>

<div>
    </br>
    <input type = "checkbox" name="cell[]" value="X">X
    <div id="conditionalDiv">
    <input type ="text" name="azimuthx" size="5" placeholder="AzimuthX">
    <input type ="text" name="heightx" size="5"  placeholder="Height X">
    <input type ="text" name="mtiltx" size="5" placeholder="M_TILT">
    <input type ="text" name="etiltx" size="5" placeholder="E_TILT">
    <input type ="text" name="area1x" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2x" size="15" placeholder="English Serving Area"></br>
    <input type ="text" name="cnotex" size="90" placeholder="Cell Note">
    </div>
    <script>
        // Get references to the elements
        const checkbox1 = document.getElementById('checkbox1');
        const conditionalDiv = document.getElementById('conditionalDiv');

        // Add an event listener to the first checkbox
        checkbox1.addEventListener('change', () => {
            if (checkbox1.checked) {
                // Hide the div if checkbox1 is checked
                conditionalDiv.style.display = 'none';
            } else {
                // Show the div if checkbox1 is unchecked
                conditionalDiv.style.display = 'block';
            }
        });
    </script>
    
    <input type = "checkbox" name="cell[]" value="Y">Y
    <div id="conditionalDiv1">
    <input type ="text" name="azimuthy" size="5" placeholder="AzimuthY">
    <input type ="text" name="heighty" size="5"  placeholder="Height Y">
    <input type ="text" name="mtilty" size="5" placeholder="M_TILT">
    <input type ="text" name="etilty" size="5" placeholder="E_TILT">
    <input type ="text" name="area1y" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2y" size="15" placeholder="English Serving Area"></br>
    <input type ="text" name="cnotey" size="90" placeholder="Cell Note">
    </div>
    <script>
        // Get references to the elements
        const checkbox2 = document.getElementById('checkbox2');
        const conditionalDiv1 = document.getElementById('conditionalDiv1');

        // Add an event listener to the first checkbox
        checkbox2.addEventListener('change', () => {
            if (checkbox2.checked) {
                // Hide the div if checkbox1 is checked
                conditionalDiv1.style.display = 'none';
            } else {
                // Show the div if checkbox1 is unchecked
                conditionalDiv1.style.display = 'block';
            }
        });
    </script>
    <input type = "checkbox" name="cell[]" value="Z">Z
    <div id="conditionalDiv3">
    <input type ="text" name="azimuthz" size="5" placeholder="AzimuthZ">
    <input type ="text" name="heightz" size="5"  placeholder="HeightZ">
    <input type ="text" name="mtiltz" size="5" placeholder="M_TILT">
    <input type ="text" name="etiltz" size="5" placeholder="E_TILT">
    <input type ="text" name="area1z" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2z" size="15" placeholder="English Serving Area"></br>
    <input type ="text" name="cnotez" size="90" placeholder="Cell Note">
    </div>
    <script>
        // Get references to the elements
        const checkbox3 = document.getElementById('checkbox3');
        const conditionalDiv3 = document.getElementById('conditionalDiv3');

        // Add an event listener to the first checkbox
        checkbox3.addEventListener('change', () => {
            if (checkbox3.checked) {
                // Hide the div if checkbox1 is checked
                conditionalDiv3.style.display = 'none';
            } else {
                // Show the div if checkbox1 is unchecked
                conditionalDiv3.style.display = 'block';
            }
        });
    </script>
<input type = "checkbox" name="cell[]" value="W">W
    <div id="conditionalDiv4">
    <input type ="text" name="azimuthw" size="5" placeholder="AzimuthW">
    <input type ="text" name="heightw" size="5"  placeholder="HeightW">
    <input type ="text" name="mtiltw" size="5" placeholder="M_TILT">
    <input type ="text" name="etiltw" size="5" placeholder="E_TILT">
    <input type ="text" name="area1w" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2w" size="15" placeholder="English Serving Area"></br>
    <input type ="text" name="cnotew" size="90" placeholder="Cell Note">
    </div>
    <script>
        // Get references to the elements
        const checkbox4 = document.getElementById('checkbox4');
        const conditionalDiv4 = document.getElementById('conditionalDiv4');

        // Add an event listener to the first checkbox
        checkbox4.addEventListener('change', () => {
            if (checkbox4.checked) {
                // Hide the div if checkbox1 is checked
                conditionalDiv4.style.display = 'none';
            } else {
                // Show the div if checkbox1 is unchecked
                conditionalDiv4.style.display = 'block';
            }
        });
    </script>


</br>
</div>
<div>
</br>
Select Extra Cells:</br>
    <input type = "checkbox" name="cell[]" value="V">V
    <input type ="text" name="azimuthv" size="5" placeholder="Azimuthv">
    <input type ="text" name="heightv" size="5"  placeholder="Height v">
    <input type ="text" name="mtiltv" size="5" placeholder="M_TILT">
    <input type ="text" name="etiltv" size="5" placeholder="E_TILT">
    <input type ="text" name="area1v" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2v" size="15" placeholder="English Serving Area"></br>
    <input type ="text" name="cnotev" size="90" placeholder="Cell Note">
    </br></br>
    </div>
<div>

    <input type = "checkbox" name="cell[]" value="U">U
    <input type ="text" name="azimuthu" size="5" placeholder="AzimuthU">
    <input type ="text" name="heightu" size="5"  placeholder="Height U">
    <input type ="text" name="mtiltu" size="5" placeholder="M_TILT">
    <input type ="text" name="etiltu" size="5" placeholder="E_TILT">
    <input type ="text" name="area1u" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2u" size="15" placeholder="English Serving Area"></br>
    <input type ="text" name="cnoteu" size="90" placeholder="Cell Note">
    </br></br>
    </div>
<div>
    <input type = "checkbox" name="cell[]" value="E">E
    <input type ="text" name="azimuthe" size="5" placeholder="AzimuthE">
    <input type ="text" name="heighte" size="5"  placeholder="Height E">
    <input type ="text" name="mtilte" size="5" placeholder="M_TILT">
    <input type ="text" name="etilte" size="5" placeholder="E_TILT">
    <input type ="text" name="area1e" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2e" size="15" placeholder="English Serving Area"></br>
    <input type ="text" name="cnotee" size="90" placeholder="Cell Note">
</br></br>
</div>

</div>


<div class="footer">
   
    
    <div class="type">
    <label>Select Next Page:</br></label></br>
    <input type ="radio" id= "custom-option2" name="SiteType" value="3G" class="custom">
    <label for="custom-option2" class="custom-label">3G Site Page.</label>
    
    <input type ="radio" id= "custom-option3" name="SiteType" value="4G" class="custom">
    <label for="custom-option3" class="custom-label">4G Site Page.</label>
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
<a href="update3G.php?id3=<?php echo $siteid; ?>" class="fixed-button" target="_blank">Edit 3G Info</a>
<a href="update4G.php?id4=<?php echo $siteid; ?>" class="fixed-button2" target="_blank">Edit 4G Info</a>
<a href="update_basic_info.php?id=<?php echo $siteid; ?>" class="fixed-button3" target="_blank">Edit Basic Info</a>
</div>


</body>
</html>
<script>
function confirmAndClose() {
    if (window.confirm('Are you sure you don’t want to add 2G site only without continue?')) {
        document.getElementById('myForm').submit();
        setTimeout(() => {
            window.close();
        }, 30); // Delay to ensure form submission completes
    }
}
</script>
