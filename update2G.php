<?php 
include "config.php";
?>
<?php
if(isset($_GET['id2']))
{
$siteid =$_GET['id2'];
$sql= "SELECT s.*,  t.* , c.* FROM NEW_SITES s JOIN TWO_G_SITES t ON(s.ID = t.SITE_ID) JOIN TWO_G_CELLS c ON (t.CELL_ID = c.CID_KEY)     WHERE  t.SITE_ID = :siteid";
$sqll= "SELECT t.* , c.* FROM  TWO_G_SITES t JOIN TWO_G_CELLS c ON (t.CELL_ID = c.CID_KEY) WHERE t.SITE_ID = :siteid";
$result  = oci_parse($conn,$sql);
oci_bind_by_name($result, ':siteid' , $siteid);
oci_execute($result);
$row  = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS);

$resultt  = oci_parse($conn,$sqll);
oci_bind_by_name($resultt, ':siteid' , $siteid);
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
    
 
 

}

}
    ?>
<?php    

if(isset($_POST['submit']))
{

    $sid      = $_POST ['id'];
    $cellid   = $_POST['cid'] ; 
    $band     = $_POST['band'];
    $BTS      = $_POST['BTS'];
    $date2G   = $_POST['onairdate'];
    $RBS1     = $_POST['900Rbs'];
    $date1    = $_POST['900onairdate'];
    $RBS2     = $_POST['1800Rbs'];
    $status2G = $_POST['sitestatus'];
    $date2    = $_POST['1800onairdate'];
    $BSC      = $_POST['BSC'];
    $rBSC     = $_POST['realBSC']; 
    $lac      = $_POST['lac'];
    $snote    = $_POST['snotes'];
    $sitecode = $_POST['sitecode'];
//echo $sitecode;

$query = "UPDATE TWO_G_SITES 
          SET BAND = :band,
              SITE_STATUS = :status2G,
              BTS_TYPE = :BTS,
              BSC = :BSC,
              TWOG_ON_AIR_DATE = :date2G,
              NINTY_GSM_RBS_TYPE = :RBS1,
              NINTY_ON_AIR_DATE = :date1,
              EIGHTY_GSM_RBS_TYPE = :RBS2,
              EIGHTY_ON_AIR_DATE = :date2,
              NOTES = :snote,
              REAL_BSC = :rBSC,
              LAC = :lac
          WHERE SITE_ID = :sid";
echo $sid;
$updateresult = oci_parse($conn, $query);

oci_bind_by_name($updateresult, ':band', $band);
oci_bind_by_name($updateresult, ':status2G', $status2G);
oci_bind_by_name($updateresult, ':BTS', $BTS);
oci_bind_by_name($updateresult, ':BSC', $BSC);
oci_bind_by_name($updateresult, ':date2G', $date2G);
oci_bind_by_name($updateresult, ':RBS1', $RBS1);
oci_bind_by_name($updateresult, ':date1', $date1);
oci_bind_by_name($updateresult, ':RBS2', $RBS2);
oci_bind_by_name($updateresult, ':date2', $date2);
oci_bind_by_name($updateresult, ':snote', $snote);
oci_bind_by_name($updateresult, ':rBSC', $rBSC);
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
            //$cname = "Hello";
            $BSIC       = $_POST['BSICa']     ;
            $bcch       = $_POST['BCCHa']     ;
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
          
            $BSIC       = $_POST['BSICb']     ;
            $bcch       = $_POST['BCCHb']     ;
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
         
            $BSIC       = $_POST['BSICc']     ;
            $bcch       = $_POST['BCCHc']     ;
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
            $BSIC       = $_POST['BSICd']     ;
            $bcch       = $_POST['BCCHd']     ;
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
            $BSIC       = $_POST['BSICx']     ;
            $bcch       = $_POST['BCCHx']     ;
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
            $BSIC       = $_POST['BSICy']     ;
            $bcch       = $_POST['BCCHy']     ;
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
            $BSIC       = $_POST['BSICz']     ;
            $bcch       = $_POST['BCCHz']     ;
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
            $BSIC       = $_POST['BSICw']     ;
            $bcch       = $_POST['BCCHw']     ;
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
            $BSIC       = $_POST['BSICe']     ;
            $bcch       = $_POST['BCCHe']     ;
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
            $BSIC       = $_POST['BSICv']     ;
            $bcch       = $_POST['BCCHv']     ;
            $celldate   = $_POST['celldatev'] ;
      
     
    
            if(!empty( $_POST['etiltv'] && !empty($_POST['mtiltv']))){
                $ttilt = sprintf('%d',$_POST['mtiltv'] + $_POST['etiltv']);
            }
            else{ $ttilt ="-";}
        }

        $query1 = "UPDATE TWO_G_CELLS 
        SET CELL_CODE = :cellcode,
            CELL_NAME = :cname,
            CELL_ID = :cellid2,
            AZIMUTH = :azimuth,
            HIEGHT = :height,
            BSIC = :BSIC,
            M_TILT = :mtilt,
            E_TILT = :etilt,
            BSC = :BSC,
            BCCH = :bcch,
            CELL_ON_AIR_DATE = :celldate,
            NOTE = :cnote,
            SERVING_AREA_IN_ENGLISH = :aarea,
            SERVING_AREA = :earea 
        WHERE CELL_CODE = :cellcode AND CID_KEY = :sid";

