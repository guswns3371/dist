<?php
$conn = mysqli_connect('localhost','root',
    'wnsgusgk3537','user');

//    var_dump($_POST);
$sql ="
    INSERT INTO UserInfo
    (id,password,username,email,birthday)
    VALUES(
      '{$_POST['id']}',
      '{$_POST['password']}',
      '{$_POST['username']}',
      '{$_POST['email']}',
      '{$_POST['birthday']}'
    ) 
    "; //insert 하면 새로운게 새로 생김


$result = mysqli_query($conn,$sql);
if($result === false){
    $error ="회원가입 실패";
    $error2 ="저장하는 과정에서 문제가 생겼습니다";

    $sql2 = "SELECT * FROM UserInfo";
    $result2 = mysqli_query($conn,$sql2);
    $row2 = mysqli_fetch_array($result2);
    if($_POST['id'] === $row2['id']){
        $error2 ="이미 존재하는 아이디 입니다.";
    }

    //echo $error ;

    error_log(mysqli_error($conn)); // tail -f /var/log/apache2/error.log 에서 로그볼수 있다.

}else {
    $error = "회원가입 성공";
    $error2 = "회원가입이 성공적으로 이뤄졌습니다";

//    $error = "<h2  class=\"display-3\">"."회원가입 성공"."</h2>";
//    $error2 = "<h2  class=\"lead\">"."회원가입이 성공적으로 이뤄졌습니다"."</h2>";
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Narrow Jumbotron Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://bootstrap4.kr/docs/4.0/examples/narrow-jumbotron/narrow-jumbotron.css" rel="stylesheet">
    <script src=/js/jquery.min.js></script>

    <style>
        body{
            background-color: #d8ecf1;
            font-size: 15px;
        }

    </style>
</head>

<body>

<div class="container">


    <main role="main">

        <div class="jumbotron">
            <h2 class="display-3"> <?=$error?> </h2>
            <p  class="lead"><?=$error2?></p>
            <p><a class="btn btn-lg btn-success" href="http://127.0.0.1/my/login.php" role="button">로그인 페이지</a></p>
            <p><a class="btn btn-lg btn-success" href="http://127.0.0.1/my/register.php" role="button">회원가입 페이지</a></p>
        </div>



    </main>


</div> <!-- /container -->
</body>


</html>
