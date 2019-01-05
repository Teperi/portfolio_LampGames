function getLink() {

}

// 아이디 중복 확인 데이터 가져오기
function getUserInfofromId(str, cFunction) {
    var xhr = new XMLHttpRequest();
    var url = "/php/curltest.php"
    xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            cFunction(this);
        }
    }
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    xhr.send(data);
}