$result1 = oci_parse($conn, $query1);

oci_bind_by_name($result1, ':cellcode', $cellcode);
oci_bind_by_name($result1, ':cname', $cname);
oci_bind_by_name($result1, ':cellid2', $cellid2);
oci_bind_by_name($result1, ':azimuth', $azimuth);
oci_bind_by_name($result1, ':height', $height);
oci_bind_by_name($result1, ':BSIC', $BSIC);
oci_bind_by_name($result1, ':mtilt', $mtilt);
oci_bind_by_name($result1, ':etilt', $etilt);
oci_bind_by_name($result1, ':BSC', $BSC);
oci_bind_by_name($result1, ':bcch', $bcch);
oci_bind_by_name($result1, ':celldate', $celldate);
oci_bind_by_name($result1, ':cnote', $cnote);
oci_bind_by_name($result1, ':aarea', $aarea);
oci_bind_by_name($result1, ':earea', $earea);
oci_bind_by_name($result1, ':sid', $sid);

$message = '';

if (oci_execute($result1)) {
    header("Location: thankyou.php");
    exit();

} else {
 $e = oci_error($result1);
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


    <title> Update 2G Site Info page </title>
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

        button {
            width: 70%;
            Height: 35px;
            font-size: 17px;
            font-weight: bold;
            margin: 10px;
            border-radius: 10px;
            text-align: center;
            border: none;
            color: #5c1c1c;
            
        }

        .button:hover {
            box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
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
            <h1></br> Update 2G Site Informations </h1>
            <?php echo $row['SITE_CODE']; ?> details</br>
            </br>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF"]); ?>" method="POST">
            <div class="form1">
                <div>
                    <input type="hidden" name="id" value="<?php echo $siteid; ?>">
                    <input type="hidden" name="cid" value="<?php echo $row['CID_KEY']; ?>">
                    <input type="hidden" name="sitecode" value="<?php echo $row['SITE_CODE']; ?>">
                </div>

                Select Band Width: </br>
                <?php
            $checked = [];
            $checked[0] =   isset($row['BAND']) && $row['BAND'] == "900"         ? 'checked' : '';
            $checked[1] =   isset($row['BAND']) && $row['BAND'] == "1800"        ? 'checked' : '';
            $checked[2] =   isset($row['BAND']) && $row['BAND'] == "900/1800"    ? 'checked' : '';

            ?>
                <input type="radio" id="option1" name="band" value="900" checked="<?php echo $checked[0];?>">900
                <input type="radio" id="option2" name="band" value="1800" checked="<?php echo $checked[0];?>">1800
                <input type="radio" id="option3" name="band" value="900/1800"
                    checked="<?php echo $checked[0];?>">900/1800</br></br>

                <div>
                    <label for="air date">2G On Air Date:</label>
                    <input type="text" name="onairdate" size="15" id="air date"
                        value="<?php echo $row['TWOG_ON_AIR_DATE']; ?>"></br></br>
                </div>

                <div>
                    BTS Type: <select name="BTS">

                        <option value="Empty">--</option>
                        <option value="Macro" <?php if($row['BTS_TYPE']=="Macro" ) echo 'Selected' ;?>>Macro</option>
                        <option value="Mbts" <?php if($row['BTS_TYPE']=="Mbts" ) echo 'Selected' ;?>>MBTS</option>
                        <option value="Micro" <?php if($row['BTS_TYPE']=="Micro" ) echo 'Selected' ;?>>Micro</option>
                        <option value="Grd" <?php if($row['BTS_TYPE']=="Grd" ) echo 'Selected' ;?>>GRD</option>
                        <option value="Rdu" <?php if($row['BTS_TYPE']=="Rdu" ) echo 'Selected' ;?>>RDU</option>

                    </select></br></br>
                </div>

                <div>
                    Site Status: <select name="sitestatus">

                        <option value="Empty">--</option>
                        <option value="On Air" <?php if($row['SITE_STATUS']=="On Air" ) echo 'Selected' ;?>>On Air
                        </option>
                        <option value="On Air (Stopped)" <?php if($row['SITE_STATUS']=="On Air (Stopped)" )
                            echo 'Selected' ;?>>On Air (Stopped)
                        </option>
                        <option value="On Air (Stopped_2)" <?php if($row['SITE_STATUS']=="On Air (Stopped_2)" )
                            echo 'Selected' ;?>>On Air (Stopped_2)
                        </option>
                    </select>
                    </br></br>
                </div>

                <div>
                    900 GSM RBS Type:
                    <select name="900Rbs">
                        <option value="">--</option>
                        <option value="BTS3900" <?php if($row['NINTY_GSM_RBS_TYPE']=="BTS3900" ) echo 'Selected' ;?>
                            >BTS3900</option>
                        <option value="DBS3900" <?php if($row['NINTY_GSM_RBS_TYPE']=="DBS3900" ) echo 'Selected' ;?>
                            >DBS3900</option>
                        <option value="DBS5900" <?php if($row['NINTY_GSM_RBS_TYPE']=="DBS5900" ) echo 'Selected' ;?>
                            >DBS5900</option>
                        <option value="BTS3900A" <?php if($row['NINTY_GSM_RBS_TYPE']=="BTS3900A" ) echo 'Selected' ;?>
                            >BTS3900A</option>
                        <option value="BTS3900L" <?php if($row['NINTY_GSM_RBS_TYPE']=="BTS3900L" ) echo 'Selected' ;?>
                            >BTS3900L</option>
                        <option value="6130" <?php if($row['NINTY_GSM_RBS_TYPE']=="6130" ) echo 'Selected' ;?>>
                            6130</option>
                        <option value="6102" <?php if($row['NINTY_GSM_RBS_TYPE']=="6102" ) echo 'Selected' ;?>>
                            6102</option>
                        <option value="6102/RRUS" <?php if($row['NINTY_GSM_RBS_TYPE']=="6102/RRUS" ) echo 'Selected' ;?>
                            >6102/RRUS</option>
                        <option value="6102/RUS" <?php if($row['NINTY_GSM_RBS_TYPE']=="6102/RUS" ) echo 'Selected' ;?>
                            >6102/RUS</option>
                        <option value="6102_V2" <?php if($row['NINTY_GSM_RBS_TYPE']=="6102_V2" ) echo 'Selected' ;?>
                            >6102_V2</option>
                        <option value="6102/RUG" <?php if($row['NINTY_GSM_RBS_TYPE']=="6102/RUG" ) echo 'Selected' ;?>
                            >6102/RUG</option>
                        <option value="6102\RRUS" <?php if($row['NINTY_GSM_RBS_TYPE']=="6102\RRUS" ) echo 'Selected' ;?>
                            >6102\RRUS</option>
                        <option value="6102W" <?php if($row['NINTY_GSM_RBS_TYPE']=="6102W" ) echo 'Selected' ;?>>
                            6102W</option>
                        <option value="2206" <?php if($row['NINTY_GSM_RBS_TYPE']=="2206" ) echo 'Selected' ;?>>
                            2206</option>
                        <option value="2206_V1" <?php if($row['NINTY_GSM_RBS_TYPE']=="2206_V1" ) echo 'Selected' ;?>
                            >2206_V1</option>
                        <option value="2206_V2" <?php if($row['NINTY_GSM_RBS_TYPE']=="2206_V2" ) echo 'Selected' ;?>
                            >2206_V2</option>
                        <option value="2216" <?php if($row['NINTY_GSM_RBS_TYPE']=="2216" ) echo 'Selected' ;?>>
                            2216</option>
                        <option value="2216_V2" <?php if($row['NINTY_GSM_RBS_TYPE']=="2216_V2" ) echo 'Selected' ;?>
                            >2216_V2</option>
                        <option value="6150" <?php if($row['NINTY_GSM_RBS_TYPE']=="6150" ) echo 'Selected' ;?>>
                            6150</option>
                        <option value="6150/RUS" <?php if($row['NINTY_GSM_RBS_TYPE']=="6150/RUS" ) echo 'Selected' ;?>
                            >6150/RUS</option>
                        <option value="6201" <?php if($row['NINTY_GSM_RBS_TYPE']=="6201" ) echo 'Selected' ;?>>
                            6201</option>
                        <option value="6201_V2" <?php if($row['NINTY_GSM_RBS_TYPE']=="6201_V2" ) echo 'Selected' ;?>
                            >6201_V2</option>
                        <option value="6201\DUG" <?php if($row['NINTY_GSM_RBS_TYPE']=="6201\DUG" ) echo 'Selected' ;?>
                            >6201\DUG</option>
                        <option value="6201/RUS" <?php if($row['NINTY_GSM_RBS_TYPE']=="6201/RUS" ) echo 'Selected' ;?>
                            >6201/RUS</option>
                        <option value="6201V2/RUS" <?php if($row['NINTY_GSM_RBS_TYPE']=="6201V2/RUS" ) echo 'Selected'
                            ;?>>6201V2/RUS
                        </option>
                        <option value="6301" <?php if($row['NINTY_GSM_RBS_TYPE']=="6301" ) echo 'Selected' ;?>>
                            6301</option>
                        <option value="6301/RRUS" <?php if($row['NINTY_GSM_RBS_TYPE']=="6301/RRUS" ) echo 'Selected' ;?>
                            >6301/RRUS</option>
                        <option value="2109" <?php if($row['NINTY_GSM_RBS_TYPE']=="2109" ) echo 'Selected' ;?>>
                            2109</option>
                        <option value="2111" <?php if($row['NINTY_GSM_RBS_TYPE']=="2111" ) echo 'Selected' ;?>>
                            2111</option>
                        <option value="2116" <?php if($row['NINTY_GSM_RBS_TYPE']=="2116" ) echo 'Selected' ;?>>
                            2116</option>
                        <option value="2302" <?php if($row['NINTY_GSM_RBS_TYPE']=="2302" ) echo 'Selected' ;?>>
                            2302</option>
                        <option value="2308" <?php if($row['NINTY_GSM_RBS_TYPE']=="2308" ) echo 'Selected' ;?>>
                            2308</option>
                        <option value="6601" <?php if($row['NINTY_GSM_RBS_TYPE']=="6601" ) echo 'Selected' ;?>>
                            6601</option>
                        <option value="6601/RRUS" <?php if($row['NINTY_GSM_RBS_TYPE']=="6601/RRUS" ) echo 'Selected' ;?>
                            >6601/RRUS</option>


                    </select>
                    </br></br>

                    <label for="air date1">900 On Air Date:</label>
                    <input type="text" name="900onairdate" size="15" id="air date1"
                        value="<?php echo $row['NINTY_ON_AIR_DATE']; ?>"></br></br>
                </div>

                <div>
                    1800 GSM RBS Type:
                    <select name="1800Rbs">

                        <option value="">--</option>
                        <option value="BTS3900" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="BTS3900" ) echo 'Selected' ;?>
                            >BTS3900</option>
                        <option value="DBS3900" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="DBS3900" ) echo 'Selected' ;?>
                            >DBS3900</option>
                        <option value="DBS5900" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="DBS5900" ) echo 'Selected' ;?>
                            >DBS5900</option>
                        <option value="BTS3900A" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="BTS3900A" ) echo 'Selected' ;?>
                            >BTS3900A</option>
                        <option value="BTS3900L" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="BTS3900L" ) echo 'Selected' ;?>
                            >BTS3900L</option>
                        <option value="6130" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6130" ) echo 'Selected' ;?>>
                            6130</option>
                        <option value="6102" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6102" ) echo 'Selected' ;?>>
                            6102</option>
                        <option value="6102/RRUS" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6102/RRUS" ) echo 'Selected'
                            ;?>>6102/RRUS
                        </option>
                        <option value="6102/RUS" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6102/RUS" ) echo 'Selected' ;?>
                            >6102/RUS</option>
                        <option value="6102_V2" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6102_V2" ) echo 'Selected' ;?>
                            >6102_V2</option>
                        <option value="6102/RUG" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6102/RUG" ) echo 'Selected' ;?>
                            >6102/RUG</option>
                        <option value="6102\RRUS" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6102\RRUS" ) echo 'Selected'
                            ;?>>6102\RRUS
                        </option>
                        <option value="6102W" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6102W" ) echo 'Selected' ;?>>6102W
                        </option>
                        <option value="2206" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="2206" ) echo 'Selected' ;?>>
                            2206</option>
                        <option value="2206_V1" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="2206_V1" ) echo 'Selected' ;?>
                            >2206_V1</option>
                        <option value="2206_V2" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="2206_V2" ) echo 'Selected' ;?>
                            >2206_V2</option>
                        <option value="2216" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="2216" ) echo 'Selected' ;?>>
                            2216</option>
                        <option value="2216_V2" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="2216_V2" ) echo 'Selected' ;?>
                            >2216_V2</option>
                        <option value="6150" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6150" ) echo 'Selected' ;?>>
                            6150</option>
                        <option value="6150/RUS" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6150/RUS" ) echo 'Selected' ;?>
                            >6150/RUS</option>
                        <option value="6201" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6201" ) echo 'Selected' ;?>>
                            6201</option>
                        <option value="6201_V2" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6201_V2" ) echo 'Selected' ;?>
                            >6201_V2</option>
                        <option value="6201\DUG" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6201\DUG" ) echo 'Selected' ;?>
                            >6201\DUG</option>
                        <option value="6201/RUS" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6201/RUS" ) echo 'Selected' ;?>
                            >6201/RUS</option>
                        <option value="6201V2/RUS" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6201V2/RUS" ) echo 'Selected'
                            ;?>>6201V2/RUS
                        </option>
                        <option value="6301" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6301" ) echo 'Selected' ;?>>
                            6301</option>
                        <option value="6301/RRUS" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6301/RRUS" ) echo 'Selected'
                            ;?>>6301/RRUS
                        </option>
                        <option value="2109" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="2109" ) echo 'Selected' ;?>>
                            2109</option>
                        <option value="2111" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="2111" ) echo 'Selected' ;?>>
                            2111</option>
                        <option value="2116" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="2116" ) echo 'Selected' ;?>>
                            2116</option>
                        <option value="2302" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="2302" ) echo 'Selected' ;?>>
                            2302</option>
                        <option value="2308" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="2308" ) echo 'Selected' ;?>>
                            2308</option>
                        <option value="6601" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6601" ) echo 'Selected' ;?>>
                            6601</option>
                        <option value="6601/RRUS" <?php if($row['EIGHTY_GSM_RBS_TYPE']=="6601/RRUS" ) echo 'Selected'
                            ;?>>6601/RRUS
                        </option>

                    </select>
                    </br></br>

                    <label for="air date2">1800 On Air Date:</label>
                    <input type="text" name="1800onairdate" size="15" id="air date2"
                        value="<?php echo $row['EIGHTY_ON_AIR_DATE']; ?>"></br></br>
                </div>

                <div>

                    BSC: <select name="BSC" value="<?php echo $row['BSC']; ?>">

                        <option value="Empty">--</option>
                        <option value="EVOBSC1">EVOBSC1</option>
                        <option value="EVOBSC2">EVOBSC2</option>
                        <option value="EVOBSC4">EVOBSC4</option>
                        <option value="EVOBSC5">EVOBSC5</option>
                        <option value="EVOBSC6">EVOBSC6</option>
                        <option value="EVOBSC9">EVOBSC9</option>
                        <option value="HDBSC1"> HDBSC1 </option>
                        <option value="HDBSC2"> HDBSC2 </option>
                        <option value="HBSC1"> HBSC1 </option>
                        <option value="HBSC2"> HBSC2 </option>
                        <option value="HBSC4"> HBSC4 </option>
                        <option value="HBSC7"> HBSC7 </option>
                        <option value="HBSC8"> HBSC8 </option>
                        <option value="HBSC10"> HBSC10 </option>
                        <option value="HBSC11"> HBSC11 </option>
                        <option value="HSKBSC2">HSKBSC2</option>



                    </select>
                    </br></br>
                </div>
                <div>
                    <label for="lac">Real BSC:</label>
                    <input type="text" name="realBSC" size="15" id="RBSC"
                        value="<?php echo $row['REAL_BSC']; ?>"></br></br>
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

                Select Cells:</br>
                <?php 

  
