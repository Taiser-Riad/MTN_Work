<?php 
include "config.php";
?>
<?php
if(isset($_GET['id2']))
{
$siteid =$_GET['id2'];
$sql= "SELECT s.*,  t.* , c.* FROM NEW_SITES s JOIN TWO_G_SITES t ON(s.ID = t.SITE_ID) JOIN TWO_G_CELLS c ON (t.CELL_ID = c.CID_KEY)     WHERE  t.SITE_ID = :siteid";
$result = oci_parse($conn,$sql);
oci_bind_by_name($result ,':siteid' ,$siteid);
oci_execute($result);
$row = oci_fetch_array($result , OCI_ASSOC + OCI_RETURN_NULLS);

$sqll= "SELECT t.* , c.* FROM  TWO_G_SITES t JOIN TWO_G_CELLS c ON (t.CELL_ID = c.CID_KEY) WHERE t.Site_ID = :siteid";
$resultt = oci_parse($conn,$sqll);
oci_bind_by_name($resultt ,':siteid' ,$siteid);

if (oci_execute($resultt)){
    $data = [
        'A' => null, 'B' => null, 'C' => null, 'D' => null, 
        'X' => null, 'Y' => null, 'Z' => null, 'W' => null, 
        'V' => null, 'E' => null,
    ];
       
    while ($row1 = oci_fetch_array($resultt , OCI_ASSOC + OCI_RETURN_NULLS)){
        $cellcode_char  =substr($row1['CELL_CODE'],-1);
        if (in_array($cellcode_char , ['A','B','C','D','X','Y','Z','D','W','V','E'])){
            $data[$cellcode_char] = $row1;
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
    <title>MTN Syria | 2G Site Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1c355c;
            --secondary: #ff6600;
            --accent: #f0b52d;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --success: #28a745;
            --card-shadow: 0 8px 30px rgba(0,0,0,0.12);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: goldenrod;;
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            position: sticky;
            top: 0;
            background: var(--primary);
            color: white;
            padding: 15px 0;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 60px;
            height: 60px;
            background: #fff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .logo-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.4rem;
        }

        .logo-text span {
            color: var(--accent);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: var(--primary);
        }

        #welcome {
            font-size: 0.95rem;
        }

        .logout-button {
            padding: 8px 15px;
            background-color: var(--secondary);
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: var(--transition);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .logout-button:hover {
            background-color: #e55a00;
            transform: translateY(-2px);
        }

        /* Main Content Styles */
        .site-header {
            background: linear-gradient(135deg, var(--primary) 0%, #0d1a30 100%);
            color: white;
            padding: 40px 0;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 0 0 12px 12px;
            box-shadow: var(--card-shadow);
        }

        .site-code {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .site-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
        }

        .info-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            transition: var(--transition);
        }

        .info-card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(28, 53, 92, 0.1);
        }

        .card-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.5rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title i {
            color: var(--secondary);
        }

        .toggle-btn {
            background: rgba(28, 53, 92, 0.1);
            border: none;
            border-radius: 6px;
            padding: 8px 15px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .toggle-btn:hover {
            background: rgba(28, 53, 92, 0.2);
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        .info-table th {
            background-color: var(--primary);
            color: white;
            text-align: left;
            padding: 15px;
            font-weight: 500;
        }

        .info-table td {
            padding: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .info-table tr:nth-child(even) {
            background-color: rgba(28, 53, 92, 0.03);
        }

        .info-table tr:hover {
            background-color: rgba(28, 53, 92, 0.05);
        }

        .notes-section {
            background: rgba(28, 53, 92, 0.05);
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .notes-label {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 10px;
            display: block;
        }

        .notes-content {
            background: white;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            min-height: 60px;
        }

        /* Footer */
        footer {
            background: var(--primary);
            color: white;
            padding: 30px 0 20px;
            margin-top: 40px;
            border-radius: 12px 12px 0 0;
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .footer-logo {
            font-family: 'Poppins', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .footer-logo span {
            color: var(--accent);
        }

        .footer-about {
            max-width: 300px;
            opacity: 0.8;
            line-height: 1.7;
            font-size: 0.95rem;
        }

        .footer-heading {
            font-size: 1.1rem;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .footer-links a:hover {
            color: white;
        }

        .contact-info {
            list-style: none;
        }

        .contact-info li {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            color: rgba(255,255,255,0.8);
            font-size: 0.95rem;
        }

        .copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.6);
            font-size: 0.85rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-primary {
            background: var(--secondary);
            color: white;
        }

        .btn-primary:hover {
            background: #e55a00;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: var(--primary);
            color: white;
        }

        .btn-secondary:hover {
            background: #152645;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .site-code {
                font-size: 2rem;
            }
            
            .info-table th, 
            .info-table td {
                padding: 12px 10px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 768px) {
            .card-title {
                font-size: 1.3rem;
            }
            
            .info-card {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .site-code {
                font-size: 1.8rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <div class="logo-container">
                <div class="logo">
                    <i class="fas fa-tower-cell" style="font-size: 2rem; color: var(--primary);"></i>
                </div>
                <div class="logo-text">MTN <span>Syria</span></div>
            </div>
            
            <div class="user-info">
                <?php
                if (isset($_COOKIE['loggedInUser'])) {
                    $username = htmlspecialchars($_COOKIE['loggedInUser']);
                    $initial = strtoupper(substr($username, 0, 1));
                    echo "<div class='user-avatar'>$initial</div>";
                    echo "<span id='welcome'>Welcome, <strong>$username</strong></span>";
                }
                ?>
            </div>
        </div>
    </header>

    <!-- Site Header -->
    <div class="site-header">
        <div class="container">
            <div class="site-code"><?php echo $row['SITE_CODE']; ?></div>
            <div class="site-subtitle">2G Site Details</div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit="window.close();">
            <input type="hidden" name="id" value="<?php echo $siteid; ?>">
            <input type="hidden" name="cid" value="<?php echo $row['CID_KEY']; ?>">

            <!-- Site Information Card -->
            <div class="info-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Site Information</h3>
                    <button type="button" class="toggle-btn" aria-label="Toggle section">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                
                <div class="table-container">
                    <table class="info-table">
                        <thead>
                            <tr>
                                <th>Property</th>
                                <th>Value</th>
                                <th>Property</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Site Code</strong></td>
                                <td><?php echo $row['SITE_CODE']; ?></td>
                                <td><strong>2G On Air Date</strong></td>
                                <td><?php echo $row['TWOG_ON_AIR_DATE']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Band Width</strong></td>
                                <td><?php echo $row['BAND']; ?></td>
                                <td><strong>Site Status</strong></td>
                                <td><?php echo $row['SITE_STATUS']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>BTS Type</strong></td>
                                <td><?php echo $row['BTS_TYPE']; ?></td>
                                <td><strong>900 GSM RBS Type</strong></td>
                                <td><?php echo $row['NINTY_GSM_RBS_TYPE']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>900 On Air Date</strong></td>
                                <td><?php echo $row['NINTY_ON_AIR_DATE']; ?></td>
                                <td><strong>1800 GSM RBS Type</strong></td>
                                <td><?php echo $row['EIGHTY_GSM_RBS_TYPE']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>1800 On Air Date</strong></td>
                                <td><?php echo $row['EIGHTY_ON_AIR_DATE']; ?></td>
                                <td><strong>BSC</strong></td>
                                <td><?php echo $row['BSC']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>Real BSC</strong></td>
                                <td><?php echo $row['REAL_BSC']; ?></td>
                                <td><strong>LAC</strong></td>
                                <td><?php echo $row['LAC']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="notes-section">
                    <span class="notes-label">Site Notes:</span>
                    <div class="notes-content"><?php echo $row['NOTES'] ? $row['NOTES'] : 'No notes available'; ?></div>
                </div>
            </div>

            <!-- Cells Information Card -->
            <div class="info-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-broadcast-tower"></i> Cells Information</h3>
                    <button type="button" class="toggle-btn" aria-label="Toggle section">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                
                <div class="table-container">
                    <table class="info-table">
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
                                <th>Serving Area</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach (['A','B','C','D','X','Y','Z','W','V','E'] as $cellcode_char) {
                                if (isset($data[$cellcode_char])) { 
                                    $cell = $data[$cellcode_char];
                            ?>
                            <tr>
                                <td><?= $cell['CELL_CODE'] ?? '-' ?></td>
                                <td><?= $cell['CELL_ID'] ?? '-' ?></td>
                                <td><?= $cell['CELL_NAME'] ?? '-' ?></td>
                                <td><?= $cell['AZIMUTH'] ?? '-' ?></td>
                                <td><?= $cell['CELL_ON_AIR_DATE'] ?? '-' ?></td>
                                <td><?= $cell['HIEGHT'] ?? '-' ?></td>
                                <td><?= $cell['BSIC'] ?? '-' ?></td>
                                <td><?= $cell['BCCH'] ?? '-' ?></td>
                                <td><?= $cell['M_TILT'] ?? '-' ?></td>
                                <td><?= $cell['E_TILT'] ?? '-' ?></td>
                                <td><?= $cell['CGI'] ?? '-' ?></td>
                                <td><?= $cell['SERVING_AREA'] ?? '-' ?></td>
                            </tr>
                            <?php 
                                }
                            } 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button type="button" class="btn btn-secondary" onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
                <button type="submit" name="submit" class="btn btn-primary">
                    <i class="fas fa-check-circle"></i> Done
                </button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-about">
                    <div class="footer-logo">MTN <span>Syria</span></div>
                    <p>Providing cutting-edge telecommunications services across Syria with a commitment to quality and innovation.</p>
                </div>
                
                <div>
                    <h3 class="footer-heading">Contact Support</h3>
                    <ul class="contact-info">
                        <li><i class="fas fa-envelope"></i> support@mtn.com.sy</li>
                        <li><i class="fas fa-phone"></i> +963 11 222 3333</li>
                        <li><i class="fas fa-map-marker-alt"></i> Damascus, Syria</li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; <?php echo date("Y"); ?> MTN Syria. All rights reserved. | Quality & Performance Team, Network Division</p>
            </div>
        </div>
    </footer>

    <script>
        // Collapsible sections
        document.querySelectorAll('.toggle-btn').forEach(button => {
            button.addEventListener('click', () => {
                const card = button.closest('.info-card');
                const content = card.querySelector('.table-container, .notes-section');
                const icon = button.querySelector('i');
                
                if (content.style.display === 'none') {
                    content.style.display = 'block';
                    icon.className = 'fas fa-chevron-down';
                } else {
                    content.style.display = 'none';
                    icon.className = 'fas fa-chevron-up';
                }
            });
        });

        // Print button functionality
        document.querySelector('.btn-secondary').addEventListener('click', () => {
            window.print();
        });
    </script>
</body>
</html>