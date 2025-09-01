<?php
// audit_viewer.php
require 'logAuditAction.php';

// Apply filters if needed
$filters = [];
if (!empty($_GET['start_date'])) $filters['start_date'] = $_GET['start_date'];
if (!empty($_GET['end_date'])) $filters['end_date'] = $_GET['end_date'];

echo "<h1>Audit Trail</h1>";
displayAuditLog($conn, $filters);
?>