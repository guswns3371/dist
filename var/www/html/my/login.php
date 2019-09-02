<!doctype html>


<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="/css/login.css" rel="stylesheet">
    <link href="/css/s.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--<script src="/js/register2.js"></script>-->
    <!--<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>-->
    <!--<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script language="JavaScript">
        function validate_login() {
            var id = document.getElementById("Lid");
            var password = document.getElementById("Lpassword");
            // var autologin_cb = document.getElementById("autologin_cb");
            // var isAuto = autologin_cb.getAttribute("checked");
            //$(autologin_cb).is(":checked");
            var bool =false;
            if(id.value ==="" || password.value ===""){
                alert("아이디와 비밀번호를 모두 입력하세요");
                bool = false;
            }

            else if(id.value !=="" && password.value !=="") {
                $.ajax({
                    url: "logincheck.php",
                    type: "POST",
                    data: {
                            // $("form").serialize(),
                            isAuto : $(autologin_cb).is(":checked"),
                        Lid : $('#Lid').val(),
                        Lpassword : $('#Lpassword').val()

                            },
                }).done(function (data) {

                    if (data === 0) {
                        bool= true;
                        location.href = "music_home.php"; // 현재 로케이션을 옮긴다
                        /** 갓 윤규형 진짜 */
                        //alert("로그인에 성공하였습니다.");


                    }
                    if (data === 1) {
                        bool= false;
                        alert("아이디와 비밀번호가 일치하지 않습니다.");

                    }
                    if (data === 2) {
                        bool= false; // 비동기식 코드라서 바로바로 반영 안됨
                        alert("존재하지 않는 아이디 입니다.");
                        location.reload();
                    }

                });
            }
            console.error(bool);
            return bool;
           // alert("로그인에 성공하였습니다.");
        }
    </script>
</head>
<body>

<div id="login-page" class="row">
    <div class="col s12 z-depth-4 card-panel">
        <form name="loginn" class="login-form" onsubmit="return validate_login();" action="http://127.0.0.1/my/mypage_2.php"
              method="post">
            <div class="row">
                <div class="input-field col s12 center">
                    <h4>로그인</h4>
                    <!--<p class="center">Join to our community now !</p>-->
                </div>
            </div>

            <div class="row margin">
                <div class="input-field col s12">
                    <!-- <i class="mdi-social-person-outline prefix"></i> -->

                    <input id="Lid" name="Lid" type="text" placeholder="아이디" />
                    <label for="Lid"></label>
                </div>
            </div>

            <div class="row margin">
                <div class="input-field col s12">
                    <!-- <i class="mdi-action-lock-outline prefix"></i> -->
                    <input id="Lpassword" name="Lpassword" type="password" placeholder="비밀번호" />
                    <label for="Lpassword"></label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    
                  <input id ="autologin_cb" type="checkbox" value="" class="mycheckbox"  /> 30일간 자동로그인
                         <!-- 천사 엔젤분이 알려주심
                         먼저 개발자 모드에서 커서로 그 부분을 본다
                         css 부분에서 하나하나 만져본다
                         -->

                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <button type="submit" class="btn waves-effect waves-light col s12">로그인</button>

                </div>
                <div class="input-field col s12">
                <p class="margin center medium-small sign-up">아직 가입 안하셨나요? <a href="http://127.0.0.1/my/register.php">회원가입</a></p>
                </div>
            </div>


        </form>
    </div>
</div>
<!--<script src="/js/register2.js"></script>-->
<!--<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>-->
<!--<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>-->
</body>
</html>