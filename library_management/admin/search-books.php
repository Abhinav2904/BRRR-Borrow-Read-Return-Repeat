<?php
include('../includes/db.php');

if (isset($_GET['query'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_GET['query']);

    // Fetch books based on the search query (search by name, author, or genre)
    $query = "SELECT * FROM books WHERE name LIKE '%$searchQuery%' OR author LIKE '%$searchQuery%' OR genre LIKE '%$searchQuery%' ORDER BY id ASC";
    $result = mysqli_query($conn, $query);

    // Check if any books match the search query
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td><img src="images/' . $row['image'] . '" alt="Book Image" class="book-image"></td>';
            echo '<td class="details-column">';
            echo 'Name: ' . $row['name'] . '<br>';
            echo 'Genre: ' . $row['genre'] . '<br>';
            echo 'Author: ' . $row['author'] . '<br>';
            echo 'Trending: ' . ($row['trending'] == '1' ? 'Yes' : 'No') . '<br>';
            echo 'Date Added: ' . date("d-m-Y", strtotime($row['created_on'])) . '</td>';
            echo '<td class="description-column">';
            $short_description = strlen($row['description']) > 900 ? substr($row['description'], 0, 900) . '...' : $row['description'];
            echo $short_description;
            if (strlen($row['description']) > 900) {
                echo '<a href="#" class="read-more">Read More</a>';
                echo '<span class="full-description" style="display:none;">' . $row['description'] . '</span>';
            }
            echo '</td>';
            echo '<td>';
            echo '<div class="row">';
            echo '<div class="col-md-5">';
            echo '<a href="edit-book.php?id=' . $row['id'] . '" class="btn btn-sm btn-primary">Edit</a><br><br>';
            echo 'Quantity: ' . $row['quantity'] . '</div>';
            echo '<div class="col-md-7">';
            echo '<select class="form-select form-select-sm book-status" data-id="' . $row['id'] . '">';
            echo '<option value="0" ' . ($row['status'] == '0' ? 'selected' : '') . '>Show</option>';
            echo '<option value="1" ' . ($row['status'] == '1' ? 'selected' : '') . '>Archive</option>';
            echo '</select>';
            echo '</div>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5">No books found.</td></tr>';
    }
}
?>
