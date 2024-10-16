<?php
session_start();
include 'db_connect.php'; // Database connection

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (isset($_POST['submit_registration'])) {
    // Village ID
    $village_id = $_POST['village_id'];
    
    // Basic Information
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $marital_status = $_POST['marital_status'];
    $contact_no = $_POST['contact_no'];
    $email = $_POST['email'];
    $vemail = $_POST['vemail'];
    $password = $_POST['password'];

    // Identity and Documentation
    $aadhar_no = $_POST['aadhar_no'];
    $voter_id = isset($_POST['voter_id']) ? $_POST['voter_id'] : null;
    $ration_card = $_POST['ration_card'];
    $pan_card = isset($_POST['pan_card']) ? $_POST['pan_card'] : null;

    // Address Details
    $house_no = $_POST['house_no'];
    $street = $_POST['street'];
    $pincode = $_POST['pincode'];
    $district = $_POST['district'];
    $state = $_POST['state'];

    // Family and Household Information
    $household_head = $_POST['household_head'];
    $family_members = $_POST['family_members'];

    // Education and Employment (Optional)
    $education_level = isset($_POST['education_level']) ? $_POST['education_level'] : null;
    $occupation = isset($_POST['occupation']) ? $_POST['occupation'] : null;
    $monthly_income = isset($_POST['monthly_income']) ? $_POST['monthly_income'] : null;
    $employment_type = isset($_POST['employment_type']) ? $_POST['employment_type'] : null;

    // Land and Property Details (Optional)
    $land_ownership = isset($_POST['land_ownership']) ? $_POST['land_ownership'] : null;
    $land_size = isset($_POST['land_size']) ? $_POST['land_size'] : null;
    $land_type = isset($_POST['land_type']) ? $_POST['land_type'] : null;
    $livestock_ownership = isset($_POST['livestock_ownership']) ? $_POST['livestock_ownership'] : null;

    // Health and Welfare Information (Optional)
    $health_condition = isset($_POST['health_condition']) ? $_POST['health_condition'] : null;
    $disability_status = isset($_POST['disability_status']) ? $_POST['disability_status'] : null;
    $health_scheme = isset($_POST['health_scheme']) ? $_POST['health_scheme'] : null;
    $welfare_beneficiary = isset($_POST['welfare_beneficiary']) ? $_POST['welfare_beneficiary'] : null;

    // Utilities and Services (Optional)
    $electricity_conn = isset($_POST['electricity_conn']) ? $_POST['electricity_conn'] : null;
    $water_conn = isset($_POST['water_conn']) ? $_POST['water_conn'] : null;
    $sanitation_facility = isset($_POST['sanitation_facility']) ? $_POST['sanitation_facility'] : null;
    $cooking_fuel = isset($_POST['cooking_fuel']) ? $_POST['cooking_fuel'] : null;
    $internet_connectivity = isset($_POST['internet_connectivity']) ? $_POST['internet_connectivity'] : null;

    // Emergency Contact
    $emergency_name = $_POST['emergency_name'];
    $emergency_relation = $_POST['emergency_relation'];
    $emergency_phone = $_POST['emergency_phone'];

    // Upload files
    $photo = $_FILES['photo'];
    $signature = $_FILES['signature'];
    $aadhar_card = $_FILES['aadhar_card'];
    $income_cast = $_FILES['income_cast'];

    // File upload directory
    $target_dir = "uploads/";

    $link = isset($_POST['landlink']) ? $_POST['landlink'] : null;


    // Create uploads directory if it doesn't exist
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $photo_target = $target_dir . basename($photo["name"]);
    $signature_target = $target_dir . basename($signature["name"]);
    $aadhar_card_target = $target_dir . basename($aadhar_card["name"]);
    $income_cast_target = $target_dir . basename($income_cast["name"]);

    // Check for upload errors
    if ($photo["error"] != 0 || $signature["error"] != 0 || $aadhar_card["error"] != 0  || $income_cast["error"] != 0 ) {
        die("Error uploading files.");
    }

    // Move files to uploads folder
    if (!move_uploaded_file($photo['tmp_name'], $photo_target) || !move_uploaded_file($signature['tmp_name'], $signature_target) || !move_uploaded_file($aadhar_card['tmp_name'], $aadhar_card_target ) ) {
        die("Error moving uploaded files.");
    }

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO residents (
        village_id, full_name, gender, dob, marital_status, contact_no, email, vemail, password, aadhar_no, voter_id, ration_card, 
        pan_card, house_no, street, pincode, district, state, household_head, family_members, education_level, 
        occupation, monthly_income, employment_type, land_ownership, land_size, land_type, livestock_ownership, 
        health_condition, disability_status, health_scheme, welfare_beneficiary, electricity_conn, water_conn, 
        sanitation_facility, cooking_fuel, internet_connectivity, emergency_name, emergency_relation, emergency_phone, 
        photo, signature, aadhar_card, income_cast, link
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?)");

    $stmt->bind_param("sssssssssssssssssssssssssssssssssssssssssssss", 
        $village_id, $full_name, $gender, $dob, $marital_status, $contact_no, $email, $vemail, $password, $aadhar_no, 
        $voter_id, $ration_card, $pan_card, $house_no, $street, $pincode, $district, $state, 
        $household_head, $family_members, $education_level, $occupation, $monthly_income, $employment_type, 
        $land_ownership, $land_size, $land_type, $livestock_ownership, $health_condition, $disability_status, 
        $health_scheme, $welfare_beneficiary, $electricity_conn, $water_conn, $sanitation_facility, 
        $cooking_fuel, $internet_connectivity, $emergency_name, $emergency_relation, $emergency_phone, 
        $photo["name"], $signature["name"], $aadhar_card["name"], $income_cast["name"] ,$link
    );

    if ($stmt->execute()) {
        echo "REGISTRATION SUCCESSFUL!!!";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<header>
    <h1>Resident Registration</h1>
    <form method="post" enctype="multipart/form-data">
        <!-- Village ID -->
        <label>Village ID:</label>
        <input type="text" name="village_id" required>
        
        <!-- Basic Information -->
        <h2>Basic Information</h2>
        <label>Full Name:</label>
        <input type="text" name="full_name" required>
        <label>Gender:</label>
        <select name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
        <label>Date of Birth:</label>
        <input type="date" name="dob" required>
        <label>Marital Status:</label>
        <select name="marital_status" required>
            <option value="single">Single</option>
            <option value="married">Married</option>
        </select>
        <label>Contact No:</label>
        <input type="text" name="contact_no" required>
        <label>Email Address:</label>
        <input type="email" name="email" required>
        <label>Village Email :</label>
        <input type="email" name="vemail" required>
        <label>Password :</label>
        <input type="text" name="password" required>

        <!-- Identity and Documentation -->
        <h2>Identity and Documentation</h2>
        <label>Aadhar No:</label>
        <input type="text" name="aadhar_no" required>
        <label>Voter ID (Optional):</label>
        <input type="text" name="voter_id">
        <label>Ration Card Number:</label>
        <input type="text" name="ration_card" required>
        <label>PAN Card No (Optional):</label>
        <input type="text" name="pan_card">

        <!-- Address Details -->
        <h2>Address Details</h2>
        <label>House Number/House Name:</label>
        <input type="text" name="house_no" required>
        <label>Street/Village:</label>
        <input type="text" name="street" required>
        <label>Pincode:</label>
        <input type="text" name="pincode" required>
        <label>District:</label>
        <input type="text" name="district" required>
        <label>State:</label>
        <input type="text" name="state" required>

        <!-- Family and Household Information -->
        <h2>Family and Household Information</h2>
        <label>Household Head Name:</label>
        <input type="text" name="household_head" required>
        <label>No. of Family Members:</label>
        <input type="number" name="family_members" required>

        <!-- Education and Employment (Optional) -->
        <h2>Education and Employment</h2>
        <label>Education Level:</label>
        <select name="education_level">
            <option value="primary">Primary</option>
            <option value="secondary">Secondary</option>
            <option value="graduate">Graduate</option>
            <option value="postgraduate">Postgraduate</option>
        </select>
        <label>Occupation:</label>
        <input type="text" name="occupation">
        <label>Monthly Income:</label>
        <input type="text" name="monthly_income">
        <label>Employment Type:</label>
        <select name="employment_type">
            <option value="government">Government Employee</option>
            <option value="self-employed">Self Employed</option>
            <option value="agriculture">Agriculture</option>
            <option value="skilled-labour">Skilled/Unskilled Labour</option>
        </select>

        <!-- Land and Property Details (Optional) -->
        <h2>Land and Property Details</h2>
        <label>Land Ownership Status:</label>
        <select name="land_ownership">
            <option value="ownsland">Owns Land</option>
            <option value="tenant">Tenant</option>
        </select>
        <label>Landholding Size (Optional):</label>
        <input type="text" name="land_size">
        <label>Type of Land (Optional):</label>
        <select name="land_type">
            <option value="agricultural">Agricultural</option>
            <option value="residential">Residential</option>
            <option value="commercial">Commercial</option>
        </select>
        <label>Livestock Ownership (Optional):</label>
        <input type="text" name="livestock_ownership">

        <!-- Health and Welfare Information (Optional) -->
        <h2>Health and Welfare Information</h2>
        <label>Health Condition (if any):</label>
        <input type="text" name="health_condition">
        <label>Disability Status (if any):</label>
        <input type="text" name="disability_status">
        <label>Registered for Health Schemes (if any):</label>
        <input type="text" name="health_scheme">
        <label>Government Welfare Beneficiary Status (if any):</label>
        <input type="text" name="welfare_beneficiary">

        <!-- Utilities and Services (Optional) -->
        <h2>Utilities and Services</h2>
        <label>Electricity Connection Number:</label>
        <input type="text" name="electricity_conn">
        <label>Water Connection Details:</label>
        <input type="text" name="water_conn">
        <label>Sanitation Facility:</label>
        <select name="sanitation_facility">
            <option value="own_toilet">Own Toilet</option>
            <option value="public_toilet">Public Toilet</option>
        </select>
        <label>Cooking Fuel Source:</label>
        <input type="text" name="cooking_fuel">
        <label>Internet Connectivity:</label>
        <select name="internet_connectivity">
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>

        <!-- Emergency Contact -->
        <h2>Emergency Contact</h2>
        <label>Emergency Contact Name:</label>
        <input type="text" name="emergency_name" required>
        <label>Relation to Resident:</label>
        <input type="text" name="emergency_relation" required>
        <label>Emergency Contact Phone No:</label>
        <input type="text" name="emergency_phone" required>

        <!-- File Uploads -->
        <h2>Upload Documents</h2>
        <label>Upload Resident's Photocopy:</label>
        <input type="file" name="photo" required>
        <label>Upload Signature or Thumbprint:</label>
        <input type="file" name="signature" required>
        <label>Upload Aadhar Card:</label>
        <input type="file" name="aadhar_card" required>
        <label>Income and caste certificate:</label>
        <input type="file" name="income_cast" >
        <label>Add Link:</label>
        <input type="text" name="landlink">
</br>
</br>

        <input type="submit" name="submit_registration" value="Register">
    </form>
</body>
</html>








<?php

// Fetch villagers from the database
$sql = "SELECT village_id, full_name, contact_no, email FROM residents";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dashboard.css"> <!-- Assuming dashboard.css for styling -->
</head>
<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li>Welcome, <?php echo isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Admin'; ?></li>
            <li><a href="profile_list.php">All Villager Profiles</a></li>
            <li><a href="complaints_list.php">Complaints</a></li>
            <li><a href="add_products.php">Add Shopping credentials</a></li>
            <li>
                <form method="post" action="logout.php">
                    <button type="submit" name="logout" class="logout-button">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</body>
</html>
