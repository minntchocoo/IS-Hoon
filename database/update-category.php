<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
}

// Include necessary files and configurations
require_once 'connection.php';
// Assuming you have a database connection established

// Retrieve the product number from the query parameter
$Category_ID = $_POST['Category_ID'];

// Retrieve the product data from the database based on the product number
$sql = "SELECT * FROM category WHERE Category_ID = :Category_ID";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':Category_ID', $Category_ID);
$stmt->execute();
$category = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the product exists
if (!$category) {
    echo 'Cat not found.';
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate the input data to prevent SQL injections and other security issues
    // You can use appropriate validation and sanitization methods based on your requirements
    $sanitizedNewData = filter_var_array($_POST, FILTER_SANITIZE_STRING);

    // Extract the specific fields you want to update from the $newData array
    // Modify the field names according to your database schema
    $categoryname = $sanitizedNewData['category'];
    $description = $sanitizedNewData['description'];
  
    // Add more fields as per your requirements

    // Prepare the SQL statement to update the product
    $sql = "UPDATE category SET 
            category = :category, 
            description = :description
            WHERE Category_ID = :Category_ID";

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':category', $categoryname);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':Category_ID', $Category_ID);
 

    // Check if the update was successful
    if ($stmt->execute()) {
        // Update successful
        $successMessage = urlencode('Category updated successfully.');
        header('Location: ../flavor-category-add.php?message=' . $successMessage);
        exit();
    } else {
        // Update failed
        echo 'Failed to update category.';
    }
}
?>
