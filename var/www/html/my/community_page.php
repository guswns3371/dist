<!doctype html>
<?php
      include ("mypage_2.php");

    $db = new mysqli("localhost","root","wnsgusgk3537","user");
    $db->set_charset("utf8");

    function mq($sql)
    {
        global $db;
        return $db->query($sql);
    }
?>

<html>
<head>
    <link href="/css/bootstrap.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script>
            function write() {

                $.ajax({
                    url: "writecheck.php",
                    type: "POST"
                }).done(function (data) {

                    if (data == 0) {
                        alert("로그인 후 게시글을 작성할 수 있습니다");
                    }
                    if (data == 1) {

                        location.href = "community_write_page.php"; // 현재 로케이션을 옮긴다
                        /** 갓 윤규형 진짜 */

                    }

                });
            }
        </script>
    <style>
        table {
            width: 100%;
            border-top: 1px solid #444444;
            border-collapse: collapse;
        }
        th, td {
            border-bottom: 1px solid #444444;
            padding: 9px;
        }
    </style>
</head>

<body>
<section class="articles-area section-padding-0-100">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Articles Post Area -->
            <div class="col-12 col-lg-8" style="flex-grow: 0;flex-shrink: 0;flex-basis: 90%;max-width: 90%;">
                <div class="mt-100">

                    <div id="upper-article-list"  class="single-articles-area d-flex flex-wrap mb-30">
                        <table style="height: 50px;width: 1000px;">
                            <colgroup>
                                <col style="width:80px">
                                <col style="width:120px">
                                <col>
                                <col style="width:100px">
                                <col style="width:100px">
                                <col style="width:80px">



                            </colgroup>
                            <thead>

                            <tr id="normalTableTitle" style="border-color:#0f0f0f;">

                                <th scope="col" style="width: 370px">번호</th>
                                <th scope="col" style="width: 320px"><span class="article_title" style="width: 360px">제목</span></th>
                                <th scope="col" class="th_name" style="width: 100px">작성자</th>
                                <th scope="col">작성일</th>
                                <th scope="col">조회</th>


                            </tr>
                            <tr id="simpleTableTitle" style="display:none;">

                                <th colspan="6" style="height:0px;padding: 0px;"></th>


                            </tr>
                            </thead>
                        </table>

                    </div>

                    <div id="lower-article-list" class="single-articles-area d-flex flex-wrap mb-30">
                        <table style="height: 50px;width: 1000px;">
                            <colgroup>
                                <col style="width:100px">
                                <col>
                                <col style="width:120px">
                                <col style="width:100px">
                                <col style="width:80px">

                            </colgroup>
                            <?php
                            if(isset($_GET['page'])){
                                $page = $_GET['page'];
                            }else{
                                $page = 1;
                            }
                            $sql = mq("select * from Community_Info");
                            $row_num = mysqli_num_rows($sql); //게시판 총 레코드 수
                            $list = 15; //한 페이지에 보여줄 개수
                            $block_ct = 5; //블록당 보여줄 페이지 개수

                            $block_num = ceil($page/$block_ct); // 현재 페이지 블록 구하기
                            $block_start = (($block_num - 1) * $block_ct) + 1; // 블록의 시작번호
                            $block_end = $block_start + $block_ct - 1; //블록 마지막 번호

                            $total_page = ceil($row_num / $list); // 페이징한 페이지 수 구하기
                            if($block_end > $total_page) $block_end = $total_page; //만약 블록의 마지박 번호가 페이지수보다 많다면 마지박번호는 페이지 수
                            $total_block = ceil($total_page/$block_ct); //블럭 총 개수
                            $start_num = ($page-1) * $list; //시작번호 (page-1)에서 $list를 곱한다.

                            $conn = mysqli_connect('localhost','root',
                                'wnsgusgk3537','user');
