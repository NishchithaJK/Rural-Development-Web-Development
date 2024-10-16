<?php
// Start session and include database connection
session_start();
include('db_connect.php');

// If the form is submitted, insert the data into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image_url = mysqli_real_escape_string($conn, $_POST['image_url']);

    // SQL query to insert product into the database
    $sql = "INSERT INTO products (name, price, description, image_url) 
            VALUES ('$product_name', '$price', '$description', '$image_url')";

    if (mysqli_query($conn, $sql)) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// If delete is requested, delete the product from the database using prepared statements
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);  // Ensure it's an integer

    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $delete_id);

    // Execute the delete query
    if ($stmt->execute()) {
        echo "Product deleted successfully!";
        header("Location: admin.php"); // Redirect to the admin dashboard after deletion
        exit;
    } else {
        echo "Error deleting product: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch all products from the database
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="add_products.css">
</head>
<body>
    <h2>Admin Dashboard - Add a New Product</h2>
    <form method="POST">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required><br><br>

        <label for="price">Price (in ₹):</label>
        <input type="number" id="price" name="price" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="image_url">Image URL:</label>
        <input type="text" id="image_url" name="image_url" required><br><br>

        <button type="submit">Add Product</button>
    </form>

    <h2>Manage Products</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Price (₹)</th>
            <th>Description</th>
            <th>Image</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td><img src='" . $row['image_url'] . "' alt='" . $row['name'] . "' style='width:100px;height:100px;'></td>";
                
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No products available.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
