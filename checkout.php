<?php
session_start();
$conn = new mysqli("localhost", "root", "", "blaqmerch");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Retrieve items from the session cart
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$items = [];
$total = 0;

if (!empty($cart)) {
    $ids = implode(',', array_map('intval', $cart));
    $sql = "SELECT * FROM items WHERE item_id IN ($ids)";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
            $total += $row['price'];
        }
    }
}

// VAT Calculation
$vat = $total * 0.175;
$grand_total = $total + $vat;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - BlaqMerch</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .checkout-container {
            max-width: 700px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .checkout-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .checkout-container table {
            width: 100%;
            margin-bottom: 20px;
        }
        .checkout-container td, .checkout-container th {
            padding: 10px;
            text-align: left;
        }
        .checkout-container input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .btn-checkout {
            width: 100%;
            background: #111;
            color: white;
            padding: 15px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .btn-checkout:hover {
            background: #333;
        }
        .summary {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>

<div class="checkout-container">
    <h2>Checkout</h2>

    <?php if (empty($items)): ?>
        <p>Your bag is empty. <a href="home1.php">Continue shopping</a></p>
    <?php else: ?>
        <form action="confirm.php" method="post">
            <table>
                <tr><th>Item</th><th>Price</th></tr>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>£<?= number_format($item['price'], 2) ?></td>
                        <input type="hidden" name="item_ids[]" value="<?= $item['item_id'] ?>">
                    </tr>
                <?php endforeach; ?>
                <tr><td class="summary">Subtotal:</td><td class="summary">£<?= number_format($total, 2) ?></td></tr>
                <tr><td class="summary">VAT (17.5%):</td><td class="summary">£<?= number_format($vat, 2) ?></td></tr>
                <tr><td class="summary">Total:</td><td class="summary">£<?= number_format($grand_total, 2) ?></td></tr>
            </table>

            <label for="customer_name">Your Name:</label>
            <input type="text" id="customer_name" name="customer_name" required placeholder="e.g. Jordan Banks">

            <input type="submit" class="btn-checkout" value="Place Order">
        </form>
    <?php endif; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>

