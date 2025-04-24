<?php
session_start();

$vendor = $_SESSION['vendor'];
?>
<h1>Welcome, <?php echo htmlspecialchars($vendor['vendorid']); ?>!</h1>
<h1>index file</h1>