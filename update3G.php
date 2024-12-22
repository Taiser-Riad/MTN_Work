<?php 
include "config.php";
?>
<?php 
if(isset($_GET['id3']))
{
$id =$_GET['id3'];
$sql  = "SELECT s.*, t.* , c.*     FROM NEW_SITES s       INNER JOIN THREE_G_SITES t ON(s.ID = t.SITE_ID) JOIN THREE_G_CELLS c ON (t.CELL_ID = c.CID) WHERE s.ID = :id";
$sqll = "SELECT t.* , c.*          FROM THREE_G_SITES t   INNER JOIN THREE_G_CELLS c ON (t.CELL_ID = c.CID) WHERE t.CELL_ID = :id";


$result  = oci_parse($conn,$sql);
oci_bind_by_name($result , ':id' ,$id);
oci_execute($result);

$resultt = oci_parse($conn,$sqll);
oci_bind_by_name($resultt , ':id' ,$id);
oci_execute($resultt);


$row     = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS);
//$row1    = mysqli_fetch_assoc($resultt);

if ($resultt){
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
    
 
 

}







}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $sid        = $_POST ['id'];
    $sitecode   = $_POST['sitecode'];
   // $sitename   = $_POST['sitename'];
    $wbts       = $_POST['wbts'];
    $RNC        = $_POST['RNC'];
    $status     = $_POST['sitestatus'];
    $date3G     = $_POST['onairdate'];
    $BTS        = $_POST['bts'];
    $carriers   = $_POST['numcarriers'];
    $lac        = $_POST['lac'];
    $restordate = $_POST['restoration'];
    $snote      = $_POST['snotes'];
    $reno       = $_POST['renovation'];
    $RRNC       = $_POST['RRNS'];
    $cellid2    = $wbts;
    
   
;
    $multisectorid = "2765";
    

   //$query1 ="UPDATE `3gsites` SET `Site_Code`='$sitecode',`WBTS_Type`='$wbts',`RNC`='$RNC',`Site_Status`='$status',`3GON_AIR_DATE`='$date3G',`Renovation_Date`='$reno',`BTS_Type`='$BTS',`Number_Of_Carriers`='$carriers',`Notes`='$snote',`Real_RNC`='$RRNC',`Restoration_Date`='$restordate',`LAC`='$lac' WHERE Site_ID = '$sid'";
   //$updateresult = mysqli_query($conn,$query1);


   $query1 = "UPDATE THREE_G_SITES 
   SET SITE_CODE = :sitecode,
       WBTS_TYPE = :wbts,
       RNC = :RNC,
       SITE_STATUS = :status,
       THREE_G_ON_AIR_DATE = :date3G,
       Renovation_Date = :reno,
       BTS_TYPE = :BTS,
       NUMBER_OF_CARRIERS = :carriers,
       NOTES = :snote,
       REAL_RNC = :RRNC,
       RESTORATION_Date = :restordate,
       LAC = :lac 
   WHERE SITE_ID = :sid";

$updateresult = oci_parse($conn, $query1);

oci_bind_by_name($updateresult, ':sitecode', $sitecode);
oci_bind_by_name($updateresult, ':wbts', $wbts);
oci_bind_by_name($updateresult, ':RNC', $RNC);
oci_bind_by_name($updateresult, ':status', $status);
oci_bind_by_name($updateresult, ':date3G', $date3G);
oci_bind_by_name($updateresult, ':reno', $reno);
oci_bind_by_name($updateresult, ':BTS', $BTS);
oci_bind_by_name($updateresult, ':carriers', $carriers);
oci_bind_by_name($updateresult, ':snote', $snote);
oci_bind_by_name($updateresult, ':RRNC', $RRNC);
oci_bind_by_name($updateresult, ':restordate', $restordate);
oci_bind_by_name($updateresult, ':lac', $lac);
oci_bind_by_name($updateresult, ':sid', $sid);

