<?php
session_start();
$conn = mysqli_connect('localhost','root',
    'wnsgusgk3537','user');
$m_idx = $_POST['m_idx'];
$userid = $_SESSION['UserId'];
header('Content-Type: text/html; charset=utf-8'); // utf-8인코딩

$db = new mysqli("localhost","root","wnsgusgk3537","user");
$db->set_charset("utf8");

function mq($sql)
{
    global $db;
    return $db->query($sql);
}
error_log("music_UNLIKE");
$alert;
if($userid != ""){
    $sql2 ="
            delete from LikedMusic
            where liked_m_m_idx = '$m_idx'
            and liked_m_userid = '$userid'
            ";
    $result2 = mysqli_query($conn,$sql2);
    error_log(mysqli_error($conn));
    if($result2 === false){//제대로 삭제가 안 되었을떄
        $alert ="2";
    }else{ // 제대로 삭제 되었을떄
        $sql4 = mq("select * from LikedMusic where liked_m_m_idx ='$m_idx'");
        $rep_count = mysqli_num_rows($sql4);
//        $alert = "1";
        $alert = "    <label class=\"btn_like\" id=\"btn_like\">
                    <button class=\"btn btn-outline-primary\" id=\"likebtn\" style=\"padding-bottom: 3px;padding-top: 3px;
                            margin-left: 10px; margin-bottom: 5px;\" value=\"like\" >❤ $rep_count</button>
                </label>";
    }
}else{
    $alert = "3";
}

echo $alert;

error_log(mysqli_error($conn));// tail -f /var/log/apache2/error.log 에서 로그볼수 있다.
?>