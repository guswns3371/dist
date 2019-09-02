
<?php
include ("mypage_2.php");
//include ("db.php");
$db = new mysqli("localhost","root","wnsgusgk3537","user");
$db->set_charset("utf8");

function mq($sql)
{
    global $db;
    return $db->query($sql);
}
?>
<?php
    $page = $_GET['page'];
    $bno = $_GET['comm_num']; /* bno함수에 comm_num값을 받아와 넣음*/
    $hit = mysqli_fetch_array(mq("select * from Community_Info where comm_num ='".$bno."'"));
    $hit = $hit['comm_view'] + 1;
    $fet = mq("update Community_Info set comm_view = '".$hit."' where comm_num = '".$bno."'");
    $sql = mq("select * from Community_Info where comm_num='".$bno."'"); /* 받아온 comm_num값을 선택 */
    $board = $sql->fetch_array();
    $comm_num = $board['comm_num'];
    $comm_file = $board['comm_file'];
    $comm_userid = $board['comm_userid'];
    $trim_filename = str_replace("%20", " ", $comm_file);
    error_log($trim_filename);
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>게시판</title>
    <link href="/css/bootstrap.css" rel="stylesheet">
<!--    <link rel="stylesheet"  href="/css/style.css" />-->
    <style>
        hr {
            margin-top: 0px;
            margin-bottom: 10px;
            border: 0;
            border-top: 1px solid #eee;
        }
        /* 댓글 */
        .reply_view {
            width:900px;
            margin-top:100px;
            word-break:break-all;
        }
        .dap_lo {
            font-size: 14px;
            padding:10px 0 15px 0;
            border-bottom: solid 1px gray;
        }
        .dap_to {
            margin-top:5px;
        }
        .rep_me {
            font-size:12px;
        }
        .rep_me ul li {
            float:left;
            width: 30px;
        }
        .dat_delete {
            display: none;
        }
        .dat_edit {
            display:none;

        }
        .dat_reply{
            display:none;

        }
        .dap_sm {
            position: absolute;
            top: 10px;
        }
        .dap_edit_t{
            width:520px;
            height:70px;
            position: absolute;
            top: 40px;
        }
        .re_mo_bt {
            position: absolute;
            top:40px;
            right: 5px;
            width: 90px;
            height: 72px;
        }
        #re_content {
            width:700px;
            height: 56px;
        }
        .dap_ins {
            margin-top:50px;
        }
        .re_bt {
            position: absolute;
            width:100px;
            height:56px;
            font-size:16px;
            margin-left: 10px;
        }
        #foot_box {
            height: 50px;
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<!--   <script src="/js/common.js"></script>-->
    <script>
        $(document).ready(function(){

            $("#rep_bt2").click(function(){
                var params = $("form").serialize();
                $.ajax({
                    type: 'post',
                    url: 'community_reply_ok.php?=<?php echo $board["comm_num"]; ?>',
                    data : params,
                    dataType : 'html',
                    success: function(data){
                        console.error("/".data);
                        if (data == 0){
                            alert("댓글을 입력하세요");
                        } else {
                            $(".reply_view").html(data);
                            $(".form-control").val('');
                        }

                    }
                });
            });
            //
            $(".dat_edit_bt").click(function(){
                /* dat_edit_bt클래스 클릭시 동작(댓글 수정) */

                var obj = $(this).closest(".dap_lo").find(".dat_edit");
                obj.show();
                // obj.dialog({
                //     autoOpen : false,
                //     modal:true,
                //     width:650,
                //     height:200,
                //     title:"댓글 수정"});
            });
            //
            $(".dat_delete_bt").click(function(){
                /* dat_delete_bt클래스 클릭시 동작(댓글 삭제) */
                var obj = $(this).closest(".dap_lo").find(".dat_delete");
                obj.show();
            });
            $(".dat_reply_bt").click(function(){
                /* dat_delete_bt클래스 클릭시 동작(댓글 삭제) */
                var obj = $(this).closest(".dap_lo").find(".dat_reply");
                obj.show();
            });
            //
        });
        function modify_ok() {
            var r= confirm("정말 수정 하시겠습니까?")
            if(r == true){
                location.href = "community_modify.php?comm_num=<?php echo $comm_num?>&page=<?php echo $page?>&comm_file=<?php echo $comm_file?>";
            }else {

            }
        }
        function delete_ok() {
            var r= confirm("정말 삭제 하시겠습니까?")
            if(r == true){
                location.href = "community_delete.php?comm_num=<?php echo $comm_num?>&page=<?php echo $page?>&comm_file=<?php echo $comm_file?>";
            }else {

            }
        }
    </script>
</head>
<body>


