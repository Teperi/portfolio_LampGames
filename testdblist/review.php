<!DOCTYPE html>
<html>
<?php session_start();
?>
<head>
    <meta charset="utf-8" />
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Material 아이콘 사용하기 위한 용도 -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lamp Games - Review & Play Games!!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 개인용 css 파일 -->
    <link rel="stylesheet" type="text/css" media="screen" href="/list.css" />
    <!-- html 각각 관리(navbar, footer 등) -->
    <script src="../shareHTML/includeHTML.js"></script>

</head>

<body>
    <header>
        <!-- 네비게이션 바 -->
        <nav include-html="/shareHTML/nav.php"> </nav>
    </header>
    <main>
        <div class="container">
            <blockquote class="dohyeon-font">
                <h1>Review</h1>
            </blockquote>
            <div class="row">
                    <!-- 게시판 리스트 -->
                    <?php
                        require_once $_SERVER["DOCUMENT_ROOT"].'/php/connectDB.php';
                        
                        $limitNumber = 1;
                        $query = 'SELECT * FROM reviewList ORDER BY reg_date DESC LIMIT ' . $limitNumber;
                        $result_sql = mysqli_query($conn,$query);
                        if(mysqli_num_rows($result_sql) > 0) {
                            while($row = $result_sql->fetch_assoc()) {
                                $categoryColor;
                                if($row['category'] == '루리웹') {
                                    $categoryColor = 'blue';
                                } else {
                                    $categoryColor = 'purple';
                                }

                                echo '<div class="col s12">
                                            <a href="review_content.php">
                                                <div class="card horizontal hoverable cardHorizen">
                                                    <div class="card-image col s3" style="padding:0px">
                                                        <img src="../images/fortnite-xbox-fortnight-game-release.jpg" class="cardHorizenImg">
                                                    </div>
                                                    <div class="card-stacked col s9 truncate">
                                                        <div class="card-content">
                                                            <span class="card-title grey-text text-darken-4 dohyeon-font truncate" id="reviewList_title">'.$row['title'].'</span>
                                                            <p class="grey-text text-darken-4 truncate">test</p>
                                                        </div>
                                                        <div class="card-action dohyeon-font">
                                                            <div class="chip '. $categoryColor .' white-text truncate">'.$row['category'].'</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>';
                            }
                        }
                    ?>
                    <div class="col s12">
                        <button class='waves-effect btn-flat indigo white-text hoverable col s12' onclick>더보기</button>
                    </div>
                    
            </div>
        </div>



        <footer include-html="../shareHTML/footer.php"> </footer>
        <!-- HTML 공통 파일 포함 -->
        <script>
            includeHTML();
        </script>
    </main>

</body>

</html>