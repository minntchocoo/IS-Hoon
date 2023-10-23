<?php
try {
    require('database/connection.php');

    // Fetch all products
    $sql = "SELECT product_num, product_name, product_stock FROM product";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $low_stock_threshold = 10; // Set your low stock threshold

    foreach ($products as $product) {
        $product_num = $product['product_num'];
        $product_stock = $product['product_stock'];
        $product_name = $product['product_name'];

        if ($product_stock <= $low_stock_threshold) {
            // Implement notification logic (e.g., send an email or store data to notify the front-end).
            echo "Low stock for $product_name (Product ID: $product_num). Current quantity: $product_stock.\n";
        }
    }

    // Close the database connection
    $conn = null;
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
