<?php
include ("mypage_2.php");
include ("db.php");

$bno = $_GET['comm_num'];
$page = $_GET['page'];
$sql = mq("select * from Community_Info where comm_num='$bno';");
$board = $sql->fetch_array();
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>게시판</title>
<!--    <link rel="stylesheet" href="/css/style.css" />-->
    <link href="/css/bootstrap.css" rel="stylesheet">
</head>
<body>
<!--<div id="board_write">-->
<!--    <h1><a href="/">자유게시판</a></h1>-->
<!--    <h4>글을 수정합니다.</h4>-->
<!--    <div id="write_area">-->
<!--        <form action="modify_ok.php/--><?php //echo $board['comm_num']; ?><!--" method="post">-->
<!--            <input type="hidden" name="idx" value="--><?//=$bno?><!--" />-->
<!--            <div id="in_title">-->
<!--                <textarea name="title" id="utitle" rows="1" cols="55" placeholder="제목" maxlength="100" required>--><?php //echo $board['comm_title']; ?><!--</textarea>-->
<!--            </div>-->
<!--            <div class="wi_line"></div>-->
<!---->
<!--            <div class="wi_line"></div>-->
<!--            <div id="in_content">-->
<!--                <textarea name="content" id="ucontent" placeholder="내용" required>--><?php //echo $board['comm_content']; ?><!--</textarea>-->
<!--            </div>-->
<!---->
<!--            <div class="bt_se">-->
<!--                <button type="submit">글 작성</button>-->
<!--            </div>-->
<!--        </form>-->
<!--    </div>-->
<!--</div>-->

<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"></div>

    <div class="panel-body">

        <div class="container">
            <h2>글을 수정합니다</h2>
                <form action="community_modify_ok.php?comm_num=<?php echo $board['comm_num']; ?>&page=<?php echo $page; ?>" method="post">
                    <div class="form-group">
                        <label for="subject">제목</label>
                        <input type="hidden" name="comm_num" value="<?=$bno?>" />
                        <div id="in_title">
                            <textarea class="form-control" name="comm__title" id="comm__title" rows="1" cols="55" placeholder="제목" maxlength="100" required><?php echo $board['comm_title']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content">글 작성:</label>
                        <textarea class="form-control" rows="10" name="comm__content" class="form-control" id="comm__content" placeholder="내용" required><?php echo $board['comm_content']; ?></textarea>

                    </div>

                    <div>
                        <button class="btn btn-secondary " type="submit">글 수정</button>
                    </div>

                </form>

        </div>
    </div> <!--panel end-->
</div>

</div>
</body>
</html>
