<?php
include ("db.php");
$filename = $_GET['m_filename'];
$uploader = $_GET['m_uploader'];

$trim_filename = str_replace("%20", " ", $filename);
error_log("music delete :".$trim_filename."/".$uploader);
//unlink("/var/www/html/music_upload/".$filename);
$sql = mq("delete from MusicInfo where m_filename='$filename' and m_uploader='$uploader'");
if($sql){
    echo "<script type=\"text/javascript\">alert(\"게시된 음악이 삭제되었습니다.\");</script>";
}else{
    echo "<script type=\"text/javascript\">alert(\"게시된 음악을 삭제하지 못했습니다. 관리자에게 문의하세요.\");</script>";
}
?>
<meta http-equiv="refresh" content="0 url=music_home.php" />
