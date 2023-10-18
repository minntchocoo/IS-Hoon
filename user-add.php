<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
}
$_SESSION['table'] = 'user';
$user = $_SESSION['user'];
$users = include('database/show-user.php');
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
                        <h1 class="section_header"><i class="fa fa-plus"></i> Create Account</h1>
                        <div class="dashboard_content_main">
                            <div id="userAddFormContainer">
                                <form action="database/add.php" method="POST" class="appForm">
                                    <div class="appFormInputContainer">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="appFormInput" id="first_name" name="first_name" />
                                    </div>
                                    <br>

                                    <div class="appFormInputContainer">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="appFormInput" id="last_name" name="last_name" />
                                    </div>

                                    <div class="appFormInputContainer">
                                        <label for="email">Email</label>
                                        <input type="text" class="appFormInput" id="email" name="email" />
                                    </div>
                                    <div class="appFormInputContainer">
                                        <label for="password">Password</label>
                                        <input type="password" class="appFormInput" id="password" name="password" />
                                    </div>

                                    <button type="submit" class="appBtn"><i class="fa fa-plus"></i> Create Account</button>

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
                        <h1 class="section_header"><i class="fa fa-list"></i> Accounts</h1>
                        <div class="dashboard_content_main">
                            <div class="section_content"></div>
                            <div class="user">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $index => $user) { ?>
                                            <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= $user['first_name'] ?></td>
                                                <td><?= $user['last_name'] ?></td>
                                                <td><?= $user['email'] ?></td>
                                                <td><?= date('M d,Y @ h:i:s A', strtotime($user['created_at'])) ?></td>
                                                <td><?= date('M d,Y @ h:i:s A', strtotime($user['updated_at'])) ?></td>
                                                <td>
                                                    <a href="" class="update_user" data-userid='<?= $user['id'] ?>'><i class="fa fa-pencil"></i> Edit</a>
                                                    <a href="" class="deleteUser" data-userid="<?= $user['id'] ?>" data-fname="<?= $user['first_name'] ?>" data-lname="<?= $user['last_name'] ?>">
                                                        <i class="fa fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <p class="userCount"><?= count($users) ?> Users</p>
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
            $(document).on('click', '.deleteUser', function(e) {
                e.preventDefault();
                var userId = $(this).data('userid');
                var fname = $(this).data('fname');
                var lname = $(this).data('lname');
                var fullName = fname + ' ' + lname;

                if (window.confirm('Are you sure to delete ' + fname + '?')) {
                    $.ajax({
                        method: 'POST',
                        data: {
                            user_id: userId,
                            fullname: fullName,
                        },
                        url: 'database/delete-user.php',
                        dataType: "json",
                        success: function(data) {
                            if (data.success) {
                                if (window.confirm(data.message)) {
                                    location.reload();
                                }
                            } else {
                                window.alert(data.message);
                            }
                        }
                    });
                } else {
                    console.log('will not delete');
                }
            });

            $(document).on('click', '.update_user', function(e) {
                e.preventDefault();
                var firstName = $(this).closest('tr').find('td:nth-child(2)').text();
                var lastName = $(this).closest('tr').find('td:nth-child(3)').text();
                var email = $(this).closest('tr').find('td:nth-child(4)').text();
                var userid = $(this).data('userid');

                var modal = `
                    <div class="modal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Update User Information</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="mb-3">
                                            <label for="update_first_name" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="update_first_name" value="${firstName}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="update_last_name" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="update_last_name" value="${lastName}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="update_email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="update_email" value="${email}">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="update_user_button">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                var $modal = $(modal);
                $modal.modal('show');

                $modal.find('#update_user_button').on('click', function() {
                    var updatedFirstName = $modal.find('#update_first_name').val();
                    var updatedLastName = $modal.find('#update_last_name').val();
                    var updatedEmail = $modal.find('#update_email').val();

                    var requestData = {
                        user_id: userid,
                        first_name: updatedFirstName,
                        last_name: updatedLastName,
                        email: updatedEmail
                    };

                    $.ajax({
                        method: 'POST',
                        data: requestData,
                        url: 'database/update-user.php',
                        dataType: 'json',
                        success: function(data) {
                            if (data.success) {
                                alert(data.message);
                                location.reload();
                            } else {
                                alert(data.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('An error occurred while updating the user: ' + error);
                        }
                    });

                    $modal.modal('hide');
                });

                $modal.on('hidden.bs.modal', function() {
                    $modal.remove();
                });
            });
        });
    </script>
</body>
</html>
