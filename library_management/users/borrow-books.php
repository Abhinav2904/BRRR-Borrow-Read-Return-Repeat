<?php
session_start();
include('../includes/db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch books in the cart
$query = "SELECT * FROM cart WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $bookIds = []; // To keep track of book IDs for deletion
    while ($row = mysqli_fetch_assoc($result)) {
        $book_id = $row['item'];
        $created_by = $user_id;

        // Insert into borrowed_books table
        $insertQuery = "INSERT INTO borrowed_books (user_id, book_id, created_by) 
                        VALUES ($user_id, $book_id, $created_by)";
        if (mysqli_query($conn, $insertQuery)) {
            $bookIds[] = $row['id']; // Collect the cart entry ID for deletion
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error inserting into borrowed_books']);
            exit();
        }
    }

    // Delete the corresponding entries from the cart table
    if (!empty($bookIds)) {
        $idsToDelete = implode(',', $bookIds);
        $deleteQuery = "DELETE FROM cart WHERE user_id = $user_id";
        mysqli_query($conn, $deleteQuery);
        unset($_SESSION['cart']);
    }

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No books in the cart']);
}
?>
