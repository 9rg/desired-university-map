<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewpoint" user-scalable=no>
  <title>志望校MAP</title>
  <link href="style.css" rel="stylesheet">
</head>

<body>
  <?php
  if(isset($_POST['type'], $_POST['region'], $_POST['prefecture'], $_POST['faculty'])){
    $type = $_POST['type'];
    $region = $_POST['region'];
    $prefecture = $_POST['prefecture'];
    $faculty = $_POST['faculty'];
    $graduate = $_POST['graduate'];
  }
  ?>

  <header>
    <a href="index.php"><h1>志望校MAP</h1></a>
    <nav>
      <ul>
        <li><button type="button" onclick="location.href='map.php'">マップ</button></li>
        <li><button type="button" onclick="location.href='index.php'">条件設定</button></li>
        <li><button type="button" onclick="location.href='aboutsite.html'">当サイトについて</button></li>
        <li><button type="button" onclick="location.href='opinionBox.html'">ご意見箱</button></li>
      </ul>
    </nav>
  </header>

  <main>
    <?php
    if(isset($_POST['type'], $_POST['region'], $_POST['prefecture'], $_POST['faculty'])){
      require_once __DIR__.'/vendor/autoload.php';//環境変数から値を取得
      $dotenv = Dotenv\Dotenv::create(__DIR__);
      $dotenv->load();
      $mysqli = new mysqli( getenv('MYSQLHOSTNAME'), getenv('MYSQLUSERNAME'), getenv('MYSQLPASSWORD'), getenv('MYSQLDBNAME'));
      if($mysqli->connect_error){
        echo $mysqli->connect_error;
        exit();
      }
      else{
        $mysqli->set_charset("utf-8");
      }
      $con = [];
      if($type){
        $con[] = "type = '$type'";
      }
      if($region){
        $con[] = "region = '$region'";
      }
      if($prefecture){
        $con[] = "prefecture = '$prefecture'";
      }
      if($faculty){
        $con[] = "faculty like '%$faculty%'";
      }
      if($graduate){
        $con[] = "graduate = '$graduate'";
      }
      $finalcon = implode(" AND ",$con);
      $sql = "SELECT * FROM universities WHERE $finalcon";
      echo '<script>';
      echo 'console.log("発行されているSQL文:'. $sql .'");';
      echo '</script>';

      $count = 0;
      if($result = $mysqli->query($sql)){
        while($row = $result->fetch_assoc()){
          $lat[] = $row['latitude'];
          $lng[] = $row['longitude'];
          $name[] = $row['name'];
          $address[] = $row['address'];
          $count++;
        }
      }
      $mysqli->close();
    }
    ?>
    <div id="target">
      <?php
      require_once __DIR__.'/vendor/autoload.php';//環境変数から値を取得
      $dotenv = Dotenv\Dotenv::create(__DIR__);
      $dotenv->load();
      echo '<script ';
      echo 'src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key='.getenv('APIKEY').'&callback=initMAP" async defer>';
      ?>
      </script>
      <script>
      function initMAP(){
        var target = document.getElementById('target');//描画領域の取得
        var map;//マップ用の変数
        var tokyo = {lat: 35.681167, lng: 139.767052};//マップで表示したい位置
        var marker = []; //マーカーのための変数
        var infoWindow = [];
        map = new google.maps.Map(target,{
          center: tokyo,
          zoom: 10,
          zoomControl: true,
          mapTypeID: 'roadmap',
          clickableIcons: true
        });
        <?php
        if(isset($_POST['type'], $_POST['region'], $_POST['prefecture'], $_POST['faculty'])){
          $i = 0;
          while($i<$count){
            echo 'var point = {lat: '. $lat[$i] .', lng: '. $lng[$i] .'};';
            echo "marker[$i] = new google.maps.Marker({ position: point, map: map, animation:google.maps.Animation.DROP});";
            echo "infoWindow[$i] = new google.maps.InfoWindow({";
              echo "content: '<div class=".'"'.'contentsName">'. $name[$i] .'</div><br><p>'. $address[$i] ."</p>'"; //<div class = "">
              echo '});';
              echo "marker[$i].addListener('click', function(){";
                echo "infoWindow[$i].open(map, marker[$i]);";
                echo '});';
                $i++;
              }
            }
            ?>
            google.maps.event.addDomlistener( window, 'load', initMAP);
          }
          </script>
        </div>
        <section class="searchParent">
          <?php
          if(!isset($_POST['type'], $_POST['region'], $_POST['prefecture'], $_POST['faculty'])){
            echo '<p class="message">下のボタンから<br>検索条件を設定してください</p>';
          }
          else {
            echo '<p class="message"><br>';
            echo require_once ('sqlConverter.php');
            echo '<br>に該当する大学が'. $count .'件見つかりました。</p>';
          }
          ?>
          <p>
            <button class="toSearch" onclick="history.back()">検索条件の設定・変更</button>
          </p>
        </section>
      </main>
    </body>
    </html>
