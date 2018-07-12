<?
$array = array('email', 'email', 'email');
foreach($array as $value) {
while(strlen($array[$value])<6) {
$array[$value] = "." . $array[$value];
}
}
$array = implode("",$array);
$array = str_split($array);
for($i=0;$i<count($banknotes);$i++){
    $array[$i] = ord($array[$i])    ;
    $array[$i] = pack("C*", $array[$i]);
}
$array = implode( $array);
var_dump($array);die();
?>