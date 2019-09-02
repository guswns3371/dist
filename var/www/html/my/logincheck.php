    <?php
            session_start();
            $conn = mysqli_connect('localhost','root',
                'wnsgusgk3537','user');

            $sql2 = "SELECT * FROM UserInfo";
            $result2 = mysqli_query($conn,$sql2);
            $id = $_POST['Lid'];
            $pw = $_POST['Lpassword'];

            $isauto = $_POST['isAuto'];
            //$isauto  = ($A) ? 'true' : 'false';
            error_log($isauto); // 체크박스 체크하면 true , 안하면 false
            $alert = "3";
            while ($row = mysqli_fetch_array($result2)){
//                error_log($row['id']." / ".$id);
                if ($row['id'] == $id) {
                    if($row['password'] == $pw){
        //                $alert = "로그인에 성공하였습니다.";
//                        error_log($row['id']." / ".$row['username'] );

                        $session_id = session_id();

                        $session_time = time()+3600;
                        error_log("logincheck :".$session_id);
                        $sql3 ="
                                UPDATE UserInfo set
                                session_id ='$session_id',session_time = '$session_time' WHERE 
                                id = '$id'
                                "; // 세션 아이디를 넣는 쿼리문 갓문혁님의 발자취가 담겨있습니다.
                        $result3 = mysqli_query($conn, $sql3);
                           if($result3){
                               $_SESSION['UserId'] =  $row['id'];
                               $_SESSION['UserName'] = $row['username'];
                               $_SESSION['UserPassword'] =  $row['password'];
                               if($isauto == 'true'){
                                   error_log("session_id!".$session_id);
                                   error_log("session_time!".$session_time);
                                   setcookie("user_session_ID",$session_id,time()+3600*24*30);
                                   setcookie("username",$row['username']);
//                                   $cookie =  $_COOKIE[session_name()]; //왜?????????????????? ㅅㅂ?????????????
                               }

                           }


                        $alert ="0";
                    }else{
        //                $alert = "아이디와 비밀번호가 일치하지 않습니다.";
                        $alert = "1";
                    }

                }
            }
            if($alert == "3"){
                    //            $alert = "존재하지 않는 아이디 입니다.";
                    $alert = "2";


            }
            echo $alert;
            error_log(mysqli_error($conn));// tail -f /var/log/apache2/error.log 에서 로그볼수 있다.
    ?>