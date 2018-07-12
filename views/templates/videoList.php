<?php //if(isset($_SESSION['login'])) {  ?>
<div class="row">
    <!--  page header -->
    <div class="col-lg-12">
        <h2 class="page-header" style="text-align: center">Videos</h2>
    </div>
    <!-- end  page header -->
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table" id="dataTables-videos">
                <thead>
                <tr>
                    <th style="">
                        <div class="th-inner"></div>
                        <div class="fht-cell"></div>
                    </th>
                    <th style="">
                        <div class="th-inner">Device id</div>
                        <div class="fht-cell"></div>
                    </th>
                    <th style="">
                        <div class="th-inner">Serial number</div>
                        <div class="fht-cell"></div>
                    </th>
                    <th style="">
                        <div class="th-inner">Address</div>
                        <div class="fht-cell"></div>
                    </th>
                    <th style="">
                        <div class="th-inner">Date/Тime</div>
                        <div class="fht-cell"></div>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                for($i=0;$i<count($data);$i++){ ?>
                    <tr>
                        <td>
                            <a href="/videos/<?php echo $data[$i]['device_id'];?>/<?php echo $data[$i]['id'];?>"
                               class="btn btn-player" type="submit"><i class="fa fa-play" aria-hidden="true"></i>
                                Watch</a>
                        </td>
                        <td>
                            <?php echo $data[$i]['device_id'];?>
                        </td>
                        <td>
                            <?php echo $data[$i]['num'];?>
                        </td>
                        <td>
                            <?php echo $data[$i]['installation_city']
                                . " " . $data[$i]['installatiion_street']
                                . "," . $data[$i]['installation_house_number'];
                            ?>
                        </td>
                        <td>
                            <?php echo $data[$i]['created_at'];?>
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
    <?php //}else{
    //
    //    header("Location: /");
    //
    //} ?>
<script>
    $(document).ready(function () {
        $('#dataTables-videos').dataTable( {
                "order": [[ 1, "asc" ]] // Sort by first column ascending
//                , responsive: true
            }
        );
    });

    $('.date-range').empty().append(

        $('<button/>', {id:"reset", class:'btn-reset' }).text('reset')


    );





    $("input").keyup(function () {

        var value = $(this).val();
        table
            .columns( 4 )
            .search( value)
            .draw();

    }).keyup();

</script>