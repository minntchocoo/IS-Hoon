<?php 
    $data = $_POST;
    $userid = $data['user_id'];
    $f_name = $data['first_name'];
    $l_name = $data['last_name'];
    $email = $data['email'];

    try {
        include('connection.php');
        $stmt = $conn->prepare("UPDATE user SET first_name = ?, last_name = ?, email = ? WHERE id = ?");
        $stmt->execute([$f_name, $l_name, $email, $userid]);

        $affectedRows = $stmt->rowCount();

        if ($affectedRows > 0) {
            echo json_encode([
                'success' => true,
                'message' => $f_name . ' ' . $l_name . ' has been successfully updated.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No changes were made.'
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error processing your request: ' . $e->getMessage()
        ]);
    }
?>
