# Lamp Games

- [포트폴리오 접속 링크](http://54.180.115.109/)

## 개요

- 개발기간: 2018.12.19 ~ 2018.02.02 / 2019.05.28~2019.05.30(AWS 서버로 이전 및 버그 수정)
- 개발목적: Game 관련 웹 사이트 제작
- 주요기능
  - 실제 게임 플레이: HTML5 기반 게임(PC 전용)
  - 게임뉴스기사: 게임 관련된 뉴스기사 크롤링

## 사용 도구

- OS
  - AMI
- Back-end
  - [Apache/2.4.37](linuxscript_files/install_apache.sh)
  - [Mysql/5.7.24](linuxscript_files/install_mysql.sh)
  - [PHP/7.3.0](linuxscript_files/install_php.sh)
    - CURL, PHP Simple HTML DOM Parser: 크롤링 도구
  - Nodejs/10.15
    - Express
    - Socket.io
- Front-end
  - JavaScript & Jquery
  - [Materializecss](https://materializecss.com)
- Game Framework
  - [Phaser3](https://phaser.io/)