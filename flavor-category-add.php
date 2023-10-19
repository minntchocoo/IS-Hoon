<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
}
$_SESSION['table'] = 'user';
$user = $_SESSION['user'];
$flavors = include('database/show-flavor.php');
$category = include('database/show-category.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" type="text/css" href="css/login.css?v=p<?= time(); ?>">
    <script src="https://kit.fontawesome.com/2cfb65917d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="js/bootstrap-5.3.0-alpha3-dist/css/bootstrap.min.css?v=p<?= time(); ?>">
</head>

<body>
    <div id="dashboardMainContainer">
        <?php include('partial/app-sidebar.php') ?>

        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include('partial/app-topNav.php') ?>

            <div class="dashboard_content">
                <div class="row">
                    <div class="column column-5">
                        <a href="#" class="addFlavor btn btn-light float-right" data-toggle="modal" data-target="#addFlavorModal">Add Flavor</a>
                        <h1 class="section_header"> <i class="fa fa-clipboard"></i> Flavor     </h1>
                        <div class="dashboard_content_main">
                            <div class="section_content"></div>
                            <div class="user">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Flavor</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($flavors as $index => $f) { ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= $f['flavor'] ?></td>
                                                <td><?= $f['description'] ?></td>
                                                
                                                <td>
                                                    <a href="#" class="updateFlavor" data-toggle="modal" data-target="#updateFlavorModal<?= $f['flavor_ID'] ?>">
                                                            <i class="fa fa-pencil"></i> Edit </a>
                                                    <a href="database/delete-flavor.php?flavor_ID=<?= $f['flavor_ID'] ?>" class="deleteFlavor">
                                                    <i class="fa fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                          
                                        <?php } ?>
                                           <!-- FLAVOR EDIT-->
                                           <div class="modal fade" id="updateFlavorModal<?= $f['flavor_ID'] ?>" tabindex="-1" role="dialog" aria-labelledby="updateflavorModalLabel<?= $f['flavor_ID'] ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="updateFlavorModalLabel<?= $f['flavor_ID'] ?>">Edit Flavor</h5>
                                                            <button type="button" class="close-modal" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="database/update-flavor.php">
                                                                <input type="hidden" name="flavor_ID" value="<?= $f['flavor_ID'] ?>">

                                                                <div class="form-group">
                                                                    <label for="flavor">Flavor:</label>
                                                                    <input type="text" class="form-control" name="flavor" value="<?= $f['flavor'] ?>" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="description">Description:</label>
                                                                    <input type="text" class="form-control" name="description" value="<?= $f['description'] ?>" required>
                                                                </div>

                                                                


                                                                <!-- Add more fields here -->

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Update Flavor</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- FLAVOR MODAL-->
                                        <div class="modal fade" id="addFlavorModal" tabindex="-1" role="dialog" aria-labelledby="addFlavorModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addFlavorModalLabel">Add Flavor</h5>
                                                        <button type="button" class="close-modal" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="database/add-flavor.php">
                                                            <div class="form-group">
                                                                <label for="flavor">Flavor:</label>
                                                                <input type="text" class="form-control" name="flavor" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="description">Description:</label>
                                                                <input type="text" class="form-control" name="description" required>
                                                            </div>

                                                            <!-- Add more fields here if needed -->

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Add Flavor</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tbody>
                                </table>
                                <p class="userCount"><?= count($flavors) ?> flavors</p>
                            </div>
                        </div>
                    </div>
                    <div class="column column-7">
                        <a href="#" class="addCategory btn btn-light float-right" data-toggle="modal" data-target="#addCategoryModal">Add Category</a>
                        <h1 class="section_header">
                            <i class="fa fa-list"></i> Category
                            
                        </h1>
                        <div class="dashboard_content_main">
                            <div class="section_content"></div>
                            <div class="user">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Category Name</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($category as $index => $c) { ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= $c['category'] ?></td>
                                                <td><?= $c['description'] ?></td>
                                                
                                                <td>
                                                <a href="#" class="updateCategory" data-toggle="modal" data-target="#updateCategoryModal<?= $c['Category_ID'] ?>">
                                                        <i class="fa fa-pencil"></i> Edit </a>
                                                <a href="database/delete-category.php?Category_ID=<?= $c['Category_ID'] ?>" class="deleteCategory">
                                                <i class="fa fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                            <!-- CATEGORY EDIT -->
                                            <div class="modal fade" id="updateCategoryModal<?= $c['Category_ID'] ?>" tabindex="-1" role="dialog" aria-labelledby="updateCategoryModalLabel<?= $c['Category_ID'] ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="updateCategoryModalLabel<?= $c['Category_ID'] ?>">Edit Category</h5>
                                                            <button type="button" class="close-modal" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="database/update-category.php">
                                                                <input type="hidden" name="Category_ID" value="<?= $c['Category_ID'] ?>">

                                                                <div class="form-group">
                                                                    <label for="category">Category:</label>
                                                                    <input type="text" class="form-control" name="category" value="<?= $c['category'] ?>" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="description">Description:</label>
                                                                    <input type="text" class="form-control" name="description" value="<?= $c['description'] ?>" required>
                                                                </div>

                                                                


                                                                <!-- Add more fields here -->

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Update Category</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                         
                                           
                                        <?php } ?>

                                       <!-- CATEGORY ADD -->
                                            <!-- Add Category Modal -->
                                            <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                                                            <button type="button" class="close-modal" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="database/add-category.php">
                                                                <div class="form-group">
                                                                    <label for="category">Category:</label>
                                                                    <input type="text" class="form-control" name="category" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="description">Description:</label>
                                                                    <input type="text" class="form-control" name="description" required>
                                                                </div>

                                                                <!-- Add more fields here if needed -->

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Add Category</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    </tbody>
                                </table>
                                <p class="userCount"><?= count($category) ?> Category</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery/jquery-3.7.0.min.js"></script>
    <script src="js/bootstrap-5.3.0-alpha3-dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.updateCategory').click(function() {
                var targetModal = $(this).data('target');
                $(targetModal).modal('show');
            });

            $('.modal').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
            });

            $('.close-modal').click(function() {
                var modal = $(this).closest('.modal');
                modal.modal('hide');
            });

            $('.modal').on('click', function(e) {
                if ($(e.target).hasClass('modal') || $(e.target).hasClass('close')) {
                    $(this).modal('hide');
                }
            });
        });
    
    </script>
    
    <!-- flavor -->
    <script>
    $(document).ready(function() {
        $('.updateFlavor').click(function() {
            var targetModal = $(this).data('target');
            $(targetModal).modal('show');
        });

        $('.modal').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
        });

        $('.close-modal').click(function() {
            var modal = $(this).closest('.modal');
            modal.modal('hide');
        });

        $('.modal').on('click', function(e) {
            if ($(e.target).hasClass('modal') || $(e.target).hasClass('close')) {
                $(this).modal('hide');
            }
        });
    });
    </script>

    <!-- CATEGORY ADD -->
    <script>
        $(document).ready(function() {
            $('.addCategory').click(function() {
                var targetModal = $(this).data('target');
                $(targetModal).modal('show');
            });

            $('.modal').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
            });

            $('.close-modal').click(function() {
                var modal = $(this).closest('.modal');
                modal.modal('hide');
            });

            $('.modal').on('click', function(e) {
                if ($(e.target).hasClass('modal') || $(e.target).hasClass('close')) {
                    $(this).modal('hide');
                }
            });
        });
    </script>
    <!-- FLAVOR ADD -->

    <script>
      $(document).ready(function() {
            // Attach the event handler to the parent container with class 'column-5'
            $('.column-5').on('click', '.addFlavor', function() {
                var targetModal = $(this).data('target');
                $(targetModal).modal('show');
            });

            $('.modal').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
            });

            $('.close-modal').click(function() {
                var modal = $(this).closest('.modal');
                modal.modal('hide');
            });

            $('.modal').on('click', function(e) {
                if ($(e.target).hasClass('modal') || $(e.target).hasClass('close')) {
                    $(this).modal('hide');
                }
            });
        });


    </script>