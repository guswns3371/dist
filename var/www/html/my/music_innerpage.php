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
$sql2 =mq("select * from UserInfo where id= '$m_uploader'");
while ($row2 = $sql2->fetch_array()){
    $userimg = $row2['userimg'];
    $userimg = "/image/userimg/".$userimg;
}

$sql3 =mq("select * from UserInfo where id= '$userid_session'");
while ($row3 = $sql3->fetch_array()){
    $user_session_img = $row3['userimg'];
    $user_session_img = "/image/userimg/".$user_session_img;

}
if($userid_session == ""){
    $user_session_img = "/image/white.jpg";
}
?>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".btn_delete").click(function() {
                var r= confirm("정말 삭제 하시겠습니까?")
                if(r == true){
                    var obj = $(this).closest(".media-body").find("#filename_val");
                    var obj2 = $(this).closest(".media-body").find("#uploader_val");
                    // alert("music_delete.php?m_filename="+obj.val()+"&m_uploader="+obj2.val()+"")
                    location.href = "music_delete.php?m_filename="+obj.val()+"&m_uploader="+obj2.val()+"";
                }else {

                }
            });

            $(".btn_edit").click(function() {
                var r= confirm("수정 하시겠습니까?")
                if(r == true){
                    var obj = $(this).closest(".media-body").find("#filename_val");
                    var obj2 = $(this).closest(".media-body").find("#uploader_val");
                    var obj3 = $(this).closest(".media-body").find("#m_idx");
                    // alert("music_delete.php?m_filename="+obj.val()+"&m_uploader="+obj2.val()+"")
                    location.href = "music_edit.php?m_filename="+obj.val()+"&m_uploader="+obj2.val()+"&m_idx="+obj3.val();
                }else {

                }
            });
            //////////////////////////////////////////////////////////
            $(".like_btn_area").click(function(){
                var obj = $(this).closest(".media-body").find("#m_idx");
                var obj2 = $(this).closest(".media-body").find("#likebtn");
                var obj3 = $(this).closest(".media-body").find("#like_btn_area");
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
///////////////////////////////////////////////////////////////////////

        });
        function music_reply(ele) {
            var obj = $(this).closest("#music_reply_form").find("#music_reply");
            var audio = document.getElementById("music_audio");
            if(event.key === 'Enter') {
               // alert(ele.value);

                    $.ajax({
                        url: "music_reply_ok.php",
                        type: "POST",
                        data:{ mre_content : ele.value,
                                 m_idx : <?php echo $m_idx?>,
                            currenttime : audio.currentTime
                        },
                    }).done(function(data) {

                        if(data == 0){
                            alert("댓글 내용을 입력해주세요")
                        }
                        if(data == 1){
                           // location.reload();
                            document.getElementById("music_reply").value = "";
                            $("#music_reply_list_content").load(location.href + " #music_reply_list_content>*", ""); //특정 div 만 새로 고침 하는것이다 대박쓰 개쩔어
                           // $("#comments_btn").load(location.href + " #comments_btn>*", ""); //특정 div 만 새로 고침 하는것이다 대박쓰 개쩔어
                        }
                        if(data == 2){
                            alert("댓글달기에 실패 했습니다")
                        }
                        if(data ==3){
                            alert("로그인 후 댓글을 달 수 있습니다")
                        }


                    });


            }
        }

