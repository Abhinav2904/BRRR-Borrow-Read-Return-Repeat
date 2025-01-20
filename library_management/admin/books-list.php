<?php
session_start();
include('../includes/db.php');

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 0) {
    header("Location: ../login.php");
    exit();
}

// Fetch books from the database
$query = "SELECT * FROM books ORDER BY id ASC";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/admin.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include('sidebar.php'); ?>

            <!-- Main Content -->
            <div class="col-md-10 content">
                <h2>Books List</h2>
                

                <table class="table table-borderless">
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Details</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><img src="images/<?php echo $row['image']; ?>" alt="Book Image" class="book-image"></td>
                <td class="details-column">
                    Name: <?php echo $row['name']; ?><br>
                    Genre: <?php echo $row['genre']; ?><br>
                    Author: <?php echo $row['author']; ?><br>
                    Trending: <?php echo $row['trending'] == '1' ? 'Yes' : 'No'; ?><br>
                    Date Added: <?php echo date("d-m-Y", strtotime($row['created_on'])); ?>
                </td>
                <td class="description-column">
                    <?php
                    $short_description = strlen($row['description']) > 900 ? substr($row['description'], 0, 900) . '...' : $row['description'];
                    echo $short_description;
                    if (strlen($row['description']) > 900): ?>
                        <a href="#" class="read-more">Read More</a>
                        <span class="full-description" style="display:none;"><?php echo $row['description']; ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="row">
                        <div class="col-md-5">
                            <a href="edit-book.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a><br><br>
                            Quantity: <?php echo $row['quantity']; ?>
                        </div>
                        <div class="col-md-7">
                            <select class="form-select form-select-sm book-status" data-id="<?php echo $row['id']; ?>">
                                <option value="0" <?php echo $row['status'] == '0' ? 'selected' : ''; ?>>Show</option>
                                <option value="1" <?php echo $row['status'] == '1' ? 'selected' : ''; ?>>Archive</option>
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.book-status').change(function () {
                var bookId = $(this).data('id');
                var newStatus = $(this).val();

                // AJAX request to manage-book-status.php
                $.ajax({
                    url: 'manage-book-status.php',
                    type: 'POST',
                    data: {
                        id: bookId,
                        status: newStatus
                    },
                    success: function (response) {
                        alert(response); // Show success message from server
                    },
                    error: function () {
                        alert('An error occurred while updating the status. Please try again.');
                    }
                });
            });
        });
    </script>
</body>
</html>
