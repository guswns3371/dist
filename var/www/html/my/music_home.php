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
error_log("???????? : ".$userid_session);
?>


<html>
<head>
    <!--    <link href="/css/bootstrap2.min.css" rel="stylesheet">-->

    <script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>

        $(document).ready(function(){

        });

        $('body').on('click','.btn_delete',function(){
            var r= confirm("정말 삭제 하시겠습니까?")
            if(r == true){
                var obj = $(this).closest(".media-body").find("#filename_val");
                var obj2 = $(this).closest(".media-body").find("#uploader_val");
                // alert("music_delete.php?m_filename="+obj.val()+"&m_uploader="+obj2.val()+"")
                location.href = "music_delete.php?m_filename="+obj.val()+"&m_uploader="+obj2.val()+"";
            }else {

            }
        });
        //////////////////////////////////////////////////////////
        $('body').on('click','.btn_edit',function(){
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
        ///////////////////////////////////////////////////////////////////////
        $('body').on('click','.like_btn_area',function(){
            var obj = $(this).closest(".media-body").find("#m_idx");
            var obj2 = $(this).closest(".media-body").find("#likebtn");
            var obj3 = $(this).closest(".media-body").find("#like_btn_area");
            var userid = "<?php echo $userid_session?>";
            if(userid !=""){
                if(obj2.val() == "like"){
                    $.ajax({
                        url: "music_like.php",
                        type: "POST",
                        data:{ m_idx : obj.val()},
                    }).done(function(data) {

                        if(data !=""){
                            obj3.html("")
                            obj3.html(data)
                        }else {
                            alert("좋아요 체크에 실패 했습니다")
                        }

                    });

                }else if(obj2.val() == "liked"){
                    $.ajax({
                        url: "music_unlike.php",
                        type: "POST",
                        data:{ m_idx : obj.val()},
                    }).done(function(data) {

                        if(data !=""){
                            obj3.html("")
                            obj3.html(data)
                        }else {
                            alert("좋아요 체크에 실패 했습니다")
                        }

                    });

                }

            }else {
                alert("로그인 후 좋아요를 누르실 수 있습니다");
            }

        });

        $('body').on('click','.audio',function(){
            $(".audio").on("play", function() {
                $(".audio").not(this).each(function(index, audio) {
                    audio.pause();
                    audio.currentTime = 0;
                });
            });
        });
        ////////////////////////////////////////////////////////

    </script>
    <style>
        .btn{
            border: 1px solid;
        }
        .modal-open {
            overflow: auto;
        }

        .dropdown {
            position: absolute;
        }
    </style>

</head>

<body>
<hr class="one">

<!-- Modal -->
<div class="modal" id="layerpop" tabindex="-1" role="dialog" data-backdrop="false" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="bodybody">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Send message</button>
            </div>
        </div>
    </div>
</div>


<div class="container2">

          </div>



<?php
//$sql2 = mq('select * from MusicInfo order by m_idx desc');
//while ($board = $sql2->fetch_array())  {
//    $m_idx = $board['m_idx'];
//    $m_uploader = $board['m_uploader'];
//    $m_title = $board['m_title'];
//    $m_genre = $board['m_genre'];
//    $m_artist = $board['m_artist'];
//    $m_likecnt = $board['m_likecnt'];
//    $m_playcnt = $board['m_playcnt'];
//    $m_length = $board['m_length'];
//    $m_filename = $board['m_filename'];
//    $m_image = $board['m_image'];
//    if($m_image =="data:;base64,"){
//        $m_image = "/image/none.png";
//    }
//    //error_log("music home :".$m_uploader."/".$m_title."/".$m_genre."/".$m_artist."/".$m_likecnt."/".$m_playcnt."/".$m_filename);
//
//    $sql3 =mq("select * from UserInfo where id= '$m_uploader'");
//    while ($row2 = $sql3->fetch_array()){
//
//        $username= $row2['username'];
//        $userid = $row2['id'];
//        $usermig = $row2['userimg'];
//        $userbackimg = $row2['userbackimg'];
//
//        $usermig = str_replace(" ","%20",$usermig);
//        $userbackimg = str_replace(" ","%20",$userbackimg); // 파일 이름에 띄어쓰기 있으면 노노 -> 공백을 %20으로 채워야 한다
////    error_log("userbackimg :".$userbackimg);
//    }
//    if($usermig == ""){
//        $usermig ="http://127.0.0.1/image/white.jpg";
//    }else{
//        $usermig = "http://127.0.0.1/image/userimg/".$usermig;
//    }
//    if($userbackimg == ""){
//        $userbackimg ="http://127.0.0.1/image/shit.jpg";
//    }else{
//        $userbackimg = "http://127.0.0.1/image/userbackimg/".$userbackimg;
//    }
//    ?>
<!---->
<!--<div class="container" style="margin-bottom: 20px">-->
<!--    <div class="media">-->
<!--        <div><h4><a href="music_mymusic.php?m_uploader=--><?php //echo $m_uploader?><!--">-->
<!--                    <img src=--><?php //echo $usermig?><!-- alt='file' title='file' style="border-radius: 50%;width: 40px;height: 40px;margin-right: 15px"/>--><?php //echo $m_uploader?><!--</a></h4>-->
<!--            <img src="--><?php //echo $m_image?><!--" alt="..."  style="width: 226px; height: 226px;">-->
<!--        </div>-->
<!--        <div class="media-body" style="margin-left: 30px">-->
<!--            <div id="audio_player"></div>-->
<!--            <input id="m_idx" name="m_idx" value="--><?php //echo $m_idx?><!--" style="display: none"/>-->
<!--            <input id="filename_val" value="--><?php //echo $m_filename?><!--" style="display: none"/>-->
<!--            <input id="uploader_val" value="--><?php //echo $m_uploader?><!--" style="display: none"/>-->
<!--            <div><p style="margin-top: 60px; margin-left: 15px;font-size: 16px;">--><?php //echo $m_artist?><!--</p></div>-->
<!--            <a style="margin-left: 30px;background-color: #3c3c3c; color: white;padding-bottom: 1px;padding-top: 1px;font-size: 15px"-->
<!--               class="d-inline-flex p-2 pull-right" href="music_genre_list.php?m_genre=--><?php //echo $m_genre?><!--">#--><?php //echo $m_genre?><!--</a>-->
<!---->
<!--            <a href="music_innerpage.php?m_idx=--><?php //echo $m_idx?><!--&m_artist=--><?php //echo $m_artist?><!--"-->
<!--               style="margin-left: 10px;font-size: 18px;color: black" id="m_title"> --><?php //echo $m_title?><!--</a>-->
<!---->
<!--            <div>-->
<!--                <audio class="audio" controls style="width: 854px; margin-top: 30px;margin-bottom: 20px">-->
<!--                    <source src="/music_upload/--><?php //echo $m_filename?><!--" type="audio/mpeg">-->
<!--                </audio>-->
<!--            </div>-->
<!--            <div class="btn pull-right" style="padding-bottom: 3px;padding-top: 3px;margin-top: 10px;border: 1px solid transparent;" >-->
<!--                --><?php //echo $m_length?>
<!--            </div>-->
<!--            --><?php
//            $sql_ = mq("select * from MusicReply where mre_m_idx ='$m_idx'");
//            $rep_count_ = mysqli_num_rows($sql_);
//            ?>
<!--            <div class="btn pull-right"  style="padding-bottom: 3px;-->
<!--                        padding-top: 3px;margin-bottom: 5px;margin-top: 10px;border: 1px solid transparent;">-->
<!--                <img  src="/image/comment.png" style="margin-left: 5px"> --><?php //echo $rep_count_?>
<!--            </div>-->
<!---->
<!--            <div class="btn pull-right"style="margin-left: 10px;padding-bottom: 3px;-->
<!--                        padding-top: 3px;margin-bottom: 5px;margin-top: 10px;margin-right: 5px;border: 1px solid transparent;" >▶ 재생횟수--><?php //echo $m_playcnt?><!--</div>-->
<!---->
            <!--                        좋아요 버튼-->
<!--            --><?php
//            $sql4 = mq("select * from LikedMusic where liked_m_m_idx ='$m_idx'");
//            $rep_count = mysqli_num_rows($sql4);
//
//                $sql5 = mq("select * from LikedMusic where liked_m_m_idx ='$m_idx' and liked_m_userid = '$userid_session'");
//                $rep_count2 = mysqli_num_rows($sql5);
//                ?>
<!--            <label class="like_btn_area" id="like_btn_area">-->
<!--                --><?php
//                if($rep_count2 == 1){
//                ?>
<!--                    <label class="btn_liked" >-->
<!--                        <button class="btn btn-outline-primary" id="likebtn" style="padding-bottom: 3px;padding-top: 3px;-->
<!--                            margin-left: 10px; margin-bottom: 5px;background-color: #2b669a;color: white;" value="liked" >❤ --><?php //echo $rep_count?><!--</button>-->
<!--                    </label>-->
<!---->
<!--                --><?php //}else {?>
<!--                      <label class="btn_like" >-->
<!--                        <button class="btn btn-outline-primary" id="likebtn" style="padding-bottom: 3px;padding-top: 3px;-->
<!--                            margin-left: 10px; margin-bottom: 5px;" value="like" >❤ --><?php //echo $rep_count?><!--</button>-->
<!--                    </label>-->
<!--                    --><?php //}?>
<!--            </label>-->
<!--            -->
<!--            <!--                        좋아요 버튼---->
<!---->
<!--            --><?php
//                if($_SESSION['UserId'] == $m_uploader){
//                ?>
<!--                    <label class="btn_delete">-->
<!--                        <button class="btn btn-outline-primary" id="deletebtn" onclick="music_delete();" style="padding-bottom: 3px;padding-top: 3px;margin-left: 10px; margin-bottom: 5px">Delete</button>-->
<!--                    </label>-->
<!--                --><?php //} ?>
<!---->
<!--            --><?php
//            if($_SESSION['UserId'] == $m_uploader){
//                ?>
<!--                <label class="btn_edit">-->
<!--                    <button class="btn btn-outline-primary" id="editbtn" onclick="music_edit();" style="padding-bottom: 3px;padding-top: 3px;margin-left: 10px; margin-bottom: 5px">Edit</button>-->
<!--                </label>-->
<!--            --><?php //} ?>
<!---->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<?php //} ?>


</body>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<script>
    var start =0;
    var limit =5;
    var reachedMax = false;

    $(window).scroll(function () {
       if($(window).scrollTop() === $(document).height() - $(window).height())
           getData();
    });
    
    $(document).ready(function () {
       getData();
    });
    function getData() {
        if(reachedMax)
            return;

        $.ajax({
            url: 'music_home_infinite_scroll.php',
            method : 'POST',
            dataType: 'text',
            data:{
              getData : 1,
              start : start,
              limit: limit
            },
            success:function (response) {
                if(response == 'reachedMax'){
                    reachedMax = true;
                }else {
                    start +=  limit;
                    $(".container2").append(response);
                }
            }
        });
    }
    //////////////////////////////////////////////////////
</script>
<script>
    $('body').on('click','.btn_playlist',function(){
        var obj = $(this).closest(".media-body").find("#m_idx");
        var obj2 = $(this).closest(".media-body").find("#dropdownmenu");
       // alert(obj.val());
        obj2.html("");
        var menu1 = '<a class="dropdown-item" href="#" id="fuck"><?php echo heyy;?></a>';
        // document.querySelector('#dropdownmenu').innerHTML = '<a class="dropdown-item" href="#">fuck</a>';
        menu1 +='<a class="dropdown-item"  id="create_playlist">Create Playlist</a>';
        obj2.html(menu1);

    });
    $('body').on('click','#create_playlist',function(){
        $("#layerpop").modal('show');
    });
</script>

</html>