<?php
session_start();
include 'db_connect.php'; // Database connection

// Check if village_id is set in the URL
if (isset($_GET['village_id'])) {
    $village_id = $_GET['village_id'];

    // Fetch resident data from the database
    $sql = "SELECT * FROM residents WHERE village_id = '$village_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $resident = mysqli_fetch_assoc($result);
    } else {
        echo "No resident found with this village ID.";
        exit;
    }
} else {
    echo "Village ID is not specified.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <h1>Resident Profile</h1>

    <h2>Basic Information</h2>
    <p><strong>Full Name:</strong> <?php echo $resident['full_name']; ?></p>
    <p><strong>Gender:</strong> <?php echo $resident['gender']; ?></p>
    <p><strong>Date of Birth:</strong> <?php echo $resident['dob']; ?></p>
    <p><strong>Marital Status:</strong> <?php echo $resident['marital_status']; ?></p>
    <p><strong>Contact No:</strong> <?php echo $resident['contact_no']; ?></p>
    <p><strong>Email Address:</strong> <?php echo $resident['email']; ?></p>

    <h2>Identity and Documentation</h2>
    <p><strong>Aadhar No:</strong> <?php echo $resident['aadhar_no']; ?></p>
    <p><strong>Voter ID:</strong> <?php echo $resident['voter_id'] ? $resident['voter_id'] : 'N/A'; ?></p>
    <p><strong>Ration Card Number:</strong> <?php echo $resident['ration_card']; ?></p>
    <p><strong>PAN Card No:</strong> <?php echo $resident['pan_card'] ? $resident['pan_card'] : 'N/A'; ?></p>

    <h2>Address Details</h2>
    <p><strong>House Number/House Name:</strong> <?php echo $resident['house_no']; ?></p>
    <p><strong>Street/Village:</strong> <?php echo $resident['street']; ?></p>
    <p><strong>Pincode:</strong> <?php echo $resident['pincode']; ?></p>
    <p><strong>District:</strong> <?php echo $resident['district']; ?></p>
    <p><strong>State:</strong> <?php echo $resident['state']; ?></p>

    <h2>Family and Household Information</h2>
    <p><strong>Household Head Name:</strong> <?php echo $resident['household_head']; ?></p>
    <p><strong>No. of Family Members:</strong> <?php echo $resident['family_members']; ?></p>

    <h2>Education and Employment</h2>
    <p><strong>Education Level:</strong> <?php echo $resident['education_level'] ? $resident['education_level'] : 'N/A'; ?></p>
    <p><strong>Occupation:</strong> <?php echo $resident['occupation'] ? $resident['occupation'] : 'N/A'; ?></p>
    <p><strong>Monthly Income:</strong> <?php echo $resident['monthly_income'] ? $resident['monthly_income'] : 'N/A'; ?></p>
    <p><strong>Employment Type:</strong> <?php echo $resident['employment_type'] ? $resident['employment_type'] : 'N/A'; ?></p>

    <h2>Land and Property Details</h2>
    <p><strong>Land Ownership Status:</strong> <?php echo $resident['land_ownership'] ? $resident['land_ownership'] : 'N/A'; ?></p>
    <p><strong>Landholding Size:</strong> <?php echo $resident['land_size'] ? $resident['land_size'] : 'N/A'; ?></p>
    <p><strong>Type of Land:</strong> <?php echo $resident['land_type'] ? $resident['land_type'] : 'N/A'; ?></p>
    <p><strong>Livestock Ownership:</strong> <?php echo $resident['livestock_ownership'] ? $resident['livestock_ownership'] : 'N/A'; ?></p>

    <h2>Health and Welfare Information</h2>
    <p><strong>Health Condition:</strong> <?php echo $resident['health_condition'] ? $resident['health_condition'] : 'N/A'; ?></p>
    <p><strong>Disability Status:</strong> <?php echo $resident['disability_status'] ? $resident['disability_status'] : 'N/A'; ?></p>
    <p><strong>Registered for Health Schemes:</strong> <?php echo $resident['health_scheme'] ? $resident['health_scheme'] : 'N/A'; ?></p>
    <p><strong>Government Welfare Beneficiary Status:</strong> <?php echo $resident['welfare_beneficiary'] ? $resident['welfare_beneficiary'] : 'N/A'; ?></p>

    <h2>Utilities and Services</h2>
    <p><strong>Electricity Connection Number:</strong> <?php echo $resident['electricity_conn'] ? $resident['electricity_conn'] : 'N/A'; ?></p>
    <p><strong>Water Connection Details:</strong> <?php echo $resident['water_conn'] ? $resident['water_conn'] : 'N/A'; ?></p>
    <p><strong>Sanitation Facility:</strong> <?php echo $resident['sanitation_facility'] ? $resident['sanitation_facility'] : 'N/A'; ?></p>
    <p><strong>Cooking Fuel Source:</strong> <?php echo $resident['cooking_fuel'] ? $resident['cooking_fuel'] : 'N/A'; ?></p>
    <p><strong>Internet Connectivity:</strong> <?php echo $resident['internet_connectivity'] ? 'Yes' : 'No'; ?></p>

    <h2>Emergency Contact</h2>
    <p><strong>Emergency Contact Name:</strong> <?php echo $resident['emergency_name']; ?></p>
    <p><strong>Relation to Resident:</strong> <?php echo $resident['emergency_relation']; ?></p>
    <p><strong>Emergency Contact Phone No:</strong> <?php echo $resident['emergency_phone']; ?></p>

    <h2>Uploaded Documents</h2>
    <p><strong>Photocopy:</strong> <img src="uploads/<?php echo $resident['photo']; ?>" alt="Resident Photo" width="150"></p>
    <p><strong>Signature:</strong> <img src="uploads/<?php echo $resident['signature']; ?>" alt="Resident Signature" width="150"></p>
    <p><strong>Landmark:</strong> 
    <a href="<?php echo $resident['link']; ?>" target="_blank"><?php echo $resident['link']; ?></a>
</p>
<button onclick="copyToClipboard('<?php echo $resident['link']; ?>')">Copy Link</button>

<script>
function copyToClipboard(text) {
    const tempInput = document.createElement('input');
    tempInput.style.position = 'absolute';
    tempInput.style.left = '-9999px';
    tempInput.value = text;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);
    alert('Link copied to clipboard');
}
</script>





    <a href="index.php"><a href="logout.php">Logout</a>
    <script src="js/script.js"></script>

