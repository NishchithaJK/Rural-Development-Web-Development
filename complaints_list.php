<?php
session_start();
include 'db_connect.php'; // Database connection

// Check if the admin is logged in
// Add admin authentication check here

// Fetch complaints with resident details, tied by village ID, ensuring each complaint is tied only to the right resident
$sql = "SELECT complaints.complaint_id, complaints.complaint_text, complaints.created_at, complaints.resolved, 
        residents.full_name, residents.photo, complaints.village_id 
        FROM complaints 
        JOIN residents ON residents.village_id = complaints.village_id 
        WHERE complaints.village_id = residents.village_id
        ORDER BY complaints.created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Complaints</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <h1>Complaints List</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <tr>
                <th>Resident</th>
                <th>Village ID</th>
                <th>Complaint</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>
                        <img src="uploads/<?php echo $row['photo']; ?>" alt="Resident Photo" width="50">
                        <?php echo $row['full_name']; ?>
                    </td>
                    <td><?php echo $row['village_id']; ?></td>
                    <td><?php echo $row['complaint_text']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td><?php echo $row['resolved'] ? 'Resolved' : 'Unresolved'; ?></td>
                    <td>
                        <?php if (!$row['resolved']): ?>
                            <form method="post" action="">
                                <input type="hidden" name="complaint_id" value="<?php echo $row['complaint_id']; ?>">
                                <input type="submit" name="resolve_complaint" value="Mark as Resolved">
                            </form>
                        <?php else: ?>
                            <button disabled>Resolved</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No complaints found.</p>
    <?php endif; ?>

    <?php
    // Mark complaint as resolved
    if (isset($_POST['resolve_complaint'])) {
        $complaint_id = $_POST['complaint_id'];
        $sql_resolve = "UPDATE complaints SET resolved = 1 WHERE complaint_id = $complaint_id";
        if (mysqli_query($conn, $sql_resolve)) {
            header("Location: admin.php"); // Refresh the page after resolving the complaint
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    ?>
</body>
</html>