if (oci_execute($updateresult)) {
echo "Data Updated Successfully";
} else {
$e = oci_error($updateresult);
echo "Error Updating Data: " . htmlentities($e['message']);
}



   if(!empty($_POST['cell'])){
    foreach($_POST['cell'] as $selected){
        if($selected == 'A'){

            $cellid2    = $_POST['cellida']  ;
            $cellcode   = $_POST['cellcodea'];
            $azimuth    = $_POST['azimutha'] ;
            $height     = $_POST['heighta']  ;
            $mtilt      = $_POST['mtilta']   ;
            $etilt      = $_POST['etilta']   ;
            $aarea      = $_POST['area1a']   ;
            $earea      = $_POST['area2a']   ;
            $cnote      = $_POST['cnotesa']  ;
            $cname      = $_POST['cellnamea'];
            $celldate   = $_POST['celldatea'] ;
      
     
    
            if(!empty( $_POST['etilta'] && !empty($_POST['mtilta']))){
                $ttilt = sprintf('%d',$_POST['mtilta'] + $_POST['etilta']);
            }
            else{ $ttilt ="-";}


        }

        elseif($selected == 'B'){

            $cellid2    = $_POST['cellidb']  ;
            $cellcode   = $_POST['cellcodeb'];
            $azimuth    = $_POST['azimuthb'] ;
            $height     = $_POST['heightb']  ;
            $mtilt      = $_POST['mtiltb']   ;
            $etilt      = $_POST['etiltb']   ;
            $aarea      = $_POST['area1b']   ;
            $earea      = $_POST['area2b']   ;
            $cnote      = $_POST['cnotesb']  ;
            $cname      = $_POST['cellnameb'];
            $celldate   = $_POST['celldateb'] ;
      
     
    
            if(!empty( $_POST['etiltb'] && !empty($_POST['mtiltb']))){
                $ttilt = sprintf('%d',$_POST['mtiltb'] + $_POST['etiltb']);
            }
            else{ $ttilt ="-";}
    


        }



        elseif($selected == 'C'){

            $cellid2    = $_POST['cellidc']  ;
            $cellcode   = $_POST['cellcodec'];
            $azimuth    = $_POST['azimuthc'] ;
            $height     = $_POST['heightc']  ;
            $mtilt      = $_POST['mtiltc']   ;
            $etilt      = $_POST['etiltc']   ;
            $aarea      = $_POST['area1c']   ;
            $earea      = $_POST['area2c']   ;
            $cnote      = $_POST['cnotesc']  ;
            $cname      = $_POST['cellnamec'];
            $celldate   = $_POST['celldatec'] ;
      
     
    
            if(!empty( $_POST['etiltc'] && !empty($_POST['mtiltc']))){
                $ttilt = sprintf('%d',$_POST['mtiltc'] + $_POST['etiltc']);
            }
            else{ $ttilt ="-";}
        }


        elseif($selected == 'D'){


            $cellid2    = $_POST['cellidd']  ;
            $cellcode   = $_POST['cellcoded'];
            $azimuth    = $_POST['azimuthd'] ;
            $height     = $_POST['heightd']  ;
            $mtilt      = $_POST['mtiltd']   ;
            $etilt      = $_POST['etiltd']   ;
            $aarea      = $_POST['area1d']   ;
            $earea      = $_POST['area2d']   ;
            $cnote      = $_POST['cnotesd']  ;
            $cname      = $_POST['cellnamed'];
            $celldate   = $_POST['celldated'] ;
      
     
    
            if(!empty( $_POST['etiltd'] && !empty($_POST['mtiltd']))){
                $ttilt = sprintf('%d',$_POST['mtiltd'] + $_POST['etiltd']);
            }
            else{ $ttilt ="-";}
        }

        elseif($selected == 'X'){
            $cellid2    = $_POST['cellidx']  ;
            $cellcode   = $_POST['cellcodex'];
            $azimuth    = $_POST['azimuthx'] ;
            $height     = $_POST['heightx']  ;
            $mtilt      = $_POST['mtiltx']   ;
            $etilt      = $_POST['etiltx']   ;
            $aarea      = $_POST['area1x']   ;
            $earea      = $_POST['area2x']   ;
            $cnote      = $_POST['cnotesx']  ;
            $cname      = $_POST['cellnamex'];
            $celldate   = $_POST['celldatex'] ;
      
     
    
            if(!empty( $_POST['etiltx'] && !empty($_POST['mtiltx']))){
                $ttilt = sprintf('%d',$_POST['mtiltx'] + $_POST['etiltx']);
            }
            else{ $ttilt ="-";}
        }


        elseif($selected == 'Y'){


            $cellid2    = $_POST['cellidy']  ;
            $cellcode   = $_POST['cellcodey'];
            $azimuth    = $_POST['azimuthy'] ;
            $height     = $_POST['heighty']  ;
            $mtilt      = $_POST['mtilty']   ;
            $etilt      = $_POST['etilty']   ;
            $aarea      = $_POST['area1y']   ;
            $earea      = $_POST['area2y']   ;
            $cnote      = $_POST['cnotesy']  ;
            $cname      = $_POST['cellnamey'];
            $celldate   = $_POST['celldatey'] ;
      
     
    
            if(!empty( $_POST['etilty'] && !empty($_POST['mtilty']))){
                $ttilt = sprintf('%d',$_POST['mtilty'] + $_POST['etilty']);
            }
            else{ $ttilt ="-";}
        }
        
        elseif($selected == 'Z'){

            $cellid2    = $_POST['cellidz']  ;
            $cellcode   = $_POST['cellcodez'];
            $azimuth    = $_POST['azimuthz'] ;
            $height     = $_POST['heightz']  ;
            $mtilt      = $_POST['mtiltz']   ;
            $etilt      = $_POST['etiltz']   ;
            $aarea      = $_POST['area1z']   ;
            $earea      = $_POST['area2z']   ;
            $cnote      = $_POST['cnotesz']  ;
            $cname      = $_POST['cellnamez'];
            $celldate   = $_POST['celldatez'] ;
      
     
    
            if(!empty( $_POST['etiltz'] && !empty($_POST['mtiltz']))){
                $ttilt = sprintf('%d',$_POST['mtiltz'] + $_POST['etiltz']);
            }
            else{ $ttilt ="-";}
        }


        elseif($selected == 'W'){

            $cellid2    = $_POST['cellidw']  ;
            $cellcode   = $_POST['cellcodew'];
            $azimuth    = $_POST['azimuthw'] ;
            $height     = $_POST['heightw']  ;
            $mtilt      = $_POST['mtiltw']   ;
            $etilt      = $_POST['etiltw']   ;
            $aarea      = $_POST['area1w']   ;
            $earea      = $_POST['area2w']   ;
            $cnote      = $_POST['cnotesw']  ;
            $cname      = $_POST['cellnamew'];
            $celldate   = $_POST['celldatew'] ;
      
     
    
            if(!empty( $_POST['etiltw'] && !empty($_POST['mtiltw']))){
                $ttilt = sprintf('%d',$_POST['mtiltw'] + $_POST['etiltw']);
            }
            else{ $ttilt ="-";}
        }

        elseif($selected == 'E'){

            $cellid2    = $_POST['cellide']  ;
            $cellcode   = $_POST['cellcodee'];
            $azimuth    = $_POST['azimuthe'] ;
            $height     = $_POST['heighte']  ;
            $mtilt      = $_POST['mtilte']   ;
            $etilt      = $_POST['etilte']   ;
            $aarea      = $_POST['area1e']   ;
            $earea      = $_POST['area2e']   ;
            $cnote      = $_POST['cnotese']  ;
            $cname      = $_POST['cellnamee'];
            $celldate   = $_POST['celldatee'] ;
      
     
    
            if(!empty( $_POST['etilte'] && !empty($_POST['mtilte']))){
                $ttilt = sprintf('%d',$_POST['mtilte'] + $_POST['etilte']);
            }
            else{ $ttilt ="-";}
        }


        elseif($selected == 'V'){

            $cellid2    = $_POST['cellidv']  ;
            $cellcode   = $_POST['cellcodev'];
            $azimuth    = $_POST['azimuthv'] ;
            $height     = $_POST['heightv']  ;
            $mtilt      = $_POST['mtiltv']   ;
            $etilt      = $_POST['etiltv']   ;
            $aarea      = $_POST['area1v']   ;
            $earea      = $_POST['area2v']   ;
            $cnote      = $_POST['cnotesv']  ;
            $cname      = $_POST['cellnamev'];
            $celldate   = $_POST['celldatev'] ;
      
     
    
            if(!empty( $_POST['etiltv'] && !empty($_POST['mtiltv']))){
                $ttilt = sprintf('%d',$_POST['mtiltv'] + $_POST['etiltv']);
            }
            else{ $ttilt ="-";}
        }
    

        $query2 = "UPDATE THREE_G_CELLS
        SET MSCELL_ID = :multisectorid,
            CELL_ID = :cellid2,
            CELL_CODE = :cellcode,
            CELL_NAME = :cname,
            ON_AIR_DATE = :celldate,
            AZIMUTH = :azimuth,
            M_TILT = :mtilt,
            E_TILT = :etilt,
            TOTAL_TILT = :ttilt,
            SERVING_AREA = :aarea,
            SERVING_AREA_IN_ENGLISH = :earea,
            NOTE = :cnote,
            HIEGHT = :height 
        WHERE CELL_CODE = :cellcode AND CID = :sid ";

$result2 = oci_parse($conn, $query2);

oci_bind_by_name($result2, ':multisectorid', $multisectorid);
oci_bind_by_name($result2, ':cellid2', $cellid2);
oci_bind_by_name($result2, ':cellcode', $cellcode);
oci_bind_by_name($result2, ':cname', $cname);
oci_bind_by_name($result2, ':celldate', $celldate);
oci_bind_by_name($result2, ':azimuth', $azimuth);
oci_bind_by_name($result2, ':mtilt', $mtilt);
oci_bind_by_name($result2, ':etilt', $etilt);
oci_bind_by_name($result2, ':ttilt', $ttilt);
oci_bind_by_name($result2, ':aarea', $aarea);
oci_bind_by_name($result2, ':earea', $earea);
oci_bind_by_name($result2, ':cnote', $cnote);
oci_bind_by_name($result2, ':height', $height);
oci_bind_by_name($result2, ':sid', $sid);

if (oci_execute($result2)) {
 //echo "Data Updated Successfully";
 header("Location:Update_thankyou.html");
} else {
 $e = oci_error($result2);
 echo "Error Updating Data: " . htmlentities($e['message']);
}



    }


 }



}
?>



