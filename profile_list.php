<?php
session_start();
include 'db_connect.php'; // Database connection

// Fetch all villagers added by the admin
$sql = "SELECT village_id, full_name, photo FROM residents";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Villager Profiles</title>
    <link rel="stylesheet" href="profile_list.css"> <!-- Link to your CSS file -->
</head>
<body>
    <h1>Villager Profiles</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="villager-list">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="villager-box">
                    <img src="uploads/<?php echo $row['photo']; ?>" alt="Villager Photo" width="100">
                    <h3><?php echo $row['full_name']; ?></h3>
                    <form method="get" action="villager_profile.php">
                        <input type="hidden" name="village_id" value="<?php echo $row['village_id']; ?>">
                        <input type="submit" value="See Profile Details">
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No villagers found.</p>
    <?php endif; ?>
</body>
</html>



