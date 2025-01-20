<?php
session_start();
include('../includes/db.php');

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 0) {
    header("Location: ../login.php");
    exit();
}

$admin_id = $_SESSION['user_id'];  // Get the admin's user id
$error_message = '';
$success_message = '';

$genre_id = $_GET['id']; // Get the genre ID

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $genre_name = mysqli_real_escape_string($conn, $_POST['genre']);

    // Check if the genre already exists in the database
    $check_query = "SELECT * FROM genre WHERE genre = '$genre_name'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $error_message = "This genre already exists.";
    } else {
        // update genre in the database
        $update_query = "UPDATE genre SET genre = '$genre_name', modified_on = NOW(), modified_by = $admin_id WHERE id = $genre_id;";
        
        if (mysqli_query($conn, $update_query)) {
            $success_message = "$genre_name has been successfully updated.";
        } else {
            $error_message = "Error updating genre. Please try again.";
        }
    }
}
// Fetch genres from the database
$query = "SELECT * FROM genre WHERE id = $genre_id ORDER BY id ASC";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Genre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/admin.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include('sidebar.php'); ?> <!-- Include the sidebar here -->

            <!-- Main Content -->
            <div class="col-md-10 content">
                <h2>Edit Genre</h2>

                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error_message; ?>
                    </div>
                <?php elseif (!empty($success_message)): ?>
                    <div class="alert alert-success">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="edit-genre.php?id=<?=$genre_id?>">
                    <div class="form-group">
                        <label for="genre">Genre Name:</label>
                        <input type="text" id="genre" name="genre" class="form-control" value="<?=$row['genre']?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Genre</button>
                </form>

                <div class="center-text">
                    <a href="dashboard.php">Go back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/admin-js.js"></script>
</body>
</html>
