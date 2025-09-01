<?php 
include "config.php";
header('Content-Type: text/html; charset=UTF-8');
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
if(isset($_GET['id2'])) {
    $siteid = $_GET['id2'];
    
    // Query for site information
    $sql = "SELECT s.*, t.*, c.* FROM NEW_SITES s 
            JOIN TWO_G_SITES t ON(s.ID = t.SITE_ID) 
            JOIN TWO_G_CELLS c ON (t.CELL_ID = c.CID_KEY) 
            WHERE t.SITE_ID = :siteid";
    $result = oci_parse($conn, $sql);
    oci_bind_by_name($result, ':siteid', $siteid);
    oci_execute($result);
    $row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS);

    // Query for cells information
    $sqll = "SELECT t.*, c.* FROM TWO_G_SITES t 
             JOIN TWO_G_CELLS c ON (t.CELL_ID = c.CID_KEY) 
             WHERE t.SITE_ID = :siteid";
    $resultt = oci_parse($conn, $sqll);
    oci_bind_by_name($resultt, ':siteid', $siteid);
    
    // Initialize cells data array
    $data = [
        'A' => null, 'B' => null, 'C' => null, 'D' => null,
        'X' => null, 'Y' => null, 'Z' => null, 'W' => null,
        'V' => null, 'E' => null
    ];
    
    if (oci_execute($resultt)) {
        // Process all cell rows
        while ($row1 = oci_fetch_array($resultt, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $cellcode_char = substr($row1['CELL_CODE'], -1);
            if (in_array($cellcode_char, ['A','B','C','D','X','Y','Z','W','V','E'])) {
                $data[$cellcode_char] = $row1;
            }
        }
    }
} 

