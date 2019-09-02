<?php
include ("db.php");

$bno = $_POST['comm_num'];
$page = $_GET['page'];
$userpw = password_hash($_POST['pw'], PASSWORD_DEFAULT);
$sql = mq("update Community_Info set comm_title='".$_POST['comm__title']."',comm_content='".$_POST['comm__content']."' where comm_num='".$bno."'"); ?>
?>
<script type="text/javascript">alert("수정되었습니다.");</script>
<meta http-equiv="refresh" content="0 url=http://127.0.0.1/my/community_inner.php?comm_num=<?php echo $bno; ?>&page=<?php echo $page;?>">