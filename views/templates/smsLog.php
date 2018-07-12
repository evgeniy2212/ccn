
<div class="row">
    <!--  page header -->
    <div class="col-lg-12">
        <h2 class="page-header">SMS archive</h2>
    </div>
    <!-- end  page header -->
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <a href="/edit/thermometer/<?php echo $data['hub_id'] ?>/<?php echo $data['position'] ?>" class="btn btn-xs btn-default">
            <span class="glyphicon glyphicon-chevron-left"></span>Edit thermometer
        </a>
        <a href="/statistics/<?php echo $data['hub_id'] ?>/<?php echo $data['position'] ?>" class="btn btn-xs btn-default">
            <span class="glyphicon glyphicon-chevron-left"></span>Statistics
        </a>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table" id="dataTables-sms-archive">
                <thead>
                <tr>
                    <th style="">
                        <div class="th-inner">Message</div>
                        <div class="fht-cell"></div>
                    </th>
                    <th style="">
                        <div class="th-inner">Phone number</div>
                        <div class="fht-cell"></div>
                    </th>
                    <th style="">
                        <div class="th-inner">Sending time</div>
                        <div class="fht-cell"></div>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                for($i=0;$i<count($data)-2;$i++){ ?>
                    <tr>
                        <td>
                            <?php echo $data[$i]['message'];?>
                        </td>
                        <td><?php echo $data[$i]['phone'];?></td>
                        <td><?php echo $data[$i]['created_at'];?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div class="fixed-table-pagination">

            </div>
        </div>
        <div class="clearfix">
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function () {
        $('#dataTables-sms-archive').dataTable( {
                "order": [[ 1, "asc" ]] // Sort by first column ascending
//                , responsive: true
            }
        );
    });
</script>