///////////////////////////////// 특정시간 틀기
        $(document).ready(function(){

        });// 이속에다가 밑에 코드를 넣으면 ㄴㄴ
        // 왜나면 페이지가 리로드 된후 특정 div 를 다시 리로드 하면
        //예전엔 없었던 html 코드가 새롭게 생기기 떄문에 더이상 클릭을 인식하지 못한다
        // ready 의 의미는 페이지가 모두 리로드 되고나서 괄호속 코드를 실행한다는 의미
        $('body').on('click','.mre_time_2',function(){

            var myAudio=document.getElementById("music_audio");
            var mre_time= $(this).closest(".music_reply_list").find(".mre_time");
            var currentTime =Math.floor(mre_time.val());

            // alert(currentTime)

            myAudio.play();
            myAudio.currentTime = currentTime;

        });
    </script>
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
            width: 450px; height: 450px; margin-top: 30px;margin-left: 10px;
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
<div class="" id="background_img" style="width: 1700px;height: 500px;margin:0 auto;">
    <div class="media-body" >
        <label class="user_img pull-right" id="user_img" style="margin-right: 30px"> </label>

        <label>

            <div></div>
            <h1 class="d-inline-flex p-2" style="background-color: #505759;color: white; margin-top: 50px;margin-left: 30px"><?php echo $m_artist?></h1>

            <div>
                <h2 class="d-inline-flex p-2" style="background-color: #505759;color: white; margin-top: 0px;margin-left: 30px"><?php echo $m_title?></h2>
                <a style="margin-left: 30px;background-color: #3c3c3c; color: white;padding-bottom: 3px;padding-top: 3px"
                   class="d-inline-flex p-2 pull-right" href="music_genre_list.php?m_genre=<?php echo urlencode($m_genre)?>">#<?php echo $m_genre?></a>
<!--                <h4 class="d-inline-flex p-2 pull-right" style="font-size: 18px;margin-left: 20px;-->
<!--                background-color: #505759; color: white;padding-bottom: 3px;padding-top: 3px" >#--><?php //echo $m_genre?><!--</h4>-->

                <div>
                    <audio id="music_audio" class="music_audio" controls style="width: 1100px; margin-top: 280px;margin-left: 20px">
                        <source src="/music_upload/<?php echo $m_filename?>" type="audio/mpeg">
                    </audio>
                </div>


                <!-- 댓글입력-->
                <div id="music_reply_form" name="music_reply_form">
                    <p>
                        <img src="<?php echo $user_session_img ?>" style="width: 60px;height: 60px" align="left">
                        <input onkeydown="music_reply(this)" type="text" class="form-control" name ="music_reply" id="music_reply"
                               style="width: 1100px;margin-top: 20px;height: 60px;border-top-width: 13px;border-bottom-width: 13px;border-right-width: 10px;border-left-width: 10px;"
                               placeholder="댓글을 입력해 주세요" autocomplete=off>
                    </p>
                </div>

                <!-- 댓글입력-->


                <input id="m_idx" name="m_idx" value="<?php echo $m_idx?>" style="display: none"/>
                <input id="filename_val" value="<?php echo $m_filename?>" style="display: none"/>
                <input id="uploader_val" value="<?php echo $m_uploader?>" style="display: none"/>
<!--                -->
                <div style="margin-top: 10px" >
                    <div class="btn pull-right" style="padding-bottom: 3px;padding-top: 3px;margin-top: 10px;border: 1px solid transparent;" disabled >
                        <?php echo $m_length?>
                    </div>

