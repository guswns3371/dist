<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="/css/register_2.css" rel="stylesheet">
<!--    -->
<!--//    $conn = mysqli_connect('localhost','root',-->
<!--//        'wnsgusgk3537','user');-->
<!--//-->
<!--//        $sql2 = "SELECT * FROM UserInfo";-->
<!--//        $result2 = mysqli_query($conn,$sql2);-->
<!--//    $ok =strcmp(join.id.value,"");-->
<!--//    if($ok) {-->
<!--//        $alert="아이디를 입력하세요";-->
<!--//    }else{-->
<!--//                                    while($row = mysqli_fetch_array($result2)){-->
<!--//                                        //$row = mysqli_fetch_array($result2)에서 mysqli_fetch_array는 $result2에 있는 값이 없을때까지 그다음 정보를 반환한다-->
<!--//                                        //mysqli_fetch_array이 $result2에서 반환할 값이 없을때 NULL이 반환된다. php에서는 NULL == false 이다.-->
<!--//                                        //즉 while(false) 가 되어 이 반복문이 끝난다-->
<!--//                                        echo $row['id'];-->
<!--//-->
<!--//-->
<!--//-->
<!--//-->
<!--//                                            if (strcmp($row['id'],join.id.value)) {-->
<!--//                                                $alert = "이미 존재하는 아이디입니다";-->
<!--//                                            } else {-->
<!--//                                                $alert = "사용 가능한 아이디입니다";-->
<!--//                                            }-->
<!--//                                            $alert = "fuck";-->
<!--//                                        }-->
<!--//                }-->
<!--//-->
<!--//        //echo $error ;-->
<!--//    echo $alert;-->
<!--//-->
<!--//        error_log(mysqli_error($conn));// tail -f /var/log/apache2/error.log 에서 로그볼수 있다.-->
<!--//-->
<!--//-->
<!--//-->
<!--//    -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script language="JavaScript">
        function validate() {
            var re = /^(?=.*?[a-z])(?=.*?[0-9]).{4,12}$/ // 아이디가 적합한지 검사할 정규식
            var re2 = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
            // 이메일이 적합한지 검사할 정규식
            var re3 = /^[가-힣]{2,4}$/;//이름이 적합한지 검사할 정규식
            var re4 = /^[1-2]{1}[0-9]{3}[0-1]{1}[0-9]{1}[0-3]{1}[0-9]{1}$/;//생년월일 적합한지 검사할 정규식 yyyymmdd 형식
            var re5 = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,18}$/
            // 패스워드가 적합한지 검사할 정규식
            /**
             하나 이상의 영문 대문자 (?=.*?[AZ])
             적어도 하나의 영문 소문자 (?=.*?[az])
             하나 이상의 숫자 (?=.*?[0-9])
             하나 이상의 특수 문자 (?=.*?[#?!@$%^&*-])
             최소 길이 8 인치 .{6,} (앵커 포함)
             */
            var id = document.getElementById("id");
            var password = document.getElementById("password");
            var password_a = document.getElementById("password_a");
            var email = document.getElementById("email");
            var birthday = document.getElementById("birthday");
            var username = document.getElementById("username");
            var boolean = false;

            if((id.value=="") || !check(re,id,"아이디는 4~12자의 영문 대소문자와 숫자로 입력") || (password.value=="") ||
                (!check(re5,password,"패스워드는 6~18자의 영문 대소문자,숫자,특수문자로 입력")) ||
                (join.password.value != join.password_a.value) || (username.value=="") ||
                (!check(re3,username,"이름은 2~4자의 한글로만 입력"))|| (email.value=="") ||
                (!check(re2, email, "적합하지 않은 이메일 형식입니다."))|| (join.birthday.value=="") ||
                (!check(re4,birthday,"생년월일은 YYYYMMDD 형식으로만 입력 (예: 19990101)"))
            ) {
                // if (id.value == "") {
                //     // alert("이름을 입력해 주세요");
                //     id.focus();
                // }
                // if (!check(re, id, "아이디는 4~12자의 영문과 숫자로 입력")) {
                //     document.querySelector('#id2').innerHTML = "아이디는 4~12자의 영문과 숫자로 입력";
                //
                // }else {
                //     //ocument.querySelector('#id2').innerHTML = "";
                // }

                var id = $("#id").val();
                $.ajax({
                    url: "registerIdcheck.php",
                    type: "POST",
                    data:$("form").serialize(),
                }).done(function(data) {


                    if(data == 0){
                        var re = /^(?=.*?[a-z])(?=.*?[0-9]).{4,12}$/ // 아이디가 적합한지 검사할 정규식
                        if(re.test(id)) {
                            document.querySelector('#id2').innerHTML = "사용 가능한 아이디입니다";
                        }else {
                            document.querySelector('#id2').innerHTML = "아이디는 4~12자의 영문과 숫자로 입력!";
                        }
                    }
                    if(data ==1){
                        document.querySelector('#id2').innerHTML = "이미 존재하는 아이디입니다";
                    }if(data ==2){

                        document.querySelector('#id2').innerHTML = "아이디를 입력하세요";
                    }

                });

                if (password.value == "") {

                    password.focus();
                    // document.querySelector('#password2').innerHTML = "패스워드를 입력해 주세요";

                }
                if (!check(re5, password, "패스워드는 6~18자의 영문 대소문자,숫자,특수문자로 입력")) {
                    document.querySelector('#password2').innerHTML = "패스워드는 6~18자의 영문 대소문자,숫자,특수문자로 입력";

                }else {
                    document.querySelector('#password2').innerHTML = "";
                }

                if (join.password.value != join.password_a.value) {
                   // alert("비밀번호가 다릅니다. 다시 확인해 주세요.");

                    join.password_a.value = "";
                    join.password_a.focus();
                    document.querySelector('#password_a2').innerHTML = "비밀번호가 다릅니다. 다시 확인해 주세요.";

                }else {
                    document.querySelector('#password_a2').innerHTML = "";
                }


                if (username.value == "") {
                    // alert("이름을 입력해 주세요");
                    username.focus();
                    // document.querySelector('#username2').innerHTML = "이름을 입력해 주세요";

                }
                if (!check(re3, username, "이름은 2~4자의 한글로만 입력")) {
                    document.querySelector('#username2').innerHTML = "이름은 2~4자의 한글로만 입력";
                }else {
                    document.querySelector('#username2').innerHTML = "";
                }

                if (email.value == "") {
                    // alert("이메일을 입력해 주세요");
                    email.focus();

                }
                if (!check(re2, email, "적합하지 않은 이메일 형식입니다.")) {
                    document.querySelector('#email2').innerHTML = "적합하지 않은 이메일 형식입니다.";
                }else {
                    document.querySelector('#email2').innerHTML = "";
                }


                if (birthday.value == "") {
                   // alert("생년월일을 입력해 주세요");
                    join.birthday.focus();

                }
                if (!check(re4, birthday, "생년월일은 YYYYMMDD 형식으로만 입력 (예: 19990101)")) {
                    document.querySelector('#birthday2').innerHTML = "생년월일은 YYYYMMDD 형식으로만 입력 (예: 19990101)!";
                }else {
                    document.querySelector('#birthday2').innerHTML = "";
                }
                boolean = false;
            }else {
                //alert("회원가입이 완료되었습니다.");

                var a;
                var id = $("#id").val();
                $.ajax({
                    url: "registerIdcheck.php",
                    type: "POST",
                    async:false, //비동기를 동기로 바꿔줘야 전역변수 초기화 할수 있다 ㅄ아
                    data:$("form").serialize(),
                }).done(function(data) {
                    a =data;
                    if(a  == 0){
                        var re = /^(?=.*?[a-z])(?=.*?[0-9]).{4,12}$/ // 아이디가 적합한지 검사할 정규식
                        if(re.test(id)) {
                            //document.querySelector('#id2').innerHTML = "사용 가능한 아이디입니다!";
                            boolean = true;
                        }else {
                            document.querySelector('#id2').innerHTML = "아이디는 4~12자의 영문과 숫자로 입력!";
                            boolean = false;
                        }
                    }
                    if(a  ==1){
                        document.querySelector('#id2').innerHTML = "이미 존재하는 아이디입니다!";
                        boolean = false;
                    }if(a  ==2){

                        document.querySelector('#id2').innerHTML = "아이디를 입력하세요!";
                        boolean = false;
                    }

                });

                console.error(boolean);
                //boolean = true;
            }
            return boolean;
        }

        function check(re, what, message) {
            if(re.test(what.value)) {
                return true;
            }
           // alert(message);

            what.focus();
            //return false;
        }

        function idcheck() {

           var id = $("#id").val();
            $.ajax({
                url: "registerIdcheck.php",
                type: "POST",
                data:$("form").serialize(),
        }).done(function(data) {


            if(data == 0){
                var re = /^(?=.*?[a-z])(?=.*?[0-9]).{4,12}$/ // 아이디가 적합한지 검사할 정규식
                if(re.test(id)) {
                    document.querySelector('#id2').innerHTML = "사용 가능한 아이디입니다";
                }else {
                    document.querySelector('#id2').innerHTML = "아이디는 4~12자의 영문과 숫자로 입력!";
                }
            }
            if(data ==1){
                document.querySelector('#id2').innerHTML = "이미 존재하는 아이디입니다";
            }if(data ==2){

                document.querySelector('#id2').innerHTML = "아이디를 입력하세요";
                }

            });

        }
    </script>