<!DOCTYPE html>
<html lang="en">
<html>

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web\css\all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> 3G Site page </title>
    <script>
    function confirmupdate() {
        const confirmed = confirm("Are you sure you want to update?");
        return confirmed;
    }
    </script>
    <style>
    .footer {
        background: #1c355c;
        font-size: 17px;
        margin-top: 10px;
        color: white;
        width: 99%;
        padding-left: 10px;
        padding-bottom: 10px;
        padding-top: 30px;



    }




    .submit {
        width: 20%;

        float: right;
        display: flex;


    }

    .submit1 {
        width: 20%;

        float: left;
        display: flex;


    }

    .submit input {

        width: 70%;
        Height: 35px;
        font-size: 17px;
        font-weight: bold;
        margin: 10px;
        border-radius: 10px;
        text-align: center;
        border: none;
        color: #1c355c;

    }

    .submit2 {

        width: 70%;
        Height: 35px;
        font-size: 17px;
        font-weight: bold;
        margin: 10px;
        border-radius: 10px;
        text-align: center;
        border: none;
        color: #1c355c;

    }

    body {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: goldenrod;


    }

    .container {
        /*position: relative;*/

        width: 65%;
        background: whitesmoke;
        padding-top: 0;
        margin-top: 0px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);

        border: 2px solid gray;
        color: #1c355c;
        border-radius: 5px;

    }

    h1 {
        text-align: center;
        width: 100%;
        height: 100px;
        margin-top: 0;
        color: white;
        margin-bottom: 0px;


    }


    .header {

        width: 100%;
        background: #1c355c;
        color: white;
        text-align: center;


    }

    .form1 {
        margin-top: 15px;
        width: 95%;
        padding-left: 40px;

    }

    input {
        background-color: #e1e6ed;
        border: 0.5px solid #e1e6ed;
    }

    select {
        background-color: #e1e6ed;
        border: 0.5px solid #e1e6ed;
    }

    input[type=text]:focus {
        border: 0.8px solid #e1e6ed;
    }

    input[type=select]:focus {
        border: 0.8px solid #e1e6ed;

    }

    .field {
        background-color: #e1e6ed;

    }
    </style>





</head>