<!--                    <div class="btn pull-right" id="comments_btn" style="padding-bottom: 3px; padding-top: 3px;margin-bottom: 5px;margin-top: 10px;border: 1px solid transparent;">-->
<!--                    --><?php
//                    $sql_2 = mq("select * from MusicReply where mre_m_idx ='$m_idx'");
//                    $rep_count_2 = mysqli_num_rows($sql_2);
//                    ?>
<!---->
<!--                        <img  src="/image/comment.png" style="margin-left: 5px"> --><?php //echo $rep_count_2?>
<!--                    </div>-->

                    <div class="btn pull-right" style="margin-left: 10px;padding-bottom: 3px;
                        padding-top: 3px;margin-bottom: 5px;margin-top: 10px;margin-right: 5px;border: 1px solid transparent;" >▶ 재생횟수<?php echo $m_playcnt?></div>

                    <!--                        좋아요 버튼-->
                    <?php
                    $sql4 = mq("select * from LikedMusic where liked_m_m_idx ='$m_idx'");
                    $rep_count = mysqli_num_rows($sql4);
                    //                        $sql4 = mq("select * from LikedMusic where liked_m_m_idx ='$m_idx' and liked_m_userid ='$m_uploader'");
                    //            if ($board4 = $sql4->fetch_array())  {
                    $sql5 = mq("select * from LikedMusic where liked_m_m_idx ='$m_idx' and liked_m_userid = '$userid_session'");
                    $rep_count2 = mysqli_num_rows($sql5);
                    // error_log("rep_count2 : ".$rep_count2." / ".$m_idx." / ".$userid);
                    ?>
                    <label class="like_btn_area" id="like_btn_area" style="margin-top: 7px">
                        <?php
                        if($rep_count2 == 1){
                            ?>
                            <label class="btn_liked" >
                                <button class="btn btn-outline-primary" id="likebtn" style="padding-bottom: 3px;padding-top: 3px;
                            margin-left: 10px; margin-bottom: 5px;background-color: #2b669a;color: white;" value="liked" >❤ <?php echo $rep_count?></button>
                            </label>

                        <?php }else {?>
                            <label class="btn_like" >
                                <button class="btn btn-outline-primary" id="likebtn" style="padding-bottom: 3px;padding-top: 3px;
                            margin-left: 10px; margin-bottom: 5px;" value="like" >❤ <?php echo $rep_count?></button>
                            </label>
                        <?php }?>
                    </label>
                    <!--                        좋아요 버튼-->


                    <?php
                    if($_SESSION['UserId'] == $m_uploader){
                        ?>
                        <label class="btn_delete">
                            <button class="btn btn-outline-primary" id="deletebtn" onclick="music_delete();" style="margin-top: 2px;padding-bottom: 3px;padding-top: 3px;margin-left: 10px; margin-bottom: 5px">Delete</button>
                        </label>
                    <?php } ?>
                    <?php
                    if($_SESSION['UserId'] == $m_uploader){
                        ?>
                        <label class="btn_edit">
                            <button class="btn btn-outline-primary" id="editbtn" onclick="music_edit();" style="padding-bottom: 3px;padding-top: 3px;margin-left: 10px; margin-bottom: 5px">Edit</button>
                        </label>
                    <?php } ?>
                </div>
        </label>
    </div>
</div>

<hr class="one">

