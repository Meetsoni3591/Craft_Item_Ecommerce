<?php
// Database connection parameters
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

// SQL to create orders table
$sql_orders = "CREATE TABLE IF NOT EXISTS orders (
    order_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    product_id INT(11) NOT NULL,
    order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10,2) NOT NULL,
    shipping_address TEXT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    payment_status ENUM('pending', 'completed', 'failed') NOT NULL DEFAULT 'pending',
    order_status ENUM('processing', 'shipped', 'delivered', 'cancelled') NOT NULL DEFAULT 'processing',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user_register(id) ON DELETE CASCADE
    FOREIGN KEY (product_id) REFERENCES product_table(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

// SQL to create order items table
$sql_order_items = "CREATE TABLE IF NOT EXISTS order_items (
    item_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    order_id INT(11) NOT NULL,
    product_id INT(11) NOT NULL,
    quantity INT(11) NOT NULL,
    price_per_unit DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product_table(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

// Execute the SQL statements
if ($conn->query($sql_orders) === TRUE) {
    echo "Orders table created successfully<br>";
} else {
    echo "Error creating orders table: " . $conn->error . "<br>";
}

if ($conn->query($sql_order_items) === TRUE) {
    echo "Order items table created successfully<br>";
} else {
    echo "Error creating order items table: " . $conn->error . "<br>";
}

// Close connection
$conn->close();
echo "Database setup completed!";
?> 
