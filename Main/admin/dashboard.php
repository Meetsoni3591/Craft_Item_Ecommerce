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

// Get user count
$user_query = "SELECT COUNT(*) as user_count FROM user_register";
$user_result = $conn->query($user_query);
$user_count = 0;
if ($user_result && $user_result->num_rows > 0) {
    $user_data = $user_result->fetch_assoc();
    $user_count = $user_data['user_count'];
}

// Get vendor count
$vendor_query = "SELECT COUNT(*) as vendor_count FROM vendors";
$vendor_result = $conn->query($vendor_query);
$vendor_count = 0;
if ($vendor_result && $vendor_result->num_rows > 0) {
    $vendor_data = $vendor_result->fetch_assoc();
    $vendor_count = $vendor_data['vendor_count'];
}

// Get product count    
$product_query = "SELECT COUNT(*) as product_count FROM product_table";
$product_result = $conn->query($product_query);
$product_count = 0;
if ($product_result && $product_result->num_rows > 0) {
    $product_data = $product_result->fetch_assoc();
    $product_count = $product_data['product_count'];
}

// Get contact count
$contact_query = "SELECT COUNT(*) as contact_count FROM contact";
$contact_result = $conn->query($contact_query);
$contact_count = 0;
if ($contact_result && $contact_result->num_rows > 0) {
    $contact_data = $contact_result->fetch_assoc();
    $contact_count = $contact_data['contact_count'];
}

// Fetch total sales
// $query_sales = "SELECT COUNT(order_id) AS total_sales FROM orders WHERE status = 'delivered'";
// $result_sales = $conn->query($query_sales);
// $total_sales = ($result_sales->num_rows > 0) ? $result_sales->fetch_assoc()['total_sales'] : 0;

// Fetch total sales (delivered orders)
// $query_sales = "SELECT COUNT(order_id) AS total_sales FROM orders WHERE status = 'delivered'";
// $result_sales = $conn->query($query_sales);
// $total_sales = ($result_sales->num_rows > 0) ? $result_sales->fetch_assoc()['total_sales'] : 0;

// Fetch total revenue (sum of total_price in delivered orders)
$query_revenue = "SELECT SUM(total_price) AS total_revenue FROM orders";
$result_revenue = $conn->query($query_revenue);
$total_revenue = ($result_revenue->num_rows > 0) ? $result_revenue->fetch_assoc()['total_revenue'] : 0;

// Fetch monthly revenue
// $month_revenue_query = "SELECT MONTH(order_date) AS month, SUM(total_price) AS revenue 
//                         FROM orders WHERE status = 'delivered' 
//                         GROUP BY MONTH(order_date)";
// $month_revenue_result = $conn->query($month_revenue_query);

// $months = [];
// $revenues = [];
// while ($row = $month_revenue_result->fetch_assoc()) {
//     $months[] = date('F', mktime(0, 0, 0, $row['month'], 1)); // Convert month number to name
//     $revenues[] = $row['revenue'];
// }



?>

