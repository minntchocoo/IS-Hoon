<?php
    // the session will begin
    session_start();


    $error_message='';
    
    if($_POST){
        include('database/connection.php');   
        $email =$_POST['email'];
        $password =$_POST['password'];
        $query = 'SELECT * FROM user WHERE user.email="'. $email . '" AND user.password="'. $password .'"';
        $stmt = $conn->prepare($query);
        $stmt-> execute();

        


        if($stmt->rowCount() > 0) {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $user = $stmt->fetchAll()[0];
            $_SESSION['user'] = $user; // STORES THE LOGGED IN USER IN A SESSION VARIABLE
            
            header('Location: dashboard.php');

        } else $error_message = " Please input a valid email or password.";

       
        



                 
    }



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System Login</title>

    <link rel="stylesheet" type="text/css" href="css/login.css?v=<?php echo time();?>">

</head>
<body id= 'loginBody'>
    <?php if(!empty($error_message)) { ?>
        <div id='errorMessage' >
            <strong>ERROR:</strong> </p> <?= $error_message ?> </p>
        </div>
    <?php } ?>

    


    
    <div class="container">
        <div class="loginHeader">  
            <h1>WELCOME TO OUR WEBSITE!</h1>
            <p>Inventory Management System</p>
    
        </div>
        <div class="loginBody">
            <form action="index.php" method ='POST'>
                <div class="loginInput">
                    <label for="">Email</label>
                    <input placeholder="Email" name='email' type="text">
                </div>
                <div class="loginInput">
                    <label for="">Password</label>
                    <input placeholder="Password" name='password' type="password"
                    
                    
                    id="myInput"><br><br>

                    <div<input class = "show_password">
                        <label class="show_password"> <input class="show_password" type = "checkbox" onclick = "myFunction()"> Show password </label>
                    
                    </div>
                    
                    
                    <script>
                        function myFunction() {
                            var x = document.getElementById('myInput');
                            if(x.type ==='password') {
                                x.type = "text";
                            } else {
                                x.type="password";
                            }

                        }
                    </script>
                </div>
                <div class="login_button_container">
                    <button>Log In</button>
                </div>
                <div class="register">
                        <p>Create a new account <a href="sign-up.php">Sign up</a></p>
                    </div>

                
            </form>
    
        </div>
    
    </div>
    

    
</body>
</html>