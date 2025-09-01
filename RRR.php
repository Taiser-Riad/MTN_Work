<?php
include "config.php";
if(isset($_GET['id'])) {
    $siteid = $_GET['id'];
    $sqll = "SELECT * FROM NEW_SITES WHERE ID= :siteid";
    $result = oci_parse($conn, $sqll);
    oci_bind_by_name($result, ':siteid', $siteid);
    oci_execute($result);
    $row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS);

    $sitecode = $row['SITE_CODE'];
    $check_sql = "SELECT * FROM POWER_BACKUP WHERE SITE_CODE = :sitecode";
    $check_stmt = oci_parse($conn, $check_sql);
    oci_bind_by_name($check_stmt, ':sitecode', $sitecode);
    oci_execute($check_stmt);
}


if($_SERVER["REQUEST_METHOD"] == "POST")
{

    $Gen         = $_POST['Gen'] ?? '';
    $gen_brand   = $_POST['gen_brand'] ?? '';
    $engine_brand = $_POST['engine_brand'] ?? '';
    $status      = $_POST['status'] ?? '';
    $ownership   = $_POST['ownership'] ?? '';
    $capacity    = $_POST['capacity'] ?? '';
    $qty         = $_POST ['qty'] ?? '';
    $cage        = $_POST['cage'] ?? '';
    $currentstatus = $_POST['currentstatus'] ?? '';
    $warehouse   = $_POST['warehouse'] ?? '';
    $warehouse_code =  $_POST['warehouse_sitecode'] ?? '';


    // if(!empty($_POST['warehouse']) && isset($_POST['warehouse'])){
    //     echo"in";
    // $select_warehouse = "SELECT * FROM WAREHOUSE_GENERATOR WHERE OLD_SITE_CODE =:sitecode";
    // $warehouse_stmt = oci_parse($conn,$select_warehouse);
    // oci_bind_by_name($warehouse_stmt, ':sitecode' ,$warehouse_code);
    // if(oci_execute($warehouse_stmt)){
    //     if ($row1 = oci_fetch_array($warehouse_stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
    //         echo"fetch";
    //        $warehouse_pid = $row1['PID'];
    //        $warehouse_gid = $row1['GID'];
    //        echo $warehouse_pid;
    //        echo $warehouse_gid;
        
    //     //}
    
    
    //     $sqlgen = "UPDATE GENERTAOR 
    //     SET PID = :pid, 
    //         SITE_CODE= :sitecode 
    //         WHERE GID = :gid";
    
    // $update_gen = oci_parse($conn, $sqlgen);
    
    // // Bind the parameters
    // oci_bind_by_name($update_gen, ':pid', $warehouse_pid);
    // oci_bind_by_name($update_gen, ':sitecode', $warehouse_code);
    // oci_bind_by_name($update_gen, ':gid', $warehouse_gid);
    
    // oci_execute($update_gen);
    // echo"update";
    
    // $delete_warehouse = "DELETE FROM WAREHOUSE_GENERATOR WHERE GID =:gid";
    // $delete_stmtt = oci_parse($conn, $delete_warehouse);
    // oci_bind_by_name($delete_stmtt, ':gid', $warehouse_gid);
    // oci_execute($delete_stmtt);
    
    // }
    // }
    // }\





    
if (!empty($_POST['Gen']) && isset($_POST['Gen'])) {

    $sqlgen = "INSERT INTO GENERTAOR (PID , GID , SITE_CODE, BRAND, ENGINE_BRAND, INITIAL_STATUS, QUANTITY, OWNERSHIP, CAGE, CAPACITY ,CURRENT_STATUS) 
    VALUES (:pid ,GENERATOR_SEQ.NEXTVAL, :sitecode, :brand, :engbrand, :status1, :qty, :owner1 ,:cage, :cap, :curr) RETURNING GID INTO :gid";

$insert_gen = oci_parse($conn,$sqlgen);
oci_bind_by_name($insert_gen, ':pid'      ,$PID);
oci_bind_by_name($insert_gen, ':sitecode' ,$sitecode);
oci_bind_by_name($insert_gen, ':brand'    ,$gen_brand);
oci_bind_by_name($insert_gen, ':engbrand' ,$engine_brand);
oci_bind_by_name($insert_gen, ':status1'  ,$status);
oci_bind_by_name($insert_gen, ':qty'     ,$qty);
oci_bind_by_name($insert_gen, ':owner1'   ,$ownership);
oci_bind_by_name($insert_gen, ':cage'    ,$cage);
oci_bind_by_name($insert_gen, ':cap'    ,$capacity);
oci_bind_by_name($insert_gen, ':curr'    ,$currentstatus);
oci_bind_by_name($insert_gen, ':gid' ,$GID, -1, SQLT_INT);


if (oci_execute($insert_gen)) {  

    $sql_insert = "INSERT INTO GENERTAOR_AUDIT (
        DETAIL_ID,
        USER_ID,
        SITE_CODE,
        NEW_BRAND,
        NEW_ENGINE_BRAND,
        NEW_CAPACITY,
        NEW_INITIAL_STATUS,
        NEW_QUANTITY,
        NEW_OWNERSHIP,
        NEW_CAGE,
        ADDED_BY,
        ADDED_AT,
        NEW_CURRENT_STATUS
       
    ) VALUES (
        GENERATOR_SEQ.NEXTVAL,
        :user_id,
        :site_code,
        :new_brand,
        :new_engine_brand,
        :new_capacity,
        :new_initial_status,
        :new_quantity,
        :new_ownership,
        :new_cage,
        :changed_by,
        SYSDATE,
        :new_curr
          )RETURNING DETAIL_ID INTO :last_detail_id";
    
    $insert_stmt = oci_parse($conn, $sql_insert);
    
    // Bind variables
    oci_bind_by_name($insert_stmt, ':last_detail_id', $DETAIL_ID, -1, SQLT_INT);
    oci_bind_by_name($insert_stmt, ':user_id', $user_id1);
    oci_bind_by_name($insert_stmt, ':site_code', $sitecode);
    oci_bind_by_name($insert_stmt, ':new_brand', $gen_brand);
    oci_bind_by_name($insert_stmt, ':new_engine_brand', $engine_brand);
    oci_bind_by_name($insert_stmt, ':new_capacity', $capacity);
    oci_bind_by_name($insert_stmt, ':new_initial_status', $new_initial_status);
    oci_bind_by_name($insert_stmt, ':new_quantity', $qty);
    oci_bind_by_name($insert_stmt, ':new_ownership', $ownership);
    oci_bind_by_name($insert_stmt, ':new_cage', $cage);
    oci_bind_by_name($insert_stmt, ':new_curr', $currentstatus);
    oci_bind_by_name($insert_stmt, ':changed_by', $username1);
 
    
    // Execute the statement
    if (oci_execute($insert_stmt)) {
        //echo "Record inserted successfully.";
    } else {
        $e = oci_error($insert_stmt); // For detailed error
        echo "Error inserting record: " . $e['message'];
    }
    




 } 
   else { 
    $e = oci_error($insert_gen); echo "Error Updating Data: " . htmlentities($e['message']);
 

   }




if (!empty($_POST['tank1']) && isset($_POST['tank1'])) {

    $sqltank1 = "INSERT INTO TANK (GID, TANK_SHAPE, TANK_TYPE, TANK_ACTUAL_VOLUME, TANK_HEIGHT, TANK_WIDTH, TANK_LENGTH, TANK_MAXIMUM ,TANK_INDEX) 
    VALUES (:gid , :shape, :type, :volume, :height, :width, :length ,:maximum,:indexx)";

    $insert_tank1 = oci_parse($conn, $sqltank1);
    oci_bind_by_name($insert_tank1, ':gid'      ,$GID);
    oci_bind_by_name($insert_tank1, ':shape'    ,$t1shape);
    oci_bind_by_name($insert_tank1, ':type'     ,$t1type);
    oci_bind_by_name($insert_tank1, ':volume'   ,$t1volume);
    oci_bind_by_name($insert_tank1, ':height'   ,$t1height);
    oci_bind_by_name($insert_tank1, ':width'    ,$t1width);
    oci_bind_by_name($insert_tank1, ':length'   ,$t1length);
    oci_bind_by_name($insert_tank1, ':maximum'  ,$t1max);
    oci_bind_by_name($insert_tank1, ':indexx'  ,$tank1);


if(oci_execute($insert_tank1)){

}
else{
    $e = oci_error($insert_tank1); echo "Error Updating Data: " . htmlentities($e['message']);
}
    
}


if (!empty($_POST['tank1']) && !empty($_POST['tank2']) && isset($_POST['tank2'])) {

   $sqltank2 = "INSERT INTO TANK (GID, TANK_SHAPE, TANK_TYPE, TANK_ACTUAL_VOLUME, TANK_HEIGHT, TANK_WIDTH, TANK_LENGTH, TANK_MAXIMUM ,TANK_INDEX) 
    VALUES (:gid , :shape, :type, :volume, :height, :width, :length ,:maximum,:indexx)";

    $insert_tank2 = oci_parse($conn, $sqltank2);
    oci_bind_by_name($insert_tank2, ':gid'      ,$GID);
    oci_bind_by_name($insert_tank2, ':shape'    ,$t2shape);
    oci_bind_by_name($insert_tank2, ':type'     ,$t2type);
    oci_bind_by_name($insert_tank2, ':volume'   ,$t2volume);
    oci_bind_by_name($insert_tank2, ':height'   ,$t2height);
    oci_bind_by_name($insert_tank2, ':width'    ,$t2width);
    oci_bind_by_name($insert_tank2, ':length'   ,$t2length);
    oci_bind_by_name($insert_tank2, ':maximum'  ,$t2max);
    oci_bind_by_name($insert_tank2, ':indexx'  ,$tank2);
    





if(oci_execute($insert_tank2)){

}
else{
    $e = oci_error($insert_tank2); echo "Error Updating Data: " . htmlentities($e['message']);
}
    
}
elseif(empty($_POST['tank1']) && !empty($_POST['tank2']) && isset($_POST['tank2'])){
    echo '<script>alert("Insert TANK1 before inserting TANK2")</script>';
    
}

if (!empty($_POST['tank1']) && !empty($_POST['tank2']) && !empty($_POST['tank3']) && isset($_POST['tank3'])) {



    $sqltank3 = "INSERT INTO TANK (GID, TANK_SHAPE, TANK_TYPE, TANK_ACTUAL_VOLUME, TANK_HEIGHT, TANK_WIDTH, TANK_LENGTH, TANK_MAXIMUM ,TANK_INDEX) 
    VALUES (:gid , :shape, :type, :volume, :height, :width, :length ,:maximum,:indexx)";

    $insert_tank3 = oci_parse($conn, $sqltank3);
    oci_bind_by_name($insert_tank3, ':gid'      ,$GID);
    oci_bind_by_name($insert_tank3, ':shape'    ,$t3shape);
    oci_bind_by_name($insert_tank3, ':type'     ,$t3type);
    oci_bind_by_name($insert_tank3, ':volume'   ,$t3volume);
    oci_bind_by_name($insert_tank3, ':height'   ,$t3height);
    oci_bind_by_name($insert_tank3, ':width'    ,$t3width);
    oci_bind_by_name($insert_tank3, ':length'   ,$t3length);
    oci_bind_by_name($insert_tank3, ':maximum'  ,$t3max);
    oci_bind_by_name($insert_tank3, ':indexx'  ,$tank3);
    


    

if(oci_execute($insert_tank3)){

}
else{
    $e = oci_error($insert_tank3); echo "Error Updating Data: " . htmlentities($e['message']);
}
    
}
elseif((empty($_POST['tank1']) || empty($_POST['tank2'])) && !empty($_POST['tank3']) && isset($_POST['tank3'])){
    echo '<script>alert("Insert TANK1 & TANK2 before inserting TANK1")</script>';
}



}



