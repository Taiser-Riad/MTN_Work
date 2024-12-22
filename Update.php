<?php 
include "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<html>

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web\css\all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search data</title>
    <script>
    function confirm() {
        return confirm("Are you sure you want to update?");
    }
    </script>
</head>

<body>
    <div class="container">
        <form method="POST" onsubmit="return confirm();">
            <input type="text" name="search" placeholder="Search data">
            <button name="submit">Search</button>
        </form>
        <div class="result">
            <table class="table">
                <?php 
                if(isset($_POST['submit'])){
                    $search = $_POST['search'];
                    $sql="SELECT * FROM new_sites WHERE Site_code LIKE '%$search%'";
                    $sqll= "SELECT s.Site_code,  t.* , c.* FROM new_sites s JOIN 2gsites t ON(s.ID = t.Site_ID) JOIN 2gcells c ON (t.Cell_ID = c.CID_Key)     WHERE s.Site_code LIKE '%$search%'";
                    $sqll2="SELECT s.Site_code , t.* , c.* FROM new_sites s JOIN 3gsites t ON(s.ID = t.Site_ID) JOIN 3gcells c ON (t.Cell_ID = c.CID)         WHERE s.Site_code LIKE '%$search%'";
                    $sqll3="SELECT s.Site_code , t.* , c.* FROM new_sites s JOIN 4gsites t ON(s.ID = t.SID)     JOIN 4gcells c ON (t.Cell_ID_KEY = c.CID_Key) WHERE s.Site_code LIKE '%$search%'";

                    $result  =  mysqli_query($conn,$sql);
                    $resultt =  mysqli_query($conn,$sqll);
                    $resultt2 = mysqli_query($conn,$sqll2);
                    $resultt3 = mysqli_query($conn,$sqll3);


                    if($result){
                        if(mysqli_num_rows($result)>0){
                            echo '<h2> Basic Info</h2>
                            <thead>
                            <tr>
                            <th>Site Code</th>
                            <th>Site Name</th>
                            <th>Zone</th>
                            <th>Province</th>
                            <th>City/Rural</th>
                            <th>Supplier</th>
                            <th>BSC</th>
                            <th>Power_Backup</th>
                            <th>Site On Air Date</th>
                            <th>Relocation Date</th>
                            <th>Coordinates E</th>
                            <th>Coordinates N</th>
                            <th>Altitude</th>
                            <th>Site Address</th>
                            <th>Arabic Name</th>
                            <th>TX Node</th>
                            <th>Technical Priority</th>
                            <th>Administrative Area</th>
                            <th>Node Category</th>
                            <th>Site Ranking</th>
                            <th>Subcontractor</th>
                            <th>Invoice Tyology</th>
                            <th>Area Ranking</th>
                            </tr>
                            </thead>';
                        
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tbody>
                            <tr>
                             <td>' . $row['Site_code']           . '</td>;
                             <td>' . $row['Site_Name']           . '</td>;
                             <td>'.  $row['Zone']                . '</td>;
                             <td>' . $row['Province']            . '</td>;
                             <td>' . $row['CR']                  . '</td>;
                             <td>'  .$row['Supplier']            . '</td>;
                             <td>' . $row['BSC']                 . '</td>;
                             <td>' . $row['Power_Backup']        . '</td>;
                             <td>' . $row['Site_On_Air_Date']    . '</td>;
                             <td>' . $row['Relocation_Date']     . '</td>;
                             <td>' . $row['Coordinates_E']       . '</td>;
                             <td>' . $row['Coordinates_N']       . '</td>;
                             <td>' . $row['Altitude']            . '</td>;
                             <td>'  .$row['Site_Adress']         . '</td>;
                             <td>' . $row['Arabic_Name']         . '</td>;
                             <td>' . $row['TX_Node']             . '</td>;
                             <td>' . $row['Technical_Priority']  . '</td>;
                             <td>' . $row['Administrative_Area'] . '</td>;
                             <td>' . $row['Node_Category']       . '</td>;
                             <td>' . $row['Site_Ranking']        . '</td>;
                             <td>'  .$row['Subcontractor']       . '</td>;
                             <td>' . $row['Invoice_Tyology']     . '</td>;
                             <td>' . $row['Area_Ranking']        . '</td>;
                            </tr>
                            </tbody>';

                        }
                        
                        }
                    }
                    else {
                    echo "<h2>Data Not Found!! </h2>";
                    }
                    if($resultt){
                        if(mysqli_num_rows($resultt)>0){
                            
                            echo '<h2> 2G Site Info</h2>
                            <thead>
                            <tr>
                            <th>Band</th>
                            <th>Site_Status</th>
                            <th>BTS_Type</th>
                            <th>BSC</th>
                            <th>2G_On_Air_Date</th>
                            <th>900GSM_RBS_Type</th>
                            <th>900On_Air_Date</th>
                            <th>1800GSM_RBS_Type</th>
                            <th>1800On_Air_Date</th>
                            <th>Site Notes</th>
                            <th>Real_BSC</th>
                            <th>LAC</th>
                            <th>Cell_code</th>
                            <th>Cell_Name</th>
                            <th>Cell_ID</th>
                            <th>AZIMUTH</th>
                            <th>Hieght</th>
                            <th>BSiC</th>
                            <th>M_TILT</th>
                            <th>E_TILT</th>
                            <th>Total_TILT</th>
                            <th>BSC</th>
                            <th>BCCH</th>
                            <th>Cell_On_Air_Date</th>
                            <th>Cell Notes</th>
                            <th>serving_Area_IN_English</th>
                            <th>Serving_Area_IN_Arabic</th>
                            </tr>
                        </thead>';
                        
                        while ($roww = mysqli_fetch_assoc($resultt)) {
                            echo '<tbody>
                            <tr>
                             <td>' . $roww['Band']                     . '</td>;
                             <td>' . $roww['Site_Status']               . '</td>;
                             <td>'.  $roww['BTS_Type']                  . '</td>;
                             <td>' . $roww['BSC']                       . '</td>;
                             <td>' . $roww['2G_On_Air_Date']            . '</td>;
                             <td>'  .$roww['900GSM_RBS_Type']           . '</td>;
                             <td>' . $roww['900On_Air_Date']            . '</td>;
                             <td>' . $roww['1800GSM_RBS_Type']          . '</td>;
                             <td>' . $roww['1800On_Air_Date']           . '</td>;
                             <td>' . $roww['Notes']                     . '</td>;
                             <td>' . $roww['Real_BSC']                  . '</td>;
                             <td>' . $roww['LAC']                       . '</td>;
                             <td>' . $roww['Cell_code']                 . '</td>;
                             <td>'  .$roww['Cell_Name']                 . '</td>;
                             <td>' . $roww['Cell_ID']                   . '</td>;
                             <td>' . $roww['AZIMUTH']                   . '</td>;
                             <td>' . $roww['Hieght']                    . '</td>;
                             <td>' . $roww['BSiC']                      . '</td>;
                             <td>' . $roww['M_TILT']                    . '</td>;
                             <td>' . $roww['E_TILT']                    . '</td>;
                             <td>'  .$roww['Total_TILT']                . '</td>;
                             <td>' . $roww['BSC']                       . '</td>;
                             <td>' . $roww['BCCH']                      . '</td>;
                             <td>' . $roww['Cell_On_Air_Date']          . '</td>;
                             <td>' . $roww['Notes']                     . '</td>;
                             <td>' . $roww['serving_Area_IN_English']   . '</td>;
                             <td>' . $roww['Serving_Area']              . '</td>;

                            </tr>
                            </tbody>';
                        }
                        }

                    }
                    else{
                        echo "<h2> 2G Site Is Not Found!! </h2>";
                    }




                
                
                }
                
                
                ?>
            </table>
        </div>
    </div>
</body>

</html>