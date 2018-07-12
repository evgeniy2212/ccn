<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>ccn-systems.com</title>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="icon" href="/assets/flex_files/logo31.png">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script>
        $(function () {
            $('#tabs').tabs({active: 1});

            function signIn() {
                emptyContent();
                $('#container').empty().append(
                    $('<div/>', {class: 'title'}).append(
                        $('<h1/>').text('Welcome')
                    ),
                    $('<form/>', {class: 'form', id: 'login-form'}).append(
                        $('<div/>', {class: 'form-rec'}).append(
                            $('<label/>', {class: 'form-label'}).text('Plase enter User ID'),
                            $('<input/>', {class: 'form-input', name: 'login'}),
                            $('<a/>', {class: 'form-label2', href: '#'}).text('Forgot your User ID?')
                        ),
                        $('<div/>', {class: 'form-rec'}).append(
                            $('<label/>', {class: 'form-label'}).text('Plase enter your Password'),
                            $('<input/>', {class: 'form-input', name: 'password', type: 'password'}),
                            $('<a/>', {class: 'form-label2', href: '#'}).text('Forgot you your Password?')
                        ),
                        $('<div/>', {class: 'form-buttons'}).append(
                            $('<button/>', {id: 'fb-sign-in', class: 'form-button'}).text('Sign In'),
                            $('<button/>', {id: 'fb-cancel', class: 'form-button form-button-r'}).text('Cancel'),
                            $('<button/>', {id: 'fb-sign-in-remember', class: 'form-button'}).append(
                                'Sign In',
                                $('<p/>', {class: 'font1'}).append('and remember my ID')
                            )
                            //and remember my ID
                        )
                    )
                );
            }

            function startPage() {
                $('#container-wrap').removeClass('activ');
                $('#tabs').show();
            }

            function emptyContent() {
                $('#tabs').hide();
                $('#container-wrap').addClass('activ');
                $('#container').removeClass().empty();
            }

            $('body').on('click',
                '#btn-signin' +
                ',#edit-account' +
                ',#close-account',
                signIn
            );
            //$('body').on('click', '#close-account', startPage);

            //todo btn-sign-out
            $('body').on('click', '#btn-sign-out', function () {
                $.ajax({
                    type: "GET",
                    url: "/logout",
                    //dataType: "script",
                    success: function (msg) {
                        emptyContent();
                        $('#container').empty().append(
                            //$('<button/>', {id: 'fb-database', class: 'form-button'}).text('Database')
                            $('<div/>', {class: 'title'}).append(
                                $('<h1/>').text('Sign out successful')
                            ),
                            $('<div/>').append(
                                $('<p/>').text('Thank you for choosing Currency Control Network.'),
                                $('<p/>').text('We appreciate your business and look forward to serving you in the future.')
                            ),
                            $('<div/>').append(
                                $('<button/>', {class: 'form-button btn-form-cancel'}).text('Cancel')
                            )
                        );
                    },
                    error: function (msg) {
                        alert('Logout error');
                    }
                });
                //startPage();
            });
            //todo open-account
            $('body').on('click', '#open-account', function () {
                emptyContent();
                $('#container').addClass('select-plan').append(
                    //$('<button/>', {id: 'fb-database', class: 'form-button'}).text('Database')
                    $('<div/>', {class: 'title'}).append(
                        $('<h1/>').text('Welcome')
                    ),
                    $('<div/>').append(
                        $('<h3/>').text('Select:')
                    ),
                    $('<div/>').append($('<button/>', {class: 'plan-button'}).text('Buisness')),
                    $('<div/>').append($('<button/>', {class: 'plan-button'}).text('Individual')),
                    $('<div/>').append($('<button/>', {class: 'plan-button'}).text('Department')),
                    $('<div/>').append($('<button/>', {class: 'form-button btn-form-cancel'}).text('Cancel'))
                );
            });

            $('body').on('click', '#fb-sign-in, #fb-sign-in-remember', function (e) {
                //emptyContent();
                e.preventDefault();
                var data = $('#login-form').serialize(); //login
                console.log(data);
                $.ajax({
                    type: "POST",
                    data: data,
                    url: "/login",
                    //dataType: "script",
                    success: function (msg) {
                        //if (msg == '') {
                        emptyContent();
                        $('#container').empty().addClass('container-text').append(
                            $('<button/>', {id: 'fb-database', class: 'form-button'}).text('Database')
                        );
                        //}
                    },
                    error: function (msg) {
                        alert('Login or password incorrect');
                    }
                });
            });
            $('body').on('click', '#fb-cancel', function (e) {
                e.preventDefault();
                startPage();
            });
            /*$('body').on('click', '#fb-sign-in-remember', function () {
             emptyContent();
             $('#container').empty().append(
             $('<button/>', {id: 'fb-database', class: 'form-button'}).text('Database')
             );
             });/**/

            $('body').on('click', '.btns .btn', function () {
                //emptyContent();
                startPage();
                $('#tabs').tabs({active: 0});
                $('#tabs-0').empty().append(
                    $('<div/>', {class: 'message'}).append(
                        $('<p/>', {class: 'msg'}).append(
                            'We are sorry, at this time this part of the website is under maintenance.'
                        )
                    )
                );
            });
            $('body').on('click', '#container .message', function () {
                startPage();
            });
            $('body').on('click', '.btn-form-cancel', function () {
                startPage();
            });
            /*$('body').on('click', '.plan-button', function () {
             startPage();
             });/**/

            $('body').on('click', '.btn-content', function () {
                startPage();
                showContent($(this).html());
            });
            $('body').on('click', '#fb-database', function () {
                //window.location.assign('//ccn-systems.com');
                window.open('//ccn-systems.com', '_blank');
            });
            /**/

            function showContent(dataName) {
                $.ajax({
                    type: "POST",
                    data: {data_name: dataName},
                    url: "/test/getContent.php",
                    //dataType: "script",
                    success: function (msg) {
                        /*
                        emptyContent();
                        $('#container').addClass('container-text').append(
                            $('<div/>').append(msg)
                        );
                        /**/

                        $('#tabs').tabs({active: 0});
                        $('#tabs-0').empty().append(
                            $('<div/>').addClass('container-text').append(
                                $('<div/>').append(msg)
                            )
                        );
                    }
                });
            }
        });
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
            min-width: 1000px;
            font-size: 14px;
            font: 14px/20px Times;
        }

        /*		.bg{
                    display: block;
                    position:fixed;
                    left:0;
                    right:0;
                    top:0;
                    bottom:0;
                    background: url(flex_files/bg.png) center center no-repeat;
                    background-size: cover;
                    //background-size: auto auto;
                    background-position: center 0;
                    //background-origin: content-box;
                    box-sizing: border-box;
                    z-index: -1;
                }/**/
        .bg {
            background: url(/assets/flex_files/bg.jpg) center center no-repeat;
            background-size: 2000px;
            background-position: center -110px;

            background: url('/assets/flex_files/bg.jpg') no-repeat scroll center -110px / 2000px auto transparent;
            width: 100%;
            z-index: -1;
            position: fixed;
            height: 100%;
        }

        .wrapper {
            display: flex;
            flex-direction: column;
            width: 100%;
            min-width: 900px;
            height: 100%;
            padding: 0.5em 5em 0 5em;
            margin: 0 auto;
            /*font: 14px/20px Arial, sans-serif;/**/
            font: 14px/20px Times;
            box-sizing: border-box;
        }

        .content {
            flex: 1 0 auto;
            display: flex;
            flex-direction: row;
            box-sizing: border-box;
        }

        /*h1 {
            padding: 40px 20px 30px;
            font: 26px/1.3 Arial, sans-serif;
            text-align: center;
        }/**/

        p {
            padding: 0px 0px 10px 0px;
        }

        #cntct p {
            padding: 0px 0px 0px 0px;
        }

        #cntct input, #cntct textarea {
            padding: 0.1em 0.2em;
        }

        a {
            /*color: #3498DB;/**/
            color: #0c0c0c;
            outline: none;
        }

        .header-wrap {
            flex: 0 0 auto;
            border: 2px #2e7684 solid;
            padding: 1em 1em;
            background: rgb(174, 197, 215);
        }

        .header {
            flex: 0 0 auto;
            border: 2px #2e7684 solid;
            height: 11em;
            background: rgba(255, 255, 255, 1);
            /*box-sizing: border-box;/**/
            display: flex;
            flex-direction: row;
            padding: 0.5em;
            box-sizing: border-box;
            box-shadow: 0 0 1em #89afd8, 0 0 1em #89afd8;
        }

        .header > * {
            background: rgba(255, 255, 255, 0.8);
        }

        .footer {
            flex: 0 0 auto;
            height: 2em;
            text-align: center;
        }

        .bnr {
            display: block;
            flex: 0 0 auto;
            height: 10em;
            background: url(/assets/flex_files/shutterstock.jpg) center center no-repeat;
            background-size: 80em 100%;
            margin: 1em 0em;
        }

        .logo {
            flex: 0 0 auto;
            height: 100%;
            margin-left: 1em;
        }

        .branding {
            font-family: Times;
            font-size: 2.5em;
            color: #FFFFFF;
            text-shadow: -0 -1px 2px #38649e,
            0 -1px 2px #38649e,
            -0 1px 2px #38649e,
            0 1px 2px #38649e,
            -1px -0 2px #38649e,
            1px -0 2px #38649e,
            -1px 0 2px #38649e,
            1px 0 2px #38649e,
            -1px -1px 2px #38649e,
            1px -1px 2px #38649e,
            -1px 1px 2px #38649e,
            1px 1px 2px #38649e,
            -1px -1px 2px #38649e,
            1px -1px 2px #38649e,
            -1px 1px 2px #38649e,
            1px 1px 2px #38649e;

            margin-left: 1em;
            margin-top: 0.2em;
        }

        .branding > * {
            margin: 0.4em;
            padding: auto;
        }

        .branding > *:nth-child(2) {
            margin-left: 3.5em;
        }

        .branding > *:nth-child(3) {
            margin-left: 6.2em;
        }

        .header-center {
            flex: 1 0 auto;
            height: 100%;
        }

        .header-buttons {
            flex: 0 0 12em;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .header-buttons button.btn {
            width: auto;
            background: #729fcf;
            border: 1px #4d93b9 solid;
            border-radius: 5px;
            flex: 1 0 auto;
            margin: 0.1em;
            color: #2d5b71;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0px 0px 12px #FFFFFF;

            /*display: inline-block;/**/
            /*font-size: 24px;
            /*font-weight: bold;/**/
            /*color: rgba(255,255,255,.6);
            /*text-shadow: 1px 1px rgba(0,0,0,.3);
            text-decoration: none;
            /*padding: 20px;/**/
            border-radius: 5px;
            background: rgb(101, 157, 214);

            /*box-shadow:
            inset 0 0 2px 1px rgba(0, 0, 0, 0.66),
            inset rgba(0,0,0,.3) -5px -5px 8px 5px,
            inset rgba(255,255,255,.5) 5px 5px 8px 5px/*,
            1px 1px 1px rgba(255,255,255,.1),
            -2px -2px 5px rgba(0,0,0,.5)/**/;
            box-shadow: 0px 0px 2px 1px rgba(255, 255, 255, 0.66) inset, 0px -1px 2px 1px #00367B inset, 3px 4px 9px 0px #FFF inset;
            transition: .2s;

        }

        .header-buttons button.btn:hover {
            background: #7eb0e6;
        }

        .left, .right {
            flex: 0 1 20em;
        }

        .center {
            display: flex;
            flex: 1 2 60em;
            flex-direction: column;
            margin: 0.2em;
        }
        .center>* {
            flex: 0 0 auto;
        }

        .center #tabs {
            border: 3px #4281a4 solid;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0px 0px 12px #FFFFFF;
            min-height: 29em;
            overflow: hidden;
        }

        .btns {
            display: flex;
            flex-direction: column;
            height: 30em;
        }

        div.left > div > button, div.right > div > button {
            width: auto;
            background: rgba(189, 254, 235, 0.8);
            border: 3px #4281a4 solid;
            border-radius: 4px;
            /*flex: 1 0 auto;/**/
            flex: 0 1 5em;
            margin: 0.2em;
            color: #000;
            cursor: pointer;
            box-shadow: 0px 0px 12px #FFFFFF;
        }

        .ft {
            flex: 30 0 auto;
            display: flex;
            flex-direction: row;
            padding: 0.7em 25% 2em 25%;
            /*justify-content: space-around;
            align-content: space-between;/**/
        }

        .ft button {
            width: auto;
            background: rgba(189, 254, 235, 0.8);
            border: 3px #4281a4 solid;
            border-radius: 3px;
            flex: 1 0 auto;
            margin: 0.2em;
            color: #000;
            cursor: pointer;
            box-shadow: 0px 0px 12px #FFFFFF;
            padding: 0.2em 0;
            height: 2.2em;

        }

        .btn {
            font-size: 14px;
            padding: 0em 0.5em;
        }

        .tab-border {
            border: 2px #2e7684 solid !important;
            margin: 0.7em;
            overflow: hidden;
        }

        .ui-tabs-panel {
            border: 2px #2e7684 solid !important;
            margin: 0.5em;
            box-sizing: border-box;
            box-shadow: 0 0 0.5em #89afd8, 0 0 1em #89afd8, 0 0 1em #89afd8, 0 0 1em #89afd8;
            background: #FFFFFF !important;
            min-height: 24em !important;
            max-height: 24em !important; /**/
            /*min-height: 230px;
            max-height: 18em !important;/**/
            overflow-y: auto !important;
        }

        .ui-tabs .ui-tabs-nav {
            padding: 0 !important;
        }

        .ui-tabs {
            padding: 0 !important;
        }

        /*.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active {
            /*border: 1px solid #C5C5C5;/**/
        /*background: none repeat scroll 0% 0% #cde1f7 !important;
        /*font-weight: normal;
        color: #454545;/**/
        /*}/**/
        .ui-tabs-active, ui-state-active {

        }

        .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover {
            border: 0px !important;
        }

        .ui-widget-header .ui-state-default {
            border-right: 2px solid #4382a5 !important;
            border-left: 0px !important;

        }

        /*.ui-widget-header .ui-state-default:first-child{
            border-left: 0px !important;
        }/**/
        .ui-widget-header .ui-state-default:last-child {
            border-right: 0px !important;
        }

        .ui-widget-content .ui-tab {
            background: none repeat scroll 0% 0% #e2f3ff !important;
            border-bottom: 2px solid #4382a5 !important;
        }

        .ui-widget-content .ui-tabs-active {
            background: none repeat scroll 0% 0% rgba(255, 255, 255, 1) !important;
            border-bottom: 0px !important;
        }

        .ui-tabs .ui-tabs-nav li {
            margin: 0px 0 0px 0px !important;
        }

        .ui-corner-all, .ui-corner-top, .ui-corner-right, .ui-corner-tr {
            border-radius: 0px !important;
        }

        /*        .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover {
                border: 0px solid #003EFF!important;
                background: none repeat scroll 0% 0% rgba(255, 255, 255, 1);
                /*font-weight: normal;/**/
        /*        }/**/

        .ui-tabs .ui-tabs-nav .ui-tabs-anchor {
            box-sizing: border-box !important;
            width: 100% !important;
            text-align: center !important;
            font-weight: bold;
        }

        .ui-state-active a:link {
            color: #000000 !important;
            text-decoration: none;
        }

        .ui-widget-header {
            border: 0px solid #DDD;
            background: none repeat scroll 0% 0% #427e91 !important;
        }

        .ui-tabs .ui-tabs-nav {
            display: flex !important;
        }

        .ui-tabs .ui-tabs-nav li {
            flex: 1 0 auto !important;
        }

        #container-wrap {
            display: none;
            flex-direction: column;
            width: 100%;
            height: 100%;
            min-height: 5em;
            padding: 0.5em 5em 0 5em;
            margin: 0 auto;
            /*font: 14px/20px Arial, sans-serif;/**/
            font: 14px/20px Times;
            box-sizing: border-box;

            flex-direction: row;
            padding: 0.5em;
            border: 2px #2e7684 solid;

        }

        #container-wrap.activ {
            display: flex;
            z-index: 10;
        }

        #container {
            display: flex;
            flex-direction: column; /**/
            width: 100%;
            height: 100%;
            padding: 0.5em 5em 0 5em;
            margin: 0 auto;
            /*font: 14px/20px Arial, sans-serif;/**/
            font: 14px/20px Times;
            box-sizing: border-box;

            background: rgba(255, 255, 255, 1);
            /*flex-direction: row;/**/
            padding: 3em 0.5em 5em 0.5em;
            border: 2px #2e7684 solid;
            box-shadow: 0 0 1em #89afd8, 0 0 1em #89afd8;
            min-height: 20em;
            text-align: center;

            /*align-items: center;/**/
            justify-content: space-around;

        }

        #container > * {
            flex: 0 0 auto;
            vertical-align: middle;
            /*width: 100%;
            box-sizing: border-box;/**/
        }

        #container .title {
            flex: 0 0 auto;
            background: linear-gradient(#9BC3FF, rgba(62, 125, 195, 1), rgba(85, 137, 195, 1), #00499B, #A1CDFF) repeat scroll 0% 0% transparent;
            /*font-size: 1.7em;/**/
            text-align: center;
            margin: 1.5em;
        }

        #container .title h1 {
            color: #000;
            background: #fff;
            mix-blend-mode: lighten;

            text-shadow: 0px 1px 1px #38649E;
        }

        #container .form {
            display: flex;
            flex-direction: column;
        }

        #container .form .form-rec {
            display: flex;
            flex-direction: row;
            margin: 0.5em;
        }

        #container .form .form-rec > * {
            flex: 0 1 auto;
        }

        #container .form .form-rec > *:nth-child(1) {
            flex: 0 0 auto;
            padding-right: 1em;
            text-align: end;
            width: 31%;
        }

        #container .form .form-rec > *:nth-child(3) {
            flex: 0 0 auto;
            padding-left: 1em;
            text-align: start;
            width: 31%;
        }

        .form-input {
            width: 33%;
            border: 1px dashed #9fc3e9;
            box-shadow: 0px 0px 0.4em 5px rgba(175, 199, 236, 1);
        }

        #container .form .form-rec > *:nth-child(3) {
            flex: 0 0 auto;
            padding-left: 1em;
            width: 33%;
        }

        .form-buttons {
            display: flex;
            flex-direction: row;
            margin: 1.5em 4em 0.5em 4em;
        }

        .form-buttons > * {
            margin: 1em;
            flex: 1 0 auto;
            width: 20%;
        }

        .form-button {
            margin: 1em;
            border: 1px solid #647486;
            background: none repeat scroll 0% 0% #c6d8e9;
            box-shadow: 0px 0px 0.2em 0.3em rgba(143, 197, 255, 1);
            border-radius: 4px;
            font-weight: bold;
            padding: 0.2em 1em;
            cursor: pointer;
        }

        .form-button.form-button-r {
            background: none repeat scroll 0% 0% #ecc7c6;
        }

        .plan-button {
            background-color: #c7d8eb;
            color: #000000;
            flex: 0 0 2.5em;
            width: 25em;
            font-weight: bold;
            border: 0;
            margin: 0.3em;
            height: 2.5em;
            cursor: pointer;
            border: 1px dotted #006dcc;
        }

        .btn-form-cancel {
            background-color: #ffffff;
            width: 15em;
            font-weight: bold;
        }

        .font1 {
            font-size: 0.7em;
            margin: 0;
            padding: 0;
        }

        .message {
            border: 1px solid #647486;
            border-radius: 3px;
            text-align: center;
            margin: 6.5em 5%;
            padding: 0.25em;
            overflow: hidden;
        }
        .msg {
            border: 1px solid #2e7684;
            box-shadow: 0 0 0.5em #89afd8, 0 0 1em #89afd8, 0 0 1em #89afd8, 0 0 1em #89afd8;
            padding: 2em;
        }

        #container.container-text {
            display: block;
            padding: 2em;
            text-align: justify;
            /*overflow: auto;
            max-height: 15em;/**/
        }
        /*font-weight: bold;/**/

        @media screen and (min-width: 2000px) {
            .bg {
                background-size: 100% auto;
                background-position-y: -200px;
            }
        }
    </style>
