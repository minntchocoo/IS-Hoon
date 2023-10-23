<?php
// Database connection code (as shown in a previous response)
require('connection.php');
// Query to fetch product data from the database
$query = $conn->query("SELECT product_num, product_name, product_price FROM product");
$products = $query->fetchAll(PDO::FETCH_ASSOC);

// Encode the product data as JSON and send it to JavaScript
header('Content-Type: application/json');
echo json_encode($products);
?>
