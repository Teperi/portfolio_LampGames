# 순서 mysql -> apache -> php

# 필요한 설치
yum install -y expat-devel
# 설치 후 재시작 필요. 나의 경우 적용이 되지 않았었는데 재시작하니 적용됨

# 다운로드 받을 폴더로 이동
cd /usr/local/src/

# 의존 파일 및 아파치 다운로드
wget http://mirror.apache-kr.org//apr/apr-1.6.5.tar.gz
wget http://mirror.apache-kr.org//apr/apr-util-1.6.1.tar.gz
wget https://sourceforge.net/projects/pcre/files/pcre/8.42/pcre-8.42.tar.gz
wget http://apache.mirror.cdnetworks.com//httpd/httpd-2.4.37.tar.gz


# 압축 해제
# apr, apr-util 폴더 위치 및 이름 변경
# apache 공식문서에 저장 위치가 지정되어 있음
tar -zxvf httpd-2.4.37.tar.gz
tar -zxvf pcre-8.42.tar.gz
tar -zxvf apr-1.6.5.tar.gz
mv apr-1.6.5 httpd-2.4.37/srclib/apr
tar -zxvf apr-util-1.6.1.tar.gz
mv apr-util-1.6.1 httpd-2.4.37/srclib/apr-util

# pcre 설치
cd pcre-8.42
./configure --prefix=/usr/local
make
make install

# 아파치 설치를 위해 폴더 이동
cd /usr/local/src/httpd-2.4.37

# 설치
# --prefix=/usr/local/apache2 : 설치 경로
# --with-pcre=/usr/local/bin/pcre-config : pcre 경로
./configure --prefix=/usr/local/apache2 \
--enable-module=so \
--with-pcre=/usr/local/bin/pcre-config
make
make install

# 설정 변경 (AH00058 error 수정)
cd /usr/local/apache2
nano conf/httpd.conf
# servername 찾으면 
# #ServerName www.example.com:80 이라고 적힌 부분이 있음
# ServerName 127.0.0.1:80 으로 수정

# 실행 확인
/usr/local/apache2/bin/apachectl start
# 프로세스 확인
ps -ef | grep httpd

curl http://127.0.0.1
# <html><body><h1>It works!</h1></body></html>
# 위 처럼 뜨면 성공임

