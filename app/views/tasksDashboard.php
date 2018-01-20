<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="robots" content="noindex, nofollow">

        <!-- CSS -->
        <?= HTML::style('misc/plugins/bootstrap/dist/css/bootstrap.min.css'); ?>
        <?= HTML::style('misc/css/font-awesome.min.css'); ?>
        <?= HTML::style('misc/css/AdminLTE.css'); ?>
        <?= HTML::style('misc/css/_all-skins.css'); ?>
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
                        <li><a href="<?= URL::asset('/dashboard/tasks');?>"><i class="fa fa-book"></i> <span>Tasks</span></a></li>
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
                    <h1>Tasks section</h1>
                    <ol class="breadcrumb">
                        <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> Home</a></li>
                    </ol>
                </section>

                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Tasks</h3>
                                </div>
                                <div class="box-body no-padding">
                                    <table id="usersDataTable" class="table table-condensed">
                                        <tbody>
                                            <tr>
                                                <th style="width: 10%">#</th>
                                                <th style="width: 40%">Title</th>
                                                <th style="width: 30%"> File</th>
                                                <th style="width: 20%">Created</th>
                                            </tr>
                                            @foreach($tasksData as $task)
                                            <tr>
                                                <td>{{$task->id}}</td>
                                                <td>{{$task->title}}</td>
                                                <td><a title="Download task file..."  href="{{URL::to('/')}}/uploads/tasks/{{$task->file_name}}">{{URL::to('/')}}/uploads/tasks/{{$task->file_name}}</a></td>
                                                <td>{{\Carbon\Carbon::parse($task->created_at)->format('d.m.Y H:i')}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="box-footer clearfix">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <footer class="main-footer"></footer>
        </div>

        <!-- Javascript -->
        <?= HTML::script('misc/js/jquery-latest.min.js'); ?>
        <?= HTML::script('misc/js/bootstrap.min.js'); ?>
        <?= HTML::script('misc/js/adminlte.min.js'); ?>
        <!-- END Javascript -->
    </body>
</html>
