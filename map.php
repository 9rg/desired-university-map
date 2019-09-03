<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>志望校MAP</title>
  <link href="style.css" rel="stylesheet">
</head>

<body>
  <?php
  if(isset($_POST['type'])){
    $type = $_POST['type'];
    $region = $_POST['region'];
    $prefecture = $_POST['prefecture'];
    $faculty = $_POST['faculty'];
    $graduate = $_POST['graduate'];
  }
  ?>

  <header>
    <a href="map.php"><h1>志望校MAP</h1></a>
    <nav>
      <ul>
        <li><button type="button" onclick="location.href='map.php'">マップ</button></li>
        <li><button type="button" onclick="location.href='search.php'">条件指定</button></li>
        <li><button type="button" onclick="location.href='bio.html'">当サイトについて</button></li>
        <li><button type="button" onclick="location.href='register.php'">会員登録・ログイン</button></li>
      </ul>
    </nab>
  </header>

  <main>
    <?php
    $mysqli = new mysqli('localhost', 'kuragane', 'VVmmjcU6TYTKJLQJ', 'kuragane');
    if($mysqli->connect_error){
      echo $mysqli->connect_error;
      exit();
    }
    else{
      $mysqli->set_charset("utf-8");
    }

    if($type || $region || $prefecture || $faculty || $graduate){
      $con = "WHERE";
      if($type){
        $con .= " university_type = '$type'";
      }
      if($region){
        $con .= " AND university_region = '$region'";
      }
      if($prefecture){
        $con .= " AND university_prefecture = '$prefecture'";
      }
      if($faculty){
        $con .= " AND university_faculty = '$faculty'";
      }
      if($graduate){
        $con .= " AND university_graduate = '$graduate'";
      }
      $sql = "SELECT * FROM university_table $con";
    }
    elseif(isset($_POST['type'])){
      $sql = "SELECT * FROM university_table";
    }

    echo "<p>発行されているsql文：$sql</p><br>";

    $count == 0;
    if($result = $mysqli->query($sql)){
      while($row = $result->fetch_assoc()){
        $lat[] = $row['latitude'];
        $lng[] = $row['longitude'];
        $name[] = $row['university_name'];
        $count++;
      }
    }
    $mysqli->close();
    ?>

    <div id="target">
      <script
      src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyBVNWrMt19jJzpCOHDw6VN2g-LZdxuHIj4&callback=initMAP" async defer></script>
      <script>
      function initMAP(){
        var target = document.getElementById('target');//描画領域の取得
        var map;//マップ用の変数
        var tokyo = {lat: 35.681167, lng: 139.767052};//マップで表示したい位置
        var marker; //マーカーのための変数
        map = new google.maps.Map(target,{
          center: tokyo,
          zoom: 10,
          zoomControl: true,
          mapTypeID: 'roadmap',
          clickableIcons: true
        });
        <?php
        $i = 0;
        while($i<$count){
          echo 'var point = {lat: '. $lat[$i] .', lng: '. $lng[$i] .'};';
          echo 'marker = new google.maps.Marker({ position: point, map: map});';
          $i++;
        }
        ?>
          google.maps.event.addDomlistener( window, 'load', initialize);
        }
        </script>
      </div>
      <section class="searchParent">
        <?php
        if(!$type){
          echo '<p class="message">下のボタンから<br>検索条件を設定してください</p>';
        }
        else {
          echo '<p class="message">区分:'.$type.' 地方:'.$region.' 都道府県:'.$prefecture.' 学部:'.$faculty.' 大学院の有無:'.$graduate.'<br>';
          echo 'に該当する大学が'. $count .'件見つかりました。</p>';
        }
        ?>
        <button class="toSearch" onclick="location.href='search.php'">検索条件の設定・変更</button>
      </section>
    </main>
  </body>
  </html>