while ($row1 = oci_fetch_array($resultt, OCI_ASSOC + OCI_RETURN_NULLS)){
      
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
                    <input type="checkbox" name="cell[]" value="<?= 'A' ?>" <?php if ( $data['A']) echo 'checked' ; ?>>
                    <?= 'A' ?>

                    <input type="text" name="cellida" size="4" placeholder="Cell ID"
                        value="<?= $data['A']['CELL_ID']?? '' //echo cell_id and if it is null echo ''?>">
                    <input type="text" name="cellcodea" size="5" placeholder="Cell Code"
                        value="<?= $data['A']['CELL_CODE']?? 'empty' ?>">
                    <input type="text" name="cellnamea" size="15" placeholder="Cell Name"
                        value="<?= $data['A']['CELL_NAME']?? 'woow' ?>">
                    <input type="text" name="azimutha" size="3" placeholder="Azimuth"
                        value="<?= $data['A']['AZIMUTH']?? '' ?>">
                    <input type="text" name="celldatea" size="6" placeholder="On Air Date"
                        value="<?= $data['A']['CELL_ON_AIR_DATE']?? '' ?>">
                    <input type="text" name="heighta" size="3" placeholder="Height"
                        value="<?= $data['A']['HIEGHT']?? '' ?>">
                    <input type="text" name="BSICa" size="3" placeholder="BSIC" value="<?= $data['A']['BSIC']?? '' ?>">
                    <input type="text" name="BCCHa" size="3" placeholder="BCCH" value="<?= $data['A']['BCCH']?? '' ?>">
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
                    <input type="checkbox" name="cell[]" value="<?= 'B' ?>" <?php if ( $data['B']) echo 'checked' ; ?>>
                    <?= 'B' ?>

                    <input type="text" name="cellidb" size="4" placeholder="Cell ID"
                        value="<?= $data['B']['CELL_ID']?? '' //echo cell_id and if it is null echo ''?>">
                    <input type="text" name="cellcodeb" size="5" placeholder="Cell Code"
                        value="<?= $data['B']['CELL_CODE']?? 'empty' ?>">
                    <input type="text" name="cellnameb" size="15" placeholder="Cell Name"
                        value="<?= $data['B']['CELL_NAME']?? 'woow' ?>">
                    <input type="text" name="azimuthb" size="3" placeholder="Azimuth"
                        value="<?= $data['B']['AZIMUTH']?? '' ?>">
                    <input type="text" name="celldateb" size="6" placeholder="On Air Date"
                        value="<?= $data['B']['CELL_ON_AIR_DATE']?? '' ?>">
                    <input type="text" name="heightb" size="3" placeholder="Height"
                        value="<?= $data['B']['HIEGHT']?? '' ?>">
                    <input type="text" name="BSICb" size="3" placeholder="BSIC" value="<?= $data['B']['BSIC']?? '' ?>">
                    <input type="text" name="BCCHb" size="3" placeholder="BCCH" value="<?= $data['B']['BCCH']?? '' ?>">
                    <input type="text" name="mtiltb" size="3" placeholder="M_TILT"
                        value="<?= $data['B']['M_TILT']?? '' ?>">
                    <input type="text" name="etiltb" size="3" placeholder="E_TILT"
                        value="<?= $data['B']['E_TILT']?? '' ?>"></br>
                    <input type="text" name="area1b" size="30" placeholder="Arabic Serving Area"
                        value="<?= $data['B']['SERVING_AREA']?? '' ?>">
                    <input type="text" name="area2b" size="30" placeholder="English Serving Area"
                        value="<?= $data['B']['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
                    <input type="text" name="cnotesb" size="100" placeholder="NOTE"
                        value="<?= $data['B']['NOTE']?? '' ?>">

                </div>

                <?php } ?>

                <?php 

