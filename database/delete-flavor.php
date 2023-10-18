<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['flavor_ID'])) {
    $flavor_ID = $_GET['flavor_ID'];

    try {
        // Perform the deletion operation
        include('connection.php');
        $command = "DELETE FROM flavor WHERE flavor_ID = :flavor_ID";
        $statement = $conn->prepare($command);
        $statement->bindParam(':flavor_ID', $flavor_ID);
        $statement->execute();

        $_SESSION['response'] = [
            'success' => true,
            'message' => 'Flavor deleted successfully.'
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
