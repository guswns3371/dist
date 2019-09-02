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
$userid_session = $_SESSION['UserId'];
$m_uploader = $_GET['m_uploader'];
$sql3 =mq("select * from UserInfo where id= '$m_uploader'");
while ($row2 = $sql3->fetch_array()){
    $username= $row2['username'];
    $userid = $row2['id'];
    $usermig = $row2['userimg'];
    $userbackimg = $row2['userbackimg'];

    $usermig = str_replace(" ","%20",$usermig);
    $userbackimg = str_replace(" ","%20",$userbackimg); // 파일 이름에 띄어쓰기 있으면 노노 -> 공백을 %20으로 채워야 한다
    error_log("userbackimg :".$userbackimg);
}
if($usermig == ""){
    $usermig ="http://127.0.0.1/image/white.jpg";
}else{
    $usermig = "http://127.0.0.1/image/userimg/".$usermig;
}
if($userbackimg == ""){
    $userbackimg ="http://127.0.0.1/image/shit.jpg";
}else{
    $userbackimg = "http://127.0.0.1/image/userbackimg/".$userbackimg;
}
error_log("userbackimg2 :".$userbackimg);
$sql2 = mq("select * from MusicInfo where m_uploader ='$m_uploader' order by m_idx desc");
$rep_count_2 = mysqli_num_rows($sql2);

