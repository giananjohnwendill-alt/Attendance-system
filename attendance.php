<?php
require_once __DIR__ . '/includes/auth.php';
require_login('instructor');

$active = 'attendance';
$q = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : '';
$rows = attendance_all();
if ($q !== '') {
    $filtered = array();
    foreach ($rows as $row) {
        $haystack = strtolower((isset($row[0]) ? $row[0] : '') . ' ' . (isset($row[1]) ? $row[1] : ''));
        if (strpos($haystack, $q) !== false) {
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
    <title>Attendance</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="app">
    <?php include __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main">
        <div class="page-head">
            <h1 class="page-title">Attendance</h1>
            <form class="search" style="margin:0;" method="get" action="attendance.php">
                <span>&#9906;</span>
                <input type="text" name="q" placeholder="Search name" value="<?php echo e(isset($_GET['q']) ? $_GET['q'] : ''); ?>">
                <button type="submit" class="role-btn" style="width:auto;margin:0;padding:4px 10px;font-size:11px;">Go</button>
            </form>
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
                <tr class="empty-row"><td colspan="5">No attendance records found.</td></tr>
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
