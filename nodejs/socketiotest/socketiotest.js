// 터미널에서 해준 일
// npm install --save -g express
// npm link express
// 전역 설치 한 후에는 windows 에서 링크 해줘야 함
// 리눅스에서는 설치 폴더를 링크 해줘야 함. 이건 추후 리눅스 설정 이후 적어둘 예정

//step2 socket.io 설치 및 추가(위에 터미널에서 해준 일에서 express 를 socket.io 로 바꿔 실행)

//express 가져오기
var app = require('express')();
// http 통신
var http = require('http').Server(app);
// socket.io 추가
var io = require('socket.io')(http);

// We define a route handler '/' that gets called when we hit our website home.
app.get('/', function(req, res) {
    // res.send('<h1>Hello world</h1>'); 헬로우 월드 띄우기
    res.sendFile(__dirname + '/socketiotest.html');
});

io.on('connection', function(socket) {
    console.log('a user connected');
    socket.on('disconnect', function() {
        console.log('user disconnect');
    });
    // 채팅 메시지 받을 경우 콘솔에 출력
    // socket.on('chat message', function(msg) {
    //     console.log('message: ' + msg);
    // });

    socket.broadcast.emit('Server : 접속 완료');

    // 채팅 메시지를 받았을 경우 다시 뿌려줌
    socket.on('chat message', function(msg) {
        io.emit('chat message', msg);
    });
});

//We make the http server listen on port 3000.
http.listen(3000, function() {
    console.log('listening on *:3000');
});



// 이후 좀 더 깊은 공부를 하고싶은 경우
// https://socket.io/demos/chat/ 여기서 확인하면 됩니다.
// 이 소스는 https://github.com/socketio/socket.io/tree/master/examples/chat 여기서 볼 수 있음
// 처음 시작시 주었던 숙제를 모두 해결한 버젼이기 때문에 나중에 필요한 곳을 찾아보면 될듯.

// 숙제 목록
// Broadcast a message to connected users when someone connects or disconnects.
// Add support for nicknames.
// Don’t send the same message to the user that sent it himself. Instead, append the message directly as soon as he presses enter.
// Add “{user} is typing” functionality.
// Show who’s online.
// Add private messaging.
// Share your improvements!