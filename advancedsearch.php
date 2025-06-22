<?php 
include "config.php";
header('Content-Type: text/html; charset=UTF-8');
$userrname = '';  // default value
$dep = ''; 
if(isset($_GET['user']))
{
$username =$_GET['user'];
$sqll= "SELECT * FROM USERS WHERE USERNAME= :username";
$result = oci_parse($conn,$sqll);
oci_bind_by_name($result, ':username' ,$username);
oci_execute($result);
$row = oci_fetch_array($result , OCI_ASSOC + OCI_RETURN_NULLS);
$userrname = $row['USERNAME'];
$dep = $row['DEPARTMENT'];
//echo $userrname;

}
?>
<?php
$results = [];
if($_SERVER["REQUEST_METHOD"] == "POST"){
$selectedTables = isset($_POST['tech']) ? $_POST['tech'] : [];
$selectedzone = isset($_POST['Zone']) ? $_POST['Zone'] : '';
$selectedCity = isset($_POST['C/R']) ? $_POST['C/R'] : null;
$searchVendor = isset($_POST['vendor']) ? $_POST['vendor'] : '';
$searchprovince = isset($_POST['province']) ? $_POST['province'] : [];
$selectedStatus = isset($_POST['sitestatus']) ? $_POST['sitestatus'] : [];
$searchPriority = isset($_POST['priority']) ? $_POST['priority'] : [];
$startYear = isset($_POST['yearSelectStart']) ? $_POST['yearSelectStart'] : '';
$endYear = isset($_POST['yearSelectEnd']) ? $_POST['yearSelectEnd'] : '';
$selectedMonth = isset($_POST['monthSelect']) ? $_POST['monthSelect'] : '';
$selectedRestoration = isset($_POST['restoration']) ? $_POST['restoration'] : '';

$sql = "SELECT NEW_SITES.SITE_CODE ,NEW_SITES.PROVINCE ,NEW_SITES.SUPPLIER ,NEW_SITES.SITE_ON_AIR_DATE ";

$joinConditions = [];
$matchIndicators = [];
$whereConditions = [];
$technologyFlags = [
    '2G' => false,
    '3G' => false,
    'LTE' => false,
    '2Gonly' => false,
    '3Gonly' => false,
    '4Gonly' => false,
    '2G-3G' => false,
    '2G-4G' => false,
    '3G-4G' => false,
];

if (!empty($selectedTables)) {
    foreach ($selectedTables as $table) {
        switch ($table) {
            case 'TWO_G_SITES':
                $joinConditions[] = "INNER JOIN TWO_G_SITES  ON NEW_SITES.ID = TWO_G_SITES.SITE_ID"; // Adjust join condition
                $matchIndicators[] = "CASE WHEN TWO_G_SITES.SITE_ID IS NOT NULL THEN '2G'  END AS TECHNOLOGY_2G";
                $matchIndicators[] = "TWO_G_SITES.TWOG_ON_AIR_DATE AS \"2G_ON_AIR_DATE\"";
                $whereConditions[] = "NEW_SITES.ID != 2775";
                if (!empty($_POST['yearSelectStart']) && !empty($_POST['yearSelectEnd'])) {
                    $startDate = $_POST['yearSelectStart'];
                    $endDate = $_POST['yearSelectEnd'];

                $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE,'MM/DD/YYYY')) BETWEEN $startYear AND $endYear";
                }
                else if (!empty($_POST['yearSelectStart'])) {
                    $startYear = $_POST['yearSelectStart'];
                    if (!empty($_POST['monthSelect'])){
                        $month = $_POST['monthSelect'];
                       
                        $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE,'MM/DD/YYYY')) = $startYear AND EXTRACT(MONTH FROM TO_DATE(NEW_SITES.SITE_ON_AIR_DATE,'MM/DD/YYYY')) = $month";
                        $matchIndicators[] = "CASE WHEN TWO_G_SITES.SITE_ID IS NOT NULL THEN '2G'  END AS TECHNOLOGY_2G";
                       }
                       else{
                    $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE,'MM/DD/YYYY')) = $startYear";
                       }
                
                }
                 if (!empty($_POST['Zone']) || ($_POST['Zone'] !== '')) {
                    $zone = $_POST['Zone'];

                    $whereConditions[] = "NEW_SITES.ZONE = '$zone'";
                    $matchIndicators[] = "NEW_SITES.ZONE";
                
                }
                if (!empty($_POST['vendor']) || ($_POST['vendor'] !== '')) {
                    $vendor = $_POST['vendor'];

                    $whereConditions[] = "NEW_SITES.SUPPLIER = '$vendor'";
                    $matchIndicators[] = "NEW_SITES.SUPPLIER";
                
                }
                if (!empty($_POST['province']) && !in_array('', $_POST['province'])) {
                    $province = $_POST['province'];

                    $provinceList = "'" . implode("','", $province) . "'";
                    $whereConditions[] = "NEW_SITES.PROVINCE IN ($provinceList)";
                    $matchIndicators[] = "NEW_SITES.PROVINCE";
            
                
                }
                if (!empty($_POST['C/R']) || ($_POST['C/R'] !== '')) {
                    $CR = $_POST['C/R'];
                    if($CR === 'Rural'){
                    $whereConditions[] = "NEW_SITES.CR LIKE '%-R'";
                    $matchIndicators[] = "NEW_SITES.CR";
                    }
                     else {
                        $whereConditions[] = "NEW_SITES.CR NOT LIKE '%-R'";
                        $matchIndicators[] = "NEW_SITES.CR";
                     }
                
                }
                        if (!empty($_POST['priority']) && !in_array('', $_POST['priority'])) {
                    $priority = $_POST['priority'];
                
                    $priorityList = "'" . implode("','", $priority) . "'";
                    $whereConditions[] = "NEW_SITES.TECHNICAL_PRIORITY IN ($priorityList)";
                    $matchIndicators[] = "NEW_SITES.TECHNICAL_PRIORITY";
                
                }
                if (!empty($_POST['sitestatus']) && !in_array('', $_POST['sitestatus'])) {
                    $sitestatus = $_POST['sitestatus']; // Assuming this is an array
                
                    // Convert the array to a comma-separated list of values
                    $sitestatusList = "'" . implode("','", $sitestatus) . "'";
                    $whereConditions[] = "TWO_G_SITES.SITE_STATUS IN ($sitestatusList)";
                    $matchIndicators[] = "TWO_G_SITES.SITE_STATUS AS \"2G_STATUS\"";
                }
                // if (!empty($_POST['restoration'])) {
                //     $restDate = $_POST['restoration'];
                    

                // $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(TWO_G_SITES.RESTORATION_DATE,'MM/DD/YYYY')) = $restDate";
                //}

                break;
            case 'THREE_G_SITES':
                $joinConditions[] = "INNER JOIN THREE_G_SITES  ON NEW_SITES.ID = THREE_G_SITES.SITE_ID"; // Adjust join condition
                $matchIndicators[] = "CASE WHEN THREE_G_SITES.SITE_ID IS NOT NULL THEN '3G' END AS TECHNOLOGY_3G";
                $matchIndicators[] = "THREE_G_SITES.THREE_G_ON_AIR_DATE AS \"3G_ON_AIR_DATE\"";
                $whereConditions[] = "NEW_SITES.ID != 2775";
                //$technologyFlags['3G'] = true;
                if (!empty($_POST['yearSelectStart']) && !empty($_POST['yearSelectEnd'])) {
                    $startDate = $_POST['yearSelectStart'];
                    $endDate = $_POST['yearSelectEnd'];

                $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(THREE_G_SITES.THREE_G_ON_AIR_DATE,'MM/DD/YYYY')) BETWEEN $startYear AND $endYear";
                }
                else if (!empty($_POST['yearSelectStart'])) {
                    $startYear = $_POST['yearSelectStart'];
                    if (!empty($_POST['monthSelect'])){
                        $month = $_POST['monthSelect'];
                       
                        $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(THREE_G_SITES.THREE_G_ON_AIR_DATE,'MM/DD/YYYY')) = $startYear AND EXTRACT(MONTH FROM TO_DATE(THREE_G_SITES.THREE_G_ON_AIR_DATE,'MM/DD/YYYY')) = $month";
                       }
                       else{
                    $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(THREE_G_SITES.THREE_G_ON_AIR_DATE,'MM/DD/YYYY')) = $startYear";
                       }
                
                }
                if (!empty($_POST['Zone']) || ($_POST['Zone'] !== '')) {
                    $zone = $_POST['Zone'];

                    $whereConditions[] = "NEW_SITES.ZONE = '$zone'";
                    $matchIndicators[] = "NEW_SITES.ZONE";
                
                }
                if (!empty($_POST['vendor']) || ($_POST['vendor'] !== '')) {
                    $vendor = $_POST['vendor'];

                    $whereConditions[] = "NEW_SITES.SUPPLIER = '$vendor'";
                    $matchIndicators[] = "NEW_SITES.SUPPLIER";
                
                }
            

                if (!empty($_POST['province']) && !in_array('', $_POST['province'])) {
                    $province = $_POST['province'];

                    $provinceList = "'" . implode("','", $province) . "'";
                    $whereConditions[] = "NEW_SITES.PROVINCE IN ($provinceList)";
                    $matchIndicators[] = "NEW_SITES.PROVINCE";
            
                
                }

                if (!empty($_POST['C/R']) || ($_POST['C/R'] !== '')) {
                    $CR = $_POST['C/R'];
                    if($CR === 'Rural'){
                    $whereConditions[] = "NEW_SITES.CR LIKE '%-R'";
                    $matchIndicators[] = "NEW_SITES.CR";
                    }
                     else {
                        $whereConditions[] = "NEW_SITES.CR NOT LIKE '%-R'";
                        $matchIndicators[] = "NEW_SITES.CR";
                     }
                
                }
          

                if (!empty($_POST['priority']) && !in_array('', $_POST['priority'])) {
                    $priority = $_POST['priority'];
                   
                    $priorityList = "'" . implode("','", $priority) . "'";
                    $whereConditions[] = "NEW_SITES.TECHNICAL_PRIORITY IN ($priorityList)";
                    $matchIndicators[] = "NEW_SITES.TECHNICAL_PRIORITY";
                
                }



                if (!empty($_POST['sitestatus']) && !in_array('', $_POST['sitestatus'])) {
                    $sitestatus = $_POST['sitestatus']; // Assuming this is an array
                
                    // Convert the array to a comma-separated list of values
                    $sitestatusList = "'" . implode("','", $sitestatus) . "'";
                    $whereConditions[] = "THREE_G_SITES.SITE_STATUS IN ($sitestatusList)";
                    $matchIndicators[] = "THREE_G_SITES.SITE_STATUS AS \"3G_STATUS\"";
                }

       
                break;
            case 'FOUR_G_SITES':
                $joinConditions[] = "INNER JOIN FOUR_G_SITES ON NEW_SITES.ID = FOUR_G_SITES.SID"; // Adjust join condition
                $matchIndicators[] = "CASE WHEN FOUR_G_SITES.SID IS NOT NULL THEN 'LTE' END AS TECHNOLOGY_4G";
                $whereConditions[] = "NEW_SITES.ID != 2775";
                //$technologyFlags['LTE'] = true;
                if (!empty($_POST['yearSelectStart']) && !empty($_POST['yearSelectEnd'])) {
                    $startYear = $_POST['yearSelectStart'];
                    $endYear = $_POST['yearSelectEnd'];

                $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(FOUR_G_SITES.ACTIVATION_DATE,'MM/DD/YYYY')) BETWEEN $startYear AND $endYear";
                }
                else if (!empty($_POST['yearSelectStart'])) {
                    $startYear = $_POST['yearSelectStart'];
                    if (!empty($_POST['monthSelect'])){
                        $month = $_POST['monthSelect'];
                       
                        $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(FOUR_G_SITES.ACTIVATION_DATE,'MM/DD/YYYY')) = $startYear AND EXTRACT(MONTH FROM TO_DATE(FOUR_G_SITES.ACTIVATION_DATE,'MM/DD/YYYY')) = $month";
                       }
                       else{
                    $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(FOUR_G_SITES.ACTIVATION_DATE,'MM/DD/YYYY')) = $startYear";
                       }
                
                }
                if (!empty($_POST['Zone']) || ($_POST['Zone'] !== '')) {
                    $zone = $_POST['Zone'];

                    $whereConditions[] = "NEW_SITES.ZONE = '$zone'";
                    $matchIndicators[] = "NEW_SITES.ZONE";
                
                }
                if (!empty($_POST['vendor']) || ($_POST['vendor'] !== '')) {
                    $vendor = $_POST['vendor'];

                    $whereConditions[] = "NEW_SITES.SUPPLIER = '$vendor'";
                    $matchIndicators[] = "NEW_SITES.SUPPLIER";
                
                }
                if (!empty($_POST['province']) && !in_array('', $_POST['province'])) {
                    $province = $_POST['province'];

                    $provinceList = "'" . implode("','", $province) . "'";
                    $whereConditions[] = "NEW_SITES.PROVINCE IN ($provinceList)";
                    $matchIndicators[] = "NEW_SITES.PROVINCE";
            
                
                }

                if (!empty($_POST['C/R']) || ($_POST['C/R'] !== '')) {
                    $CR = $_POST['C/R'];
                    if($CR === 'Rural'){
                    $whereConditions[] = "NEW_SITES.CR LIKE '%-R'";
                    $matchIndicators[] = "NEW_SITES.CR";
                    }
                     else {
                        $whereConditions[] = "NEW_SITES.CR NOT LIKE '%-R'";
                        $matchIndicators[] = "NEW_SITES.CR";
                     }
                
                }
                if (!empty($_POST['priority']) && !in_array('', $_POST['priority'])) {
                    $priority = $_POST['priority'];
                   
                    $priorityList = "'" . implode("','", $priority) . "'";
                    $whereConditions[] = "NEW_SITES.TECHNICAL_PRIORITY IN ($priorityList)";
                    $matchIndicators[] = "NEW_SITES.TECHNICAL_PRIORITY";
                
                }
                if (!empty($_POST['sitestatus']) && !in_array('', $_POST['sitestatus'])) {
                    $sitestatus = $_POST['sitestatus']; // Assuming this is an array
                
                    // Convert the array to a comma-separated list of values
                    $sitestatusList = "'" . implode("','", $sitestatus) . "'";
                    $whereConditions[] = "FOUR_G_SITES.STATUS IN ($sitestatusList)";
                    $matchIndicators[] = "FOUR_G_SITES.STATUS AS \"4G_STATUS\"";
                }
                break;

                case '':
                    $joinConditions[] = "LEFT JOIN TWO_G_SITES ON NEW_SITES.ID = TWO_G_SITES.SITE_ID";
                    $joinConditions[] = "LEFT JOIN THREE_G_SITES ON NEW_SITES.ID = THREE_G_SITES.SITE_ID";
                    $joinConditions[] = "LEFT JOIN FOUR_G_SITES ON NEW_SITES.ID = FOUR_G_SITES.SID";
                    // $technologyFlags['2G'] = true;
                    // $technologyFlags['3G'] = true;
                    // $technologyFlags['LTE'] = true;
                    // Add match indicators for all technologies
                    $matchIndicators[] = "CASE WHEN TWO_G_SITES.SITE_ID IS NOT NULL THEN '2G' END AS TECHNOLOGY_2G";
                    $matchIndicators[] = "CASE WHEN THREE_G_SITES.SITE_ID IS NOT NULL THEN '3G' END AS TECHNOLOGY_3G";
                    $matchIndicators[] = "CASE WHEN FOUR_G_SITES.SID IS NOT NULL THEN 'LTE' END AS TECHNOLOGY_4G";
                    $matchIndicators[] = "TWO_G_SITES.TWOG_ON_AIR_DATE AS \"2G_ON_AIR_DATE\"";
                    $matchIndicators[] = "THREE_G_SITES.THREE_G_ON_AIR_DATE AS \"3G_ON_AIR_DATE\"";
                    $matchIndicators[] = "THREE_G_SITES.THREE_G_ON_AIR_DATE AS \"LTE_ON_AIR_DATE\"";
                    $whereConditions[] = "NEW_SITES.ID != 2775";
                
                    if (!empty($_POST['yearSelectStart']) && !empty($_POST['yearSelectEnd'])) {
                        $startDate = $_POST['yearSelectStart'];
                        $endDate = $_POST['yearSelectEnd'];
                
                    $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(NEW_SITES.SITE_ON_AIR_DATE,'MM/DD/YYYY')) BETWEEN $startYear AND $endYear";
                    }
                    else if (!empty($_POST['yearSelectStart'])) {
                        $startYear = $_POST['yearSelectStart'];
                        if (!empty($_POST['monthSelect'])){
                            $month = $_POST['monthSelect'];
                           
                            $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(NEW_SITES.SITE_ON_AIR_DATE,'MM/DD/YYYY')) = $startYear AND EXTRACT(MONTH FROM TO_DATE(NEW_SITES.SITE_ON_AIR_DATE,'MM/DD/YYYY')) = $month";
                           }
                           else{
                        $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(NEW_SITES.SITE_ON_AIR_DATE,'MM/DD/YYYY')) = $startYear";
                           }
                    
                    }
                    if (!empty($_POST['Zone']) || ($_POST['Zone'] !== '')) {
                        $zone = $_POST['Zone'];
                
                        $whereConditions[] = "NEW_SITES.ZONE = '$zone'";
                        $matchIndicators[] = "NEW_SITES.ZONE";
                    
                    }
                    if (!empty($_POST['vendor']) || ($_POST['vendor'] !== '')) {
                        $vendor = $_POST['vendor'];
                
                        $whereConditions[] = "NEW_SITES.SUPPLIER = '$vendor'";
                        $matchIndicators[] = "NEW_SITES.SUPPLIER";
                    
                    }
                    if (!empty($_POST['province']) && !in_array('', $_POST['province'])) {
                        $province = $_POST['province'];
    
                        $provinceList = "'" . implode("','", $province) . "'";
                        $whereConditions[] = "NEW_SITES.PROVINCE IN ($provinceList)";
                        $matchIndicators[] = "NEW_SITES.PROVINCE";
                
                    
                    }
                    if (!empty($_POST['C/R']) || ($_POST['C/R'] !== '')) {
                        $CR = $_POST['C/R'];
                        if($CR === 'Rural'){
                        $whereConditions[] = "NEW_SITES.CR LIKE '%-R'";
                        $matchIndicators[] = "NEW_SITES.CR";
                        }
                         else {
                            $whereConditions[] = "NEW_SITES.CR NOT LIKE '%-R'";
                            $matchIndicators[] = "NEW_SITES.CR";
                         }
                    
                    }
                    if (!empty($_POST['priority']) && !in_array('', $_POST['priority'])) {
                        $priority = $_POST['priority'];
                       
                        $priorityList = "'" . implode("','", $priority) . "'";
                        $whereConditions[] = "NEW_SITES.TECHNICAL_PRIORITY IN ($priorityList)";
                        $matchIndicators[] = "NEW_SITES.TECHNICAL_PRIORITY";
                    
                    }
                
                    if (!empty($_POST['sitestatus']) && !in_array('', $_POST['sitestatus'])) {
                        $sitestatus = $_POST['sitestatus']; // Assuming this is an array
                    
                        // Convert the array to a comma-separated list of values
                        $sitestatusList = "'" . implode("','", $sitestatus) . "'";
                        $whereConditions[] = "TWO_G_SITES.SITE_STATUS IN ($sitestatusList)
                                             AND FOUR_G_SITES.STATUS IN ($sitestatusList) 
                                             AND THREE_G_SITES.SITE_STATUS IN ($sitestatusList)";
                        $matchIndicators[] = "TWO_G_SITES.SITE_STATUS AS \"2G_STATUS\", FOUR_G_SITES.STATUS AS \"4G_STATUS\", THREE_G_SITES.SITE_STATUS AS \"3G_STATUS\"";
                    }
                
                    break;

                    case 'TWO_G_SITES1':
                        $joinConditions[] = "INNER JOIN TWO_G_SITES ON NEW_SITES.ID = TWO_G_SITES.SITE_ID";
                        $joinConditions[] = "LEFT JOIN THREE_G_SITES ON NEW_SITES.ID = THREE_G_SITES.SITE_ID";
                        $joinConditions[] = "LEFT JOIN FOUR_G_SITES ON NEW_SITES.ID = FOUR_G_SITES.SID";

                        $matchIndicators[] = "CASE WHEN TWO_G_SITES.SITE_ID IS NOT NULL AND THREE_G_SITES.SITE_ID IS NULL AND FOUR_G_SITES.SID IS NULL THEN '2G ONLY' END AS TECHNOLOGY_2G_ONLY";
                        $matchIndicators[] = "TWO_G_SITES.TWOG_ON_AIR_DATE AS \"2G_ON_AIR_DATE\"";
                        $whereConditions[] = " THREE_G_SITES.SITE_ID IS NULL AND FOUR_G_SITES.SID IS NULL";
                        $whereConditions[] = "NEW_SITES.ID != 2775";
                        if (!empty($_POST['yearSelectStart']) && !empty($_POST['yearSelectEnd'])) {
                            $startDate = $_POST['yearSelectStart'];
                            $endDate = $_POST['yearSelectEnd'];
        
                        $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE,'MM/DD/YYYY')) BETWEEN $startYear AND $endYear";
                        }
                        else if (!empty($_POST['yearSelectStart'])) {
                            $startYear = $_POST['yearSelectStart'];
                            if (!empty($_POST['monthSelect'])){
                                $month = $_POST['monthSelect'];
                               
                                $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE,'MM/DD/YYYY')) = $startYear AND EXTRACT(MONTH FROM TO_DATE(NEW_SITES.SITE_ON_AIR_DATE,'MM/DD/YYYY')) = $month";
                                $matchIndicators[] = "CASE WHEN TWO_G_SITES.SITE_ID IS NOT NULL THEN '2G'  END AS TECHNOLOGY_2G";
                               }
                               else{
                            $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE,'MM/DD/YYYY')) = $startYear";
                               }
                        
                        }
                         if (!empty($_POST['Zone'])|| ($_POST['Zone'] !== '')) {
                            $zone = $_POST['Zone'];
        
                            $whereConditions[] = "NEW_SITES.ZONE = '$zone'";
                            $matchIndicators[] = "NEW_SITES.ZONE";
                        
                        }
                        if (!empty($_POST['vendor']) || ($_POST['vendor'] !== '')) {
                            $vendor = $_POST['vendor'];
        
                            $whereConditions[] = "NEW_SITES.SUPPLIER = '$vendor'";
                            $matchIndicators[] = "NEW_SITES.SUPPLIER";
                        
                        }
                   if (!empty($_POST['province']) && !in_array('', $_POST['province'])) {
                    $province = $_POST['province'];

                    $provinceList = "'" . implode("','", $province) . "'";
                    $whereConditions[] = "NEW_SITES.PROVINCE IN ($provinceList)";
                    $matchIndicators[] = "NEW_SITES.PROVINCE";
            
                
                }
                        if (!empty($_POST['C/R']) || ($_POST['C/R'] !== '')) {
                            $CR = $_POST['C/R'];
                            if($CR === 'Rural'){
                            $whereConditions[] = "NEW_SITES.CR LIKE '%-R'";
                            $matchIndicators[] = "NEW_SITES.CR";
                            }
                             else {
                                $whereConditions[] = "NEW_SITES.CR NOT LIKE '%-R'";
                                $matchIndicators[] = "NEW_SITES.CR";
                             }
                        
                        }
                        if (!empty($_POST['priority']) && !in_array('', $_POST['priority'])) {
                            $priority = $_POST['priority'];
                           
                            $priorityList = "'" . implode("','", $priority) . "'";
                            $whereConditions[] = "NEW_SITES.TECHNICAL_PRIORITY IN ($priorityList)";
                            $matchIndicators[] = "NEW_SITES.TECHNICAL_PRIORITY";
                        
                        }
                        if (!empty($_POST['sitestatus']) && !in_array('', $_POST['sitestatus'])) {
                            $sitestatus = $_POST['sitestatus']; // Assuming this is an array
                        
                            // Convert the array to a comma-separated list of values
                            $sitestatusList = "'" . implode("','", $sitestatus) . "'";
                            $whereConditions[] = "TWO_G_SITES.SITE_STATUS IN ($sitestatusList)";
                            $matchIndicators[] = "TWO_G_SITES.SITE_STATUS AS \"2G_STATUS\"";
                        }
                        break;



                        case 'THREE_G_SITES1':
                            $joinConditions[] = "INNER JOIN THREE_G_SITES  ON NEW_SITES.ID = THREE_G_SITES.SITE_ID"; // Adjust join condition
                            $joinConditions[] = "LEFT JOIN TWO_G_SITES ON NEW_SITES.ID = TWO_G_SITES.SITE_ID";
                            $joinConditions[] = "LEFT JOIN FOUR_G_SITES ON NEW_SITES.ID = FOUR_G_SITES.SID";
                            $matchIndicators[] = "CASE WHEN TWO_G_SITES.SITE_ID IS NULL AND THREE_G_SITES.SITE_ID IS NOT NULL AND FOUR_G_SITES.SID IS NULL THEN '3G ONLY' END AS TECHNOLOGY_3G_ONLY";
                            $matchIndicators[] = "THREE_G_SITES.THREE_G_ON_AIR_DATE AS \"3G_ON_AIR_DATE\"";
                            $whereConditions[] = " TWO_G_SITES.SITE_ID IS NULL AND FOUR_G_SITES.SID IS NULL";
                            $whereConditions[] = "NEW_SITES.ID != 2775";
                            //$technologyFlags['3G'] = true;
                            if (!empty($_POST['yearSelectStart']) && !empty($_POST['yearSelectEnd'])) {
                                $startDate = $_POST['yearSelectStart'];
                                $endDate = $_POST['yearSelectEnd'];
            
                            $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(THREE_G_SITES.THREE_G_ON_AIR_DATE,'MM/DD/YYYY')) BETWEEN $startYear AND $endYear";
                            }
                            else if (!empty($_POST['yearSelectStart'])) {
                                $startYear = $_POST['yearSelectStart'];
                                if (!empty($_POST['monthSelect'])){
                                    $month = $_POST['monthSelect'];
                                   
                                    $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(THREE_G_SITES.THREE_G_ON_AIR_DATE,'MM/DD/YYYY')) = $startYear AND EXTRACT(MONTH FROM TO_DATE(THREE_G_SITES.THREE_G_ON_AIR_DATE,'MM/DD/YYYY')) = $month";
                                   }
                                   else{
                                $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(THREE_G_SITES.THREE_G_ON_AIR_DATE,'MM/DD/YYYY')) = $startYear";
                                   }
                            
                            }
                            if (!empty($_POST['Zone']) || ($_POST['Zone'] !== '')) {
                                $zone = $_POST['Zone'];
            
                                $whereConditions[] = "NEW_SITES.ZONE = '$zone'";
                                $matchIndicators[] = "NEW_SITES.ZONE";
                            
                            }
                            if (!empty($_POST['vendor']) || ($_POST['vendor'] !== '')) {
                                $vendor = $_POST['vendor'];
            
                                $whereConditions[] = "NEW_SITES.SUPPLIER = '$vendor'";
                                $matchIndicators[] = "NEW_SITES.SUPPLIER";
                            
                            }
                            if (!empty($_POST['province']) && !in_array('', $_POST['province'])) {
                                $province = $_POST['province'];
            
                                $provinceList = "'" . implode("','", $province) . "'";
                                $whereConditions[] = "NEW_SITES.PROVINCE IN ($provinceList)";
                                $matchIndicators[] = "NEW_SITES.PROVINCE";
                        
                            
                            }
                            if (!empty($_POST['C/R']) || ($_POST['C/R'] !== '')) {
                                $CR = $_POST['C/R'];
                                if($CR === 'Rural'){
                                $whereConditions[] = "NEW_SITES.CR LIKE '%-R'";
                                $matchIndicators[] = "NEW_SITES.CR";
                                }
                                 else {
                                    $whereConditions[] = "NEW_SITES.CR NOT LIKE '%-R'";
                                    $matchIndicators[] = "NEW_SITES.CR";
                                 }
                            
                            }
                            if (!empty($_POST['priority']) && !in_array('', $_POST['priority'])) {
                                $priority = $_POST['priority'];
                               
                                $priorityList = "'" . implode("','", $priority) . "'";
                                $whereConditions[] = "NEW_SITES.TECHNICAL_PRIORITY IN ($priorityList)";
                                $matchIndicators[] = "NEW_SITES.TECHNICAL_PRIORITY";
                            
                            }
                            if (!empty($_POST['sitestatus']) && !in_array('', $_POST['sitestatus'])) {
                                $sitestatus = $_POST['sitestatus']; // Assuming this is an array
                            
                                // Convert the array to a comma-separated list of values
                                $sitestatusList = "'" . implode("','", $sitestatus) . "'";
                                $whereConditions[] = "THREE_G_SITES.SITE_STATUS IN ($sitestatusList)";
                                $matchIndicators[] = "THREE_G_SITES.SITE_STATUS AS \"3G_STATUS\"";
                            }
                            break;


                            case 'FOUR_G_SITES1':
                                $joinConditions[] = "INNER JOIN FOUR_G_SITES ON NEW_SITES.ID = FOUR_G_SITES.SID"; // Adjust join condition
                                $joinConditions[] = "LEFT JOIN TWO_G_SITES ON NEW_SITES.ID = TWO_G_SITES.SITE_ID";
                                $joinConditions[] = "LEFT JOIN THREE_G_SITES ON NEW_SITES.ID = THREE_G_SITES.SITE_ID";
                                $matchIndicators[] = "CASE WHEN TWO_G_SITES.SITE_ID IS NULL AND THREE_G_SITES.SITE_ID IS NULL AND FOUR_G_SITES.SID IS NOT  NULL THEN '4G ONLY' END AS TECHNOLOGY_4G_ONLY";
                                $matchIndicators[] = "FOUR_G_SITES.ACTIVATION_DATE AS \"LTE_ON_AIR_DATE\"";
                                $whereConditions[] = " TWO_G_SITES.SITE_ID IS NULL AND THREE_G_SITES.SITE_ID IS NULL";
                                $whereConditions[] = "NEW_SITES.ID != 2775";
                                //$technologyFlags['LTE'] = true;
                                if (!empty($_POST['yearSelectStart']) && !empty($_POST['yearSelectEnd'])) {
                                    $startYear = $_POST['yearSelectStart'];
                                    $endYear = $_POST['yearSelectEnd'];
                
                                $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(FOUR_G_SITES.ACTIVATION_DATE,'MM/DD/YYYY')) BETWEEN $startYear AND $endYear";
                                }
                                else if (!empty($_POST['yearSelectStart'])) {
                                    $startYear = $_POST['yearSelectStart'];
                                    if (!empty($_POST['monthSelect'])){
                                        $month = $_POST['monthSelect'];
                                       
                                        $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(FOUR_G_SITES.ACTIVATION_DATE,'MM/DD/YYYY')) = $startYear AND EXTRACT(MONTH FROM TO_DATE(FOUR_G_SITES.ACTIVATION_DATE,'MM/DD/YYYY')) = $month";
                                       }
                                       else{
                                    $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(FOUR_G_SITES.ACTIVATION_DATE,'MM/DD/YYYY')) = $startYear";
                                       }
                                
                                }
                                if (!empty($_POST['Zone']) || ($_POST['Zone'] !== '')) {
                                    $zone = $_POST['Zone'];
                
                                    $whereConditions[] = "NEW_SITES.ZONE = '$zone'";
                                    $matchIndicators[] = "NEW_SITES.ZONE";
                                
                                }
                                if (!empty($_POST['vendor']) || ($_POST['vendor'] !== '')) {
                                    $vendor = $_POST['vendor'];
                
                                    $whereConditions[] = "NEW_SITES.SUPPLIER = '$vendor'";
                                    $matchIndicators[] = "NEW_SITES.SUPPLIER";
                                
                                }
                                if (!empty($_POST['province']) && !in_array('', $_POST['province'])) {
                                    $province = $_POST['province'];
                
                                    $provinceList = "'" . implode("','", $province) . "'";
                                    $whereConditions[] = "NEW_SITES.PROVINCE IN ($provinceList)";
                                    $matchIndicators[] = "NEW_SITES.PROVINCE";
                            
                                
                                }
                                if (!empty($_POST['C/R']) || ($_POST['C/R'] !== '')) {
                                    $CR = $_POST['C/R'];
                                    if($CR === 'Rural'){
                                    $whereConditions[] = "NEW_SITES.CR LIKE '%-R'";
                                    $matchIndicators[] = "NEW_SITES.CR";
                                    }
                                     else {
                                        $whereConditions[] = "NEW_SITES.CR NOT LIKE '%-R'";
                                        $matchIndicators[] = "NEW_SITES.CR";
                                     }
                                
                                }
                                if (!empty($_POST['priority']) && !in_array('', $_POST['priority'])) {
                                    $priority = $_POST['priority'];
                                   
                                    $priorityList = "'" . implode("','", $priority) . "'";
                                    $whereConditions[] = "NEW_SITES.TECHNICAL_PRIORITY IN ($priorityList)";
                                    $matchIndicators[] = "NEW_SITES.TECHNICAL_PRIORITY";
                                
                                }
                                if (!empty($_POST['sitestatus']) && !in_array('', $_POST['sitestatus'])) {
                                    $sitestatus = $_POST['sitestatus']; // Assuming this is an array
                                
                                    // Convert the array to a comma-separated list of values
                                    $sitestatusList = "'" . implode("','", $sitestatus) . "'";
                                    $whereConditions[] = "FOUR_G_SITES.STATUS IN ($sitestatusList)";
                                    $matchIndicators[] = "FOUR_G_SITES.STATUS AS \"4G_STATUS\"";
                                }
                                break;


                                        case 'TWO_THREE':
                                            $joinConditions[] = "LEFT JOIN FOUR_G_SITES ON NEW_SITES.ID = FOUR_G_SITES.SID"; // Adjust join condition
                                            $joinConditions[] = "INNER JOIN TWO_G_SITES ON NEW_SITES.ID = TWO_G_SITES.SITE_ID";
                                            $joinConditions[] = "INNER JOIN THREE_G_SITES ON NEW_SITES.ID = THREE_G_SITES.SITE_ID";
                                            $matchIndicators[] = "CASE WHEN TWO_G_SITES.SITE_ID IS NOT NULL THEN '2G' END AS TECHNOLOGY_2G";
                                            $matchIndicators[] = "CASE WHEN THREE_G_SITES.SITE_ID IS NOT NULL THEN '3G' END AS TECHNOLOGY_3G";
                                            $matchIndicators[] = "CASE WHEN FOUR_G_SITES.SID IS NOT NULL THEN 'LTE' END AS TECHNOLOGY_4G";
                                            $matchIndicators[] = "TWO_G_SITES.TWOG_ON_AIR_DATE AS \"2G_ON_AIR_DATE\"";
                                            $matchIndicators[] = "THREE_G_SITES.THREE_G_ON_AIR_DATE AS \"3G_ON_AIR_DATE\"";
                                             $whereConditions[] = "TWO_G_SITES.SITE_ID IS NOT NULL AND THREE_G_SITES.SITE_ID IS NOT NULL AND FOUR_G_SITES.SID IS NULL";
                                             $whereConditions[] = "NEW_SITES.ID != 2775";
                                            //$technologyFlags['LTE'] = true;
                                            if (!empty($_POST['yearSelectStart']) && !empty($_POST['yearSelectEnd'])) {
                                                $startYear = $_POST['yearSelectStart'];
                                                $endYear = $_POST['yearSelectEnd'];
                            
                                            $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE,'MM/DD/YYYY')) BETWEEN $startYear AND $endYear
                                                              AND EXTRACT(YEAR FROM TO_DATE(THREE_G_SITES.THREE_G_ON_AIR_DATE, 'MM/DD/YYYY')) BETWEEN $startYear AND $endYear";
                                            }
                                            else if (!empty($_POST['yearSelectStart'])) {
                                                $startYear = $_POST['yearSelectStart'];
                                                if (!empty($_POST['monthSelect'])){
                                                    $month = $_POST['monthSelect'];
                                                   
                                                   // $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE,'MM/DD/YYYY') && THREE_G_SITES.THREE_G_ON_AIR_DATE,'MM/DD/YYYY')) = $startYear AND EXTRACT(MONTH FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE,'MM/DD/YYYY')  && THREE_G_SITES.THREE_G_ON_AIR_DATE,'MM/DD/YYYY')) = $month";
                                                 
                                                
                                                $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE, 'MM/DD/YYYY')) = $startYear 
                                                AND EXTRACT(YEAR FROM TO_DATE(THREE_G_SITES.THREE_G_ON_AIR_DATE, 'MM/DD/YYYY')) = $startYear 
                                                AND EXTRACT(MONTH FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE, 'MM/DD/YYYY')) = $month 
                                                AND EXTRACT(MONTH FROM TO_DATE(THREE_G_SITES.THREE_G_ON_AIR_DATE, 'MM/DD/YYYY')) = $month";
                                                
                                                }
                                                   else{
                                                $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE,'MM/DD/YYYY')) = $startYear
                                                                  AND EXTRACT(YEAR FROM TO_DATE(THREE_G_SITES.THREE_G_ON_AIR_DATE, 'MM/DD/YYYY')) = $startYear ";
                                                   }
                                            
                                            }
                                            if (!empty($_POST['Zone']) || ($_POST['Zone'] !== '')) {
                                                $zone = $_POST['Zone'];
                            
                                                $whereConditions[] = "NEW_SITES.ZONE = '$zone'";
                                                $matchIndicators[] = "NEW_SITES.ZONE";
                                            
                                            }
                                            if (!empty($_POST['vendor']) || ($_POST['vendor'] !== '')) {
                                                $vendor = $_POST['vendor'];
                            
                                                $whereConditions[] = "NEW_SITES.SUPPLIER = '$vendor'";
                                                $matchIndicators[] = "NEW_SITES.SUPPLIER";
                                            
                                            }
                                            if (!empty($_POST['province']) && !in_array('', $_POST['province'])) {
                                                $province = $_POST['province'];
                            
                                                $provinceList = "'" . implode("','", $province) . "'";
                                                $whereConditions[] = "NEW_SITES.PROVINCE IN ($provinceList)";
                                                $matchIndicators[] = "NEW_SITES.PROVINCE";
                                        
                                            
                                            }
                                            if (!empty($_POST['C/R']) || ($_POST['C/R'] !== '')) {
                                                $CR = $_POST['C/R'];
                                                if($CR === 'Rural'){
                                                $whereConditions[] = "NEW_SITES.CR LIKE '%-R'";
                                                $matchIndicators[] = "NEW_SITES.CR";
                                                }
                                                 else {
                                                    $whereConditions[] = "NEW_SITES.CR NOT LIKE '%-R'";
                                                    $matchIndicators[] = "NEW_SITES.CR";
                                                 }
                                            
                                            }
                                            if (!empty($_POST['priority']) && !in_array('', $_POST['priority'])) {
                                                $priority = $_POST['priority'];
                                               
                                                $priorityList = "'" . implode("','", $priority) . "'";
                                                $whereConditions[] = "NEW_SITES.TECHNICAL_PRIORITY IN ($priorityList)";
                                                $matchIndicators[] = "NEW_SITES.TECHNICAL_PRIORITY";
                                            
                                            }
                                            if (!empty($_POST['sitestatus']) && !in_array('', $_POST['sitestatus'])) {
                                                $sitestatus = $_POST['sitestatus']; // Assuming this is an array
                                            
                                                // Convert the array to a comma-separated list of values
                                                $sitestatusList = "'" . implode("','", $sitestatus) . "'";
                                                $whereConditions[] = "TWO_G_SITES.SITE_STATUS IN ($sitestatusList)
                                                                AND THREE_G_SITES.SITE_STATUS IN ($sitestatusList)";
                                             $matchIndicators[] = "TWO_G_SITES.SITE_STATUS AS \"2G_STATUS\", THREE_G_SITES.SITE_STATUS AS \"3G_STATUS\"";

                                            }
                                            break;




                                            case 'TWO_FOUR':
                                                $joinConditions[] = "INNER JOIN FOUR_G_SITES ON NEW_SITES.ID = FOUR_G_SITES.SID"; // Adjust join condition
                                                $joinConditions[] = "INNER JOIN TWO_G_SITES ON NEW_SITES.ID = TWO_G_SITES.SITE_ID";
                                                $joinConditions[] = "LEFT JOIN THREE_G_SITES ON NEW_SITES.ID = THREE_G_SITES.SITE_ID";
                                                $matchIndicators[] = "CASE WHEN TWO_G_SITES.SITE_ID IS NOT NULL THEN '2G' END AS TECHNOLOGY_2G";
                                                $matchIndicators[] = "CASE WHEN THREE_G_SITES.SITE_ID IS NOT NULL THEN '3G' END AS TECHNOLOGY_3G";
                                                $matchIndicators[] = "CASE WHEN FOUR_G_SITES.SID IS NOT NULL THEN 'LTE' END AS TECHNOLOGY_4G";
                                                $matchIndicators[] = "TWO_G_SITES.TWOG_ON_AIR_DATE AS \"2G_ON_AIR_DATE\"";
                                                $matchIndicators[] = "FOUR_G_SITES.ACTIVATION_DATE AS \"LTE_ON_AIR_DATE\"";
                                                $whereConditions[] = " TWO_G_SITES.SITE_ID IS NOT NULL AND THREE_G_SITES.SITE_ID IS NULL AND FOUR_G_SITES.SID IS NOT NULL";
                                                $whereConditions[] = "NEW_SITES.ID != 2775";
                                                //$technologyFlags['LTE'] = true;
                                                if (!empty($_POST['yearSelectStart']) && !empty($_POST['yearSelectEnd'])) {
                                                    $startYear = $_POST['yearSelectStart'];
                                                    $endYear = $_POST['yearSelectEnd'];
                                
                                                $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE,'MM/DD/YYYY')) BETWEEN $startYear AND $endYear
                                                                  AND EXTRACT(YEAR FROM TO_DATE(FOUR_G_SITES.ACTIVATION_DATE, 'MM/DD/YYYY')) BETWEEN $startYear AND $endYear";


                                                }
                                                else if (!empty($_POST['yearSelectStart'])) {
                                                    $startYear = $_POST['yearSelectStart'];
                                                    if (!empty($_POST['monthSelect'])){
                                                        $month = $_POST['monthSelect'];
                                                       
                                                       // $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE,'MM/DD/YYYY') && THREE_G_SITES.THREE_G_ON_AIR_DATE,'MM/DD/YYYY')) = $startYear AND EXTRACT(MONTH FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE,'MM/DD/YYYY')  && THREE_G_SITES.THREE_G_ON_AIR_DATE,'MM/DD/YYYY')) = $month";
                                                     
                                                    
                                                    $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE, 'MM/DD/YYYY')) = $startYear 
                                                    AND EXTRACT(YEAR FROM TO_DATE(FOUR_G_SITES.ACTIVATION_DATE, 'MM/DD/YYYY')) = $startYear 
                                                    AND EXTRACT(MONTH FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE, 'MM/DD/YYYY')) = $month 
                                                    AND EXTRACT(MONTH FROM TO_DATE(FOUR_G_SITES.ACTIVATION_DATE, 'MM/DD/YYYY')) = $month";
                                                    
                                                    }
                                                       else{
                                                    $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE,'MM/DD/YYYY')) = $startYear
                                                                      AND EXTRACT(YEAR FROM TO_DATE(FOUR_G_SITES.ACTIVATION_DATE, 'MM/DD/YYYY')) = $startYear ";
                                                       }
                                                
                                                }
                                                if (!empty($_POST['Zone']) || ($_POST['Zone'] !== '')) {
                                                    $zone = $_POST['Zone'];
                                
                                                    $whereConditions[] = "NEW_SITES.ZONE = '$zone'";
                                                    $matchIndicators[] = "NEW_SITES.ZONE";
                                                
                                                }
                                                if (!empty($_POST['vendor']) || ($_POST['vendor'] !== '')) {
                                                    $vendor = $_POST['vendor'];
                                
                                                    $whereConditions[] = "NEW_SITES.SUPPLIER = '$vendor'";
                                                    $matchIndicators[] = "NEW_SITES.SUPPLIER";
                                                
                                                }
                                                if (!empty($_POST['province']) && !in_array('', $_POST['province'])) {
                                                    $province = $_POST['province'];
                                
                                                    $provinceList = "'" . implode("','", $province) . "'";
                                                    $whereConditions[] = "NEW_SITES.PROVINCE IN ($provinceList)";
                                                    $matchIndicators[] = "NEW_SITES.PROVINCE";
                                            
                                                
                                                }
                                                if (!empty($_POST['C/R']) || ($_POST['C/R'] !== '')) {
                                                    $CR = $_POST['C/R'];
                                                    if($CR === 'Rural'){
                                                    $whereConditions[] = "NEW_SITES.CR LIKE '%-R'";
                                                    $matchIndicators[] = "NEW_SITES.CR";
                                                    }
                                                     else {
                                                        $whereConditions[] = "NEW_SITES.CR NOT LIKE '%-R'";
                                                        $matchIndicators[] = "NEW_SITES.CR";
                                                     }
                                                
                                                }
                                                if (!empty($_POST['priority']) && !in_array('', $_POST['priority'])) {
                                                    $priority = $_POST['priority'];
                                                   
                                                    $priorityList = "'" . implode("','", $priority) . "'";
                                                    $whereConditions[] = "NEW_SITES.TECHNICAL_PRIORITY IN ($priorityList)";
                                                    $matchIndicators[] = "NEW_SITES.TECHNICAL_PRIORITY";
                                                
                                                }
                                                if (!empty($_POST['sitestatus']) && !in_array('', $_POST['sitestatus'])) {
                                                    $sitestatus = $_POST['sitestatus']; // Assuming this is an array
                                                
                                                    // Convert the array to a comma-separated list of values
                                                    $sitestatusList = "'" . implode("','", $sitestatus) . "'";
                                                    $whereConditions[] = "TWO_G_SITES.SITE_STATUS IN ($sitestatusList)
                                                                          AND FOUR_G_SITES.STATUS IN ($sitestatusList)";
                                                    $matchIndicators[] = "TWO_G_SITES.SITE_STATUS AS \"2G_STATUS\", FOUR_G_SITES.STATUS AS \"4G_STATUS\"";
                                                }
                                                break;

                                                case 'THREE_FOUR':
                                                    $joinConditions[] = "INNER JOIN FOUR_G_SITES ON NEW_SITES.ID = FOUR_G_SITES.SID"; // Adjust join condition
                                                    $joinConditions[] = "LEFT JOIN TWO_G_SITES ON NEW_SITES.ID = TWO_G_SITES.SITE_ID";
                                                    $joinConditions[] = "INNER JOIN THREE_G_SITES ON NEW_SITES.ID = THREE_G_SITES.SITE_ID";
                                                    $matchIndicators[] = "CASE WHEN TWO_G_SITES.SITE_ID IS NOT NULL THEN '2G' END AS TECHNOLOGY_2G";
                                                    $matchIndicators[] = "CASE WHEN THREE_G_SITES.SITE_ID IS NOT NULL THEN '3G' END AS TECHNOLOGY_3G";
                                                    $matchIndicators[] = "CASE WHEN FOUR_G_SITES.SID IS NOT NULL THEN 'LTE' END AS TECHNOLOGY_4G";
                                                    $matchIndicators[] = "THREE_G_SITES.THREE_G_ON_AIR_DATE AS \"3G_ON_AIR_DATE\"";
                                                    $matchIndicators[] = "FOUR_G_SITES.ACTIVATION_DATE AS \"LTE_ON_AIR_DATE\"";
                                                    $whereConditions[] = " TWO_G_SITES.SITE_ID IS NULL AND THREE_G_SITES.SITE_ID IS NOT NULL AND FOUR_G_SITES.SID IS NOT NULL";
                                                    $whereConditions[] = "NEW_SITES.ID != 2775";
                                                    //$technologyFlags['LTE'] = true;
                                                    if (!empty($_POST['yearSelectStart']) && !empty($_POST['yearSelectEnd'])) {
                                                        $startYear = $_POST['yearSelectStart'];
                                                        $endYear = $_POST['yearSelectEnd'];
                                    
                                                    $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(THREE_G_SITES.THREE_G_ON_AIR_DATE,'MM/DD/YYYY')) BETWEEN $startYear AND $endYear
                                                                      AND EXTRACT(YEAR FROM TO_DATE(FOUR_G_SITES.ACTIVATION_DATE, 'MM/DD/YYYY')) BETWEEN $startYear AND $endYear";
    
    
                                                    }
                                                    else if (!empty($_POST['yearSelectStart'])) {
                                                        $startYear = $_POST['yearSelectStart'];
                                                        if (!empty($_POST['monthSelect'])){
                                                            $month = $_POST['monthSelect'];
                                                           
                                                           // $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE,'MM/DD/YYYY') && THREE_G_SITES.THREE_G_ON_AIR_DATE,'MM/DD/YYYY')) = $startYear AND EXTRACT(MONTH FROM TO_DATE(TWO_G_SITES.TWOG_ON_AIR_DATE,'MM/DD/YYYY')  && THREE_G_SITES.THREE_G_ON_AIR_DATE,'MM/DD/YYYY')) = $month";
                                                         
                                                        
                                                        $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(THREE_G_SITES.THREE_G_ON_AIR_DATE, 'MM/DD/YYYY')) = $startYear 
                                                        AND EXTRACT(YEAR FROM TO_DATE(FOUR_G_SITES.ACTIVATION_DATE, 'MM/DD/YYYY')) = $startYear 
                                                        AND EXTRACT(MONTH FROM TO_DATE(THREE_G_SITES.THREE_G_ON_AIR_DATE, 'MM/DD/YYYY')) = $month 
                                                        AND EXTRACT(MONTH FROM TO_DATE(FOUR_G_SITES.ACTIVATION_DATE, 'MM/DD/YYYY')) = $month";
                                                        
                                                        }
                                                           else{
                                                        $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(THREE_G_SITES.THREE_G_ON_AIR_DATE,'MM/DD/YYYY')) = $startYear
                                                                          AND EXTRACT(YEAR FROM TO_DATE(FOUR_G_SITES.ACTIVATION_DATE, 'MM/DD/YYYY')) = $startYear ";
                                                           }
                                                    
                                                    }
                                                    if (!empty($_POST['Zone']) || ($_POST['Zone'] !== '')) {
                                                        $zone = $_POST['Zone'];
                                    
                                                        $whereConditions[] = "NEW_SITES.ZONE = '$zone'";
                                                        $matchIndicators[] = "NEW_SITES.ZONE";
                                                    
                                                    }
                                                    if (!empty($_POST['vendor']) || ($_POST['vendor'] !== '')) {
                                                        $vendor = $_POST['vendor'];
                                    
                                                        $whereConditions[] = "NEW_SITES.SUPPLIER = '$vendor'";
                                                        $matchIndicators[] = "NEW_SITES.SUPPLIER";
                                                    
                                                    }
                                                    if (!empty($_POST['province']) && !in_array('', $_POST['province'])) {
                                                        $province = $_POST['province'];
                                    
                                                        $provinceList = "'" . implode("','", $province) . "'";
                                                        $whereConditions[] = "NEW_SITES.PROVINCE IN ($provinceList)";
                                                        $matchIndicators[] = "NEW_SITES.PROVINCE";
                                                
                                                    
                                                    }
                                                    if (!empty($_POST['C/R']) || ($_POST['C/R'] !== '')) {
                                                        $CR = $_POST['C/R'];
                                                        if($CR === 'Rural'){
                                                        $whereConditions[] = "NEW_SITES.CR LIKE '%-R'";
                                                        $matchIndicators[] = "NEW_SITES.CR";
                                                        }
                                                         else {
                                                            $whereConditions[] = "NEW_SITES.CR NOT LIKE '%-R'";
                                                            $matchIndicators[] = "NEW_SITES.CR";
                                                         }
                                                    
                                                    }
                                                    if (!empty($_POST['priority']) && !in_array('', $_POST['priority'])) {
                                                        $priority = $_POST['priority'];
                                                       
                                                        $priorityList = "'" . implode("','", $priority) . "'";
                                                        $whereConditions[] = "NEW_SITES.TECHNICAL_PRIORITY IN ($priorityList)";
                                                        $matchIndicators[] = "NEW_SITES.TECHNICAL_PRIORITY";
                                                    
                                                    }
                                                    if (!empty($_POST['sitestatus']) && !in_array('', $_POST['sitestatus'])) {
                                                        $sitestatus = $_POST['sitestatus']; // Assuming this is an array
                                                    
                                                        // Convert the array to a comma-separated list of values
                                                        $sitestatusList = "'" . implode("','", $sitestatus) . "'";
                                                        $whereConditions[] = "THREE_G_SITES.SITE_STATUS IN ($sitestatusList)
                                                                              AND FOUR_G_SITES.STATUS IN ($sitestatusList)";
                                                        $matchIndicators[] = "FOUR_G_SITES.STATUS AS \"4G_STATUS\", THREE_G_SITES.SITE_STATUS AS \"3G_STATUS\"";
                                                    }
                                                    break;
    


                default:
                echo "Invalid table selected.";
                exit;
        }
    }
}



