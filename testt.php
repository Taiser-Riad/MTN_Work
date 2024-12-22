<?php 
include "config.php";
?>
<?php
if(isset($_GET['id2']))
{
$siteid =$_GET['id2'];
$sql= "SELECT s.*,  t.* , c.* FROM new_sites s JOIN 2gsites t ON(s.ID = t.Site_ID) JOIN 2gcells c ON (t.Cell_ID = c.CID_Key)     WHERE  t.Site_ID = '$siteid'";
//$sql= "SELECT s.Site_code,  t.* FROM new_sites s JOIN 2gsites t ON(s.ID = t.Site_ID) WHERE t.Site_ID = '$siteid'";
//$sql=  "SELECT * FROM 2gsites WHERE Site_ID = '$siteid'";
$sqll= "SELECT t.* , c.* FROM  2gsites t JOIN 2gcells c ON (t.Cell_ID = c.CID_Key) WHERE t.Site_ID = '$siteid'";
$result  = mysqli_query($conn,$sql);
$row     = mysqli_fetch_assoc($result);

$resultt  = mysqli_query($conn,$sqll);
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
    
   
    while ($row1 = mysqli_fetch_assoc($resultt)){
      
        //Get The Letter of Cell Code
        $cellcode_char  =substr($row1['Cell_code'],-1);
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
    

$query = "UPDATE 2gsites SET Band = '$band',`Site_Status`='$status2G',`BTS_Type`='$BTS',`BSC`='$BSC',`2G_On_Air_Date`='$date2G',`900GSM_RBS_Type`='$RBS1',`900On_Air_Date`='$date1',`1800GSM_RBS_Type`='$RBS2',`1800On_Air_Date`='$date2',`Notes`='$snote',`Real_BSC`='$rBSC',`LAC`='$lac' WHERE Site_ID ='$sid'";
$updateresult = mysqli_query($conn,$query);

   
    // Get the letters that were checked in the form
     

      
      //if(isset($_POST['cell'])){
        $checked_letters = $_POST['cell'] ?? [];
        echo "<pre>";
      Print_r($checked_letters);
      echo "</pre>";
      //$count_letters = count($checked_letters);
        foreach ($checked_letters as $lett) {
            //for($i=0; $i< $count_letters+1 ; $i++ ){
       echo $lett;
 //echo $cellletter;
 //$cellCode2 = $sitecode.$lett;
        $cellid2    = $_POST['cellid']  ;
        $cellcode   = $_POST['cellcode'];
        $azimuth    = $_POST['azimuth'] ;
        $height     = $_POST['height']  ;
        $mtilt      = $_POST['mtilt']   ;
        $etilt      = $_POST['etilt']   ;
        $aarea      = $_POST['area1']   ;
        $earea      = $_POST['area2']   ;
        $cnote      = $_POST['cnotes']  ;
        $cname      = $_POST['cellname'];
        //$cname = "Hello";
        $BSIC       = $_POST['BSIC']     ;
        $bcch       = $_POST['BCCH']     ;
        $celldate   = $_POST['celldate'] ;
//$cellCode2 = $sitecode.$lett;

//echo "<pre>";
      //print_r($cellCode2);
      //echo "</pre>";
   echo $cellCode2;

        if(!empty( $_POST['etilt'] && !empty($_POST['mtilt']))){
            $ttilt = sprintf('%d',$_POST['mtilt'] + $_POST['etilt']);
        }
        else{ $ttilt ="-";}

        
 

       $query1="UPDATE 2gcells SET Cell_Name ='$cname',Cell_ID ='$cellid2',AZIMUTH ='$azimuth', Hieght ='$height', BSiC ='$BSIC',M_TILT ='$mtilt', E_TILT ='$etilt', BSC ='$BSC', BCCH ='$bcch', Cell_On_Air_Date ='$celldate', Note ='$cnote', serving_Area_IN_English ='$aarea', Serving_Area ='$earea' WHERE (Cell_code = '$cellCode2' AND  CID_Key = '$sid')";
       
    $result1 = mysqli_query($conn,$query1);
      
   if (!$result1){echo("Error description: " . mysqli_error($conn));
   
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
            Update 2G details Informations.</br>
            </br>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form1">
                <div>
                    <input type="hidden" name="id" value="<?php echo $siteid; ?>">
                    <input type="hidden" name="cid" value="<?php echo $row['CID_Key']; ?>">
                    <div>
                        <label for="code">Site Code:</label>
                        <input type="text" name="sitecode" size="7" id="code"
                            value="<?php echo $row['Site_code'] ?>"></br></br>

                    </div>

                </div>

                Select Band Width: </br>
                <?php
            $checked = [];
            $checked[0] =   isset($row['Band']) && $row['Band'] == "900"         ? 'checked' : '';
            $checked[1] =   isset($row['Band']) && $row['Band'] == "1800"        ? 'checked' : '';
            $checked[2] =   isset($row['Band']) && $row['Band'] == "900/1800"    ? 'checked' : '';

            ?>
                <input type="radio" id="option1" name="band" value="900" checked="<?php echo $checked[0];?>">900
                <input type="radio" id="option2" name="band" value="1800" checked="<?php echo $checked[0];?>">1800
                <input type="radio" id="option3" name="band" value="900/1800"
                    checked="<?php echo $checked[0];?>">900/1800</br></br>

                <div>
                    <label for="air date">2G On Air Date:</label>
                    <input type="text" name="onairdate" size="15" id="air date"
                        value="<?php echo $row['2G_On_Air_Date']; ?>"></br></br>
                </div>

                <div>
                    BTS Type: <select name="BTS">

                        <option value="Empty">--</option>
                        <option value="Macro" <?php if($row['BTS_Type'] == "Macro") echo 'Selected' ;?>>Macro</option>
                        <option value="Mbts" <?php if($row['BTS_Type'] == "Mbts" ) echo 'Selected' ;?>>MBTS</option>
                        <option value="Micro" <?php if($row['BTS_Type'] == "Micro") echo 'Selected' ;?>>Micro</option>
                        <option value="Grd" <?php if($row['BTS_Type'] == "Grd"  ) echo 'Selected' ;?>>GRD</option>
                        <option value="Rdu" <?php if($row['BTS_Type'] == "Rdu"  ) echo 'Selected' ;?>>RDU</option>

                    </select></br></br>
                </div>

                <div>
                    Site Status: <select name="sitestatus">

                        <option value="Empty">--</option>
                        <option value="On Air" <?php if($row['BTS_Type'] == "Macro") echo 'Selected' ;?>>On Air
                        </option>
                        <option value="On Air (Stopped)" <?php if($row['BTS_Type'] == "Mbts" ) echo 'Selected' ;?>>On
                            Air (Stopped) </option>
                        <option value="On Air (Stopped_2)" <?php if($row['BTS_Type'] == "Micro") echo 'Selected' ;?>>On
                            Air (Stopped_2)</option>
                    </select>
                    </br></br>
                </div>

                <div>
                    900 GSM RBS Type:
                    <select name="900Rbs">
                        <option value="">--</option>
                        <option value="BTS3900" <?php if($row['900GSM_RBS_Type'] == "BTS3900") echo 'Selected' ;?>>
                            BTS3900</option>
                        <option value="DBS3900" <?php if($row['900GSM_RBS_Type'] == "DBS3900") echo 'Selected' ;?>>
                            DBS3900</option>
                        <option value="DBS5900" <?php if($row['900GSM_RBS_Type'] == "DBS5900") echo 'Selected' ;?>>
                            DBS5900</option>
                        <option value="BTS3900A" <?php if($row['900GSM_RBS_Type'] == "BTS3900A")echo 'Selected' ;?>>
                            BTS3900A</option>
                        <option value="BTS3900L" <?php if($row['900GSM_RBS_Type'] == "BTS3900L")echo 'Selected' ;?>>
                            BTS3900L</option>
                        <option value="6102" <?php if($row['900GSM_RBS_Type'] == "6102")    echo 'Selected' ;?>>6102
                        </option>
                        <option value="6130" <?php if($row['900GSM_RBS_Type'] == "6130")    echo 'Selected' ;?>>6130
                        </option>
                        <option value="6150" <?php if($row['900GSM_RBS_Type'] == "6150")    echo 'Selected' ;?>>6150
                        </option>
                        <option value="6201" <?php if($row['900GSM_RBS_Type'] == "6201")    echo 'Selected' ;?>>6201
                        </option>
                        <option value="6301" <?php if($row['900GSM_RBS_Type'] == "6301")    echo 'Selected' ;?>>6301
                        </option>
                        <option value="2109" <?php if($row['900GSM_RBS_Type'] == "2109")    echo 'Selected' ;?>>2109
                        </option>
                        <option value="2111" <?php if($row['900GSM_RBS_Type'] == "2111")    echo 'Selected' ;?>>2111
                        </option>
                        <option value="2116" <?php if($row['900GSM_RBS_Type'] == "2116")    echo 'Selected' ;?>>2116
                        </option>
                        <option value="2206" <?php if($row['900GSM_RBS_Type'] == "2206")    echo 'Selected' ;?>>2206
                        </option>
                        <option value="2216" <?php if($row['900GSM_RBS_Type'] == "2216")    echo 'Selected' ;?>>2216
                        </option>
                        <option value="2302" <?php if($row['900GSM_RBS_Type'] == "2302")    echo 'Selected' ;?>>2302
                        </option>
                        <option value="2308" <?php if($row['900GSM_RBS_Type'] == "2308")    echo 'Selected' ;?>>2308
                        </option>

                    </select>
                    </br></br>

                    <label for="air date1">900 On Air Date:</label>
                    <input type="text" name="900onairdate" size="15" id="air date1"
                        value="<?php echo $row['900On_Air_Date']; ?>"></br></br>
                </div>

                <div>
                    1800 GSM RBS Type:
                    <select name="1800Rbs">

                        <option value="">--</option>
                        <option value="BTS3900" <?php if($row['900GSM_RBS_Type']  == "BTS3900") echo 'Selected' ;?>>
                            BTS3900</option>
                        <option value="DBS3900" <?php if($row['1800GSM_RBS_Type'] == "DBS3900") echo 'Selected' ;?>>
                            DBS3900</option>
                        <option value="DBS5900" <?php if($row['1800GSM_RBS_Type'] == "DBS5900") echo 'Selected' ;?>>
                            DBS5900</option>
                        <option value="BTS3900A" <?php if($row['1800GSM_RBS_Type'] == "BTS3900A")echo 'Selected' ;?>>
                            BTS3900A</option>
                        <option value="BTS3900L" <?php if($row['1800GSM_RBS_Type'] == "BTS3900L")echo 'Selected' ;?>>
                            BTS3900L</option>
                        <option value="6102" <?php if($row['1800GSM_RBS_Type'] == "6102")    echo 'Selected' ;?>>6102
                        </option>
                        <option value="6130" <?php if($row['1800GSM_RBS_Type'] == "6130")    echo 'Selected' ;?>>6130
                        </option>
                        <option value="6150" <?php if($row['1800GSM_RBS_Type'] == "6150")    echo 'Selected' ;?>>6150
                        </option>
                        <option value="6201" <?php if($row['1800GSM_RBS_Type'] == "6201")    echo 'Selected' ;?>>6201
                        </option>
                        <option value="6301" <?php if($row['1800GSM_RBS_Type'] == "6301")    echo 'Selected' ;?>>6301
                        </option>
                        <option value="2109" <?php if($row['1800GSM_RBS_Type'] == "2109")    echo 'Selected' ;?>>2109
                        </option>
                        <option value="2111" <?php if($row['1800GSM_RBS_Type'] == "2111")    echo 'Selected' ;?>>2111
                        </option>
                        <option value="2116" <?php if($row['1800GSM_RBS_Type'] == "2116")    echo 'Selected' ;?>>2116
                        </option>
                        <option value="2206" <?php if($row['1800GSM_RBS_Type'] == "2206")    echo 'Selected' ;?>>2206
                        </option>
                        <option value="2216" <?php if($row['1800GSM_RBS_Type'] == "2216")    echo 'Selected' ;?>>2216
                        </option>
                        <option value="2302" <?php if($row['1800GSM_RBS_Type'] == "2302")    echo 'Selected' ;?>>2302
                        </option>
                        <option value="2308" <?php if($row['1800GSM_RBS_Type'] == "2308")    echo 'Selected' ;?>>2308
                        </option>

                    </select>
                    </br></br>

                    <label for="air date2">1800 On Air Date:</label>
                    <input type="text" name="1800onairdate" size="15" id="air date2"
                        value="<?php echo $row['1800On_Air_Date']; ?>"></br></br>
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
                        value="<?php echo $row['Real_BSC']; ?>"></br></br>
                </div>
                <div>
                    <label for="lac">LAC:</label>
                    <input type="text" name="lac" size="4" id="lac" value="<?php echo $row['LAC']; ?>"></br></br>
                </div>
                <div>
                    <label for="note1">Site Notes:</label>
                    <input type="text" name="snotes" size="75" id="note1"
                        value="<?php echo $row['Notes']; ?>"></br></br>
                </div>

                Select Cells:</br>
                <?php 
foreach (['A','B','C','X','Y','Z','D','W','V','E'] as $letter) : ?>


                <div>


                    </br>
                    <input type="checkbox" name="cell[]" value="<?= $letter ?>"
                        <?php if ( $data[$letter]) echo 'checked'; ?>><?= $letter ?>

                    <input type="text" name="cellid" size="4" placeholder="Cell ID"
                        value="<?= $data[$letter]['Cell_ID']?? '' //echo cell_id and if it is null echo ''?>">
                    <input type="text" name="cellcode" size="5" placeholder="Cell Code"
                        value="<?= $data[$letter]['Cell_code']?? 'empty' ?>">
                    <input type="text" name="cellname" size="15" placeholder="Cell Name"
                        value="<?= $data[$letter]['Cell_Name']?? 'woow' ?>">
                    <input type="text" name="azimuth" size="3" placeholder="Azimuth"
                        value="<?= $data[$letter]['AZIMUTH']?? '' ?>">
                    <input type="text" name="celldate" size="6" placeholder="On Air Date"
                        value="<?= $data[$letter]['Cell_On_Air_Date']?? '' ?>">
                    <input type="text" name="height" size="3" placeholder="Height"
                        value="<?= $data[$letter]['Hieght']?? '' ?>">
                    <input type="text" name="BSIC" size="3" placeholder="BSIC"
                        value="<?= $data[$letter]['BSiC']?? '' ?>">
                    <input type="text" name="BCCH" size="3" placeholder="BCCH"
                        value="<?= $data[$letter]['BCCH']?? '' ?>">
                    <input type="text" name="mtilt" size="3" placeholder="M_TILT"
                        value="<?= $data[$letter]['M_TILT']?? '' ?>">
                    <input type="text" name="etilt" size="3" placeholder="E_TILT"
                        value="<?= $data[$letter]['E_TILT']?? '' ?>"></br>
                    <input type="text" name="area1" size="20" placeholder="Arabic Serving Area"
                        value="<?= $data[$letter]['Serving_Area']?? '' ?>">
                    <input type="text" name="area2" size="20" placeholder="English Serving Area"
                        value="<?= $data[$letter]['serving_Area_IN_English']?? '' ?>"></br></br>
                    <input type="text" name="cnotes" size="75" placeholder="Note"
                        value="<?= $data[$letter]['Note']?? '' ?>">

                </div>
                <?php endforeach; ?>

            </div>
            <div class="footer">


                <div class="type">
                    <label>Select Next Page:</br></label></br>
                    <label for="3g"></label>
                    <input type="radio" id="3g" name="SiteType" value="3G">Update 3G Site Info.
                    <label for="4g"></label>
                    <input type="radio" id="4g" name="SiteType" value="4G">Update 4G Site Info.
                    <label for="addsite"></label>
                    <input type="radio" id="addsite" name="SiteType" value="addsite">Go back to Search Page.
                </div>
                <div class="submit">

                    <input type="submit" name="submit" value="Update">
                </div>
                <div style="clear:both;"></div>


            </div>

        </form>
    </div>


</body>

</html>