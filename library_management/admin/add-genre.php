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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $genre_name = mysqli_real_escape_string($conn, $_POST['genre']);

    // Check if the genre already exists in the database
    $check_query = "SELECT * FROM genre WHERE genre = '$genre_name'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $error_message = "This genre already exists.";
    } else {
        // Insert the new genre into the database
        $insert_query = "INSERT INTO genre (genre, created_by) VALUES ('$genre_name', '$admin_id')";
        
        if (mysqli_query($conn, $insert_query)) {
            $success_message = "$genre_name has been successfully added.";
        } else {
            $error_message = "Error adding genre. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Genre</title>
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
                <h2>Add Genre</h2>

                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error_message; ?>
                    </div>
                <?php elseif (!empty($success_message)): ?>
                    <div class="alert alert-success">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="add-genre.php">
                    <div class="form-group">
                        <label for="genre">Genre Name:</label>
                        <input type="text" id="genre" name="genre" class="form-control" value="<?php echo isset($genre_name) ? $genre_name : ''; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Genre</button>
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
