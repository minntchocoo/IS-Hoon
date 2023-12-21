<?php 
     session_start();
     if(!isset($_SESSION['user'])) header('Location: index.php');
     $_SESSION['table'] = 'users';
     $user = $_SESSION['user'];
     require('database/connection.php');



    // Function to get total sales by product number
    function GetTotalSalesByProductNum($targetProductNum)
    {
        require('database/connection.php');
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
        require('database/connection.php');
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_num', $targetProductNum);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total_quantity'];
    }

    // Get all products from the database
    $sqlProducts = "SELECT product_num, product_name FROM product";
    $stmtProducts = $conn->prepare($sqlProducts);
    $stmtProducts->execute();
    $products = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" type="text/css" href="css/login.css?v=p<?php echo time();?>">
    <script src="https://kit.fontawesome.com/2cfb65917d.js" crossorigin="anonymous"></script>
    <style>
        #totalsContainer {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #663311b7;
            color: #fff;
        }

        .total-value {
            font-weight: bold;
            color: #007BFF; /* Adjust the color as needed */
        }
    </style>
</head>
<body>
    <div id="dashboardMainContainer">
        <?php include('partial/app-sidebar.php') ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include('partial/app-topNav.php') ?>
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <!-- Chart Container -->
                    <canvas id="salesChart" width="400" height="200"></canvas>
                    <form id="getTotalsForm" action="#" method="post">
                        <label for="productSelect">Select Product:</label>
                        <select id="productSelect" name="product_num">
                            <?php foreach ($products as $product): ?>
                                <option value="<?php echo $product['product_num']; ?>"><?php echo $product['product_name']; ?></option>
                            <?php endforeach; ?>
                        </select>

                        <input type="button" value="Get Totals" onclick="getTotals()">
                    </form>

                    <div id="totalsContainer"></div>
                </div>
             

               
            </div>
        </div>
    </div>

    <script src='js/script.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
   <script>
    // Function to fetch sales data from the server
    function getTotals() {
        var selectedProductNum = $("#productSelect").val();

        $.ajax({
            type: 'POST',
            url: 'database/getTotal.php', // Replace with the actual URL of your PHP script
            data: { product_num: selectedProductNum },
            success: function(response) {
                $("#totalsContainer").html(response);
                updateChart(); // Call the function to update the chart if needed
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('An error occurred while fetching data.');
            }
        });
    }

function fetchSalesData() {
        // Make an AJAX call to fetch data from the server
        $.ajax({
            type: 'POST',
            url: 'database/fetch-sales-data.php', // Replace with the actual URL of your PHP script
            dataType: 'json',
            success: function(response) {
                // Update the chart with the fetched data
                updateChart(response);
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('An error occurred while fetching data.');
            }
        });
    }

    // Function to update the chart with new data
    function updateChart(data) {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const label = '$' + context.parsed.y.toFixed(2);
                                const datasetLabel = context.dataset.label || '';
                                const index = context.dataIndex;

                                const totalSales = data.datasets[0].data[index];
                                const totalQuantity = data.datasets[1].data[index];

                                return label + ' - ' + datasetLabel + ' - ' + 'Total Sales: $' + totalSales + ', Total Quantity: ' + totalQuantity;
                            },
                            title: function (context) {
                                return 'Day ' + context[0].label;
                            }
                        }
                    }
                }
            },
        });
    }

    // Fetch sales data and update the chart when the page loads
    fetchSalesData();
</script>



</body>
</html>
