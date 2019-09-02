<?php
include ("db.php");
$reply_idx = $_POST['rno'];
$page = $_GET['page'];
$reply_comm_num = $_POST['b_no'];
$userpassword = $_SESSION['UserPassword'];
$username =$_SESSION['UserName'];
$inputpassword = $_POST['pw'];

error_log("reply delete 5: ".$reply_idx."/".$reply_comm_num."/".$username."/".$userpassword."/".$inputpassword);
if($userpassword == $inputpassword){
    $sql = mq("delete from Community_Reply where reply_idx='$reply_idx' and reply_comm_num='$reply_comm_num';");
    echo "<script type=\"text/javascript\">alert(\"댓글이 삭제되었습니다.\");</script>";
}else{
    echo "<script type=\"text/javascript\">alert(\"비밀번호를 확인해 주세요\");</script>";
}

?>
<!--<script type="text/javascript">alert("댓글이 삭제되었습니다.");</script>-->
<meta http-equiv="refresh" content="0 url=community_inner.php?comm_num=<?php echo $reply_comm_num;?>&page=<?php echo $page;?>" />
