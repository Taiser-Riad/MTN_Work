<?php 
include "config.php";
?>
<?php
if(isset($_GET['id4']))
{
    $id =$_GET['id4'];
    $sql = "SELECT s.*, t.* , c.*   FROM NEW_SITES s      INNER JOIN FOUR_G_SITES t ON(s.ID = t.SID)    JOIN FOUR_G_CELLS c ON (t.CELL_ID_KEY = c.CID_KEY) WHERE s.ID = :id";
    $sqll= "SELECT t.* , c.*        FROM FOUR_G_SITES t   INNER JOIN FOUR_G_CELLS c ON (t.CELL_ID_KEY = c.CID_KEY) WHERE t.CELL_ID_KEY = :id";

    $result  = oci_parse($conn,$sql);
    oci_bind_by_name($result , ':id' ,$id);
    oci_execute($result);
    
    $resultt = oci_parse($conn,$sqll);
    oci_bind_by_name($resultt , ':id' ,$id);
    oci_execute($resultt);


    $row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS);


    if ($resultt){
        //define array with keys to store the fetching result for each cell in it
        $data = [
            'A' => null,
            'B' => null,
            'C' => null,
            'D' => null,
    
        
        ];
            
         
         
        
        }


    }


   if($_SERVER["REQUEST_METHOD"] == "POST")
   {
       $sid        = $_POST ['id'];
       $sitecode   = $_POST['sitecode'];
       $sitename   = $_POST['sitename'];
       $nodeb      = $_POST['nodeb'];
       $BTS        = $_POST['BTS'];
       $status     = $_POST['status'];
       $date4G     = $_POST['onairdate'];
       $restordate = $_POST['restoration'];
       $lac        = $_POST['lac'];
       //$azimuth    = $_POST['azimuth'];
       //$height     = $_POST['height'];
       $snote      = $_POST['snotes'];
       ///$cnote      = $_POST['cnotes'];
       //$mtilt      = $_POST['mtilt'];
       //$etilt      = $_POST['etilt'];
       //$ttilt      = $_POST['ttilt'];
       //$earea      = $_POST['area1'];
       //$aarea      = $_POST['area2'];
       $site_type  = $_POST['SiteType'];

$query1 = "UPDATE FOUR_G_SITES SET SITE_CODE =:sitecode, ENODEB_ID =:nodeb, BTS_TYPE =:BTS, LAC =:lac, STATUS =:status, ACTIVATION_DATE =:date4G, NOTE =:snote, RESTORATION_DATE =:restordate WHERE SID =:sd ";
    
    $updateresult = oci_parse($conn, $query1);
    
    oci_bind_by_name($updateresult, ':sitecode', $sitecode);
    oci_bind_by_name($updateresult, ':nodeb', $nodeb);
    oci_bind_by_name($updateresult, ':BTS', $BTS);
    oci_bind_by_name($updateresult, ':status', $status);
    oci_bind_by_name($updateresult, ':date4G', $date4G);
    oci_bind_by_name($updateresult, ':snote', $snote);
    oci_bind_by_name($updateresult, ':restordate', $restordate);
    oci_bind_by_name($updateresult, ':lac', $lac);
    oci_bind_by_name($updateresult, ':sd', $sid);
    
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
            $query2 = "UPDATE FOUR_G_CELLS
            SET CELL_ID = :cellid2,
                CELL_CODE = :cellcode,
                CELL_NAME = :cname,
                ON_AIR_DATE = :celldate,
                AZIMUTH = :azimuth,
                M_TILT = :mtilt,
                E_TILT = :etilt,
                TOTAL_TILT = :ttilt,
                SERVING_AREA = :aarea,
                SERVING_AREA_IN_ENGLISH = :earea,
                NOTES = :cnote,
                HEIGHT = :height 
            WHERE CELL_CODE = :cellcode AND CID_KEY = :sid";
    
    $result2 = oci_parse($conn, $query2);
    
    
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

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web\css\all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> 4G Site page </title>
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
            <h1></br> 4G Site Informations </h1>
            <?php echo $row['SITE_CODE']; ?> details.</br>
            </br>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
            onsubmit="return confirmupdate();">
            <div class="form1">
                <div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    Site Code:<input type="text" name="sitecode" value="<?php echo $row['SITE_CODE']; ?>"></br></br>
                    Site Name:<input type="text" name="sitename" disabled
                        value="<?php echo $row['SITE_NAME']; ?>"></br></br>
                </div>
                <div>
                    <label for="node">E NodeB_ID:</label>
                    <input type="text" name="nodeb" size="5" id="node"
                        value="<?php echo $row['ENODEB_ID']; ?>"></br></br>
                </div>

                <div>
                    BTS Type: <select name="BTS">
                        <option value="">--</option>
                        <option value="DBS3900" <?php if($row['BTS_TYPE'] == "DBS3900")      echo 'Selected' ;?>>DBS3900
                        </option>
                        <option value="DBS5900" <?php if($row['BTS_TYPE'] == "DBS5900")      echo 'Selected' ;?>>DBS3900
                        </option>
                        <option value="BTS3900A" <?php if($row['BTS_TYPE'] == "DBS3900A")    echo 'Selected' ;?>>
                            BTS3900A</option>
                        <option value="BTS3900L" <?php if($row['BTS_TYPE'] == "BTS3900L")    echo 'Selected' ;?>>
                            BTS3900L</option>
                        <option value="6102" <?php if($row['BTS_TYPE'] == "6102")         echo 'Selected' ;?>>6102
                        </option>
                        <option value="6103" <?php if($row['BTS_TYPE'] == "6103")         echo 'Selected' ;?>>6103
                        </option>
                        <option value="6150" <?php if($row['BTS_TYPE'] == "DBS3900")       echo 'Selected' ;?>>6150
                        </option>
                        <option value="6201" <?php if($row['BTS_TYPE'] == "6201")          echo 'Selected' ;?>>6201
                        </option>
                        <option value="6301" <?php if($row['BTS_TYPE'] == "6301")           echo 'Selected' ;?>>6301
                        </option>
                        <option value="6601" <?php if($row['BTS_TYPE'] == "6601")    echo 'Selected' ;?>>6601</option>
                        <option value="6102L" <?php if($row['BTS_TYPE'] == "6102L")    echo 'Selected' ;?>>6102L
                        </option>
                        <option value="6201L" <?php if($row['BTS_TYPE'] == "6201L")    echo 'Selected' ;?>>6201L
                        </option>
                        <option value="5212" <?php if($row['BTS_TYPE'] == "5212")    echo 'Selected' ;?>>5212</option>
                        <option value="5216" <?php if($row['BTS_TYPE'] == "5216")    echo 'Selected' ;?>>5216</option>
                        <option value="BB5212" <?php if($row['BTS_TYPE'] == "BB5212")    echo 'Selected' ;?>>BB5212
                        </option>
                        <option value="DUS3102" <?php if($row['BTS_TYPE'] == "DUS3102")    echo 'Selected' ;?>>DUS3102
                        </option>
                        <option value="DUS5201" <?php if($row['BTS_TYPE'] == "DUS5201")    echo 'Selected' ;?>>DUS5201
                        </option>
                        <option value="RBS6601" <?php if($row['BTS_TYPE'] == "RBS6601")    echo 'Selected' ;?>>RBS6601
                        </option>
                        <option value="RBS6102L" <?php if($row['BTS_TYPE'] == "RBS6102L")    echo 'Selected' ;?>>
                            RBS6102L</option>
                    </select>
                    </br></br>
                </div>

                <div>
                    Site Status: <select name="status">


                        <option value="Empty">--</option>
                        <option value="On Air" <?php if($row['STATUS'] == "On Air")             echo 'Selected' ;?>>On
                            Air </option>
                        <option value="On Air (Stopped)"
                            <?php if($row['STATUS'] == "On Air (Stopped)")   echo 'Selected' ;?>>On Air (Stopped)
                        </option>
                        <option value="On Air (Stopped_2)"
                            <?php if($row['STATUS'] == "On Air (Stopped_2)") echo 'Selected' ;?>>On Air (Stopped_2)
                        </option>

                    </select>
                    </br></br>
                </div>
                <div>
                    <label for="air date">4G On Air Date:</label>
                    <input type="text" name="onairdate" size="15" id="air date"
                        value="<?php echo $row['ACTIVATION_DATE']; ?>"></br></br>
                </div>

                <div>
                    <label for="rest">Restoration Date:</label>
                    <input type="text" name="restoration" size="15" id="rest"
                        value="<?php echo $row['RESTORATION_DATE']; ?>"></br></br>
                </div>

                <div>
                    <label for="lac">LAC:</label>
                    <input type="text" name="lac" size="4" id="lac" value="<?php echo $row['LAC']; ?>"></br></br>
                </div>
                <div>
                    <label for="note">Site Notes:</label>
                    <input type="text" name="snotes" size="89" id="note" value="<?php echo $row['NOTE']; ?>"></br></br>
                </div>



                <div>
                    Select Cells:</br>
                    <?php 

  
while ($row1 = oci_fetch_array($resultt , OCI_ASSOC + OCI_RETURN_NULLS)){
      
    //Get The Letter of Cell Code
    $cellcode_char  =substr($row1['CELL_CODE'],-1);
    //search in $data array to find one of this letters
    if (in_array($cellcode_char , ['A','B','C','D'])){
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
                            value="<?= $data['A']['On_Air_Date']?? '' ?>">
                        <input type="text" name="heighta" size="3" placeholder="Height"
                            value="<?= $data['A']['HEIGHT']?? '' ?>">
                        <input type="text" name="mtilta" size="3" placeholder="M_TILT"
                            value="<?= $data['A']['M_TILT']?? '' ?>">
                        <input type="text" name="etilta" size="3" placeholder="E_TILT"
                            value="<?= $data['A']['E_TILT']?? '' ?>"></br>
                        <input type="text" name="area1a" size="30" placeholder="Arabic Serving Area"
                            value="<?= $data['A']['SERVING_AREA']?? '' ?>">
                        <input type="text" name="area2a" size="30" placeholder="English Serving Area"
                            value="<?= $data['A']['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
                        <input type="text" name="cnotesa" size="100" placeholder="Note"
                            value="<?= $data['A']['NOTES']?? '' ?>">

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
                            value="<?= $data['B']['On_Air_Date']?? '' ?>">
                        <input type="text" name="heightb" size="3" placeholder="Height"
                            value="<?= $data['B']['HEIGHT']?? '' ?>">
                        <input type="text" name="mtiltb" size="3" placeholder="M_TILT"
                            value="<?= $data['B']['M_TILT']?? '' ?>">
                        <input type="text" name="etiltb" size="3" placeholder="E_TILT"
                            value="<?= $data['B']['E_TILT']?? '' ?>"></br>
                        <input type="text" name="area1b" size="30" placeholder="Arabic Serving Area"
                            value="<?= $data['B']['SERVING_AREA']?? '' ?>">
                        <input type="text" name="area2b" size="30" placeholder="English Serving Area"
                            value="<?= $data['B']['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
                        <input type="text" name="cnotesb" size="100" placeholder="Note"
                            value="<?= $data['B']['NOTES']?? '' ?>">

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
                            value="<?= $data['C']['On_Air_Date']?? '' ?>">
                        <input type="text" name="heightc" size="3" placeholder="Height"
                            value="<?= $data['C']['HEIGHT']?? '' ?>">
                        <input type="text" name="mtiltc" size="3" placeholder="M_TILT"
                            value="<?= $data['C']['M_TILT']?? '' ?>">
                        <input type="text" name="etiltc" size="3" placeholder="E_TILT"
                            value="<?= $data['C']['E_TILT']?? '' ?>"></br>
                        <input type="text" name="area1c" size="30" placeholder="Arabic Serving Area"
                            value="<?= $data['C']['SERVING_AREA']?? '' ?>">
                        <input type="text" name="area2c" size="30" placeholder="English Serving Area"
                            value="<?= $data['C']['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
                        <input type="text" name="cnotesc" size="100" placeholder="Note"
                            value="<?= $data['C']['NOTES']?? '' ?>">

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
                            value="<?= $data['D']['On_Air_Date']?? '' ?>">
                        <input type="text" name="heightd" size="3" placeholder="Height"
                            value="<?= $data['D']['HEIGHT']?? '' ?>">
                        <input type="text" name="mtiltd" size="3" placeholder="M_TILT"
                            value="<?= $data['D']['M_TILT']?? '' ?>">
                        <input type="text" name="etiltd" size="3" placeholder="E_TILT"
                            value="<?= $data['D']['E_TILT']?? '' ?>"></br>
                        <input type="text" name="area1d" size="30" placeholder="Arabic Serving Area"
                            value="<?= $data['D']['SERVING_AREA']?? '' ?>">
                        <input type="text" name="area2d" size="30" placeholder="English Serving Area"
                            value="<?= $data['D']['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
                        <input type="text" name="cnotesd" size="100" placeholder="Note"
                            value="<?= $data['D']['NOTES']?? '' ?>">

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
                            value="<?= $data['E']['On_Air_Date']?? '' ?>">
                        <input type="text" name="heighte" size="3" placeholder="Height"
                            value="<?= $data['E']['HEIGHT']?? '' ?>">
                        <input type="text" name="mtilte" size="3" placeholder="M_TILT"
                            value="<?= $data['E']['M_TILT']?? '' ?>">
                        <input type="text" name="etilte" size="3" placeholder="E_TILT"
                            value="<?= $data['E']['E_TILT']?? '' ?>"></br>
                        <input type="text" name="area1e" size="30" placeholder="Arabic Serving Area"
                            value="<?= $data['E']['SERVING_AREA']?? '' ?>">
                        <input type="text" name="area2e" size="30" placeholder="English Serving Area"
                            value="<?= $data['E']['SERVING_AREA_IN_ENGLISH']?? '' ?>"></br></br>
                        <input type="text" name="cnotese" size="100" placeholder="Note"
                            value="<?= $data['E']['Notes']?? '' ?>">

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