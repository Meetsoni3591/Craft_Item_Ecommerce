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
$user = $_SESSION['user'];
$user_id = $_SESSION['user']['userid'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $total_price = $_POST['total_amount']; // Get total amount from hidden input field
    $payment_type = $_POST['payment_type'];
    $shipping_address = $_POST['shipping_address'];
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Insert into orders table
        $query = "INSERT INTO orders (user_id, total_price, payment_type, shipping_address, order_date) 
                 VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("idss", $user_id, $total_price, $payment_type, $shipping_address);
        
        if ($stmt->execute()) {
            $order_id = $stmt->insert_id; // Get the inserted order ID
            
            // Process cart items
            $cart_items = json_decode($_POST['cart_items_json'], true);
            
            if (!empty($cart_items)) {
                foreach ($cart_items as $item) {
                    $product_id = $item['id'];
                    $quantity = $item['quantity'];
                    $price = $item['price'];
                    $subtotal = $price * $quantity;
                    
                    // Insert into order_items table
                    $item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                                  VALUES (?, ?, ?, ?)";
                    $item_stmt = $conn->prepare($item_query);
                    $item_stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
                    $item_stmt->execute();
                    
                    // Update product stock (optional)
                    // $update_stock = "UPDATE product_table SET stock = stock - ? WHERE id = ?";
                    // $stock_stmt = $conn->prepare($update_stock);
                    // $stock_stmt->bind_param("ii", $quantity, $product_id);
                    // $stock_stmt->execute();
                }
            }
            
            // Commit transaction
            $conn->commit();
            
            // Redirect to order confirmation page
            header("Location: order_confirmation.php?order_id=" . $order_id);
            exit();
        } else {
            throw new Exception("Error creating order: " . $stmt->error);
        }
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $error_message = "Error processing your order: " . $e->getMessage();
    }
}
?>

