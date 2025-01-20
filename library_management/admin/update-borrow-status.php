<?php
session_start();
include('../includes/db.php');

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 0) {
    header("Location: ../login.php");
    exit();
}

// Get the borrow ID and status from the POST request
$borrowId = $_POST['id'];
$status = $_POST['status'];
$adminId = $_POST['admin_id'];

// Fetch the book ID associated with the borrowed book entry
$query = "SELECT * FROM borrowed_books WHERE id = $borrowId";
$result = mysqli_query($conn, $query);
$borrow = mysqli_fetch_assoc($result);

if ($borrow) {
    // Update the status of the borrowed book entry
    $updateQuery = "UPDATE borrowed_books SET status = $status, action_by = $adminId, action_on = NOW() WHERE id = $borrowId";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($status == 1) { // If the status is 'Accepted'
        // Reduce 1 from the book quantity
        $bookId = $borrow['book_id'];
        $bookQuery = "SELECT quantity FROM books WHERE id = $bookId";
        $bookResult = mysqli_query($conn, $bookQuery);
        $book = mysqli_fetch_assoc($bookResult);

        if ($book && $book['quantity'] > 0) {
            $newQuantity = $book['quantity'] - 1;
            $updateBookQuery = "UPDATE books SET quantity = $newQuantity WHERE id = $bookId";
            mysqli_query($conn, $updateBookQuery);
        }
    }

    if ($updateResult) {
        echo json_encode("success");
    } else {
        echo json_encode("error");
    }
}
?>
