<?php
session_start();
include 'includes/db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, return a redirect URL
    echo json_encode(['redirect' => 'login.php']);
    exit();
}

// Handle adding/removing books from cart
$action = json_decode(file_get_contents('php://input'), true)['action'];
$book_id = json_decode(file_get_contents('php://input'), true)['book_id'];

$user_id = $_SESSION['user_id'];

if ($action == 'add') {
    // Add to cart
    $query = "INSERT INTO cart (user_id, created_by, item) VALUES ('$user_id', '$user_id', '$book_id')";
    mysqli_query($conn, $query);

    // Add book to session cart array for instant feedback
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = $book_id;

    echo json_encode(['success' => true, 'message' => 'Book added to cart']);
} else if ($action == 'remove') {
    // Remove from cart
    $query = "DELETE FROM cart WHERE user_id = '$user_id' AND item = '$book_id'";
    mysqli_query($conn, $query);

    // Remove book from session cart array for instant feedback
    if (($key = array_search($book_id, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
    }

    echo json_encode(['success' => true, 'message' => 'Book removed from cart']);
}
?>
