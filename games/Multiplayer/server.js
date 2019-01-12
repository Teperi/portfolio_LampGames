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

// Listen on port 5000
app.set('port', (process.env.PORT || 5000));
http.listen(app.get('port'), function() {
    console.log('listening on port', app.get('port'));
});

io.on('connection', function(socket) {
    console.log("New client has connected with id:", socket.id);
    // key 를 socket id 를 사용하여 진행
    players[socket.id]

    socket.on('new-player', function(state_data) { // Listen for new-player event on this client 
        console.log("New player has state:", state_data);
        socket.broadcast.emit('create-player', state_data);

    });
});