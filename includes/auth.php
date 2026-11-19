<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/functions.php';

function current_user()
{
    return isset($_SESSION['user']) ? $_SESSION['user'] : null;
}

function is_logged_in()
{
    return current_user() !== null;
}

function require_login($role = null)
{
    $user = current_user();
    if (!$user) {
        redirect('index.php');
    }
    if ($role !== null && $user['role'] !== $role) {
        redirect($user['role'] === 'instructor' ? 'dashboard.php' : 'student_attendance.php');
    }
}
