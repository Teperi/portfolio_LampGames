// 터미널에서 해준 일
// npm install --save -g express
// npm link express
// 전역 설치 한 후에는 windows 에서 링크 해줘야 함
// 리눅스에서는 설치 폴더를 링크 해줘야 함. 이건 추후 리눅스 설정 이후 적어둘 예정


//express 가져오기
var app = require('express')();
// http 통신
var http = require('http').Server(app);

// We define a route handler '/' that gets called when we hit our website home.
app.get('/', function(req, res) {
    // res.send('<h1>Hello world</h1>'); 헬로우 월드 띄우기
    res.sendFile(__dirname + '/socketiotest.html');
});

//We make the http server listen on port 3000.
http.listen(3000, function() {
    console.log('listening on *:3000');
});