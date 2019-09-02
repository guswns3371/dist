<!doctype html>
<?php
include ("mypage_2.php");
?>
<html>
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        function saveit() {

            $.ajax({
                url: "community_saveit.php",
                type: "POST",
                data:
                    $("#formname1").serialize()
                ,
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            }).done(function (data) {
                    if(data == 0){// 제목 내용 둘중 하나라도 없을경우
                        alert("제목과 내용을 모두 입력해 주세요");
                    }
                    if(data == 1){//제대로 저장이 안 되었을떄
                        alert("저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의 하세요")
                    }
                    if(data == 2){// 제대로 저장이 되었을떄
                        alert("저장 완료")
                        location.href = "community_page.php?page=1";
                    }

            });
        }
    </script>
</head>
<body>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"></div>

    <div class="panel-body">

        <div class="container">
            <h2>글쓰기</h2>
                <form role="form" id="formname1" name="formname1" method="post" action="community_saveit.php" enctype="multipart/form-data">

<!--                    <div class="row">-->
<!--                        <div class="col-md-6">-->
<!--                            <div class="form-group">-->
<!--                                <label for="name">NAME</label>-->
<!--                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="col-md-6">-->
<!--                            <div class="form-group">-->
<!--                                <label for="pass">Password</label>-->
<!--                                <input type="password" class="form-control" name="pass" id="pass" placeholder="Enter password">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->


<!--                    <div class="form-group">-->
<!--                        <label for="email">Email address</label>-->
<!--                        <input type="email" class="form-control" name ="email" id="email" placeholder="Enter email">-->
<!--                    </div>-->


                    <div class="form-group">
                        <label for="subject">제목</label>
                        <input type="text" class="form-control" name ="comm__title" id="comm__title" placeholder="게시글 제목을 입력하세요">
<!--                        name ="comm__title" 이 에이젝스로 넘길때 가는 정보명이다. id 가 아니라-->
                    </div>


                    <div class="form-group">
                        <label for="content">글 작성:</label>
                        <textarea class="form-control" rows="10" name="comm__content" id="comm__content"></textarea>

                    </div>

                    <div class="form-group" id="in_file">
<!--                        <label for="File">첨부파일</label>-->
                        <input class="btn" type="file" id="b_file" name="b_file" value="파일선택">
                    </div>


                    <div class="center-block" style='width:300px'>
                        <input class="btn" type="submit" value="저장하기" style="font-size: 12px" id="save_btn">
                        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                        <script>
                            document.querySelector('#save_btn').addEventListener('click',function (event) {

                                //saveit();
                                //ajax 말고 폼태그로 action="community_saveit.php" 보내버림
                            });
                        </script>
                        <input class="btn" type="reset" value="다시쓰기" style="font-size: 12px">
                        <input class="btn" type="button" value="뒤로가기" onclick="history.back(1)" style="font-size: 12px">
                    </div>

                </form>


        </div>
    </div> <!--panel end-->
</div>

</div>
</body>
</html>
