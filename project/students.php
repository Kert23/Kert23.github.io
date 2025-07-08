<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Students | Borrow Buddies</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="js/main.js"></script>
</head>
<body class="light-mode">

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
    <h2>Registered Students</h2>
    <table class="styled-table">
        <thead>
            <tr><th>Student ID</th><th>Name</th><th>Course</th><th>Year Level</th></tr>
        </thead>
        <tbody>
            <?php
            $students = $conn->query("SELECT * FROM students");
            while ($s = $students->fetch_assoc()) {
                echo "<tr>
                    <td>{$s['student_id']}</td>
                    <td>{$s['name']}</td>
                    <td>{$s['course']}</td>
                    <td>{$s['year_level']}</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
