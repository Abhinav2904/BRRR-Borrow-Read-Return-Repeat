<?php
session_start();
include('../includes/db.php');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $cart_id = intval($_POST['cart_id']);
    $book_id = intval($_POST['book_id']);

    // Delete the item from the cart in the database
    $query = "DELETE FROM cart WHERE id = $cart_id AND user_id = $user_id AND item = $book_id";
    if (mysqli_query($conn, $query)) {
        // Remove the book from the session cart array
        if (isset($_SESSION['cart'])) {
            $key = array_search($book_id, $_SESSION['cart']);
            if ($key !== false) {
                unset($_SESSION['cart'][$key]);
                // Reindex the session array to prevent issues with numeric keys
                $_SESSION['cart'] = array_values($_SESSION['cart']);
            }
        }
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to remove item']);
    }
    exit();
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
exit();
?>