<!-- <h1>Welcome, <?php echo htmlspecialchars($user['userid']); ?>!</h1> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - ProjectCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .checkout-container {
            max-width: 1200px;
            margin: 30px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(136, 76, 76, 0.99);
            overflow: hidden;
        }
        .checkout-header {
            background:rgb(123, 55, 55);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .checkout-body {
            padding: 30px;
        }
        .product-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 15px;
        }
        .product-details {
            flex-grow: 1;
        }
        .product-price {
            font-weight: bold;
            color:rgb(130, 76, 76);
        }
        .form-control:focus {
            border-color:rgb(133, 82, 82);
            box-shadow: 0 0 0 0.25rem rgba(122, 73, 73, 0.94);
        }
        .btn-primary {
            background-color:rgb(106, 56, 56);
            border-color:rgb(113, 70, 70);
        }
        .btn-primary:hover {
            background-color:rgb(95, 47, 47);
            border-color:rgb(93, 45, 45);
        }
        .payment-methods {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }
        .payment-method {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .payment-method:hover {
            border-color:rgb(110, 66, 66);
        }
        .payment-method.selected {
            border-color:rgb(113, 69, 69);
            background-color: rgba(101, 62, 62, 0.91);
        }
        .payment-method i {
            font-size: 24px;
            margin-bottom: 10px;
            color:rgb(95, 53, 53);
        }
        .order-summary {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 20px;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .summary-total {
            font-weight: bold;
            font-size: 1.2em;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }
        .success-message {
            text-align: center;
            padding: 50px 20px;
        }
        .success-icon {
            font-size: 80px;
            color:rgb(101, 56, 56);
            margin-bottom: 20px;
        }
        .empty-cart-message {
            text-align: center;
            padding: 30px;
        }
        .back-to-cart {
            display: inline-block;
            margin-top: 15px;
            color:rgb(114, 69, 69);
            text-decoration: none;
        }
        .back-to-cart:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
       
            <!-- <div class="success-message">
                <i class="fas fa-check-circle success-icon"></i>
                <h2>Order Placed Successfully!</h2>
                <p>Thank you for your purchase. Your order has been received and is being processed.</p>
                <p>You will receive an email confirmation shortly.</p>
                <div class="mt-4">
                    <a href="Homepage.php?id=<?php echo urlencode($userID); ?>&email=<?php echo urlencode($userEmail); ?>&first_name=<?php echo urlencode($firstName); ?>&last_name=<?php echo urlencode($lastName); ?>&logged_in=true" class="btn btn-primary">Continue Shopping</a>
                </div>
            </div> -->
      
            <div class="checkout-header">
                <h2><i class="fas fa-shopping-cart"></i> Checkout</h2>
            </div>
            <div class="checkout-body">
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>
                
                <div id="checkout-content">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="mb-3">Your Cart Items</h4>
                            <div id="cart-items-container">
                                <!-- Cart items will be displayed here -->
                            </div>
                            
                            <form id="checkout-form" method="post" action="checkout.php">
                                <input type="hidden" name="cart_items_json" id="cart-items-json">
                                <input type="hidden" name="total_amount" id="total-amount-input">
                                
                                <h4 class="mb-3 mt-4">Shipping Information</h4>
                                <div class="mb-3">
                                    <label for="shipping_address" class="form-label">Shipping Address</label>
                                    <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3" required></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input style="opacity: 0" class="form-check-input" type="checkbox" id="same_address" checked>
                                        <label class="form-check-label" for="same_address">
                                        
                                        </label>
                                    </div>
                                </div>
                                
                                <div id="billing_address_container" style="display: none;">
                                    <div class="mb-3">
                                        <label for="billing_address" class="form-label">Billing Address</label>
                                        <textarea class="form-control" id="billing_address" name="billing_address" rows="3"></textarea>
                                    </div>
                                </div>
                                
                                    <h4 class="mb-3 mt-4">Payment Method</h4>
                                    <label for="payment_type">Select Payment Type:</label>
                                    <select name="payment_type" id="payment_type" required onchange="updatePaymentMethod()">
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="PayPal">PayPal</option>
                                    <option value="Cash on Delivery">Cash on Delivery</option>
                                    <option value="UPI">UPI</option>
                                    <option value="Net Banking">Net Banking</option>
                                    </select>
                                  
                                    <input type="hidden" name="payment_method" id="payment_method" value="Credit Card">
<script>
    function updatePaymentMethod() {
        let selectedPayment = document.getElementById("payment_type").value;
        document.getElementById("payment_method").value = selectedPayment;
    }
</script>

                                
                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">Place Order</button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="order-summary">
                                <h4 class="mb-3">Order Summary</h4>
                                <div id="summary-items">
                                    <!-- Summary items will be displayed here -->
                                </div>
                                <div class="summary-item summary-total">
                                    <span>Total</span>
                                    <span id="summary-total">₹0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="empty-cart-message" class="empty-cart-message" style="display: none;">
                    <h4>Your cart is empty</h4>
                    <p>Please add some products to your cart before proceeding to checkout.</p>
                    <a href="cart.php" class="back-to-cart"><i class="fas fa-arrow-left"></i> Back to Cart</a>
                    <div class="mt-3">
                        <a href="Homepage.php" class="btn btn-primary">Continue Shopping</a>
                    </div>
                </div>
            </div>
        
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get cart from localStorage
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            let cartContainer = document.getElementById("cart-items-container");
            let summaryItems = document.getElementById("summary-items");
            let summaryTotal = document.getElementById("summary-total");
            let totalAmountInput = document.getElementById("total-amount-input");
            let cartItemsJson = document.getElementById("cart-items-json");
            let checkoutContent = document.getElementById("checkout-content");
            let emptyCartMessage = document.getElementById("empty-cart-message");
            
            // Check if cart is empty
            if (cart.length === 0) {
                checkoutContent.style.display = "none";
                emptyCartMessage.style.display = "block";
                return;
            } else {
                checkoutContent.style.display = "block";
                emptyCartMessage.style.display = "none";
            }
            
            // Toggle billing address
            document.getElementById("same_address").addEventListener("change", function() {
                let billingContainer = document.getElementById("billing_address_container");
                if (this.checked) {
                    billingContainer.style.display = "none";
                    document.getElementById("billing_address").value = document.getElementById("shipping_address").value;
                } else {
                    billingContainer.style.display = "block";
                }
            });
            
            // Payment method selection
            document.querySelectorAll(".payment-method").forEach(method => {
                method.addEventListener("click", function() {
                    document.querySelectorAll(".payment-method").forEach(m => m.classList.remove("selected"));
                    this.classList.add("selected");
                    document.getElementById("payment_method").value = this.getAttribute("data-method");
                });
            });
            
            // Shipping address change
            document.getElementById("shipping_address").addEventListener("input", function() {
                if (document.getElementById("same_address").checked) {
                    document.getElementById("billing_address").value = this.value;
                }
            });
            
            // Display cart items
            let totalAmount = 0;
            cartContainer.innerHTML = "";
            summaryItems.innerHTML = "";
            
            cart.forEach((item, index) => {
                // Ensure item has an ID
                if (!item.id) {
                    console.warn("Product missing ID:", item.name);
                    item.id = index + 1; // Use index+1 as fallback ID
                }
                
                // Add to cart items display
                let itemHtml = `
                    <div class="product-item">
                        <img src="${item.image}" alt="${item.name}" class="product-image">
                        <div class="product-details">
                            <h5>${item.name}</h5>
                            <div>Quantity: ${item.quantity}</div>
                        </div>
                        <div class="product-price">₹${(item.price * item.quantity).toFixed(2)}</div>
                    </div>
                `;
                cartContainer.innerHTML += itemHtml;
                
                // Add to summary
                let summaryHtml = `
                    <div class="summary-item">
                        <span>${item.name} x ${item.quantity}</span>
                        <span>₹${(item.price * item.quantity).toFixed(2)}</span>
                    </div>
                `;
                summaryItems.innerHTML += summaryHtml;
                
                totalAmount += item.price * item.quantity;
            });
            
            // Update total
            summaryTotal.textContent = `₹${totalAmount.toFixed(2)}`;
            totalAmountInput.value = totalAmount.toFixed(2);
            
            // Prepare cart items for submission
            cartItemsJson.value = JSON.stringify(cart);
            
            // Form submission
            document.getElementById("checkout-form").addEventListener("submit", function(e) {
                if (cart.length === 0) {
                    e.preventDefault();
                    alert("Your cart is empty!");
                    return;
                }
                
                // Ensure billing address is set
                if (document.getElementById("same_address").checked) {
                    document.getElementById("billing_address").value = document.getElementById("shipping_address").value;
                }
                
                // Store cart items in form data
                cartItemsJson.value = JSON.stringify(cart);
                
                // Form will submit normally
                // Clear cart after successful submission (will happen on order confirmation page)
            });
        });
    </script>
</body>
</html>
