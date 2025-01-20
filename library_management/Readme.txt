BRRR - Borrow, Read, Return, Repeat

Overview

BRRR is a web-based library management system designed to streamline the process of borrowing, reading, returning, and repeating. It offers distinct functionalities for admins and users to efficiently manage library resources and activities.

Features

Admin Functionality

Manage Books: Add, edit, or remove books.

View Reports:

Total books in the library.

Active borrowed books.

Count of active borrowers.

Books Returned.

Manage Book Status: Show or archive books.

Track Borrowed Books: View books currently borrowed by users and their statuses.

Approve Returns: Accept return requests and update book quantities.

User Functionality

Register and Login: Users can create an account and log in to access the system.

Browse Books: Search books by title, author, or genre.

Borrow Books: Request to borrow books, if available.

Return Books: Request to return borrowed books.

View Borrowing History: Track currently borrowed books and their statuses.

System Structure

Frontend:

Developed with HTML, CSS (via Bootstrap), and JavaScript (with jQuery for interactivity).

Responsive and user-friendly interface for both admins and users.

Backend:

Built using PHP for server-side logic.

AJAX is used for seamless, asynchronous interactions with the server.

Database:

MySQL database with the following tables:

users: Stores user details (including roles).

books: Stores book information.

borrowed_books: Tracks borrowing and return statuses.

cart: Stores information of books the user wants to shortlist.

Code Explanation

Folder Structure

includes/: Contains reusable files such as db.php for database connection and common layouts like header.php and footer.php.

admin/: Contains admin-specific functionalities, including dashboards, book management, and return approvals.

assets/: Stores CSS and JS files.

users/: Contains user-specific functionalities, including dashboard, cart management, borrow and return request management.

Root Files:

index.php: Entry point for users.

login.php & register.php: Handle authentication.

Core Functionalities

Admin Dashboard (admin/dashboard.php):

Displays cards with key metrics using queries to fetch counts from respective tables.

Book Management (admin/book-list.php):

Allows admins to manage books.

Borrowing System:

Borrow Request: Users can borrow books if available (status handled in borrowed_books).

Return Request: Users request returns, and admins approve them.

AJAX Integration:

Dynamic Status Updates: Used in managing book availability and approving returns without reloading the page.

Database Schema

users Table:

Fields: id, name, email, password, role (0 for admin, 1 for user).

books Table:

Fields: id, name, author, genre, quantity, description, status (0 for show, 1 for archive).

borrowed_books Table:

Fields: id, user_id, book_id, status (0 for pending, 1 for borrowed, 2 for rejected, 3 for return requested, 4 for returned).

Setup Instructions

Install XAMPP and start Apache and MySQL.

Place the project folder in the htdocs directory.

Import the library.sql file into your MySQL database.

Update db.php in the includes/ folder with your database credentials.

Access the application at http://localhost/[project-folder].