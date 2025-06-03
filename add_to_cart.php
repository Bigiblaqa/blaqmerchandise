<?php
session_start();

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // Format: [item_id => quantity]
}

// Add an item to the cart
if (isset($_POST['item_id'])) {
    $item_id = intval($_POST['item_id']);

    // If item already exists in cart, increase quantity
    if (isset($_SESSION['cart'][$item_id])) {
        $_SESSION['cart'][$item_id]++;
    } else {
        $_SESSION['cart'][$item_id] = 1;
    }
}

// Redirect user back to the same page they came from
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>
