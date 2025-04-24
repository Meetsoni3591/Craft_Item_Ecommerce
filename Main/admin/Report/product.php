<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin | Product Report</title>
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

        .table-container {
            width: 100%;
            overflow-x: auto;
            background-color: #292c30;
            padding: 1px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }

        .table {
            width: 100%;
            border-radius: 25px;
            border-collapse: collapse;
            border-spacing: 0;
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead {
            background-color: #413d3d;
            color: white;
        }

        .table thead th {
            padding: 12px;
            text-align: left;
            font-weight: normal;
            color: rgb(214, 192, 164);
            font-weight: 800;
        }

        .table tbody td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            color: #D0D0D0;
            font-size: 15px;
        }

        .report-header {
            text-align: center;
            color: white;
            margin: 20px 0;
            font-size: 24px;
            font-weight: bold;
        }

        .print-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #413d3d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .print-button:hover {
            background-color: #555;
        }

        .category-select {
            display: block;
            margin: 20px auto;
            padding: 8px 15px;
            background-color: #413d3d;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            width: 200px;
        }

        .category-select option {
            background-color: #292c30;
            color: white;
        }

        @media print {
            .print-button, .category-select {
                display: none;
            }
            body {
                background-color: white;
                color: black;
            }
            .table-container {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="report-header">Product Report</div>
        <div class="table-container">
            <?php
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

            echo '<form method="post" action="">
                <select name="category" class="category-select" onchange="this.form.submit()">
                    <option value="all" ' . (isset($_POST['category']) && $_POST['category'] == 'all' ? 'selected' : '') . '>All Categories</option>
                    <option value="homedecor" ' . (isset($_POST['category']) && $_POST['category'] == 'homedecor' ? 'selected' : '') . '>Home Decor</option>
                    <option value="Craft" ' . (isset($_POST['category']) && $_POST['category'] == 'Craft' ? 'selected' : '') . '>Craft</option>
                    <option value="Jewellary" ' . (isset($_POST['category']) && $_POST['category'] == 'Jewellary' ? 'selected' : '') . '>Jewellary</option>
                    <option value="ACCESSORIES" ' . (isset($_POST['category']) && $_POST['category'] == 'ACCESSORIES' ? 'selected' : '') . '>Accessories</option>
                    <option value="WALLDECOR" ' . (isset($_POST['category']) && $_POST['category'] == 'WALLDECOR' ? 'selected' : '') . '>Wall Decor</option>
                    <option value="GIFTING" ' . (isset($_POST['category']) && $_POST['category'] == 'GIFTING' ? 'selected' : '') . '>Gifting</option>
                </select>
            </form>';

            $category = isset($_POST['category']) ? $_POST['category'] : 'all';
            $query = "SELECT * FROM product_table";
            if ($category != 'all') {
                $query .= " WHERE category = '$category'";
            }

            echo "<table class='table'>";
            echo "<thead><tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Product Price</th>
                <th>Product Description</th>   
                <th>Product Stock</th>
                <th>Product Category</th>
                <th>Product Subcategory</th>
                </tr></thead><tbody>";

            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['stock'] . "</td>";
                echo "<td>" . $row['category'] . "</td>";   
                echo "<td>" . $row['sub_category'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";  
            $conn->close();
            ?>
        </div>
        <button class="print-button" onclick="window.print()">Print Report</button>
    </div>
</body>
</html>