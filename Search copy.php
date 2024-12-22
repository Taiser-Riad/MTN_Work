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
            <form method="POST">
                <input type="text" class="input1" name="search" placeholder="Search data">
                <button name="submit">Search</button>
            </form>


        </div>
        <div class="result">
            <div class="table-wrapper">
                <table class="table1">
                    <?php 

                
                if(isset($_GET['id'])){
                    $search = $_GET['id'];
                    //$search = $_POST['search'];
                    $sql="SELECT * FROM new_sites WHERE Site_code LIKE '%$search%'";
                    $sqll= "SELECT s.Site_code,  t.* , c.* FROM new_sites s JOIN 2gsites t ON(s.ID = t.Site_ID) JOIN 2gcells c ON (t.Cell_ID = c.CID_Key)     WHERE s.Site_code LIKE '%$search%'";
                    $sqll2="SELECT s.Site_code , t.* , c.* FROM new_sites s JOIN 3gsites t ON(s.ID = t.Site_ID) JOIN 3gcells c ON (t.Cell_ID = c.CID)         WHERE s.Site_code LIKE '%$search%'";
                    $sqll3="SELECT s.Site_code , t.* , c.* FROM new_sites s JOIN 4gsites t ON(s.ID = t.SID)     JOIN 4gcells c ON (t.Cell_ID_KEY = c.CID_Key) WHERE s.Site_code LIKE '%$search%'";

                    $result  =  mysqli_query($conn,$sql);
                    $resultt =  mysqli_query($conn,$sqll);
                    $resultt2 = mysqli_query($conn,$sqll2);
                    $resultt3 = mysqli_query($conn,$sqll3);





                        if(mysqli_num_rows($result)>0){
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
                        
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id =$row['ID'];
                            echo '<tbody>
                            <tr>
                             <td>' . $row['Site_code']           . '</td>
                             <td>' . $row['Site_Name']           . '</td>
                             <td>' . $row['Province']            . '</td>
                             <td>' . $row['Site_On_Air_Date']    . '</td>
                             <td> <a href="update_basic_info.php?id='. $row['ID'] .'">Update</a></td>
                             

                            </tr>
                            </tbody>';
                           
                            echo "</div>";
                           
                        }
                       
                    
                
                    
                   
                    ?>
                </table>

                <?php
                    
                     echo"<div><div class= 'Lfloat'><button type='button' class= 'btn'><a href='Info.php?id2=". $id ."'> >>>>More Details</a></button></div>";
                     echo"<div class='Rfloat'><button type='button' class='btn' class ='btnn'><a href='delete_all.php?id2=". $id ."'>Cancel Site with all technologies</a></button></div><div style='clear:both;'></div></div>";


                        }
                        else {
                    echo "Site Is Not Exist!!";
                    }
                       ?>
            </div>




            <div class="table-wrapper">
                <table class="table2">
                    <?php

                    if(mysqli_num_rows($resultt)>0){

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

                    while ($roww = mysqli_fetch_assoc($resultt)) {
                        $id2 = $roww['Site_ID'];
                        echo '<tbody>
                        <tr>
                         <td>' . $roww['Cell_code']                  . '</td>
                         <td>'  .$roww['Cell_Name']                 . '</td>
                         <td>' . $roww['Cell_ID']                   . '</td>
                         <td>' . $roww['Cell_On_Air_Date']          . '</td>
                         <td> <a href="update2G.php?id2='. $roww['Site_ID'] .'">Update</a></td>
                         <td> <a href="delete2GCell.php?id2='. $roww['Cell_code'] .'">Delete Cell</a></td>
                       </tr>
                       </tbody>';

                        echo "</div>";
                    }
                
                
               
                ?>
                </table>
                <?php
                     echo"<div><div class= 'Lfloat'><button type='button' class= 'btn'><a href='Info2G.php?id2=". $id2 ."'> >>>>More Details</a></button></div>";
                     echo"<div class='Rfloat'><button type='button' class='btn' class ='btnn'><a href='delete2G.php?id12=". $id2 ."'> >>>>Cancell 2G Site</a></button></div><div style='clear:both;'></div></div>";
                   
                }
                        else {
                    echo "2G Site Is Not Exist!!";
                    }
                       ?>
            </div>

            <div class="table-wrapper">
                <table class="table3">
                    <?php
            if(mysqli_num_rows($resultt2)>0){
                            
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

            while ($roww2 = mysqli_fetch_assoc($resultt2)) {
                $id3 = $roww2['Site_ID'];
                echo '<tbody>
                <tr>
                 <td>' . $roww2['Site_Code']                 . '</td>
                 <td>' . $roww2['Cell_Code']                 . '</td>
                 <td>'  .$roww2['Cell_Name']                 . '</td>
                 <td>' . $roww2['Cell_ID']                   . '</td>
                 <td>'.  $roww2['3GOn_Air_Date']             . '</td>
                 <td>' . $roww2['On_Air_Date']               . '</td>
                 <td> <a href="update3G.php?id2='. $roww2['Site_ID'] .'">Update</a></td>
                 <td> <a href="delete3GCell.php?id2='. $roww2['Cell_Code'] .'">Delete Cell</a></td>
                </tr>
                </tbody>';
                echo "</div>";
             }
        

        
            
             ?>
                </table>
                <?php

                echo"<div><div class= 'Lfloat'><button type='button' class= 'btn'><a href='Info3G.php?id3=". $id3 ."'> >>>>More Details</a></button></div>";
                echo"<div class='Rfloat'><button type='button' class='btn' class ='btnn'><a href='delete3G.php?id13=". $id3 ."'> >>>>Cancell 3G Site</a></button></div><div style='clear:both;'></div></div>";
                 
                      }
                        else {
                    echo "3G Site Is Not Exist!!";
                    }

                       ?>

            </div>
            <div class="table-wrapper">
                <table class="table4">
                    <?php
            if(mysqli_num_rows($resultt3)>0){
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
           

            while ($roww3 = mysqli_fetch_assoc($resultt3)) {
                $id4 = $roww3['SID'];
                echo '<tbody>
                <tr>
                 <td>' . $roww3['Site_code']                 . '</td>
                 <td>' . $roww3['Cell_code']                 . '</td>
                 <td>'  .$roww3['Cell_Name']                 . '</td>
                 <td>' . $roww3['Cell_ID']                   . '</td>
                 <td>'.  $roww3['Activation_Date']           . '</td>
                 <td>' . $roww3['On_Air_Date']               . '</td>
                 <td> <a href="update4G.php?id4='. $roww3['SID'] .'">Update</a></td>
                 <td> <a href="delete4GCell.php?id4='. $roww3['Cell_code'] .'">Delete Cell</a></td>
                </tr>
                </tbody>';
                echo "</div>";
    

             
            }
           

            
            ?>
                </table>
                <?php

                    echo"<div><div class= 'Lfloat'><button type='button' class= 'btn'><a href='Info4G.php?id4=". $id4 ."'> >>>>More Details</a></button></div>";
                    echo"<div class='Rfloat'><button type='button' class='btn' class ='btnn'><a href='delete4G.php?id14=". $id4 ."'> >>>>Cancell 4G Site</a></button></div><div style='clear:both;'></div></div>";

                   
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