<?php
// Add category logic and database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the category and description values from the form
    $flavor = $_POST['flavor'];
    $description = $_POST['description'];

    // Validate the inputs (perform any necessary validation)

    // Insert the new category into the database

    // Create a new PDO instance (adjust the parameters based on your database configuration)
    include('connection.php');

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO flavor (flavor, description) VALUES (:flavor, :description)");

    // Bind the parameters
    $stmt->bindParam(':flavor', $flavor);
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
