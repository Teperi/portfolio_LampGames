# 순서 mysql -> apache -> php

# 의존 파일 설치 
yum -y install cmake ncurses-devel gcc gcc-c++

# 유저 생성 (mysql)
groupadd -g 400 mysql
useradd -u 400 -g 400 -d /usr/local/mysql -s /bin/false mysql

# mysql 5.7 다운로드 및 압축해제
cd /usr/local/src
wget https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-5.7.24.tar.gz
tar -zxvf mysql-5.7.24.tar.gz

# 압축 해제된 폴더 접속
cd mysql-5.7.24

# configure 값 설정 후 인스톨
# 설명
# -DCMAKE_INSTALL_PREFIX=/usr/local/mysql : 설치 경로
# -DWITH_EXTRA_CHARSETS=all \
# -DMYSQL_DATADIR=/usr/local/mysql/data : data 디렉토리 설치 경로
# -DENABLED_LOCAL_INFILE=1 \
# -DDOWNLOAD_BOOST=1 : Mysql 에 필요한 부스트 자동 다운로드
# -DWITH_BOOST=/usr/local/include/boost : 부스트 다운로드 경로
# -DWITH_INNOBASE_STORAGE_ENGINE=1 \
# -DWITH_PARTITION_STORAGE_ENGINE=1 \
# -DWITH_FEDERATED_STORAGE_ENGINE=1 \
# -DWITH_BLACKHOLE_STORAGE_ENGINE=1 \
# -DWITH_MYISAM_STORAGE_ENGINE=1 \
# -DENABLED_LOCAL_INFILE=1 \
# -DMYSQL_UNIX_ADDR=/tmp/mysql.sock : soket 생성경로
# -DSYSCONFDIR=/etc \
# -DDEFAULT_CHARSET=utf8 : 언어셋. 설정에 따라 euckr로 변경가능
# -DMYSQL_TCP_PORT=3306 : 기본 sql포트
# -DDEFAULT_COLLATION=utf8_general_ci \
# -DWITH_EXTRA_CHARSETS=all

cmake \
-DCMAKE_INSTALL_PREFIX=/usr/local/mysql \
-DWITH_EXTRA_CHARSETS=all \
-DMYSQL_DATADIR=/usr/local/mysql/data \
-DENABLED_LOCAL_INFILE=1 \
-DDOWNLOAD_BOOST=1 \
-DWITH_BOOST=/usr/local/include/boost \
-DWITH_INNOBASE_STORAGE_ENGINE=1 \
-DWITH_PARTITION_STORAGE_ENGINE=1 \
-DWITH_FEDERATED_STORAGE_ENGINE=1 \
-DWITH_BLACKHOLE_STORAGE_ENGINE=1 \
-DWITH_MYISAM_STORAGE_ENGINE=1 \
-DENABLED_LOCAL_INFILE=1 \
-DMYSQL_UNIX_ADDR=/tmp/mysql.sock \
-DSYSCONFDIR=/etc \
-DDEFAULT_CHARSET=utf8 \
-DMYSQL_TCP_PORT=3306 \
-DDEFAULT_COLLATION=utf8_general_ci \
-DWITH_EXTRA_CHARSETS=all

# 설치
# make 속도를 올리기 위해 cpu 코어 숫자 조정
make all -j3
make install
 
# 부스트 다운로드 폴더로 이동 - 경로 확인해야 함 버젼이 바뀌었을 수 있음
cd /usr/local/include/boost/boost_1_59_0
# 부스트 설치
./bootstrap.sh 
./b2 install 

# mysql db 생성
# deprecated 되었다고 하지만 이대로 써도 문제는 없음.
/usr/local/src/mysql-5.7.24/client/mysql_install_db --user=mysql --datadir=/usr/local/mysql/data --basedir=/usr/local/mysql


