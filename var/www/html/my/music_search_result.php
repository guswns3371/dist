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
$search_m = $_GET['topsearch'];// 검색 변수


$userid_session = $_SESSION['UserId'];
$m_uploader =$userid_session;
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
?>


<html>
<head>
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

        $('body').on('click','.like_btn_area',function(){
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
                            // $("#liked_list_content").load(location.href + " #liked_list_content>*", ""); //특정 div 만 새로 고침 하는것이다 대박쓰 개쩔어
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
                            // $("#liked_list_content").load(location.href + " #liked_list_content>*", ""); //특정 div 만 새로 고침 하는것이다 대박쓰 개쩔어
                        } else {
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

<div class="" id="background_img" style="width: 1700px;margin:0 auto;">

    <div class="media-body" >
        <label class="user_img" id="user_img" style="margin-left: 20px">

        </label>

        <label>
                <h2 class="d-inline-flex p-2" style="background-color: #505759;color: white; margin-top: 0px;margin-left: 30px">Search results for </h2>
            <div></div>
            <h1 class="d-inline-flex p-2" style="background-color: #505759;color: white; margin-top: 0px;margin-left: 30px;font-size: 70px">“<?php echo $search_m?>”</h1>

            <div>


        </label>
    </div>

</div>
</div>

<hr class="one">

<div class="container2"></div>


</body>
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
            url: 'music_search_result_infinite_scroll.php',
            method : 'POST',
            dataType: 'text',
            data:{
                getData : 1,
                start : start,
                limit: limit,
                search_m : "<?php echo $search_m?>"
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
</html>
