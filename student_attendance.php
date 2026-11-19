<?php
require_once __DIR__ . '/includes/auth.php';

/* Students can check in directly from the role picker without logging in. */
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/process_attendance.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Attendance</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="student-page">
        <div class="student-card">
            <a class="back back-top" href="index.php" aria-label="Back">&#8249;</a>

           <select class="subject-select" name="subject" form="attendanceForm">
    <?php foreach (subject_options() as $subject): ?>
        <option value="<?php echo e($subject); ?>">
            <?php echo e($subject); ?>
        </option>
    <?php endforeach; ?>
</select>

            <img src="assets/images/logo.png" alt="CPC Logo" class="cpc-logo">

            <?php if ($error !== ''): ?>
                <div class="msg error" style="max-width:360px;margin:14px auto -30px;"><?php echo e($error); ?></div>
            <?php endif; ?>

            <form class="student-form" id="attendanceForm" method="post" action="student_attendance.php">
                <div class="field">
                    <label for="idno">Input ID no.</label>
                    <input id="idno" type="text" name="idno" required>
                </div>
                <button class="btn" type="submit">Present</button>
            </form>
        </div>
    </div>
</body>
</html>
