<?php

// Include your database connection file
include 'database/connection.php';

// Set the target date as today
$targetDate = isset($_POST['targetDate']) ? $_POST['targetDate'] : date('Y-m-d');

// Prepare and execute the stored procedure
$sql = "CALL GetOneDaySalesReport(:targetDate)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':targetDate', $targetDate, PDO::PARAM_STR);
$stmt->execute();

// Fetch and display the results
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$conn = null;

?>