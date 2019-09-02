<?php
session_start();
include ("/var/www/html/getID3/getid3/getid3.php");
$conn = mysqli_connect('localhost','root',
    'wnsgusgk3537','user');

$m_userid = $_SESSION['UserId'];

$error = $_FILES['music_file']['error'];
$tmpfile =  $_FILES['music_file']['tmp_name']; //post 방식으로 넘겨받음  $_FILES['b_file']
$o_name = $_FILES['music_file']['name'];
$filename = iconv("UTF-8", "EUC-KR",$_FILES['music_file']['name']);
if(strpos($filename,"'") !== false){
    $filename = str_replace("'","",$filename); //문자열에 ' 문자가 있으면 mysql 신택스 문제가 생긴다
}
$filename = $m_userid."_".$filename;
$folder = "/var/www/html/music_upload/".$filename;
move_uploaded_file($tmpfile,$folder);

$alert;
$getID3 = new getID3;
$filename_ = $folder;
if($filename_ !=""){
    $file = $getID3->analyze($filename_);
    $res = array();
    $res["file"] = $filename_;
    $res["album"] = $file["tags"]["id3v2"]["album"][0];
    $res["title"] = $file["tags"]["id3v2"]["title"][0];


    $res["artist"] = $file["tags"]["id3v2"]["artist"][0];
    $res["play_length"] = $file['playtime_string'];
    $res["picture"]=$file['id3v2']['APIC'][0]['data']; //바이너리 이미지 코드
    $res["picture2"]=$file['id3v2']['comments'];
    $res["image_mime"]=$file['id3v2']['APIC'][0]['image_mime'];
    $res["genre"]=$file['id3v2']['comments']['genre'][0];

    if($res["title"]==""){
        $o_name = strtok($o_name, '.');
        $res["title"] = $o_name;
    }
    if(strpos($res["title"],"'") !== false){
        $res["title"] = str_replace("'","",$res["title"]); //문자열에 ' 문자가 있으면 mysql 신택스 문제가 생긴다
    }

    if($res["picture"]==""){
        $res["picture"] = $file['id3v2']['PIC'][0]['data'];
    }
    if($res["picture"]==""){
        $res["picture"] = $file['comments']['picture'][0]['data'];
    }

    ///////////////////////////////////////////////////
    if($res["image_mime"] ==""){
        $res["image_mime"] = $file['id3v2']['PIC'][0]['image_mime'];
    }// 이미지 파일이 안나오는경우 = 배열 경로를 잘못 찾아 들어간것이다.
    if($res["image_mime"] ==""){
        $res["image_mime"] = $file['comments']['picture'][0]['image_mime'];
    }// 이미지 파일이 안나오는경우 = 배열 경로를 잘못 찾아 들어간것이다.2

    $res["real_picture"]='data:' . $res["image_mime"] . ';base64,' . base64_encode($res["picture"]);
    $img_mime = str_replace("image/","",$res["image_mime"]);

    $file = "/var/www/html/music_upload/music_image/".$m_userid."_".$res["title"].'.'.$img_mime;
//    file_put_contents($file, base64_encode($res["picture"]));

    /** !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
    file_put_contents($file, base64_decode(base64_encode($res["picture"]))); // 헐 ㅅㅂ 됐어 ㅅㅂ !!!!!!!1
    // 바이너리 이미지 코드를 이미지 파일로 저장 하는 과정입니다. 오메 ㅅㅂ 되버렸잖아 ㅎ하하하ㅏ하하하하하ㅏ하
    /** !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/

//    $sql2 ="
//            INSERT INTO MusicInfo
//            (m_uploader,m_title,m_genre,m_artist,m_image,m_filename,m_length,m_filepath)
//            VALUES(
//              '{$m_userid}',
//              '{$res["title"]}',
//              '{$res["genre"]}',
//              '{$res["artist"]}',
//
//              '{$res["real_picture"]}',
//              '{$filename}',
//              '{$res["play_length"]}',
//              '{$folder}'
//            )
//            ";
//    $result2 = mysqli_query($conn,$sql2);
//    error_log("music upload error2 :".mysqli_error($conn));
//    if($result2 === false){//제대로 저장이 안 되었을떄
//        $alert ="2";
//    }else{ // 제대로 저장이 되었을떄
//        $alert = "3";
//    }
    $alert ="3";
}else{
    $alert = "1";
}


?>

<?php if($alert == "3"){?>
    <meta http-equiv="refresh" content="0 url=music_upload.php?filename=<?php echo urlencode($filename)?>&title=<?php echo urlencode($res["title"])?>&artist=<?php echo urlencode($res["artist"])?>&genre=<?php echo urlencode($res["genre"])?>&image_mime=<?php echo $img_mime?>"/>
<!--urlencode()을 해줘야 &문자가 GET방식에서 기능 없는 단순 문자로 인식된다-->
<?php } else if(($alert == "1") || ($alert == "2")){?>
<script type="text/javascript">alert("문제가 생겼습니다. 관리자에게 문의 하세요.");</script>
<meta http-equiv="refresh" content="0 url=music_pre_upload.php"/>
<?php }?>
