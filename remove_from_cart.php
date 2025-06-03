<?php
session_start();

if (isset($_GET['item_id'])) {
    $item_id = intval($_GET['item_id']);

    // If the item exists in the cart, remove it completely
    if (isset($_SESSION['cart'][$item_id])) {
        unset($_SESSION['cart'][$item_id]);
    }
}

// Redirect back to the cart page
header("Location: cart.php");
exit();
?>
