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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Backup Configuration</title>
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

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
        color: var(--dark);
        line-height: 1.6;
        padding: 20px;
        min-height: 100vh;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    header {
        background: linear-gradient(to right, var(--primary), #2c5282);
        color: white;
        padding: 25px;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
        text-align: center;
        margin-bottom: 25px;
        box-shadow: var(--box-shadow);
    }

    header h1 {
        font-size: 2.2rem;
        margin-bottom: 5px;
    }

    header p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .audit-info {
        background: #e3f2fd;
        border-left: 4px solid var(--secondary);
        padding: 15px 20px;
        margin-bottom: 25px;
        border-radius: var(--border-radius);
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: var(--box-shadow);
    }

    .audit-info i {
        color: var(--secondary);
        font-size: 1.4rem;
    }

    .form-container {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .form-section {
        padding: 25px;
        border-bottom: 1px solid #eaeaea;
    }

    .form-section:last-child {
        border-bottom: none;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        cursor: pointer;
    }

    .section-header h3 {
        font-size: 1.4rem;
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-header i {
        transition: var(--transition);
    }

    .section-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .form-group label i {
        color: var(--secondary);
    }

    .required label:after {
        content: " *";
        color: var(--accent);
    }

    input,
    select,
    textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #d1d5db;
        border-radius: var(--border-radius);
        font-size: 1rem;
        transition: var(--transition);
        background: #f8fafc;
    }

    input:focus,
    select:focus,
    textarea:focus {
        outline: none;
        border-color: var(--secondary);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        background: white;
    }

    input[type="checkbox"],
    input[type="radio"] {
        width: auto;
        margin-right: 8px;
    }

    .checkbox-group,
    .radio-group {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 8px;
    }

    .checkbox-item,
    .radio-item {
        display: flex;
        align-items: center;
        background: #f1f8ff;
        padding: 10px 15px;
        border-radius: var(--border-radius);
        flex: 1 0 200px;
    }

    .sub-options {
        background: #f0f9ff;
        padding: 15px;
        margin-top: 15px;
        border-radius: var(--border-radius);
        border-left: 3px solid var(--secondary);
    }

    .tank-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 15px;
    }

    .tank-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: var(--border-radius);
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .tank-card h4 {
        color: var(--primary);
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e2e8f0;
    }

    .form-footer {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        padding: 25px;
        background: #f8fafc;
        border-top: 1px solid #eaeaea;
    }

    .btn {
        padding: 12px 30px;
        border: none;
        border-radius: var(--border-radius);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: #152642;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .toggle-icon {
        transition: var(--transition);
    }

    .collapsed .toggle-icon {
        transform: rotate(0deg);
    }

    .expanded .toggle-icon {
        transform: rotate(180deg);
    }

    .section-collapse {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }

    .section-content {
        max-height: 2000px;
        transition: max-height 0.5s ease-in;
    }

    .collapsed .section-content {
        max-height: 0;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .section-content {
            grid-template-columns: 1fr;
        }

        .tank-grid {
            grid-template-columns: 1fr;
        }

        .form-footer {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }

    .form-group .hint {
        font-size: 0.85rem;
        color: #6b7280;
        margin-top: 5px;
        font-style: italic;
    }
    </style>
</head>

<body>

        <form id="myForm" action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit="return confirmupdate();">
            <header>
                <h1><i class="fas fa-bolt"></i> Power Backup Configuration</h1>
                <p>Comprehensive setup for your site's power systems</p>
            </header>
            <div class="form1">
                <div>
                    <input type="hidden" name="id" value="<?php echo $siteid; ?>">
                    <input type="hidden" name="sitecode" value="<?php echo $row['SITE_CODE']; ?>">
            <div class="audit-info">
                <i class="fas fa-info-circle"></i>
                <div>All changes are logged in the audit trail for security and compliance purposes.</div>
            </div>
            
            <div class="form-container">
                <!-- Site Information Section -->
                <div class="form-section">
                    <div class="section-header expanded" data-section="siteInfo">
                        <h3><i class="fas fa-building"></i> Site Information</h3>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </div>
                    <div class="section-content">
                        <div class="form-group required">
                            <label for="siteCode"><i class="fas fa-qrcode"></i> Site Code</label>
                            <input type="text" id="siteCode" name="siteCode" value=<?php echo $row['SITE_CODE']; ?> readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="siteName"><i class="fas fa-map-marker-alt"></i> Site Name</label>
                            <input type="text" id="siteName" name="siteName" value="Main Data Center" readonly>
                        </div>
                    </div>
                </div>
                
                
                <!-- Electrical Counter Section -->
                <div class="form-section">
                    <div class="section-header expanded" data-section="electrical">
                        <h3><i class="fas fa-tachometer-alt"></i> Electrical Counter</h3>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </div>
                    <div class="section-content">
                        <div class="form-group">
                            <label for="serialNumber"><i class="fas fa-hashtag"></i> Serial Number</label>
                            <input type="text" id="serialNumber" name="serialNumber" placeholder="Enter serial number">
                        </div>
                        
                        <div class="form-group">
                            <label for="counterBreaker"><i class="fas fa-plug"></i> Counter Circuit Breaker</label>
                            <input type="text" id="counterBreaker" name="counterBreaker" placeholder="Enter breaker details">
                        </div>

                        <div class="form-group">
                            <label for="counterStatus"><i class="fas fa-info-circle"></i> Counter Status</label>
                            <select id="counterStatus" name="counterStatus">
                                <option value="">Select status</option>
                                <option value="Good">Good</option>
                                <option value="Bad">Bad</option>
                                <option value="Need replace">Need replace</option>
                                <option value="Need Overhauling">Need Overhauling</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="ownership"><i class="fas fa-user-tag"></i> Ownership</label>
                            <select id="ownership" name="ownership">
                                <option value="MTN">MTN</option>
                                <option value="Third Party">Third Party</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="powerType"><i class="fas fa-bolt"></i> Power Type</label>
                            <select id="powerType" name="cpower">
                                <option value="Three phase">Three phase</option>
                                <option value="Mono phase">Mono phase</option>
                            </select>
                        </div>
                    </div>



                    </div>
                
                <!-- Cabinet Information Section -->
                <div class="form-section">
                    <div class="section-header expanded" data-section="cabinet">                        <h3><i class="fas fa-server"></i> Cabinet Information</h3>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </div>
                    <div class="section-content">
                        <div class="form-group">
                            <label for="cabinetType"><i class="fas fa-cube"></i> Cabinet Type</label>
                            <select id="cabinetType" name="cabinetType">
                                <option value="">Select cabinet type</option>
                                <option value="Delta">Delta</option>
                                <option value="Ericsson">Ericsson</option>
                                <option value="Huawei">Huawei</option>
                                <option value="Eltek">Eltek</option>
                            </select>
                        </div>
                     <div class="form-group">
                            <label for="rectifierType"><i class="fas fa-microchip"></i> Rectifier Type</label>
                            <select id="rectifierType" name="rectifierType">
                                <option value="">Select rectifier type</option>
                                <option value="Delta">Delta</option>
                                <option value="Ericsson">Ericsson</option>
                                <option value="ETP48200">ETP48200</option>
                                <option value="Eltek">Eltek</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-network-wired"></i> IP Addresses</label>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <input type="text" name="huaweiIP" placeholder="Huawei IP">
                                <input type="text" name="deltaIP" placeholder="Delta IP">
                                <input type="text" name="eltekIP" placeholder="ELTEK IP">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label><i class="fas fa-solar-panel"></i> Module Quantities</label>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <input type="number" name="acModuleQty" placeholder="AC Module Quantity">
                                <input type="number" name="solarModuleQty" placeholder="Solar Module Quantity">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label><i class="fas fa-shield-alt"></i> Cabinet Cage</label>
                            <div class="radio-group">
                                <div class="radio-item">
                                    <input type="radio" id="cabinetCageYes" name="cabinetCage" value="Yes">
                                    <label for="cabinetCageYes">Yes</label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" id="cabinetCageNo" name="cabinetCage" value="No">
                                    <label for="cabinetCageNo">No</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="cabinetNotes"><i class="fas fa-sticky-note"></i> Notes</label>
                            <textarea id="cabinetNotes" name="cabinetNotes" rows="3" placeholder="Additional cabinet notes"></textarea>
                        </div>
                    </div>
                </div>
                






                    <!-- Generator Information Section -->
                <div class="form-section">
                    <div class="section-header expanded" data-section="generator">
                        <h3><i class="fas fa-gas-pump"></i> Generator Information</h3>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </div>
                    <div class="section-content">
                        <div class="form-group">
                            <label><i class="fas fa-check-circle"></i> Generator Installed</label>
                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="hasGenerator" name="hasGenerator">
                                    <label for="hasGenerator">Yes, we have a generator</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="sub-options">
                            <div class="form-group">
                                <label for="genBrand"><i class="fas fa-industry"></i> Generator Brand</label>
                                <select id="genBrand" name="gen_brand">
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
                        </div>


                            <div class="form-group">
                                <label for="engineBrand"><i class="fas fa-cogs"></i> Engine Brand</label>
                                <select id="engineBrand" name="engine_brand">


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

                        </div>



                        <div class="form-group">
                                <label for="genStatus"><i class="fas fa-clipboard-check"></i> Initial Status</label>
                                <select id="genStatus" name="genStatus">

                                <option value="-">-</option>
                                <option value="Bad">Bad</option>
                                <option value="Good">Good</option>
                                <option value="Need replace">Need replace</option>
                                <option value="Need Overhauling">Need Overhauling</option>

                            </select>
                        </div>                           
                            <div class="form-group">
                                <label for="ownership"><i class="fas fa-user-tag"></i> Ownership</label>
                                <select id="ownership" name="ownership">
                                <option value="MTN">MTN</option>
                                <option value="MTN_OOS">MTN_OOS</option>
                                <option value="MTN_Rented">MTN_Rented</option>
                                <option value="Other_MTN">Other_MTN</option>
                                <option value="Other">Other</option>
                                <option value="STE">STE</option>
                                <option value="Switch">Switch</option>
                                <option value="Syriatel">Syriatel</option>


                            </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="capacity"><i class="fas fa-charging-station"></i> Capacity (kVA)</label>
                                <input type="text" id="capacity" name="capacity" placeholder="Enter capacity">
                            </div>

                        <!-- <label>Quantity:</label> -->
                        <div class="form-group">
                                <label for="quantity"><i class="fas fa-calculator"></i> Quantity</label>
                                <input type="number" id="quantity" name="quantity" min="1" value="1">
                            </div>
                            
                            <div class="form-group">
                                <label><i class="fas fa-shield-alt"></i> Generator Cage</label>
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input type="radio" id="genCageYes" name="genCage" value="Yes">
                                        <label for="genCageYes">Yes</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" id="genCageNo" name="genCage" value="No">
                                        <label for="genCageNo">No</label>
                                    </div>
                                </div>
                            </div>
                            
                            <h4 style="margin: 20px 0 15px; color: var(--primary);">Tanks Information</h4>
                            
                            <div class="tank-grid">
                                <div class="tank-card">
                                    <h4><i class="fas fa-oil-can"></i> Tank 1</h4>
                                    <div class="form-group">
                                        <label>Shape</label>
                                        <select name="t1shape">
                                            <option value="Cuboid">Cuboid</option>
                                            <option value="Cylinder">Cylinder</option>
                                        </select>

                            </div>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select name="t1type">
                                            <option value="Internal">Internal</option>
                                            <option value="External">External</option>
                                        </select>
                            </div>
                                    <div class="form-group">
                                        <label>Volume (L)</label>
                                        <input type="number" name="t1volume" placeholder="Actual volume">
                                    </div>
                                    <div class="form-group">
                                        <label>Dimensions (cm)</label>
                                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px;">
                                            <input type="number" name="t1height" placeholder="H">
                                            <input type="number" name="t1width" placeholder="W">
                                            <input type="number" name="t1length" placeholder="L">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Max Capacity (L)</label>
                                        <input type="number" name="t1max" placeholder="Maximum fuel">
                                    </div>
                                </div>
                                
                                <div class="tank-card">
                                    <h4><i class="fas fa-oil-can"></i> Tank 2</h4>
                                    <div class="form-group">
                                        <label>Shape</label>
                                        <select name="t2shape">
                                            <option value="Cuboid">Cuboid</option>
                                            <option value="Cylinder">Cylinder</option>
                                        </select>
                                    </div>
                            <div class="form-group">
                                        <label>Type</label>
                                        <select name="t2type">
                                            <option value="Internal">Internal</option>
                                            <option value="External">External</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Volume (L)</label>
                                        <input type="number" name="t2volume" placeholder="Actual volume">
                                    </div>
                                    <div class="form-group">
                                        <label>Dimensions (cm)</label>
                                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px;">
                                            <input type="number" name="t2height" placeholder="H">
                                            <input type="number" name="t2width" placeholder="W">
                                            <input type="number" name="t2length" placeholder="L">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Max Capacity (L)</label>
                                        <input type="number" name="t2max" placeholder="Maximum fuel">
                                    </div>
                                </div>

                                <div class="tank-card">
                                    <h4><i class="fas fa-oil-can"></i> Tank 3</h4>
                                    <div class="form-group">
                                        <label>Shape</label>
                                <select name="t3shape">
                                    <option value="Cuboid">Cuboid</option>
                                    <option value="Cylinder">Cylinder</option>
                                </select>
                            </div>
                            <div class="form-group">
                                        <label>Type</label>
                                        <select name="t3type">
                                            <option value="Internal">Internal</option>
                                            <option value="External">External</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Volume (L)</label>
                                        <input type="number" name="t3volume" placeholder="Actual volume">
                                    </div>



                            <div class="form-group">
                                        <label>Dimensions (cm)</label>
                                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px;">
                                            <input type="number" name="t3height" placeholder="H">
                                            <input type="number" name="t3width" placeholder="W">
                                            <input type="number" name="t3length" placeholder="L">
                                        </div>
                                    </div>
                            <div class="form-group">
                                        <label>Max Capacity (L)</label>
                                        <input type="number" name="t3max" placeholder="Maximum fuel">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Solar Information Section -->
                <div class="form-section">
                    <div class="section-header" data-section="solar">
                        <h3><i class="fas fa-solar-panel"></i> Solar Information</h3>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </div>
                    <div class="section-content">
                        <div class="form-group">
                            <label><i class="fas fa-check-circle"></i> Hybrid/Solar Installed</label>
                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input type="checkbox" id="hasSolar" name="hasSolar">
                                    <label for="hasSolar">Yes, we have solar system</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="sub-options">
                            <div class="form-group">
                                <label for="solarType"><i class="fas fa-cogs"></i> System Type</label>
                                <select id="solarType" name="solarType">
                                    <option value="Delta">Delta</option>
                                    <option value="Eltek">Eltek</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="solarStatus"><i class="fas fa-clipboard-check"></i> System Status</label>
                                <select id="solarStatus" name="solarStatus">
                                    <option value="Active">Active</option>
                                    <option value="Not Active">Not Active</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="solarBrand"><i class="fas fa-industry"></i> Brand Ownership</label>
                                <select id="solarBrand" name="solarBrand">
                                    <option value="hyprid">Hyprid</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="installed">Installed</option>
                                    <option value="OOS">OOS</option>
                                    <option value="Wind">Wind</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="panelsQty"><i class="fas fa-solar-panel"></i> Panels Quantity</label>
                                <input type="number" id="panelsQty" name="panelsQty" min="1" value="1">
                            </div>
                            
                            <div class="form-group">
                                <label for="panelCapacity"><i class="fas fa-battery-full"></i> Panel Capacity (W)</label>
                                <input type="number" id="panelCapacity" name="panelCapacity" placeholder="Enter capacity">
                            </div>
                            
                            <div class="form-group">
                                <label for="modulesQty"><i class="fas fa-cubes"></i> Modules Quantity</label>
                                <input type="number" id="modulesQty" name="modulesQty" min="1" value="1">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Batteries Information Section -->
                <div class="form-section">
                    <div class="section-header" data-section="batteries">
                        <h3><i class="fas fa-battery-three-quarters"></i> Batteries Information</h3>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </div>
                    <div class="section-content">
                        <div class="tank-grid">
                            <div class="tank-card">
                                <h4><i class="fas fa-battery-full"></i> Group 1 Batteries</h4>
                                <div class="form-group">
                                    <div id="sub_main5" class="sub-options">
                                <label for="solarBrand"><i class="fas fa-industry"></i> Brand Ownership</label>
                                <select id="solarBrand" name="solarBrand">
                                    <option value="hyprid">Hyprid</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="installed">Installed</option>
                                    <option value="OOS">OOS</option>
                                    <option value="Wind">Wind</option>
                                </select>
                        </div>

                    </div>
                    <h3> Ampere Info:</h3><br>
                    <label><input type="checkbox" name="Ampere" id="main4" onclick="toggleSubOptions('main4')">
                        Ampere</label><br>
                    <div id="sub_main4" class="sub-options">
                        <!-- <label>Ampere Capacity</label> -->
                        <div>
                            <input type="text" name="ampcapacity" size="5" placeholder="Ampere Capacity">
                        </div><br>

                        <!-- <label>Ampere Duration</label> -->
                        <div>
                            <input type="text" name="ampduration" size="5" placeholder="Ampere Duration">
                        </div><br>
                    </div>


                    <div>
                        <h3> Batteries Info:</h3><br>
                        <label><input type="checkbox" name="B1Battaries" id="main5" onclick="toggleSubOptions('main5')">
                            Batteries</label><br>
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

                            </div>

                            <div class="form-group">
                                    <label for="b1Type"><i class="fas fa-cogs"></i> Type</label>
                                    <select id="b1Type" name="b1Type">
                                        <option value="Gel">Gel</option>
                                        <option value="Lithium">Lithium</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="b1Status"><i class="fas fa-clipboard-check"></i> Status</label>
                                    <select id="b1Status" name="b1Status">
                                        <option value="Active">Active</option>
                                        <option value="Not Active">Not Active</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="b1Qty"><i class="fas fa-calculator"></i> Quantity</label>
                                    <input type="number" id="b1Qty" name="b1Qty" min="1" value="1">
                                </div>
                                
                                <div class="form-group">
                                    <label for="b1Capacity"><i class="fas fa-charging-station"></i> Capacity (Ah)</label>
                                    <input type="number" id="b1Capacity" name="b1Capacity" placeholder="Enter capacity">
                                </div>
                                
                                <div class="form-group">
                                    <label for="b1Date"><i class="fas fa-calendar-alt"></i> Installation Date</label>
                                    <input type="date" id="b1Date" name="b1Date">
                                </div>
                            </div>
                            
                            <div class="tank-card">
                                <h4><i class="fas fa-battery-full"></i> Group 2 Batteries</h4>
                                <div class="form-group">
                                    <label for="b2Brand"><i class="fas fa-industry"></i> Brand</label>
                                    <select id="b2Brand" name="b2brand">
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

                                </div>

                                <div class="form-group">
                                    <label for="b2Type"><i class="fas fa-cogs"></i> Type</label>
                                    <select id="b2Type" name="b2type">
                                        <option value="Gel">Gel</option>
                                        <option value="Lithium">Lithium</option>
                                    </select>

                                </div>

                                <div class="form-group">
                                    <label for="b2Status"><i class="fas fa-clipboard-check"></i> Status</label>
                                    <select id="b2Status" name="b2status">
                                        <option value="Active">Active</option>
                                        <option value="Not Active">Not Active</option>
                                    </select>
                                </div>
                                    <!-- <label> Quantity:</label> -->

                               <div class="form-group">
                                    <label for="b2Qty"><i class="fas fa-calculator"></i> Quantity</label>
                                    <input type="number" id="b2Qty" name="b2Qty" min="1" value="1">
                                </div>
                                <div class="form-group">
                                    <label for="b2Capacity"><i class="fas fa-charging-station"></i> Capacity (Ah)</label>
                                    <input type="number" id="b2Capacity" name="b2capacity" placeholder="Enter capacity">
                                </div>
                                
                                <div class="form-group">
                                    <label for="b2Date"><i class="fas fa-calendar-alt"></i> Installation Date</label>
                                    <input type="date" id="b2Date" name="b2Date">
                                </div>
                            </div>
                        </div>
                    </div>

                    <label><input type="checkbox" name="lines" id="main31" onclick="toggleSubOptions('main31')">
                        Lines</label><br>
                    <div id="sub_main31" class="sub-options">
                        <label> Lines Type:</label>
<div class="form-section">
                    <div class="section-header" data-section="safety">
                        <h3><i class="fas fa-shield-alt"></i> Site Safety</h3>
                        <i class="fas fa-chevron-down toggle-icon"></i>
                    </div>
                    <div class="section-content">
                        <div class="form-group">
                            <label><i class="fas fa-shield-virus"></i> Site Cage</label>
                            <div class="radio-group">
                                <div class="radio-item">
                                    <input type="radio" id="siteCageYes" name="siteCage" value="Yes">
                                    <label for="siteCageYes">Yes</label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" id="siteCageNo" name="siteCage" value="No">
                                    <label for="siteCageNo">No</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label><i class="fas fa-hard-hat"></i> Guard Presence</label>
                            <div class="radio-group">
                                <div class="radio-item">
                                    <input type="radio" id="guardYes" name="guard" value="Yes">
                                    <label for="guardYes">Yes</label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" id="guardNo" name="guard" value="No">
                                    <label for="guardNo">No</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="linesType"><i class="fas fa-bolt"></i> Power Lines Type</label>
                            <select id="linesType" name="linesType">
                                <option value="Industrial">Industrial</option>
                                <option value="Golden">Golden</option>
                                <option value="Rationing">Rationing</option>
                                <option value="Non Rationing">Non Rationing</option>
                            </select>
                    </div>
                    <h3> Site Protection:</h3><br>
                    <label>Cage:</label>
                    <div><br>
                        <input type="radio" name="sitecage" value="Yes"> Yes
                        <input type="radio" name="sitecage" value="No"> No
                    </div><br>


                    <label>Gurde:</label>
                    <div><br>
                        <input type="radio" name="sitegurde" value="Yes"> Yes
                        <input type="radio" name="sitegurde" value="No"> No
                    </div><br>


                </div>
            </div>
                <!-- Form Footer -->
                <div class="form-footer">
                    <button type="button" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Configuration
                    </button>
                </div>
                <div style="clear:both;"></div>
            </div>







    </div>
    <script>
        // Collapsible section functionality
        document.querySelectorAll('.section-header').forEach(header => {
            header.addEventListener('click', () => {
                const content = header.nextElementSibling;
                header.classList.toggle('expanded');
                header.classList.toggle('collapsed');
            });
        });
        
        // Form submission
        document.getElementById('powerConfigForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Configuration saved successfully!');
        });
        
        // Toggle sub-options based on checkbox state
        document.getElementById('hasGenerator').addEventListener('change', function() {
            const subOptions = this.closest('.form-group').nextElementSibling;
            if (this.checked) {
                subOptions.style.display = 'block';
            } else {
                subOptions.style.display = 'none';
            }
        });
        
        document.getElementById('hasSolar').addEventListener('change', function() {
            const subOptions = this.closest('.form-group').nextElementSibling;
            if (this.checked) {
                subOptions.style.display = 'block';
            } else {
                subOptions.style.display = 'none';
            }
        });
        
        // Initialize hidden sub-options
        document.querySelectorAll('.sub-options').forEach(el => {
            el.style.display = 'none';
        });
    </script>
</body>

</html>