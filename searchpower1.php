<?php 
include "config.php";
//echo phpinfo();
header('Content-Type: text/html; charset=UTF-8');
?>
<?php
if(isset($_GET['user']))
{
$username =$_GET['user'];
$sqll= "SELECT * FROM USERS WHERE USERNAME= :username";
$result = oci_parse($conn,$sqll);
oci_bind_by_name($result, ':username' ,$username);
oci_execute($result);
$row11 = oci_fetch_array($result , OCI_ASSOC + OCI_RETURN_NULLS);
$userrname = $row11['USERNAME'];
$dep = $row11['DEPARTMENT'];
$user_id =  $row11['USER_ID'];
//echo $userrname;

}



?>

<!DOCTYPE html>
<html lang="ar">
<html>
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href= "fontawesome-free-6.5.2-web\css\all.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Search data</title>
<style>
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
display:flex;
flex-direction:column;
width:60%;
max-height:100vh;
min-height:60%;
background: whitesmoke;
padding-top:0;
margin-top:0px;
box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
padding:10px;
border:2px solid gray;
color: #1c355c;
border-radius:5px;
overflow:hidden;



}

.header {
   
    flex:0 0 auto;
    background: #1c355c;
    color: white;
    text-align: center;
    margin-top:0px;
    align-items: center;
  justify-content: center;
  padding:10px;
    
   
}

.footer
{
    flex:0 0 auto;
    background: #1c355c;
    font-size: 17px;
    margin-top:10px;
    color: white;
    /* width: 100%;*/
    padding:10px;
    padding-bottom:10px;
    padding-top:30px;
    height:20%;
    
 

}

.form1{
    flex:0 0 auto;
    margin-top: 15px;
    /*width: 80%;*/
    padding: 40px;
    vertical-align: center;
    
   
}


.input1 {
    background-color:#e1e6ed;
    border:0.5px solid #e1e6ed;
    width:30%;
    Height:30px;
    margin-left:200px;
   

}
.input1[type=text]:focus{
    border:0.8px solid #e1e6ed;
    
}
.input1[type=select]:focus{
    border:0.8px solid #e1e6ed;

}
button{
    width:15%;
    Height:33px;
    background: #1c355c;
    border:none;
    color:white;
    font-size: 13px;
   font-weight: bold;
}
table, th, td {
    border:2px solid #b4c5e0;
    border-collapse: collapse;
    text-align:center;
    
    
}
table, tr, td {
  
    font-size: 14px;
    
    
}
.result{
    flex:1 1 auto;
    margin-left:10px;
    padding: 10px;
    overflow:auto;
    
}
h2{
    background-color:#1c355c;
    color: white;
    margin-left:0px;
    padding-left:5px;
    width:100%;
 
    
}

.table-wrapper{
    display:flex;
flex-direction:column;
align-items: stretch;
width:100%;

}


 .table-wrapper table{
width:100%;
border-collapse:collapse;
margin-bottom:20px;
 }

 button a {
    color: white;
    font-size:13px;
    font-weight:bold;
    text-decoration:none;
 }
 .Rfloat{
    float: right;
    width:16%;
    overflow: hidden;
    border:2px solid #b4c5e0;
}
.Lfloat{
    float: left;
    width:16%;
    overflow: hidden;
    border:2px solid #b4c5e0;
}
.btn{
    width:100%

}
.btnn{
    float: right;
}
.button10 span {
  cursor: pointer;
border-radius:5px;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button10 span:after {
  content: '\00AB';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button10:hover span {
  padding-right: 25px;
}

.button10:hover span:after {
  opacity: 1;
  right: 0;
}
.disabled-link {
    pointer-events: none;
    cursor: default;
    color: grey; /* Adjust the color to indicate it's disabled */
    text-decoration: none; /* Optional: Remove underline */
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
<?php  echo "<a href= 'export power.php'><button type='button' class='modal-btn'>Export All Data</button></a>";

                         ?>
        </form>
     

    </div>
    <div class="result">
     
                <?php 

                
                        if(isset($_POST['submit'])){
                            $search = $_POST['search'] ?? '';
                            //$code2 = substr($search,-3)?? '';
                            //$code1 = strtoupper(substr($search, 0, 3));
                            $search = strtoupper($search);
                            $code1 = substr($search, 0, 3);
                            if (!preg_match("/^(DAM|DMR|DRA|ALP|DRZ|HMS|HMA|TRS|LTK|RKA|IDB|SWD|QRA|HSK)$/", $code1)) {
                                // Output JavaScript alert if the site code is not valid
                                //echo '<script>alert("Site code" .$code1." not valid");</script>';
                            echo "Site code" .$code1." not valid";
                                exit; // Stop further script execution
                              
                            }
                           // $search = $code1.$code2;
                          // header("location:addpower.php?id='. $row['ID'] .' & user_id='.$user_id.'");

                        
                       

                            $search = "%$search%";
                            $sql=  "SELECT * FROM NEW_SITES WHERE SITE_CODE LIKE :search";
                            // $sqll= "SELECT s.SITE_CODE,  t.* , c.* FROM NEW_SITES s JOIN TWO_G_SITES t   ON(s.ID = t.SITE_ID) JOIN TWO_G_CELLS c   ON (t.Cell_ID = c.CID_Key)     WHERE s.SITE_CODE LIKE :search";
                            // $sqll2="SELECT s.SITE_CODE , t.* , c.* FROM NEW_SITES s JOIN THREE_G_SITES t ON(s.ID = t.SITE_ID) JOIN THREE_G_CELLS c ON (t.Cell_ID = c.CID)         WHERE s.SITE_CODE LIKE :search";
                            // $sqll3="SELECT s.SITE_CODE , t.* , c.* FROM NEW_SITES s JOIN FOUR_G_SITES t  ON(s.ID = t.SID)     JOIN FOUR_G_CELLS c  ON (t.Cell_ID_KEY = c.CID_Key) WHERE s.SITE_CODE LIKE :search";


                            $result  =  oci_parse($conn,$sql);
                            oci_bind_by_name($result,':search' ,$search);
                            oci_execute($result);

                            
                            if($row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS)){

                                $id = $row['ID'];
                                header("location:addpower.php?id=" . $row['ID'] . "&user_id=" . $user_id);
                            }

else{
    echo "Site doesn't exist!!";
}





                           
                        }

                      ?>







 
        </div>

        <div class="footer">
<button type='button' class= 'button10'><?php echo" <a href='Mainpage.php?user=".$userrname."'>"; ?><span> Back </span></a></button>


</div>
</div>
</body>
</html>