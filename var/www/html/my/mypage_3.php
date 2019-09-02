<!doctype html>
<?php
session_start();
$conn = mysqli_connect('localhost','root',
    'wnsgusgk3537','user');
$cookie =  $_COOKIE["user_session_ID"];
error_log("myapge session :".session_id());
error_log("2!".$cookie);
$sql2 = "SELECT * FROM UserInfo WHERE session_id = '$cookie' ";
$result2 = mysqli_query($conn,$sql2);
$row=mysqli_fetch_assoc($result2);
if(!isset($_COOKIE["user_session_ID"])){
    $userid_session = $_SESSION['UserId'];
    $sql2 = "SELECT * FROM UserInfo WHERE id = '$userid_session' ";
    $result2 = mysqli_query($conn,$sql2);
    $row=mysqli_fetch_assoc($result2);
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Uncopyright Sounds</title>

    <!-- Favicon -->
    <link rel="icon" href="/image/favicon.ico">

    <!-- Stylesheet -->
    <!--실험-->
    <link  href="/css/mypagecss/style.css" rel="stylesheet">
    <link href="/css/bootstrap.css" rel="stylesheet">

    <!--    <link href="/css/bootstrap2.min.css" rel="stylesheet">-->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        function upload() {
            alert("???")
            location.href = "music_upload.php"
        }
    </script>
    <style>
        body{
            background-color: #f6f6f6;
        }
        .modal-backdrop.in {
            filter: alpha(opacity=50);
            opacity: 0;
        }

        /*div.maudio .audio-control .progress-bar {*/
            /*width: 40% !important;*/
            /*height: 100% !important;*/
            /*margin: 11px 5px;*/
            /*border-radius: 3px;*/
            /*background: #afafaf;*/
            /*overflow: hidden;*/
        /*}*/
        /*div.maudio .audio-control {*/
            /*overflow: hidden;*/
            /*margin-top: 10px;*/
            /*margin-left: 30% !important;*/
            /*font-size: 12px;*/
            /*font-weight: normal;*/
        /*}*/
        /*div.maudio .audio-control {*/
            /*overflow: hidden;*/
            /*width: 1500px !important;*/
            /*margin-top: 5px;*/
            /*font-size: 12px;*/
            /*font-weight: normal;*/
        /*}*/
    </style>
</head>
<body>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm" style="height: 66px">
    <!--    <h5 class="my-0 mr-md-auto font-weight-normal" style="font-size: 22px">Company name</h5>-->
    <div class="my-0 mr-md-auto font-weight-normal">
        <a href="http://127.0.0.1/my/music_home.php"><img src="/image/uncopyright-logo.png" alt=""></a>
    </div>
    <div>
        <form action="music_search_result.php" method="get" class="form-inline">
            <div class="form-group mx-sm-3 mb-2">
                <label for="topSearch" class="sr-only">Search</label>
                <input class="form-control" type="search" name="topsearch" id="topSearch" placeholder="Search" style="height: 34px;width: 504px;">
            </div>
            <button type="submit" class="btn btn-primary mb-2" style="margin-right: 10px"><i class="fa fa-search"></i></button>
            <?php
            if(isset($_SESSION['UserId'])){
                ?>
                <a  href="music_pre_upload.php" class="btn btn-primary mb-2" style="margin-right: 50px"><i >Upload</i></a>
            <?php }else {?>
                <a  href="#" class="btn btn-primary mb-2" style="margin-right: 50px" disabled><i >Upload</i></a>
            <?php }?>
        </form>
    </div>

    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="http://127.0.0.1/my/music_home.php">Home</a>
        <a class="p-2 text-dark" href="#">Collection</a>
        <?php
        if(isset($_SESSION['UserId'])){
            ?>
            <a class="p-2 text-dark" href="community_page.php?page=1" >Community</a>
        <?php }else {?>
            <a class="p-2 text-dark" href="community_page.php?page=1" style="margin-right: 150px">Community</a>
        <?php }?>

        <?php
        if(!isset($_SESSION['UserId']) ) {// 로그인 안했을 때 (자동로그인 상태인지 알아야함)
            if($cookie == "") { //자동 로그인 상태가 아닐 떄
                echo "<a id=\"A\" class=\"p-2 text-dark\" href=\"#\"  style=\"margin: 8px\">.</a>";
            }else{//자동 로그인 상태일 떄
                $uname = $row['username'];
                $uid = $row['id'];
                echo "<a id=\"A\" class=\"p-2 text-dark\" href=\"music_mymusic.php?m_uploader=$uid\"  style=\"margin: 8px\"> $uname($uid)</a>";
            }
        }else{//로그인 했을 때 (자동로그인 체크 여부가 의미 없다)
            $uname = $row['username'];
            $uid = $row['id'];
            echo "<a id=\"A\" class=\"p-2 text-dark\" href=\"music_mymusic.php?m_uploader=$uid\" style=\"margin: 8px\"> $uname($uid)</a>";
        }
        ?>
        <!--        <a id="A" class="p-2 text-dark" href="#"  style="margin: 8px">.</a>-->
    </nav>

    <?php
    //    실험
    //    $conn = mysqli_connect('localhost','root',
    //        'wnsgusgk3537','user');
    //    $cookie =  $_COOKIE["user_session_ID"];
    //    error_log("myapge session :".session_id());
    //    error_log("2!".$cookie);
    //    $sql2 = "SELECT * FROM UserInfo WHERE session_id = '$cookie' ";
    //    $result2 = mysqli_query($conn,$sql2);
    //    $row=mysqli_fetch_assoc($result2);

    error_log("2!!".$row['session_id']);
    error_log($row['id']);
    error_log("session-userid".$_SESSION['UserId']);
    if(!isset($_SESSION['UserId']) ){// 로그인 안했을 때 (자동로그인 상태인지 알아야함)
        if($cookie == ""){ //자동 로그인 상태가 아닐 떄
            echo "  <a class=\"btn btn-outline-primary\" href=\"http://127.0.0.1/my/login.php\" style=\"border: 1px solid #5ca7f7;\">로그인</a>";

        }else{ //자동 로그인 상태일 떄
            $userid = $row['id'];
            $username = $row['username'];
            $userpassword =  $row['password'];

            $_SESSION['UserId'] =  $userid;
            $_SESSION['UserName'] = $username;
            $_SESSION['UserPassword'] = $userpassword;
//            echo "<script>  document.querySelector('#A').innerHTML = \" $username($userid)\";</script>";
            echo "  <a class=\"btn btn-outline-primary\" href=\"http://127.0.0.1/my/logout.php\" style=\"border: 1px solid #5ca7f7;\">로그아웃</a>";

        }
    }else{//로그인 했을 때 (자동로그인 체크 여부가 의미 없다)
        //로그인 저장했을 때
        $userid =  $_SESSION['UserId'];
        $username = $_SESSION['UserName'];
        $userpassword = $_SESSION['UserPassword'];
//        echo "<script>  document.querySelector('#A').innerHTML = \" $username($userid).\";</script>";
        echo "  <a class=\"btn btn-outline-primary\" href=\"http://127.0.0.1/my/logout.php\" style=\"border: 1px solid #5ca7f7;\">로그아웃</a>";
    }
    ?>
</div>

</div>

<!--<div class="media" style="position: fixed; bottom: 0;background-color: #edeaf7;height: 6%;width: 100%">-->
<!--    <div id="app" class="app" style=" width: 1300px;">-->
<!--        <div class="maudio" >-->
<!--            <div class="audio-control" >-->
<!--                <a href="javascript:;" class="fast-reverse"></a>-->
<!--                <a href="javascript:;" class="play"></a>-->
<!--                <a href="javascript:;" class="fast-forward"></a>-->
<!--                <div class="progress-bar" style="width: 300px;">-->
<!--                    <div class="progress-pass">-->
<!---->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="time-keep">-->
<!--                    <span class="current-time">00:00</span> / <span class="duration">05:05</span>-->
<!--                </div>-->
<!--                <a class="mute"></a>-->
<!--                <div class="volume-bar">-->
<!--                    <div class="volume-pass">-->
<!---->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <img src="/music_upload/music_image/ansgur3371_Be Randy.jpeg" style="width: 50px;height: 50px;margin-bottom: 5px;margin-left: 0px">-->
<!--    <p style="margin-left: 15px;"><span>artist</span> <br><span style="color: #000;">title</span></p>-->
<!--</div>-->


</body>
<link rel="stylesheet" href="/css/maudio.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT"
        crossorigin="anonymous">
</script>
<script src="/js/maudio.js"></script>
<script>
    // var h = '<audio controls src="./audio-test-01.mp3" autoplay="autoplay"></audio><audio controls src="https://mycugb.com/17ing/music/yc_yixin_yunkaiwusan.mp3"></audio><audio controls src="https://mycugb.com/17ing/music/17ing_20130508.mp3"></audio>'
    var h = '<audio controls src="/music_upload/ansgur3371_01 Jaded.mp3"></audio>'

    $('#app').html(h)

    maudio({
        obj:'audio',
        fastStep:10
    })

    $('audio').on('abort',function(){
        console.log('abort')
    })

    $('audio').on('canplay',function(){
        console.log('canplay')
    })

    $('audio').on('canplaythrough',function(){
        console.log('canplaythrough')
    })

    $('audio').on('durationchange',function(){
        console.log('durationchange')
    })

    $('audio').on('emptied',function(){
        console.log('emptied')
    })

    $('audio').on('ended',function(){
        console.log('ended')
    })

    $('audio').on('error',function(){
        console.log('error')
    })

    $('audio').on('loadeddata',function(){
        console.log('loadeddata')
    })

    $('audio').on('loadedmetadata',function(){
        console.log('loadedmetadata')
    })

    $('audio').on('loadstart',function(){
        console.log('loadstart')
    })

    $('audio').on('pause',function(){
        console.log('pause')
    })

    $('audio').on('play',function(){
        console.log('play')
    })

    $('audio').on('playing',function(){
        console.log('playing')
    })

    $('audio').on('progress',function(){
        console.log('progress')
    })

    $('audio').on('ratechange',function(){
        console.log('ratechange')
    })

    $('audio').on('seeked',function(){
        console.log('seeked')
    })

    $('audio').on('seeking',function(){
        console.log('seeking')
    })

    $('audio').on('stalled',function(){
        console.log('stalled')
    })

    $('audio').on('suspend',function(){
        console.log('suspend')
    })

    $('audio').on('timeupdate',function(){
        console.log('timeupdate')
    })

    $('audio').on('volumechange',function(){
        console.log('volumechange')
    })

    $('audio').on('waiting',function(){
        console.log('waiting')
    })
    // $('audio')[0].play()
</script>
</html>
