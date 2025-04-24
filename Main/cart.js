document.addEventListener("DOMContentLoaded", function () {
    // Select all "Add to Cart" buttons
    let cartButtons = document.querySelectorAll(".add-to-cart");

    cartButtons.forEach(button => {
        button.addEventListener("click", function () {
            let product = this.closest(".product"); // Find parent product div
            
            // Extract product name and price (Adjust selectors based on your structure)
            let productName = product.querySelector("h3")?.textContent.trim();
            let productPrice = product.querySelector("p")?.textContent.replace("₹", "").trim();
            let productImage = product.querySelector("img")?.src; // Get image URL if available

            let item = {
                name: productName,
                price: parseFloat(productPrice),
                image: productImage,
                quantity: 1
            };

            addToCart(item);
        });
    });

    // Function to add product to cart
    function addToCart(item) {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];

        // Check if item is already in the cart
        let existingItem = cart.find(cartItem => cartItem.name === item.name);

        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push(item);
        }

        // Save updated cart to localStorage
        localStorage.setItem("cart", JSON.stringify(cart));

        alert(`${item.name} added to cart!`);
    }
});
