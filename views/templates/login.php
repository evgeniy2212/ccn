<?php
ob_clean();
require_once 'home.php';
exit();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <!-- Core CSS - Include with every page -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/datepicker3.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">

    <!--Icons-->
    <script src="js/lumino.glyphs.js"></script>

</head>

<body>
<div class="row">
<nav class="navbar navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <?php /*<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button><?/**/?>
<!--            <a class="navbar-brand" href="/">-->
<!--                <img src="" alt="logo"/>-->
<!--            </a>-->
            <a class="navbar-brand" href="/">
                <img src="/assets/img/logo1.png" alt="logo" width="130"/>
            </a>

            <div class="hdr-brand">
                <p>Currency</p>
                <p>Control</p>
                <p>Network</p>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</nav>
</div>

    <div class="row login-block">
         <div class="col-md-6 col-md-offset-3 text-center logo-margin">
                <div class="login-panel panel panel-default center-block">
                    <div class="panel-heading center-block">
                        <h3 class="panel-title sign-up-head ">Sign in</h3>
                    </div>
                    <?php
                    if($_SESSION['status'] == 'new'){ ?>
                        <div class="alert bg-success green-panel" role="alert">
                            <svg class="glyph stroked checkmark">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-checkmark"></use>
                            </svg> Thank you for registration! Now you can login.
                            <a href="#" class="pull-right">
                            </a>
                        </div>
                    <?php } ?>
                    <div class="panel-body center-block">
                        <form method="POST" action="/login">
                            <fieldset class="login center-block">
                                <div class="form-group">
                                    <input class="form-control" placeholder="Login" name="login" type="text" maxlength="20" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" maxlength="20" value="">
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" class="login-form-label" type="checkbox" value="1">Remeber me
                                    </label>
                                    <div class="pull-right">
                                        <a href="/lost-pass" class="login-form-label">Forgot password?</a>
                                    </div>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <div class="row margin-left-1px">
                                <button class="btn btn-add font-25-px" type="submit">Sign in</button>
                                <a href="/signup" class="btn btn-sign-up font-25-px">Sign up</a>
                                </div>
                            </fieldset>
                        </form>
                        <br>
                    </div>
                </div>
         </div>
    </div>

<!-- Core Scripts - Include with every page -->
<script src="assets/plugins/jquery-1.10.2.js"></script>
<script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
<script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script>

</body>

</html>