<body>
<div class="panel panel-default" style="margin-top: 70px">
    <!-- Default panel contents -->
    <div class="panel-heading"></div>

    <div class="panel-body">

        <div class="container">
            <h1><?php echo $board['comm_title']; ?></h1>
            <hr class="one">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" style="width: 1100px; font-style: italic">
                                                <label for="name"></label>
                                                <?php
                                                $sql3 = mq("select * from Community_Reply where reply_comm_num='".$bno."'");
                                                $rep_count = mysqli_num_rows($sql3);

                                                $sql3 =mq("select * from UserInfo where id= '$comm_userid'");
                                                while ($row2 = $sql3->fetch_array()){
                                                    $username= $row2['username'];
                                                    $userid = $row2['id'];
                                                    $usermig = $row2['userimg'];

                                                    $usermig = str_replace(" ","%20",$usermig); // 파일 이름에 띄어쓰기 있으면 노노 -> 공백을 %20으로 채워야 한다
                                                }
                                                if($usermig == ""){
                                                    $usermig ="http://127.0.0.1/image/white.jpg";
                                                }else{
                                                    $usermig = "http://127.0.0.1/image/userimg/".$usermig;
                                                }
                                                ?>
                                                <div style="color: #28a4c9"><b><img src=<?php echo $usermig;?> style="width: 20px;height: 20px;margin-right: 5px;"/><?php echo $board['comm_username']; ?></b></div> <?php echo $board['comm_date']."   "; ?> <?php echo "댓글수 : ".$rep_count ?>
                                                <div class="pull-right">조회수:<?php echo $board['comm_view']; ?></div>
                                            </div>
                                        </div>
                                    </div>


            <hr class="one">
            <div>
                <?php
                    if($board['comm_file'] != null){?>
                파일 : <a href="/community_upload/<?php echo $board['comm_file'];?>" download><?php echo $board['comm_file']; ?></a>
                <?php }?>
            </div>
                <div class="form-group" style="margin-bottom: 200px">
                    <label for="subject" style="font-size: 18px">
                    <?php echo nl2br($board['comm_content']); ?>
                    </label>
                </div>
            <!-- 여기까지가 글 불러오기-->

            <!-- 글 목록/ 삭제/ 수정 버튼 부분-->
            <hr class="one">
                <div class="center-block" >
                    <a class="btn btn-secondary" href="community_page.php?page=<?php echo $page?>">목록으로</a>
                    <?php
                        if($board['comm_userid'] == $_SESSION['UserId']){
                            echo "
                             <a class=\"btn btn-secondary\" href='javascript::' onclick=\"modify_ok();\">수정</a>
                             <a class=\"btn btn-secondary\" href='javascript::' onclick=\"delete_ok();\">삭제</a>";
                        }
                    ?>
                </div>
