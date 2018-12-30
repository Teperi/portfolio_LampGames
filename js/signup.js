const test = document.getElementById("test");

function validate() {
    // id, 비밀번호, 닉네임이 맞는지 확인하는 

    // id 의 경우 영문 대,소문자 or 숫자 or _ 로 시작하는 4~12 가지 글자 (_외 특수문자 금지)
    var idValidate = /^(\w){4,12}$/;
    // 비밀번호의 경우 영문 대,소문자 or 숫자 or _ 로 시작하는 8~20 가지 글자 (첫 글자 외 특수문자 가능)
    var pwValidate = /^(\w)([~!@#$%^&*()-?]|\w){8,20}$/;
    // 닉네임의 경우 영문 대,소문자 or 숫자 or _ or 한글 로 시작하는 2~15 가지 글자 (_외 특수문자 금지)
    var nickValidate = /^([가-힣]|\w)([가-힣]|\w){3,10}$/;

    // 각각의 정보를 html 에서 가져옴
    var id = document.getElementById("id");
    var email = document.getElementById("email");
    var nickname = document.getElementById("nickName");
    var pw1 = document.getElementById("passwordFirst");
    var pw2 = document.getElementById("passwordConfirm");;
    if (!idValidate.test(id.value)) {
        id.classList.add("invalid");
        document.getElementById("iderror").innerHTML = '안됨';
    } else {
        id.classList.remove("invalid");
        document.getElementById("iderror").innerHTML = '';


    }
    // 회원가입 버튼 활성화
    // document.getElementById("submit").classList.remove('disabled');
}

function main() {
    test.addEventListener('click', () => validate());
}
main();