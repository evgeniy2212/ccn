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
        <div class="panel panel- data-block">
            <div class="panel-heading">
                <a href="/" class="btn btn-xs btn-default">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <svg class="glyph stroked email">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-email"></use>
                </svg>
                Send new password
            </div>
            <?php if($_POST['remindPass'] == true){ ?>
            <div class="alert bg-success green-panel" role="alert">
                <svg class="glyph stroked checkmark">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-checkmark"></use>
                </svg> A new password has been sent to your e-mail address.
                <a href="#" class="pull-right">
                </a>
            </div>
            <?php } ?>
            <div class="panel-body">
                <form name="signUp" id="signUp" method="POST" action="/send-new-pass">
                    <h6><i>* - required fields</i></h6>
                    <h5>Please enter your email address below and we'll send you a new password.</h5>
                    <div class="form-group">
                        <label>E-mail*</label>
                        <input name="email" id="email" class="form-control" placeholder="">
                    </div>
                    <button class="btn btn-add center-block">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>