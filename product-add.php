<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: product-add.php');
}
$_SESSION['table'] = 'product';
$user = $_SESSION['user'];
$products = include('database/show-product.php');


$sql_flavor = "SELECT flavor_ID, flavor FROM flavor";
$sql_category = "SELECT Category_ID, category FROM category";
$sql_supplier = "SELECT Supplier_ID, company_name FROM supplier";
include('database/connection.php');
try
{
   $stmt=$conn->prepare($sql_flavor); 
   $stmt->execute();
   $rs1=$stmt->fetchAll(); 

   $stmt2=$conn->prepare($sql_category);
   $stmt2->execute();
   $rs2=$stmt2->fetchAll();

   $stmt3=$conn->prepare($sql_supplier);
   $stmt3->execute();
   $rs3=$stmt3->fetchAll();

} catch(Exception $ex) {
   echo($ex -> getMessage());

}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product </title>

    <link rel="stylesheet" type="text/css" href="css/login.css?v=p<?php echo time();?>">
    <script src="https://kit.fontawesome.com/2cfb65917d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/to/font-awesome/css/font-awesome.min.css">
    

</head>
<body>
<div id="dashboardMainContainer">
        <?php include('partial/app-sidebar.php') ?>

        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include('partial/app-topNav.php') ?>
    
            <div class="dashboard_content">
                        <div class="dashboard_content_main">
                            <div id = "userAddFormContainer">

                                <form action="database/add-product.php" method="POST" class="appForm">
                                    <div class ="appFormInputContainer">
                                        <label for="product_name">Product Name</label>
                                        <input type="text" class ="appFormInput" id="product_name" name= "product_name"/>
                                    </div>
                                    <br>
                                
                                    <div class ="appFormInputContainer">
                                        <label for="product_price">Product Price</label>
                                        <input type="text" class = "appFormInput" id="product_price" name= "product_price"/>
                                    </div>
                                
                                    <div class ="appFormInputContainer">
                                        <label for="product_stock">Product Stock</label>
                                        <input type="text" class = "appFormInput" id="product_stock" name= "product_stock"/>
                                    </div>
                                    <div class ="appFormInputContainer">
                                        <label for="exp_date">Expiry Date</label>
                                        <input type="date" class = "appFormInput" id="exp_date" name= "exp_date"/>
                                    </div>
                                    <div class ="appFormInputContainer">
                                        <label for="man_date">Manufacturing Date</label>
                                        <input type="date" class = "appFormInput" id="man_date" name= "man_date"/>
                                    </div>
                                    <div class ="appFormInputContainer">
                                        <label for="quantity">Quantity</label>
                                        <input type="text" class = "appFormInput" id="quantity" name= "quantity"/>
                                    </div>
                                    <div class="appFormInputContainer">
                                            <label for="Category_ID"> Category </label>
                                            <select name="category" id="category">
                                                <option> -- Select Category -- </option>
                                                <?php foreach ($rs2 as $output) {?>
                                                <option value="<?php echo $output['Category_ID']; ?>"><?php echo $output['category'];?></option>
                                                <?php }?>
                                            </select>

                                    </div>
                                    <div class="appFormInputContainer">
                                            <label for="flavor_ID"> Flavor </label>
                                            <select name="flavor" id="flavor">
                                                <option> -- Select Flavor -- </option>
                                                <?php foreach ($rs1 as $output) {?>
                                                <option value="<?php echo $output['flavor_ID']; ?>"><?php echo $output['flavor'];?></option>
                                                <?php }?>
                                            </select>

                                    </div>
                                    <div class="appFormInputContainer">
                                            <label for="Supplier_ID"> Supplier </label>
                                            <select name="supplier" id="supplier">
                                                <option> -- Select Supplier -- </option>
                                                <?php foreach ($rs3 as $output) {?>
                                                <option value="<?php echo $output['Supplier_ID']; ?>"><?php echo $output['company_name'];?></option>
                                                <?php }?>
                                            </select>

                                    </div>


                                    <button type="submit" class="appBtn"><i class ="fa fa-plus"></i> Add Product</button>
                                
                                </form>
                                <?php 
                                    if(isset($_SESSION['response'])) {
                                        $response_message = $_SESSION['response']['message']; 
                                        $is_success = $_SESSION['response']['success'];
                                
                                ?>s
                                    <div class = "responseMessage">
                                        <p class = "responseMessage" <?= $is_success ? 'responseMessage__success' : 'responseMessage__error' ?>"> 
                                            <?= $response_message ?>

                                        </p>

                                    </div>
                                <?php unset($_SESSION['response']); } 
                                ?>



                            </div>

                        </div>
                    </div>
                </div>
        
    </div>

    
 
    
<script src='js/script.js'></script>
</body>
</html>
            
            