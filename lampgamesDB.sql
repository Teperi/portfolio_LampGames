-- 데이터베이스 만들기
CREATE DATABASE lampgamesdb;

-- DB 접속
USE lampgamesdb;

-- 유저정보 TABLE 만들기
CREATE TABLE user_info (
    idx int (11) NOT NULL AUTO_INCREMENT  PRIMARY KEY ,
    id varchar(20) NOT NULL COMMENT '회원 아이디',
    nickName varchar(20) COMMENT '회원 닉네임',
    email varchar(100) NOT NULL COMMENT '회원 이메일',
    joinDate DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT '회원 가입일',
    password varchar(255) NOT NULL COMMENT '회원 비밀번호',
    admin int(1) NOT NULL DEFAULT 0 COMMENT '관리자 여부',
    UNIQUE (id, nickName, email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 로그인 테스트용 데이터 넣기
INSERT INTO user_info (id, nickName, email, password, admin)
VALUES ('admin', '관리자', 'test@test.com', '11', '1');
INSERT INTO user_info (id, nickName, email, password)
VALUES ('ssss', '테스트2', 'test2@test.com', '11');

