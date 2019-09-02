<!doctype html>
<?php
include ("mypage_2.php");
$m_idx = $_GET['m_idx'];
header('Content-Type: text/html; charset=utf-8'); // utf-8인코딩

$db = new mysqli("localhost","root","wnsgusgk3537","user");
$db->set_charset("utf8");

function mq($sql)
{
    global $db;
    return $db->query($sql);
}
$userid_session = $_SESSION['UserId'];
$m_idx = $_GET['m_idx'];

$sql =mq("select * from MusicInfo where m_idx= '$m_idx'");
while ($row = $sql->fetch_array()){
    $m_title = $row['m_title'];
    $m_genre= $row['m_genre'];
    $m_uploader = $row['m_uploader'];
    $m_artist = $row['m_artist'];
    $m_descript = $row['m_descript'];
    $m_image = $row['m_image'];
    $m_length = $row['m_length'];
    $m_filepath = $row['m_filepath'];
    $m_filename = $row['m_filename'];
}
?>
<?php
$count = 0;
$sql9 = mq("select * from LikedMusic where liked_m_m_idx = '$m_idx' order by liked_m_idx desc");
$rep_count_7 = mysqli_num_rows($sql9);
?>


<html>
<head>
    <style>
        body{
            background-color: #f6f6f6;
        }
        #background_img{
            background-image: url("<?php echo $m_image?>");

            width: 1110px; height: 280px;

            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;

        }
        #user_img{
            background-image: url("<?php echo $m_image?>");
            width: 300px; height: 300px; margin-top: 40px;margin-left: 50px;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        img {
            border-radius: 50%;
        }
    </style>
</head>
<body>
<!-- 이미지-->
<div class="" id="background_img" style="width: 1700px;height: 400px;margin:0 auto;">
    <div class="media-body" >
        <label class="user_img" id="user_img" style="margin-right: 30px"> </label>

        <label>
            <h1 class="d-inline-flex p-2" style="background-color: #505759;color: white; margin-top: 50px;margin-left: 30px">❤ <?php echo $rep_count_7?> people likes</h1>
            <div></div>
            <h1 class="d-inline-flex p-2" style="background-color: #505759;color: white; margin-top: 0px;margin-left: 30px"><?php echo $m_title?></h1>

            <div>
                <h2 class="d-inline-flex p-2" style="background-color: #505759;color: white; margin-top: 0px;margin-left: 30px">by <?php echo $m_artist?></h2>
                <a style="margin-left: 30px;background-color: #3c3c3c; color: white;padding-bottom: 3px;padding-top: 3px"
                   class="d-inline-flex p-2" href="music_genre_list.php?m_genre=<?php echo $m_genre?>">#<?php echo $m_genre?></a>
        </label>
    </div>
</div>
<!-- 이미지-->
<div class=""  style="height: 600px;width: 1750px;margin-left: 30px;padding: 30px">

    <!--                        좋아요 누른 사람 리스트 나오는 곳-->
    <article id="likes_list" class="likes_list">

        <hr class="one">
        <div>
            <div>
                <ul>
                    <li>
                        <?php

                        while(($board9 = $sql9->fetch_array())){

                            $liked_m_m_idx = $board9['liked_m_m_idx'];
                            $liked_m_userid = $board9['liked_m_userid'];

                            $sql9_ = mq("select * from UserInfo where id ='$liked_m_userid' order by Userkey desc");
                            while (($board_ = $sql9_->fetch_array()) ){

                                $userimg_ = $board_['userimg'];
                                $id_= $board_['id'];
                                if(strpos($userimg_," ") !== false){
                                    $userimg_ = str_replace(" ","%20",$userimg_); //문자열에 ' 문자가 있으면 mysql 신택스 문제가 생긴다
                                }
                                $userimg_path_ = "/image/userimg/".$userimg_;
                                ?>

                                <label class="likes_top_5list" id="likes_top_5list" >
                                    <div class="" id="liked_music_row" style="margin-bottom: 20px">
                                        <figure style="width: 200px">
                                            <img src=<?php echo $userimg_path_?> alt="..."  style="width: 140px; height: 140px;">
                                            <figcaption>
                                                <a style="font-size: 18px;color: black;margin-left: 12px;margin-top: 10px" href="music_mymusic.php?m_uploader=<?php echo $id_?>">
                                                    <?php echo $id_?></a>
                                            </figcaption>
                                        </figure>
                                    </div>
                                </label>

                            <?php }?>
                        <?php }?>

                    </li>

                </ul>
            </div>
        </div>
    </article>
    <!--                        좋아요  누른 사람 리스트 나오는 곳-->
</div>
</body>
</html>