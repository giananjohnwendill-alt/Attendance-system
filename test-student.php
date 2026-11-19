
<?php
require_once __DIR__ . '/config/database.php';

echo "<h2>Database Test</h2>";

echo "Connected Database: ";
$result = $conn->query("SELECT DATABASE() AS db");
$row = $result->fetch_assoc();
echo htmlspecialchars($row['db']) . "<br><br>";

$id = "20241071";

$stmt = $conn->prepare(
    "SELECT id, student_id, full_name FROM students WHERE student_id = ?"
);

$stmt->bind_param("s", $id);
$stmt->execute();

$result = $stmt->get_result();

echo "<h3>Student Search Result:</h3>";

if ($result->num_rows > 0) {
    while ($student = $result->fetch_assoc()) {
        echo "FOUND!<br>";
        echo "ID: " . htmlspecialchars($student['student_id']) . "<br>";
        echo "Name: " . htmlspecialchars($student['full_name']) . "<br>";
    }
} else {
    echo "STUDENT NOT FOUND!";
}

$stmt->close();
?>
