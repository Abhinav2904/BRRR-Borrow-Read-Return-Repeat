<?php
session_start();
include 'includes/db.php';

header('Content-Type: application/json');

// Get search term from the request
$search = json_decode(file_get_contents('php://input'), true)['search'] ?? '';
$search = mysqli_real_escape_string($conn, $search);

// Get current user's cart items from session
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Query to get books based on search
$query = "SELECT * FROM books WHERE status = '0'";
if (!empty($search)) {
    $query .= " AND (name LIKE '%$search%' OR author LIKE '%$search%' OR genre LIKE '%$search%')";
}

$result = mysqli_query($conn, $query);

$books = [];
if (mysqli_num_rows($result) > 0) {
    while ($book = mysqli_fetch_assoc($result)) {
        // Check if the book is in the cart
        $book['in_cart'] = in_array($book['id'], $cart_items);
        $books[] = $book;
    }
}

echo json_encode(['success' => true, 'books' => $books]);
?>
