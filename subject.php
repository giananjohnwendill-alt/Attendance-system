<?php
require_once __DIR__ . '/includes/auth.php';
require_login('instructor');

$active = 'subject';
$subject = isset($_GET['subject']) ? $_GET['subject'] : '';
$rows = attendance_all();
if ($subject !== '') {
    $filtered = array();
    foreach ($rows as $row) {
        if (isset($row[4]) && stripos($row[4], $subject) !== false) {
            $filtered[] = $row;
        }
    }
    $rows = $filtered;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subject</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="app">
    <?php include __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main">
        <div class="page-head">
            <h1 class="page-title">Subject</h1>
            <details class="dd light">
                <summary>Select subject</summary>
                <div class="dd-menu">
                    <?php foreach (subject_options() as $option): ?>
                        <a class="<?php echo $subject === $option ? 'active' : ''; ?>"
                           href="subject.php?subject=<?php echo urlencode($option); ?>"><?php echo e($option); ?></a>
                    <?php endforeach; ?>
                    <a href="subject.php">All subjects</a>
                </div>
            </details>
        </div>

        <table class="data">
            <thead>
                <tr>
                    <th><span>STUDENTS NAME</span></th>
                    <th><span>ID NO.</span></th>
                    <th><span>DATE</span></th>
                    <th><span>TIME-IN</span></th>
                    <th><span>SUBJECT</span></th>
                </tr>
            </thead>
            <tbody>
            <?php if (!$rows): ?>
                <tr class="empty-row"><td colspan="5">No records for this subject.</td></tr>
            <?php else: ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?php echo e(isset($row[0]) ? $row[0] : ''); ?></td>
                        <td><?php echo e(isset($row[1]) ? $row[1] : ''); ?></td>
                        <td><?php echo e(isset($row[2]) ? $row[2] : ''); ?></td>
                        <td><?php echo e(isset($row[3]) ? $row[3] : ''); ?></td>
                        <td><?php echo e(isset($row[4]) ? $row[4] : ''); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </main>
</div>
</body>
</html>
