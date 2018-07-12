<div class="row">
    <!--  page header -->
    <div class="col-lg-12">
        <h2 class="page-header" style="text-align: center">Alarm List</h2>
    </div>
    <!-- end  page header -->
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table" id="dataTables-alarms">
                <thead>
                <tr>
                    <th style="">
                        <div class="th-inner">Datetime</div>
                        <div class="fht-cell"></div>
                    </th>
                    <th style="">
                        <div class="th-inner">Video</div>
                        <div class="fht-cell"></div>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                for($i=0;$i<count($data);$i++){ ?>
                    <tr>
                        <td>
                            <?php echo $data[$i]['created_at'];?>
                        </td>
                        <td>
                            <a href="/undo-alarm/<?php echo $data[$i]['id'];?>"
                               class="btn btn-player" type="submit"><i class="fa fa-play" aria-hidden="true"></i>
                                Cancel
                            </a>
                        </td>
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