if ($cellcode_char =='C'){

?>


                <div>


                    </br>
                    <input type="checkbox" name="cell[]" value="<?= 'C' ?>" <?php if ( $data['C']) echo 'checked' ; ?>>
                    <?= 'C' ?>

                    <input type="text" name="cellidc" size="4" placeholder="Cell ID"
                        value="<?= $data['C']['CELL_ID']?? '' //echo cell_id and if it is null echo ''?>">
                    <input type="text" name="cellcodec" size="5" placeholder="Cell Code"
                        value="<?= $data['C']['CELL_CODE']?? 'empty' ?>">
                    <input type="text" name="cellnamec" size="15" placeholder="Cell Name"
                        value="<?= $data['C']['CELL_NAME']?? 'woow' ?>">
                    <input type="text" name="azimuthc" size="3" placeholder="Azimuth"
                        value="<?= $data['C']['AZIMUTH']?? '' ?>">
                    <input type="text" name="celldatec" size="6" placeholder="On Air Date"
                        value="<?= $data['C']['CELL_ON_AIR_DATE']?? '' ?>">
                    <input type="text" name="heightc" size="3" placeholder="Height"
                        value="<?= $data['C']['HIEGHT']?? '' ?>">
                    <input type="text" name="BSICc" size="3" placeholder="BSIC" value="<?= $data['C']['BSIC']?? '' ?>">
                    <input type="text" name="BCCHc" size="3" placeholder="BCCH" value="<?= $data['C']['BCCH']?? '' ?>">
                    <input type="text" name="mtiltc" size="3" placeholder="M_TILT"
                        value="<?= $data['C']['M_TILT']?? '' ?>">
                    <input type="text" name="etiltc" size="3" placeholder="E_TILT"
                        value="<?= $data['C']['E_TILT']?? '' ?>"></br>
                    <input type="text" name="area1c" size="30" placeholder="Arabic Serving Area"
                        value="<?= $data['C']['SERVING_AREA']?? '' ?>">
                    <input type="text" name="area2c" size="30" placeholder="English Serving Area"
                        value="<?= $data['C']['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
                    <input type="text" name="cnotesc" size="100" placeholder="Note"
                        value="<?= $data['C']['NOTE']?? '' ?>">

                </div>

                <?php } ?>

                <?php 

