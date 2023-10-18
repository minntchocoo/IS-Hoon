<?php
include('connection.php');

$stmt = $conn->prepare("SELECT * FROM flavor");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);


return $stmt->fetchAll();