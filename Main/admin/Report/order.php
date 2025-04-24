<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin | Order Report</title>
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

        @media print {
            .print-button {
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
        <div class="report-header">Order Report</div>
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

            $query = "SELECT * FROM orders"; // fetch all data from product table

            echo "<table class='table'>";
            echo "<thead><tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Total Price</th>
                <th>Order date</th>   
                <th>Status</th>
                <th>Payment type</th>
                <th>Shipping address</th>
                </tr></thead><tbody>";

            $result = $conn->query($query);
            while($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row['order_id'] . "</td>";
                echo "<td>" . $row['user_id'] . "</td>";
                echo "<td>" . $row['total_price'] . "</td>";
                echo "<td>" . $row['order_date'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>" . $row['payment_type'] . "</td>";   
                echo "<td>" . $row['shipping_address'] . "</td>";
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

