<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

include('dbcon2.php');


$stmt = $con->prepare('select * from UserInfo');
$stmt->execute();

if ($stmt->rowCount() > 0)
{
    $data = array();

    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);

        array_push($data,
            array(
                'UserKey'=>$UserKey,
                'id'=>$id,
                'password'=>$password,
                'username'=>$username,
                'email'=>$email,
                'bithday'=>$birthday,
                'sessioin_id'=>$session_id,
                'session_time'=>$session_time,
                'userbackimg'=>$userbackimg,
            ));
    }

    header('Content-Type: application/json; charset=utf8');
    $json = json_encode($data, JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
    echo $json;
}

?>