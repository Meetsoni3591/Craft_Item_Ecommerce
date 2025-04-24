<?php
session_start();
?>

<?php include '/xampp/htdocs/ProjectCraft/Main/header.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forged with Touch!</title>
    
    <style>
        .slideshow {
            position: relative;
            width: 100%;
            max-width: 100%;
            height: 400px;
            overflow: hidden;
        }
        .slideshow img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            animation: fade 25s infinite;
        }
        .slideshow img:nth-child(1) { animation-delay: 0s; }
        .slideshow img:nth-child(2) { animation-delay: 5s; }
        .slideshow img:nth-child(3) { animation-delay: 10s; }
        .slideshow img:nth-child(4) { animation-delay: 15s; }
        .slideshow img:nth-child(5) { animation-delay: 20s; }
        
        @keyframes fade {
            0% { opacity: 0; }
            10% { opacity: 1; }
            20% { opacity: 1; }
            30% { opacity: 0; }
            100% { opacity: 0; }
        }

        .products {
            padding: 50px 20px;
            text-align: center;
        }
        h2 {
            text-align: center;
            color: #752d42;
            margin: 2%;
            font-size: 90%;
        }
        .product-grid {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .product-item {
            margin: 10px;
            text-align: center;
        }
        .rupee {
            font-size: 14px;
            font-weight: bold;
            color: #000;
        }
        .product-item img {
            width: 300px;
            height: 350px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 10px;
        }
        .product-item h3 {
            margin-top: 10px;
            font-size: 80%;
        }
        .product-item p {
            font-size: 1em;
            color: #090808;
        }
        .add-to-cart, .wishlist-btn {
            background-color: #752d42;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 5px;
        }
        .add-to-cart:hover, .wishlist-btn:hover {
            background-color: #5a1f31;
        }
    </style>
</head>
 <!-- add to cart script  -->
 <script>
document.addEventListener("DOMContentLoaded", function () {
    const cartButtons = document.querySelectorAll(".add-to-cart");

    cartButtons.forEach(button => {
        button.addEventListener("click", function () {
            let productID = this.getAttribute("data-id"); // Unique ID
            let productName = this.getAttribute("data-name");
            let productPrice = parseFloat(this.getAttribute("data-price"));
            let productImage = this.getAttribute("data-image");

            let cart = JSON.parse(localStorage.getItem("cart")) || [];

            // Check if product with the same ID exists
            let existingProduct = cart.find(item => item.id === productID);

            if (existingProduct) {
                existingProduct.quantity += 1; // Increase quantity
            } else {
                cart.push({
                    id: productID,
                    name: productName,
                    price: productPrice,
                    quantity: 1,
                    image: productImage
                });
            }

            localStorage.setItem("cart", JSON.stringify(cart));

            // Show success alert
            alert(`${productName} has been added to your cart! 🛒`);
        });
    });
});

</script>
<body>

<div class="slideshow">
    <img src="./Images/main.jpg" alt="Forged with Magic's Touch">
    <img src="./Images/elephant.png" alt="Forged with Magic's Touch">
    <img src="./Images/glass-art.jpg" alt="Forged with Magic's Touch">
    <img src="./Images/gift.jpg" alt="Forged with Magic's Touch">
    <img src="./Images/main.jpg" alt="Forged with Magic's Touch">
</div>


<?php
$con = mysqli_connect("localhost", "root", "", "project_craft");

$query = "SELECT * FROM product_table WHERE category = 'craft' AND sub_category = 'beaded jewellery';";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    echo '<section class="products">';
    echo '<div class="product-grid">';
    while ($row = mysqli_fetch_assoc($result)) {
        $productID = $row['id']; 
        $productName = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
        $productPrice = $row['price'];
        $productImage = "/ProjectCraft/Main/admin/CRUD/images/" . $row['image'];

        echo '<div class="product-item">';
        echo '<a href="/ProjectCraft/Main/product_details.php?id=' . $productID . '">';
        echo '<img src="' . $productImage . '" alt="' . $productName . '">';
        echo '</a>';
        echo '<h3>' . $row['description'] . '</h3>';
        echo '<p><span class="rupee">&#8377;</span>' . $productPrice . '</p>';
        
        echo '<button class="add-to-cart"  
            data-id="' . $productID . '"
            data-name="' . $productName . '" 
            data-price="' . $productPrice . '" 
            data-image="' . $productImage . '">
            Add to Cart
        </button>';

        echo '<button class="wishlist-btn"
            data-id="' . $productID . '"
            data-name="' . $productName . '"
            data-price="' . $productPrice . '"
            data-image="' . $productImage . '">
            ❤️ Add to Wishlist
        </button>';

        echo '</div>';
    }
    echo '</div>';
    echo '</section>';
} else {
    echo '<div style="text-align: center; padding: 20px;">No products found</div>';
}
?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const wishlistButtons = document.querySelectorAll(".wishlist-btn");
    let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

    function updateWishlistCount() {
        document.getElementById("wishlist-count").innerText = wishlist.length;
    }
    updateWishlistCount();

    wishlistButtons.forEach(button => {
        let productID = button.getAttribute("data-id");

        if (wishlist.some(item => item.id === productID)) {
            button.textContent = "✅ In Wishlist";
        }

        button.addEventListener("click", function () {
            let productID = this.getAttribute("data-id"); 
            let productName = this.getAttribute("data-name");
            let productPrice = parseFloat(this.getAttribute("data-price"));
            let productImage = this.getAttribute("data-image");

            let existingProduct = wishlist.find(item => item.id === productID);

            if (existingProduct) {
                wishlist = wishlist.filter(item => item.id !== productID);
                alert(`${productName} removed from wishlist ❌`);
                this.textContent = "❤️ Add to Wishlist";
            } else {
                wishlist.push({
                    id: productID,
                    name: productName,
                    price: productPrice,
                    image: productImage
                });
                alert(`${productName} added to wishlist ❤️`);
                this.textContent = "✅ In Wishlist";
            }

            localStorage.setItem("wishlist", JSON.stringify(wishlist));
            updateWishlistCount();
        });
    });
});
</script>

</body>
</html>

<?php include '/xampp/htdocs/ProjectCraft/Main/footer.php' ?>