elseif(!empty($_POST['warehouse']) && isset($_POST['warehouse'])){
    $warehouse   = $_POST['warehouse'] ?? '';
    $warehouse_code =  $_POST['warehouse_sitecode'] ?? '';
    echo"in warehouse";
    echo  $warehouse;
    echo $warehouse_code;
$select_warehouse = "SELECT * FROM WAREHOUSE_GENERATOR WHERE OLD_SITE_CODE =:sitecode";
$warehouse_stmt = oci_parse($conn,$select_warehouse);
oci_bind_by_name($warehouse_stmt, ':sitecode' ,$warehouse_code);
if(oci_execute($warehouse_stmt)){
    if ($row1 = oci_fetch_array($warehouse_stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
        echo"fetch";
       $warehouse_pid = $row1['PID'];
       $warehouse_gid = $row1['GID'];
       echo $warehouse_pid;
       echo $warehouse_gid;
    
    //}


    $sqlgen = "UPDATE GENERTAOR 
    SET PID = :pid, 
        SITE_CODE= :sitecode 
        WHERE GID = :gid";

$update_gen = oci_parse($conn, $sqlgen);

// Bind the parameters
oci_bind_by_name($update_gen, ':pid', $warehouse_pid);
oci_bind_by_name($update_gen, ':sitecode', $warehouse_code);
oci_bind_by_name($update_gen, ':gid', $warehouse_gid);

oci_execute($update_gen);
echo"update";

$delete_warehouse = "DELETE FROM WAREHOUSE_GENERATOR WHERE GID =:gid";
$delete_stmtt = oci_parse($conn, $delete_warehouse);
oci_bind_by_name($delete_stmtt, ':gid', $warehouse_gid);
oci_execute($delete_stmtt);

}
}
}



}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Backup Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
</head>

