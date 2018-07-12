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
                <a href="/my-parameters" class="btn btn-xs btn-default">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                Change password
            </div>
            <div class="panel-body">

                <?php
                if($data){ ?>
                    <div class="alert bg-success green-panel" role="alert">
                        <svg class="glyph stroked checkmark">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-checkmark"></use>
                        </svg> Your password was changed.
                        <a href="#" class="pull-right">
                        </a>
                    </div>
                <?php } ?>

                <form role="form" name="signUp" id="signUp" method="POST" action="/save-change-password">
                    <div class="form-group">
                        <label>Enter old password</label>
                        <input name="old-password" id="old-password" type="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Enter new password</label>
                        <input name="password" id="password" type="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Confirm password</label>
                        <input name="repeat-password" id="repeat-password" type="password" class="form-control">
                    </div>
                    <button class="btn btn-add center-block" type="submit">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>