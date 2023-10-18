<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
}
$_SESSION['table'] = 'user';
$user = $_SESSION['user'];
$products = include('database/show-product.php');


// Retrieve categories from the database
$stmtCategories = $conn->prepare("SELECT * FROM category");
$stmtCategories->execute();
$categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);

// Retrieve flavors from the database
$stmtFlavors = $conn->prepare("SELECT * FROM flavor");
$stmtFlavors->execute();
$flavors = $stmtFlavors->fetchAll(PDO::FETCH_ASSOC);

$stmtSuppliers = $conn->prepare("SELECT * FROM supplier");
$stmtSuppliers->execute();
$suppliers = $stmtSuppliers->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" type="text/css" href="css/login.css?v=p<?= time(); ?>">
    <script src="https://kit.fontawesome.com/2cfb65917d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="js/bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css?v=p<?= time(); ?>">
</head>

<body>
    <div id="dashboardMainContainer">
        <?php include('partial/app-sidebar.php') ?>

        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include('partial/app-topNav.php') ?>

            <div class="dashboard_content">
                <div class="row">
                    
                    <div class="column column">
                        <h1 class="section_header"><i class="fa fa-list"></i> Products</h1>
                        <div class="dashboard_content_main">
                            <div class="section_content"></div>
                            <div class="products">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Product No.</th>
                                            <th>Product Name</th>
                                            <th>Product Price</th>
                                            <th>Product Stock</th>
                                            <th>Exppiry Date</th>
                                            <th>Manufacturing Date</th>
                                            <th>Quantity</th>
                                            <th>Category</th>
                                            <th>Flavor</th>
                                            <th>Supplier</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($products as $index => $user) {
                                            $categoryName = '';
                                            foreach ($categories as $category) {
                                                if ($category['Category_ID'] == $user['Category_ID']) {
                                                    $categoryName = $category['category'];
                                                    break;
                                                }
                                            }
                                    
                                            // Retrieve the flavor name based on the flavor_ID
                                            $flavorName = '';
                                            foreach ($flavors as $flavor) {
                                                if ($flavor['flavor_ID'] == $user['flavor_ID']) {
                                                    $flavorName = $flavor['flavor'];
                                                    break;
                                                }
                                            }

                                            $supplierName = '';
                                            foreach ($suppliers as $supplier) {
                                                if ($supplier['Supplier_ID'] == $user['Supplier_ID']) {
                                                    $supplierName = $supplier['company_name'];
                                                    break;
                                                }
                                            }
                                            
                                            ?>  
                                            <tr>
                                                <td><?= $user['product_num'] ?></td>
                                                <td><?= $user['product_name'] ?></td>
                                                <td><?= $user['product_price'] ?></td>
                                                <td><?= $user['product_stock'] ?></td>
                                                <td><?= date('M d,Y @ h:i:s A', strtotime($user['exp_date'])) ?></td>
                                                <td><?= date('M d,Y @ h:i:s A', strtotime($user['man_date'])) ?></td>
                                                <td><?= $user['quantity'] ?></td>
                                                <td><?= $categoryName ?></td>
                                                <td><?= $flavorName ?></td>
                                                <td><?= $supplierName ?></td>
                                                <td>
                                                <!-- <a href="database/update-product.php?product_num=<?= $user['product_num'] ?>" class="update_product">
                                                <i class="fa fa-pencil"></i> Edit
                                                    </a> -->
                                                    <a href="#" class="updateProduct" data-toggle="modal" data-target="#updateProductModal<?= $user['product_num'] ?>">
                                                        <i class="fa fa-pencil"></i> Edit </a>

                                                        <a href="database/delete-product.php?product_num=<?= $user['product_num'] ?>" class="deleteProduct">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>
                                                </td>
                                            </tr>



                                            <div class="modal fade" id="updateProductModal<?= $user['product_num'] ?>" tabindex="-1" role="dialog" aria-labelledby="updateProductModalLabel<?= $user['product_num'] ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="updateProductModalLabel<?= $user['product_num'] ?>">Edit Product</h5>
                                                            <button type="button" class="close-modal" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="database/update-product.php">
                                                                <input type="hidden" name="product_num" value="<?= $user['product_num'] ?>">

                                                                <div class="form-group">
                                                                    <label for="product_name">Product Name:</label>
                                                                    <input type="text" class="form-control" name="product_name" value="<?= $user['product_name'] ?>" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="product_price">Product Price:</label>
                                                                    <input type="number" class="form-control" name="product_price" value="<?= $user['product_price'] ?>" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="product_stock">Product Stock:</label>
                                                                    <input type="number" class="form-control" name="product_stock" value="<?= $user['product_stock'] ?>" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="exp_date">Expiration Date:</label>
                                                                    <input type="date" class="form-control" name="exp_date" value="<?= $user['exp_date'] ?>" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="man_date">Manufacturing Date:</label>
                                                                    <input type="date" class="form-control" name="man_date" value="<?= $user['man_date'] ?>" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="Category_ID">Category:</label>
                                                                    <select class="form-control" name="Category_ID" required>
                                                                        <?php foreach ($categories as $category) { ?>
                                                                            <option value="<?= $category['Category_ID'] ?>" <?= ($category['Category_ID'] == $user['Category_ID']) ? 'selected' : '' ?>>
                                                                                <?= $category['category'] ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="flavor_ID">Flavor:</label>
                                                                    <select class="form-control" name="flavor_ID" required>
                                                                        <?php foreach ($flavors as $flavor) { ?>
                                                                            <option value="<?= $flavor['flavor_ID'] ?>" <?= ($flavor['flavor_ID'] == $user['flavor_ID']) ? 'selected' : '' ?>>
                                                                                <?= $flavor['flavor'] ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="Supplier_ID">Supplier:</label>
                                                                    <select class="form-control" name="supplier_ID" required>
                                                                        <?php foreach ($suppliers as $supplier) { ?>
                                                                            <option value="<?= $supplier['Supplier_ID'] ?>" <?= ($supplier['Supplier_ID'] == $user['Supplier_ID']) ? 'selected' : '' ?>>
                                                                                <?= $supplier['company_name'] ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>      
      


                                                                <!-- Add more fields here -->

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Update Product</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php } ?>
                                    </tbody>
                                </table>
                                <?php
                                    $message = $_GET['message'] ?? ''; // Retrieve the message from the query parameter
                                    if (!empty($message)) {
                                        echo '<div class="alert alert-success">' . $message . '</div>';
                                    }
                                ?>
                                <p class="userCount"><?= count($products) ?> Products</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery/jquery-3.7.0.min.js"></script>
    <script src="js/bootstrap-5.3.0-alpha3-dist/js/bootstrap.min.js"></script>

    <script>
    $(document).ready(function() {
        $('.updateProduct').click(function() {
            var targetModal = $(this).data('target');
            $(targetModal).modal('show');
        });

        $('.modal').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
        });

        $('.close-modal').click(function() {
            var modal = $(this).closest('.modal');
            modal.modal('hide');
        });

        $('.modal').on('click', function(e) {
            if ($(e.target).hasClass('modal') || $(e.target).hasClass('close')) {
                $(this).modal('hide');
            }
        });
    });
    </script>



</body> 
</html>


