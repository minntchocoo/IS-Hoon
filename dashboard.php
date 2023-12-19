<?php 
     session_start();
     if(!isset($_SESSION['user'])) header('Location: index.php');
     $_SESSION['table'] = 'users';
     $user = $_SESSION['user'];
     require('database/connection.php');
     $pdo = $conn;
     // Fetch products from the database
     $stmt = $pdo->query("SELECT * FROM product");
     $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard </title>

    <link rel="stylesheet" type="text/css" href="css/login.css?v=p<?php echo time();?>">
    <script src="https://kit.fontawesome.com/2cfb65917d.js" crossorigin="anonymous"></script>
    <style>
        .product-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            width: calc(33.33% - 20px);
            box-sizing: border-box;
            float: left;
            margin-right: 20px;
        }
        .product-card:last-child {
            margin-right: 0;
        }
        .product-card img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-right: 10px;
        }
        .product-card h3 {
            margin-top: 0;
        }
        .product-card p {
            margin-bottom: 5px;
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
                    <h2>On-Stock Products</h2>
                    <div id="productList">
                        <?php 
                            $count = 0;
                            foreach ($products as $product) : 
                        ?>
                            <div class="product-card">
                                <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['product_name']; ?>">
                                <div>
                                    <h3><?php echo $product['product_name']; ?></h3>
                                    <p>Stock: <?php echo $product['product_stock']; ?></p>
                                    <p>Price: $<?php echo $product['product_price']; ?></p>
                                </div>
                            </div>
                            <?php 
                                $count++;
                                if ($count % 3 == 0) {
                                    echo '<div style="clear:both;"></div>';
                                }
                            endforeach; 
                            ?>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <script src='js/script.js'></script>
</body>
</html>
