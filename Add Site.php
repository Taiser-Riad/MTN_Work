<?php 
include "config.php";
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $scode= $_POST['sitecode'] ?? '';
    $sname= $_POST['sitename'] ?? '';
    $pbackup= $_POST['powerbackup'] ?? '';
    $ondate= $_POST['onairdate'] ?? '';
    $relocdate= "-";
    $coorE =$_POST['coordinatesE'] ?? '';
    $coorN =$_POST['coordinatesN'] ?? '';
    $alttuide =$_POST['alttitude'] ?? '';
    $siteadd =$_POST['address'] ?? '';
    $ara_name =$_POST['arabicname'] ?? '';
    $admin_area =$_POST['adminarea'] ?? '';
    $TX_node =$_POST['txnode'] ?? '';
    //$area_rank =$_POST['arearanking'];
    //$zone =$_POST['zone'];
    $supplier =$_POST['supplier'] ?? '';
    $cityrural1 =$_POST['C/R'] ?? '';
    //$province =$_POST['province'];
    //$BSC = $_POST['BSC'];
    $prio = $_POST['priority'] ?? '';
    $cat = $_POST['category'] ?? '';
    $subcontractor = $_POST['sub'] ?? '';
    $invoice = $_POST['invoice'] ?? '';
    $site_ranking = $_POST['sranking'] ?? '';
    $site_type = $_POST['SiteType'];
    
    
   

        if (substr($scode,0,3) == "DAM"){ $province = "Damascus" ; $zone ="South"; }
    elseif (substr($scode,0,3) == "ALP"){$province = "Aleppo" ; $zone ="North"; }
    elseif (substr($scode,0,3) == "DMR"){$province = "Damascus Rural" ; $zone ="South"; }
    elseif (substr($scode,0,3) == "DRA"){$province = "Daraa" ; $zone ="South"; }
    elseif (substr($scode,0,3) == "DRZ"){$province = "Deir Elzor" ; $zone ="North"; }
    elseif (substr($scode,0,3) == "HMA"){$province = "Hama" ; $zone ="North"; }
    elseif (substr($scode,0,3) == "HMS"){$province = "Homs" ; $zone ="North"; }
    elseif (substr($scode,0,3) == "HSK"){$province = "Hassakeh" ; $zone ="North"; }
    elseif (substr($scode,0,3) == "IDB"){$province = "Idleb" ; $zone ="North"; }
    elseif (substr($scode,0,3) == "LTK"){$province = "Lattakia" ; $zone ="North"; }
    elseif (substr($scode,0,3) == "RKA"){$province = "Rakka" ; $zone ="North"; }
    elseif (substr($scode,0,3) == "SWD"){$province = "Sweida" ; $zone ="South"; }
    elseif (substr($scode,0,3) == "TRS"){$province = "Tartous" ; $zone ="North"; }
    elseif (substr($scode,0,3) == "QRA"){$province = "Qounaitera" ; $zone ="South"; }

if($cityrural1 == "City"){
    $cityrural = substr($scode,0,3);
}
else{
    $cityrural = substr($scode,0,3) ."-R";
}

