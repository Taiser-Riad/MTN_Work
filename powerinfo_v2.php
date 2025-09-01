<?php

include "config.php";
if(isset($_GET['id'])) {
    $siteid = $_GET['id'];
    $sqll = "SELECT * FROM NEW_SITES WHERE ID= :siteid";
    $result = oci_parse($conn, $sqll);
    oci_bind_by_name($result, ':siteid', $siteid);
    oci_execute($result);
    $row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS);

    $sitecode = $row['SITE_CODE'];
    $check_sql = "SELECT * FROM POWER_BACKUP WHERE SITE_CODE = :sitecode";
    $check_stmt = oci_parse($conn, $check_sql);
    oci_bind_by_name($check_stmt, ':sitecode', $sitecode);
    oci_execute($check_stmt);
}


if($_SERVER["REQUEST_METHOD"] == "POST")
{
    echo "Current request method: " . $_SERVER["REQUEST_METHOD"]; 
    $site = $_POST['sitecode'];
if(isset($_POST['remove_gen'])){



    $sql_gen = "SELECT * FROM GENERTAOR WHERE SITE_CODE=:sitecode";
    $select_gen = oci_parse($conn, $sql_gen);
    oci_bind_by_name($select_gen, ':sitecode', $site);
    oci_execute($select_gen);
    if($row_gen = oci_fetch_array($select_gen, OCI_ASSOC + OCI_RETURN_NULLS))
    {
           $GID  = $row_gen['GID'];
           $PID  = $row_gen['PID'];
    
    $insert_gen = "INSERT INTO WAREHOUSE_GENERATOR (GID, PID, OLD_SITE_CODE, MOVED_DATE) VALUES (:gid, :pid, :sitecode, SYSDATE) ";
    $stmt = oci_parse($conn, $insert_gen);
    oci_bind_by_name($stmt, ':pid', $PID);
    oci_bind_by_name($stmt, ':gid', $GID);
    oci_bind_by_name($stmt, ':sitecode', $site);
   if(oci_execute($stmt)){
    echo "after inserting";
    $update_gen = "UPDATE GENERTAOR 
                SET SITE_CODE = NULL,
                PID = NULL
                WHERE GID = :gid";

    $stmtt = oci_parse($conn, $update_gen);
    oci_bind_by_name($stmtt, ':gid', $GID);
    oci_execute($stmtt);

   }

   $sql_insert = "INSERT INTO GENERTAOR_AUDIT (
    DETAIL_ID,
    USER_ID,
    SITE_CODE,
    REMOVED_BY,
    REMOVED_AT,
    GID
   
) VALUES (
    GENERATOR_SEQ.NEXTVAL,
    :user_id,
    :site_code,
    :changed_by,
    SYSDATE,
    :gid
      )RETURNING DETAIL_ID INTO :last_detail_id";

$insert_stmt = oci_parse($conn, $sql_insert);

// Bind variables
oci_bind_by_name($insert_stmt, ':last_detail_id', $DETAIL_ID, -1, SQLT_INT);
oci_bind_by_name($insert_stmt, ':user_id', $user_id1);
oci_bind_by_name($insert_stmt, ':site_code', $sitecode);
oci_bind_by_name($insert_stmt, ':changed_by', $username1);
oci_bind_by_name($insert_stmt, ':gid', $GID);



// Execute the statement
if (oci_execute($insert_stmt)) {
    //echo "Record inserted successfully.";
} else {
    $e = oci_error($insert_stmt); // For detailed error
    echo "Error inserting record: " . $e['message'];
}




    }

}




}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Backup Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --secondary: #7209b7;
            --accent: #f72585;
            --success: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --border-color: #d0d7de;
            --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: var(--dark);
            line-height: 1.6;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .modal.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: white;
            width: 90%;
            max-width: 900px;
            border-radius: 16px;
            overflow: hidden;
            transform: translateY(20px) scale(0.98);
            transition: transform 0.4s ease, opacity 0.4s ease;
            box-shadow: var(--card-shadow);
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal.active .modal-content {
            transform: translateY(0) scale(1);
        }

        .modal-header {
            background: linear-gradient(to right, #1c355c, #2c5282);
            padding: 24px 30px;
            text-align: center;
            position: relative;
            color: white;
        }

        .modal-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .site-code {
            display: inline-block;
            background: rgba(255, 255, 255, 0.15);
            padding: 6px 14px;
            border-radius: 100px;
            margin-top: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            backdrop-filter: blur(4px);
        }

        .close-btn {
            position: absolute;
            top: 24px;
            right: 24px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 30px;
        }

        .section-title {
            background: linear-gradient(to right, #1c355c, #2c5282);
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }

        .section-title h3 {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .action-link.delete {
            color: indianred;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            cursor: pointer;
            transition: var(--transition);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .action-link.delete:hover {
            /* background: rgba(255, 255, 255, 0.3); */
            background: white;
            transform: translateY(-2px);
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 0;
            margin-bottom: 28px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            transition: var(--transition);
            border: 1px solid var(--border-color);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.1);
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            border-radius: 0 0 12px 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }

        th,  td {
            background-color: var(--light);
            font-weight: 600;
            padding: 16px;
            text-align: left;
            border: 1px solid var(--border-color);
        }
        th {
            background-color: var(--light);
            font-weight: 600;
            border-bottom: 2px solid var(--border-color);
        }
        

        tr:last-child td {
            border-bottom: 1px solid var(--border-color);
        }

        tr:hover {
            background-color: #fafbff;
        }

        .no-data {
            background: linear-gradient(to right, #1c355c, #2c5282);
            text-align: center;
            padding: 28px;
            color: white;
            font-style: italic;
            border-radius: 12px;
            margin-bottom: 28px;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.2);
        }

        .no-data i {
            font-size: 2rem;
            margin-bottom: 12px;
            display: block;
            opacity: 0.8;
        }

        .modal-footer {
            padding: 24px;
            background: var(--light);
            display: flex;
            justify-content: center;
            border-top: 1px solid var(--light-gray);
        }

        .modal-btn {
            padding: 14px 36px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            background: linear-gradient(to right, #1c355c, #2c5282);
            color: white;
            font-size: 1rem;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.25);
        }

        .modal-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.35);
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 100px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-active {
            background: rgba(76, 201, 240, 0.15);
            color: #1894c7;
        }

        .status-inactive {
            background: rgba(247, 37, 133, 0.15);
            color: #c11167;
        }

        @media (max-width: 768px) {
            .modal-content {
                width: 95%;
            }
            
            .modal-body {
                padding: 20px;
            }
            
            .section-title {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            
            th, td {
                padding: 12px 10px;
            }
            
            .modal-header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="modal active" id="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h2>Power Backup Information</h2>
                    <div class="site-code"><?php echo isset($sitecode) ? $sitecode : 'No Site Code'; ?></div>
                </div>
                <button type="button" class="close-btn" id="closeModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="siteCode" name="sitecode" value="<?php echo $row['SITE_CODE']; ?>">
                    
                    <?php if(isset($sitecode)): ?>
                    <!-- Generator Information -->
                    <?php
                        $sql_gen = "SELECT * FROM GENERTAOR WHERE SITE_CODE=:sitecode";
                        $select_gen = oci_parse($conn, $sql_gen);
                        oci_bind_by_name($select_gen, ':sitecode', $sitecode);
                        oci_execute($select_gen);
                        
                        if($row_gen = oci_fetch_array($select_gen, OCI_ASSOC + OCI_RETURN_NULLS)): 
                    ?>
                    <div class="card">
                        <div class="section-title">
                            <h3><i class="fas fa-bolt"></i> Generator Information</h3>
                            <button class="action-link delete" type="submit" name="remove_gen" aria-label="Delete generator">
                                <i class="fas fa-trash"></i> Remove Generator
                            </button>
                        </div>
                        <div class="table-wrapper">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Brand</th>
                                        <th>Capacity</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $row_gen['BRAND'] ?? '-'; ?></td>
                                        <td><?php echo $row_gen['CAPACITY'] ?? '-'; ?></td>
                                        <td><span class="status-badge status-active"><?php echo $row_gen['INITIAL_STATUS'] ?? 'Unknown'; ?></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="no-data">
                        <i class="fas fa-bolt"></i>
                        <p>No Generator found for this site</p>
                    </div>
                    <?php endif; ?>

                    <!-- Solar Information -->
                    <?php
                        $sql_hyp = "SELECT * FROM HYPRID WHERE SITE_CODE=:sitecode";
                        $select_hyp = oci_parse($conn, $sql_hyp);
                        oci_bind_by_name($select_hyp, ':sitecode', $sitecode);
                        oci_execute($select_hyp);
                        
                        if($row_hyp = oci_fetch_array($select_hyp, OCI_ASSOC + OCI_RETURN_NULLS)): 
                    ?>
                    <div class="card">
                        <div class="section-title">
                            <h3><i class="fas fa-solar-panel"></i> Solar Information</h3>
                        </div>
                        <div class="table-wrapper">
                            <table>
                                <thead>
                                    <tr>
                                        <th>System Type</th>
                                        <th>System Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $row_hyp['TYPE'] ?? '-'; ?></td>
                                        <td><span class="status-badge status-active"><?php echo $row_hyp['STATUS'] ?? 'Unknown'; ?></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="no-data">
                        <i class="fas fa-solar-panel"></i>
                        <p>No Solar system found for this site</p>
                    </div>
                    <?php endif; ?>

                    <!-- Batteries Information -->
                    <?php
                        $sql_batt = "SELECT * FROM BATTERIES WHERE SITE_CODE=:sitecode";
                        $select_batt = oci_parse($conn, $sql_batt);
                        oci_bind_by_name($select_batt, ':sitecode', $sitecode);
                        oci_execute($select_batt);
                        
                        if($row_batt = oci_fetch_array($select_batt, OCI_ASSOC + OCI_RETURN_NULLS)): 
                    ?>
                    <div class="card">
                        <div class="section-title">
                            <h3><i class="fas fa-battery-full"></i> Batteries Information</h3>
                        </div>
                        <div class="table-wrapper">
                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="3">Group 1</th>
                                        <th colspan="3">Group 2</th>
                                    </tr>
                                    <tr>
                                        <th>Brand</th>
                                        <th>Status</th>
                                        <th>Quantity</th>
                                        <th>Brand</th>
                                        <th>Status</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $row_batt['G1_BRAND'] ?? '-'; ?></td>
                                        <td><span class="status-badge status-active"><?php echo $row_batt['G1_STATUS'] ?? 'Unknown'; ?></span></td>
                                        <td><?php echo $row_batt['G1_QUANTITY'] ?? '-'; ?></td>
                                        <td><?php echo $row_batt['G2_BRAND'] ?? '-'; ?></td>
                                        <td><span class="status-badge status-active"><?php echo $row_batt['G2_STATUS'] ?? 'Unknown'; ?></span></td>
                                        <td><?php echo $row_batt['G2_QUANTITY'] ?? '-'; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="no-data">
                        <i class="fas fa-battery-full"></i>
                        <p>No Batteries found for this site</p>
                    </div>
                    <?php endif; ?>

                    <!-- Lines Information -->
                    <?php
                        $sql_lines = "SELECT * FROM LINES WHERE SITE_CODE=:sitecode";
                        $select_lines = oci_parse($conn, $sql_lines);
                        oci_bind_by_name($select_lines, ':sitecode', $sitecode);
                        oci_execute($select_lines);
                        
                        if($row_lines = oci_fetch_array($select_lines, OCI_ASSOC + OCI_RETURN_NULLS)): 
                    ?>
                    <div class="card">
                        <div class="section-title">
                            <h3><i class="fas fa-plug"></i> Lines Information</h3>
                        </div>
                        <div class="table-wrapper">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $row_lines['TYPE'] ?? '-'; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="no-data">
                        <i class="fas fa-plug"></i>
                        <p>No Lines found for this site</p>
                    </div>
                    <?php endif; ?>
                    
                    <?php else: ?>
                    <div class="no-data">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>No site information available</p>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="modal-btn" id="closeBtn">Close</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Get DOM elements
        const modal = document.getElementById('modal');
        const closeModalBtn = document.getElementById('closeModal');
        const closeBtn = document.getElementById('closeBtn');
        const modalContent = document.querySelector('.modal-content');

        // Close modal and iframe function with smooth transition
        function closeModal() {
            // Start the closing animation
            modalContent.style.transform = 'translateY(20px) scale(0.98)';
            modal.style.opacity = '0';
            modal.style.visibility = 'hidden';
            
            // After the transition completes, close everything
            setTimeout(() => {
                try {
                    // Check if we're in an iframe
                    if (window.parent !== window) {
                        // Send the message format that the parent expects
                        window.parent.postMessage({ 
                            action: 'closePowerInfo'
                        }, '*');
                    } else {
                        // Fallback for standalone use
                        try {
                            window.close();
                        } catch (e) {
                            console.log("Couldn't close window:", e);
                            // Final fallback - just hide the modal
                            modal.style.display = 'none';
                        }
                    }
                } catch (e) {
                    console.log("Communication error:", e);
                    // Fallback handling
                    try {
                        window.close();
                    } catch (e) {
                        modal.style.display = 'none';
                    }
                }
            }, 400);
        }

        // Event listeners
        closeModalBtn.addEventListener('click', closeModal);
        closeBtn.addEventListener('click', closeModal);

        // Close modal when clicking outside the content
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>