<body>
    <div class="container">
        <div class="header">
            <h1></br> 3G Site Informations </h1>
            <?php echo $row['SITE_CODE']; ?> Informations.</br>
            </br>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
            onsubmit="return confirmupdate();">
            <div class="form1">
                <div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    Site Code:<input type="text" name="sitecode" value="<?php echo $row['SITE_CODE']; ?>"></br></br>
                    Site Name:<input type="text" name="sitename" disabled
                        value="<?php echo $row['SITE_NAME']; ?>"></br></br>
                </div>
                <div>
                    <label for="wbts">WBTS ID:</label>
                    <input type="text" name="wbts" size="5" id="wbts"
                        value="<?php echo $row['WBTS_TYPE']; ?>"></br></br>
                </div>

                <div>
                    RNC: <select name="RNC">
                        <option value="">--</option>
                        <option value="RNC_ALP2" <?php if($row['RNC'] == "RNC_ALP2")             echo 'Selected' ;?>>
                            RNC_ALP2</option>
                        <option value="RNC_ALP3" <?php if($row['RNC'] == "RNC_ALP3")             echo 'Selected' ;?>>
                            RNC_ALP3</option>
                        <option value="RNC_ALP4" <?php if($row['RNC'] == "RNC_ALP4")             echo 'Selected' ;?>>
                            RNC_ALP4</option>
                        <option value="RNC_Hama" <?php if($row['RNC'] == "RNC_Hama")             echo 'Selected' ;?>>
                            RNC_Hama</option>
                        <option value="RNC_Homs2" <?php if($row['RNC'] == "RNC_Homs2")            echo 'Selected' ;?>>
                            RNC_Homs2</option>
                        <option value="RNC_TRS1" <?php if($row['RNC'] == "RNC_TRS1")             echo 'Selected' ;?>>
                            RNC_TRS1</option>
                        <option value="RNC_TRS4" <?php if($row['RNC'] == "RNC_TRS4")             echo 'Selected' ;?>>
                            RNC_TRS4</option>
                        <option value="RNC3_LTK" <?php if($row['RNC'] == "RNC3_LTK")             echo 'Selected' ;?>>
                            RNC3_LTK</option>
                        <option value="HBSC2_Thawra"
                            <?php if($row['RNC'] == "HBSC2_Thawra")         echo 'Selected' ;?>>HBSC2_Thawra</option>
                        <option value="HBSC4_DahietKudsaya"
                            <?php if($row['RNC'] == "HBSC4_DahietKudsaya")  echo 'Selected' ;?>>HBSC4_DahietKudsaya
                        </option>
                        <option value="HBSC7_Swaida"
                            <?php if($row['RNC'] == "HBSC7_Swaida")         echo 'Selected' ;?>>HBSC7_Swaida</option>
                        <option value="HBSC8_Daraa" <?php if($row['RNC'] == "HBSC8_Daraa")          echo 'Selected' ;?>>
                            HBSC8_Daraa</option>
                        <option value="HBSC10_YouthCity"
                            <?php if($row['RNC'] == "HBSC10_YouthCity")     echo 'Selected' ;?>>HBSC10_YouthCity
                        </option>
                        <option value="HBSC11_DahietQudsaya"
                            <?php if($row['RNC'] == "HBSC11_DahietQudsaya") echo 'Selected' ;?>>HBSC11_DahietQudsaya
                        </option>
                    </select>
                    </br></br>
                </div>

                <div>
                    Site Status: <select name="sitestatus">

                        <option value="Empty">--</option>
                        <option value="On Air"
                            <?php if($row['SITE_STATUS'] == "On Air")             echo 'Selected' ;?>>On Air </option>
                        <option value="On Air (Stopped)"
                            <?php if($row['SITE_STATUS'] == "On Air (Stopped)")   echo 'Selected' ;?>>On Air (Stopped)
                        </option>
                        <option value="On Air (Stopped_2)"
                            <?php if($row['SITE_STATUS'] == "On Air (Stopped_2)") echo 'Selected' ;?>>On Air (Stopped_2)
                        </option>
                    </select>
                    </br></br>
                </div>


                <div>
                    <label for="air date">3G On Air Date:</label>
                    <input type="text" name="onairdate" size="15" id="air date"
                        value="<?php echo $row['THREE_G_ON_AIR_DATE']; ?>"></br></br>
                </div>

                <div>
                    BTS Type: <select name="bts">
                        <option value="">--</option>
                        <option value="BTS3900" <?php if($row['BTS_TYPE'] == "BTS3900")    echo 'Selected' ;?>>BTS3900
                        </option>
                        <option value="BTS3900A" <?php if($row['BTS_TYPE'] == "BTS3900A")   echo 'Selected' ;?>>BTS3900A
                        </option>
                        <option value="BTS3900L" <?php if($row['BTS_TYPE'] == "BTS3900L")   echo 'Selected' ;?>>BTS3900L
                        </option>
                        <option value="DBS3900" <?php if($row['BTS_TYPE'] == "DBS3900")    echo 'Selected' ;?>>DBS3900
                        </option>
                        <option value="DBS5900" <?php if($row['BTS_TYPE'] == "DBS5900")    echo 'Selected' ;?>>DBS5900
                        </option>
                        <option value="3206" <?php if($row['BTS_TYPE'] == "3206")       echo 'Selected' ;?>>3206
                        </option>
                        <option value="6130" <?php if($row['BTS_TYPE'] == "6130")       echo 'Selected' ;?>>6130
                        </option>
                        <option value="6150" <?php if($row['BTS_TYPE'] == "6150")       echo 'Selected' ;?>>6150
                        </option>
                        <option value="6601" <?php if($row['BTS_TYPE'] == "6601")       echo 'Selected' ;?>>6601
                        </option>
                        <option value="6601/RRUS" <?php if($row['BTS_TYPE'] == "6601/RRUS")  echo 'Selected' ;?>>
                            6601/RRUS</option>
                        <option value="6601W" <?php if($row['BTS_TYPE'] == "6601W")      echo 'Selected' ;?>>6601W
                        </option>
                        <option value="2216" <?php if($row['BTS_TYPE'] == "2216")       echo 'Selected' ;?>>2216
                        </option>
                        <option value="6012" <?php if($row['BTS_TYPE'] == "6012")       echo 'Selected' ;?>>6012
                        </option>
                        <option value="6301" <?php if($row['BTS_TYPE'] == "6301")       echo 'Selected' ;?>>6301
                        </option>
                        <option value="6301W" <?php if($row['BTS_TYPE'] == "6301W")      echo 'Selected' ;?>>6301W
                        </option>
                        <option value="3206M" <?php if($row['BTS_TYPE'] == "3206M")      echo 'Selected' ;?>>3206M
                        </option>
                        <option value="6102" <?php if($row['BTS_TYPE'] == "6102")       echo 'Selected' ;?>>6102
                        </option>
                        <option value="6102_V2" <?php if($row['BTS_TYPE'] == "6102_V2")    echo 'Selected' ;?>>6102_V2
                        </option>
                        <option value="6102_V1" <?php if($row['BTS_TYPE'] == "6102_V1")    echo 'Selected' ;?>>6102_V1
                        </option>
                        <option value="6102/RRUS" <?php if($row['BTS_TYPE'] == "6102/RRUS")  echo 'Selected' ;?>>
                            6102/RRUS</option>
                        <option value="6102/RUS" <?php if($row['BTS_TYPE'] == "6102/RUS")   echo 'Selected' ;?>>6102/RUS
                        </option>
                        <option value="6102W" <?php if($row['BTS_TYPE'] == "6102W")      echo 'Selected' ;?>>6102W
                        </option>
                        <option value="6102W/RRUS" <?php if($row['BTS_TYPE'] == "6102W/RRUS") echo 'Selected' ;?>>
                            6102W/RRUS</option>
                        <option value="6102/RUW" <?php if($row['BTS_TYPE'] == "6102/RUW")   echo 'Selected' ;?>>6102/RUW
                        </option>
                        <option value="6201" <?php if($row['BTS_TYPE'] == "6201")       echo 'Selected' ;?>>6201
                        </option>
                        <option value="6201\RUW" <?php if($row['BTS_TYPE'] == "6201\RUW")   echo 'Selected' ;?>>6201\RUW
                        </option>
                        <option value="6201_V2" <?php if($row['BTS_TYPE'] == "6201_V2")    echo 'Selected' ;?>>6201_V2
                        </option>
                        <option value="6201V2W" <?php if($row['BTS_TYPE'] == "6201V2W")    echo 'Selected' ;?>>6201V2W
                        </option>
                        <option value="6201W" <?php if($row['BTS_TYPE'] == "6201W")      echo 'Selected' ;?>>6201W
                        </option>





                    </select>
                    </br></br>
                </div>
                <div>
                    <label for="carry">Numbers Of Carries:</label>
                    <input type="text" name="numcarriers" size="3" id="carry"
                        value="<?php echo $row['NUMBER_OF_CARRIERS']; ?>"></br></br>
                </div>

                <div>
                    <label for="reno">Renovation Date:</label>
                    <input type="text" name="renovation" size="15" id="reno"
                        value="<?php echo $row['RENOVATION_DATE']; ?>"></br></br>
                </div>

                <div>
                    <label for="rest">Restoration Date:</label>
                    <input type="text" name="restoration" size="15" id="rest"
                        value="<?php echo $row['RESTORATION_DATE']; ?>"></br></br>
                </div>

                <div>
                    <label for="RealRnc">Real RNC:</label>
                    <input type="text" name="RRNS" size="15" id="RealRnc"
                        value="<?php echo $row['REAL_RNC']; ?>"></br></br>
                </div>


                <div>
                    <label for="lac">LAC:</label>
                    <input type="text" name="lac" size="4" id="lac" value="<?php echo $row['LAC']; ?>"></br></br>
                </div>

                <div>

                    <label for="note1">Site Notes:</label>
                    <input type="text" name="snotes" size="89" id="note1"
                        value="<?php echo $row['NOTES']; ?>"></br></br>
                </div>

                <div>
                    Select Cells:</br>
                    <?php 

  