if (empty($site_type)) {
    echo "<script>alert('You should select a site type');</script>";
} else {
    // Process the form submission
    echo "<p>Form submitted successfully with site type: $site_type</p>";
    // Add your database logic here
}

    if($site_type == '2G')
    {
      
    $sqll = 'SELECT * FROM NEW_SITES WHERE SITE_CODE = :site_code'; 
    $stid = oci_parse($conn, $sqll);
    oci_bind_by_name($stid, ':site_code', $scode); 
    oci_execute($stid);

    //$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)
    if($num_rows = oci_num_rows($stid)==0)
    {

     
        $sql = "INSERT INTO NEW_SITES (ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, BSC, POWER_BACKUP, SITE_ON_AIR_DATE, RELOCATION_DATE, COORDINATES_E, COORDINATES_N, ALTTITUDE, SITE_ADDRESS, ARABIC_NAME, TX_NODE, TECHNICAL_PRIORITY, ADMINSTRITAVE_AREA, NODE_CATEGORY, SITE_RANKING, SUBCONTRACTOR, INVOICE_TOYOLOGY) 
        VALUES (NEW_SITES_SEQ.NEXTVAL, :scode, :sname, :zone, :province, :cityrural, :supplier, :BSC, :pbackup, :ondate, :relocdate, :coorE, :coorN, :altitude, :siteadd, :ara_name, :TX_node, :prio, :admin_area, :cat, :site_ranking, :subcontractor, :invoice) 
        RETURNING ID INTO :last_id";

$insert_stmt = oci_parse($conn, $sql);

oci_bind_by_name($insert_stmt, ':scode', $scode);
oci_bind_by_name($insert_stmt, ':sname', $sname);
oci_bind_by_name($insert_stmt, ':zone', $zone);
oci_bind_by_name($insert_stmt, ':province', $province);
oci_bind_by_name($insert_stmt, ':cityrural', $cityrural);
oci_bind_by_name($insert_stmt, ':supplier', $supplier);
oci_bind_by_name($insert_stmt, ':BSC', $BSC);
oci_bind_by_name($insert_stmt, ':pbackup', $pbackup);
oci_bind_by_name($insert_stmt, ':ondate', $ondate);
oci_bind_by_name($insert_stmt, ':relocdate', $relocdate);
oci_bind_by_name($insert_stmt, ':coorE', $coorE);
oci_bind_by_name($insert_stmt, ':coorN', $coorN);
oci_bind_by_name($insert_stmt, ':altitude', $altitude);
oci_bind_by_name($insert_stmt, ':siteadd', $siteadd);
oci_bind_by_name($insert_stmt, ':ara_name', $ara_name);
oci_bind_by_name($insert_stmt, ':TX_node', $TX_node);
oci_bind_by_name($insert_stmt, ':prio', $prio);
oci_bind_by_name($insert_stmt, ':admin_area', $admin_area);
oci_bind_by_name($insert_stmt, ':cat', $cat);
oci_bind_by_name($insert_stmt, ':site_ranking', $site_ranking);
oci_bind_by_name($insert_stmt, ':subcontractor', $subcontractor);
oci_bind_by_name($insert_stmt, ':invoice', $invoice);
//oci_bind_by_name($insert_stmt, ':area_rank', $area_rank);
oci_bind_by_name($insert_stmt, ':last_id', $ID, -1, SQLT_INT);

if (!oci_execute($insert_stmt)) { 
    $err = oci_error($insert_stmt); 
    die("Error executing: " . $err['message']);
}

oci_free_statement($insert_stmt); 
oci_close($conn);

// Redirect after closing the connection
header("Location: 2G.php?id=$ID");
exit;


    }
    else 
    {
        while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS))
        {
            echo "Site Already Exist";
            $ID= $row[0];
            header("location:2G.php?id=$ID");
        }
    }
    }
    elseif($site_type == '3G')
    {
     
    $sqll = 'SELECT * FROM NEW_SITES WHERE SITE_CODE = :site_code'; 
    $stid = oci_parse($conn, $sqll);
    oci_bind_by_name($stid, ':site_code', $scode); 
    oci_execute($stid);

    //$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)
    if($num_rows = oci_num_rows($stid)==0)
    {

     
        $sql = "INSERT INTO NEW_SITES (ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, BSC, POWER_BACKUP, SITE_ON_AIR_DATE, RELOCATION_DATE, COORDINATES_E, COORDINATES_N, ALTTITUDE, SITE_ADDRESS, ARABIC_NAME, TX_NODE, TECHNICAL_PRIORITY, ADMINSTRITAVE_AREA, NODE_CATEGORY, SITE_RANKING, SUBCONTRACTOR, INVOICE_TOYOLOGY) 
        VALUES (NEW_SITES_SEQ.NEXTVAL, :scode, :sname, :zone, :province, :cityrural, :supplier, :BSC, :pbackup, :ondate, :relocdate, :coorE, :coorN, :altitude, :siteadd, :ara_name, :TX_node, :prio, :admin_area, :cat, :site_ranking, :subcontractor, :invoice) 
        RETURNING ID INTO :last_id";

$insert_stmt = oci_parse($conn, $sql);

oci_bind_by_name($insert_stmt, ':scode', $scode);
oci_bind_by_name($insert_stmt, ':sname', $sname);
oci_bind_by_name($insert_stmt, ':zone', $zone);
oci_bind_by_name($insert_stmt, ':province', $province);
oci_bind_by_name($insert_stmt, ':cityrural', $cityrural);
oci_bind_by_name($insert_stmt, ':supplier', $supplier);
oci_bind_by_name($insert_stmt, ':BSC', $BSC);
oci_bind_by_name($insert_stmt, ':pbackup', $pbackup);
oci_bind_by_name($insert_stmt, ':ondate', $ondate);
oci_bind_by_name($insert_stmt, ':relocdate', $relocdate);
oci_bind_by_name($insert_stmt, ':coorE', $coorE);
oci_bind_by_name($insert_stmt, ':coorN', $coorN);
oci_bind_by_name($insert_stmt, ':altitude', $altitude);
oci_bind_by_name($insert_stmt, ':siteadd', $siteadd);
oci_bind_by_name($insert_stmt, ':ara_name', $ara_name);
oci_bind_by_name($insert_stmt, ':TX_node', $TX_node);
oci_bind_by_name($insert_stmt, ':prio', $prio);
oci_bind_by_name($insert_stmt, ':admin_area', $admin_area);
oci_bind_by_name($insert_stmt, ':cat', $cat);
oci_bind_by_name($insert_stmt, ':site_ranking', $site_ranking);
oci_bind_by_name($insert_stmt, ':subcontractor', $subcontractor);
oci_bind_by_name($insert_stmt, ':invoice', $invoice);
//oci_bind_by_name($insert_stmt, ':area_rank', $area_rank);
oci_bind_by_name($insert_stmt, ':last_id', $ID, -1, SQLT_INT);

if (!oci_execute($insert_stmt)) { 
    $err = oci_error($insert_stmt); 
    die("Error executing: " . $err['message']);
}

oci_free_statement($insert_stmt); 
oci_close($conn);

            header("location:3G.php?id2=$ID");
            exit;
       
     
        }
        else 
        {
            while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS))
            {
                echo "Site Already Exist";
                $ID= $row[0];
                header("location:3G.php?id2=$ID");
            }
        }
        }

    elseif($site_type == '4G')
    {
        
        $sqll = 'SELECT * FROM NEW_SITES WHERE SITE_CODE = :site_code'; 
    $stid = oci_parse($conn, $sqll);
    oci_bind_by_name($stid, ':site_code', $scode); 
    oci_execute($stid);

    //$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)
    if($num_rows = oci_num_rows($stid)==0)
    {

     
        $sql = "INSERT INTO NEW_SITES (ID, SITE_CODE, SITE_NAME, ZONE, PROVINCE, CR, SUPPLIER, BSC, POWER_BACKUP, SITE_ON_AIR_DATE, RELOCATION_DATE, COORDINATES_E, COORDINATES_N, ALTTITUDE, SITE_ADDRESS, ARABIC_NAME, TX_NODE, TECHNICAL_PRIORITY, ADMINSTRITAVE_AREA, NODE_CATEGORY, SITE_RANKING, SUBCONTRACTOR, INVOICE_TOYOLOGY) 
        VALUES (NEW_SITES_SEQ.NEXTVAL, :scode, :sname, :zone, :province, :cityrural, :supplier, :BSC, :pbackup, :ondate, :relocdate, :coorE, :coorN, :altitude, :siteadd, :ara_name, :TX_node, :prio, :admin_area, :cat, :site_ranking, :subcontractor, :invoice) 
        RETURNING ID INTO :last_id";

$insert_stmt = oci_parse($conn, $sql);

oci_bind_by_name($insert_stmt, ':scode', $scode);
oci_bind_by_name($insert_stmt, ':sname', $sname);
oci_bind_by_name($insert_stmt, ':zone', $zone);
oci_bind_by_name($insert_stmt, ':province', $province);
oci_bind_by_name($insert_stmt, ':cityrural', $cityrural);
oci_bind_by_name($insert_stmt, ':supplier', $supplier);
oci_bind_by_name($insert_stmt, ':BSC', $BSC);
oci_bind_by_name($insert_stmt, ':pbackup', $pbackup);
oci_bind_by_name($insert_stmt, ':ondate', $ondate);
oci_bind_by_name($insert_stmt, ':relocdate', $relocdate);
oci_bind_by_name($insert_stmt, ':coorE', $coorE);
oci_bind_by_name($insert_stmt, ':coorN', $coorN);
oci_bind_by_name($insert_stmt, ':altitude', $altitude);
oci_bind_by_name($insert_stmt, ':siteadd', $siteadd);
oci_bind_by_name($insert_stmt, ':ara_name', $ara_name);
oci_bind_by_name($insert_stmt, ':TX_node', $TX_node);
oci_bind_by_name($insert_stmt, ':prio', $prio);
oci_bind_by_name($insert_stmt, ':admin_area', $admin_area);
oci_bind_by_name($insert_stmt, ':cat', $cat);
oci_bind_by_name($insert_stmt, ':site_ranking', $site_ranking);
oci_bind_by_name($insert_stmt, ':subcontractor', $subcontractor);
oci_bind_by_name($insert_stmt, ':invoice', $invoice);
//oci_bind_by_name($insert_stmt, ':area_rank', $area_rank);
oci_bind_by_name($insert_stmt, ':last_id', $ID, -1, SQLT_INT);

if (!oci_execute($insert_stmt)) { 
    $err = oci_error($insert_stmt); 
    die("Error executing: " . $err['message']);
}

oci_free_statement($insert_stmt); 
oci_close($conn);

            header("location:4G.php?id3=$ID");
            exit;

        }
        else 
        {
            while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS))
            {
                echo "Site Already Exist";
                $ID= $row[0];
                header("location:4G.php?id3=$ID");

            }
        }
        }
      

}

