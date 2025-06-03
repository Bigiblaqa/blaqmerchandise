<?php
session_start(); // Always include this when using sessions

$conn = new mysqli("localhost", "root", "", "blaqmerch");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customerName = isset($_POST['customer_name']) ? trim($_POST['customer_name']) : '';
$itemIds = isset($_POST['item_ids']) ? $_POST['item_ids'] : [];

if (empty($customerName) || empty($itemIds)) {
    echo "<h2>Invalid submission. <a href='purchase.php'>Start Over</a></h2>";
    exit();
}

// Insert customer
$stmt = $conn->prepare("INSERT INTO customers (name) VALUES (?)");
$stmt->bind_param("s", $customerName);
$stmt->execute();
$customerId = $stmt->insert_id;
$stmt->close();

// Prepare purchase insert outside loop
$purchaseStmt = $conn->prepare("INSERT INTO purchases (customer_id, item_id) VALUES (?, ?)");

// Loop through selected items and insert
foreach ($itemIds as $itemId) {
    $itemId = intval($itemId);
    $purchaseStmt->bind_param("ii", $customerId, $itemId);
    $purchaseStmt->execute();
}
$purchaseStmt->close();

// ✅ Clear cart after order
unset($_SESSION['cart']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaction Complete - BlaqMerchandise</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; text-align: center; background: #f9f9f9; }
        .message { padding: 20px; background: #e0ffe0; border: 1px solid #2ecc71; border-radius: 10px; display: inline-block; }
        a {
            display: inline-block;
            margin: 15px;
            text-decoration: none;
            background: #111;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }
        a:hover {
            background: #333;
        }
    </style>
</head>
<body>
    <div class="message">
        <h2>✅ Thank you, <?= htmlspecialchars($customerName); ?>!</h2>
        <p>Your purchase has been recorded successfully.</p>
    </div>

    <div>
        <a href="home1.php">🏠 Return to Home</a>
        <a href="purchase.php">🛍️ Buy More Items</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>
