    <?php
        $conn = mysqli_connect('localhost','root',
            'wnsgusgk3537','user');

        $sql2 = "SELECT * FROM UserInfo";
        $result2 = mysqli_query($conn,$sql2);
        $id = $_POST['id'];
        $bool = false;
//        $alert = "사용 가능한 아이디입니다";
          $alert ="0";
        if($id != "") {
            while ($row = mysqli_fetch_array($result2)) {
                //$row = mysqli_fetch_array($result2)에서 mysqli_fetch_array는 $result2에 있는 값이 없을때까지 그다음 정보를 반환한다
                //mysqli_fetch_array이 $result2에서 반환할 값이 없을때 NULL이 반환된다. php에서는 NULL == false 이다.
                //즉 while(false) 가 되어 이 반복문이 끝난다
                //echo $row['id'];
                if ($row['id'] == $id) {
//                    $alert = "이미 존재하는 아이디입니다";
                    $alert ="1";
                    $bool = true;
                } else {

                }
                //error_log($row['id']);
            }
        }else{
//            $alert = "아이디를 입력하세요";
            $alert ="2";
        }

        echo $alert;

        error_log(mysqli_error($conn));// tail -f /var/log/apache2/error.log 에서 로그볼수 있다.
        $bool = false;

    ?>