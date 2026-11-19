<?php
/* Expects $active: dashboard | attendance | subject | students */
if (!isset($active)) {
    $active = '';
}
?>
<aside class="sidebar">
    <div class="brand">
       <img src="assets/images/logo.png" alt="CPC Logo" class="sidebar-logo">
        <div class="brand-name">CORDOVA PUBLIC<br>COLLEGE</div>
    </div>
    <nav class="nav">
        <a href="dashboard.php" class="<?php echo $active === 'dashboard' ? 'active' : ''; ?>">
            <span class="ico">&#8962;</span> Dashboard
        </a>
        <a href="attendance.php" class="<?php echo $active === 'attendance' ? 'active' : ''; ?>">
            <span class="ico">&#9678;</span> Attendance
        </a>
        <a href="subject.php" class="<?php echo $active === 'subject' ? 'active' : ''; ?>">
            <span class="ico">&#9636;</span> Subject
        </a>
        <a href="students.php" class="<?php echo $active === 'students' ? 'active' : ''; ?>">
            <span class="ico">&#9823;</span> Students Information
        </a>
    </nav>
</aside>
