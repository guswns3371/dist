<?php
session_start();
$conn = mysqli_connect('localhost','root',
    'wnsgusgk3537','user');
$followed_userid = $_POST['followed_userid'];
$following_userid = $_POST['following_userid'];
$userid_session = $_SESSION['UserId'];
header('Content-Type: text/html; charset=utf-8'); // utf-8인코딩

$db = new mysqli("localhost","root","wnsgusgk3537","user");
$db->set_charset("utf8");

function mq($sql)
{
    global $db;
    return $db->query($sql);
}
error_log("user_FOLLOW");
$alert;
if($userid_session !=""){
    $sql2 ="
            INSERT INTO FollowUser
            (following_user_id,followed_user_id)
            VALUES(
              '{$following_userid}',
              '{$followed_userid}'
            ) 
            ";
    $result2 = mysqli_query($conn,$sql2);
    error_log(mysqli_error($conn));
    if($result2 === false){//제대로 저장이 안 되었을떄
        $alert ="2";
    }else{ // 제대로 저장이 되었을떄
        $sql4 = mq("select * from FollowUser where followed_user_id ='$followed_userid' and following_user_id = '$userid_session'");

//        $alert = "1";
        $alert ="         <label id=\"btn_followed\" class=\"btn_followed pull-right\">
                <button class=\"btn btn-outline-primary \" id=\"followbtn\" value=\"followed\" style=\"padding-bottom: 3px;padding-top: 3px;
            margin-left: 0px; margin-bottom: 5px;background-color: #2b669a;color: white;\">Following</button>
            </label>";
    }
}else{
    $alert="로그인 해주세요";
}

echo $alert;

error_log(mysqli_error($conn));// tail -f /var/log/apache2/error.log 에서 로그볼수 있다.
?>