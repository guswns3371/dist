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
$filename = $_GET['m_filename'];
$uploader = $_GET['m_uploader'];
$m_idx = $_GET['m_idx'];

$trim_filename = str_replace("%20", " ", $filename);
$sql2 = mq("select * from MusicInfo where m_filename = '$trim_filename'" );
while ($board = $sql2->fetch_array())  {
    $artist = $board['m_artist'];
    $title = $board['m_title'];
    $genre = $board['m_genre'];
    $image = $board['m_image'];
    $filename = $board['m_filename'];
    $descript = $board['m_descript'];
}




if(strpos($artist,"%20") !== false){
    $artist = str_replace("%20"," ",$artist);
}

$m_userid = $_SESSION['UserId'];
$imgfile = $image;
$file_without_extension = $m_userid."_".$title;

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
            <form role="form" class="form-horizontal" id="formname2" name="formname2" method="post"
                  action="music_edit_ok.php?filename=<?php echo $filename?>&uploader=<?php echo $uploader?>&m_idx=<?php echo $m_idx?>" enctype="multipart/form-data">

                <div class="col-md-4 text-center">
                    <div class="col">
                        <img id="holder" name="holder" src="<?php echo $imgfile?>" alt="..." class="rounded mx-auto d-block" style="width: 226px; height: 226px;">
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
                            <textarea class="form-control" autocomplete=off rows="10" name="m_desc" id="m_desc" ><?php echo $descript?></textarea>

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="center-block" style='width:300px;margin-bottom: 300px'>
                            <input class="btn btn-outline-primary" type="submit" value="편집하기" style="font-size: 12px;border: 1px solid #5ca7f7;" id="save_btn">
                            <a class="btn btn-outline-primary" href="javascript:history.back()" id="undo" style="font-size: 12px;border: 1px solid #5ca7f7;">취소하기</a>
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


