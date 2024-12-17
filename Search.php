<?php 
include "config.php";
//echo phpinfo();
?>
<!DOCTYPE html>
<html lang="en">
<html>

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web\css\all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search data</title>
    <style>
    body {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: goldenrod;


    }

    .container {
        /*position: relative;*/
        display: flex;
        flex-direction: column;
        width: 60%;
        max-height: 100vh;
        min-height: 60%;
        background: whitesmoke;
        padding-top: 0;
        margin-top: 0px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
        padding: 10px;
        border: 2px solid gray;
        color: #1c355c;
        border-radius: 5px;
        overflow: hidden;



    }

    .header {

        flex: 0 0 auto;
        background: #1c355c;
        color: white;
        text-align: center;
        margin-top: 0px;
        align-items: center;
        justify-content: center;
        padding: 10px;


    }

    .footer {
        flex: 0 0 auto;
        background: #1c355c;
        font-size: 17px;
        margin-top: 10px;
        color: white;
        /* width: 100%;*/
        padding: 10px;
        padding-bottom: 10px;
        padding-top: 30px;
        height: 20%;



    }

    .form1 {
        flex: 0 0 auto;
        margin-top: 15px;
        /*width: 80%;*/
        padding: 40px;
        vertical-align: center;


    }


    .input1 {
        background-color: #e1e6ed;
        border: 0.5px solid #e1e6ed;
        width: 30%;
        Height: 30px;
        margin-left: 200px;


    }

    .input1[type=text]:focus {
        border: 0.8px solid #e1e6ed;

    }

    .input1[type=select]:focus {
        border: 0.8px solid #e1e6ed;

    }

    button {
        width: 15%;
        Height: 33px;
        background: #1c355c;
        border: none;
        color: white;
        font-size: 15px;
        font-weight: bold;
    }

    table,
    th,
    td {
        border: 2px solid #b4c5e0;
        border-collapse: collapse;
        text-align: center;


    }

    table,
    tr,
    td {

        font-size: 14px;


    }

    .result {
        flex: 1 1 auto;
        margin-left: 10px;
        padding: 10px;
        overflow: auto;

    }

    h2 {
        background-color: #1c355c;
        color: white;
        margin-left: 0px;
        padding-left: 5px;
        width: 100%;


    }

    .table-wrapper {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        width: 100%;

    }


    .table-wrapper table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    button a {
        color: white;
        font-size: 13px;
        font-weight: bold;
        text-decoration: none;
    }

    .Rfloat {
        float: right;
        width: 16%;
        overflow: hidden;
        border: 2px solid #b4c5e0;
    }

    .Lfloat {
        float: left;
        width: 16%;
        overflow: hidden;
        border: 2px solid #b4c5e0;
    }

    .btn {
        width: 100%
    }

    .btnn {
        float: right;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1></br> Search.Edit.Delete </h1>
            Enter Site Code</br>
            </br>
        </div>
        <div class="form1">
            <form id="searchForm" method="POST">
                <input type="text" class="input1" name="search" placeholder="Search Site Code">
                <button type="submit" name="submit">Search</button>
            </form>


        </div>

        <div class="result">

            <div class="table-wrapper">
                <table class="table1">
                    <?php 

                
                        if(isset($_POST['submit'])){
                            $search = $_POST['search'];
                            $search = "%$search%";
                            $sql=  "SELECT * FROM NEW_SITES WHERE SITE_CODE LIKE :search";
                            $sqll= "SELECT s.SITE_CODE,  t.* , c.* FROM NEW_SITES s JOIN TWO_G_SITES t   ON(s.ID = t.SITE_ID) JOIN TWO_G_CELLS c   ON (t.Cell_ID = c.CID_Key)     WHERE s.SITE_CODE LIKE :search";
                            $sqll2="SELECT s.SITE_CODE , t.* , c.* FROM NEW_SITES s JOIN THREE_G_SITES t ON(s.ID = t.SITE_ID) JOIN THREE_G_CELLS c ON (t.Cell_ID = c.CID)         WHERE s.SITE_CODE LIKE :search";
                            $sqll3="SELECT s.SITE_CODE , t.* , c.* FROM NEW_SITES s JOIN FOUR_G_SITES t  ON(s.ID = t.SID)     JOIN FOUR_G_CELLS c  ON (t.Cell_ID_KEY = c.CID_Key) WHERE s.SITE_CODE LIKE :search";


                            $result  =  oci_parse($conn,$sql);
                            oci_bind_by_name($result,':search' ,$search);
                            oci_execute($result);

                            $resultt = oci_parse($conn, $sqll); 
                            oci_bind_by_name($resultt, ':search', $search);
                            oci_execute($resultt);

                            $resultt2 = oci_parse($conn, $sqll2); 
                            oci_bind_by_name($resultt2, ':search', $search); 
                            oci_execute($resultt2);

                            $resultt3 = oci_parse($conn, $sqll3); 
                            oci_bind_by_name($resultt3, ':search', $search); 
                            oci_execute($resultt3);




                            if($row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS)){
                                echo "<div class='title'>";
                                echo '<h2> Basic Info</h2>
                                <thead>
                                <tr>
                                <th>Site Code</th>
                                <th>Site Name</th>
                                <th>Province</th>
                                <th>Site On Air Date</th>
                                </tr>
                                </thead>';
                            
                                do {
                                    $id = $row['ID'];
                                    echo '<tbody>
                                    <tr>
                                    <td>' . $row['SITE_CODE'] . '</td>
                                    <td>' . $row['SITE_NAME'] . '</td>
                                    <td>' . $row['PROVINCE'] . '</td>
                                    <td>' . $row['SITE_ON_AIR_DATE'] . '</td>
                                
                                    <td> <a href="update_basic_info.php?id='. $row['ID'] .'">Update</a></td>
                                    <td> <a href="delete_all.php?id2='. $row['ID'] .'">Cancel Site</a></td>
                                    </tr>
                                    </tbody>';
                                } while ($row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS));
                            
                                echo "</div>";
                            
                                            
                   
                    ?>
                </table>

                <?php
                    
                 
                     echo"<div><div class= 'Lfloat'><button type='button' class= 'btn'><a href='Info.php?id2=". $id ."' target='_blank'> >>>>More Details</a></button></div>";
                     echo"<div class='Rfloat'><button type='button' class='btn' class ='btnn'><a href='delete_all.php?id2=". $id ."' target='_blank'>Cancel Site with all technologies</a></button></div><div style='clear:both;'></div></div>";


                        }
                        else {
                    echo "Site Is Not Exist!!";
                    }
                
                       ?>
            </div>
            <div class="table-wrapper">
                <table class="table2">
                    <?php
                    if($roww = oci_fetch_array($resultt, OCI_ASSOC + OCI_RETURN_NULLS)){
                
                        echo "<div class='title'>";   
                        echo '<h2> 2G Site Info</h2>
                        <thead>
                        <tr>
                        <th>Cell_code</th>
                        <th>Cell_Name</th>
                        <th>Cell_ID</th>
                        <th>Cell_On_Air_Date</th>
                        </tr>
                     </thead>';

                     do {
                   // while ($roww = mysqli_fetch_assoc($resultt)) {
                        $id2 = $roww['SITE_ID'];
                        echo '<tbody>
                        <tr>
                         <td>' . $roww['CELL_CODE']                  . '</td>
                         <td>'  .$roww['CELL_NAME']                 . '</td>
                         <td>' . $roww['CELL_ID']                   . '</td>
                         <td>' . $roww['CELL_ON_AIR_DATE']          . '</td>
                         <td> <a href="update2G.php?id2='. $roww['SITE_ID'] .'">Update</a></td>
                         <td> <a href="delete2GCell.php?id2='. $roww['CELL_CODE'] .'">Delete Cell</a></td>
                       </tr>
                       </tbody>';
                   }while ($roww = oci_fetch_array($resultt, OCI_ASSOC + OCI_RETURN_NULLS));
                    echo "</div>";
                    
                    
                
               
                ?>
                </table>
                <?php
                     echo"<div><div class= 'Lfloat'><button type='button' class= 'btn'><a href='Info2G.php?id2=". $id2 ."' target='_blank'> >>>>More Details</a></button></div>";
                     echo"<div class='Rfloat'><button type='button' class='btn' class ='btnn'><a href='delete2G.php?id12=". $id2 ."' target='_blank'> >>>>Cancell 2G Site</a></button></div><div style='clear:both;'></div></div>";
                   
                }
                        else {
                    echo "2G Site Is Not Exist!!";
                    }
                       ?>
            </div>

            <div class="table-wrapper">
                <table class="table3">
                    <?php
            //if(mysqli_num_rows($resultt2)>0){
            if($roww2 = oci_fetch_array($resultt2, OCI_ASSOC + OCI_RETURN_NULLS)){
                echo "<div class='title'>";
                echo '<h2> 3G Site Info</h2>
                <thead>
                <tr>
                <th>Site Code</th>
                <th>Cell Code</th>
                <th>Cell Name</th>
                <th>Cell ID</th>
                <th>Site On Air Date</th>
                <th>Cell On Air Date</th>
                
          
                
                </tr>
            </thead>';
                do{
            //while ($roww2 = mysqli_fetch_assoc($resultt2)) {
                $id3 = $roww2['SITE_ID'];
                echo '<tbody>
                <tr>
                 <td>' . $roww2['SITE_CODE']                 . '</td>
                 <td>' . $roww2['CELL_CODE']                 . '</td>
                 <td>'  .$roww2['CELL_NAME']                 . '</td>
                 <td>' . $roww2['CELL_ID']                   . '</td>
                 <td>'.  $roww2['THREE_G_ON_AIR_DATE']             . '</td>
                 <td>' . $roww2['ON_AIR_DATE']               . '</td>
                 <td> <a href="update3G.php?id2='. $roww2['SITE_ID'] .'">Update</a></td>
                 <td> <a href="delete3GCell.php?id2='. $roww2['CELL_CODE'] .'">Delete Cell</a></td>
                </tr>
                </tbody>';
                
             }while ($roww2 = oci_fetch_array($resultt2, OCI_ASSOC + OCI_RETURN_NULLS));
        
             echo "</div>";
        
            
             ?>
                </table>
                <?php

                echo"<div><div class= 'Lfloat'><button type='button' class= 'btn'><a href='Info3G.php?id3=". $id3 ."' target='_blank'> >>>>More Details</a></button></div>";
                echo"<div class='Rfloat'><button type='button' class='btn' class ='btnn'><a href='delete3G.php?id13=". $id3 ."' target='_blank'> >>>>Cancell 3G Site</a></button></div><div style='clear:both;'></div></div>";
                 
                      }
                        else {
                    echo "3G Site Is Not Exist!!";
                    }

                       ?>


            </div>
            <div class="table-wrapper">
                <table class="table4">
                    <?php
            if($roww3 = oci_fetch_array($resultt3, OCI_ASSOC + OCI_RETURN_NULLS)){
            //if(mysqli_num_rows($resultt3)>0){
                echo "<div class='title'>";        
                echo '<h2> 4G Site Info</h2>
                <thead>
                <tr>
                <th>Site Code</th>
                <th>Cell Code</th>
                <th>Cell Name</th>
                <th>Cell ID</th>
                <th>Site On Air Date</th>
                <th>Cell On Air Date</th>       
                
                </tr>
            </thead>';
           
                do{
            //while ($roww3 = mysqli_fetch_assoc($resultt3)) {
                $id4 = $roww3['SID'];
                echo '<tbody>
                <tr>
                 <td>' . $roww3['SITE_CODE']                 . '</td>
                 <td>' . $roww3['CELL_CODE']                 . '</td>
                 <td>'  .$roww3['CELL_NAME']                 . '</td>
                 <td>' . $roww3['CELL_ID']                   . '</td>
                 <td>'.  $roww3['ACTIVATION_DATE']           . '</td>
                 <td>' . $roww3['ON_AIR_DATE']               . '</td>
                 <td> <a href="update4G.php?id4='. $roww3['SID'] .'">Update</a></td>
                 <td> <a href="delete4GCell.php?id4='. $roww3['CELL_CODE'] .'">Delete Cell</a></td>
                </tr>
                </tbody>';
               
    

             
            }while ($roww3 = oci_fetch_array($resultt3, OCI_ASSOC + OCI_RETURN_NULLS));
           
            echo "</div>";
            
            ?>
                </table>
                <?php

                    echo"<div><div class= 'Lfloat'><button type='button' class= 'btn'><a href='Info4G.php?id4=". $id4 ."' target='_blank'> >>>>More Details</a></button></div>";
                    echo"<div class='Rfloat'><button type='button' class='btn' class ='btnn'><a href='delete4G.php?id14=". $id4 ."' target='_blank'> >>>>Cancell 4G Site</a></button></div><div style='clear:both;'></div></div>";

                   
                      }
                        else {
                    echo "4G Site Is Not Exist!!";
                    }
                }
                       ?>
            </div>
        </div>
        <div class="footer">


        </div>
    </div>
</body>

</html>