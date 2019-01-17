var express = require('express'); // Express contains some boilerplate to for routing and such
var app = express();
var http = require('http').Server(app);
var io = require('socket.io').listen(http);

// 접속중인 플레이어를 담는 배열
var players = {};

// 총알 
var bullet_array = [];

// Serve the index page 
app.use(express.static('shooter'));
app.get("/", function(request, response) {
    response.sendFile(__dirname + '/shooter/shooter.html');
});

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
            hpbar_x: state_data.hpbar_x,
            hpbar_y: state_data.hpbar_y,
            hpbar_hp: state_data.value,
            playerId: socket.id,
            nickname: state_data.nickname
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
        players[socket.id].hpbar_x = movementData.hpbar_x;
        players[socket.id].hpbar_y = movementData.hpbar_y;
        players[socket.id].hpbar_hp = movementData.hpbar_hp;
        players[socket.id].rotation = movementData.rotation;
        players[socket.id].nickname = movementData.nickname;
        // emit a message to all players about the player that moved
        socket.broadcast.emit('playerMoved', players[socket.id]);
    });

    socket.on('shootBullet', function(data) {
        if (players[socket.id] == undefined) return;
        data.owner_id = socket.id; // Attach id of the player to the bullet 
        var new_bullet = data;
        bullet_array.push(new_bullet);
    });
});

// Listen on port 3000
app.set('port', (process.env.PORT || 3000));
http.listen(app.get('port'), function() {
    console.log('listening on port', app.get('port'));
});

// Update the bullets 60 times per frame and send updates 
function ServerGameLoop() {
    for (var i = 0; i < bullet_array.length; i++) {
        var bullet = bullet_array[i];
        bullet.x += bullet.speed_x;
        bullet.y += bullet.speed_y;

        // Check if this bullet is close enough to hit any player 
        for (var id in players) {
            if (bullet.owner_id != id) {
                // And your own bullet shouldn't kill you
                var dx = players[id].x - bullet.x;
                var dy = players[id].y - bullet.y;
                var dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < 40) {
                    io.emit('playerHit', id); // Tell everyone this player got hit
                }
            }
        }

        // Remove if it goes too far off screen 
        if (bullet.x < -10 || bullet.x > 1000 || bullet.y < -10 || bullet.y > 1000) {
            bullet_array.splice(i, 1);
            i--;
        }

    }
    // Tell everyone where all the bullets are by sending the whole array
    io.emit("bulletsUpdate", bullet_array);
}

setInterval(ServerGameLoop, 16);