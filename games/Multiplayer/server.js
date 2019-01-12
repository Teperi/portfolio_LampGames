var express = require('express'); // Express contains some boilerplate to for routing and such
var app = express();
var http = require('http').Server(app);
var io = require('socket.io').listen(http);

// 접속중인 플레이어를 담는 배열
var players = {};

// Serve the index page 
app.use(express.static('shooter'));
// app.get("/", function(request, response) {
//     response.sendFile(__dirname + '/pirateshooter.html');
// });

io.on('connection', function(socket) {
    console.log("New client has connected with id:", socket.id);
    socket.on('new-player', function(state_data) { // Listen for new-player event on this client 
        console.log("New player has state:", state_data);
        // key 를 socket id 를 사용하여 진행
        players[socket.id] = {
            // 넘겨준 정보 저장
            x: state_data.x,
            y: state_data.y,
            rotation: state_data.rotation,
            playerId: socket.id
        };
        // 현재 플레이어를 currentPlayers 에 저장
        socket.emit('currentPlayers', players);
        // 모든 클라이언트에게 새 플레이어가 등장했다고 보내기
        socket.broadcast.emit('create-newplayer', players[socket.id]);
    });

    // 접속이 끊어진 경우
    socket.on('disconnect', function() {
        // players 에 저장된 데이터 지우기aw
        delete players[socket.id];
        // 다른 클라이언트에 플레이어가 나갔다고 알림
        io.emit('disconnect', socket.id);
    });


    // when a player moves, update the player data
    socket.on('playerMovement', function(movementData) {
        players[socket.id].x = movementData.x;
        players[socket.id].y = movementData.y;
        players[socket.id].rotation = movementData.rotation;
        // emit a message to all players about the player that moved
        socket.broadcast.emit('playerMoved', players[socket.id]);
    });



});

// Listen on port 5000
app.set('port', (process.env.PORT || 5000));
http.listen(app.get('port'), function() {
    console.log('listening on port', app.get('port'));
});