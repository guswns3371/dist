<?php
include ("db.php");

$bno = $_GET['comm_num'];
$page = $_GET['page'];
$comm_file = $_GET['comm_file'];
$trim_filename = str_replace("%20", " ", $comm_file);
error_log("delete file : ".$trim_filename);
unlink("/var/www/html/community_upload/".$trim_filename);
$sql = mq("delete from Community_Info where comm_num='$bno';");
?>
<script type="text/javascript">alert("삭제되었습니다.");</script>
<meta http-equiv="refresh" content="0 url=community_page.php?page=<?php echo $page?>" />