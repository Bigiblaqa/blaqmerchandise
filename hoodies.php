<?php
session_start();
$conn = new mysqli("localhost", "root", "", "blaqmerch");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM items WHERE category = 'hoodies'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hoodies - BlaqMerch</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>🧥 BlaqMerch - Hoodies</h1>

<div class="top-bar" style="text-align: center; margin: 20px;">
    <a href="home1.php" class="btn">🏠</a>
    <a href="purchase.php" class="btn">⬅️ Continue Shopping</a>
    <a href="cart.php" class="btn">🛍️ View Bag (<?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0 ?>)</a>
</div>

<div class="grid">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                <h3><?= htmlspecialchars($row['name']) ?></h3>
                <p>£<?= number_format($row['price'], 2) ?></p>
                <form action="add_to_cart.php" method="post">
                    <input type="hidden" name="item_id" value="<?= $row['item_id'] ?>">
                    <input type="submit" value="Add to Bag" class="submit-btn">
                </form>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center;">No hoodies available right now.</p>
    <?php endif; ?>
</div>

</body>
</html>

<?php $conn->close(); ?>


