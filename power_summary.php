<?php
include "config.php";

if(isset($_GET['id'])) {
    $siteid = $_GET['id'];
    
    // Get site code
    $sql = "SELECT SITE_CODE FROM NEW_SITES WHERE ID = :siteid";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':siteid', $siteid);
    oci_execute($stmt);
    $row = oci_fetch_array($stmt, OCI_ASSOC);
    $sitecode = $row['SITE_CODE'];

    // Get power backup summary
    $sql = "SELECT * FROM POWER_BACKUP WHERE SITE_CODE = :sitecode";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':sitecode', $sitecode);
    oci_execute($stmt);
    $power = oci_fetch_array($stmt, OCI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Power Backup Summary</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .summary-container { max-width: 800px; margin: 0 auto; }
        .section { margin-bottom: 20px; }
        .section-title { background: #1c355c; color: white; padding: 10px; }
        .grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .item { padding: 10px; border-bottom: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="summary-container">
        <h1>Power Backup Summary - <?php echo $sitecode; ?></h1>
        
        <div class="section">
            <div class="section-title">Generator Information</div>
            <div class="grid">
                <div class="item"><strong>MTN Generator:</strong> <?php echo $power['MTN_GEN'] ?? '-'; ?></div>
                <div class="item"><strong>Quantity:</strong> <?php echo $power['QUANTITY'] ?? '-'; ?></div>
                <div class="item"><strong>MTN OOS Generator:</strong> <?php echo $power['MTN_OOS_GEN'] ?? '-'; ?></div>
                <div class="item"><strong>MTN Rented Generator:</strong> <?php echo $power['MTN_RENTED_GEN'] ?? '-'; ?></div>
                <div class="item"><strong>Other MTN Generator:</strong> <?php echo $power['OTHER_MTN_GEN'] ?? '-'; ?></div>
                <div class="item"><strong>Other Generator:</strong> <?php echo $power['OTHER_GEN'] ?? '-'; ?></div>
                <div class="item"><strong>STE Generator:</strong> <?php echo $power['STE_GEN'] ?? '-'; ?></div>
                <div class="item"><strong>Switch Generator:</strong> <?php echo $power['SWITCH_GEN'] ?? '-'; ?></div>
                <div class="item"><strong>Syriatel Generator:</strong> <?php echo $power['SYRIATEL_GEN'] ?? '-'; ?></div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Batteries Information</div>
            <div class="grid">
                <div class="item"><strong>Group 1 Gel Batteries:</strong> <?php echo $power['G1_GEL_BATT'] ?? '-'; ?></div>
                <div class="item"><strong>Group 1 Lithium Batteries:</strong> <?php echo $power['G1_LITHIUM_BATT'] ?? '-'; ?></div>
                <div class="item"><strong>Group 2 Gel Batteries:</strong> <?php echo $power['G2_GEL_BATT'] ?? '-'; ?></div>
                <div class="item"><strong>Group 2 Lithium Batteries:</strong> <?php echo $power['G2_LITHIUM_BATT'] ?? '-'; ?></div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Hybrid/Solar Information</div>
            <div class="grid">
                <div class="item"><strong>Hybrid:</strong> <?php echo $power['HYPRID'] ?? '-'; ?></div>
                <div class="item"><strong>Hybrid Installed:</strong> <?php echo $power['HYPRID_INSTALLED'] ?? '-'; ?></div>
                <div class="item"><strong>Hybrid Inactive:</strong> <?php echo $power['HYPRID_INACTIVE'] ?? '-'; ?></div>
                <div class="item"><strong>Hybrid OOS:</strong> <?php echo $power['HYPRID_OOS'] ?? '-'; ?></div>
                <div class="item"><strong>Hybrid Wind:</strong> <?php echo $power['HYPRID_WIND'] ?? '-'; ?></div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Power Lines</div>
            <div class="grid">
                <div class="item"><strong>Ampere:</strong> <?php echo $power['AMPERE'] ?? '-'; ?></div>
                <div class="item"><strong>Industrial Line:</strong> <?php echo $power['INDUSTRIAL_LINE'] ?? '-'; ?></div>
                <div class="item"><strong>Golden Line:</strong> <?php echo $power['GOLDEN_LINE'] ?? '-'; ?></div>
                <div class="item"><strong>Rationing Line:</strong> <?php echo $power['RATINING_LINE'] ?? '-'; ?></div>
                <div class="item"><strong>Non-Rationing Line:</strong> <?php echo $power['NON_RATINING_LINE'] ?? '-'; ?></div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Safety</div>
            <div class="grid">
                <div class="item"><strong>Cage:</strong> <?php echo $power['CAGE'] ?? '-'; ?></div>
                <div class="item"><strong>Guard Presence:</strong> <?php echo $power['GURDE'] ?? '-'; ?></div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
}
?>