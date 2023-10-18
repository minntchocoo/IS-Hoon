<?php
    include('database/connection.php')
    

?>



<div class="dashboard_sidebar" id="dashboard_sidebar">
    <h3 class="dashboard_logo" id = "dashboard_logo"> IMS </h3>
    <div class="dashboard_sidebar_user">
        <img src="images/art.jpg" alt="User image." id ="userImage" />
        <span><?= $user['first_name'] . ' ' . $user['last_name']?></span>
    </div>
    <div class="dashboard_sidebar_menu">
        <ul class="dashboard_menu_list">
            <!-- class="menuActive" -->
            <li>
                <a href="./dashboard.php"><i class="fa fa-dashboard "></i> <span class="menuText" >Dashboard</span></a>
            </li>
            <li>
                <a href="./user-add.php"><i class="fa fa-user-plus "></i> <span class="menuText">Create New Account</span></a>
            </li>
            <li>
                <a href="./product-add.php"><i class="fa-solid fa-boxes-stacked"> </i> <span class="menuText" style="margin-left: 3px;"> Add Product</span></a>
            </li>
            <li>
                <a href="./view-product.php"><i class="fa-solid fa-folder-open"> </i> <span class="menuText" style="margin-left: 3px;"> View Product</span></a>
            </li>
            <li>
                <a href="./flavor-category-add.php"><i class="fa-solid fa-wheat-awn"> </i> <span class="menuText" style="margin-left: 3px;"> Categories & Flavor </span></a>
            </li>
            <li>
                <a href="./suppliers.php"><i class="fa-solid fa-truck-ramp-box"> </i> <span class="menuText" style="margin-left: 3px;"> Suppliers </span></a>
            </li>



        </ul>



    </div>

</div>