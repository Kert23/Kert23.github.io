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
    <title>Storage | Borrow Buddies</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="js/main.js"></script>
</head>
<body class="light-mode">

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
    <h2>📦 Storage Inventory</h2>

    <table class="styled-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Description</th>
                <th>Total Quantity</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $items = $conn->query("SELECT * FROM items ORDER BY item_name ASC");

            if ($items->num_rows > 0) {
                while ($item = $items->fetch_assoc()) {
                    echo "<tr>
                        <td>" . htmlspecialchars($item['item_name']) . "</td>
                        <td>" . htmlspecialchars($item['description']) . "</td>
                        <td>" . (int)$item['quantity'] . "</td>
                        <td>" . ucfirst(htmlspecialchars($item['status'])) . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4' style='text-align:center;'>No items found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
