<?php
session_start();
include 'db.php';

// Set timezone for correct datetime
date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = trim($_POST['student_id']);
    $student_name = trim($_POST['student_name']);
    $course = trim($_POST['course']);
    $year_level = trim($_POST['year_level']);

    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO students (student_id, name, course, year_level) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $student_id, $student_name, $course, $year_level);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("UPDATE students SET name=?, course=?, year_level=? WHERE student_id=?");
        $stmt->bind_param("ssss", $student_name, $course, $year_level, $student_id);
        $stmt->execute();
    }

    if (isset($_POST['items']) && is_array($_POST['items'])) {
        foreach ($_POST['items'] as $item_id => $qty) {
            $qty = (int)$qty;
            if ($qty > 0) {
                $check = $conn->prepare("SELECT quantity FROM items WHERE item_id = ?");
                $check->bind_param("i", $item_id);
                $check->execute();
                $available = $check->get_result()->fetch_assoc()['quantity'];

                if ($available >= $qty) {
                    // Use PHP datetime instead of NOW()
                    $borrow_date = date('Y-m-d H:i:s');

                    $stmt = $conn->prepare("INSERT INTO transactions (item_id, student_id, quantity, borrow_date, status) VALUES (?, ?, ?, ?, 'borrowed')");
                    $stmt->bind_param("siss", $item_id, $student_id, $qty, $borrow_date);
                    $stmt->execute();

                    $newQty = $available - $qty;
                    $newStatus = ($newQty > 0) ? 'available' : 'unavailable';

                    $update = $conn->prepare("UPDATE items SET quantity = ?, status = ? WHERE item_id = ?");
                    $update->bind_param("isi", $newQty, $newStatus, $item_id);
                    $update->execute();
                }
            }
        }
        $message = "✅ Items successfully issued!";
    } else {
        $message = "⚠️ No items selected.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Issue Items | Borrow Buddies</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="js/main.js"></script>
</head>
<body class="light-mode">
<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content fade-in">
    <h2>📤 Borrow Items</h2>

    <?php if ($message) echo "<p class='success'>$message</p>"; ?>

    <form method="POST" class="form-box">
        <label>Student ID:</label>
        <input type="text" name="student_id" required>

        <label>Full Name:</label>
        <input type="text" name="student_name" required>

        <label>Course:</label>
        <input type="text" name="course" required>

        <label>Year Level:</label>
        <input type="text" name="year_level" required>

        <h3>Select Items to Borrow</h3>
        <table class="styled-table">
            <thead>
                <tr><th>Item</th><th>Description</th><th>Available</th><th>Quantity to Borrow</th></tr>
            </thead>
            <tbody>
                <?php
                $items = $conn->query("SELECT * FROM items WHERE quantity > 0 ORDER BY item_name ASC");
                while ($item = $items->fetch_assoc()) {
                    echo "<tr>
                        <td>" . htmlspecialchars($item['item_name']) . "</td>
                        <td>" . htmlspecialchars($item['description']) . "</td>
                        <td>" . (int)$item['quantity'] . "</td>
                        <td><input type='number' name='items[" . $item['item_id'] . "]' min='0' max='" . $item['quantity'] . "' value='0' style='width: 60px;'></td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <button type="submit" class="btn">Confirm Borrow</button>
    </form>
</div>
</body>
</html>
