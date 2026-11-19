CORDOVA PUBLIC COLLEGE - ATTENDANCE CHECKER
===========================================

Built with HTML + CSS + PHP only. No JSON, no database, no JavaScript.
Data is stored in plain pipe-delimited text files under data/.

RUN IT
------
Open a terminal in this folder and run:

    php -S localhost:8000

Then visit http://localhost:8000 in your browser.
(Any PHP web server works - e.g. XAMPP: place this folder in htdocs.)

DEMO ACCOUNTS
-------------
Instructor : bernie@cordova.edu  / instructor123
Student    : regine@cordova.edu  / student123

You can also create new accounts with the Sign Up screen.

FILES
-----
index.php              - "Log in as?" role picker (Student goes straight to check-in)
login.php              - login (Instructor; Student accounts can still log in here)
signup.php             - registration
student_attendance.php - student "Input ID no." + subject + Present
process_attendance.php - records attendance (blocks duplicates for the same ID on the same day)
attendance_result.php  - "Attendance already checked!" / success screen
dashboard.php          - instructor dashboard
attendance.php         - attendance records + name search
subject.php            - attendance records filtered by subject
students.php           - student information + section filter + add/edit links
add_student.php        - add student form
update_student.php     - edit student form (pencil icon)
logout.php             - sign out

includes/functions.php - flat-file data helpers
includes/auth.php      - session / role guards
includes/sidebar.php   - shared instructor sidebar
assets/style.css       - all styling

DATA FILES (pipe-delimited, one record per line)
------------------------------------------------
data/accounts.txt    role | name | email | password hash
data/students.txt    name | school id | section | course
data/attendance.txt  name | id no. | date (m/d/y) | time-in | subject

NOTES
-----
- The circular college logo is drawn with CSS as a placeholder. Drop a real
  image in and replace the <div class="logo"> blocks if you have one.
- Sessions are used to keep users logged in; no cookies are written by the app
  itself beyond the PHP session cookie.
- Passwords are stored with password_hash() / checked with password_verify().
