function clickdelete(idx, title) {
    if (confirm('"' + title + '"' + '\n글을 삭제하시겠습니까?')) {
        sendDelete(idx, callbackDelete);
    } else {
        console.log('삭제 취소');
    }
}

function sendDelete(number, callback) {
    var data = 'idx=' + number;
    var xhr = new XMLHttpRequest();
    var url = "/php/DBcommand/deleteNews.php";
    xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            callback(this);
        }
    }
    xhr.open('POST', url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    xhr.send(data);
}

function callbackDelete(xhttp) {
    location.reload();
}