$sql7 = mq("select * from LikedMusic where liked_m_userid ='$m_uploader'");
$rep_count_7 = mysqli_num_rows($sql7);
?>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        $(document).ready(function(){

///////////////////////////////////////////////////////////////////////
        });
        $('body').on('click','.btn_delete',function(){
            var r= confirm("정말 삭제 하시겠습니까?")
            if(r == true){
                var obj = $(this).closest("#media-body").find("#filename_val");
                var obj2 = $(this).closest("#media-body").find("#uploader_val");
                // alert("music_delete.php?m_filename="+obj.val()+"&m_uploader="+obj2.val()+"")
                location.href = "music_delete.php?m_filename="+obj.val()+"&m_uploader="+obj2.val()+"";
            }else {

            }
        });
        $('body').on('click','.btn_edit',function(){
            var r= confirm("수정 하시겠습니까?")
            if(r == true){
                var obj = $(this).closest(".media-body-2").find("#filename_val");
                var obj2 = $(this).closest(".media-body-2").find("#uploader_val");
                var obj3 = $(this).closest(".media-body-2").find("#m_idx");
                // alert("music_delete.php?m_filename="+obj.val()+"&m_uploader="+obj2.val()+"")
                location.href = "music_edit.php?m_filename="+obj.val()+"&m_uploader="+obj2.val()+"&m_idx="+obj3.val();
            }else {

            }
        });
        //////////////////////////////////////////////////////////////////////좋아요
        $('body').on('click','.like_btn_area',function(){
            var obj = $(this).closest(".media-body-2").find("#m_idx");
            var obj2 = $(this).closest(".media-body-2").find("#likebtn");
            var obj3 = $(this).closest(".media-body-2").find("#like_btn_area");
            var userid = "<?php echo $userid_session?>";
            if(userid !="") {
                if (obj2.val() == "like") {
                    $.ajax({
                        url: "music_like.php",
                        type: "POST",
                        data: {m_idx: obj.val()},
                    }).done(function (data) {

                        if (data != "") {
                            obj3.html("")
                            obj3.html(data)
                            $("#likes_list").load(location.href + " #likes_list>*", ""); //특정 div 만 새로 고침 하는것이다 대박쓰 개쩔어
                        } else {
                            alert("좋아요 체크에 실패 했습니다")
                        }

                    });

                } else if (obj2.val() == "liked") {
                    $.ajax({
                        url: "music_unlike.php",
                        type: "POST",
                        data: {m_idx: obj.val()},
                    }).done(function (data) {

                        if (data != "") {
                            obj3.html("")
                            obj3.html(data)
                            $("#likes_list").load(location.href + " #likes_list>*", ""); //특정 div 만 새로 고침 하는것이다 대박쓰 개쩔어
                        } else {
                            alert("좋아요 체크에 실패 했습니다")
                        }

                    });

                }
            }else {
                alert("로그인 후 좋아요를 누르실 수 있습니다");
            }

        });
        //////////////////////////////////////////////////////////////////////좋아요

        ///////////////////////////////////////////////////////////////////////팔로우
        $('body').on('click','.follow_btn_area',function(){
            var obj = $(this).closest(".extra_btn").find("#followed_userid");
            var obj2 = $(this).closest(".extra_btn").find("#following_userid");
            var obj4 = $(this).closest(".extra_btn").find("#followbtn");
            var obj3 = $(this).closest(".extra_btn").find("#follow_btn_area");

            if(obj4.val() == "follow"){
                $.ajax({
                    url: "user_follow.php",
                    type: "POST",
                    data:{ followed_userid : obj.val(),
                        following_userid : obj2.val()

                    },
                }).done(function(data) {

                    if(data !=""){
                        obj3.html("")
                        obj3.html(data)
                        $("#InfoStats").load(location.href + " #InfoStats>*", ""); //특정 div 만 새로 고침 하는것이다 대박쓰 개쩔어
                        $("#following_list").load(location.href + " #following_list>*", ""); //특정 div 만 새로 고침 하는것이다 대박쓰 개쩔어
                        $("#follower_list").load(location.href + " #follower_list>*", ""); //특정 div 만 새로 고침 하는것이다 대박쓰 개쩔어
                    }else {
                        alert("팔로우 체크에 실패 했습니다")
                    }

                });

            }else if(obj4.val() == "followed"){
                $.ajax({
                    url: "user_unfollow.php",
                    type: "POST",
                    data:{ followed_userid : obj.val(),
                        following_userid : obj2.val()
                    },
                }).done(function(data) {

                    if(data !=""){
                        obj3.html("")
                        obj3.html(data)
                        $("#InfoStats").load(location.href + " #InfoStats>*", ""); //특정 div 만 새로 고침 하는것이다 대박쓰 개쩔어
                        $("#following_list").load(location.href + " #following_list>*", ""); //특정 div 만 새로 고침 하는것이다 대박쓰 개쩔어
                        $("#follower_list").load(location.href + " #follower_list>*", ""); //특정 div 만 새로 고침 하는것이다 대박쓰 개쩔어
                    }else {
                        alert("팔로우 취소 체크에 실패 했습니다")
                    }

                });

            }

        });
        ///////////////////////////////////////////////////////////////////////팔로우

        ///////////////////////////////////////////////////////////////////////오디오
        $('body').on('click','.audio',function(){
            $(".audio").on("play", function() {
                $(".audio").not(this).each(function(index, audio) {
                    audio.pause();
                    audio.currentTime = 0;
                });
            });
        });
        ///////////////////////////////////////////////////////////////////////오디오
    </script>
    <style>
        body{
            background-color: #f6f6f6;
        }
        #background_img{
            background-image: url("<?php echo $userbackimg?>");
            /*ㅅㅂ url(<?php echo $userbackimg?>) => url("<?php echo $userbackimg?>") 이렇게 해줘야 한다 ㅅㅂ!!!!*/
            width: 1110px; height: 280px;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        #user_img{
            background-image: url("<?php echo $usermig?>");
            width: 220px; height: 220px; margin-top: 30px;margin-left: 10px;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;

        }
        .btn{
            border: 1px solid;
        }
        input[type="file"] {
            display: none;
        }
        .user_img {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 6px 12px;
            cursor: pointer;
        }
    </style>
</head>

