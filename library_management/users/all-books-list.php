<?php
session_start();
include('../includes/db.php');

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header("Location: ../login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

// Initial query to fetch borrowed books from the database
$query = "SELECT * FROM borrowed_books WHERE user_id = $user_id ORDER BY created_on DESC";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowed Books List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/user.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include('user-sidebar.php'); ?>

            <!-- Main Content -->
            <div class="col-md-10 content">
                <h2>Borrowed Books List</h2>

                <!-- Search Bar -->
                <input type="text" id="search-bar" class="form-control mb-3" placeholder="Search by Book Name, Genre, User Name, Email, or Phone" />

                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Book Details</th>
                            <th>User Details</th>
                            <th>Borrowed On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="borrowed-books-list">
                        <?php 
                        $x = 1;
                        while ($row = mysqli_fetch_assoc($result)):
                            // Fetch book details
                            $book_id = $row['book_id'];
                            $book_query = "SELECT * FROM books WHERE id = $book_id";
                            $book_result = mysqli_query($conn, $book_query);
                            $book = mysqli_fetch_assoc($book_result);
                            
                            // Fetch user details
                            $user_id = $row['user_id'];
                            $user_query = "SELECT * FROM users WHERE id = $user_id";
                            $user_result = mysqli_query($conn, $user_query);
                            $user = mysqli_fetch_assoc($user_result);
                            
                            // Format date
                            $borrowed_on = date(" H:i d-m-Y", strtotime($row['action_on']));
                        ?>
                        <tr class="borrowed-book-item">
                            <td><?php echo $x++; ?></td>
                            <td>
                                <div class="d-flex">
                                    <div class="me-3">
                                        <img src="../admin/images/<?php echo $book['image']; ?>" alt="Book Image" class="book-image" style="width: 60px; height: 90px;">
                                    </div>
                                    <div>
                                        <strong><?php echo $book['name']; ?></strong><br>
                                        Author: <?php echo $book['author']; ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong><?php echo $user['name']; ?></strong><br>
                                Email: <?php echo $user['email']; ?><br>
                                Phone: <?php echo $user['phone']; ?>
                            </td>
                            <td><?php echo $borrowed_on; ?></td>
                            <td>
                                <?php if ($row['status'] == 0): ?>
                                    <span class="badge bg-info">Borrow Requested</span>
                                <?php elseif ($row['status'] == 1): ?>
                                    <span class="badge bg-warning">Borrowed</span>
                                <?php elseif ($row['status'] == 2): ?>
                                    <span class="badge bg-danger">Borrow Rejected</span>
                                <?php elseif ($row['status'] == 3): ?>
                                    <span class="badge bg-dark">Return Requested</span>
                                <?php elseif ($row['status'] == 4): ?>
                                    <span class="badge bg-success">Returned</span>
                                <?php endif; ?>
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

            // Handle dynamic search input
            $("#search-bar").keyup(function () {
                const searchTerm = $(this).val().toLowerCase();

                $(".borrowed-book-item").each(function () {
                    const bookName = $(this).find("td:nth-child(2)").text().toLowerCase();
                    const genre = $(this).find("td:nth-child(2)").text().toLowerCase();
                    const userName = $(this).find("td:nth-child(3)").text().toLowerCase();
                    const email = $(this).find("td:nth-child(3)").text().toLowerCase();
                    const phone = $(this).find("td:nth-child(3)").text().toLowerCase();

                    if (bookName.indexOf(searchTerm) !== -1 || genre.indexOf(searchTerm) !== -1 || userName.indexOf(searchTerm) !== -1 || email.indexOf(searchTerm) !== -1 || phone.indexOf(searchTerm) !== -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
</body>
</html>
