<?php
    $servername ='localhost';
    $username ='root';
    $password ='';

    //connecting to database..
    try {
        $conn = new PDO("mysql:host=$servername;dbname=inventory;port=3306", $username, $password);
         // the PDO error mode is set to exception
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
    } catch(\Exception $e) {
        echo $e->getMessage();
    }

?>