else {
    // If no tables are selected, retrieve data from all tables with LEFT JOINs
    $joinConditions[] = "LEFT JOIN TWO_G_SITES ON NEW_SITES.ID = TWO_G_SITES.SITE_ID";
    $joinConditions[] = "LEFT JOIN THREE_G_SITES ON NEW_SITES.ID = THREE_G_SITES.SITE_ID";
    $joinConditions[] = "LEFT JOIN FOUR_G_SITES ON NEW_SITES.ID = FOUR_G_SITES.SID";
    $matchIndicators[] = "CASE WHEN TWO_G_SITES.SITE_ID IS NOT NULL THEN '2G' END AS TECHNOLOGY_2G";
    $matchIndicators[] = "CASE WHEN THREE_G_SITES.SITE_ID IS NOT NULL THEN '3G' END AS TECHNOLOGY_3G";
    $matchIndicators[] = "CASE WHEN FOUR_G_SITES.SID IS NOT NULL THEN 'LTE' END AS TECHNOLOGY_4G";
    $matchIndicators[] = "TWO_G_SITES.TWOG_ON_AIR_DATE AS \"2G_ON_AIR_DATE\"";
    $matchIndicators[] = "THREE_G_SITES.THREE_G_ON_AIR_DATE AS \"3G_ON_AIR_DATE\"";
    $matchIndicators[] = "FOUR_G_SITES.ACTIVATION_DATE AS \"LTE_ON_AIR_DATE\"";
    $whereConditions[] = "NEW_SITES.ID != 2775";

    if (!empty($_POST['yearSelectStart']) && !empty($_POST['yearSelectEnd'])) {
        $startDate = $_POST['yearSelectStart'];
        $endDate = $_POST['yearSelectEnd'];

    $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(NEW_SITES.SITE_ON_AIR_DATE,'MM/DD/YYYY')) BETWEEN $startYear AND $endYear";
    }
    else if (!empty($_POST['yearSelectStart'])) {
        $startYear = $_POST['yearSelectStart'];
        if (!empty($_POST['monthSelect'])){
            $month = $_POST['monthSelect'];
           
            $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(NEW_SITES.SITE_ON_AIR_DATE,'MM/DD/YYYY')) = $startYear AND EXTRACT(MONTH FROM TO_DATE(NEW_SITES.SITE_ON_AIR_DATE,'MM/DD/YYYY')) = $month";
           }
           else{
        $whereConditions[] = "EXTRACT(YEAR FROM TO_DATE(NEW_SITES.SITE_ON_AIR_DATE,'MM/DD/YYYY')) = $startYear";
           }
    
    }
    if (!empty($_POST['Zone']) || ($_POST['Zone'] !== '')) {
        $zone = $_POST['Zone'];

        $whereConditions[] = "NEW_SITES.ZONE = '$zone'";
        $matchIndicators[] = "NEW_SITES.ZONE";
    
    }
    if (!empty($_POST['vendor']) || ($_POST['vendor'] !== '')) {
        $vendor = $_POST['vendor'];

        $whereConditions[] = "NEW_SITES.SUPPLIER = '$vendor'";
        $matchIndicators[] = "NEW_SITES.SUPPLIER";
    
    }
    if (!empty($_POST['province']) && !in_array('', $_POST['province'])) {
        $province = $_POST['province'];

        $provinceList = "'" . implode("','", $province) . "'";
        $whereConditions[] = "NEW_SITES.PROVINCE IN ($provinceList)";
        $matchIndicators[] = "NEW_SITES.PROVINCE";

    
    }
    if (!empty($_POST['C/R']) || ($_POST['C/R'] !== '')) {
        $CR = $_POST['C/R'];
        if($CR === 'Rural'){
        $whereConditions[] = "NEW_SITES.CR LIKE '%-R'";
        $matchIndicators[] = "NEW_SITES.CR";
        }
         else {
            $whereConditions[] = "NEW_SITES.CR NOT LIKE '%-R'";
            $matchIndicators[] = "NEW_SITES.CR";
         }
    
    }
    if (!empty($_POST['priority']) && !in_array('', $_POST['priority'])) {
        $priority = $_POST['priority'];
       
        $priorityList = "'" . implode("','", $priority) . "'";
        $whereConditions[] = "NEW_SITES.TECHNICAL_PRIORITY IN ($priorityList)";
        $matchIndicators[] = "NEW_SITES.TECHNICAL_PRIORITY";
    
    }

    if (!empty($_POST['sitestatus']) && !in_array('', $_POST['sitestatus'])) {
        $sitestatus = $_POST['sitestatus']; // Assuming this is an array
    
        // Convert the array to a comma-separated list of values
        $sitestatusList = "'" . implode("','", $sitestatus) . "'";
        $whereConditions[] = "TWO_G_SITES.SITE_STATUS IN ($sitestatusList) AND FOUR_G_SITES.STATUS IN ($sitestatusList) AND THREE_G_SITES.SITE_STATUS IN ($sitestatusList)";
        $matchIndicators[] = "TWO_G_SITES.SITE_STATUS AS \"2G_STATUS\", FOUR_G_SITES.STATUS AS \"4G_STATUS\", THREE_G_SITES.SITE_STATUS AS \"3G_STATUS\"";
    }

}
if (!empty($matchIndicators)){
    $sql = "SELECT NEW_SITES.SITE_CODE ,NEW_SITES.PROVINCE ,NEW_SITES.SUPPLIER ,NEW_SITES.SITE_ON_AIR_DATE,"; 
}