while ($row1 = oci_fetch_array($resultt , OCI_ASSOC + OCI_RETURN_NULLS)){
      
    //Get The Letter of Cell Code
    $cellcode_char  =substr($row1['CELL_CODE'],-1);
    //search in $data array to find one of this letters
    if (in_array($cellcode_char , ['A','B','C','D','X','Y','Z','D','W','V','E'])){
        //store th row from fetching result in array due to letter  
      $data[$cellcode_char] = $row1;
    
  if ($cellcode_char == 'A'){



?>



                    <div>


                        </br>
                        <input type="checkbox" name="cell[]" value="<?= 'A' ?>"
                            <?php if ( $data['A']) echo 'checked'; ?>><?= 'A' ?>

                        <input type="text" name="cellida" size="4" placeholder="Cell ID"
                            value="<?= $data['A']['CELL_ID']?? '' //echo CELL_ID and if it is null echo ''?>">
                        <input type="text" name="cellcodea" size="5" placeholder="Cell Code"
                            value="<?= $data['A']['CELL_CODE']?? 'empty' ?>">
                        <input type="text" name="cellnamea" size="15" placeholder="Cell Name"
                            value="<?= $data['A']['CELL_NAME']?? 'woow' ?>">
                        <input type="text" name="azimutha" size="3" placeholder="Azimuth"
                            value="<?= $data['A']['AZIMUTH']?? '' ?>">
                        <input type="text" name="celldatea" size="6" placeholder="On Air Date"
                            value="<?= $data['A']['ON_AIR_DATE']?? '' ?>">
                        <input type="text" name="heighta" size="3" placeholder="Height"
                            value="<?= $data['A']['HIEGHT']?? '' ?>">
                        <input type="text" name="mtilta" size="3" placeholder="M_TILT"
                            value="<?= $data['A']['M_TILT']?? '' ?>">
                        <input type="text" name="etilta" size="3" placeholder="E_TILT"
                            value="<?= $data['A']['E_TILT']?? '' ?>"></br>
                        <input type="text" name="area1a" size="30" placeholder="Arabic Serving Area"
                            value="<?= $data['A']['SERVING_AREA']?? '' ?>">
                        <input type="text" name="area2a" size="30" placeholder="English Serving Area"
                            value="<?= $data['A']['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
                        <input type="text" name="cnotesa" size="100" placeholder="Note"
                            value="<?= $data['A']['NOTE']?? '' ?>">

                    </div>

                    <?php } ?>


                    <?php 

if ($cellcode_char =='B'){

?>


                    <div>


                        </br>
                        <input type="checkbox" name="cell[]" value="<?= 'B' ?>"
                            <?php if ( $data['B']) echo 'checked'; ?>><?= 'B' ?>

                        <input type="text" name="cellidb" size="4" placeholder="Cell ID"
                            value="<?= $data['B']['CELL_ID']?? '' //echo CELL_ID and if it is null echo ''?>">
                        <input type="text" name="cellcodeb" size="5" placeholder="Cell Code"
                            value="<?= $data['B']['CELL_CODE']?? 'empty' ?>">
                        <input type="text" name="cellnameb" size="15" placeholder="Cell Name"
                            value="<?= $data['B']['CELL_NAME']?? 'woow' ?>">
                        <input type="text" name="azimuthb" size="3" placeholder="Azimuth"
                            value="<?= $data['B']['AZIMUTH']?? '' ?>">
                        <input type="text" name="celldateb" size="6" placeholder="On Air Date"
                            value="<?= $data['B']['ON_AIR_DATE']?? '' ?>">
                        <input type="text" name="heightb" size="3" placeholder="Height"
                            value="<?= $data['B']['HIEGHT']?? '' ?>">
                        <input type="text" name="mtiltb" size="3" placeholder="M_TILT"
                            value="<?= $data['B']['M_TILT']?? '' ?>">
                        <input type="text" name="etiltb" size="3" placeholder="E_TILT"
                            value="<?= $data['B']['E_TILT']?? '' ?>"></br>
                        <input type="text" name="area1b" size="30" placeholder="Arabic Serving Area"
                            value="<?= $data['B']['SERVING_AREA']?? '' ?>">
                        <input type="text" name="area2b" size="30" placeholder="English Serving Area"
                            value="<?= $data['B']['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
                        <input type="text" name="cnotesb" size="100" placeholder="Note"
                            value="<?= $data['B']['NOTE']?? '' ?>">

                    </div>

                    <?php } ?>

                    <?php 

if ($cellcode_char =='C'){

?>


                    <div>


                        </br>
                        <input type="checkbox" name="cell[]" value="<?= 'C' ?>"
                            <?php if ( $data['C']) echo 'checked'; ?>><?= 'C' ?>

                        <input type="text" name="cellidc" size="4" placeholder="Cell ID"
                            value="<?= $data['C']['CELL_ID']?? '' //echo CELL_ID and if it is null echo ''?>">
                        <input type="text" name="cellcodec" size="5" placeholder="Cell Code"
                            value="<?= $data['C']['CELL_CODE']?? 'empty' ?>">
                        <input type="text" name="cellnamec" size="15" placeholder="Cell Name"
                            value="<?= $data['C']['CELL_NAME']?? 'woow' ?>">
                        <input type="text" name="azimuthc" size="3" placeholder="Azimuth"
                            value="<?= $data['C']['AZIMUTH']?? '' ?>">
                        <input type="text" name="celldatec" size="6" placeholder="On Air Date"
                            value="<?= $data['C']['ON_AIR_DATE']?? '' ?>">
                        <input type="text" name="heightc" size="3" placeholder="Height"
                            value="<?= $data['C']['HIEGHT']?? '' ?>">
                        <input type="text" name="mtiltc" size="3" placeholder="M_TILT"
                            value="<?= $data['C']['M_TILT']?? '' ?>">
                        <input type="text" name="etiltc" size="3" placeholder="E_TILT"
                            value="<?= $data['C']['E_TILT']?? '' ?>"></br>
                        <input type="text" name="area1c" size="30" placeholder="Arabic Serving Area"
                            value="<?= $data['C']['SERVING_AREA']?? '' ?>">
                        <input type="text" name="area2c" size="30" placeholder="English Serving Area"
                            value="<?= $data['C']['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
                        <input type="text" name="cnotesc" size="100" placeholder="Note"
                            value="<?= $data['C']['Note']?? '' ?>">

                    </div>

                    <?php } ?>

                    <?php 

if ($cellcode_char =='D'){

?>


                    <div>


                        </br>
                        <input type="checkbox" name="cell[]" value="<?= 'D' ?>"
                            <?php if ( $data['D']) echo 'checked'; ?>><?= 'D' ?>

                        <input type="text" name="cellidd" size="4" placeholder="Cell ID"
                            value="<?= $data['D']['CELL_ID']?? '' //echo CELL_ID and if it is null echo ''?>">
                        <input type="text" name="cellcoded" size="5" placeholder="Cell Code"
                            value="<?= $data['D']['CELL_CODE']?? '' ?>">
                        <input type="text" name="cellnamed" size="15" placeholder="Cell Name"
                            value="<?= $data['D']['CELL_NAME']?? '' ?>">
                        <input type="text" name="azimuthd" size="3" placeholder="Azimuth"
                            value="<?= $data['D']['AZIMUTH']?? '' ?>">
                        <input type="text" name="celldated" size="6" placeholder="On Air Date"
                            value="<?= $data['D']['ON_AIR_DATE']?? '' ?>">
                        <input type="text" name="heightd" size="3" placeholder="Height"
                            value="<?= $data['D']['HIEGHT']?? '' ?>">
                        <input type="text" name="mtiltd" size="3" placeholder="M_TILT"
                            value="<?= $data['D']['M_TILT']?? '' ?>">
                        <input type="text" name="etiltd" size="3" placeholder="E_TILT"
                            value="<?= $data['D']['E_TILT']?? '' ?>"></br>
                        <input type="text" name="area1d" size="30" placeholder="Arabic Serving Area"
                            value="<?= $data['D']['SERVING_AREA']?? '' ?>">
                        <input type="text" name="area2d" size="30" placeholder="English Serving Area"
                            value="<?= $data['D']['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
                        <input type="text" name="cnotesd" size="100" placeholder="Note"
                            value="<?= $data['D']['NOTE']?? '' ?>">

                    </div>

                    <?php } ?>
                    <?php 
if ($cellcode_char =='X'){

?>


                    <div>


                        </br>
                        <input type="checkbox" name="cell[]" value="<?= 'X'?>"
                            <?php if ( $data['X']) echo 'checked'; ?>><?= 'X' ?>

                        <input type="text" name="cellidx" size="4" placeholder="Cell ID"
                            value="<?= $data['X']['CELL_ID']?? '' //echo CELL_ID and if it is null echo ''?>">
                        <input type="text" name="cellcodex" size="5" placeholder="Cell Code"
                            value="<?= $data['X']['CELL_CODE']?? 'empty' ?>">
                        <input type="text" name="cellnamex" size="15" placeholder="Cell Name"
                            value="<?= $data['X']['CELL_NAME']?? 'woow' ?>">
                        <input type="text" name="azimuthx" size="3" placeholder="Azimuth"
                            value="<?= $data['X']['AZIMUTH']?? '' ?>">
                        <input type="text" name="celldatex" size="6" placeholder="On Air Date"
                            value="<?= $data['X']['ON_AIR_DATE']?? '' ?>">
                        <input type="text" name="heightx" size="3" placeholder="Height"
                            value="<?= $data['X']['HIEGHT']?? '' ?>">
                        <input type="text" name="mtiltx" size="3" placeholder="M_TILT"
                            value="<?= $data['X']['M_TILT']?? '' ?>">
                        <input type="text" name="etiltx" size="3" placeholder="E_TILT"
                            value="<?= $data['X']['E_TILT']?? '' ?>"></br>
                        <input type="text" name="area1x" size="30" placeholder="Arabic Serving Area"
                            value="<?= $data['X']['SERVING_AREA']?? '' ?>">
                        <input type="text" name="area2x" size="30" placeholder="English Serving Area"
                            value="<?= $data['X']['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
                        <input type="text" name="cnotesx" size="100" placeholder="Note"
                            value="<?= $data['X']['Note']?? '' ?>">

                    </div>

                    <?php } ?>

                    <?php 
if ($cellcode_char =='Y'){

?>


                    <div>


                        </br>
                        <input type="checkbox" name="cell[]" value="<?= 'Y' ?>"
                            <?php if ( $data['Y']) echo 'checked'; ?>><?= 'Y' ?>

                        <input type="text" name="cellidy" size="4" placeholder="Cell ID"
                            value="<?= $data['Y']['CELL_ID']?? '' //echo CELL_ID and if it is null echo ''?>">
                        <input type="text" name="cellcodey" size="5" placeholder="Cell Code"
                            value="<?= $data['Y']['CELL_CODE']?? 'empty' ?>">
                        <input type="text" name="cellnamey" size="15" placeholder="Cell Name"
                            value="<?= $data['Y']['CELL_NAME']?? 'woow' ?>">
                        <input type="text" name="azimuthy" size="3" placeholder="Azimuth"
                            value="<?= $data['Y']['AZIMUTH']?? '' ?>">
                        <input type="text" name="celldatey" size="6" placeholder="On Air Date"
                            value="<?= $data['Y']['ON_AIR_DATE']?? '' ?>">
                        <input type="text" name="heighty" size="3" placeholder="Height"
                            value="<?= $data['Y']['HIEGHT']?? '' ?>">
                        <input type="text" name="mtilty" size="3" placeholder="M_TILT"
                            value="<?= $data['Y']['M_TILT']?? '' ?>">
                        <input type="text" name="etilty" size="3" placeholder="E_TILT"
                            value="<?= $data['Y']['E_TILT']?? '' ?>"></br>
                        <input type="text" name="area1y" size="30" placeholder="Arabic Serving Area"
                            value="<?= $data['Y']['SERVING_AREA']?? '' ?>">
                        <input type="text" name="area2y" size="30" placeholder="English Serving Area"
                            value="<?= $data['Y']['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
                        <input type="text" name="cnotesy" size="100" placeholder="Note"
                            value="<?= $data['Y']['NOTE']?? '' ?>">

                    </div>

                    <?php } ?>



                    <?php 
if ($cellcode_char =='Z'){

?>


                    <div>


                        </br>
                        <input type="checkbox" name="cell[]" value="<?= 'Z' ?>"
                            <?php if ( $data['Z']) echo 'checked'; ?>><?= 'Z' ?>

                        <input type="text" name="cellidz" size="4" placeholder="Cell ID"
                            value="<?= $data['Z']['CELL_ID']?? '' //echo CELL_ID and if it is null echo ''?>">
                        <input type="text" name="cellcodez" size="5" placeholder="Cell Code"
                            value="<?= $data['Z']['CELL_CODE']?? 'empty' ?>">
                        <input type="text" name="cellnamez" size="15" placeholder="Cell Name"
                            value="<?= $data['Z']['CELL_NAME']?? 'woow' ?>">
                        <input type="text" name="azimuthz" size="3" placeholder="Azimuth"
                            value="<?= $data['Z']['AZIMUTH']?? '' ?>">
                        <input type="text" name="celldatez" size="6" placeholder="On Air Date"
                            value="<?= $data['Z']['ON_AIR_DATE']?? '' ?>">
                        <input type="text" name="heightz" size="3" placeholder="Height"
                            value="<?= $data['Z']['HIEGHT']?? '' ?>">
                        <input type="text" name="mtiltz" size="3" placeholder="M_TILT"
                            value="<?= $data['Z']['M_TILT']?? '' ?>">
                        <input type="text" name="etiltz" size="3" placeholder="E_TILT"
                            value="<?= $data['Z']['E_TILT']?? '' ?>"></br>
                        <input type="text" name="area1z" size="30" placeholder="Arabic Serving Area"
                            value="<?= $data['Z']['SERVING_AREA']?? '' ?>">
                        <input type="text" name="area2z" size="30" placeholder="English Serving Area"
                            value="<?= $data['Z']['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
                        <input type="text" name="cnotesz" size="100" placeholder="Note"
                            value="<?= $data['Z']['NOTE']?? '' ?>">

                    </div>

                    <?php } ?>


                    <?php 
if ($cellcode_char =='W'){

?>


                    <div>


                        </br>
                        <input type="checkbox" name="cell[]" value="<?= 'w' ?>"
                            <?php if ( $data['W']) echo 'checked'; ?>><?= 'W' ?>

                        <input type="text" name="cellidw" size="4" placeholder="Cell ID"
                            value="<?= $data['W']['CELL_ID']?? '' //echo CELL_ID and if it is null echo ''?>">
                        <input type="text" name="cellcodew" size="5" placeholder="Cell Code"
                            value="<?= $data['W']['CELL_CODE']?? 'empty' ?>">
                        <input type="text" name="cellnamew" size="15" placeholder="Cell Name"
                            value="<?= $data['W']['CELL_NAME']?? 'woow' ?>">
                        <input type="text" name="azimuthw" size="3" placeholder="Azimuth"
                            value="<?= $data['W']['AZIMUTH']?? '' ?>">
                        <input type="text" name="celldatew" size="6" placeholder="On Air Date"
                            value="<?= $data['W']['ON_AIR_DATE']?? '' ?>">
                        <input type="text" name="heightw" size="3" placeholder="Height"
                            value="<?= $data['W']['HIEGHT']?? '' ?>">
                        <input type="text" name="mtiltw" size="3" placeholder="M_TILT"
                            value="<?= $data['W']['M_TILT']?? '' ?>">
                        <input type="text" name="etiltw" size="3" placeholder="E_TILT"
                            value="<?= $data['W']['E_TILT']?? '' ?>"></br>
                        <input type="text" name="area1w" size="30" placeholder="Arabic Serving Area"
                            value="<?= $data['W']['SERVING_AREA']?? '' ?>">
                        <input type="text" name="area2w" size="30" placeholder="English Serving Area"
                            value="<?= $data['W']['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
                        <input type="text" name="cnotesw" size="100" placeholder="Note"
                            value="<?= $data['W']['NOTE']?? '' ?>">

                    </div>

                    <?php } ?>

                    <?php 
if ($cellcode_char =='V'){

?>


                    <div>


                        </br>
                        <input type="checkbox" name="cell[]" value="<?= 'v' ?>"
                            <?php if ( $data['V']) echo 'checked'; ?>><?= 'V' ?>

                        <input type="text" name="cellidv" size="4" placeholder="Cell ID"
                            value="<?= $data['V']['CELL_ID']?? '' //echo CELL_ID and if it is null echo ''?>">
                        <input type="text" name="cellcodev" size="5" placeholder="Cell Code"
                            value="<?= $data['V']['CELL_CODE']?? 'empty' ?>">
                        <input type="text" name="cellnamev" size="15" placeholder="Cell Name"
                            value="<?= $data['V']['CELL_NAME']?? 'woow' ?>">
                        <input type="text" name="azimuthv" size="3" placeholder="Azimuth"
                            value="<?= $data['V']['AZIMUTH']?? '' ?>">
                        <input type="text" name="celldatev" size="6" placeholder="On Air Date"
                            value="<?= $data['V']['ON_AIR_DATE']?? '' ?>">
                        <input type="text" name="heightv" size="3" placeholder="Height"
                            value="<?= $data['V']['HIEGHT']?? '' ?>">
                        <input type="text" name="mtiltv" size="3" placeholder="M_TILT"
                            value="<?= $data['V']['M_TILT']?? '' ?>">
                        <input type="text" name="etiltv" size="3" placeholder="E_TILT"
                            value="<?= $data['V']['E_TILT']?? '' ?>"></br>
                        <input type="text" name="area1v" size="30" placeholder="Arabic Serving Area"
                            value="<?= $data['V']['SERVING_AREA']?? '' ?>">
                        <input type="text" name="area2v" size="30" placeholder="English Serving Area"
                            value="<?= $data['V']['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
                        <input type="text" name="cnotesv" size="100" placeholder="Note"
                            value="<?= $data['V']['NOTE']?? '' ?>">

                    </div>

                    <?php } ?>

                    <?php 
if ($cellcode_char =='E'){

?>


                    <div>


                        </br>
                        <input type="checkbox" name="cell[]" value="<?= 'E' ?>"
                            <?php if ( $data['E']) echo 'checked'; ?>><?= 'E' ?>

                        <input type="text" name="cellide" size="4" placeholder="Cell ID"
                            value="<?= $data['E']['CELL_ID']?? '' //echo CELL_ID and if it is null echo ''?>">
                        <input type="text" name="cellcodee" size="5" placeholder="Cell Code"
                            value="<?= $data['E']['CELL_CODE']?? 'empty' ?>">
                        <input type="text" name="cellnamee" size="15" placeholder="Cell Name"
                            value="<?= $data['E']['CELL_NAME']?? 'woow' ?>">
                        <input type="text" name="azimuthe" size="3" placeholder="Azimuth"
                            value="<?= $data['E']['AZIMUTH']?? '' ?>">
                        <input type="text" name="celldatee" size="6" placeholder="On Air Date"
                            value="<?= $data['E']['ON_AIR_DATE']?? '' ?>">
                        <input type="text" name="heighte" size="3" placeholder="Height"
                            value="<?= $data['E']['HIEGHT']?? '' ?>">
                        <input type="text" name="mtilte" size="3" placeholder="M_TILT"
                            value="<?= $data['E']['M_TILT']?? '' ?>">
                        <input type="text" name="etilte" size="3" placeholder="E_TILT"
                            value="<?= $data['E']['E_TILT']?? '' ?>"></br>
                        <input type="text" name="area1e" size="30" placeholder="Arabic Serving Area"
                            value="<?= $data['E']['SERVING_AREA']?? '' ?>">
                        <input type="text" name="area2e" size="30" placeholder="English Serving Area"
                            value="<?= $data['E']['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
                        <input type="text" name="cnotese" size="100" placeholder="Note"
                            value="<?= $data['E']['NOTE']?? '' ?>">

                    </div>

                    <?php } ?>



                    <?php 

}


}
?>
                </div>
            </div>
            <div class="footer">


                <div class="submit">

                    <input type="submit" name="submit" value="Update">
                </div>
                <div class="submit1">
                    <button class="submit2"
                        onclick="if(window.confirm('Are you sure to close without update?')) { window.close(); }">
                        Discard </button>
                </div>
                <div style="clear:both;"></div>


            </div>
        </form>
    </div>
</body>

</html>