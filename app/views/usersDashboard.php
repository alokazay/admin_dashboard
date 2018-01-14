<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="robots" content="noindex, nofollow">
        <meta name="csrf-token" content="<?= csrf_token(); ?>">

        <!-- CSS -->
        <?= HTML::style('misc/plugins/bootstrap/dist/css/bootstrap.min.css'); ?>
        <?= HTML::style('misc/css/font-awesome.min.css'); ?>
        <?= HTML::style('misc/css/AdminLTE.css'); ?>
        <?= HTML::style('misc/css/_all-skins.css'); ?>
        <?= HTML::style('misc/css/dropzone.css'); ?>
        <?= HTML::style('misc/css/custom.css'); ?>
        <!-- END CSS -->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <input type="hidden" id="rootUrl" value="https://seiken.dp.ua/dashboard">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="https://seiken.dp.ua/" target="_blank" class="logo">
                  <!-- mini logo for sidebar mini 50x50 pixels -->
                  <span class="logo-mini"><b>Ad</b>Min</span>
                  <!-- logo for regular state and mobile devices -->
                  <span class="logo-lg"><b>Dashboard</b> Panel</span>
                </a>
            </header>

            <aside class="main-sidebar">
                <section class="sidebar">
                    <div class="user-panel">
                        <div class="pull-left image"><img src="../misc/images/user6-128x128.jpg" class="img-circle" alt="User Image"></div>
                        <div class="pull-left info">
                            <p><?=ucfirst($userData->user_login); ?> [<?=$userData->role;?>]</p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                            <a href="<?= URL::asset('/logout');?>"><i class="fa fa-circle text-danger"></i> Logout</a>
                        </div>
                    </div>

                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header">MAIN NAVIGATION</li>
                        <li><a href="<?= URL::asset('/dashboard/users');?>"><i class="fa fa-book"></i> <span>Users</span></a></li>
                    </ul>
                </section>
            </aside>

            <div class="content-wrapper">
                <div id="successMessage" class="callout callout-success" style="display: none;">
                    <h4>Success!</h4>
                    <span class="message"></span>
                </div>

                <div id="errorMessage" class="callout callout-danger" style="display: none;">
                    <h4>Error!</h4>
                    <span class="message"></span>
                </div>
                
                <section class="content-header">
                    <h1>Admin section</h1>
                    <ol class="breadcrumb">
                        <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Home</a></li>
                    </ol>
                </section>

                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Users Data Table</h3>
                                </div>

                                <div class="box-body no-padding">
                                    <table id="usersDataTable" class="table table-condensed">
                                        <tbody>
                                            <tr>
                                                <th style="width: 10%">#</th>
                                                <th style="width: 40%">User Login</th>
                                                <th style="width: 30%"> Role</th>
                                                <th style="width: 20%">Actions</th>
                                            </tr>
                                            <?php foreach ($usersData as $userData): ?>
                                           
                                            <tr>
                                                <td><?=$userData->id;?></td>
                                                <td>
                                                    <?php if ($userData->role == 'manager'): ?>
                                                    <span><a href="#">[ Tasks : <?=$userData->tasks;?> ]</a></span> 
                                                    <?php endif; ?>
                                                    <?=$userData->user_login;?></td>
                                                <td>
                                                    <span><a href="#">[ Role : <?=$userData->role;?> ]</a></span>
                                                </rd>
                                                <td>
                                                    <?php if ($userData->role == 'manager') :?>
                                                    <span class="label label-warning actionLabel" data-toggle="modal" data-target="#addTaskModal" 
                                                        onclick="jQuery('#newTaskUserId').val(<?=$userData->id;?>);">Add task</span>
                                                    <?php endif; ?>
                                                    <?php if ($userData->id != 1): ?>
                                                    <span class="label label-danger actionLabel" data-toggle="modal" data-target="#deleteUserModal" 
                                                        onclick="jQuery('#deleteUserId').val(<?=$userData->id;?>);">Delete user</span>
                                                    <?php endif;?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="box-footer clearfix">
                                    <div class="pull-left">
                                        <button type="button" class="btn btn-block btn-success btn-xs" data-toggle="modal" data-target="#addNewUserModal">Add New User</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <footer class="main-footer"></footer>
        </div>

        <!-- Add new user modal -->
        <div class="modal fade" id="addNewUserModal" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Add new user modal</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="box-body">
                                
                                <div class="form-group">
                                    <label for="newUserLogin">User Login</label>
                                    <input type="text" class="form-control" id="newUserLogin" placeholder="User Login" autocomplete="off">
                                </div>
                                
                                <div class="form-group">
                                    <label for="newUserPassword">Password</label>
                                    <input type="password" class="form-control" id="newUserPassword" placeholder="Password" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label>User role</label>
                                    <select id="newUserRole" class="form-control">
                                        <option value="admin">Admin</option>
                                        <option value="manager">Manager</option>
                                    </select>
                                </div>

                                <!-- Alert messages -->
                                <div id="newUserModalErrorMessage" class="callout callout-danger">
                                    <h4>Ошибка !</h4>
                                    <p>Ошибка сохранения данных</p>
                                </div>
                                <!-- End Alert messages -->
                            </div>   
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="saveNewUserData();">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Add new user modal -->

        <!-- Add task modal -->
        <div class="modal fade" id="addTaskModal" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Add task modal</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            
                            <div class="box-body">
                            	 <div class="form-group">
                                    <label for="newTaskTitle">Title</label>
                                    <input type="text" class="form-control" placeholder="Task title" autocomplete="off" onkeyup="jQuery('#newTaskTitle').val(jQuery(this).val());">
                                </div>
                                <!-- Alert messages -->
                                <div id="newTaskModalErrorMessage" class="callout callout-danger">
                                    <h4>Ошибка !</h4>
                                    <p>Ошибка сохранения данных</p>
                                </div>
                                <!-- End Alert messages -->
                            </div>   
                        </form>

                        <form id="taskDropzoneForm" class="dropzone">
                            <input type="hidden" name="newTaskUserId" id="newTaskUserId" value="">
                            <input type="hidden" name="newTaskTitle" id="newTaskTitle" value="">
                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Add task modal -->

         <!-- Delete user confirmation modal -->
         <div class="modal fade" id="deleteUserModal" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <input type="hidden" id="deleteUserId" value="">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Delete user modal</h4>
                    </div>
                    <div class="modal-body">
                        <p>You are about to delete user data, this procedure is irreversible.</p>
                        <p>Do you want to proceed?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger btn-ok" onclick="deleteUserData();">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Delete user confirmation modal -->

        <!-- Alert messages -->
        <div id="errorMessage" class="callout callout-danger">
            <h4>I am a danger callout!</h4>
            <p>There is a problem that we need to fix. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
        </div>

        <div id="successMessage" class="callout callout-success">
            <h4>Успешное сохранение данных !</h4>
            <p>Данные успешно сохранены.</p>
        </div>
        <!-- End Alert messages -->

        <!-- Javascript -->
        <?= HTML::script('misc/js/jquery-latest.min.js'); ?>
        <?= HTML::script('misc/js/bootstrap.min.js'); ?>
        <?= HTML::script('misc/js/adminlte.min.js'); ?>
        <?= HTML::script('misc/js/dropzone.js'); ?>
        <?= HTML::script('misc/js/usersDashboard.js'); ?>

        <!-- END Javascript -->
    </body>
</html>