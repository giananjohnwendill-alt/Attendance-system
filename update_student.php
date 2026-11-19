
<?php
require_once __DIR__ . '/includes/auth.php';
require_login('instructor');

$dbId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$all = students_all();
$row = null;

/* Find student using actual database ID */
foreach ($all as $student) {
    if ((int)$student[4] === $dbId) {
        $row = $student;
        break;
    }
}

if (!$row) {
    redirect('students.php');
}

$name = $row[0];
$id = $row[1];
$section = $row[2];
$course = $row[3];

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $section = isset($_POST['section']) ? trim($_POST['section']) : '';
    $id = isset($_POST['id']) ? trim($_POST['id']) : '';
    $course = isset($_POST['course']) ? trim($_POST['course']) : '';

    if ($name === '' || $section === '' || $id === '') {
        $error = 'Please fill in the required fields.';
    } else {
        $success = update_student_record(
            $dbId,
            $name,
            $id,
            $section,
            $course
        );

        if ($success) {
            redirect('students.php');
        } else {
            $error = 'Unable to update student. Please check the School ID.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Student Information</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="form-page">
    <header class="form-head">
        <a class="back" style="position:static;font-size:22px;"
           href="students.php" aria-label="Back">&#8249;</a>

        <h2 class="plain">Update Student Information</h2>

       <img src="assets/images/logo.png" alt="CPC Logo" class="cpc-logo">
    </header>

    <div class="form-body">
        <?php if ($error !== ''): ?>
            <div class="msg error"><?php echo e($error); ?></div>
        <?php endif; ?>

        <form method="post" action="update_student.php?id=<?php echo e($dbId); ?>">
            <div class="form-card">
                <div class="row">
                    <label for="name">Student Name</label>
                    <input id="name" type="text" name="name"
                           value="<?php echo e($name); ?>" required>
                </div>

                <div class="row">
                    <label for="section">Section &amp; Year</label>
                    <input id="section" type="text" name="section"
                           value="<?php echo e($section); ?>" required>
                </div>

                <div class="row">
                    <label for="id">School ID</label>
                    <input id="id" type="text" name="id"
                           value="<?php echo e($id); ?>" required>
                </div>

                <div class="row">
                    <label for="course">Course</label>
                    <input id="course" type="text" name="course"
                           value="<?php echo e($course); ?>">
                </div>
            </div>

            <div class="form-actions">
                <button class="btn" type="submit">Save Changes</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
