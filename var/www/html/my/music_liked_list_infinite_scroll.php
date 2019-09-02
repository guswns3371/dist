<?php
session_start();
header('Content-Type: text/html; charset=utf-8'); // utf-8인코딩

$db = new mysqli("localhost","root","wnsgusgk3537","user");
$db->set_charset("utf8");

function mq($sql)
{
    global $db;
    return $db->query($sql);
}
$userid_session = $_SESSION['UserId'];

if(isset($_POST['getData'])){
    $conn = new mysqli('localhost','root','wnsgusgk3537','user');
    $start = $conn->real_escape_string($_POST['start']);
    $limit = $conn->real_escape_string($_POST['limit']);
    $m_uploader2 = $conn->real_escape_string($_POST['m_uploader2']);
    error_log("m_uploader2 : ".$m_uploader2);
    $sql00 = $conn->query("select * from LikedMusic where liked_m_userid = '$m_uploader2' order by liked_m_idx desc LIMIT $start,$limit");
    if($sql00->num_rows >0) {
        $response = "";

        while ($board_ = $sql00->fetch_array()) {
            ////////////////////////////////////

            $liked_m_m_idx = $board_['liked_m_m_idx'];
            $liked_m_userid = $board_['liked_m_userid'];


            $sql99 =mq("SELECT * FROM MusicInfo where m_idx= '$liked_m_m_idx'");
            if ($board = $sql99->fetch_array()){

            $m_idx = $board['m_idx'];
            $m_uploader = $board['m_uploader'];
            $m_title = $board['m_title'];
            $m_genre = $board['m_genre'];
            $m_artist = $board['m_artist'];
            $m_likecnt = $board['m_likecnt'];
            $m_playcnt = $board['m_playcnt'];
            $m_length = $board['m_length'];
            $m_filename = $board['m_filename'];
            $m_image = $board['m_image'];
            if ($m_image == "data:;base64,") {
                $m_image = "/image/none.png";
            }
            //error_log("music home :".$m_uploader."/".$m_title."/".$m_genre."/".$m_artist."/".$m_likecnt."/".$m_playcnt."/".$m_filename);

            $sql3 = mq("select * from UserInfo where id= '$m_uploader'");
            if ($row2 = $sql3->fetch_array()) {

                $username = $row2['username'];
                $userid = $row2['id'];
                $usermig = $row2['userimg'];
                $userbackimg = $row2['userbackimg'];

                $usermig = str_replace(" ", "%20", $usermig);
                $userbackimg = str_replace(" ", "%20", $userbackimg); // 파일 이름에 띄어쓰기 있으면 노노 -> 공백을 %20으로 채워야 한다
            }
            if ($usermig == "") {
                $usermig = "http://127.0.0.1/image/white.jpg";
            } else {
                $usermig = "http://127.0.0.1/image/userimg/" . $usermig;
            }
            if ($userbackimg == "") {
                $userbackimg = "http://127.0.0.1/image/shit.jpg";
            } else {
                $userbackimg = "http://127.0.0.1/image/userbackimg/" . $userbackimg;
            }
            $sql_ = mq("select * from MusicReply where mre_m_idx ='$m_idx'");
            $rep_count_ = mysqli_num_rows($sql_);
            $sql4 = mq("select * from LikedMusic where liked_m_m_idx ='$m_idx'");
            $rep_count = mysqli_num_rows($sql4);
            $sql5 = mq("select * from LikedMusic where liked_m_m_idx ='$m_idx' and liked_m_userid = '$userid_session'");
            $rep_count2 = mysqli_num_rows($sql5);
            ////////////////////////////////
            ///
            if ($_SESSION['UserId'] == $m_uploader) {
                if ($rep_count2 == 1) { //좋아요된 상태
                    $response .= '
                    <div class="container" style="margin-bottom: 20px">
    <div class="media">
        <div><h4><a href="music_mymusic.php?m_uploader='.$m_uploader.'">
                    <img src=' . $usermig . ' alt=\'file\' title=\'file\' style="border-radius: 50%;width: 40px;height: 40px;margin-right: 15px"/>' . $m_uploader . ' </a></h4>
            <img src=' . $m_image . ' alt="..."  style="width: 226px; height: 226px;">
        </div>
        <div class="media-body" style="margin-left: 30px">
            <div id="audio_player"></div>
            <input id="m_idx" name="m_idx" value="' . $m_idx . '" style="display: none"/>
            <input id="filename_val" value="' . $m_filename . '" style="display: none"/>
            <input id="uploader_val" value="' . $m_uploader . '" style="display: none"/>
            <div><p style="margin-top: 60px; margin-left: 15px;font-size: 16px;">' . $m_artist . '</p></div>
            <a style="margin-left: 30px;background-color: #3c3c3c; color: white;padding-bottom: 1px;padding-top: 1px;font-size: 15px"
               class="d-inline-flex p-2 pull-right" href="music_genre_list.php?m_genre='.urlencode($m_genre).'"># '.$m_genre.'</a>

            <a href="music_innerpage.php?m_idx=' . $m_idx . '&m_artist=' . $m_artist . '"
               style="margin-left: 10px;font-size: 18px;color: black" id="m_title"> ' . $m_title . '</a>

            <div>
                <audio class="audio" controls style="width: 854px; margin-top: 30px;margin-bottom: 20px">
                    <source src="/music_upload/' . $m_filename . '" type="audio/mpeg">
                </audio>
            </div>
            <div class="btn pull-right" style="padding-bottom: 3px;padding-top: 3px;margin-top: 10px;border: 1px solid transparent;" >
               ' . $m_length . '
            </div>
       
            <div class="btn pull-right"  style="padding-bottom: 3px;
                        padding-top: 3px;margin-bottom: 5px;margin-top: 10px;border: 1px solid transparent;">
                <img  src="/image/comment.png" style="margin-left: 5px"> ' . $rep_count_ . '
            </div>

            <div class="btn pull-right"style="margin-left: 10px;padding-bottom: 3px;
                        padding-top: 3px;margin-bottom: 5px;margin-top: 10px;margin-right: 5px;border: 1px solid transparent;" >▶ 재생횟수' . $m_playcnt . '</div>



                 <label class="like_btn_area" id="like_btn_area">
         
                    <label class="btn_liked" >
                        <button class="btn btn-outline-primary" id="likebtn" style="padding-bottom: 3px;padding-top: 3px;
                            margin-left: 10px; margin-bottom: 5px;background-color: #2b669a;color: white;" value="liked" >❤ ' . $rep_count . '</button>
                    </label>

            </label>
            
 <label class="btn_playlist">
                        <button class="btn btn-outline-primary" id="playlistbtn" style="padding-bottom: 3px;padding-top: 3px;margin-left: 10px; margin-bottom: 5px">Add</button>
                    </label>
            <!--                        좋아요 버튼-->
          
                    <label class="btn_delete">
                        <button class="btn btn-outline-primary" id="deletebtn" onclick="music_delete();" style="padding-bottom: 3px;padding-top: 3px;margin-left: 10px; margin-bottom: 5px">Delete</button>
                    </label>
      
                <label class="btn_edit">
                    <button class="btn btn-outline-primary" id="editbtn" onclick="music_edit();" style="padding-bottom: 3px;padding-top: 3px;margin-left: 10px; margin-bottom: 5px">Edit</button>
                </label>
          
       
            </div>
        </div>
    </div>
</div>
                    ';
                } else {// 좋아요되지 않은 상태
                    $response .= '
                    <div class="container" style="margin-bottom: 20px">
    <div class="media">
        <div><h4><a href="music_mymusic.php?m_uploader='.$m_uploader.'">
                    <img src=' . $usermig . ' alt=\'file\' title=\'file\' style="border-radius: 50%;width: 40px;height: 40px;margin-right: 15px"/>' . $m_uploader . ' </a></h4>
            <img src=' . $m_image . ' alt="..."  style="width: 226px; height: 226px;">
        </div>
        <div class="media-body" style="margin-left: 30px">
            <div id="audio_player"></div>
            <input id="m_idx" name="m_idx" value="' . $m_idx . '" style="display: none"/>
            <input id="filename_val" value="' . $m_filename . '" style="display: none"/>
            <input id="uploader_val" value="' . $m_uploader . '" style="display: none"/>
            <div><p style="margin-top: 60px; margin-left: 15px;font-size: 16px;">' . $m_artist . '</p></div>
            <a style="margin-left: 30px;background-color: #3c3c3c; color: white;padding-bottom: 1px;padding-top: 1px;font-size: 15px"
               class="d-inline-flex p-2 pull-right" href="music_genre_list.php?m_genre='.urlencode($m_genre).'"># '.urlencode($m_genre).'</a>

            <a href="music_innerpage.php?m_idx=' . $m_idx . '&m_artist=' . $m_artist . '"
               style="margin-left: 10px;font-size: 18px;color: black" id="m_title"> ' . $m_title . '</a>

            <div>
                <audio class="audio" controls style="width: 854px; margin-top: 30px;margin-bottom: 20px">
                    <source src="/music_upload/' . $m_filename . '" type="audio/mpeg">
                </audio>
            </div>
            <div class="btn pull-right" style="padding-bottom: 3px;padding-top: 3px;margin-top: 10px;border: 1px solid transparent;" >
               ' . $m_length . '
            </div>
       
            <div class="btn pull-right"  style="padding-bottom: 3px;
                        padding-top: 3px;margin-bottom: 5px;margin-top: 10px;border: 1px solid transparent;">
                <img  src="/image/comment.png" style="margin-left: 5px"> ' . $rep_count_ . '
            </div>

            <div class="btn pull-right"style="margin-left: 10px;padding-bottom: 3px;
                        padding-top: 3px;margin-bottom: 5px;margin-top: 10px;margin-right: 5px;border: 1px solid transparent;" >▶ 재생횟수' . $m_playcnt . '</div>



                 <label class="like_btn_area" id="like_btn_area">
             
                      <label class="btn_like" >
                        <button class="btn btn-outline-primary" id="likebtn" style="padding-bottom: 3px;padding-top: 3px;
                            margin-left: 10px; margin-bottom: 5px;" value="like" >❤ ' . $rep_count . '</button>
                    </label>
                 
            </label>
            
 <label class="btn_playlist">
                        <button class="btn btn-outline-primary" id="playlistbtn" style="padding-bottom: 3px;padding-top: 3px;margin-left: 10px; margin-bottom: 5px">Add</button>
                    </label>
            <!--                        좋아요 버튼-->
          
                    <label class="btn_delete">
                        <button class="btn btn-outline-primary" id="deletebtn" onclick="music_delete();" style="padding-bottom: 3px;padding-top: 3px;margin-left: 10px; margin-bottom: 5px">Delete</button>
                    </label>
      
                <label class="btn_edit">
                    <button class="btn btn-outline-primary" id="editbtn" onclick="music_edit();" style="padding-bottom: 3px;padding-top: 3px;margin-left: 10px; margin-bottom: 5px">Edit</button>
                </label>
          
       
            </div>
        </div>
    </div>
</div>
                    ';
                }

            } else {
                if ($rep_count2 == 1) {// 좋아요 된 상태
                    $response .= '
                    <div class="container" style="margin-bottom: 20px">
    <div class="media">
        <div><h4><a href="music_mymusic.php?m_uploader='.$m_uploader.'">
                    <img src=' . $usermig . ' alt=\'file\' title=\'file\' style="border-radius: 50%;width: 40px;height: 40px;margin-right: 15px"/>' . $m_uploader . ' </a></h4>
            <img src=' . $m_image . ' alt="..."  style="width: 226px; height: 226px;">
        </div>
        <div class="media-body" style="margin-left: 30px">
            <div id="audio_player"></div>
            <input id="m_idx" name="m_idx" value="' . $m_idx . '" style="display: none"/>
            <input id="filename_val" value="' . $m_filename . '" style="display: none"/>
            <input id="uploader_val" value="' . $m_uploader . '" style="display: none"/>
            <div><p style="margin-top: 60px; margin-left: 15px;font-size: 16px;">' . $m_artist . '</p></div>
            <a style="margin-left: 30px;background-color: #3c3c3c; color: white;padding-bottom: 1px;padding-top: 1px;font-size: 15px"
               class="d-inline-flex p-2 pull-right" href="music_genre_list.php?m_genre='.urlencode($m_genre).'"># '.$m_genre.'</a>

            <a href="music_innerpage.php?m_idx=' . $m_idx . '&m_artist=' . $m_artist . '"
               style="margin-left: 10px;font-size: 18px;color: black" id="m_title"> ' . $m_title . '</a>

            <div>
                <audio class="audio" controls style="width: 854px; margin-top: 30px;margin-bottom: 20px">
                    <source src="/music_upload/' . $m_filename . '" type="audio/mpeg">
                </audio>
            </div>
            <div class="btn pull-right" style="padding-bottom: 3px;padding-top: 3px;margin-top: 10px;border: 1px solid transparent;" >
               ' . $m_length . '
            </div>
       
            <div class="btn pull-right"  style="padding-bottom: 3px;
                        padding-top: 3px;margin-bottom: 5px;margin-top: 10px;border: 1px solid transparent;">
                <img  src="/image/comment.png" style="margin-left: 5px"> ' . $rep_count_ . '
            </div>

            <div class="btn pull-right"style="margin-left: 10px;padding-bottom: 3px;
                        padding-top: 3px;margin-bottom: 5px;margin-top: 10px;margin-right: 5px;border: 1px solid transparent;" >▶ 재생횟수' . $m_playcnt . '</div>



                 <label class="like_btn_area" id="like_btn_area">
            
                    <label class="btn_liked" >
                        <button class="btn btn-outline-primary" id="likebtn" style="padding-bottom: 3px;padding-top: 3px;
                            margin-left: 10px; margin-bottom: 5px;background-color: #2b669a;color: white;" value="liked" >❤ ' . $rep_count . '</button>
                    </label>
            </label>
            
 <label class="btn_playlist">
                        <button class="btn btn-outline-primary" id="playlistbtn" style="padding-bottom: 3px;padding-top: 3px;margin-left: 10px; margin-bottom: 5px">Add</button>
                    </label>
            <!--                        좋아요 버튼-->
    
      
            </div>
        </div>
    </div>
</div>
                    ';
                } else {// 좋아요되지 않은 상태
                    $response .= '
                    <div class="container" style="margin-bottom: 20px">
    <div class="media">
        <div><h4><a href="music_mymusic.php?m_uploader='.$m_uploader.'">
                    <img src=' . $usermig . ' alt=\'file\' title=\'file\' style="border-radius: 50%;width: 40px;height: 40px;margin-right: 15px"/>' . $m_uploader . ' </a></h4>
            <img src=' . $m_image . ' alt="..."  style="width: 226px; height: 226px;">
        </div>
        <div class="media-body" style="margin-left: 30px">
            <div id="audio_player"></div>
            <input id="m_idx" name="m_idx" value="' . $m_idx . '" style="display: none"/>
            <input id="filename_val" value="' . $m_filename . '" style="display: none"/>
            <input id="uploader_val" value="' . $m_uploader . '" style="display: none"/>
            <div><p style="margin-top: 60px; margin-left: 15px;font-size: 16px;">' . $m_artist . '</p></div>
            <a style="margin-left: 30px;background-color: #3c3c3c; color: white;padding-bottom: 1px;padding-top: 1px;font-size: 15px"
               class="d-inline-flex p-2 pull-right" href="music_genre_list.php?m_genre='.urlencode($m_genre).'"># '.$m_genre.'</a>

            <a href="music_innerpage.php?m_idx=' . $m_idx . '&m_artist=' . $m_artist . '"
               style="margin-left: 10px;font-size: 18px;color: black" id="m_title"> ' . $m_title . '</a>

            <div>
                <audio class="audio" controls style="width: 854px; margin-top: 30px;margin-bottom: 20px">
                    <source src="/music_upload/' . $m_filename . '" type="audio/mpeg">
                </audio>
            </div>
            <div class="btn pull-right" style="padding-bottom: 3px;padding-top: 3px;margin-top: 10px;border: 1px solid transparent;" >
               ' . $m_length . '
            </div>
       
            <div class="btn pull-right"  style="padding-bottom: 3px;
                        padding-top: 3px;margin-bottom: 5px;margin-top: 10px;border: 1px solid transparent;">
                <img  src="/image/comment.png" style="margin-left: 5px"> ' . $rep_count_ . '
            </div>

            <div class="btn pull-right"style="margin-left: 10px;padding-bottom: 3px;
                        padding-top: 3px;margin-bottom: 5px;margin-top: 10px;margin-right: 5px;border: 1px solid transparent;" >▶ 재생횟수' . $m_playcnt . '</div>



                 <label class="like_btn_area" id="like_btn_area">
               
                      <label class="btn_like" >
                        <button class="btn btn-outline-primary" id="likebtn" style="padding-bottom: 3px;padding-top: 3px;
                            margin-left: 10px; margin-bottom: 5px;" value="like" >❤ ' . $rep_count . '</button>
                    </label>
                   
            </label>
            
 <label class="btn_playlist">
                        <button class="btn btn-outline-primary" id="playlistbtn" style="padding-bottom: 3px;padding-top: 3px;margin-left: 10px; margin-bottom: 5px">Add</button>
                    </label>
            <!--                        좋아요 버튼-->
    
      
            </div>
        </div>
    </div>
</div>
                    ';
                }

            }

        }
    }
        exit($response);
    }else{
        exit('reachedMax');
    }
}
?>