<?php
include 'includes/db.php';
include 'includes/header.php';

$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $query = "SELECT * FROM users WHERE email = '$email' OR phone = '$phone'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if ($user['email'] === $email) {
            $error_message = "Email is already registered.";
        } elseif ($user['phone'] === $phone) {
            $error_message = "Phone number is already registered.";
        }
    } else {
        $query = "INSERT INTO users (name, phone, dob, email, password, role) VALUES ('$name', '$phone', '$dob', '$email', '$password', 1)";
        if (mysqli_query($conn, $query)) {
            $success_message = "Registration successful! Redirecting to login page...";
            header("Refresh: 3; URL=login.php");
        } else {
            $error_message = "Error: Unable to register. Please try again.";
        }
    }
}
?>
<link href="assets/main.css" rel="stylesheet">
<div class="container">
    <h2>Register</h2>
    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
    <?php endif; ?>
    <?php if ($success_message): ?>
        <div class="alert alert-success"><?= $success_message ?></div>
    <?php endif; ?>
    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
            <div class="error"></div>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required>
            <div class="error"></div>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" value="<?= htmlspecialchars($_POST['dob'] ?? '') ?>" required>
            <div class="error"></div>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            <div class="error"></div>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <div class="error"></div>
        </div>
        <button type="submit">Register</button>
    </form>
    <div class="center-text">
        <p>Already Registered? <a href="login.php">Login Here</a></p>
    </div>
</div>
<script src="assets/validations.js"></script>
<?php include 'includes/footer.php'; ?>
