<?php
include('connection.php');

$stmt = $conn->prepare("SELECT * FROM user ORDER BY created_at");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);


return $stmt->fetchAll();