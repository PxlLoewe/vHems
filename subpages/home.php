<!DOCTYPE html>
<html lang="de">

<head>
    <link rel="stylesheet" href="/subpages/css/home.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vHEMS-BETAVERSION</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/start.css">
</head>
<body>
    <div class="parent">
        <div class="div1">
            <h1 class="schrift"> Willkommen <?php echo $user->vorname; ?>! </h1>
            <br>
            <br>
            <h2 class="schrift2"> Die offizielle Beta-Version ist nun nach mehreren Monaten Programmierarbeit durch Johannes und Robert entstanden. </h2>
        </div>
        <div class="div2">
            <h2 class="schrift2"> Wir wünschen viel Spaß bei der Benutzung.</h2>
            <h2><span class="date" id="datetime"></span></h2>
            <script>
                var dt = moment().format("DD.MM.YYYY")
                document.getElementById("datetime").innerHTML = dt
            </script>
        </div>
        <div class="div3">
            <img src="https://www.dwd.de/DWD/warnungen/warnapp_gemeinden/json/warnungen_gemeinde_map_de.png" alt="DWD" />
        </div>
        <div class="div4">
            <iframe src="https://discord.com/widget?id=634851154865422336&theme=black" width="auto" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
        </div>
        <div class="version">version: <?php echo $version;?></div>
    </div>
</body>

</html>