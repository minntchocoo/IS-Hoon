<?php
require 'sales-db.php'; // 

if ($_POST['product_id'] && $_POST['quantity']) {
    $product_num = $_POST['product_id'];
    $quantity = $_POST['quantity'];

   
    $query = "SELECT price FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    $total = $product['price'] * $quantity;

    
    $query = "INSERT INTO sales (product_id, quantity, total) VALUES ($product_id, $quantity, $total)";
    mysqli_query($conn, $query);

    
?>
