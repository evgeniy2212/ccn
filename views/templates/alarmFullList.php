<div class="row">
    <!--  page header -->
    <div class="col-lg-12">
        <h2 class="page-header" style="text-align: center">Alarm List</h2>
    </div>
    <!-- end  page header -->
</div>
<?/*
[id] => 12
[device_id] => 1e-00-11-00-19
[type] => remove
[start_id] => 1
[end_id] => 85
[created_at] => 2017-03-29 15:54:52
<?/**/?>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table" id="dataTables-alarms">
                <thead>
                <tr>
                    <th style="">
                        <div class="th-inner"></div>
                        <div class="fht-cell"></div>
                    </th>
                    <th style="">
                        <div class="th-inner"></div>
                        <div class="fht-cell"></div>
                    </th>
                    <th style="">
                        <div class="th-inner">start_id</div>
                        <div class="fht-cell"></div>
                    </th>
                    <th style="">
                        <div class="th-inner">end_id</div>
                        <div class="fht-cell"></div>
                    </th>
                    <th style="">
                        <div class="th-inner">Datetime</div>
                        <div class="fht-cell"></div>
                    </th>
                    <th style="">
                        <div class="th-inner">State</div>
                        <div class="fht-cell"></div>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                for($i=0;$i<count($data);$i++){ ?>
                    <tr>
                        <td>
                            <?php echo $data[$i]['id'];?>
                        </td>
                        <td>
                            <?php echo $data[$i]['device_id'];?>
                        </td>
                        <td>
                            <?php echo $data[$i]['start_id'];?>
                        </td>
                        <td>
                            <?php echo $data[$i]['end_id'];?>
                        </td>
                        <td>
                            <?php echo $data[$i]['created_at'];?>
                        </td>
                        <td>
                            <?php echo $data[$i]['type'];?>
                        </td>
                            <?php /*
                        <td>
                            <a href="/undo-alarm/<?php echo $data[$i]['id'];?>"
                               class="btn btn-player" type="submit"><i class="fa fa-play" aria-hidden="true"></i>
                                Cancel
                            </a>
                        </td>
                        <?/**/?>
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
        $('#dataTables-alarms').dataTable( {
                "order": [[ 0, "desc" ]] // Sort by first column ascending
//                , responsive: true
            }
        );
    });
</script>