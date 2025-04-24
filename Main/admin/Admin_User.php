<?php
session_start();

// Check if the admin is logged in


// Check if admin_name is set in session
if (isset($_SESSION['Admin_name']) && !empty($_SESSION['Admin_name'])) {
    $admin_name = $_SESSION['Admin_name'];
} else {
    $admin_name = "Stuti Nayi"; // Default fallback if session value is missing
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_craft";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all users from the user_register table
$sql = "SELECT * FROM user_register";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin | User Details</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link rel="shortcut icon" href="/static/favicon2.png">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">


    <!-- Libraries Stylesheet -->
    <link href="/projectcraft/admin_css/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="/projectcraft/admin_css/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
     <link href="/projectcraft/admin_css/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/projectcraft/admin_css/css/style.css" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    body {
    background-color: black;
    color: white;
    font-family: Arial, sans-serif;
}

.bg-secondary, .container-fluid, .sidebar, .footer, .navbar {
    background-color: black !important;
    color: white !important;
    border-color: #444;
}

.rounded {
    border-radius: 8px;
}

.p-4 {
    padding: 16px;
}

.text-primary {
    color: white !important;
}

.mb-2 {
    margin-bottom: 8px;
    font-weight: bold;
}

.mb-0 {
    margin-bottom: 0;
    font-size: 18px;
    font-weight: bold;
}

.d-flex {
    display: flex;
}

.align-items-center {
    align-items: center;
}

.justify-content-between {
    justify-content: space-between;
}

.ms-3 {
    margin-left: 12px;
}

.fa-3x {
    font-size: 2.5rem;
    color: white !important;
}

/* Custom container styles for Total User, Total Vendors, etc. */
.bg-secondary.rounded {
    background-color: #222 !important; /* Dark Gray Container */
    border: 1px solid #555;
    color: white !important;
}
    /* Custom styles for SweetAlert2 */
    .swal2-popup {
        width: 300px; /* Adjust width as needed */
        padding: 10px; /* Adjust padding as needed */
        font-size: 14px; /* Adjust font size for a more compact look */
    }
    
    .swal2-title {
        font-size: 16px; /* Title font size */
    }
    
    .swal2-content {
        font-size: 14px; /* Content font size */
    }
    
    .swal2-confirm, .swal2-cancel {
        font-size: 14px; /* Button font size */
        padding: 6px 12px; /* Adjust button padding */
    }
    
    .swal2-buttonswrapper {
        padding: 10px 0; /* Adjust button wrapper padding */
    }
    th{
        color: rgb(214, 192, 164);
        align-content: center;
        font-weight: 800;

    }
    td{
        color: rgb(100, 118, 131);
        font-weight: 800;

    }
    .table-container {
        width: 100%;
        overflow-x: auto;
        background-color: #292c30;
        padding: 1px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .table {
        width: 100%;
        border-radius: 25px;
        border-collapse: collapse;
        border-spacing: 0;
        border-radius: 10px; /* Adjust the radius to your preference */
        overflow: hidden; /* Ensures the corners are rounded */
    }

    .table thead {
        background-color: #413d3d;
        color: white;
    }
    tr{
        border: 3px navajowhite;
    }

    .table thead th {
        padding: 12px;
        text-align: left;
        font-weight: normal;
    }

    .table tbody td {
        padding: 8px;
        border-bottom: 1px solid #ddd;
        color: #D0D0D0;
        font-size: 15px;
    }

</style>
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <!-- <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="/Projectcraft/Main/Homepage.php" class="navbar-brand mx-4 mb-3">
                <!-- <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Craft</h3> -->
                <h3 class="text-primary">Art & Craft</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <!-- <div class="position-relative">
                        <img class="rounded-circle" src="/static/admin_css/img/user.jpg" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div> -->
                    <div class="ms-3">
                    <h6 class="mb-0">Admin <strong><?php echo htmlspecialchars($admin_name); ?></strong></h6>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="Dashboard.php" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="Admin_Products.php" class="nav-item nav-link"><i class="fa fa-shopping-cart me-2"></i>Products</a>
                    <a href="Admin_Orders.php" class="nav-item nav-link active"><i class="fa fa-shopping-bag me-2"></i>Orders</a>
                    <a href="Admin_Vendor.php" class="nav-item nav-link"><i class="fa fa-store me-2"></i>Vendor Details</a>
                    <a href="Admin_User.php" class="nav-item nav-link"><i class="fa fa-user me-2"></i>User</a>
                    <a href="Admin_Contact.php" class="nav-item nav-link"><i class="fa fa-envelope me-2"></i>Contact</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-chart-bar me-2"></i>Reports</a>
                        <div class="dropdown-menu bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="/projectCraft/main/admin/Report/product.php" class="dropdown-item">Product Report</a>
                            <a href="/projectCraft/main/admin/Report/order.php" class="dropdown-item">Order Report</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            
            <!-- Navbar End -->


            <!-- Table Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-secondary rounded h-100 p-4">
                        <h2 class="mb-4">All Users Details</h2>
                        <h6 class="mb-4">User Data</h6>
                            <div class="table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">First Name</th>
                                            <th scope="col">Last Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Password</th>
                                            <!-- <th scope="col">Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result && $result->num_rows > 0) {
                                            $counter = 1;
                                            // Output data of each row
                                            while($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $counter . "</td>";
                                                echo "<td>" . htmlspecialchars($row["First_name"]) . "</td>";
                                                echo "<td>" . htmlspecialchars($row["Last_name"]) . "</td>";
                                                echo "<td>" . htmlspecialchars($row["Email"]) . "</td>";
                                                echo "<td>" . htmlspecialchars($row["Phone"]) . "</td>";
                                                echo "<td>" . htmlspecialchars($row["Address"]) . "</td>";
                                                echo "<td>" . htmlspecialchars($row["Password"]) . "</td>";
                                                // echo "<td> <button type='button' class='btn btn-danger btn-sm' onclick='confirmDelete(" . $row["id"] . ")'> <i class='bi bi-trash'></i> Delete </button> </td>";
                                                echo "</tr>";
                                                $counter++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='8' class='text-center'>No users found</td></tr>";
                                        }
                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
            <script>
                function confirmDelete(userId) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this user!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33', // Red color for OK
                        cancelButtonColor: '#3085d6', // Green color for Cancel
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        customClass: {
                            popup: 'swal2-popup' // Apply the custom class here
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to a delete handler
                            window.location.href = 'delete_user.php?id=' + userId;
                        }
                    });
                }
            </script>

            <!-- Table End -->


            <!-- Footer Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                        &copy; <a href="#">Craft.com</a>, All Right Reserved. 
                        </div>
                       
                    </div>
                </div>
            </div>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/projectcraft/admin_css/lib/chart/chart.min.js"></script>
    <script src="/projectcraft/admin_css/lib/easing/easing.min.js"></script>
    <script src="/projectcraft/admin_css/lib/waypoints/waypoints.min.js"></script>
    <script src="/projectcraft/admin_css/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="/projectcraft/admin_css/lib/tempusdominus/js/moment.min.js"></script>
    <script src="/projectcraft/admin_css/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="/projectcraft/admin_css/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="/projectcraft/admin_css/js/main.js"></script>
</body>

</html>