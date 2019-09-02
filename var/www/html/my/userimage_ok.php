<?php
session_start();
$conn = mysqli_connect('localhost','root',
    'wnsgusgk3537','user');
$db = new mysqli("localhost","root","wnsgusgk3537","user");
$db->set_charset("utf8");

function mq($sql)
{
    global $db;
    return $db->query($sql);
}

$userid = $_GET['userid'];

$error = $_FILES['userimg_file']['error'];
error_log("userimg upload error num:".$error);

$alert;
if( $error != 0 ) { // 0 이면 문제 없음
    switch ($error) {
        case 1: //UPLOAD_ERR_INI_SIZE
            $alert = "3";
            break;
        case 2: //UPLOAD_ERR_FORM_SIZE
            $alert = "3";
            break;
        case 4: //UPLOAD_ERR_NO_FILE
            $alert = "4";
            break;
        default:
            $alert = "5";
    }
}

$tmpfile =  $_FILES['userimg_file']['tmp_name']; //post 방식으로 넘겨받음  $_FILES['userimg_file']
$o_name = $_FILES['userimg_file']['name'];
$filename = iconv("UTF-8", "EUC-KR",$_FILES['userimg_file']['name']);
if(strpos($filename,"'") !== false){
    $filename = str_replace("'","",$filename); //문자열에 ' 문자가 있으면 mysql 신택스 문제가 생긴다
}
$filename = $userid."_".$filename;
$folder = "/var/www/html/image/userimg/".$filename;
move_uploaded_file($tmpfile,$folder);

//이미 이미지가 정해졌다면
$sql2 = mq("select * from UserInfo where id='".$userid."'");
while($row2 = mysqli_fetch_array($sql2)){
    $old_userimg = $row2['userimg'];
    if($old_userimg !=""){
        unlink("/var/www/html/image/userimg/".$old_userimg);
    }
}

$sql = "update UserInfo 
            set userimg='".$filename."'
          
            where id='".$userid."'
        ";
$result2 = mysqli_query($conn,$sql);
error_log("userimg ok :".mysqli_error($conn));
if($result2 == false){
    $alert = "1";
}else{
    $alert = "2";
}
?>

<?php  if(($alert == "1")){?>
    <script type="text/javascript">alert("저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의 하세요.");</script>
    <meta http-equiv="refresh" content="0 url=music_mymusic.php?m_uploader=<?php echo $userid?>"/>
<?php } else if($alert == "2"){?>
<!--    <script type="text/javascript">alert("업로드가 완료되었습니다.");</script>-->
    <meta http-equiv="refresh" content="0 url=music_mymusic.php?m_uploader=<?php echo $userid?>"/>
<?php } else if($alert == "3"){?>
    <script type="text/javascript">alert("파일이 너무 큽니다");</script>
    <meta http-equiv="refresh" content="0 url=music_mymusic.php?m_uploader=<?php echo $userid?>"/>
<?php } else if($alert == "4"){?>
<script type="text/javascript">alert("파일이 첨부되지 않았습니다");</script>
<meta http-equiv="refresh" content="0 url=music_mymusic.php?m_uploader=<?php echo $userid?>"/>
<?php } else if($alert == "5"){?>
<script type="text/javascript">alert("파일이 제대로 업로드되지 않았습니다");</script>
<meta http-equiv="refresh" content="0 url=music_mymusic.php?m_uploader=<?php echo $userid?>"/>
<?php }?>