if ($cellcode_char =='D'){

?>


                <div>


                    </br>
                    <input type="checkbox" name="cell[]" value="<?= 'D' ?>" <?php if ( $data['D']) echo 'checked' ; ?>>
                    <?= 'D' ?>

                    <input type="text" name="cellidd" size="4" placeholder="Cell ID"
                        value="<?= $data['D']['CELL_ID']?? '' //echo cell_id and if it is null echo ''?>">
                    <input type="text" name="cellcoded" size="5" placeholder="Cell Code"
                        value="<?= $data['D']['CELL_CODE']?? '' ?>">
                    <input type="text" name="cellnamed" size="15" placeholder="Cell Name"
                        value="<?= $data['D']['CELL_NAME']?? '' ?>">
                    <input type="text" name="azimuthd" size="3" placeholder="Azimuth"
                        value="<?= $data['D']['AZIMUTH']?? '' ?>">
                    <input type="text" name="celldated" size="6" placeholder="On Air Date"
                        value="<?= $data['D']['CELL_ON_AIR_DATE']?? '' ?>">
                    <input type="text" name="heightd" size="3" placeholder="Height"
                        value="<?= $data['D']['HIEGHT']?? '' ?>">
                    <input type="text" name="BSICd" size="3" placeholder="BSIC" value="<?= $data['D']['BSIC']?? '' ?>">
                    <input type="text" name="BCCHd" size="3" placeholder="BCCH" value="<?= $data['D']['BCCH']?? '' ?>">
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
                    <input type="checkbox" name="cell[]" value="<?= 'X'?>" <?php if ( $data['X']) echo 'checked' ; ?>>
                    <?= 'X' ?>

                    <input type="text" name="cellidx" size="4" placeholder="Cell ID"
                        value="<?= $data['X']['Cell_ID']?? '' //echo cell_id and if it is null echo ''?>">
                    <input type="text" name="cellcodex" size="5" placeholder="Cell Code"
                        value="<?= $data['X']['CELL_CODE']?? 'empty' ?>">
                    <input type="text" name="cellnamex" size="15" placeholder="Cell Name"
                        value="<?= $data['X']['CELL_NAME']?? 'woow' ?>">
                    <input type="text" name="azimuthx" size="3" placeholder="Azimuth"
                        value="<?= $data['X']['AZIMUTH']?? '' ?>">
                    <input type="text" name="celldatex" size="6" placeholder="On Air Date"
                        value="<?= $data['X']['CELL_ON_AIR_DATE']?? '' ?>">
                    <input type="text" name="heightx" size="3" placeholder="Height"
                        value="<?= $data['X']['HIEGHT']?? '' ?>">
                    <input type="text" name="BSICx" size="3" placeholder="BSIC" value="<?= $data['X']['BSIC']?? '' ?>">
                    <input type="text" name="BCCHx" size="3" placeholder="BCCH" value="<?= $data['X']['BCCH']?? '' ?>">
                    <input type="text" name="mtiltx" size="3" placeholder="M_TILT"
                        value="<?= $data['X']['M_TILT']?? '' ?>">
                    <input type="text" name="etiltx" size="3" placeholder="E_TILT"
                        value="<?= $data['X']['E_TILT']?? '' ?>"></br>
                    <input type="text" name="area1x" size="30" placeholder="Arabic Serving Area"
                        value="<?= $data['X']['SERVING_AREA']?? '' ?>">
                    <input type="text" name="area2x" size="30" placeholder="English Serving Area"
                        value="<?= $data['X']['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
                    <input type="text" name="cnotesx" size="100" placeholder="Note"
                        value="<?= $data['X']['NOTE']?? '' ?>">

                </div>

                <?php } ?>

                <?php 
