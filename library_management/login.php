<?php
include 'includes/db.php';
include 'includes/header.php';

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];

            if ($user['role'] == 0) {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: users/dashboard.php");
            }
            exit();
        } else {
            $error_message = "Incorrect password.";
        }
    } else {
        $error_message = "No user found with this email.";
    }
}
?>
<link href="assets/main.css" rel="stylesheet">
<div class="container">
    <h2>Login</h2>
    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <div class="error"></div>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <div class="error"></div>
        </div>
        <button type="submit">Login</button>
    </form>
    <div class="center-text">
        <p>Not Registered? <a href="register.php">Register Here</a></p>
    </div>
</div>
<script src="assets/validations.js"></script>
<?php include 'includes/footer.php'; ?>
