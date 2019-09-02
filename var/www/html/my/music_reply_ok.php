<?php
session_start();
header('Content-Type: text/html; charset=utf-8'); // utf-8인코딩
$conn = mysqli_connect('localhost','root',
    'wnsgusgk3537','user');

$mre_content = $_POST['mre_content'];
$m_idx = $_POST['m_idx'];
$currenttime_ori = $_POST['currenttime'];

$currenttime = $_POST['currenttime'];
$currenttime = floor($currenttime); //  소수점 버림
$current_min = floor($currenttime/60);
$current_sec = ($currenttime - $current_min*60);
if($current_sec <10){
    $current_sec = "0".$current_sec;
}
$current_final = $current_min.":".$current_sec;

$date = date('Y-m-d');
$userid_session = $_SESSION['UserId'];

$alert;
if(!isset($_SESSION['UserId'])){
    $alert = "3";
}else{
    if($mre_content != ""){
        $sql2 ="
            INSERT INTO MusicReply
            (mre_m_idx,mre_userid,mre_content,mre_date,mre_time,mre_currentTime)
            VALUES(
              '{$m_idx}',
              '{$userid_session}',
              '{$mre_content}',
              '{$date}',
              '{$current_final}',
              '{$currenttime_ori}'
            ) 
            ";
        $result2 = mysqli_query($conn,$sql2);
        error_log("music upload error2 :".mysqli_error($conn));
        if($result2 === false){//제대로 저장이 안 되었을떄
            $alert ="2";
        }else{ // 제대로 저장이 되었을떄
            $alert = "1";
        }
    }else{
        $alert ="0"; // 입력된값이 없을떄
    }
}

echo $alert
?>

