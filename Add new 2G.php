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
    //$area_rank =$_POST['arearanking'];
    //$zone =$_POST['zone'];
    $supplier =$_POST['supplier'] ?? '';
    $cityrural1 =$_POST['C/R'] ?? '';
    //$province =$_POST['province'];
    //$BSC = $_POST['BSC'];
    $prio = $_POST['priority'] ?? '';
    $cat = $_POST['category'] ?? '';
    $subcontractor = $_POST['sub'] ?? '';
    $invoice = $_POST['invoice'] ?? '';
    $site_ranking = $_POST['sranking'] ?? '';
    $site_type = $_POST['SiteType'] ?? '';

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
    $supplier = $_POST['supplier'] ?? '';
    $code1 = substr($sitecode,0,3)?? '';
    $code2 = substr($sitecode,-2)?? '';
    $suppliers = [
        'Ericsson' => ['EVOBSC1', 'EVOBSC2', 'EVOBSC4','EVOBSC5','EVOBSC6','EVOBSC9','HDBSC1','HDBSC2'],
        'Huawei' => ['HBSC1', 'HBSC2', 'HBSC4','HBSC7','HBSC8','HBSC10','HBSC11','HSKBSC2'],
    ];
//echo $code1;
//echo $code2;

if($BSC == "HBSC1"){$LBSC = "HBSC1_Thawra";}
elseif($BSC == "HBSC2"){$LBSC = "HBSC2_Thawra";}
elseif($BSC == "HBSC4"){$LBSC = "HBSC4_DahietKudsaya";}
elseif($BSC == "HBSC7"){$LBSC = "HBSC7_Swaida";}
elseif($BSC == "HBSC8"){$LBSC = "HBSC8_Daraa";}
elseif($BSC == "HBSC10"){$LBSC = "HBSC10_YouthCity";}
elseif($BSC == "HBSC11"){$LBSC = "HBSC11_DahietQudsaya";}
else {$LBSC = $BSC;}

    
    if(substr($scode,0,3) != "DAM" || substr($scode,0,3) != "ALP" || substr($scode,0,3) != "DMR"|| substr($scode,0,3) != "DRA"|| substr($scode,0,3) != "DAM"
    || substr($scode,0,3) != "DRZ"|| substr($scode,0,3) != "HMA"|| substr($scode,0,3) != "HMS"|| substr($scode,0,3) != "HSK"|| substr($scode,0,3) != "IDB"
    || substr($scode,0,3) != "RKA"|| substr($scode,0,3) != "SWD"|| substr($scode,0,3) != "TRS"|| substr($scode,0,3) != "QRA" ){
        echo "<script>alert('Site Code not valid');</script>";
    }
   

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
        $cellid2 = '10'.$code2;
    }
    elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
        $cellid2 = '11'.$code2;
    }
    elseif (is_numeric($code2) && intval($code2) >= 200 && intval($code2) <= 299){
        $cellid2 = '12'.$code2;
    }
    elseif (is_numeric($code2) && intval($code2) >= 300 && intval($code2) <= 399){
        $cellid2 = ("13".$code2);
    }
    elseif (is_numeric($code2) && intval($code2) >= 400 && intval($code2) <= 499){
        $cellid2 = ("14".$code2);
    }
    elseif (is_numeric($code2) && intval($code2) >= 500 && intval($code2) <= 599){
        $cellid2 = ("15".$code2);
    }
    elseif (is_numeric($code2) && intval($code2) >= 600 && intval($code2) <= 699){
        $cellid2 = ("16".$code2);
    }
    elseif (is_numeric($code2) && intval($code2) >= 700 && intval($code2) <= 799){
        $cellid2 = ("17".$code2);
    }
    elseif (is_numeric($code2) && intval($code2) >= 800 && intval($code2) <= 899){
        $cellid2 = ("18".$code2);
    }
    elseif (is_numeric($code2) && intval($code2) >= 900 && intval($code2) <= 999){
        $cellid2 = ("19".$code2);
    }
    }
    
    elseif($code1 == "DMR"){
        if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
            $cellid2 = ("54".$code2);
        }
        elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
            $cellid2 = ("55".$code2);
        }
        elseif (is_numeric($code2) && intval($code2) >= 200 && intval($code2) <= 299){
            $cellid2 = ("56".$code2);
        }
        elseif (is_numeric($code2) && intval($code2) >= 300 && intval($code2) <= 399){
            $cellid2 = ("57".$code2);
        }
        elseif (is_numeric($code2) && intval($code2) >= 400 && intval($code2) <= 499){
            $cellid2 = ("58".$code2);
        }
        elseif (is_numeric($code2) && intval($code2) >= 500 && intval($code2) <= 599){
            $cellid2 = ("59".$code2);
        }
        elseif (is_numeric($code2) && intval($code2) >= 600 && intval($code2) <= 699){
            $cellid2 = ("52".$code2);
        }
        elseif (is_numeric($code2) && intval($code2) >= 800 && intval($code2) <= 899){
            $cellid2 = ("53".$code2);
        }
        }
        elseif($code1 == "DRA"){
            if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                $cellid2 = ("60".$code2);
            }
            elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                $cellid2 = ("61".$code2);
            } 
        }
        elseif($code1 == "SWD"){
            if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                $cellid2 = ("48".$code2);
            }
            elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                $cellid2 = ("49".$code2);
            } 
        }
        elseif($code1 == "QRA"){
            if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                $cellid2 = ("64".$code2);
            }
            elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                $cellid2 = ("65".$code2);
            } 
        }
        if($code1 == "ALP"){
            if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                $cellid2 = ("20".$code2);
            }
            elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                $cellid2 = ("21".$code2);
            }
            elseif (is_numeric($code2) && intval($code2) >= 200 && intval($code2) <= 299){
                $cellid2 = ("22".$code2);
            }
            elseif (is_numeric($code2) && intval($code2) >= 300 && intval($code2) <= 399){
                $cellid2 = ("23".$code2);
            }
            elseif (is_numeric($code2) && intval($code2) >= 400 && intval($code2) <= 499){
                $cellid2 = ("24".$code2);
            }
            elseif (is_numeric($code2) && intval($code2) >= 500 && intval($code2) <= 599){
                $cellid2 = ("25".$code2);
            }
            elseif (is_numeric($code2) && intval($code2) >= 800 && intval($code2) <= 899){
                $cellid2 = ("28".$code2);
            }
            elseif (is_numeric($code2) && intval($code2) >= 900 && intval($code2) <= 999){
                $cellid2 = ("29".$code2);
            }
            }
            elseif($code1 == "IDB"){
                if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                    $cellid2 = ("50".$code2);
                }
                elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                    $cellid2 = ("51".$code2);
                } 
            }
            elseif($code1 == "RKA"){
                if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                    $cellid2 = ("62".$code2);
                }
                elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                    $cellid2 = ("63".$code2);
                } 
            }
            elseif($code1 == "DRZ"){
                if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                    $cellid2 = ("26".$code2);
                }
                elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                    $cellid2 = ("27".$code2);
                } 
            }
            elseif($code1 == "HSK"){
                if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                    $cellid2 = ("38".$code2);
                }
                elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                    $cellid2 = ("39".$code2);
                } 
            }
                elseif($code1 == "HMS"){
                if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                    $cellid2 = ("30".$code2);
                }
                elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                    $cellid2 = ("31".$code2);
                }
                elseif (is_numeric($code2) && intval($code2) >= 200 && intval($code2) <= 299){
                    $cellid2 = ("32".$code2);
                }
                elseif (is_numeric($code2) && intval($code2) >= 300 && intval($code2) <= 399){
                    $cellid2 = ("33".$code2);
                }
            }
            elseif($code1 == "HMA"){
                if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                    $cellid2 = ("34".$code2);
                }
                elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                    $cellid2 = ("35".$code2);
                }
                elseif (is_numeric($code2) && intval($code2) >= 200 && intval($code2) <= 299){
                    $cellid2 = ("36".$code2);
                }
                elseif (is_numeric($code2) && intval($code2) >= 500 && intval($code2) <= 599){
                    $cellid2 = ("37".$code2);
                }
            }
            elseif($code1 == "LTK"){
                if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                    $cellid2 = ("40".$code2);
                }
                elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                    $cellid2 = ("41".$code2);
                }
                elseif (is_numeric($code2) && intval($code2) >= 200 && intval($code2) <= 299){
                    $cellid2 = ("42".$code2);
                }
                elseif (is_numeric($code2) && intval($code2) >= 300 && intval($code2) <= 399){
                    $cellid2 = ("43".$code2);
                }
            }
            elseif($code1 == "TRS"){
                if (is_numeric($code2) && intval($code2) >= 1 && intval($code2) <= 99){
                    $cellid2 = ("44".$code2);
                }
                elseif (is_numeric($code2) && intval($code2) >= 100 && intval($code2) <= 199){
                    $cellid2 = ("45".$code2);
                }
                elseif (is_numeric($code2) && intval($code2) >= 200 && intval($code2) <= 299){
                    $cellid2 = ("46".$code2);
                }
                elseif (is_numeric($code2) && intval($code2) >= 500 && intval($code2) <= 599){
                    $cellid2 = ("47".$code2);
                }
            }
