<?php
require_once __DIR__ . '/includes/auth.php';
require_login('instructor');

$active = 'dashboard';
$user = current_user();
$q = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : '';

$lessons = array(
    array('A1', 'Bernard Carr', '+8', '12.07.2026', 'Done'),
    array('A1', 'Henry Pote', '+7', '17.07.2026', 'Pending'),
    array('A1', 'Helens Love', '+5', '22.07.2026', 'Done'),
);
if ($q !== '') {
    $filtered = array();
    foreach ($lessons as $lesson) {
        if (strpos(strtolower($lesson[0] . ' ' . $lesson[1]), $q) !== false) {
            $filtered[] = $lesson;
        }
    }
    $lessons = $filtered;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="app">
    <?php include __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main">
        <form class="search" method="get" action="dashboard.php">
            <span>&#9906;</span>
            <input type="text" name="q" placeholder="" value="<?php echo e(isset($_GET['q']) ? $_GET['q'] : ''); ?>">
        </form>

        <div class="dash-wrap">
            <div class="center">
                <div class="banner">
                    <div>
                        <h3>Welcome back, <?php echo e($user['name']); ?>!</h3>
                        <p>New programming language classes are available.</p>
                        <a class="chip" href="subject.php">Learn more</a>
                    </div>
                    <div class="book" aria-hidden="true"></div>
                </div>

                <div>
                    <div class="section-label">Classes</div>
                    <div class="stats">
                        <div class="stat">
                            <div class="num"><strong>50</strong><span>Students</span></div>
                            <div class="box">&#9788;</div>
                        </div>
                        <div class="stat">
                            <div class="num"><strong>10</strong><span>Subjects</span></div>
                            <div class="box">&#128218;</div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="section-label">Lessons</div>
                    <div class="table-card">
                        <table class="data">
                            <thead>
                                <tr>
                                    <th><span>Class</span></th>
                                    <th><span>Teacher Name</span></th>
                                    <th><span>Members</span></th>
                                    <th><span>Starting</span></th>
                                    <th><span>Material</span></th>
                                    <th><span>Payment</span></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!$lessons): ?>
                                <tr class="empty-row"><td colspan="6">No lessons found.</td></tr>
                            <?php else: ?>
                                <?php foreach ($lessons as $lesson): ?>
                                    <tr>
                                        <td><?php echo e($lesson[0]); ?></td>
                                        <td><?php echo e($lesson[1]); ?></td>
                                        <td>
                                            <span class="avatars">&#9679;&#9679;&#9679; <strong><?php echo e($lesson[2]); ?></strong></span>
                                        </td>
                                        <td><?php echo e($lesson[3]); ?></td>
                                        <td>&#8595; Download</td>
                                        <td><?php echo e($lesson[4]); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <aside class="right">
                <div class="profile">
                    <div class="avatar">&#9787;</div>
                    <div class="name"><?php echo e($user['name']); ?></div>
                    <div class="role">Instructor</div>
                    <details class="dd">
                        <summary>Profile</summary>
                        <div class="dd-menu">
                            <a href="#">Settings and privacy</a>
                            <a href="#">Help and Support</a>
                            <a href="#">Display and Accessibility</a>
                            <a href="logout.php">Log out</a>
                        </div>
                    </details>
                </div>

                <div class="calendar">
                    <div class="cal-head">
                        <a href="#">&#8249;</a>
                        <span>December 2026</span>
                        <a href="#">&#8250;</a>
                    </div>
                    <table class="cal">
                        <thead>
                            <tr><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th><th>Sun</th></tr>
                        </thead>
                        <tbody>
                            <tr><td class="blank"></td><td class="mark">1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td></tr>
                            <tr><td>7</td><td>8</td><td>9</td><td class="today">10</td><td>11</td><td>12</td><td>13</td></tr>
                            <tr><td>14</td><td>15</td><td>16</td><td>17</td><td>18</td><td>19</td><td>20</td></tr>
                            <tr><td>21</td><td class="mark">22</td><td>23</td><td>24</td><td>25</td><td class="mark">26</td><td>27</td></tr>
                            <tr><td>28</td><td>29</td><td>30</td><td>31</td><td class="blank">1</td><td class="blank">2</td><td class="blank"></td></tr>
                        </tbody>
                    </table>
                </div>

                <div class="reminders-title">Reminders</div>
                <div class="reminder">
                    <div class="bell">&#128276;</div>
                    <div><strong>Eng - Vocabulary test</strong>12 Dec 2026, Friday</div>
                </div>
            </aside>
        </div>
    </main>
</div>
</body>
</html>