</head>

<body>
<div class="bg"></div>
<div class="wrapper">
    <div class="header-wrap">
        <div class="header">
            <a href="/" class="logo"><img src="/assets/flex_files/logo33.png" class="logo"></a>

            <div class="header-center">
                <div class="branding">
                    <p>Currency</p>

                    <p>Control</p>

                    <p>Network</p>
                </div>
            </div>
            <div class="header-buttons">
                <button class="btn" id="btn-signin">Sign In</button>
                <button class="btn" id="btn-sign-out">Sign Out</button>
                <button class="btn" id="open-account">Open Account</button>
                <button class="btn" id="edit-account">Edit Account</button>
                <button class="btn" id="close-account">Close Account</button>
            </div>
        </div>
    </div>

    <div class="bnr"></div>

    <div class="content">

        <div class="left">
            <div class="btns">
                <button class="btn">How does the Currency Control Network work</button>
                <button class="btn">How to do an emergency process on your device</button>
                <button class="btn">How to do an emergency process on your computer</button>
                <button class="btn">How to return sent serial numbers on your device</button>
                <button class="btn">How to return sent serial numbers on your computer</button>
                <button class="btn">How to use cell phone for scanning</button>
                <button class="btn">How to work cell phone into CCN</button>
            </div>
        </div>

        <div class="center">
            <div id="container-wrap">
                <div id="container">

                </div>
            </div>

            <div id="tabs">
                <ul>
                    <li style="display: none"><a href="#tabs-0">Careers</a></li>
                    <li><a href="#tabs-1">Home</a></li>
                    <li><a href="#tabs-2">About Us</a></li>
                    <li><a href="#tabs-3">Service</a></li>
                    <li><a href="#tabs-4">Products</a></li>
                    <li><a href="#tabs-5">Partnership</a></li>
                    <li><a href="#tabs-6">Careers</a></li>
                </ul>
                <div class="tab-border">
                    <div id="tabs-0">
                    </div>
                    <div id="tabs-1">
                        <p>Welcome to the Currency Control Network (CCN) website. On our website, you will find full and
                            detailed information regarding the functionality and use of the Currency Control Network
                            System.
                            <br>
                            <br>
                            Our company’s mission is to reduce the risks of criminal actions against businesses and
                            ordinary people who use cash bills. We are the only company representing this type of
                            patented service throughout the United States. We are proud that our company’s activities
                            are aimed at minimizing crimes that cause people to suffer theft, injuries, and sometimes
                            even the loss of life. We believe that our country should enjoy only joy and happiness, not
                            grief and suffering.
                            <br>
                            <br>
                            If you believe that the activities of our company may be useful to you, we would be happy to
                            cooperate with you.
                            <br>
                            <br>
                            On the left and right you will find detailed, step-by-step instructions for opening and
                            using your account. These presentations will make using our system and our special equipment
                            as simple as possible.</p>


                    </div>
                    <div id="tabs-2">
                        Our company exists to reduce crimes associated with cash. Our system scans and temporarily
                        stores the serial numbers of our clients’ banknotes and, in the case of theft, sends serial
                        numbers of stolen banknotes to a computer database.
                        <br>
                        <br>
                        The centralized computer system will inform us immediately in the event of an attempt to use
                        banknotes with a criminal past. In addition, our system provides video and audio record that
                        will be very useful for police departments when investigating crimes. Police departments will
                        have the opportunity to re-activate banknotes after receiving the necessary information from the
                        rightful owner (except, of course, in the case of fraudulent banknotes).
                        <br>
                        <br>
                        We are always working to ensure that users feel comfortable using our system.
                        Particular attention is paid to the security of both the system and the personal information of
                        our customers.
                        <br>
                        <br>
                        Our activities will reduce such crimes as robbery, illegal production of banknotes, kidnapping
                        of adults and children for ransom, and other crimes connected with cash bills.

                    </div>
                    <div id="tabs-3">
                        “CCN” serves all types of customers who want our service throughout the United States. Our
                        clients include every different type of company, and all of them are united by the fact that
                        they use cash banknotes in their daily activities.
                        <br>
                        <br>
                        Whether you receive cash in the office or on the go, our services will help you ensure that
                        every banknote you accept is safe and legitimate. Simply by scanning your bills with a
                        stationary scanner or a mobile device, you can upload and cross-reference serial numbers in our
                        database in a matter of seconds.
                        <br>
                        <br>
                        In the event that your business’ cash gets stolen, the serial numbers of the stolen banknotes
                        will be flagged in our system. The next time they are scanned at another business or a bank, our
                        centralized scanning system will alert local authorities, ensuring that criminals are punished
                        according to the law.
                        <br>
                        <br>
                        For the functioning of our system, we use only the newest computer devices, and of course, we
                        constantly
                        update the software.
                    </div>
                    <div id="tabs-4">
                        All companies that wish to be connected to our system need to have the following equipment:
                        <br>
                        <br>
                        Computer
                        The computer can be used to connect a local scanner (or scanners) from a central computer
                        system. Companies can use existing computers instead of buying new ones, and they will be free
                        to install our program seamlessly onto their system. Banks will need to purchase new computers,
                        so that our system does not have connection with the bank's network. This is very important for
                        the security of the banking system. The cost of the computer that will be installed for our
                        customers will be $180.
                        <br>
                        <br>
                        Scanner Device
                        We offer several types of scanning devices, which differ in functionality. We offer:
                        <br>
                        <ul>
                            <li style="margin-left: 20px">The simplest devices with all necessary functions. Such
                                devices include the Multi-Functional
                                Process Device-10 (MFPD-10) for $145 per unit.
                            </li>
                            <li style="margin-left: 20px">More sophisticated devices with additional sensors to check
                                for the authenticity of banknotes.
                                Such devices include the FT-700M for $1,400 per unit.
                            </li>
                            <li style="margin-left: 20px">A wireless device. This device is not required for all our
                                users. Companies that intend to use
                                only one scanner may not need to purchase this device. They can use the cable connection
                                to the
                                computer. For companies that intend to use 2-6 scanning devices, we offer a wireless
                                device at
                                $170 per unit. For companies that intend to use 7 or more scanning devices, we offer a
                                device at
                                $390.00 per unit. The advanced unit (7+) will have a longer range to support more
                                devices.
                            </li>
                        </ul>
                        <br>
                        Installation
                        There are three options for installing all the necessary equipment for connection to the central
                        server system:
                        <br>
                        <ul>
                            <li style="margin-left: 20px">
                                Our technicians can handle all the equipment installation work. The cost of work in this
                                case
                                will be calculated depending on the number of scanning devices:  
                                1-6 scanners $160.00
                                7-13 scanners $250.00
                                14-25 scanners $420.00  
                                26-40 scanners $700.00
                            </li>
                            <li style="margin-left: 20px">
                                You can use services of any other company that offers this type of service.
                            </li>
                            <li style="margin-left: 20px">
                                You can install the equipment yourself. On our website, you will find detailed
                                step-by-step
                                information on how to install all necessary equipment. We have simplified the
                                installation
                                process so that any of our users can install the necessary equipment. This is especially
                                true
                                for those of our customers who plan to use only 1 or 2 scanning devices.
                            </li>
                        </ul>

                    </div>
                    <div id="tabs-5">
                        We are interested in partnering with any foreign companies that wish to create this kind of
                        business in their state, on any continent. After the creation of the joint company, we will
                        share everything that we have been developing for a long time – our knowledge, experience,
                        structure, and software. In addition, we can assist our partners who cooperate with us in the
                        production of the necessary special equipment. From there, our partners only need to cover all
                        financial expenses for building the business.
                        <br>
                        <br>
                        This proposal involves not only providing our partners with all the developments that we have
                        achieved, but also cooperating with them to create a unified system across all developed
                        countries. All the municipal systems of countries will be linked to each other for more
                        effective activities. In the modern world, everything is interconnected; banknotes of one state
                        can be used in the banking system of another state, and in this situation it is very important
                        to have an interconnected control system.
                        <br>
                        <br>
                        Regarding business proposals, please contact:
                        <br>
                        business@ccn-systems.com
                    </div>
                    <div id="tabs-6">
                        <div class="message">
                            <p class="msg">We are very sorry that we don’t have any open positions at this time.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="right">
            <div class="btns">
                <button class="btn">How to open an account</button>
                <button class="btn">How to edit an account</button>
                <button class="btn">How to close an account</button>
                <button class="btn">How to install a new device</button>
                <button class="btn">How to install multiple new devices</button>
                <button class="btn">How to replace devices</button>
                <button class="btn">Frequently asked questions</button>
            </div>
        </div>

    </div>

    <div class="ft">
        <button class="btn btn-content">Privacy Policy</button>
        <button class="btn btn-content">Contact</button>
        <button class="btn btn-content">Terms of Service</button>
    </div>

    <!-- .content -->

    <div class="footer">Copyright 2017 CCN</div>

</div>
<!-- .wrapper -->
</body>
</html>