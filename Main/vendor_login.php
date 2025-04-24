<?php
// session_destroy();
$host = 'localhost';
$user = 'root'; 
$password = ''; 
$dbname = 'project_craft'; 
$conn = new mysqli($host, $user, $password, $dbname);
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $email=$_POST['email'];
    $password=$_POST['Password'];

    $sql="SELECT * FROM vendors WHERE email='$email' ";
    $res=$conn->query($sql);
    
    if($res->num_rows>0)
    {
        $data =$res->fetch_assoc();
        $vendor_id = $data['vendor_id'];
        $vendor_email = $data['email'];
        $vendor_name = $data['name'];
        $vendor_pass = $data['password'];
        if($password == $vendor_pass)
        {
            $_SESSION['vendor'] = [
                'vendorid' => $vendor_id,
                'vendorname' => $vendor_name
                
            ];
           
            header('Location: vendor/Dashboard.php');
            exit;
        }
        else
        {
            echo "Invalid password. <a href='vendor_register.html'>Try again</a>";
        }
    }
    else
    {
        echo "No user find this email. <a href='vendor_register.html'>Registerd again</a>";
    }
} 

?>