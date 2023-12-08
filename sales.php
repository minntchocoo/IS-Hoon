
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: sales-db.php');
}
$_SESSION['table'] = 'sales';
$user = $_SESSION['user'];
$products = include('database/show-product.php');
$sales = include('database/show-sales.php');

$sql_product = "SELECT product_num, product_name, product_price FROM product";
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
    
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            width: 80%; /* Adjust the width as needed */
            max-width: 400px; /* Set a maximum width if desired */
            padding: 20px;
            background-color: #7f2b2b; /* Adjust background color */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px; /* Optional: Add border-radius for rounded corners */
        }

        .modal-content {
            /* Additional styles for the modal content if needed */
        }

        /* Additional styles for better readability */
        #salesTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        #salesTable th, #salesTable td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #salesTable th {
            background-color: #f2f2f2;
        }
        /* Close button style */
        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 22px;
            cursor: pointer;
        }
        .reports-button {
            border-radius: 8px;
            top: 10px;
            right: 10px;
            font-size: 22px;
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
                    <button type="button" class="appBtn" onclick="reports()">Daily Sales Report</button>
                    <div id="myModal" class="modal">
                        <div class="modal-content">
                            <span class="close-button" onclick="closeModal()">&times;</span>
                            <h2></h2>
                            <table id="salesTable">

                            </table>
                        </div>
                    </div>
                    <div id="userAddFormContainer">
                        <?php 
                            if(isset($_SESSION['response'])) {
                                $response_message = $_SESSION['response']['messages']; 
                                $is_success = $_SESSION['response']['success'];
                        ?>
                            <div class="responseMessage <?= $is_success ? 'responseMessage__success' : 'responseMessage__error' ?>">
                                <p><?= $response_message ?></p>
                            </div>
                        <?php unset($_SESSION['response']); } ?>
                    
                        <form id="salesForm" action="database/sales-db.php" method="POST" class="appForm">
                            <div class="appFormInputContainer">
                                <h2><i class="fa-solid fa-table-list"></i> Product Selection</h2>
                                <label for="product_name">Product</label>
                                <select id="productSelect" name="product_id">
                                    <?php foreach ($rs1 as $output) { ?>
                                        <option value="<?php echo $output['product_num']; ?>">
                                            <?php echo $output['product_name']; ?> - $<?php echo number_format($output['product_price'], 2); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <input type="number" id="quantity" name="quantity" placeholder="Quantity" min="1">
                                <button onclick="addToCart()">Add to Cart</button>
                            </div>

                            <br>

                            <div class="appFormInputContainer">
                                <div>
                                    <h2><i class="fa-solid fa-cart-plus"></i> Shopping Cart</h2>
                                    <ul id="cart">
                                        <!-- Cart items will be displayed here -->
                                    </ul>
                                    <p>Total: $<span id="total">0.00</span></p>
                                    <input type="hidden" value="">
                                </div>
                            </div>

                            <button type="button" class="appBtn" onclick="checkout()">Checkout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src='js/script.js'></script>
</body>

    <script>
        const products = <?php echo json_encode($products); ?>;
        const cart = [];

        function addToCart() {
            event.preventDefault();
            const productSelect = document.getElementById("productSelect");
            const quantityInput = document.getElementById("quantity");
            const selectedProductId = productSelect.value;
            const quantity = parseInt(quantityInput.value, 10);

            if (!quantity || quantity < 1) {
                alert("Please enter a valid quantity.");
                return;
            }

            console.log(products);
            console.log(selectedProductId);

            // Check if products is an array and has items
            if (!Array.isArray(products) || products.length === 0) {
                alert("No products found in the database.");
                return;
            }

            try {
                console.log(selectedProductId);
                const selectedProduct = products.find(product => product.product_num === selectedProductId);

                console.log(selectedProduct);
                if (!selectedProduct) {
                    console.log("selected product", selectedProduct);
                    throw new Error("Product not found in the database.");
                }

                const cartItem = {
                    product: selectedProduct,
                    quantity
                };
                cart.push(cartItem);
                updateCart();
                quantityInput.value = "";
            } catch (error) {
                alert(`Error adding to cart: ${error.message}`);
            }
        }

        function updateCart() {
            const cartList = document.getElementById("cart");
            const totalSpan = document.getElementById("total");
            let cartHTML = "";
            let total = 0;

            cart.forEach(item => {
                const { product, quantity } = item;
                
                const itemTotal = product['product_price'] * quantity;
                total += itemTotal;
                cartHTML += `<li>${product.product_name} x${quantity} - $${itemTotal.toFixed(2)}</li>`;
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
            console.log(cart)
            // Display the receipt (in this example, we alert it).
            alert(formatReceipt(receipt));

            const cartData = cart.map(item => ({
                product_num: item.product.product_num,
                product_name: item.product.product_name,
                total: item.product.product_price * item.quantity,
                quantity: item.quantity
            }));

            
            $.ajax({
                type: "POST",
                    url: "database/sales-db.php", // Change this to the actual URL of your PHP script
                    data: { cart: JSON.stringify(cartData) },
                    
                    success: function (response) {
                        var responseData = JSON.parse(response);
                        if (responseData.status === "success") {
                            alert("Items recorded in the database successfully.");
                            alert(responseData.messages)
                            // Clear the cart and update the UI.
                            cart.length = 0; // Clear the cart array.
                            updateCart();
                        } else {
                            console.log(response)
                            alert("Failed to record items in the database.");
                            
                        }
                    },
                    error: function () {
                        alert("An error occurred while communicating with the server.");
                    }
                });
                        
            // Clear the cart and update the UI.
            

        }

        function getTotal() {
            return cart.reduce((total, item) => {
                const itemTotal = item.product.product_price * item.quantity;
                return total + itemTotal;
            }, 0);
        }

        function formatReceipt(receipt) {
            const items = receipt.items.map(item => {
                return `${item.product.product_name} x${item.quantity} - $${(item.product.product_price * item.quantity).toFixed(2)}`;
            });

            return `Receipt:\n${items.join('\n')}\n\nTotal: $${receipt.total.toFixed(2)}`;
        }

        function reports() {
        var modal = document.getElementById("myModal");
        modal.style.display = "block";

        // Make an AJAX call to fetch data from the server
        $.ajax({
            type: "POST",
            url: "database/reports.php", // Replace with the actual URL of your PHP script
            data: { targetDate: '2023-12-07' }, // Replace with the desired target date
            success: function (response) {
                var salesData = JSON.parse(response);
                displaySalesData(salesData);
            },
            error: function () {
                alert("An error occurred while fetching data.");
            }
        });
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        function displaySalesData(salesData) {
            var table = document.getElementById("salesTable");
            var header = table.createTHead();
            var headerRow = header.insertRow();
            headerRow.insertCell().innerHTML = "<b>Product</b>";
            headerRow.insertCell().innerHTML = "<b>Quantity</b>";
            headerRow.insertCell().innerHTML = "<b>Price</b>";

            salesData.forEach(function (sale) {
                var row = table.insertRow();
                row.insertCell().innerHTML = sale.product_name; // Assuming your PHP returns product_name
                row.insertCell().innerHTML = sale.total_quantity;
                row.insertCell().innerHTML = "$" + sale.total_amount;
            });
        }





    </script>
</html>


<?php
try {
    // Replace with your actual database credentials and details
    require('database/connection.php');

    // Function to update product quantity after a sale

    // Function to check and notify when stock is low
    function checkLowStock($conn, $product_num, $threshold) {
        $sql = "SELECT product_name, product_stock FROM product WHERE product_num = :product_num";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':product_num', $product_num, PDO::PARAM_INT);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $product_stock = $product['product_stock'];

            if ($product_stock <= $threshold) {
                echo "Low stock for {$product['product_name']}. Current quantity: $product_stock.";
                // Implement notification logic (e.g., send an email).
            }
        } else {
            echo "Product not found.";
        }
    }

    // Example usage:
    $product_num = 3; // Replace with the actual product ID.
    $sales = 0; // Replace with the actual quantity sold.
    $low_stock_threshold = 10; // Set your low stock threshold.

    checkLowStock($conn, $product_num, $low_stock_threshold);

    // Close the database connection
    $conn = null;
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>