


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up </title>

    <link rel="stylesheet" type="text/css" href="css/login.css?v=p<?php echo time();?>">
    <script src="https://kit.fontawesome.com/2cfb65917d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/to/font-awesome/css/font-awesome.min.css">
    

</head>
<body>
    <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <div id = "userAddFormContainer">

                        <form action="database/add.php" method="POST" class="appForm">
                            <div class ="appFormInputContainer">
                                <label for="first_name">First Name</label>
                                <input type="text" class ="appFormInput" id="first_name" name= "first_name"/>
                            </div>
                            <br>
                        
                            <div class ="appFormInputContainer">
                                <label for="last_name">Last Name</label>
                                <input type="text" class = "appFormInput" id="last_name" name= "last_name"/>
                            </div>
                        
                            <div class ="appFormInputContainer">
                                <label for="email">Email</label>
                                <input type="text" class = "appFormInput" id="email" name= "email"/>
                            </div>
                            <div class ="appFormInputContainer">
                                <label for="password">Password</label>
                                <input type="password" class = "appFormInput" id="password" name= "password"/>
                            </div>

                            <button type="submit" class="appBtn"><i class ="fa fa-plus"></i> Create Account</button>
                        
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
            
            