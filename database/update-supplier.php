<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
}

// Include necessary files and configurations
require_once 'connection.php';
// Assuming you have a database connection established

// Retrieve the product number from the query parameter
$Supplier_ID = $_POST['Supplier_ID'];

// Retrieve the product data from the database based on the product number
$sql = "SELECT * FROM supplier WHERE Supplier_ID = :Supplier_ID";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':Supplier_ID', $Supplier_ID);
$stmt->execute();
$supplier = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the product exists
if (!$supplier) {
    echo 'Supplier not found.';
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate the input data to prevent SQL injections and other security issues
    // You can use appropriate validation and sanitization methods based on your requirements
    $sanitizedNewData = filter_var_array($_POST, FILTER_SANITIZE_STRING);

    // Extract the specific fields you want to update from the $newData array
    // Modify the field names according to your database schema
    $suppliername = $sanitizedNewData['company_name'];
    $contact_num = $sanitizedNewData['contact_num'];
    $email = $sanitizedNewData['email'];
  
    // Add more fields as per your requirements

    // Prepare the SQL statement to update the product
    $sql = "UPDATE supplier SET 
            supplier = :supplier, 
            contact_num = :contact_num,
            email = email
            WHERE Supplier_ID = :Supplier_ID";

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':company_name', $suppliername);
    $stmt->bindParam(':contact_num', $contact_num);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':Supplier_ID', $Supplier_ID);
 

    // Check if the update was successful
    if ($stmt->execute()) {
        // Update successful
        $successMessage = urlencode('Supplier updated successfully.');
        header('Location: ../suppliers.php?message=' . $successMessage);
        exit();
    } else {
        // Update failed
        echo 'Failed to update suppliers.';
    }
}
?>
