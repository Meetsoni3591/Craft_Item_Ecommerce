
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}
$user = $_SESSION['user'];
?>

<!-- <h1>Welcome, <?php echo htmlspecialchars($user['userid']); ?>!</h1> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
       
/* Cart Section */
.cart-container {
    flex-grow: 1;
    width: 70%;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(144, 56, 56, 0.1);
}

        body { font-family: Arial, sans-serif; background:rgb(243, 229, 238); }
        .cart-container { width: 70%; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(144, 56, 56, 0.1); margin-top: 30px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: center; border-bottom: 1px solid #ddd; }
        th { background:rgb(193, 57, 127); color: white; }
        img { width: 80px; border-radius: 5px; }
        .remove-btn { background:purple; color: white; border: none; padding: 8px 12px; cursor: pointer; border-radius: 5px; }
        .remove-btn:hover { background: Orchid; }
        .checkout-btn {
            display: block;
            width: 100%;
            background:hsl(324, 23.80%, 43.70%);
            color: white;
            padding: 12px;
            border: none;
            cursor: pointer;
            margin-top: 20px;
            border-radius: 5px;
            font-size: 16px;
        }
        .checkout-btn:hover { background:rgb(189, 142, 166); }
    </style>
</head>
<body>

    <div class="cart-container">
        <h2>🛒 Your Shopping Cart</h2>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th >User ID</th>
                    <th>Image</th>
                    <th>Price (₹)</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="cart-items">
                <!-- Cart items will be dynamically inserted here -->
            </tbody>
        </table>

        <h3 id="total-price" style="text-align: right; margin-top: 20px;">Total: ₹0</h3>

        <button class="checkout-btn" id="checkout">Proceed to Checkout</button>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let cart = JSON.parse(localStorage.getItem("cart")) || [];
            let cartTable = document.getElementById("cart-items");
            let totalPriceElement = document.getElementById("total-price");

            if (cart.length === 0) {
                cartTable.innerHTML = "<tr><td colspan='6'>Your cart is empty</td></tr>";
            } else {
                let totalAmount = 0;
                cartTable.innerHTML = ""; // Clear previous content

                cart.forEach((item, index) => {
                    let row = `<tr>
                        <td>${item.name}</td>
                        <td><?php echo htmlspecialchars($user['userid']); ?></td>
                        <td><img src="${item.image}" alt="${item.name}"></td>
                        <td>₹${item.price}</td>
                        <td>${item.quantity}</td>
                        <td>₹${item.price * item.quantity}</td>
                        <td><button class="remove-btn" data-index="${index}">Remove</button></td>
                    </tr>`;
                    totalAmount += item.price * item.quantity;
                    cartTable.innerHTML += row;
                });

                totalPriceElement.innerHTML = `Total: ₹${totalAmount}`;

                // Remove item event
                document.querySelectorAll(".remove-btn").forEach(button => {
                    button.addEventListener("click", function () {
                        let index = this.getAttribute("data-index");
                        cart.splice(index, 1);
                        localStorage.setItem("cart", JSON.stringify(cart));
                        location.reload(); // Refresh page
                    });
                });
            }
        });
    </script>

</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        let cartTable = document.getElementById("cart-items");
        let totalPriceElement = document.getElementById("total-price");

        if (cart.length === 0) {
            cartTable.innerHTML = "<tr><td colspan='6'>Your cart is empty</td></tr>";
        } else {
            let totalAmount = 0;
            cartTable.innerHTML = ""; // Clear previous content

            cart.forEach((item, index) => {
                let row = `<tr>
                    <td>${item.name}</td>
                    <td><?php echo htmlspecialchars($user['userid']); ?></td>
                    <td><img src="${item.image}" alt="${item.name}"></td>
                    <td>₹${item.price}</td>
                    <td>
                        <button class="quantity-btn" data-index="${index}" data-action="decrease">-</button>
                        ${item.quantity}
                        <button class="quantity-btn" data-index="${index}" data-action="increase">+</button>
                    </td>
                    <td>₹${item.price * item.quantity}</td>
                    <td><button class="remove-btn" data-index="${index}">Remove</button></td>
                </tr>`;
                totalAmount += item.price * item.quantity;
                cartTable.innerHTML += row;
            });

            totalPriceElement.innerHTML = `Total: ₹${totalAmount}`;

            // Remove item event
            document.querySelectorAll(".remove-btn").forEach(button => {
                button.addEventListener("click", function () {
                    let index = this.getAttribute("data-index");
                    cart.splice(index, 1);
                    localStorage.setItem("cart", JSON.stringify(cart));
                    location.reload(); // Refresh page
                });
            });

            // Quantity change event
            document.querySelectorAll(".quantity-btn").forEach(button => {
                button.addEventListener("click", function () {
                    let index = this.getAttribute("data-index");
                    let action = this.getAttribute("data-action");
                    if (action === "increase") {
                        cart[index].quantity += 1;
                    } else if (action === "decrease" && cart[index].quantity > 1) {
                        cart[index].quantity -= 1;
                    }
                    localStorage.setItem("cart", JSON.stringify(cart));
                    location.reload(); // Refresh page
                });
            });
        }
    });
</script>
<script>
document.getElementById("checkout").addEventListener("click", function () {
    let totalAmount = document.getElementById("total-price").innerText.replace("Total: ₹", "").trim();
    
    // Get all cart items
    let cartItems = [];
    document.querySelectorAll(".cart-item").forEach(item => {
        let name = item.querySelector(".product-name").innerText;
        let id = item.querySelector(".user-id").innerText;
        let image = item.querySelector(".product-image").src;
        let price = parseFloat(item.querySelector(".product-price").innerText.replace("₹", "").trim());
        let quantity = parseInt(item.querySelector(".product-quantity").innerText.trim());

        cartItems.push({ name, image, price, quantity });
    });

    // Store cart details and total amount in localStorage
    localStorage.setItem("checkoutCart", JSON.stringify(cartItems));
    localStorage.setItem("totalAmount", totalAmount);

    // Redirect to checkout page
    window.location.href = "checkout.php";
});



</script>
