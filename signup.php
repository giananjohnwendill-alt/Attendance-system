<?php
require_once __DIR__ . '/includes/auth.php';

$validRoles = array('instructor', 'student');
$role = isset($_GET['role']) && in_array($_GET['role'], $validRoles, true) ? $_GET['role'] : 'instructor';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postedRole = isset($_POST['role']) ? $_POST['role'] : 'instructor';
    $role = in_array($postedRole, $validRoles, true) ? $postedRole : 'instructor';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($name === '' || $email === '' || $password === '') {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (find_account($email)) {
        $error = 'An account with that email already exists.';
    } else {
        create_account($role, $name, $email, $password);
        redirect('login.php?role=' . $role . '&registered=1');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="auth-page">
        <div class="auth-card">
            <a class="back" href="login.php?role=<?php echo e($role); ?>" aria-label="Back">&#8249;</a>
            <img src="assets/images/logo.png" alt="CPC Logo" class="cpc-logo">
            <h2>SIGN UP</h2>

            <?php if ($error !== ''): ?>
                <div class="msg error"><?php echo e($error); ?></div>
            <?php endif; ?>

            <form method="post" action="signup.php">
                <input type="hidden" name="role" value="<?php echo e($role); ?>">
                <div class="field">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" value="<?php echo e(isset($_POST['name']) ? $_POST['name'] : ''); ?>" required>
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="<?php echo e(isset($_POST['email']) ? $_POST['email'] : ''); ?>" required>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                </div>
                <button class="btn" type="submit">Sign Up</button>
            </form>

            <div class="auth-footer">
                Already have an account? <a href="login.php?role=<?php echo e($role); ?>">Sign In</a>
            </div>
        </div>
    </div>
</body>
</html>
