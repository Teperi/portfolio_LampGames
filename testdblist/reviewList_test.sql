CREATE TABLE reviewList (
  listidx int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title varchar(200) NOT NULL,
  content text NOT NULL,
  category varchar(20) NOT NULL,
  reg_date DATETIME NOT NULL,
  UNIQUE (listidx)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO reviewList (title, category, reg_date, content)
VALUES ('더 게임 어워드 2018년 GOTY, \'갓 오브 워\' 수상', '게임메카', '2018-12-07 14:34:00', 
'<p style="font-size: large;">
    세계 5대 GOTY(Game of the Year)로 꼽히는 \'더 게임 어워드\'에서 2018년 최고의 게임을 선정했다. 쟁쟁한 경쟁자를 뚫고 GOTY를 거머쥔 게임은 바로 \'갓 오브 워\'다.<br><br>
</p>
<p style="font-size: large;">
    \'더 게임 어워드\'는 6일(현지 기준), 미국 로스앤젤레스에서 진행됐다. 현장에서는 신작 발표와 함께 최고의 액션, 최고의 내러티브, 최고의 음악, 그리고 2018년 최고의 게임까지 다양한 분야에 걸쳐 시상이 이뤄졌다.<br><br>
</p>
<p style="font-size: large;">
    그 중에서도 가장 눈길을 끄는 것이 바로 2018년 GOTY다. \'더 게임 어워드\' GOTY 후보작은 뛰어난 완성도를 자랑한 플랫포머 인디게임 \'셀레스트\', 고대 그리스를 구현하는데 성공한 \'어쌔신 크리드: 오디세이\', 북유럽 신화를 배경으로 하는 호쾌한 액션게임 \'갓 오브 워\', 완성도를 크게 끌어 올린 \'몬스터 헌터: 월드\', 오픈월드 명가 락스타게임즈의 \'레드 데드 리뎀션 2\', 그리고 마블코믹스 최고의 영웅을 재해석한 \'스파이더맨\' 6종이었다.<br><br>
</p>
<img src="/images/gowreview1.jpg" class="center-block" alt="">
<p class="center">▲ \'갓 오브 워\' 스크린샷 (사진: 게임메카 촬영)</p>
<br>
<p style="font-size: large;">
    그 중에서 2018 GOTY의 영광은 \'갓 오브 워\'가 가져갔다. 또한 \'갓 오브 워\'는 최고의 게임 디렉션 상, 최고의 액션 어드벤처게임 상까지 받았다.<br><br>
</p>
<p style="font-size: large;">
    \'갓 오브 워\'는 지난 4월 20일 PS4 독점작으로 발매됐다. 익숙한 그리스 신화가 아닌 북유럽 신화를 배경으로 바꾸고, 보다 향상된 그래픽과 스토리, 강화된 육성 요소 등으로 호평을 받았다. 이에 발매 3일 만에 310만 장 판매를 기록하며 상반기부터 GOTY 후보로 꼽혔다.<br><br>
</p>
<p style="font-size: large;">
    비록 GOTY는 가져가지 못했지만, 다른 후보작들도 여러 분야에서 상을 받았다. GOTY 유력 후보로 점쳐젔던 \'레드 데드 리뎀션 2\'는 최고의 내러티브 게임, 최고의 음악 게임, 최고의 음향 디렉션을 받았고, 주인공 \'아서 모건\'을 연기한 로저 클라크는 최고의 퍼포먼스 상을 받았다. \'셀레스트\' 역시 최고의 인디게임, 최고의 영향 상을 받았다.<br><br>
</p>');


INSERT INTO reviewList (title, category, reg_date, content)
VALUES ('포트나이트, 2018년 마지막 업데이트 실시', '루리웹', '2018-12-09 10:03:00', 
'<p style="font-size: large;">
    한 해 동안 전 세계적으로 큰 사랑을 받은
    <포트나이트>가 2018년 마지막 업데이트를 실시했다. <br><br>
</p>
<p style="font-size: large;">
    세계적인 게임 개발사이자 게임엔진 개발사인 에픽게임즈의 한국법인 에픽게임즈 코리아(대표 박성철)는 자사가 개발하고 서비스 중인
    <포트나이트> 시즌7 2차 콘텐츠 업데이트를 진행했다고 31일 밝혔다.
        <br><br>
</p>
<p style="font-size: large;">
    붐박스의 음악 소리 반경 내 건설된 적의 구조물은 음파 공격을 받을 때마다 피해를 받아 파괴된다. 붐박스의 효과를 없애려면 무기를 이용해 붐박스를 쏴서 맞춰야 한다. <br><br>
</p>
<img src="/images/pnreview2.jpg" class="center-block" alt="" width="100%">
<br>
<p style="font-size: large;">
    한편, 새로운 한정 모드는 물론, 기존에 즐겼던 한정 모드를 플레이할 수 있는 \'14일간의 포트나이트\' 이벤트는 1월 2일 아침까지 즐길 수 있다. 대규모 팀 모드는 이틀에 한 번씩 변경되며, 소규모 팀 모드는 매일 새로운 모드를 만나볼 수 있다. 변경된 모드는 매일 오후 11시에 로그인하면 확인 가능하다. <br><br>
</p>
<p style="font-size: large;">
    에픽게임즈 코리아 박성철 대표는 "
    <포트나이트>의 올해 마지막 업데이트를 진행하면서 2018년을 돌아보니 정말 많은 분들이
        <포트나이트>에 큰 관심을 보내주신 한 해로 기억될 것 같다."면서, "2019년에는 유저분들의 관심이 사랑으로 바뀔 수 있도록 더 재밌는
            <포트나이트>를 서비스하는 에픽게임즈가 되겠다."고 말했다.
                <br><br>
</p>
<p style="font-size: large;">
    시즌7 2차 콘텐츠 업데이트와 \'14일간의 포트나이트\' 이벤트에 대한 자세한 내용은
    <포트나이트> 공식 카페(http://cafe.naver.com/fortnitekr)에서 확인할 수 있다.<br><br>
</p>');

-- 데이터 들어갔는지 확인용. (content 의 경우 너무 길어서 출력 확인 안함)
select listidx, title, reg_date, category from reviewList;

