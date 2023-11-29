<?php
try {
    $cart = json_decode($_POST['cart'], true);

    // Replace with your database connection details
    require('connection.php');
    $pdo = $conn;

    // Start a transaction
    $pdo->beginTransaction();

    $messages = []; // Initialize an array to store messages

    foreach ($cart as $item) {
        $product_num = $item['product_num'];
        $product_name = $item['product_name'];
        $quantity = intval($item['quantity']);
        $total = intval($item['total']);
        $sale_date = date("Y-m-d H:i:s");

        // Retrieve the current stock quantity
        $stmt = $pdo->prepare("SELECT product_stock FROM product WHERE product_num = :product_num");
        $stmt->bindParam(':product_num', $product_num);
        $stmt->execute();
        $current_stock = $stmt->fetchColumn();

        // Check if there is enough stock to sell
        if ($current_stock >= $quantity) {
            // Insert the sale record
            $stmt = $pdo->prepare("INSERT INTO sales (product_num, quantity, total, sale_date) VALUES (:product_num, :quantity, :total, :sale_date)");
            $stmt->bindParam(':product_num', $product_num);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':sale_date', $sale_date);
            $stmt->execute();

            // Update the product stock
            $stmt = $pdo->prepare("UPDATE product SET product_stock = product_stock - :quantity WHERE product_num = :product_num");
            $stmt->bindParam(':product_num', $product_num);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->execute();

            // Check if the stock is below 10
            if ($current_stock - $quantity < 5) {
                $stock_increase = 30;
                
                $stmt = $pdo->prepare("UPDATE product SET product_stock = product_stock - :quantity WHERE product_num = :product_num");
                $stmt->bindParam(':product_num', $product_num);
                $stmt->bindParam(':quantity', $stock_increase);
                $stmt->execute();

                $messages[] = "warning: Product with ID $product_name has low stock (below 10) and 10 stock was added.";
            }
        } else {
            // Rollback the transaction if there's not enough stock
            $pdo->rollBack();
            $messages[] = "error: Insufficient stock for product with ID $product_num";
            exit();
        }
    }

    // Commit the transaction
    $pdo->commit();

    // Close the database connection
    $response = [
        'status' => 'success',
        'messages' => $messages,
    ];

    echo json_encode($response); // Return the response as JSON
} catch (PDOException $e) {
    // Handle any database errors here
    $error_message = "Database Error: " . $e->getMessage();
    error_log($error_message, 0); // Log the error

    $response = [
        'status' => 'error',
        'message' => $error_message,
    ];

    echo json_encode($response); // Return the response as JSON
}

?>