<body>
<!-- 배경 이미지 넣는곳-->
<div class="" id="background_img" style="width: 1700px;margin:0 auto;">
<!--    <div class="img-responsive"  style="background-image: url('http://127.0.0.1/image/shit.jpg'); width: 1110px; height: 280px "></div>-->
<!--    <img src="/image/none.png" class="rounded mx-auto d-block" alt="..." style="width: 1110px; height: 280px">-->

    <div class="media-body" >
        <label class="user_img" id="user_img" style="margin-left: 20px">
            <?php
            if($_SESSION['UserId']== $userid){
            ?>
            <form action="userimage_ok.php?userid=<?php echo $userid?>" method="post" enctype="multipart/form-data">
                <input type="file" onchange="this.form.submit()" id="userimg_file" name="userimg_file" accept="image/*"/>
                <i id="userimg_edit_btn"class="btn pull-right" style="display: none;margin-top: 160px;margin-right: 40px;padding-top: 2px;padding-bottom: 2px;background-color: #dbdbdb;">Update Image</i>
            </form>
            <?php }?>
        </label>

        <label>
            <label >
                <?php
                if($_SESSION['UserId']== $userid){
                    ?>
                    <form action="backimg_ok.php?userid=<?php echo $userid?>" method="post" enctype="multipart/form-data">
                        <input type="file" onchange="this.form.submit()" id="backimg_file" name="backimg_file" accept="image/*"/>
                        <i id="backimg_edit_btn"  class="btn pull-right"
                           style="display: none;margin-left: 1300px;margin-bottom: 120px;margin-top: 0px;padding-top: 2px;padding-bottom: 2px;background-color: #dbdbdb">Update Image</i>
                    </form>
                <?php }?>
            </label>
            <div></div>
            <h2 class="d-inline-flex p-2" style="background-color: #505759;color: white; margin-top: 0px;margin-left: 30px"><?php echo $m_uploader?></h2>

            <div>
                <h4 class="d-inline-flex p-2" style="background-color: #505759;color: white; margin-top: 0px;margin-left: 30px"><?php echo $username?></h4>

        </label>
    </div>

<!--        <img src="/image/white.jpg" class="rounded float-left" alt="..." style="width: 220px; height: 220px; margin-top: 30px;margin-left: 10px; ">-->

    </div>
</div>
<hr class="one">
<div>
    <div class="sidenav pull-right" style="height: 1000px;width: 550px;margin-right: 100px;padding-left: 30px">
        <?php
        $sql5 = mq("select * from FollowUser where followed_user_id ='$m_uploader' and following_user_id = '$userid_session'");
        $rep_count2 = mysqli_num_rows($sql5);
        ?>
        <article id="extra_btn" class="extra_btn">
            <input id="followed_userid" name="followed_userid" value="<?php echo $m_uploader?>" style="display: none"/>
            <input id="following_userid" name="following_userid" value="<?php echo $userid_session?>" style="display: none"/>

            <?php
            if($m_uploader != $userid_session){
            ?>

            <label id="follow_btn_area" class="follow_btn_area">

            <?php
            if($rep_count2 == 1){
            ?>
                <label id="btn_followed" class="btn_followed pull-right">
                    <button class="btn btn-outline-primary " id="followbtn" value="followed" style="padding-bottom: 3px;padding-top: 3px;
            margin-left: 0px; margin-bottom: 5px;background-color: #2b669a;color: white;">Following</button>
                </label>
            <?php }else {?>
                <label id="btn_follow" class="btn_follow pull-right">
                    <button class="btn btn-outline-primary " id="followbtn" value="follow"  style="padding-bottom: 3px;padding-top: 3px;
            margin-left: 0px; margin-bottom: 5px">Follow</button>
                </label>
            <?php }?>
            </label>

            <?php }?>

        </article>
