//express 가져오기
const express = require('express');
const app = express();
// http 통신
var http = require('http').Server(app);
// socket.io 추가
var io = require('socket.io')(http);
// 포트 사용
var port = process.env.PORT || 8080;

app.get('/', function(req, res) {
    res.sendFile(__dirname + '/index.html');
});

//어떤 포트로 받을 것인지 결정
http.listen(port, function() {
    console.log('listening on *:' + port);
});

io.sockets.on('connection', function(socket) {
    console.log('New User connect');
    socket.on('join', (room) => {
        const clients = io.sockets.adapter.rooms[room]
        console.log(clients);
        const numClients = (typeof clients !== 'undefined') ? clients.length : 0
        if (numClients > 1) {
            // TODO: 여기에 접속할 수 없다는 콜백함수 제작 필요함
            console.log('already_full');
        } else if (numClients === 1) {
            socket.join(room)
            io.in(room).emit('ready')
        } else {
            socket.join(room)
        }
    })

    socket.on('offer', (data) => {
        const { room, offer } = data
        console.log(offer);
        socket.to(room).emit('offer', offer)
    })

    socket.on('answer', (data) => {
        const { room, candidate } = data
        socket.to(room).emit('answer', candidate)
    })

    socket.on('candidate', (data) => {
        const { room, candidate } = data
        socket.to(room).emit('candidate', candidate)
    })
})