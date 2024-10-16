<?php
session_start();
include('db_connect.php'); // Include your database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="products.css">
    <title>Shopping Village Products</title>
</head>
<body>

    <!-- Header -->
    <header>
        <div class="header-left">
            <h1 style="color:white">VILLAGE PANCHAYAT SHOPPING</h1>
        </div>
        <div class="header-right">
            <p><?php echo $_SESSION['username']; ?>
            <a href="logout.php" class="logout-btn">Logout</a></p>
        </div>
    </header>

    <!-- Products Section -->
    <div class="products-container">
        <h2>Available Village Products</h2>

        <?php
        // Fetch products from the database
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='product' data-price='" . $row['price'] . "'>";
                echo "<img src='" . $row['image_url'] . "' alt='" . $row['name'] . "' />";
                echo "<h3>" . $row['name'] . "</h3>";
                echo "<p>" . $row['description'] . " ₹" . $row['price'] . "</p>";
                echo "<button onclick=\"addToCart('" . $row['name'] . "', " . $row['price'] . ")\">Add to Cart</button>";
                echo "</div>";
            }
        } else {
            echo "<p>No products available at the moment.</p>";
        }
        ?>
    </div>

    <!-- Cart Section -->
    <div class="cart">
        <h2>Your Cart</h2>
        <ul id="cart-items"></ul>
        <div id="total-amount">Total: ₹0</div>
        <button onclick="checkout()">Checkout</button>
    </div>

    <!-- Delivery Details Modal -->
    <div id="delivery-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Enter Delivery Details</h2>
            <form id="delivery-form" onsubmit="handleCheckout(event)">
                <label for="address">Address:</label>
                <input type="text" id="address" required>

                <label for="pincode">Pincode:</label>
                <input type="text" id="pincode" required>

                <!-- New phone number input -->
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" pattern="[0-9]{10}" required>

                <button type="submit">Confirm Order</button>
            </form>
        </div>
    </div>

    <script>
        let cart = [];
        let totalAmount = 0;

        function addToCart(product, price) {
            const existingItem = cart.find(item => item.product === product);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({ product, price, quantity: 1 });
            }
            totalAmount += price;
            displayCart();
        }

        function displayCart() {
            const cartItems = document.getElementById('cart-items');
            cartItems.innerHTML = '';
            cart.forEach(item => {
                const li = document.createElement('li');
                li.textContent = `${item.quantity} nos of ${item.product} - ₹${item.price * item.quantity}`;
                cartItems.appendChild(li);
            });
            document.getElementById('total-amount').textContent = `Total: ₹${totalAmount}`;
        }

        function checkout() {
            if (cart.length > 0) {
                document.getElementById('delivery-modal').style.display = 'block';
            } else {
                alert("Your cart is empty.");
            }
        }

        function closeModal() {
            document.getElementById('delivery-modal').style.display = 'none';
        }

        function handleCheckout(event) {
            event.preventDefault();
            const address = document.getElementById('address').value;
            const pincode = document.getElementById('pincode').value;
            const phone = document.getElementById('phone').value;

            alert(`Order placed!\nAddress: ${address}\nPincode: ${pincode}\nPhone: ${phone}\nTotal Amount: ₹${totalAmount}`);
            cart = [];
            totalAmount = 0;
            displayCart();
            closeModal();
        }
    </script>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <p>&copy; 2024 Village Panchayat Development. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