<!--        사용자info-->
      <article id="InfoStats" style="margin-bottom: 150px">
          <table class="table">
              <tbody>
              <tr>
                  <td>
                      <a>
                          <h3 scope="col" style="font-size: 17px">Followers</h3>
                          <?php
                          $sql99 = mq("select * from FollowUser where followed_user_id ='$m_uploader'");
                          $rep_count33 = mysqli_num_rows($sql99);
                          ?>
                          <div style="font-size: 25px"><?php echo $rep_count33?></div>
                      </a>
                  </td>
                  <td>
                      <a>
                          <h3 scope="col" style="font-size: 17px">Following</h3>
                          <?php
                          $sql88 = mq("select * from FollowUser where following_user_id ='$m_uploader'");
                          $rep_count22 = mysqli_num_rows($sql88);
                          ?>
                          <div style="font-size: 25px"><?php echo $rep_count22?></div>
                      </a>
                  </td>   <td>
                      <a>
                          <h3 scope="col" style="font-size: 17px">Tracks</h3>
                          <div style="font-size: 25px"><?php echo $rep_count_2?></div>
                      </a>
                  </td>

              </tr>
              </tbody>
          </table>
      </article>
        <!--                        좋아요 곡 탑5 리스트 나오는 곳-->
        <article id="likes_list" class="likes_list">
            <a>
                <label class="likes_count" id="likes_count">
                    <h4> ❤ <?php echo $rep_count_7?> likes <a class="pull-right" style="margin-right: 20px"
                                                              href="music_liked_list.php?liked_m_userid=<?php echo $m_uploader?>">View all</a></h4>
                </label>

            </a>
            <hr class="one">
            <div>
                <div>
                    <ul>
                        <?php
                        $count = 0;
                        $sql9 = mq("select * from LikedMusic where liked_m_userid = '$m_uploader' order by liked_m_idx desc");
                        while($board9 = $sql9->fetch_array()){
                            $liked_m_m_idx = $board9['liked_m_m_idx'];
                            $sql8 = mq("select * from MusicInfo where m_idx ='$liked_m_m_idx' order by m_idx desc");


                        while(($board8 = $sql8->fetch_array()) && ($count<5)){
                            $count++;
                            $m_idx9 = $board8['m_idx'];
                            $m_uploader9 = $board8['m_uploader'];
                            $m_title9 = $board8['m_title'];
                            $m_genre9 = $board8['m_genre'];
                            $m_artist9 = $board8['m_artist'];
                            $m_likecnt9 = $board8['m_likecnt'];
                            $m_playcnt9 = $board8['m_playcnt'];
                            $m_filename9 = $board8['m_filename'];
                            $m_length9 = $board8['m_length'];
                            $m_image9 = $board8['m_image'];


                            if(strlen($m_title9)>50)
                            {
                                $m_title9=str_replace($board8['m_title'],mb_substr($board8['m_title'],0,50,"utf-8")."...",$board8['m_title']); //title이 30을 넘어서면 ...표시
                            }
                        ?>
                            <li>
                                <label class="likes_top_5list" id="likes_top_5list">
                                    <div class="media" id="liked_music_row" style="margin-bottom: 20px">
                                        <input id="liked_music_idx" name="liked_music_idx" value="<?php echo $m_idx9?>" style="display: none"/>
                                        <img src=<?php echo $m_image9?> alt="..."  style="width: 70px; height: 70px;">
                                        <label>
                                            <div class="" style="padding-left: 10px">
                                                <a style="font-size: 18px;color: black" href="music_innerpage.php?m_idx=<?php echo $m_idx9?>&m_artist=<?php echo $m_artist9?>">
                                                    <?php echo $m_artist9?><br><?php echo $m_title9?></a>
                                            </div>
                                        </label>
                                    </div>
                               </label>
                        </li>

                        <?php }?>
                        <?php }?>

                    </ul>
                </div>
            </div>
        </article>
        <!--                        좋아요 곡 탑5 리스트 나오는 곳-->


        <?php
        $count_ = 0;
        $sql999 = mq("select * from FollowUser where followed_user_id = '$m_uploader' order by follow_idx desc");

        ?>
        <!--                        팔로우 한 사람들 나오는 곳-->
        <article id="follower_list" class="follower_list">
            <a>
                <label class="likes_count" id="likes_count">
                    <h4> <img src="/image/me.png" style="width: 15px;height: 15px"> <?php echo $rep_count33?> followers <a class="pull-right" style="margin-right: 20px"
                                                                     href="music_follower_people_list.php?followed_user_id=<?php echo $m_uploader?>">View all</a></h4>
                </label>
            </a>
            <hr class="one">
            <div>
                <div>
                    <ul>
                        <li>
                            <?php
                            while(($board9 = $sql999->fetch_array()) &&($count_<6)){
                                $count_++;
                                $followed_user_id = $board9['followed_user_id'];
                                $following_user_id = $board9['following_user_id'];

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
                                            <figure style="width: 80px">
                                                <img src=<?php echo $userimg_path_?> alt="..."  style="width: 70px; height: 70px;border-radius: 50%;">
                                                <figcaption>

                                                    <a style="font-size: 13px;color: black;" href="music_mymusic.php?m_uploader=<?php echo $id_?>">
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
        <!--                        팔로우 한 사람들 나오는 곳-->


        <?php
        $count_2 = 0;
        $sql999_2 = mq("select * from FollowUser where following_user_id = '$m_uploader' order by follow_idx desc");

        ?>
        <!--        내가 팔로우 한 사람들 나오는 곳-->
        <article id="following_list" class="following_list">
            <a>
                <label class="likes_count" id="likes_count">
                    <h4> <img src="/image/followers.png" style="width: 15px;height: 15px"> <?php echo $rep_count22?> following <a class="pull-right" style="margin-right: 20px"
                                                                                                                           href="music_following_people_list.php?followed_user_id=<?php echo $m_uploader?>">View all</a></h4>
                </label>
            </a>
            <hr class="one">
            <div>
                <div>
                    <ul>
                        <li>
                            <?php
                            while(($board9_2 = $sql999_2->fetch_array()) &&($count_2<6)){
                                $count_2++;
                                $followed_user_id_2 = $board9_2['followed_user_id'];
                                $following_user_id_2 = $board9_2['following_user_id'];

                                $sql9_2 = mq("select * from UserInfo where id ='$followed_user_id_2' order by Userkey desc");
                                while (($board_2 = $sql9_2->fetch_array()) ){

                                    $userimg_2 = $board_2['userimg'];
                                    $id_2= $board_2['id'];
                                    if(strpos($userimg_2," ") !== false){
                                        $userimg_2 = str_replace(" ","%20",$userimg_2); //문자열에 ' 문자가 있으면 mysql 신택스 문제가 생긴다
                                    }
                                    $userimg_path_2 = "/image/userimg/".$userimg_2;

                                    ?>

                                    <label class="likes_top_5list" id="likes_top_5list" >
                                        <div class="" id="liked_music_row" style="margin-bottom: 20px">
                                            <figure style="width: 80px">
                                                <img src=<?php echo $userimg_path_2?> alt="..."  style="width: 70px; height: 70px;border-radius: 50%;">
                                                <figcaption>

                                                    <a style="font-size: 13px;color: black;" href="music_mymusic.php?m_uploader=<?php echo $id_2?>">
                                                        <?php echo $id_2?></a>


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
        <!--        내가 팔로우 한 사람들 나오는 곳-->
    </div>

    <div class="main" >
    <div class="container22"></div>
    </div>


<!--    <div class="main" >-->
<!---->
<!--        --><?php
////        $sql2 = mq("select * from MusicInfo where m_uploader ='$m_uploader' order by m_idx desc");
////        $rep_count_2 = mysqli_num_rows($sql2);
//        while ($board = $sql2->fetch_array())  {
//            $m_idx = $board['m_idx'];
//            $m_uploader = $board['m_uploader'];
//            $m_title = $board['m_title'];
//            $m_genre = $board['m_genre'];
//            $m_artist = $board['m_artist'];
//            $m_likecnt = $board['m_likecnt'];
//            $m_playcnt = $board['m_playcnt'];
//            $m_filename = $board['m_filename'];
//            $m_length = $board['m_length'];
//            $m_image = $board['m_image'];
//            if($m_image =="data:;base64,"){
//                $m_image = "/image/none.png";
//            }
//          //  error_log("music home :".$m_uploader."/".$m_title."/".$m_genre."/".$m_artist."/".$m_likecnt."/".$m_playcnt."/".$m_filename);
//            ?>
<!---->
<!--            <div class="" style="margin-bottom: 20px">-->
<!--                <div class="media" style="margin-left: 100px">-->
<!--                    <div><h4><a href="music_mymusic.php?m_uploader=--><?php //echo $m_uploader?><!--">-->
<!--                                <img src=--><?php //echo $usermig?><!-- alt='file' title='file' style="border-radius: 50%;width: 40px;height: 40px;margin-right: 15px"/> --><?php //echo $m_uploader?><!--</a></h4>-->
<!---->
<!--                        <img src="--><?php //echo $m_image?><!--" alt="..."  style="width: 226px; height: 226px;">-->
<!--                    </div>-->
<!--                    <div class="media-body-2" id="media-body" style="margin-left: 30px">-->
<!--                        <div id="audio_player"></div>-->
<!--                        <input id="m_idx" name="m_idx" value="--><?php //echo $m_idx?><!--" style="display: none"/>-->
<!--                        <input id="filename_val" name="filename_val" value="--><?php //echo $m_filename?><!--" style="display: none"/>-->
<!--                        <input id="uploader_val" name="uploader_val" value="--><?php //echo $m_uploader?><!--" style="display: none"/>-->
<!--                        <p style="margin-top: 60px; margin-left: 15px;font-size: 16px;">--><?php //echo $m_artist?><!--</p>-->
<!--                        <a style="margin-left: 30px;background-color: #3c3c3c; color: white;padding-bottom: 1px;padding-top: 1px;font-size: 15px"-->
<!--                           class="d-inline-flex p-2 pull-right" href="music_genre_list.php?m_genre=--><?php //echo $m_genre?><!--">#--><?php //echo $m_genre?><!--</a>-->
<!--                        <a href="music_innerpage.php?m_idx=--><?php //echo $m_idx?><!--&m_artist=--><?php //echo $m_artist?><!--" style="margin-left: 10px;font-size: 18px;color: black" id="m_title"> --><?php //echo $m_title?><!--</a>-->
<!---->
<!--                        <div>-->
<!--                            <audio class="audio" controls style="width: 854px; margin-top: 30px;margin-bottom: 20px">-->
<!--                                <source src="/music_upload/--><?php //echo $m_filename?><!--" type="audio/mpeg">-->
<!--                            </audio>-->
<!--                        </div>-->
<!---->
<!--                        <div class="btn pull-right" style="padding-bottom: 3px;padding-top: 3px;margin-top: 10px;border: 1px solid transparent;">-->
<!--                            --><?php //echo $m_length?>
<!--                        </div>-->
<!--                        --><?php
//                        $sql_ = mq("select * from MusicReply where mre_m_idx ='$m_idx'");
//                        $rep_count_ = mysqli_num_rows($sql_);
//                        ?>
<!--                        <div class="btn pull-right"  style="padding-bottom: 3px;-->
<!--                        padding-top: 3px;margin-bottom: 5px;margin-top: 10px;border: 1px solid transparent;">-->
<!--                            <img  src="/image/comment.png" style="margin-left: 5px"> --><?php //echo $rep_count_?>
<!--                        </div>-->
<!--                        <div class="btn pull-right"style="margin-left: 10px;padding-bottom: 3px;-->
<!--                        padding-top: 3px;margin-bottom: 5px;margin-top: 10px;margin-right: 5px;border: 1px solid transparent;" >▶ 재생횟수--><?php //echo $m_playcnt?><!--</div>-->
<!--                        <div   style="margin-top: 10px">-->
<!---->
<!--                            <!--                        좋아요 버튼---->
<!--                            --><?php
//                            $sql4 = mq("select * from LikedMusic where liked_m_m_idx ='$m_idx'");
//                            $rep_count = mysqli_num_rows($sql4);
//                            //                        $sql4 = mq("select * from LikedMusic where liked_m_m_idx ='$m_idx' and liked_m_userid ='$m_uploader'");
//                            //            if ($board4 = $sql4->fetch_array())  {
//                            $sql5 = mq("select * from LikedMusic where liked_m_m_idx ='$m_idx' and liked_m_userid = '$userid_session'");
//                            $rep_count2 = mysqli_num_rows($sql5);
//                            // error_log("rep_count2 : ".$rep_count2." / ".$m_idx." / ".$userid);
//                            ?>
<!--                            <label class="like_btn_area" id="like_btn_area">-->
<!--                                --><?php
//                                if($rep_count2 == 1){
//                                    ?>
<!--                                    <label class="btn_liked" >-->
<!--                                        <button class="btn btn-outline-primary" id="likebtn" style="padding-bottom: 3px;padding-top: 3px;-->
<!--                            margin-left: 10px; margin-bottom: 5px;background-color: #2b669a;color: white;" value="liked" >❤ --><?php //echo $rep_count?><!--</button>-->
<!--                                    </label>-->
<!---->
<!--                                --><?php //}else {?>
<!--                                    <label class="btn_like" >-->
<!--                                        <button class="btn btn-outline-primary" id="likebtn" style="padding-bottom: 3px;padding-top: 3px;-->
<!--                            margin-left: 10px; margin-bottom: 5px;" value="like" >❤ --><?php //echo $rep_count?><!--</button>-->
<!--                                    </label>-->
<!--                                --><?php //}?>
<!--                            </label>-->
<!--                            <!--                        좋아요 버튼---->
<!---->
<!--                            --><?php
//                            if($_SESSION['UserId'] == $m_uploader){
//                                ?>
<!--                                <label class="btn_delete">-->
<!--                                    <button class="btn btn-outline-primary" id="deletebtn" onclick="music_delete();" style="padding-bottom: 3px;padding-top: 3px;-->
<!--                                margin-left: 10px; margin-bottom: 5px">Delete</button>-->
<!--                                </label>-->
<!--                            --><?php //} ?>
<!--                            --><?php
//                            if($_SESSION['UserId'] == $m_uploader){
//                                ?>
<!--                                <label class="btn_edit">-->
<!--                                    <button class="btn btn-outline-primary" id="editbtn" onclick="music_edit();" style="padding-bottom: 3px;padding-top: 3px;margin-left: 10px; margin-bottom: 5px">Edit</button>-->
<!--                                </label>-->
<!--                            --><?php //} ?>
<!---->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--        --><?php //} ?>
<!---->
<!--    </div>-->



</div>



</body>
<!-- script를 맨 마지막에 놯야지 실행 된다-->
<script>
    var editButton = document.getElementById('edit_btn');
    var favDialog = document.getElementById('favDialog');


    // // “Update details” button opens the <dialog> modally
    // editButton.onclick = function() {
    //      favDialog.showModal();
    // }user_edit_btn

    $(document).ready(function () {
        $(document).on('mouseenter', '#background_img', function () {
            $("#background_img").find("#backimg_edit_btn").show();
        }).on('mouseleave', '.media-body', function () {
            $("#background_img").find("#backimg_edit_btn").hide();
        });
    });
    $(document).ready(function () {
        $(document).on('mouseenter', '.user_img', function () {
            $(".user_img").find("#userimg_edit_btn").show();
        }).on('mouseleave', '.user_img', function () {
            $(".user_img").find("#userimg_edit_btn").hide();
        });
    });
    //
    // //좋아요 버튼이 클릭되었을 때
    // $(document).on('click','#liked_music_row', function(){
    //     var obj = $(this).closest("#liked_music_row").find("#liked_music_idx");
    //    // alert(obj.val());
    // });


</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<script>
    var start =0;
    var limit =5;
    var reachedMax = false;

    $(window).scroll(function () {
        if($(window).scrollTop() == $(document).height() - $(window).height())
            getData();
    });

    $(document).ready(function () {
        getData();
    });
    function getData() {
        if(reachedMax)
            return;

        $.ajax({
            url: 'music_mymusic_list_infinite_scroll.php',
            method : 'POST',
            dataType: 'text',
            data:{
                getData : 1,
                start : start,
                limit: limit,
                m_uploader : "<?php echo $m_uploader?>"
            },
            success:function (response) {
                if(response == 'reachedMax'){
                     start =0;
                     limit =5;
                    reachedMax = true;
                }else {
                    start +=  limit;
                    $(".container22").append(response);
                }
            }
        });
    }
    //////////////////////////////////////////////////////
</script>
</html>