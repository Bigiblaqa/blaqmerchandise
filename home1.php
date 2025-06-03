<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to BlaqMerchandise</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f4f4;
            text-align: center;
        }

        header {
            background-color: #111;
            color: white;
            padding: 30px 0;
        }

        header img {
            width: 120px;
            margin-bottom: 10px;
        }

        h1 {
            margin: 10px 0 0 0;
            font-size: 2.5em;
            letter-spacing: 1px;
        }

        .content {
            padding: 50px 20px;
        }

        .nav-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
        }

        .nav-buttons a {
            background-color: #111;
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            font-size: 1.1em;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .nav-buttons a:hover {
            background-color: #444;
        }

        footer {
            margin-top: 80px;
            padding: 20px;
            background-color: #111;
            color: white;
        }
    </style>
</head>
<body>

<header>
    <!-- 🖼 Logo Image -->
    <img src="images/logo.jpg.jpg" alt="BlaqMerchandise Logo">

    <h1>🖤 BlaqMerchandise</h1>
    <p>Urban Style. Digital Hustle.</p>
</header>

<div class="content">
    <h2>What would you like to do today?</h2>

    <div class="nav-buttons">
        <a href="purchase.php">🛒 Purchase Items</a>
        <a href="list_customers.php">👤 View Customers</a>
        <a href="list_purchases.php">📦 View Purchases</a>
        <a href="cart.php">🛍️ View Bag</a>
    </div>
</div>

<footer>
    &copy; <?php echo date("Y"); ?> BlaqMerchandise. All rights reserved.
</footer>

</body>
</html>
