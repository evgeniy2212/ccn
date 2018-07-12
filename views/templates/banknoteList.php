<div class="row">
    <!--  page header -->
    <div class="col-lg-12">
        <h2 class="page-header" style="text-align: center"><?php echo $data['title']; ?></h2>
    </div>
    <!-- end  page header -->
</div>
<?php //echo '<pre>' . print_r($data, 1) . '</pre>';?>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">

            <table class="table" id="dataTables-banknotes">

                <thead>
                <tr>
                    <? if ($data['title'] == 'Criminal banknotes') { ?>
                        <th><input name="select_all" value="1" id="example-select-all" type="checkbox"/></th>
                    <? } ?>
                    <th style="">
                        <div class="th-inner"><?php /*Device id<?/**/ ?></div>
                        <div class="fht-cell">#</div>
                    </th>
                    <th style="">
                        <div class="th-inner">Device id</div>
                        <div class="fht-cell"></div>
                    </th>
                    <th style="">
                        <div class="th-inner"></div>
                        <div class="fht-cell">Serial number</div>
                    </th>
                    <th style="">
                        <div class="th-inner"><?php /*Datetime<?/**/ ?></div>
                        <div class="fht-cell">Date/Time</div>
                    </th>
                    <?php /**/
                    if ($data['title'] == '12 hours folder') { ?>
                        <th style="">
                            <div class="th-inner"></div>
                            <div class="fht-cell">timeout</div>
                        </th>
                    <?php } ?>
                    <?php /**/
                    if ($data['title'] == 'Incoming criminal banknotes') { ?>
                        <th style="">
                            <div class="th-inner"></div>
                            <div class="fht-cell"></div>
                        </th>


                    <? } /**/ ?>
                </tr>
                </thead>
                <tbody>
                <?php
                $banknotes = $data['banknotes'];

                for ($i = 0; $i < count($banknotes); $i++) { ?>
                    <tr>
                        <? if ($data['title'] == 'Criminal banknotes') { ?>
                            <td></td>
                        <? } ?>
                        <td id="idBank">
                            <?php echo $banknotes[$i]['id']; ?>
                        </td>
                        <? /**/
                        ?>
                        <td>
                            <?php echo $banknotes[$i]['device_id']; ?>
                        </td><? /**/
                        ?>
                        <td id="num"><?php echo $banknotes[$i]['num']; ?></td>
                        <td id="create"><?php echo $banknotes[$i]['created_at']; ?></td>
                        <?php if ($data['title'] == '12 hours folder') { ?>

                            <td class="timeout"><?php echo $banknotes[$i]['timeout'];
                                ?></td>
                        <?php } ?>

                        <?php if ($data['title'] == 'Incoming criminal banknotes') { ?>
                            <?php if ($banknotes[$i]['vid']) { ?>

                                <td class="btn btn-player">
                                    <a href="/videos-for-alarm/<?php echo $banknotes[$i]['device_id']; ?>/<?php echo $banknotes[$i]['alm_id']; ?>"
                                       class="btn btn-player" type="submit"> <i class="fa fa-play"
                                                                                aria-hidden="true"></i>
                                        Watch</a>
                                </td>


                                <!--                            <td>--><?php //echo $banknotes[$i]['alarms_start_id'];?><!--</td>-->
                                <!--                            <td>--><?php ////echo $banknotes[$i]['alarms_end_id'];?><!--<!--</td>-->

                            <?php } else { ?>
                                <td>
                                    <p>no video</p>
                                </td>
                            <? }
                        } ?>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

            <? if ($data['title'] == 'Criminal banknotes') { ?>
                <a id="removeCriminal" href="/mark-checked">
                    <button value="ddd" class="btn-reset-bd" id="btn-delete-rec" type="submit">Not Criminal</button>
                </a>


            <? } ?>
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
        <? if ($data['title'] == 'Criminal banknotes') { ?>
        $('#example-select-all').on('click', function () {
            var rows = table.rows({'search': 'applied'}).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });

        <? } ?>

        var table = $('#dataTables-banknotes').DataTable({
            <? if ($data['title'] == 'Criminal banknotes') { ?>
            'columnDefs': [{
                'targets': 0,
                'searchable': false,
                'orderable': false,
                'width': '1%',
                'className': 'dt-body-center',
                'render': function (data, type, full, meta){
                    //console.log(full[1]);
                    var val = full[1];
                    return '<input type="checkbox" data-val="'+val+'" name="data_check['+val+']" value="">';
                }
            }],
            'initComplete': function() {
                this.find('tr').each(function(index,elem){
                    //console.log(elem);
                    var $checkbox = $(elem).find('input[type="checkbox"]');
                    $checkbox.data('val');
                });
            },
            <? } ?>
            "order": [[1, "asc"]]// Sort by first column ascending
//                , responsive: true
        });

        $(document.body).on('click', '#btn-delete-rec', function (e) {
            e.preventDefault();
            var aId = [];
            $('#dataTables-banknotes').find('tr').each(function (index, elem) {
                var $checkbox = $(elem).find('input[type="checkbox"]');
                if ($checkbox.prop('checked') && $checkbox.data('val'))
                    aId.push($checkbox.data('val'));
            });
            console.log(aId);
            $.ajax({
                url: '/cancel-criminal-json',
                type: 'POST',
                data: {'aId':aId},

                success: function (data) {

                        document.location.reload();

                }
            });
        });

        $(document.body).on('keyup', '#from, #to', function () {
            table.draw();

            //    $(table).dataTable('draw');
        });

        $(document.body).on('change', '#from, #to', function () {

            table.draw();

            //   $(table).dataTable('draw');
        });


        $('.date-range').empty().append(
            $('<label/>', {for: "from"}).text('From'),
            $('<input/>', {id: "from", class: 'form-control input-sm', name: "from"}),
            $('<label/>', {for: "to"}).text('to'),
            $('<input/>', {id: "to", class: 'form-control input-sm', name: "to"}),

            $('<button/>', {id: "reset", class: 'btn-reset'}).text('reset')
        );
//
        $('.date-range').css({
            "display": "inline-block"
        });


        document.getElementById("reset").onclick = function (e) {
            document.getElementById("from").value = "";
            document.getElementById("to").value = "";
            $("#from").datetimepicker("option", "minDate", null);
            $("#to").datetimepicker("option", "minDate", null);
            table.draw();

        };
        $("input").keyup(function () {
            var value = $(this).val();
            table
                .columns(2)
                .search(value)
                .draw();
        }).keyup();

        setInterval(function () {
            $('.timeout').each(function (key, value) {
                var text = $(value).text();


                var date = new Date().getTime();

                var arrText = text.split(":");
                console.log(arrText);


                var time = (parseInt(arrText[0]) * 60 + parseInt(arrText[1])) * 60 + parseInt(arrText[2]);


                time--;
                arrText[2] = time % 60;
                console.log([time, time % 60]);
                time = Math.floor(time / 60);
                arrText[1] = time % 60;
                time = Math.floor(time / 60);
                arrText[0] = time % 60;
                text = arrText.join(':');

                $(this).text(text);
                if ((arrText[2] == 0) && (arrText[1] == 0) && (arrText[0] == 0)) {
                    location.href = '/check-time';
                }


            });
        }, 1000);

    });


</script>