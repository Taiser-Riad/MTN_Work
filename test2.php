<?php
// Make sure you connect to the database
$conn = mysqli_connect("your_host", "your_username", "your_password", "your_database");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the letters that were checked in the form
    $checked_letters = $_POST['letters'] ?? [];

    // Loop through A, B, C, D
    foreach (['A', 'B', 'C', 'D'] as $letter) {
        // Get the value from the text field for the current letter
        $field_value = $_POST['field_' . $letter] ?? '';

        // Check if this letter was checked in the form
        if (in_array($letter, $checked_letters)) {
            // Perform the update or insert into the cells table
            // Assuming 'some_column' is the column you want to update
            $query = "UPDATE cells SET some_column = ? WHERE site_code = ? AND site_id = ?";
            $stmt = mysqli_prepare($conn, $query);
            $site_code = 'some_base_code_' . $letter; // Adjust site_code based on your logic
            mysqli_stmt_bind_param($stmt, 'ssi', $field_value, $site_code, $site_id);

            // Execute the query
            mysqli_stmt_execute($stmt);
        }
    }

    // Redirect or show a success message
    header("Location: success.php");
    exit;
}
?>


input type ="text"      name="cellid"   size="4"  placeholder="Cell ID"     disabled   value = "<?= $data[$letter]['Cell_ID']?? '' //echo cell_id and if it is null echo ''?>">
    <input type ="text"      name="cellcode" size="5"  placeholder="Cell Code"             value = "<?= $data[$letter]['Cell_code']?? '' ?>" >
    <input type ="text"      name="azimuth"  size="3"  placeholder="Azimuth"               value = "<?= $data[$letter]['AZIMUTH']?? '' ?>" >
    <input type ="text"      name="height"   size="3"  placeholder="Height"                value = "<?= $data[$letter]['Hieght']?? '' ?>">
    <input type ="text"      name="mtilt"    size="3"  placeholder="M_TILT"                value = "<?= $data[$letter]['M_TILT']?? '' ?>">
    <input type ="text"      name="etilt"    size="3"  placeholder="E_TILT"                value = "<?= $data[$letter]['E_TILT']?? '' ?>">
    <input type ="text"      name="area1"    size="20" placeholder="Arabic Serving Area"   value = "<?= $data[$letter]['Serving_Area']?? '' ?>">
    <input type ="text"      name="area2"    size="20" placeholder="English Serving Area"  value = "<?= $data[$letter]['serving_Area_IN_English']?? '' ?>"></br></br>
    <input type ="text"      name="cnotes"   size="75" placeholder="Note"                  value = "<?= $data[$letter]['Note']?? '' ?>">



    SELECT t.Site_ID, t.Cell_ID, s.Site_code, s.Site_Name, t.Band ,s.Zone, s.Province, s.CR, s.Supplier, t.Site_Status, s.Site_On_Air_Date, t.Notes, s.Coordinates_E, s.Coordinates_N, s.Site_Adress, s.BSC FROM new_sites s JOIN 2gsites t ON(s.ID = t.Site_ID)
$insertQuery = " INSERT INTO new_table1 (col1, col2, col3)
SELECT t1.col1, t1.col2, t1.col3 
FROM table1 t1
JOIN table2 t2 ON t1.id = t2.table1_id
WHERE your_condition_here
";


$query ="INSERT INTO `cancelled_sites`(`Site_ID`, `Cell_ID`, `Site_Code`, `Site_Name`, `Band`, `Zone`, `Province`, `CR`, `Supplier`, `Status_Before`, `On_Air_Date`, `Cancellation_Date`, `Note`, `Coordinates_E`, `Coordinates_N`, `Site_Adress`, `2G_RBS`) VALUES ($row['Site_ID'], $row['Cell_ID'], $row['Site_code'], $row['Site_Name'] , $row['Band'] ,$row['Zone'] ,$row['Province'] ,$row['CR'], $row['Supplier'] , $row['Site_Status'] , $row['Site_On_Air_Date'] , $cancelldate , $row['Notes'], $row['Coordinates_E'], $row['Coordinates_N'] , $row['Site_Adress'] ,$row['BSC']) WHERE s.ID = '$id'";