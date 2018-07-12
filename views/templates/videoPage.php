<div class="row">
    <!--  page header -->
    <div class="col-lg-12">
        <h2 class="page-header" style="text-align: center">Alarm video</h2>
    </div>
    <!-- end  page header -->
</div>

<div class="panel panel-default data-block">
    <div class="panel-body">
        <video class='center' width="640" height="480" controls autoplay>
            <source src="/data/<?php echo $data['filename'];?>" type="video/mp4">
<!--            --><?php //var_dump($data['filename']);die(); ?>
            Your browser does not support the video tag.
        </video>
        <div class="center">

            <h4><b>Device id:  </b><?php echo $data['device_id'];?></h4>
            <h4><b>Datetime:  </b><?php echo $data['created_at'];?></h4>
        </div>
        <div class="clearfix">
        </div>
    </div>
</div>