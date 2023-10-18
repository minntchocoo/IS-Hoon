<?php
        session_start();

        $table__name = $_SESSION['table'];

        $company_name = $_POST['company_name'];
        $Contact_ID = $_POST['contact_num'];
        $email = $_POST['email'];
        
        //$encrypted = password_hash($password, PASSWORD_DEFAULT);
        // ->RANDOMIZE PASSWORD IN DATABASE (41:00MINUTE IN YT VID)
        // Adding records ----

        try{
            $command = "INSERT INTO 
                                supplier(company_name, contact_num, email)
                            VALUES 
                                ('".$company_name."','".$contact_num."','".$email."')";
                            

            include('connection.php');

            $conn->exec($command);
            $response = [
                'success' => true,
                'message' => ' Supplier added successfully.' 
            ];
                
        } catch(PDOException $e) {
            
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
        $_SESSION['response'] = $response;
        header('location: ../suppliers.php')

    ?>


