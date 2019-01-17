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

io.on('connection', (socket) => {
    socket.on('stream', (video) => {
        socket.broadcast.emit('stream', video);
    });
});


//We make the http server listen on port 3000.
http.listen(8080, function() {
    console.log('listening on *:8080');
});