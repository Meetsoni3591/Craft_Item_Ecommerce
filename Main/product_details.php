<?php
$con = mysqli_connect("localhost", "root", "", "project_craft");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $productID = intval($_GET['id']);

    $query = "SELECT * FROM product_table WHERE id = $productID";
    $result = mysqli_query($con, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $productName = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
        $productPrice = $row['price'];
        $productImage = "/ProjectCraft/Main/admin/CRUD/images/" . $row['image'];
        $productDescription = htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8');
    } else {
        echo "Product not found!";
        exit();
    }
} else {
    echo "Invalid Product!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $productName; ?> - Product Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        /* 🌟 Modernized Product Details Page */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .product-detail-container {
            display: flex;
            flex-wrap: wrap;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            max-width: 900px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .product-image {
            flex: 1;
            max-width: 50%;
            padding: 10px;
        }

        .product-image img {
            width: 100%;
            border-radius: 10px;
        }

        .product-info {
            flex: 1;
            max-width: 50%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .product-info h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }

        .price {
            font-size: 22px;
            font-weight: bold;
            color: #ff3f6c;
            margin-bottom: 10px;
        }

        .description {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }

        .quantity-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .quantity-container input {
            width: 50px;
            padding: 5px;
            text-align: center;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* 🛒 Add to Cart & Wishlist Buttons */
        .button-container {
            display: flex;
            gap: 10px;
        }

        .button-container button {
            flex: 1;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .add-to-cart {
            background:rgb(180, 102, 120);
            color: white;
        }

        .add-to-cart:hover {
            background: #e62e5c;
        }

        .wishlist-button {
            background:rgb(180, 102, 120);
                color: white;
        }

        .wishlist-button:hover {
            background: #e62e5c;
            color: black;
        }

        @media (max-width: 768px) {
            .product-detail-container {
                flex-direction: column;
                max-width: 100%;
                margin: 20px;
            }

            .product-image, .product-info {
                max-width: 100%;
                text-align: center;
            }

            .button-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <div class="product-detail-container">
        <div class="product-image">
            <img src="<?php echo $productImage; ?>" alt="<?php echo $productName; ?>">
        </div>
        <div class="product-info">
            <h1><?php echo $productName; ?></h1>
            <p class="price">₹<?php echo $productPrice; ?></p>
            <p class="description"><?php echo $productDescription; ?></p>

            <!-- Quantity Selector -->
            <div class="quantity-container">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" min="1" value="1">
            </div>

            <div class="button-container">
                <button class="add-to-cart"
                    data-id="<?php echo $productID; ?>"
                    data-name="<?php echo $productName; ?>"
                    data-price="<?php echo $productPrice; ?>"
                    data-image="<?php echo $productImage; ?>">
                    <i class="fa fa-shopping-cart"></i> Add to Cart
                </button>

                <button class="wishlist-button"
                    data-id="<?php echo $productID; ?>"
                    data-name="<?php echo $productName; ?>"
                    data-price="<?php echo $productPrice; ?>"
                    data-image="<?php echo $productImage; ?>">
                    <i class="fa fa-heart"></i> Wishlist
                </button>
            </div>
        </div>
    </div>
</body>

<script>
document.querySelector(".add-to-cart").addEventListener("click", function() {
    let productID = this.getAttribute("data-id");
    let productName = this.getAttribute("data-name");
    let productPrice = parseFloat(this.getAttribute("data-price"));
    let productImage = this.getAttribute("data-image");
    let quantity = parseInt(document.getElementById("quantity").value);

    if (quantity < 1) {
        alert("Please select a valid quantity.");
        return;
    }

    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    let existingProduct = cart.find(item => item.id === productID);

    if (existingProduct) {
        existingProduct.quantity += quantity;
    } else {
        cart.push({ id: productID, name: productName, price: productPrice, quantity: quantity, image: productImage });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    alert(`${quantity} x ${productName} added to cart! 🛒`);
});

document.querySelector(".wishlist-button").addEventListener("click", function() {
    let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
    let productID = this.getAttribute("data-id");

    if (wishlist.some(item => item.id === productID)) {
        alert("Already in wishlist! ❤️");
    } else {
        wishlist.push({ id: productID, name: this.getAttribute("data-name"), price: this.getAttribute("data-price"), image: this.getAttribute("data-image") });
        localStorage.setItem("wishlist", JSON.stringify(wishlist));
        alert("Added to wishlist! ❤️");
    }
});
</script>

</html>