?>
<!DOCTYPE html>
<html lang="en">
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web\css\all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Add Site page </title>
    <script>
    function confirmcancel() {
        return confirm("Are you sure you want to cancel without adding site?");

    }


    function confirmSubmission() {
        // Check if any radio button is selected
        const radios = document.querySelectorAll('input[name="SiteType"]');
        let isChecked = false;
        radios.forEach(radio => {
            if (radio.checked) {
                isChecked = true;
            }
        });

        if (!isChecked) {
            alert('You should select a site type');
            return false; // Prevent form submission
        }

        return true; // Allow form submission
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


    .submit1 {
        width: 20%;

        float: left;
        display: flex;


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

        width: 60%;
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
        width: 80%;
        padding: 40px;

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

    input[type="radio"].custom {
        display: none;
    }

    /* Create a custom radio button for elements with the custom class */
    input[type="radio"].custom+label.custom-label {
        display: inline-block;
        padding: 7px 18px;
        margin: 5px;
        cursor: pointer;

        border-radius: 8px;
        background-color: #ffffff;
        color: #1c355c;
        transition: background-color 0.3s, color 0.3s;
        font-size: bold;
    }

    /* Style the selected state for elements with the custom class */
    input[type="radio"].custom:checked+label.custom-label {
        background-color: #3299a8;
        color: #ffffff;
        border-color: #007BFF;
        border: 2px solid white;
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




</head>

<body>
    <div class="container">
        <div class="header">
            <h1></br> Basic Site Informations </h1>
            Please fill basic site informations before moving to add technologies.</br>
            </br>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
            onsubmit="return confirmSubmission();">
            <div class="form1">
                <div>
                    <label class="required-field" for="code">Site Code</label>
                    <input type="text" name="sitecode" size="7" id="code" required></br></br>

                </div>

                <div>
                    <label class="required-field" for="name">Site Name</label>
                    <input type="text" name="sitename" size="33" id="name" required></br></br>
                </div>


                <div>
                    <label class="required-field" >City/Rural</label>
                    <input  type="radio" id="city" name="C/R" value="City" > City
                    <input type="radio" id="rural" name="C/R" value="Rural">Rural</br></br>
                </div>
                <div>
                    <label class="required-field">Supplier</label>
                    <input type="radio" id="erc" name="supplier" value="Ericsson" >Ericsson
                    <input type="radio" id="hu" name="supplier" value="Huawei">Huawei</br></br>
                </div>

                    <div>
                    Power Backup:
                    <select name="power">
                        <option value="">--</option>
                        <option value="2 MTN Generator">2 MTN Generator</option>
                        <option value="2 MTN Generator + Ampere">2 MTN Generator + Ampere</option>
                        <option value="2 MTN Generator + Hybrid">2 MTN Generator + Hybrid</option>
                        <option value="2 MTN Generator + Hybrid (OOS)">2 MTN Generator + Hybrid (OOS)</option>
                        <option value="2 MTN Generator + Hybrid + Ampere">2 MTN Generator + Hybrid + Ampere</option>
                        <option value="2 MTN Generator + Hybrid + Non Rationing line">2 MTN Generator + Hybrid + Non Rationing line</option>
                        <option value="2 MTN Generator + Hybrid + Wind">2 MTN Generator + Hybrid + Wind</option>
                        <option value="2 MTN Generator + Non Rationing line">2 MTN Generator + Non Rationing line</option>
                        <option value="Ampere">Ampere</option>
                        <option value="Ampere + Industrial line">Ampere + Industrial line</option>
                        <option value="Ampere + Other MTN Gen">Ampere + Other MTN Gen</option>
                        <option value="Ampere + Hybrid">Ampere + Hybrid</option>
                        <option value="Batteries">Batteries</option>
                        <option value="Hybrid">Hybrid</option>
                        <option value="Hybrid (Installed) + MTN Generator">Hybrid (Installed) + MTN Generator</option>
                        <option value="Hybrid + Ampere + Non Rationing line">Hybrid + Ampere + Non Rationing line</option>
                        <option value="Hybrid + Ampere + Other MTN Gen">Hybrid + Ampere + Other MTN Gen</option>
                        <option value="Hybrid + Industrial line">Hybrid + Industrial line</option>
                        <option value="Hybrid + Lithium batteries">Hybrid + Lithium batteries</option>
                        <option value="Hybrid + MTN rented Generator + Ampere">Hybrid + MTN rented Generator + Ampere</option>
                        <option value="Hybrid + Non Rationing line">Hybrid + Non Rationing line</option>
                        <option value="Hybrid + Other MTN Gen">Hybrid + Other MTN Gen</option>
                        <option value="Hybrid + Syriatel Generator">Hybrid + Syriatel Generator</option>
                        <option value="Industrial line">Industrial line</option>
                        <option value="Lithium Batteries">Lithium Batteries</option>
                        <option value="MTN Generator">MTN Generator</option>
                        <option value="MTN Generator (OOS) + Ampere">MTN Generator (OOS) + Ampere</option>
                        <option value="MTN Generator (OOS) + Hybrid + Ampere">MTN Generator (OOS) + Hybrid + Ampere</option>
                        <option value="MTN Generator (OOS) + MTN Rented Generator">MTN Generator (OOS) + MTN Rented Generator</option>
                        <option value="MTN Generator (OOS)+ Hybrid + Ampere">MTN Generator (OOS)+ Hybrid + Ampere</option>
                        <option value="MTN Generator + Ampere">MTN Generator + Ampere</option>
                        <option value="MTN Generator + Ampere + Other MTN Gen">MTN Generator + Ampere + Other MTN Gen</option>
                        <option value="MTN Generator + Ampere + Syriatel Generator">MTN Generator + Ampere + Syriatel Generator</option>
                        <option value="MTN Generator + Hybrid">MTN Generator + Hybrid</option>
                        <option value="MTN Generator + Hybrid (inactive) + Ampere">MTN Generator + Hybrid (inactive) + Ampere</option>
                        <option value="MTN Generator + Hybrid (OOS) + Ampere">MTN Generator + Hybrid (OOS) + Ampere</option>
                        <option value="MTN Generator + Hybrid (OOS) +industrial line">MTN Generator + Hybrid (OOS) +industrial line</option>
                        <option value="MTN Generator + Hybrid + Ampere">MTN Generator + Hybrid + Ampere</option>
                        <option value="MTN Generator + Hybrid + Golden line">MTN Generator + Hybrid + Golden line</option>
                        <option value="MTN Generator + Hybrid + Industrial line">MTN Generator + Hybrid + Industrial line</option>
                        <option value="MTN Generator + Hybrid + Non Rationing line">MTN Generator + Hybrid + Non Rationing line</option>
                        <option value="MTN Generator + Hybrid + Other Generator">MTN Generator + Hybrid + Other Generator</option>
                        <option value="MTN Generator + Hybrid + STE generator">MTN Generator + Hybrid + STE generator</option>
                        <option value="MTN Generator + Hybrid + Syriatel Generator">MTN Generator + Hybrid + Syriatel Generator</option>
                        <option value="MTN Generator + Hybrid(OOS)">MTN Generator + Hybrid(OOS)</option>
                        <option value="MTN Generator + Hybrid+ industrial line">MTN Generator + Hybrid+ industrial line</option>
                        <option value="MTN Generator + Hybrid+ Lithium batteries">MTN Generator + Hybrid+ Lithium batteries</option>
                        <option value="MTN Generator + Industrial line">MTN Generator + Industrial line</option>
                        <option value="MTN Generator + Lithium batteries">MTN Generator + Lithium batteries</option>
                        <option value="MTN Generator + MTN Generator (OOS) + MTN Rented Generator">MTN Generator + MTN Generator (OOS) + MTN Rented Generator</option>
                        <option value="MTN Generator + Non Rationing line">MTN Generator + Non Rationing line</option>
                        <option value="MTN Generator + STE Generator">MTN Generator + STE Generator</option>
                        <option value="MTN Generator + STE Generator + Non Rationing line">MTN Generator + STE Generator + Non Rationing line</option>
                        <option value="MTN Generator + Syriatel Generator">MTN Generator + Syriatel Generator</option>
                        <option value="MTN Generator(OOS)+MTN rented Generaor">MTN Generator(OOS)+MTN rented Generaor</option>
                        <option value="MTN Rented Generator">MTN Rented Generator</option>
                        <option value="MTN Rented Generator + Ampere">MTN Rented Generator + Ampere</option>
                        <option value="Non Rationing line">Non Rationing line</option>
                        <option value="Other Generator">Other Generator</option>
                        <option value="Other MTN Gen + Ampere">Other MTN Gen + Ampere</option>
                        <option value="Other MTN Gen + Industrial line">Other MTN Gen + Industrial line</option>
                        <option value="Other MTN Gen + Non Rationing line">Other MTN Gen + Non Rationing line</option>
                        <option value="Other MTN Generator">Other MTN Generator</option>
                        <option value="STE Generator">STE Generator</option>
                        <option value="Switch Generator">Switch Generator</option>
                        <option value="Syriatel Generator">Syriatel Generator</option>
                    </select>
                </div>
</br>
</br>

                <label class="required-field" for="air date">On Air Date:</label>
                <input type="date" name="onairdate" size="15" id="air date" required></br></br>
            </div>
            <div>
                <label class="required-field" for="coorE">Coordinates E:</label>
                <input type="text" name="coordinatesE" size="10" id="coorE" required></br></br>
            </div>
            <div>
                <label class="required-field" for="coorN">Coordinates N:</label>
                <input type="text" name="coordinatesN" size="10" id="coorN" required></br></br>
            </div>
            <div>
                <label  for="Att">Alttitude:</label>
                <input type="text" name="alttitude" size="4" id="Att"></br></br>
            </div>
            <div>
                <label class="required-field" for="address">Site Address:</label>
                <input type="text" name="address" size="60" id="address" required></br></br>
            </div>
            <div>
                <label class="required-field" for="arname">Arabic Name:</label>
                <span lang="Ar"><input type="text" name="arabicname" size="60" id="arname" required></span></br></br>
            </div>
            <div>
                <label for="admin">Adminstrative Area:</label>
                <input type="text" name="adminarea" size="60" id="admin"></br></br>
            </div>
            <div>
                <label for="node">TX Node:</label>
                <input type="text" name="txnode" size="3" id="node"></br></br>
            </div>

            <div>
                Node Category: <select name="category">
                    <option value="Empty">--</option>
                    <option value="Normal">Normal</option>
                    <option value="Golden">Golden</option>
                    <option value="Silver">Silver</option>
                    <option value="Tail">Tail</option>
                </select>
                </br></br>
            </div>

            <div>
                Technical Priority: <select name="priority">
                    <option value="Empty">--</option>
                    <option value="Priority1">Priority1</option>
                    <option value="Priority2">Priority2</option>
                    <option value="Priority3">Priority3</option>
                    <option value="Priority4">Priority4</option>
                </select>
                </br></br>
            </div>

            <div>
                Subcontractor: <select name="sub">
                    <option value="Empty">--</option>
                    <option value="Brj">Brj</option>
                    <option value="others">Others</option>
                </select>
                </br></br>
            </div>
            <div class="required-field">
                Invoice Topology: <select name="invoice" required>
                    <option value="Empty">--</option>
                    <option value="Tower / Generator / Solar and or TX Repeater">Tower / Generator / Solar and
                        or TX Repeater</option>
                    <option value="PTS Shelter / Indoor shelter and or TX node">PTS Shelter / Indoor shelter and
                        or TX node</option>
                    <option value="Others">Others</option>
                </select>
                </br></br>
            </div>
            <div>
                Site Ranking: <select name="sranking">
                    <option value="Empty">--</option>
                    <option value="Priority1">Priority1</option>
                    <option value="Priority1-Tourism">Priority1-Tourism</option>
                    <option value="Priority2">Priority2</option>
                    <option value="Priority2-Tourism">Priority2-Tourism</option>
                    <option value="Priority3">Priority3</option>
                    <option value="Priority3-Tourism">Priority3-Tourism</option>
                    <option value="Priority4">Priority4</option>
                    <option value="Priority4-Tourism">Priority4-Tourism</option>
                    <option value="VIP">VIP</option>
                    <option value="VIP-Tourism">VIP-Tourism</option>
                </select>
                </br></br>
            </div>

    </div>
    <div class="footer">
        <div>
            <label>
                <h3>Select Next Page:</h3>
            </label>

            <input type="radio" id="custom-option1" name="SiteType" value="2G" class="custom" required>
            <label for="custom-option1" class="custom-label">2G Site Page.</label>

            <input type="radio" id="custom-option2" name="SiteType" value="3G" class="custom">
            <label for="custom-option2" class="custom-label">3G Site Page.</label>

            <input type="radio" id="custom-option3" name="SiteType" value="4G" class="custom">
            <label for="custom-option3" class="custom-label">4G Site Page.</label>
        </div>
        <div class="submit">
            <input type="submit" name="submit" value="Next">
        </div>
        <div class="submit1">
            <button type="button" class="submit2" onclick="if(confirmcancel()) { window.close(); }"> Cancel
            </button>
        </div>
        <div style="clear:both;"></div>
    </div>

    </form>
    </div>
</body>

</html>