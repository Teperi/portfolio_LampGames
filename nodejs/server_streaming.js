var express = require('express'); // Express contains some boilerplate to for routing and such
var app = express();
var http = require('http').Server(app);
var io = require('socket.io').listen(http);

const RTCMultiConnectionServer = require('rtcmulticonnection-server');
const path = require('path');
const port = process.env.PORT || 3001;


app.set('port', port);
http.listen(app.get('port'), function() {
    console.log('listening on port', app.get('port'));
});

// --------------------------
// socket.io codes goes below



var streaming = io;

var streamingRoom = {};

streaming.on('connection', function(socket) {
    // ----------------------
    // below code is optional

    RTCMultiConnectionServer.addSocket(socket);

    const params = socket.handshake.query;

    if (params.msgEvent == 'video-broadcast-demo') {
        if (!streamingRoom[params.sessionid]) {
            streamingRoom[params.sessionid] = {
                userid: params.userid,
                sessionid: params.sessionid,
                title: params.streamtitle,
                watchcount: 0
            }
        } else {
            streamingRoom[params.sessionid].watchcount++;
            // emit 의 역할은 어디로?
            streaming.emit('viewer', streamingRoom[params.sessionid]);
        }
    }

    if (!params.socketCustomEvent) {
        params.socketCustomEvent = 'custom-message';
    }

    socket.on('disconnect-with', (data) => {
        if (data in streamingRoom) {
            //방송 삭제
            delete streamingRoom[data];
        } else {
            streamingRoom[params.sessionid].watchcount--;
        }
    });

    socket.on(params.socketCustomEvent, function(message) {
        socket.broadcast.emit(params.socketCustomEvent, message);
    });

});

var lobby = io.of('lobby');

lobby.on('connection', (socket) => {
    if (Object.keys(streamingRoom).length <= 0) {
        socket.emit('nothing');
    } else {
        socket.emit('stream_room', streamingRoom);
    }
});