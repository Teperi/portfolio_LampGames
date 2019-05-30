//체력 바 클래스
// draw 를 통해 화면에 그릴 수 있고,
// constructor 를 통해 첫 구성을 할 수 있다.(구성과 동시에 그려줌)
// 체력 게이지는 decrease 를 통해 감소시킨다.

var nowscene;
class HealthBar {
  constructor(scene, x, y) {
    this.bar = new Phaser.GameObjects.Graphics(scene);

    this.x = x;
    this.y = y;
    this.value = 100;
    this.p = 50 / 100;

    this.draw();

    scene.add.existing(this.bar);
  }

  decrease(amount) {
    this.value -= amount;

    if (this.value < 0) {
      this.value = 0;
    }

    this.draw();

    return this.value === 0;
  }

  draw() {
    this.bar.clear();

    //  BG
    this.bar.fillStyle(0x000000);
    this.bar.fillRect(this.x, this.y, 54, 12);

    //  Health

    this.bar.fillStyle(0xffffff);
    this.bar.fillRect(this.x + 2, this.y + 2, 50, 8);

    if (this.value < 30) {
      this.bar.fillStyle(0xff0000);
    } else {
      this.bar.fillStyle(0x00ff00);
    }

    var d = Math.floor(this.p * this.value);

    this.bar.fillRect(this.x + 2, this.y + 2, d, 8);
  }
}

// 프리로딩 페이지
// 여기에는 이미지 및 게임에 필요한 다른 것들이 먼저 로딩된다.
var Preloader = new Phaser.Class({
  Extends: Phaser.Scene,

  initialize: function Preloader() {
    Phaser.Scene.call(this, { key: 'preloader' });
  },

  preload: function() {
    this.load.image('tile', 'assets/tileSand2.png');
    this.load.image('bullet', 'assets/bullet.png');
    this.load.image('tank', 'assets/tank_blue.png');
    this.load.image('otherPlayer', 'assets/tank_dark.png');
    this.load.image('button', 'assets/playbutton.png');
  },

  create: function() {
    console.log('%c Preloader ', 'background: green; color: white; display: block;');
    nowscene = 'Preloader';
    this.scene.start('startpage');
  }
});

var nickname;

// 스타트 페이지
// 여기에선 닉네임 입력 창이 나타나야 하지만, 지금은 우선 Play 버튼으로 대체한다.
var StartPage = new Phaser.Class({
  Extends: Phaser.Scene,

  initialize: function StartPage() {
    Phaser.Scene.call(this, { key: 'startpage' });
    window.MENU = this;
  },

  create: function() {
    console.log('%c StartPage ', 'background: green; color: white; display: block;');
    nowscene = 'StartPage';
    var bg = this.add.image(400, 500, 'button').setDisplaySize(200, 60);

    bg.setInteractive();

    this.add.text(100, 100, "What's your name?", { font: '48px Courier', fill: '#ffffff' });
    this.add.text(100, 160, 'Just typing', { font: '15px Courier', fill: '#ffffff' });
    if (nickname == undefined) {
      nickname = this.add.text(200, 200, 'Anonymous', { font: '48px Courier', fill: '#ffffff' });
    } else {
      nickname = this.add.text(200, 200, nickname._text, { font: '48px Courier', fill: '#ffffff' });
    }

    var self = this;

    $(document).bind('keydown', function(e) {
      if (e.keyCode == 8) {
        // backspace

        e.preventDefault();
        // do whatever the backspace should do
        if (nowscene == 'StartPage') {
          nickname.destroy();
          nickname._text = nickname._text.substr(0, nickname._text.length - 1);
          nickname = self.add.text(200, 200, nickname._text, {
            font: '48px Courier',
            fill: '#ffffff'
          });
        }
      } else if (nowscene == 'StartPage' && e.keyCode >= 48 && e.keyCode <= 105) {
        nickname.destroy();
        nickname = self.add.text(200, 200, nickname._text + e.key, {
          font: '48px Courier',
          fill: '#ffffff'
        });
      }
    });

    bg.once(
      'pointerup',
      function() {
        this.scene.start('ingame');
      },
      this
    );
  }
});

// 인게임 페이지
// 여기에는 모든 게임의 상황이 들어가 있다.

