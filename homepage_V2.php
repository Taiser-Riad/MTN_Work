<?php 
include "config.php";
?>
<?php
// $orginal_sitecode = '';
// $siteid = '';
// $userrname = '';
// $user_id = '';

  if(isset($_GET['user_id']))
  {
  $userid =$_GET['user_id'];
  $sqll= "SELECT * FROM USERS WHERE USER_ID= :userid";
  $result = oci_parse($conn,$sqll);
  oci_bind_by_name($result, ':userid' ,$userid);
  oci_execute($result);
  $row112 = oci_fetch_array($result , OCI_ASSOC + OCI_RETURN_NULLS);
  $userrname = $row112['USERNAME'];
  $dep = $row112['DEPARTMENT'];
  $user_id =  $row112['USER_ID'];
  }


if(isset($_GET['id']))
{
$siteid =$_GET['id'];
$sqll= "SELECT * FROM NEW_SITES WHERE ID= :siteid";
$result = oci_parse($conn,$sqll);
oci_bind_by_name($result, ':siteid' ,$siteid);
oci_execute($result);
$row = oci_fetch_array($result , OCI_ASSOC + OCI_RETURN_NULLS);

$orginal_sitecode = $row['SITE_CODE'];
//$original_PID     = $row['SID'];
}



if (!empty($_POST['searchcode'])) {
    $searchcode = $_POST['searchcode'];
    $user_id =  $_POST['userid1'];
    $userrname  =  $_POST['username1'];


    $searchcode = strtoupper($searchcode);
    $code1 = substr($searchcode, 0, 3);
    if (!preg_match("/^(DAM|DMR|DRA|ALP|DRZ|HMS|HMA|TRS|LTK|RKA|IDB|SWD|QRA|HSK)$/", $code1)) {
        // Output JavaScript alert if the site code is not valid
        //echo '<script>alert("Site code" .$code1." not valid");</script>';
    echo "Site code" .$code1." not valid";
    header("Location: can't.php?id=" . $sid . "&user_id=" . $user_id1);
        exit(); // Stop further script execution
    }




    $sqll = "SELECT * FROM NEW_SITES WHERE SITE_CODE= :searchcode";
    $result = oci_parse($conn, $sqll);
    oci_bind_by_name($result, ':searchcode', $searchcode);
    oci_execute($result);
    $row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS);

    if ($row) {
        $orginal_sitecode = $row['SITE_CODE'];
        $siteid = $row['ID']; // Assuming ID is the primary key you want to use
    } else {
        echo "<script>alert('No site found for the given code.');</script>";
    }
}

