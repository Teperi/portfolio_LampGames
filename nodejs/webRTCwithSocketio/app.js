var express = require('express'); // Express contains some boilerplate to for routing and such
var app = express();
// http 통신
var http = require('http').Server(app);
// socket.io 추가
var io = require('socket.io')(http);

app.use(express.static('public'));
// We define a route handler '/' that gets called when we hit our website home.
app.get('/', function(req, res) {
    res.sendFile(__dirname + 'index.html');
});

//We make the http server listen on port 3000.
http.listen(8080, function() {
    console.log('listening on *:8080');
});


let broadcaster;
io.on('connection', (socket) => {
    console.log("new user in : " + socket.id);

    socket.on('start', (sdp) => {
        console.log("new broadcast start");
        broadcaster = sdp;
    });

    socket.on('join', () => {
        console.log("new join");
        socket.emit('broadcaster', broadcaster);
    });

    socket.on('remote', (sdp) => {
        console.log('시청자 sdp 전송');
        socket.emit('new_remote', sdp);
    })
});