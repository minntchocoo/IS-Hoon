<?php
include('connection.php');

$stmt = $conn->prepare("SELECT * FROM product");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);


return $stmt->fetchAll();