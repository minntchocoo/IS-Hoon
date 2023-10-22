<!DOCTYPE html>
<html>
<head>
    <title>POS System</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
    <h1>Point of Sale System</h1>

    <div>
        <h2>Product Selection</h2>
        <select id="productSelect">
            <option value="1">Product 1 - $10.00</option>
            <option value="2">Product 2 - $15.00</option>
            <option value="3">Product 3 - $20.00</option>
        </select>
        <input type="number" id="quantity" placeholder="Quantity" min="1">
        <button onclick="addToCart()">Add to Cart</button>
    </div>

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
            { id: 1, name: "Product 1", price: 10.00 },
            { id: 2, name: "Product 2", price: 15.00 },
            { id: 3, name: "Product 3", price: 20.00 }
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
            // Implement checkout functionality, e.g., send data to the server or print a receipt
            alert("Checkout functionality not implemented in this example.");
        }
    </script>
</body>
</html>
