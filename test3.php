<?php 
// Database connection
$mysqli = new mysqli("localhost", "username", "password", "database");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Step 1: Insert data from the first set of joined tables to the new ones
$insertQuery = "
    INSERT INTO new_table1 (col1, col2, col3)
    SELECT t1.col1, t1.col2, t1.col3 
    FROM table1 t1
    JOIN table2 t2 ON t1.id = t2.table1_id
    WHERE your_condition_here
";

$insertQuery2 = "
    INSERT INTO new_table2 (col1, col2, col3)
    SELECT t2.col1, t2.col2, t2.col3 
    FROM table1 t1
    JOIN table2 t2 ON t1.id = t2.table1_id
    WHERE your_condition_here
";

if ($mysqli->query($insertQuery) === TRUE && $mysqli->query($insertQuery2) === TRUE) {
    echo "Data inserted into new tables successfully.";
} else {
    echo "Error inserting data: " . $mysqli->error;
}

// Step 2: Delete the moved data from the original tables
$deleteQuery = "
    DELETE t1, t2
    FROM table1 t1
    JOIN table2 t2 ON t1.id = t2.table1_id
    WHERE your_condition_here
";

if ($mysqli->query($deleteQuery) === TRUE) {
    echo "Data deleted from original tables successfully.";
} else {
    echo "Error deleting data: " . $mysqli->error;
}

// Close the connection
$mysqli->close();
?>
SELECT c.CID_Key, c.Cell_code, c.Cell_Name, c.Cell_ID,c.Cell_On_Air_Date, c.Note ,c.Serving_Area,
c.serving_Area_IN_English FROM `2gcells`

SELECT t.900GSM_RBS_Type, t.1800GSM_RBS_Type` FROM `2gsites`

SELECT s.Site_code, s.Site_Name, s.Zone, s.Province, s.CR, s.Supplier, s.BSC, FROM `new_sites`