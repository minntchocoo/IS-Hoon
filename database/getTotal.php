<?php
// Include the database connection file
require('connection.php');

// Function to get total sales by product number
function GetTotalSalesByProductNum($targetProductNum)
{
    require('connection.php');
    $sql = "SELECT getTotalSalesByProductNum(:product_num) AS total_sales";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_num', $targetProductNum);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total_sales'];
}

// Function to get total quantity by product number
function GetTotalQuantityByProductNum($targetProductNum)
{
    $sql = "SELECT getTotalQuantityByProductNum(:product_num) AS total_quantity";
    require('connection.php');
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_num', $targetProductNum);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total_quantity'];
}

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedProductNum = $_POST["product_num"];
    $totalSales = GetTotalSalesByProductNum($selectedProductNum);
    $totalQuantity = GetTotalQuantityByProductNum($selectedProductNum);
?>
    <div id="totalsContainer">
        <h2>Total Sales: <span class="total-value">$<?php echo $totalSales; ?></span></h2>
        <h2>Total Quantity: <span class="total-value"><?php echo $totalQuantity; ?></span></h2>
    </div>
<?php
} else {
    // If it's not a POST request, return an error message
    echo json_encode(['error' => 'Invalid request method']);
}
?>
