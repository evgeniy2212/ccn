<div class="col-md-4 col-md-offset-4 text-center logo-margin ">
    <img src="assets/img/logo.png" alt=""/>
</div>
<div class="row">
    <!--  page header -->
    <div class="col-lg-12">
        <h1 class="page-header"></h1>
    </div>
    <!-- end  page header -->
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default data-block">
            <div class="panel-heading">
                <a href="/" class="btn btn-xs btn-default">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <b>Sign Up</b>
            </div>
            <div class="panel-body">
                <form role="form" name="signUp" id="signUp" method="POST" action="/registration">
                    <h6><i>* - required fields</i></h6>
                    <div class="form-group">
                        <label>Login*</label>
                        <input name="login" id="login" class="form-control" placeholder="">
                    </div>
                    <div>
                        <p id="errlogin"></p>
                    </div>
                    <div class="form-group">
                        <label>Password*</label>
                        <input name="password" id="password" type="password" class="form-control">
                    </div>
                    <div>
                        <p id="errpass"></p>
                    </div>
                    <div class="form-group">
                        <label>Repeat password*</label>
                        <input name="repeat-password" id="repeat-password" type="password" class="form-control">
                    </div>
                    <div>
                        <p id="errpassr"></p>
                    </div>
                    <div class="form-group">
                        <label>E-mail*</label>
                        <input name="email" id="email" class="form-control" placeholder="">
                    </div>
                    <div>
                        <p id="erremail"></p>
                    </div>
                    <div class="alert bg-primary" role="alert">
                        <svg class="glyph stroked empty-message">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-empty-message">
                            </use>
                        </svg> You can find your Hub ID and License key on the local web-interface
                    </div>
                    <div class="form-group">
                        <label>Hub ID*</label>
                        <input name="hub-id" id="hub-id" class="form-control" placeholder="">
                    </div>
                    <div>
                        <p id="errhubid"></p>
                    </div>
                    <div class="form-group">
                        <label>License key*</label>
                        <input name="license-key" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input name="phone" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>First Name</label>
                        <input name="firstname" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input name="lastname" class="form-control" placeholder="">
                    </div>
                    <a onclick="valid()" class="btn btn-add center-block" name="signUp" id="signUp">Sign up</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>// Wait for the DOM to be ready
    function valid() {
        var login = document.getElementById('login');
        var password = document.getElementById('password');
        var repeatPassword = document.getElementById('repeat-password');
        var email = document.getElementById('email');
        var hubId = document.getElementById('hub-id');
        var errlogin = document.getElementById('errlogin');
        var errpass = document.getElementById('errpass');
        var errpassr = document.getElementById('errpassr');
        var erremail = document.getElementById('erremail');
        var errhubid = document.getElementById('errhubid');
        var errCount = 0;


        //validate email
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (email.value == '' || !re.test(email.value))
        {
            if (erremail.textContent == '') {
                erremail.insertAdjacentHTML('afterbegin', '<p><div class=\"alert bg-danger\" ' +
                    'role=\"alert\"><svg class="glyph stroked cancel">' +
                    '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-cancel">' +
                    '</use>' +
                    '</svg>Please enter a valid email address. </div>' +
                    '</p>');
            }
            errCount++;
        }else
        if (erremail.textContent != '') {
            erremail.innerHTML = "";
        }



        //validate login
        if (login.value.length < 5) {
            if (errlogin.textContent == '') {
                errlogin.insertAdjacentHTML('afterbegin', '<p><div class=\"alert bg-danger\" ' +
                    'role=\"alert\"><svg class="glyph stroked cancel">' +
                    '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-cancel">' +
                    '</use>' +
                    '</svg>Login must be at least 5 letters long </div>' +
                    '</p>');
            }
            errCount++;
        }else
            if (errlogin.textContent != '') {
                errlogin.innerHTML = "";
            }

        //validate password
        if (password.value.length < 5 || password.value.length === 0) {
            if (errpass.textContent == '') {
                errpass.insertAdjacentHTML('afterbegin', '<p><div class=\"alert bg-danger\" ' +
                    'role=\"alert\"><svg class="glyph stroked cancel">' +
                    '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-cancel">' +
                    '</use>' +
                    '</svg>Password must be at least 5 letters long </div>' +
                    '</p>');
            }
            errCount++;
        }else
        if (errpass.textContent != '') {
            errpass.innerHTML = "";
        }


        //validate password-repeart
        if (password.value != repeatPassword.value) {
            if (errpassr.textContent == '') {
                errpassr.insertAdjacentHTML('afterbegin', '<p><div class=\"alert bg-danger\" ' +
                    'role=\"alert\"><svg class="glyph stroked cancel">' +
                    '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-cancel">' +
                    '</use>' +
                    '</svg>Password does not match the confirm password. </div>' +
                    '</p>');
            }
            errCount++;
        }else
        if (errpassr.textContent != '') {
            errpassr.innerHTML = "";
        }

        //validate hub id
        var rh = /(\w{2})-(\w{2})-(\w{2})-(\w{2})-(\w{2})/;
        if (hubId.value == '' || !rh.test(hubId.value))
        {
            if (errhubid.textContent == '') {
                errhubid.insertAdjacentHTML('afterbegin', '<p><div class=\"alert bg-danger\" ' +
                    'role=\"alert\"><svg class="glyph stroked cancel">' +
                    '<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-cancel">' +
                    '</use>' +
                    '</svg>Please enter a valid HUB ID. </div>' +
                    '</p>');
            }
            errCount++;
        }else
        if (errhubid.textContent != '') {
            errhubid.innerHTML = "";
        }


            if(errCount > 0){
                return false;
            }else{
                document.getElementById('signUp').submit();
            }


        }
</script>