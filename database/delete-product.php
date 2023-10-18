<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['product_num'])) {
    $product_num = $_GET['product_num'];

    try {
        // Perform the deletion operation
        include('connection.php');
        $command = "DELETE FROM product WHERE product_num = :product_num";
        $statement = $conn->prepare($command);
        $statement->bindParam(':product_num', $product_num);
        $statement->execute();

        $_SESSION['response'] = [
            'success' => true,
            'message' => 'Product deleted successfully.'
        ];
    } catch (PDOException $e) {
        $_SESSION['response'] = [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

header('Location: ../view-product.php');
exit();
?>
