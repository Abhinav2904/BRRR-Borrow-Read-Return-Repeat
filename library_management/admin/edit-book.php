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


$book_id = $_GET['id']; // Get the book ID

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $trending = isset($_POST['trending']) ? 1 : 0;
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $genres = isset($_POST['genres']) ? implode(',', $_POST['genres']) : '';
    
    // Validate inputs
    if (!preg_match("/^[a-zA-Z0-9\s]+$/", $name)) {
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

        if($image_name != ''){
            // Update the book into the database
            $update_query = "UPDATE books SET 
                     name = '$name', 
                     image = '$image_name', 
                     author = '$author', 
                     description = '$description', 
                     genre = '$genres', 
                     trending = '$trending', 
                     quantity = '$quantity', 
                     modified_by = '$admin_id', 
                     modified_on = NOW() 
                 WHERE id = '$book_id'";
        }else{
            // Update the book into the database
            $update_query = "UPDATE books SET 
                     name = '$name',  
                     author = '$author', 
                     description = '$description', 
                     genre = '$genres', 
                     trending = '$trending', 
                     quantity = '$quantity', 
                     modified_by = '$admin_id', 
                     modified_on = NOW() 
                 WHERE id = '$book_id'";
        }
            if (mysqli_query($conn, $update_query)) {
                $success_message = "Book '$name' has been successfully updated.";
            } else {
                $error_message = "Error updating book. Please try again.";
            }
        
    }
}

$query = "SELECT * FROM books WHERE id = $book_id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
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
                <h2>Edit Book</h2>

                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger">
                        <?php echo $error_message; ?>
                    </div>
                <?php elseif (!empty($success_message)): ?>
                    <div class="alert alert-success">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="edit-book.php?id=<?=$book_id?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Book Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?=$row['name']?>" required>
                    </div>

                    <div class="form-group">
                        <label for="author">Author Name:</label>
                        <input type="text" id="author" name="author" class="form-control" value="<?=$row['author']?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="image">Book Image:</label>
                                <input type="file" id="image" name="image" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                        <img src="images/<?= $row['image'] ?>" class="stamp-image" alt="<?= $row['name'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="genres">Genres:</label><br>
                        <?php
                        $genres_query = "SELECT id, genre FROM genre";
                        $genres_result = mysqli_query($conn, $genres_query);

                        if (mysqli_num_rows($genres_result) > 0):
                            while ($rows = mysqli_fetch_assoc($genres_result)): ?>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" id="genre_<?php echo $rows['id']; ?>" name="genres[]" value="<?php echo $rows['genre']; ?>" class="form-check-input" <?php if (strpos($row['genre'], $rows['genre']) !== false){ ?>checked<?php } ?>>
                                    <label class="form-check-label" for="genre_<?php echo $rows['id']; ?>"><?php echo $rows['genre']; ?></label>
                                </div>
                            <?php endwhile;
                        else: ?>
                            <p>No genres found. Please add genres first.</p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="trending">Trending:</label>
                        <input type="checkbox" id="trending" name="trending" value="1" <?php if($row['trending']=='1'){?>checked<?php } ?>>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" value="<?=$row['quantity']?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="4" class="form-control"><?=$row['description']?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Book</button>
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
