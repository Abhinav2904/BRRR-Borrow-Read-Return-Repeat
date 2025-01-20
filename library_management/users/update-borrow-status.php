<?php
// Include database connection
include '../includes/db.php';

// Set content type to JSON for API response
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the JSON input from the client
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate the input data
    if (isset($data['id']) && isset($data['status'])) {
        $id = intval($data['id']); // Convert to integer to prevent SQL injection
        $status = intval($data['status']);

        // Validate the values (e.g., ensure valid status values)
        if ($id > 0 && in_array($status, [1, 2, 3, 4])) { // Adjust status values as per your use case
            // Update the borrowed_books table
            $sql = "UPDATE borrowed_books SET status = $status WHERE id = $id";

            if (mysqli_query($conn, $sql)) {
                // If update is successful, respond with success
                echo json_encode(['success' => true]);
            } else {
                // If update fails, return the SQL error
                echo json_encode(['success' => false, 'error' => 'db error']);
            }
        } else {
            // Invalid ID or status value
            echo json_encode(['success' => false, 'error' => 'Invalid ID or status value.']);
        }
    } else {
        // Missing required fields in the input
        echo json_encode(['success' => false, 'error' => 'Invalid data provided.']);
    }
} else {
    // Handle invalid request methods
    echo json_encode(['success' => false, 'error' => 'Invalid request method. Only POST is allowed.']);
}

// Close the database connection
mysqli_close($conn);
?>