# 권한 설정
chown -R mysql:mysql /usr/local/mysql
chmod 711 /usr/local/mysql
chmod 707 /usr/local/mysql/data
chmod 751 /usr/local/mysql/bin
chmod 750 /usr/local/mysql/bin/*
chmod 755 /usr/local/mysql/bin/mysql
chmod 755 /usr/local/mysql/bin/mysqldump

# 실행을 위한 폴더 만들어 놓기
mkdir /var/lib/mysql
chmod 755 -R /var/lib/mysql
chown -R mysql:mysql /var/lib/mysql


# 설정,실행파일 복사 및 권한설정 
cp -arp /usr/local/mysql/support-files/mysql.server /etc/init.d/mysqld
chmod 700 /etc/init.d/mysqld

# 새로 파일을 만들어줘야 함
nano /etc/my.cnf 
# 아래 END 부터 END 설정으로 변경
:<<END
    [client]
    default-character-set = utf8
    port = 3306
    socket = /var/run/mysql/mysql.sock
    default-character-set = utf8

    [mysqld]
    socket=/var/run/mysql/mysql.sock
    datadir = /usr/local/mysql/data
    basedir = /usr/local/mysql
    #user = mysql
    #bind-address = 0.0.0.0
    #
    skip-external-locking
    key_buffer_size = 384M
    max_allowed_packet = 1M
    table_open_cache = 512
    sort_buffer_size = 2M
    read_buffer_size = 2M
    read_rnd_buffer_size = 8M
    myisam_sort_buffer_size = 64M
    thread_cache_size = 8
    query_cache_size = 32M

    #dns query
    skip-name-resolve

    #connection
    max_connections = 1000
    max_connect_errors = 1000
    wait_timeout= 60

    #slow-queries
    #slow_query_log = /home/mysql_data/slow-queries.log
    #long_query_time = 3
    #log-slow-queries = /free/mysql_data/mysql-slow-queries.log

    ##timestamp
    explicit_defaults_for_timestamp

    symbolic-links=0

    ### log
    log-error=/var/log/mysqld.log
    pid-file=/var/run/mysqld/mysqld.pid

    ###chracter
    character-set-client-handshake=FALSE
    init_connect = SET collation_connection = utf8_general_ci
    init_connect = SET NAMES utf8
    character-set-server = utf8
    collation-server = utf8_general_ci

    symbolic-links=0

    ##Password Policy
    #validate_password_policy=LOW
    #validate_password_policy=MEDIUM

    ### MyISAM Spectific options
    default-storage-engine = myisam
    key_buffer_size = 32M
    bulk_insert_buffer_size = 64M
    myisam_sort_buffer_size = 128M
    myisam_max_sort_file_size = 10G
    myisam_repair_threads = 1

    ### INNODB Spectific options
    #default-storage-engine = InnoDB
    #skip-innodb
    #innodb_additional_mem_pool_size = 16M
    #innodb_buffer_pool_size = 1024MB
    #innodb_data_file_path = ibdata1:10M:autoextend
    #innodb_write_io_threads = 8
    #innodb_read_io_threads = 8
    #innodb_thread_concurrency = 16
    #innodb_flush_log_at_trx_commit = 1
    #innodb_log_buffer_size = 8M
    #innodb_log_file_size = 128M
    #innodb_log_files_in_group = 3
    #innodb_max_dirty_pages_pct = 90
    #innodb_lock_wait_timeout = 120

    [mysqldump]
    default-character-set = utf8
    max_allowed_packet = 16M

    [mysql]
    no-auto-rehash
    default-character-set = utf8

    [myisamchk]
    key_buffer_size = 256M
    sort_buffer_size = 256M
    read_buffer = 2M
    write_buffer = 2M
END

# 실행 명령어 넣어주기
chkconfig --add mysqld


# mysqld 실행 중인지 확인
 netstat -ntlp | grep mysqld

# 실행중이 아닐 경우
service mysqld start

# 비밀번호 확인
cat /root/.mysql_secret 

# mysql 명령어 사용
ln -s /usr/local/mysql/bin/mysql /usr/bin/mysql

# mysql 접속
 mysql -u root -p

# 만약 접속이 안된다면?
/usr/local/mysql/bin/mysql -u root -p

# 접속 테스트
# mysql> show databases;

# 만약 You must reset your password using ALTER USER statement before executing this statement. 메시지가 뜰 경우
# mysql> SET PASSWORD = PASSWORD('패스워드');  
 
# mysql> exit

/usr/local/mysql/bin/mysql -V
# mysql  Ver 14.14 Distrib 5.7.10, for Linux (x86_64) using  EditLine wrapper

# error 1 : PID 가 문제가 있는 경우
# 해결방법 : chown -R mysql:mysql /usr/local/mysql 을 실행해서 모든 파일의 권한을 바꿔즌다.