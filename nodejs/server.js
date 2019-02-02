var express = require('express'); // Express contains some boilerplate to for routing and such
var app = express();
var http = require('http').Server(app);
var io = require('socket.io').listen(http);

const RTCMultiConnectionServer = require('rtcmulticonnection-server');
const path = require('path');
const port = process.env.PORT || 3000;


app.set('port', port);
http.listen(app.get('port'), function() {
    console.log('listening on port', app.get('port'));
});

// 최상위 경로 설정
app.use('/', express.static(__dirname));

io.of('/chatting').on('connection', function(socket) {
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
        io.of('/chatting').emit('chat message', msg);
    });
});