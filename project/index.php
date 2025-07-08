<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

$totalItems = $conn->query("SELECT COUNT(*) FROM items")->fetch_row()[0];
$totalStudents = $conn->query("SELECT COUNT(*) FROM students")->fetch_row()[0];
$borrowed = $conn->query("SELECT COUNT(*) FROM transactions WHERE status = 'borrowed'")->fetch_row()[0];
$returned = $conn->query("SELECT COUNT(*) FROM transactions WHERE status = 'returned'")->fetch_row()[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Borrow Buddies</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="js/main.js"></script>
</head>
<body class="light-mode">

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<main class="main-content fade-in">
    <h2 class="section-title bounce" style="margin-bottom: 30px;">
        <span style="font-size: 1.3em;">👋</span> Welcome, <strong><?= htmlspecialchars($_SESSION['admin']); ?></strong>
    </h2>

    <section class="cards-container">
        <div class="card pop">
            <div class="card-icon">📦</div>
            <div class="label">Total Items</div>
            <div class="value"><?= $totalItems; ?></div>
        </div>
        <div class="card pop">
            <div class="card-icon">📤</div>
            <div class="label">Borrowed</div>
            <div class="value"><?= $borrowed; ?></div>
        </div>
        <div class="card pop">
            <div class="card-icon">✅</div>
            <div class="label">Returned</div>
            <div class="value"><?= $returned; ?></div>
        </div>
        <div class="card pop">
            <div class="card-icon">👨‍🎓</div>
            <div class="label">Students</div>
            <div class="value"><?= $totalStudents; ?></div>
        </div>
    </section>

    <section class="latest">
        <h3 class="section-subtitle">📌 Latest Borrowed Items</h3>
        <div class="table-responsive">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Student</th>
                        <th>Borrow Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $latest = $conn->query("
                        SELECT items.item_name, students.name, transactions.borrow_date
                        FROM transactions
                        JOIN items ON transactions.item_id = items.item_id
                        JOIN students ON transactions.student_id = students.student_id
                        WHERE transactions.status = 'borrowed'
                        ORDER BY transactions.borrow_date DESC
                        LIMIT 5
                    ");

                    if ($latest->num_rows > 0) {
                        while ($row = $latest->fetch_assoc()) {
                            echo "<tr>
                                <td>" . htmlspecialchars($row['item_name']) . "</td>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['borrow_date']) . "</td>
                              </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No borrowed items yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<script src="js/script.js"></script>
</body>
</html>
