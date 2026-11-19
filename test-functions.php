<?php
require_once __DIR__ . '/includes/functions.php';

echo "<h2>Students All Function Test</h2>";

$students = students_all();

echo "<pre>";
print_r($students);
echo "</pre>";

$searchID = "20241071";
$found = false;

foreach ($students as $student) {
    if (isset($student[1]) && trim($student[1]) === $searchID) {
        $found = true;
        echo "STUDENT FOUND: " . htmlspecialchars($student[0]);
        break;
    }
}

if (!$found) {
    echo "STUDENT NOT FOUND!";
}
?>