
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Admin | Log in</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="robots" content="noindex, nofollow">
        
        <?= HTML::style('misc/plugins/bootstrap/dist/css/bootstrap.min.css'); ?>
        <?= HTML::style('misc/css/font-awesome.min.css'); ?>
        <?= HTML::style('misc/css/AdminLTE.css'); ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>

    <body class="hold-transition login-page">
        <div class="login-box">
            
            <div class="login-logo">
                <a href="https://seiken.dp.ua/"><b>Login</b> TO DASHBOARD</a>
            </div>
            
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <?php echo Form::open(array('url' => '/login')); ?>
                    
                <div class="form-group has-feedback">
                        
                        <!--<input type="email" name="email" class="form-control" placeholder="Email" required autocomplete="off">-->
                        
                        <input type="text" name="userLogin" class="form-control" placeholder="Email" autocomplete="off" value="admin">

                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    
                    <div class="form-group has-feedback">
                        <!--<input type="password" name="password" class="form-control" placeholder="Password" required autocomplete="off">-->

                        <input type="text" name="userPassword" class="form-control" placeholder="Password"  autocomplete="off" value="admin">


                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    
                    <div class="row">
                       
                        <div class="col-xs-4">
                          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                        </div>
                    </div>

                <?php echo Form::close(); ?>

            </div>
        </div>

        <?= HTML::script('misc/js/jquery-latest.min.js'); ?>
        <?= HTML::script('misc/plugins/bootstrap/dist/js/bootstrap.min.js'); ?>

    </body>
</html>