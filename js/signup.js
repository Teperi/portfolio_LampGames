const test = document.getElementById("test");

function validate() {
    // id, 비밀번호, 닉네임이 맞는지 확인하는 

    // id 의 경우 영문 대,소문자 or 숫자 or _ 로 시작하는 4~12 가지 글자 (_외 특수문자 금지)
    var idValidate = /^(\w){4,12}$/;
    // email 의 경우 양식에 맞는 글자만 사용되어야함 ex) aaa@aa.aa

    var emailValidate = /^(\w|[-.])+[@](\w|[-.])+[.]\w{2,5}$/;

    // 비밀번호의 경우 영문 대,소문자 or 숫자 or _ 로 시작하는 8~20 가지 글자 (첫 글자 외 특수문자 가능)
    var pwValidate = /^(\w)([~!@#$%^&*()-?]|\w){7,19}$/;
    // 닉네임의 경우 영문 대,소문자 or 숫자 or _ or 한글 로 시작하는 3~10 가지 글자 (_외 특수문자 금지)
    var nickValidate = /^([가-힣]|\w){3,10}$/;

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

    // 모든 양식이 맞았는지 확인하는 변수 생성
    var confirmCount = 0;
    // 양식이 틀렸을 경우에는
    // 1. 아래 밑줄을 빨간색으로 변경 (invalid class 추가로 변경 가능)
    // 2. helper-text 로 안내 띄우기
    // 맞았을 경우 모두 되돌리기

    //  아이디 양식 확인
    if (id_input.value.length == 0) {
        pw1_input.classList.remove("valid");
        id_input.classList.add("invalid");
        idHelper_span.innerHTML = '아이디를 입력해 주세요.';
    } else if (id_input.value.length < 4) {
        id_input.classList.add("invalid");
        idHelper_span.innerHTML = '아이디는 4자 이상 입력해 주세요.';
    } else if (id_input.value.length > 12) {
        id_input.classList.add("invalid");
        idHelper_span.innerHTML = '아이디는 12자 이하로 입력해 주세요.';
    } else {
        if (!idValidate.test(id_input.value)) {
            id_input.classList.add("invalid");
            idHelper_span.innerHTML = '아이디에는 영어, 숫자, _ 만 사용할 수 있습니다.';
        } else {
            id_input.classList.remove("invalid");
            idHelper_span.innerHTML = '';
            confirmCount++;
        }
    }
    // 이메일 양식 확인
    if (email_input.value.length == 0) {
        email_input.classList.add("invalid");
        emailHelper_span.innerHTML = '이메일 주소를 입력해 주세요.';
    } else {
        if (!emailValidate.test(email_input.value)) {
            email_input.classList.add("invalid");
            emailHelper_span.innerHTML = '이메일 양식을 다시 확인해 주세요.';
        } else {
            email_input.classList.remove("invalid");
            emailHelper_span.innerHTML = '';
            confirmCount++;
        }
    }

    // 닉네임 양식 확인
    if (nickname_input.value.length == 0) {
        nickname_input.classList.add("invalid");
        nickHelper_span.innerHTML = '닉네임을 입력해 주세요.';
    } else if (nickname_input.value.length < 3) {
        nickname_input.classList.add("invalid");
        nickHelper_span.innerHTML = '닉네임은 3자 이상 입력해 주세요.';
    } else if (nickname_input.value.length > 10) {
        nickname_input.classList.add("invalid");
        nickHelper_span.innerHTML = '닉네임은 10자 이하로 입력해 주세요.';
    } else {
        if (!nickValidate.test(nickname_input.value)) {
            nickname_input.classList.add("invalid");
            nickHelper_span.innerHTML = '닉네임에는 한글, 영어, 숫자, _ 만 사용할 수 있습니다.\n(한글의 경우 자음 및 모음 단독 입력 불가능)';
        } else {
            nickname_input.classList.remove("invalid");
            nickHelper_span.innerHTML = '';
            confirmCount++;
        }
    }
    // 비밀번호 양식 확인
    if (pw1_input.value.length == 0) {
        pw1_input.classList.add("invalid");
        pw1Helper_span.innerHTML = '비밀번호를 입력해 주세요.';
    } else if (pw1_input.value.length < 3) {
        pw1_input.classList.add("invalid");
        pw1Helper_span.innerHTML = '비밀번호를 8자 이상 입력해 주세요.';
    } else if (pw1_input.value.length > 10) {
        pw1_input.classList.add("invalid");
        pw1Helper_span.innerHTML = '비밀번호를 20자 이하로 입력해 주세요.';
    } else {
        if (!pwValidate.test(pw1_input.value)) {
            pw1_input.classList.add("invalid");
            pw1Helper_span.innerHTML = '비밀번호에는 영어, 숫자, 허용된 특수문자만 사용할 수 있습니다.\n(가능한 특수문자 : ~ ! @ # $ % ^ & * ( ) - ? )';
        } else {
            pw1_input.classList.remove("invalid");
            pw1Helper_span.innerHTML = '';
            confirmCount++;
        }
    }
    //비밀번호 확인부분 처리
    if (pw2_input.value.length == 0) {
        pw2_input.classList.add("invalid");
        pw2Helper_span.innerHTML = '비밀번호를 한번 더 입력해 주세요.';
    } else if (pw2_input.value != pw1_input.value) {
        pw2_input.classList.add("invalid");
        pw2Helper_span.innerHTML = '비밀번호가 일치하지 않습니다.';
    } else {
        pw2_input.classList.remove("invalid");
        pw2Helper_span.innerHTML = '';
        confirmCount++;
    }
    console.log(confirmCount);
    if (confirmCount == 5) {
        document.getElementById("submit").classList.remove('disabled');
    } else {
        document.getElementById("submit").classList.add('disabled');
    }

}
// 회원가입 버튼 활성화
// document.getElementById("submit").classList.remove('disabled');


function main() {
    test.addEventListener('click', () => validate());
}
main();