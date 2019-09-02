<?php
    session_start(); // 세션을 사용 하려면 session_start 무조건 해줘야 하는거 알아 몰라? 아는 새끼가 그래?
    $conn = mysqli_connect('localhost','root',
        'wnsgusgk3537','user');
    $cookie =  $_COOKIE["user_session_ID"];
    error_log("2!".$cookie);
    $sql2 = "SELECT * FROM UserInfo WHERE session_id = '$cookie' ";
    $result2 = mysqli_query($conn,$sql2);
    $row=mysqli_fetch_assoc($result2);

    error_log("writecheck".$cookie);

    $username = $row['username'];
    error_log("session-userid".$_SESSION['UserId']);

    if(isset($_SESSION['UserId'])){//로그인 상태
        if($cookie == ""){//자동로그인 안했을떄
            echo "1";
            error_log("login? ok -no auto");
        }else{//자동로그인 상태
            echo "1";
            error_log("login? ok -yes auto");
        }

    }else{ //  로그아웃 상태 ( 자동로그인 여부를 따져야 한다)
        if($cookie == ""){//자동로그인 안했을떄
            echo "0";
            error_log("login? no -no auto");
        }else{//자동로그인 상태
           echo "1";
            error_log("login? no -yes auto");
        }

    }

?>
