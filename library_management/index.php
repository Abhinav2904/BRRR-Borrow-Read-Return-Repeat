<?php
include 'includes/db.php';
include 'includes/header.php';

// Cart Items check
$cart_items = [];
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $cart_query = "SELECT item FROM cart WHERE created_by = '$user_id'";
    $cart_result = mysqli_query($conn, $cart_query);

    while ($row = mysqli_fetch_assoc($cart_result)) {
        $cart_items[] = $row['item'];
    }
}
?>
<link href="assets/main.css" rel="stylesheet">
<div class="container">
    <h1>Welcome to BRRR</h1>
    <h2>Borrow - Read - Return - Repeat</h2>
    <!-- Search bar -->
    <input type="text" id="search-bar" class="form-control mb-3" placeholder="Search by Name, Author, or Genre">

    <!-- Books Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Image</th>
                <th>Details</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="books-table">
            <!-- Rows will be populated via JavaScript -->
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const searchBar = document.getElementById('search-bar');
    const booksTable = document.getElementById('books-table');

    // Fetch all books initially
    fetchBooks();

    // Add event listener to search bar for live search
    searchBar.addEventListener('keyup', () => fetchBooks(searchBar.value));

    function fetchBooks(query = '') {
        fetch('fetch-books.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ search: query })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderBooks(data.books);
            } else {
                booksTable.innerHTML = '<tr><td colspan="5">No books found.</td></tr>';
            }
        });
    }

    function renderBooks(books) {
    booksTable.innerHTML = ''; // Clear current table rows
    let sNo = 1;

    books.forEach(book => {
        const inCart = book.in_cart ? 'Remove' : 'Add to Cart';
        const btnClass = book.in_cart ? 'btn-danger' : 'btn-primary';
        const btnAction = book.in_cart ? 'remove' : 'add';

        // If the book quantity is 0, apply the 'out-of-stock' class and disable the button
        const isOutOfStock = book.quantity === '0';
        const row = `
            <tr class="${isOutOfStock ? 'out-of-stock' : ''}">
                <td>${sNo++}</td>
                <td><img src="admin/images/${book.image}" class="book-image" alt="${book.name}"></td>
                <td>
                    <strong>${book.name}</strong><br>
                    Author: ${book.author}<br>
                    Genre: ${book.genre}<br>
                    Stock: ${book.quantity}
                </td>
                <td>${book.description}</td>
                <td>
                    <button class="btn ${btnClass} btn-sm add-to-cart"
                            data-action="${btnAction}" 
                            data-book-id="${book.id}"
                            ${isOutOfStock ? 'disabled' : ''}>
                            ${isOutOfStock ? 'Out of Stock' : inCart}
                    </button>
                </td>
            </tr>`;

        booksTable.innerHTML += row;
    });

    // Reinitialize event listeners for buttons
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', handleCartAction);
    });
}



    function handleCartAction() {
        const bookId = this.getAttribute('data-book-id');
        const action = this.getAttribute('data-action');
        const buttonElement = this;

        // AJAX request for add/remove action
        fetch('cart-handler.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action, book_id: bookId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.redirect) {
                // Redirect to login if not authenticated
                window.location.href = data.redirect;
            } else if (data.success) {
                alert(data.message);

                // Update button state based on the action
                if (action === 'add') {
                    buttonElement.textContent = 'Remove';
                    buttonElement.classList.remove('btn-primary');
                    buttonElement.classList.add('btn-danger');
                    buttonElement.setAttribute('data-action', 'remove');
                } else {
                    buttonElement.textContent = 'Add to Cart';
                    buttonElement.classList.remove('btn-danger');
                    buttonElement.classList.add('btn-primary');
                    buttonElement.setAttribute('data-action', 'add');
                }
            } else {
                alert(data.message);
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('An error occurred. Please try again.');
        });
    }
});


</script>
<?php include 'includes/footer.php'; ?>
