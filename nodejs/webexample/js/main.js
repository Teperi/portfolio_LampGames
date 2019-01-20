const localVideo = document.getElementById('localVideo');
const remoteVideo = document.getElementById('remoteVideo');

const roomName = document.getElementById('roomName');

const startButton = document.getElementById('startButton');
startButton.addEventListener('click', initRTC, false);

const callButton = document.getElementById('callButton');
callButton.addEventListener('click', startCall, false);

const hangupButton = document.getElementById('hangupButton');
hangupButton.addEventListener('click', hangupCall, false);

function initRTC() {
    const socket = io();
    const roomName = options.roomName
    navigator.mediaDevices.getUserMedia({
            video: {
                width: 640,
                height: 480,
                facingMode: 'user'
            },
            audio: true
        })
        .then(mediaStream => {
            localVideo.srcObject = mediaStream
            localVideo.volume = 0
            localStream = mediaStream
        });
    socket.on('connect', () => {
        navigator.mediaDevices.getUserMedia({
                video: {
                    width: 640,
                    height: 480,
                    facingMode: 'user'
                },
                audio: true
            })
            .then(mediaStream => {
                localVideo.srcObject = mediaStream
                localVideo.volume = 0
                localStream = mediaStream
            });

        socket.emit('join', roomName.value, (err) => {
            if (err) alert(err);
            else {
                socket.on('offer', offer => {
                    createAnswer(offer);
                });
                socket.on('candidate', (candidate) => {
                    if (peerConnection) peerConnection.addIceCandidate(candidate);
                });
                socket.on('answer', onAnswer);
            }
        });
    });

    function startCall() {
        const iceServers = [{
            'urls': 'stun:stun.l.google.com:19302'
        }];
        peerConnection = new RTCPeerConnection({ iceServers: iceServers });
        peerConnection.addEventListener('icecandidate', handleConnection);
        peerConnection.addEventListener('addstream', gotRemoteMediaStream);
        peerConnection.addStream(localStream);
        createOffer();
    }

    function hangupCall() {
        if (peerConnection) {
            peerConnection.close()
            peerConnection = null
        }
    }

    function onAnswer(answer) {
        peerConnection.setRemoteDescription(answer)
            .catch(e => console.log(e));
    };

    function createOffer() {
        peerConnection.createOffer()
            .then(offer => {
                peerConnection.setLocalDescription(offer)
                return offer
            })
            .then(offer => socket.emit('offer', { room: roomName, offer }));
    };

    function createAnswer(description) {
        peerConnection.setRemoteDescription(description)
            .then(() => peerConnection.createAnswer())
            .then((answer) => {
                peerConnection.setLocalDescription(answer)
                return answer;
            })
            .then((answer) => socket.emit('answer', { room: roomName, answer }))
            .catch(e => console.log(e));
    };

    function gotRemoteMediaStream(event) {
        const mediaStream = event.stream;
        remoteVideo.srcObject = mediaStream;
        remoteStream = mediaStream;
    };

    function handleConnection(event) {
        const iceCandidate = event.candidate;
        socket.emit('candidate', { room: roomName, candidate: iceCandidate });
    };
};