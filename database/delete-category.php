<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['Category_ID'])) {
    $Category_ID = $_GET['Category_ID'];

    try {
        // Perform the deletion operation
        include('connection.php');
        $command = "DELETE FROM category WHERE Category_ID = :Category_ID";
        $statement = $conn->prepare($command);
        $statement->bindParam(':Category_ID', $Category_ID);
        $statement->execute();

        $_SESSION['response'] = [
            'success' => true,
            'message' => 'Category deleted successfully.'
        ];
    } catch (PDOException $e) {
        $_SESSION['response'] = [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

header('Location: ../flavor-category-add.php');
exit();
?>
