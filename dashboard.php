<?php 
     session_start();
     if(!isset($_SESSION['user'])) header('Location: index.php');
     $_SESSION['table'] = 'users';
     $user = $_SESSION['user'];
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard </title>

    <link rel="stylesheet" type="text/css" href="css/login.css?v=p<?php echo time();?>">
    <script src="https://kit.fontawesome.com/2cfb65917d.js" crossorigin="anonymous"></script>

</head>
<body>
    <div id="dashboardMainContainer">
        <?php include('partial/app-sidebar.php') ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include('partial/app-topNav.php') ?>
            <div class="dashboard_content">
                <div class="dashboard_content_main">

                </div>
            </div>
        </div>
        
    </div>

    
 
    
<script src='js/script.js'></script>
</body>
</html>