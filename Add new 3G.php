<?php 
include "config.php";
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $scode= $_POST['sitecode'] ?? '';
    //$scode= $_POST['sitecode'] ?? '';
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
    //$area_rank =$_POST['arearanking'];
    //$zone =$_POST['zone'];
    $supplier =$_POST['supplier'] ?? '';
    $cityrural1 =$_POST['C/R'] ?? '';

    $prio = $_POST['priority'] ?? '';
    $cat = $_POST['category'] ?? '';
    $subcontractor = $_POST['sub'] ?? '';
    $invoice = $_POST['invoice'] ?? '';
    $site_ranking = $_POST['sranking'] ?? '';
    $site_type = $_POST['SiteType'] ??'';
   
    $sitecode   = $_POST['sitecode'].'U';
    //$wbts       = $_POST['wbts'] ?? '';
    $RNC        = $_POST['RNC'] ?? '';
    $status     = "On Air";
   
    $BTS        = $_POST['bts'] ?? '';
    $carriers   = $_POST['numcarriers'] ?? '';
    $lac        = $_POST['lac'] ?? '';
    $restordate = $_POST['restoration'] ?? '';
    $snote      = $_POST['snotes'] ?? '';
    //$cellid2    = $wbts;
   // $sitecode1   = $_POST['sitecode'];
    $multisectorid = "2770";
 
    $code1 = substr($scode,0,3)?? '';
    $code2 = substr($scode,-3)?? '';
    $code3 = substr($scode,-2)?? '';
    
    $scode = strtoupper($scode);
    $code1 = substr($scode, 0, 3);
    //$code1 = strtoupper(substr($scode, 0, 3));


    $dateTime = new DateTime($ondate);
    $ondate = $dateTime->format('m/d/Y');

    $dateTime1 = new DateTime($restordate);
    $restordate = $dateTime1->format('m/d/Y');

  
    if (!preg_match("/^(DAM|DMR|DRA|ALP|DRZ|HMS|HMA|TRS|LTK|RKA|IDB|SWD|QRA|HSK)$/", $code1)) {
        // Output JavaScript alert if the site code is not valid
        //echo '<script>alert("Site code" .$code1." not valid");</script>';
    echo "Site code" .$code1." not valid";
        exit; // Stop further script execution
    }
    //$scode = $code1.$code2;
   

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

            $wbts = $cellid2;

   
  
        
        $sqll = 'SELECT * FROM NEW_SITES WHERE SITE_CODE = :site_code'; 
    $stid = oci_parse($conn, $sqll);
    oci_bind_by_name($stid, ':site_code', $scode); 
    oci_execute($stid);

    //$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)
    if($num_rows = oci_num_rows($stid)==0)
    {

     
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
    $err = oci_error($insert_stmt); 
    die("Error executing: " . $err['message']);
}

