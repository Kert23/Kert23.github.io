<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_history'])) {
    $conn->query("DELETE FROM transactions");
    $message = "✅ Borrow history cleared successfully!";
}

$sql = "
    SELECT 
        t.transaction_id,
        s.name AS student_name,
        i.item_name,
        t.borrow_date,
        t.return_date,
        t.status
    FROM transactions t
    JOIN students s ON t.student_id = s.student_id
    JOIN items i ON t.item_id = i.item_id
    ORDER BY t.borrow_date DESC, t.transaction_id DESC
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Borrow Buddies - Borrow History</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="js/main.js"></script>

    <style>
        .btn-danger {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .btn-danger:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body class="light-mode">
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
    <h2>Borrow History</h2>

    <form method="POST" onsubmit="return confirm('Are you sure you want to clear all history?');">
        <button type="submit" name="clear_history" class="btn-danger">Clear All History</button>
    </form>

    <?php if (!empty($message)): ?>
        <p class="success"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <table>
        <tr>
            <th>Student Name</th>
            <th>Item Name</th>
            <th>Borrow Date</th>
            <th>Return Date and Time</th>
            <th>Status</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['student_name']) ?></td>
                    <td><?= htmlspecialchars($row['item_name']) ?></td>
                    <td><?= $row['borrow_date'] ?></td>
                    <td><?= $row['return_date'] ?? '—' ?></td>
                    <td style="color: <?= $row['status'] == 'returned' ? 'green' : 'orange' ?>">
                        <?= ucfirst($row['status']) ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">No transaction history yet.</td></tr>
        <?php endif; ?>
    </table>
</div>

<script src="js/script.js"></script>
</body>
</html>
