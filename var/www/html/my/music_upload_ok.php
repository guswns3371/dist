<?php
session_start();
//foreach (glob("/var/www/html/getID3/demos/*.php") as $filename)
//{
//    include $filename;
//}
include ("/var/www/html/getID3/getid3/getid3.php");

$conn = mysqli_connect('localhost','root',
    'wnsgusgk3537','user');
$date = date('Y-m-d');
$m_userid = $_SESSION['UserId'];
$m_title = $_POST['m_title'];
$m_genre = $_POST['m_genre'];
$m_artist = $_POST['m_artist'];
$m_desc = $_POST['m_desc'];
if(strpos($m_desc,"'") !== false){
    $m_desc = str_replace("'","",$m_desc); //문자열에 ' 문자가 있으면 mysql 신택스 문제가 생긴다
}
if(strpos($m_artist,"'") !== false){
    $m_artist = str_replace("'","",$m_artist); //문자열에 ' 문자가 있으면 mysql 신택스 문제가 생긴다
}
if(strpos($m_genre,"'") !== false){
    $m_genre = str_replace("'","",$m_genre); //문자열에 ' 문자가 있으면 mysql 신택스 문제가 생긴다
}
////        첨부파일 부분
//$error = $_FILES['m_file']['error'];
//$tmpfile =  $_FILES['m_file']['tmp_name']; //post 방식으로 넘겨받음  $_FILES['b_file']
//$o_name = $_FILES['m_file']['name'];
//$filename = iconv("UTF-8", "EUC-KR",$_FILES['m_file']['name']);
//
//if(strpos($filename,"'") !== false){
//    $filename = str_replace("'","",$filename); //문자열에 ' 문자가 있으면 mysql 신택스 문제가 생긴다
//}
//$filename = $m_userid."_".$filename;

$filename = $_GET['filename'];
$folder = "/var/www/html/music_upload/".$filename;
error_log("music upload folder : ".$folder);
//move_uploaded_file($tmpfile,$folder);


$getID3 = new getID3;
$filename_ = $folder;
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


if(strpos($res["title"],"'") !== false){
    $res["title"] = str_replace("'","",$res["title"]); //문자열에 ' 문자가 있으면 mysql 신택스 문제가 생긴다
}
if(strpos($res["artist"],"'") !== false){
    $res["artist"] = str_replace("'","",$res["artist"]); //문자열에 ' 문자가 있으면 mysql 신택스 문제가 생긴다
}
if(strpos($res["genre"],"'") !== false){
    $res["genre"] = str_replace("'","",$res["genre"]); //문자열에 ' 문자가 있으면 mysql 신택스 문제가 생긴다
}


