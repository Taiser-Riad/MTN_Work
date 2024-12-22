<?php 
include "config.php";
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $scode= $_POST['sitecode'];
    $sname= $_POST['sitename'];
    $pbackup= $_POST['powerbackup'];
    $ondate= $_POST['onairdate'];
    $relocdate= "-";
    $coorE =$_POST['coordinatesE'];
    $coorN =$_POST['coordinatesN'];
    $alttuide =$_POST['alttitude'];
    $siteadd =$_POST['address'];
    $ara_name =$_POST['arabicname'];
    $admin_area =$_POST['adminarea'];
    $TX_node =$_POST['txnode'];
    $area_rank =$_POST['arearanking'];
    //$zone =$_POST['zone'];
    $supplier =$_POST['supplier'];
    $cityrural1 =$_POST['C/R'];
    //$province =$_POST['province'];
    //$BSC = $_POST['BSC'];
    $prio = $_POST['priority'];
    $cat = $_POST['category'];
    $subcontractor = $_POST['sub'];
    $invoice = $_POST['invoice'];
    $site_ranking = $_POST['sranking'];
    $site_type = $_POST['SiteType'];
    //$code2 = substr($scode,0,3)
    

        if (substr($scode,0,3) == "DAM"){ $province = "Damascus" ; $zone ="South";}
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
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: goldenrod;
        }

        .container {
            width: 60%;
            background: whitesmoke;
            padding: 20px;
            margin-top: 0;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
            border: 2px solid gray;
            border-radius: 5px;
            color: #1c355c;
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
            padding: 20px 0;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .form1 {
            width: 100%;
        }

        .form1 label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input {
            background-color: #e1e6ed;
            border: 1px solid #ddd;
            border-radius: 5px;

        }

        select {
            background-color: #e1e6ed;
            border: 0.5px solid #e1e6ed;
        }

        input[type=text]:focus,
        input[type=date]:focus {
            border-color: #1c355c;
            background-color: #fff;
        }

        input[type=select]:focus {
            border: 0.8px solid #ff9317;

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
        <form action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF"]); ?>" method="POST">
            <div class="form1">
                <div>
                    <label for="code">Site Code</label>
                    <input type="text" name="sitecode" size="7" id="code" required></br></br>

                </div>

                <div>
                    <label for="name">Site Name</label>
                    <input type="text" name="sitename" size="33" id="name" required></br></br>
                </div>


                <div>
                    <input type="radio" id="city" name="C/R" value="City">City
                    <input type="radio" id="rural" name="C/R" value="Rural">Rural</br></br>
                </div>
                <div>

                    <input type="radio" id="erc" name="supplier" value="Ericsson">Ericsson
                    <input type="radio" id="hu" name="supplier" value="Huawei">Huawei</br></br>
                </div>
                <div>
                    <label for="power">Power Backup:</label>
                    <input type="text" name="powerbackup" size="50" id="power"></br></br>
                </div>
                <div>
                    <label for="air date">On Air Date:</label>
                    <input type="date" name="onairdate" size="15" id="air date"></br></br>
                </div>
                <div>
                    <label for="coorE">Coordinates E:</label>
                    <input type="text" name="coordinatesE" size="10" id="coorE"></br></br>
                </div>
                <div>
                    <label for="coorN">Coordinates N:</label>
                    <input type="text" name="coordinatesN" size="10" id="coorN"></br></br>
                </div>
                <div>
                    <label for="Att">Alttitude:</label>
                    <input type="text" name="alttitude" size="4" id="Att"></br></br>
                </div>
                <div>
                    <label for="address">Site Address:</label>
                    <input type="text" name="address" size="60" id="address"></br></br>
                </div>
                <div>
                    <label for="arname">Arabic Name:</label>
                    <span lang="Ar"><input type="text" name="arabicname" size="60" id="arname"></span></br></br>
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
                        <option value="golden">Golden Brj</option>
                        <option value="others">Others</option>
                    </select>
                    </br></br>
                </div>
                <div>
                    Invoice Topology: <select name="invoice">
                        <option value="Empty">--</option>
                        <option value="Tower / Generator / Solar and or TX Repeater">Tower / Generator / Solar and or TX
                            Repeater</option>
                        <option value="PTS Shelter / Indoor shelter and or TX node">PTS Shelter / Indoor shelter and or
                            TX node</option>
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
                    <label>Select Next Page:</br></label></br>
                    <label for="2g"></label>
                    <input type="radio" id="2g" name="SiteType" value="2G">2G Site Page.
                    <label for="3g"></label>
                    <input type="radio" id="3g" name="SiteType" value="3G">3G Site Page.
                    <label for="4g"></label>
                    <input type="radio" id="4g" name="SiteType" value="4G">4G Site Page.

                </div>
                <div class="submit">
                    <input type="submit" name="submit" value="Next">
                </div>
                <div style="clear:both;"></div>
            </div>

        </form>
    </div>
</body>

</html>