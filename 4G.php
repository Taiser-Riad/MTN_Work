<?php 
        include "config.php";
        ?>
        <?php
        if(isset($_GET['id3']))
        {
        $siteid =$_GET['id3'];
        $sqll= "SELECT * FROM NEW_SITES WHERE ID= :siteid";
        $result = oci_parse($conn, $sqll);
        oci_bind_by_name($result, ':siteid', $siteid);
        oci_execute($result);
        $row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS);
        //echo $row['SITE_CODE'];
        $newcode = $row['SITE_CODE']."A";
        $newcode3 = $row['SITE_CODE']."B";
        $newcode4 = $row['SITE_CODE']."C";
        $newcode5 = $row['SITE_CODE']."D";

        $sqll2 = "SELECT * FROM TWO_G_CELLS WHERE CELL_CODE = :newcode";
        $result2 = oci_parse($conn,$sqll2);
        oci_bind_by_name($result2, ':newcode', $newcode);
        oci_execute($result2);
        $num_rows = oci_num_rows($result2);
        if($result2 !== false){

            $row2 = oci_fetch_array($result2 , OCI_ASSOC+OCI_RETURN_NULLS);
            if($row2 != false){
            $azimuth1 = $row2['AZIMUTH'] ?? '' ;
            $height1 = $row2['HIEGHT'] ?? '';
            $mtilt1 = $row2['M_TILT'] ?? '';
            $etilt1 = $row2['E_TILT'] ?? '';
            $earea1 = $row2['SERVING_AREA_IN_ENGLISH'] ?? '';
            $aarea1 = $row2['SERVING_AREA'] ?? '';
            }
        }
            $sqll3 = "SELECT * FROM TWO_G_CELLS WHERE CELL_CODE = :newcode3";
            $result3 = oci_parse($conn,$sqll3);
            oci_bind_by_name($result3, ':newcode3', $newcode3);
            oci_execute($result3);
            //$num_rows1 = oci_num_rows($result3);
            
            
            if($result3 !== false){
                $row3 = oci_fetch_array($result3 , OCI_ASSOC+OCI_RETURN_NULLS);
                if($row3 !== false){
                $azimuth2 = $row3['AZIMUTH'] ?? '';
                $height2 = $row3['HIEGHT'] ?? '';
                $mtilt2 = $row3['M_TILT'] ?? '';
                $etilt2 = $row3['E_TILT'] ?? '';
                $earea2 = $row3['SERVING_AREA_IN_ENGLISH'] ?? '';
                $aarea2 = $row3['SERVING_AREA'] ?? '';
            }
            }
            $sqll4 = "SELECT * FROM TWO_G_CELLS WHERE CELL_CODE = :newcode4";
            $result4 = oci_parse($conn,$sqll4);
            oci_bind_by_name($result4, ':newcode4', $newcode4);
            oci_execute($result4);
            //$num_rows4 = oci_num_rows($result4);

            if($result4 !== false){
                $row4 = oci_fetch_array($result4 , OCI_ASSOC+OCI_RETURN_NULLS);
                if($row4 !== false){
                $azimuth3 = $row4['AZIMUTH'] ?? '';
                $height3 = $row4['HIEGHT'] ?? '';
                $mtilt3 = $row4['M_TILT'] ?? '';
                $etilt3 = $row4['E_TILT'] ?? '';
                $earea3 = $row4['SERVING_AREA_IN_ENGLISH'] ?? '';
                $aarea3 = $row4['SERVING_AREA'] ?? '';
            }
        }
            $sqll5 = "SELECT * FROM TWO_G_CELLS WHERE CELL_CODE = :newcode5";
            $result5 = oci_parse($conn,$sqll5);
            oci_bind_by_name($result5, ':newcode5', $newcode5);
            oci_execute($result5);
            $num_rows5 = oci_num_rows($result5);

            if($result5 !== false){
                $row5 = oci_fetch_array($result5 , OCI_ASSOC+OCI_RETURN_NULLS);
                if($row5 !== false){
                $azimuth4 = $row5['AZIMUTH'] ?? '';
                $height4 = $row5['HIEGHT'] ?? '';
                $mtilt4 = $row5['M_TILT'] ?? '';
                $etilt4 = $row5['E_TILT'] ?? '';
                $earea4 = $row5['SERVING_AREA_IN_ENGLISH'] ?? '';
                $aarea4 = $row5['SERVING_AREA'] ?? '';
            }
            
        } 

        }


        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $sid= $_POST ['id'] ?? '';
            $sitecode = $_POST['sitecode'].'L';
            $sitename = $_POST['sitename'] ?? '';
            //$nodeb = $_POST['nodeb'] ?? '';
            $BTS = $_POST['BTS'] ?? '';
            $status = "On Air";
            $date4G = $_POST['onairdate'] ?? '';
            $restordate = $_POST['restoration'] ?? '';
            $lac = $_POST['lac'] ?? '';
            $snote = $_POST['snotes'] ?? '';
       
            $site_type = $_POST['SiteType'] ?? '';
            $sitecode1 = $_POST['sitecode'];
            $code1 = substr($sitecode1,0,3)?? '';
            $code2 = substr($sitecode1,-3)?? '';

     
            
    $dateTime = new DateTime($date4G);
    $date4G  = $dateTime->format('m/d/Y');

    $dateTime1 = new DateTime($restordate);
    $restordate = $dateTime1->format('m/d/Y');


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
          
          
       
           
          
         


            $sql = "INSERT INTO  FOUR_G_SITES (SID, CELL_ID_KEY, SITE_CODE ,ENODEB_ID, BTS_TYPE, LAC, STATUS, ACTIVATION_DATE, NOTE, RESTORATION_DATE) 
            VALUES (:sd,FOUR_G_SITES_SEQ.NEXTVAL , :sitecode, :enodeb, :bts, :lac, :statu, :date4G, :snote, :restordate)
            RETURNING CELL_ID_KEY INTO :last_id";
            $insert_stmt =oci_parse($conn,$sql);
        

            oci_bind_by_name($insert_stmt, ':sd'      , $sid);
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
                        $cellname = $sitename.'-'.$selected;
                        echo $cellcode."</br>";
                    
                        if($selected == 'A'){
                            $newcellid = $nodeb.'1';
                            $azimuth = $_POST['azimutha'] ?? '';
                            $height = $_POST['heighta'] ?? '';
                            $mtilt = $_POST['mtilta'] ?? '';
                            $etilt = $_POST['etilta'] ?? '';
                            $earea = $_POST['area1a'] ?? '';
                            $aarea = $_POST['area2a'] ?? '';
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
                            $earea = $_POST['area1b'] ?? '';
                            $aarea = $_POST['area2b'] ?? '';
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
                            $earea = $_POST['area1C'] ?? '';
                            $aarea = $_POST['area2C'] ?? '';
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
                            $earea = $_POST['area1d'] ?? '';
                            $aarea = $_POST['area2d'] ?? '';
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
                            $earea = $_POST['area1e'] ?? '';
                            $aarea = $_POST['area2e'] ?? '';
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

            if($site_type == 'addsite'){
                header("location:Add Site.php");
            }



        }

        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href= "fontawesome-free-6.5.2-web\css\all.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> 4G Site page </title>

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

        .submit1{
            width: 20%;
            
        float:left; 
        display: flex;
        
        
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
        function openNewTab(url) {
            window.open(url, '_blank'); // Open the passed URL in a new tab
        }
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
                    <h1></br> 4G Site Informations </h1>
                    Fill  <?php echo $row['SITE_CODE']."L"?>  Informations.</br>
                    </br>
            </div>
        <form id ="myForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit= "return validateForm();">
        <div class="form1">
        <div>
        <input type ="hidden" name ="id" value="<?php echo $siteid; ?>">
        <input type ="hidden" name ="sitecode" value="<?php echo $row['SITE_CODE']; ?>">
        <input type ="hidden" name ="sitename" value="<?php echo $row['SITE_NAME']; ?>">
        </div>
    
        <div>
            BTS Type:   <select name="BTS" required>    
            <option value="">--</option>     
                <option value="BTS5900">BTS5900</option> 
                <option value="DBS3900">DBS3900</option>
                <option value="DBS5900">DBS5900</option>
                <option value="BTS3900A">BTS3900A</option>
                <option value="BTS3900L">BTS3900L</option>
                <option value="6102">6102</option>
                <option value="6103">6103</option>
                <option value="6150">6150</option>
                <option value="6201">6201</option>
                <option value="6301">6301</option>
                <option value="6601">6601</option>
                <option value="6102L">6102L</option>
                <option value="6201L">6201L</option>
                <option value="5212">5212</option>
                <option value="5216">5216</option>
                <option value="BB5212">BB5212</option>
                <option value="DUS3102">DUS3102</option>
                <option value="DUS5201">DUS5201</option>
                <option value="RBS6601">RBS6601</option>
                <option value="RBS6102L">RBS6102L</option>
            </select>
            </br></br>
        </div>
        
        <div>
            <label for="air date" required>4G On Air Date:</label>
            <input type ="date" name="onairdate" size="15" id="air date"></br></br>
        </div>

        <div>
            <label for="rest">Restoration Date:</label>
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
            <input type ="text" name="azimutha" size="5" placeholder ="Azimuth"              value = "<?php echo $row2 !== false  ? $azimuth1: ''; ?>">
            <input type ="text" name="heighta" size="5"  placeholder ="Height"               value = "<?php echo $row2 !== false  ? $height1: ''; ?>">
            <input type ="text" name="mtilta" size="5"   placeholder ="M_TILT"               value = "<?php echo $row2 !== false  ? $mtilt1: ''; ?>">
            <input type ="text" name="etilta" size="5"   placeholder ="E_TILT"               value = "<?php echo $row2 !== false  ? $etilt1: ''; ?>">
            <input type ="text" name="area1a" size="15"  placeholder ="Arabic Serving Area"  value = "<?php echo $row2 !== false  ? $earea1: ''; ?>">
            <input type ="text" name="area2a" size="15"  placeholder ="English Serving Area" value = "<?php echo $row2 !== false  ? $aarea1: ''; ?>"></br>
            <input type ="text" name="cnotea" size="90"  placeholder="Cell Note">

        </div>

        <div>
        </br>
            <input type = "checkbox" name="cell[]" value="B">B
            <input type ="text" name="azimuthb" size="5" placeholder ="Azimuth"               value = "<?php echo $row3 !== false ? $azimuth2: '' ?>">
            <input type ="text" name="heightb"  size="5" placeholder ="Height"                value = "<?php echo $row3 !== false ? $height2: '' ?>">
            <input type ="text" name="mtiltb"   size="5" placeholder ="M_TILT"                value = "<?php echo $row3 !== false ? $mtilt2: '' ?>">
            <input type ="text" name="etiltb"   size="5" placeholder ="E_TILT"                value = "<?php echo $row3 !== false ? $etilt2: '' ?>">
            <input type ="text" name="area1b"   size="15" placeholder ="Arabic Serving Area"  value = "<?php echo $row3 !== false ? $earea2: '' ?>">
            <input type ="text" name="area2b"   size="15" placeholder ="English Serving Area" value = "<?php echo $row3 !== false ? $aarea2: '' ?>"></br>
            <input type ="text" name="cnoteb" size="90"  placeholder="Cell Note">

        </div>
        <div>
        </br>
            <input type = "checkbox" name="cell[]" value="C">C
            <input type ="text" name="azimuthC" size="5" placeholder ="Azimuth"              value = "<?php echo $row4 !== false ? $azimuth3: '' ?>">
            <input type ="text" name="heightC"  size="5"  placeholder ="Height"              value = "<?php echo $row4 !== false ? $height3: '' ?>">
            <input type ="text" name="mtiltC" size="5"   placeholder ="M_TILT"               value = "<?php echo $row4 !== false ? $mtilt3: '' ?>">
            <input type ="text" name="etiltC" size="5"   placeholder  ="E_TILT"              value = "<?php echo $row4 !== false ? $etilt3: '' ?>">
            <input type ="text" name="area1C" size="15"  placeholder ="Arabic Serving Area"  value = "<?php echo $row4 !== false ? $earea3: '' ?>">
            <input type ="text" name="area2C" size="15"  placeholder ="English Serving Area" value = "<?php echo $row4 !== false ? $aarea3: '' ?>"></br>
            <input type ="text" name="cnoteC" size="90"  placeholder="Cell Note">
        </div>
        <div>
        </br>
            <input type = "checkbox" name="cell[]" value="D">D
            <input type ="text" name="azimuthd" size="5" placeholder ="Azimuth"              value = "<?php echo $row5 !== false ? $azimuth4: '' ?>">
            <input type ="text" name="heightd" size="5"  placeholder ="Height"               value = "<?php echo $row5 !== false ? $height4: '' ?>">
            <input type ="text" name="mtiltd" size="5"   placeholder ="M_TILT"               value = "<?php echo $row5 !== false ? $mtilt4: '' ?>">
            <input type ="text" name="etiltd" size="5"   placeholder ="E_TILT"               value = "<?php echo $row5 !== false ? $etilt4: '' ?>">
            <input type ="text" name="area1d" size="15"  placeholder ="Arabic Serving Area"  value = "<?php echo $row5 !== false ? $earea4: '' ?>">
            <input type ="text" name="area2d" size="15"  placeholder ="English Serving Area" value = "<?php echo $row5 !== false ? $aarea4: '' ?>"></br>
            <input type ="text" name="cnoted" size="90"  placeholder="Cell Note">

        </div>
        </div>

        </div>
      

        <div class="footer">
        <div class="type">
            <label></br></label></br>
        


            
        </div>

     
        <div class ="submit">
        <input type="submit" name="submit" value = "Done" onclick="confirmAndClose();">
</div>
        <div style="clear:both;"></div>
        </div>
        </form>
        <a href="update2G.php?id2=<?php echo $siteid; ?>" class="fixed-button" target="_blank">Edit 2G Info</a>
        <a href="update3G.php?id3=<?php echo $siteid; ?>" class="fixed-button2" target="_blank">Edit 3G Info</a>
        <a href="update_basic_info.php?id=<?php echo $siteid; ?>" class="fixed-button3" target="_blank">Edit Basic Info</a>
        </div>
        </body>
        </html>
        <script>
function confirmAndClose() {
    if (window.confirm('Are you sure you want to add 4G?')) {
        document.getElementById('myForm').submit();
        setTimeout(() => {
            window.close();
        }, 10); // Delay to ensure form submission completes
    }
}
</script>