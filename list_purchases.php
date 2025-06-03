<?php
$conn = new mysqli("localhost", "root", "", "blaqmerch");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "
SELECT c.name AS customer_name, i.name AS item_name
FROM purchases p
JOIN customers c ON p.customer_id = c.customer_id
JOIN items i ON p.item_id = i.item_id
ORDER BY p.purchase_id DESC
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Purchase List - BlaqMerch</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h1 { text-align: center; }
        table {
            width: 70%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th { background-color: #111; color: white; }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            background: #111;
            color: white;
            padding: 10px 20px;
            width: 150px;
            margin-left: auto;
            margin-right: auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<h1>📦 Purchase Records</h1>

<?php
if ($result->num_rows > 0) {
    echo "<table><tr><th>Customer Name</th><th>Item Purchased</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['customer_name']}</td><td>{$row['item_name']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align:center;'>No purchases found.</p>";
}
?>

<a href="home1.php">⬅️ Back to Home</a>

</body>
</html>

<?php $conn->close(); ?>
