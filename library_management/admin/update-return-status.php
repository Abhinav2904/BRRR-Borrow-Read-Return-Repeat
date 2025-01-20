<?php
// Include database connection
include '../includes/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['borrowId'], $data['bookId'])) {
        $borrowId = intval($data['borrowId']);
        $bookId = intval($data['bookId']);

        // Begin transaction
        mysqli_begin_transaction($conn);

        try {
            // Update borrowed_books status
            $updateBorrowedBooks = "UPDATE borrowed_books SET status = 4, returned_on = NOW() WHERE id = $borrowId";
            if (!mysqli_query($conn, $updateBorrowedBooks)) {
                throw new Exception('Error updating borrowed_books: ' . mysqli_error($conn));
            }

            // Increase book quantity
            $updateBooks = "UPDATE books SET quantity = quantity + 1 WHERE id = $bookId";
            if (!mysqli_query($conn, $updateBooks)) {
                throw new Exception('Error updating books: ' . mysqli_error($conn));
            }

            // Commit transaction
            mysqli_commit($conn);

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            // Rollback transaction on error
            mysqli_rollback($conn);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid data provided.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}

mysqli_close($conn);
?>