if(isset($_POST['submit']))
{

    $sid      = $_POST ['id'] ?? '';
    $cellid   = $_POST['cid'] ?? '' ; 
    $band     = $_POST['band'] ?? '';
    $BTS      = $_POST['BTS'] ?? '';
    $date2G   = $_POST['onairdate'] ?? '';
    $RBS1     = $_POST['900Rbs'] ?? '';
    $date1    = $_POST['900onairdate'] ?? '';
    $RBS2     = $_POST['1800Rbs'] ?? '';
    $status2G = $_POST['sitestatus'] ?? '';
    $date2    = $_POST['1800onairdate'] ?? '';
    $BSC      = $_POST['BSC'] ?? '';
    $rBSC     = $_POST['realBSC'] ?? ''; 
    $lac      = $_POST['lac'] ?? '';
    $snote    = $_POST['snotes'] ?? '';
    $sitecode = $_POST['sitecode'] ?? '';
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

            $cellid2    = $_POST['cellida'] ?? ''  ;
            $cellcode   = $_POST['cellcodea'] ?? '';
            $azimuth    = $_POST['azimutha'] ?? '' ;
            $height     = $_POST['heighta'] ?? ''  ;
            $mtilt      = $_POST['mtilta'] ?? ''   ;
            $etilt      = $_POST['etilta'] ?? ''   ;
            $aarea      = $_POST['area1a'] ?? ''   ;
            $earea      = $_POST['area2a'] ?? ''   ;
            $cnote      = $_POST['cnotesa'] ?? ''  ;
            $cname      = $_POST['cellnamea'] ?? '';
            //$cname = "Hello";
            $BSIC       = $_POST['BSICa'] ?? ''     ;
            $bcch       = $_POST['BCCHa'] ?? ''     ;
            $celldate   = $_POST['celldatea'] ?? '' ;
      
     
    
            if(!empty( $_POST['etilta'] && !empty($_POST['mtilta']))){
                $ttilt = sprintf('%d',$_POST['mtilta'] + $_POST['etilta']);
            }
            else{ $ttilt ="-";}


        }

        elseif($selected == 'B'){

            $cellid2    = $_POST['cellidb'] ?? ''  ;
            $cellcode   = $_POST['cellcodeb'] ?? '';
            $azimuth    = $_POST['azimuthb'] ?? '' ;
            $height     = $_POST['heightb'] ?? ''  ;
            $mtilt      = $_POST['mtiltb'] ?? ''   ;
            $etilt      = $_POST['etiltb'] ?? ''   ;
            $aarea      = $_POST['area1b'] ?? ''   ;
            $earea      = $_POST['area2b']  ?? ''  ;
            $cnote      = $_POST['cnotesb'] ?? ''  ;
            $cname      = $_POST['cellnameb'] ?? '';
          
            $BSIC       = $_POST['BSICb'] ?? ''     ;
            $bcch       = $_POST['BCCHb'] ?? ''     ;
            $celldate   = $_POST['celldateb'] ?? '' ;
      
     
    
            if(!empty( $_POST['etiltb'] && !empty($_POST['mtiltb']))){
                $ttilt = sprintf('%d',$_POST['mtiltb'] + $_POST['etiltb']);
            }
            else{ $ttilt ="-";}
    


        }



        elseif($selected == 'C'){

            $cellid2    = $_POST['cellidc'] ?? ''  ;
            $cellcode   = $_POST['cellcodec'] ?? '';
            $azimuth    = $_POST['azimuthc'] ?? '' ;
            $height     = $_POST['heightc'] ?? ''  ;
            $mtilt      = $_POST['mtiltc'] ?? ''   ;
            $etilt      = $_POST['etiltc'] ?? ''   ;
            $aarea      = $_POST['area1c'] ?? ''   ;
            $earea      = $_POST['area2c'] ?? ''   ;
            $cnote      = $_POST['cnotesc'] ?? ''  ;
            $cname      = $_POST['cellnamec'] ?? '';
         
            $BSIC       = $_POST['BSICc'] ?? ''     ;
            $bcch       = $_POST['BCCHc'] ?? ''     ;
            $celldate   = $_POST['celldatec'] ?? '' ;
      
     
    
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


            $cellid2    = $_POST['cellidy'] ?? ''  ;
            $cellcode   = $_POST['cellcodey'] ?? '';
            $azimuth    = $_POST['azimuthy'] ?? '' ;
            $height     = $_POST['heighty'] ?? ''  ;
            $mtilt      = $_POST['mtilty'] ?? ''   ;
            $etilt      = $_POST['etilty'] ?? ''   ;
            $aarea      = $_POST['area1y'] ?? ''   ;
            $earea      = $_POST['area2y'] ?? ''   ;
            $cnote      = $_POST['cnotesy'] ?? ''  ;
            $cname      = $_POST['cellnamey'] ?? '';
            $BSIC       = $_POST['BSICy'] ?? ''     ;
            $bcch       = $_POST['BCCHy'] ?? ''     ;
            $celldate   = $_POST['celldatey'] ?? '' ;
      
     
    
            if(!empty( $_POST['etilty'] && !empty($_POST['mtilty']))){
                $ttilt = sprintf('%d',$_POST['mtilty'] + $_POST['etilty']);
            }
            else{ $ttilt ="-";}
        }
        
        elseif($selected == 'Z'){

            $cellid2    = $_POST['cellidz'] ?? ''  ;
            $cellcode   = $_POST['cellcodez'] ?? '';
            $azimuth    = $_POST['azimuthz'] ?? '' ;
            $height     = $_POST['heightz'] ?? ''  ;
            $mtilt      = $_POST['mtiltz'] ?? ''   ;
            $etilt      = $_POST['etiltz'] ?? ''   ;
            $aarea      = $_POST['area1z'] ?? ''   ;
            $earea      = $_POST['area2z'] ?? ''   ;
            $cnote      = $_POST['cnotesz'] ?? ''  ;
            $cname      = $_POST['cellnamez'] ?? '';
            $BSIC       = $_POST['BSICz'] ?? ''     ;
            $bcch       = $_POST['BCCHz'] ?? ''     ;
            $celldate   = $_POST['celldatez'] ?? '' ;
      
     
    
            if(!empty( $_POST['etiltz'] && !empty($_POST['mtiltz']))){
                $ttilt = sprintf('%d',$_POST['mtiltz'] + $_POST['etiltz']);
            }
            else{ $ttilt ="-";}
        }


        elseif($selected == 'W'){

            $cellid2    = $_POST['cellidw'] ?? ''  ;
            $cellcode   = $_POST['cellcodew'] ?? '';
            $azimuth    = $_POST['azimuthw'] ?? '' ;
            $height     = $_POST['heightw'] ?? ''  ;
            $mtilt      = $_POST['mtiltw'] ?? ''   ;
            $etilt      = $_POST['etiltw'] ?? ''   ;
            $aarea      = $_POST['area1w'] ?? ''   ;
            $earea      = $_POST['area2w'] ?? ''   ;
            $cnote      = $_POST['cnotesw'] ?? ''  ;
            $cname      = $_POST['cellnamew'] ?? '';
            $BSIC       = $_POST['BSICw'] ?? ''     ;
            $bcch       = $_POST['BCCHw'] ?? ''     ;
            $celldate   = $_POST['celldatew'] ?? '' ;
      
     
    
            if(!empty( $_POST['etiltw'] && !empty($_POST['mtiltw']))){
                $ttilt = sprintf('%d',$_POST['mtiltw'] + $_POST['etiltw']);
            }
            else{ $ttilt ="-";}
        }

        elseif($selected == 'E'){

            $cellid2    = $_POST['cellide'] ?? ''  ;
            $cellcode   = $_POST['cellcodee'] ?? '';
            $azimuth    = $_POST['azimuthe'] ?? '' ;
            $height     = $_POST['heighte'] ?? ''  ;
            $mtilt      = $_POST['mtilte'] ?? ''   ;
            $etilt      = $_POST['etilte'] ?? ''   ;
            $aarea      = $_POST['area1e'] ?? ''   ;
            $earea      = $_POST['area2e'] ?? ''   ;
            $cnote      = $_POST['cnotese'] ?? ''  ;
            $cname      = $_POST['cellnamee'] ?? '';
            $BSIC       = $_POST['BSICe'] ?? ''     ;
            $bcch       = $_POST['BCCHe'] ?? ''     ;
            $celldate   = $_POST['celldatee'] ?? '' ;
      
     
    
            if(!empty( $_POST['etilte'] && !empty($_POST['mtilte']))){
                $ttilt = sprintf('%d',$_POST['mtilte'] + $_POST['etilte']);
            }
            else{ $ttilt ="-";}
        }


        elseif($selected == 'V'){

            $cellid2    = $_POST['cellidv'] ?? ''  ;
            $cellcode   = $_POST['cellcodev'] ?? '';
            $azimuth    = $_POST['azimuthv'] ?? '' ;
            $height     = $_POST['heightv'] ?? ''  ;
            $mtilt      = $_POST['mtiltv'] ?? ''   ;
            $etilt      = $_POST['etiltv'] ?? ''   ;
            $aarea      = $_POST['area1v'] ?? ''   ;
            $earea      = $_POST['area2v'] ?? ''   ;
            $cnote      = $_POST['cnotesv'] ?? ''  ;
            $cname      = $_POST['cellnamev'] ?? '';
            $BSIC       = $_POST['BSICv'] ?? ''     ;
            $bcch       = $_POST['BCCHv'] ?? ''     ;
            $celldate   = $_POST['celldatev'] ?? '' ;
      
     
    
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

if (oci_execute($result1)) {
 //echo "Data Updated Successfully";
 //header("Refresh:0");
 header("Location:Update_thankyou.html");
 //exit();
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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTN Syria | Update 2G Site Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap"
        rel="stylesheet">
    <style>
    :root {
        --primary: #1c355c;
        --secondary: #ff6600;
        --accent: #f0b52d;
        --light: #f8f9fa;
        --dark: #212529;
        --gray: #6c757d;
        --success: #28a745;
        --card-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        --transition: all 0.3s ease;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Roboto', sans-serif;
        background-color: goldenrod;
        color: var(--dark);
        line-height: 1.6;
        overflow-x: hidden;
    }

    .container {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Header Styles */
    header {
        position: sticky;
        top: 0;
        background: var(--primary);
        color: white;
        padding: 15px 0;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
    }

    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .logo-container {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .logo {
        width: 60px;
        height: 60px;
        background: #fff;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .logo-text {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.4rem;
    }

    .logo-text span {
        color: var(--accent);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        background: var(--accent);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: var(--primary);
    }

    #welcome {
        font-size: 0.95rem;
    }

    .logout-button {
        padding: 8px 15px;
        background-color: var(--secondary);
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        transition: var(--transition);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .logout-button:hover {
        background-color: #e55a00;
        transform: translateY(-2px);
    }

    /* Site Header */
    .site-header {
        background: linear-gradient(135deg, var(--primary) 0%, #0d1a30 100%);
        color: white;
        padding: 40px 0;
        text-align: center;
        margin-bottom: 30px;
        border-radius: 0 0 12px 12px;
        box-shadow: var(--card-shadow);
    }

    .site-code {
        font-family: 'Poppins', sans-serif;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .site-subtitle {
        font-size: 1.25rem;
        opacity: 0.9;
    }

    /* Form Cards */
    .info-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: var(--card-shadow);
        margin-bottom: 30px;
        transition: var(--transition);
    }

    .info-card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid rgba(28, 53, 92, 0.1);
    }

    .card-title {
        font-family: 'Poppins', sans-serif;
        font-size: 1.5rem;
        color: var(--primary);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-title i {
        color: var(--secondary);
    }

    .toggle-btn {
        background: rgba(28, 53, 92, 0.1);
        border: none;
        border-radius: 6px;
        padding: 8px 15px;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .toggle-btn:hover {
        background: rgba(28, 53, 92, 0.2);
    }

    /* Form Styles */
    .form-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--primary);
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e1e6ed;
        border-radius: 8px;
        background-color: #f8f9fa;
        transition: var(--transition);
        font-family: 'Roboto', sans-serif;
        font-size: 1rem;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(240, 181, 45, 0.2);
    }

    .radio-group {
        display: flex;
        gap: 15px;
        margin-top: 5px;
    }

    .radio-label {
        display: flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
    }

    .radio-label input[type="radio"] {
        accent-color: var(--secondary);
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%231c355c' viewBox='0 0 16 16'%3E%3Cpath d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 12px;
        padding-right: 40px;
    }

    /* Cells Table */
    .table-container {
        overflow-x: auto;
        margin-top: 20px;
        max-height: 60vh;
        position: relative;
        border: 1px solid #e1e6ed;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .table-header {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .info-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.95rem;
    }

    .info-table th {
        background-color: var(--primary);
        color: white;
        text-align: left;
        padding: 12px 15px;
        font-weight: 500;
        position: sticky;
        top: 0;
        z-index: 20;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .info-table th:first-child {
        position: sticky;
        left: 0;
        z-index: 30;
    }

    .info-table td {
        padding: 10px 12px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        background-color: white;
        vertical-align: middle;
    }

    .info-table tr:nth-child(even) td {
        background-color: rgba(28, 53, 92, 0.03);
    }

    .info-table tr:hover {
        background-color: rgba(28, 53, 92, 0.05);
    }

    .info-table input[type="text"] {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #e1e6ed;
        border-radius: 4px;
        background-color: white;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .info-table input[type="text"]:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 2px rgba(240, 181, 45, 0.2);
    }

    .cell-checkbox {
        text-align: center;
        position: sticky;
        left: 0;
        background-color: inherit;
        z-index: 5;
    }

    .cell-checkbox input {
        accent-color: var(--secondary);
        width: 18px;
        height: 18px;
    }

    .required-field::after {
        content: "*";
        color: #e74c3c;
        margin-left: 3px;
        font-size: 0.9em;
    }

    .table-actions {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .table-filter {
        padding: 8px 15px;
        border: 1px solid #e1e6ed;
        border-radius: 6px;
        width: 250px;
    }

    .table-info {
        font-size: 0.9rem;
        color: var(--gray);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-info i {
        color: var(--accent);
    }

    /* Notes Section */
    .notes-section {
        background: rgba(28, 53, 92, 0.05);
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }

    .notes-label {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 10px;
        display: block;
    }

    .notes-content {
        background: white;
        padding: 15px;
        border-radius: 6px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        min-height: 60px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 30px;
    }

    .btn {
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn-primary {
        background: var(--secondary);
        color: white;
    }

    .btn-primary:hover {
        background: #e55a00;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: var(--primary);
        color: white;
    }

    .btn-secondary:hover {
        background: #152645;
        transform: translateY(-2px);
    }

    .btn-outline {
        background: transparent;
        border: 2px solid var(--primary);
        color: var(--primary);
    }

    .btn-outline:hover {
        background: rgba(28, 53, 92, 0.1);
    }

    /* Footer */
    footer {
        background: var(--primary);
        color: white;
        padding: 30px 0 20px;
        margin-top: 40px;
        border-radius: 12px 12px 0 0;
    }

    .footer-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-bottom: 30px;
    }

    .footer-logo {
        font-family: 'Poppins', sans-serif;
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .footer-logo span {
        color: var(--accent);
    }

    .footer-about {
        max-width: 300px;
        opacity: 0.8;
        line-height: 1.7;
        font-size: 0.95rem;
    }

    .footer-heading {
        font-size: 1.1rem;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .footer-links {
        list-style: none;
    }

    .footer-links li {
        margin-bottom: 10px;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: var(--transition);
        font-size: 0.95rem;
    }

    .footer-links a:hover {
        color: white;
    }

    .contact-info {
        list-style: none;
    }

    .contact-info li {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.95rem;
    }

    .copyright {
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.85rem;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .site-code {
            font-size: 2rem;
        }

        .info-table th,
        .info-table td {
            padding: 12px 10px;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 768px) {
        .card-title {
            font-size: 1.3rem;
        }

        .info-card {
            padding: 20px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .site-code {
            font-size: 1.8rem;
        }

        .form-section {
            grid-template-columns: 1fr;
        }

        .radio-group {
            flex-direction: column;
            gap: 8px;
        }
    }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="logo-container">
                <div class="logo">
                    <i class="fas fa-tower-cell" style="font-size: 2rem; color: var(--primary);"></i>
                </div>
                <div class="logo-text">MTN <span>Syria</span></div>
            </div>

            <div class="user-info">
                <?php
                if (isset($_COOKIE['loggedInUser'])) {
                    $username = htmlspecialchars($_COOKIE['loggedInUser']);
                    $initial = strtoupper(substr($username, 0, 1));
                    echo "<div class='user-avatar'>$initial</div>";
                    echo "<span id='welcome'>Welcome, <strong>$username</strong></span>";
                }
                ?>
            </div>
        </div>
    </header>

    <!-- Site Header -->
    <div class="site-header">
        <div class="container">
            <div class="site-code"><?php echo $row['SITE_CODE']; ?></div>
            <div class="site-subtitle">Update 2G Site Details</div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo $siteid; ?>">
            <input type="hidden" name="cid" value="<?php echo $row['CID_KEY']; ?>">
            <input type="hidden" name="sitecode" value="<?php echo $row['SITE_CODE']; ?>">

            <!-- Site Information Card -->
            <div class="info-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Site Information</h3>
                    <button type="button" class="toggle-btn" aria-label="Toggle section">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>

                <div class="form-section">
                    <div class="form-group">
                        <label>Band Width</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="band" value="900"
                                    <?php echo (isset($row['BAND']) && $row['BAND'] == "900") ? 'checked' : ''; ?>> 900
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="band" value="1800"
                                    <?php echo (isset($row['BAND']) && $row['BAND'] == "1800") ? 'checked' : ''; ?>>
                                1800
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="band" value="900/1800"
                                    <?php echo (isset($row['BAND']) && $row['BAND'] == "900/1800") ? 'checked' : ''; ?>>
                                900/1800
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="onairdate">2G On Air Date</label>
                        <input type="text" class="form-control" name="onairdate" id="onairdate"
                            value="<?php echo $row['TWOG_ON_AIR_DATE']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="BTS">BTS Type</label>
                        <select class="form-control" name="BTS" id="BTS">
                            <option value="Empty">--</option>
                            <option value="Macro" <?php if($row['BTS_TYPE'] == "Macro") echo 'Selected' ;?>>Macro
                            </option>
                            <option value="Mbts" <?php if($row['BTS_TYPE'] == "Mbts") echo 'Selected' ;?>>MBTS</option>
                            <option value="Micro" <?php if($row['BTS_TYPE'] == "Micro") echo 'Selected' ;?>>Micro
                            </option>
                            <option value="Grd" <?php if($row['BTS_TYPE'] == "Grd") echo 'Selected' ;?>>GRD</option>
                            <option value="Rdu" <?php if($row['BTS_TYPE'] == "Rdu") echo 'Selected' ;?>>RDU</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sitestatus">Site Status</label>
                        <select class="form-control" name="sitestatus" id="sitestatus">
                            <option value="Empty">--</option>
                            <option value="On Air" <?php if($row['SITE_STATUS'] == "On Air") echo 'Selected' ;?>>On Air
                            </option>
                            <option value="On Air (Stopped)"
                                <?php if($row['SITE_STATUS'] == "On Air (Stopped)") echo 'Selected' ;?>>On Air (Stopped)
                            </option>
                            <option value="On Air (Stopped_2)"
                                <?php if($row['SITE_STATUS'] == "On Air (Stopped_2)") echo 'Selected' ;?>>On Air
                                (Stopped_2)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="900Rbs">900 GSM RBS Type</label>
                        <select class="form-control" name="900Rbs" id="900Rbs">
                            <option value="">--</option>
                            <option value="BTS5900"
                                <?php if($row['NINTY_GSM_RBS_TYPE'] == "BTS5900") echo 'Selected' ;?>>BTS5900</option>
                            <option value="BTS3900"
                                <?php if($row['NINTY_GSM_RBS_TYPE'] == "BTS3900") echo 'Selected' ;?>>BTS3900</option>
                            <!-- Other options remain the same -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="900onairdate">900 On Air Date</label>
                        <input type="text" class="form-control" name="900onairdate" id="900onairdate"
                            value="<?php echo $row['NINTY_ON_AIR_DATE']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="1800Rbs">1800 GSM RBS Type</label>
                        <select class="form-control" name="1800Rbs" id="1800Rbs">
                            <option value="">--</option>
                            <option value="BTS5900"
                                <?php if($row['EIGHTY_GSM_RBS_TYPE'] == "BTS5900") echo 'Selected' ;?>>BTS5900</option>
                            <option value="BTS3900"
                                <?php if($row['EIGHTY_GSM_RBS_TYPE'] == "BTS3900") echo 'Selected' ;?>>BTS3900</option>
                            <!-- Other options remain the same -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="1800onairdate">1800 On Air Date</label>
                        <input type="text" class="form-control" name="1800onairdate" id="1800onairdate"
                            value="<?php echo $row['EIGHTY_ON_AIR_DATE']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="BSC">BSC</label>
                        <select class="form-control" name="BSC" id="BSC">
                            <option value="Empty">--</option>
                            <option value="EVOBSC1" <?php if($row['BSC'] == "EVOBSC1") echo 'Selected' ;?>>EVOBSC1
                            </option>
                            <option value="EVOBSC2" <?php if($row['BSC'] == "EVOBSC2") echo 'Selected' ;?>>EVOBSC2
                            </option>
                            <!-- Other options remain the same -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="realBSC">Real BSC</label>
                        <input type="text" class="form-control" name="realBSC" id="realBSC"
                            value="<?php echo $row['REAL_BSC']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="lac">LAC</label>
                        <input type="text" class="form-control" name="lac" id="lac" value="<?php echo $row['LAC']; ?>">
                    </div>
                </div>

                <div class="notes-section">
                    <span class="notes-label">Site Notes:</span>
                    <input type="text" class="form-control" name="snotes" value="<?php echo $row['NOTES']; ?>">
                </div>
            </div>

            <!-- Cells Information Card -->
            <div class="info-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-broadcast-tower"></i> Cells Information</h3>
                    <div class="table-actions">
                        <input type="text" class="table-filter" placeholder="Filter cells...">
                        <div class="table-info">
                            <i class="fas fa-info-circle"></i>
                            <span>Select cells to update</span>
                        </div>
                    </div>
                </div>

                <div class="table-container">
                    <table class="info-table">
                        <thead class="table-header">
                            <tr>
                                <th class="cell-checkbox">Select</th>
                                <th><span class="required-field">Cell Code</span></th>
                                <th>Cell ID</th>
                                <th>Cell Name</th>
                                <th>Azimuth</th>
                                <th>On Air Date</th>
                                <th>Height</th>
                                <th>BSIC</th>
                                <th>BCCH</th>
                                <th>M_TILT</th>
                                <th>E_TILT</th>
                                <th>Arabic Area</th>
                                <th>English Area</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                    $cell_chars = ['A','B','C','D','X','Y','Z','W','V','E'];
                    foreach ($cell_chars as $char) {
                        $cell = isset($data[$char]) ? $data[$char] : null;
                    ?>
                            <tr>
                                <td class="cell-checkbox">
                                    <input type="checkbox" name="cell[]" value="<?= $char ?>"
                                        <?= $cell ? 'checked' : '' ?>>
                                </td>
                                <td>
                                    <input type="text" name="cellcode<?= strtolower($char) ?>"
                                        value="<?= $cell ? htmlspecialchars($cell['CELL_CODE']) : '' ?>" required>
                                </td>
                                <td>
                                    <input type="text" name="cellid<?= strtolower($char) ?>"
                                        value="<?= $cell ? htmlspecialchars($cell['CELL_ID']) : '' ?>">
                                </td>
                                <td>
                                    <input type="text" name="cellname<?= strtolower($char) ?>"
                                        value="<?= $cell ? htmlspecialchars($cell['CELL_NAME']) : '' ?>">
                                </td>
                                <td>
                                    <input type="text" name="azimuth<?= strtolower($char) ?>"
                                        value="<?= $cell ? htmlspecialchars($cell['AZIMUTH']) : '' ?>">
                                </td>
                                <td>
                                    <input type="text" name="celldate<?= strtolower($char) ?>"
                                        value="<?= $cell ? htmlspecialchars($cell['CELL_ON_AIR_DATE']) : '' ?>">
                                </td>
                                <td>
                                    <input type="text" name="height<?= strtolower($char) ?>"
                                        value="<?= $cell ? htmlspecialchars($cell['HIEGHT']) : '' ?>">
                                </td>
                                <td>
                                    <input type="text" name="BSIC<?= strtolower($char) ?>"
                                        value="<?= $cell ? htmlspecialchars($cell['BSIC']) : '' ?>">
                                </td>
                                <td>
                                    <input type="text" name="BCCH<?= strtolower($char) ?>"
                                        value="<?= $cell ? htmlspecialchars($cell['BCCH']) : '' ?>">
                                </td>
                                <td>
                                    <input type="text" name="mtilt<?= strtolower($char) ?>"
                                        value="<?= $cell ? htmlspecialchars($cell['M_TILT']) : '' ?>">
                                </td>
                                <td>
                                    <input type="text" name="etilt<?= strtolower($char) ?>"
                                        value="<?= $cell ? htmlspecialchars($cell['E_TILT']) : '' ?>">
                                </td>
                                <td>
                                    <input type="text" name="area1<?= strtolower($char) ?>"
                                        value="<?= $cell ? htmlspecialchars($cell['SERVING_AREA']) : '' ?>">
                                </td>
                                <td>
                                    <input type="text" name="area2<?= strtolower($char) ?>"
                                        value="<?= $cell ? htmlspecialchars($cell['SERVING_AREA_IN_ENGLISH']) : '' ?>">
                                </td>
                                <td>
                                    <input type="text" name="cnotes<?= strtolower($char) ?>"
                                        value="<?= $cell ? htmlspecialchars($cell['NOTE']) : '' ?>">
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="table-info" style="margin-top: 15px;">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Cell Code is a required field for all selected cells</span>
                </div>
            </div>
            <!-- Action Buttons -->
            <div class="action-buttons">
                <button type="button" class="btn btn-outline"
                    onclick="if(confirm('Are you sure you want to cancel?')) { window.close(); }">
                    <i class="fas fa-times-circle"></i> Cancel
                </button>
                <button type="submit" name="submit" class="btn btn-primary"
                    onclick="return confirm('Are you sure you want to update?');">
                    <i class="fas fa-save"></i> Update Site
                </button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-about">
                    <div class="footer-logo">MTN <span>Syria</span></div>
                    <p>Providing cutting-edge telecommunications services across Syria with a commitment to quality and
                        innovation.</p>
                </div>

                <div>
                    <h3 class="footer-heading">Contact Support</h3>
                    <ul class="contact-info">
                        <li><i class="fas fa-envelope"></i> support@mtn.com.sy</li>
                        <li><i class="fas fa-phone"></i> +963 11 222 3333</li>
                        <li><i class="fas fa-map-marker-alt"></i> Damascus, Syria</li>
                    </ul>
                </div>
            </div>

            <div class="copyright">
                <p>&copy; <?php echo date("Y"); ?> MTN Syria. All rights reserved. | Quality & Performance Team, Network
                    Division</p>
            </div>
        </div>
    </footer>

    <script>
        // Collapsible sections
        document.querySelectorAll('.toggle-btn').forEach(button => {
            button.addEventListener('click', () => {
                const card = button.closest('.info-card');
                const content = card.querySelector('.form-section, .table-container, .notes-section');
                const icon = button.querySelector('i');
                
                if (content.style.display === 'none') {
                    content.style.display = 'block';
                    icon.className = 'fas fa-chevron-down';
                } else {
                    content.style.display = 'none';
                    icon.className = 'fas fa-chevron-up';
                }
            });
        });
        
        // Table filtering
        const filterInput = document.querySelector('.table-filter');
        filterInput.addEventListener('input', function() {
            const filterValue = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.info-table tbody tr');
            
            tableRows.forEach(row => {
                const cellCode = row.querySelector('td:nth-child(2) input').value.toLowerCase();
                const cellName = row.querySelector('td:nth-child(4) input').value.toLowerCase();
                
                if (cellCode.includes(filterValue) || cellName.includes(filterValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>