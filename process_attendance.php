
<?php
require_once __DIR__ . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('student_attendance.php');
}

$id = isset($_POST['idno']) ? trim($_POST['idno']) : '';
$subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';

if ($id === '' || !in_array($subject, subject_options(), true)) {
    $error = 'Please enter your ID number and choose a subject.';
    return;
}

/* Find student using the ID number */
$studentFound = false;

foreach (students_all() as $row) {
    if (isset($row[1]) && trim((string)$row[1]) === $id) {
        $studentFound = true;
        break;
    }
}

if (!$studentFound) {
    $error = 'Student ID number not found. Please check your ID.';
    return;
}

/* Check if attendance already exists today */
if (has_checked_today($id)) {
    redirect('attendance_result.php?status=already');
}

/* Save attendance */
$saved = add_attendance_record('', $id, $subject);

if (!$saved) {
    $error = 'Unable to save attendance. Please try again.';
    return;
}

redirect('attendance_result.php?status=ok');
