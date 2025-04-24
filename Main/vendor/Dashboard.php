<?php
session_start();
$host = 'localhost';
$user = 'root'; 
$password = ''; 
$dbname = 'project_craft'; 
$conn = new mysqli($host, $user, $password, $dbname);

$vendor = $_SESSION['vendor'];
$vendor_id =  $vendor['vendorid'];
$sql="SELECT * FROM vendors WHERE vendor_id='$vendor_id'";
$res=$conn->query($sql);
if($res->num_rows>0)
    {
        $data =$res->fetch_assoc();
        $vendor_name = $data['name'];
        
    }
    else{
        echo "Database Error";
    }

// echo $vendor_name;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Vendor Dashboard</title>
    </head>
    <body>
    
    <h1>Welcome, <?php echo htmlspecialchars($vendor_name); ?>! to Vendor Dashboard </h1>
</body>
</html>