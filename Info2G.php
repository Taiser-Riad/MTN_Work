<?php 
include "config.php";
?>
<?php
if(isset($_GET['id2']))
{
$siteid =$_GET['id2'];
$sql= "SELECT s.*,  t.* , c.* FROM NEW_SITES s JOIN TWO_G_SITES t ON(s.ID = t.SITE_ID) JOIN TWO_G_CELLS c ON (t.CELL_ID = c.CID_KEY)     WHERE  t.SITE_ID = :siteid";
//$sql= "SELECT s.Site_code,  t.* FROM new_sites s JOIN TWO_G_SITES t ON(s.ID = t.Site_ID) WHERE t.Site_ID = '$siteid'";
//$sql=  "SELECT * FROM TWO_G_SITES WHERE Site_ID = '$siteid'";
$sqll= "SELECT t.* , c.* FROM  TWO_G_SITES t JOIN TWO_G_CELLS c ON (t.CELL_ID = c.CID_KEY) WHERE t.Site_ID = :siteid";

$result = oci_parse($conn,$sql);
oci_bind_by_name($result ,':siteid' ,$siteid);
oci_execute($result);
$row = oci_fetch_array($result , OCI_ASSOC + OCI_RETURN_NULLS);


$resultt = oci_parse($conn,$sqll);
oci_bind_by_name($resultt ,':siteid' ,$siteid);

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
    
   
    while ($row1 = oci_fetch_array($resultt , OCI_ASSOC + OCI_RETURN_NULLS)){
      
        //Get The Letter of Cell Code
        $cellcode_char  =substr($row1['CELL_CODE'],-1);
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

exit();
 
    }
  
   
    
?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href= "fontawesome-free-6.5.2-web\css\all.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title> 2G Site Info page </title>
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

width: 70%;
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
    width: 95%;
    padding-left: 40px;
   
}
input {
    background-color:#e1e6ed;
    border:0.5px solid #e1e6ed;
    color:#1c355c;
}
select {
    background-color:#e1e6ed;
    border:0.5px solid #e1e6ed;
    color:#1c355c;
    opacity:1;
}
input[type=text]:focus{
    border:0.8px solid #e1e6ed;
}
input[type=select]:focus{
    border:0.8px solid #e1e6ed;

}
input[type="checkbox"][disabled][checked] {
 
    border:0.5px solid #e1e6ed;
    opacity:1;

}

input[type="radio"]:disabled:checked{
    background-color:#e1e6ed;
    border:0.5px solid #e1e6ed;
    opacity:1;

}
.field{
    background-color:#e1e6ed;
    
}
table, th, td {
    border:2px solid #b4c5e0;
    border-collapse: collapse;
    text-align:center;
    
    
}
table, tr, td {
  
    font-size: 14px;
    height: 30px;
    white-space: nowrap;
    
    
}
.table-wrapper{
    display:flex;
flex-direction:column;
align-items: stretch;
width:100%;
overflow-x: auto; 
}


 .table-wrapper table{
width:100%;
border-collapse:collapse;
margin-bottom:20px;
 }

 thead {
    display: table-header-group; /* Keep the header fixed */
}

tbody {
    display: table-row-group; /* Group rows together */
}
hr{
    color:#1c355c;
}
</style>


</head>
<body >
    <div class="container">
    
        <div class="header">
            <h1></br> <?php echo $row['SITE_CODE']; ?>  </h1>
            2G details Info.</br>
</br>
        </div>
     
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit="window.close();">
        <div class="form1">
        <div>
            <input type ="hidden" name ="id"       value="<?php echo $siteid; ?>">
            <input type ="hidden" name ="cid"      value="<?php echo $row['CID_KEY']; ?>">
            
        </div>

<h2>Site Information: </h2>
        <div class="table-wrapper">
    <table border="1">
        <thead>
            <tr>
                <th>Site Code</th>
                <th>Band Width</th>
                <th>BTS Type</th>
                <th>Site Status</th>
                <th>2G On Air Date</th>
                <th>900 GSM RBS Type</th>
                <th>900 On Air Date</th>
                <th>1800 GSM RBS Type</th>
                <th>1800 On Air Date</th>
                <th> BSC</th>
                <th>Real BSC</th>
                <th>LAC</th>
                
            </tr>
        </thead>
