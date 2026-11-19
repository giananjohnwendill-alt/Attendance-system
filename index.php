
<?php
require_once __DIR__ . '/includes/auth.php';

if (is_logged_in()) {
    $u = current_user();
    redirect($u['role'] === 'instructor' ? 'dashboard.php' : 'student_attendance.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Checker</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <div class="auth-page">

        <h1>ATTENDANCE CHECKER</h1>

        <div class="role-card">

            <img
                src="assets/images/logo.png"
                alt="CPC Logo"
                class="cpc-logo"
            >

            <p>Log in as?</p>

            <a class="role-btn" href="login.php?role=instructor">
                Instructor
            </a>

            <a class="role-btn" href="student_attendance.php">
                Student
            </a>

        </div>

    </div>

</body>
</html>