if (!empty($joinConditions)) {
    $sql .= implode(", ", $matchIndicators) . " FROM NEW_SITES " . implode(" ", $joinConditions);
} else {
    $sql .= "FROM NEW_SITES"; // No additional tables selected
}
if (!empty($whereConditions)) {
    $sql .= " WHERE " . implode(" AND ", $whereConditions);
}

$countSql = "SELECT COUNT(*) AS TotalCount FROM (" . $sql . ")";
// Prepare and execute the statement
$stmt = oci_parse($conn, $sql);

oci_execute($stmt);
//echo $sql;

$stmt1 = oci_parse($conn, $countSql);

oci_execute($stmt1);

//Fetch results
   
// echo "<table border='1'>";
// echo "<tr><th>SITE CODE</th><th>TECHNOLOGY</th></tr>";

while ($row = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) {
    // Display the results

 
    $technologyValue = [];
    if (!empty($row['TECHNOLOGY_2G'])) {
        $technologyValue[] = '2G';
    }
     if (!empty($row['TECHNOLOGY_3G'])) {
        $technologyValue[] = '3G';
    }
     if (!empty($row['TECHNOLOGY_4G']) ) {
        $technologyValue[] = 'LTE';
    }
    if (!empty($row['TECHNOLOGY_2G_ONLY'])) {
        $technologyValue[] = '2G ONLY';
    }
    if (!empty($row['TECHNOLOGY_3G_ONLY'])) {
        $technologyValue[] = '3G ONLY';
    }
    if (!empty($row['TECHNOLOGY_4G_ONLY'])) {
        $technologyValue[] = '4G ONLY';
    }
    if (empty($technologyValue)) {
        //echo "No technology found for this row.<br>";
    } else {
        $row['TECHNOLOG'] = implode('-', $technologyValue);
      
    }
    $results[] = $row;
    foreach ($results as $row) {
        // echo "<pre>";
        // print_r($row);
        // echo "</pre>";
    }
 
}
while ($row1 = oci_fetch_array($stmt1, OCI_ASSOC+OCI_RETURN_NULLS)){
    $results1[] = $row1;
// foreach ($results1 as $row1) {
//     echo "<pre>";
//     print_r($row1);
//     echo "</pre>";
// }
}
//echo "</table>";
// Free statement and close the connection
oci_free_statement($stmt);
oci_free_statement($stmt1);
oci_close($conn);

}
?>
<!DOCTYPE html>
<html lang="en">
<html>
<head>
    
