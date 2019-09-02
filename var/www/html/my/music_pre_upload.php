<!doctype html>
<?php
include ("mypage_2.php");
?>
<html>
<head>
    <style>
        input[type="file"] {
            display: none;
        }
    </style>
</head>
<body>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"></div>

    <div class="panel-body">

        <div class="container">
            <label style="background-color: #2b669a;width: 500px;height: 70px;margin-left: 340px;margin-right: 300px;margin-top: 200px;margin-bottom: 0px;"">
                <form action="music_pre_upload_ok.php" method="post" enctype="multipart/form-data">
                    <input type="file" onchange="this.form.submit()" id="music_file" name="music_file" accept=".mp3"/>
                    <i id="choose_music_btn" class="btn" style="color: white;width: 500px;font-size: 30px;margin: 5px">Choose Your Music</i>
                </form>
            </label>
            <div style="margin-left: 380px;margin-right: 300px;margin-top: 25px;margin-bottom: 300px;width: 500px;font-size: 25px;">
                (mp3 파일만 업로드 할 수 있습니다.)
            </div>
        </div>
    </div>
</div>
</body>
</html>