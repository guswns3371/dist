<?php
        session_start();
        $conn = mysqli_connect('localhost','root',
            'wnsgusgk3537','user');
        $date = date('Y-m-d');

        $cookie =  $_COOKIE["user_session_ID"];
        $comm_userid = $_SESSION['UserId'];
        if($cookie !=""){
            $sql2 = "SELECT * FROM UserInfo WHERE session_id = '$cookie' ";
        }else{
            $sql2 = "SELECT * FROM UserInfo WHERE id = '$comm_userid' ";
        }
//        $sql2 = "SELECT * FROM UserInfo WHERE session_id = '$cookie' ";
        $result2 = mysqli_query($conn,$sql2);
        $row=mysqli_fetch_assoc($result2);
        $comm_password = $row['password'];
        $comm_username = $row['username'];


        $comm_title = $_POST['comm__title']; // comm__title 은 아이디가 아니라 name 이다 이새끼야
        $comm_content = $_POST['comm__content'];
        error_log("username / password =".$comm_username." / ".$comm_password);
        error_log("title / content / date =".$comm_title." / ".$comm_content." / ".$date);

//        첨부파일 부분
        $tmpfile =  $_FILES['b_file']['tmp_name']; //post 방식으로 넘겨받음  $_FILES['b_file']
        $o_name = $_FILES['b_file']['name'];
        $filename = iconv("UTF-8", "EUC-KR",$_FILES['b_file']['name']);
        $folder = "/var/www/html/community_upload/".$filename;
        move_uploaded_file($tmpfile,$folder);

//        $comm_username = $_SESSION['UserName']; //자동로그인 상태에서 바로 글쓰기 할떄 오류나타남
//        $comm_password = $_SESSION['UserPassword'];

        $alert;
        if(($comm_title == "") || ($comm_content == "")){ // 제목 내용 둘중 하나라도 없을경우
            $alert = "0";
            if($tmpfile == null){
                $alert ="3";
            }
        }else{// 제목 내용 모두 작성시
            $sql2 ="
            INSERT INTO Community_Info
            (comm_username,comm_userid,comm_password,comm_title,comm_content,comm_date,comm_file)
            VALUES(
              '{$comm_username}',
              '{$comm_userid}',
              '{$comm_password}',
              '{$comm_title}',
              '{$comm_content}',
              '{$date}',
              '{$o_name}'
            ) 
            ";

            $result2 = mysqli_query($conn,$sql2);
            error_log(mysqli_error($conn));
            if($result2 === false){//제대로 저장이 안 되었을떄
                $alert ="1";
            }else{ // 제대로 저장이 되었을떄
                $alert = "2";
            }
        }
        echo $alert;
?>
<?php if($alert == "0"){
    ?>
    <script type="text/javascript">alert("제목과 내용을 모두 입력해 주세요!");</script>
    <meta http-equiv="refresh" content="0 url=community_write_page.php"/>
<?php } else if(($alert == "1") || ($alert == "3")){?>
    <script type="text/javascript">alert("저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의 하세요.");</script>
    <meta http-equiv="refresh" content="0 url=community_page.php?page=1"/>
<?php } else if($alert == "2"){?>
    <script type="text/javascript">alert("글쓰기 완료되었습니다.");</script>
    <meta http-equiv="refresh" content="0 url=community_page.php?page=1"/>
<?php } ?>