</head>
<body>
<div id="register-page" class="row">
    <div class="col s12 z-depth-4 card-panel">
<!--        action="http://127.0.0.1/my/register_success.php"-->
        <form name="join" class="login-form" onsubmit="return validate();" method="POST"
              action="http://127.0.0.1/my/register_success.php">
            <div class="row">
                <div class="input-field col s12 center">
                    <h4>회원가입</h4>
                </div>
            </div>

            <div class="row margin">
                <div class="input-field col s12">
                    <input id="id" name="id" type="text" placeholder="아이디 (영문, 숫자 조합 | 4-12자)" required = required />
                    <span id="id2" style="color: #f22d32;" ></span> <br />
<!--                    <button type="button" class="btn" id="button2" onclick="idcheck();" >아이디 중복확인</button>-->

                </div>
            </div>

            <div class="row margin">
                <div class="input-field col s12">
                    <input id="password" name="password" type="password" placeholder="비밀번호 (영문 대소문자, 숫자, 특수문자 조합 | 6-18자)"
                    required = required/>
                    <span id="password2" style="color: #f22d32;"></span>
                    <label for="password"></label>
                </div>
            </div>

            <div class="row margin">
                <div class="input-field col s12">
                    <input id="password_a" name="password_a" type="password" placeholder="비밀번호 확인"  required = required />
                    <span id="password_a2" style="color: #f22d32;"></span>
                    <label for="password_a"></label>
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12">
                    <input id="username" name="username" type="text" placeholder="이름"  required = required />
                    <span id="username2" style="color: #f22d32;"></span>
                    <label for="username"></label>
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12">

                    <input id="email" name="email" type="text"  style="cursor: auto;" placeholder="이메일" required = required />
                    <span id="email2" style="color: #f22d32;"></span>
                    <label for="email"></label>
                </div>
            </div>

            <div class="row margin">
                <div class="input-field col s12">
                    <input id="birthday" name="birthday" type="text" placeholder="생년월일 (YYYYMMDD)" required = required />
                    <span id="birthday2" style="color: #f22d32;" ></span>
                    <label for="birthday"></label>
                </div>
            </div>



            <div class="row">
                <div class="input-field col s12">
                    <button type="submit" id = "button1" class="btn waves-effect waves-light col s12">회원가입</button>
                    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                    <script type="text/javascript">
                        document.querySelector('#button1').addEventListener('click',function (event) {

                           // idcheck();
                          validate();
                        });

                    </script>

                </div>
            </div>


        </form>
    </div>
</div>
<!--<script src="/js/register2.js"></script>-->
<!--<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>-->
<!--<script type="text/javascript" src="/js/jquery.validate.min.js"></script>-->
<!--<script type="text/javascript" src="/js/additional-methods.min.js"></script>-->
<!--<script type="text/javascript" src="/js/messages_ko.min.js"></script>-->
</body>
</html>