$conn->close();
?>
<h6 class="mb-0">Admin <strong><?php echo htmlspecialchars($admin_name); ?></strong></h6>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin | Dashboard</title>
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
        border-radius : 25px;
        border-collapse:collapse;
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

    /* .table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .table tbody tr:hover {
        background-color: #e8e8e8;
    } */

    .table tbody td {
        padding: 8px;
        border-bottom: 1px solid #ddd;
        color: #D0D0D0;
        font-size: 15px;
    }

    .table img {
        width: 100px;
        height: 100px;
        border-radius: 15px;
        border: 2px solid blanchedalmond;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
        padding: 10px 20px;
        color: white;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-success i {
        font-size: 24px;
    }
    h2{
        text-align : center;
    }
    </style>
    <!-- <style>
        body {
            background-color: #f8f9fa;
            color: #333;
            font-family: 'Open Sans', sans-serif;

            body {
                /* background-color: #f8f9fa; */
                margin: 0;
                padding: 0;
            }

        }

        .bg-secondary,
        .container-fluid,
        .sidebar,
        .footer,
        .navbar {
            background-color: #ffffff !important;
            color: #333 !important;
            border-color: #ddd;
        }

        .rounded {
            border-radius: 8px;
        }

        .p-4 {
            padding: 16px;
        }

        .text-primary {
            color: rgb(0, 0, 0) !important;
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
            color: rgb(0, 0, 0) !important;
        }

        /* Custom container styles for Total User, Total Vendors, etc. */
        .bg-secondary.rounded {
            background-color: #f1f1f1 !important;
            /* Light Gray Container */
            border: 1px solid #ccc;
            color: #333 !important;
        }

        .sidebar {
            background-color: #ffffff !important;
            /* White background */
            border-right: 1px solid #ddd;
            /* Light border */
            min-height: 100vh;
        }

        /* Sidebar Navbar */
        .sidebar .navbar {
            background-color: #ffffff !important;
            /* White navbar */
            color: #333 !important;
            /* Dark text */
        }

        /* Sidebar Links */
        .sidebar .navbar-nav .nav-link {
            color: #333 !important;
            /* Dark text for links */
            padding: 10px 15px;
            font-weight: bold;
            border-radius: 5px;
            transition: 0.3s;
        }

        /* Sidebar Active Link */
        .sidebar .navbar-nav .nav-link.active {
            background-color: rgb(135, 170, 205) !important;
            /* Light Blue Active */
            color: white !important;
        }

        /* Sidebar Hover Effect */
        .sidebar .navbar-nav .nav-link:hover {
            background-color: rgb(99, 92, 138) !important;
            /* Light gray on hover */
        }

        /* Sidebar Icons */
        .sidebar .navbar-nav .nav-link i {
            color: rgb(249, 249, 249) !important;
            /* Blue icons */
            margin-right: 8px;
        }


        /* Dashboard boxes */
        .bg-secondary {
            background-color: #ffffff !important;
            border: 1px solid #ddd;
        }

        .bg-secondary:hover {
            background-color: #e8e8e8 !important;
        }

        h6.mb-0 {
            font-weight: bold;
            color: rgb(0, 0, 0);
        }

        /* Ensure the footer and bottom section have a white background */
        .footer {
            background-color: #ffffff !important;
            /* White background */
            color: #333 !important;
            /* Dark text */
            padding: 15px;
            text-align: center;
            border-top: 1px solid #ddd;
            /* Light border for separation */
        }

        /* Fix any extra black sections */
        body,
        html {
            background-color: #f8f9fa !important;
            /* Light gray background */
        }

        .container-fluid {
            background-color: #ffffff !important;
            /* Ensure containers are white */
        }

        /* If there's an unwanted black section at the bottom */
        .black-section {
            background-color: #ffffff !important;
        }

        .content {
            padding: 20px;
            background-color: #ffffff !important;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        /* Table */
        .table-container {
            width: 100%;
            overflow-x: auto;
            background-color: #ffffff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead {
            background-color: rgb(0, 0, 0);
            color: white;
        }

        .table thead th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tbody tr:hover {
            background-color: #e8e8e8;
        }

        .table tbody td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 15px;
        }

        /* Footer */
        .footer {
            background-color: #ffffff !important;
            color: #333 !important;
            padding: 15px;
            text-align: center;
            border-top: 1px solid #ddd;
        }

        /* Fix any extra black sections */
        body,
        html {
            background-color: #f8f9fa !important;
        }

        .container-fluid {
            background-color: #ffffff !important;
        }

        /* If there's an unwanted black section at the bottom */
        .black-section {
            background-color: #ffffff !important;
        }
    </style> -->

    
</head>
<script>
    const months = <?php echo json_encode($months); ?>;
    const revenues = <?php echo json_encode($revenues); ?>;

    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Revenue ($)',
                data: revenues,
                backgroundColor: 'rgba(0, 0, 0, 0.5)',
                borderColor: 'rgb(0, 0, 0)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

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
        <br><br>
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <!-- <a href="#" class="">
                </a> -->

                <div class="navbar-nav align-items-center ms-auto">

                    <div class="nav-item dropdown">

                    </div>
                    <div class="nav-item dropdown">

                    </div>
                </div>
            </nav>
            <!-- Navbar End -->


            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-line fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total User</p>
                                <h6 class="mb-0"><?php echo $user_count; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-bar fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Vendors </p>
                                <h6 class="mb-0"><?php echo $vendor_count; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-area fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Products</p>
                                <h6 class="mb-0"><?php echo $product_count; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-chart-pie fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total contact Queries</p>
                                <h6 class="mb-0"><?php echo $contact_count; ?></h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-shopping-cart fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Sales</p>
                                <h6 class="mb-0"><?php echo $total_revenue ?></h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                            <i class="fa fa-dollar-sign fa-3x text-primary"></i>
                            <div class="ms-3">
                                <p class="mb-2">Total Revenue</p>
                                <h6 class="mb-0"><?php echo number_format($total_revenue * 10 / 100, 2); ?></h6>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Sale & Revenue End -->

            <!-- Table Start -->
            <!-- <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h2 class="mb-4">Orders Details</h2>
                            <div class="table-responsive">
                                
                                <div class="table-container">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">First Name</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Address</th>
                                                <th scope="col">Apartment suite</th>
                                                <th scope="col">Postal zip</th>
                                                <th scope="col">Total Products</th>
                                                <th scope="col">Total price</th>
                                                {% comment %} <th scope="col">Service area</th> {% endcomment %}

                                            </tr>
                                        </thead>
                                        <tbody>
                                            {% for data in data %}Demo data for testing 
                                                <tr>
                                                    <td> forloop.counter </td>
                                                    <td> data.first_name </td>
                                                    <td> data.last_name </td>
                                                    <td> data.email </td>
                                                    <td> data.phone </td>
                                                    <td> data.address </td>
                                                    <td> data.apartment_suite </td>
                                                    <td> data.postal_zip </td>
                                                    <td> data.Total_products </td>
                                                    <td> data.Total_price </td>
                                                    
                                                </tr>
                                            {% endfor %}
                                        </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
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