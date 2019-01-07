var add = (function() {
    var counter = 0;
    return function() {
        return counter += 1;
    }
})();

function moreclick() {
    var countNum = add();
    document.getElementById('more').classList.add('disabled');
    sendcountnum(countNum, resultout);
}

function sendcountnum(number, callback) {
    var data = 'morecount=' + number;
    var xhr = new XMLHttpRequest();
    var url = "/php/DBtoView/newsList.php";
    xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            callback(this);
        }
    }
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    xhr.send(data);
}

function resultout(xhttp) {
    if (xhttp.responseText.length != 4) {
        document.getElementById('newsList').innerHTML += xhttp.responseText;
        document.getElementById('more').classList.remove('disabled');
        // TODO: 마지막 리스트 출력 이후 더보기 disabled 기능 출력
    }
}