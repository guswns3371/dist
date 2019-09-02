<!doctype html>
<?php
include ("mypage_2.php");
header('Content-Type: text/html; charset=utf-8'); // utf-8인코딩

$db = new mysqli("localhost","root","wnsgusgk3537","user");
$db->set_charset("utf8");

function mq($sql)
{
    global $db;
    return $db->query($sql);
}
//include ("/var/www/html/getID3/demos/demo.browse.php");
//$getID3 = new getID3;
//$filename_ = "/var/www/html/music_upload/01 No Tears.mp3";
//$file = $getID3->analyze($filename_);
//$res = array();
//$res["file"] = $filename_;
//$res["album"] = $file["tags"]["id3v2"]["album"][0];
//$res["title"] = $file["tags"]["id3v2"]["title"][0];
//$res["artist"] = $file["tags"]["id3v2"]["artist"][0];
//$res["playtime"] = $file['playtime_string'];
//$res["picture"]=$file['id3v2']['APIC'][0]['data']; //바이너리 이미지 코드
//$res["picture2"]=$file['id3v2']['comments'];
//$res["image_mime"]=$file['id3v2']['APIC'][0]['image_mime'];
//
//if($res["picture"]==""){
//    $res["picture"] = $file['id3v2']['PIC'][0]['data'];
//}
//if($res["image_mime"] ==""){
//    $res["image_mime"] = $file['id3v2']['PIC'][11]['image_mime'];
//}
//function data_uri($file, $mime)
//{
//  //$contents = file_get_contents($file);
//  $base64   = base64_encode($file); // 바이너리 이미지 코드를 png로 바꾸는 역할
//  return ('data:' . $mime . ';base64,' . $base64);
//}
//$res["real_picture"]=data_uri($res["picture"],$res["image_mime"]);
//
//print_r($res);
$artist = $_GET['artist'];
$title = $_GET['title'];
$genre = $_GET['genre'];
$image_mime = $_GET['image_mime'];
$filename = $_GET['filename'];

if(strpos($artist,"%20") !== false){
    $artist = str_replace("%20"," ",$artist);
}

$m_userid = $_SESSION['UserId'];
$imgfile = "/music_upload/music_image/".$m_userid."_".$title.'.'.$image_mime;
$file_without_extension = $m_userid."_".$title;

//$sql2 = mq("select * from MusicInfo where m_uploader='".$userid."' and m_filename = '".$filename."' ");
//while ($board = $sql2->fetch_array())  {
//
//$title = $board['m_title'];
//$genre = $board['m_genre'];
//$artist = $board['m_artist'];
//$m_filename = $board['m_filename'];
//$image = $board['m_image'];
//if($image =="data:;base64,"){
//    $image = "/image/none.png";
//}
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="/css/file-upload.css" />
    <style>
        input[type="file"] {
            display: none;
        }
    </style>
    <script type="text/javascript" src="/js/jquery-3.3.1.min.js" charset="utf-8"></script>
    <script type="text/javascript">

        var sel_file;

        $(document).ready(function() {
            $("#music_newimg_file").on("change", handleImgFileSelect);
        });

        function handleImgFileSelect(e) {
            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);

            filesArr.forEach(function(f) {
                if(!f.type.match("image.*")) {
                    alert("확장자는 이미지 확장자만 가능합니다.");
                    return;
                }

                sel_file = f;

                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#holder").attr("src", e.target.result);
                }
                reader.readAsDataURL(f);
            });
        }

    </script>


</head>
<body>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"></div>

    <div class="panel-body">

        <div class="container">
            <h2 style="margin-bottom: 50px">Upload Your Music</h2>
            <form role="form" class="form-horizontal" id="formname2" name="formname2" method="post" action="music_upload_ok.php?filename=<?php echo urlencode($filename)?>" enctype="multipart/form-data">

                <div class="col-md-4 text-center">
                    <div class="col">
<!--                        <img src="--><?php //echo data_uri($res["picture"],$res["image_mime"]); ?><!--" alt="An elephant" />-->
                        <img id="holder" name="holder" src="<?php echo $imgfile?>" alt="..." class="rounded mx-auto d-block" style="width: 226px; height: 226px;">
<!--                        <img src="--><?php //echo $image?><!--" alt="..." class="rounded mx-auto d-block" style="width: 226px; height: 226px;">-->


<!--                        <img id="holder" src="--><?php //echo $image?><!--" class="rounded mx-auto d-block" style="width: 226px; height: 226px;"/>-->


<!--                        <div><button class="btn btn-outline-primary" style="width: 260px;margin-top: 5px;border: 1px solid #5ca7f7;">Image Upload</button></div>-->
                        <label>

                            <input type="file"  id="music_newimg_file" name="music_newimg_file" accept="image/*"/>
                            <i id="choose_music_img_btn" class="btn btn-outline-primary" style="width: 250px;margin-top: 5px;border: 1px solid #5ca7f7;">Image Upload</i>

                        </label>

                    </div>
                </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" style="margin-right: 0px">
                                                <label for="pass">Title</label>
                                                <input type="text" autocomplete=off class="form-control" name="m_title" id="m_title" value="<?php echo $title?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group" style="margin-right: 0px">
                                                <label for="email">Genre</label>
                                                <input type="text" autocomplete=off class="form-control" name ="m_genre" id="m_genre" value="<?php echo $genre?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group" style="margin-right: 0px">
                                                <label for="subject">Artist</label>
                                                <input type="text" autocomplete=off class="form-control" name ="m_artist" id="m_artist" value="<?php echo $artist?>">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group" style="margin-right: 0px">
                                                <label for="content">Description</label>
                                                <textarea class="form-control" autocomplete=off rows="10" name="m_desc" id="m_desc" placeholder="선택사항"></textarea>

                                            </div>
                                        </div>

<!--                                        <div class="col-md-6">-->
<!--                                        <div class="form-group" id="in_file" style="margin-right: 0px">-->
<!---->
<!--                                            <input class="btn" type="file" id="m_file" name="m_file" onclick="file();" accept=".mp3" value="파일선택">-->
<!--                                        </div>-->
<!--                                        </div>-->

                                        <div class="col-md-6">
                                            <div class="center-block" style='width:300px;margin-bottom: 300px'>
                                                <input class="btn btn-outline-primary" type="submit" value="업로드하기" style="font-size: 12px;border: 1px solid #5ca7f7;" id="save_btn">
                                                <a class="btn btn-outline-primary" href="music_upload_cancel.php?filename=<?php echo $filename?>&image_mime=<?php echo $image_mime?>&file_without_extension=<?php echo $file_without_extension?>" id="undo" style="font-size: 12px;border: 1px solid #5ca7f7;">취소하기</a>
                                            </div>
                                        </div>


                                    </div>


            </form>


        </div>
    </div> <!--panel end-->
</div>
</body>
<?php //}?>

</html>


