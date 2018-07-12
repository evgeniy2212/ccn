<?php //if(isset($_SESSION['login'])) {  ?>
<div class="row">
    <!--  page header -->
    <div class="col-lg-12 col-md-12 col-sm-12">
        <h1 class="page-header" style="text-align: center">Banknotes list</h1>
    </div>


    <!-- end  page header -->
</div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive table-borderless">

                <table class="table" id="dataTables-example">
                                <thead>
                                <tr>

                                    <th style="">
                                        <div class="th-inner">Device Id</div>
                                        <div class="fht-cell"></div>
                                    </th>
                                    <th style="">
                                        <div class="th-inner">Serial number</div>
                                        <div class="fht-cell"></div>
                                    </th>

                                    <th style="">
                                        <div class="th-inner">Status</div>
                                        <div class="fht-cell"></div>
                                    </th>
                                    <th style="">
                                        <div class="th-inner">Datetime</div>
                                        <div class="fht-cell"></div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                for($i=0;$i<count($data);$i++){ ?>
                                <tr>
                                    <td>

                                    </td>
                                    <td>
                                        <?php echo $data[$i]['device_id'];?>
                                    </td>
                                    <td>
                                        <?php echo $data[$i]['num'];?>
                                    </td>

                                    <td>
                                        <?php echo $data[$i]['statusText'];?>
                                    </td>
                                    <td>
                                        <b><?php echo $data[$i]['created_at'];?></b>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>

                    <a id="clearDatabase" href="/delete-data-db" ><button value="ddd" class="btn-reset-bd" id="btn-reset-bd" type="submit">TEST_RESET</button></a>
                    <div class="fixed-table-pagination">

                        </div>
                </div>
                <div class="clearfix">

                </div>
                </div>

<?php

?>
<script>



var json = null;
var newJson = null;
$.ajax({
    url: '/banknotes-json',
    type: 'POST',
    dataType: "json",
    success: function (data) {
        if(data.length > 0)
        {
            json = data;
        }
    }
});




//var table =
$(document).ready(function() {
    var scrollTop = 0;
    var table = $('#dataTables-example').DataTable({


        "destroy": true,
        "scrollY": "800px",
        "scrollCollapse": true,
        "paging": !false,
        "processing": true,
        "order": [[3, "desc"]],
        "ajax": {
            "type": "POST",
            "url": "/banknotes-json"
        },
        "columns": [
            {"data": 'device_id'},
            {"data": 'num'},
            {"data": 'statusText'},
            {"data": 'created_at'}
        ],
        "createdRow": function( row, data, dataIndex ) {
            if ( data["status"] == 0 ) {
                $( row ).css( "background-color", "#c3dcfd" );
                $( row ).css( "color", "#696969" );

            }else if(data["status"] == 1){
                $( row ).css( "background-color", "#8acea3" );
                $( row ).css( "color", "#696969" );
            }else if(data["status"] == 2){
                $( row ).css( "background-color", "#de9088" );
                $( row ).css( "color", "#FFFAF0" );
            }else if(data["status"] == 3){
                $( row ).css( "background-color", "#de9088" );
                $( row ).css( "color", "#FFFAF0" );
            }else if(data["status"] == 4){
                $( row ).css( "background-color", "##FF8C00" );
                $( row ).css( "color", "#FFFAF0" );
            }
        }
    });

    $('.date-range').empty().append(
        $('<label/>', {for:"from"}).text('From'),
        $('<input/>', {id:"from", class:'form-control input-sm', name:"from"}),
        $('<label/>', {for:"to"}).text('to'),
        $('<input/>', {id:"to", class:'form-control input-sm', name:"to"}),
        $('<button/>', {id:"reset", class:'btn-reset' }).text('reset')

    );
    $('.date-range').css({
        "display": "inline-block"
    });



    document.getElementById("reset").onclick = function (e) {
        document.getElementById("from").value = "";
        document.getElementById("to").value = "";
        $("#from").datetimepicker("option", "minDate", null) ;
        $("#to").datetimepicker("option", "minDate", null) ;
        table.draw();

    };

    $(document.body).on('click', '#clearDatabase', function() {
        if (confirm("Do you want to clear database?")){
            return true;
        }else{
            return false;
        }
    });

    $(document.body).on('keyup', '#from, #to', function() {
        table.draw();
    });

    $(document.body).on('change', '#from, #to', function() {
        table.draw();
    });

    $("input").keyup(function () {
        var value = $(this).val();
        table
            .columns( 1 )
            .search( value)
            .draw();

    }).keyup();

    setInterval(function () {
        $.fn.dataTable.ext.errMode = 'none';
        scrollTop = $('.dataTables_scrollBody').get(0).scrollTop;
        table.ajax.reload(function () {
            $('.dataTables_scrollBody').scrollTop(scrollTop);
        }, false);
    }, 3000);
});


/*setInterval( function () {
    $.ajax({
        url: '/banknotes-json',
        type: 'POST',
        dataType: "json",
        success: function (data) {
            var newJson = data;
            if(JSON.stringify(json) !== JSON.stringify(newJson))
            {
                json = newJson;
                newJson = data;
                $(document).ready(function() {
                    var table = $('#dataTables-example').DataTable({
                        "destroy": true,
                        "scrollY": "800px",
                        "scrollCollapse": true,
                        "paging": false,
                        "processing": true,
                        "order": [[3, "desc"]],
                        "ajax": {
                            "type": "POST",
                            "url": "/banknotes-json"
                        },
                        "columns": [
                            {"data": 'device_id'},
                            {"data": 'num'},
                            {"data": 'status'},
                            {"data": 'created_at'}
                        ],
                        "createdRow": function( row, data, dataIndex ) {
                            if ( data["status"] == 0 ) {
                                $( row ).css( "background-color", "#c3dcfd" );
                                $( row ).css( "color", "#696969" );
                            }else if(data["status"] == 1){
                                $( row ).css( "background-color", "#8acea3" );
                                $( row ).css( "color", "#696969" );
                            }else if(data["status"] == 2){
                                $( row ).css( "background-color", "#de9088" );
                                $( row ).css( "color", "#FFFAF0" );
                            }
                        }
                    });

                    $('.date-range').empty().append(
                        $('<label/>', {for:"from"}).text('From'),
                        $('<input/>', {id:"from", class:'form-control input-sm', name:"from"}),
                        $('<label/>', {for:"to"}).text('to'),
                        $('<input/>', {id:"to", class:'form-control input-sm', name:"to"})
                    );

                    $(document.body).on('keyup', '#from, #to', function() {
                        table.draw();
                    });

                    $(document.body).on('change', '#from, #to', function() {
                        table.draw();
                    });

                    $(function () {
                        var dateFormat = "mm/dd/yy";
                        var from = $("#from").datepicker({
                            defaultDate: "+1w",
                            changeMonth: true,
                            numberOfMonths: 1,
                            dateFormat: 'yy-mm-dd'
                        }).on("change", function () {
                            to.datepicker("option", "minDate", getDate(this));
                        });

                        var to = $("#to").datepicker({
                            defaultDate: "+1w",
                            changeMonth: true,
                            changeYear: true,
                            numberOfMonths: 1,
                            dateFormat: 'yy-mm-dd'
                        }).on("change", function () {
                            from.datepicker("option", "maxDate", getDate(this));
                        });

                        function getDate(element) {
                            var date;
                            try {
                                date = $.datepicker.parseDate(dateFormat, element.value);
                            } catch (error) {
                                date = null;
                            }
                            return date;
                        }
                    });


                });


            }
        }
    });

}, 5000 );/**/


//    var table = $('#dataTables-example').DataTable( {
//        ajax: "/banknotes-json"
//    } );
//
</script>
