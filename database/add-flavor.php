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
   // Assuming $conn is your database connection

    // Prepare the SQL call to the stored procedure
    $stmt = $conn->prepare("CALL InsertFlavor(:flavor, :description)");

    // Bind the parameters
    $stmt->bindParam(':flavor', $flavor, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);

    

    // Execute the statement
    $stmt->execute();

    // Optionally, you can check for success or handle errors
    if ($stmt->errorCode() !== "00000") {
        $errorInfo = $stmt->errorInfo();
        echo "Error executing stored procedure: " . $errorInfo[2];
    } else {
        echo "Stored procedure executed successfully.";
    }


    // Close the database connection
    $conn = null;

    // Redirect the user to the page displaying the category list or any other desired page
    header("Location: ../flavor-category-add.php");
    exit;
}
?>
