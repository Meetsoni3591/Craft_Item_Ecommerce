<?php include'/xampp/htdocs/ProjectCraft/Main/header.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* padding: 20px; */
            text-align: center;
        }
        h1 {
            color: #752d42;
        }
        .wishlist-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }
        .wishlist-item {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            width: 250px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.2);
        }
        .wishlist-item img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .wishlist-item h3 {
            font-size: 16px;
            margin: 10px 0;
        }
        .wishlist-item p {
            font-size: 14px;
            color: #333;
        }
        .remove-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .remove-btn:hover {
            background-color: #c0392b;
        }
        .empty-message {
            font-size: 18px;
            color: #555;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <h1>My Wishlist</h1>

    <div id="wishlist-container" class="wishlist-container"></div>

    <p id="empty-message" class="empty-message" style="display: none;">Your wishlist is empty! Add some products. 😊</p>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];
            const wishlistContainer = document.getElementById("wishlist-container");
            const emptyMessage = document.getElementById("empty-message");

            function updateWishlistDisplay() {
                wishlistContainer.innerHTML = "";
                if (wishlist.length === 0) {
                    emptyMessage.style.display = "block";
                } else {
                    emptyMessage.style.display = "none";
                    wishlist.forEach((item, index) => {
                        let productDiv = document.createElement("div");
                        productDiv.classList.add("wishlist-item");
                        productDiv.innerHTML = `
                            <a href="/ProjectCraft/Main/product_details.php?id=${item.id}">
                                <img src="${item.image}" alt="${item.name}">
                            </a>
                            <h3>${item.name}</h3>
                            <p><strong>Price:</strong> ₹${item.price}</p>
                            <button class="remove-btn" data-index="${index}">❌ Remove</button>
                        `;
                        wishlistContainer.appendChild(productDiv);
                    });

                    document.querySelectorAll(".remove-btn").forEach(button => {
                        button.addEventListener("click", function () {
                            let index = this.getAttribute("data-index");
                            wishlist.splice(index, 1);
                            localStorage.setItem("wishlist", JSON.stringify(wishlist));
                            updateWishlistDisplay();
                        });
                    });
                }
            }

            updateWishlistDisplay();
        });
    </script>
<?php include '/xampp/htdocs/ProjectCraft/Main/footer.php'; ?>

</body>
</html>

