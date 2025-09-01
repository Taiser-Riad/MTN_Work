<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Information | MTN Syria</title>
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
        max-width: 1000px;
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
        padding: 30px 20px;
        position: relative;
    }

    .header h1 {
        font-size: 2rem;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .header p {
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
        opacity: 0.9;
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

    /* Info Content */
    .info-container {
        padding: 30px;
    }

    .info-card {
        background: white;
        border-radius: 8px;
        padding: 25px;
        box-shadow: var(--card-shadow);
        margin-bottom: 25px;
    }

    .info-card h2 {
        color: var(--primary);
        font-size: 1.5rem;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--light);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-item strong {
        color: var(--primary);
        margin-bottom: 5px;
        font-size: 0.95rem;
    }

    .info-item .info-value {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 0.95rem;
        color: var(--dark);
        min-height: 40px;
        display: flex;
        align-items: center;
        border-color:gray;
    }

    
    .info-item select.info-value {
        width: 100%;
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 0.95rem;
        color: var(--dark);
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%231c355c' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1em;
        border-color:gray;
    }

    /* Buttons */
    .button-group {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 20px;
        flex-wrap: wrap;
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
        border: none;
        cursor: pointer;
        font-size: 1rem;
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
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .header h1 {
            font-size: 1.6rem;
            padding-top: 10px;
        }
        
        .header p {
            font-size: 1rem;
        }
        
        .info-container {
            padding: 20px 15px;
        }
        
        .button-group {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }

    /* Print Styles - Optimized for single page */
    @media print {
        body {
            background: white;
            padding: 0;
            font-size: 10pt;
            line-height: 1.4;
        }

        .container {
            max-width: 100%;
            box-shadow: none;
            border-radius: 0;
            margin: 0;
            padding: 0;
        }

        .header {
            background: var(--primary) !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            padding: 15px 0;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 18pt;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 10pt;
        }

        .back-button, .button-group {
            display: none !important;
        }

        .info-container {
            padding: 0 10px;
        }

        .info-card {
            box-shadow: none;
            padding: 0;
            margin-bottom: 0;
        }

        .info-card h2 {
            font-size: 14pt;
            margin-bottom: 10px;
            padding-bottom: 5px;
        }

        .info-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .info-item {
            margin-bottom: 5px;
        }

        .info-item strong {
            font-size: 9pt;
            margin-bottom: 2px;
        }

        .info-item .info-value {
            font-size: 9pt;
            padding: 5px 8px;
            min-height: 30px;
            background: transparent !important;
            border: 1px solid #ddd !important;
        }

        select.info-value {
            background-image: none !important;
            padding-right: 8px !important;
        }

        .footer {
            font-size: 8pt;
            padding: 10px;
            margin-top: 10px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        @page {
            size: A4 portrait;
            margin: 0.5cm;
        }

        /* Hide URL and page info when printing */
        @page {
            @bottom-right {
                content: none;
            }
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

            <h1><i class="fas fa-info-circle"></i> Site Information</h1>
            <p>Detailed information about the site</p>
        </div>

        <!-- Information Container -->
        <div class="info-container">
            <div class="info-card">
                <h2><i class="fas fa-wifi"></i> Basic Site Information</h2>
                
                <div class="info-grid">
                    <?php 
                    include "config.php";
                    if(isset($_GET['id2'])) {
                        $siteid = $_GET['id2'];
                        $sqll = "SELECT * FROM NEW_SITES WHERE ID= :siteid";
                        $result = oci_parse($conn, $sqll);
                        oci_bind_by_name($result, ':siteid', $siteid);
                        oci_execute($result);
                        $row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS);
                    }
                    ?>
                    
                    <div class="info-item">
                        <strong>Site Code:</strong>
                        <div class="info-value"><?php echo $row['SITE_CODE'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="info-item">
                        <strong>Site Name:</strong>
                        <div class="info-value"><?php echo $row['SITE_NAME'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="info-item">
                        <strong>Zone:</strong>
                        <div class="info-value"><?php echo $row['ZONE'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="info-item">
                        <strong>Province:</strong>
                        <div class="info-value"><?php echo $row['PROVINCE'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="info-item">
                        <strong>City / Rural:</strong>
                        <div class="info-value"><?php echo $row['CR'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="info-item">
                        <strong>Supplier:</strong>
                        <div class="info-value"><?php echo $row['SUPPLIER'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="info-item">
                        <strong>Power Backup:</strong>
                        <div class="info-value"><?php echo $row['POWER_BACKUP'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="info-item">
                        <strong>On Air Date:</strong>
                        <div class="info-value"><?php echo $row['SITE_ON_AIR_DATE'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="info-item">
                        <strong>Coordinates E:</strong>
                        <div class="info-value"><?php echo $row['COORDINATES_E'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="info-item">
                        <strong>Coordinates N:</strong>
                        <div class="info-value"><?php echo $row['COORDINATES_N'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="info-item">
                        <strong>Altitude:</strong>
                        <div class="info-value"><?php echo $row['ALTTITUDE'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="info-item">
                        <strong>Site Address:</strong>
                        <div class="info-value"><?php echo $row['SITE_ADDRESS'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="info-item">
                        <strong>Arabic Name:</strong>
                        <div class="info-value"><?php echo $row['ARABIC_NAME'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="info-item">
                        <strong>Administrative Area:</strong>
                        <div class="info-value"><?php echo $row['ADMINSTRITAVE_AREA'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="info-item">
                        <strong>TX Node:</strong>
                        <div class="info-value"><?php echo $row['NODE_CATEGORY'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="info-item">
                        <strong>Node Category:</strong>
                        <select class="info-value" disabled>
                            <option value="Empty">--</option>  
                            <option value="Normal" <?php if(isset($row['NODE_CATEGORY']) && $row['NODE_CATEGORY'] == "Normal") echo 'selected'; ?>>Normal</option>
                            <option value="Golden" <?php if(isset($row['NODE_CATEGORY']) && $row['NODE_CATEGORY'] == "Golden") echo 'selected'; ?>>Golden</option>
                            <option value="Silver" <?php if(isset($row['NODE_CATEGORY']) && $row['NODE_CATEGORY'] == "Silver") echo 'selected'; ?>>Silver</option>
                            <option value="Tail" <?php if(isset($row['NODE_CATEGORY']) && $row['NODE_CATEGORY'] == "Tail") echo 'selected'; ?>>Tail</option>
                        </select>
                    </div>
                    
                    <div class="info-item">
                        <strong>Technical Priority:</strong>
                        <select class="info-value" disabled>
                            <option value="Empty">--</option>  
                            <option value="Priority 1" <?php if(isset($row['TECHNICAL_PRIORITY']) && $row['TECHNICAL_PRIORITY'] == "Priority 1") echo 'selected'; ?>>Priority1</option>
                            <option value="Priority 2" <?php if(isset($row['TECHNICAL_PRIORITY']) && $row['TECHNICAL_PRIORITY'] == "Priority 2") echo 'selected'; ?>>Priority2</option>
                            <option value="Priority 3" <?php if(isset($row['TECHNICAL_PRIORITY']) && $row['TECHNICAL_PRIORITY'] == "Priority 3") echo 'selected'; ?>>Priority3</option>
                            <option value="Priority 4" <?php if(isset($row['TECHNICAL_PRIORITY']) && $row['TECHNICAL_PRIORITY'] == "Priority 4") echo 'selected'; ?>>Priority4</option>
                        </select>
                    </div>
                    
                    <div class="info-item">
                        <strong>Subcontractor:</strong>
                        <select class="info-value" disabled>
                            <option value="Empty">--</option>  
                            <option value="Brj" <?php if(isset($row['SUBCONTRACTOR']) && $row['SUBCONTRACTOR'] == "Brj") echo 'selected'; ?>>Brj</option>
                            <option value="Wetel" <?php if(isset($row['SUBCONTRACTOR']) && $row['SUBCONTRACTOR'] == "Wetel") echo 'selected'; ?>>Wetel</option>
                            <option value="others" <?php if(isset($row['SUBCONTRACTOR']) && $row['SUBCONTRACTOR'] == "others") echo 'selected'; ?>>Others</option>
                        </select>
                    </div>
                    
                    <div class="info-item">
                        <strong>Invoice Topology:</strong>
                        <select class="info-value" disabled>
                            <option value="Empty">--</option>  
                            <option value="Tower / Generator / Solar and or TX Repeater" <?php if(isset($row['INVOICE_TYOLOGY']) && $row['INVOICE_TYOLOGY'] == "Tower / Generator / Solar and or TX Repeater") echo 'selected'; ?>>Tower / Generator / Solar and or TX Repeater</option>
                            <option value="PTS Shelter / Indoor shelter and or TX node" <?php if(isset($row['INVOICE_TYOLOGY']) && $row['INVOICE_TYOLOGY'] == "PTS Shelter / Indoor shelter and or TX node") echo 'selected'; ?>>PTS Shelter / Indoor shelter and or TX node</option>
                            <option value="Other" <?php if(isset($row['INVOICE_TYOLOGY']) && $row['INVOICE_TYOLOGY'] == "Other") echo 'selected'; ?>>Others</option>
                        </select>
                    </div>
                    
                    <div class="info-item">
                        <strong>Site Ranking:</strong>
                        <select class="info-value" disabled>
                            <option value="Empty">--</option>  
                            <option value="Priority 1" <?php if(isset($row['SITE_RANKING']) && $row['SITE_RANKING'] == "Priority 1") echo 'selected'; ?>>Priority1</option>
                            <option value="Priority 1-Tourism" <?php if(isset($row['SITE_RANKING']) && $row['SITE_RANKING'] == "Priority 1-Tourism") echo 'selected'; ?>>Priority1-Tourism</option>
                            <option value="Priority 2" <?php if(isset($row['SITE_RANKING']) && $row['SITE_RANKING'] == "Priority 2") echo 'selected'; ?>>Priority2</option>
                            <option value="Priority 2-Tourism" <?php if(isset($row['SITE_RANKING']) && $row['SITE_RANKING'] == "Priority 2-Tourism") echo 'selected'; ?>>Priority2-Tourism</option>
                            <option value="Priority 3" <?php if(isset($row['SITE_RANKING']) && $row['SITE_RANKING'] == "Priority 3") echo 'selected'; ?>>Priority3</option>
                            <option value="Priority 3-Tourism" <?php if(isset($row['SITE_RANKING']) && $row['SITE_RANKING'] == "Priority 3-Tourism") echo 'selected'; ?>>Priority3-Tourism</option>
                            <option value="Priority 4" <?php if(isset($row['SITE_RANKING']) && $row['SITE_RANKING'] == "Priority 4") echo 'selected'; ?>>Priority4</option>
                            <option value="Priority 4-Tourism" <?php if(isset($row['SITE_RANKING']) && $row['SITE_RANKING'] == "Priority 4-Tourism") echo 'selected'; ?>>Priority4-Tourism</option>
                            <option value="VIP" <?php if(isset($row['SITE_RANKING']) && $row['SITE_RANKING'] == "VIP") echo 'selected'; ?>>VIP</option>
                            <option value="VIP-Tourism" <?php if(isset($row['SITE_RANKING']) && $row['SITE_RANKING'] == "VIP-Tourism") echo 'selected'; ?>>VIP-Tourism</option>
                        </select>
                    </div>
                </div>
                
                <div class="button-group">
                    <button class="btn btn-secondary" onclick="window.print();">
                        <i class="fas fa-print"></i> Print Details
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; <?php echo date('Y'); ?> MTN Syria - Network Division | Quality & Performance Team</p>
        </div>
    </div>
</body>
</html>