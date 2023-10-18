<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['Supplier_ID'])) {
    $Supplier_ID = $_GET['Supplier_ID'];

    try {
        // Perform the deletion operation
        include('connection.php');
        $command = "DELETE FROM supplier WHERE Supplier_ID = :Supplier_ID";
        $statement = $conn->prepare($command);
        $statement->bindParam(':Supplier_ID', $Supplier_ID);
        $statement->execute();

        $_SESSION['response'] = [
            'success' => true,
            'message' => 'Supplier deleted successfully.'
        ];
    } catch (PDOException $e) {
        $_SESSION['response'] = [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

header('Location: ../suppliers.php');
exit();
?>
