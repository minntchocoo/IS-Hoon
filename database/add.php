<?php
    session_start();

    $table__name = $_SESSION['table'];

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];  

    //$encrypted = password_hash($password, PASSWORD_DEFAULT);
    // ->RANDOMIZE PASSWORD IN DATABASE (41:00MINUTE IN YT VID)
    // Adding records ----

    try{
        $command = "INSERT INTO 
                               user(first_name, last_name, email, password, created_at, updated_at)
                           VALUES 
                               ('".$first_name."','".$last_name."','".$email."', '".$password."', NOW(), NOW())";
                           

        include('connection.php');

        $conn->exec($command);
        $response = [
            'success' => true,
            'message' => ' Account created successfully.' 
        ];
        
    } catch(PDOException $e) {
        
        $response = [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
    $_SESSION['response'] = $response;
    header('location: ../user-add.php')

?>


