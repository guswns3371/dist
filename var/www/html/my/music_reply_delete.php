<?php
session_start();
header('Content-Type: text/html; charset=utf-8'); // utf-8인코딩
$conn = mysqli_connect('localhost','root',
    'wnsgusgk3537','user');
$db = new mysqli("localhost","root","wnsgusgk3537","user");
$db->set_charset("utf8");

function mq($sql)
{
    global $db;
    return $db->query($sql);
}
$alert;
$mre_idx = $_POST['mre_idx'];
$sql = "delete from MusicReply where mre_idx='$mre_idx'";
error_log("music_reply".$mre_idx);

$result2 = mysqli_query($conn,$sql);
error_log(mysqli_error($conn));
if($result2 === false){//제대로 저장이 안 되었을떄
    $alert ="2";
}else{ // 제대로 저장이 되었을떄
    $alert = "1";
}
echo $alert;
?>