oci_free_statement($insert_stmt); 
oci_close($conn);


    $sqll = "INSERT INTO  THREE_G_SITES (SITE_ID, CELL_ID, SITE_CODE ,WBTS_TYPE, RNC, SITE_STATUS, THREE_G_ON_AIR_DATE, BTS_TYPE, NUMBER_OF_CARRIERS, NOTES, REAL_RNC, RESTORATION_DATE, LAC) 
    VALUES (:sd ,THREE_G_SITES_SEQ.NEXTVAL ,:sitecode ,:wbts ,:RNC ,:statu ,:date3G ,:BTS ,:carriers ,:snote ,:Real_RNC ,:restordate ,:lac)
    RETURNING CELL_ID INTO :last_id";
    $insert_stmt1 =oci_parse($conn,$sqll);
   

    oci_bind_by_name($insert_stmt1, ':sd'      , $ID);
    oci_bind_by_name($insert_stmt1, ':sitecode', $sitecode);
    oci_bind_by_name($insert_stmt1, ':wbts'    , $wbts);
    oci_bind_by_name($insert_stmt1, ':RNC'     , $RNC);
    oci_bind_by_name($insert_stmt1, ':statu'   , $status);
    oci_bind_by_name($insert_stmt1, ':date3G'  , $ondate);
    oci_bind_by_name($insert_stmt1, ':BTS'     , $BTS);
    oci_bind_by_name($insert_stmt1, ':carriers', $carriers);
    oci_bind_by_name($insert_stmt1, ':snote'   , $snote);
    oci_bind_by_name($insert_stmt1, ':Real_RNC', $RNC);
    oci_bind_by_name($insert_stmt1, ':restordate', $restordate);
    oci_bind_by_name($insert_stmt1, ':lac'       , $lac);
    oci_bind_by_name($insert_stmt1, ':last_id'   , $Cell_ID, -1, SQLT_INT);




    //if (!oci_execute($insert_stmt1)) { 
        //$err = oci_error($insert_stmt1); 
        //throw new Exception("Error executing: " . $err['message']); }
     //$Cell_ID = oci_parse($conn, "SELECT THREE_G_SITES_SEQ.CURRVAL FROM THREE_G_SITES");

     if(!oci_execute($insert_stmt1))
     { 
         $err = oci_error($insert_stmt1); 
die("Error executing: " . $err['message']);
     }




    oci_free_statement($insert_stmt1); 
    oci_close($conn);



    $selectedA = false;
    $selectedB = false;
    $selectedC = false;
    $selectedD = false;
    if(!empty($_POST['cell'])){
        // Loop to store and display values of individual checked checkbox.
        foreach($_POST['cell'] as $selected){

            $cellcode = $sitecode .$selected;
            $cellname = $sname.'-'.$selected;
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
         
         $sqlll ="INSERT INTO THREE_G_CELLS (CID, MSCELL_ID, CELL_ID, CELL_CODE, CELL_NAME, ON_AIR_DATE, CARRIER, AZIMUTH, M_TILT, E_TILT, TOTAL_TILT, SERVING_AREA, SERVING_AREA_IN_ENGLISH, NOTE, HIEGHT) 
         VALUES (:cell_id, :multisectorid, :newcellid, :cellcode, :cellname, :date3G, :carriers, :azimuth, :mtilt, :etilt, :ttilt, :aarea, :earea, :cnote, :height)";
         $stmtt =oci_parse ($conn,$sqlll);

         oci_bind_by_name($stmtt, ':cell_id' ,$Cell_ID);
         oci_bind_by_name($stmtt, ':multisectorid' ,$multisectorid);
         oci_bind_by_name($stmtt, ':newcellid', $newcellid);
         oci_bind_by_name($stmtt, ':cellcode', $cellcode);
         oci_bind_by_name($stmtt, ':cellname', $cellname);
         oci_bind_by_name($stmtt, ':date3G', $ondate);
         oci_bind_by_name($stmtt, ':carriers', $carriers);
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
             $err = oci_error($stmtt); 
 die("Error executing: " . $err['message']);
         }
     }
         oci_free_statement($stmtt); 
         oci_close($conn);

     }







            //header("location:4G.php?id3=$ID");
            //exit;






        }
        else 
        {
            while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS))
            {
                echo "Site Already Exist";
                $ID= $row[0];
                //header("location:4G.php?id3=$ID");

            }
        }
        if($site_type == '4G'){
            header("location:4G.php?id3=$ID");
        }
        elseif($site_type == '2G'){
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
<title> Add Site page </title>
<script>
function confirmcancel(){
        return confirm ("Are you sure you want to cancel without adding site?" );
     
    }
    
    

    

    </script>
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

<script>
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
<body>
<div class="container">
<div class="header">
            <h1></br> New 3G Site Informations  </h1>
            Please fill 3G site informations and then select next page to add another technology.</br>
</br>
        </div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit= "return validateForm();">
<div class="form1">
<div>
    <label class="required-field" for="code">Site Code</label>
    <input type="text" name="sitecode" size="7" id="code" required></br></br>

</div>

<div>
    <label class="required-field" for="name">Site Name</label>
    <input type="text" name="sitename" size="33" id="name" required></br></br>
</div>


<div>
    <label class="required-field">City/Rural</label>
                    <input type="radio" id="city" name="C/R" value="City"> City
    <input type="radio" id="rural" name="C/R" value="Rural">Rural</br></br>
</div>
<div>
<label class="required-field">Supplier</label>
    <input type="radio" id="erc" name="supplier" value="Ericsson">Ericsson
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
                        <option value="2 MTN Generator + Hybrid + Non Rationing line">2 MTN Generator + Hybrid + Non
                            Rationing line</option>
                        <option value="2 MTN Generator + Hybrid + Wind">2 MTN Generator + Hybrid + Wind</option>
                        <option value="2 MTN Generator + Non Rationing line">2 MTN Generator + Non Rationing line
                        </option>
                        <option value="Ampere">Ampere</option>
                        <option value="Ampere + Industrial line">Ampere + Industrial line</option>
                        <option value="Ampere + Other MTN Gen">Ampere + Other MTN Gen</option>
                        <option value="Ampere + Hybrid">Ampere + Hybrid</option>
                        <option value="Batteries">Batteries</option>
                        <option value="Hybrid">Hybrid</option>
                        <option value="Hybrid (Installed) + MTN Generator">Hybrid (Installed) + MTN Generator</option>
                        <option value="Hybrid + Ampere + Non Rationing line">Hybrid + Ampere + Non Rationing line
                        </option>
                        <option value="Hybrid + Ampere + Other MTN Gen">Hybrid + Ampere + Other MTN Gen</option>
                        <option value="Hybrid + Industrial line">Hybrid + Industrial line</option>
                        <option value="Hybrid + Lithium batteries">Hybrid + Lithium batteries</option>
                        <option value="Hybrid + MTN rented Generator + Ampere">Hybrid + MTN rented Generator + Ampere
                        </option>
                        <option value="Hybrid + Non Rationing line">Hybrid + Non Rationing line</option>
                        <option value="Hybrid + Other MTN Gen">Hybrid + Other MTN Gen</option>
                        <option value="Hybrid + Syriatel Generator">Hybrid + Syriatel Generator</option>
                        <option value="Industrial line">Industrial line</option>
                        <option value="Lithium Batteries">Lithium Batteries</option>
                        <option value="MTN Generator">MTN Generator</option>
                        <option value="MTN Generator (OOS) + Ampere">MTN Generator (OOS) + Ampere</option>
                        <option value="MTN Generator (OOS) + Hybrid + Ampere">MTN Generator (OOS) + Hybrid + Ampere
                        </option>
                        <option value="MTN Generator (OOS) + MTN Rented Generator">MTN Generator (OOS) + MTN Rented
                            Generator</option>
                        <option value="MTN Generator (OOS)+ Hybrid + Ampere">MTN Generator (OOS)+ Hybrid + Ampere
                        </option>
                        <option value="MTN Generator + Ampere">MTN Generator + Ampere</option>
                        <option value="MTN Generator + Ampere + Other MTN Gen">MTN Generator + Ampere + Other MTN Gen
                        </option>
                        <option value="MTN Generator + Ampere + Syriatel Generator">MTN Generator + Ampere + Syriatel
                            Generator</option>
                        <option value="MTN Generator + Hybrid">MTN Generator + Hybrid</option>
                        <option value="MTN Generator + Hybrid (inactive) + Ampere">MTN Generator + Hybrid (inactive) +
                            Ampere</option>
                        <option value="MTN Generator + Hybrid (OOS) + Ampere">MTN Generator + Hybrid (OOS) + Ampere
                        </option>
                        <option value="MTN Generator + Hybrid (OOS) +industrial line">MTN Generator + Hybrid (OOS)
                            +industrial line</option>
                        <option value="MTN Generator + Hybrid + Ampere">MTN Generator + Hybrid + Ampere</option>
                        <option value="MTN Generator + Hybrid + Golden line">MTN Generator + Hybrid + Golden line
                        </option>
                        <option value="MTN Generator + Hybrid + Industrial line">MTN Generator + Hybrid + Industrial
                            line</option>
                        <option value="MTN Generator + Hybrid + Non Rationing line">MTN Generator + Hybrid + Non
                            Rationing line</option>
                        <option value="MTN Generator + Hybrid + Other Generator">MTN Generator + Hybrid + Other
                            Generator</option>
                        <option value="MTN Generator + Hybrid + STE generator">MTN Generator + Hybrid + STE generator
                        </option>
                        <option value="MTN Generator + Hybrid + Syriatel Generator">MTN Generator + Hybrid + Syriatel
                            Generator</option>
                        <option value="MTN Generator + Hybrid(OOS)">MTN Generator + Hybrid(OOS)</option>
                        <option value="MTN Generator + Hybrid+ industrial line">MTN Generator + Hybrid+ industrial line
                        </option>
                        <option value="MTN Generator + Hybrid+ Lithium batteries">MTN Generator + Hybrid+ Lithium
                            batteries</option>
                        <option value="MTN Generator + Industrial line">MTN Generator + Industrial line</option>
                        <option value="MTN Generator + Lithium batteries">MTN Generator + Lithium batteries</option>
                        <option value="MTN Generator + MTN Generator (OOS) + MTN Rented Generator">MTN Generator + MTN
                            Generator (OOS) + MTN Rented Generator</option>
                        <option value="MTN Generator + Non Rationing line">MTN Generator + Non Rationing line</option>
                        <option value="MTN Generator + STE Generator">MTN Generator + STE Generator</option>
                        <option value="MTN Generator + STE Generator + Non Rationing line">MTN Generator + STE Generator
                            + Non Rationing line</option>
                        <option value="MTN Generator + Syriatel Generator">MTN Generator + Syriatel Generator</option>
                        <option value="MTN Generator(OOS)+MTN rented Generaor">MTN Generator(OOS)+MTN rented Generaor
                        </option>
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
<div>
    <label class="required-field" for="air date">On Air Date:</label>
    <input type="date" name="onairdate" size="15" id="air date" required></br></br>
</div>
<div>
    <label class="required-field" for="coorE">Coordinates E:</label>
    <input type="text" name="coordinatesE" size="10" id="coorE" required></br></br>
</div>
<div>
    <label class="required-field" for="coorN">Coordinates N:</label>
    <input type="text" name="coordinatesN" size="10" id="coorN" required></br></br>
</div>
<div>
    <label class="required-field" for="Att">Alttitude:</label>
    <input type="text" name="alttitude" size="4" id="Att" required></br></br>
</div>
<div>
    <label class="required-field" for="address">Site Address:</label>
    <input type="text" name="address" size="60" id="address" required></br></br>
</div>
<div>
    <label class="required-field" for="arname">Arabic Name:</label>
    <span lang="Ar"><input type="text" name="arabicname" size="60" id="arname"
                            required></span></br></br>
</div>
<div>
    <label class="required-field" for="admin">Adminstrative Area:</label>
    <input type="text" name="adminarea" size="60" id="admin" required></br></br>
</div>
<div>
    <label class="required-field" for="node">TX Node:</label>
    <input type="text" name="txnode" size="3" id="node" required></br></br>
</div>

<div>
    Node Category: <select name="category" required>    
        <option value="Empty">--</option>  
        <option value="Normal">Normal</option>
        <option value="Golden">Golden</option>
        <option value="Silver">Silver</option>
        <option value="Tail">Tail</option>
    </select>
    </br></br>
</div>

<div>
    Technical Priority: <select name="priority" required>    
        <option value="Empty">--</option>  
        <option value="Priority 1">Priority1</option>
        <option value="Priority 2">Priority2</option>
        <option value="Priority 3">Priority3</option>
        <option value="Priority 4">Priority4</option>
    </select>
    </br></br>
</div>

    <div>
    Subcontractor: <select name="sub" required> 
        <option value="Empty">--</option>  
        <option value="Brj">Brj</option>
        <option value="others">Others</option>
    </select>
    </br></br>
</div>
<div>
Invoice Topology: <select name="invoice" required>    
        <option value="Empty">--</option>  
        <option value="Tower / Generator / Solar and or TX Repeater">Tower / Generator / Solar and or TX
                            Repeater</option>
        <option value="PTS Shelter / Indoor shelter and or TX node">PTS Shelter / Indoor shelter and or
                            TX node</option>
        <option value="Others">Others</option>
    </select>
    </br></br>
</div>
<div>
    Site Ranking: <select name="sranking" required>  
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
    RNC: <select name="RNC" required>    
        <option value="">--</option>
        <option value="RNC_ALP2">RNC_ALP2</option>
        <option value="RNC_ALP3">RNC_ALP3</option>
        <option value="RNC_ALP4">RNC_ALP4</option>
        <option value="RNC_Hama">RNC_Hama</option>
        <option value="RNC_Homs2">RNC_Homs2</option>
        <option value="RNC_TRS1">RNC_TRS1</option>
        <option value="RNC_TRS4">RNC_TRS4</option>
        <option value="RNC3_LTK">RNC3_LTK</option>
        <option value="HBSC2_Thawra">HBSC2_Thawra</option>
        <option value="HBSC4_DahietKudsaya">HBSC4_DahietKudsaya</option>
        <option value="HBSC7_Swaida">HBSC7_Swaida</option>
        <option value="HBSC8_Daraa">HBSC8_Daraa</option>
        <option value="HBSC10_YouthCity">HBSC10_YouthCity</option>
        <option value="HBSC11_DahietQudsaya">HBSC11_DahietQudsaya</option>
    </select>
    </br></br>
</div>



<div>
    <label for="air date" required>3G On Air Date:</label>
    <input type="date" name="onairdate" size="15" id="air date"></br></br>
</div>

<div>
    BTS Type: <select name="bts" required> 
        <option value="">--</option>      
        <option value="BTS5900">BTS5900</option> 
        <option value="BTS3900">BTS3900</option>
        <option value="BTS3900A">BTS3900A</option> 
        <option value="BTS3900L">BTS3900L</option>
        <option value="DBS3900">DBS3900</option>
        <option value="DBS5900">DBS5900</option>
        <option value="3206">3206</option>
        <option value="6130">6130</option>
        <option value="6150">6150</option>
        <option value="6601">6601</option>
        <option value="6601/RRUS">6601/RRUS</option>
        <option value="6601W">6601W</option>
        <option value="2216">2216</option>
        <option value="6012">6012</option>
        <option value="6301">6301</option>
        <option value="6301W">6301W</option>
        <option value="3206M">3206M</option>
        <option value="6102">6102</option>
        <option value="6102_V2">6102_V2</option>
        <option value="6102_V1">6102_V1</option>
        <option value="6102/RRUS">6102/RRUS</option>
        <option value="6102/RUS">6102/RUS</option>
        <option value="6102W">6102W</option>
        <option value="6102W/RRUS">6102W/RRUS</option>
        <option value="6102/RUW">6102/RUW</option>
        <option value="6201">6201</option>
        <option value="6201\RUW">6201\RUW</option>
        <option value="6201_V2">6201_V2</option>
        <option value="6201V2W">6201V2W</option>
        <option value="6201W">6201W</option>

    </select>
    </br></br>
</div>
<div>
    <label for="carry" required>Numbers Of Carries:</label>
    <input type="text" name="numcarriers" size="3" id="carry"></br></br>
</div>

<div>
    <label for="rest" required>Restoration Date:</label>
    <input type="date" name="restoration" size="15" id="rest"></br></br>
</div>
<div>
<label for="lac" required>LAC:</label>
    <input type="text" name="lac" size="4" id="lac"></br></br>
</div>
<div>
<label for="note1">Site Notes:</label>
    <input type="text" name="snotes" size="89" id="note1"></br></br>
</div>


<div>
    Select Cells:</br>
    <input type = "checkbox" name="cell[]"  id="checkbox1" value="A">A
    
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
    <input type = "checkbox" name="cell[]" id="checkbox2" value="B">B
  

    <input type ="text" name="azimuthb" size="5" placeholder ="Azimuth"               >
    <input type ="text" name="heightb"  size="5" placeholder ="Height"                >
    <input type ="text" name="mtiltb"   size="5" placeholder ="M_TILT"               >
    <input type ="text" name="etiltb"   size="5" placeholder ="E_TILT"               >
    <input type ="text" name="area1b"   size="15" placeholder ="Arabic Serving Area"  >
    <input type ="text" name="area2b"   size="15" placeholder ="English Serving Area"></br>
    <input type ="text" name="cnoteb" size="90"  placeholder="Cell Note">

</div>
<div>
</br>
    <input type = "checkbox" name="cell[]" id="checkbox3" value="C">C
    <input type ="text" name="azimuthC" size="5" placeholder ="Azimuth"              >
    <input type ="text" name="heightC"  size="5"  placeholder ="Height"              >
    <input type ="text" name="mtiltC" size="5"   placeholder ="M_TILT"               >
    <input type ="text" name="etiltC" size="5"   placeholder  ="E_TILT"              >
    <input type ="text" name="area1C" size="15"  placeholder ="Arabic Serving Area"  >
    <input type ="text" name="area2C" size="15"  placeholder ="English Serving Area" ></br>
    <input type ="text" name="cnoteC" size="90"  placeholder="Cell Note">
</div>
<div>
</br>
    <input type = "checkbox" name="cell[]" id="checkbox4" value="D">D
    <input type ="text" name="azimuthd" size="5" placeholder ="Azimuth"                  >
    <input type ="text" name="heightd" size="5"  placeholder ="Height"                   >
    <input type ="text" name="mtiltd" size="5"   placeholder ="M_TILT"                   >
    <input type ="text" name="etiltd" size="5"   placeholder ="E_TILT"                   >
    <input type ="text" name="area1d" size="15"  placeholder ="Arabic Serving Area"      >
    <input type ="text" name="area2d" size="15"  placeholder ="English Serving Area"     ></br>
    <input type ="text" name="cnoted" size="90"  placeholder="Cell Note">

</div>
<div>
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
    <input type ="text" name="azimuthv"  size="5" placeholder="Azimuth">
    <input type ="text" name="heightv" size="5"  placeholder="Height">
    <input type ="text" name="mtiltv" size="5" placeholder="M_TILT">
    <input type ="text" name="etiltv" size="5" placeholder="E_TILT">
    <input type ="text" name="area1v" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2v" size="15" placeholder="English Serving Area"></br>
    <input type ="text" name="cnotev" size="90"  placeholder="Cell Note">
    </br></br>
    </div>
<div>

    <input type = "checkbox" name="cell[]" value="U">U
    <input type ="text" name="azimuthu" size="5" placeholder="Azimuth">
    <input type ="text" name="heightu" size="5"  placeholder="Height">
    <input type ="text" name="mtiltu" size="5" placeholder="M_TILT">
    <input type ="text" name="etiltu" size="5" placeholder="E_TILT">
    <input type ="text" name="area1u" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2u" size="15" placeholder="English Serving Area"></br>
    <input type ="text" name="cnoteu" size="90"  placeholder="Cell Note">
    </br></br>
    </div>
<div>
    <input type = "checkbox" name="cell[]" value="E">E
    <input type ="text" name="azimuthe" size="5" placeholder="Azimuth">
    <input type ="text" name="heighte" size="5"  placeholder="Height">
    <input type ="text" name="mtilte" size="5" placeholder="M_TILT">
    <input type ="text" name="etilte" size="5" placeholder="E_TILT">
    <input type ="text" name="area1e" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2e" size="15" placeholder="English Serving Area"></br>
    <input type ="text" name="cnotee" size="90"  placeholder="Cell Note">
</br></br>
</div>



    
    </div>

</div>
<div class="footer">
<div>
<label><h3>Select Next Page:</h3></label>
    
    <input type ="radio" id="custom-option1" name="SiteType" value="2G" class="custom">
    <label for="custom-option1" class="custom-label">2G Site Page.</label>
   
    
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
</div>
</body>
</html>
<script>
function confirmAndClose() {
    if (window.confirm('Are you sure you want to add 3G site only without continue?')) {
        document.getElementById('myForm').submit();
        setTimeout(() => {
            window.close();
        }, 30); // Delay to ensure form submission completes
    }
}
</script>