<tbody>
<tr>
   <td><?php echo $row['SITE_CODE'];  ?></td>
   <td><?php echo $row['BAND'];  ?></td>
   <td><?php echo $row['BTS_TYPE'];  ?></td>
   <td><?php echo $row['TWOG_ON_AIR_DATE'];  ?></td>
   <td><?php echo $row['SITE_STATUS'];  ?></td>
   <td><?php echo $row['NINTY_GSM_RBS_TYPE'];  ?></td>
   <td><?php echo $row['NINTY_ON_AIR_DATE'];  ?></td>
   <td><?php echo $row['EIGHTY_GSM_RBS_TYPE'];  ?></td>
   <td><?php echo $row['EIGHTY_ON_AIR_DATE'];  ?></td>
   <td><?php echo $row['BSC'];  ?></td>
   <td><?php echo $row['REAL_BSC'];  ?></td>
   <td><?php echo $row['LAC'];  ?></td>

   
</tbody>
</table>
</div>

        

<div>
    <label for="note1">Site Notes:</label>
    <input type ="text" name="snotes" size="100"  id="note1" disabled value="<?php echo $row['NOTES']; ?>"></br></br>
</div>
</br> </br>

<h2>Cells Informations:</h2>

<?php 



while ($row1 = oci_fetch_array($resultt, OCI_ASSOC + OCI_RETURN_NULLS)) {
    // Get The Letter of Cell Code
    $cellcode_char = substr($row1['CELL_CODE'], -1);
    
    // Search in $data array to find one of these letters
    if (in_array($cellcode_char, ['A', 'B', 'C', 'D', 'X', 'Y', 'Z', 'W', 'V', 'E'])) {
        // Store the row from fetching result in array due to letter  
        $data[$cellcode_char] = $row1;
    }
}

// Display the table only once
if (!empty($data)): ?>
<div class="table-wrapper">
    <table border="1">
        <thead>
            <tr>
                <th>Cell Code</th>
                <th>Cell ID</th>
                <th>Cell Name</th>
                <th>Azimuth</th>
                <th>On Air Date</th>
                <th>Height</th>
                <th>BSIC</th>
                <th>BCCH</th>
                <th>M_TILT</th>
                <th>E_TILT</th>
                <th>CGI</th>
                
                <th>Arabic Serving Area</th>
                <th>English Serving Area</th>

            </tr>
        </thead>
        <tbody>
            <?php 
            // Loop through the cell codes and display the rows
            foreach (['A', 'B', 'C', 'D', 'X', 'Y', 'Z', 'W', 'V', 'E'] as $cellcode_char) {
                if (isset($data[$cellcode_char])) { ?>
                    <tr>
                        <td><?= $data[$cellcode_char]['CELL_CODE'] ?? '-' ?></td>
                        <td><?= $data[$cellcode_char]['CELL_ID'] ?? '-' ?></td>
                        <td><?= $data[$cellcode_char]['CELL_NAME'] ?? '-' ?></td>
                        <td><?= $data[$cellcode_char]['AZIMUTH'] ?? '-' ?></td>
                        <td><?= $data[$cellcode_char]['CELL_ON_AIR_DATE'] ?? '-' ?></td>
                        <td><?= $data[$cellcode_char]['HIEGHT'] ?? '-' ?></td>
                        <td><?= $data[$cellcode_char]['BSIC'] ?? '-' ?></td>
                        <td><?= $data[$cellcode_char]['BCCH'] ?? '-' ?></td>
                        <td><?= $data[$cellcode_char]['M_TILT'] ?? '-' ?></td>
                        <td><?= $data[$cellcode_char]['E_TILT'] ?? '-' ?></td>
                        <td><?= $data[$cellcode_char]['CGI'] ?? '-'?></td>
                       
                        <td><?= $data[$cellcode_char]['SERVING_AREA'] ?? '-' ?></td>
                        <td><?= $data[$cellcode_char]['SERVING_AREA_IN_ENGLISH'] ?? '-' ?></td>
                    </tr>
                <?php }
            } ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

 </div>

<div class="footer">
   
    
        <div class="submit">
    
        <input type="submit" name="submit" value="Done">
        </div>
        <div style="clear:both;"></div>
   
    
</div>

</form>
</div>


</body>
</html>