if(isset($_POST['submit'])){

        // Debugging output

    $sid         = $_POST ['id'] ?? '';
    $sitecode    = $_POST['sitecode'];
    //CONTER
    $serial      = $_POST['serial'] ?? '';
    $counter     = $_POST['counter'] ?? '';
    $cowner      = $_POST['owner'] ?? '';
    $cpower      = $_POST['cpower'] ?? '';
    $estatus     = $_POST['cstatus'] ?? '';
    $ATS         = $_POST['ATS'] ?? '';

    
    //CABINET
    $cabtype     = $_POST['cabtype'] ?? '';
    $HIP         = $_POST['HIP'] ?? '';
    $DIP         = $_POST['DIP'] ?? '';
    $EIP         = $_POST['EIP'] ?? '';
    $ACqty       = $_POST ['ACqty'] ?? '';
    $solarqty    = $_POST['solarqty'];
    $cabinetcage = $_POST['cabinetcage'] ?? '';
    $cabnote     = $_POST['cabnote'] ?? '';
    $rectifier   = $_POST['rectype'] ?? '';
    $main        = $_POST['maincabinet'] ?? 'False';
 
    
    //GEN
    $Gen         = $_POST['Gen'] ?? '';
    $gen_brand   = $_POST['gen_brand'] ?? '';
    $engine_brand = $_POST['engine_brand'] ?? '';
    $status      = $_POST['status'] ?? '';
    $ownership   = $_POST['ownership'] ?? '';
    $capacity    = $_POST['capacity'] ?? '';
    $qty         = $_POST ['qty'] ?? '';
    $cage        = $_POST['cage'] ?? '';
    $currentstatus = $_POST['currentstatus'] ?? '';

    //tanks
    $tank1       = $_POST['tank1'] ?? '';
    $t1shape     = $_POST['t1shape'] ?? '';
    $t1type      = $_POST['t1type'] ?? '';
    $t1volume    = $_POST['t1volume'] ?? '';
    $t1height    = $_POST['t1height'] ?? '';
    $t1width     = $_POST['t1width'] ?? '';
    $t1length    = $_POST['t1length'] ?? '';
    $t1max       = $_POST['t1max'] ?? '';
    $tank2       = $_POST['tank2'] ?? '';
    $t2shape     = $_POST['t2shape'] ?? '';
    $t2type      = $_POST['t2type'] ?? '';
    $t2volume    = $_POST['t2volume'] ?? '';
    $t2height    = $_POST['t2height'] ?? '';
    $t2width     = $_POST['t2width'] ?? '';
    $t2length    = $_POST['t2length'] ?? '';
    $t2max       = $_POST['t2max'] ?? '';
    $tank3       = $_POST['tank3'] ?? '';
    $t3shape     = $_POST['t3shape'] ?? '';
    $t3type      = $_POST['t3type'] ?? '';
    $t3volume    = $_POST['t3volume'] ?? '';
    $t3height    = $_POST['t3height'] ?? '';
    $t3width     = $_POST['t3width'] ?? '';
    $t3length    = $_POST['t3length'] ?? '';
    $t3max       = $_POST['t3max'] ?? '';
  
    
    //hyprid 
    $Hyprid      = $_POST['Hyprid'] ?? '';
    $solartype   = $_POST['solartype'] ?? '';
    $solarbrand   = $_POST['solarbrand'] ?? '';
    $solarstatus = $_POST['solarstatus'] ?? '';
    $panelqty    = $_POST['panelqty'] ?? '';
    $solarcapacity= $_POST['solarcapacity'] ?? '';
    $solarmodqty = $_POST['solarmodqty'] ?? '';
    //$solarownership= $_POST['solarownership'] ?? '';

    //$NonRationig = $_POST['NonRationig'] ?? '';
    $Ampere      = $_POST['Ampere'] ?? '';
    $ampcapacity = $_POST['ampcapacity'] ?? '';
    $ampduration = $_POST['ampduration'] ?? '';
    //batteries
    $B1Battaries = $_POST['B1Battaries'] ?? '';
    $b1status    = $_POST['b1status']   ?? '';
    $b1type      = $_POST['b1type']     ?? '';
    $b1capacity  = $_POST['b1capacity'] ?? '';
    $b1brand     = $_POST['b1brand']    ?? '';
    $b1qty       = $_POST['b1qty']      ?? '';
    $b1b1date    = $_POST['b1date']   ?? '';
    $B2Battaries = $_POST['B2Battaries']?? '';
    $b2status    = $_POST['b2status']   ?? '';
    $b2type      = $_POST['b2type']     ?? '';
    $b2capacity  = $_POST['b2capacity'] ?? '';
    $b2brand     = $_POST['b2brand']    ?? '';
    $b2qty       = $_POST['b2qty']      ?? '';
    $b2b1date    = $_POST['b2date']   ?? '';
//lines
    $line        = $_POST['lines']       ?? '';
    $lines       = $_POST['ltype']       ?? '';
//site 
    $sitecage    = $_POST['sitecage']    ?? '';
    $gurde       = $_POST['sitegurde']   ?? '';

    $user_id1    = $_POST['userid']    ?? '';
    $username1   = $_POST['username']   ?? '';



    $code2 = substr($sitecode , 0, 3);

    $userstat ="SELECT * FROM  USERS WHERE USER_ID =:userid AND USERNAME=:username";

    $result31 = oci_parse($conn,$userstat);
    
    oci_bind_by_name($result31,':userid'  ,$user_id1);
    oci_bind_by_name($result31,':username',$username1);
    
    oci_execute($result31); 
    
    
    $row_user = oci_fetch_array($result31, OCI_ASSOC + OCI_RETURN_NULLS);
    
    $province = $row_user['PROVINCE'];
    $provinceArray = explode('-', $province);
    if (!in_array($code2, $provinceArray)) {
        header("Location: can't.php?id=" . $sid . "&user_id=" . $user_id1);
        exit(); // Exit the script if the site code is not valid
    }



else{





//echo $currentstatus;
    $check_sql = "SELECT * FROM POWER_BACKUP WHERE SITE_CODE = :sitecode";
    $check_stmt = oci_parse($conn, $check_sql);
    oci_bind_by_name($check_stmt, ':sitecode', $sitecode);

    if (oci_execute($check_stmt)) {
        // $check_row = oci_fetch_array($check_stmt, OCI_ASSOC);
        // $count = $check_row['count'];
       

        $count = 0;
        if ($row1 = oci_fetch_array($check_stmt, OCI_ASSOC)) {
            $count++;
             $old_PID  = $row1['PID'] ?? '';
             $old_cage = $row1['CAGE'] ?? '';
             $old_gurd = $row1['GURDE'] ?? '';
        }

        //echo "Count of records in POWER_BACKUP: $count<br>"; // Debugging line



        if ($count == 0) {


    $sql  = "INSERT INTO POWER_BACKUP (SID, PID, SITE_CODE) 
    VALUES (:siteid,POWER_SEQ.NEXTVAL,:sitecode) RETURNING PID INTO :last_pid";


$insert_stmt = oci_parse($conn,$sql);
oci_bind_by_name($insert_stmt,':siteid'   ,$sid);
oci_bind_by_name($insert_stmt,':sitecode' ,$sitecode);
oci_bind_by_name($insert_stmt,':last_pid', $PID, -1, SQLT_INT);

if (oci_execute($insert_stmt)) {  
   
 } 
   else { 
    $e = oci_error($insert_stmt); 
    echo "Error Updating Data: " . htmlentities($e['message']);

   }


if (!empty($_POST['serial']) && isset($_POST['serial'])) {

$sql = "INSERT INTO ELECTRICAL_COUNTER (PID , SITE_CODE, SERIAL_NUMBER, TYPE, OWNER_SHIP, COUNTER_CIRCUIT_BREAKER, STATUS) 
        VALUES (:pid , :sitecode, :serial, :type, :owner, :counter, :status1)";

$insert_electrical = oci_parse($conn,$sql);
oci_bind_by_name($insert_electrical, ':pid' ,$PID);
oci_bind_by_name($insert_electrical, ':sitecode' ,$sitecode);
oci_bind_by_name($insert_electrical, ':type' ,$cpower);
oci_bind_by_name($insert_electrical, ':serial' ,$serial);
oci_bind_by_name($insert_electrical, ':counter' ,$counter);
oci_bind_by_name($insert_electrical, ':owner' ,$cowner);
oci_bind_by_name($insert_electrical, ':status1' ,$estatus);

if (oci_execute($insert_electrical)) {  

 } 
   else { 
    $e = oci_error($insert_electrical); 
    echo "Error Updating Data: " . htmlentities($e['message']);

   }

    }


if (!empty($_POST['cabtype']) && isset($_POST['cabtype'])) {

$sqlcab = "INSERT INTO CABINET (PID , CABINET_TYPE, RECTIFIER_TYPE, AC_MODULE_QUANTITY, SOLAR_MOUDULE_QUANTITY, DELTA_IP, HWAUEI_IP, ELTEK_IP,CABINET_CAGE,NOTE,MAIN) 
           VALUES (:pid , :cab, :rect, :acmodule, :solarmodule, :deltaip, :hwip ,:eltikip ,:cage, :note,:main)";


$insert_cabinet = oci_parse($conn,$sqlcab);
oci_bind_by_name($insert_cabinet, ':pid' ,$PID);
oci_bind_by_name($insert_cabinet, ':cab' ,$cabtype);
oci_bind_by_name($insert_cabinet, ':rect' ,$rectifier);
oci_bind_by_name($insert_cabinet, ':acmodule' ,$ACqty);
oci_bind_by_name($insert_cabinet, ':solarmodule' ,$solarqty);
oci_bind_by_name($insert_cabinet, ':hwip' ,$HIP);
oci_bind_by_name($insert_cabinet, ':deltaip' ,$DIP);
oci_bind_by_name($insert_cabinet, ':eltikip' ,$EIP);
oci_bind_by_name($insert_cabinet, ':cage' ,$cabinetcage);
oci_bind_by_name($insert_cabinet, ':note' ,$cabnote);
oci_bind_by_name($insert_cabinet, ':main' ,$main);

if (oci_execute($insert_cabinet)) {  
    //echo "DONE";
    //header("Location:Update_thankyou.html");
 } 
   else { 
    $e = oci_error($insert_cabinet); 
    echo "Error Updating Data: " . htmlentities($e['message']);

   }


}

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


if (!empty($_POST['Ampere']) && isset($_POST['Ampere'])) {

    $sqlamp = "INSERT INTO AMPERE (PID , SITE_CODE , CAPACITY, DURATION) 
    VALUES (:pid ,:sitecode, :capacity, :duration)";

$insert_amp = oci_parse($conn,$sqlamp);
oci_bind_by_name($insert_amp, ':pid'      ,$PID);
oci_bind_by_name($insert_amp, ':sitecode' ,$sitecode);
oci_bind_by_name($insert_amp, ':capacity' ,$ampcapacity);
oci_bind_by_name($insert_amp, ':duration' ,$ampduration);




if (oci_execute($insert_amp)) {  
    //echo "DONE";
    //header("Location:Update_thankyou.html");
 } 
   else { 
    $e = oci_error($insert_amp); 
    echo "Error Updating Data: " . htmlentities($e['message']);

   }



}



if (!empty($_POST['Hyprid']) && isset($_POST['Hyprid'])) {

    $sqlhyprid = "INSERT INTO HYPRID (PID , SITE_CODE, TYPE, PANELS_QUANTITY, PANELS_CAPACITY, STATUS, MODULE_QUANTITY, BRAND) 
                  VALUES (:pid , :sitecode, :type, :pqty, :pcabacity, :status, :mqty,:brand)";
    
    
    $insert_hyprid = oci_parse($conn,$sqlhyprid);
    oci_bind_by_name($insert_hyprid, ':pid' ,$PID);
    oci_bind_by_name($insert_hyprid, ':sitecode' ,$sitecode);
    oci_bind_by_name($insert_hyprid, ':type' ,$solartype);
    oci_bind_by_name($insert_hyprid, ':pqty' ,$panelqty);
    oci_bind_by_name($insert_hyprid, ':pcabacity' ,$solarcapacity);
    oci_bind_by_name($insert_hyprid, ':status' ,$solarstatus);
    oci_bind_by_name($insert_hyprid, ':mqty' ,$solarmodqty);
    oci_bind_by_name($insert_hyprid, ':brand' ,$solarbrand);
    
    
    if (oci_execute($insert_hyprid)) {  
        //echo "DONE";
        //header("Location:Update_thankyou.html");
     } 
       else { 
        $e = oci_error($insert_hyprid); echo "Error Updating Data: " . htmlentities($e['message']);
    
       }
    
    
    }
    

    if (!empty($_POST['B1Battaries']) && isset($_POST['B1Battaries'])) {

        $sqlbattaries = "INSERT INTO BATTERIES (PID , SITE_CODE, G1_BRAND, G1_CAPACITY, G1_TYPE, G1_STATUS, G1_QUANTITY, G1_INSTALLATION_DATE) 
                         VALUES (:pid , :sitecode, :brand, :cabacity, :type , :status, :qty, :date1)";
        
        
        $insert_battaries = oci_parse($conn,$sqlbattaries);
        oci_bind_by_name($insert_battaries, ':pid' ,$PID);
        oci_bind_by_name($insert_battaries, ':sitecode' ,$sitecode);
        oci_bind_by_name($insert_battaries, ':brand'    ,$b1brand);
        oci_bind_by_name($insert_battaries, ':cabacity' ,$b1capacity);
        oci_bind_by_name($insert_battaries, ':type'     ,$b1type);
        oci_bind_by_name($insert_battaries, ':status'   ,$b1status);
        oci_bind_by_name($insert_battaries, ':qty'      ,$b1qty);
        oci_bind_by_name($insert_battaries, ':date1'     ,$b1b1date);

        
        if (oci_execute($insert_battaries)) {  
            //echo "DONE";
            //header("Location:Update_thankyou.html");
         } 
           else { 
            $e = oci_error($insert_battaries); echo "Error Updating Data: " . htmlentities($e['message']);
        
           }
        
     
        }


            if (!empty($_POST['B1Battaries']) &&!empty($_POST['B2Battaries']) && isset($_POST['B2Battaries'])) {

                $sqlbattaries2 = "UPDATE BATTERIES SET 
                G2_BRAND =:brand, 
                G2_CAPACITY =:cabacity, 
                G2_TYPE=:type, 
                G2_STATUS =:status, 
                G2_QUANTITY =:qty, 
                G2_INSTALLATION_DATE=:date2
                WHERE PID =:pid";
                
                



                $insert_battaries2 = oci_parse($conn,$sqlbattaries2);
                oci_bind_by_name($insert_battaries2, ':pid' ,$PID);
                //oci_bind_by_name($insert_battaries2, ':sitecode' ,$sitecode);
                oci_bind_by_name($insert_battaries2, ':brand'    ,$b2brand);
                oci_bind_by_name($insert_battaries2, ':cabacity' ,$b2capacity);
                oci_bind_by_name($insert_battaries2, ':type'     ,$b2type);
                oci_bind_by_name($insert_battaries2, ':status'   ,$b2status);
                oci_bind_by_name($insert_battaries2, ':qty'      ,$b2qty);
                oci_bind_by_name($insert_battaries2, ':date2'     ,$b2b1date);
        
                
                if (oci_execute($insert_battaries2)) {  
                    //echo "DONE";
                    //header("Location:Update_thankyou.html");
                 } 
                   else { 
                    $e = oci_error($insert_battaries2); echo "Error Updating Data: " . htmlentities($e['message']);
                
                   }
                
             
                }

                else{
                    //echo "Insert Batteries Groupe1 before Groupe2";
                    echo '<script>alert("Insert Batteries Groupe1 before Groupe2")</script>';
                }


                if (!empty($_POST['lines']) && isset($_POST['lines'])) {

                    $sqllines = "INSERT INTO LINES (PID, SITE_CODE, TYPE) 
                                     VALUES (:pid ,:sitecode, :type)";
                    
                    
                    $insert_lines = oci_parse($conn,$sqllines);
                    oci_bind_by_name($insert_lines, ':pid'      ,$PID);
                    oci_bind_by_name($insert_lines, ':sitecode' ,$sitecode);
                    oci_bind_by_name($insert_lines, ':type'     ,$lines);

            
                    
                    if (oci_execute($insert_lines)) {  
                        //echo "DONE";
                        //header("Location:Update_thankyou.html");
                     } 
                       else { 
                        $e = oci_error($insert_lines); echo "Error Updating Data: " . htmlentities($e['message']);
                    
                       }
                    
                 
                    }
              
               
     
                    if (!empty($_POST['sitecage']) && isset($_POST['sitecage'])) {

                        $sqlcage = "UPDATE POWER_BACKUP SET CAGE =:cage WHERE PID =:pid ";
                                                            
                        
                        $update_cage = oci_parse($conn,$sqlcage);
                        oci_bind_by_name($update_cage, ':pid'      ,$PID);
                        oci_bind_by_name($update_cage, ':cage' ,$sitecage);
                        
                
                        
                        if (oci_execute($update_cage)) {  
                            //echo "DONE";
                            //header("Location:Update_thankyou.html");
                         } 
                           else { 
                            $e = oci_error($update_cage); echo "Error Updating Data: " . htmlentities($e['message']);
                        
                           }
                        
                     
                        }


                        if (!empty($_POST['sitegurde']) && isset($_POST['sitegurde'])) {

                            $sqlgurde = "UPDATE POWER_BACKUP SET GURDE =:gurde WHERE PID =:pid ";
                                                                
                            
                            $update_gurde = oci_parse($conn,$sqlgurde);
                            oci_bind_by_name($update_gurde, ':pid'   ,$PID);
                            oci_bind_by_name($update_gurde, ':gurde' ,$gurde);
                            
                    
                            
                            if (oci_execute($update_gurde)) {  
                                //echo "DONE";
                                //header("Location:Update_thankyou.html");
                             } 
                               else { 
                                $e = oci_error($update_gurde); echo "Error Updating Data: " . htmlentities($e['message']);
                            
                               }
                            
                         
                            }
                     

                            //echo '<script>alert("'.$row["SITE_CODE"].' Power backup inserted Successfully")</script>';
                            
                         



    }

else{

$sql_elect = "SELECT * FROM ELECTRICAL_COUNTER WHERE SITE_CODE =:sitecode";
$select_elect = oci_parse($conn, $sql_elect);
oci_bind_by_name($select_elect, ':sitecode', $sitecode);
oci_execute($select_elect);

if($row_elec = oci_fetch_array($select_elect, OCI_ASSOC + OCI_RETURN_NULLS))
{

    $OLD_TYPE              =   $row_elec ['TYPE'];
    $OLD_OWNERSHIP         =   $row_elec ['OWNER_SHIP'];
    $OLD_STATUS            =   $row_elec ['STATUS'];
    $OLD_CIRCUIT_BREAKER   =   $row_elec ['COUNTER_CIRCUIT_BREAKER'];
    $OLD_SERIAL_NUMBER     =   $row_elec ['SERIAL_NUMBER'];
    $OLD_ATS_INSTALLED     =   $row_elec ['ATS_INSTALLED'];

if($OLD_TYPE == $cpower && $OLD_OWNERSHIP == $cowner && $OLD_STATUS == $estatus && $OLD_CIRCUIT_BREAKER == $counter  && $OLD_SERIAL_NUMBER == $serial && $ATS == $OLD_ATS_INSTALLED){


}

    else{
        $sql11 = "INSERT INTO ELECTRICAL_AUDIT (
            DETAIL_ID,
            OLD_TYPE,
            NEW_TYPE,
            OLD_OWNERSHIP,
            NEW_OWNER_SHIP,
            OLD_STATUS,
            NEW_STATUS,
            OLD_CIRCUIT_BREAKER,
            NEW_CIRCUIT_BREAKER,
            OLD_SERIAL_NUMBER,
            NEW_SERIAL_NUMBER,
            CHANGED_BY,
            USER_ID,
            SITE_CODE,
            CHANGE_AT,
            OLD_ATS_INSTALLER,
            NEW_ATS_INSTALLER
        ) 
        VALUES (
            ELECTRICAL_AUDIT_SEQ.NEXTVAL,  -- Assuming you want to generate a new ID
            :oldtype,
            :newtype,
            :oldownership,
            :newownership,
            :oldstatus,
            :newstatus,
            :oldcircut,
            :newcircut,
            :oldserial,
            :newserial,
            :username,
            :userid,
            :sitecode,
            SYSDATE,
            :oldats,
            :newats
        )
        RETURNING DETAIL_ID INTO :last_detail_id";
    
    $insert_electrical_audit = oci_parse($conn, $sql11);
    
    // Bind parameters
    oci_bind_by_name($insert_electrical_audit, ':last_detail_id', $DETAIL_ID, -1, SQLT_INT);
    oci_bind_by_name($insert_electrical_audit, ':newtype', $cpower);
    oci_bind_by_name($insert_electrical_audit, ':oldtype', $OLD_TYPE);
    oci_bind_by_name($insert_electrical_audit, ':newcircut', $counter);
    oci_bind_by_name($insert_electrical_audit, ':oldcircut', $OLD_CIRCUIT_BREAKER);
    oci_bind_by_name($insert_electrical_audit, ':newownership', $cowner);
    oci_bind_by_name($insert_electrical_audit, ':oldownership', $OLD_OWNERSHIP);
    oci_bind_by_name($insert_electrical_audit, ':oldstatus', $OLD_STATUS);
    oci_bind_by_name($insert_electrical_audit, ':newstatus', $estatus);
    oci_bind_by_name($insert_electrical_audit, ':sitecode', $sitecode);
    oci_bind_by_name($insert_electrical_audit, ':newserial', $serial);
    oci_bind_by_name($insert_electrical_audit, ':oldserial', $OLD_SERIAL_NUMBER);
    oci_bind_by_name($insert_electrical_audit, ':username', $username1);
    oci_bind_by_name($insert_electrical_audit, ':userid', $user_id1);
    oci_bind_by_name($insert_electrical_audit, ':oldats', $OLD_ATS_INSTALLED);
    oci_bind_by_name($insert_electrical_audit, ':newats', $ATS);
    
    // Execute the insert
    $resultt = oci_execute($insert_electrical_audit);
    
    if ($resultt) {
    echo "Record inserted successfully.";
    } else {
    $e = oci_error($insert_electrical_audit);  // For oci_execute errors
    echo "Error inserting record: " . $e['message'];
    }
    
    // Free statement resources
    oci_free_statement($insert_electrical_audit);

    }



//echo "New Type: $cpower, Old Type: $OLD_TYPE, New Circuit: $counter, Old Circuit: $OLD_CIRCUIT_BREAKER, New Ownership: $cowner, Old Ownership: $OLD_OWNERSHIP, Old Status: $OLD_STATUS, New Status: $estatus, Site Code: $sitecode, New Serial: $serial, Old Serial: $OLD_SERIAL_NUMBER, Username: $username1, User ID: $user_id1";




$sql = "UPDATE ELECTRICAL_COUNTER 
        SET 
         SERIAL_NUMBER = :serial, 
        TYPE = :type, 
        OWNER_SHIP = :owner, 
        COUNTER_CIRCUIT_BREAKER = :counter, 
        STATUS = :status1 
        WHERE PID = :pid";

$update_electrical = oci_parse($conn, $sql);

// Bind the parameters
oci_bind_by_name($update_electrical, ':pid', $old_PID);
//oci_bind_by_name($update_electrical, ':sitecode', $sitecode);
oci_bind_by_name($update_electrical, ':serial', $serial);
oci_bind_by_name($update_electrical, ':type', $cpower);
oci_bind_by_name($update_electrical, ':counter', $cpower); // Assuming this is correct
oci_bind_by_name($update_electrical, ':owner', $cowner);
oci_bind_by_name($update_electrical, ':status1', $estatus);

// Execute the update
$result = oci_execute($update_electrical);

if ($result) {
   //echo "Record updated successfully.";
} else {
    $e = oci_error($update_electrical);  // For oci_execute errors
    echo "Error updating record: " . $e['message'];
}

// Clean up
oci_free_statement($update_electrical);

}


else{

    $sql = "INSERT INTO ELECTRICAL_COUNTER (PID , SITE_CODE, SERIAL_NUMBER, TYPE, OWNER_SHIP, COUNTER_CIRCUIT_BREAKER, STATUS) 
    VALUES (:pid , :sitecode, :serial, :type, :owner, :counter, :status1)";

$insert_electrical = oci_parse($conn,$sql);
oci_bind_by_name($insert_electrical, ':pid' ,$old_PID);
oci_bind_by_name($insert_electrical, ':sitecode' ,$sitecode);
oci_bind_by_name($insert_electrical, ':type' ,$cpower);
oci_bind_by_name($insert_electrical, ':serial' ,$serial);
oci_bind_by_name($insert_electrical, ':counter' ,$counter);
oci_bind_by_name($insert_electrical, ':owner' ,$cowner);
oci_bind_by_name($insert_electrical, ':status1' ,$estatus);

if (oci_execute($insert_electrical)) {  

} 
else { 
$e = oci_error($insert_electrical); 
echo "Error Updating Data: " . htmlentities($e['message']);

}

}



$sql_cab = "SELECT * FROM CABINET WHERE PID=:pid";
$select_cab = oci_parse($conn, $sql_cab);
oci_bind_by_name($select_cab, ':pid', $old_PID);
oci_execute($select_cab);

if($row_cab = oci_fetch_array($select_cab, OCI_ASSOC + OCI_RETURN_NULLS))
{

    $CABINET_TYPE           = $row_cab['CABINET_TYPE'];
    $RECTIFIER_TYPE         = $row_cab['RECTIFIER_TYPE'];
    $AC_MODULE_QUANTITY     = $row_cab['AC_MODULE_QUANTITY'];
    $SOLAR_MOUDULE_QUANTITY = $row_cab['SOLAR_MOUDULE_QUANTITY'];
    $DELTA_IP               = $row_cab['DELTA_IP'];
    $HWAUEI_IP              = $row_cab['HWAUEI_IP'];
    $ELTEK_IP               = $row_cab['ELTEK_IP'];
    $CABINET_CAGE           = $row_cab['CABINET_CAGE'];
    $OLD_MAIN               = $row_cab['MAIN'];


if($CABINET_TYPE == $cabtype && $RECTIFIER_TYPE == $rectifier &&  $AC_MODULE_QUANTITY == $ACqty &&  $SOLAR_MOUDULE_QUANTITY == $solarqty && $DELTA_IP == $DIP &&  $HWAUEI_IP == $HIP && $ELTEK_IP == $EIP &&  $CABINET_CAGE == $cabinetcage && $OLD_MAIN == $main){}

else{


    $sql12 = "INSERT INTO CABINET_AUDIT (
        DETAIL_ID,
        USER_ID,
        SITE_CODE,
        OLD_CABINET_TYPE,
        NEW_CABINET_TYPE,
        OLD_RECTIFIER_TYPE,
        NEW_RECTIFIER_TYPE,
        OLD_AC_MODULE_QUANTITY,
        NEW_AC_MODULE_QUANTITY,
        OLD_SOLAR_MOUDULE_QUANTITY,
        NEW_SOLAR_MOUDULE_QUANTITY,
        OLD_DELTA_IP,
        NEW_DELTA_IP,
        OLD_HWAUEI_IP,
        NEW_HWAUEI_IP,
        OLD_ELTEK_IP,
        NEW_ELTEK_IP,
        OLD_CABINET_CAGE,
        NEW_CABINET_CAGE,
        CHANGED_BY,
        CHANGE_AT,
        OLD_MAIN,
        NEW_MAIN
    ) 
    VALUES (
        CABINET_AUDIT_SEQ.NEXTVAL,  -- Assuming you want to generate a new ID
        :userid,
        :sitecode,
        :oldcabinet,
        :newcabinet,
        :oldrectifier,
        :newrectifier,
        :oldac,
        :newac,
        :oldsolar,
        :newsolar,
        :olddip,
        :newdip,
        :oldhip,
        :newhip,
        :oldeip,
        :neweip,
        :oldcage,
        :newcage,
        :username,
        SYSDATE,
        :oldmain,
        :newmain
    )
    RETURNING DETAIL_ID INTO :last_detail_id";

$insert_cabinet_audit = oci_parse($conn, $sql12);
    
// Bind parameters
oci_bind_by_name($insert_cabinet_audit, ':last_detail_id', $DETAIL_ID, -1, SQLT_INT);
oci_bind_by_name($insert_cabinet_audit, ':userid', $user_id1);
oci_bind_by_name($insert_cabinet_audit, ':username', $username1);
oci_bind_by_name($insert_cabinet_audit, ':sitecode', $sitecode);
oci_bind_by_name($insert_cabinet_audit, ':oldcabinet', $CABINET_TYPE);
oci_bind_by_name($insert_cabinet_audit, ':newcabinet', $cabtype);
oci_bind_by_name($insert_cabinet_audit, ':oldrectifier',$RECTIFIER_TYPE);
oci_bind_by_name($insert_cabinet_audit, ':newrectifier',$rectifier);
oci_bind_by_name($insert_cabinet_audit, ':oldac',$AC_MODULE_QUANTITY);
oci_bind_by_name($insert_cabinet_audit, ':newac',$ACqty);
oci_bind_by_name($insert_cabinet_audit, ':oldsolar',$SOLAR_MOUDULE_QUANTITY);
oci_bind_by_name($insert_cabinet_audit, ':newsolar',$solarqty);
oci_bind_by_name($insert_cabinet_audit, ':oldeip',$ELTEK_IP);
oci_bind_by_name($insert_cabinet_audit, ':neweip',$EIP);
oci_bind_by_name($insert_cabinet_audit, ':olddip',$DELTA_IP);
oci_bind_by_name($insert_cabinet_audit, ':newdip',$DIP);
oci_bind_by_name($insert_cabinet_audit, ':oldhip',$HWAUEI_IP);
oci_bind_by_name($insert_cabinet_audit, ':newhip',$HIP);
oci_bind_by_name($insert_cabinet_audit, ':oldcage',$CABINET_CAGE);
oci_bind_by_name($insert_cabinet_audit, ':newcage',$cabinetcage);
oci_bind_by_name($insert_cabinet_audit, ':newmain',$main);
oci_bind_by_name($insert_cabinet_audit, ':oldmain',$OLD_MAIN);



// Execute the insert
$resultt = oci_execute($insert_cabinet_audit);

if ($resultt) {
echo "Record inserted successfully.";
} else {
$e = oci_error($insert_cabinet_audit);  // For oci_execute errors
echo "Error inserting record: " . $e['message'];
}

// Free statement resources
oci_free_statement($insert_cabinet_audit);


}

  $sqlcab = "UPDATE CABINET 
           SET CABINET_TYPE = :cab, 
               RECTIFIER_TYPE = :rect, 
               AC_MODULE_QUANTITY = :acmodule, 
               SOLAR_MOUDULE_QUANTITY = :solarmodule, 
               DELTA_IP = :deltaip, 
               HWAUEI_IP = :hwip, 
               ELTEK_IP = :eltikip, 
               CABINET_CAGE = :cage, 
               NOTE = :note,
               MAIN =:main 
           WHERE PID = :pid";

$update_cabinet = oci_parse($conn, $sqlcab);

// Bind the parameters
oci_bind_by_name($update_cabinet, ':pid', $old_PID);
oci_bind_by_name($update_cabinet, ':cab', $cabtype);
oci_bind_by_name($update_cabinet, ':rect', $rectifier);
oci_bind_by_name($update_cabinet, ':acmodule', $ACqty);
oci_bind_by_name($update_cabinet, ':solarmodule', $solarqty);
oci_bind_by_name($update_cabinet, ':hwip', $HIP);
oci_bind_by_name($update_cabinet, ':deltaip', $DIP);
oci_bind_by_name($update_cabinet, ':eltikip', $EIP);
oci_bind_by_name($update_cabinet, ':cage', $cabinetcage);
oci_bind_by_name($update_cabinet, ':note', $cabnote);
oci_bind_by_name($update_cabinet, ':main', $main);

// Execute the update
$result = oci_execute($update_cabinet);

if ($result) {
    //echo "Record updated successfully.";
} else {
    $e = oci_error($update_cabinet);  // For oci_execute errors
    echo "Error updating record: " . $e['message'];
}

// Clean up
oci_free_statement($update_cabinet);





}
else{
    $sqlcab = "INSERT INTO CABINET (PID , CABINET_TYPE, RECTIFIER_TYPE, AC_MODULE_QUANTITY, SOLAR_MOUDULE_QUANTITY, DELTA_IP, HWAUEI_IP, ELTEK_IP,CABINET_CAGE,NOTE,MAIN) 
    VALUES (:pid , :cab, :rect, :acmodule, :solarmodule, :deltaip, :hwip ,:eltikip ,:cage, :note,:main)";


$insert_cabinet = oci_parse($conn,$sqlcab);
oci_bind_by_name($insert_cabinet, ':pid' ,$old_PID);
oci_bind_by_name($insert_cabinet, ':cab' ,$cabtype);
oci_bind_by_name($insert_cabinet, ':rect' ,$rectifier);
oci_bind_by_name($insert_cabinet, ':acmodule' ,$ACqty);
oci_bind_by_name($insert_cabinet, ':solarmodule' ,$solarqty);
oci_bind_by_name($insert_cabinet, ':hwip' ,$HIP);
oci_bind_by_name($insert_cabinet, ':deltaip' ,$DIP);
oci_bind_by_name($insert_cabinet, ':eltikip' ,$EIP);
oci_bind_by_name($insert_cabinet, ':cage' ,$cabinetcage);
oci_bind_by_name($insert_cabinet, ':note' ,$cabnote);
oci_bind_by_name($insert_cabinet, ':main' ,$main);

if (oci_execute($insert_cabinet)) {  
//echo "DONE";
//header("Location:Update_thankyou.html");
} 
else { 
$e = oci_error($insert_cabinet); 
echo "Error Updating Data: " . htmlentities($e['message']);

}

}

$sql_gen = "SELECT * FROM GENERTAOR WHERE SITE_CODE=:sitecode";
$select_gen = oci_parse($conn, $sql_gen);
oci_bind_by_name($select_gen, ':sitecode', $sitecode);
oci_execute($select_gen);

if($row_gen = oci_fetch_array($select_gen, OCI_ASSOC + OCI_RETURN_NULLS))
{
    $old_GID            = $row_gen['GID'];
    $OLD_BRAND          = $row_gen['BRAND'];
    $OLD_ENGINE_BRAND   = $row_gen['ENGINE_BRAND'];
    $OLD_CAPACITY       = $row_gen['CAPACITY'];
    $OLD_INITIAL_STATUS = $row_gen['INITIAL_STATUS'];
    $OLD_QUANTITY       = $row_gen['QUANTITY'];
    $OLD_OWNERSHIP      = $row_gen['OWNERSHIP'];
    $OLD_CAGE           = $row_gen['CAGE'];   
    $OLD_CURRENT_STATUS     = $row_gen['CURRENT_STATUS']; 

if($OLD_BRAND == $gen_brand && $OLD_ENGINE_BRAND == $engine_brand && $OLD_CAPACITY == $capacity && $OLD_INITIAL_STATUS == $status && $OLD_QUANTITY == $qty && $OLD_OWNERSHIP == $ownership && $OLD_CAGE == $cage && $OLD_CURRENT_STATUS ==$currentstatus ){}

else{
    $sql_insert = "INSERT INTO GENERTAOR_AUDIT (
        DETAIL_ID,
        USER_ID,
        SITE_CODE,
        OLD_BRAND,
        NEW_BRAND,
        OLD_ENGINE_BRAND,
        NEW_ENGINE_BRAND,
        OLD_CAPACITY,
        NEW_CAPACITY,
        OLD_INITIAL_STATUS,
        NEW_INITIAL_STATUS,
        OLD_QUANTITY,
        NEW_QUANTITY,
        OLD_OWNERSHIP,
        NEW_OWNERSHIP,
        OLD_CAGE,
        NEW_CAGE,
        CHANGED_BY,
        CHANGE_AT,
        OLD_CURRENT_STATUS,
        NEW_CURRENT_STATUS
       
    ) VALUES (
        GENERATOR_SEQ.NEXTVAL,
        :user_id,
        :site_code,
        :old_brand,
        :new_brand,
        :old_engine_brand,
        :new_engine_brand,
        :old_capacity,
        :new_capacity,
        :old_initial_status,
        :new_initial_status,
        :old_quantity,
        :new_quantity,
        :old_ownership,
        :new_ownership,
        :old_cage,
        :new_cage,
        :changed_by,
        SYSDATE,
        :old_curr,
        :new_curr
          )RETURNING DETAIL_ID INTO :last_detail_id";
    
    $insert_stmt = oci_parse($conn, $sql_insert);
    
    // Bind variables
    oci_bind_by_name($insert_stmt, ':last_detail_id', $DETAIL_ID, -1, SQLT_INT);
    oci_bind_by_name($insert_stmt, ':user_id', $user_id1);
    oci_bind_by_name($insert_stmt, ':site_code', $sitecode);
    oci_bind_by_name($insert_stmt, ':old_brand', $OLD_BRAND);
    oci_bind_by_name($insert_stmt, ':new_brand', $gen_brand);
    oci_bind_by_name($insert_stmt, ':old_engine_brand', $OLD_ENGINE_BRAND);
    oci_bind_by_name($insert_stmt, ':new_engine_brand', $engine_brand);
    oci_bind_by_name($insert_stmt, ':old_capacity', $OLD_CAPACITY);
    oci_bind_by_name($insert_stmt, ':new_capacity', $capacity);
    oci_bind_by_name($insert_stmt, ':old_initial_status', $OLD_INITIAL_STATUS);
    oci_bind_by_name($insert_stmt, ':new_initial_status', $new_initial_status);
    oci_bind_by_name($insert_stmt, ':old_quantity', $OLD_QUANTITY);
    oci_bind_by_name($insert_stmt, ':new_quantity', $qty);
    oci_bind_by_name($insert_stmt, ':old_ownership', $OLD_OWNERSHIP);
    oci_bind_by_name($insert_stmt, ':new_ownership', $ownership);
    oci_bind_by_name($insert_stmt, ':old_cage', $OLD_CAGE);
    oci_bind_by_name($insert_stmt, ':new_cage', $cage);
    oci_bind_by_name($insert_stmt, ':old_curr', $OLD_CURRENT_STATUS);
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



$sqlgen = "UPDATE GENERTAOR 
           SET BRAND = :brand, 
               ENGINE_BRAND = :engbrand, 
               INITIAL_STATUS = :status, 
               QUANTITY = :qty, 
               OWNERSHIP = :owner, 
               CAGE = :cage, 
               CAPACITY = :cap,
               CURRENT_STATUS = :curr
           WHERE PID = :pid";

$update_gen = oci_parse($conn, $sqlgen);

// Bind the parameters
oci_bind_by_name($update_gen, ':pid', $old_PID);
//oci_bind_by_name($update_gen, ':sitecode', $sitecode);
oci_bind_by_name($update_gen, ':brand', $gen_brand);
oci_bind_by_name($update_gen, ':engbrand', $engine_brand);
oci_bind_by_name($update_gen, ':status', $status);
oci_bind_by_name($update_gen, ':qty', $qty);
oci_bind_by_name($update_gen, ':owner', $ownership);
oci_bind_by_name($update_gen, ':cage', $cage);
oci_bind_by_name($update_gen, ':cap', $capacity);
oci_bind_by_name($update_gen, ':curr', $currentstatus);
// Execute the update
$result = oci_execute($update_gen);

if ($result) {
   // echo "Record updated successfully.";


$sql_tank = "SELECT * FROM TANK WHERE GID=:gid";
$select_tank = oci_parse($conn, $sql_tank);
oci_bind_by_name($select_tank, ':gid', $old_GID);
oci_execute($select_tank);

$has_rows = false; 
$first_index  = false;
$second_index = false;
$third_index  = false;

while($row_tank = oci_fetch_array($select_tank, OCI_ASSOC + OCI_RETURN_NULLS))
{

    $has_rows  = true; 
  

    $index =  htmlspecialchars($row_tank['TANK_INDEX']);
//echo $index.'HELLO';

    if ($index == 1){

        $first_index  = true;

        $TANK1_SHAPE             = htmlspecialchars($row_tank['TANK_SHAPE']) ?? '';
        $TANK1_TYPE              = htmlspecialchars($row_tank['TANK_TYPE']) ?? '';
        $TANK1_ACTUAL_VOLUME     = htmlspecialchars($row_tank['TANK_ACTUAL_VOLUME']) ?? '';
        $TANK1_HEIGHT            = htmlspecialchars($row_tank['TANK_HEIGHT']) ?? '';
        $TANK1_WIDTH             = htmlspecialchars($row_tank['TANK_WIDTH']) ?? '';
        $TANK1_LENGTH            = htmlspecialchars($row_tank['TANK_LENGTH']) ?? '';
        $TANK1_MAXIMUM           = htmlspecialchars($row_tank['TANK_MAXIMUM']) ?? '';



        $sqltank1 = "UPDATE TANK 
        SET TANK_SHAPE = :shape, 
            TANK_TYPE = :type, 
            TANK_ACTUAL_VOLUME = :volume, 
            TANK_HEIGHT = :height, 
            TANK_WIDTH = :width, 
            TANK_LENGTH = :length, 
            TANK_MAXIMUM = :maximum
            
        WHERE GID = :gid AND TANK_INDEX =: indexx";
    
    $update_tank1 = oci_parse($conn, $sqltank1);
    
    // Bind the parameters
    oci_bind_by_name($update_tank1, ':gid', $old_GID);
    oci_bind_by_name($update_tank1, ':shape', $t1shape);
    oci_bind_by_name($update_tank1, ':type', $t1type);
    oci_bind_by_name($update_tank1, ':volume', $t1volume);
    oci_bind_by_name($update_tank1, ':height', $t1height);
    oci_bind_by_name($update_tank1, ':width', $t1width);
    oci_bind_by_name($update_tank1, ':length', $t1length);
    oci_bind_by_name($update_tank1, ':maximum', $t1max);
    oci_bind_by_name($update_tank1, ':indexx', $index);
    
    
    // Execute the update
    $result = oci_execute($update_tank1);
    
    if ($result) {
    //echo "Record updated successfully.";
    } else {
    $e = oci_error($update_tank1);  // For oci_execute errors
    echo "Error updating record: " . $e['message'];
    }
    
    // Clean up
    oci_free_statement($update_tank1);

    }
    
    if($index == 2){

    $second_index = true;


        $TANK2_MAXIMUM           = htmlspecialchars($row_tank['TANK_MAXIMUM']) ?? '';
        $TANK2_SHAPE             = htmlspecialchars($row_tank['TANK_SHAPE']) ?? '';
        $TANK2_TYPE              = htmlspecialchars($row_tank['TANK_TYPE']) ?? '';
        $TANK2_ACTUAL_VOLUME     = htmlspecialchars($row_tank['TANK_ACTUAL_VOLUME']) ?? '';
        $TANK2_HEIGHT            = htmlspecialchars($row_tank['TANK_HEIGHT']) ?? '';
        $TANK2_LENGTH            = htmlspecialchars($row_tank['TANK_LENGTH']) ?? '';
        $TANK2_WIDTH             = htmlspecialchars($row_tank['TANK_WIDTH']) ?? '';


        $sqltank1 = "UPDATE TANK 
        SET TANK_SHAPE = :shape, 
            TANK_TYPE = :type, 
            TANK_ACTUAL_VOLUME = :volume, 
            TANK_HEIGHT = :height, 
            TANK_WIDTH = :width, 
            TANK_LENGTH = :length, 
            TANK_MAXIMUM = :maximum
            
        WHERE GID = :gid AND TANK_INDEX =: indexx";
    
    $update_tank1 = oci_parse($conn, $sqltank1);
    
    // Bind the parameters
    oci_bind_by_name($update_tank1, ':gid', $old_GID);
    oci_bind_by_name($update_tank1, ':shape', $t2shape);
    oci_bind_by_name($update_tank1, ':type', $t2type);
    oci_bind_by_name($update_tank1, ':volume', $t2volume);
    oci_bind_by_name($update_tank1, ':height', $t2height);
    oci_bind_by_name($update_tank1, ':width', $t2width);
    oci_bind_by_name($update_tank1, ':length', $t2length);
    oci_bind_by_name($update_tank1, ':maximum', $t2max);
    oci_bind_by_name($update_tank1, ':indexx', $index);
    
    
    // Execute the update
    $result = oci_execute($update_tank1);
    
    if ($result) {
    //echo "Record updated successfully.";
    } else {
    $e = oci_error($update_tank1);  // For oci_execute errors
    echo "Error updating record: " . $e['message'];
    }
    
    // Clean up
    oci_free_statement($update_tank1);
    
    
    }
    
    if($index == 3){

     $third_index  = true;
    
        $TANK3_SHAPE             = htmlspecialchars($row_tank['TANK_SHAPE']) ?? '';
        $TANK3_ACTUAL_VOLUME     = htmlspecialchars($row_tank['TANK_ACTUAL_VOLUME']) ?? '';
        $TANK3_HEIGHT            = htmlspecialchars($row_tank['TANK_HEIGHT']) ?? '';
        $TANK3_TYPE              = htmlspecialchars($row_tank['TANK_TYPE']) ?? '';
     
        $TANK3_MAXIMUM           = htmlspecialchars($row_tank['TANK_MAXIMUM']) ?? '';
        $TANK3_LENGTH            = htmlspecialchars($row_tank['TANK_LENGTH']) ?? '';
        $TANK3_WIDTH             = htmlspecialchars($row_tank['TANK_WIDTH']) ?? '';



        $sqltank1 = "UPDATE TANK 
        SET TANK_SHAPE = :shape, 
            TANK_TYPE = :type, 
            TANK_ACTUAL_VOLUME = :volume, 
            TANK_HEIGHT = :height, 
            TANK_WIDTH = :width, 
            TANK_LENGTH = :length, 
            TANK_MAXIMUM = :maximum
            
        WHERE GID = :gid AND TANK_INDEX =: indexx";
    
    $update_tank1 = oci_parse($conn, $sqltank1);
    
    // Bind the parameters
    oci_bind_by_name($update_tank1, ':gid', $old_GID);
    oci_bind_by_name($update_tank1, ':shape', $t3shape);
    oci_bind_by_name($update_tank1, ':type', $t3type);
    oci_bind_by_name($update_tank1, ':volume', $t3volume);
    oci_bind_by_name($update_tank1, ':height', $t3height);
    oci_bind_by_name($update_tank1, ':width', $t3width);
    oci_bind_by_name($update_tank1, ':length', $t3length);
    oci_bind_by_name($update_tank1, ':maximum', $t3max);
    oci_bind_by_name($update_tank1, ':indexx', $index);
    
    
    // Execute the update
    $result = oci_execute($update_tank1);
    
    if ($result) {
    //echo "Record updated successfully.";
    } else {
    $e = oci_error($update_tank1);  // For oci_execute errors
    echo "Error updating record: " . $e['message'];
    }
    
    // Clean up
    oci_free_statement($update_tank1);
    
    }








}







if(
($TANK1_SHAPE == $t1shape && $TANK1_TYPE == $t1type && $TANK1_ACTUAL_VOLUME == $t1volume && $TANK1_HEIGHT  == $t1height 
&& $TANK1_WIDTH  == $t1width && $TANK1_LENGTH  == $t1length && $TANK1_MAXIMUM  == $t1max) || ($TANK2_SHAPE  == $t2shape && $TANK2_TYPE  == $t2type 
&& $TANK2_ACTUAL_VOLUME == $t2volume && $TANK2_HEIGHT == $t2height && $TANK2_LENGTH  == $t2length && $TANK2_WIDTH  == $t2width  && $TANK2_MAXIMUM == $t2max) 
|| ($TANK3_SHAPE  == $t3shape && $TANK3_TYPE  == $t3type && $TANK3_ACTUAL_VOLUME== $t3volume && $TANK3_HEIGHT  == $t3height 
 && $TANK3_MAXIMUM  == $t3max && $TANK3_LENGTH  == $t3length 
&& $TANK3_WIDTH  == $t3width)
){}
else{

    $sql_insert = "INSERT INTO TANK_AUDIT (
      DETAIL_ID,USER_ID,SITE_CODE,OLD_TANK1_SHAPE,NEW_TANK1_SHAPE,OLD_TANK1_TYPE,NEW_TANK1_TYPE,OLD_TANK1_VOLUME,NEW_TANK1_VOLUME,
      OLD_TANK1_HEIGHT,NEW_TANK1_HEIGHT,OLD_TANK1_WIDTH,NEW_TANK1_WIDTH,OLD_TANK1_LENGTH,NEW_TANK1_LENGTH,OLD_TANK1_MAXIMUM,
      OLD_TANK2_SHAPE,NEW_TANK2_SHAPE,OLD_TANK2_TYPE,NEW_TANK2_TYPE,OLD_TANK2_VOLUME,NEW_TANK2_VOLUME,OLD_TANK2_HEIGHT,NEW_TANK2_HEIGHT,
      OLD_TANK2_WIDTH,NEW_TANK2_WIDTH,OLD_TANK2_LENGTH,NEW_TANK2_LENGTH,OLD_TANK2_MAXIMUM,OLD_TANK3_SHAPE,NEW_TANK3_SHAPE,OLD_TANK3_TYPE,NEW_TANK3_TYPE,OLD_TANK3_VOLUME,NEW_TANK3_VOLUME,OLD_TANK3_HEIGHT,NEW_TANK3_HEIGHT,OLD_TANK3_WIDTH,NEW_TANK3_WIDTH,OLD_TANK3_LENGTH,NEW_TANK3_LENGTH,OLD_TANK3_MAXIMUM,CHANGED_BY, CHANGE_AT, NEW_TANK1_MAXIMUM, NEW_TANK2_MAXIMUM, NEW_TANK3_MAXIMUM
    ) VALUES (
        TANK_AUDIT_SEQ.NEXTVAL,
        :user_id,
        :site_code,
        :old_tank1_shape,
        :new_tank1_shape,
        :old_tank1_type,
        :new_tank1_type,
        :old_tank1_volume,
        :new_tank1_volume,
        :old_tank1_height,
        :new_tank1_height,
        :old_tank1_width,
        :new_tank1_width,
        :old_tank1_length,
        :new_tank1_length,
        :old_tank1_maximum,
        :old_tank2_shape,
        :new_tank2_shape,
        :old_tank2_type,
        :new_tank2_type,
        :old_tank2_volume,
        :new_tank2_volume,
        :old_tank2_height,
        :new_tank2_height,
        :old_tank2_width,
        :new_tank2_width,
        :old_tank2_length,
        :new_tank2_length,
        :old_tank2_maximum,
        :old_tank3_shape,
        :new_tank3_shape,
        :old_tank3_type,
        :new_tank3_type,
        :old_tank3_volume,
        :new_tank3_volume,
        :old_tank3_height,
        :new_tank3_height,
        :old_tank3_width,
        :new_tank3_width,
        :old_tank3_length,
        :new_tank3_length,
        :old_tank3_maximum,
        :changed_by,
        SYSDATE,
        :new_tank1_maximum,
        :new_tank2_maximum,
        :new_tank3_maximum
    )RETURNING DETAIL_ID INTO :last_detail_id";
    
    $insert_stmt = oci_parse($conn, $sql_insert);

    // Bind variables for the insert statement
    oci_bind_by_name($insert_stmt, ':user_id', $user_id1);
    oci_bind_by_name($insert_stmt, ':site_code', $sitecode);
    oci_bind_by_name($insert_stmt, ':old_tank1_shape', $TANK1_SHAPE);
    oci_bind_by_name($insert_stmt, ':new_tank1_shape', $t1shape);
    oci_bind_by_name($insert_stmt, ':old_tank1_type', $TANK1_TYPE);
    oci_bind_by_name($insert_stmt, ':new_tank1_type', $t1type);
    oci_bind_by_name($insert_stmt, ':old_tank1_volume', $TANK1_ACTUAL_VOLUME);
    oci_bind_by_name($insert_stmt, ':new_tank1_volume', $t1volume);
    oci_bind_by_name($insert_stmt, ':old_tank1_height', $TANK1_HEIGHT);
    oci_bind_by_name($insert_stmt, ':new_tank1_height', $t1height);
    oci_bind_by_name($insert_stmt, ':old_tank1_width', $TANK1_WIDTH);
    oci_bind_by_name($insert_stmt, ':new_tank1_width', $t1width);
    oci_bind_by_name($insert_stmt, ':old_tank1_length', $TANK1_LENGTH);
    oci_bind_by_name($insert_stmt, ':new_tank1_length', $t1length);
    oci_bind_by_name($insert_stmt, ':old_tank1_maximum', $TANK1_MAXIMUM);
    oci_bind_by_name($insert_stmt, ':old_tank2_shape', $TANK2_SHAPE);
    oci_bind_by_name($insert_stmt, ':new_tank2_shape', $t2shape);
    oci_bind_by_name($insert_stmt, ':old_tank2_type', $TANK2_TYPE);
    oci_bind_by_name($insert_stmt, ':new_tank2_type', $t2type);
    oci_bind_by_name($insert_stmt, ':old_tank2_volume', $TANK2_ACTUAL_VOLUME);
    oci_bind_by_name($insert_stmt, ':new_tank2_volume', $t2volume);
    oci_bind_by_name($insert_stmt, ':old_tank2_height', $TANK2_HEIGHT);
    oci_bind_by_name($insert_stmt, ':new_tank2_height', $t2height);
    oci_bind_by_name($insert_stmt, ':old_tank2_width', $TANK2_WIDTH);
    oci_bind_by_name($insert_stmt, ':new_tank2_width', $t2width);
    oci_bind_by_name($insert_stmt, ':old_tank2_length', $TANK2_LENGTH);
    oci_bind_by_name($insert_stmt, ':new_tank2_length', $t2length);
    oci_bind_by_name($insert_stmt, ':old_tank2_maximum', $TANK2_MAXIMUM);
    oci_bind_by_name($insert_stmt, ':old_tank3_shape', $TANK3_SHAPE);
    oci_bind_by_name($insert_stmt, ':new_tank3_shape', $t3shape);
    oci_bind_by_name($insert_stmt, ':old_tank3_type', $TANK3_TYPE);
    oci_bind_by_name($insert_stmt, ':new_tank3_type', $t3type);
    oci_bind_by_name($insert_stmt, ':old_tank3_volume', $TANK3_ACTUAL_VOLUME);
    oci_bind_by_name($insert_stmt, ':new_tank3_volume', $t3volume);
    oci_bind_by_name($insert_stmt, ':old_tank3_height', $TANK3_HEIGHT);
    oci_bind_by_name($insert_stmt, ':new_tank3_height', $t3height);
    oci_bind_by_name($insert_stmt, ':old_tank3_width', $TANK3_WIDTH);
    oci_bind_by_name($insert_stmt, ':new_tank3_width', $t3width);
    oci_bind_by_name($insert_stmt, ':old_tank3_length', $TANK3_LENGTH);
    oci_bind_by_name($insert_stmt, ':new_tank3_length', $t3length);
    oci_bind_by_name($insert_stmt, ':old_tank3_maximum', $TANK3_MAXIMUM);
    oci_bind_by_name($insert_stmt, ':changed_by', $username1);
    oci_bind_by_name($insert_stmt, ':new_tank1_maximum', $t1max);
    oci_bind_by_name($insert_stmt, ':new_tank2_maximum', $t2max);
    oci_bind_by_name($insert_stmt, ':new_tank3_maximum', $t3max);
    
    // Bind variable for returning the last inserted DETAIL_ID
    oci_bind_by_name($insert_stmt, ':last_detail_id', $last_detail_id, -1, SQLT_INT);
    
    // Execute the statement
    if (oci_execute($insert_stmt)) {
        //echo "Record inserted successfully. Last DETAIL_ID: " . $last_detail_id;
    } else {
        $e = oci_error($insert_stmt); // For detailed error
        echo "Error inserting record: " . $e['message'];
    }
    
    

    
}




} else {
    $e = oci_error($update_gen);  // For oci_execute errors
    echo "Error updating record: " . $e['message'];
}

// Clean up
oci_free_statement($update_gen);

///



if($has_rows == false){

    if (!empty($_POST['tank1']) && isset($_POST['tank1'])) {
    
        $sqltank1 = "INSERT INTO TANK (GID, TANK_SHAPE, TANK_TYPE, TANK_ACTUAL_VOLUME, TANK_HEIGHT, TANK_WIDTH, TANK_LENGTH, TANK_MAXIMUM ,TANK_INDEX) 
        VALUES (:gid , :shape, :type, :volume, :height, :width, :length ,:maximum,:indexx)";
    
        $insert_tank1 = oci_parse($conn, $sqltank1);
        oci_bind_by_name($insert_tank1, ':gid'      ,$old_GID);
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
        oci_bind_by_name($insert_tank2, ':gid'      ,$old_GID);
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
        oci_bind_by_name($insert_tank3, ':gid'      ,$old_GID);
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


if ($first_index == true && $second_index == false && $third_index == false){


    if (!empty($_POST['tank2']) && isset($_POST['tank2'])) {
    
        $sqltank2 = "INSERT INTO TANK (GID, TANK_SHAPE, TANK_TYPE, TANK_ACTUAL_VOLUME, TANK_HEIGHT, TANK_WIDTH, TANK_LENGTH, TANK_MAXIMUM ,TANK_INDEX) 
         VALUES (:gid , :shape, :type, :volume, :height, :width, :length ,:maximum,:indexx)";
     
         $insert_tank2 = oci_parse($conn, $sqltank2);
         oci_bind_by_name($insert_tank2, ':gid'      ,$old_GID);
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




     if (!empty($_POST['tank2']) && !empty($_POST['tank3']) && isset($_POST['tank3'])) {
    
    
    
        $sqltank3 = "INSERT INTO TANK (GID, TANK_SHAPE, TANK_TYPE, TANK_ACTUAL_VOLUME, TANK_HEIGHT, TANK_WIDTH, TANK_LENGTH, TANK_MAXIMUM ,TANK_INDEX) 
        VALUES (:gid , :shape, :type, :volume, :height, :width, :length ,:maximum,:indexx)";
    
        $insert_tank3 = oci_parse($conn, $sqltank3);
        oci_bind_by_name($insert_tank3, ':gid'      ,$old_GID);
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
elseif((empty($_POST['tank2'])) && !empty($_POST['tank3']) && isset($_POST['tank3'])){
    echo '<script>alert("Insert TANK2 before inserting TANK1")</script>';
}







}

if ($first_index == true && $second_index == true && $third_index == false){


    if (!empty($_POST['tank3']) && isset($_POST['tank3'])) {
    
    
    
        $sqltank3 = "INSERT INTO TANK (GID, TANK_SHAPE, TANK_TYPE, TANK_ACTUAL_VOLUME, TANK_HEIGHT, TANK_WIDTH, TANK_LENGTH, TANK_MAXIMUM ,TANK_INDEX) 
        VALUES (:gid , :shape, :type, :volume, :height, :width, :length ,:maximum,:indexx)";
    
        $insert_tank3 = oci_parse($conn, $sqltank3);
        oci_bind_by_name($insert_tank3, ':gid'      ,$old_GID);
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



}











///
}

else{

    if (!empty($_POST['Gen']) && isset($_POST['Gen'])) {

        $sqlgen = "INSERT INTO GENERTAOR (PID , GID , SITE_CODE, BRAND, ENGINE_BRAND, INITIAL_STATUS, QUANTITY, OWNERSHIP, CAGE, CAPACITY ,CURRENT_STATUS) 
        VALUES (:pid ,GENERATOR_SEQ.NEXTVAL, :sitecode, :brand, :engbrand, :status1, :qty, :owner1 ,:cage, :cap, :curr) RETURNING GID INTO :gid";
    
    $insert_gen = oci_parse($conn,$sqlgen);
    oci_bind_by_name($insert_gen, ':pid'      ,$old_PID);
    oci_bind_by_name($insert_gen, ':sitecode' ,$sitecode);
    oci_bind_by_name($insert_gen, ':brand'    ,$gen_brand);
    oci_bind_by_name($insert_gen, ':engbrand' ,$engine_brand);
    oci_bind_by_name($insert_gen, ':status1'  ,$status);
    oci_bind_by_name($insert_gen, ':qty'     ,$qty);
    oci_bind_by_name($insert_gen, ':owner1'   ,$ownership);
    oci_bind_by_name($insert_gen, ':cage'    ,$cage);
    oci_bind_by_name($insert_gen, ':cap'    ,$capacity);
    oci_bind_by_name($insert_gen, ':curr'    ,$currentstatus);
    oci_bind_by_name($insert_gen, ':gid' ,$NewGID, -1, SQLT_INT);
    
    
    if (oci_execute($insert_gen)) {  
        //echo "DONE";
        //echo "Inserted successfully. Last GID: " . $GID; 
     } 
       else { 
        $e = oci_error($insert_gen); echo "Error Updating Data: " . htmlentities($e['message']);
     
    
       }
    
    
    
    
    if (!empty($_POST['tank1']) && isset($_POST['tank1'])) {
    
        $sqltank1 = "INSERT INTO TANK (GID, TANK_SHAPE, TANK_TYPE, TANK_ACTUAL_VOLUME, TANK_HEIGHT, TANK_WIDTH, TANK_LENGTH, TANK_MAXIMUM ,TANK_INDEX) 
        VALUES (:gid , :shape, :type, :volume, :height, :width, :length ,:maximum,:indexx)";
    
        $insert_tank1 = oci_parse($conn, $sqltank1);
        oci_bind_by_name($insert_tank1, ':gid'      ,$NewGID);
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
        oci_bind_by_name($insert_tank2, ':gid'      ,$NewGID);
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
        oci_bind_by_name($insert_tank3, ':gid'      ,$NewGID);
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





}








$sql_amp = "SELECT * FROM AMPERE WHERE SITE_CODE=:sitecode";
$select_amp = oci_parse($conn, $sql_amp);
oci_bind_by_name($select_amp, ':sitecode', $sitecode);
oci_execute($select_amp);

if($row_amp = oci_fetch_array($select_amp, OCI_ASSOC + OCI_RETURN_NULLS))
{


    $CAPACITY = $row_amp['CAPACITY'];
    $DURATION = $row_amp['DURATION'];



    if($CAPACITY == $ampcapacity && $DURATION == $ampduration){}

    else{

        $sql_insert = "INSERT INTO AMPERE_AUDIT (
            DETAIL_ID,
            USER_ID,
            SITE_CODE,
            OLD_CAPACITY,
            NEW_CAPACITY,
            OLD_DURATION,
            NEW_DURATION,
            CHANGED_BY,
            CHANGE_AT
        ) VALUES (
            TANK_AUDIT_SEQ.NEXTVAL,
            :user_id,
            :site_code,
            :old_capacity,
            :new_capacity,
            :old_duration,
            :new_duration,
            :changed_by,
            SYSDATE
        ) RETURNING DETAIL_ID INTO :last_detail_id";
$insert_stmt = oci_parse($conn, $sql_insert);

// Bind variables for the insert statement
oci_bind_by_name($insert_stmt, ':user_id', $user_id1);
oci_bind_by_name($insert_stmt, ':site_code', $sitecode);
oci_bind_by_name($insert_stmt, ':old_capacity', $CAPACITY);
oci_bind_by_name($insert_stmt, ':new_capacity', $ampcapacity);
oci_bind_by_name($insert_stmt, ':old_duration', $DURATION);
oci_bind_by_name($insert_stmt, ':new_duration', $ampduration);
oci_bind_by_name($insert_stmt, ':changed_by', $username1);

// Bind variable for returning the last inserted DETAIL_ID
oci_bind_by_name($insert_stmt, ':last_detail_id', $last_detail_id, -1, SQLT_INT);

// Execute the statement
if (oci_execute($insert_stmt)) {
    //echo "Record inserted successfully. Last DETAIL_ID: " . $last_detail_id;
} else {
    $e = oci_error($insert_stmt); // For detailed error
    echo "Error inserting record: " . $e['message'];
}
    



    }
 
  $sqlamp = "UPDATE AMPERE 
  SET  CAPACITY = :capacity, 
       DURATION = :duration 
  WHERE PID = :pid";

$update_amp = oci_parse($conn, $sqlamp);

// Bind the parameters
oci_bind_by_name($update_amp, ':pid', $old_PID); // Unique identifier for the record to update
//oci_bind_by_name($update_amp, ':sitecode', $sitecode);
oci_bind_by_name($update_amp, ':capacity', $ampcapacity);
oci_bind_by_name($update_amp, ':duration', $ampduration);

// Execute the update
$result = oci_execute($update_amp);

if ($result) {
//echo "Record updated successfully.";
} else {
$e = oci_error($update_amp);  // For oci_execute errors
echo "Error updating record: " . $e['message'];
}

// Clean up
oci_free_statement($update_amp);


}

else{

    if (!empty($_POST['Ampere']) && isset($_POST['Ampere'])) {

        $sqlamp = "INSERT INTO AMPERE (PID , SITE_CODE , CAPACITY, DURATION) 
        VALUES (:pid ,:sitecode, :capacity, :duration)";
    
    $insert_amp = oci_parse($conn,$sqlamp);
    oci_bind_by_name($insert_amp, ':pid'      ,$old_PID);
    oci_bind_by_name($insert_amp, ':sitecode' ,$sitecode);
    oci_bind_by_name($insert_amp, ':capacity' ,$ampcapacity);
    oci_bind_by_name($insert_amp, ':duration' ,$ampduration);
    
    
    
    
    if (oci_execute($insert_amp)) {  
        //echo "DONE";
        //header("Location:Update_thankyou.html");
     } 
       else { 
        $e = oci_error($insert_amp); 
        echo "Error Updating Data: " . htmlentities($e['message']);
    
       }
    
    
    
    }
}

$sql_hyp = "SELECT * FROM HYPRID WHERE SITE_CODE=:sitecode";
$select_hyp = oci_parse($conn, $sql_hyp);
oci_bind_by_name($select_hyp, ':sitecode',$sitecode);
oci_execute($select_hyp);

if($row_hyp = oci_fetch_array($select_hyp, OCI_ASSOC + OCI_RETURN_NULLS))
{


    $TYPE            = $row_hyp['TYPE'];
    $PANELS_QUANTITY = $row_hyp['PANELS_QUANTITY'];
    $PANELS_CAPACITY = $row_hyp['PANELS_CAPACITY'];
    $STATUS          = $row_hyp['STATUS'];
    $MODULE_QUANTITY = $row_hyp['MODULE_QUANTITY'];
    $BRAND           = $row_hyp['BRAND'];


if($PANELS_QUANTITY == $panelqty && $PANELS_CAPACITY == $solarcapacity && $MODULE_QUANTITY == $solarmodqty 
&& $STATUS == $solarstatus  && $BRAND == $solarbrand && $TYPE == $solartype){

}
else{

    $sql_insert = "INSERT INTO HYPRID_AUDIT (
        DETAIL_ID, USER_ID, SITE_CODE, OLD_TYPE, NEW_TYPE, OLD_PANELS_QTY, NEW_PANELS_QTY, OLD_PANELS_CAP, NEW_PANELS_CAP, OLD_STATUS, NEW_STATUS, OLD_MODULE_QTY, NEW_MODULE_QTY, OLD_BRAND, NEW_BRAND, CHANGED_BY, CHANGE_AT
    ) VALUES (
        AMPERE_AUDIT_SEQ.NEXTVAL,
        :user_id,
        :site_code,
        :old_type,
        :new_type,
        :old_panels_qty,
        :new_panels_qty,
        :old_panels_cap,
        :new_panels_cap,
        :old_status,
        :new_status,
        :old_module_qty,
        :new_module_qty,
        :old_brand,
        :new_brand,
        :changed_by,
        SYSDATE
    ) RETURNING DETAIL_ID INTO :last_detail_id";
    
    $insert_stmt = oci_parse($conn, $sql_insert);

// Bind variables for the insert statement
oci_bind_by_name($insert_stmt, ':user_id', $user_id1);
oci_bind_by_name($insert_stmt, ':site_code', $sitecode);
oci_bind_by_name($insert_stmt, ':old_type', $TYPE);
oci_bind_by_name($insert_stmt, ':new_type', $solartype);
oci_bind_by_name($insert_stmt, ':old_panels_qty', $PANELS_QUANTITY);
oci_bind_by_name($insert_stmt, ':new_panels_qty', $panelqty);
oci_bind_by_name($insert_stmt, ':old_panels_cap', $PANELS_CAPACITY);
oci_bind_by_name($insert_stmt, ':new_panels_cap', $solarcapacity);
oci_bind_by_name($insert_stmt, ':old_status', $STATUS);
oci_bind_by_name($insert_stmt, ':new_status', $solarstatus);
oci_bind_by_name($insert_stmt, ':old_module_qty', $MODULE_QUANTITY); 
oci_bind_by_name($insert_stmt, ':new_module_qty', $solarmodqty);
oci_bind_by_name($insert_stmt, ':old_brand', $BRAND);
oci_bind_by_name($insert_stmt, ':new_brand', $solarbrand);
oci_bind_by_name($insert_stmt, ':changed_by', $username1);

// Bind variable for returning the last inserted DETAIL_ID
oci_bind_by_name($insert_stmt, ':last_detail_id', $last_detail_id, -1, SQLT_INT);

// Execute the statement
if (oci_execute($insert_stmt)) {
    //echo "Record inserted successfully. Last DETAIL_ID: " . $last_detail_id;
} else {
    $e = oci_error($insert_stmt); // For detailed error
    echo "Error inserting record: " . $e['message'];
}



}



  $sqlhyprid = "UPDATE HYPRID 
  SET  TYPE = :type, 
      PANELS_QUANTITY = :pqty, 
      PANELS_CAPACITY = :pcapacity, 
      STATUS = :status, 
      MODULE_QUANTITY = :mqty, 
      BRAND = :brand 
  WHERE PID = :pid";

$update_hyprid = oci_parse($conn, $sqlhyprid);

// Bind the parameters
oci_bind_by_name($update_hyprid, ':pid', $old_PID); 
//oci_bind_by_name($update_hyprid, ':sitecode', $sitecode);
oci_bind_by_name($update_hyprid, ':type', $solartype);
oci_bind_by_name($update_hyprid, ':pqty', $panelqty);
oci_bind_by_name($update_hyprid, ':pcapacity', $solarcapacity);
oci_bind_by_name($update_hyprid, ':status', $solarstatus);
oci_bind_by_name($update_hyprid, ':mqty', $solarmodqty);
oci_bind_by_name($update_hyprid, ':brand', $solarbrand);

// Execute the update
if (oci_execute($update_hyprid)) {  
//echo "Record updated successfully.";
// Optionally redirect or perform other actions

} else { 
$e = oci_error($update_hyprid); 
echo "Error updating data: " . htmlentities($e['message']);
}

// Clean up
oci_free_statement($update_hyprid);


}

else{

    if (!empty($_POST['Hyprid']) && isset($_POST['Hyprid'])) {

        $sqlhyprid = "INSERT INTO HYPRID (PID , SITE_CODE, TYPE, PANELS_QUANTITY, PANELS_CAPACITY, STATUS, MODULE_QUANTITY, BRAND) 
                      VALUES (:pid , :sitecode, :type, :pqty, :pcabacity, :status, :mqty,:brand)";
        
        
        $insert_hyprid = oci_parse($conn,$sqlhyprid);
        oci_bind_by_name($insert_hyprid, ':pid' ,$old_PID);
        oci_bind_by_name($insert_hyprid, ':sitecode' ,$sitecode);
        oci_bind_by_name($insert_hyprid, ':type' ,$solartype);
        oci_bind_by_name($insert_hyprid, ':pqty' ,$panelqty);
        oci_bind_by_name($insert_hyprid, ':pcabacity' ,$solarcapacity);
        oci_bind_by_name($insert_hyprid, ':status' ,$solarstatus);
        oci_bind_by_name($insert_hyprid, ':mqty' ,$solarmodqty);
        oci_bind_by_name($insert_hyprid, ':brand' ,$solarbrand);
        
        
        if (oci_execute($insert_hyprid)) {  
            //echo "DONE";
            //header("Location:Update_thankyou.html");
         } 
           else { 
            $e = oci_error($insert_hyprid); echo "Error Updating Data: " . htmlentities($e['message']);
        
           }
        
        
        }


}


$sql_batt = "SELECT * FROM BATTERIES WHERE SITE_CODE=:sitecode";
$select_batt = oci_parse($conn, $sql_batt);
oci_bind_by_name($select_batt, ':sitecode', $sitecode);
oci_execute($select_batt);

if($row_batt = oci_fetch_array($select_batt, OCI_ASSOC + OCI_RETURN_NULLS))
{

    $G1_BRAND             = $row_batt['G1_BRAND'];
    $G1_CAPACITY          = $row_batt['G1_CAPACITY'];
    $G1_TYPE              = $row_batt['G1_TYPE'];
    $G1_STATUS            = $row_batt['G1_STATUS'];
    $G1_QUANTITY          = $row_batt['G1_QUANTITY'];
    $G1_INSTALLATION_DATE = $row_batt['G1_INSTALLATION_DATE'];
    $G2_BRAND             = $row_batt['G2_BRAND'];
    $G2_CAPACITY          = $row_batt['G2_CAPACITY'];
    $G2_TYPE              = $row_batt['G2_TYPE'];
    $G2_STATUS            = $row_batt['G2_STATUS'];
    $G2_QUANTITY          = $row_batt['G2_QUANTITY'];
    $G2_INSTALLATION_DATE = $row_batt['G2_INSTALLATION_DATE'];


    if( $G1_BRAND == $b1brand && $G2_BRAND == $b2brand && $G1_CAPACITY == $b1capacity && $G2_CAPACITY == $b2capacity && $G1_TYPE == $b1type && $G2_TYPE == $b2type 
    && $G1_STATUS == $b1status && $G2_STATUS == $b2status && $G1_QUANTITY == $b1qty && $G2_QUANTITY == $b2qty && $G1_INSTALLATION_DATE == $b1b1date && $G2_INSTALLATION_DATE == $b2b1date) {

    }

else{

    $sql_insert = "INSERT INTO BATTERIES_AUDIT (
        DETAIL_ID,
        USER_ID,
        SITE_CODE,
        OLD_G1_BRAND,
        NEW_G1_BRAND,
        OLD_G1_CAPACITY,
        NEW_G1_CAPACITY,
        OLD_G1_TYPE,
        NEW_G1_TYPE,
        OLD_G1_STATUS,
        NEW_G1_STATUS,
        OLD_G1_QUANTITY,
        NEW_G1_QUANTITY,
        OLD_G1_INSTALL_DATE,
        NEW_G1_INSTALL_DATE,
        OLD_G2_BRAND,
        NEW_G2_BRAND,
        OLD_G2_CAPACITY,
        NEW_G2_CAPACITY,
        OLD_G2_TYPE,
        NEW_G2_TYPE,
        OLD_G2_STATUS,
        NEW_G2_STATUS,
        OLD_G2_QUANTITY,
        NEW_G2_QUANTITY,
        OLD_G2_INSTALL_DATE,
        NEW_G2_INSTALL_DATE,
        CHANGED_BY,
        CHANGE_AT
    ) VALUES (
        BATTERIES_AUDIT_SEQ.NEXTVAL,
        :user_id,
        :site_code,
        :old_g1_brand,
        :new_g1_brand,
        :old_g1_capacity,
        :new_g1_capacity,
        :old_g1_type,
        :new_g1_type,
        :old_g1_status,
        :new_g1_status,
        :old_g1_quantity,
        :new_g1_quantity,
        :old_g1_install_date,
        :new_g1_install_date,
        :old_g2_brand,
        :new_g2_brand,
        :old_g2_capacity,
        :new_g2_capacity,
        :old_g2_type,
        :new_g2_type,
        :old_g2_status,
        :new_g2_status,
        :old_g2_quantity,
        :new_g2_quantity,
        :old_g2_install_date,
        :new_g2_install_date,
        :changed_by,
        SYSDATE
    ) RETURNING DETAIL_ID INTO :last_detail_id";



$insert_stmt = oci_parse($conn, $sql_insert);

// Bind variables for the insert statement
oci_bind_by_name($insert_stmt, ':user_id', $user_id1);
oci_bind_by_name($insert_stmt, ':site_code', $sitecode);
oci_bind_by_name($insert_stmt, ':old_g1_brand', $G1_BRAND);
oci_bind_by_name($insert_stmt, ':new_g1_brand', $b1brand);
oci_bind_by_name($insert_stmt, ':old_g1_capacity', $G1_CAPACITY);
oci_bind_by_name($insert_stmt, ':new_g1_capacity', $b1capacity);
oci_bind_by_name($insert_stmt, ':old_g1_type', $G1_TYPE);
oci_bind_by_name($insert_stmt, ':new_g1_type', $b1type);
oci_bind_by_name($insert_stmt, ':old_g1_status', $G1_STATUS);
oci_bind_by_name($insert_stmt, ':new_g1_status', $b1status);
oci_bind_by_name($insert_stmt, ':old_g1_quantity', $G1_QUANTITY);
oci_bind_by_name($insert_stmt, ':new_g1_quantity', $b1qty);
oci_bind_by_name($insert_stmt, ':old_g1_install_date', $G1_INSTALLATION_DATE);
oci_bind_by_name($insert_stmt, ':new_g1_install_date', $b1b1date);


oci_bind_by_name($insert_stmt, ':old_g2_brand', $G2_BRAND);
oci_bind_by_name($insert_stmt, ':new_g2_brand', $b2brand);
oci_bind_by_name($insert_stmt, ':old_g2_capacity', $G2_CAPACITY);
oci_bind_by_name($insert_stmt, ':new_g2_capacity', $b2capacity);
oci_bind_by_name($insert_stmt, ':old_g2_type', $G2_TYPE);
oci_bind_by_name($insert_stmt, ':new_g2_type', $b2type);
oci_bind_by_name($insert_stmt, ':old_g2_status', $G2_STATUS);
oci_bind_by_name($insert_stmt, ':new_g2_status', $b2status);
oci_bind_by_name($insert_stmt, ':old_g2_quantity', $G2_QUANTITY);
oci_bind_by_name($insert_stmt, ':new_g2_quantity', $b2qty);
oci_bind_by_name($insert_stmt, ':old_g2_install_date', $G2_INSTALLATION_DATE);
oci_bind_by_name($insert_stmt, ':new_g2_install_date', $b2b1date);
oci_bind_by_name($insert_stmt, ':changed_by', $username1);

// Bind variable for returning the last inserted DETAIL_ID
oci_bind_by_name($insert_stmt, ':last_detail_id', $last_detail_id, -1, SQLT_INT);

// Execute the statement
if (oci_execute($insert_stmt)) {
   // echo "Record inserted successfully. Last DETAIL_ID: " . $last_detail_id;
} else {
    $e = oci_error($insert_stmt); // For detailed error
    echo "Error inserting record: " . $e['message'];
}

    
}







  $sqlbattaries = "UPDATE BATTERIES 
  SET G1_BRAND = :brand, 
      G1_CAPACITY = :cabacity, 
      G1_TYPE = :type, 
      G1_STATUS = :status, 
      G1_QUANTITY = :qty, 
      G1_INSTALLATION_DATE = :date1,
      G2_BRAND = :brand2, 
      G2_CAPACITY = :cabacity2, 
      G2_TYPE = :type2, 
      G2_STATUS = :status2, 
      G2_QUANTITY = :qty2, 
      G2_INSTALLATION_DATE = :date2 
  WHERE PID = :pid";

$update_battaries = oci_parse($conn, $sqlbattaries);

// Bind the parameters
oci_bind_by_name($update_battaries, ':pid', $old_PID);
//oci_bind_by_name($update_battaries, ':sitecode', $sitecode);
oci_bind_by_name($update_battaries, ':brand', $b1brand);
oci_bind_by_name($update_battaries, ':cabacity', $b1capacity);
oci_bind_by_name($update_battaries, ':type', $b1type);
oci_bind_by_name($update_battaries, ':status', $b1status);
oci_bind_by_name($update_battaries, ':qty', $b1qty);
oci_bind_by_name($update_battaries, ':date1', $b1b1date);
oci_bind_by_name($update_battaries, ':brand2', $b2brand);
oci_bind_by_name($update_battaries, ':cabacity2', $b2capacity);
oci_bind_by_name($update_battaries, ':type2', $b2type);
oci_bind_by_name($update_battaries, ':status2', $b2status);
oci_bind_by_name($update_battaries, ':qty2', $b2qty);
oci_bind_by_name($update_battaries, ':date2', $b2b1date);

// Execute the update
if (oci_execute($update_battaries)) {  
//echo "Record updated successfully.";
// Optionally redirect or perform other actions
// header("Location: Update_thankyou.html");
} else { 
$e = oci_error($update_battaries); 
echo "Error updating data: " . htmlentities($e['message']);
}

// Clean up
oci_free_statement($update_battaries);

}
else{



    if (!empty($_POST['B1Battaries']) && isset($_POST['B1Battaries'])) {

        $sqlbattaries = "INSERT INTO BATTERIES (PID , SITE_CODE, G1_BRAND, G1_CAPACITY, G1_TYPE, G1_STATUS, G1_QUANTITY, G1_INSTALLATION_DATE) 
                         VALUES (:pid , :sitecode, :brand, :cabacity, :type , :status, :qty, :date1)";
        
        
        $insert_battaries = oci_parse($conn,$sqlbattaries);
        oci_bind_by_name($insert_battaries, ':pid' ,$old_PID);
        oci_bind_by_name($insert_battaries, ':sitecode' ,$sitecode);
        oci_bind_by_name($insert_battaries, ':brand'    ,$b1brand);
        oci_bind_by_name($insert_battaries, ':cabacity' ,$b1capacity);
        oci_bind_by_name($insert_battaries, ':type'     ,$b1type);
        oci_bind_by_name($insert_battaries, ':status'   ,$b1status);
        oci_bind_by_name($insert_battaries, ':qty'      ,$b1qty);
        oci_bind_by_name($insert_battaries, ':date1'     ,$b1b1date);

        
        if (oci_execute($insert_battaries)) {  
            //echo "DONE";
            //header("Location:Update_thankyou.html");
         } 
           else { 
            $e = oci_error($insert_battaries); echo "Error Updating Data: " . htmlentities($e['message']);
        
           }
        
     
        }


            if (!empty($_POST['B1Battaries']) &&!empty($_POST['B2Battaries']) && isset($_POST['B2Battaries'])) {

                $sqlbattaries2 = "UPDATE BATTERIES SET 
                G2_BRAND =:brand, 
                G2_CAPACITY =:cabacity, 
                G2_TYPE=:type, 
                G2_STATUS =:status, 
                G2_QUANTITY =:qty, 
                G2_INSTALLATION_DATE=:date2
                WHERE PID =:pid";
                
                



                $insert_battaries2 = oci_parse($conn,$sqlbattaries2);
                oci_bind_by_name($insert_battaries2, ':pid' ,$old_PID);
                //oci_bind_by_name($insert_battaries2, ':sitecode' ,$sitecode);
                oci_bind_by_name($insert_battaries2, ':brand'    ,$b2brand);
                oci_bind_by_name($insert_battaries2, ':cabacity' ,$b2capacity);
                oci_bind_by_name($insert_battaries2, ':type'     ,$b2type);
                oci_bind_by_name($insert_battaries2, ':status'   ,$b2status);
                oci_bind_by_name($insert_battaries2, ':qty'      ,$b2qty);
                oci_bind_by_name($insert_battaries2, ':date2'     ,$b2b1date);
        
                
                if (oci_execute($insert_battaries2)) {  
                    //echo "DONE";
                    //header("Location:Update_thankyou.html");
                 } 
                   else { 
                    $e = oci_error($insert_battaries2); echo "Error Updating Data: " . htmlentities($e['message']);
                
                   }
                
             
                }

                else{
                    //echo "Insert Batteries Groupe1 before Groupe2";
                    echo '<script>alert("Insert Batteries Groupe1 before Groupe2")</script>';
                }






}


$sql_lines = "SELECT * FROM LINES WHERE SITE_CODE=:sitecode";
$select_lines = oci_parse($conn, $sql_lines);
oci_bind_by_name($select_lines, ':sitecode',$sitecode);
oci_execute($select_lines);

if($row_lines = oci_fetch_array($select_lines, OCI_ASSOC + OCI_RETURN_NULLS))
{

    $old_type = $row_lines['TYPE'];

    if($old_type == $lines){}
else{

    $sql_insert = "INSERT INTO LINES_AUDIT (
        DETAIL_ID,
        USER_ID,
        SITE_CODE,
        OLD_TYPE,
        NEW_TYPE,
        CHANGED_BY,
        CHANGE_AT
    ) VALUES (
        LINES_AUDIT_SEQ.NEXTVAL,
        :user_id,
        :site_code,
        :old_type,
        :new_type,
        :changed_by,
        SYSDATE
    ) RETURNING DETAIL_ID INTO :last_detail_id";
    
    $insert_stmt = oci_parse($conn, $sql_insert);

// Bind variables for the insert statement
oci_bind_by_name($insert_stmt, ':user_id', $user_id1);
oci_bind_by_name($insert_stmt, ':site_code', $sitecode);
oci_bind_by_name($insert_stmt, ':old_type', $old_type);
oci_bind_by_name($insert_stmt, ':new_type', $lines);
oci_bind_by_name($insert_stmt, ':changed_by', $username1);

// Bind variable for returning the last inserted DETAIL_ID
oci_bind_by_name($insert_stmt, ':last_detail_id', $last_detail_id, -1, SQLT_INT);

if (oci_execute($insert_stmt)) {
    //echo "Record inserted successfully. Last DETAIL_ID: " . $last_detail_id;
} else {
    $e = oci_error($insert_stmt); // For detailed error
    echo "Error inserting record: " . $e['message'];
}



} 

  $sqllines = "UPDATE LINES 
  SET  TYPE = :type 
  WHERE PID = :pid";

$update_lines = oci_parse($conn, $sqllines);

// Bind the parameters
oci_bind_by_name($update_lines, ':pid', $old_PID); 
//oci_bind_by_name($update_lines, ':sitecode', $sitecode);
oci_bind_by_name($update_lines, ':type', $lines);


if (oci_execute($update_lines)) {  
//echo "Record updated successfully.";
// Optionally redirect or perform other actions

} else { 
$e = oci_error($update_lines); 
echo "Error updating data: " . htmlentities($e['message']);
}

// Clean up
oci_free_statement($update_lines);

}

else{
    if (!empty($_POST['lines']) && isset($_POST['lines'])) {

        $sqllines = "INSERT INTO LINES (PID, SITE_CODE, TYPE) 
                         VALUES (:pid ,:sitecode, :type)";
        
        
        $insert_lines = oci_parse($conn,$sqllines);
        oci_bind_by_name($insert_lines, ':pid'      ,$old_PID);
        oci_bind_by_name($insert_lines, ':sitecode' ,$sitecode);
        oci_bind_by_name($insert_lines, ':type'     ,$lines);


        
        if (oci_execute($insert_lines)) {  
            //echo "DONE";
            //header("Location:Update_thankyou.html");
         } 
           else { 
            $e = oci_error($insert_lines); echo "Error Updating Data: " . htmlentities($e['message']);
        
           }
        
     
        }
}

//echo '<script>alert("'.$row["SITE_CODE"].' Power backup updated Successfully")</script>';
$power = "SELECT * FROM POWER_BACKUP WHERE SITE_CODE =:sitecode";

    
$insert_power = oci_parse($conn, $power);

oci_bind_by_name($insert_power, ':sitecode', $sitecode);

oci_execute($insert_power);

if($row_power = oci_fetch_array($insert_power, OCI_ASSOC + OCI_RETURN_NULLS)) {  
 

$OLD_GURD1 = $row_power ['GURDE'] ?? '';
$OLD_CAGE1 = $row_power ['CAGE'] ?? '';

    if($OLD_CAGE1 != $sitecage){

        $sqlcagee = "UPDATE POWER_BACKUP SET CAGE =:cage WHERE SITE_CODE =:sitecode ";
                                        
    
        $update_cage = oci_parse($conn,$sqlcagee);
        oci_bind_by_name($update_cage, ':sitecode' ,$sitecode);
        oci_bind_by_name($update_cage, ':cage' ,$sitecage);  
        oci_execute($update_cage); 
    }

    if($OLD_GURD1 != $gurde ){

        $sqlgurde = "UPDATE POWER_BACKUP SET GURDE =:gurde WHERE SITE_CODE =:sitecode ";
                                            
        
        $update_gurde = oci_parse($conn,$sqlgurde);
        oci_bind_by_name($update_gurde, ':sitecode' ,$sitecode);
        oci_bind_by_name($update_gurde, ':gurde' ,$gurde);
        oci_execute($update_gurde);
    }



}
}

$power_backup = [];

$sqlpower = "SELECT SITE_CODE,OWNERSHIP, QUANTITY FROM  GENERTAOR WHERE SITE_CODE=:sitecode";      
$result_power = oci_parse($conn,$sqlpower);
oci_bind_by_name($result_power, ':sitecode'   ,$sitecode);
//oci_bind_by_name($select_power, ':gurde' ,$gurde);
oci_execute($result_power);

if($rowpower = oci_fetch_array($result_power, OCI_ASSOC + OCI_RETURN_NULLS)){
$power_backup[] = 'Generator';


$ownership = $rowpower['OWNERSHIP'];
$quantity  = $rowpower['QUANTITY'];
if($ownership == 'MTN'){
  $ooss      = '-';
  $rentedd   ='-';
  $othermtnn = '-';
  $otherr    = '-';
  $syriatell = '-';
  $switchh   ='-';
  $stee      ='-';
    $sql = "UPDATE POWER_BACKUP SET MTN_GEN =:mtn ,QUANTITY=:qty ,MTN_OOS_GEN=:oos, 
    MTN_RENTED_GEN=:rented,OTHER_MTN_GEN=:othermtn , OTHER_GEN=: other, 
    STE_GEN=:ste,SWITCH_GEN=:switch,
    SYRIATEL_GEN = :syriatel
    WHERE SITE_CODE=:sitecode"; 
    $update_gen = oci_parse($conn,$sql);

    oci_bind_by_name($update_gen, ':sitecode' ,$sitecode);
    oci_bind_by_name($update_gen, ':mtn' ,$ownership);
    oci_bind_by_name($update_gen, ':qty' ,$quantity);
    oci_bind_by_name($update_gen, ':oos' ,$ooss);
    oci_bind_by_name($update_gen, ':rented' ,$rentedd);
    oci_bind_by_name($update_gen, ':switch' ,$switchh);
    oci_bind_by_name($update_gen, ':syriatel' ,$syriatell);
    oci_bind_by_name($update_gen, ':othermtn' ,$othermtnn);
    oci_bind_by_name($update_gen, ':other' ,$otherr);
    oci_bind_by_name($update_gen, ':ste' ,$stee);
    oci_execute($update_gen);        

    

}


elseif($ownership == 'MTN_OOS'){

  $mtngenn   = '-';
  $rentedd   ='-';
  $othermtnn = '-';
  $otherr    = '-';
  $syriatell = '-';
  $switchh   ='-';
  $quantityy =1; 
  $stee      ='-';
  

$sql = "UPDATE POWER_BACKUP SET MTN_OOS_GEN =:mtn,  
      MTN_GEN =:mtn1 ,QUANTITY=:qty,
      MTN_RENTED_GEN=:rented,OTHER_MTN_GEN=:othermtn , OTHER_GEN=: other, 
      STE_GEN=:ste,SWITCH_GEN=:switch,
      SYRIATEL_GEN =:syriatel
WHERE SITE_CODE=:sitecode"; 
$update_gen = oci_parse($conn,$sql);

oci_bind_by_name($update_gen, ':sitecode' ,$sitecode);
oci_bind_by_name($update_gen, ':mtn' ,$ownership);
oci_bind_by_name($update_gen, ':qty' ,$quantityy);
oci_bind_by_name($update_gen, ':mtn1' ,$mtngenn);
oci_bind_by_name($update_gen, ':rented' ,$rentedd);
oci_bind_by_name($update_gen, ':switch' ,$switchh);
oci_bind_by_name($update_gen, ':syriatel' ,$syriatell);
oci_bind_by_name($update_gen, ':othermtn' ,$othermtnn);
oci_bind_by_name($update_gen, ':other' ,$otherr);
oci_bind_by_name($update_gen, ':ste' ,$stee);


oci_execute($update_gen);        



}

elseif($ownership == 'MTN_Rented'){

  $mtngenn   = '-';
  //$rentedd   ='-';
  $othermtnn = '-';
  $otherr    = '-';
  $syriatell = '-';
  $switchh   ='-';
  $quantityy = 1; 
  $stee      ='-';
  $ooss      = '-';

  

$sql = "UPDATE POWER_BACKUP SET MTN_RENTED_GEN =:mtn,  
      MTN_GEN =:mtn1 ,QUANTITY=:qty , MTN_OOS_GEN =:oos,
      OTHER_MTN_GEN=:othermtn , OTHER_GEN=: other, 
      STE_GEN=:ste,SWITCH_GEN=:switch,
      SYRIATEL_GEN = :syriatel

WHERE SITE_CODE=:sitecode"; 
$update_gen = oci_parse($conn,$sql);

oci_bind_by_name($update_gen, ':sitecode' ,$sitecode);
oci_bind_by_name($update_gen, ':mtn' ,$ownership);
oci_bind_by_name($update_gen, ':qty' ,$quantityy);
oci_bind_by_name($update_gen, ':oos' ,$ooss);
oci_bind_by_name($update_gen, ':mtn1',$mtngenn);
oci_bind_by_name($update_gen, ':switch',$switchh);
oci_bind_by_name($update_gen, ':syriatel',$syriatell);
oci_bind_by_name($update_gen, ':other' ,$otherr);
oci_bind_by_name($update_gen, ':ste' ,$stee);
oci_bind_by_name($update_gen, ':othermtn' ,$othermtnn);




oci_execute($update_gen);        



}


elseif($ownership == 'Other_MTN'){

  $mtngenn   = '-';
 
  $rentedd = '-';
  $otherr    = '-';
  $syriatell = '-';
  $switchh   ='-';
  $quantityy = 1; 
  $stee      ='-';
  $ooss      = '-';



$sql = "UPDATE POWER_BACKUP SET OTHER_MTN_GEN =:mtn, 


      MTN_RENTED_GEN =:rented,  
      MTN_GEN =:mtn1 ,QUANTITY=:qty , MTN_OOS_GEN =:oos,
      OTHER_GEN=: other, 
      STE_GEN=:ste,SWITCH_GEN=:switch,
      SYRIATEL_GEN = :syriatel
WHERE SITE_CODE=:sitecode"; 
$update_gen = oci_parse($conn,$sql);

oci_bind_by_name($update_gen, ':sitecode' ,$sitecode);
oci_bind_by_name($update_gen, ':mtn' ,$ownership);

oci_bind_by_name($update_gen, ':qty' ,$quantityy);
oci_bind_by_name($update_gen, ':oos' ,$ooss);
oci_bind_by_name($update_gen, ':mtn1' ,$mtngenn);
oci_bind_by_name($update_gen, ':switch' ,$switchh);
oci_bind_by_name($update_gen, ':syriatel' ,$syriatell);
oci_bind_by_name($update_gen, ':rented' ,$rentedd);
oci_bind_by_name($update_gen, ':other' ,$otherr);
oci_bind_by_name($update_gen, ':ste' ,$stee);




oci_execute($update_gen);        



}



elseif($ownership == 'Other'){

  $mtngenn   = '-';
 
  $othermtnn = '-';
  $rentedd    = '-';
  $syriatell = '-';
  $switchh   ='-';
  $quantityy = 1; 
  $stee      ='-';
  $ooss      = '-';

$sql = "UPDATE POWER_BACKUP SET OTHER_GEN =:mtn,  
OTHER_MTN_GEN =:othermtn,  
MTN_RENTED_GEN =:rented,  
MTN_GEN =:mtn1 ,QUANTITY=:qty , MTN_OOS_GEN =:oos,
STE_GEN=:ste,SWITCH_GEN=:switch,
SYRIATEL_GEN = :syriatel

WHERE SITE_CODE=:sitecode"; 
$update_gen = oci_parse($conn,$sql);

oci_bind_by_name($update_gen, ':sitecode' ,$sitecode);
oci_bind_by_name($update_gen, ':mtn' ,$ownership);
oci_bind_by_name($update_gen, ':qty' ,$quantityy);
oci_bind_by_name($update_gen, ':oos' ,$ooss);
oci_bind_by_name($update_gen, ':mtn1' ,$mtngenn);
oci_bind_by_name($update_gen, ':switch' ,$switchh);
oci_bind_by_name($update_gen, ':syriatel' ,$syriatell);
oci_bind_by_name($update_gen, ':othermtn' ,$othermtnn);
oci_bind_by_name($update_gen, ':rented' ,$rentedd);
oci_bind_by_name($update_gen, ':ste' ,$stee);

oci_execute($update_gen);        



}
elseif($ownership == 'STE'){
  $mtngenn   = '-';
 
  $othermtnn = '-';
  $otherr    = '-';
  $syriatell = '-';
  $switchh   ='-';
  $quantityy = 1; 
  $rentedd   ='-';
  $ooss      = '-';

$sql = "UPDATE POWER_BACKUP SET STE_GEN =:mtn,  
OTHER_GEN =:other,  
OTHER_MTN_GEN =:othermtn,  
MTN_RENTED_GEN =:rented,  
MTN_GEN =:mtn1 ,QUANTITY=:qty , MTN_OOS_GEN =:oos,
SWITCH_GEN=:switch,
SYRIATEL_GEN = :syriatel

WHERE SITE_CODE=:sitecode"; 
$update_gen = oci_parse($conn,$sql);

oci_bind_by_name($update_gen, ':sitecode' ,$sitecode);
oci_bind_by_name($update_gen, ':mtn' ,$ownership);
oci_bind_by_name($update_gen, ':qty' ,$quantityy);
oci_bind_by_name($update_gen, ':oos' ,$ooss);
oci_bind_by_name($update_gen, ':mtn1' ,$mtngenn);
oci_bind_by_name($update_gen, ':switch' ,$switchh);
oci_bind_by_name($update_gen, ':syriatel' ,$syriatell);
oci_bind_by_name($update_gen, ':othermtn' ,$othermtnn);
oci_bind_by_name($update_gen, ':other' ,$otherr);
oci_bind_by_name($update_gen, ':rented' ,$rentedd);

oci_execute($update_gen);        



}


elseif($ownership == 'Switch'){
  $mtngenn   = '-';
   $othermtnn = '-';
  $otherr    = '-';
  $syriatell = '-';
  $rentedd   ='-';
  $quantityy = 1; 
  $stee      ='-';
  $ooss      = '-';
  //echo "hiiii";


$sql = "UPDATE POWER_BACKUP SET SWITCH_GEN =:mtn, 
STE_GEN =:ste,  
OTHER_GEN =:other,  
OTHER_MTN_GEN =:othermtn,  
MTN_RENTED_GEN =:rented,  
MTN_GEN =:mtn1 ,QUANTITY=:qty , MTN_OOS_GEN =:oos,
OTHER_GEN=: other, 
SYRIATEL_GEN = :syriatel

WHERE SITE_CODE=:sitecode"; 
$update_gen = oci_parse($conn,$sql);

oci_bind_by_name($update_gen, ':sitecode',$sitecode);
oci_bind_by_name($update_gen, ':mtn' ,$ownership);
oci_bind_by_name($update_gen, ':qty' ,$quantityy);
oci_bind_by_name($update_gen, ':oos' ,$ooss);
oci_bind_by_name($update_gen, ':mtn1' ,$mtngenn);
oci_bind_by_name($update_gen, ':rented' ,$rentedd);
oci_bind_by_name($update_gen, ':syriatel' ,$syriatell);
oci_bind_by_name($update_gen, ':othermtn' ,$othermtnn);
oci_bind_by_name($update_gen, ':other' ,$otherr);
oci_bind_by_name($update_gen, ':ste' ,$stee);

oci_execute($update_gen);        



}


elseif($ownership == 'Syriatel'){

  $mtngenn   = '-';
  $othermtnn = '-';
  $otherr    = '-';
  $rentedd = '-';
  $switchh   ='-';
  $quantityy = 1; 
  $stee      ='-';
  $ooss      = '-';

$sql = "UPDATE POWER_BACKUP SET SYRIATEL_GEN =:mtn,  
SWITCH_GEN =:mtn  
STE_GEN =:ste,  
OTHER_GEN =:other,  
OTHER_MTN_GEN =:othermtn,  
MTN_RENTED_GEN =:rented,  
MTN_GEN =:mtn1 ,QUANTITY=:qty , MTN_OOS_GEN =:oos,
OTHER_GEN=: other
WHERE SITE_CODE=:sitecode"; 
$update_gen = oci_parse($conn,$sql);

oci_bind_by_name($update_gen, ':sitecode' ,$sitecode);
oci_bind_by_name($update_gen, ':mtn' ,$ownership);
oci_bind_by_name($update_gen, ':qty' ,$quantityy);
oci_bind_by_name($update_gen, ':oos' ,$ooss);
oci_bind_by_name($update_gen, ':mtn1' ,$mtngenn);
oci_bind_by_name($update_gen, ':switch' ,$switchh);
oci_bind_by_name($update_gen, ':rented' ,$rentedd);
oci_bind_by_name($update_gen, ':othermtn' ,$othermtnn);
oci_bind_by_name($update_gen, ':other' ,$otherr);
oci_bind_by_name($update_gen, ':ste' ,$stee);

oci_execute($update_gen);        



}



}        

$sqlhyp = "SELECT SITE_CODE,BRAND FROM  HYPRID WHERE SITE_CODE=:sitecode";      
$result_hyp = oci_parse($conn,$sqlhyp);
oci_bind_by_name($result_hyp, ':sitecode'   ,$sitecode);
//oci_bind_by_name($result_hyp, ':gurde' ,$gurde);
oci_execute($result_hyp);

if($rowhyp = oci_fetch_array($result_hyp, OCI_ASSOC + OCI_RETURN_NULLS)){
    $power_backup[] = 'Hyprid';
$brand = $rowhyp['BRAND'];


if($brand == 'hyprid'){

$sql = "UPDATE POWER_BACKUP SET HYPRID =:mtn WHERE SITE_CODE=:sitecode"; 
$update_hyp = oci_parse($conn,$sql);

oci_bind_by_name($update_hyp, ':sitecode' ,$sitecode);
oci_bind_by_name($update_hyp, ':mtn' ,$brand);
oci_execute($update_hyp);        



}


elseif($brand == 'inactive'){

    $inst = '-';
$sql = "UPDATE POWER_BACKUP SET HYPRID_INACTIVE =:mtn , HYPRID_INSTALLED =:ins WHERE SITE_CODE=:sitecode"; 
$update_hyp = oci_parse($conn,$sql);

oci_bind_by_name($update_hyp, ':sitecode' ,$sitecode);
oci_bind_by_name($update_hyp, ':mtn' ,$brand);
oci_bind_by_name($update_hyp, ':ins' ,$inst);
oci_execute($update_hyp);        



}

elseif($brand == 'installed'){
    $inac = '-';   
$sql = "UPDATE POWER_BACKUP SET HYPRID_INSTALLED =:mtn , HYPRID_INACTIVE =:inac WHERE SITE_CODE=:sitecode"; 
$update_hyp = oci_parse($conn,$sql);

oci_bind_by_name($update_hyp, ':sitecode' ,$sitecode);
oci_bind_by_name($update_hyp, ':mtn'  ,$brand);
oci_bind_by_name($update_hyp, ':inac' ,$inac);
oci_execute($update_hyp);        



}

elseif($brand == 'OOS'){
        
$sql = "UPDATE POWER_BACKUP SET HYPRID_OOS =:mtn WHERE SITE_CODE=:sitecode"; 
$update_hyp = oci_parse($conn,$sql);

oci_bind_by_name($update_hyp, ':sitecode' ,$sitecode);
oci_bind_by_name($update_hyp, ':mtn' ,$brand);
oci_execute($update_hyp);        

}    

elseif($brand == 'Wind'){
        
$sql = "UPDATE POWER_BACKUP SET HYPRID_WIND =:mtn WHERE SITE_CODE=:sitecode"; 
$update_hyp = oci_parse($conn,$sql);

oci_bind_by_name($update_hyp, ':sitecode' ,$sitecode);
oci_bind_by_name($update_hyp, ':mtn' ,$brand);
oci_execute($update_hyp);        



}

}

$sqlamp = "SELECT SITE_CODE FROM  AMPERE WHERE SITE_CODE=:sitecode";      
$result_amp = oci_parse($conn,$sqlamp);
oci_bind_by_name($result_amp, ':sitecode'   ,$sitecode);

oci_execute($result_amp);

if($rowamp = oci_fetch_array($result_amp, OCI_ASSOC + OCI_RETURN_NULLS)){

    $power_backup[] = 'Ampere';
$code = $rowamp['SITE_CODE'];
if(!empty($code) && isset($code)){

$amp = "Ampere";
$sql = "UPDATE POWER_BACKUP SET AMPERE =:mtn WHERE SITE_CODE=:sitecode"; 
$update_amp = oci_parse($conn,$sql);

oci_bind_by_name($update_amp, ':sitecode' ,$sitecode);
oci_bind_by_name($update_amp, ':mtn' ,$amp);
oci_execute($update_amp);   

}

}

$sqlbatt = "SELECT SITE_CODE,G1_TYPE ,G2_TYPE FROM  BATTERIES WHERE SITE_CODE=:sitecode";      
$result_batt = oci_parse($conn,$sqlbatt);
oci_bind_by_name($result_batt, ':sitecode'   ,$sitecode);

oci_execute($result_batt);

if($rowbatt = oci_fetch_array($result_batt, OCI_ASSOC + OCI_RETURN_NULLS)){
    $power_backup[] = 'Batteries';

$type1 = $rowbatt['G1_TYPE'];
$type2 = $rowbatt['G2_TYPE'];
if($type1 == 'Gel' ){


$sql = "UPDATE POWER_BACKUP SET G1_GEL_BATT =:mtn WHERE SITE_CODE=:sitecode"; 
$update_batt = oci_parse($conn,$sql);

oci_bind_by_name($update_batt, ':sitecode' ,$sitecode);
oci_bind_by_name($update_batt, ':mtn' ,$type1);
oci_execute($update_batt);   

}
elseif($type1 == 'Lithium' ){


$sql = "UPDATE POWER_BACKUP SET G1_LITHIUM_BATT =:mtn WHERE SITE_CODE=:sitecode"; 
$update_batt = oci_parse($conn,$sql);

oci_bind_by_name($update_batt, ':sitecode' ,$sitecode);
oci_bind_by_name($update_batt, ':mtn' ,$type1);
oci_execute($update_batt);   

}

if($type2 == 'Gel' ){


$sql = "UPDATE POWER_BACKUP SET G2_GEL_BATT =:mtn WHERE SITE_CODE=:sitecode"; 
$update_batt = oci_parse($conn,$sql);

oci_bind_by_name($update_batt, ':sitecode' ,$sitecode);
oci_bind_by_name($update_batt, ':mtn' ,$type1);
oci_execute($update_batt);   

}
elseif($type2 == 'Lithium' ){


$sql = "UPDATE POWER_BACKUP SET G2_LITHIUM_BATT =:mtn WHERE SITE_CODE=:sitecode"; 
$update_batt = oci_parse($conn,$sql);

oci_bind_by_name($update_batt, ':sitecode' ,$sitecode);
oci_bind_by_name($update_batt, ':mtn' ,$type1);
oci_execute($update_batt);   

}
}
$sqlline = "SELECT SITE_CODE, TYPE FROM  LINES WHERE SITE_CODE=:sitecode";      
$result_line = oci_parse($conn,$sqlline);
oci_bind_by_name($result_line, ':sitecode'   ,$sitecode);

oci_execute($result_line);
if($rowline = oci_fetch_array($result_line, OCI_ASSOC + OCI_RETURN_NULLS)){
    $power_backup[] = 'Line';
$line = $rowline['TYPE'];


if($line == 'Industrial' ){


$sql = "UPDATE POWER_BACKUP SET INDUSTRIAL_LINE =:mtn WHERE SITE_CODE=:sitecode"; 
    $update_line = oci_parse($conn,$sql);

    oci_bind_by_name($update_line, ':sitecode' ,$sitecode);
    oci_bind_by_name($update_line, ':mtn' ,$line);
    oci_execute($update_line);   

}

elseif($line == 'Golden' ){


$sql = "UPDATE POWER_BACKUP SET GOLDEN_LINE =:mtn WHERE SITE_CODE=:sitecode"; 
    $update_line = oci_parse($conn,$sql);

    oci_bind_by_name($update_line, ':sitecode' ,$sitecode);
    oci_bind_by_name($update_line, ':mtn' ,$line);
    oci_execute($update_line);   

}
elseif($line == 'Non Rationing' ){


$sql = "UPDATE POWER_BACKUP SET NON_RATINING_LINE =:mtn WHERE SITE_CODE=:sitecode"; 
    $update_line = oci_parse($conn,$sql);

    oci_bind_by_name($update_line, ':sitecode' ,$sitecode);
    oci_bind_by_name($update_line, ':mtn' ,$line);
    oci_execute($update_line);   

}
elseif($line == 'Rationing' ){


$sql = "UPDATE POWER_BACKUP SET RATINING_LINE =:mtn WHERE SITE_CODE=:sitecode"; 
    $update_line = oci_parse($conn,$sql);

    oci_bind_by_name($update_line, ':sitecode' ,$sitecode);
    oci_bind_by_name($update_line, ':mtn' ,$line);
    oci_execute($update_line);   

}




}


$power_backup_string = implode('-', $power_backup);
//echo $power_backup_string;








$stmt = "SELECT * FROM POWER_BACKUP WHERE SITE_CODE =:sitecode";

$result = oci_parse($conn,$stmt);

oci_bind_by_name($result,':sitecode',$sitecode);

oci_execute($result);   

if($row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS)){

$mtn1       =   isset($row['MTN_GEN'])           ? 'MTN Generator'             : '-';
$oos1       =   isset($row['MTN_OOS_GEN'])       ? 'MTN OOS Generator'         : '-';
$rent1      =   isset($row['MTN_RENTED_GEN'])    ? 'MTN Rented Generator'      : '-';
$othermtn1  =   isset($row['OTHER_MTN_GEN'])     ? 'Other MTN Generator'       : '-';
$other1     =   isset($row['OTHER_GEN'])         ? 'Other Generator'           : '-';
$ste1       =   isset($row['STE_GEN'])           ? 'STE Generator'             : '-';
$switch1    =   isset($row['SWITCH_GEN'])        ? 'Switch Generator'          : '-';
$syriatel1  =   isset($row['SYRIATEL_GEN'])      ? 'Syriatel Generator'        : '-';
$hyprid1    =   isset($row['HYPRID'])            ? 'Hyprid'                    : '-';
$inactive1  =   isset($row['HYPRID_INACTIVE'])   ? 'Hyprid Inactive'           : '-';
$installed1 =   isset($row['HYPRID_INSTALLED'])  ? 'Hyprid Installed'          : '-';
$hypridoos1 =   isset($row['HYPRID_OOS'])        ? 'Hyprid OOS'                : '-';
$wind1      =   isset($row['HYPRID_WIND'])       ? 'Hyprid Wind'               : '-';
$amp1       =   isset($row['AMPERE'])            ? 'Ampere'                    : '-';
$g1gel1     =   isset($row['G1_GEL_BATT'])       ? 'Gel Batteries-group1'      : '-';
$g1lithium1 =   isset($row['G1_LITHIUM_BATT'])   ? 'Lithium Batteries-group1'  : '-';
$indust1    =   isset($row['INDUSTRIAL_LINE'])   ? 'Industrial Line'           : '-';
$golden1    =   isset($row['GOLDEN_LINE'])       ? 'Golden Line'               : '-';
$ration1    =   isset($row['RATINING_LINE'])     ? 'Rationing Line'            : '-';
$gel1       =   isset($row['G2_GEL_BATT'])       ? 'Gel Batteries-group2'      : '-';
$lithium1   =   isset($row['G2_LITHIUM_BATT'])   ? 'Lithium Batteries-group2'  : '-';
$nonration1 =   isset($row['NON_RATINING_LINE']) ? 'Non Rationing Line'        : '-';




$stmtt = "UPDATE POWER_BACKUP SET MTN_GEN=:mtn,
MTN_OOS_GEN =:oosgen,
MTN_RENTED_GEN =:rented,
OTHER_GEN=: othergen,
STE_GEN =: stegen,
SWITCH_GEN =:switchgen,
SYRIATEL_GEN =:syriatel,
HYPRID =:hyprid,
HYPRID_INACTIVE =:inactive,
HYPRID_OOS =:oos,
HYPRID_INSTALLED =:hinstalled,
HYPRID_WIND =:wind,
AMPERE=:amp,
G1_GEL_BATT=:gell,
G1_LITHIUM_BATT=:lithium,
INDUSTRIAL_LINE=:indust,
GOLDEN_LINE=:golden,
RATINING_LINE=:ration,
G2_GEL_BATT=:gel,
G2_LITHIUM_BATT =:lith,
NON_RATINING_LINE=:non,
POWER_BACKUP=:power_backup
 WHERE SITE_CODE=:sitecode
";
$updatepower = oci_parse($conn, $stmtt);




// oci_bind_by_name($updatepower, ':pid', $PID);
oci_bind_by_name($updatepower, ':sitecode', $sitecode);
oci_bind_by_name($updatepower, ':mtn', $mtn1);
oci_bind_by_name($updatepower, ':oosgen', $oos1);
oci_bind_by_name($updatepower, ':rented', $rent1);
oci_bind_by_name($updatepower, ':othergen', $othermtn1);
oci_bind_by_name($updatepower, ':stegen', $ste1);
oci_bind_by_name($updatepower, ':switchgen', $switch1);
oci_bind_by_name($updatepower, ':syriatel', $syriatel1);
oci_bind_by_name($updatepower, ':hyprid', $hyprid1);
oci_bind_by_name($updatepower, ':inactive', $inactive1);
oci_bind_by_name($updatepower, ':hinstalled', $installed1);
oci_bind_by_name($updatepower, ':oos', $hypridoos1);
oci_bind_by_name($updatepower, ':wind', $wind1);
oci_bind_by_name($updatepower, ':amp', $amp1);
oci_bind_by_name($updatepower, ':gell', $g1gel1);
oci_bind_by_name($updatepower, ':lithium', $g1lithium1);
oci_bind_by_name($updatepower, ':indust', $indust1);
oci_bind_by_name($updatepower, ':golden', $golden1);
oci_bind_by_name($updatepower, ':ration', $ration1);
oci_bind_by_name($updatepower, ':gel', $gel1);
oci_bind_by_name($updatepower, ':lith', $lithium1);
oci_bind_by_name($updatepower, ':non', $nonration1);
oci_bind_by_name($updatepower, ':power_backup', $power_backup_string);


if (oci_execute($updatepower)) {  
echo "DONE";
//echo $power_backup_string;
} 
else { 
$e = oci_error($updatepower); echo "Error Updating Data: " . htmlentities($e['message']);
//echo "error";

}


}






//}
//header("Location: Power_Thankyou.html");
         



header("Location: Power_Thankyou.php?id=" . $sid . "&user_id=" . $user_id1);
exit(); // It's a good practice to call exit after header redirection


         }
}



               }
              


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Backup Configuration | Version 2.0</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    :root {
        --primary: #1c355c;
        --secondary: #3498db;
        --accent: #f39c12;
        --light: #f8f9fa;
        --dark: #212529;
        --success: #28a745;
        --border-radius: 8px;
        --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    body {
        background: linear-gradient(135deg, #daa520 0%, #b8860b 100%);
        color: var(--dark);
        min-height: 100vh;
        padding: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .audit-header {
        background: linear-gradient(to right, var(--primary), #2c5282);
        color: white;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
        box-shadow: var(--box-shadow);
    }

    .audit-info {
        background: #e3f2fd;
        border-left: 4px solid var(--secondary);
        box-shadow: var(--box-shadow);
    }

    .form-container {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
    }

    .section-header {
        background: linear-gradient(to right, #1c355c, #2c5282);
        color: white;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .section-header:hover {
        background: linear-gradient(to right, #152642, #1a3e6b);
    }

    .section-content {
        background: #f8fafc;
        border-radius: 8px;
        padding: 20px;
    }

    .tank-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }

    .tank-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-3px);
    }

    .btn-gold {
        background: goldenrod;
        color: white;
        border: 2px solid transparent;
        font-weight: 600;
    }

    .btn-gold:hover {
        background: #1c355c;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .search-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .search-input {
        border: 2px solid #d1d9e6;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .search-input:focus {
        border-color: var(--primary);
        box-shadow: 0 5px 15px rgba(28, 53, 92, 0.1);
    }

    .search-button {
        background: var(--primary);
        color: white;
        font-weight: 600;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .search-button:hover {
        background: #152a50;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .success-message {
        background-color: #d4edda;
        color: #155724;
        border-radius: 5px;
        display: none;
    }

    .form-footer {
        background: #f8fafc;
        border-top: 1px solid #eaeaea;
    }

    .required label:after {
        content: " *";
        color: var(--accent);
    }

    .power-summary-modal {
        max-width: 900px;
    }

    .dynamic-field {
        transition: all 0.3s ease;
        overflow: hidden;
        max-height: 0;
        opacity: 0;
    }

    .dynamic-field.active {
        max-height: 2000px;
        opacity: 1;
        padding: 15px;
        margin-top: 15px;
        border-radius: 8px;
        background: #f0f9ff;
        border-left: 4px solid #3498db;
    }

    .dimensions-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .tank-toggle .form-check-input {
        transform: scale(1.5);
    }

    .tank-card h4 {
        color: var(--primary);
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 10px;
    }
    </style>
</head>

<body>
    <div class="container py-4">
        <form id="powerConfigForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
            class="needs-validation" novalidate>
            <div class="card mb-4 shadow-lg">
                <div class="card-header audit-header py-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-bolt fa-2x me-3"></i>
                        <div>
                            <h1 class="h3 mb-0">Power Backup Configuration</h1>
                            <p class="mb-0">Comprehensive setup for your site's power systems</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="alert audit-info p-3 mb-4 d-flex align-items-center">
                        <i class="fas fa-info-circle fa-2x me-3 text-primary"></i>
                        <div class="fs-5">All changes are logged in the audit trail for security and compliance
                            purposes.</div>
                    </div>

                    <div class="alert alert-success success-message d-flex align-items-center" id="successMessage">
                        <i class="fas fa-check-circle fa-2x me-3"></i>
                        <div class="fs-5">Configuration saved successfully!</div>
                    </div>

                    <!-- Search Form -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="search-container">
                                <div class="input-group">
                                    <input type="hidden" name="userid1" value="<?php echo $user_id; ?>">
                                    <input type="hidden" name="username1" value="<?php echo $userrname; ?>">
                                    <input type="text" class="form-control form-control-lg search-input"
                                        name="searchcode" placeholder="Enter site code (e.g., DAM123)" required>
                                    <button type="submit" name="Search" class="btn search-button">
                                        <i class="fas fa-search me-2"></i>Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Site Information -->
                    <div class="card mb-4">
                        <div class="card-header section-header d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" href="#siteInfo">
                            <h3 class="h5 mb-0"><i class="fas fa-building me-2"></i> Site Information</h3>
                            <i class="fas fa-chevron-down toggle-icon"></i>
                        </div>
                        <div id="siteInfo" class="collapse show">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="siteCode" class="form-label"><i class="fas fa-qrcode me-2"></i>
                                                Site Code</label>
                                            <input type="text" id="siteCode" name="sitecode" class="form-control"
                                                value="<?php echo $row['SITE_CODE']; ?>" readonly>
                                            <input type="hidden" name="id" value="<?php echo $siteid; ?>">
                                            <input type="hidden" name="userid" value="<?php echo $user_id; ?>">
                                            <input type="hidden" name="username" value="<?php echo $userrname; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="siteName" class="form-label"><i
                                                    class="fas fa-map-marker-alt me-2"></i> Site Name</label>
                                            <input type="text" id="siteName" name="siteName" class="form-control"
                                                value="<?php echo htmlspecialchars($row['SITE_NAME'] ?? ''); ?>"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"><i class="fa fa-list-alt me-2"></i>
                                                Summary</label>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-gold w-100" data-bs-toggle="modal"
                                                    data-bs-target="#powerInfoModal">
                                                    <i class="fas fa-eye me-2"></i>View Summary
                                                </button>
                                                <a href="export_power.php" class="btn btn-primary w-100">
                                                    <i class="fas fa-download me-2"></i>Export
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Electrical Counter -->
                    <div class="card mb-4">
                        <div class="card-header section-header d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" href="#electrical">
                            <h3 class="h5 mb-0"><i class="fas fa-tachometer-alt me-2"></i> Electrical Counter</h3>
                            <i class="fas fa-chevron-down toggle-icon"></i>
                        </div>
                        <div id="electrical" class="collapse">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="counter_serial" class="form-label"><i
                                                    class="fas fa-hashtag me-2"></i> Serial Number</label>
                                            <input type="text" id="counter_serial" name="serial" class="form-control"
                                                placeholder="Enter serial number"
                                                value="<?php echo $serial_number ? $serial_number : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="counter_breaker" class="form-label"><i
                                                    class="fas fa-plug me-2"></i> Counter Circuit Breaker</label>
                                            <input type="text" id="counter_breaker" name="counter" class="form-control"
                                                placeholder="Enter breaker details"
                                                value="<?php echo $COUNTER_CIRCUIT_BREAKER ? $COUNTER_CIRCUIT_BREAKER : ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="counter_status" class="form-label"><i
                                                    class="fas fa-info-circle me-2"></i> Counter Status</label>
                                            <select id="counter_status" name="cstatus" class="form-select">
                                                <option value="">-- Select Status --</option>
                                                <option value="Not Exsist"
                                                    <?php if($STATUS  == "Not Exsist") echo 'selected'; ?>>Not Exsist
                                                </option>
                                                <option value="Good" <?php if($STATUS  == "Good") echo 'selected'; ?>>
                                                    Good</option>
                                                <option value="Bad" <?php if($STATUS  == "Bad") echo 'selected'; ?>>Bad
                                                </option>
                                                <option value="Need replace"
                                                    <?php if($STATUS  == "Need replace") echo 'selected'; ?>>Need
                                                    replace</option>
                                                <option value="Need Overhauling"
                                                    <?php if($STATUS  == "Need Overhauling") echo 'selected'; ?>>Need
                                                    Overhauling</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="counter_owner" class="form-label"><i
                                                    class="fas fa-user-tag me-2"></i> Ownership</label>
                                            <select id="counter_owner" name="owner" class="form-select">
                                                <option value="--">-- Select Ownership --</option>
                                                <option value="MTN" <?php if($OWNER_SHIP  == "MTN") echo 'selected'; ?>>
                                                    MTN</option>
                                                <option value="Third Party"
                                                    <?php if($OWNER_SHIP  == "Third Party") echo 'selected'; ?>>Third
                                                    Party</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="counter_power" class="form-label"><i
                                                    class="fas fa-bolt me-2"></i> Power Type</label>
                                            <select id="counter_power" name="cpower" class="form-select">
                                                <option value="Three phase"
                                                    <?php if($type  == "Three phase") echo 'selected'; ?>>Three phase
                                                </option>
                                                <option value="Mono phase"
                                                    <?php if($type  == "Mono phase") echo 'selected'; ?>>Mono phase
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="counter_breaker" class="form-label"><i
                                                    class="fas fa-plug me-2"></i> ATS INSTALLER</label>
                                            <input type="text" id="counter_breaker" name="ATS" class="form-control"
                                                placeholder="ATS"
                                                value="<?php echo $ATS_INSTALLED ? $ATS_INSTALLED : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cabinet Information -->
                    <div class="card mb-4">
                        <div class="card-header section-header d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" href="#cabinet">
                            <h3 class="h5 mb-0"><i class="fas fa-server me-2"></i> Cabinet Information</h3>
                            <i class="fas fa-chevron-down toggle-icon"></i>
                        </div>
                        <div id="cabinet" class="collapse">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cabinet_type" class="form-label"><i
                                                    class="fas fa-cube me-2"></i> Cabinet Type</label>
                                            <select id="cabinet_type" name="cabtype" class="form-select">
                                                <option value="">-- Select Type --</option>
                                                <option value="Delta"
                                                    <?php if($CABINET_TYPE  == "Delta") echo 'selected'; ?>>Delta
                                                </option>
                                                <option value="Ericsson"
                                                    <?php if($CABINET_TYPE  == "Ericsson") echo 'selected'; ?>>Ericsson
                                                </option>
                                                <option value="Huawei"
                                                    <?php if($CABINET_TYPE  == "Huawei") echo 'selected'; ?>>Huawei
                                                </option>
                                                <option value="Eltek"
                                                    <?php if($CABINET_TYPE  == "Eltek") echo 'selected'; ?>>Eltek
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="rectifier_type" class="form-label"><i
                                                    class="fas fa-microchip me-2"></i> Rectifier Type</label>
                                            <select id="rectifier_type" name="rectype" class="form-select">
                                                <option value="">-- Select Type --</option>
                                                <option value="Delta"
                                                    <?php if($RECTIFIER_TYPE  == "Delta") echo 'selected'; ?>>Delta
                                                </option>
                                                <option value="Ericsson"
                                                    <?php if($RECTIFIER_TYPE  == "Ericsson") echo 'selected'; ?>>
                                                    Ericsson</option>
                                                <option value="ETP48200"
                                                    <?php if($RECTIFIER_TYPE  == "ETP48200") echo 'selected'; ?>>
                                                    ETP48200</option>
                                                <option value="Eltek"
                                                    <?php if($RECTIFIER_TYPE  == "Eltek") echo 'selected'; ?>>Eltek
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"><i class="fas fa-network-wired me-2"></i> IP
                                                Addresses</label>
                                            <div class="row g-2">
                                                <div class="col-12">
                                                    <input type="text" class="form-control" name="HIP"
                                                        placeholder="Huawei IP"
                                                        value="<?php echo $HWAUEI_IP ? $HWAUEI_IP : ''; ?>">
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" class="form-control" name="DIP"
                                                        placeholder="Delta IP"
                                                        value="<?php echo $DELTA_IP  ? $DELTA_IP  : ''; ?>">
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" class="form-control" name="EIP"
                                                        placeholder="ELTEK IP"
                                                        value="<?php echo $ELTEK_IP  ? $ELTEK_IP : ''; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"><i class="fas fa-solar-panel me-2"></i> Module
                                                Quantities</label>
                                            <div class="row g-2">
                                                <div class="col-12">
                                                    <input type="number" class="form-control" name="ACqty"
                                                        placeholder="AC Module Quantity"
                                                        value="<?php echo $AC_MODULE_QUANTITY     ? $AC_MODULE_QUANTITY  : ''; ?>">
                                                </div>
                                                <div class="col-12">
                                                    <input type="number" class="form-control" name="solarqty"
                                                        placeholder="Solar Module Quantity"
                                                        value="<?php echo $SOLAR_MOUDULE_QUANTITY ? $SOLAR_MOUDULE_QUANTITY : ''; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"><i class="fas fa-shield-alt me-2"></i> Cabinet
                                                Cage</label>
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="cabinet_cage_yes"
                                                        name="cabinetcage" value="Yes"
                                                        <?php echo (isset($CABINET_CAGE) && $CABINET_CAGE == "Yes") ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="cabinet_cage_yes">Yes</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="cabinet_cage_no"
                                                        name="cabinetcage" value="No"
                                                        <?php echo (isset($CABINET_CAGE) && $CABINET_CAGE == "No") ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="cabinet_cage_no">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"><i class="fas fa-shield-alt me-2"></i> Main
                                                Cabinet</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="cabinet_yes"
                                                    name="maincabinet" value="True"
                                                    <?php if ( $MAIN == "True") echo 'checked'; ?>>
                                                <label class="form-check-label" for="cabinet_yes">Main Cabinet</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="cabinet_notes" class="form-label"><i
                                                    class="fas fa-sticky-note me-2"></i> Notes</label>
                                            <textarea id="cabinet_notes" name="cabnote" class="form-control" rows="3"
                                                placeholder="Additional cabinet notes"><?php echo $NOTE ? $NOTE : ''; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Generator Information -->
                    <div class="card mb-4">
                        <div class="card-header section-header d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" href="#generator">
                            <h3 class="h5 mb-0"><i class="fas fa-gas-pump me-2"></i> Generator Information</h3>
                            <i class="fas fa-chevron-down toggle-icon"></i>
                        </div>
                        <div id="generator" class="collapse">
                            <div class="card-body">
                                <div class="form-group mb-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="generator_present"
                                            name="Gen" value="1">
                                        <label class="form-check-label" for="generator_present">Generator
                                            Installed</label>
                                    </div>
                                </div>

                                <div id="generatorOptions" class="dynamic-field">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="generator_brand" class="form-label"><i
                                                        class="fas fa-industry me-2"></i> Generator Brand</label>
                                                <select id="generator_brand" name="gen_brand" class="form-select">
                                                    <option value="--">-- Select Brand --</option>
                                                    <option value="Paknika"
                                                        <?php if($BRAND   == "Paknika")  echo 'selected'; ?>>Paknika
                                                    </option>
                                                    <option value="Sdmo"
                                                        <?php if($BRAND   == "Sdmo") echo 'selected'; ?>>Sdmo</option>
                                                    <option value="Saccal"
                                                        <?php if($BRAND   == "Saccal") echo 'selected'; ?>>Saccal
                                                    </option>
                                                    <option value="Trion"
                                                        <?php if($BRAND   == "Trion") echo 'selected'; ?>>Trion</option>
                                                    <option value="Green Power"
                                                        <?php if($BRAND   == "Green Power") echo 'selected'; ?>>Green
                                                        Power</option>
                                                    <option value="Telegen"
                                                        <?php if($BRAND   == "Telegen") echo 'selected'; ?>>Telegen
                                                    </option>
                                                    <option value="JET" <?php if($BRAND   == "JET") echo 'selected'; ?>>
                                                        JET</option>
                                                    <option value="MPG" <?php if($BRAND   == "MPG") echo 'selected'; ?>>
                                                        MPG</option>
                                                    <option value="FAW" <?php if($BRAND   == "FAW") echo 'selected'; ?>>
                                                        FAW</option>
                                                    <option value="KeyPower"
                                                        <?php if($BRAND   == "KeyPower") echo 'selected'; ?>>KeyPower
                                                    </option>
                                                    <option value="Valiant"
                                                        <?php if($BRAND   == "Valiant") echo 'selected'; ?>>Valiant
                                                    </option>
                                                    <option value="JIMCO"
                                                        <?php if($BRAND   == "JIMCO") echo 'selected'; ?>>JIMCO</option>
                                                    <option value="EATON"
                                                        <?php if($BRAND   == "EATON") echo 'selected'; ?>>EATON</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="engine_brand" class="form-label"><i
                                                        class="fas fa-cogs me-2"></i> Engine Brand</label>
                                                <select id="engine_brand" name="engine_brand" class="form-select">
                                                    <option value="--">-- Select Brand --</option>
                                                    <option value="Paknika"
                                                        <?php if($ENGINE_BRAND   == "Paknika") echo 'selected'; ?>>
                                                        Paknika</option>
                                                    <option value="Yanmar"
                                                        <?php if($ENGINE_BRAND   == "Yanmar") echo 'selected'; ?>>Yanmar
                                                    </option>
                                                    <option value="John Deere"
                                                        <?php if($ENGINE_BRAND   == "John Deere") echo 'selected'; ?>>
                                                        John Deere</option>
                                                    <option value="Kohler"
                                                        <?php if($ENGINE_BRAND   == "Kohler") echo 'selected'; ?>>Kohler
                                                    </option>
                                                    <option value="YORK"
                                                        <?php if($ENGINE_BRAND   == "YORK") echo 'selected'; ?>>YORK
                                                    </option>
                                                    <option value="FAW"
                                                        <?php if($ENGINE_BRAND   == "FAW") echo 'selected'; ?>>FAW
                                                    </option>
                                                    <option value="Mitsubishi"
                                                        <?php if($ENGINE_BRAND   == "Mitsubishi") echo 'selected'; ?>>
                                                        Mitsubishi</option>
                                                    <option value="Lister"
                                                        <?php if($ENGINE_BRAND   == "Lister") echo 'selected'; ?>>Lister
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="generator_status" class="form-label"><i
                                                        class="fas fa-clipboard-check me-2"></i> Initial Status</label>
                                                <select id="generator_status" name="status" class="form-select">
                                                    <option value="--">-- Select Status --</option>
                                                    <option value="Bad"
                                                        <?php if($INITIAL_STATUS == "Bad") echo 'selected'; ?>>Bad
                                                    </option>
                                                    <option value="Good"
                                                        <?php if($INITIAL_STATUS == "Good") echo 'selected'; ?>>Good
                                                    </option>
                                                    <option value="Need replace"
                                                        <?php if($INITIAL_STATUS == "Need replace") echo 'selected'; ?>>
                                                        Need replace</option>
                                                    <option value="Need Overhauling"
                                                        <?php if($INITIAL_STATUS == "Need Overhauling") echo 'selected'; ?>>
                                                        Need Overhauling</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="generator_status" class="form-label"><i
                                                        class="fas fa-clipboard-check me-2"></i> Current Status</label>
                                                <select id="generator_status" name="currentstatus" class="form-select">
                                                    <option value="--">-- Select Status --</option>
                                                    <option value="Bad"
                                                        <?php if($CURRENT_STATUS == "Bad") echo 'selected'; ?>>Bad
                                                    </option>
                                                    <option value="Good"
                                                        <?php if($CURRENT_STATUS == "Good") echo 'selected'; ?>>Good
                                                    </option>
                                                    <option value="Need replace"
                                                        <?php if($CURRENT_STATUS == "Need replace") echo 'selected'; ?>>
                                                        Need replace</option>
                                                    <option value="Need Overhauling"
                                                        <?php if($CURRENT_STATUS == "Need Overhauling") echo 'selected'; ?>>
                                                        Need Overhauling</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="generator_owner" class="form-label"><i
                                                        class="fas fa-user-tag me-2"></i> Ownership</label>
                                                <select id="generator_owner" name="ownership" class="form-select">
                                                    <option value="--">-- Select Ownership --</option>
                                                    <option value="MTN"
                                                        <?php if($OWNERSHIP == "MTN") echo 'selected'; ?>>MTN</option>
                                                    <option value="MTN_OOS"
                                                        <?php if($OWNERSHIP == "MTN_OOS") echo 'selected'; ?>>MTN_OOS
                                                    </option>
                                                    <option value="MTN_Rented"
                                                        <?php if($OWNERSHIP == "MTN_Rented") echo 'selected'; ?>>
                                                        MTN_Rented</option>
                                                    <option value="Other_MTN"
                                                        <?php if($OWNERSHIP == "Other_MTN") echo 'selected'; ?>>
                                                        Other_MTN</option>
                                                    <option value="Other"
                                                        <?php if($OWNERSHIP == "Other") echo 'selected'; ?>>Other
                                                    </option>
                                                    <option value="STE"
                                                        <?php if($OWNERSHIP == "STE") echo 'selected'; ?>>STE</option>
                                                    <option value="Switch"
                                                        <?php if($OWNERSHIP == "Switch") echo 'selected'; ?>>Switch
                                                    </option>
                                                    <option value="Syriatel"
                                                        <?php if($OWNERSHIP == "Syriatel") echo 'selected'; ?>>Syriatel
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="generator_capacity" class="form-label"><i
                                                        class="fas fa-charging-station me-2"></i> Capacity (kVA)</label>
                                                <input type="text" id="generator_capacity" name="capacity"
                                                    class="form-control" placeholder="Enter capacity"
                                                    value="<?php echo $CAPACITY ? $CAPACITY : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="generator_qty" class="form-label"><i
                                                        class="fas fa-calculator me-2"></i> Quantity</label>
                                                <input type="number" id="generator_qty" name="qty" class="form-control"
                                                    min="1" value="<?php echo $QUANTITY ? $QUANTITY : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-label"><i class="fas fa-shield-alt me-2"></i>
                                                    Generator Cage</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            id="generator_cage_yes" name="cage" value="Yes"
                                                            <?php echo (isset($CAGE) && $CAGE == "Yes") ? 'checked' : ''; ?>>
                                                        <label class="form-check-label"
                                                            for="generator_cage_yes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            id="generator_cage_no" name="cage" value="No"
                                                            <?php echo (isset($CAGE) && $CAGE == "No") ? 'checked' : ''; ?>>
                                                        <label class="form-check-label"
                                                            for="generator_cage_no">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tank Section -->
                                    <div class="mt-4">
                                        <h4 class="mb-3"><i class="fas fa-oil-can me-2"></i> Fuel Tanks</h4>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="tank-card">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h4 class="h5 mb-0"><i class="fas fa-oil-can me-2"></i> Tank 1
                                                        </h4>
                                                        <div class="tank-toggle form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="tank1"
                                                                value="1">
                                                        </div>
                                                    </div>
                                                    <div class="tank-fields">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Shape</label>
                                                            <select name="t1shape" class="form-select">
                                                                <option value="--">-- Select Shape --</option>
                                                                <option value="Cuboid"
                                                                    <?php if($TANK1_SHAPE == "Cuboid") echo 'selected'; ?>>
                                                                    Cuboid</option>
                                                                <option value="Cylinder"
                                                                    <?php if($TANK1_SHAPE == "Cylinder") echo 'selected'; ?>>
                                                                    Cylinder</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Type</label>
                                                            <select name="t1type" class="form-select">
                                                                <option value="--">-- Select Type --</option>
                                                                <option value="Internal"
                                                                    <?php if($TANK1_TYPE == "Internal") echo 'selected'; ?>>
                                                                    Internal</option>
                                                                <option value="External"
                                                                    <?php if($TANK1_TYPE == "External") echo 'selected'; ?>>
                                                                    External</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Volume (L)</label>
                                                            <input type="number" name="t1volume" class="form-control"
                                                                placeholder="Actual volume"
                                                                value="<?php echo $TANK1_ACTUAL_VOLUME  ? $TANK1_ACTUAL_VOLUME  : ''; ?>">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Dimensions (cm)</label>
                                                            <div class="dimensions-grid">
                                                                <input type="number" name="t1height"
                                                                    class="form-control" placeholder="H"
                                                                    value="<?php echo $TANK1_HEIGHT ? $TANK1_HEIGHT   : ''; ?>">
                                                                <input type="number" name="t1width" class="form-control"
                                                                    placeholder="W"
                                                                    value="<?php echo $TANK1_WIDTH  ? $TANK1_WIDTH  : ''; ?>">
                                                                <input type="number" name="t1length"
                                                                    class="form-control" placeholder="L"
                                                                    value="<?php echo $TANK1_LENGTH ? $TANK1_LENGTH : ''; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Max Capacity (L)</label>
                                                            <input type="number" name="t1max" class="form-control"
                                                                placeholder="Maximum fuel"
                                                                value="<?php echo $TANK1_MAXIMUM ? $TANK1_MAXIMUM   : ''; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="tank-card">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h4 class="h5 mb-0"><i class="fas fa-oil-can me-2"></i> Tank 2
                                                        </h4>
                                                        <div class="tank-toggle form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="tank2"
                                                                value="2">
                                                        </div>
                                                    </div>
                                                    <div class="tank-fields">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Shape</label>
                                                            <select name="t2shape" class="form-select">
                                                                <option value="--">-- Select Shape --</option>
                                                                <option value="Cuboid"
                                                                    <?php if($TANK2_SHAPE   == "Cuboid") echo 'selected'; ?>>
                                                                    Cuboid</option>
                                                                <option value="Cylinder"
                                                                    <?php if($TANK2_SHAPE   == "Cylinder") echo 'selected'; ?>>
                                                                    Cylinder</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Type</label>
                                                            <select name="t2type" class="form-select">
                                                                <option value="--">-- Select Type --</option>
                                                                <option value="Internal"
                                                                    <?php if($TANK2_TYPE   == "Internal") echo 'selected'; ?>>
                                                                    Internal</option>
                                                                <option value="External"
                                                                    <?php if($TANK2_TYPE   == "External") echo 'selected'; ?>>
                                                                    External</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Volume (L)</label>
                                                            <input type="number" name="t2volume" class="form-control"
                                                                placeholder="Actual volume"
                                                                value="<?php echo $TANK2_ACTUAL_VOLUME  ? $TANK2_ACTUAL_VOLUME  : ''; ?>">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Dimensions (cm)</label>
                                                            <div class="dimensions-grid">
                                                                <input type="number" name="t2height"
                                                                    class="form-control" placeholder="H"
                                                                    value="<?php echo $TANK2_HEIGHT ? $TANK2_HEIGHT   : ''; ?>">
                                                                <input type="number" name="t2width" class="form-control"
                                                                    placeholder="W"
                                                                    value="<?php echo $TANK2_WIDTH  ? $TANK2_WIDTH  : ''; ?>">
                                                                <input type="number" name="t2length"
                                                                    class="form-control" placeholder="L"
                                                                    value="<?php echo $TANK2_LENGTH ?  $TANK2_LENGTH : ''; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Max Capacity (L)</label>
                                                            <input type="number" name="t2max" class="form-control"
                                                                placeholder="Maximum fuel"
                                                                value="<?php echo $TANK2_MAXIMUM ? $TANK2_MAXIMUM   : ''; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="tank-card">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h4 class="h5 mb-0"><i class="fas fa-oil-can me-2"></i> Tank 3
                                                        </h4>
                                                        <div class="tank-toggle form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" name="tank3"
                                                                value="3">
                                                        </div>
                                                    </div>
                                                    <div class="tank-fields">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Shape</label>
                                                            <select name="t3shape" class="form-select">
                                                                <option value="--">-- Select Shape --</option>
                                                                <option value="Cuboid"
                                                                    <?php if($TANK3_SHAPE   == "Cuboid") echo 'selected'; ?>>
                                                                    Cuboid</option>
                                                                <option value="Cylinder"
                                                                    <?php if($TANK3_SHAPE   == "Cylinder") echo 'selected'; ?>>
                                                                    Cylinder</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Type</label>
                                                            <select name="t3type" class="form-select">
                                                                <option value="--">-- Select Type --</option>
                                                                <option value="Internal"
                                                                    <?php if($TANK3_TYPE   == "Internal") echo 'selected'; ?>>
                                                                    Internal</option>
                                                                <option value="External"
                                                                    <?php if($TANK3_TYPE   == "External") echo 'selected'; ?>>
                                                                    External</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Volume (L)</label>
                                                            <input type="number" name="t3volume" class="form-control"
                                                                placeholder="Actual volume"
                                                                value="<?php echo $TANK3_ACTUAL_VOLUME  ? $TANK3_ACTUAL_VOLUME  : ''; ?>">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">Dimensions (cm)</label>
                                                            <div class="dimensions-grid">
                                                                <input type="number" name="t3height"
                                                                    class="form-control" placeholder="H"
                                                                    value="<?php echo $TANK3_HEIGHT   ? $TANK3_HEIGHT   : ''; ?>">
                                                                <input type="number" name="t3width" class="form-control"
                                                                    placeholder="W"
                                                                    value="<?php echo $TANK3_WIDTH    ? $TANK3_WIDTH   : ''; ?>">
                                                                <input type="number" name="t3length"
                                                                    class="form-control" placeholder="L"
                                                                    value="<?php echo $TANK3_LENGTH   ? $TANK3_LENGTH   : ''; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Max Capacity (L)</label>
                                                            <input type="number" name="t3max" class="form-control"
                                                                placeholder="Maximum fuel"
                                                                value="<?php echo $TANK3_MAXIMUM ? $TANK3_MAXIMUM   : ''; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Continue with other sections (Solar, Ampere, Batteries, Safety) -->
                    <!-- [Other sections follow the same pattern as above] -->

                    <!-- Form Footer -->
                    <div class="form-footer card-footer d-flex justify-content-end gap-3 py-3">
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i> Reset Form
                        </button>
                        <button type="submit" name="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Save Configuration
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Power Info Modal -->
    <div class="modal fade" id="powerInfoModal" tabindex="-1" aria-labelledby="powerInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="powerInfoModalLabel">Power Backup Summary</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="powerInfoFrame" src="powerinfo.php?id=<?php echo $siteid; ?>"
                        style="width:100%; height:70vh; border:none;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap components
        const collapseElements = document.querySelectorAll('.collapse');
        collapseElements.forEach(el => {
            new bootstrap.Collapse(el, {
                toggle: false
            });
        });

        // Toggle dynamic fields
        const toggleDynamicField = (checkboxId, fieldId) => {
            const checkbox = document.getElementById(checkboxId);
            const field = document.getElementById(fieldId);

            if (checkbox && field) {
                // Initial state
                if (checkbox.checked) {
                    field.classList.add('active');
                }

                // Toggle on change
                checkbox.addEventListener('change', () => {
                    if (checkbox.checked) {
                        field.classList.add('active');
                    } else {
                        field.classList.remove('active');
                    }
                });
            }
        };

        // Initialize dynamic fields
        toggleDynamicField('generator_present', 'generatorOptions');
        toggleDynamicField('solar_present', 'solarOptions');
        toggleDynamicField('ampere_present', 'ampereOptions');
        toggleDynamicField('lines_present', 'linesOptions');

        // Toggle tank fields
        document.querySelectorAll('.tank-toggle input[type="checkbox"]').forEach(checkbox => {
            const fields = checkbox.closest('.tank-card').querySelector('.tank-fields');

            if (fields) {
                // Initial state
                if (checkbox.checked) {
                    fields.style.display = 'block';
                } else {
                    fields.style.display = 'none';
                }

                // Toggle on change
                checkbox.addEventListener('change', () => {
                    if (checkbox.checked) {
                        fields.style.display = 'block';
                    } else {
                        fields.style.display = 'none';
                    }
                });
            }
        });

        // Form validation
        const form = document.getElementById('powerConfigForm');
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    });
    </script>
</body>

</html>