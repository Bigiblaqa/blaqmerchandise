<?php
session_start();
$conn = new mysqli("localhost", "root", "", "blaqmerch");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set up cart and pull item data with quantities
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$items = [];
$total = 0;

if (!empty($cart)) {
    $ids = implode(',', array_keys($cart));
    $sql = "SELECT * FROM items WHERE item_id IN ($ids)";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['item_id'];
            $qty = $cart[$id];
            $row['quantity'] = $qty;
            $row['subtotal'] = $row['price'] * $qty;
            $items[] = $row;
            $total += $row['subtotal'];
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Bag - BlaqMerch</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .cart-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }

        .summary {
            text-align: right;
            font-weight: bold;
        }

        .btn, .submit-btn {
            background-color: #111;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #333;
        }

        h1 {
            text-align: center;
        }

        .actions {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="cart-container">
    <h1>🛍️ Your BlaqMerch Bag</h1>

    <?php if (empty($items)): ?>
        <p>Your bag is currently empty. <a href="purchase.php" class="btn">  ⬅️ Continue Shopping</a></p>
    <?php else: ?>
        <form action="checkout.php" method="post">
            <table>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Remove</th>
                </tr>

                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>£<?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>£<?= number_format($item['subtotal'], 2) ?></td>
                        <td>
                            <a href="remove_from_cart.php?item_id=<?= $item['item_id'] ?>" class="btn">❌</a>
                        </td>
                        <input type="hidden" name="item_ids[]" value="<?= $item['item_id'] ?>">
                    </tr>
                <?php endforeach; ?>

                <tr>
                    <td colspan="3" class="summary">Total:</td>
                    <td colspan="2" class="summary">£<?= number_format($total, 2) ?></td>
                </tr>
            </table>

            <div class="actions">
                <input type="submit" class="btn" value="✅ Proceed to Checkout">
                <a href="purchase.php" class="btn">⬅️ Continue Shopping</a>
                <a href="home1.php" class="btn">🏠</a> 
            </div>
        </form>
    <?php endif; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>
