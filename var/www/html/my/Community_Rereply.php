<?php
//include ("db.php");
session_start();
header('Content-Type: text/html; charset=utf-8'); // utf-8인코딩

$db = new mysqli("localhost","root","wnsgusgk3537","user");
$db->set_charset("utf8");

function mq($sql)
{
    global $db;
    return $db->query($sql);
}

$conn = mysqli_connect('localhost','root',
    'wnsgusgk3537','user');

$page = $_GET['page'];
$comm_num = $_GET['comm_num'];
$reply_idx = $_GET['reply_idx'];

$user_id =  $_SESSION['UserId'];
$user_pw =  $_SESSION['UserPassword'];
$user_name =  $_SESSION['UserName'];
$rereply_content = $_POST['re_reply_content3'];
$date = date('Y-m-d h:i:sa');
error_log("rereply : ".$page."/".$comm_num."/".$reply_idx."/".$rereply_content."/".$date."/".$user_id."/".$user_pw."/".$user_name);
$alert;
if($rereply_content!=""){
    $sql = "INSERT INTO Community_ReReply (rereply_reply_idx,rereply_comm_num,rereply_username,rereply_userid,rereply_content,rereply_date) 
          VALUES( 
              '{$reply_idx}',
              '{$comm_num}',
              '{$user_name}',
              '{$user_id}',
              '{$rereply_content}',
              '{$date}'
              )
              ";
    $result2 = mysqli_query($conn,$sql);
    error_log("music upload error2 :".mysqli_error($conn));
    if($result2 === false){//제대로 저장이 안 되었을떄
        $alert ="1";
    }else{ // 제대로 저장이 되었을떄
        $alert = "2";
    }
}else{
    $alert = "0"; // 내용을 모두 입력 안했을때
}


?>
<?php if($alert == "0"){
    ?>
    <script type="text/javascript">alert("내용을 모두 입력해 주세요!");</script>
    <meta http-equiv="refresh" content="0 url=community_inner.php?comm_num=<?php echo $comm_num?>&page=<?php echo $page?>"/>
<?php } else if(($alert == "1")){?>
    <script type="text/javascript">alert("저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의 하세요.");</script>
    <meta http-equiv="refresh" content="0 url=community_inner.php?comm_num=<?php echo $comm_num?>&page=<?php echo $page?>"/>
<?php } else if(($alert == "2")){?>
    <script type="text/javascript">alert("댓글을 성공적으로 달았습니다");</script>
    <meta http-equiv="refresh" content="0 url=community_inner.php?comm_num=<?php echo $comm_num?>&page=<?php echo $page?>"/>
<?php }?>