</body>
</html>



<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialize variables
$village_id = '';
$resident = null;
$error = '';

// Fetch resident details based on village ID input
if (isset($_POST['fetch_resident'])) {
    $village_id = $_POST['village_id'];

    $sql = "SELECT full_name, photo FROM residents WHERE village_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $village_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $resident = $result->fetch_assoc();

    if (!$resident) {
        $error = "No resident found with this Village ID.";
    }
}

// Handle complaint submission
if (isset($_POST['submit_complaint'])) {
    $village_id = $_POST['village_id'];
    $complaint_text = $_POST['complaint_text'];

    // Insert complaint into the database
    $stmt = $conn->prepare("INSERT INTO complaints (village_id, complaint_text) VALUES (?, ?)");
    $stmt->bind_param("ss", $village_id, $complaint_text);
    if ($stmt->execute()) {
        echo "Complaint submitted successfully.";
    } else {
        echo "Error submitting complaint: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Complaint</title>
    <link rel="stylesheet" href="profile.css"> <!-- Assuming you have a CSS file for styling -->
</head>
<body>
    <h1>Submit Your Complaint</h1>

    <!-- Form to fetch resident details based on village ID -->
    <form method="post" action="">
        <label for="village_id">Enter Village ID:</label>
        <input type="text" name="village_id" id="village_id" value="<?php echo $village_id; ?>" required><br>
        <input type="submit" name="fetch_resident" value="Fetch Resident">

        <?php if ($error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
    </form>

    <?php if ($resident): ?>
        <!-- Display resident's photo and allow complaint submission -->
        <h2>Resident: <?php echo $resident['full_name']; ?></h2>
        <img src="uploads/<?php echo $resident['photo']; ?>" alt="Resident Photo" width="100"><br>

        <!-- Complaint form -->
        <form method="post" action="">
            <input type="hidden" name="village_id" value="<?php echo $village_id; ?>">
            <textarea name="complaint_text" placeholder="Enter your complaint here" required></textarea><br>
            <input type="submit" name="submit_complaint" value="Submit Complaint">
        </form>
    <?php endif; ?>
    <script src="js/script.js"></script>

</body>
</html>
