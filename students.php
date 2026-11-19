
<?php
require_once __DIR__ . '/includes/auth.php';
require_login('instructor');

$active = 'students';
$section = isset($_GET['section']) ? $_GET['section'] : '';

$students = students_all();

if ($section !== '') {
    $filtered = array();

    foreach ($students as $row) {
        if (isset($row[2]) && $row[2] === $section) {
            $filtered[] = $row;
        }
    }

    $students = $filtered;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Information</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="app">
    <?php include __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main">
        <div class="page-head">
            <h1 class="page-title">Student Information</h1>

            <div style="display:flex;align-items:center;gap:12px;">
                <details class="dd light">
                    <summary>Select section</summary>
                    <div class="dd-menu">
                        <?php foreach (section_options() as $option): ?>
                            <a class="<?php echo $section === $option ? 'active' : ''; ?>"
                               href="students.php?section=<?php echo urlencode($option); ?>">
                                <?php echo e($option); ?>
                            </a>
                        <?php endforeach; ?>

                        <a href="students.php">All sections</a>
                    </div>
                </details>

                <a class="tool-icon" href="add_student.php" title="Add student">+</a>
            </div>
        </div>

        <table class="data">
            <thead>
                <tr>
                    <th><span>STUDENTS NAME</span></th>
                    <th><span>ID NO.</span></th>
                    <th><span>SECTION</span></th>
                    <th style="width:40px;"></th>
                </tr>
            </thead>

            <tbody>
            <?php if (!$students): ?>
                <tr class="empty-row">
                    <td colspan="4">No students found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($students as $row): ?>
                    <tr>
                        <td><?php echo e($row[0]); ?></td>
                        <td><?php echo e($row[1]); ?></td>
                        <td><?php echo e($row[2]); ?></td>
                        <td>
                            <a class="tool-icon"
                               style="width:26px;height:26px;font-size:13px;"
                               href="update_student.php?id=<?php echo e($row[4]); ?>"
                               title="Edit student">&#9998;</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </main>
</div>
</body>
</html>
