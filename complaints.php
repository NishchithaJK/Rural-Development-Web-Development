<?php
session_start();
include 'db_connect.php'; // Database connection

// Handle complaint submission
if (isset($_POST['submit_complaint'])) {
    $village_id = $_POST['village_id'];
    $complaint_text = $_POST['complaint_text'];

    // Check if the village ID exists in the residents table
    $stmt = $conn->prepare("SELECT full_name, photo FROM residents WHERE village_id = ?");
    $stmt->bind_param("s", $village_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $resident = $result->fetch_assoc();

    if ($resident) {
        // Village ID is valid, insert the complaint
        $stmt = $conn->prepare("INSERT INTO complaints (village_id, complaint_text) VALUES (?, ?)");
        $stmt->bind_param("ss", $village_id, $complaint_text);
        if ($stmt->execute()) {
            echo "Complaint submitted successfully for village ID: " . $village_id;
        } else {
            echo "Error submitting complaint: " . $stmt->error;
        }
    } else {
        // Invalid village ID
        echo "Invalid village ID. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Complaint</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Submit a Complaint</h1>
    
    <form method="post" action="">
        <label for="village_id">Enter Village ID:</label><br>
        <input type="text" id="village_id" name="village_id" placeholder="Enter your village ID" required><br><br>

        <label for="complaint_text">Enter Your Complaint:</label><br>
        <textarea id="complaint_text" name="complaint_text" placeholder="Enter your complaint here" required></textarea><br><br>

        <input type="submit" name="submit_complaint" value="Submit Complaint">
    </form>

</body>
</html>
