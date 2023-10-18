<?php
// Add category logic and database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the category and description values from the form
    $category = $_POST['category'];
    $description = $_POST['description'];

    // Validate the inputs (perform any necessary validation)

    // Insert the new category into the database

    // Create a new PDO instance (adjust the parameters based on your database configuration)
    include('connection.php');

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO category (category, description) VALUES (:category, :description)");

    // Bind the parameters
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':description', $description);

    // Execute the statement
    $stmt->execute();

    // Close the database connection
    $conn = null;

    // Redirect the user to the page displaying the category list or any other desired page
    header("Location: ../flavor-category-add.php");
    exit;
}
?>
