<?php
session_start();
include 'db_connect.php'; // Database connection

if (isset($_GET['village_id'])) {
    $village_id = $_GET['village_id'];

    // Fetch villager details
    $stmt = $conn->prepare("SELECT * FROM residents WHERE village_id = ?");
    $stmt->bind_param("s", $village_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $villager = $result->fetch_assoc();
    } else {
        die("Villager not found.");
    }
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $villager['full_name']; ?>'s Profile</title>
    <link rel="stylesheet" href="villager_profile.css"> <!-- Link to your CSS file -->
</head>
<body>
    <h1>Profile Details of <?php echo $villager['full_name']; ?></h1>

    <div class="profile-details">
        <img src="uploads/<?php echo $villager['photo']; ?>" alt="Villager Photo" width="150">
        <p><strong>Full Name:</strong> <?php echo $villager['full_name']; ?></p>
        <p><strong>Gender:</strong> <?php echo $villager['gender']; ?></p>
        <p><strong>Date of Birth:</strong> <?php echo $villager['dob']; ?></p>
        <p><strong>Marital Status:</strong> <?php echo $villager['marital_status']; ?></p>
        <p><strong>Contact No:</strong> <?php echo $villager['contact_no']; ?></p>
        <p><strong>Email:</strong> <?php echo $villager['email']; ?></p>
        <p><strong>Aadhar No:</strong> <?php echo $villager['aadhar_no']; ?></p>
        <p><strong>Voter ID:</strong> <?php echo $villager['voter_id']; ?></p>
        <p><strong>Ration Card No:</strong> <?php echo $villager['ration_card']; ?></p>
        <p><strong>PAN Card No:</strong> <?php echo $villager['pan_card']; ?></p>
        <p><strong>House No:</strong> <?php echo $villager['house_no']; ?></p>
        <p><strong>Street:</strong> <?php echo $villager['street']; ?></p>
        <p><strong>Pincode:</strong> <?php echo $villager['pincode']; ?></p>
        <p><strong>District:</strong> <?php echo $villager['district']; ?></p>
        <p><strong>State:</strong> <?php echo $villager['state']; ?></p>
        <p><strong>Household Head:</strong> <?php echo $villager['household_head']; ?></p>
        <p><strong>No. of Family Members:</strong> <?php echo $villager['family_members']; ?></p>
        <!-- Add more fields as needed -->
    </div>

    <a href="admin.php">Back to Villager List</a>
</body>
</html>
