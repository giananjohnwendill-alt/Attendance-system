<?php
require_once __DIR__ . '/includes/auth.php';

/* Open to direct (guest) student check-ins as well. */
$status = isset($_GET['status']) ? $_GET['status'] : 'already';
$message = $status === 'ok'
    ? 'ATTENDANCE SUCCESSFULLY CHECKED!'
    : 'ATTENDANCE ALREADY CHECKED!';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Status</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="result-page">
        <div class="result-card">
            <h2><?php echo e($message); ?></h2>
            <a class="btn" href="student_attendance.php">Back to home</a>
        </div>
    </div>
</body>
</html>
