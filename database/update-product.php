<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
}

// Include necessary files and configurations
require_once 'connection.php';
// Assuming you have a database connection established

// Retrieve the product number from the query parameter
$productNum = $_POST['product_num'];

// Retrieve the product data from the database based on the product number
$sql = "SELECT * FROM product WHERE product_num = :product_num";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':product_num', $productNum);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the product exists
if (!$product) {
    echo 'Product not found.';
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate the input data to prevent SQL injections and other security issues
    // You can use appropriate validation and sanitization methods based on your requirements
    $sanitizedNewData = filter_var_array($_POST, FILTER_SANITIZE_STRING);

    // Extract the specific fields you want to update from the $newData array
    // Modify the field names according to your database schema
    $productName = $sanitizedNewData['product_name'];
    $productPrice = $sanitizedNewData['product_price'];
    $productStock = $sanitizedNewData['product_stock'];
    $expdate = $sanitizedNewData['exp_date'];
    $mandate = $sanitizedNewData['man_date'];
    $category = $sanitizedNewData['Category_ID'];
    $flavor = $sanitizedNewData['flavor_ID'];
    $supplier = $sanitizedNewData['supplier_ID'];
    // Add more fields as per your requirements

    // Prepare the SQL statement to update the product
    $sql = "UPDATE product SET 
            product_name = :product_name, 
            product_price = :product_price, 
            product_stock = :product_stock,
            exp_date = :exp_date,
            man_date = :man_date,
            Category_ID = :Category_ID,
            flavor_ID = :flavor_ID,
            Supplier_ID = :Supplier_ID


            WHERE product_num = :product_num";

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_name', $productName);
    $stmt->bindParam(':product_price', $productPrice);
    $stmt->bindParam(':product_stock', $productStock);
    $stmt->bindParam(':exp_date', $expdate);
    $stmt->bindParam(':man_date', $mandate);
    $stmt->bindParam(':Category_ID', $category);
    $stmt->bindParam(':flavor_ID', $flavor);
    $stmt->bindParam(':Supplier_ID', $supplier);
    $stmt->bindParam(':product_num', $productNum);


    // Check if the update was successful
    if ($stmt->execute()) {
        // Update successful
        $successMessage = urlencode('Product updated successfully.');
        header('Location: ../view-product.php?message=' . $successMessage);
        exit();
    } else {
        // Update failed
        echo 'Failed to update product.';
    }
}
?>
