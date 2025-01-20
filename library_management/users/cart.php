<?php
session_start();
include('../includes/db.php');

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch books in cart from the database
$query = "SELECT * FROM cart WHERE user_id = $user_id ORDER BY id ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/user.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include('user-sidebar.php'); ?>

            <!-- Main Content -->
            <div class="col-md-10 content">
                <h2>Your Cart</h2>

                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Image</th>
                            <th>Details</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items">
                        <?php $x = 1; $flag=0; while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr id="cart-row-<?php echo $row['id']; ?>">
                                <td><?php echo $x++; ?></td>
                                <?php
                                $book_id = $row['item'];
                                $qb = "SELECT * FROM books WHERE id = $book_id";
                                $rb = mysqli_query($conn, $qb);
                                $book_row = mysqli_fetch_assoc($rb);
                                ?>
                                <td><img src="../admin/images/<?php echo $book_row['image']; ?>" alt="Book Image" class="book-image"></td>
                                <td class="details-column">
                                    Name: <?php echo $book_row['name']; ?><br>
                                    Genre: <?php echo $book_row['genre']; ?><br>
                                    Author: <?php echo $book_row['author']; ?><br>
                                    Date Added: <?php echo date("d-m-Y", strtotime($book_row['created_on'])); ?>
                                </td>
                                <td>
                                    <button 
                                        class="btn btn-sm btn-danger remove-cart-item" 
                                        data-cart-id="<?php echo $row['id']; ?>" 
                                        data-book-id="<?php echo $book_id; ?>">Remove</button>
                                </td>
                            </tr>
                        <?php $flag=1; ?>
                        <?php endwhile; ?>
                        <?php if ($flag == 0): ?>
                            <tr>
                                <td colspan="4" class="text-center">No Books Added Yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <button id="borrow-books-btn" class="btn btn-primary mt-3" 
                        <?php echo $flag == 0 ? 'disabled' : ''; ?>>
                    Borrow
                </button>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        // Handle remove button click
        $(".remove-cart-item").click(function () {
            const cartId = $(this).data("cart-id");
            const bookId = $(this).data("book-id");
            const rowId = `#cart-row-${cartId}`;

            // Send AJAX request to remove item
            $.ajax({
                url: "remove-from-cart.php",
                type: "POST",
                data: {
                    cart_id: cartId,
                    book_id: bookId
                },
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.status === "success") {
                        // Remove the row from the table
                        $(rowId).remove();
                        alert("Book removed from cart!");

                        // Check if the cart is now empty
                        const remainingRows = $("#cart-items tr").filter(function () {
                            return !$(this).hasClass("no-books-row");
                        }).length;

                        if (remainingRows === 0) {
                            $("#cart-items").html(`
                                <tr class="no-books-row">
                                    <td colspan="4" class="text-center">No Books Added Yet.</td>
                                </tr>
                            `);
                            $("#borrow-books-btn").prop("disabled", true);
                        }
                    } else {
                        alert("Failed to remove item. Please try again.");
                    }
                },
                error: function () {
                    alert("An error occurred. Please try again.");
                }
            });
        });

        // Handle borrow button click
        $("#borrow-books-btn").click(function () {
            $.ajax({
                url: "borrow-books.php",
                type: "POST",
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.status === "success") {
                        alert("Your request to borrow the book(s) has been sent to the admin.");
                        $("#cart-items").html(`
                            <tr class="no-books-row">
                                <td colspan="4" class="text-center">No Books Added Yet.</td>
                            </tr>
                        `);
                        $("#borrow-books-btn").prop("disabled", true);
                    } else {
                        alert("Failed to process your request. Please try again.");
                    }
                },
                error: function () {
                    alert("An error occurred. Please try again.");
                }
            });
        });
    });
</script>


</body>
</html>
