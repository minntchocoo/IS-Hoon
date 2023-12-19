<?php
include 'connection.php';

$targetDate = isset($_POST['targetDate']) ? $_POST['targetDate'] : date('Y-m-d');

try {
    $sql = "CALL GetOneDaySalesReport(:targetDate)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':targetDate', $targetDate, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output JSON
    header('Content-Type: application/json');
    echo json_encode($result);
} catch (PDOException $e) {
    // Log the error for debugging (remove or replace with a more sophisticated logging mechanism in production)
    error_log('Database error: ' . $e->getMessage());

    // Handle database errors
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'An error occurred while processing the request.']);
}
?>
