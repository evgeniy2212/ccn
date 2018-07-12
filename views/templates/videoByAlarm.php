<style>
    #video {
        display: flex;
        flex-direction: row;
    }

    #videoarea {
        flex: 0 0 auto;
    }

    #playlist {
        flex: 0 0 auto;
    }

    #playlist {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding-left: 4em;
        margin: 1em;
    }

    #playlist > * {
        flex: 0 0 auto;
    }

    #playlist ul {
        margin: 0;
        padding: 0;
    }

    #playlist li {
        cursor: pointer;
        padding: 0.4em 1.5em;
        list-style: none;
        color: #000000;
    }

    #playlist li:hover {
        background-color: rgba(0, 109, 204, 0.38);
    }

    #playlist li.activ, #playlist li.activ:hover {
        background-color: #006dcc;
        color: #FFFFFF;
    }

    #videoarea {
        float: left;
        width: 640px;
        height: 480px;
        margin: 1em;
        /*border:1px solid silver;/**/
        box-shadow: 0px 0px 20px #F3F3F3;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header" style="text-align: center">Videos for alarm</h2>
    </div>
</div>

<div class="panel panel-default">
    <div id="video">
        <video id="videoarea" controls="controls" poster="" src=""></video>
        <div id="playlist">
            <ul>
                <? $rec = []; ?>
                <? foreach ($data as &$rec) { ?>
                    <li movieurl="/data/<?= $rec['filename']; ?>"><?= basename($rec['filename']); ?></li>
                    <? //print_r($rec); ?>
                <? } ?>
            </ul>
            <div>
                <span>
                    <input type="checkbox" id="video-autoplay" checked="checked">
                    <label for="video-autoplay">Autoplay</label><br><br>
                </span>

                <div>
                    <? if (count($rec)) { ?>
                        Device: <?= $rec['dev'] ?><br>
                        Serial number: <?= $rec['sNum'] ?>
                    <? } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#playlist li").on("click", function () {
            $("#playlist li").removeClass('activ');
            $(this).addClass('activ');
            $("#videoarea").attr({
                "src": $(this).attr("movieurl"),
                "poster": "",
                "autoplay": "autoplay"
            })
        });
        $("#videoarea").attr({
            "src": $("#playlist li").eq(0).attr("movieurl"),
            "poster": $("#playlist li").eq(0).attr("moviesposter")
        });
        $("#playlist li:nth-child(1)").click();

        document.getElementById('videoarea').addEventListener('ended', myHandler, false);
        function myHandler(e) {
            if ($('#video-autoplay').prop('checked'))
                $("#playlist li.activ").next().click();
        }
    });
</script>