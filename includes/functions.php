
<?php
require_once __DIR__ . '/../config/database.php';

function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function redirect($url)
{
    header('Location: ' . $url);
    exit;
}

/* ACCOUNTS */

function find_account($email)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $account = $result->fetch_assoc();

    $stmt->close();

    if (!$account) {
        return null;
    }

    return array(
        $account['role'],
        $account['name'],
        $account['email'],
        $account['password'],
        $account['id']
    );
}

function verify_login($email, $password)
{
    $account = find_account($email);

    if ($account && password_verify($password, $account[3])) {
        return $account;
    }

    return null;
}

function create_account($role, $name, $email, $password)
{
    global $conn;

    if (find_account($email)) {
        return false;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "INSERT INTO users (role, name, email, password) VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param("ssss", $role, $name, $email, $hashedPassword);

    $success = $stmt->execute();
    $stmt->close();

    return $success;
}

/* STUDENTS */

function students_all()
{
    global $conn;

    $result = $conn->query("SELECT * FROM students ORDER BY id DESC");
    $rows = array();

    while ($row = $result->fetch_assoc()) {
        $rows[] = array(
            $row['full_name'],
            $row['student_id'],
            $row['department'],
            isset($row['email']) ? $row['email'] : '',
            $row['id']
        );
    }

    return $rows;
}

function add_student_record($name, $id, $section, $course)
{
    global $conn;

    $stmt = $conn->prepare(
        "INSERT INTO students (student_id, full_name, department) VALUES (?, ?, ?)"
    );

    $stmt->bind_param("sss", $id, $name, $section);
    $success = $stmt->execute();
    $stmt->close();

    return $success;
}

function update_student_record($dbId, $name, $id, $section, $course)
{
    global $conn;

    $stmt = $conn->prepare(
        "UPDATE students
         SET full_name = ?, student_id = ?, department = ?
         WHERE id = ?"
    );

    $stmt->bind_param("sssi", $name, $id, $section, $dbId);

    $success = $stmt->execute();
    $stmt->close();

    return $success;
}

/* ATTENDANCE */

function attendance_all()
{
    global $conn;

    $result = $conn->query("
        SELECT students.full_name, students.student_id,
               attendance.attendance_date,
               attendance.attendance_time,
               attendance.status
        FROM attendance
        INNER JOIN students ON attendance.student_id = students.id
        ORDER BY attendance.id DESC
    ");

    $rows = array();

    while ($row = $result->fetch_assoc()) {
        $rows[] = array(
            $row['full_name'],
            $row['student_id'],
            date('m/d/y', strtotime($row['attendance_date'])),
            date('h:iA', strtotime($row['attendance_time'])),
            $row['status']
        );
    }

    return $rows;
}

function has_checked_today($id)
{
    global $conn;

    $stmt = $conn->prepare("
        SELECT attendance.id
        FROM attendance
        INNER JOIN students ON attendance.student_id = students.id
        WHERE students.student_id = ?
        AND attendance.attendance_date = CURDATE()
        LIMIT 1
    ");

    $stmt->bind_param("s", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;

    $stmt->close();

    return $exists;
}

function add_attendance_record($name, $id, $subject)
{
    global $conn;

    $stmt = $conn->prepare(
        "SELECT id FROM students WHERE student_id = ? LIMIT 1"
    );

    $stmt->bind_param("s", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();

    if (!$student) {
        return false;
    }

    $studentDbId = (int)$student['id'];

    $stmt = $conn->prepare("
        INSERT INTO attendance
        (student_id, attendance_date, attendance_time, status)
        VALUES (?, CURDATE(), CURTIME(), 'Present')
    ");

    $stmt->bind_param("i", $studentDbId);
    $success = $stmt->execute();
    $stmt->close();

    return $success;
}

/* OPTIONS */

function subject_options()
{
    return array('PLATFORM TECH.', 'INFO. TECH.', 'DATA STRUC.');
}

function section_options()
{
    return array('BSIT-2B', 'BSIT-2A', 'BSIT-2C');
}
