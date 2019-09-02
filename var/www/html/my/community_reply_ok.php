<?php
//include ("db.php");
session_start();
header('Content-Type: text/html; charset=utf-8'); // utf-8인코딩

$db = new mysqli("localhost","root","wnsgusgk3537","user");
$db->set_charset("utf8");

function mq($sql)
{
    global $db;
    return $db->query($sql);
}
$bno = $_POST['bno'];
$user_id =  $_SESSION['UserId'];
$user_pw =  $_SESSION['UserPassword'];
$user_name =  $_SESSION['UserName'];
$reply_content = $_POST['content'];
$date = date('Y-m-d h:i:sa');

error_log("reply_ok 5 :".$bno."/".$user_id."/".$user_pw."/".$user_name."/".$date."/".$reply_content);
//$userpw = password_hash($_POST['dat_pw'], PASSWORD_DEFAULT);
if($reply_content!=""){
    $sql = mq("INSERT INTO Community_Reply (reply_comm_num,reply_username,reply_userid,reply_password,reply_content,reply_date) 
          VALUES( 
              '{$bno}',
              '{$user_name}',
              '{$user_id}',
              '{$user_pw}',
              '{$reply_content}',
              '{$date}')");
}else{
    echo "0";
}
?>
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
                    $(".reply_view").html(data);
                    $(".form-control").val('');
                }
            });
        });
        //
        $(".dat_edit_bt").click(function(){
            /* dat_edit_bt클래스 클릭시 동작(댓글 수정) */
            alert("11121")
            var obj = $(this).closest(".dap_lo").find(".dat_edit");
            obj.dialog({
                modal:true,
                width:650,
                height:200,
                title:"댓글 수정"});
        });
        //
        $(".dat_delete_bt").click(function(){
            /* dat_delete_bt클래스 클릭시 동작(댓글 삭제) */
            alert("222")
            var obj = $(this).closest(".dap_lo").find(".dat_delete");
            obj.dialog({
                modal:true,
                width:400,
                title:"댓글 삭제확인"});
        });
        //

    });
</script>

<h3>댓글목록</h3>
<?php
if($reply_content!=""){
$sql3 = mq("select * from Community_Reply where reply_comm_num='".$bno."' order by reply_idx desc");
    while($reply = $sql3->fetch_array()){

    ?>
    <div class="dap_lo">
        <div><b><?php echo $reply['reply_username'];?></b></div>
        <div class="dap_to comt_edit"><?php echo nl2br("$reply[content]"); ?></div>
        <div class="rep_me dap_to"><?php echo $reply['reply_date']; ?></div>
        <?php if($reply_userid == $_SESSION['UserId'])
        {
            echo " <div class=\"rep_me rep_menu\">
                            <a class=\"dat_edit_bt\" href=\"javascript:;\">수정</a>
                            <a class=\"dat_delete_bt\" href=\"javascript:;\">삭제</a>
                        </div>";
        }?>
<!--        <div class="rep_me rep_menu">-->
<!--            <a class="dat_edit_bt" href="javascript:;">수정</a>-->
<!--            <a class="dat_delete_bt" href="javascript:;">삭제</a>-->
<!--        </div>-->
        <!-- 댓글 수정 폼 dialog -->
        <div class="dat_edit">
            <form method="post" action="rep_modify_ok.php">
                <input type="hidden" name="rno" value="<?php echo $reply['reply_idx']; ?>" /><input type="hidden" name="b_no" value="<?php echo $bno; ?>">
                <input type="password" name="pw" class="dap_sm" placeholder="비밀번호3" />
                <textarea name="content" class="dap_edit_t"><?php echo $reply['reply_content']; ?></textarea>
                <input type="submit" value="수정하기3" class="re_mo_bt">
            </form>
        </div>
        <!-- 댓글 삭제 비밀번호 확인 -->
        <div class="dat_delete">
            <form action="reply_delete.php" method="post">
                <input type="hidden" name="rno" value="<?php echo $reply['reply_idx']; ?>" /><input type="hidden" name="b_no" value="<?php echo $bno; ?>">
                <p>비밀번호<input type="password" name="pw" /> <input type="submit" value="확인"></p>
            </form>
        </div>
    </div>
<?php }}else{
    echo "0";
} ?>

<!--- 댓글 입력 폼 -->
<div class="dap_ins">
    <form method="post" class="reply_form">
        <input type="hidden" name="bno" value="<?php echo $bno; ?>">
        <input type="text" name="dat_user" id="dat_user" size="15" placeholder="아이디">
        <input type="password" name="dat_pw" id="dat_pw" size="15" placeholder="비밀번호">
        <div style="margin-top:10px; ">
            <textarea name="content" class="reply_content" id="re_content" ></textarea>
            <button type="suid="rep_bt" class="re_bt">댓글</button>
        </div>
    </form>
</div>