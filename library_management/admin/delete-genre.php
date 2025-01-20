<?php
session_start();
include_once '../includes/db.php'; // Include the database connection

// Check if 'id' is passed via GET
if (isset($_GET['id'])) {
    $genre_id = $_GET['id']; // Get the genre ID

    // Perform the delete operation
    $query = "DELETE FROM genre WHERE id = $genre_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['success_msg'] = "Genre has been successfully deleted.";
    } else {
        $_SESSION['error_msg'] = "Failed to delete genre. Please try again.";
    }
} else {
    $_SESSION['error_msg'] = "Invalid genre ID.";
}

// Redirect to the genre list page
header("Location: genre-list.php");
exit();
?>
