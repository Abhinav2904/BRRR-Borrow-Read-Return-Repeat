<div class="col-md-2 sidebar">
    <h4 class="text-center text-light">Admin Panel</h4>
    <!-- Main Tabs with Submenus -->
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="../index.php">Home</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="dashboard.php">Dashboard</a>
         </li>
         <!-- Users Tab -->
        <!-- <li class="nav-item">
            <a class="nav-link" href="#" onclick="toggleSubMenu('users')">
                Users <span class="toggle-icon" id="users-toggle">+</span>
            </a>
            <ul class="nav flex-column submenu" id="users-submenu">
                <li class="nav-item">
                    <a class="nav-link" href="add-user.php">Add User</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user-list.php">User List</a>
                </li>
            </ul>
        </li> -->

        <!-- Books Tab -->
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="toggleSubMenu('books')">
                Books <span class="toggle-icon" id="books-toggle">+</span>
            </a>
            <ul class="nav flex-column submenu" id="books-submenu">
                <li class="nav-item">
                    <a class="nav-link" href="add-book.php">Add Book</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="books-list.php">Books List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add-genre.php">Add Genre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="genre-list.php">Genre List</a>
                </li>
            </ul>
        </li>

        <!-- Reports Tab -->
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="toggleSubMenu('reports')">
                Borrows <span class="toggle-icon" id="reports-toggle">+</span>
            </a>
            <ul class="nav flex-column submenu" id="reports-submenu">
                <li class="nav-item">
                    <a class="nav-link" href="borrowed-books-list.php">Borrow Requests</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="borrowed-books.php">Ongoing Borrows</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="borrowed-books-returned.php">Borrows Returned</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="borrow-request-rejected.php">Borrows Rejected</a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="toggleSubMenu('returns')">
                Returns <span class="toggle-icon" id="returns-toggle">+</span>
            </a>
            <ul class="nav flex-column submenu" id="returns-submenu">
                <li class="nav-item">
                    <a class="nav-link" href="return-requests.php">Return Requests</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="books-returned.php">Books Returned</a>
                </li>
            </ul>
        </li>

        <!-- Logout -->
        <li class="nav-item">
            <a class="nav-link" href="../logout.php">Logout</a>
        </li>
    </ul>
</div>

<script src="../assets/admin-js.js"></script>
