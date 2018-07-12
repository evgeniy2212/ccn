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
                My parameters
            </div>
            <div class="panel-body ">

                <?php
                if($data['changed']){ ?>
                    <div class="alert bg-success green-panel" role="alert">
                        <svg class="glyph stroked checkmark">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-checkmark"></use>
                        </svg> Your parameters was changed.
                        <a href="#" class="pull-right">
                        </a>
                    </div>
                <?php } ?>

                <form role="form" name="signUp" id="signUp" method="POST" action="/save-my-parameters">
                    <div class="form-group">
                        <label>First Name</label>
                        <input name="firstname" class="form-control" placeholder="" value="<?php echo $data['first_name']; ?>" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input name="lastname" class="form-control" placeholder="" value="<?php echo $data['last_name']; ?>" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input name="phone" class="form-control" placeholder="" value="<?php echo $data['phone']; ?>" maxlength="15">
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input name="email" class="form-control" placeholder="" value="<?php echo $data['email']; ?>" maxlength="30">
                    </div>
                    <button class="btn btn-add" type="submit">Save</button>
                    <a href="/change-password" class="btn btn-def">Change Password</a>
<!--                    <a href="#" class="btn btn-warning">Change E-mail</a>-->
                </form>
            </div>
        </div>
    </div>
</div>