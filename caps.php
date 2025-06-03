<?php
session_start();  // Start session before any output

// Database connection
$conn = new mysqli("localhost", "root", "", "blaqmerch");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all caps from the database
$sql    = "SELECT * FROM items WHERE category = 'caps'";
$result = $conn->query($sql);

// Count total quantity of items in the bag
$cartCount = 0;
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cartCount = array_sum($_SESSION['cart']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Caps – BlaqMerch</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Page‑specific styling */
        .grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin: 30px 0;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 220px;
            padding: 15px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
        .card h3 {
            margin: 10px 0 5px;
            font-size: 1.1rem;
        }
        .card p {
            font-weight: bold;
            margin: 5px 0;
        }
        .submit-btn, .btn {
            background-color: #111;
            color: #fff;
            padding: 10px 16px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 10px 5px 0;
        }
        .submit-btn:hover, .btn:hover {
            background-color: #333;
        }
        h1 {
            text-align: center;
            margin-top: 40px;
        }
        .top-bar {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

    <h1>🧢 BlaqMerch – Caps Collection</h1>

    <!-- Navigation Bar -->
    <div class="top-bar">
        <a href="home1.php"        class="btn">🏠 Home</a>
        <a href="purchase.php"    class="btn">⬅️ Continue Shopping</a>
        <a href="cart.php"        class="btn">🛍️ View Bag (<?= $cartCount ?>)</a>
    </div>

    <!-- Product Grid -->
    <div class="grid">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <img src="<?= htmlspecialchars($row['image_url']) ?>"
                         alt="<?= htmlspecialchars($row['name']) ?>">
                    <h3><?= htmlspecialchars($row['name']) ?></h3>
                    <p>£<?= number_format($row['price'], 2) ?></p>
                    <form action="add_to_cart.php" method="post">
                        <input type="hidden" name="item_id"
                               value="<?= $row['item_id'] ?>">
                        <input type="submit" value="Add to Bag"
                               class="submit-btn">
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center;">No caps found.</p>
        <?php endif; ?>
    </div>

</body>
</html>
<?php $conn->close(); ?>
