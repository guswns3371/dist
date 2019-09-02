<?php
        session_start();
        // 모든 세션 변수 해제
        $_SESSION = array();

        // 세션을 없애려면, 세션 쿠키도 지웁니다.
        // 주의: 이 동작은 세션 데이터뿐이 아닌, 세션 자체를 파괴합니다!
        if (isset($_COOKIE["user_session_ID"])) {
            error_log("3!".$_COOKIE["user_session_ID"]);
            setcookie("user_session_ID", "", time()-42000);
        }
//        session_unset();
        //session_destroy(); // 이거 한다고 해서 세션 아이디가 새롭게 갱신 되는의미는 아니다
        session_regenerate_id(true); // 이런식으로 regenerate 해야지 새롭게 갱신된다는 사실

            error_log("4!".$_COOKIE["user_session_ID"]);
?>
<meta http-equiv="refresh" content="0;url=music_home.php" />