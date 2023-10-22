<?php
try {
    $cart = json_decode($_POST['cart'], true);

    // Replace with your database connection details
    require('connection.php');
    $pdo = $conn;

    // Prepare the SQL statement for insertion
    $stmt = $pdo->prepare("INSERT INTO sales (product_num, quantity , total, sale_date) VALUES (:product_num,:quantity, :total, :sale_date)");

    // Iterate through the cart and insert each item
    foreach ($cart as $item) {
        $product_num = $item['product_num'];     // Replace with the actual key for product name // Convert total to an integer
        $quantity = intval($item['quantity']); 
        $total = intval($item['total']);          // Convert quantity to an integer   // Replace with the actual key for quantity
        $sale_date = date("Y-m-d H:i:s");          // Replace with the actual key for sale date

        $stmt->bindParam(':product_num', $product_num);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':sale_date', $sale_date);

        $stmt->execute();
    }

    // Close the database connection

    echo "success"; // Return a success message
} catch (PDOException $e) {
    // Handle any database errors here
    error_log("Database Error: " . $e->getMessage(), 0); // Log the error
    echo "error"; // Return an error message
}
?>