if ($cellcode_char =='Y'){

?>


                <div>


                    </br>
                    <input type="checkbox" name="cell[]" value="<?= 'Y' ?>" <?php if ( $data['Y']) echo 'checked' ; ?>>
                    <?= 'Y' ?>

                    <input type="text" name="cellidy" size="4" placeholder="Cell ID"
                        value="<?= $data['Y']['CELL_ID']?? '' //echo cell_id and if it is null echo ''?>">
                    <input type="text" name="cellcodey" size="5" placeholder="Cell Code"
                        value="<?= $data['Y']['CELL_CODE']?? 'empty' ?>">
                    <input type="text" name="cellnamey" size="15" placeholder="Cell Name"
                        value="<?= $data['Y']['CELL_NAME']?? 'woow' ?>">
                    <input type="text" name="azimuthy" size="3" placeholder="Azimuth"
                        value="<?= $data['Y']['AZIMUTH']?? '' ?>">
                    <input type="text" name="celldatey" size="6" placeholder="On Air Date"
                        value="<?= $data['Y']['CELL_ON_AIR_DATE']?? '' ?>">
                    <input type="text" name="heighty" size="3" placeholder="Height"
                        value="<?= $data['Y']['HIEGHT']?? '' ?>">
                    <input type="text" name="BSICy" size="3" placeholder="BSIC" value="<?= $data['Y']['BSIC']?? '' ?>">
                    <input type="text" name="BCCHy" size="3" placeholder="BCCH" value="<?= $data['Y']['BCCH']?? '' ?>">
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
                    <input type="checkbox" name="cell[]" value="<?= 'Z' ?>" <?php if ( $data['Z']) echo 'checked' ; ?>>
                    <?= 'Z' ?>

                    <input type="text" name="cellidz" size="4" placeholder="Cell ID"
                        value="<?= $data['Z']['Cell_ID']?? '' //echo cell_id and if it is null echo ''?>">
                    <input type="text" name="cellcodez" size="5" placeholder="Cell Code"
                        value="<?= $data['Z']['Cell_code']?? 'empty' ?>">
                    <input type="text" name="cellnamez" size="15" placeholder="Cell Name"
                        value="<?= $data['Z']['Cell_Name']?? 'woow' ?>">
                    <input type="text" name="azimuthz" size="3" placeholder="Azimuth"
                        value="<?= $data['Z']['AZIMUTH']?? '' ?>">
                    <input type="text" name="celldatez" size="6" placeholder="On Air Date"
                        value="<?= $data['Z']['Cell_On_Air_Date']?? '' ?>">
                    <input type="text" name="heightz" size="3" placeholder="Height"
                        value="<?= $data['Z']['Hieght']?? '' ?>">
                    <input type="text" name="BSICz" size="3" placeholder="BSIC" value="<?= $data['Z']['BSiC']?? '' ?>">
                    <input type="text" name="BCCHz" size="3" placeholder="BCCH" value="<?= $data['Z']['BCCH']?? '' ?>">
                    <input type="text" name="mtiltz" size="3" placeholder="M_TILT"
                        value="<?= $data['Z']['M_TILT']?? '' ?>">
                    <input type="text" name="etiltz" size="3" placeholder="E_TILT"
                        value="<?= $data['Z']['E_TILT']?? '' ?>"></br>
                    <input type="text" name="area1z" size="30" placeholder="Arabic Serving Area"
                        value="<?= $data['Z']['Serving_Area']?? '' ?>">
                    <input type="text" name="area2z" size="30" placeholder="English Serving Area"
                        value="<?= $data['Z']['serving_Area_IN_English']?? '' ?>"></br></br>
                    <input type="text" name="cnotesz" size="100" placeholder="Note"
                        value="<?= $data['Z']['Note']?? '' ?>">

                </div>

                <?php } ?>


                <?php 
