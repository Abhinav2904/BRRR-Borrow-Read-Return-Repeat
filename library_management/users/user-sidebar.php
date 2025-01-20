<div class="col-md-2 sidebar">
    <h4 class="text-center text-light">User Account</h4>
    <!-- Main Tabs with Submenus -->
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="../index.php">Home</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="dashboard.php">Dashboard</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="cart.php">Cart</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="#" onclick="toggleSubMenu('user_books')">
                My Books <span class="toggle-icon" id="user_books-toggle">+</span>
            </a>
            <ul class="nav flex-column submenu" id="user_books-submenu">
               <li class="nav-item">
                  <a class="nav-link" href="all-books-list.php">All Books</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="books-requested.php">Borrow Requests</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="ongoing-borrows.php">Ongoing Borrows</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="books-returned.php">Books Returned</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="request-rejected.php">Requests Denied</a>
               </li>
            </ul>
        </li>

        <!-- Logout -->
        <li class="nav-item">
            <a class="nav-link" class="btn btn-danger btn-sm" href="../logout.php">Logout</a>
        </li>
    </ul>
</div>

<script src="../assets/user-js.js"></script>
