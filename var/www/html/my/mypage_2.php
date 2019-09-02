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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


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


</body>
</html>
