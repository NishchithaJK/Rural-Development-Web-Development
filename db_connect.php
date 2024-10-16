<?php
    $servername = "localhost";
    $username = "root"; // Adjust according to your MySQL configuration
    $password = ""; // Adjust according to your MySQL configuration
    $dbname = "data";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>