var Game = new Phaser.Class({
  Extends: Phaser.Scene,

  initialize: function Game() {
    Phaser.Scene.call(this, { key: 'ingame' });
    window.GAME = this;

    var cursors;
    var player;
    var bullets;
    var bullet_array;
    var self;
  },

  create: function() {
    nowscene = 'Game';
    console.log('%c Game ', 'background: green; color: white; display: block;');
    bullet_array = [];
    this.add.tileSprite(0, 0, config.width, config.height, 'tile').setOrigin(0, 0);

    // 화살표와 wasd 모두 사용할 수 있도록 설정
    cursors = this.input.keyboard.addKeys({
      up1: Phaser.Input.Keyboard.KeyCodes.UP,
      up2: Phaser.Input.Keyboard.KeyCodes.W,
      down1: Phaser.Input.Keyboard.KeyCodes.DOWN,
      down2: Phaser.Input.Keyboard.KeyCodes.S,
      left1: Phaser.Input.Keyboard.KeyCodes.LEFT,
      left2: Phaser.Input.Keyboard.KeyCodes.A,
      right1: Phaser.Input.Keyboard.KeyCodes.RIGHT,
      right2: Phaser.Input.Keyboard.KeyCodes.D,
      space: Phaser.Input.Keyboard.KeyCodes.SPACE,
      shift: Phaser.Input.Keyboard.KeyCodes.SHIFT
    });

    // 플레이어 생성(맵 가운데)
    player = this.physics.add
      .sprite(Math.random() * config.width, Math.random() * config.height, 'tank')
      .setDisplaySize(42, 46);
    player.setCollideWorldBounds(true);
    player.hp = new HealthBar(this, player.x - 27, player.y - 40);
    player.nickname = this.add.text(player.x - 27, player.y - 60, nickname._text, {
      fill: '#000000'
    });

    // 소켓을 설정함
    this.socket = io('http://54.180.115.109:8080/');

    // 내가 접속해서 만들어지는 정보 보내기
    this.socket.emit('new-player', {
      x: player.x,
      y: player.y,
      hpbar_x: player.hp.x,
      hpbar_y: player.hp.y,
      hpbar_hp: player.hp.value,
      rotation: player.rotation,
      nickname: player.nickname._text
    });

    // 현재 상태에 다른 플레이어를 담을 수 있는 그룹 만들기
    this.otherPlayers = this.physics.add.group();
    // this 상태 self 변수에 저장
    self = this;

    // 내가 접속할 때 만들어져있는 모든 플레이어의 정보 가져옴
    this.socket.on('currentPlayers', function(players) {
      Object.keys(players).forEach(function(id) {
        if (players[id].playerId === self.socket.id) {
        } else {
          // 나를 제외한 다른 사람들을 저장하는 함수 사용
          addOtherPlayers(self, players[id]);
        }
      });
    });

    // 새로운 클라이언트 접속이 생겼을 때 또 다시 추가
    this.socket.on('create-newplayer', function(playerInfo) {
      addOtherPlayers(self, playerInfo);
    });

    // 접속이 끊어진 클라이언트는 지우기
    this.socket.on('disconnect', function(playerId) {
      self.otherPlayers.getChildren().forEach(function(otherPlayer) {
        if (playerId === otherPlayer.playerId) {
          otherPlayer.hp.bar.clear();
          otherPlayer.nickname.destroy();
          otherPlayer.destroy();
        }
      });
    });

    this.socket.on('playerMoved', function(playerInfo) {
      self.otherPlayers.getChildren().forEach(function(otherPlayer) {
        if (playerInfo.playerId === otherPlayer.playerId) {
          otherPlayer.setRotation(playerInfo.rotation);
          otherPlayer.setPosition(playerInfo.x, playerInfo.y);
          otherPlayer.hp.value = playerInfo.hpbar_hp;
          otherPlayer.hp.x = playerInfo.hpbar_x;
          otherPlayer.hp.y = playerInfo.hpbar_y;
          otherPlayer.hp.draw();
          otherPlayer.nickname.destroy();
          otherPlayer.nickname = self.add.text(
            playerInfo.x - 27,
            playerInfo.y - 60,
            playerInfo.nickname,
            { fill: '#000000' }
          );
        }
      });
    });

    // Listen for any player hit events and make that player flash
    this.socket.on('playerHit', function(id) {
      if (id == self.socket.id) {
        //If this is you
        player.alpha = 0;
        player.hp.decrease(5);
      } else {
        // Find the right player
        self.otherPlayers.getChildren()[
          findOtherPlayerIndex(self.otherPlayers.getChildren(), id)
        ].alpha = 0;
        self.otherPlayers
          .getChildren()
          [findOtherPlayerIndex(self.otherPlayers.getChildren(), id)].hp.decrease(5);
      }
    });

    // 맵 모든 영역을 클릭하면 반응하도록 해주는 함수
    this.input.on('pointerdown', function() {
      // 서버와 통신할 경우에 위치 등의 정보는 서버에서 계산해야 한다.
      // 클라이언트에서 계산할 경우 해킹으로 인해 오류가 날 수 있다.

      // 위치 확인
      var bullet_x = Math.cos(player.rotation + Math.PI / 2);
      var bullet_y = Math.sin(player.rotation + Math.PI / 2);

      // 소켓으로 정보 보내기
      self.socket.emit('shootBullet', {
        x: player.x + bullet_x * 30,
        y: player.y + bullet_y * 30,
        speed_x: bullet_x * 5,
        speed_y: bullet_y * 5
      });

      // // 과거 1인용 게임 전용으로 만들 경우
      // // 총알 첫 위치 계산 함수
      // var start_x = Math.cos(player.rotation + Math.PI / 2) * 30;
      // var start_y = Math.sin(player.rotation + Math.PI / 2) * 30;

      // // 방향 및 속도 계산 함수
      // var speed_x = Math.cos(player.rotation + Math.PI / 2) * 300;
      // var speed_y = Math.sin(player.rotation + Math.PI / 2) * 300;
      // // bullet 만들어서 발사함
      // let bullet = bullets.create(player.x + start_x, player.y + start_y, 'bullet');
      // bullet.setCollideWorldBounds(false);
      // bullet.setVelocity(speed_x, speed_y);
    });

    this.socket.on('bulletsUpdate', function(server_bullet_array) {
      for (let i = 0; i < server_bullet_array.length; i++) {
        if (bullet_array[i] == undefined) {
          bullet_array[i] = self.physics.add.sprite(
            server_bullet_array[i].x,
            server_bullet_array[i].y,
            'bullet'
          );
        } else {
          bullet_array[i].x = server_bullet_array[i].x;
          bullet_array[i].y = server_bullet_array[i].y;
        }
      }
      // Otherwise if there's too many, delete the extra
      for (var i = server_bullet_array.length; i < bullet_array.length; i++) {
        bullet_array[i].destroy();
        bullet_array.splice(i, 1);
        i--;
      }
    });

    // 다른 사람들 정보 저장하는 함수
    function addOtherPlayers(self, playerInfo) {
      // 다른 사람들의 x/y 좌표를 가져와서 다른 색깔로 만들기
      var otherPlayer = self.add
        .sprite(playerInfo.x, playerInfo.y, 'otherPlayer')
        .setDisplaySize(42, 46)
        .setSize(42, 46);
      // id 는 소켓 id 저장
      otherPlayer.playerId = playerInfo.playerId;
      otherPlayer.hp = new HealthBar(self, playerInfo.hpbar_x, playerInfo.hpbar_y);
      otherPlayer.hp.value = playerInfo.hpbar_hp;
      otherPlayer.nickname = self.add.text(
        playerInfo.x - 27,
        playerInfo.y - 60,
        playerInfo.nickname,
        { fill: '#000000' }
      );
      // 추가하기
      self.otherPlayers.add(otherPlayer);
    }

    function findOtherPlayerIndex(array, id) {
      for (let i = 0; i < array.length; i++) {
        if (array[i]['playerId'] == id) {
          return i;
        }
      }
      return -1;
    }
  },

  update: function(time, delta) {
    // To make player flash when they are hit, set player.spite.alpha = 0
    if (player.alpha < 1) {
      player.alpha += (1 - player.alpha) * 0.16;
    } else {
      player.alpha = 1;
    }

    // To make player flash when they are hit, set player.spite.alpha = 0
    for (let i = 0; i < self.otherPlayers.getChildren().length; i++) {
      if (self.otherPlayers.getChildren()[i].alpha < 1) {
        self.otherPlayers.getChildren()[i].alpha +=
          (1 - self.otherPlayers.getChildren()[i].alpha) * 0.16;
      } else {
        self.otherPlayers.getChildren()[i].alpha = 1;
      }
    }
    // 좌우 컨트롤
    // player 의 경우 setVelocity로 이동
    // hp bar 의 경우 player의 좌표를 기준으로 좌표를 변경하고 다시 그려줌
    if (cursors.right1.isDown || cursors.right2.isDown) {
      player.setVelocityX(150);
      player.hp.x = player.x - 27;
      player.hp.draw();
      player.nickname.destroy();
      player.nickname = this.add.text(player.x - 27, player.y - 60, nickname._text, {
        fill: '#000000'
      });
    } else if (cursors.left1.isDown || cursors.left2.isDown) {
      player.setVelocityX(-150);
      player.hp.x = player.x - 27;
      player.hp.draw();
      player.nickname.destroy();
      player.nickname = this.add.text(player.x - 27, player.y - 60, nickname._text, {
        fill: '#000000'
      });
    } else {
      player.setVelocityX(0);
    }

    // 상하 컨트롤

    if (cursors.down1.isDown || cursors.down2.isDown) {
      player.setVelocityY(150);
      player.hp.y = player.y - 40;
      player.hp.draw();
      player.nickname.destroy();
      player.nickname = this.add.text(player.x - 27, player.y - 60, nickname._text, {
        fill: '#000000'
      });
    } else if (cursors.up1.isDown || cursors.up2.isDown) {
      player.setVelocityY(-150);
      player.hp.y = player.y - 40;
      player.hp.draw();
      player.nickname.destroy();
      player.nickname = this.add.text(player.x - 27, player.y - 60, nickname._text, {
        fill: '#000000'
      });
    } else {
      player.setVelocityY(0);
    }

    // 플레이어의 방향을 마우스 커서 위치로 항상 돌아가도록 설정
    player.rotation =
      Phaser.Math.Angle.Between(
        player.x,
        player.y,
        this.input.mousePointer.x,
        this.input.mousePointer.y
      ) - 1.6;

    // emit player movement
    var x = player.x;
    var y = player.y;
    var r = player.rotation;
    if (
      player.oldPosition &&
      (x !== player.oldPosition.x ||
        y !== player.oldPosition.y ||
        r !== player.oldPosition.rotation)
    ) {
      this.socket.emit('playerMovement', {
        x: x,
        y: y,
        hpbar_x: player.hp.x,
        hpbar_y: player.hp.y,
        hpbar_hp: player.hp.value,
        rotation: r,
        nickname: player.nickname._text
      });
    }

    // save old position data
    player.oldPosition = {
      x: player.x,
      y: player.y,
      rotation: player.rotation
    };

    if (player.hp.value == 0) {
      // 내가 접속해서 만들어지는 정보 보내기
      this.socket.disconnect();
      this.scene.start('gameover');
    }
  }
});

//게임 오버 페이지
// 게임으로 다시 들어갈 수 있도록 해줌

var GameOver = new Phaser.Class({
  Extends: Phaser.Scene,

  initialize: function GameOver() {
    Phaser.Scene.call(this, { key: 'gameover' });
    window.OVER = this;
  },

  create: function() {
    nowscene = 'GameOver';
    console.log('%c GameOver ', 'background: green; color: white; display: block;');

    this.add.text(100, 100, 'Game Over', { font: '100px Courier', fill: '#ffffff' });

    this.add.text(400, 450, '- Click to start restart -', {
      font: '16px D2Coding',
      fill: '#00ff00'
    });

    this.input.once(
      'pointerup',
      function(event) {
        this.scene.start('startpage');
      },
      this
    );
  }
});

var config = {
  type: Phaser.AUTO,
  width: 800,
  height: 600,
  parent: document.getElementById('game-view'),
  physics: {
    default: 'arcade',
    arcade: {
      gravity: { y: 0 },
      debug: false
    }
  },
  scene: [Preloader, StartPage, Game, GameOver]
};

var game = new Phaser.Game(config);
