CREATE TABLE reviewList (
  listidx int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '리뷰 번호',
  title varchar(256) NOT NULL COMMENT '제목',
  views int(11) NOT NULL DEFAULT 0,
  precontent varchar(512) NOT NULL COMMENT '미리보기 내용',
  mainimg varchar(512) NOT NULL COMMENT '사진',
  reg_date DATETIME NOT NULL COMMENT '업로드 날짜',
  ref varchar(20) NOT NULL COMMENT '원본 사이트',
  refurl varchar(512) COMMENT '원본 주소',
  content text NOT NULL COMMENT '내용',
  UNIQUE (listidx)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO reviewList (
    title, 
    mainimg, 
    reg_date, 
    ref, 
    refurl, 
    precontent, 
    content)
VALUES (
    '더 게임 어워드 2018년 GOTY, \'갓 오브 워\' 수상', 
    '/images/gowtestimage.jpg', 
    '2018-12-07 14:34:00', 
    '게임메카', 
    'https://www.gamemeca.com/view.php?gid=1513589',  
    '세계 5대 GOTY(Game of the Year)로 꼽히는 \'더 게임 어워드\'에서 2018년 최고의 게임을 선정했다. 쟁쟁한 경쟁자를 뚫고 GOTY를 거머쥔 게임은 바로 \'갓 오브 워\'다.',
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

INSERT INTO reviewList (
    title, 
    mainimg, 
    reg_date, 
    ref, 
    refurl, 
    precontent, 
    content)
VALUES (
    '포켓몬 고, 신기능 힘입어 2018년 연매출 35% 성장',
    '/images/pokemongoreview.jpg',
    '2019-01-04 11:07:26',
    '루리웹',
    'http://bbs.ruliweb.com/news/read/117256',
    '\'포켓몬 고\'의 기세가 예전 같지 않을지는 몰라도 글로벌 마켓, 그 중에서도 미국과 일본 지역에서는 여전히 많은 인기를 얻고 있는 것으로 나타났다.',
    '\'포켓몬 고\'의 기세가 예전 같지 않을지는 몰라도 글로벌 마켓, 그 중에서도 미국과 일본 지역에서는 여전히 많은 인기를 얻고 있는 것으로 나타났다.<br><br>
    시장 분석 업체인 센서 타워가 스토어 인텔리전스 플랫폼을 이용해 분석한 바에 따르면, 포켓몬 고의 2018년 글로벌 연매출은 7억
    9500만 달러(한화 약 8960억 원)로 전년도 대비 35% 증가한 것으로 나타났으며, 특히 12월에는 구글플레이 스토어와 
    애플 앱스토어에서 7500만 달러(845억 원)의 매출을 발생시켜 전년 동기 대비 32% 성장했다.<br><br>
    지역 별로는 미국 매출이 전체의 33%인 2억 6200만 달러(2952억 원)를 차지하는 것으로 나타났고, 일본은 2억 3900만 달러(2693억 원)로 전년도보다 5% 늘어난 30%로 증가했다.<br><br>
    여기에는 많은 플레이어들이 바라마지 않았던 \'교환 기능\'과 \'트레이너 배틀\'이 주효했던 것으로 분석된다. 6월에 추가된 교환 
    기능은 친구와 포켓몬을 교환할 수 있게 해주며, 12월에 도입된 트레이너 배틀은 세 마리 포켓몬으로 파티를 편성한 플레이어가 다른
    이용자와 실시간으로 배틀을 즐길 수 있게 해주는데, 덕분에 2018년 일 평균 매출은 전년도의 160만 달러(18억 원)에서 
    220만 달러(24억 원)로 성장했다.<br><br>
    <p align="center">
    <a class="img_load"><img src="%ED%8F%AC%EC%BC%93%EB%AA%AC%20%EA%B3%A0,%20%EC%8B%A0%EA%B8%B0%EB%8A%A5%20%ED%9E%98%EC%9E%85%EC%96%B4%202018%EB%85%84%20%EC%97%B0%EB%A7%A4%EC%B6%9C%2035%%20%EC%84%B1%EC%9E%A5%20%20%20%EB%A3%A8%EB%A6%AC%EC%9B%B9_files/167a57f9bfeafd4.jpg" width="720" border="1"></a><br><br>
    </p>
    11월 16일 전 세계에 동시 발매된 \'포켓몬스터 레츠고! 피카츄·이브이\' 또한 영향을 미친 것으로 보인다. 닌텐도 스위치와 
    포켓몬 고의 특징을 합친 이 게임은 포켓몬 고에서 잡은 포켓몬을 데려와 함께 모험할 수 있게 하는 등 연계를 모색했다.<br><br>
    참고로 2016년 론칭 된 포켓몬 고의 누적 매출은 2018년 연말 기준 22억 달러(2조 4796억 원)에 달하는 것으로 나타났다.<br><br>
    <p align="center">
    <img src="%ED%8F%AC%EC%BC%93%EB%AA%AC%20%EA%B3%A0,%20%EC%8B%A0%EA%B8%B0%EB%8A%A5%20%ED%9E%98%EC%9E%85%EC%96%B4%202018%EB%85%84%20%EC%97%B0%EB%A7%A4%EC%B6%9C%2035%%20%EC%84%B1%EC%9E%A5%20%20%20%EB%A3%A8%EB%A6%AC%EC%9B%B9_files/areyou.jpg" width="500" border="1"><br><br>
    </p>'
);


INSERT INTO reviewList (
    title, 
    mainimg, 
    reg_date, 
    ref, 
    refurl, 
    precontent, 
    content)
VALUES (
    '포트나이트, 2018년 마지막 업데이트 실시', 
    '/images/fortnite-xbox-fortnight-game-release.jpg',
    '2018-12-09 10:03:00', 
    '루리웹',
    'http://bbs.ruliweb.com/news/read/117143',
    '한 해 동안 전 세계적으로 큰 사랑을 받은 <포트나이트>가 2018년 마지막 업데이트를 실시했다.',
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
select listidx, title, reg_date, ref from reviewList;