
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: sales-db.php');
}
$_SESSION['table'] = 'sales';
$user = $_SESSION['user'];
$products = include('database/show-sales.php');


$sql_product = "SELECT product_num, product_name FROM product";
include('database/connection.php');
try
{
   $stmt=$conn->prepare($sql_product); 
   $stmt->execute();
   $rs1=$stmt->fetchAll(); 

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

                                <form action="database/sales-db.php" method="POST" class="appForm">
                                    <div class ="appFormInputContainer">
                                        <h2>Product Selection</h2>
                                        <select id="productSelect">
                                            <option value="1"> $30.00</option>
                                            <option value="2"> $55.00</option>
                                            <option value="3"> $80.00</option>
                                        </select>
                                        <input type="number" id="quantity" placeholder="Quantity" min="1">
                                        <button onclick="addToCart()">Add to Cart</button>
                                    </div>
                                    <div class="appFormInputContainer">
                                            <label for="product_num"> Product </label>
                                            <select name="product_name" id="product_name">
                                                <option> -- Select Product -- </option>
                                                <?php foreach ($rs1 as $output) {?>
                                                <option value="<?php echo $output['product_num']; ?>"><?php echo $output['product_name'];?></option>
                                                <?php }?>
                                            </select>

                                    </div>
                                    
                                    <button type="submit" class="appBtn"><i class ="fa fa-plus"></i> Add Sales</button> 
                                    
                                    <br>

                                    <div class="appFormInputContainer">
                                        <div>
                                            <h2>Shopping Cart</h2>
                                            <ul id="cart">
                                                <!-- Cart items will be displayed here -->
                                            </ul>
                                            <p>Total: $<span id="total">0.00</span></p>
                                            <button onclick="checkout()">Checkout</button>
                                        </div>

                                        <script>
                                            const products = [
                                                { id: 1, name: "Product 1", price: 30.00 },
                                                { id: 2, name: "Product 2", price: 55.00 },
                                                { id: 3, name: "Product 3", price: 80.00 }
                                            ];

                                            const cart = [];

                                            function addToCart() {
                                                const productSelect = document.getElementById("productSelect");
                                                const quantityInput = document.getElementById("quantity");
                                                const selectedProductId = parseInt(productSelect.value);
                                                const quantity = parseInt(quantityInput.value);

                                                if (!quantity || quantity < 1) {
                                                    alert("Please enter a valid quantity.");
                                                    return;
                                                }

                                                const selectedProduct = products.find(product => product.id === selectedProductId);
                                                if (selectedProduct) {
                                                    const cartItem = {
                                                        product: selectedProduct,
                                                        quantity
                                                    };
                                                    cart.push(cartItem);
                                                    updateCart();
                                                    quantityInput.value = "";
                                                }
                                            }

                                            function updateCart() {
                                                const cartList = document.getElementById("cart");
                                                const totalSpan = document.getElementById("total");
                                                let cartHTML = "";
                                                let total = 0;

                                                cart.forEach(item => {
                                                    const { product, quantity } = item;
                                                    const itemTotal = product.price * quantity;
                                                    total += itemTotal;
                                                    cartHTML += `<li>${product.name} x${quantity} - $${itemTotal.toFixed(2)}</li>`;
                                                });

                                                cartList.innerHTML = cartHTML;
                                                totalSpan.textContent = total.toFixed(2);
                                            }

                                            function checkout() {
                                                // Perform the checkout logic here.
                                                // This is a simplified example, so adjust it according to your requirements.

                                                // Verify if the cart is empty.
                                                if (cart.length === 0) {
                                                    alert("Your cart is empty. Add items before checking out.");
                                                    return;
                                                }

                                                // Generate a receipt or send data to the server for further processing.
                                                // You can customize this part based on your specific needs.

                                                const receipt = {
                                                    items: cart,
                                                    total: getTotal(),
                                                };

                                                // Display the receipt (in this example, we alert it).
                                                alert(formatReceipt(receipt));

                                                // Clear the cart and update the UI.
                                                cart.length = 0; // Clear the cart array.
                                                updateCart();
                                            }

                                            function getTotal() {
                                                return cart.reduce((total, item) => {
                                                    const itemTotal = item.product.price * item.quantity;
                                                    return total + itemTotal;
                                                }, 0);
                                            }

                                            function formatReceipt(receipt) {
                                                const items = receipt.items.map(item => {
                                                    return `${item.product.name} x${item.quantity} - $${(item.product.price * item.quantity).toFixed(2)}`;
                                                });

                                                return `Receipt:\n${items.join('\n')}\n\nTotal: $${receipt.total.toFixed(2)}`;
                                            }

                                        </script>
                                    </div>
                                    

                                       
                                
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

<?php
// Include your database connection code here (e.g., db_connection.php)
// Replace this with your actual database connection code.

// Simulate a database connection

$servername = "localhost";
$username = "yang";
$password = "ily3000";
$inventory = "inventory.sql"; // Replace with your actual database name

// Create a database connection
$conn = mysqli_connect($servername, $username, $password, $inventory);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to update product quantity after a sale
function updateProductQuantity($product_num, $sales) {
    global $conn;

    $sql = "UPDATE product SET product_stock = product_stock - $sales WHERE id = $product_num";

    if (mysqli_query($conn, $sql)) {
        echo "Product quantity updated successfully.";
    } else {
        echo "Error updating product quantity: " . mysqli_error($conn);
    }
}

// Function to check and notify when stock is low
function checkLowStock($product_num, $threshold) {
    global $conn;

    $sql = "SELECT name, product_stock FROM product WHERE id = $product_num";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $product_stock = $product['product_stock'];

        if ($product_stock <= $threshold) {
            echo "Low stock for {$product['name']}. Current quantity: $product_stock.";
            // Implement notification logic (e.g., send an email).
        }
    } else {
        echo "Product not found.";
    }
}

// Example usage:
$product_num = 1; // Replace with the actual product ID.
$sales = 5; // Replace with the actual quantity sold.
$low_stock_threshold = 10; // Set your low stock threshold.

updateProductQuantity($product_num, $sales);
checkLowStock($product_num, $low_stock_threshold);

// Close the database connection
mysqli_close($conn);
?>

            
            