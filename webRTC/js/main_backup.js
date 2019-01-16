'use strict';

// 미디어 스트림의 제약: 비디오와 오디오 허용
// https://webrtc.github.io/samples/src/content/peerconnection/constraints/
// 위 사이트에서 설정에 대한 내용을 좀 더 볼 수 있음
// ex) min max 는 어떻게 주는가..
const mediaStreamConstraints = {
    audio: true,
    video: {
        width: {
            min: 1280
        },
        height: {
            min: 720
        }
    },
};

// 비디오가 위치할 자리 찾기
const localVideo = document.querySelector('video');

// Local stream that will be reproduced on the video.
let localStream;

// Handles success by adding the MediaStream to the video element.
// scrObject: 
function gotLocalMediaStream(mediaStream) {
    localStream = mediaStream;
    // 비디오가 위치할 자리의 object 를 미디어스트림으로 저장
    localVideo.srcObject = mediaStream;
}

// Handles error by logging a message to the console with the error message.
function handleLocalMediaStreamError(error) {
    console.log('navigator.getUserMedia error: ', error);
}

// Initializes media stream.
// getUserMedia: 브라우저에서 카메라 접속 설정 권한 보내기
// 허용되었을 경우 MediaStream 리턴
navigator.mediaDevices.getUserMedia(mediaStreamConstraints)
    .then(gotLocalMediaStream).catch(handleLocalMediaStreamError);