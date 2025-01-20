<?php
include('../includes/db.php');
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    // Redirect to login page if user is not logged in or not an admin
    header("Location: ../login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/user.css" rel="stylesheet"> <!-- Link to external CSS -->
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Include Sidebar -->
        <?php include('user-sidebar.php'); ?>

        <!-- Main Content -->
        <div class="col-md-10 content">
            <h2>Welcome, <?=$row['name']?>!</h2>
            <p>This is your dashboard. Use the sidebar to navigate through the user panel.</p>
            <!-- Add your dashboard widgets or content here -->
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