//                            $sql2 = "SELECT * FROM Community_Info";
                            $sql2 = mq("select * from Community_Info order by comm_num desc limit $start_num, $list");
                            $result2 = mysqli_query($conn,$sql2);
                            while($row = mysqli_fetch_array($sql2)){
                                $comm_num = $row['comm_num'];
                                $comm_title = $row['comm_title'];
                                $comm_content = $row['comm_content'];
                                $comm_username = $row['comm_username'];
                                $comm_date =  $row['comm_date'];
                                $comm_view =  $row['comm_view'];
                                $comm_userid = $row['comm_userid'];
                                $timenow = date("Y-m-d");

                                if(strlen($comm_title)>40)
                                {
                                    $comm_title=str_replace($row["comm_title"],mb_substr($row["comm_title"],0,30,"utf-8")."...",$row["comm_title"]); //title이 30을 넘어서면 ...표시
                                }

                                if($comm_date==$timenow){
                                    $img = "<img src='/image/new.png' alt='new' title='new' />";
                                }else{
                                    $img ="";
                                }

                              if($row['comm_file'] != ""){
                                   $img2 ="<img src='/image/icon_photo.png' alt='file' title='file' />";
                               }else{
                                   $img2 ="<img src='/image/icon_no_photo.png' alt='file' title='file' />";
                              }

                                $sql3 = mq("select * from Community_Reply where reply_comm_num='".$row['comm_num']."'");
                                $rep_count = mysqli_num_rows($sql3);
                                if($rep_count ==0){
                                    $rep_count = "";
                                }else{
                                    $rep_count = "[".$rep_count."]";
                                }

                                $sql3 =mq("select * from UserInfo where id= '$comm_userid'");
                                while ($row2 = $sql3->fetch_array()){
                                    $username= $row2['username'];
                                    $userid = $row2['id'];
                                    $usermig = $row2['userimg'];
                                    $userbackimg = $row2['userbackimg'];

                                    $usermig = str_replace(" ","%20",$usermig); // 파일 이름에 띄어쓰기 있으면 노노 -> 공백을 %20으로 채워야 한다
                                }
                                if($usermig == ""){
                                    $usermig ="http://127.0.0.1/image/white.jpg";
                                }else{
                                    $usermig = "http://127.0.0.1/image/userimg/".$usermig;
                                }
                                echo "
                           <tbody>
                            <tr>
                                <td class=\"td_num\"> $comm_num</td>
                                <td colspan=\"2\" class=\"td_article\">

                                    <div class=\"board-list\" style=\"width: 90px\">
                                        <div class=\"inner_list\" style=\"width: 600px\">

                                            $img2<a class=\"article\" href=\" http://127.0.0.1/my/community_inner.php?comm_num=$comm_num&page=$page\">
                                               $comm_title
                                            </a>

                                          
                                            <a style=\"font-weight:bold; color:red;\">
                                                <strong >$rep_count</strong>  $img 
                                            </a>
                                           

                                        </div>
                                    </div>
                                </td>
                                <td class=\"td_name\">
                                    <div class=\"pers_nick_area\">
                                    <table role=\"presentation\" cellspacing=\"0\">
                                    <tbody>
                                    <tr>
                                    <img src=$usermig style=\"width: 10px;height: 10px;margin-right: 15px\"/>
                                    <a href=\"music_mymusic.php?m_uploader=$userid\" class=\"m-tcol-c\">$comm_username</a>
                                   
                                    </tr>
                                    </tbody>
                                    </table>
                                    </div>
                                  
                                </td>
                                <td class=\"td_date\" style=\"width: 110px\">$comm_date</td>
                                <td class=\"td_view\" style=\"width: 100px\">$comm_view</td>
                               
                            </tr>
                            </tbody>
                            ";
                            }
                            ?>
                        </table>
                    </div>
                    <!-- ### Pagination Area ### -->
                    <nav aria-label="Page navigation example">
                        <div id="search_box">
                            <form action="community_search_result.php" method="get">
                                <div class="my-1">
                                    <select name="catgo" style="margin-left: 220px; height: 37px">
                                        <option value="comm_title">제목</option>
                                        <option value="comm_username">글쓴이</option>
                                        <option value="comm_content">내용</option>
                                    </select>

                                    <label for="input-default">
                                        <input type="text" name="search" size="40" required="required"  style="height: 39px;"/>

                                        <button class="btn" style="height: 40px">검색</button>
                                    </label>
                                </div>

                            </form>
                        </div>
<!--                            <li class="page-item active"><a class="page-link" href="#">01</a></li>-->
<!--                            <li class="page-item"><a class="page-link" href="#">02</a></li>-->
<!--                            <li class="page-item"><a class="page-link" href="#">03</a></li>-->

                            <div id="page_num">
                                <ul class="pagination mt-100" style="width: 999px">
                                    <?php
                                    if($page <= 1)
                                    { //만약 page가 1보다 크거나 같다면
                                        echo "<li class='fo_re'><a>처음</a></li>"; //처음이라는 글자에 빨간색 표시
                                    }else{
                                        echo "<li><a href='?page=1'>처음</a></li>"; //알니라면 처음글자에 1번페이지로 갈 수있게 링크
                                    }
                                    if($page <= 1)
                                    { //만약 page가 1보다 크거나 같다면 빈값

                                    }else{
                                        $pre = $page-1; //pre변수에 page-1을 해준다 만약 현재 페이지가 3인데 이전버튼을 누르면 2번페이지로 갈 수 있게 함
                                        echo "<li><a href='?page=$pre'>이전</a></li>"; //이전글자에 pre변수를 링크한다. 이러면 이전버튼을 누를때마다 현재 페이지에서 -1하게 된다.
                                    }
                                    for($i=$block_start; $i<=$block_end; $i++){
                                        //for문 반복문을 사용하여, 초기값을 블록의 시작번호를 조건으로 블록시작번호가 마지박블록보다 작거나 같을 때까지 $i를 반복시킨다
                                        if($page == $i){ //만약 page가 $i와 같다면
                                            echo "<li class='fo_re' style='color: red'><a>[$i]</a></li>"; //현재 페이지에 해당하는 번호에 굵은 빨간색을 적용한다
                                        }else{
                                            echo "<li><a href='?page=$i'>[$i]</a></li>"; //아니라면 $i
                                        }
                                    }
                                    if($block_num >= $total_block){ //만약 현재 블록이 블록 총개수보다 크거나 같다면 빈 값

                                    }else{
                                        $next = $page + 1; //next변수에 page + 1을 해준다.
                                        echo "<li><a href='?page=$next'>다음</a></li>"; //다음글자에 next변수를 링크한다. 현재 4페이지에 있다면 +1하여 5페이지로 이동하게 된다.
                                    }
                                    if($page >= $total_page){ //만약 page가 페이지수보다 크거나 같다면
                                        echo "<li class='fo_re'><a>마지막</a></li>"; //마지막 글자에 긁은 빨간색을 적용한다.
                                    }else{
                                        echo "<li><a href='?page=$total_page'>마지막</a></li>"; //아니라면 마지막글자에 total_page를 링크한다.
                                    }
                                    ?>





                            <li class="page-item"><a class="btn pull-right" id="wirteok" >글쓰기</a></li>
                            <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                            <script type="text/javascript">
                                document.querySelector('#wirteok').addEventListener('click',function (event) {
                                    write();
                                });

                            </script>
                        </ul>
                </div>
                        <!-- 18.10.11 검색 추가 -->

                </div>
                    </nav>
                </div>
            </div>

        </div>
    </div>
</section>
</body>
</html>