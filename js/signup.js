// id 의 경우 영문 대,소문자 or 숫자 or _ 로 시작하는 4~12 가지 글자 (_외 특수문자 금지)
const idValidate = /^(\w){4,12}$/;
// email 의 경우 양식에 맞는 글자만 사용되어야함 ex) aaa@aa.aa
const emailValidate = /^(\w|[-.])+[@](\w|[-.])+[.]\w{2,5}$/;
// 닉네임 정규식 : 닉네임의 경우 영문 대,소문자 or 숫자 or _ or 한글 로 시작하는 3~10 가지 글자 (_외 특수문자 금지)
const nickValidate = /^([가-힣]|\w){3,10}$/;
// 비밀번호의 경우 영문 대,소문자 or 숫자 or _ 로 시작하는 8~20 가지 글자 (첫 글자 외 특수문자 가능)
const pwValidate = /^(\w)([~!@#$%^&*()-?]|\w){7,19}$/;

// 각각의 정보를 html 에서 가져옴
// 입력된 input 값 가져오는 변수
var id_input = document.getElementById("id");
var email_input = document.getElementById("email");
var nickname_input = document.getElementById("nickName");
var pw1_input = document.getElementById("passwordFirst");
var pw2_input = document.getElementById("passwordConfirm");
// 아래 helper text 값 가져오는 변수
var idHelper_span = document.getElementById("iderror");
var emailHelper_span = document.getElementById("emailerror");
var nickHelper_span = document.getElementById("nickNameerror");
var pw1Helper_span = document.getElementById("passwordFirsterror");
var pw2Helper_span = document.getElementById("passwordConfirmerror");

// 각각의 양식이 맞는지 확인
let idCheckComfirm = false;
let nickCheckComfirm = false;
let emailCheckComfirm = false;
let pw1CheckComfirm = false;
let pw2CheckComfirm = false;


function resettext() {
    idHelper_span.innerHTML = '';
    emailHelper_span.innerHTML = '';
    nickHelper_span.innerHTML = '';
    pw1Helper_span.innerHTML = '';
    pw2Helper_span.innerHTML = '';
}



function comfirmcomplete() {
    if (idCheckComfirm && nickCheckComfirm && emailCheckComfirm && pw1CheckComfirm && pw2CheckComfirm) {
        document.getElementById("submit").classList.remove('disabled');
        return true;
    } else {
        document.getElementById("submit").classList.add('disabled');
        return false;
    }
}

// 아이디 중복 확인 데이터 가져오기
function getUserInfofromId(str, cFunction) {
    var data = 'id=' + str;
    var xhr = new XMLHttpRequest();
    var url = "../php/signupcheck.php"
    xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            cFunction(this);
        }
    }
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    xhr.send(data);
}

//콜백 함수
function callbackUserInfofromId(xhttp) {
    if (xhttp.responseText.length === 4) {
        id_input.classList.remove("invalid");
        idHelper_span.innerHTML = '';
        idCheckComfirm = true;
    } else {
        id_input.classList.add("invalid");
        idHelper_span.innerHTML = '존재하는 아이디입니다.';
        idCheckComfirm = false;
    }
    comfirmcomplete();
}

//  아이디 양식 확인
function idcheck() {
    // 아이디가 입력 안된 경우 입력 요구
    if (id_input.value.length == 0) {
        id_input.classList.remove("valid");
        id_input.classList.add("invalid");
        idHelper_span.innerHTML = '아이디를 입력해 주세요.';
        idCheckComfirm = false;
        // 아이디가 4자 이하인 경우 4자 이상 요구
    } else if (id_input.value.length < 4) {
        id_input.classList.add("invalid");
        idHelper_span.innerHTML = '아이디는 4자 이상 입력해 주세요.';
        idCheckComfirm = false;
        // 아이디가 12자 초과 : 줄이기 
    } else if (id_input.value.length > 12) {
        id_input.classList.add("invalid");
        idHelper_span.innerHTML = '아이디는 12자 이하로 입력해 주세요.';
        idCheckComfirm = false;
    } else {
        // 양식에 맞지 않는다면 오류 출력
        if (!idValidate.test(id_input.value)) {
            id_input.classList.add("invalid");
            idHelper_span.innerHTML = '아이디에는 영어, 숫자, _ 만 사용할 수 있습니다.';
            idCheckComfirm = false;
        } else {
            // 중복 처리
            getUserInfofromId(id_input.value, callbackUserInfofromId);
        }
    }
}

// 닉네임 중복 확인 데이터 가져오기
function getUserInfofromEmail(str, cFunction) {
    var data = 'email=' + str;
    var xhr = new XMLHttpRequest();
    var url = "/php/signupcheck.php"
    xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            cFunction(this);
        }
    }
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    xhr.send(data);
}

//콜백 함수
function callbackUserInfofromEmail(xhttp) {
    if (xhttp.responseText.length === 4) {
        id_input.classList.remove("invalid");
        emailHelper_span.innerHTML = '';
        emailCheckComfirm = true;
    } else {
        id_input.classList.add("invalid");
        emailHelper_span.innerHTML = '존재하는 E-mail 주소입니다.';
        emailCheckComfirm = false;
    }
    comfirmcomplete();
}