if ($cellcode_char =='W'){

?>


                <div>


                    </br>
                    <input type="checkbox" name="cell[]" value="<?= 'w' ?>" <?php if ( $data['W']) echo 'checked' ; ?>>
                    <?= 'W' ?>

                    <input type="text" name="cellidw" size="4" placeholder="Cell ID"
                        value="<?= $data['W']['CELL_ID']?? '' //echo cell_id and if it is null echo ''?>">
                    <input type="text" name="cellcodew" size="5" placeholder="Cell Code"
                        value="<?= $data['W']['CELL_CODE']?? 'empty' ?>">
                    <input type="text" name="cellnamew" size="15" placeholder="Cell Name"
                        value="<?= $data['W']['CELL_NAME']?? 'woow' ?>">
                    <input type="text" name="azimuthw" size="3" placeholder="Azimuth"
                        value="<?= $data['W']['AZIMUTH']?? '' ?>">
                    <input type="text" name="celldatew" size="6" placeholder="On Air Date"
                        value="<?= $data['W']['CELL_ON_AIR_DATE']?? '' ?>">
                    <input type="text" name="heightw" size="3" placeholder="Height"
                        value="<?= $data['W']['HIEGHT']?? '' ?>">
                    <input type="text" name="BSICw" size="3" placeholder="BSIC" value="<?= $data['W']['BSIC']?? '' ?>">
                    <input type="text" name="BCCHw" size="3" placeholder="BCCH" value="<?= $data['W']['BCCH']?? '' ?>">
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
                    <input type="checkbox" name="cell[]" value="<?= 'v' ?>" <?php if ( $data['V']) echo 'checked' ; ?>>
                    <?= 'V' ?>

                    <input type="text" name="cellidv" size="4" placeholder="Cell ID"
                        value="<?= $data['V']['Cell_ID']?? '' //echo cell_id and if it is null echo ''?>">
                    <input type="text" name="cellcodev" size="5" placeholder="Cell Code"
                        value="<?= $data['V']['CELL_CODE']?? 'empty' ?>">
                    <input type="text" name="cellnamev" size="15" placeholder="Cell Name"
                        value="<?= $data['V']['CELL_NAME']?? 'woow' ?>">
                    <input type="text" name="azimuthv" size="3" placeholder="Azimuth"
                        value="<?= $data['V']['AZIMUTH']?? '' ?>">
                    <input type="text" name="celldatev" size="6" placeholder="On Air Date"
                        value="<?= $data['V']['CELL_ON_AIR_DATE']?? '' ?>">
                    <input type="text" name="heightv" size="3" placeholder="Height"
                        value="<?= $data['V']['HIEGHT']?? '' ?>">
                    <input type="text" name="BSICv" size="3" placeholder="BSIC" value="<?= $data['V']['BSIC']?? '' ?>">
                    <input type="text" name="BCCHv" size="3" placeholder="BCCH" value="<?= $data['V']['BCCH']?? '' ?>">
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
                    <input type="checkbox" name="cell[]" value="<?= 'E' ?>" <?php if ( $data['E']) echo 'checked' ; ?>>
                    <?= 'E' ?>

                    <input type="text" name="cellide" size="4" placeholder="Cell ID"
                        value="<?= $data['E']['CELL_ID']?? '' //echo cell_id and if it is null echo ''?>">
                    <input type="text" name="cellcodee" size="5" placeholder="Cell Code"
                        value="<?= $data['E']['CELL_CODE']?? 'empty' ?>">
                    <input type="text" name="cellnamee" size="15" placeholder="Cell Name"
                        value="<?= $data['E']['CELL_NAME']?? 'woow' ?>">
                    <input type="text" name="azimuthe" size="3" placeholder="Azimuth"
                        value="<?= $data['E']['AZIMUTH']?? '' ?>">
                    <input type="text" name="celldatee" size="6" placeholder="On Air Date"
                        value="<?= $data['E']['CELL_ON_AIR_DATE']?? '' ?>">
                    <input type="text" name="heighte" size="3" placeholder="Height"
                        value="<?= $data['E']['HIEGHT']?? '' ?>">
                    <input type="text" name="BSICe" size="3" placeholder="BSIC" value="<?= $data['E']['BSIC']?? '' ?>">
                    <input type="text" name="BCCHe" size="3" placeholder="BCCH" value="<?= $data['E']['BCCH']?? '' ?>">
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
            <script>
                function close_window() {
  if (confirm("Close Window?")) {
    close();
  }
}
            </script>
            <div class="footer">
                <div class="submit">
                    <input type="submit" name="submit" value="Update">
                </div>
                <div class="submit">
                    <button type="button" onclick="if(window.confirm('Are you sure?')) { window.close(); }">Discard</button>
                </div>
                <div style="clear:both;"></div>


            </div>

        </form>
    </div>


</body>

</html>