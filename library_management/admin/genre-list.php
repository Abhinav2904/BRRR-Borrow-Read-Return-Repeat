<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 0) {
    // Redirect to login page if user is not logged in or not an admin
    header("Location: ../login.php");
    exit();
}

include('../includes/db.php');

// Fetch genres from the database
$query = "SELECT * FROM genre ORDER BY id ASC";
$result = mysqli_query($conn, $query);

// Display success or error messages after deletion of genre
if (isset($_SESSION['success_msg'])) {
    echo "<p class='alert alert-success'>{$_SESSION['success_msg']}</p>";
    unset($_SESSION['success_msg']);
}

if (isset($_SESSION['error_msg'])) {
    echo "<p class='alert alert-danger'>{$_SESSION['error_msg']}</p>";
    unset($_SESSION['error_msg']);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genre List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/admin.css" rel="stylesheet"> <!-- Link to external CSS -->
</head>
<body>
    <div class="row">
        <?php include('sidebar.php'); ?>

        <div class="col-md-10 content">
            <h2>Genre List</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Genre</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $flag = 0;?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <?php $flag = 1;?>
                        <tr>
                            <td class="text-center"><?php echo $row['id']; ?></td>
                            <td class="text-center"><?php echo $row['genre']; ?></td>
                            <td class="text-center">
                                <a href="edit-genre.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete-genre.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this genre?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <?php if($flag==0){?>
                        <tr>
                            <p class='alert alert-danger'>No Genres Added Yet.</p>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
