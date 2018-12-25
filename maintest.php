<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Rock Paper Scissors Game</title>
        <link rel="stylesheet" href="style.css" />
    </head>

    <body>
        <header>
            <h1>Rock Paper Scissors</h1>
        </header>

        <div class="score-board">
            <div id="user-label" class="badge">user</div>
            <div id="computer-label" class="badge">comp</div>
            <span id="user-score">0</span>:<span id="computer-score">0</span>
        </div>

        <div class ="result">
            <p>Paper covers rock. You win!</p>
        </div>

        <div class="choices">
            <div class="choice" id="rock">
                <img src="images/rock.png" class="buttonimage" alt="">
            </div>
            <div class="choice" id="paper">
                <img src="images/paper.png" class="buttonimage" alt="">
            </div>
            <div class="choice" id="scissors">
                <img src="images/scissors.png" class="buttonimage" alt="">
            </div>
        </div>

        <p id="action-message">Make your move</p>

        <script src="app.js" charset="utf-8"></script>
        
    </body>
</html>