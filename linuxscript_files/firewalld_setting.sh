# 방화벽 열기
ifconfig
# 여기에 나오는 ip 확인
# 나의 경우 192.168.79.130 이었음

# 1. vmware 에서 웹서버 포트 열기
# vmware > edit > virtual network editor 열기
# Gateway IP : 192.168.79.2 (아래 보였던 subnet IP 뒤에 0 대신 2를 설정함)

# Add 를 통해 열어줄 포트 설정 
# 웹이므로 80 포트 열기 > Add 통해서 열기
# 80 / TCP / ifconfig 에서 확인한 IP / 80 / 웹서버

# 참고 : http://horae.tistory.com/entry/%EB%AA%A8%EC%9D%98%ED%99%98%EA%B2%BD-%EC%84%A4%EC%A0%95-NAT-%EC%99%B8%EB%B6%80%EC%97%90%EC%84%9C-Vmware-Guest-OS-%EC%97%90-%EC%A0%91%EC%86%8D%ED%95%98%EA%B8%B0


# 2. cent os 방화벽 설정

# 참고 : http://blog.plura.io/?p=4519
# 참고 : https://wikidocs.net/16275
# 참고 : https://www.lesstif.com/pages/viewpage.action?pageId=43844015

# 현재 리스트 확인 & 액티브되어있는 리스트 확인
firewall-cmd --list-all-zones
firewall-cmd -get-active-zones

# 보통 public 이 열려 있기 때문에 public에 http 추가
firewall-cmd --permanent --zone=public --add-service=http
firewall-cmd --permanent --zone=public --add-service=https
firewall-cmd --permanent --zone=public --add-port=80/tcp

# 방화벽 재시작
firewall-cmd --reload

# 이렇게 한 후 아까 ifconfig 에 나온 IP 로 접속하면 잘 나옴 끝!