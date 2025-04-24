<?php include '/xampp/htdocs/ProjectCraft/Main/header.php'?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dining</title>
  <link rel="stylesheet" href="bedding_cussion.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
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
<style>
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
<body>
  <div class="breadcrumb">
    <a href="/ProjectCraft/Main/homepage.php">Home</a>/
    <span>Homedecor</span>/
    <span>Dinning</span>
  </div>
<h1>Dining</h1>
<!-- <div class="dropdown">
    <button class="dropbtn">Sort By Price - Low To High ▼</button>
    <div class="dropdown-content">
      <a href="#">Price - Low To High</a>
      <a href="#">Price - High To Low</a>
    </div>
  </div> -->
<div>
<?php
$con = mysqli_connect("localhost", "root", "", "project_craft");

$query = "SELECT * FROM product_table WHERE category = 'homedecor' AND sub_category = 'dinning';";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    echo '<section class="products">';
    echo '<div class="product-grid">';
    while ($row = mysqli_fetch_assoc($result)) {
        $productID = $row['id']; // Unique ID from DB
        $productName = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
        $productPrice = $row['price'];
        $productImage = "/ProjectCraft/Main/admin/CRUD/images/" . $row['image'];

        echo '<div class="product-item">';
        echo '<a href="/ProjectCraft/Main/product_details.php?id=' . $productID . '">';
        echo '<img src="' . $productImage . '" alt="' . $productName . '">';
        echo '</a>';
        echo '<h3>' . $row['description'] . '</h3>';
        echo '<p><span class="rupee">&#8377;</span>' . $productPrice . '</p>';
        
        // Add Unique ID to Button
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
</div>
</div> 
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
<?php include '/xampp/htdocs/ProjectCraft/Main/footer.php'?>
