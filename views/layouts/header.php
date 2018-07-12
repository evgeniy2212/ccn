<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CCN-Systems</title>


    <link rel="stylesheet" href="/assets/css/font-awesome.css">
<!--    <script src="/assets/js/jquery1.12.4.min.js"></script>-->
    <link href="/assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/datepicker3.css" rel="stylesheet">

    <link href="/assets/css/jquery-ui-timepicker-addon.css" rel="stylesheet">
    <link href="/assets/css/styles.css" rel="stylesheet">

    <link rel="stylesheet" media="all" type="text/css" href="/assets/css/jquery-ui-1-11-0.css"/>
<!--    <link rel="stylesheet" media="all" type="text/css" href="/assets/css/jquery-ui.css"/>-->
    <link href="../../assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet"/>
   <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.css"/>-->
<!--    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>-->

    <link rel="stylesheet" type="text/css" href="/assets/css/datatables.min.css"/>
<!--    <script type="text/javascript" src="/assets/js/datatables.min.js"></script>-->

    <!--[if lt IE 9]>
    <script src="/assets/js/html5shiv.js"></script>
    <script src="/assets/js/respond.min.js"></script>
    <![endif]-->
    <script src="/assets/js/jquery-1.11.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>

    <script src="/assets/js/jquery-1.11.1.min.js"></script>

  <!--  <script src="/assets/js/jquery-1.12.4.js"></script>-->
    <script src="/assets/js/jquery1.12.4.min.js"></script>
    <script src="/assets/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/assets/js/jquery-1.11.1.min.js"></script>

    <script type="text/javascript" src="/assets/js/jquery-ui.min.js"></script>

    <script src="../../assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="../../assets/plugins/dataTables/dataTables.bootstrap.js"></script>


   <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
   <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->

<!--    <script src="/assets/js/bootstrap-datetimepicker.js"></script>-->
    <script src="/assets/js/jquery-ui-timepicker-addon.js"></script>
</head>

<body>


<div class="row">
    <nav class="navbar navbar-fixed-top" role="navigation">

        <div class="container-head">
            <div class="navbar-header">
                <? /*<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button><?/**/ ?>

                <a class="navbar-brand" href="/">
                    <img src="/assets/flex_files/logo33.png" alt="logo" width="130"/>
                </a>
                <div class="hdr-brand">
                    <p>Currency</p>
                    <p>Control</p>
                    <p>Network</p>
                </div>

                <ul class="user-menu">
                    <li class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!--                        <img src="/assets/img/user-icon.png" alt="message" height="35" width="35">-->
                            <?php echo ucfirst($_SESSION['login']); ?>
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">
                                    <svg class="glyph stroked male-user">
                                        <use xlink:href="#stroked-male-user"></use>
                                    </svg>
                                    Profile</a></li>
                            <li><a href="/logout">
                                    <svg class="glyph stroked cancel">
                                        <use xlink:href="#stroked-cancel"></use>
                                    </svg>
                                    Logout</a></li>
                        </ul>
                        <!--                </li>-->
                </ul>
            </div>


        </div><!-- /.container-fluid -->
    </nav>
</div>

<div id="sidebar-collapse" class="col-sm-2 col-lg-2 sidebar">
    <ul class="nav nav-margin-top menu">
        <li class="big-nav-item">ALL CATEGORIES</li>
        <li><a href="/" class="<?php if ($_GET['request'] == ""
                or substr($_GET['request'], 0, 16) == "edit/thermometer"
                or substr($_GET['request'], 0, 10) == "statistics"
            ) {
                echo "nav-item-selected";
            } ?> nav-item">
                Database</a></li>
        </br>
        <li class="big-nav-item">FOLDERS</li>
        <li><a href="/criminal" class="<?php if ($_GET['request'] == "criminal") {
                echo "nav-item-selected";
            } ?> nav-item">
                Criminal</a></li>
        <li><a href="/incoming" class="<?php if ($_GET['request'] == "incoming") {
                echo "nav-item-selected";
            } ?> nav-item">
                Incoming</a></li>
        <li><a href="/temporary" class="<?php if ($_GET['request'] == "temporary") {
                echo "nav-item-selected";
            } ?> nav-item">
                Temporary</a></li>
        <li><a href="/criminal-incoming" class="<?php if ($_GET['request'] == "criminal-incoming") {
                echo "nav-item-selected";
            } ?> nav-item">
                Criminal incoming</a></li>
        <li class="big-nav-item">PROCESSING</li>

        <li><a href="/12-hours-folder" class="<?php if ($_GET['request'] == "12-hours-folder") {
                echo "nav-item-selected";
            } ?> nav-item">
                12 hours folder</a></li>

        <li class="big-nav-item">MEDIA</li>
        <li><a href="/videos" class="<?php
            if ($_GET['request'] == "videos") {
                echo "nav-item-selected";
            } ?> nav-item">
                Videos</a></li>
        <li class="big-nav-item">ACTIONS</li>
        <? /**/ ?>
        <a href="/press-alarm/<?php echo $_SESSION['device_id'] ?>"
           class="btn btn-alarm" type="submit">
            SEND <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
        <a href="/press-back-alarm/<?php echo $_SESSION['device_id']; ?>"
           class="btn btn-temporary" type="submit">
            RETURN <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        <a href="/undo-last-10hours/<?php echo $_SESSION['device_id']; ?>"
           class="btn btn-undo" type="submit">
            TEST_PROCESSING <i class="fa fa-arrows-h" aria-hidden="true"></i></a>

    </ul>
</div><!--/.sidebar-->
<div class="col-sm-10 col-sm-offset-2 col-lg-10 col-lg-offset-2 main">

<script>

</script>