if (empty($site_type)) {
    echo "<script>alert('You should select a site type');</script>";
} else {
    // Process the form submission
    echo "<p>Form submitted successfully with site type: $site_type</p>";
    // Add your database logic here
}


  
      
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
exit;


    try{
        $sqll= "INSERT INTO TWO_G_SITES(SITE_ID, CELL_ID, BAND, SITE_STATUS, BTS_TYPE, BSC, TWOG_ON_AIR_DATE, NINTY_GSM_RBS_TYPE, NINTY_ON_AIR_DATE, EIGHTY_GSM_RBS_TYPE, EIGHTY_ON_AIR_DATE, NOTES, REAL_BSC, LAC) 
        VALUES (:sd, TWO_G_SITES_SEQ.NEXTVAL, :band,:statu, :bts, :bsc, :date2G, :ninty_rbs, :ninty_date, :eighty_rbs, :eighty_date, :snote, :Rbsc,:lac)
        RETURNING CELL_ID INTO :last_id";
        
        $insert_stmt1 =oci_parse($conn,$sqll);
        
        oci_bind_by_name($insert_stmt1, ':sd'      , $sid);
        //oci_bind_by_name($insert_stmt, ':sitecode', $sitecode);
        oci_bind_by_name($insert_stmt1, ':band'    , $band);
        oci_bind_by_name($insert_stmt1, ':bsc'     , $BSC);
        oci_bind_by_name($insert_stmt1, ':statu'   , $status2G);
        oci_bind_by_name($insert_stmt1, ':date2G'  , $date2G);
        oci_bind_by_name($insert_stmt1, ':bts'     , $BTS);
        oci_bind_by_name($insert_stmt1, ':ninty_rbs', $RBS1);
        oci_bind_by_name($insert_stmt1, ':ninty_date', $date1);
        oci_bind_by_name($insert_stmt1, ':eighty_rbs', $RBS2);
        oci_bind_by_name($insert_stmt1, ':eighty_date', $date2);
        oci_bind_by_name($insert_stmt1, ':snote'   , $snote);
        oci_bind_by_name($insert_stmt1, ':Rbsc', $LBSC);
        oci_bind_by_name($insert_stmt1, ':lac'       , $lac);
        oci_bind_by_name($insert_stmt1, ':last_id'   , $Cell_ID, -1, SQLT_INT);
        
        
        
        if (!oci_execute($insert_stmt1)) {
            throw new Exception(oci_error($insert_stmt1)['message']);
        }
        
        //$Cell_ID = oci_parse($conn, "SELECT 2GSITES_SEQ.CURRVAL FROM TWOGSITES");
            oci_free_statement($insert_stmt1);
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
       
                    // Database connection details
                    $username = "C##Hadeel";
                    $password = "MTN";
                    $connection_string = "//localhost/XE"; // Change XE if your SID is different
                    try{
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
                    oci_bind_by_name($stid, ':cell_on_air_date', $date1);
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
                header("location:3G.php?id2=$sid");
            }
            else if($site_type == '4G'){
                header("location:4G.php?id3=$sid");
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
<script>
function confirmcancel(){
        return confirm ("Are you sure you want to cancel without adding site?" );
     
    }
    
    
        function confirmSubmission() {
            // Check if any radio button is selected
            const radios = document.querySelectorAll('input[name="SiteType"]');
            let isChecked = false;
            radios.forEach(radio => {
                if (radio.checked) {
                    isChecked = true;
                }
            });

            if (!isChecked) {
                alert('You should select a site type');
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }
    
    

    </script>
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
  background-color: #3299a8;
  color: #ffffff;
  border-color: #007BFF;
  border:2px solid white;
}

</style>




</head>
<body>
<div class="container">
<div class="header">
            <h1></br> New 2G Site Informations </h1>
             Please fill 2G site informations and then select next page to add another technology.</br>
</br>
        </div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit= "return confirmSubmission();">
<div class="form1">
<div>
    <label for="code">Site Code</label>
    <input type ="text" name="sitecode" size="7" id="code" required></br></br>

</div>

<div>
    <label for="name">Site Name</label>
    <input type ="text" name="sitename" size="33" id="name" required></br></br>
</div>


<div>
    <input type ="radio" id= "city" name="C/R" value="City">City
    <input type ="radio" id= "rural" name="C/R" value="Rural">Rural</br></br>
</div>
<div>

    <input type ="radio" id= "erc" name="supplier" value="Ericsson">Ericsson
    <input type ="radio" id= "hu" name="supplier" value="Huawei">Huawei</br></br>
</div>
<div>
    <label for="power">Power Backup:</label>
    <input type ="text" name="powerbackup" size="50" id="power"></br></br>
</div>
<div>
    <label for="air date">On Air Date:</label>
    <input type ="date" name="onairdate" size="15" id="air date"></br></br>
</div>
<div>
    <label for="coorE">Coordinates E:</label>
    <input type ="text" name="coordinatesE" size="10" id="coorE"></br></br>
</div>
<div>
    <label for="coorN">Coordinates N:</label>
    <input type ="text" name="coordinatesN" size="10" id="coorN"></br></br>
</div>
<div>
    <label for="Att">Alttitude:</label>
    <input type ="text" name="alttitude" size="4" id="Att"></br></br>
</div>
<div>
    <label for="address">Site Address:</label>
    <input type ="text" name="address" size="60" id="address"></br></br>
</div>
<div>
    <label for="arname">Arabic Name:</label>
    <span lang="Ar"><input type ="text" name="arabicname" size="60" id="arname"></span></br></br>
</div>
<div>
    <label for="admin">Adminstrative Area:</label>
    <input type ="text" name="adminarea" size="60" id="admin"></br></br>
</div>
<div>
    <label for="node">TX Node:</label>
    <input type ="text" name="txnode" size="3" id="node"></br></br>
</div>

<div>
    Node Category:   <select name="category">    
        <option value="Empty">--</option>  
        <option value="Normal">Normal</option>
        <option value="Golden">Golden</option>
        <option value="Silver">Silver</option>
        <option value="Tail">Tail</option>
    </select>
    </br></br>
</div>

<div>
    Technical Priority:   <select name="priority">    
        <option value="Empty">--</option>  
        <option value="Priority1">Priority1</option>
        <option value="Priority2">Priority2</option>
        <option value="Priority3">Priority3</option>
        <option value="Priority4">Priority4</option>
    </select>
    </br></br>
</div>

    <div>
    Subcontractor:   <select name="sub"> 
        <option value="Empty">--</option>  
        <option value="Brj">Brj</option>
        <option value="others">Others</option>
    </select>
    </br></br>
</div>
<div>
Invoice Topology:   <select name="invoice">    
        <option value="Empty">--</option>  
        <option value="Tower / Generator / Solar and or TX Repeater">Tower / Generator / Solar and or TX Repeater</option>
        <option value="PTS Shelter / Indoor shelter and or TX node">PTS Shelter / Indoor shelter and or TX node</option>
        <option value="Others">Others</option>
    </select>
    </br></br>
</div>
<div>
    Site Ranking:   <select name="sranking">  
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
Select Band Width: </br>
            


            <input type ="radio" id= "option1"  name="band" value="900">900
            <input type ="radio" id= "option2" name="band" value="1800">1800
            <input type ="radio" id= "option3"  name="band" value="900/1800">900/1800</br></br>




        


    <div>
    BTS Type:  <select name="BTS">
        
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
    <label for="air date">2G On Air Date:</label>
    <input type ="date" name="onairdate" size="15" id="air date"></br></br>
</div>
<div id="content-container">
<div id="div1" class="content-div">
    900 GSM RBS Type:   
    <select name="900Rbs"> 
        <option value="">--</option>       
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


    BSC:   <select name="BSC">    
  
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
    <label for="lac">LAC:</label>
    <input type ="text" name="lac" size="4" id="lac"></br></br>
</div>
<div>
    <label for="note1">Site Notes:</label>
    <input type ="text" name="snotes" size="89" id="note1"></br></br>
</div>


<div id="container2">
  
    <div id="div4" class="content-cont">
<div>
    Select Cells:</br>
    <input type = "checkbox" name="cell[]"  value="A">A
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
    <input type = "checkbox" name="cell[]"  value="B">B
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
    <input type = "checkbox" name="cell[]"  value="C">C
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
    <input type = "checkbox" name="cell[]"  value="D">D
    <input type ="text" name="azimuthd" size="5" placeholder="AzimuthD">
    <input type ="text" name="heightd" size="5"  placeholder="Height D">
    <input type ="text" name="mtiltd" size="5" placeholder="M_TILT">
    <input type ="text" name="etiltd" size="5" placeholder="E_TILT">
    <input type ="text" name="area1d" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2d" size="15" placeholder="English Serving Area"></br>
    <input type ="text" name="cnoted" size="90" placeholder="Cell Note">

</div>
            </div>

<div>
<div id="div5" class="content-cont">
    </br>
    <input type = "checkbox" name="cell[]" value="X">X
    
    <input type ="text" name="azimuthx" size="5" placeholder="AzimuthX">
    <input type ="text" name="heightx" size="5"  placeholder="Height X">
    <input type ="text" name="mtiltx" size="5" placeholder="M_TILT">
    <input type ="text" name="etiltx" size="5" placeholder="E_TILT">
    <input type ="text" name="area1x" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2x" size="15" placeholder="English Serving Area"></br>
    <input type ="text" name="cnotex" size="90" placeholder="Cell Note">
            </br>
 
    
    <input type = "checkbox" name="cell[]" value="Y">Y
    <input type ="text" name="azimuthy" size="5" placeholder="AzimuthY">
    <input type ="text" name="heighty" size="5"  placeholder="Height Y">
    <input type ="text" name="mtilty" size="5" placeholder="M_TILT">
    <input type ="text" name="etilty" size="5" placeholder="E_TILT">
    <input type ="text" name="area1y" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2y" size="15" placeholder="English Serving Area"></br>
    <input type ="text" name="cnotey" size="90" placeholder="Cell Note">
    </br>
    <input type = "checkbox" name="cell[]" value="Z">Z
    <input type ="text" name="azimuthz" size="5" placeholder="AzimuthZ">
    <input type ="text" name="heightz" size="5"  placeholder="HeightZ">
    <input type ="text" name="mtiltz" size="5" placeholder="M_TILT">
    <input type ="text" name="etiltz" size="5" placeholder="E_TILT">
    <input type ="text" name="area1z" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2z" size="15" placeholder="English Serving Area"></br>
    <input type ="text" name="cnotez" size="90" placeholder="Cell Note">
    </br>
<input type = "checkbox" name="cell[]" value="W">W

    <input type ="text" name="azimuthw" size="5" placeholder="AzimuthW">
    <input type ="text" name="heightw" size="5"  placeholder="HeightW">
    <input type ="text" name="mtiltw" size="5" placeholder="M_TILT">
    <input type ="text" name="etiltw" size="5" placeholder="E_TILT">
    <input type ="text" name="area1w" size="15" placeholder="Arabic Serving Area">
    <input type ="text" name="area2w" size="15" placeholder="English Serving Area"></br>
    <input type ="text" name="cnotew" size="90" placeholder="Cell Note">
    </div>
    </br>

    </div>
    <div id="div6" class="content-cont">
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
</div>
    </div>
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
<div>
<label><h3>Select Next Page:</h3></label>
       
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
</div>
</body>
</html>
<script>
function confirmAndClose() {
    if (window.confirm('Are you sure you want to add 2G site only without continue?')) {
        document.getElementById('myForm').submit();
        setTimeout(() => {
            window.close();
        }, 30); // Delay to ensure form submission completes
    }
}
</script>
