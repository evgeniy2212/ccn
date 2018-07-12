<html>
<body>

<form action="handlerMCS.php" method="post">
    Name: <input type="text" name="NEED_PAGE"><br>
    <input type="submit">
</form>

<?php var_dump([$_POST,$_FILES, filesize($_FILES['userfile']['tmp_name'])]);


echo '<br/>';
echo ini_get('upload_max_filesize').'<br/>';
ini_set("upload_max_filesize","200M");
ini_set("upload_tmp_dir",".");
echo ini_get("upload_max_filesize");
echo '<br/>';
echo ini_get("post_max_size");

$uploaddir = './data/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);

?>
<form action="" class="form" enctype="multipart/form-data" method="post">
    <input name="MAX_FILE_SIZE" value="50000000" type="hidden">

    <label>
        <span>Ваше имя</span>
        <input name="name" type="text">
    </label>

    <label class="file-label">
        <span>Прикрепить файл</span>
        <input name="userfile" id="file" type="file">
    </label>

    <button class="btn">Отправить</button>
</form>
<?php echo date("H:i:s");?>
<br>
<?php

echo $lastVideoTime = substr('2017.06.22 00:58:54_3.mp4', 0,19);
?>
<br>
<?php
echo $lastAutoAlarm = substr('2017-06-21 04:18:08', 0,19);
if ($lastAutoAlarm !== $lastVideoTime) {
    $videoRequest['lastAlarmTime'] = $lastAutoAlarm;
    var_dump($videoRequest);
}
?>

<script>

    var timestamp = new Date('2014-01-16 12:00:00'.replace(' ', 'T')).getTime();

console.log(timestamp);
</script>

</body>
</html>