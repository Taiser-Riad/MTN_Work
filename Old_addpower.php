<?php 
include "config.php";
?>
<?php
if(isset($_GET['id']))
{
$siteid =$_GET['id'];
$sqll= "SELECT * FROM NEW_SITES WHERE ID= :siteid";
$result = oci_parse($conn,$sqll);
oci_bind_by_name($result, ':siteid' ,$siteid);
oci_execute($result);
$row = oci_fetch_array($result , OCI_ASSOC + OCI_RETURN_NULLS);

//$sitecode = $row['SITE_CODE'];
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
    $estatus     = $_POST['cstatus '] ?? '';
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
    //GEN
    $Gen         = $_POST['Gen'] ?? '';
    $gen_brand   = $_POST['gen_brand'] ?? '';
    $engine_brand = $_POST['engine_brand'] ?? '';
    $status      = $_POST['status'] ?? '';
    $ownership   = $_POST['ownership'] ?? '';
    $capacity    = $_POST['capacity'] ?? '';
    $qty         = $_POST ['qty'] ?? '';
    $cage        = $_POST['cage'];
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
    $solarqty    = $_POST['solarqty'] ?? '';
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



    $check_sql = "SELECT * FROM POWER_BACKUP WHERE SITE_CODE = :sitecode";
    $check_stmt = oci_parse($conn, $check_sql);
    oci_bind_by_name($check_stmt, ':sitecode', $sitecode);

    if (oci_execute($check_stmt)) {
        // $check_row = oci_fetch_array($check_stmt, OCI_ASSOC);
        // $count = $check_row['count'];
       

        $count = 0;
        while ($row = oci_fetch_array($check_stmt, OCI_ASSOC)) {
            $count++;
        }

        echo "Count of records in POWER_BACKUP: $count<br>"; // Debugging line



        if ($count == 0) {


    $sql  = "INSERT INTO POWER_BACKUP (SID, PID, SITE_CODE) 
    VALUES (:siteid,POWER_SEQ.NEXTVAL,:sitecode) RETURNING PID INTO :last_pid";


$insert_stmt = oci_parse($conn,$sql);
oci_bind_by_name($insert_stmt,':siteid'   ,$sid);
oci_bind_by_name($insert_stmt,':sitecode' ,$sitecode);
oci_bind_by_name($insert_stmt,':last_pid', $PID, -1, SQLT_INT);
oci_execute($insert_stmt);


if (!empty($_POST['serial']) && isset($_POST['serial'])) {

$sql = "INSERT INTO ELECTRICAL_COUNTER (PID , SITE_CODE, SERIAL_NUMBER, TYPE, OWNER_SHIP, COUNTER_CIRCUIT_BREAKER, STATUS) 
        VALUES (:pid , :sitecode, :serial, :type, :owner, :counter, :status1)";

$insert_electrical = oci_parse($conn,$sql);
oci_bind_by_name($insert_electrical, ':pid' ,$PID);
oci_bind_by_name($insert_electrical, ':sitecode' ,$sitecode);
oci_bind_by_name($insert_electrical, ':type' ,$cpower);
oci_bind_by_name($insert_electrical, ':serial' ,$serial);
oci_bind_by_name($insert_electrical, ':counter' ,$cpower);
oci_bind_by_name($insert_electrical, ':owner' ,$cowner);
oci_bind_by_name($insert_electrical, ':status1' ,$estatus);

if (oci_execute($insert_electrical)) {  
    //echo "DONE";
    //header("Location:Update_thankyou.html");
 } 
   else { 
    $e = oci_error($insert_electrical); 
    echo "Error Updating Data: " . htmlentities($e['message']);

   }

    }


if (!empty($_POST['cabtype']) && isset($_POST['cabtype'])) {

$sqlcab = "INSERT INTO CABINET (PID , CABINET_TYPE, RECTIFIER_TYPE, AC_MODULE_QUANTITY, SOLAR_MOUDULE_QUANTITY, DELTA_IP, HWAUEI_IP, ELTEK_IP,CABINET_CAGE,NOTE) 
           VALUES (:pid , :cab, :rect, :acmodule, :solarmodule, :deltaip, :hwip ,:eltikip ,:cage, :note)";


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

    $sqlgen = "INSERT INTO GENERTAOR (PID , GID , SITE_CODE, BRAND, ENGINE_BRAND, INITIAL_STATUS, QUANTITY, OWNERSHIP, CAGE,CAPACITY) 
    VALUES (:pid ,GENERATOR_SEQ.NEXTVAL, :sitecode, :brand, :engbrand, :status, :qty, :owner ,:cage,:cap) RETURNING GID INTO :last_gid";

$insert_gen = oci_parse($conn,$sqlgen);
oci_bind_by_name($insert_gen, ':pid'      ,$PID);
oci_bind_by_name($insert_gen, ':sitecode' ,$sitecode);
oci_bind_by_name($insert_gen, ':brand'    ,$gen_brand);
oci_bind_by_name($insert_gen, ':engbrand' ,$engine_brand);
oci_bind_by_name($insert_gen, ':status'  ,$status);
oci_bind_by_name($insert_gen, ':qty'     ,$qty);
oci_bind_by_name($insert_gen, ':owner'   ,$ownership);
oci_bind_by_name($insert_gen, ':cage'    ,$cage);
oci_bind_by_name($insert_gen, ':cap'    ,$capacity);
oci_bind_by_name($insert_gen, ':last_gid'   ,$GID, -1, SQLT_INT);



if (oci_execute($insert_gen)) {  
    //echo "DONE";
    //header("Location:Update_thankyou.html");
 } 
   else { 
    $e = oci_error($insert_gen); echo "Error Updating Data: " . htmlentities($e['message']);

   }






if (!empty($_POST['tank1']) && isset($_POST['tank1'])) {

    $sqltank1 = "INSERT INTO TANK (GID, TANK1_SHAPE, TANK1_TYPE, TANK1_ACTUAL_VOLUME, TANK1_HEIGHT, TANK1_WIDTH, TANK1_LENGTH, TANK1_MAXIMUM) 
    VALUES (:gid , :shape, :type, :volume, :height, :width, :length ,:maximum)";

    $insert_tank1 = oci_parse($conn, $sqltank1);
    oci_bind_by_name($insert_tank1, ':gid'      ,$GID);
    oci_bind_by_name($insert_tank1, ':shape'    ,$t1shape);
    oci_bind_by_name($insert_tank1, ':type'     ,$t1type);
    oci_bind_by_name($insert_tank1, ':volume'   ,$t1volume);
    oci_bind_by_name($insert_tank1, ':height'   ,$t1height);
    oci_bind_by_name($insert_tank1, ':width'    ,$t1width);
    oci_bind_by_name($insert_tank1, ':length'   ,$t1length);
    oci_bind_by_name($insert_tank1, ':maximum'  ,$t1max);
    

if(oci_execute($insert_tank1)){

}
else{
    $e = oci_error($insert_tank1); echo "Error Updating Data: " . htmlentities($e['message']);
}
    
}


if (!empty($_POST['tank1']) && !empty($_POST['tank2']) && isset($_POST['tank2'])) {

    $sqltank2 = "UPDATE TANK 
    SET TANK2_SHAPE =:shape , 
    TANK2_TYPE =:type, 
    TANK2_ACTUAL_VOLUME =:volume , 
    TANK2_HEIGHT =:height, 
    TANK2_WIDTH =:width, 
    TANK2_LENGTH =:length, 
    TANK2_MAXIMUM=:maximum 
    WHERE GID =:gid";

    $insert_tank2 = oci_parse($conn, $sqltank2);
    oci_bind_by_name($insert_tank2, ':gid'      ,$GID);
    oci_bind_by_name($insert_tank2, ':shape'    ,$t2shape);
    oci_bind_by_name($insert_tank2, ':type'     ,$t2type);
    oci_bind_by_name($insert_tank2, ':volume'   ,$t2volume);
    oci_bind_by_name($insert_tank2, ':height'   ,$t2height);
    oci_bind_by_name($insert_tank2, ':width'    ,$t2width);
    oci_bind_by_name($insert_tank2, ':length'   ,$t2length);
    oci_bind_by_name($insert_tank2, ':maximum'  ,$t2max);
    

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

    $sqltank3 = "UPDATE TANK 
    SET TANK3_SHAPE =:shape , 
    TANK3_TYPE =:type, 
    TANK3_ACTUAL_VOLUME =:volume , 
    TANK3_HEIGHT =:height, 
    TANK3_WIDTH =:width, 
    TANK3_LENGTH =:length, 
    TANK3_MAXIMUM=:maximum 
    WHERE GID =:gid";

    $insert_tank3 = oci_parse($conn, $sqltank3);
    oci_bind_by_name($insert_tank3, ':gid'      ,$GID);
    oci_bind_by_name($insert_tank3, ':shape'    ,$t3shape);
    oci_bind_by_name($insert_tank3, ':type'     ,$t3type);
    oci_bind_by_name($insert_tank3, ':volume'   ,$t3volume);
    oci_bind_by_name($insert_tank3, ':height'   ,$t3height);
    oci_bind_by_name($insert_tank3, ':width'    ,$t3width);
    oci_bind_by_name($insert_tank3, ':length'   ,$t3length);
    oci_bind_by_name($insert_tank3, ':maximum'  ,$t3max);
    

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
    $e = oci_error($insert_amp); echo "Error Updating Data: " . htmlentities($e['message']);

   }



}



if (!empty($_POST['Hyprid']) && isset($_POST['Hyprid'])) {

    $sqlhyprid = "INSERT INTO HYPRID (PID , SITE_CODE, TYPE, PANELS_QUANTITY, PANELS_CAPACITY, STATUS, MODULE_QUANTITY, BRAND) 
                  VALUES (:pid , :sitecode, :type, :pqty, :pcabacity, :status, :mqty,:brand)";
    
    
    $insert_hyprid = oci_parse($conn,$sqlhyprid);
    oci_bind_by_name($insert_hyprid, ':pid' ,$PID);
    oci_bind_by_name($insert_hyprid, ':sitecode' ,$sitecode);
    oci_bind_by_name($insert_hyprid, ':type' ,$solartype);
    oci_bind_by_name($insert_hyprid, ':pqty' ,$solarqty);
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


        // if (!empty($_POST['B1Battaries']) && !empty($_POST['B2Battaries']) && isset($_POST['B2Battaries'])) {

        //     $sqlbattaries2 = "UPDATE BATTERIES SET SITE_CODE =:sitecode, G2_BRAND =:brand, G2_CAPACITY =:cabacity, G2_TYPE=:type, G2_STATUS =:status, G2_QUANTITY =:qty, G2_INSTALLATION_DATE=:date";
            
            
        //     $insert_battaries2 = oci_parse($conn,$sqlbattaries2);
        //     oci_bind_by_name($insert_battaries2, ':pid' ,$PID);
        //     oci_bind_by_name($insert_battaries2, ':sitecode' ,$sitecode);
        //     oci_bind_by_name($insert_battaries2, ':brand'    ,$b2brand);
        //     oci_bind_by_name($insert_battaries2, ':cabacity' ,$b2capacity);
        //     oci_bind_by_name($insert_battaries2, ':type'     ,$b2type);
        //     oci_bind_by_name($insert_battaries2, ':status'   ,$b2status);
        //     oci_bind_by_name($insert_battaries2, ':qty'      ,$b2qty);
        //     oci_bind_by_name($insert_battaries2, ':date'     ,$b2b1date);
    
            
        //     if (oci_execute($insert_battaries2)) {  
        //         //echo "DONE";
        //         //header("Location:Update_thankyou.html");
        //      } 
        //        else { 
        //         $e = oci_error($insert_battaries2); echo "Error Updating Data: " . htmlentities($e['message']);
            
        //        }
            
         
        //     }


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
                      

                $sqlpower = "SELECT SITE_CODE,OWNERSHIP, QUANTITY FROM  GENERTAOR WHERE SITE_CODE=:sitecode";      
                $result_power = oci_parse($conn,$sqlpower);
                oci_bind_by_name($result_power, ':sitecode'   ,$sitecode);
                //oci_bind_by_name($select_power, ':gurde' ,$gurde);
                oci_execute($result_power);

              if($rowpower = oci_fetch_array($result_power, OCI_ASSOC + OCI_RETURN_NULLS)){
                $ownership = $rowpower['OWNERSHIP'];
                $quantity  = $rowpower['QUANTITY'];
                if($ownership == 'MTN'){
                
                    $sql = "UPDATE POWER_BACKUP SET MTN_GEN =:mtn ,QUANTITY=:qty  WHERE SITE_CODE=:sitecode"; 
                    $update_gen = oci_parse($conn,$sql);

                    oci_bind_by_name($update_gen, ':sitecode' ,$sitecode);
                    oci_bind_by_name($update_gen, ':mtn' ,$ownership);
                    oci_bind_by_name($update_gen, ':qty' ,$quantity);
                    oci_execute($update_gen);        
            
                    

              }


              elseif($ownership == 'MTN_OOS'){
            
                $sql = "UPDATE POWER_BACKUP SET MTN_OOS_GEN =:mtn  WHERE SITE_CODE=:sitecode"; 
                $update_gen = oci_parse($conn,$sql);

                oci_bind_by_name($update_gen, ':sitecode' ,$sitecode);
                oci_bind_by_name($update_gen, ':mtn' ,$ownership);
             
                oci_execute($update_gen);        
        
                

          }

          elseif($ownership == 'MTN_Rented'){
            
            $sql = "UPDATE POWER_BACKUP SET MTN_RENTED_GEN =:mtn  WHERE SITE_CODE=:sitecode"; 
            $update_gen = oci_parse($conn,$sql);

            oci_bind_by_name($update_gen, ':sitecode' ,$sitecode);
            oci_bind_by_name($update_gen, ':mtn' ,$ownership);
         
            oci_execute($update_gen);        
    
            

      }


      elseif($ownership == 'Other_MTN'){
            
        $sql = "UPDATE POWER_BACKUP SET OTHER_MTN_GEN =:mtn  WHERE SITE_CODE=:sitecode"; 
        $update_gen = oci_parse($conn,$sql);

        oci_bind_by_name($update_gen, ':sitecode' ,$sitecode);
        oci_bind_by_name($update_gen, ':mtn' ,$ownership);
     
        oci_execute($update_gen);        

        

  }



  elseif($ownership == 'Other'){
            
    $sql = "UPDATE POWER_BACKUP SET OTHER_GEN =:mtn  WHERE SITE_CODE=:sitecode"; 
    $update_gen = oci_parse($conn,$sql);

    oci_bind_by_name($update_gen, ':sitecode' ,$sitecode);
    oci_bind_by_name($update_gen, ':mtn' ,$ownership);
 
    oci_execute($update_gen);        

    

}
elseif($ownership == 'STE'){
            
    $sql = "UPDATE POWER_BACKUP SET STE_GEN =:mtn  WHERE SITE_CODE=:sitecode"; 
    $update_gen = oci_parse($conn,$sql);

    oci_bind_by_name($update_gen, ':sitecode' ,$sitecode);
    oci_bind_by_name($update_gen, ':mtn' ,$ownership);
 
    oci_execute($update_gen);        

    

}


elseif($ownership == 'Switch'){
            
    $sql = "UPDATE POWER_BACKUP SET SWITCH_GEN =:mtn  WHERE SITE_CODE=:sitecode"; 
    $update_gen = oci_parse($conn,$sql);

    oci_bind_by_name($update_gen, ':sitecode' ,$sitecode);
    oci_bind_by_name($update_gen, ':mtn' ,$ownership);
 
    oci_execute($update_gen);        

    

}


elseif($ownership == 'Syriatel'){
            
    $sql = "UPDATE POWER_BACKUP SET SYRIATEL_GEN =:mtn  WHERE SITE_CODE=:sitecode"; 
    $update_gen = oci_parse($conn,$sql);

    oci_bind_by_name($update_gen, ':sitecode' ,$sitecode);
    oci_bind_by_name($update_gen, ':mtn' ,$ownership);
 
    oci_execute($update_gen);        

    

}



}        

            $sqlhyp = "SELECT SITE_CODE,BRAND FROM  HYPRID WHERE SITE_CODE=:sitecode";      
            $result_hyp = oci_parse($conn,$sqlhyp);
            oci_bind_by_name($result_hyp, ':sitecode'   ,$sitecode);
            //oci_bind_by_name($result_hyp, ':gurde' ,$gurde);
            oci_execute($result_hyp);

          if($rowhyp = oci_fetch_array($result_hyp, OCI_ASSOC + OCI_RETURN_NULLS)){
            $brand = $rowhyp['BRAND'];

            
            if($brand == 'hyprid'){
                
                $sql = "UPDATE POWER_BACKUP SET HYPRID =:mtn WHERE SITE_CODE=:sitecode"; 
                $update_hyp = oci_parse($conn,$sql);

                oci_bind_by_name($update_hyp, ':sitecode' ,$sitecode);
                oci_bind_by_name($update_hyp, ':mtn' ,$brand);
                oci_execute($update_hyp);        
        
                

          }


          elseif($brand == 'inactive'){
                
            $sql = "UPDATE POWER_BACKUP SET HYPRID_INACTIVE =:mtn WHERE SITE_CODE=:sitecode"; 
            $update_hyp = oci_parse($conn,$sql);

            oci_bind_by_name($update_hyp, ':sitecode' ,$sitecode);
            oci_bind_by_name($update_hyp, ':mtn' ,$brand);
            oci_execute($update_hyp);        
    
            

      }

     elseif($brand == 'installed'){
                        
                $sql = "UPDATE POWER_BACKUP SET HYPRID_INSTALLED =:mtn WHERE SITE_CODE=:sitecode"; 
                $update_hyp = oci_parse($conn,$sql);

                oci_bind_by_name($update_hyp, ':sitecode' ,$sitecode);
                oci_bind_by_name($update_hyp, ':mtn' ,$brand);
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


        $stmt = "SELECT * FROM POWER_BACKUP WHERE PID =:pid";

        $result = oci_parse($conn,$stmt);
        
        oci_bind_by_name($result,':pid',$PID);
  
        oci_execute($result);   
    
        if($row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS)){

            $mtn1 = isset($row['MTN_GEN'])   ? 1 : 0;
            $oos1 = isset($row['MTN_OOS_GEN'])   ? 1 : 0;
            $rent1 = isset($row['MTN_RENTED_GEN'])   ? 1 : 0;
            $othermtn1 = isset($row['OTHER_MTN_GEN'])   ? 1 : 0;
            $other1 = isset($row['OTHER_GEN'])   ? 1 : 0;
            
            $ste1 = isset($row['STE_GEN'])   ? 1 : 0;
            $switch1 = isset($row['SWITCH_GEN'])   ? 1 : 0;

            $syriatel1 = isset($row['SYRIATEL_GEN'])   ? 1 : 0;
            $hyprid1 = isset($row['HYPRID'])   ? 1 : 0;
            $inactive1 = isset($row['HYPRID_INACTIVE'])   ? 1 : 0;
            $installed1 = isset($row['HYPRID_INSTALLED'])   ? 1 : 0;
            $hypridoos1 = isset($row['HYPRID_OOS'])   ? 1 : 0;
            $wind1 = isset($row['HYPRID_WIND'])   ? 1 : 0;
            $amp1 = isset($row['AMPERE'])   ? 1 : 0;

            $g1gel1 = isset($row['G1_GEL_BATT'])   ? 1 : 0;
            $g1lithium1 = isset($row['G1_LITHIUM_BATT'])   ? 1 : 0;


            $indust1 = isset($row['INDUSTRIAL_LINE'])   ? 1 : 0;
            $golden1 = isset($row['GOLDEN_LINE'])   ? 1 : 0;
            $ration1 = isset($row['RATINING_LINE'])   ? 1 : 0;
            $gel1 = isset($row['G2_GEL_BATT'])   ? 1 : 0;
            $lithium1 = isset($row['G2_LITHIUM_BATT'])   ? 1 : 0;
            $nonration1 = isset($row['NON_RATINING_LINE'])   ? 1 : 0;




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
            NON_RATINING_LINE=:non WHERE PID =:pid AND SITE_CODE=:sitecode
            ";
          $updatepower = oci_parse($conn, $stmtt);
        



          oci_bind_by_name($updatepower, ':pid', $PID);
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


          if (oci_execute($updatepower)) {  
            //echo "DONE";
            //header("Location:Update_thankyou.html");
         } 
           else { 
            $e = oci_error($updatepower); echo "Error Updating Data: " . htmlentities($e['message']);
        
           }


        }


    }

    
          }









                }







?>


<!DOCTYPE html>
<html>
<head>
    <title>Power Backup</title>
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






        .sub-options {
            display: none;
            margin-left: 20px;
        }

  .filter {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: space-between;}
  

    .filter div {
    flex: 1 1 calc(16.6% - 10px);
    min-width: 200px;
}


.filter label {
    display: block;
    font-weight: bold;
    margin-bottom: 8px;
    color: #1c355c;
    font-size: small;
}

 label {
    display: block;
    font-weight: bold;
    margin-bottom: 8px;
    color: #1c355c;
    font-size: small;
}

.filter select,
.filter input[type="text"],
.filter input[type="number"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccd0d4;
    border-radius: 25px;
    background-color: #d7e0ee;
    font-size: 13px;
    color: #1c355c;
    transition: border-color 0.3s, box-shadow 0.3s;
}

 select,
 input[type="text"],
 input[type="number"] {
    width: 60%;
    padding: 10px;
    margin-left:30px;
    border: 1px solid #ccd0d4;
    border-radius: 15px;
    background-color: #d7e0ee;
    font-size: 13px;
    color: #1c355c;
    transition: border-color 0.3s, box-shadow 0.3s;
}
.filter select:focus,
.filter input[type="text"]:focus,
.filter input[type="number"]:focus {
    border-color: #80bdff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    outline: none;
}

select:focus,
input[type="text"]:focus,
input[type="number"]:focus {
    border-color: #80bdff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    outline: none;
}



.filter h3,
.filter h4 {
    font-size: 1em;
    margin-bottom: 5px;
    color: #1c355c;
}
h3,
h4 {
    font-size: 1em;
    margin-bottom: 5px;
    color: #1c355c;
}

    </style>
    <script>
        function toggleSubOptions(id) {
            var div = document.getElementById('sub_' + id);
            if (document.getElementById(id).checked) {
                div.style.display = 'block';
            } else {
                div.style.display = 'none';
                // Uncheck all inside if hidden
                var checkboxes = div.querySelectorAll('input[type=checkbox]');
                checkboxes.forEach(cb => cb.checked = false);
            }
        }

        function confirmupdate(){
        return confirm ("Are you sure you want to update power backup?" );
     
    }
    </script>
</head>
<body>

<div class="container">
<div class="header">
            <h1></br> <?php echo $row['SITE_CODE']; ?> </h1>
             POWER BACKUP.</br>
</br>
        </div>
<form id="myForm" action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit="return confirmupdate();">
<div class="form1">
<div>
        <input type ="hidden" name ="id"       value="<?php echo $siteid; ?>">
        <input type ="hidden" name ="sitecode" value="<?php echo $row['SITE_CODE']; ?>">

</div>
<!-- <div class="filter"> -->
<div>
<h3> Electrical Counter Info:</h3><br>
<div>
<div>
  <!-- <label> Serial Number</label> -->
  <input type ="text" name="serial" placeholder ="Serial Number"><br><br>
  <!-- <label> Counter Circuit Breaker</label> -->
  <input type ="text" name="counterbraker" placeholder ="Counter Circuit Breaker"><br><br>
</div>

<label>Counter Status:</label>
  <div>
  <select name="cstatus">

   <option value="Bad">Bad</option>
   <option value="Good">Good</option>
   <option value="Need replace">Need replace</option>
   <option value="Need Overhauling">Need Overhauling</option>
   
</select>
  </div><br>

  <label>Counter Ownership:</label>
  <div>
  <select name="owner">

   <option value="MTN">MTN</option>

</select>
  </div><br>

  <label>Power Type:</label>
  <div>
  <select name="cpower">
  <option value="Three phase">Three phase </option>
   <option value="Mono phase">Mono phase </option>

</select>
  </div><br>



</div>


<h3> Cabinet Info:</h3><br>
<div>

<label> Cabinet Type:</label>
<div>
   <select name="cabtype">
   
                      <option value="Delta">Delta</option>
                      <option value="Ericsson">Ericsson</option>
                      <option value="Huawei">Huawei</option>
                      <option value="Eltek">Eltek</option>
                  </select>
  
  </div><br>
  <label> Rectifier Type:</label>
  <div>
   <select name="rectype">
   
                      <option value="Delta">Delta</option>
                      <option value="Ericsson">Ericsson</option>
                      <option value="ETP48200">ETP48200</option>
                      <option value="Eltek">Eltek</option>
                  </select>
  
  </div><br>

  <div>
  <!-- <label> Huawei IP</label> -->
  <input type ="text" name="HIP" size="5" placeholder="Huawei IP"><br><br>
</div>

<div>
  <!-- <label> Delta IP</label> -->
  <input type ="text" name="DIP" size="5" placeholder="Delta IP"><br><br>
</div>

<div>
  <!-- <label> ELTEK IP</label> -->
  <input type ="text" name="EIP" size="5" placeholder="ELTEK IP"><br><br>
</div>

  <!-- <label> AC Module Quantity</label> -->
  <input type ="text" name="ACqty" size="5" placeholder="AC Module Quantity"><br><br>
<!-- 
<label> Solar Module Quantity</label> -->
  <input type ="text" name="solarqty" size="5" placeholder="Solar Module Quantity"><br><br>


  <label>Cabinet Cage:</label>
  <div><br>
<input type ="radio" name= "cabinetcage"> Yes 
<input type ="radio" name= "cabinetcage"> No 
  </div><br>
  <label> Note</label>
  <input type ="text" name="cabnote" size="5"><br><br>

</div>





<h3> Generator Info:</h3><br>
<label><input type="checkbox" name="Gen" id="main1" onclick="toggleSubOptions('main1')"> Generator</label><br>
<div id="sub_main1" class="sub-options">
   
 
    

      <label> Brand:</label>
      <div>
     <select name="gen_brand">
    
                        <option value="Paknika">Paknika</option>
                        <option value="Sdmo">Sdmo</option>
                        <option value="Saccal">Saccal</option>
                        <option value="Trion">Trion</option>
                        <option value="Green Power">Green Power</option>
                        <option value="Telegen">Telegen</option>
                        <option value="JET">JET</option>
                        <option value="MPG">MPG</option>
                        <option value="FAW">FAW</option>
                        <option value="KeyPower">KeyPower</option>
                        <option value="Valiant">Valiant</option>
                        <option value="JIMCO">JIMCO</option>
                        <option value="EATON">EATON</option>
                    </select>
                    </div><br>
    

    
    
    <label> Engine Brand:</label>
    <div>
   <select name="engine_brand">
   
                      <option value="-">-</option>
                      <option value="Paknika">Paknika</option>
                      <option value="Yanmar">Yanmar</option>
                      <option value="John Deere">John Deere</option>
                      <option value="Kohler">Kohler</option>
                      <option value="YORK">YORK</option>
                      <option value="FAW">FAW</option>
                      <option value="Mitsubishi">Mitsubishi</option>
                      <option value="Lister">Lister</option>
                    
                  </select>
  
  </div><br>



  <label>Initial Status:</label>
  <div>
  <select name="status">
   
   <option value="-">-</option>
   <option value="Bad">Bad</option>
   <option value="Good">Good</option>
   <option value="Need replace">Need replace</option>
   <option value="Need Overhauling">Need Overhauling</option>
   
</select>
  </div><br>

  <label> Ownership:</label>
    <div>
   <select name="ownership">
                      <option value="MTN">MTN</option>
                      <option value="MTN_OOS">MTN_OOS</option>
                      <option value="MTN_Rented">MTN_Rented</option>
                      <option value="Other_MTN">Other_MTN</option>
                      <option value="Other">Other</option>
                      <option value="STE">STE</option>
                      <option value="Switch">Switch</option>
                      <option value="Syriatel">Syriatel</option>
               
                    
                  </select>
  
  </div><br>



  <!-- <label>Capacity:</label> -->
  <div>
<input type ="text" name= "capacity" size= "5" placeholder ="Capacity">
  </div><br>

  <!-- <label>Quantity:</label> -->
  <div>
<input type ="text" name= "qty" size= "5" placeholder ="Quantity">
  </div><br>

  <label>Generator Cage:</label>
  <div><br>
<input type ="radio" name= "cage"> Yes 
<input type ="radio" name= "cage"> No 
  </div><br>

  <h4>Tanks Info:</h4>

  <label><input type="checkbox" name="tank1" id="main13" onclick="toggleSubOptions('main13')"> Tank1</label>
<div id="sub_main13" class="sub-options">


<label> Shape:</label>
    <div>
   <select name="t1shape">

                      <option value="Cuboid">Cuboid</option>
                      <option value="Cylinder">Cylinder</option>

                  </select>
  
  </div><br>
<label> Type:</label>
    <div>
   <select name="t1type">

                      <option value="Internal">Internal</option>
                      <option value="External">External</option>
                      
                  </select>
  
  </div><br>



    <input type ="text" name="t1volume" size="5" placeholder="Actual Volume"><br><br>
    <input type ="text" name="t1height" size="5" placeholder="Height"><br><br>
    <input type ="text" name="t1width" size="5"  placeholder="Width"><br><br>
    <input type ="text" name="t1length" size="5" placeholder="Length"><br><br>
    <input type ="text" name="t1max" size="5" placeholder="Maximum fuel Quantity"><br><br>


</div>


<label><input type="checkbox" name="tank2" id="main14" onclick="toggleSubOptions('main14')"> Tank2</label>
<div id="sub_main14" class="sub-options">


<label> Shape:</label>
    <div>
   <select name="t2shape">

                      <option value="Cuboid">Cuboid</option>
                      <option value="Cylinder">Cylinder</option>

                  </select>
  
  </div><br>
<label> Type:</label>
    <div>
   <select name="t2type">

                      <option value="Internal">Internal</option>
                      <option value="External">External</option>
                      
                  </select>
  
  </div><br>



    <input type ="text" name="t2volume" size="5" placeholder="Actual Volume"><br><br>
    <input type ="text" name="t2height" size="5" placeholder="Height"><br><br>
    <input type ="text" name="t2width" size="5"  placeholder="Width"><br><br>
    <input type ="text" name="t2length" size="5" placeholder="Length"><br><br>
    <input type ="text" name="t2max" size="5" placeholder="Maximum fuel Quantity"><br><br>


</div>


<label><input type="checkbox" name="tank3" id="main15" onclick="toggleSubOptions('main15')"> Tank3</label>
<div id="sub_main15" class="sub-options">


<label> Shape:</label>
    <div>
   <select name="t3shape">

                      <option value="Cuboid">Cuboid</option>
                      <option value="Cylinder">Cylinder</option>

                  </select>
  
  </div><br>
<label> Type:</label>
    <div>
   <select name="t3type">

                      <option value="Internal">Internal</option>
                      <option value="External">External</option>
                      
                  </select>
  
  </div><br>



    <input type ="text" name="t3volume" size="5" placeholder="Actual Volume"><br><br>
    <input type ="text" name="t3height" size="5" placeholder="Height"><br><br>
    <input type ="text" name="t3width" size="5"  placeholder="Width"><br><br>
    <input type ="text" name="t3length" size="5" placeholder="Length"><br><br>
    <input type ="text" name="t3max" size="5" placeholder="Maximum fuel Quantity"><br><br>


</div>








</div>
<h3> Solar Info:</h3><br>
<label><input type="checkbox" name="Hyprid" id="main2" onclick="toggleSubOptions('main2')"> Hyprid "Solar"</label><br>
<div id="sub_main2" class="sub-options">

  <label> Type</label>
    <div>
   <select name="solartype">

                      <option value="Delta">Delta</option>
                      <option value="Eltek">Eltek</option>

                  </select>
  
  </div><br>

  <label> Status</label>
    <div>
   <select name="solarstatus">

                      <option value="Active">Active</option>
                      <option value="Not Active">Not Active</option>

                  </select>
  
  </div><br>

  <!-- <label>Solar Panels Quantity</label> -->
  <div>
<input type ="text" name= "solarqty" size= "5" placeholder = "Solar Panels Quantity">
  </div><br>
  <!-- <label>Solar Panel Capacity</label> -->
  <div>
<input type ="text" name= "solarcapacity" size= "5" placeholder = "Solar Panel Capacity">
  </div><br>
  <!-- <label>Solar Module Quantity</label> -->
  <div>
<input type ="text" name= "solarmodqty" size= "5" placeholder = "Solar Module Quantity">
  </div><br>

  <label> Ownership</label>
    <div>
   <select name="solarbrand">

                      <option value="hyprid"> Hyprid</option>
                      <option value="inactive"> Inactive</option>
                      <option value="installed"> Installed</option>
                      <option value="OOS"> OOS</option>
                      <option value="Wind"> Wind</option>

                  </select>
  
  </div><br>

</div>

<!-- You can add a form and PHP logic to save selected options -->

<h3> Ampere Info:</h3><br>
<label><input type="checkbox" name="Ampere" id="main4" onclick="toggleSubOptions('main4')"> Ampere</label><br>
<div id="sub_main4" class="sub-options">
<!-- <label>Ampere Capacity</label> -->
  <div>
<input type ="text" name= "ampcapacity" size= "5" placeholder="Ampere Capacity">
  </div><br>

  <!-- <label>Ampere Duration</label> -->
  <div>
<input type ="text" name= "ampduration" size= "5" placeholder="Ampere Duration">
  </div><br>
</div>


<div>
<h3> Batteries Info:</h3><br>
<label><input type="checkbox" name="B1Battaries" id="main5" onclick="toggleSubOptions('main5')"> Batteries</label><br>
<div id="sub_main5" class="sub-options">



<label> Brand:</label>
    <div>
   <select name="b1brand">

                      <option value="North_Star">North Star</option>
                      <option value="Narada">Narada</option>
                      <option value="Power_Safe">Power Safe</option>
                      <option value="CDTRUE">CDTRUE</option>
                      <option value="Huawei">Huawei</option>
                      <option value="Agisson">Agisson</option>
                      <option value="Deye">Deye</option>
                      <option value="Riyada">Riyada</option>
                      <option value="AHG">AHG</option>
                      <option value="VR-Solar">VR-Solar</option>
                      <option value="Shoto">Shoto</option>
                      <option value="GFM">GFM</option>
                      <option value="Coslight">Coslight</option>
                      <option value="NO">NO</option>
                      <option value="Angeergy">Angeergy</option>
                      <option value="Marathon">Marathon</option>
                      <option value="Fiamm">Fiamm</option>
                      <option value="Sonnenschein">Sonnenschein</option>
                      <option value="LI_Ion">LI - Ion</option>
                  </select>
  
  </div><br>

  <label> Type:</label>
    <div>
   <select name="b1type">

                      <option value="Gel">Gel</option>
                      <option value="Lithium">Lithium</option>
                  </select>
  
  </div><br>

  <label> Status:</label>
    <div>
   <select name="b1status">

                      <option value="Active">Active</option>
                      <option value="Not Active">Not Active</option>
                  </select>
  
  </div><br>

  <div>
    <!-- <label> Quantity:</label> -->
    <input type="text" name="b1qty" placeholder = "Quantity"><br>
  
  </div><br>

  <div>
    <!-- <label> Capacity:</label> -->
    <input type="text" name="b1capacity" placeholder = "Capacity"><br>
  
  </div><br>


  <div>
    <label> Installation Date:</label>
    <input type="date" name="b1date" placeholder = "Installation Date"><br>
  
  </div><br>
  <label><input type="checkbox" name="B2Battaries" id="main19" onclick="toggleSubOptions('main19')">Adittional Battaries</label><br>
        <div id="sub_main19" class="sub-options">

        <label> Brand:</label>
    <div>
   <select name="b2brand">

                      <option value="North_Star">North Star</option>
                      <option value="Narada">Narada</option>
                      <option value="Power_Safe">Power Safe</option>
                      <option value="CDTRUE">CDTRUE</option>
                      <option value="Huawei">Huawei</option>
                      <option value="Agisson">Agisson</option>
                      <option value="Deye">Deye</option>
                      <option value="Riyada">Riyada</option>
                      <option value="AHG">AHG</option>
                      <option value="VR-Solar">VR-Solar</option>
                      <option value="Shoto">Shoto</option>
                      <option value="GFM">GFM</option>
                      <option value="Coslight">Coslight</option>
                      <option value="NO">NO</option>
                      <option value="Angeergy">Angeergy</option>
                      <option value="Marathon">Marathon</option>
                      <option value="Fiamm">Fiamm</option>
                      <option value="Sonnenschein">Sonnenschein</option>
                      <option value="LI_Ion">LI - Ion</option>
                  </select>
  
  </div><br>

  <label> Type:</label>
    <div>
   <select name="b2type">

                      <option value="Gel">Gel</option>
                      <option value="Lithium">Lithium</option>
                  </select>
  
  </div><br>

  <label> Status:</label>
    <div>
   <select name="b2status">

                      <option value="Active">Active</option>
                      <option value="Not Active">Not Active</option>
                  </select>
  
  </div><br>

  <div>
    <!-- <label> Quantity:</label> -->
    <input type="text" name="b2qty" placeholder="Quantity"><br>
  
  </div><br>

  <div>
    <!-- <label> Capacity:</label> -->
    <input type="text" name="b2capacity" placeholder="Capacity"><br>
  
  </div><br>


  <div>
    <label> Installation Date:</label>
    <input type="date" name="b2date" placeholder="Installation Date"><br>
  
  </div><br>



</div>
</div>
</div>

<label><input type="checkbox" name="lines" id="main31" onclick="toggleSubOptions('main31')"> Lines</label><br>
<div id="sub_main31" class="sub-options">
<label> Lines Type:</label>
    
   <select name="ltype">

                      <option value="Industrial">Industrial</option>
                      <option value="Golden">Golden</option>
                      <option value="Rationing ">Rationing </option>
                      <option value="Non Rationing ">Non Rationing </option>
                    
                  </select>
  
  <br>

</div>
<h3> Site Safty:</h3><br>
<label>Cage:</label>
  <div><br>
<input type ="radio" name= "sitecage" value= "Yes"> Yes 
<input type ="radio" name= "sitecage" value= "No"> No 
  </div><br>


  <label>Gurde:</label>
  <div><br>
<input type ="radio" name= "sitegurde" value= "Yes"> Yes 
<input type ="radio" name= "sitegurde" value= "No"> No 
  </div><br>


    </div>
</div>

<div class="footer">
<div class="submit">
<input type="submit" name="submit" value="Done">
    </div>
    <div style="clear:both;"></div>
        </div>


   


    
   
    </div>
</body>
</html>


