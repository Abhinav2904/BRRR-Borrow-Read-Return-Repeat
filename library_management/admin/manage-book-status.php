<?php
session_start();
include('../includes/db.php');

// Check if the request method is POST and the required data is set
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['status'])) {
    $book_id = $_POST['id'];
    $new_status = $_POST['status'];

    // Validate the status (only '0' or '1' is acceptable)
    if ($new_status == '0' || $new_status == '1') {
        // Prepare the SQL query to update the status
        $update_query = "UPDATE books SET status = '$new_status' WHERE id = '$book_id'";

        if (mysqli_query($conn, $update_query)) {
            echo "Book status updated successfully.";
        } else {
            echo "Error updating book status. Please try again.";
        }
    } else {
        echo "Invalid status value.";
    }
} else {
    echo "Invalid request.";
}

?>