if($res["picture"]==""){
    $res["picture"] = $file['id3v2']['PIC'][0]['data'];
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

function data_uri($file, $mime)
{
    //$contents = file_get_contents($file);
    $base64   = base64_encode($file); // 바이너리 이미지 코드를 인코딩하는 역할
    return ('data:' . $mime . ';base64,' . $base64);
}
error_log("music upload image base64 :".base64_encode($res["picture"]));
$res["real_picture"]='data:' . $res["image_mime"] . ';base64,' . base64_encode($res["picture"]);
error_log("music upload image data :".$res["real_picture"]);
error_log("music upload filename :".$filename);


//        첨부파일 부분
$error2 = $_FILES['music_newimg_file']['error'];
$tmpfile2 =  $_FILES['music_newimg_file']['tmp_name']; //post 방식으로 넘겨받음  $_FILES['music_newimg_file']
if($tmpfile2 != ""){
    $o_name2 = $_FILES['music_newimg_file']['name'];
    $filename2 = iconv("UTF-8", "EUC-KR",$_FILES['music_newimg_file']['name']);
    if(strpos($filename2,"'") !== false){
        $filename2 = str_replace("'","",$filename2); //문자열에 ' 문자가 있으면 mysql 신택스 문제가 생긴다
    }
    $filename2 = $m_userid."_".$filename2;
    $folder2 = "/var/www/html/music_upload/music_image/music_image_modified/".$filename2;
    move_uploaded_file($tmpfile2,$folder2);

    $getID3_2 = new getID3;
    $filename_2 = $folder2;
    $file_2 = $getID3_2->analyze($filename_2);
    $res_2 = array();
//    $res_2["picture"]=$file_2['id3v2']['APIC'][0]['data'];// 바이너리 이미지 코드
    $res_2["image_mime"]=$file_2['mime_type'];
    $image_data=file_get_contents($folder2);
    $encoded_image=base64_encode($image_data);
    $res["real_picture"]='data:' . $file_2['mime_type'] . ';base64,' . $encoded_image;
}


$alert;
if($file['id3v2'] == ""){ // 파일정보를 빼낼수 없을 떄
    $alert="6";
}else{
    if(($m_title == "") ||($m_genre == "") ||($m_artist == "")){
        $alert="0";

    }else{
        if( $error != 0 ) {
            switch( $error ) {
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
        }else{
//        $sql2 ="
//            INSERT INTO MusicInfo
//            (m_uploader,m_title,m_genre,m_artist,m_descript,m_filename)
//            VALUES(
//              '{$m_userid}',
//              '{$m_title}',
//              '{$m_genre}',
//              '{$m_artist}',
//              '{$m_desc}',
//              '{$filename}'
//            )
//            ";
            $sql2 ="
            INSERT INTO MusicInfo
            (m_uploader,m_title,m_genre,m_artist,m_descript,m_image,m_filename,m_length,m_filepath,m_date)
            VALUES(
              '{$m_userid}',
              '{$m_title}',
              '{$m_genre}',
              '{$m_artist}',
              '{$m_desc}',
              '{$res["real_picture"]}',
              '{$filename}',
              '{$res["play_length"]}',
              '{$folder}',
              '{$date}'
            ) 
            ";
            $result2 = mysqli_query($conn,$sql2);
            error_log("music upload error2 :".mysqli_error($conn));
            if($result2 === false){//제대로 저장이 안 되었을떄
                $alert ="1";
            }else{ // 제대로 저장이 되었을떄
                $alert = "2";
            }
        }

    }
}

?>
<?php if($alert == "0"){
    ?>
    <script type="text/javascript">alert("내용을 모두 입력해 주세요!");</script>
    <meta http-equiv="refresh" content="0 url=music_upload.php?filename=<?php echo urlencode($filename)?>&title=<?php echo urlencode($res["title"])?>&artist=<?php echo urlencode($res["artist"])?>&genre=<?php echo urlencode($res["genre"])?>&image_mime=<?php echo $img_mime?>"/>
<?php } else if(($alert == "1")){?>
    <script type="text/javascript">alert("저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의 하세요.");</script>
    <meta http-equiv="refresh" content="0 url=music_upload.php?filename=<?php echo urlencode($filename)?>&title=<?php echo urlencode($res["title"])?>&artist=<?php echo urlencode($res["artist"])?>&genre=<?php echo urlencode($res["genre"])?>&image_mime=<?php echo $img_mime?>"/>
<?php } else if($alert == "2"){?>
    <script type="text/javascript">alert("업로드가 완료되었습니다.");</script>
    <meta http-equiv="refresh" content="0 url=music_home.php"/>
<?php } else if($alert == "3"){?>
    <script type="text/javascript">alert("파일이 너무 큽니다");</script>
    <meta http-equiv="refresh" content="0 url=music_upload.php?filename=<?php echo urlencode($filename)?>&title=<?php echo urlencode($res["title"])?>&artist=<?php echo urlencode($res["artist"])?>&genre=<?php echo urlencode($res["genre"])?>&image_mime=<?php echo $img_mime?>"/>
<?php } else if($alert == "4"){?>
<script type="text/javascript">alert("파일이 첨부되지 않았습니다");</script>
    <meta http-equiv="refresh" content="0 url=music_upload.php?filename=<?php echo urlencode($filename)?>&title=<?php echo urlencode($res["title"])?>&artist=<?php echo urlencode($res["artist"])?>&genre=<?php echo urlencode($res["genre"])?>&image_mime=<?php echo $img_mime?>"/>
<?php } else if($alert == "5"){?>
<script type="text/javascript">alert("파일이 제대로 업로드되지 않았습니다");</script>
    <meta http-equiv="refresh" content="0 url=music_upload.php?filename=<?php echo urlencode($filename)?>&title=<?php echo urlencode($res["title"])?>&artist=<?php echo urlencode($res["artist"])?>&genre=<?php echo urlencode($res["genre"])?>&image_mime=<?php echo $img_mime?>"/>
<?php } else if($alert == "6"){?>
    <script type="text/javascript">alert("지원하지 않는 파일 형식입니다.");</script>
    <meta http-equiv="refresh" content="0 url=music_upload.php?filename=<?php echo urlencode($filename)?>&title=<?php echo urlencode($res["title"])?>&artist=<?php echo urlencode($res["artist"])?>&genre=<?php echo urlencode($res["genre"])?>&image_mime=<?php echo $img_mime?>"/>
<?php }?>
