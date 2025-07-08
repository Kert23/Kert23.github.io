<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['transaction_id'])) {
    $transaction_id = $_GET['transaction_id'];

    $stmt = $conn->prepare("SELECT item_id, quantity FROM transactions WHERE transaction_id = ?");
    $stmt->bind_param("i", $transaction_id);
    $stmt->execute();
    $stmt->bind_result($item_id, $qty_borrowed);
    $stmt->fetch();
    $stmt->close();

    $stmt = $conn->prepare("UPDATE transactions SET status='returned', return_date=NOW() WHERE transaction_id = ?");
    $stmt->bind_param("i", $transaction_id);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("UPDATE items SET quantity = quantity + ? WHERE item_id = ?");
    $stmt->bind_param("ii", $qty_borrowed, $item_id);
    $stmt->execute();
    $stmt->close();

    $conn->query("UPDATE items SET status = 'available' WHERE item_id = '$item_id' AND quantity > 0");

    header("Location: return.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Return Items | Borrow Buddies</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="js/main.js"></script>
</head>
<body class="light-mode">

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
    <h2>📥 Items to Return</h2>
    <table class="styled-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Student</th>
                <th>Borrow Date</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "
                SELECT t.transaction_id, i.item_name, s.name, t.borrow_date, t.quantity
                FROM transactions t
                JOIN items i ON t.item_id = i.item_id
                JOIN students s ON t.student_id = s.student_id
                WHERE t.status = 'borrowed'
            ";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>" . htmlspecialchars($row['item_name']) . "</td>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['borrow_date']) . "</td>
                    <td>" . htmlspecialchars($row['quantity']) . "</td>
                    <td><a class='btn' href='return.php?transaction_id={$row['transaction_id']}'>Mark Returned</a></td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