<body>


    <!-- Modal will be shown by default -->
    <div class="modal active" id="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><?php echo isset($sitecode) ? $sitecode : 'Site Information'; ?></h2>
                
            </div>
            <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          
<!-- 
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="generator_warehouse" name="warehouse" value="1">
                                        <label for="generator_warehouse">Generator from WareHouse</label>
                                        <div class="sub-options" id="generatorOptions">
                                            <div class="form-group">
                                                <label for="warehouse_code"><i class="fas fa-industry"></i> Site Code</label>
                                                <input type="text" id="warehouse_code" name="warehouse_sitecode">
                                            </div>
                                        </div>
                                    </div>  -->


<?php

                                    $sql_gen = "SELECT * FROM GENERTAOR WHERE SITE_CODE=:sitecode";
$select_gen = oci_parse($conn, $sql_gen);
oci_bind_by_name($select_gen, ':sitecode', $orginal_sitecode);
$execute_result2 = oci_execute($select_gen);

if (!$execute_result2) {
  $e = oci_error($select_gen);
  echo "Error executing query: " . htmlentities($e['message']);
} else {
  $row_gen = oci_fetch_array($select_gen, OCI_ASSOC + OCI_RETURN_NULLS);
  
  // Initialize variables to avoid undefined errors
  $BRAND           = $row_gen['BRAND'] ?? '';
  $ENGINE_BRAND    = $row_gen['ENGINE_BRAND'] ?? '';
  $CAPACITY        = $row_gen['CAPACITY'] ?? '';
  $INITIAL_STATUS  = $row_gen['INITIAL_STATUS'] ?? '';
  $QUANTITY        = $row_gen['QUANTITY'] ?? '';
  $OWNERSHIP       = $row_gen['OWNERSHIP'] ?? '';
  $CAGE            = $row_gen['CAGE'] ?? '';
  $GID1            = $row_gen['GID'] ?? '';
  $CURRENT_STATUS  = $row_gen['CURRENT_STATUS']??'';

  $sql_tank = "SELECT * FROM TANK WHERE GID =:gid"; // Make sure the table name is correct
  $select_tank = oci_parse($conn, $sql_tank);
  oci_bind_by_name($select_tank, ':gid', $GID1);
  $execute_result22 = oci_execute($select_tank);

  if (!$execute_result22) {
    $e = oci_error($select_tank);
    echo "Error executing query: " . htmlentities($e['message']);
  } else {
    // Initialize tank variables
    $TANK1_SHAPE = $TANK2_SHAPE = $TANK3_SHAPE = '';
    $TANK1_TYPE = $TANK2_TYPE = $TANK3_TYPE = '';
    $TANK1_ACTUAL_VOLUME = $TANK2_ACTUAL_VOLUME = $TANK3_ACTUAL_VOLUME = '';
    $TANK1_HEIGHT = $TANK2_HEIGHT = $TANK3_HEIGHT = '';
    $TANK1_WIDTH = $TANK2_WIDTH = $TANK3_WIDTH = '';
    $TANK1_LENGTH = $TANK2_LENGTH = $TANK3_LENGTH = '';
    $TANK1_MAXIMUM = $TANK2_MAXIMUM = $TANK3_MAXIMUM = '';

    while ($row_tank = oci_fetch_array($select_tank, OCI_ASSOC + OCI_RETURN_NULLS)) {
        $index = htmlspecialchars($row_tank['TANK_INDEX']);

        if ($index == 1) {
            $TANK1_SHAPE             = htmlspecialchars($row_tank['TANK_SHAPE']);
            $TANK1_TYPE              = htmlspecialchars($row_tank['TANK_TYPE']);
            $TANK1_ACTUAL_VOLUME     = htmlspecialchars($row_tank['TANK_ACTUAL_VOLUME']);
            $TANK1_HEIGHT            = htmlspecialchars($row_tank['TANK_HEIGHT']);
            $TANK1_WIDTH             = htmlspecialchars($row_tank['TANK_WIDTH']);
            $TANK1_LENGTH            = htmlspecialchars($row_tank['TANK_LENGTH']);
            $TANK1_MAXIMUM           = htmlspecialchars($row_tank['TANK_MAXIMUM']);
        } elseif ($index == 2) {
            $TANK2_SHAPE             = htmlspecialchars($row_tank['TANK_SHAPE']);
            $TANK2_TYPE              = htmlspecialchars($row_tank['TANK_TYPE']);
            $TANK2_ACTUAL_VOLUME     = htmlspecialchars($row_tank['TANK_ACTUAL_VOLUME']);
            $TANK2_HEIGHT            = htmlspecialchars($row_tank['TANK_HEIGHT']);
            $TANK2_WIDTH             = htmlspecialchars($row_tank['TANK_WIDTH']);
            $TANK2_LENGTH            = htmlspecialchars($row_tank['TANK_LENGTH']);
            $TANK2_MAXIMUM           = htmlspecialchars($row_tank['TANK_MAXIMUM']);
        } elseif ($index == 3) {
            $TANK3_SHAPE             = htmlspecialchars($row_tank['TANK_SHAPE']);
            $TANK3_TYPE              = htmlspecialchars($row_tank['TANK_TYPE']);
            $TANK3_ACTUAL_VOLUME     = htmlspecialchars($row_tank['TANK_ACTUAL_VOLUME']);
            $TANK3_HEIGHT            = htmlspecialchars($row_tank['TANK_HEIGHT']);
            $TANK3_WIDTH             = htmlspecialchars($row_tank['TANK_WIDTH']);
            $TANK3_LENGTH            = htmlspecialchars($row_tank['TANK_LENGTH']);
            $TANK3_MAXIMUM           = htmlspecialchars($row_tank['TANK_MAXIMUM']);
        }
    }
}


?>




                                     <!-- Generator Information Section -->
                    <div class="form-section">
                        <div class="section-header " data-section="generator">
                            <h3><i class="fas fa-gas-pump"></i> Generator Information</h3>
                            <i class="fas fa-chevron-down toggle-icon"></i>
                        </div>
                        <div class="section-content">
                            <div>
                             <div class="form-group">

                            <!-- warehouse -->


                                <div>
                                        <input type="checkbox" id="generator_warehouse" name="warehouse" value="1">
                                        <label for="generator_warehouse">Generator from WareHouse</label>
                                        <div >
                                            <div class="form-group">
                                                <label for="warehouse_code"><i class="fas fa-industry"></i> Site Code</label>
                                                <input type="text" id="warehouse_code" name="warehouse_sitecode">
                                            </div>
                                        </div>
                                    </div>


                                  <!-- warehouse re-->

                                <!-- <label> Generator Installed</label> -->
                                <div class="checkbox-group">
                                    <div class="checkbox-item">
                                        <input type="checkbox" id="generator_present" name="Gen" value="1">
                                        <label for="generator_present">Generator Installed</label>
                                    </div>
                                </div>
                            </div>

                            <div class="sub-options" id="generatorOptions">
                                <div class="form-group">
                                    <label for="generator_brand"><i class="fas fa-industry"></i> Generator Brand</label>
                                    <select id="generator_brand" name="gen_brand">
                                        <option value="--"> -- </option>
                                        <option value="Paknika" <?php if($BRAND   == "Paknika")  echo 'Selected';?>>
                                            Paknika</option>
                                        <option value="Sdmo" <?php if($BRAND   == "Sdmo")     echo 'Selected';?>>Sdmo
                                        </option>
                                        <option value="Saccal" <?php if($BRAND   == "Saccal")   echo 'Selected';?>>
                                            Saccal</option>
                                        <option value="Trion" <?php if($BRAND   == "Trion")    echo 'Selected';?>>Trion
                                        </option>
                                        <option value="Green Power"
                                            <?php if($BRAND   == "Green Power")echo 'Selected';?>>
                                            Green Power</option>
                                        <option value="Telegen" <?php if($BRAND   == "Telegen")  echo 'Selected';?>>
                                            Telegen</option>
                                        <option value="JET" <?php if($BRAND   == "JET")      echo 'Selected';?>>JET
                                        </option>
                                        <option value="MPG" <?php if($BRAND   == "MPG")      echo 'Selected';?>>MPG
                                        </option>
                                        <option value="FAW" <?php if($BRAND   == "FAW")      echo 'Selected';?>>FAW
                                        </option>
                                        <option value="KeyPower" <?php if($BRAND   == "KeyPower") echo 'Selected';?>>
                                            KeyPower</option>
                                        <option value="Valiant" <?php if($BRAND   == "Valiant")  echo 'Selected';?>>
                                            Valiant</option>
                                        <option value="JIMCO" <?php if($BRAND   == "JIMCO")    echo 'Selected';?>>JIMCO
                                        </option>
                                        <option value="EATON" <?php if($BRAND   == "EATON")    echo 'Selected';?>>EATON
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="engine_brand"><i class="fas fa-cogs"></i> Engine Brand</label>
                                    <select id="engine_brand" name="engine_brand">
                                        <option value="--"> -- </option>
                                        <option value="Paknika"
                                            <?php if($ENGINE_BRAND   == "Paknika")   echo 'Selected';?>>
                                            Paknika</option>
                                        <option value="Yanmar"
                                            <?php if($ENGINE_BRAND   == "Yanmar")    echo 'Selected';?>>
                                            Yanmar</option>
                                        <option value="John Deere"
                                            <?php if($ENGINE_BRAND   == "John Deere")echo 'Selected';?>>John Deere
                                        </option>
                                        <option value="Kohler"
                                            <?php if($ENGINE_BRAND   == "Kohler")  echo 'Selected';?>>
                                            Kohler</option>
                                        <option value="YORK"
                                            <?php if($ENGINE_BRAND   == "YORK")       echo 'Selected' ;?>>
                                            YORK</option>
                                        <option value="FAW"
                                            <?php if($ENGINE_BRAND   == "FAW")        echo 'Selected' ;?>>
                                            FAW</option>
                                        <option value="Mitsubishi"
                                            <?php if($ENGINE_BRAND   == "Mitsubishi") echo 'Selected';?>>Mitsubishi
                                        </option>
                                        <option value="Lister"
                                            <?php if($ENGINE_BRAND   == "Lister")     echo 'Selected';?>>
                                            Lister</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="generator_status"><i class="fas fa-clipboard-check"></i> Initial
                                        Status</label>
                                    <select id="generator_status" name="status">
                                        <option value="--"> -- </option>
                                        <option value="Bad" <?php if($INITIAL_STATUS == "Bad")    echo 'Selected';?>>Bad
                                        </option>
                                        <option value="Good" <?php if($INITIAL_STATUS == "Good")   echo 'Selected';?>>
                                            Good
                                        </option>
                                        <option value="Need replace"
                                            <?php if($INITIAL_STATUS == "Need replace")  echo 'Selected';?>>Need replace
                                        </option>
                                        <option value="Need Overhauling"
                                            <?php if($INITIAL_STATUS == "Need Overhauling")echo 'Selected';?>>Need
                                            Overhauling</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="generator_status"><i class="fas fa-clipboard-check"></i> Current
                                        Status</label>
                                    <select id="generator_status" name="currentstatus">
                                        <option value="--"> -- </option>
                                        <option value="Bad" <?php if($CURRENT_STATUS == "Bad")    echo 'Selected';?>>Bad
                                        </option>
                                        <option value="Good" <?php if($CURRENT_STATUS == "Good")   echo 'Selected';?>>
                                            Good
                                        </option>
                                        <option value="Need replace"
                                            <?php if($CURRENT_STATUS == "Need replace")  echo 'Selected';?>>Need replace
                                        </option>
                                        <option value="Need Overhauling"
                                            <?php if($CURRENT_STATUS == "Need Overhauling")echo 'Selected';?>>Need
                                            Overhauling</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="generator_owner"><i class="fas fa-user-tag"></i> Ownership</label>
                                    <select id="generator_owner" name="ownership">
                                        <option value="--"> -- </option>
                                        <option value="MTN" <?php if($OWNERSHIP == "MTN") echo 'Selected';?>>MTN
                                        </option>
                                        <option value="MTN_OOS" <?php if($OWNERSHIP == "MTN_OOS")    echo 'Selected';?>>
                                            MTN_OOS</option>
                                        <option value="MTN_Rented"
                                            <?php if($OWNERSHIP == "MTN_Rented") echo 'Selected';?>>
                                            MTN_Rented</option>
                                        <option value="Other_MTN"
                                            <?php if($OWNERSHIP == "Other_MTN")  echo 'Selected';?>>
                                            Other_MTN</option>
                                        <option value="Other" <?php if($OWNERSHIP == "Other")      echo 'Selected';?>>
                                            Other
                                        </option>
                                        <option value="STE" <?php if($OWNERSHIP == "STE")        echo 'Selected';?>>STE
                                        </option>
                                        <option value="Switch" <?php if($OWNERSHIP == "Switch")     echo 'Selected';?>>
                                            Switch</option>
                                        <option value="Syriatel"
                                            <?php if($OWNERSHIP == "Syriatel")   echo 'Selected';?>>
                                            Syriatel</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="generator_capacity"><i class="fas fa-charging-station"></i> Capacity
                                        (kVA)</label>
                                    <input type="text" id="generator_capacity" name="capacity"
                                        placeholder="Enter capacity" value="<?php echo $CAPACITY ? $CAPACITY : ''; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="generator_qty"><i class="fas fa-calculator"></i> Quantity</label>
                                    <input type="number" id="generator_qty" name="qty" min="1"
                                        value="<?php echo $QUANTITY ? $QUANTITY : ''; ?>">
                                </div>
                                <?php
                                $checked1 = [];
                                $checked1[0] =    (isset($CAGE)    && $CAGE == "Yes") ? 'checked' : '';
                                $checked1[1] =    (isset($CAGE)    && $CAGE == "No")  ? 'checked' : '';
                                //echo $CAGE;
                                ?>
                                <div class="form-group">
                                    <label><i class="fas fa-shield-alt"></i> Generator Cage</label>
                                    <div class="radio-group">
                                        <div class="radio-item">
                                            <input type="radio" id="generator_cage_yes" name="cage" value="Yes"
                                                <?php echo $checked1[0];?>>
                                            <label for="generator_cage_yes">Yes</label>
                                        </div>
                                        <div class="radio-item">
                                            <input type="radio" id="generator_cage_no" name="cage" value="No"
                                                <?php echo $checked1[1];?>>
                                            <label for="generator_cage_no">No</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class=" form-section" style="display: grid; grid-template-columns: repeat(1, 1fr);">
                                <div class="section-content">
                                    <div class="tank-grid"
                                        style="display: grid; grid-template-columns: repeat(3, 2fr);">
                                        <div class="tank-card">
                                            <h4>
                                                <i class="fas fa-oil-can"></i> Tank 1
                                                <span class="tank-toggle">
                                                    <input type="checkbox" name="tank1" value="1">
                                                </span>
                                            </h4>
                                            <div class="tank-fields">
                                                <div class="form-group">
                                                    <label>Shape</label>
                                                    <select name="t1shape">
                                                        <option value="--"> -- </option>
                                                        <option value="Cuboid"
                                                            <?php if($TANK1_SHAPE == "Cuboid")    echo 'Selected';?>>
                                                            Cuboid
                                                        </option>
                                                        <option value="Cylinder"
                                                            <?php if($TANK1_SHAPE == "Cylinder")  echo 'Selected';?>>
                                                            Cylinder
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select name="t1type">
                                                        <option value="--"> -- </option>
                                                        <option value="Internal"
                                                            <?php if( $TANK1_TYPE   == "Internal")  echo 'Selected';?>>
                                                            Internal
                                                        </option>
                                                        <option value="External"
                                                            <?php if( $TANK1_TYPE   == "External")  echo 'Selected';?>>
                                                            External
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Volume (L)</label>
                                                    <input type="number" name="t1volume" placeholder="Actual volume"
                                                        value="<?php echo $TANK1_ACTUAL_VOLUME  ? $TANK1_ACTUAL_VOLUME  : ''; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Dimensions (cm)</label>
                                                    <div
                                                        style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px;">
                                                        <input type="number" name="t1height" placeholder="H"
                                                            value="<?php echo $TANK1_HEIGHT ? $TANK1_HEIGHT   : ''; ?>">
                                                        <input type="number" name="t1width" placeholder="W"
                                                            value="<?php echo $TANK1_WIDTH  ? $TANK1_WIDTH  : ''; ?>">
                                                        <input type="number" name="t1length" placeholder="L"
                                                            value="<?php echo $TANK1_LENGTH ? $TANK1_LENGTH : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Max Capacity (L)</label>
                                                    <input type="number" name="t1max" placeholder="Maximum fuel"
                                                        value="<?php echo $TANK1_MAXIMUM ? $TANK1_MAXIMUM   : ''; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tank-card">
                                            <h4>
                                                <i class="fas fa-oil-can"></i> Tank 2
                                                <span class="tank-toggle">
                                                    <input type="checkbox" name="tank2" value="2">
                                                </span>
                                            </h4>
                                            <div class="tank-fields">
                                                <div class="form-group">
                                                    <label>Shape</label>
                                                    <select name="t2shape">
                                                        <option value="--"> -- </option>
                                                        <option value="Cuboid"
                                                            <?php if($TANK2_SHAPE   == "Cuboid")    echo 'Selected';?>>
                                                            Cuboid
                                                        </option>
                                                        <option value="Cylinder"
                                                            <?php if($TANK2_SHAPE   == "Cylinder")  echo 'Selected';?>>
                                                            Cylinder
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select name="t2type">
                                                        <option value="--"> -- </option>
                                                        <option value="Internal"
                                                            <?php if( $TANK2_TYPE   == "Internal")  echo 'Selected';?>>
                                                            Internal
                                                        </option>
                                                        <option value="External"
                                                            <?php if( $TANK2_TYPE   == "External")  echo 'Selected';?>>
                                                            External
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Volume (L)</label>
                                                    <input type="number" name="t2volume" placeholder="Actual volume"
                                                        value="<?php echo $TANK2_ACTUAL_VOLUME  ? $TANK2_ACTUAL_VOLUME  : ''; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Dimensions (cm)</label>
                                                    <div
                                                        style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px;">
                                                        <input type="number" name="t2height" placeholder="H"
                                                            value="<?php echo $TANK2_HEIGHT ? $TANK2_HEIGHT   : ''; ?>">
                                                        <input type="number" name="t2width" placeholder="W"
                                                            value="<?php echo $TANK2_WIDTH  ? $TANK2_WIDTH  : ''; ?>">
                                                        <input type="number" name="t2length" placeholder="L"
                                                            value="<?php echo $TANK2_LENGTH ?  $TANK2_LENGTH : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Max Capacity (L)</label>
                                                    <input type="number" name="t2max" placeholder="Maximum fuel"
                                                        value="<?php echo $TANK2_MAXIMUM ? $TANK2_MAXIMUM   : ''; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tank-card">
                                            <h4>
                                                <i class="fas fa-oil-can"></i> Tank 3
                                                <span class="tank-toggle">
                                                    <input type="checkbox" name="tank3" value="3">
                                                </span>
                                            </h4>
                                            <div class="tank-fields">
                                                <div class="form-group">
                                                    <label>Shape</label>
                                                    <select name="t3shape">
                                                        <option value="--"> -- </option>
                                                        <option value="Cuboid"
                                                            <?php if($TANK3_SHAPE   == "Cuboid")    echo 'Selected';?>>
                                                            Cuboid
                                                        </option>
                                                        <option value="Cylinder"
                                                            <?php if($TANK3_SHAPE   == "Cylinder")  echo 'Selected';?>>
                                                            Cylinder
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select name="t3type">
                                                        <option value="--"> -- </option>
                                                        <option value="Internal"
                                                            <?php if( $TANK3_TYPE   == "Internal")  echo 'Selected';?>>
                                                            Internal
                                                        </option>
                                                        <option value="External"
                                                            <?php if( $TANK3_TYPE   == "External")  echo 'Selected';?>>
                                                            External
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Volume (L)</label>
                                                    <input type="number" name="t3volume" placeholder="Actual volume"
                                                        value="<?php echo $TANK3_ACTUAL_VOLUME  ? $TANK3_ACTUAL_VOLUME  : ''; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Dimensions (cm)</label>
                                                    <div
                                                        style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px;">
                                                        <input type="number" name="t3height" placeholder="H"
                                                            value="<?php echo $TANK3_HEIGHT   ? $TANK3_HEIGHT   : ''; ?>">
                                                        <input type="number" name="t3width" placeholder="W"
                                                            value="<?php echo $TANK3_WIDTH    ? $TANK3_WIDTH   : ''; ?>">
                                                        <input type="number" name="t3length" placeholder="L"
                                                            value="<?php echo $TANK3_LENGTH   ? $TANK3_LENGTH   : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Max Capacity (L)</label>
                                                    <input type="number" name="t3max" placeholder="Maximum fuel"
                                                        value="<?php echo $TANK3_MAXIMUM ? $TANK3_MAXIMUM   : ''; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
}
?>
   <button type="submit" name="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Configuration
                        </button>

               
                </form>
        </div>
    </div>

</body>

</html>