<meta charset="UTF-8" />
    <title>Advanced Search Page</title>
    <!-- Include Font Awesome for icons (optional) -->
    <link rel="stylesheet" href="fontawesome-free-6.5.2-web/css/all.min.css">
    <!-- Meta tag for responsiveness -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include your CSS styles -->


    <style>


    .btn-primary {
      background-color: #1c355c;
      border-color: #1c355c;
      transition: background-color 0.3s, transform 0.3s;
    }

    .btn-primary:hover {
      background-color: #0056b3;
      transform: translateY(-2px);
    }
        /* Reset some default styles */
        body, h1, h3, h4, p, select, input {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: goldenrod;
            /* background-image: url('img.jpg'); */
            padding: 50px;
            color: #1c355c;
        }

        /* Container Styles */
        .container {
            max-width: max-content;
            margin: auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Header Styles */
        .header {
            background-color: #1c355c;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            color: white;
            font-size: 2em;
        }

        /* Filter Form Styles */
        .form1 {
            padding: 15px;
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

.filter select:focus,
.filter input[type="text"]:focus,
.filter input[type="number"]:focus {
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
        /* Submit Button Styles */
        .submit {
            text-align: center;
            margin-top: 20px;
        }

        input[type="submit"] {
            background-color: #1c355c;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Results Section Styles */
        .results-section {
            padding: 20px;
        }

        .results-section table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .results-section th, .results-section td {
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            text-align: left;
            color: #1c355c;
        }

        .results-section th {
            background-color: #1c355c;
            color: white;
            
           
           
        }

        .results-section tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .results-section tr:hover {
            background-color: #e9ecef;
        }

        .results-section p {
            text-align: center;
            font-size: 18px;
            color: #6c757d;
        }

        /* Error Message Styles */
        .error {
            color: red;
            text-align: center;
            padding: 10px;
        }

        /* Footer Styles */
        .footer {
            background: #1c355c;
            padding: 15px;
            text-align: center;
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .filter div {
                flex: 1 0.5 100%;
            }

            .field{
    background-color:#e1e6ed;
    
}

.table-wrapper table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

table {
    border-collapse: collapse;
}

/* Table Styles */
.table-wrapper {
    width: 100%;
    overflow-x: auto; /* Enables horizontal scrolling on small screens */
    border-collapse: collapse;
    margin-bottom: 20px;
}





th, td {
    border: 2px solid #b4c5e0;
    text-align: center;
    font-size: 14px;
    height: 30px;
    white-space: nowrap;
    padding: 8px; /* Adds space inside table cells */
    

}

thead {
    background-color: #f1f1f1; /* Optional: Light background for header */
   
}

tbody tr:nth-child(even) {
    background-color: #f9f9f9; /* Optional: Alternating row colors */
}

tbody tr:hover {
    background-color: #e0e0e0; /* Optional: Highlight row on hover */
}

/* Additional Styles */
hr {
    color: #1c355c;
}




        }
        .btn-primary {
  transition: background-color 0.3s, transform 0.3s;
}

.btn-primary:hover {
  background-color: #0056b3;
  transform: translateY(-2px);
}

.jumbotron {
      background-color: #1c355c;
      text-align: center;
      color: white;
    }
    .table-hover tbody tr:hover {
  background-color: #f1f1f1;
}
.icon {
    margin-right: 5px;
}



 button {
            padding: 10px 15px;
            background-color: #1c355c;
            color: white;
            border: all;
            border-radius: 12px;
            cursor: pointer;
            margin-left: auto;
            display :left;

        }
        button:hover {
            background-color:rgb(197, 88, 111);
        }

        table, th, td {
    border: 2px solid #b4c5e0;
    border-collapse: collapse;
    text-align: center;
   
}

table, tr, td {
    font-size: 14px;
    height: 30px;
    white-space: nowrap;
    font-weight: 500;
}

.table-wrapper {
    display: flex;
    flex-direction: column;
    align-items: stretch;
    width: 100%;
    max-height: 400px; /* Set a maximum height for the wrapper */
    overflow-x: auto; 
    overflow-y: auto; /* Change this to auto to show vertical scroll when needed */
}

.table-wrapper table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

thead {
    display: table-header-group; /* Keep the header fixed */
}

tbody {
    display: table-row-group; /* Group rows together */
}
.btn{
    

}
.btn:hover {
  background-color: RoyalBlue;
}
.btnn{
    float: right;
}
/* Base Button Styling */
/* Base Button Styles */
.button {
  display: inline-flex;
  align-items: center;
  gap: 8px; /* Space between icon and text */
  padding: 10px 20px;
  font-size: 16px;
  font-family: sans-serif;
  border: none;
  border-radius: 4px;
  background-color: #1c355c;
  color: #fff;
  cursor: pointer;
  transition: background-color 0.3s ease;
  /* Ensures that overflowing parts (icons sliding in) don’t break layout */
  overflow: hidden;
}

.button:hover {
  background-color: #15305a;
}

/* Icon Base Styles */
.btn-icon {
  opacity: 0;
  transition: transform 0.3s ease, opacity 0.3s ease;
  /* Keep the icon allocated a bit of space without being visible */
  display: inline-block;
}

/* ---------------------------
   Back Button Animation
   --------------------------- */
.back-button .btn-icon {
  transform: translateX(-10px);  /* Start slightly off to the left */
}

.back-button:hover .btn-icon {
  opacity: 1;
  transform: translateX(0);
}

/* ---------------------------
   Close Button Animation
   --------------------------- */
.close-button .btn-icon {
  transform: translateX(10px);  /* Start slightly off to the right */
}

.close-button:hover .btn-icon {
  opacity: 1;
  transform: translateX(0);
}

   

    </style>

</head>
<body >
    
<div class="container">

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <!-- <div class="header"><h1>Search with Filters</h1></div> -->
        <div class="jumbotron">

      <h1 class="header"><i class="fas fa-search" ></i> Advanced Search Page</h1>


    </div>

    <br>
        <div class="form1">
            <div class="filter">
                <div>
                    <label for="Zone"><i class="fas fa-globe icon" aria-hidden="true"></i>Zone:</label>  
                        <select id="Zone" name="Zone" >
                            <option value="">All</option>
                            <option value="North">North</option>
                            <option value="South">South</option>
                        </select>
                    </div>
    
    
                    <div>

                    <label for="vendor"><i class="fas fa-industry icon" aria-hidden="true"></i>Supplier:</label>
                        <select id="vevdor" name="vendor" >
                            <option value="">All</option>
                            <option value="Ericsson">Ericsson</option>
                            <option value="Huawei">Huawei</option>
                        </select>
                    </div>
    
         
                    <div>
                      <label for="C_R"><i class="fas fa-city icon" aria-hidden="true"></i>City or Rural:</label>
                        <select id="C_R" name="C/R" >
                            <option value="">All</option>
                            <option value="City">City</option>
                            <option value="Rural">Rural</option>
                        </select>
                    </div>
    
                    <div class="note" style="flex: 1 1 100%;">
                        <p><strong >Note:</strong><strong style="color: goldenrod;"> </br>Choose between two years (Start, End) or select a month with start year.</strong></p>
                    </div>
             
    
                    <div>
                    <label for="yearSelectStart"><i class="fas fa-calendar-alt icon" aria-hidden="true"></i>Start Year:</label>
                        <select name="yearSelectStart" id="yearSelectStart" >
                            <option value="">Select Year</option>
                            <?php
                            $currentYear = date("Y");
                            for ($year = 2000; $year <= $currentYear; $year++) {
                                echo "<option value=\"$year\">$year</option>";
                            }
                            ?>
                        </select>
                    </div>
    
                    <div>
                    <label for="yearSelectEnd"><i class="fas fa-calendar-alt icon" aria-hidden="true"></i>End Year:</label>
                        <select name="yearSelectEnd" id="yearSelectEnd" >
                            <option value="">Select Year</option>
                            <?php
                            for ($year = 2000; $year <= $currentYear; $year++) {
                                echo "<option value=\"$year\">$year</option>";
                            }
                            ?>
                        </select>
                    </div>
    
                    <div>
                    <label for="monthSelect"><i class="fas fa-calendar-check icon" aria-hidden="true"></i>Month:</label>
    
                        <select name="monthSelect" id="monthSelect" >
                            <option value="">All</option>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
    
                <div class="note" style="flex: 1 1 100%;">
                    <br>

                    <p><strong >Note:</strong><strong style="color: goldenrod;"> Choose multiple </strong></p>
                </div>
                
                <div>
                
                    <label for="tech"><i class="fas fa-microchip icon" aria-hidden="true"></i>Technology:</label>
                    <select name="tech[]" id="tech" multiple style="border-radius: 4px;">
                        <option value="">All</option>
                        <option value="TWO_G_SITES">2G</option>
                        <option value="THREE_G_SITES">3G</option>
                        <option value="FOUR_G_SITES">LTE</option>
                        <option value="TWO_G_SITES1">2G Only</option>
                        <option value="THREE_G_SITES1">3G Only</option>
                        <option value="FOUR_G_SITES1">LTE Only</option>
                        <option value="TWO_THREE">2G-3G</option>
                        <option value="TWO_FOUR">2G-4G</option>
                        <option value="THREE_FOUR">3G-4G</option>
                    </select>
                </div>

                <div>
                <label for="sitestatus"><i class="fas fa-info-circle icon" aria-hidden="true"></i>Status:</label>
                    <select id="sitestatus" name="sitestatus[]" multiple style="border-radius: 4px;">
                        <option value="">All</option>
                        <option value="On Air">On Air</option>
                        <option value="On Air (Stopped)">On Air (Stopped)</option>
                        <option value="On Air (Stopped_2)">On Air (Stopped_2)</option>
                    </select>
                </div>

                <div>
                <label for="province"><i class="fas fa-map-marker-alt icon" aria-hidden="true"></i>Province:</label>
                    <select id="province" name="province[]" multiple   style="border-radius: 4px;">
                        <option value="">All</option>
                        <option value="Aleppo">Aleppo</option>
                        <option value="Aleppo Rural">Aleppo Rural</option>
                        <option value="Damascus">Damascus</option>
                        <option value="Damascus Rural">Damascus Rural</option>
                        <option value="Daraa">Daraa</option>
                        <option value="Daraa Rural">Daraa Rural</option>
                        <option value="Deir El-Zor">Deir El-Zor</option>
                        <option value="Deir El-Zor Rural">Deir El-Zor Rural</option>
                        <option value="Hama">Hama</option>
                        <option value="Hama Rural">Hama Rural</option>
                        <option value="Hassakeh">Hassakeh</option>
                        <option value="Hassakeh Rural">Hassakeh Rural</option>
                        <option value="Homs">Homs</option>
                        <option value="Homs Rural">Homs Rural</option>
                        <option value="Idleb">Idleb</option>
                        <option value="Idleb Rural">Idleb Rural</option>
                        <option value="Lattakia">Lattakia</option>
                        <option value="Lattakia Rural">Lattakia Rural</option>
                        <option value="Qounaitera">Qounaitera</option>
                        <option value="Qounaitera Rural">Qounaitera Rural</option>
                        <option value="Rakka Rural">Rakka Rural</option>
                        <option value="Sweida">Sweida</option>
                        <option value="Sweida Rural">Sweida Rural</option>
                        <option value="Tartous">Tartous</option>
                        <option value="Tartous Rural">Tartous Rural</option>
                    </select>
                </div>
                <div>
                    <label for="priority"><i class="fas fa-star icon" aria-hidden="true"></i>Priority:</label>
    
                        <select name="priority[]" id="priority"  multiple style="border-radius: 4px;">
                            <option value="">All</option>
                            <option value="Priority 1">Priority 1</option>
                            <option value="Priority 2">Priority 2</option>
                            <option value="Priority 3">Priority 3</option>
                            <option value="Priority 4">Priority 4</option>
                        </select>
                    </div>


              
               

                <!-- <div>
                    <label for="restoration"><h3>Restoration Date:</h3></label>
                    <select name="restoration" id="restoration">
                        <option value="">Select Year</option>
                        <?php
                        for ($year = 2000; $year <= $currentYear; $year++) {
                            echo "<option value=\"$year\">$year</option>";
                        }
                        ?>
                    </select>
                </div> -->
            </div>

            <div class="submit">
                <br>
                <br>
                <br>
                <br>
                <br>

                <input type="submit" name="submit" value="Show Results">
            </div>
        </div>
        
<?php
 

?>
    
    

    <!-- Results Section -->
    <?php if (isset($results) && count($results) > 0): ?>
    <div class="table-wrapper">
        <?php foreach ($results1 as $row1): echo "<h3>Count Of Results: " . htmlspecialchars($row1['TOTALCOUNT']) . "</h3>"; endforeach; ?>
        <button onclick="copyTable(event)" style="width: 20%;"><i class="fa fa-copy" style="font-size:11px"> </i> Copy Table Results</button><br><br>
        <table border='1' id="resultsTable">
            <thead>
                <tr>
                    <th>SITE CODE</th>
                    <th>PROVINCE</th>
                    <th>SUPPLIER</th>
                    <th>SITE_ON_AIR_DATE</th>

                    <?php
                    // Check if any row has a non-empty value for the fields
                    $has3GOnAirDate = false;
                    $haspriority = false;
                    $has2GOnAirDate = false;
                    $has4GOnAirDate = false;
                    $has2Gstatus = false;
                    $has3Gstatus = false;
                    $has4Gstatus = false;
                    $hascr = false;
                    $haszone = false;

                    foreach ($results as $row) {
                        if (!empty($row['3G_ON_AIR_DATE'])) $has3GOnAirDate = true;
                        if (!empty($row['LTE_ON_AIR_DATE'])) $has4GOnAirDate = true;
                        if (!empty($row['2G_ON_AIR_DATE'])) $has2GOnAirDate = true;
                        if (!empty($row['2G_STATUS'])) $has2Gstatus = true;
                        if (!empty($row['3G_STATUS'])) $has3Gstatus = true;
                        if (!empty($row['4G_STATUS'])) $has4Gstatus = true;
                        if (!empty($row['CR'])) $hascr = true;
                        if (!empty($row['ZONE'])) $haszone = true;
                        if (!empty($row['TECHNICAL_PRIORITY'])) $haspriority = true;
                    }
                    ?>

                    <?php if ($hascr): ?>
                        <th>CITY/RURAL</th>
                    <?php endif; ?>
                    <?php if ($haszone): ?>
                        <th>ZONE</th>
                    <?php endif; ?>
                    <?php if ($has2GOnAirDate): ?>
                        <th>2G_ON_AIR_DATE</th>
                    <?php endif; ?>
                    <?php if ($has2Gstatus): ?>
                        <th>2G_STATUS</th>
                    <?php endif; ?>
                    <?php if ($has3GOnAirDate): ?>
                        <th>3G_ON_AIR_DATE</th>
                    <?php endif; ?>
                    <?php if ($has3Gstatus): ?>
                        <th>3G_STATUS</th>
                    <?php endif; ?>
                    <?php if ($has4GOnAirDate): ?>
                        <th>4G_ON_AIR_DATE</th>
                    <?php endif; ?>
                    <?php if ($has4Gstatus): ?>
                        <th>4G_STATUS</th>
                    <?php endif; ?>
                    <?php if ($haspriority): ?>
                        <th>TECHNICAL PRIORITY</th>
                    <?php endif; ?>
                    <th>TECHNOLOGIES</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['SITE_CODE']); ?></td>
                        <td><?php echo htmlspecialchars($row['PROVINCE']); ?></td>
                        <td><?php echo htmlspecialchars($row['SUPPLIER']); ?></td>
                        <td><?php echo htmlspecialchars($row['SITE_ON_AIR_DATE']); ?></td>

                        <?php if ($haszone): ?>
                            <td><?php echo htmlspecialchars($row['ZONE']); ?></td>
                        <?php endif; ?>

                        <?php if ($hascr): ?>
                            <td><?php echo htmlspecialchars($row['CR']); ?></td>
                        <?php endif; ?>

                        <?php if ($has2GOnAirDate): ?>
                            <td><?php echo htmlspecialchars($row['2G_ON_AIR_DATE']); ?></td>
                        <?php endif; ?>

                        <?php if ($has2Gstatus): ?>
                            <td><?php echo htmlspecialchars($row['2G_STATUS']); ?></td>
                        <?php endif; ?>

                        <?php if ($has3GOnAirDate): ?>
                            <td><?php echo htmlspecialchars($row['3G_ON_AIR_DATE']); ?></td>
                        <?php endif; ?>

                        <?php if ($has3Gstatus): ?>
                            <td><?php echo htmlspecialchars($row['3G_STATUS']); ?></td>
                        <?php endif; ?>

                        <?php if ($has4GOnAirDate): ?>
                            <td><?php echo htmlspecialchars($row['LTE_ON_AIR_DATE']); ?></td>
                        <?php endif; ?>

                        <?php if ($has4Gstatus): ?>
                            <td><?php echo htmlspecialchars($row['4G_STATUS']); ?></td>
                        <?php endif; ?>

                        <?php if ($haspriority): ?>
                            <td><?php echo htmlspecialchars($row['TECHNICAL_PRIORITY']); ?></td>
                        <?php endif; ?>

                        <td><?php echo htmlspecialchars($row['TECHNOLOG']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php elseif (isset($results)): ?>
    <div>
        <p>No results found for the selected criteria.</p>
    </div>
<?php endif; ?>

    </form>

          <!-- Footer -->
        <div class="footer">
           <!--  <p>&copy; <?php echo date("Y"); ?> MTN SYRIA</p> -->
            <!-- Back Button -->
<?php
echo "<button type='button' class='button back-button' onclick=\"location.href='Mainpage.php?user=" . $userrname . "';\">";
echo "<span class='btn-icon'>&laquo;</span>";
echo "<span class='btn-text'>Back</span>";
echo "</button>";
?>

<!-- Close Button -->
<button type="button" class="button close-button" onclick="window.close();">
    <span class="btn-text">Close</span>
    <span class="btn-icon">&times;</span>
</button>





        </div>
    </div>
    
<!-- JavaScript Function -->
<script>
function copyTable(event) {
    event.preventDefault(); // Prevent the form from submitting

    var table = document.getElementById("resultsTable");
    var range, selection;

    if (document.createRange && window.getSelection) {
        range = document.createRange();
        selection = window.getSelection();
        selection.removeAllRanges(); // Clear any existing selections
        try {
            range.selectNodeContents(table);
            selection.addRange(range);
        } catch (e) {
            range.selectNode(table);
            selection.addRange(range);
        }
        document.execCommand("copy");
        alert("Table copied to clipboard!");
        selection.removeAllRanges(); // Clear selection after copying
    } else if (document.body.createTextRange) {
        range = document.body.createTextRange();
        range.moveToElementText(table);
        range.select();
        range.execCommand("copy");
        alert("Table copied to clipboard!");
    }
}
</script>
</body>
</html>

