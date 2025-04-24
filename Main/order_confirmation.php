<?php
$host = 'localhost';
$user = 'root'; 
$password = ''; 
$dbname = 'project_craft'; 
$conn = new mysqli($host, $user, $password, $dbname);
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$order_id = $_GET['order_id'] ?? null;
$user_id = $_SESSION['user']['userid'];

if (!$order_id) {
    header("Location: homepage.php");
    exit();
}

// Fetch user details
$user_query = "SELECT First_name,Last_name, Email,Phone,Address FROM user_register WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

// Fetch order details
$order_query = "SELECT o.*, DATE_FORMAT(o.order_date, '%d %b %Y %h:%i %p') as formatted_date 
                FROM orders o 
                WHERE o.order_id = ? AND o.user_id = ?";
$stmt = $conn->prepare($order_query);
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows === 0) {
    echo "<p>Order not found or you don't have permission to view it.</p>";
    exit();
}

$order = $order_result->fetch_assoc();

// Fetch order items
$items_query = "SELECT oi.*, p.name, p.image 
                FROM order_items oi 
                JOIN product_table p ON oi.product_id = p.id 
                WHERE oi.order_id = ?";
$stmt = $conn->prepare($items_query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items_result = $stmt->get_result();

$order_items = [];
while ($item = $items_result->fetch_assoc()) {
    $order_items[] = $item;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - ProjectCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* General Styles */
body {
    background-image: url("Images/loginformbackground.jpg");
    background-size: cover;
    background-repeat: no-repeat;

    /* background-color:    rgb(234, 234, 234); */
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Main Container */
.confirmation-container {
    max-width: 900px;
    margin: 30px auto;
    background-color:rgb(147, 107, 90);
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(117, 1, 1, 0.1);
    padding: 20px;
}

/* Profile Section */
.profile-section {
    display: flex;
    font-weight: bold;
    align-items: center;
    padding: 20px;
    background: #fff;
    border-right: 2px solid #eee;
    text-align: center;
    background-color:rgba(159, 16, 157, 0);
    color: black;
}


.profile-section h5 {
    margin: 0;
    font-size: 1.2rem;
    /* color: #333; */
    color: black  ;
}


.profile-section p {
    color: black;
    margin: 5px 0;
    font-size: 0.9rem;
    color: black;
}

.edit-profile {
    display: inline-block;
    margin-top: 5px;
    text-decoration: none;
    font-size: 14px;
    color:rgb(3, 2, 11);
}

.edit-profile:hover {
    text-decoration: underline;
}

/* Order Details Section */
.order-section {
    padding: 20px;
    color: black;
}

.order-section h4 {
    font-size: 1.4rem;
    color: black;
}

.order-details p {
    font-size: 1rem;
    margin-bottom: 5px;
    color: black;
}

.order-items {
    margin-top: 20px;
    color: black;
}

/* Order Items */
.item-row {
    display: flex;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.item-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 5px;
    margin-right: 15px;
    border: 2px solid #ddd;
}

.item-details h5 {
    font-size: 1rem;
    margin: 0;
    color: black;
}

.item-details div {
    font-size: 0.9rem;
    color: black;
}

.item-price {
    font-weight: bold;
    color:rgb(0, 0, 0);
    font-size: 1rem;
}

/* Order Total */
.order-total {
    margin-top: 20px;
    text-align: right;
    font-size: 1.2em;
    font-weight: bold;
    color: black;
}

/* Buttons */
.btn-continue {
    background-color:rgba(214, 203, 199, 0.73);
    /* border-color: #6c5ce7; */
    color: white;
    padding: 10px 15px;
    font-size: 1rem;
    border-radius: 5px;
    text-decoration: none;
}

.btn-continue:hover {
    background-color:rgba(214, 203, 199, 0.73);
    border-color:rgba(214, 203, 199, 0.73);
}

/* Responsive Design */
@media (max-width: 768px) {
    .profile-section {
        flex-direction: column;
        align-items: center;
        border-right: none;
        border-bottom: 2px solid #eee;
        padding: 15px;
    }

    .profile-picture {
        margin-bottom: 10px;
    }

    .order-section {
        padding: 15px;
    }

    .item-row {
        flex-direction: column;
        text-align: center;
    }

    .item-image {
        margin-bottom: 10px;
    }
}

    </style>
</head>
<body>
    <div class="confirmation-container">
        <div class="row">
            <!-- User Profile Section on Left -->
            <div class="col-md-4 profile-section">
                <!-- <img src="/ProjectCraft/Main/user_profiles/<?php echo htmlspecialchars($user['profile_picture'] ?? 'default.png'); ?>" 
                     alt="Profile Picture" class="profile-picture"> -->
                <div>
                    <h5><?php echo htmlspecialchars($user['First_name']); ?>
                    <?php echo htmlspecialchars($user['Last_name']); ?></h5>
                    <h4><p><?php echo htmlspecialchars($user['Email']); ?></p></h4>
                    <h4><p><?php echo htmlspecialchars($user['Phone']); ?></p></h4>
                    <h4><p><?php echo htmlspecialchars($user['Address']); ?></p></h4>
                    <a href="edit_profile.php" class="edit-profile"><i class="fas fa-edit"></i> Edit Profile</a>
                </div>
            </div>

            <!-- Order Confirmation Section -->
            <div class="col-md-8 order-section">
                <h4>Order Confirmed!</h4>
                <p>Thank you for your purchase. Your order has been received and is being processed.</p>

                <div class="order-details">
                    <p><strong>Order ID:</strong> #<?php echo $order_id; ?></p>
                    <p><strong>Order Date:</strong> <?php echo $order['formatted_date']; ?></p>
                    <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_type']); ?></p>
                    <p><strong>Order Status:</strong> Processing</p>
                </div>
                
                <h4>Shipping Address</h4>
                <p><?php echo nl2br(htmlspecialchars($order['shipping_address'] ?? 'Not provided')); ?></p>

                <div class="order-items">
                    <h4>Order Items</h4>
                    <?php if (empty($order_items)): ?>
                        <p>No items found for this order.</p>
                    <?php else: ?>
                        <?php foreach ($order_items as $item): ?>
                            <div class="item-row">
                                <img src="/ProjectCraft/Main/admin/CRUD/images/<?php echo htmlspecialchars($item['image'] ?? 'no-image.jpg'); ?>" 
                                     alt="<?php echo htmlspecialchars($item['name']); ?>" class="item-image">
                                <div class="item-details">
                                    <h5><?php echo htmlspecialchars($item['name']); ?></h5>
                                    <div>Quantity: <?php echo $item['quantity']; ?></div>
                                </div>
                                <div class="item-price">₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></div>
                            </div>
                        <?php endforeach; ?>
                        <div class="order-total">
                            Total: ₹<?php echo number_format($order['total_price'], 2); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="text-center mt-4">
                    <a href="homepage.php" class="btn btn-continue">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Clear the cart after successful order
        localStorage.removeItem('cart');
    </script>
</body>
</html>