<!--            <a class=\"btn btn-secondary \" href=\"community_modify.php?comm_num=$comm_num&page=$page\">수정</a>-->
<!--            <a class=\"btn btn-secondary m\" href=\"community_delete.php?comm_num=$comm_num&page=$page\">삭제</a>";-->
            <!--- 댓글 불러오기 -->
            <div class="reply_view" style="width: 1100px">

                <h3>댓글목록</h3>
                <hr class="one">
                <?php
                $sql3 = mq("select * from Community_Reply where reply_comm_num='".$bno."' order by reply_idx desc");
                while($reply = $sql3->fetch_array()){
                    $reply_username = $reply['reply_username'];
                    $reply_userid = $reply['reply_userid'];
                    $reply_idx = $reply['reply_idx'];
                    $reply_date = $reply['reply_date'];
                    $reply_content = $reply['reply_content'];
                    //$reply_content_2 = nl2br("$reply[content]");
                    ?>
                    <div class="dap_lo" id="dap_lo" name="dap_lo">
                        <div style="color: #28a4c9"><b><?php echo $reply['reply_username'];?></b></div>
                        <div class="dap_to comt_edit" style="font-style: oblique; color: #080808; font-size: 17px"><?php echo nl2br($reply['reply_content']); ?></div>
                        <div class="rep_me dap_to" style="font-size: 14px"><?php echo $reply['reply_date']; ?></div>
                        <div class="rep_me rep_menu">
                        <?php if($reply_userid == $_SESSION['UserId'])
                        {
                            echo "
                            <a class=\"dat_edit_bt\" href=\"javascript:;\" style=\"color: #28a4c9\">수정</a>
                            <a class=\"dat_delete_bt\" href=\"javascript:;\" style=\"color: #28a4c9\">삭제</a>";
                          }?>
                        <a class="dat_reply_bt" href="javascript:;" style="color: #28a4c9">댓글</a>
                        </div>
                        <!-- 대댓글이 나오는 곳 -->
                        <?php
                        $sql2 = mq("select * from Community_ReReply where rereply_reply_idx='".$reply_idx."' and rereply_comm_num = '".$bno."' order by rereply_idx desc ");
                        while($rereply = $sql2->fetch_array()){
                            $rereply_idx= $rereply['rereply_idx'];
                            $rereply_reply_idx= $rereply['rereply_reply_idx'];
                            $rereply_comm_num= $rereply['rereply_comm_num'];
                            $rereply_username= $rereply['rereply_username'];
                            $rereply_userid= $rereply['rereply_userid'];
                            $rereply_password= $rereply['rereply_password'];
                            $rereply_content= $rereply['rereply_content'];
                            $rereply_date= $rereply['rereply_date'];

                        ?>
                            <div style="margin-left: 30px;margin-top: 10px">
                                <div>╚  <b style="color: #28a4c9"><?php echo $rereply_username;?></b></div>
                                <div class="dap_to comt_edit" style="font-style: oblique; color: #080808; font-size: 17px"><?php echo nl2br($rereply_content); ?></div>
                                <div class="rep_me dap_to" style="font-size: 14px"><?php echo $rereply_date; ?></div>
                            </div>

                        <?php }?>

                        <!-- 댓글 수정 폼 dialog -->
                        <div class="dat_edit">
                            <form method="post" action="community_reply_modify_ok.php?page=<?php echo $page?>">
                                    <div class="panel panel-default" style="width: 230px">
                                        <div class="panel-heading"></div>
                                        <input type="hidden" name="rno" id="rno" value="<?php echo $reply['reply_idx']; ?>" />
                                        <input type="hidden" name="b_no" id="b_no" value="<?php echo $bno; ?>">
                                        <input type="password" name="pw" placeholder="비밀번호" style="width: 227px" />
                                        <textarea name="reply_content2" style="width: 227px" ><?php echo $reply['reply_content']; ?></textarea>
                                        <input type="submit" class="btn btn-secondary" value="수정하기" style="width: 227px">
                                    </div>
                            </form>
                        </div>

                        <!-- 댓글 삭제 비밀번호 확인 -->
                        <div class="dat_delete">
                            <form action="community_reply_delete.php?page=<?php echo $page?>" method="post">
                                <div class="panel panel-default" style="width: 230px">
                                    <div class="panel-heading"></div>
                                    <input type="hidden" name="rno" id="rno" value="<?php echo $reply['reply_idx']; ?>" /><input type="hidden" name="b_no" id="b_no" value="<?php echo $bno; ?>">
                                    <p><input type="password" name="pw" id="pw"  placeholder="비밀번호" style="width: 227px"/>
                                        <input type="submit" class="btn btn-secondary" value="삭제하기" style="width: 227px"></p>
                                </div>
                            </form>
                        </div>

                        <!-- 대 댓글! -->
                        <div class="dat_reply">
                            <form method="post" action="Community_Rereply.php?page=<?php echo $page?>&comm_num=<?php echo $bno; ?>&reply_idx=<?php echo $reply['reply_idx']; ?>">
                                <div class="panel panel-default" style="width: 404px">
                                    <div class="panel-heading"></div>
                                    <input type="hidden" name="re_rno" id="re_rno" value="<?php echo $reply['reply_idx']; ?>" />
                                    <input type="hidden" name="re_b_no" id="re_b_no" value="<?php echo $bno; ?>">
                                    <textarea name="re_reply_content3" style="width: 400px;height: 70px;" ></textarea>
                                    <input type="submit" class="btn btn-secondary" value="댓글달기" style="width: 400px;">
                                </div>
                            </form>
                        </div>


                    </div>
                <?php } ?>

            <!--- new 댓글 입력 폼 -->
            <div class="dap_ins">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading"></div>

                <div class="panel-body">

                    <div class="container">
                        <h3>댓글쓰기</h3>

                        <form role="form" method="post" id="reply_form" name="reply_form" style="width: 1050px">
                            <div class="form-group">
                                <label for="content">댓글 작성란</label>
                                <input type="hidden" name="bno" value="<?php echo $bno; ?>">
<!--                                 $bno = $_GET['comm_num'];-->
                                <textarea class="form-control" rows="2" name="content" id="reply_content"></textarea>
                            </div>
                            <?php
                                if(isset($_SESSION['UserId'])){
                                    echo "<input type=\"submit\" id=\"rep_bt2\" class=\"btn btn-secondary\" value=\"댓글저장\" style=\"font-size: 12px\">";
                                }else{
                                    echo "<input type=\"submit\" disabled id=\"rep_bt2\" class=\"btn btn-secondary\" value=\"댓글저장\" style=\"font-size: 12px\">";
                                }
                            ?>

                        </form>

                    </div>
                </div>
            </div>
            <div>
        </div>
        </div>


    </div> <!--panel end-->

</div>

</div>
</body>
</html>