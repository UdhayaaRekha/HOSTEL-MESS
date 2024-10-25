<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link rel="stylesheet" href="manage.css">
</head>
<body>
    <div class="header">
        <h1>Manage Students</h1>
    </div>
    <div class="container">
        <form action="student_management_boys.php" method="POST">
            <input type="text" name="name" placeholder="Student Name" required>
            <input type="text" name="reg_no" placeholder="Registration Number" required>
            <input type="email" name="mail" placeholder="Email" required>
            <input type="date" name="dob" placeholder="DOB" required>
            <input type="text" name="gender" placeholder="Gender" required>
            <input type="text" name="ph_no" placeholder="Phone Number" required>
            <input type="submit" name="insert" value="Insert Student">
        </form>

        <h2>Student List</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Reg No</th>
                <th>Email</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
            <?php
            include 'student_management_backend_boys.php';
            ?>
        </table>
    </div>
</body>
</html>
