<?php
    $data =$_POST;
    $user_id = (int) $data['user_id'];
    $fullname = $data['fullname'];


    try{
        $command = "DELETE FROM user WHERE id={$user_id}";         

        include('connection.php');

        $conn->exec($command);
        echo json_encode([
            'success' => true,
            'message' => $fullname . ' successfully deleted'
        ]);
    } catch(PDOException $e) {
        
        echo json_encode([
            'success' => false,
            'message' => 'Error processing your request'
        ]);
    }

?>