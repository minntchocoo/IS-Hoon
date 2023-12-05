    <?php
        session_start();

        $table__name = $_SESSION['table'];

        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_stock = $_POST['product_stock'];
        $exp_date = $_POST['exp_date'];  
        $man_date = $_POST['man_date'];  
        $category = $_POST['category'];
        $flavor = $_POST['flavor'];
        $supplier = $_POST['supplier'];
        $imageurl = $_POST['image_url'];
        //$encrypted = password_hash($password, PASSWORD_DEFAULT);
        // ->RANDOMIZE PASSWORD IN DATABASE (41:00MINUTE IN YT VID)
        // Adding records ----

        try{
            $command = "INSERT INTO 
                                product(product_name, product_price, product_stock, exp_date, man_date,  Category_ID, flavor_ID, Supplier_ID, image_url)
                            VALUES 
                                ('".$product_name."','".$product_price."','".$product_stock."', '".$exp_date."', '".$man_date."', '".$category."', '".$flavor."', '".$supplier."', '".$imageurl"')";
                            

            include('connection.php');

            $conn->exec($command);
            $response = [
                'success' => true,
                'message' => ' Product added successfully.' 
            ];

        } catch(PDOException $e) {
            
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
        $_SESSION['response'] = $response;
        header('location: ../product-add.php')

    ?>


        