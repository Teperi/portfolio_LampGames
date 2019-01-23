
# 의존성 설치
yum -y install libxml2-devel openssl-devel libjpeg-devel libpng-devel

# 다운로드 받을 폴더로 이동
cd /usr/local/src

# 다운로드 
wget http://jp2.php.net/get/php-7.3.0.tar.gz/from/this/mirror
tar -zxvf mirror

cd php-7.3.0


# --prefix=/usr/local/php \ : php 경로 지정 // 경로 지정이 안되있을 경우 /usr/local 에 설치됨
# --with-apxs2=/usr/local/apache2/bin/apxs : apache2 설치 경로
# --with-mysqli=/usr/local/mysql/bin/mysql_config : mysql config 설치 경로
# --disable-debug \
# --with-iconv \
# --with-gd \
# --with-jpeg-dir \
# --with-png-dir \
# --with-libxml-dir \
# --with-openssl

# 설정
 ./configure \
--with-apxs2=/usr/local/apache2/bin/apxs \
--with-mysqli \
--disable-debug \
--with-iconv \
--with-gd \
--with-curl \
--with-jpeg-dir \
--with-png-dir \
--with-libxml-dir \
--with-openssl

# 설치
make
# 건너 뛰어도 상관없는 부분
make test
# 설치
make install

# 설치 확인 - 아래 파일이 있어야 apache2 와 연결이 가능하다
ls -l /usr/local/apache2/modules/libphp7.so

# 설치 확인 2 - 설정에 적혀있는지 확인
grep "libphp" /usr/local/apache2/conf/httpd.conf

# 설정 : .php 파일을 읽어올 수 있도록 아파치에 설정하기
nano /usr/local/apache2/conf/httpd.conf
# AddType application/x-httpd-php .php .html 을 맞는 위치에 추가

# 설정 : 설정을 편하게 관리하기 위해 lib로 이동 시킨 후, <?php ?> 를 <? ?> 로 변경
cp /usr/local/src/php-7.3.0/php.ini-development /usr/local/lib/php.ini

# 모든 설정 완료. 이제 htdocs 에 파일 만들어주면 됨