// 이메일 양식 확인
function emailcheck() {
    // 이메일 양식 확인
    if (email_input.value.length == 0) {
        email_input.classList.add("invalid");
        emailHelper_span.innerHTML = '이메일 주소를 입력해 주세요.';
        emailCheckComfirm = false;
    } else {
        if (!emailValidate.test(email_input.value)) {
            email_input.classList.add("invalid");
            emailHelper_span.innerHTML = '이메일 양식을 다시 확인해 주세요.';
            emailCheckComfirm = false;
        } else {
            getUserInfofromEmail(email_input.value, callbackUserInfofromEmail);
        }
    }
}

// 닉네임 중복 확인 데이터 가져오기
function getUserInfofromNick(str, cFunction) {
    var data = 'nick=' + str;
    var xhr = new XMLHttpRequest();
    var url = "/php/signupcheck.php"
    xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            cFunction(this);
        }
    }
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    xhr.send(data);
}

//콜백 함수
function callbackUserInfofromNick(xhttp) {
    if (xhttp.responseText.length === 4) {
        nickname_input.classList.remove("invalid");
        nickHelper_span.innerHTML = '';
        nickCheckComfirm = true;
    } else {
        nickname_input.classList.add("invalid");
        nickHelper_span.innerHTML = '존재하는 닉네임입니다.';
        nickCheckComfirm = false;
    }
    comfirmcomplete();
}



// 닉네임 양식 확인
function nicknamecheck() {
    if (nickname_input.value.length == 0) {
        nickname_input.classList.add("invalid");
        nickHelper_span.innerHTML = '닉네임을 입력해 주세요.';
        nickCheckComfirm = false;
    } else if (nickname_input.value.length < 3) {
        nickname_input.classList.add("invalid");
        nickHelper_span.innerHTML = '닉네임은 3자 이상 입력해 주세요.';
        nickCheckComfirm = false;
    } else if (nickname_input.value.length > 10) {
        nickname_input.classList.add("invalid");
        nickHelper_span.innerHTML = '닉네임은 10자 이하로 입력해 주세요.';
        nickCheckComfirm = false;
    } else {
        if (!nickValidate.test(nickname_input.value)) {
            nickname_input.classList.add("invalid");
            nickHelper_span.innerHTML = '닉네임에는 한글, 영어, 숫자, _ 만 사용할 수 있습니다. \n(한글의 경우 자음 및 모음 단독 입력 불가능)';
            nickCheckComfirm = false;
        } else {
            // 중복 처리
            getUserInfofromNick(nickname_input.value, callbackUserInfofromNick);
        }
    }
}

function pw1check() {
    // 비밀번호 양식 확인
    if (pw1_input.value.length == 0) {
        pw1_input.classList.add("invalid");
        pw1Helper_span.innerHTML = '비밀번호를 입력해 주세요.';
        pw1CheckComfirm = false;
    } else if (pw1_input.value.length < 3) {
        pw1_input.classList.add("invalid");
        pw1Helper_span.innerHTML = '비밀번호를 8자 이상 입력해 주세요.';
        pw1CheckComfirm = false;
    } else if (pw1_input.value.length > 10) {
        pw1_input.classList.add("invalid");
        pw1Helper_span.innerHTML = '비밀번호를 20자 이하로 입력해 주세요.';
        pw1CheckComfirm = false;
    } else {
        if (!pwValidate.test(pw1_input.value)) {
            pw1_input.classList.add("invalid");
            pw1Helper_span.innerHTML = '비밀번호에는 영어, 숫자, 허용된 특수문자만 사용할 수 있습니다. \n(사용 가능한 특수문자 : ~ ! @ # $ % ^ & * ( ) - ? )';
            pw1CheckComfirm = false;
        } else {
            pw1_input.classList.remove("invalid");
            pw1Helper_span.innerHTML = '';
            pw1CheckComfirm = true;

        }
    }
    comfirmcomplete();
}

function pw2check() {
    //비밀번호 확인부분 처리
    if (pw2_input.value.length == 0) {
        pw2_input.classList.add("invalid");
        pw2Helper_span.innerHTML = '비밀번호를 한번 더 입력해 주세요.';
        pw2CheckComfirm = false;
    } else if (pw2_input.value != pw1_input.value) {
        pw2_input.classList.add("invalid");
        pw2Helper_span.innerHTML = '비밀번호가 일치하지 않습니다.';
        pw2CheckComfirm = false;
    } else {
        pw2_input.classList.remove("invalid");
        pw2Helper_span.innerHTML = '';
        pw2CheckComfirm = true;
    }
    comfirmcomplete();
}

function main() {
    // 실시간 확인
    // 입력중 및 focusout 시 모두 처리 필요
    // focusout 처리를 안할 경우 기본 text validation 적용되서 invalid 가 사라지게 됨
    id_input.addEventListener("keyup", idcheck);
    id_input.addEventListener("blur", idcheck);

    email_input.addEventListener("keyup", emailcheck);
    email_input.addEventListener("blur", emailcheck);

    nickname_input.addEventListener("keyup", nicknamecheck);
    nickname_input.addEventListener("blur", nicknamecheck);

    pw1_input.addEventListener("keyup", pw1check);
    pw1_input.addEventListener("blur", pw1check);

    pw2_input.addEventListener("keyup", pw2check);
    pw2_input.addEventListener("blur", pw2check);
}
main();