<div style="width: 1720px" id = "music_reply_list_content">

    <?php
    $count = 0;
    $sql9 = mq("select * from LikedMusic where liked_m_m_idx = '$m_idx' order by liked_m_idx desc");
    $rep_count_7 = mysqli_num_rows($sql9);
    ?>

    <div class="sidenav pull-right"  style="height: 600px;width: 500px;margin-right: 10px;padding-left: 30px">

        <!--                        좋아요 누른 사람 리스트 나오는 곳-->
        <article id="likes_list" class="likes_list">
            <a>
                <label class="likes_count" id="likes_count">
                    <h4> ❤ <?php echo $rep_count_7?> people likes <a class="pull-right" style="margin-right: 20px"
                                                              href="music_liked_people_list.php?m_idx=<?php echo $m_idx?>">View all</a></h4>
                </label>
            </a>
            <hr class="one">
            <div>
                <div>
                    <ul>
                        <li>
                        <?php
                        while(($board9 = $sql9->fetch_array()) &&($count<5)){
                            $count++;
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
        <!--                        좋아요  누른 사람 리스트 나오는 곳-->
    </div>


        <div class="sidenav pull-right"  style="height: 600px;width: 910px;margin-right: 10px;padding-left: 0px">
            <div>
                <a class="btn" style="padding-top: 3px;padding-bottom: 3px;margin-bottom: 10px"
                   onclick="this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';" href="javascript:void(0)">
                    description
                </a><div style="DISPLAY: none">
                    <div style="font-size: 20px;margin-bottom: 40px"><?php echo nl2br($m_descript);?></div>
                </div>

            </div>

            <div >
                <?php
                $sql_ = mq("select * from MusicReply where mre_m_idx ='$m_idx' order by mre_idx desc ");
                $rep_count_ = mysqli_num_rows($sql_);
                ?>
                <div style="font-size: 18px">
                    <img src="/image/comment.png" style="margin-right:8px "><?php echo $rep_count_?> <a style="margin-left: 3px">Comments</a>
                </div>
                <hr class="one">


                <!--       댓글 나오는 곳 -->
                <?php
                //        $sql_ = mq("select * from MusicReply where mre_m_idx ='$m_idx'");
                //        $rep_count_ = mysqli_num_rows($sql_);
                while($board_ = $sql_->fetch_array()){
                    $mre_idx = $board_['mre_idx'];
                    $mre_userid = $board_['mre_userid'];
                    $mre_content = $board_['mre_content'];
                    $mre_date = $board_['mre_date'];
                    $mre_time = $board_['mre_time'];
                    $mre_currentime = $board_['mre_currentTime'];
                    $sql_2 = mq("select * from UserInfo where id ='$mre_userid' ");
                    while ($board_2 = $sql_2->fetch_array()){
                        $userimg_2= $board_2['userimg'];
                        $userimg_2 = "/image/userimg/".$userimg_2;
                        ?>

                        <div class="music_reply_list" style="width: 880px">
                            <input id="mre_idx" class="mre_idx" name="mre_idx" value="<?php echo $mre_idx?>" style="display: none"/>
                            <input id="mre_time" class="mre_time" name="mre_time" value="<?php echo $mre_currentime?>" style="display: none"/>
                            <img src="<?php echo $userimg_2 ?>" style="border-radius: 50%;width: 60px;height: 60px" align="left">
                            <div style="width: 880px;height: 60px;">
                                <h3 style="margin-bottom: 2px">
                                    <a href="music_mymusic.php?m_uploader=<?php echo $mre_userid?>" style="margin-left: 20px"><?php echo $mre_userid?></a>
                                    <a style="margin-right: 3px">at </a>
                                    <a href="javascript:;"  class="mre_time_2"  ><?php echo $mre_time?></a>
                                    <a class="pull-right" style="margin-right: 10px;margin-top: 7px"><?php echo $mre_date?></a>
                                </h3>
                                <a style="margin-left: 20px;font-size: 20px"><?php echo $mre_content?></a>

                                <label class="trash_can pull-right" for="btn pull-right trashcan" >
                                    <?php
                                    if($mre_userid == $_SESSION['UserId']){
                                        ?>

                                        <p class="btn pull-right trashcan" id="trash_can" style="margin-right: 10px;margin-top: 7px;padding: 1px;display: none"><img src="/image/garbage.png"></p>

                                    <?php }?>
                                </label>
                            </div>
                        </div>
                    <?php }?>
                <?php }?>
                <!--       댓글 나오는 곳 -->
            </div>
        </div>

        <div class="main" style="width: 250px;margin-right: 0px">
            <div>
                <img src="<?php echo $userimg?>" style="width: 220px;height: 220px;">
                <div style="margin-top: 20px;margin-bottom: 100px;margin-left: 10px">
                    <a href="music_mymusic.php?m_uploader=<?php echo $m_uploader?>" style="font-size: 20px"> <?php echo $m_uploader?></a></div>
            </div>
        </div>


</div>



</body>
<script>
    var audio = document.getElementById("music_audio");
    audio.currentTime
    $(document).ready(function () {
        $(document).on('mouseenter', '.music_reply_list', function () {

            $(this).closest(".music_reply_list").find("#trash_can").show();
        }).on('mouseleave', '.music_reply_list', function () {
            $(this).closest(".music_reply_list").find("#trash_can").hide();
        });
///////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////

    });

    $('body').on('click','.trash_can',function(){
        var mre_idx =  $(this).closest(".music_reply_list").find("#mre_idx");
        var r =confirm("댓글을 삭제 하시겠습니까?");
        if(r ==true){
            $.ajax({
                url: "music_reply_delete.php",
                type: "POST",
                data:{ mre_idx : mre_idx.val()},
            }).done(function(data) {

                if(data == 1){

                    $("#music_reply_list_content").load(location.href + " #music_reply_list_content>*", ""); //특정 div 만 새로 고침 하는것이다 대박쓰 개쩔어
                }
                if(data == 2) {
                    alert("댓글을 삭제 하지 못 했습니다")
                }

            });
        }else {

        }

    });
</script>
</html>