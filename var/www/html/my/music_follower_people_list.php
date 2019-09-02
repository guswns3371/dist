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
$followed_user_id = $_GET['followed_user_id'];


$sql =mq("select * from FollowUser where followed_user_id= '$followed_user_id'");
$rep_count_9 = mysqli_num_rows($sql);

$sql2 = mq("select * from UserInfo where id = '$followed_user_id'"); // 팔로우 당한 사람 info
if($row2 = $sql2->fetch_array()){
    $userimg = $row2['userimg'];
//    if(strpos($userimg,"'") !== false){
//        $userimg = str_replace(" ","%20",$userimg); //문자열에 ' 문자가 있으면 mysql 신택스 문제가 생긴다
//    }
    $userimg = "http://127.0.0.1/image/userimg/".$userimg;
    ////////////////////////////////////////////
    $userbackimg = $row2['userbackimg'];

    $userbackimg = "http://127.0.0.1/image/userbackimg/".$userbackimg;
}
?>



<html>
<head>
    <style>
        body{
            background-color: #f6f6f6;
        }
        #background_img{
            background-image: url("<?php echo $userbackimg?>");

            width: 1110px; height: 280px;

            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;

        }
        #user_img{
            background-image: url("<?php echo $userimg?>");
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
            <h1 class="d-inline-flex p-2" style="background-color: #505759;color: white; margin-top: 50px;margin-left: 30px">❤ <?php echo $rep_count_9?> people follow</h1>
            <div></div>
            <h1 class="d-inline-flex p-2" style="background-color: #505759;color: white; margin-top: 0px;margin-left: 30px"><?php echo $followed_user_id?></h1>

            <div>


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

                        while ($row = $sql->fetch_array()){
                            $followed_user_id = $row['followed_user_id']; //팔로우 당한사람
                            $following_user_id = $row['following_user_id'];//팔로우 하는 사람

                            $sql9_ = mq("select * from UserInfo where id ='$following_user_id' order by Userkey desc");
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