<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shop by Category - BlaqMerch</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .category-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin: 60px auto;
            max-width: 800px;
        }

        .category-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 200px;
            text-align: center;
            padding: 20px;
            text-decoration: none;
            color: #111;
            transition: 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .category-card h3 {
            margin-top: 10px;
            font-size: 1.2rem;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 40px;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

    <h1>🛍️ Browse BlaqMerch Categories</h1>

    <div class="category-container">
        <a href="caps.php" class="category-card">
            <h3>🧢Caps</h3>
        </a>

        <a href="hoodies.php" class="category-card">
            <h3>🧥Hoodies</h3>
        </a>

        <a href="tops.php" class="category-card">
            <h3>👕Tops</h3>
        </a>

        <a href="trousers.php" class="category-card">
            <h3>👖Trousers</h3>
        </a>
    </div>

</body>
</html>
