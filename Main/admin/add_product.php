<?php
session_start();

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

// Handle form submission
if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $product_category = $_POST['product_category'];
    $product_sub_category = $_POST['product_sub_category'];
    $product_stock = $_POST['product_stock'];
    
    // Handle image upload
    $product_image = '';
    $upload_success = false;
    
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $product_image = $_FILES['product_image']['name'];
        $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
        $product_image_folder = 'C:/xampp/htdocs/ProjectCraft/Main/admin/CRUD/images/' . $product_image;
        
        // Move the uploaded image to the folder
        if (move_uploaded_file($product_image_tmp_name, $product_image_folder)) {
            $upload_success = true;
        } else {
            $error_msg = "Failed to upload image";
        }
    } else {
        $error_msg = "Please select an image";
    }
    
    // If all required fields are filled and image upload was successful
    if (!empty($product_name) && !empty($product_price) && !empty($product_image) && $upload_success) {
        // Insert into database
        $insert_query = "INSERT INTO product_table (name, description, price, image, category, sub_category, stock) 
                        VALUES ('$product_name', '$product_description', '$product_price', '$product_image', '$product_category', '$product_sub_category', '$product_stock')";
        
        $result = $conn->query($insert_query);
        
        if ($result) {
            header("Location: Admin_Products.php?added=1");
            exit();
        } else {
            $error_msg = "Failed to add product: " . $conn->error;
        }
    } elseif (!$upload_success && !isset($error_msg)) {
        $error_msg = "Failed to upload image";
    } elseif (empty($product_name) || empty($product_price) || empty($product_image)) {
        $error_msg = "Please fill all required fields";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin | Add Product</title>
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

        .bg-secondary,
        .container-fluid,
        .sidebar,
        .footer,
        .navbar {
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
            background-color: #222 !important;
            /* Dark Gray Container */
            border: 1px solid #555;
            color: white !important;
        }
        .form-container {
            background-color: #191C24;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .form-control {
            background-color: #2A2E37;
            border-color: #2A2E37;
            color: #fff;
            margin-bottom: 15px;
        }
        
        .form-control:focus {
            background-color: #2A2E37;
            border-color: #EB1616;
            color: #fff;
        }
        
        .form-label {
            color: #fff;
            font-weight: 500;
        }
        
        textarea.form-control {
            min-height: 100px;
        }
    </style>
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="/Projectcraft/Main/Homepage.php" class="navbar-brand mx-4 mb-3">
                <h3 class="text-primary"> Art & Craft</h3>
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
                    <a href="Admin_Products.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Products</a>
                    <a href="Admin_Vendor.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Vendor Details</a>
                    <a href="Admin_User.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>User</a>
                    <a href="Admin_Contact.php" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Contact</a>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h2 class="mb-4">Add New Product</h2>
                            
                            <?php if(isset($error_msg)): ?>
                                <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                            <?php endif; ?>
                            
                            <div class="form-container">
                                <form method="POST" action="" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="product_name" class="form-label">Product Name *</label>
                                        <input type="text" class="form-control" id="product_name" name="product_name" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="product_description" class="form-label">Description *</label>
                                        <textarea class="form-control" id="product_description" name="product_description" required></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="product_price" class="form-label">Price *</label>
                                        <input type="number" class="form-control" id="product_price" name="product_price" step="0.01" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="product_category" class="form-label">Category *</label>
                                        <select class="form-control" id="product_category" name="product_category" required>
                                            <option value="">Select Category</option>
                                            <option value="CRAFT">CRAFT</option>
                                            <option value="HOMEDECOR">HOMEDECOR</option>
                                            <option value="JEWELLARY">JEWELLERY</option>
                                            <option value="ACCESSORIES">ACCESSORIES</option>
                                            <option value="WALL DECOR">WALL DECOR</option>
                                            <option value="GIFTING">GIFTING</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="product_sub_category" class="form-label">Sub Category *</label>
                                        <input type="text" class="form-control" id="product_sub_category" name="product_sub_category" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="product_stock" class="form-label">Stock *</label>
                                        <input type="number" class="form-control" id="product_stock" name="product_stock" min="0" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="product_image" class="form-label">Product Image *</label>
                                        <input type="file" class="form-control" id="product_image" name="product_image" accept="image/*" required>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        <a href="Admin_Products.php" class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-success" name="add_product">Add Product</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form End -->

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
