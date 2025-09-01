<?php 
include "config.php";
header('Content-Type: text/html; charset=UTF-8');
?>
<?php
if(isset($_GET['user']))
{
    $username = $_GET['user'];
    $sqll = "SELECT * FROM USERS WHERE USERNAME= :username";
    $result = oci_parse($conn, $sqll);
    oci_bind_by_name($result, ':username', $username);
    oci_execute($result);
    $row11 = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS);
    $userrname = $row11['USERNAME'];
    $dep = $row11['DEPARTMENT'];
    $user_id = $row11['USER_ID'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Search | MTN Syria</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
    :root {
        --primary: #1c355c;
        --secondary: #ff6600;
        --accent: #f0b52d;
        --light: #f5f7fb;
        --dark: #212529;
        --gray: #6c757d;
        --success: #28a745;
        --card-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: goldenrod;
        color: var(--dark);
        line-height: 1.6;
        min-height: 100vh;
        padding: 20px;
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
        background: white;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }

    /* Header Styles */
    .header {
        background: linear-gradient(135deg, var(--primary) 0%, #0d1a30 100%);
        color: white;
        text-align: center;
        padding: 25px 20px;
        position: relative;
    }

    .header h1 {
        font-size: 2.2rem;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .header p {
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto 20px;
        opacity: 0.9;
    }

    .user-info {
        position: absolute;
        top: 20px;
        right: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, 0.1);
        padding: 8px 15px;
        border-radius: 30px;
    }

    .user-avatar {
        width: 35px;
        height: 35px;
        background: var(--accent);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: var(--primary);
    }

    .back-button {
        position: absolute;
        top: 20px;
        left: 20px;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: none;
        border-radius: 30px;
        padding: 8px 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: var(--transition);
        font-weight: 500;
    }

    .back-button:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateX(-5px);
    }

    /* Search Form */
    .search-form {
        padding: 30px 20px;
        background: var(--light);
        text-align: center;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .search-container {
        max-width: 600px;
        margin: 0 auto;
        display: flex;
        gap: 10px;
    }

    .search-input {
        flex: 1;
        padding: 15px 20px;
        border: 2px solid #d1d9e6;
        border-radius: 8px;
        font-size: 1rem;
        transition: var(--transition);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 5px 15px rgba(28, 53, 92, 0.1);
    }

    .search-button {
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0 30px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .search-button:hover {
        background: #152a50;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    /* Results Section */
    .results-container {
        padding: 20px;
    }

    .result-section {
        margin-bottom: 40px;
    }

    .section-title {
        background: var(--primary);
        color: white;
        padding: 12px 20px;
        border-radius: 6px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .section-title h2 {
        font-size: 1.4rem;
        font-weight: 600;
    }

    .section-title i {
        margin-right: 10px;
    }

    .table-container {
        overflow-x: auto;
        border-radius: 8px;
        box-shadow: var(--card-shadow);
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;
    }

    th {
        background: #f0f4ff;
        color: var(--primary);
        padding: 15px 12px;
        text-align: left;
        font-weight: 600;
        border-bottom: 2px solid #d1d9e6;
    }

    td {
        padding: 12px 15px;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }

    tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    tr:hover {
        background-color: #f0f4ff;
    }

    .action-link {
        color: var(--primary);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 4px;
        transition: var(--transition);
        font-weight: 500;
    }

    .action-link:hover {
        background: rgba(28, 53, 92, 0.1);
        transform: translateY(-2px);
    }

    .action-link.update {
        color: var(--success);
    }

    .action-link.delete {
        color: #dc3545;
    }

    .button-group {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 15px;
    }

    .btn {
        padding: 12px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        text-align: center;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: #152a50;
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-secondary {
        background: var(--accent);
        color: var(--primary);
    }

    .btn-secondary:hover {
        background: #e0a825;
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-disabled {
        background: #e9ecef;
        color: #adb5bd;
        cursor: not-allowed;
        pointer-events: none;
    }

    .message {
        padding: 20px;
        background: #fff9db;
        border-left: 4px solid #ffd43b;
        border-radius: 0 8px 8px 0;
        margin: 20px 0;
        font-weight: 500;
    }

    .error {
        padding: 20px;
        background: #ffe3e3;
        border-left: 4px solid #ff6b6b;
        border-radius: 0 8px 8px 0;
        margin: 20px 0;
        font-weight: 500;
    }

    .info-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: var(--card-shadow);
        margin-bottom: 25px;
    }

    .info-card p {
        margin-bottom: 15px;
        line-height: 1.7;
    }

    .info-card strong {
        color: var(--primary);
    }

    /* Footer */
    .footer {
        background: var(--primary);
        color: white;
        padding: 20px;
        text-align: center;
        font-size: 0.9rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .header h1 {
            font-size: 1.8rem;
        }

        .search-container {
            flex-direction: column;
        }

        .user-info span {
            display: none;
        }

        .user-info {
            padding: 6px 10px;
        }

        .back-button {
            padding: 6px 15px;
            font-size: 0.9rem;
        }

        .section-title h2 {
            font-size: 1.2rem;
        }

        th,
        td {
            padding: 10px 12px;
            font-size: 0.9rem;
        }

        .btn {
            padding: 10px 15px;
            font-size: 0.9rem;
        }

        .button-group {
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .header {
            padding: 25px 15px;
        }

        .header h1 {
            font-size: 1.5rem;
        }

        .header p {
            font-size: 0.95rem;
        }

        .action-link span {
            display: none;
        }

        .action-link {
            padding: 6px;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <button class="back-button" onclick="window.history.back()">
                <i class="fas fa-arrow-left"></i>
                <span>Back</span>
            </button>

            <h1><i class="fas fa-search"></i> Site Search</h1>
            <p>Enter site code to view and manage site information</p>

            <div class="user-info">
                <div class="user-avatar"><?php echo strtoupper(substr($userrname, 0, 1)); ?></div>
                <span><?php echo $userrname; ?></span>
            </div>
        </div>

        <!-- Search Form -->
        <div class="search-form">
            <form method="POST">
                <div class="search-container">
                    <input type="text" class="search-input" name="search" placeholder="Enter site code (e.g., DAM123)"
                        required>
                    <button type="submit" name="submit" class="search-button">
                        <i class="fas fa-search"></i>
                        <span>Search</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Container -->
        <div class="results-container">
            <?php if(isset($_POST['submit'])): ?>
            <?php
                    $search = $_POST['search'];
                    $search = strtoupper($search);
                    $code1 = substr($search, 0, 3);
                    
                    if (!preg_match("/^(DAM|DMR|DRA|ALP|DRZ|HMS|HMA|TRS|LTK|RKA|IDB|SWD|QRA|HSK)$/", $code1)) {
                        echo '<div class="error"><i class="fas fa-exclamation-circle"></i> Site code "'.$code1.'" is not valid. Please enter a valid site code.</div>';
                    } else {
                        $search = "%$search%";
                        $sql = "SELECT * FROM NEW_SITES WHERE SITE_CODE LIKE :search";
                        $sqll = "SELECT s.SITE_CODE, t.*, c.* FROM NEW_SITES s JOIN TWO_G_SITES t ON(s.ID = t.SITE_ID) JOIN TWO_G_CELLS c ON (t.Cell_ID = c.CID_Key) WHERE s.SITE_CODE LIKE :search";
                        $sqll2 = "SELECT s.SITE_CODE, t.*, c.* FROM NEW_SITES s JOIN THREE_G_SITES t ON(s.ID = t.SITE_ID) JOIN THREE_G_CELLS c ON (t.Cell_ID = c.CID) WHERE s.SITE_CODE LIKE :search";
                        $sqll3 = "SELECT s.SITE_CODE, t.*, c.* FROM NEW_SITES s JOIN FOUR_G_SITES t ON(s.ID = t.SID) JOIN FOUR_G_CELLS c ON (t.Cell_ID_KEY = c.CID_Key) WHERE s.SITE_CODE LIKE :search";

                        $result = oci_parse($conn, $sql);
                        oci_bind_by_name($result, ':search', $search);
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
                ?>

            <!-- Basic Info Section -->
            <div class="result-section">
                <div class="section-title">
                    <h2><i class="fas fa-info-circle"></i> Basic Site Information</h2>
                </div>

                <?php
                        if($row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS)):
                            $id = $row['ID'];
                    ?>

                <div class="info-card">
                    <p><strong>Site Code:</strong> <?php echo $row['SITE_CODE']; ?></p>
                    <p><strong>Site Name:</strong> <?php echo $row['SITE_NAME']; ?></p>
                    <p><strong>Province:</strong> <?php echo $row['PROVINCE']; ?></p>
                    <p><strong>On Air Date:</strong> <?php echo $row['SITE_ON_AIR_DATE']; ?></p>

                    <div class="button-group">
                        <?php if($dep == 'Power'): ?>
                        <a href="addpower.php?id=<?php echo $row['ID']; ?>&user_id=<?php echo $user_id; ?>"
                            class="btn btn-primary">
                            <i class="fas fa-bolt"></i> Add Power Backup
                        </a>

                        <button type="button" class="btn btn-primary" onclick="showPowerInfoModal()"><i
                                class="fa fa-list-alt"></i> Summury</button>
                        <a href="Delete_quest.php?id2=<?php echo $row['ID']; ?>" class="btn btn-disabled">
                            <i class="fas fa-trash"></i> Cancel Site
                        </a>
                        <?php else: ?>
                        <a href="update_basic_info.php?id=<?php echo $row['ID']; ?>" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Update Info
                        </a>
                        <a href="Delete_quest.php?id2=<?php echo $row['ID']; ?>" class="btn btn-secondary">
                            <i class="fas fa-trash"></i> Cancel Site
                        </a>


                        <?php endif; ?>
                        <a href="Info.php?id2=<?php echo $row['ID']; ?>" class="btn btn-primary">
                            <i class="fas fa-info-circle"></i> More Details
                        </a>
                    </div>
                </div>

                <div class="button-group">
                    <?php if($dep == 'Power'): ?>
                    <a href="Delete_quest.php?id2=<?php echo $id; ?>" class="btn btn-disabled">
                        <i class="fas fa-trash-alt"></i> Cancel Site with all technologies
                    </a>
                    <?php else: ?>
                    <a href="Delete_quest.php?id2=<?php echo $id; ?>" class="btn btn-secondary">
                        <i class="fas fa-trash-alt"></i> Cancel Site with all technologies
                    </a>
                    <?php endif; ?>
                </div>

                <?php else: ?>
                <div class="message">
                    <i class="fas fa-exclamation-triangle"></i> Site does not exist in our database.
                </div>
                <?php endif; ?>
            </div>

            <!-- 2G Info Section -->
            <div class="result-section">
                <div class="section-title">
                    <h2><i class="fas fa-signal"></i> 2G Site Information</h2>
                </div>

                <?php
                        if($roww = oci_fetch_array($resultt, OCI_ASSOC + OCI_RETURN_NULLS)):
                            $id2 = $roww['SITE_ID'];
                    ?>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Cell Code</th>
                                <th>Cell Name</th>
                                <th>Cell ID</th>
                                <th>On Air Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php do { ?>
                            <tr>
                                <td><?php echo $roww['CELL_CODE']; ?></td>
                                <td><?php echo $roww['CELL_NAME']; ?></td>
                                <td><?php echo $roww['CELL_ID']; ?></td>
                                <td><?php echo $roww['CELL_ON_AIR_DATE']; ?></td>
                                <td>
                                    <?php if($dep == 'Power'): ?>
                                    <a href="#" class="action-link update btn-disabled">
                                        <i class="fas fa-edit"></i> <span>Update</span>
                                    </a>
                                    <a href="#" class="action-link delete btn-disabled">
                                        <i class="fas fa-trash"></i> <span>Delete</span>
                                    </a>
                                    <?php else: ?>
                                    <a href="update2G.php?id2=<?php echo $roww['SITE_ID']; ?>"
                                        class="action-link update">
                                        <i class="fas fa-edit"></i> <span>Update</span>
                                    </a>
                                    <a href="delete2Gcellquest.php?id2=<?php echo $roww['CELL_CODE']; ?>"
                                        class="action-link delete">
                                        <i class="fas fa-trash"></i> <span>Delete</span>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php } while ($roww = oci_fetch_array($resultt, OCI_ASSOC + OCI_RETURN_NULLS)); ?>
                        </tbody>
                    </table>
                </div>

                <div class="button-group">
                    <a href="info2G.php?id2=<?php echo $id2; ?>" class="btn btn-primary">
                        <i class="fas fa-info-circle"></i> More Details
                    </a>
                    <?php if($dep == 'Power'): ?>
                    <a href="Delete2Gquest.php?id12=<?php echo $id; ?>" class="btn btn-disabled">
                        <i class="fas fa-trash"></i> Cancel 2G Site
                    </a>
                    <?php else: ?>
                    <a href="Delete2Gquest.php?id12=<?php echo $id; ?>" class="btn btn-secondary">
                        <i class="fas fa-trash"></i> Cancel 2G Site
                    </a>
                    <?php endif; ?>
                </div>

                <?php else: ?>
                <div class="message">
                    <i class="fas fa-exclamation-triangle"></i> 2G site information not found for this site.
                    <?php if(isset($id) && !empty($id)): ?>
                    <div class="button-group" style="margin-top: 15px;">
                        <a href="2G.php?id=<?php echo $id; ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add 2G Technology
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- 3G Info Section -->
            <div class="result-section">
                <div class="section-title">
                    <h2><i class="fas fa-signal"></i> 3G Site Information</h2>
                </div>

                <?php
                        if($roww2 = oci_fetch_array($resultt2, OCI_ASSOC + OCI_RETURN_NULLS)):
                            $id3 = $roww2['SITE_ID'];
                    ?>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Cell Code</th>
                                <th>Cell Name</th>
                                <th>Cell ID</th>
                                <th>Site On Air Date</th>
                                <th>Cell On Air Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php do { ?>
                            <tr>
                                <td><?php echo $roww2['CELL_CODE']; ?></td>
                                <td><?php echo $roww2['CELL_NAME']; ?></td>
                                <td><?php echo $roww2['CELL_ID']; ?></td>
                                <td><?php echo $roww2['THREE_G_ON_AIR_DATE']; ?></td>
                                <td><?php echo $roww2['ON_AIR_DATE']; ?></td>
                                <td>
                                    <?php if($dep == 'Power'): ?>
                                    <a href="#" class="action-link update btn-disabled">
                                        <i class="fas fa-edit"></i> <span>Update</span>
                                    </a>
                                    <a href="#" class="action-link delete btn-disabled">
                                        <i class="fas fa-trash"></i> <span>Delete</span>
                                    </a>
                                    <?php else: ?>
                                    <a href="update3G.php?id3=<?php echo $roww2['SITE_ID']; ?>"
                                        class="action-link update">
                                        <i class="fas fa-edit"></i> <span>Update</span>
                                    </a>
                                    <a href="delete3Gcellquest.php?id3=<?php echo $roww2['CELL_CODE']; ?>"
                                        class="action-link delete">
                                        <i class="fas fa-trash"></i> <span>Delete</span>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php } while ($roww2 = oci_fetch_array($resultt2, OCI_ASSOC + OCI_RETURN_NULLS)); ?>
                        </tbody>
                    </table>
                </div>

                <div class="button-group">
                    <a href="Info3G.php?id3=<?php echo $id3; ?>" class="btn btn-primary">
                        <i class="fas fa-info-circle"></i> More Details
                    </a>
                    <?php if($dep == 'Power'): ?>
                    <a href="delete3Gques.php?id13=<?php echo $id; ?>" class="btn btn-disabled">
                        <i class="fas fa-trash"></i> Cancel 3G Site
                    </a>
                    <?php else: ?>
                    <a href="delete3Gques.php?id13=<?php echo $id; ?>" class="btn btn-secondary">
                        <i class="fas fa-trash"></i> Cancel 3G Site
                    </a>
                    <?php endif; ?>
                </div>

                <?php else: ?>
                <div class="message">
                    <i class="fas fa-exclamation-triangle"></i> 3G site information not found for this site.
                    <?php if(isset($id) && !empty($id)): ?>
                    <div class="button-group" style="margin-top: 15px;">
                        <a href="3G.php?id2=<?php echo $id; ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add 3G Technology
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- 4G Info Section -->
            <div class="result-section">
                <div class="section-title">
                    <h2><i class="fas fa-signal"></i> 4G Site Information</h2>
                </div>

                <?php
                        if($roww3 = oci_fetch_array($resultt3, OCI_ASSOC + OCI_RETURN_NULLS)):
                            $id4 = $roww3['SID'];
                    ?>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Cell Code</th>
                                <th>Cell Name</th>
                                <th>Cell ID</th>
                                <th>Site On Air Date</th>
                                <th>Cell On Air Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php do { ?>
                            <tr>
                                <td><?php echo $roww3['CELL_CODE']; ?></td>
                                <td><?php echo $roww3['CELL_NAME']; ?></td>
                                <td><?php echo $roww3['CELL_ID']; ?></td>
                                <td><?php echo $roww3['ACTIVATION_DATE']; ?></td>
                                <td><?php echo $roww3['ON_AIR_DATE']; ?></td>
                                <td>
                                    <?php if($dep == 'Power'): ?>
                                    <a href="#" class="action-link update btn-disabled">
                                        <i class="fas fa-edit"></i> <span>Update</span>
                                    </a>
                                    <a href="#" class="action-link delete btn-disabled">
                                        <i class="fas fa-trash"></i> <span>Delete</span>
                                    </a>
                                    <?php else: ?>
                                    <a href="update4G.php?id4=<?php echo $roww3['SID']; ?>" class="action-link update">
                                        <i class="fas fa-edit"></i> <span>Update</span>
                                    </a>
                                    <a href="delete4Gcellquest.php?id4=<?php echo $roww3['CELL_CODE']; ?>"
                                        class="action-link delete">
                                        <i class="fas fa-trash"></i> <span>Delete</span>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php } while ($roww3 = oci_fetch_array($resultt3, OCI_ASSOC + OCI_RETURN_NULLS)); ?>
                        </tbody>
                    </table>
                </div>  

                <div class="button-group">
                    <a href="Info4G.php?id4=<?php echo $id4; ?>" class="btn btn-primary">
                        <i class="fas fa-info-circle"></i> More Details
                    </a>
                    <button type="button" class="btn btn-primary"
                        onclick="showPowerSummaryModal(<?php echo $row['ID']; ?>)">
                        <i class="fa fa-list-alt"></i> Power Summary
                    </button>
                    <?php if($dep == 'Power'): ?>
                    <a href="delete4Gques.php?id14=<?php echo $id; ?>" class="btn btn-disabled">
                        <i class="fas fa-trash"></i> Cancel 4G Site
                    </a>
                    <!-- Add this to the bottom of the site search page, before the footer -->
                    <div id="powerSummaryModal"
                        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; justify-content:center; align-items:center;">
                        <div
                            style="background:white; padding:20px; border-radius:8px; max-width:900px; width:90%; max-height:90vh; overflow:auto;">
                            <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                                <h3>Power Backup Summary</h3>
                                <button onclick="hidePowerSummaryModal()"
                                    style="background:none; border:none; font-size:1.5rem; cursor:pointer;">&times;</button>
                            </div>
                            <iframe id="powerSummaryFrame"
                                style="width:100%; height:700px; border:none; transition: opacity 0.4s ease;"></iframe>
                        </div>
                    </div>


            
                    <script>
                    function showPowerSummaryModal(siteId) {
                        const modal = document.getElementById('powerSummaryModal');
                        const iframe = document.getElementById('powerSummaryFrame');
                        iframe.src = 'power_summary.php?id=' + siteId;
                        modal.style.display = 'flex';
                    }

                    function hidePowerSummaryModal() {
                        const modal = document.getElementById('powerSummaryModal');
                        const iframe = document.getElementById('powerSummaryFrame');
                        modal.style.display = 'none';
                        iframe.src = '';
                    }

                    // Close modal when clicking outside
                    window.addEventListener('click', function(event) {
                        const modal = document.getElementById('powerSummaryModal');
                        if (event.target === modal) {
                            hidePowerSummaryModal();
                        }
                    });
                    </script>
                    <?php else: ?>
                    <a href="delete4Gques.php?id14=<?php echo $id; ?>" class="btn btn-secondary">
                        <i class="fas fa-trash"></i> Cancel 4G Site
                    </a>
                    <?php endif; ?>
                </div>

                <?php else: ?>
                <div class="message">
                    <i class="fas fa-exclamation-triangle"></i> 4G site information not found for this site.
                    <?php if(isset($id) && !empty($id)): ?>
                    <div class="button-group" style="margin-top: 15px;">
                        <a href="4G.php?id3=<?php echo $id; ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add 4G Technology
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <?php } // End of valid site code check ?>
            <?php else: ?>
            <div class="info-card" style="text-align: center; margin-top: 30px;">
                <h3 style="color: var(--primary); margin-bottom: 15px;">
                    <i class="fas fa-search fa-2x"></i>
                </h3>
                <p>Enter a site code in the search box above to view site information.</p>
                <p style="color: var(--gray); font-size: 0.9rem; margin-top: 10px;">
                    Example site codes: DAM123, HMS456, TRS789
                </p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; <?php echo date('Y'); ?> MTN Syria - Network Division | Quality & Performance Team</p>
        </div>
    </div>

    <script>
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Focus on search input on page load
    window.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            searchInput.focus();
        }
    });
    </script>
</body>

</html>