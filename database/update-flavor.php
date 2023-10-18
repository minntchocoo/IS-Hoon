<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
}

// Include necessary files and configurations
require_once 'connection.php';
// Assuming you have a database connection established

// Retrieve the product number from the query parameter
$flavor_ID = $_POST['flavor_ID'];

// Retrieve the product data from the database based on the product number
$sql = "SELECT * FROM flavor WHERE flavor_ID = :flavor_ID";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':flavor_ID', $flavor_ID);
$stmt->execute();
$flavor = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the product exists
if (!$flavor) {
    echo 'Flavor not found.';
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate the input data to prevent SQL injections and other security issues
    // You can use appropriate validation and sanitization methods based on your requirements
    $sanitizedNewData = filter_var_array($_POST, FILTER_SANITIZE_STRING);

    // Extract the specific fields you want to update from the $newData array
    // Modify the field names according to your database schema
    $flavorname = $sanitizedNewData['flavor'];
    $description = $sanitizedNewData['description'];
  
    // Add more fields as per your requirements

    // Prepare the SQL statement to update the product
    $sql = "UPDATE flavor SET 
            flavor = :flavor, 
            description = :description
            WHERE flavor_ID = :flavor_ID";

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':flavor', $flavorname);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':flavor_ID', $flavor_ID);
 

    // Check if the update was successful
    if ($stmt->execute()) {
        // Update successful
        $successMessage = urlencode('Flavor updated successfully.');
        header('Location: ../flavor-category-add.php?message=' . $successMessage);
        exit();
    } else {
        // Update failed
        echo 'Failed to update flavor.';
    }
}
?>
