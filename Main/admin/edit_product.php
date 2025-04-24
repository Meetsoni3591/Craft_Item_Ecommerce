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

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: Admin_Products.php");
    exit();
}

$id = $_GET['id'];

// Fetch product details
$query = "SELECT * FROM product_table WHERE id = $id";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    // Product not found
    header("Location: Admin_Products.php");
    exit();
}

$product = $result->fetch_assoc();

// Handle form submission
if (isset($_POST['update_product'])) {
    $update_id = $_POST['update_id'];
    $update_name = $_POST['update_name'];
    $update_description = $_POST['update_description'];
    $update_price = $_POST['update_price'];
    $update_category = $_POST['update_category'];
    $update_sub_category = $_POST['update_sub_category'];
    $update_stock = $_POST['update_stock'];
    
    // Check if a new image is uploaded
    if (!empty($_FILES['update_image']['name'])) {
        $update_image = $_FILES['update_image']['name'];
        $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
        $update_image_folder = 'C:/xampp/htdocs/ProjectCraft/Main/admin/CRUD/images/' . $update_image;

        // Move the new image to the folder
        if (move_uploaded_file($update_image_tmp_name, $update_image_folder)) {
        // Update query with image
        $update_query = "UPDATE product_table SET 
            name = '$update_name',
            description = '$update_description',
            price = '$update_price',
            category = '$update_category',
            sub_category = '$update_sub_category',
            stock = '$update_stock',
            image = '$update_image' 
            WHERE id = $update_id";
        } else {
            $error_msg = "Failed to upload image";
            // Continue with update without changing image
            $update_query = "UPDATE product_table SET 
                name = '$update_name',
                description = '$update_description',
                price = '$update_price',
                category = '$update_category',
                sub_category = '$update_sub_category',
                stock = '$update_stock'
                WHERE id = $update_id";
        }
    } else {
        // Update query without changing image
        $update_query = "UPDATE product_table SET 
            name = '$update_name',
            description = '$update_description',
            price = '$update_price',
            category = '$update_category',
            sub_category = '$update_sub_category',
            stock = '$update_stock'
            WHERE id = $update_id";
    }

    $update_result = $conn->query($update_query);
    if ($update_result) {
        header("Location: Admin_Products.php?updated=1");
        exit();
    } else {
        $error_msg = "Failed to update product: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin | Edit Product</title>
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
        
        .product-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 2px solid #2A2E37;
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
                    <!-- <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2> -->
                </a>
                <!-- <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a> -->
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <!-- <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="/static/admin_css/img/user.jpg" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"><?php echo htmlspecialchars($admin_name); ?></span>
                        </a> -->
                        <!-- <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="logout.php" class="dropdown-item">Log Out</a>
                        </div> -->
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h2 class="mb-4">Edit Product</h2>
                            
                            <?php if(isset($error_msg)): ?>
                                <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                            <?php endif; ?>
                            
                            <div class="form-container">
                                <form method="POST" action="" enctype="multipart/form-data">
                                    <input type="hidden" name="update_id" value="<?php echo $product['id']; ?>">
                                    
                                    <div class="mb-3">
                                        <label for="update_name" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="update_name" name="update_name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="update_description" class="form-label">Description</label>
                                        <textarea class="form-control" id="update_description" name="update_description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="update_price" class="form-label">Price</label>
                                        <input type="number" class="form-control" id="update_price" name="update_price" value="<?php echo htmlspecialchars($product['price']); ?>" step="0.01" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="update_category" class="form-label">Category</label>
                                        <select class="form-control" id="update_category" name="update_category" required>
                                            <option value="">Select Category</option>
                                            <option value="CRAFT" <?php echo ($product['category'] == 'CRAFT') ? 'selected' : ''; ?>>CRAFT</option>
                                            <option value="HOMEDECOR" <?php echo ($product['category'] == 'HOMEDECOR') ? 'selected' : ''; ?>>HOMEDECOR</option>
                                            <option value="JEWELLARY" <?php echo ($product['category'] == 'JEWELLARY') ? 'selected' : ''; ?>>JEWELLARY</option>
                                            <option value="ACCESSORIES" <?php echo ($product['category'] == 'ACCESSORIES') ? 'selected' : ''; ?>>ACCESSORIES</option>
                                            <option value="WALL DECOR" <?php echo ($product['category'] == 'WALL DECOR') ? 'selected' : ''; ?>>WALL DECOR</option>
                                            <option value="GIFTING" <?php echo ($product['category'] == 'GIFTING') ? 'selected' : ''; ?>>GIFTING</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="update_sub_category" class="form-label">Sub Category</label>
                                        <input type="text" class="form-control" id="update_sub_category" name="update_sub_category" value="<?php echo htmlspecialchars($product['sub_category']); ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="update_stock" class="form-label">Stock</label>
                                        <input type="number" class="form-control" id="update_stock" name="update_stock" value="<?php echo htmlspecialchars($product['stock']); ?>" min="0" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Current Image</label>
                                        <div>
                                            <?php if (!empty($product['image'])): ?>
                                                <img src="/ProjectCraft/Main/admin/CRUD/images/<?php echo htmlspecialchars($product['image']); ?>?t=<?php echo time(); ?>" alt="Product Image" class="product-image">
                                            <?php else: ?>
                                                <p>No image available</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="update_image" class="form-label">Update Image (Leave empty to keep current image)</label>
                                        <input type="file" class="form-control" id="update_image" name="update_image" accept="image/*">
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        <a href="Admin_Products.php" class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary" name="update_product">Update Product</button>
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
