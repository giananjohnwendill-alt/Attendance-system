<?php
require_once __DIR__ . '/includes/auth.php';

$validRoles = array('instructor', 'student');
$role = isset($_GET['role']) && in_array($_GET['role'], $validRoles, true) ? $_GET['role'] : 'instructor';
$error = '';
$notice = '';

if (isset($_GET['registered'])) {
    $notice = 'Account created. Please log in.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postedRole = isset($_POST['role']) ? $_POST['role'] : 'instructor';
    $role = in_array($postedRole, $validRoles, true) ? $postedRole : 'instructor';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($email === '' || $password === '') {
        $error = 'Please enter your email and password.';
    } else {
        $account = verify_login($email, $password);
        if (!$account) {
            $error = 'Invalid email or password.';
        } elseif ($account[0] !== $role) {
            $error = 'This account is not registered as a ' . $role . '.';
        } else {
            $_SESSION['user'] = array(
                'role' => $account[0],
                'name' => $account[1],
                'email' => $account[2],
            );
            redirect($role === 'instructor' ? 'dashboard.php' : 'student_attendance.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="auth-page">
        <div class="auth-card">
            <a class="back" href="index.php" aria-label="Back">&#8249;</a>
            <img src="assets/images/logo.png" alt="CPC Logo" class="cpc-logo">
            <h2>LOG IN</h2>

            <?php if ($error !== ''): ?>
                <div class="msg error"><?php echo e($error); ?></div>
            <?php endif; ?>
            <?php if ($notice !== ''): ?>
                <div class="msg ok"><?php echo e($notice); ?></div>
            <?php endif; ?>

            <form method="post" action="login.php">
                <input type="hidden" name="role" value="<?php echo e($role); ?>">
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="<?php echo e(isset($_POST['email']) ? $_POST['email'] : ''); ?>" required>
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                </div>
                <button class="btn" type="submit">Login</button>
            </form>

            <div class="auth-footer">
                Don't have an account? <a href="signup.php?role=<?php echo e($role); ?>">Sign Up</a>
            </div>
        </div>
    </div>
</body>
</html>
