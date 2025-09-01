<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Backup Configuration</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #1c355c;
            --secondary: #3498db;
            --accent: #f39c12;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #28a745;
            --border-radius: 8px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        body {
            background-color: #f5f7fa;
            color: var(--dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            min-height: 100vh;
        }
        
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 24px;
        }
        
        .card-header {
            background: linear-gradient(to right, var(--primary), #2c5282);
            color: white;
            border-radius: var(--border-radius) !important;
            padding: 16px 20px;
        }
        
        .section-header {
            background-color: #e9ecef;
            border-radius: 6px;
            padding: 12px 16px;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .section-header:hover {
            background-color: #dee2e6;
        }
        
        .section-header h5 {
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .required::after {
            content: " *";
            color: var(--accent);
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background-color: #152642;
            border-color: #152642;
        }
        
        .info-box {
            background-color: #e8f4fc;
            border-left: 4px solid var(--secondary);
            padding: 16px;
            border-radius: 4px;
            margin-top: 20px;
        }
        
        .tank-card, .battery-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            height: 100%;
            transition: all 0.3s ease;
        }
        
        .tank-card:hover, .battery-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-3px);
        }
        
        .compatibility-note.compatible {
            color: var(--success);
        }
        
        .compatibility-note.incompatible {
            color: #dc3545;
        }
        
        .search-container {
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* Modern form controls */
        .form-control:focus, .form-select:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }
        
        /* Custom checkbox and radio buttons */
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        /* Improved card headers */
        .card-header h3 {
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        /* Status badges */
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .badge-active {
            background-color: #d4edda;
            color: #155724;
        }
        
        .badge-inactive {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        /* Animation for section expansion */
        .collapse {
            transition: all 0.3s ease;
        }
        
        /* Modern button styles */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .section-content {
                padding: 16px;
            }
            
            .tank-card, .battery-card {
                margin-bottom: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <form id="powerConfigForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <!-- Header Section -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="searchpower.php?user=<?php echo $userrname; ?>" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                    
                    <div class="text-center">
                        <h3 class="mb-1"><i class="fas fa-bolt me-2"></i>Power Backup Configuration</h3>
                        <p class="mb-0">Comprehensive setup for your site's power systems</p>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" 
                             style="width: 40px; height: 40px;">
                            <span class="fw-bold text-primary"><?php echo strtoupper(substr($userrname, 0, 2)); ?></span>
                        </div>
                        <?php
                        if (isset($_COOKIE['loggedInUser'])) {
                            $username = htmlspecialchars($_COOKIE['loggedInUser']);
                            echo '<a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>';
                        } else {
                            echo '<a href="index.php" class="btn btn-outline-primary btn-sm"><i class="fas fa-sign-in-alt"></i> Login</a>';
                        }
                        ?>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <div>All changes are logged in the audit trail for security and compliance purposes.</div>
                    </div>
                    
                    <!-- Search Form -->
                    <div class="search-container bg-light p-4 rounded mb-3">
                        <input type="hidden" name="userid1" value="<?php echo $user_id; ?>">
                        <input type="hidden" name="username1" value="<?php echo $userrname; ?>">
                        
                        <div class="input-group">
                            <input type="text" class="form-control" name="searchcode" 
                                   placeholder="Enter site code (e.g., DAM123)" 
                                   value="<?php echo $row['SITE_CODE'] ?? ''; ?>">
                            <button type="submit" name="Search" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i> Search
                            </button>
                        </div>
                    </div>
                    
                    <div class="alert alert-success d-flex align-items-center" id="successMessage" style="display: none;">
                        <i class="fas fa-check-circle me-2"></i> Configuration saved successfully!
                    </div>
                </div>
            </div>
            
            <!-- Site Information Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="mb-0"><i class="fas fa-building me-2"></i>Site Information</h3>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="siteCode" class="form-label"><i class="fas fa-qrcode"></i> Site Code</label>
                            <input type="text" class="form-control" id="siteCode" name="sitecode" 
                                   value="<?php echo $row['SITE_CODE'] ?? ''; ?>" readonly>
                            <input type="hidden" name="id" value="<?php echo $siteid; ?>">
                            <input type="hidden" name="userid" value="<?php echo $user_id; ?>">
                            <input type="hidden" name="username" value="<?php echo $userrname; ?>">
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="siteName" class="form-label"><i class="fas fa-map-marker-alt"></i> Site Name</label>
                            <input type="text" class="form-control" id="siteName" name="siteName" 
                                   value="<?php echo htmlspecialchars($row['SITE_NAME'] ?? ''); ?>" readonly>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label"><i class="fa fa-list-alt"></i> Summary</label>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-primary" onclick="showPowerInfoModal()">
                                    <i class="fas fa-eye me-1"></i> View
                                </button>
                                <?php echo "<a href='export power.php' class='btn btn-outline-success'><i class='fas fa-download me-1'></i>Export</a>"; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Electrical Counter Section -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center" 
                     data-bs-toggle="collapse" data-bs-target="#electricalCounterSection" aria-expanded="true">
                    <h3 class="mb-0"><i class="fas fa-tachometer-alt me-2"></i>Electrical Counter</h3>
                    <i class="fas fa-chevron-down"></i>
                </div>
                
                <div class="collapse show" id="electricalCounterSection">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="counter_serial" class="form-label"><i class="fas fa-hashtag"></i> Serial Number</label>
                                <input type="text" class="form-control" id="counter_serial" name="serial" 
                                       placeholder="Enter serial number" value="<?php echo $serial_number ?? ''; ?>">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="counter_breaker" class="form-label"><i class="fas fa-plug"></i> Counter Circuit Breaker</label>
                                <input type="text" class="form-control" id="counter_breaker" name="counter" 
                                       placeholder="Enter breaker details" value="<?php echo $COUNTER_CIRCUIT_BREAKER ?? ''; ?>">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="counter_status" class="form-label"><i class="fas fa-info-circle"></i> Counter Status</label>
                                <select class="form-select" id="counter_status" name="cstatus">
                                    <option value="">-- Select Status --</option>
                                    <option value="Not Exsist" <?php if(($STATUS ?? '') == "Not Exsist") echo 'Selected'; ?>>Not Exsist</option>
                                    <option value="Good" <?php if(($STATUS ?? '') == "Good") echo 'Selected'; ?>>Good</option>
                                    <option value="Bad" <?php if(($STATUS ?? '') == "Bad") echo 'Selected'; ?>>Bad</option>
                                    <option value="Need replace" <?php if(($STATUS ?? '') == "Need replace") echo 'Selected'; ?>>Need replace</option>
                                    <option value="Need Overhauling" <?php if(($STATUS ?? '') == "Need Overhauling") echo 'Selected'; ?>>Need Overhauling</option>
                                </select>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="counter_owner" class="form-label"><i class="fas fa-user-tag"></i> Ownership</label>
                                <select class="form-select" id="counter_owner" name="owner">
                                    <option value="--"> -- Select Ownership --</option>
                                    <option value="MTN" <?php if(($OWNER_SHIP ?? '') == "MTN") echo 'Selected'; ?>>MTN</option>
                                    <option value="Third Party" <?php if(($OWNER_SHIP ?? '') == "Third Party") echo 'Selected'; ?>>Third Party</option>
                                </select>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="counter_power" class="form-label"><i class="fas fa-bolt"></i> Power Type</label>
                                <select class="form-select" id="counter_power" name="cpower">
                                    <option value="Three phase" <?php if(($type ?? '') == "Three phase") echo 'Selected'; ?>>Three phase</option>
                                    <option value="Mono phase" <?php if(($type ?? '') == "Mono phase") echo 'Selected'; ?>>Mono phase</option>
                                </select>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="counter_breaker" class="form-label"><i class="fas fa-plug"></i> ATS INSTALLER</label>
                                <input type="text" class="form-control" id="counter_breaker" name="ATS" 
                                       placeholder="ATS" value="<?php echo $ATS_INSTALLED ?? ''; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Continue with other sections following the same pattern -->
            <!-- Cabinet Information, Generator Information, Solar Information, etc. -->
            
            <!-- Form Footer -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Reset Form
                        </button>
                        <button type="submit" name="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save Configuration
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Bootstrap 5 JS with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Battery compatibility code (same as before)
        const brandTypeMap = {
            'North_Star': 'Gel',
            'Narada': 'Gel,Lithium',
            // ... rest of compatibility mapping
        };
        
        // Setup battery compatibility
        function setupBatteryCompatibility() {
            document.querySelectorAll('select[id$="_brand"]').forEach(select => {
                Array.from(select.options).forEach(opt => {
                    if (opt.value !== '--') {
                        const compatibleTypes = brandTypeMap[opt.value] || '';
                        opt.setAttribute('data-type', compatibleTypes);
                    }
                });
            });
        }
        
        // Initialize battery compatibility
        setupBatteryCompatibility();
        
        // Show success message if redirected from successful submission
        if (window.location.search.includes('success=1')) {
            document.getElementById('successMessage').style.display = 'block';
            setTimeout(() => {
                document.getElementById('successMessage').style.display = 'none';
            }, 5000);
        }
        
        // Form validation
        document.getElementById('powerConfigForm').addEventListener('submit', function(e) {
            let isValid = true;
            const siteCode = document.getElementById('siteCode').value;
            
            if (!siteCode) {
                isValid = false;
                alert('Site code is required!');
                e.preventDefault();
            }
            
            if (isValid) {
                document.getElementById('successMessage').style.display = 'block';
            }
        });
    });
    </script>
</body>
</html>