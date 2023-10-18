    <?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: index.php');
    }
    $_SESSION['table'] = 'supplier';
    $user = $_SESSION['user'];
    $suppliers = include('database/show-supplier.php');

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
                            <h1 class="section_header"><i class="fa fa-plus"></i> Add Supplier</h1>
                            <div class="dashboard_content_main">
                                <div id="userAddFormContainer">
                                    <form action="database/add-supplier.php" method="POST" class="appForm">
                                        <div class="appFormInputContainer">
                                            <label for="company_name">Company Name</label>
                                            <input type="text" class="appFormInput" id="company_name" name="company_name" />
                                        </div>
                                        <br>

                                        <div class="appFormInputContainer">
                                            <label for="contact_num">Contact No</label>
                                            <input type="text" class="appFormInput" id="contact_num" name="contact_num" />
                                        </div>

                                        <div class="appFormInputContainer">
                                            <label for="email">Email</label>
                                            <input type="text" class="appFormInput" id="email" name="email" />
                                        </div>

                                        <button type="submit" class="appBtn"><i class="fa fa-plus"></i> Add Supplier</button>

                                    </form>
                                    <?php if (isset($_SESSION['response'])) {
                                        $response_message = $_SESSION['response']['message'];
                                        $is_success = $_SESSION['response']['success'];
                                    ?>
                                        <div class="responseMessage">
                                            <p class="responseMessage <?= $is_success ? 'responseMessage__success' : 'responseMessage__error' ?>">
                                                <?= $response_message ?>
                                            </p>
                                        </div>
                                    <?php
                                        unset($_SESSION['response']);
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="column column-7">
                            <h1 class="section_header"><i class="fa fa-list"></i> Suppliers</h1>
                            <div class="dashboard_content_main">
                                <div class="section_content"></div>
                                <div class="user">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Company Name</th>
                                                <th>Contact No</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($suppliers as $index => $s) { ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= $s['company_name'] ?></td>
                                                    <td><?= $s['contact_num'] ?></td>
                                                    <td><?= $s['email'] ?></td>
                                                    <td>
                                                        <a href="#" class="updateSupplier" data-toggle="modal" data-target="#updateSupplierModal<?= $s['Supplier_ID'] ?>">
                                                                    <i class="fa fa-pencil"></i> Edit </a>
                                                            <a href="database/delete-supplier.php?Supplier_ID=<?= $s['Supplier_ID'] ?>" class="deleteSupplier">
                                                            <i class="fa fa-trash"></i> Delete</a>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="updateSupplierModal<?= $s['Supplier_ID'] ?>" tabindex="-1" role="dialog" aria-labelledby="updateSupplierModalLabel<?= $s['Supplier_ID'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="updateSupplierModalLabel<?= $s['Supplier_ID'] ?>">Edit Supplier</h5>
                                                                <button type="button" class="close-modal" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="database/update-supplier.php">
                                                                    <input type="hidden" name="Supplier_ID" value="<?= $s['Supplier_ID'] ?>">

                                                                    <div class="form-group">
                                                                        <label for="company_name">Company Name:</label>
                                                                        <input type="text" class="form-control" name="company_name" value="<?= $s['company_name'] ?>" required>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="contact_num">Contact No:</label>
                                                                        <input type="text" class="form-control" name="contact_num" value="<?= $s['contact_num'] ?>" required>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="email">Email :</label>
                                                                        <input type="text" class="form-control" name="emailk" value="<?= $s['email'] ?>" required>
                                                                    </div>

                                                                

                                                                    <!-- Add more fields here -->

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Update Supplier</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <p class="userCount"><?= count($suppliers) ?> Suppliers</p>
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
            $('.updateSupplier').click(function() {
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
    </body>
    </html>
