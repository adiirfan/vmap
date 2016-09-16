<!DOCTYPE html>
<?php
session_start();

if (isset($_SESSION['adminID'])) {
    header("location: ../admin-dashboard.php");
}
?>

<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>VMap Login Portal</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href ="assets/ico/apple-touch-icon-57-precomposed.png">

    </head>

    <body>

        <!-- Content -->
        <div class="top-content">

            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <a class="logo" href="index.html"></a>
                            <h1><strong>CloudDesk</strong> VMAP</h1>
                            <div class="description">
                                <p>
                               

                                </p>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm text-center">
                                    <a class="btn btn-link-1 launch-modal center-block" href="#" data-modal-id="modal-login">Login</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- LOGIN MODAL -->
        <div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-login-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h3 class="modal-title" id="modal-login-label">Log in</h3>

                    </div>

                    <div class="modal-body">

                        <form role="form" action="" method="post" class="registration-form">
                            <div class="alert alert-danger" role="alert" id="login-failed" style="display:none">Login Failed</div>
                            <div class="form-group">
                                <label class="sr-only" for="form-username1">Username</label>
                                <input type="text" name="form-username1" placeholder="Username..." class="form-username1 form-control" id="form-username1">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-password1">Password</label>
                                <input type="password" name="form-password1" placeholder="Password..." class="form-password1 form-control" id="form-password1">
                            </div>
                            <div class="form-group">
                            </div>

                            <button class="btn" id = "admin-login">Login</button>
                        </form>

                    </div>

                </div>
            </div>
        </div>



        <!-- Javascript -->
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>

        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>