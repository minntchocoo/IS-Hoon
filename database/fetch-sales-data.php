<?php

// Include database connection
require('connection.php'); // Update this with the correct path to your connection file

// Calculate the start date for the past week
$startDate = date('Y-m-d', strtotime('-1 week'));

// Query to fetch sales data for the past week
$sql = "SELECT DATE(sale_date) AS sales_day, SUM(total) AS total_sales, SUM(quantity) AS total_quantity
        FROM sales
        WHERE sale_date >= :start_date
        GROUP BY DATE(sale_date)
        ORDER BY DATE(sale_date)";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':start_date', $startDate);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format data for Chart.js
    $chartData = [
        'labels' => [],
        'datasets' => [
            [
                'label' => 'Total Sales',
                'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                'borderColor' => 'rgba(75, 192, 192, 1)',
                'borderWidth' => 1,
                'data' => [],
            ],
            [
                'label' => 'Total Quantity',
                'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                'borderColor' => 'rgba(255, 99, 132, 1)',
                'borderWidth' => 1,
                'data' => [],
            ],
        ],
    ];

    foreach ($result as $row) {
        $chartData['labels'][] = $row['sales_day'];
        $chartData['datasets'][0]['data'][] = (float) $row['total_sales'];
        $chartData['datasets'][1]['data'][] = (int) $row['total_quantity'];
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($chartData);
} catch (PDOException $e) {
    // Handle database errors
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Database error']);
    exit();
}
?>
