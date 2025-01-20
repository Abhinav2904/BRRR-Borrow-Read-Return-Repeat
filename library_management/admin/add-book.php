<?php
session_start();
include('../includes/db.php');

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 0) {
    header("Location: ../login.php");
    exit();
}

$admin_id = $_SESSION['user_id']; // Get the admin's user id
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $trending = isset($_POST['trending']) ? 1 : 0;
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $genres = isset($_POST['genres']) ? implode(',', $_POST['genres']) : '';
    
    // Validate inputs
    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $error_message = "Book name should only contain letters and spaces.";
    } elseif (!preg_match("/^[a-zA-Z\s.]+$/", $author)) {
        $error_message = "Author name should only contain letters and spaces.";
    } elseif (!ctype_digit($quantity)) {
        $error_message = "Quantity should only contain digits.";
    } elseif (empty($genres)) {
        $error_message = "Please select at least one genre.";
    } else {
        // Handle image upload
        $image_name = '';
        if (!empty($_FILES['image']['name'])) {
            $original_name = $_FILES['image']['name'];
            $file_extension = pathinfo($original_name, PATHINFO_EXTENSION);
            $sanitized_name = str_replace(' ', '_', strtolower($name));
            $unique_name = time() . '_' . $sanitized_name . '.' . $file_extension;
            $target_dir = "images/";
            $target_file = $target_dir . $unique_name;

            // Check if the upload is successful
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image_name = $unique_name;
            } else {
                $error_message = "Error uploading the image. Please try again.";
            }
        }

        if (empty($error_message)) {
            // Insert the book into the database
            $insert_query = "INSERT INTO books (name, image, author, description, genre, trending, quantity, created_by, created_on)
                             VALUES ('$name', '$image_name', '$author', '$description', '$genres', '$trending', '$quantity', '$admin_id', NOW())";

            if (mysqli_query($conn, $insert_query)) {
                $success_message = "Book '$name' has been successfully added.";
            } else {
                $error_message = "Error adding book. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
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
                <h2>Add Book</h2>

                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error_message; ?>
                    </div>
                <?php elseif (!empty($success_message)): ?>
                    <div class="alert alert-success">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="add-book.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Book Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo isset($name) ? $name : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="author">Author Name:</label>
                        <input type="text" id="author" name="author" class="form-control" value="<?php echo isset($author) ? $author : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="image">Book Image:</label>
                        <input type="file" id="image" name="image" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="genres">Genres:</label><br>
                        <?php
                        $genres_query = "SELECT id, genre FROM genre";
                        $genres_result = mysqli_query($conn, $genres_query);

                        if (mysqli_num_rows($genres_result) > 0):
                            while ($row = mysqli_fetch_assoc($genres_result)): ?>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" id="genre_<?php echo $row['id']; ?>" name="genres[]" value="<?php echo $row['genre']; ?>" class="form-check-input">
                                    <label class="form-check-label" for="genre_<?php echo $row['id']; ?>"><?php echo $row['genre']; ?></label>
                                </div>
                            <?php endwhile;
                        else: ?>
                            <p>No genres found. Please add genres first.</p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="trending">Trending:</label>
                        <input type="checkbox" id="trending" name="trending" value="1">
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" value="<?php echo isset($quantity) ? $quantity : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="4" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Book</button>
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
