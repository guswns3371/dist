<?php
$filename = $_GET['filename'];
$file_without_extension = $_GET['file_without_extension'];
$image_mime = $_GET['image_mime'];
$trim_filename = str_replace("%20", " ", $filename);
unlink("/var/www/html/music_upload/".$filename); //음원파일 삭제


unlink("/var/www/html/music_upload/music_image/".$file_without_extension.".".$image_mime); //커버 이미지 파일 삭제
?>
<script type="text/javascript">alert("업로드를 취소 하였습니다");</script>
<meta http-equiv="refresh" content="0 url=music_home.php" />
