<?php
session_start();
include('../includes/db.php');

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 0) {
    // Redirect to login page if user is not logged in or not an admin
    header("Location: ../login.php");
    exit();
}

// Query to get total books count
$totalBooksQuery = "SELECT COUNT(*) AS total_books FROM books";
$totalBooksResult = mysqli_query($conn, $totalBooksQuery);
$totalBooksRow = mysqli_fetch_assoc($totalBooksResult);
$totalBooks = $totalBooksRow['total_books'];

// Query to get total users count (where role = 1)
$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM users WHERE role = 1";
$totalUsersResult = mysqli_query($conn, $totalUsersQuery);
$totalUsersRow = mysqli_fetch_assoc($totalUsersResult);
$totalUsers = $totalUsersRow['total_users'];

// Query to get total books borrowed (status = 1 or 3)
$totalBooksBorrowedQuery = "SELECT COUNT(*) AS total_borrowed FROM borrowed_books WHERE status IN (1, 3)";
$totalBooksBorrowedResult = mysqli_query($conn, $totalBooksBorrowedQuery);
$totalBooksBorrowedRow = mysqli_fetch_assoc($totalBooksBorrowedResult);
$totalBooksBorrowed = $totalBooksBorrowedRow['total_borrowed'];

// Query to get total active borrowers (unique user_id with status = 1 or 3)
$totalActiveBorrowersQuery = "SELECT COUNT(DISTINCT user_id) AS total_active_borrowers FROM borrowed_books WHERE status IN (1, 3)";
$totalActiveBorrowersResult = mysqli_query($conn, $totalActiveBorrowersQuery);
$totalActiveBorrowersRow = mysqli_fetch_assoc($totalActiveBorrowersResult);
$totalActiveBorrowers = $totalActiveBorrowersRow['total_active_borrowers'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/admin.css" rel="stylesheet"> <!-- Link to external CSS -->
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Include Sidebar -->
        <?php include('sidebar.php'); ?>

        <!-- Main Content -->
        <div class="col-md-10 content">
            <h2>Welcome, Admin!</h2>

            <!-- Cards Section -->
            <div class="row">
                <!-- Total Books Card -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Books</h5>
                            <div class="d-flex justify-content-between">
                                <span>Books in Library</span>
                                <span><?php echo $totalBooks; ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Users Card -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <div class="d-flex justify-content-between">
                                <span>Registered Users</span>
                                <span><?php echo $totalUsers; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <!-- Cards Section (Second Row) -->
            <div class="row">
                <!-- Books Borrowed Card -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Books Borrowed</h5>
                            <div class="d-flex justify-content-between">
                                <span>Currently Borrowed</span>
                                <span><?php echo $totalBooksBorrowed; ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Borrowers Card -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Active Borrowers</h5>
                            <div class="d-flex justify-content-between">
                                <span>Unique Borrowers</span>
                                <span><?php echo $totalActiveBorrowers; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
