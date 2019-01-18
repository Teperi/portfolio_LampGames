//express 가져오기
const express = require('express');
const app = express();
// http 통신
var http = require('http').Server(app);
// socket.io 추가
var io = require('socket.io')(http);
// 포트 사용
var port = process.env.PORT || 8080;

var bodyParser = require('body-parser');

app.use(bodyParser.urlencoded({ extended: false }));
app.use(express.static(__dirname + '/../nodejs'));
// We define a route handler '/' that gets called when we hit our website home.
app.get('/', function(req, res) {
    res.sendFile(__dirname + '/test.html');
});

// 포스트로 로비를 접속할 경우
app.post('/streaming_lobby', (req, res) => {
    var user_id = req.body.user_id;
    var nickName = req.body.nickName;
    res.sendFile(__dirname + '/streaming_lobby.html');
    io.on('connection', function(socket) {
        socket.on('disconnect', function() {});
        socket.emit('session_info', { user_id: user_id, nickName: nickName });
    });
});


//어떤 포트로 받을 것인지 결정
http.listen(port, function() {
    console.log('listening on *:' + port);
});