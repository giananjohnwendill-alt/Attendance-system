<?php
require_once __DIR__ . '/includes/auth.php';
require_login('instructor');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $section = isset($_POST['section']) ? trim($_POST['section']) : '';
    $id = isset($_POST['id']) ? trim($_POST['id']) : '';
    $course = isset($_POST['course']) ? trim($_POST['course']) : '';

    if ($name === '' || $section === '' || $id === '' || $course === '') {
        $error = 'Please fill in all fields.';
    } else {
        add_student_record($name, $id, $section, $course);
        redirect('students.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Student</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="form-page">
    <header class="form-head">
        <a class="back" style="position:static;font-size:22px;" href="students.php" aria-label="Back">&#8249;</a>
        <h2>Add Student.</h2>
        <div class="logo sm"><span>CPC</span></div>
    </header>

    <div class="form-body">
        <?php if ($error !== ''): ?>
            <div class="msg error"><?php echo e($error); ?></div>
        <?php endif; ?>

        <form method="post" action="add_student.php">
            <div class="form-card">
                <div class="row">
                    <label for="name">Student Name</label>
                    <input id="name" type="text" name="name" value="<?php echo e(isset($_POST['name']) ? $_POST['name'] : ''); ?>" required>
                </div>
                <div class="row">
                    <label for="section">Section &amp; Year</label>
                    <input id="section" type="text" name="section" value="<?php echo e(isset($_POST['section']) ? $_POST['section'] : ''); ?>" required>
                </div>
                <div class="row">
                    <label for="id">School ID</label>
                    <input id="id" type="text" name="id" value="<?php echo e(isset($_POST['id']) ? $_POST['id'] : ''); ?>" required>
                </div>
                <div class="row">
                    <label for="course">Course</label>
                    <input id="course" type="text" name="course" value="<?php echo e(isset($_POST['course']) ? $_POST['course'] : ''); ?>" required>
                </div>
            </div>
            <div class="form-actions">
                <button class="btn" type="submit">Add Student</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
