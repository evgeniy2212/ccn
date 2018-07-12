<?php
$fileName = './contents/' . $_REQUEST['data_name'] . '.html';
$fileContent = file_get_contents($fileName);
echo $fileContent;
